<?php
// Include necessary files
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

// Initialize variables
$successMsg = '';
$errorMsg = '';
$questionData = [
    'id' => '',
    'quiz_id' => '',
    'question_text' => '',
    'question_type' => '',
    'points' => 1,
    'options' => []
];
$quizTitle = '';

// Check if question ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $questionId = $_GET['id'];
    $isVideoQuestion = isset($_GET['video']) && $_GET['video'] == '1';

    // Get question data
    try {
        if ($isVideoQuestion) {
            $sql = "SELECT * FROM video_questions WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $questionId]);
            $question = $stmt->fetch();

            if ($question) {
                $questionData = $question;

                // Get options if it's a multiple-choice question
                if ($question['question_type'] === 'multiple-choice') {
                    $sql = "SELECT * FROM video_question_options WHERE question_id = :question_id ORDER BY id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':question_id' => $questionId]);
                    $questionData['options'] = $stmt->fetchAll();
                }

                // Get quiz title
                $sql = "SELECT title FROM video_quizzes WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $question['quiz_id']]);
                $quizTitle = $stmt->fetchColumn();
            }
        } else {
            $sql = "SELECT * FROM questions WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $questionId]);
            $question = $stmt->fetch();

            if ($question) {
                $questionData = $question;

                // Get options if it's a multiple-choice question
                if ($question['question_type'] === 'multiple-choice') {
                    $sql = "SELECT * FROM options WHERE question_id = :question_id ORDER BY id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':question_id' => $questionId]);
                    $questionData['options'] = $stmt->fetchAll();
                }

                // Get quiz title
                $sql = "SELECT title FROM quizzes WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $question['quiz_id']]);
                $quizTitle = $stmt->fetchColumn();
            }
        }

        if (!isset($question) || !$question) {
            $errorMsg = "Question not found.";
        }
    } catch (PDOException $e) {
        $errorMsg = "Database error: " . $e->getMessage();
    }
} elseif (isset($_GET['quiz_id']) && is_numeric($_GET['quiz_id'])) {
    // New question for an existing quiz
    $questionData['quiz_id'] = $_GET['quiz_id'];

    // Get quiz title
    try {
        $sql = "SELECT title FROM quizzes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $questionData['quiz_id']]);
        $quizTitle = $stmt->fetchColumn();
    } catch (PDOException $e) {
        $errorMsg = "Database error: " . $e->getMessage();
    }
} else {
    $errorMsg = "Invalid question or quiz ID.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errorMsg)) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_question':
                // Validate and sanitize input
                $updatedData = validateAndSanitize($_POST, ['question_text', 'points']);

                if (isset($updatedData['error'])) {
                    $errorMsg = $updatedData['error'];
                } else {
                    try {
                        $pdo->beginTransaction();

                        // Update question in database
                        if ($isVideoQuestion) {
                            $sql = "UPDATE video_questions SET question_text = :question_text, points = :points WHERE id = :id";
                        } else {
                            $sql = "UPDATE questions SET question_text = :question_text, points = :points WHERE id = :id";
                        }
                        $stmt = $pdo->prepare($sql);

                        $stmt->execute([
                            ':question_text' => $updatedData['question_text'],
                            ':points' => $updatedData['points'],
                            ':id' => $questionId
                        ]);

                        // No need to update quiz points for video questions as it's calculated on the fly
                        if (!$isVideoQuestion) {
                            updateQuizPoints($questionData['quiz_id']);
                        }

                        $pdo->commit();
                        $successMsg = "Question updated successfully!";

                        // Update displayed data
                        if ($isVideoQuestion) {
                            $sql = "SELECT * FROM video_questions WHERE id = :id";
                        } else {
                            $sql = "SELECT * FROM questions WHERE id = :id";
                        }
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':id' => $questionId]);
                        $question = $stmt->fetch();

                        if ($question) {
                            $questionData = $question;

                            // Get options if it's a multiple-choice question
                            if ($question['question_type'] === 'multiple-choice') {
                                if ($isVideoQuestion) {
                                    $sql = "SELECT * FROM video_question_options WHERE question_id = :question_id ORDER BY id";
                                } else {
                                    $sql = "SELECT * FROM options WHERE question_id = :question_id ORDER BY id";
                                }
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([':question_id' => $questionId]);
                                $questionData['options'] = $stmt->fetchAll();
                            }
                        }
                    } catch (PDOException $e) {
                        $pdo->rollBack();
                        $errorMsg = "Database error: " . $e->getMessage();
                    }
                }
                break;

            case 'add_option':
                // Validate and sanitize input
                $optionData = validateAndSanitize($_POST, ['option_text']);

                if (isset($optionData['error'])) {
                    $errorMsg = $optionData['error'];
                } else {
                    $optionData['question_id'] = $questionId;
                    $optionData['is_correct'] = isset($_POST['is_correct']) ? true : false;

                    try {
                        // Create option in database
                        if ($isVideoQuestion) {
                            $sql = "INSERT INTO video_question_options (question_id, option_text, is_correct) VALUES (:question_id, :option_text, :is_correct)";
                        } else {
                            $sql = "INSERT INTO options (question_id, option_text, is_correct) VALUES (:question_id, :option_text, :is_correct)";
                        }
                        $stmt = $pdo->prepare($sql);

                        $stmt->execute([
                            ':question_id' => $optionData['question_id'],
                            ':option_text' => $optionData['option_text'],
                            ':is_correct' => $optionData['is_correct']
                        ]);

                        $successMsg = "Option added successfully!";

                        // Update displayed data
                        if ($isVideoQuestion) {
                            $sql = "SELECT * FROM video_questions WHERE id = :id";
                        } else {
                            $sql = "SELECT * FROM questions WHERE id = :id";
                        }
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':id' => $questionId]);
                        $question = $stmt->fetch();

                        if ($question) {
                            $questionData = $question;

                            // Get options
                            if ($isVideoQuestion) {
                                $sql = "SELECT * FROM video_question_options WHERE question_id = :question_id ORDER BY id";
                            } else {
                                $sql = "SELECT * FROM options WHERE question_id = :question_id ORDER BY id";
                            }
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([':question_id' => $questionId]);
                            $questionData['options'] = $stmt->fetchAll();
                        }
                    } catch (PDOException $e) {
                        $errorMsg = "Database error: " . $e->getMessage();
                    }
                }
                break;

            case 'delete_option':
                if (isset($_POST['option_id']) && is_numeric($_POST['option_id'])) {
                    try {
                        // Delete the option
                        if ($isVideoQuestion) {
                            $sql = "DELETE FROM video_question_options WHERE id = :id";
                        } else {
                            $sql = "DELETE FROM options WHERE id = :id";
                        }
                        $stmt = $pdo->prepare($sql);

                        if ($stmt->execute([':id' => $_POST['option_id']])) {
                            $successMsg = "Option deleted successfully!";

                            // Update displayed data
                            if ($isVideoQuestion) {
                                $sql = "SELECT * FROM video_questions WHERE id = :id";
                            } else {
                                $sql = "SELECT * FROM questions WHERE id = :id";
                            }
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([':id' => $questionId]);
                            $question = $stmt->fetch();

                            if ($question) {
                                $questionData = $question;

                                // Get options
                                if ($isVideoQuestion) {
                                    $sql = "SELECT * FROM video_question_options WHERE question_id = :question_id ORDER BY id";
                                } else {
                                    $sql = "SELECT * FROM options WHERE question_id = :question_id ORDER BY id";
                                }
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([':question_id' => $questionId]);
                                $questionData['options'] = $stmt->fetchAll();
                            }
                        } else {
                            $errorMsg = "Failed to delete option. Please try again.";
                        }
                    } catch (PDOException $e) {
                        $errorMsg = "Database error: " . $e->getMessage();
                    }
                }
                break;

            case 'set_correct_option':
                if (isset($_POST['option_id']) && is_numeric($_POST['option_id'])) {
                    try {
                        $pdo->beginTransaction();

                        // First, set all options for this question to not correct
                        if ($isVideoQuestion) {
                            $sql = "UPDATE video_question_options SET is_correct = false WHERE question_id = :question_id";
                        } else {
                            $sql = "UPDATE options SET is_correct = false WHERE question_id = :question_id";
                        }
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':question_id' => $questionId]);

                        // Then, set the selected option as correct
                        if ($isVideoQuestion) {
                            $sql = "UPDATE video_question_options SET is_correct = true WHERE id = :id";
                        } else {
                            $sql = "UPDATE options SET is_correct = true WHERE id = :id";
                        }
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':id' => $_POST['option_id']]);

                        $pdo->commit();
                        $successMsg = "Correct answer updated!";

                        // Update displayed data
                        if ($isVideoQuestion) {
                            $sql = "SELECT * FROM video_questions WHERE id = :id";
                        } else {
                            $sql = "SELECT * FROM questions WHERE id = :id";
                        }
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':id' => $questionId]);
                        $question = $stmt->fetch();

                        if ($question) {
                            $questionData = $question;

                            // Get options
                            if ($isVideoQuestion) {
                                $sql = "SELECT * FROM video_question_options WHERE question_id = :question_id ORDER BY id";
                            } else {
                                $sql = "SELECT * FROM options WHERE question_id = :question_id ORDER BY id";
                            }
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([':question_id' => $questionId]);
                            $questionData['options'] = $stmt->fetchAll();
                        }
                    } catch (PDOException $e) {
                        $pdo->rollBack();
                        $errorMsg = "Database error: " . $e->getMessage();
                    }
                }
                break;
        }
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
    <style>
        .badge {
            display: inline-block;
            padding: 0.25em 0.6em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
            background-color: #f0f0f0;
            color: #333;
            margin-left: 0.5rem;
        }

        .correct-answer {
            background-color: #e8f5e9;
            border-color: #4caf50;
        }

        .option-controls form {
            display: inline-block;
        }

        .option-text {
            flex: 1;
        }
    </style>
