<?php
// Include necessary files
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

// Initialize variables
$errorMsg = '';
$lessonId = '';

// Handle quiz operations (delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete_quiz':
                if (isset($_POST['quiz_id']) && is_numeric($_POST['quiz_id'])) {
                    $quizId = $_POST['quiz_id'];
                    
                    if (deleteQuiz($quizId)) {
                        // If lessonId is provided, redirect back to lesson page
                        if (isset($_POST['lesson_id']) && is_numeric($_POST['lesson_id'])) {
                            $lessonId = $_POST['lesson_id'];
                            header("Location: edit_lesson.php?id=$lessonId&success=quiz_deleted");
                            exit;
                        } else {
                            header("Location: admin_lessons.php");
                            exit;
                        }
                    } else {
                        $errorMsg = "Failed to delete quiz. Please try again.";
                    }
                }
                break;
        }
    }
}

// If lessonId is provided, redirect to lesson page
if (isset($_GET['lesson_id']) && is_numeric($_GET['lesson_id'])) {
    $lessonId = $_GET['lesson_id'];
    header("Location: edit_lesson.php?id=$lessonId");
    exit;
}

// If there was an error, display it
if (!empty($errorMsg)) {
    echo $errorMsg;
}

// Default redirect if no other action taken
header("Location: admin_lessons.php");
exit;
?>