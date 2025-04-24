
<?php
session_start();
include 'php_functions/db_connection.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);
$subject = $_GET['subject'] ?? '';
$level = $_GET['level'] ?? '';

// Fetch filtered videos from database
$videos = [];
try {
    $query = $pdo->prepare("
        SELECT * FROM video_lessons 
        WHERE subject = :subject 
        AND level = :level 
        ORDER BY date_created DESC
    ");
    $query->bindParam(':subject', $subject);
    $query->bindParam(':level', $level);
    $query->execute();
    $videos = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching videos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartEdu</title>
    <link rel="stylesheet" href="css/landing.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
</head>
    <style>
        body{
            background-color:#f5f5f5;
        }
        .videos-container {
            max-width: 1200px;
            max-height: 600px;
            margin: 40px auto;
            padding: 20px;
        }
        h1 {
            margin-left:30%;
        }
      
        .videos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .video-card {
            width: 1000px;
            height: 520px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 6px 9px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            margin-left: 30%;
        }
        
        .video-card:hover {
            transform: translateY(-5px);
        }
        
        .video-thumbnail {
            width: 100%;
            height: 380px;
            object-fit: cover;
        }
        
        .video-info {
            padding: 15px;
        }
        
        .video-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .video-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .watch-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ff8800;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        .watch-button:hover {
            background-color: #ff7700;
        }
        
        .no-videos {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo_container">
            <img src="photos/orange.png" class="logowl" alt="Logo">
            <div class="logo">Lumin</div>
        </div>
        <div class="burger_and_search">
            <a href="styles.php" class="search">
                <img src="photos/search.png" class="search-icon" alt="Search">
            </a>
            <div class="burger" id="burger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <ul id="nav-menu">
            <li><a href="landing_logout.php">Home</a></li>
            <li><a href="styles.php">Styles</a></li>
            <li><a href="MODULES.php">Modules</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li>
                <?php if ($isLoggedIn): ?>
          
                    <a href="logout.php">Log Out</a>
                <?php else: ?>
             
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</header>


    <div class="videos-container">
        <h1><?php echo htmlspecialchars($subject); ?> Videos - <?php echo htmlspecialchars($level); ?> Level</h1>
        
        <?php if (empty($videos)): ?>
            <div class="no-videos">
                <h2>No videos available for this selection</h2>
                <p>Try selecting a different subject or level</p>
                <a href="personalize.php?subject=<?php echo urlencode($subject); ?>" class="watch-button">Go Back</a>
            </div>
        <?php else: ?>
            <div class="videos-grid">
                <?php foreach ($videos as $video): ?>
                    <?php
                    // Extract video ID from URL for thumbnail
                    $videoId = "";
                    if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video['youtube_url'], $matches)) {
                        $videoId = $matches[1];
                    }
                    ?>
                    <div class="video-card">
                        <img src="https://img.youtube.com/vi/<?php echo $videoId; ?>/mqdefault.jpg" 
                             alt="<?php echo htmlspecialchars($video['title']); ?>" 
                             class="video-thumbnail">
                        <div class="video-info">
                            <div class="video-title"><?php echo htmlspecialchars($video['title']); ?></div>
                            <div class="video-description"><?php echo htmlspecialchars(substr($video['description'], 0, 100)) . '...'; ?></div>
                            <a href="video.php?id=<?php echo $video['id']; ?>" class="watch-button">Watch Video</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


</body>
</html>
