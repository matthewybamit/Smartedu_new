<?php
/**
 * Save quiz results and update user performance
 * This file handles saving quiz attempts and updating user performance metrics
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Include necessary files
require_once 'db_connection.php';
require_once 'kmeans_clustering.php';

// Check if user is logged in
if (!isset($_SESSION['email']) && !isset($_SESSION['user_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['user_email'];

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

try {
    $pdo->beginTransaction();

    // Save quiz attempt
    $stmt = $pdo->prepare("
        INSERT INTO quiz_attempts (
            user_email, quiz_id, score, total_questions, source, subject, content_id, date_completed
        ) VALUES (
            :email, :quiz_id, :score, :total, :source, :subject, :content_id, NOW()
        )
    ");

    $stmt->execute([
        ':email' => $userEmail,
        ':quiz_id' => $data['quiz_id'],
        ':score' => $data['score'],
        ':total' => $data['total'],
        ':source' => $data['source'],
        ':subject' => $data['subject'],
        ':content_id' => $data['content_id']
    ]);

    // Update user performance
    $performanceStmt = $pdo->prepare("
        SELECT id FROM user_performance 
        WHERE user_email = :email AND subject = :subject
    ");
    $performanceStmt->execute([':email' => $userEmail, ':subject' => $data['subject']]);

    if ($performanceStmt->rowCount() > 0) {
        // Update existing performance
        $stmt = $pdo->prepare("
            UPDATE user_performance 
            SET avg_score = ((avg_score * quizzes_taken) + :score) / (quizzes_taken + 1),
                quizzes_taken = quizzes_taken + 1,
                learning_style = :style,
                last_updated = NOW()
            WHERE user_email = :email AND subject = :subject
        ");
    } else {
        // Create new performance record
        $stmt = $pdo->prepare("
            INSERT INTO user_performance (
                user_email, subject, avg_score, quizzes_taken, learning_style, last_updated
            ) VALUES (
                :email, :subject, :score, 1, :style, NOW()
            )
        ");
    }

    $stmt->execute([
        ':email' => $userEmail,
        ':subject' => $data['subject'],
        ':score' => ($data['score'] / $data['total']) * 100,
        ':style' => $data['source']
    ]);

    // Check if we should run clustering
    $quizCount = $pdo->prepare("
        SELECT COUNT(*) as count FROM quiz_attempts WHERE user_email = :email
    ");
    $quizCount->execute([':email' => $userEmail]);
    $totalQuizzes = $quizCount->fetch(PDO::FETCH_ASSOC)['count'];

    $shouldRunClustering = ($totalQuizzes % 5 === 0); // Run every 5 quizzes

    $pdo->commit();

    if ($shouldRunClustering) {
        runClustering($pdo);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Quiz results saved successfully',
        'data' => [
            'clustering_run' => $shouldRunClustering
        ]
    ]);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Error saving quiz results: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>