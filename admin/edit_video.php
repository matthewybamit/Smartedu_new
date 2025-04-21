
<?php
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

// Initialize variables
$successMsg = '';
$errorMsg = '';
$videoData = [
    'id' => '',
    'title' => '',
    'description' => '',
    'subject' => '',
    'youtube_url' => '',
    'quizzes' => []
];

// Check if video ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $videoId = $_GET['id'];
    
    // Get video data
    $video = getVideoLessonById($videoId);
    
    if ($video) {
        $videoData = $video;
    } else {
        $errorMsg = "Video not found.";
    }
} else {
    $errorMsg = "Invalid video ID.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errorMsg)) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_video':
                // Validate and sanitize input
                $updatedData = validateAndSanitize($_POST, ['title', 'subject']);
                
                if (isset($updatedData['error'])) {
                    $errorMsg = $updatedData['error'];
                } else {
                    try {
                        // Update video in database
                        $sql = "UPDATE video_lessons SET 
                                title = :title, 
                                description = :description,
                                subject = :subject,
                                youtube_url = :youtube_url 
                               WHERE id = :id";
                        $stmt = $pdo->prepare($sql);
                        
                        if ($stmt->execute([
                            ':title' => $updatedData['title'],
                            ':description' => $updatedData['description'] ?? '',
                            ':subject' => $updatedData['subject'],
                            ':youtube_url' => $updatedData['video_url'] ?? '',
                            ':id' => $videoId
                        ])) {
                            $successMsg = "Video updated successfully!";
                            
                            // Update displayed data
                            $video = getVideoLessonById($videoId);
                            if ($video) {
                                $videoData = $video;
                            }
                        } else {
                            $errorMsg = "Failed to update video. Please try again.";
                        }
                    } catch (PDOException $e) {
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
    <title>Admin - Video Management</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/admin_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'includes/sidebar.php'; ?>

<div class="admin-content">
    <h1>Edit Video Lesson</h1>
    
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
    
    <?php if (!empty($videoData['id'])): ?>
        <div class="container">
            <form method="post">
                <input type="hidden" name="action" value="update_video">
                
                <div class="form-section">
                    <h3>Video Details</h3>
                    
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($videoData['title']); ?>" required>
                    
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($videoData['description'] ?? ''); ?></textarea>
                    
                    <label for="video_url">Video URL *</label>
                    <input type="url" id="video_url" name="video_url" value="<?php echo htmlspecialchars($videoData['youtube_url']); ?>" required>
                    
                    <label for="level">Level *</label>
                    <select id="level" name="level" required>
                        <option value="">Select Level</option>
                        <option value="Beginner" <?php echo ($videoData['level'] === 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                        <option value="Intermediate" <?php echo ($videoData['level'] === 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                        <option value="Advanced" <?php echo ($videoData['level'] === 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
                    </select>

                    <label for="subject">Subject *</label>
                    <select id="subject" name="subject" required>
                        <option value="">Select Subject</option>
                        <option value="Mathematics" <?php echo ($videoData['subject'] === 'Mathematics') ? 'selected' : ''; ?>>Mathematics</option>
                        <option value="Science" <?php echo ($videoData['subject'] === 'Science') ? 'selected' : ''; ?>>Science</option>
                        <option value="English" <?php echo ($videoData['subject'] === 'English') ? 'selected' : ''; ?>>English</option>
                        <option value="History" <?php echo ($videoData['subject'] === 'History') ? 'selected' : ''; ?>>History</option>
                        <option value="Geography" <?php echo ($videoData['subject'] === 'Geography') ? 'selected' : ''; ?>>Geography</option>
                        <option value="Computer Science" <?php echo ($videoData['subject'] === 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                        <option value="Art" <?php echo ($videoData['subject'] === 'Art') ? 'selected' : ''; ?>>Art</option>
                        <option value="Music" <?php echo ($videoData['subject'] === 'Music') ? 'selected' : ''; ?>>Music</option>
                        <option value="Physical Education" <?php echo ($videoData['subject'] === 'Physical Education') ? 'selected' : ''; ?>>Physical Education</option>
                        <option value="Other" <?php echo ($videoData['subject'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                
                <div class="button-group">
                    <a href="admin_videos.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Videos
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Video
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Quizzes Section -->
        <div class="container" style="margin-top: 2rem;">
            <div class="form-section">
                <h3>Video Quizzes</h3>
                
                <?php if (isset($videoData['quizzes']) && count($videoData['quizzes']) > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Total Points</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($videoData['quizzes'] as $quiz): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                                    <td><?php echo htmlspecialchars($quiz['description'] ?? ''); ?></td>
                                    <td><?php echo $quiz['total_points']; ?> points</td>
                                    <td>
                                        <a href="edit_quiz.php?id=<?php echo $quiz['id']; ?>&video=1" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="post" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                            <input type="hidden" name="action" value="delete_quiz">
                                            <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
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
                    <p>No quizzes found for this video. Add a quiz in the create/edit form.</p>
                <?php endif; ?>
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
