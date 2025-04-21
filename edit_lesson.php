<?php
// Database connection configuration
$host = 'localhost'; 
$dbname = 'lumin_admin';
$user = 'root';
$password = '';

// Initialize variables
$successMsg = '';
$errorMsg = '';
$lessonData = [
    'id' => '',
    'title' => '',
    'description' => '',
    'level' => '',
    'subject' => '',
    'cover_photo' => '',
    'quizzes' => [],
    'materials' => []
];

try {
    // Create PDO instance for MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if lesson ID is provided
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $lessonId = $_GET['id'];
        
        // Get lesson data
        $stmt = $pdo->prepare("SELECT * FROM lessons WHERE id = :id");
        $stmt->execute([':id' => $lessonId]);
        $lesson = $stmt->fetch();
        
        if ($lesson) {
            $lessonData = $lesson;
            
            // Get associated quizzes
            $stmt = $pdo->prepare("SELECT * FROM quizzes WHERE lesson_id = :lesson_id");
            $stmt->execute([':lesson_id' => $lessonId]);
            $lessonData['quizzes'] = $stmt->fetchAll();
            
            // Get associated materials
            $stmt = $pdo->prepare("SELECT * FROM lesson_materials WHERE lesson_id = :lesson_id");
            $stmt->execute([':lesson_id' => $lessonId]);
            $lessonData['materials'] = $stmt->fetchAll();
        } else {
            $errorMsg = "Lesson not found.";
        }
    } else {
        $errorMsg = "Invalid lesson ID.";
    }
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'update_lesson') {
            // Simple validation
            if (empty($_POST['title']) || empty($_POST['subject'])) {
                $errorMsg = "Title and subject are required.";
            } else {
                // Begin transaction
                $pdo->beginTransaction();
                
                // Handle file upload if provided
                $coverPhoto = $lessonData['cover_photo'];
                if (isset($_FILES['cover_photo']) && $_FILES['cover_photo']['error'] === UPLOAD_ERR_OK) {
                    // Create directory if it doesn't exist
                    if (!is_dir('uploads/covers/')) {
                        mkdir('uploads/covers/', 0755, true);
                    }
                    
                    // Generate unique filename
                    $fileName = uniqid() . '_' . basename($_FILES['cover_photo']['name']);
                    $targetPath = 'uploads/covers/' . $fileName;
                    
                    // Upload file
                    if (move_uploaded_file($_FILES['cover_photo']['tmp_name'], $targetPath)) {
                        $coverPhoto = $targetPath;
                    }
                }
                
                // Update the lesson
                $stmt = $pdo->prepare("
                    UPDATE lessons 
                    SET title = :title, 
                        description = :description, 
                        level = :level, 
                        subject = :subject, 
                        cover_photo = :cover_photo
                    WHERE id = :id
                ");
                
                $result = $stmt->execute([
                    ':title' => $_POST['title'],
                    ':description' => $_POST['description'],
                    ':level' => $_POST['level'],
                    ':subject' => $_POST['subject'],
                    ':cover_photo' => $coverPhoto,
                    ':id' => $lessonId
                ]);
                
                if ($result) {
                    $pdo->commit();
                    $successMsg = "Lesson updated successfully!";
                    
                    // Update the displayed data
                    $stmt = $pdo->prepare("SELECT * FROM lessons WHERE id = :id");
                    $stmt->execute([':id' => $lessonId]);
                    $lesson = $stmt->fetch();
                    
                    if ($lesson) {
                        $lessonData = $lesson;
                        
                        // Get associated quizzes
                        $stmt = $pdo->prepare("SELECT * FROM quizzes WHERE lesson_id = :lesson_id");
                        $stmt->execute([':lesson_id' => $lessonId]);
                        $lessonData['quizzes'] = $stmt->fetchAll();
                        
                        // Get associated materials
                        $stmt = $pdo->prepare("SELECT * FROM lesson_materials WHERE lesson_id = :lesson_id");
                        $stmt->execute([':lesson_id' => $lessonId]);
                        $lessonData['materials'] = $stmt->fetchAll();
                    }
                } else {
                    $pdo->rollBack();
                    $errorMsg = "Failed to update lesson. Please try again.";
                }
            }
        }
    }
} catch (PDOException $e) {
    $errorMsg = "Database error: " . $e->getMessage();
}

