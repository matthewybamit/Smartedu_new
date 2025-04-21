<?php
// Include necessary files
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

// Initialize variables
$successMsg = '';
$errorMsg = '';
$quizData = [
    'id' => '',
    'lesson_id' => '',
    'title' => '',
    'description' => '',
    'total_points' => 0,
    'questions' => []
];
$lessonTitle = '';

// Check if quiz ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $quizId = $_GET['id'];

    // Get quiz data
    if (isset($_GET['video']) && $_GET['video'] == '1') {
        $quiz = getVideoQuizById($quizId);
    } else {
        $quiz = getQuizById($quizId);
    }

    if ($quiz) {
            $quizData = $quiz;

            // Check if this is a video quiz
            $isVideoQuiz = isset($_GET['video']) && $_GET['video'] == '1';

            if ($isVideoQuiz) {
                // For video quizzes, we'll handle differently
                $video = getVideoLessonById($quiz['video_id']);
                if ($video) {
                    $lessonTitle = $video['title']; // Use video title instead
                }
            } else {
                // Regular lesson quiz
                $lesson = getLessonById($quiz['lesson_id']);
                if ($lesson) {
                    $lessonTitle = $lesson['title'];
                }
            }
        } else {
            $errorMsg = "Quiz not found.";
        }
    } else {
        $errorMsg = "Invalid quiz ID.";
    }

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errorMsg)) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_quiz':
                // Validate and sanitize input
                $updatedData = validateAndSanitize($_POST, ['title']);

                if (isset($updatedData['error'])) {
                    $errorMsg = $updatedData['error'];
                } else {
                    // Update quiz in database
                    $sql = "UPDATE quizzes SET title = :title, description = :description WHERE id = :id";
                    $stmt = $pdo->prepare($sql);

                    if ($stmt->execute([
                        ':title' => $updatedData['title'],
                        ':description' => $updatedData['description'] ?? '',
                        ':id' => $quizId
                    ])) {
                        $successMsg = "Quiz updated successfully!";

                        // Update displayed data
                        if (isset($_GET['video']) && $_GET['video'] == '1') {
                            $quiz = getVideoQuizById($quizId);
                        } else {
                            $quiz = getQuizById($quizId);
                        }
                        if ($quiz) {
                            $quizData = $quiz;
                        }
                    } else {
                        $errorMsg = "Failed to update quiz. Please try again.";
                    }
                }
                break;

            case 'add_question':
                // Validate and sanitize input
                $questionData = validateAndSanitize($_POST, ['question_text', 'question_type', 'points']);

                if (isset($questionData['error'])) {
                    $errorMsg = $questionData['error'];
                } else {
                    $questionData['quiz_id'] = $quizId;

                    // Create question in database
                    $questionId = createQuestion($questionData);

                    if ($questionId) {
                        $successMsg = "Question added successfully!";

                        // If multiple choice, redirect to add options
                        if ($questionData['question_type'] === 'multiple-choice') {
                            header("Location: edit_question.php?id=$questionId&quiz_id=$quizId");
                            exit;
                        }

                        // Update displayed data
                        if (isset($_GET['video']) && $_GET['video'] == '1') {
                            $quiz = getVideoQuizById($quizId);
                        } else {
                            $quiz = getQuizById($quizId);
                        }
                        if ($quiz) {
                            $quizData = $quiz;
                        }
                    } else {
                        $errorMsg = "Failed to add question. Please try again.";
                    }
                }
                break;

            case 'delete_question':
                if (isset($_POST['question_id']) && is_numeric($_POST['question_id'])) {
                    if (deleteQuestion($_POST['question_id'])) {
                        $successMsg = "Question deleted successfully!";

                        // Update displayed data
                        if (isset($_GET['video']) && $_GET['video'] == '1') {
                            $quiz = getVideoQuizById($quizId);
                        } else {
                            $quiz = getQuizById($quizId);
                        }
                        if ($quiz) {
                            $quizData = $quiz;
                        }
                    } else {
                        $errorMsg = "Failed to delete question. Please try again.";
                    }
                }
                break;
        }
    }
}

