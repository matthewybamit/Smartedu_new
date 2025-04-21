
<?php
// Include database connection
require_once 'includes/db_connection.php';

// Initialize variables
$errorMsg = '';
$total_lessons = 0;
$total_quizzes = 0;
$total_questions = 0;
$total_videos = 0;
$recent_lessons = [];
$recent_videos = [];

try {
    // Access pdo from the included connection file
    
    // Total lessons count
    $stmt = $pdo->query("SELECT COUNT(*) FROM lessons");
    $total_lessons = $stmt->fetchColumn();
    
    // Total quizzes count
    $stmt = $pdo->query("SELECT COUNT(*) FROM quizzes");
    $total_quizzes = $stmt->fetchColumn();
    
    // Total questions count
    $stmt = $pdo->query("SELECT COUNT(*) FROM questions");
    $total_questions = $stmt->fetchColumn();
    
    // Total video lessons count
    $stmt = $pdo->query("SELECT COUNT(*) FROM video_lessons");
    $total_videos = $stmt->fetchColumn();
    
    // Get recent lessons
    $stmt = $pdo->query("SELECT * FROM lessons ORDER BY date_created DESC LIMIT 5");
    $recent_lessons = $stmt->fetchAll();
    
    // Get recent video lessons
    $stmt = $pdo->query("SELECT * FROM video_lessons ORDER BY date_created DESC LIMIT 5");
    $recent_videos = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $errorMsg = "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/admin_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .dashboard-card {
            background-color: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .dashboard-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #0E2C68;
        }
        
        .dashboard-card .count {
            font-size: 2.5rem;
            font-weight: 700;
            color: #122D64;
        }
        
        .dashboard-card .icon {
            font-size: 2.5rem;
            color: #F4A52A;
            margin-right: 1rem;
        }
        
        .card-content {
            display: flex;
            align-items: center;
        }
        
        .quick-links {
            margin-top: 1rem;
        }
        
        .quick-links a {
            display: block;
            margin-bottom: 0.5rem;
            color: #0E2C68;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .quick-links a:hover {
            color: #F4A52A;
        }
        
        .quick-links i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="admin-content">
        <h1>Admin Dashboard</h1>
        
        <!-- Status Messages -->
        <?php if (!empty($errorMsg)): ?>
            <div class="status-message error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $errorMsg; ?>
            </div>
        <?php endif; ?>
        
        <!-- Dashboard Cards -->
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Total Lessons</h3>
                <div class="card-content">
                    <i class="fas fa-book icon"></i>
                    <div class="count"><?php echo $total_lessons ?? 0; ?></div>
                </div>
            </div>
            
            <div class="dashboard-card">
                <h3>Video Lessons</h3>
                <div class="card-content">
                    <i class="fas fa-video icon"></i>
                    <div class="count"><?php echo $total_videos ?? 0; ?></div>
                </div>
            </div>
            
            <div class="dashboard-card">
                <h3>Total Quizzes</h3>
                <div class="card-content">
                    <i class="fas fa-question-circle icon"></i>
                    <div class="count"><?php echo $total_quizzes ?? 0; ?></div>
                </div>
            </div>
            
            <div class="dashboard-card">
                <h3>Total Questions</h3>
                <div class="card-content">
                    <i class="fas fa-tasks icon"></i>
                    <div class="count"><?php echo $total_questions ?? 0; ?></div>
                </div>
            </div>
        </div>
        
        <!-- Recent Lessons -->
        <div class="container" style="margin-top: 20px;">
            <div class="form-section">
                <h3>Recent Lessons</h3>
                
                <?php if (isset($recent_lessons) && count($recent_lessons) > 0): ?>
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
                            <?php foreach ($recent_lessons as $lesson): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                                    <td><?php echo htmlspecialchars($lesson['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($lesson['level']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($lesson['date_created'])); ?></td>
                                    <td>
                                        <a href="edit_lesson.php?id=<?php echo $lesson['id']; ?>" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No lessons found. Create your first lesson below.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Recent Video Lessons -->
        <div class="container">
            <div class="form-section">
                <h3>Recent Video Lessons</h3>
                
                <?php if (isset($recent_videos) && count($recent_videos) > 0): ?>
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
                            <?php foreach ($recent_videos as $video): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($video['title']); ?></td>
                                    <td><?php echo htmlspecialchars($video['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($video['level']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($video['date_created'])); ?></td>
                                    <td>
                                        <a href="edit_video.php?id=<?php echo $video['id']; ?>" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No video lessons found. Create your first video lesson below.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="container" style="margin-top: 2rem;">
            <div class="form-section">
                <h3>Quick Links</h3>
                
                <div class="quick-links">
                    <a href="create_lesson.php"><i class="fas fa-plus-circle"></i> Create New Lesson</a>
                    <a href="create_video.php"><i class="fas fa-video"></i> Create New Video Lesson</a>
                    <a href="admin_lessons.php"><i class="fas fa-book"></i> Manage Lessons</a>
                    <a href="admin_videos.php"><i class="fas fa-film"></i> Manage Video Lessons</a>
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
