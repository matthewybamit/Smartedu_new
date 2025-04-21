<?php
session_start();
include 'php_functions/db_connection.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);

// Fetch video lessons from the database
$videos = [];
try {
    $query = $pdo->query("SELECT * FROM video_lessons ORDER BY id ASC");
    $videos = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching videos: " . $e->getMessage());
}

// Fetch regular lessons (modules) from the database
$modules = [];
try {
    $query = $pdo->query("SELECT * FROM lessons ORDER BY id ASC");
    $modules = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching modules: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumin - Learning Styles</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <script defer src="js/carouselvid.js"></script>
    <script defer src="js/videoHandler.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
</head>

<style>
    
</style>
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
    <div class="search-bar">
        <input type="text" placeholder="Search..." id="searchInput">
        <button><img src="photos/search.png" alt="Search"></button>
    </div>
    
    <h2>VIDEOS</h2>
    <div class="carousel-wrapper">
        <button class="prev"><img src="photos/caret-left-fill.png"></button>
        <div class="carousel">
            <?php if (!empty($videos)): ?>
                <?php foreach ($videos as $video): ?>
                    <div class="video-item" data-video-id="<?php echo $video['id']; ?>">
                        <?php 
                        // Extract YouTube video ID from URL
                        $youtubeUrl = $video['youtube_url'];
                        $videoId = "";
                        
                        if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $youtubeUrl, $matches)) {
                            $videoId = $matches[1];
                        }
                        ?>
                        <div class="video-thumbnail" onclick="watchVideo(<?php echo $video['id']; ?>)">
                            <img src="<?php echo !empty($video['thumbnail_url']) ? htmlspecialchars($video['thumbnail_url']) : 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg'; ?>" alt="Video Thumbnail">
                            <div class="play-button">▶</div>
                        </div>
                        <p><?php echo htmlspecialchars($video['title']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback content if no videos in database -->
                <div class="video-item">
                    <div class="video-thumbnail" onclick="watchVideo('2ePf9rue1Ao', 'English - Improve Your Vocabulary')">
                        <img src="https://img.youtube.com/vi/2ePf9rue1Ao/hqdefault.jpg" alt="Video Thumbnail">
                        <div class="play-button">▶</div>
                    </div>
                    <p>English - Improve Your Vocabulary</p>
                </div>
                <div class="video-item">
                    <div class="video-thumbnail" onclick="watchVideo('9D05ej8u-gU', 'Science - The Solar System')">
                        <img src="https://img.youtube.com/vi/9D05ej8u-gU/hqdefault.jpg" alt="Video Thumbnail">
                        <div class="play-button">▶</div>
                    </div>
                    <p>Science - The Solar System</p>
                </div>
                <div class="video-item">
                    <div class="video-thumbnail" onclick="watchVideo('5MgBikgcWnY', 'Mathematics - Algebra Basics')">
                        <img src="https://img.youtube.com/vi/5MgBikgcWnY/hqdefault.jpg" alt="Video Thumbnail">
                        <div class="play-button">▶</div>
                    </div>
                    <p>Mathematics - Algebra Basics</p>
                </div>
                <div class="video-item">
                    <div class="video-thumbnail" onclick="watchVideo('3JZ_D3ELwOQ', 'History - Ancient Civilizations')">
                        <img src="https://img.youtube.com/vi/3JZ_D3ELwOQ/hqdefault.jpg" alt="Video Thumbnail">
                        <div class="play-button">▶</div>
                    </div>
                    <p>History - Ancient Civilizations</p>
                </div>
            <?php endif; ?>
        </div>
        <button class="next"><img src="photos/caret-right-fill.png" alt=""></button>
    </div>

    <div class="books-container">
        <div class="booktitle">MODULES</div>
        <div class="books-grid">
            <?php if (!empty($modules)): ?>
                <?php foreach ($modules as $module): ?>
                    <div class="book-item" onclick="openModule('<?php echo $module['subject']; ?>', '<?php echo $module['level']; ?>')">
                        <img src="<?php echo !empty($module['cover_photo']) ? htmlspecialchars($module['cover_photo']) : 'https://via.placeholder.com/150x200'; ?>" alt="<?php echo htmlspecialchars($module['title']); ?> Cover" class="book-cover" style="width: 150px; height: 200px;">
                        <p><?php echo htmlspecialchars($module['title']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback content if no modules in database -->
                <div class="book-item" onclick="openModule('History', 'Intermediate')">
                    <img src="https://m.media-amazon.com/images/I/81zwMtN5ziL._AC_UF1000,1000_QL80_.jpg" alt="History Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                    <p>History - Ancient Civilizations</p>
                </div>
                <div class="book-item" onclick="openModule('Science', 'Beginner')">
                    <img src="https://worldscientific.com/cms/10.1142/13807/asset/190d9865-4019-d986-1401-0d9865140190/13807.cover.jpg" alt="Science Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                    <p>Science - The Wonders of Science</p>
                </div>
                <div class="book-item" onclick="openModule('Mathematics', 'Advanced')">
                    <img src="https://m.media-amazon.com/images/I/71TOWmvvvPL._AC_UF1000,1000_QL80_.jpg" alt="Mathematics Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                    <p>Mathematics - Algebra Essentials</p>
                </div>
                <div class="book-item" onclick="openModule('English', 'Intermediate')">
                    <img src="https://m.media-amazon.com/images/I/71LM5u45AlL._AC_UF1000,1000_QL80_.jpg" alt="English Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                    <p>English - Mastering Vocabulary</p>
                </div>
            <?php endif; ?>
        </div>
    </div> <!-- Closing books-container -->

    <footer>
        <ul style="display: flex; flex-wrap: wrap; justify-content: center; padding: 0; list-style: none; margin: 20px 0;">
            <li style="margin: 10px;"><a href="#" style="text-decoration: none; color: inherit;">About Us</a></li>
            <li style="margin: 10px;"><a href="#" style="text-decoration: none; color: inherit;">Privacy Policy</a></li>
            <li style="margin: 10px;"><a href="#" style="text-decoration: none; color: inherit;">Terms Of Service</a></li>
            <li style="margin: 10px;"><a href="#" style="text-decoration: none; color: inherit;">FAQs</a></li>
        </ul>
        <div class="reserve" style="text-align: center; font-size: 14px;">&copy; 2025. All Rights Reserved.</div>
    </footer>

    <script>
    // Toggle the visibility of the menu
    const burger = document.getElementById('burger');
    const navMenu = document.getElementById('nav-menu');

    burger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });

    // Function to navigate to video.php with the video ID
    function watchVideo(videoId) {
        window.location.href = `video.php?id=${videoId}`;
    }

    // Function to navigate to read.php with subject and level
    function openModule(subject, level) {
        window.location.href = `read.php?subject=${encodeURIComponent(subject)}&level=${encodeURIComponent(level)}`;
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const videoItems = document.querySelectorAll('.video-item p');
        const bookItems = document.querySelectorAll('.book-item p');
        
        // Search in videos
        videoItems.forEach(item => {
            const parent = item.parentElement;
            if (item.textContent.toLowerCase().includes(searchTerm)) {
                parent.style.display = 'block';
            } else {
                parent.style.display = 'none';
            }
        });
        
        // Search in books
        bookItems.forEach(item => {
            const parent = item.parentElement;
            if (item.textContent.toLowerCase().includes(searchTerm)) {
                parent.style.display = 'block';
            } else {
                parent.style.display = 'none';
            }
        });
    });
    </script>

</body>
</html>