// Get success message from URL parameter
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'created':
            $successMsg = "Quiz created successfully!";
            break;
        case 'question_updated':
            $successMsg = "Question updated successfully!";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Lesson Management</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/admin_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'includes/sidebar.php'; ?>
    <div class="admin-content">
        <h1>Edit Quiz</h1>

        <!-- Status Messages -->
        <?php if (!empty($successMsg)): ?>
            <div class="status-message success">
                <i class="fas fa-check-circle"></i> <?php echo $successMsg; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errorMsg)): ?>
            <div class="status-message error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $errorMsg; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($quizData['id'])): ?>
            <!-- Quiz Details Form -->
            <div class="container">
                <form method="post">
                    <input type="hidden" name="action" value="update_quiz">

                    <div class="form-section">
                        <h3>Quiz Details</h3>
                        <p><strong>Lesson:</strong> <?php echo htmlspecialchars($lessonTitle); ?></p>
                        <p><strong>Total Points:</strong> <?php echo $quizData['total_points']; ?></p>

                        <label for="title">Quiz Title *</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($quizData['title']); ?>" required>

                        <label for="description">Description</label>
                        <textarea id="description" name="description"><?php echo htmlspecialchars($quizData['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="button-group">
                        <?php if (isset($_GET['video']) && $_GET['video'] == '1'): ?>
                            <a href="admin_videos.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Videos
                            </a>
                        <?php else: ?>
                            <a href="edit_lesson.php?id=<?php echo $quizData['lesson_id']; ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Lesson
                            </a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Quiz
                        </button>
                    </div>
                </form>
            </div>

            <!-- Questions Section -->
            <div class="container" style="margin-top: 2rem;">
                <div class="form-section">
                    <h3>Questions</h3>

                    <?php if (isset($quizData['questions']) && count($quizData['questions']) > 0): ?>
                        <div class="questions-list">
                            <?php foreach ($quizData['questions'] as $index => $question): ?>
                                <div class="option-item">
                                    <div>
                                        <strong><?php echo $index + 1; ?>. <?php echo htmlspecialchars($question['question_text']); ?></strong> 
                                        <span class="badge"><?php echo htmlspecialchars($question['question_type']); ?></span>
                                        <span class="badge"><?php echo $question['points']; ?> points</span>
                                        <div>
                                            <?php if ($question['question_type'] === 'multiple-choice' && isset($question['options'])): ?>
                                                <p>Options:</p>
                                                <ul>
                                                    <?php foreach ($question['options'] as $option): ?>
                                                        <li class="<?php echo $option['is_correct'] ? 'correct-option' : ''; ?>">
                                                            <?php echo htmlspecialchars($option['option_text']); ?>
                                                            <?php if ($option['is_correct']): ?>
                                                                <i class="fas fa-check-circle" style="color: green;"></i>
                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="option-controls">
                                        <a href="edit_question.php?id=<?php echo $question['id']; ?>&quiz_id=<?php echo $quizData['id']; ?>" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="post" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                            <input type="hidden" name="action" value="delete_question">
                                            <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>No questions found for this quiz. Add a question below.</p>
                    <?php endif; ?>

                    <!-- Add Question Form -->
                    <div class="add-question-form">
                        <h4>Add New Question</h4>

                        <form method="post">
                            <input type="hidden" name="action" value="add_question">

                            <label for="question_text">Question Text *</label>
                            <textarea id="question_text" name="question_text" required></textarea>

                            <div class="row">
                                <div class="col">
                                    <label for="question_type">Question Type *</label>
                                    <select id="question_type" name="question_type" required>
                                        <option value="multiple-choice">Multiple Choice</option>
                                        <option value="true-false">True/False</option>
                                        <option value="short-answer">Short Answer</option>
                                    </select>
                                </div>

                                <div class="col">
                                    <label for="points">Points *</label>
                                    <input type="number" id="points" name="points" min="1" value="1" required>
                                </div>
                            </div>

                            <div class="button-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Question
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Auto-hide success messages after 5 seconds
        setTimeout(function() {
            const successMessage = document.querySelector('.status-message.success');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    </script>
</body>
</html>