</head>
<!DOCTYPE html>
<html lang="en">

<body>


<?php include 'includes/sidebar.php'; ?>

    <div class="admin-content">
        <h1>Edit Question</h1>

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

        <?php if (!empty($questionData['quiz_id'])): ?>
            <!-- Question Form -->
            <div class="container">
                <div class="form-section">
                    <h3>Question Details</h3>
                    <p><strong>Quiz:</strong> <?php echo htmlspecialchars($quizTitle); ?></p>

                    <?php if (!empty($questionData['id'])): ?>
                        <form method="post">
                            <input type="hidden" name="action" value="update_question">

                            <label for="question_text">Question Text *</label>
                            <textarea id="question_text" name="question_text" required><?php echo htmlspecialchars($questionData['question_text']); ?></textarea>

                            <div class="row">
                                <div class="col">
                                    <label for="question_type">Question Type</label>
                                    <input type="text" id="question_type" value="<?php echo htmlspecialchars($questionData['question_type']); ?>" readonly>
                                </div>

                                <div class="col">
                                    <label for="points">Points *</label>
                                    <input type="number" id="points" name="points" min="1" value="<?php echo $questionData['points']; ?>" required>
                                </div>
                            </div>

                            <div class="button-group">
                                <a href="edit_quiz.php?id=<?php echo $questionData['quiz_id']; ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Quiz
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Question
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($questionData['question_type'] === 'multiple-choice'): ?>
                <!-- Options Section -->
                <div class="container" style="margin-top: 2rem;">
                    <div class="form-section">
                        <h3>Answer Options</h3>

                        <?php if (isset($questionData['options']) && count($questionData['options']) > 0): ?>
                            <div class="options-list">
                                <?php foreach ($questionData['options'] as $option): ?>
                                    <div class="option-item <?php echo $option['is_correct'] ? 'correct-option' : ''; ?>">
                                        <div class="option-text">
                                            <?php echo htmlspecialchars($option['option_text']); ?>
                                            <?php if ($option['is_correct']): ?>
                                                <span class="badge correct-answer">Correct Answer</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="option-controls">
                                            <?php if (!$option['is_correct']): ?>
                                                <form method="post">
                                                    <input type="hidden" name="action" value="set_correct_option">
                                                    <input type="hidden" name="option_id" value="<?php echo $option['id']; ?>">
                                                    <button type="submit" class="btn btn-secondary">
                                                        <i class="fas fa-check"></i> Mark as Correct
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this option?');">
                                                <input type="hidden" name="action" value="delete_option">
                                                <input type="hidden" name="option_id" value="<?php echo $option['id']; ?>">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>No options found for this question. Add options below.</p>
                        <?php endif; ?>

                        <!-- Add Option Form -->
                        <div class="add-option-form" style="margin-top: 2rem;">
                            <h4>Add New Option</h4>

                            <form method="post">
                                <input type="hidden" name="action" value="add_option">

                                <label for="option_text">Option Text *</label>
                                <input type="text" id="option_text" name="option_text" required>

                                <div style="margin-top: 1rem;">
                                    <label for="is_correct" style="display: inline;">
                                        <input type="checkbox" id="is_correct" name="is_correct" style="width: auto; margin-right: 0.5rem;">
                                        Mark as correct answer
                                    </label>
                                </div>

                                <div class="button-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add Option
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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