// Get success message from URL parameter
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'created':
            $successMsg = "Lesson created successfully!";
            break;
        case 'quiz_added':
            $successMsg = "Quiz added successfully!";
            break;
        case 'quiz_updated':
            $successMsg = "Quiz updated successfully!";
            break;
        case 'quiz_deleted':
            $successMsg = "Quiz deleted successfully!";
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
        <h1>Edit Lesson</h1>
        
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
        
        <?php if (!empty($lessonData['id'])): ?>
            <!-- Lesson Form -->
            <div class="container">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update_lesson">
                    <input type="hidden" name="id" value="<?php echo $lessonData['id']; ?>">
                    
                    <div class="form-section">
                        <h3>Lesson Details</h3>
                        
                        <label for="title">Title *</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($lessonData['title']); ?>" required>
                        
                        <label for="description">Description</label>
                        <textarea id="description" name="description"><?php echo htmlspecialchars($lessonData['description']); ?></textarea>
                        
                        <div class="row">
                            <div class="col">
                                <label for="level">Level</label>
                                <select id="level" name="level">
                                    <option value="">Select Level</option>
                                    <option value="Beginner" <?php if ($lessonData['level'] === 'Beginner') echo 'selected'; ?>>Beginner</option>
                                    <option value="Intermediate" <?php if ($lessonData['level'] === 'Intermediate') echo 'selected'; ?>>Intermediate</option>
                                    <option value="Advanced" <?php if ($lessonData['level'] === 'Advanced') echo 'selected'; ?>>Advanced</option>
                                </select>
                            </div>
                            
                            <div class="col">
                                <label for="subject">Subject *</label>
                                <select id="subject" name="subject" required>
                                    <option value="">Select Subject</option>
                                    <option value="Mathematics" <?php if ($lessonData['subject'] === 'Mathematics') echo 'selected'; ?>>Mathematics</option>
                                    <option value="Science" <?php if ($lessonData['subject'] === 'Science') echo 'selected'; ?>>Science</option>
                                    <option value="English" <?php if ($lessonData['subject'] === 'English') echo 'selected'; ?>>English</option>
                                    <option value="History" <?php if ($lessonData['subject'] === 'History') echo 'selected'; ?>>History</option>
                                    <option value="Geography" <?php if ($lessonData['subject'] === 'Geography') echo 'selected'; ?>>Geography</option>
                                    <option value="Computer Science" <?php if ($lessonData['subject'] === 'Computer Science') echo 'selected'; ?>>Computer Science</option>
                                    <option value="Art" <?php if ($lessonData['subject'] === 'Art') echo 'selected'; ?>>Art</option>
                                    <option value="Music" <?php if ($lessonData['subject'] === 'Music') echo 'selected'; ?>>Music</option>
                                    <option value="Physical Education" <?php if ($lessonData['subject'] === 'Physical Education') echo 'selected'; ?>>Physical Education</option>
                                    <option value="Other" <?php if ($lessonData['subject'] === 'Other') echo 'selected'; ?>>Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <label for="cover_photo">Cover Photo</label>
                        <div class="file-upload-area">
                            <input type="file" id="cover_photo" name="cover_photo" accept="image/*">
                            <p>Drag and drop an image here, or click to select a file</p>
                        </div>
                        
                        <?php if (!empty($lessonData['cover_photo'])): ?>
                            <div id="preview_container" style="display: block;">
                                <p>Current Cover Photo:</p>
                                <img src="<?php echo htmlspecialchars($lessonData['cover_photo']); ?>" class="preview-image">
                            </div>
                        <?php else: ?>
                            <div id="preview_container" style="display: none;">
                                <img id="preview_image" class="preview-image">
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="button-group">
                        <a href="admin_lessons.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Lessons
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Lesson
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Quizzes Section -->
            <div class="container" style="margin-top: 2rem;">
                <div class="form-section">
                    <h3>Quizzes</h3>
                    
                    <?php if (isset($lessonData['quizzes']) && count($lessonData['quizzes']) > 0): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Points</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lessonData['quizzes'] as $quiz): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                                        <td><?php echo htmlspecialchars($quiz['description'] ?? ''); ?></td>
                                        <td><?php echo $quiz['total_points']; ?></td>
                                        <td>
                                            <a href="edit_quiz.php?id=<?php echo $quiz['id']; ?>" class="btn btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="post" action="manage_quizzes.php" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                                <input type="hidden" name="action" value="delete_quiz">
                                                <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                                                <input type="hidden" name="lesson_id" value="<?php echo $lessonData['id']; ?>">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No quizzes found for this lesson. Add a quiz below.</p>
                    <?php endif; ?>
                    
                    <div class="button-group">
                        <a href="create_quiz.php?lesson_id=<?php echo $lessonData['id']; ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Quiz
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Preview uploaded image
        const coverPhotoInput = document.getElementById('cover_photo');
        const previewContainer = document.getElementById('preview_container');
        let previewImage = document.getElementById('preview_image');
        
        // Create preview image if it doesn't exist
        if (!previewImage) {
            previewImage = document.createElement('img');
            previewImage.id = 'preview_image';
            previewImage.className = 'preview-image';
            previewContainer.appendChild(previewImage);
        }
        
        coverPhotoInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    previewImage.setAttribute('src', this.result);
                    previewContainer.style.display = 'block';
                });
                
                reader.readAsDataURL(file);
            }
        });
        
        // Auto-hide success messages after 5 seconds
        setTimeout(function() {
            const successMessage = document.querySelector('.status-message.success');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
        
        // Drag and drop functionality for file upload
        const uploadArea = document.querySelector('.file-upload-area');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            uploadArea.classList.add('highlight');
        }
        
        function unhighlight() {
            uploadArea.classList.remove('highlight');
        }
        
        uploadArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            coverPhotoInput.files = files;
            
            // Trigger change event
            const event = new Event('change');
            coverPhotoInput.dispatchEvent(event);
        }
    </script>
</body>
</html>