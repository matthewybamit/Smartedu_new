
<?php
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

$successMsg = '';
$errorMsg = '';
$videos = [];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'delete_video':
                    if (isset($_POST['video_id']) && is_numeric($_POST['video_id'])) {
                        $stmt = $pdo->prepare("DELETE FROM video_lessons WHERE id = :id");
                        if ($stmt->execute([':id' => $_POST['video_id']])) {
                            header("Location: admin_videos.php?success=deleted");
                            exit;
                        }
                    }
                    break;
            }
        }
    }

    $stmt = $pdo->query("SELECT * FROM video_lessons ORDER BY date_created DESC");
    $videos = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $errorMsg = "Database error: " . $e->getMessage();
}

if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'created':
            $successMsg = "Video lesson created successfully!";
            break;
        case 'updated':
            $successMsg = "Video lesson updated successfully!";
            break;
        case 'deleted':
            $successMsg = "Video lesson deleted successfully!";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Video Lessons</title>

    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/admin_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <h1>Video Lessons Management</h1>
        
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
        
        <div class="container">
            <div class="form-section">
                <h3>Video Lessons</h3>
                
                <?php if (count($videos) > 0): ?>
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
                            <?php foreach ($videos as $video): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($video['title']); ?></td>
                                    <td><?php echo htmlspecialchars($video['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($video['level']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($video['date_created'])); ?></td>
                                    <td>
                                        <a href="edit_video.php?id=<?php echo $video['id']; ?>" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="post" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this video lesson?');">
                                            <input type="hidden" name="action" value="delete_video">
                                            <input type="hidden" name="video_id" value="<?php echo $video['id']; ?>">
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
                    <p>No video lessons found. Create your first video lesson below.</p>
                <?php endif; ?>
                
                <div class="button-group">
                    <a href="create_video.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Video Lesson
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
