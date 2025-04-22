<?php
/**
 * K-means clustering algorithm implementation for Lumin educational platform
 * Used to group users based on performance metrics and generate personalized recommendations
 */

/**
 * Check if we should run clustering based on time since last run or number of new data points
 */
function shouldRunClustering($pdo) {
    // Check when clustering was last run
    $lastRunQuery = $pdo->query("
        SELECT MAX(last_updated) as last_run
        FROM user_clusters
    ");
    
    $lastRun = $lastRunQuery->fetch(PDO::FETCH_ASSOC)['last_run'];
    
    // If never run before, or it's been more than a day
    if (!$lastRun || (strtotime($lastRun) < strtotime('-1 day'))) {
        return true;
    }
    
    // Check how many new quiz attempts since last run
    $newDataQuery = $pdo->prepare("
        SELECT COUNT(*) as new_count
        FROM quiz_attempts
        WHERE date_completed > :last_run
    ");
    $newDataQuery->bindParam(':last_run', $lastRun);
    $newDataQuery->execute();
    
    $newCount = $newDataQuery->fetch(PDO::FETCH_ASSOC)['new_count'];
    
    // If at least 5 new data points, run clustering
    return $newCount >= 5;
}

/**
 * Get user performance data for clustering
 */
function getUserPerformanceData($pdo) {
    // Get users with at least one quiz attempt
    $usersQuery = $pdo->query("
        SELECT DISTINCT user_email
        FROM quiz_attempts
    ");
    
    $users = [];
    
    while ($user = $usersQuery->fetch(PDO::FETCH_ASSOC)) {
        $email = $user['user_email'];
        
        // Get performance data for this user
        $perfQuery = $pdo->prepare("
            SELECT 
                subject,
                AVG(score/total_questions*100) as avg_score,
                COUNT(*) as count,
                source
            FROM quiz_attempts
            WHERE user_email = :email
            GROUP BY subject, source
        ");
        $perfQuery->bindParam(':email', $email);
        $perfQuery->execute();
        
        $performanceData = [];
        $preferredStyles = [];
        
        while ($perf = $perfQuery->fetch(PDO::FETCH_ASSOC)) {
            $subject = strtolower($perf['subject']);
            $score = floatval($perf['avg_score']);
            $source = $perf['source'];
            $count = intval($perf['count']);
            
            // Store performance for this subject
            if (!isset($performanceData[$subject])) {
                $performanceData[$subject] = $score;
            } else {
                // Average with existing score
                $performanceData[$subject] = ($performanceData[$subject] + $score) / 2;
            }
            
            // Track preferred learning style
            if (!isset($preferredStyles[$source])) {
                $preferredStyles[$source] = $count;
            } else {
                $preferredStyles[$source] += $count;
            }
        }
        
        // Only include users with performance data
        if (!empty($performanceData)) {
            // Find preferred learning style
            $preferredStyle = '';
            $maxCount = 0;
            
            foreach ($preferredStyles as $style => $count) {
                if ($count > $maxCount) {
                    $maxCount = $count;
                    $preferredStyle = $style;
                }
            }
            
            // Add style preference as a feature (1 for video, 0 for reading)
            $styleFeature = ($preferredStyle === 'video') ? 1 : 0;
            
            $users[] = [
                'email' => $email,
                'performance' => $performanceData,
                'style_preference' => $styleFeature
            ];
        }
    }
    
    return $users;
}

/**
 * Normalize feature vectors for k-means clustering
 */
function normalizeFeatures($users) {
    // Get all unique subjects
    $allSubjects = [];
    
    foreach ($users as $user) {
        foreach (array_keys($user['performance']) as $subject) {
            if (!in_array($subject, $allSubjects)) {
                $allSubjects[] = $subject;
            }
        }
    }
    
    // Create feature vectors with all subjects
    $featureVectors = [];
    
    foreach ($users as $user) {
        $vector = [
            'email' => $user['email'],
            'features' => []
        ];
        
        // Add performance for each subject (or 0 if no data)
        foreach ($allSubjects as $subject) {
            $vector['features'][] = isset($user['performance'][$subject]) 
                ? $user['performance'][$subject] / 100 // Normalize to 0-1 range
                : 0;
        }
        
        // Add learning style preference
        $vector['features'][] = $user['style_preference'];
        
        $featureVectors[] = $vector;
    }
    
    return $featureVectors;
}

/**
 * Calculate Euclidean distance between two vectors
 */
function euclideanDistance($vector1, $vector2) {
    $sum = 0;
    
    for ($i = 0; $i < count($vector1); $i++) {
        $sum += pow($vector1[$i] - $vector2[$i], 2);
    }
    
    return sqrt($sum);
}

/**
 * Calculate mean of a set of vectors
 */
function calculateMean($vectors) {
    if (empty($vectors)) return [];
    
    $dimensions = count($vectors[0]);
    $mean = array_fill(0, $dimensions, 0);
    
    foreach ($vectors as $vector) {
        for ($i = 0; $i < $dimensions; $i++) {
            $mean[$i] += $vector[$i];
        }
    }
    
    for ($i = 0; $i < $dimensions; $i++) {
        $mean[$i] /= count($vectors);
    }
    
    return $mean;
}

/**
 * Run k-means clustering algorithm
 */
function kMeansClustering($featureVectors, $k, $maxIterations = 100) {
    if (empty($featureVectors) || $k <= 0) {
        return [];
    }
    
    $numVectors = count($featureVectors);
    
    // Ensure k is not larger than the number of vectors
    $k = min($k, $numVectors);
    
    // Extract just the feature arrays for calculations
    $features = array_map(function($item) {
        return $item['features'];
    }, $featureVectors);
    
    // Initialize centroids randomly
    $centroidIndices = array_rand($features, $k);
    if (!is_array($centroidIndices)) {
        $centroidIndices = [$centroidIndices];
    }
    
    $centroids = [];
    foreach ($centroidIndices as $index) {
        $centroids[] = $features[$index];
    }
    
    // Initialize cluster assignments
    $clusters = array_fill(0, $numVectors, -1);
    
    // Run k-means algorithm
    $iteration = 0;
    $changed = true;
    
    while ($changed && $iteration < $maxIterations) {
        $changed = false;
        
        // Assign each vector to nearest centroid
        for ($i = 0; $i < $numVectors; $i++) {
            $minDistance = PHP_FLOAT_MAX;
            $closestCluster = -1;
            
            for ($j = 0; $j < $k; $j++) {
                $distance = euclideanDistance($features[$i], $centroids[$j]);
                
                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $closestCluster = $j;
                }
            }
            
            if ($clusters[$i] !== $closestCluster) {
                $clusters[$i] = $closestCluster;
                $changed = true;
            }
        }
        
        // Update centroids
        $clusterVectors = array_fill(0, $k, []);
        
        for ($i = 0; $i < $numVectors; $i++) {
            $clusterVectors[$clusters[$i]][] = $features[$i];
        }
        
        for ($j = 0; $j < $k; $j++) {
            if (!empty($clusterVectors[$j])) {
                $centroids[$j] = calculateMean($clusterVectors[$j]);
            }
        }
        
        $iteration++;
    }
    
    // Prepare final results
    $results = [];
    
    for ($i = 0; $i < $numVectors; $i++) {
        $results[] = [
            'email' => $featureVectors[$i]['email'],
            'cluster' => $clusters[$i]
        ];
    }
    
    return $results;
}

/**
 * Save clustering results to database
 */
function saveClusteringResults($pdo, $results) {
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Clear old clustering results
        $pdo->exec("DELETE FROM user_clusters");
        
        // Insert new clustering results
        $stmt = $pdo->prepare("
            INSERT INTO user_clusters (
                user_email, cluster_id, last_updated
            ) VALUES (
                :email, :cluster_id, NOW()
            )
        ");
        
        foreach ($results as $result) {
            $stmt->bindParam(':email', $result['email']);
            $stmt->bindParam(':cluster_id', $result['cluster']);
            $stmt->execute();
        }
        
        // Commit transaction
        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        // Rollback on error
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        
        error_log("Error saving clustering results: " . $e->getMessage());
        return false;
    }
}

/**
 * Run clustering with all preprocessing steps
 */
function runClustering($pdo) {
    // Get user performance data
    $users = getUserPerformanceData($pdo);
    
    if (count($users) < 2) {
        return false; // Not enough users
    }
    
    // Normalize features
    $featureVectors = normalizeFeatures($users);
    
    // Determine optimal k (between 2 and 5)
    $k = min(max(2, intval(count($featureVectors) / 5)), 5);
    
    // Run k-means clustering
    $clusteringResults = kMeansClustering($featureVectors, $k);
    
    // Save results
    return saveClusteringResults($pdo, $clusteringResults);
}

/**
 * Get recommendations based on user's cluster
 */
function getClusterBasedRecommendations($pdo, $userEmail, $limit = 5) {
    $recommendations = [];
    
    try {
        // First check if user has a cluster assignment
        $clusterQuery = $pdo->prepare("
            SELECT cluster_id 
            FROM user_clusters 
            WHERE user_email = :email 
            ORDER BY last_updated DESC 
            LIMIT 1
        ");
        $clusterQuery->bindParam(':email', $userEmail);
        $clusterQuery->execute();
        
        if ($clusterQuery->rowCount() > 0) {
            $cluster = $clusterQuery->fetch(PDO::FETCH_ASSOC);
            $clusterId = $cluster['cluster_id'];
            
            // Get learning style preference
            $styleQuery = $pdo->prepare("
                SELECT source, COUNT(*) as count 
                FROM quiz_attempts 
                WHERE user_email = :email 
                GROUP BY source 
                ORDER BY count DESC 
                LIMIT 1
            ");
            $styleQuery->bindParam(':email', $userEmail);
            $styleQuery->execute();
            
            $preferredStyle = 'read'; // Default to reading
            if ($styleQuery->rowCount() > 0) {
                $style = $styleQuery->fetch(PDO::FETCH_ASSOC);
                $preferredStyle = $style['source'];
            }
            
            // Get subjects this user has engaged with
            $subjectQuery = $pdo->prepare("
                SELECT DISTINCT subject 
                FROM quiz_attempts 
                WHERE user_email = :email
            ");
            $subjectQuery->bindParam(':email', $userEmail);
            $subjectQuery->execute();
            
            $userSubjects = [];
            while ($row = $subjectQuery->fetch(PDO::FETCH_ASSOC)) {
                $userSubjects[] = $row['subject'];
            }
            
            // If no subjects, use all available
            if (empty($userSubjects)) {
                $allSubjectsQuery = $pdo->query("
                    SELECT DISTINCT subject FROM quiz_attempts
                ");
                while ($row = $allSubjectsQuery->fetch(PDO::FETCH_ASSOC)) {
                    $userSubjects[] = $row['subject'];
                }
            }
            
            // Find what other users in same cluster did well on
            $clusterPerformanceQuery = $pdo->prepare("
                SELECT 
                    qa.subject,
                    CASE WHEN qa.source = :preferred_style THEN 1 ELSE 0 END as style_match,
                    AVG(qa.score/qa.total_questions*100) as avg_score,
                    COUNT(*) as popularity
                FROM quiz_attempts qa
                JOIN user_clusters uc ON qa.user_email = uc.user_email
                WHERE 
                    uc.cluster_id = :cluster_id AND
                    qa.user_email != :email AND
                    qa.subject IN (" . implode(',', array_fill(0, count($userSubjects), '?')) . ")
                GROUP BY qa.subject, style_match
                ORDER BY style_match DESC, avg_score DESC, popularity DESC
                LIMIT 5
            ");
            
            $clusterPerformanceQuery->bindParam(':cluster_id', $clusterId);
            $clusterPerformanceQuery->bindParam(':email', $userEmail);
            $clusterPerformanceQuery->bindParam(':preferred_style', $preferredStyle);
            
            // Bind subject parameters
            foreach ($userSubjects as $index => $subject) {
                $clusterPerformanceQuery->bindValue($index + 1, $subject);
            }
            
            $clusterPerformanceQuery->execute();
            
            $recommendedSubjects = [];
            while ($row = $clusterPerformanceQuery->fetch(PDO::FETCH_ASSOC)) {
                $recommendedSubjects[] = $row['subject'];
            }
            
            // If no recommendations from cluster, use user's own subjects
            if (empty($recommendedSubjects)) {
                $recommendedSubjects = $userSubjects;
            }
            
            // Get content items in these subjects that user hasn't seen yet
            foreach ($recommendedSubjects as $subject) {
                // Get content based on preferred learning style
                if ($preferredStyle === 'video') {
                    // Get videos in this subject
                    $videoQuery = $pdo->prepare("
                        SELECT 
                            v.id, 
                            v.title, 
                            v.description, 
                            v.subject,
                            'video' as source
                        FROM video_lessons v
                        LEFT JOIN quiz_attempts qa ON 
                            qa.content_id = v.id AND 
                            qa.user_email = :email AND
                            qa.source = 'video'
                        WHERE 
                            v.subject = :subject AND
                            qa.id IS NULL
                        ORDER BY v.id ASC
                        LIMIT 2
                    ");
                    $videoQuery->bindParam(':email', $userEmail);
                    $videoQuery->bindParam(':subject', $subject);
                    $videoQuery->execute();
                    
                    while ($video = $videoQuery->fetch(PDO::FETCH_ASSOC)) {
                        $recommendations[] = [
                            'id' => $video['id'],
                            'title' => $video['title'],
                            'desc' => substr($video['description'] ?? '', 0, 50) . '...',
                            'subject' => $video['subject'],
                            'source' => 'video'
                        ];
                        
                        if (count($recommendations) >= $limit) {
                            break 2; // Break both loops if we have enough
                        }
                    }
                } else {
                    // Get reading lessons in this subject
                    $lessonQuery = $pdo->prepare("
                        SELECT 
                            l.id, 
                            l.title, 
                            l.description, 
                            l.subject,
                            'read' as source
                        FROM lessons l
                        LEFT JOIN quiz_attempts qa ON 
                            qa.content_id = l.id AND 
                            qa.user_email = :email AND
                            qa.source = 'read'
                        WHERE 
                            l.subject = :subject AND
                            qa.id IS NULL
                        ORDER BY l.id ASC
                        LIMIT 2
                    ");
                    $lessonQuery->bindParam(':email', $userEmail);
                    $lessonQuery->bindParam(':subject', $subject);
                    $lessonQuery->execute();
                    
                    while ($lesson = $lessonQuery->fetch(PDO::FETCH_ASSOC)) {
                        $recommendations[] = [
                            'id' => $lesson['id'],
                            'title' => $lesson['title'],
                            'desc' => substr($lesson['description'] ?? '', 0, 50) . '...',
                            'subject' => $lesson['subject'],
                            'source' => 'read'
                        ];
                        
                        if (count($recommendations) >= $limit) {
                            break 2; // Break both loops if we have enough
                        }
                    }
                }
                
                // If we still need more, try alternate learning style
                if (count($recommendations) < $limit) {
                    $alternateStyle = ($preferredStyle === 'video') ? 'read' : 'video';
                    $contentTable = ($alternateStyle === 'video') ? 'video_lessons' : 'lessons';
                    
                    $alternateQuery = $pdo->prepare("
                        SELECT 
                            c.id, 
                            c.title, 
                            c.description, 
                            c.subject,
                            :alt_style as source
                        FROM {$contentTable} c
                        LEFT JOIN quiz_attempts qa ON 
                            qa.content_id = c.id AND 
                            qa.user_email = :email AND
                            qa.source = :alt_style
                        WHERE 
                            c.subject = :subject AND
                            qa.id IS NULL
                        ORDER BY c.id ASC
                        LIMIT 1
                    ");
                    $alternateQuery->bindParam(':email', $userEmail);
                    $alternateQuery->bindParam(':subject', $subject);
                    $alternateQuery->bindParam(':alt_style', $alternateStyle);
                    $alternateQuery->execute();
                    
                    while ($content = $alternateQuery->fetch(PDO::FETCH_ASSOC)) {
                        $recommendations[] = [
                            'id' => $content['id'],
                            'title' => $content['title'],
                            'desc' => substr($content['description'] ?? '', 0, 50) . '...',
                            'subject' => $content['subject'],
                            'source' => $alternateStyle
                        ];
                        
                        if (count($recommendations) >= $limit) {
                            break; // Break if we have enough
                        }
                    }
                }
            }
        }
        
        // If still no recommendations, get some popular content
        if (empty($recommendations)) {
            // Get popular content across all users
            $popularQuery = $pdo->query("
                SELECT 
                    CASE 
                        WHEN qa.source = 'read' THEN l.id
                        ELSE v.id
                    END as id,
                    CASE 
                        WHEN qa.source = 'read' THEN l.title
                        ELSE v.title
                    END as title,
                    CASE 
                        WHEN qa.source = 'read' THEN l.description
                        ELSE v.description
                    END as description,
                    CASE 
                        WHEN qa.source = 'read' THEN l.subject
                        ELSE v.subject
                    END as subject,
                    qa.source,
                    COUNT(qa.id) as attempt_count
                FROM quiz_attempts qa
                LEFT JOIN lessons l ON qa.source = 'read' AND qa.content_id = l.id
                LEFT JOIN video_lessons v ON qa.source = 'video' AND qa.content_id = v.id
                GROUP BY id, title, description, subject, qa.source
                ORDER BY attempt_count DESC
                LIMIT {$limit}
            ");
            
            while ($content = $popularQuery->fetch(PDO::FETCH_ASSOC)) {
                $recommendations[] = [
                    'id' => $content['id'],
                    'title' => $content['title'],
                    'desc' => substr($content['description'] ?? '', 0, 50) . '...',
                    'subject' => $content['subject'],
                    'source' => $content['source']
                ];
            }
        }
    } catch (PDOException $e) {
        error_log("Error getting recommendations: " . $e->getMessage());
    }
    
    return $recommendations;
}
?>