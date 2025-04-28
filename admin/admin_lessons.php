
<?php
// Include database connection
require_once 'includes/db_connection.php';

// Initialize variables
$successMsg = '';
$errorMsg = '';
$lessons = [];

try {
    // Handle lesson operations (add/edit/delete)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'delete_lesson':
                    if (isset($_POST['lesson_id']) && is_numeric($_POST['lesson_id'])) {
                        // Delete the lesson (cascade will delete related quizzes, questions, etc.)
                        $stmt = $pdo->prepare("DELETE FROM lessons WHERE id = ?");
                        if ($stmt->execute([$_POST['lesson_id']])) {
                            $successMsg = "Lesson deleted successfully!";
                            header("Location: admin_lessons.php?success=deleted");
                            exit;
                        } else {
                            $errorMsg = "Failed to delete lesson. Please try again.";
                        }
                    }
                    break;
            }
        }
    }

    // Get all lessons for display
    $stmt = $pdo->query("SELECT *, DATE_FORMAT(date_created, '%Y-%m-%d %H:%i:%s') as formatted_date FROM lessons ORDER BY date_created DESC");
    $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $errorMsg = "Database error: " . $e->getMessage();
}

// Get success message from URL parameter
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'created':
            $successMsg = "Lesson created successfully!";
            break;
        case 'updated':
            $successMsg = "Lesson updated successfully!";
            break;
        case 'deleted':
            $successMsg = "Lesson deleted successfully!";
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
        <h1>Lesson Management</h1>
        
        <!-- Status Messages -->
        <?php if (!empty($successMsg)): ?>
            <div class="status-message success">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($successMsg); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errorMsg)): ?>
            <div class="status-message error">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>
        
        <!-- Lessons List -->
        <div class="container">
            <div class="form-section">
                <h3>Lessons</h3>
                
                <?php if (count($lessons) > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Subject</th>
                                <th>Level</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lessons as $lesson): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                                    <td><?php echo htmlspecialchars($lesson['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($lesson['level']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($lesson['formatted_date'])); ?></td>
                                    <td>
                                        <a href="edit_lesson.php?id=<?php echo $lesson['id']; ?>" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="manage_quizzes.php?lesson_id=<?php echo $lesson['id']; ?>" class="btn btn-secondary">
                                            <i class="fas fa-question-circle"></i> Quizzes
                                        </a>
                                        <form method="post" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                            <input type="hidden" name="action" value="delete_lesson">
                                            <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">
                                            <button type="submit" class="btn btn-danger lesson">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No lessons found. Create your first lesson below.</p>
                <?php endif; ?>
                
                <div class="button-group">
                    <a href="create_lesson.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Lesson
                    </a>
                </div>
            </div>
        </div>
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
