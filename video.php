<?php
session_start();
include 'php_functions/db_connection.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);

// Get video ID from query parameters
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch video data from the database
$video = null;
$videoId = '';
$title = 'Video Lesson';
$description = 'Watch and learn from this educational video. After viewing, test your knowledge with a short quiz.';

if ($id > 0) {
    try {
        $query = $pdo->prepare("SELECT * FROM video_lessons WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        
        if ($query->rowCount() > 0) {
            $video = $query->fetch(PDO::FETCH_ASSOC);
            $title = $video['title'];
            $description = $video['description'];
            
            // Extract YouTube video ID from URL
            if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video['youtube_url'], $matches)) {
                $videoId = $matches[1];
            }
        }
    } catch (PDOException $e) {
        error_log("Database error in video.php: " . $e->getMessage());
    }
}

// Fallback to default video ID and title from query parameters if database fetch failed
if (empty($videoId)) {
    $videoId = isset($_GET['videoId']) ? $_GET['videoId'] : '';
    $title = isset($_GET['title']) ? $_GET['title'] : 'Video Lesson';
}

// Get related videos (same subject)
$relatedVideos = [];
if ($video) {
    try {
        $query = $pdo->prepare("SELECT * FROM video_lessons WHERE subject = :subject AND id != :id LIMIT 4");
        $query->bindParam(':subject', $video['subject']);
        $query->bindParam(':id', $id);
        $query->execute();
        $relatedVideos = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching related videos: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - Lumin</title>
    <link rel="stylesheet" href="css/video.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
    <style>
        .related-videos {
            margin-top: 40px;
        }
        .related-videos h3 {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .related-video-item {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .related-video-item:hover {
            transform: scale(1.05);
        }
        .related-video-item img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .related-video-item .title {
            font-size: 0.9rem;
            font-weight: 600;
        }
        .video-thumbnail {
            position: relative;
        }
        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ff5722;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        .video-thumbnail:hover .play-button {
            opacity: 1;
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

<div class="container">
    <div class="title"><?php echo htmlspecialchars($title); ?></div>
    <div class="video-container">
        <?php if ($videoId): ?>
        <iframe width="100%" height="500" src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId); ?>" 
            frameborder="0" allowfullscreen></iframe>
        <?php else: ?>
        <div class="video-placeholder">
            <p>Video not available. Please return to the styles page and select a video.</p>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="container2">
        <div class="abt">ABOUT</div>
        <div class="parag"><?php echo htmlspecialchars($description); ?></div>
        
        <div class="quiz-section">
            <h2>Ready to test your knowledge?</h2>
            <a href="quizone.php?source=video&id=<?php echo htmlspecialchars($id); ?>" class="start-quiz-btn">Start Quiz</a>
        </div>

        <?php if (!empty($relatedVideos)): ?>
        <div class="related-videos">
            <h3>Related Videos</h3>
            <div class="video-grid">
                <?php foreach ($relatedVideos as $relVideo): ?>
                    <?php
                    // Extract YouTube video ID for thumbnail
                    $relVideoId = "";
                    if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $relVideo['youtube_url'], $matches)) {
                        $relVideoId = $matches[1];
                    }
                    ?>
                    <div class="related-video-item" onclick="location.href='video.php?id=<?php echo $relVideo['id']; ?>'">
                        <div class="video-thumbnail">
                            <img src="<?php echo !empty($relVideo['thumbnail_url']) ? htmlspecialchars($relVideo['thumbnail_url']) : 'https://img.youtube.com/vi/' . $relVideoId . '/mqdefault.jpg'; ?>" alt="Video Thumbnail">
                            <div class="play-button">▶</div>
                        </div>
                        <div class="title"><?php echo htmlspecialchars($relVideo['title']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<footer>
    <ul>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Terms Of Service</a></li>
        <li><a href="#">FAQs</a></li>
    </ul>
    <div class="reserve">&copy; 2025. All Rights Reserved.</div>
</footer>

<script>
    // Toggle the visibility of the menu
    const burger = document.getElementById('burger');
    const navMenu = document.getElementById('nav-menu');

    burger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
</script>

</body>
</html>