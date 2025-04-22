<?php
/**
 * Performance analyzer functions for tracking and analyzing user learning performance
 */

/**
 * Update user performance metrics after completing a quiz
 * 
 * @param PDO $pdo Database connection
 * @param string $userEmail User's email
 * @param string $subject Quiz subject
 * @param int $score User's score
 * @param int $totalQuestions Total questions in quiz
 * @param string $learningStyle Learning style used (reading or video)
 * @return bool Success status
 */
function updateUserPerformance($pdo, $userEmail, $subject, $score, $totalQuestions, $learningStyle) {
    try {
        // Check if a performance record already exists for this user and subject
        $checkStmt = $pdo->prepare("
            SELECT * FROM user_performance 
            WHERE user_email = ? AND subject = ?
        ");
        $checkStmt->execute([$userEmail, $subject]);
        
        if ($checkStmt->rowCount() > 0) {
            // Update existing record
            $currentRecord = $checkStmt->fetch();
            $currentAvg = $currentRecord['avg_score'];
            $currentQuizzes = $currentRecord['quizzes_taken'];
            
            // Calculate new average score
            $newTotalScore = ($currentAvg * $currentQuizzes) + (($score / $totalQuestions) * 100);
            $newQuizCount = $currentQuizzes + 1;
            $newAvgScore = $newTotalScore / $newQuizCount;
            
            // Determine learning style preference
            $newStyle = $currentRecord['learning_style'];
            if (empty($newStyle)) {
                $newStyle = $learningStyle;
            } else if ($newStyle !== $learningStyle) {
                // If they're using a different style than before, keep the one they use more
                $checkStyleStmt = $pdo->prepare("
                    SELECT COUNT(*) as count, source 
                    FROM quiz_attempts 
                    WHERE user_email = ? 
                    GROUP BY source 
                    ORDER BY count DESC 
                    LIMIT 1
                ");
                $checkStyleStmt->execute([$userEmail]);
                if ($styleResult = $checkStyleStmt->fetch()) {
                    $newStyle = $styleResult['source'];
                }
            }
            
            // Update record
            $updateStmt = $pdo->prepare("
                UPDATE user_performance 
                SET avg_score = ?, 
                    quizzes_taken = ?, 
                    learning_style = ?,
                    last_updated = NOW() 
                WHERE user_email = ? AND subject = ?
            ");
            $updateStmt->execute([$newAvgScore, $newQuizCount, $newStyle, $userEmail, $subject]);
            
        } else {
            // Create new record
            $newAvgScore = ($score / $totalQuestions) * 100;
            
            $insertStmt = $pdo->prepare("
                INSERT INTO user_performance 
                (user_email, subject, avg_score, quizzes_taken, learning_style, last_updated) 
                VALUES (?, ?, ?, 1, ?, NOW())
            ");
            $insertStmt->execute([$userEmail, $subject, $newAvgScore, $learningStyle]);
        }
        
        // Log this quiz attempt
        $logStmt = $pdo->prepare("
            INSERT INTO quiz_attempts 
            (user_email, quiz_id, score, total_questions, source, subject, date_completed) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        $logStmt->execute([$userEmail, $currentRecord['id'] ?? 0, $score, $totalQuestions, $learningStyle, $subject]);
        
        return true;
    } catch (PDOException $e) {
        error_log("Error updating user performance: " . $e->getMessage());
        return false;
    }
}

/**
 * Get performance metrics for a user across all subjects
 * 
 * @param PDO $pdo Database connection
 * @param string $userEmail User's email
 * @return array Performance metrics
 */
function getUserPerformanceMetrics($pdo, $userEmail) {
    try {
        // Get overall metrics
        $metrics = [
            'overall_avg_score' => 0,
            'total_quizzes' => 0,
            'subjects' => [],
            'learning_style' => null,
            'latest_attempt' => null,
            'cluster' => null
        ];
        
        // Get subject performance
        $subjectStmt = $pdo->prepare("
            SELECT * FROM user_performance 
            WHERE user_email = ? 
            ORDER BY avg_score DESC
        ");
        $subjectStmt->execute([$userEmail]);
        
        $totalScoreWeighted = 0;
        $totalQuizzes = 0;
        
        while ($row = $subjectStmt->fetch()) {
            $metrics['subjects'][$row['subject']] = [
                'avg_score' => round($row['avg_score'], 1),
                'quizzes_taken' => $row['quizzes_taken'],
                'learning_style' => $row['learning_style']
            ];
            
            // Weight by number of quizzes taken
            $totalScoreWeighted += $row['avg_score'] * $row['quizzes_taken'];
            $totalQuizzes += $row['quizzes_taken'];
            
            // Use most frequently used learning style
            if ($metrics['learning_style'] === null || 
                $row['quizzes_taken'] > $metrics['subjects'][$metrics['learning_style']]['quizzes_taken']) {
                $metrics['learning_style'] = $row['subject'];
            }
        }
        
        // Calculate overall average
        if ($totalQuizzes > 0) {
            $metrics['overall_avg_score'] = round($totalScoreWeighted / $totalQuizzes, 1);
            $metrics['total_quizzes'] = $totalQuizzes;
        }
        
        // Get latest quiz attempt
        $latestStmt = $pdo->prepare("
            SELECT * FROM quiz_attempts 
            WHERE user_email = ? 
            ORDER BY date_completed DESC 
            LIMIT 1
        ");
        $latestStmt->execute([$userEmail]);
        if ($latest = $latestStmt->fetch()) {
            $metrics['latest_attempt'] = $latest;
        }
        
        // Get user's cluster
        $clusterStmt = $pdo->prepare("
            SELECT cluster_id FROM user_clusters 
            WHERE user_email = ? 
            ORDER BY last_updated DESC 
            LIMIT 1
        ");
        $clusterStmt->execute([$userEmail]);
        if ($cluster = $clusterStmt->fetch()) {
            $metrics['cluster'] = $cluster['cluster_id'];
        }
        
        return $metrics;
    } catch (PDOException $e) {
        error_log("Error getting user performance metrics: " . $e->getMessage());
        return $metrics;
    }
}

/**
 * Get performance statistics for all users
 * 
 * @param PDO $pdo Database connection
 * @return array Performance statistics
 */
function getSystemPerformanceStats($pdo) {
    try {
        $stats = [
            'total_users' => 0,
            'active_users' => 0,
            'avg_score_by_subject' => [],
            'learning_style_distribution' => [
                'reading' => 0,
                'video' => 0
            ],
            'cluster_distribution' => []
        ];
        
        // Count total users
        $userStmt = $pdo->query("SELECT COUNT(*) FROM users");
        $stats['total_users'] = $userStmt->fetchColumn();
        
        // Count active users (took at least one quiz)
        $activeStmt = $pdo->query("
            SELECT COUNT(DISTINCT user_email) 
            FROM quiz_attempts
        ");
        $stats['active_users'] = $activeStmt->fetchColumn();
        
        // Get average scores by subject
        $subjectStmt = $pdo->query("
            SELECT subject, AVG(avg_score) as avg_score 
            FROM user_performance 
            GROUP BY subject
        ");
        while ($row = $subjectStmt->fetch()) {
            $stats['avg_score_by_subject'][$row['subject']] = round($row['avg_score'], 1);
        }
        
        // Get learning style distribution
        $styleStmt = $pdo->query("
            SELECT learning_style, COUNT(*) as count 
            FROM user_performance 
            WHERE learning_style IS NOT NULL 
            GROUP BY learning_style
        ");
        while ($row = $styleStmt->fetch()) {
            $stats['learning_style_distribution'][$row['learning_style']] = $row['count'];
        }
        
        // Get cluster distribution
        $clusterStmt = $pdo->query("
            SELECT cluster_id, COUNT(*) as count 
            FROM user_clusters 
            GROUP BY cluster_id
        ");
        while ($row = $clusterStmt->fetch()) {
            $stats['cluster_distribution'][$row['cluster_id']] = $row['count'];
        }
        
        return $stats;
    } catch (PDOException $e) {
        error_log("Error getting system performance stats: " . $e->getMessage());
        return $stats;
    }
}
?>
