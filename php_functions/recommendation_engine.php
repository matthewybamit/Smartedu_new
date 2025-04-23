<?php
/**
 * Recommendation engine to suggest learning content based on user performance and clustering
 */

/**
 * Generate content recommendations for a user
 * 
 * @param PDO $pdo Database connection
 * @param string $userEmail User's email
 * @param int $limit Maximum number of recommendations to return
 * @return array Recommendations
 */
function generateUserRecommendations($pdo, $userEmail, $limit = 5) {
    try {
        // Get user performance metrics
        $performanceStmt = $pdo->prepare("
            SELECT * FROM user_performance 
            WHERE user_email = ?
        ");
        $performanceStmt->execute([$userEmail]);
        $performanceData = $performanceStmt->fetchAll();
        
        // If no performance data, return basic recommendations
        if (empty($performanceData)) {
            return getBasicRecommendations($pdo, $limit);
        }
        
        // Get user's cluster
        $clusterStmt = $pdo->prepare("
            SELECT cluster_id FROM user_clusters 
            WHERE user_email = ? 
            ORDER BY last_updated DESC 
            LIMIT 1
        ");
        $clusterStmt->execute([$userEmail]);
        $cluster = $clusterStmt->fetch();
        $clusterId = $cluster ? $cluster['cluster_id'] : null;
        
        // Organize performance by subject
        $subjectPerformance = [];
        $preferredStyle = null;
        $styleCount = ['read' => 0, 'video' => 0];
        
        foreach ($performanceData as $row) {
            $subjectPerformance[$row['subject']] = [
                'avg_score' => $row['avg_score'],
                'quizzes_taken' => $row['quizzes_taken']
            ];
            
            if ($row['learning_style']) {
                $styleCount[$row['learning_style']] += $row['quizzes_taken'];
            }
        }
        
        // Determine preferred learning style
        if ($styleCount['read'] > $styleCount['video']) {
            $preferredStyle = 'read';
        } else if ($styleCount['video'] > $styleCount['read']) {
            $preferredStyle = 'video';
        }
        
        // Identify weakest subjects (lowest scores)
        asort($subjectPerformance);
        $weakSubjects = array_keys($subjectPerformance);
        
        // Create recommendations array
        $recommendations = [];
        
        // Generate recommendations based on user's performance and cluster
        
        // 1. Recommend content for weakest subjects
        foreach ($weakSubjects as $subject) {
            $performance = $subjectPerformance[$subject];
            
            // Skip if they're doing well in this subject
            if ($performance['avg_score'] > 80) {
                continue;
            }
            
            // Decide level based on score
            $level = 'Beginner';
            if ($performance['avg_score'] > 60) {
                $level = 'Intermediate';
            } else if ($performance['avg_score'] > 30) {
                $level = 'Beginner';
            }
            
            // Always get a mix of content types regardless of preferred style
            // This ensures users get exposed to both learning methods
            
            // Get reading materials
            $lessonStmt = $pdo->prepare("
                SELECT id, title, description 
                FROM lessons 
                WHERE subject = ? AND level = ? 
                ORDER BY id ASC 
                LIMIT 1
            ");
            $lessonStmt->execute([$subject, $level]);
            
            while ($lesson = $lessonStmt->fetch()) {
                $recommendations[] = [
                    'type' => 'lesson',
                    'source' => 'reading', // Add source field for template consistency
                    'id' => $lesson['id'],
                    'title' => $lesson['title'],
                    'description' => substr($lesson['description'], 0, 100) . '...',
                    'subject' => $subject,
                    'level' => $level,
                    'priority' => ($preferredStyle === 'reading') ? 1 : 2
                ];
            }
            
            // Get video materials
            $videoStmt = $pdo->prepare("
                SELECT id, title, description, youtube_url
                FROM video_lessons 
                WHERE subject = ? AND level = ? 
                ORDER BY id ASC 
                LIMIT 1
            ");
            $videoStmt->execute([$subject, $level]);
            
            while ($video = $videoStmt->fetch()) {
                $recommendations[] = [
                    'type' => 'video',
                    'source' => 'video', // Add source field for template consistency
                    'id' => $video['id'],
                    'title' => $video['title'],
                    'description' => substr($video['description'], 0, 100) . '...',
                    'subject' => $subject,
                    'level' => $level,
                    'url' => $video['youtube_url'] ?? '',
                    'priority' => ($preferredStyle === 'video') ? 1 : 2
                ];
            }
        }
        
        // 2. Get popular content among users in the same cluster
        if ($clusterId !== null) {
            // Find other users in the same cluster
            $clusterUsersStmt = $pdo->prepare("
                SELECT user_email 
                FROM user_clusters 
                WHERE cluster_id = ? AND user_email != ? 
                LIMIT 10
            ");
            $clusterUsersStmt->execute([$clusterId, $userEmail]);
            $clusterUsers = $clusterUsersStmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (!empty($clusterUsers)) {
                // Get content that other users in this cluster performed well on
                $placeholders = implode(',', array_fill(0, count($clusterUsers), '?'));
                
                $popularContentStmt = $pdo->prepare("
                    SELECT subject, source, COUNT(*) as count 
                    FROM quiz_attempts 
                    WHERE user_email IN ({$placeholders}) 
                    AND score/total_questions >= 0.7
                    GROUP BY subject, source 
                    ORDER BY count DESC 
                    LIMIT 3
                ");
                $popularContentStmt->execute($clusterUsers);
                
                while ($popular = $popularContentStmt->fetch()) {
                    $subject = $popular['subject'];
                    $source = $popular['source'];
                    
                    // Skip if we already have recommendations for this subject
                    $alreadyHasSubject = false;
                    foreach ($recommendations as $rec) {
                        if ($rec['subject'] === $subject) {
                            $alreadyHasSubject = true;
                            break;
                        }
                    }
                    
                    if ($alreadyHasSubject) {
                        continue;
                    }
                    
                    // Get appropriate content
                    if ($source === 'reading') {
                        $contentStmt = $pdo->prepare("
                            SELECT id, title, description, level 
                            FROM lessons 
                            WHERE subject = ? 
                            ORDER BY RAND() 
                            LIMIT 1
                        ");
                    } else {
                        $contentStmt = $pdo->prepare("
                            SELECT id, title, description, level 
                            FROM video_lessons 
                            WHERE subject = ? 
                            ORDER BY RAND() 
                            LIMIT 1
                        ");
                    }
                    
                    $contentStmt->execute([$subject]);
                    if ($content = $contentStmt->fetch()) {
                        $recommendations[] = [
                            'type' => $source === 'reading' ? 'lesson' : 'video',
                            'id' => $content['id'],
                            'title' => $content['title'],
                            'description' => substr($content['description'], 0, 100) . '...',
                            'subject' => $subject,
                            'level' => $content['level'],
                            'priority' => 2
                        ];
                    }
                }
            }
        }
        
        // 3. Fill remaining recommendations with general content
        if (count($recommendations) < $limit) {
            $basicRecs = getBasicRecommendations($pdo, $limit - count($recommendations));
            $recommendations = array_merge($recommendations, $basicRecs);
        }
        
        // Sort by priority and limit to requested number
        usort($recommendations, function($a, $b) {
            return $a['priority'] - $b['priority'];
        });
        
        return array_slice($recommendations, 0, $limit);
        
    } catch (PDOException $e) {
        error_log("Error generating recommendations: " . $e->getMessage());
        return getBasicRecommendations($pdo, $limit);
    }
}

/**
 * Get basic recommendations for new users or fallback
 * 
 * @param PDO $pdo Database connection
 * @param int $limit Maximum number of recommendations
 * @return array Basic recommendations
 */
function getBasicRecommendations($pdo, $limit = 5) {
    try {
        $recommendations = [];
        
        // Get popular subjects
        $subjects = ['English', 'Mathematics', 'Science'];
        
        foreach ($subjects as $subject) {
            // Get a lesson
            $lessonStmt = $pdo->prepare("
                SELECT id, title, description, level 
                FROM lessons 
                WHERE subject = ? 
                ORDER BY RAND() 
                LIMIT 1
            ");
            $lessonStmt->execute([$subject]);
            
            if ($lesson = $lessonStmt->fetch()) {
                $recommendations[] = [
                    'type' => 'lesson',
                    'id' => $lesson['id'],
                    'title' => $lesson['title'],
                    'description' => substr($lesson['description'], 0, 100) . '...',
                    'subject' => $subject,
                    'level' => $lesson['level'],
                    'priority' => 3
                ];
            }
            
            // Get a video
            $videoStmt = $pdo->prepare("
                SELECT id, title, description, level 
                FROM video_lessons 
                WHERE subject = ? 
                ORDER BY RAND() 
                LIMIT 1
            ");
            $videoStmt->execute([$subject]);
            
            if ($video = $videoStmt->fetch()) {
                $recommendations[] = [
                    'type' => 'video',
                    'id' => $video['id'],
                    'title' => $video['title'],
                    'description' => substr($video['description'], 0, 100) . '...',
                    'subject' => $subject,
                    'level' => $video['level'],
                    'priority' => 3
                ];
            }
        }
        
        // Randomize and limit
        shuffle($recommendations);
        return array_slice($recommendations, 0, $limit);
        
    } catch (PDOException $e) {
        error_log("Error getting basic recommendations: " . $e->getMessage());
        return [];
    }
}

/**
 * Save recommendations for a user
 * 
 * @param PDO $pdo Database connection
 * @param string $userEmail User's email
 * @param array $recommendations Recommendations to save
 * @return bool Success status
 */
function saveUserRecommendations($pdo, $userEmail, $recommendations) {
    try {
        // Clear existing unviewed recommendations
        $clearStmt = $pdo->prepare("
            DELETE FROM user_recommendations 
            WHERE user_email = ? AND is_viewed = 0
        ");
        $clearStmt->execute([$userEmail]);
        
        // Insert new recommendations
        $insertStmt = $pdo->prepare("
            INSERT INTO user_recommendations 
            (user_email, lesson_id, video_id, recommendation_type, priority, is_viewed, date_created) 
            VALUES (?, ?, ?, ?, ?, 0, NOW())
        ");
        
        foreach ($recommendations as $rec) {
            $lessonId = ($rec['type'] === 'lesson') ? $rec['id'] : null;
            $videoId = ($rec['type'] === 'video') ? $rec['id'] : null;
            
            $insertStmt->execute([
                $userEmail,
                $lessonId,
                $videoId,
                $rec['type'],
                $rec['priority']
            ]);
        }
        
        return true;
        
    } catch (PDOException $e) {
        error_log("Error saving recommendations: " . $e->getMessage());
        return false;
    }
}
?>
