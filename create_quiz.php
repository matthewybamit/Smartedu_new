
<?php
// Include necessary files
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

// Initialize variables
$successMsg = '';
$errorMsg = '';
$lessonId = '';
$lessonTitle = '';

// Check if lesson ID is provided
if (isset($_GET['lesson_id']) && is_numeric($_GET['lesson_id'])) {
    $lessonId = $_GET['lesson_id'];
    
    // Get lesson data to verify it exists and show lesson title
    $lesson = getLessonById($lessonId);
    
    if ($lesson) {
        $lessonTitle = $lesson['title'];
    } else {
        $errorMsg = "Lesson not found.";
    }
} else {
    $errorMsg = "Invalid lesson ID.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errorMsg)) {
    if (isset($_POST['action']) && $_POST['action'] === 'create_quiz') {
        // Validate and sanitize input
        $quizData = validateAndSanitize($_POST, ['title', 'lesson_id']);
        
        if (isset($quizData['error'])) {
            $errorMsg = $quizData['error'];
        } else {
            try {
                // Start transaction
                $pdo->beginTransaction();
                
                // Create the quiz
                $sql = "INSERT INTO quizzes (lesson_id, title, description) VALUES (:lesson_id, :title, :description)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':lesson_id' => $quizData['lesson_id'],
                    ':title' => $quizData['title'],
                    ':description' => $_POST['description'] ?? null
                ]);
                $quizId = $pdo->lastInsertId(); // Get the newly created quiz ID
                // Assuming questions are being sent from the form in an array
                if (!empty($_POST['question_text'])) {
                    foreach ($_POST['question_text'] as $key => $questionText) {
                        if (!empty($questionText)) { // Check for empty question
                            $sqlQuestion = "INSERT INTO questions (quiz_id, question_text, question_type, points) VALUES (:quiz_id, :question_text, :question_type, :points)";
                            $stmtQuestion = $pdo->prepare($sqlQuestion);
                            $stmtQuestion->execute([
                                ':quiz_id' => $quizId,
                                ':question_text' => $questionText,
                                ':question_type' => $_POST['question_type'][$key], // Assuming question type is passed
                                ':points' => $_POST['points'][$key] // Assuming point value is passed
                            ]);
                        }
                    }
                }
                $pdo->commit();
                header("Location: edit_quiz.php?id=$quizId&success=created");
                exit;
            } catch (PDOException $e) {
                $pdo->rollBack();
                $errorMsg = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <link rel="stylesheet" href="css/admin_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-content">
        <h1>Create New Quiz</h1>
        
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
        
        <?php if (!empty($lessonId) && !empty($lessonTitle)): ?>
            <!-- Quiz Form -->
            <div class="container">
                <form method="post">
                    <input type="hidden" name="action" value="create_quiz">
                    <input type="hidden" name="lesson_id" value="<?php echo $lessonId; ?>">
                    
                    <div class="form-section">
                        <h3>Quiz Details for Lesson: <?php echo htmlspecialchars($lessonTitle); ?></h3>
                        
                        <label for="title">Quiz Title *</label>
                        <input type="text" id="title" name="title" required>
                        
                        <label for="description">Description</label>
                        <textarea id="description" name="description"></textarea>
                    </div>
                    
                    <div class="button-group">
                        <a href="edit_lesson.php?id=<?php echo $lessonId; ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Quiz
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
