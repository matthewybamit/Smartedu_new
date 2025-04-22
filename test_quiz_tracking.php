<?php
/**
 * Test script for quiz tracking and K-means clustering
 * This script simulates quiz submissions and verifies database updates
 */

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Set a test user in the session if not already logged in
if (!isset($_SESSION['email']) && !isset($_SESSION['user_email'])) {
    $_SESSION['email'] = 'test@example.com';
    $_SESSION['first_name'] = 'Test';
    $_SESSION['last_name'] = 'User';
}

// Include necessary files
require_once 'php_functions/db_connection.php';
require_once 'php_functions/kmeans_clustering.php';

echo "<h1>Quiz Tracking Test</h1>";

// Check if users table exists and create it if not
try {
    $pdo->query("SELECT 1 FROM users LIMIT 1");
    echo "<p>✓ Users table exists</p>";
} catch (PDOException $e) {
    echo "<p>⚠️ Users table does not exist. Creating it...</p>";
    include 'php_functions/create_users_table.php';
}

// Check if quiz_attempts table exists and create it if not
try {
    $pdo->query("SELECT 1 FROM quiz_attempts LIMIT 1");
    echo "<p>✓ Quiz attempts table exists</p>";
} catch (PDOException $e) {
    echo "<p>⚠️ Quiz attempts table does not exist. Creating it...</p>";
    include 'php_functions/update_database.php';
}

// Check if user_performance table exists
try {
    $pdo->query("SELECT 1 FROM user_performance LIMIT 1");
    echo "<p>✓ User performance table exists</p>";
} catch (PDOException $e) {
    echo "<p>⚠️ User performance table does not exist. Creating it...</p>";
    include 'php_functions/update_database.php';
}

// Check other required tables
$requiredTables = ['user_clusters', 'recommendations', 'lessons', 'video_lessons', 'quizzes', 'video_quizzes'];
foreach ($requiredTables as $table) {
    try {
        $pdo->query("SELECT 1 FROM $table LIMIT 1");
        echo "<p>✓ $table table exists</p>";
    } catch (PDOException $e) {
        echo "<p>⚠️ $table table does not exist. Will be created during setup...</p>";
    }
}

// Test user in database
$userEmail = $_SESSION['email'];
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $userEmail);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "<p>✓ Test user exists in database</p>";
    } else {
        echo "<p>⚠️ Test user not found in database. Creating test user...</p>";
        $insertStmt = $pdo->prepare("
            INSERT INTO users (email, first_name, last_name, date_registered)
            VALUES (:email, :first_name, :last_name, NOW())
        ");
        $insertStmt->bindParam(':email', $userEmail);
        $insertStmt->bindParam(':first_name', $_SESSION['first_name']);
        $insertStmt->bindParam(':last_name', $_SESSION['last_name']);
        $insertStmt->execute();
        echo "<p>✓ Test user created</p>";
    }
} catch (PDOException $e) {
    echo "<p>⚠️ Error checking/creating test user: " . $e->getMessage() . "</p>";
}

// Test sample content
try {
    $videoCount = $pdo->query("SELECT COUNT(*) FROM video_lessons")->fetchColumn();
    $lessonCount = $pdo->query("SELECT COUNT(*) FROM lessons")->fetchColumn();
    
    if ($videoCount > 0 && $lessonCount > 0) {
        echo "<p>✓ Sample content exists ($videoCount videos, $lessonCount lessons)</p>";
    } else {
        echo "<p>⚠️ Sample content missing. Adding sample content...</p>";
        include 'php_functions/add_sample_content.php';
    }
} catch (PDOException $e) {
    echo "<p>⚠️ Error checking sample content: " . $e->getMessage() . "</p>";
}

// Simulate quiz submission
echo "<h2>Simulating quiz submissions...</h2>";

$testSubjects = ['Mathematics', 'Programming', 'Science'];
$testStyles = ['video', 'read'];

foreach ($testSubjects as $subject) {
    foreach ($testStyles as $source) {
        $score = rand(3, 5);  // Random score between 3-5
        $total = 5;  // Total questions
        
        echo "<p>Submitting quiz: $subject ($source) - Score: $score/$total</p>";
        
        try {
            // Begin transaction
            $pdo->beginTransaction();
            
            // 1. Save quiz attempt
            $stmt = $pdo->prepare("
                INSERT INTO quiz_attempts (
                    user_email, quiz_id, score, total_questions, source, subject, content_id, date_completed
                ) VALUES (
                    :email, :quiz_id, :score, :total, :source, :subject, :content_id, NOW()
                )
            ");
            
            $quizId = 1;
            $contentId = 1;
            
            $stmt->bindParam(':email', $userEmail);
            $stmt->bindParam(':quiz_id', $quizId);
            $stmt->bindParam(':score', $score);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':source', $source);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':content_id', $contentId);
            $stmt->execute();
            
            // 2. Update user performance for this subject
            $performanceStmt = $pdo->prepare("
                SELECT id, avg_score, quizzes_taken, learning_style 
                FROM user_performance 
                WHERE user_email = :email AND subject = :subject
            ");
            $performanceStmt->bindParam(':email', $userEmail);
            $performanceStmt->bindParam(':subject', $subject);
            $performanceStmt->execute();
            
            if ($performanceStmt->rowCount() > 0) {
                // Update existing performance record
                $performance = $performanceStmt->fetch(PDO::FETCH_ASSOC);
                $currentAvg = floatval($performance['avg_score']);
                $currentQuizzes = intval($performance['quizzes_taken']);
                
                // Calculate new average score
                $scorePercent = ($score / $total) * 100;
                $newTotalScore = ($currentAvg * $currentQuizzes) + $scorePercent;
                $newQuizCount = $currentQuizzes + 1;
                $newAvgScore = $newTotalScore / $newQuizCount;
                
                // Determine learning style preference
                $newStyle = $performance['learning_style'];
                if (!$newStyle) {
                    $newStyle = $source;
                }
                
                // Update performance record
                $updateStmt = $pdo->prepare("
                    UPDATE user_performance 
                    SET avg_score = :avg_score, 
                        quizzes_taken = :quizzes_taken, 
                        learning_style = :learning_style, 
                        last_updated = NOW() 
                    WHERE id = :id
                ");
                
                $updateStmt->bindParam(':avg_score', $newAvgScore);
                $updateStmt->bindParam(':quizzes_taken', $newQuizCount);
                $updateStmt->bindParam(':learning_style', $newStyle);
                $updateStmt->bindParam(':id', $performance['id']);
                $updateStmt->execute();
                
                echo "<p>✓ Updated existing performance record</p>";
            } else {
                // Create new performance record
                $newAvgScore = ($score / $total) * 100;
                
                $insertStmt = $pdo->prepare("
                    INSERT INTO user_performance (
                        user_email, subject, avg_score, quizzes_taken, learning_style, last_updated
                    ) VALUES (
                        :email, :subject, :avg_score, 1, :learning_style, NOW()
                    )
                ");
                
                $insertStmt->bindParam(':email', $userEmail);
                $insertStmt->bindParam(':subject', $subject);
                $insertStmt->bindParam(':avg_score', $newAvgScore);
                $insertStmt->bindParam(':learning_style', $source);
                $insertStmt->execute();
                
                echo "<p>✓ Created new performance record</p>";
            }
            
            // Commit all changes
            $pdo->commit();
            
        } catch (PDOException $e) {
            // Rollback on error
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            
            echo "<p>❌ Error saving quiz results: " . $e->getMessage() . "</p>";
        }
    }
}

// Run clustering manually
echo "<h2>Running K-means clustering...</h2>";
if (runClustering($pdo)) {
    echo "<p>✓ Clustering completed successfully</p>";
} else {
    echo "<p>⚠️ Clustering failed or not enough data</p>";
}

// Generate recommendations for test user
echo "<h2>Generating recommendations...</h2>";
$recommendations = getClusterBasedRecommendations($pdo, $userEmail, 5);

if (!empty($recommendations)) {
    echo "<p>✓ Generated " . count($recommendations) . " recommendations</p>";
    
    echo "<h3>Recommendations:</h3>";
    echo "<ul>";
    foreach ($recommendations as $rec) {
        echo "<li><strong>" . htmlspecialchars($rec['title']) . "</strong> (" . $rec['source'] . ")</li>";
    }
    echo "</ul>";
    
    // Save recommendations to database
    try {
        $pdo->beginTransaction();
        
        // Clear old recommendations
        $clearStmt = $pdo->prepare("DELETE FROM recommendations WHERE user_email = :email");
        $clearStmt->bindParam(':email', $userEmail);
        $clearStmt->execute();
        
        // Insert new recommendations
        $insertStmt = $pdo->prepare("
            INSERT INTO recommendations (
                user_email, content_type, content_id, priority, is_viewed, date_created
            ) VALUES (
                :email, :content_type, :content_id, :priority, 0, NOW()
            )
        ");
        
        foreach ($recommendations as $index => $rec) {
            $contentType = $rec['source'];
            $contentId = $rec['id'];
            $priority = 5 - min($index, 4); // Higher priority for first recommendations
            
            $insertStmt->bindParam(':email', $userEmail);
            $insertStmt->bindParam(':content_type', $contentType);
            $insertStmt->bindParam(':content_id', $contentId);
            $insertStmt->bindParam(':priority', $priority);
            $insertStmt->execute();
        }
        
        $pdo->commit();
        echo "<p>✓ Saved recommendations to database</p>";
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "<p>❌ Error saving recommendations: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>⚠️ No recommendations generated. This is normal if clustering data is insufficient.</p>";
}

// Check database tables
echo "<h2>Quiz Data Summary</h2>";
$quizCount = $pdo->query("SELECT COUNT(*) FROM quiz_attempts WHERE user_email = '$userEmail'")->fetchColumn();
$perfCount = $pdo->query("SELECT COUNT(*) FROM user_performance WHERE user_email = '$userEmail'")->fetchColumn();
$clusterCount = $pdo->query("SELECT COUNT(*) FROM user_clusters WHERE user_email = '$userEmail'")->fetchColumn();
$recCount = $pdo->query("SELECT COUNT(*) FROM recommendations WHERE user_email = '$userEmail'")->fetchColumn();

echo "<p>Quiz Attempts: $quizCount</p>";
echo "<p>Performance Records: $perfCount</p>";
echo "<p>Cluster Assignments: $clusterCount</p>";
echo "<p>Recommendations: $recCount</p>";

// Show all actions needed to fix issues
echo "<h2>Next Steps</h2>";
echo "<p>Based on the test results, take the following steps to ensure everything works:</p>";
echo "<ol>";

// Check if quiz_attempts table has the right structure
try {
    $pdo->query("SELECT content_id FROM quiz_attempts LIMIT 1");
} catch (PDOException $e) {
    echo "<li>Run the update_database.php script to ensure quiz_attempts table has the content_id column</li>";
}

// Check if we need to create sample content
if ($videoCount == 0 || $lessonCount == 0) {
    echo "<li>Run the add_sample_content.php script to add sample videos and lessons</li>";
}

echo "<li>Ensure you have a php_functions/db_connection.php file with proper database credentials</li>";
echo "<li>When taking a quiz, make sure the quiz is linked to a specific content (video or reading)</li>";
echo "<li>Check that your modified quizone.php file sends the results to php_functions/save_quiz_result.php</li>";
echo "<li>Modified dashboard.php should include the kmeans_clustering.php file to show recommendations</li>";
echo "</ol>";

echo "<p><a href='dashboard.php' style='padding: 10px 20px; background-color: #ff8800; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;'>Go to Dashboard</a></p>";
?>