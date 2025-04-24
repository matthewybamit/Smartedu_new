<?php
session_start();
include 'php_functions/db_connection.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);
$subject = $_GET['subject'] ?? '';
$level = $_GET['level'] ?? '';

// Fetch filtered lessons from database
$lessons = [];
try {
    $query = $pdo->prepare("
        SELECT * FROM lessons 
        WHERE subject = :subject 
        AND level = :level 
        ORDER BY id ASC
    ");
    $query->bindParam(':subject', $subject);
    $query->bindParam(':level', $level);
    $query->execute();
    $lessons = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching lessons: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reading Lessons - <?php echo htmlspecialchars($subject); ?></title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .lessons-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .lessons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .lesson-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .lesson-card:hover {
            transform: translateY(-5px);
        }
        
        .lesson-thumbnail {
            width: 100%;
            height: 180px;
            background-color: #f5f5f5;
            position: relative;
            overflow: hidden;
        }
        
        .lesson-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .no-cover {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            height: 100%;
        }
        
        .lesson-info {
            padding: 15px;
        }
        
        .lesson-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .lesson-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .read-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ff8800;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        .read-button:hover {
            background-color: #e67a00;
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

                    <!-- admin/uploads/covers/ this is for later use-->

    <div class="lessons-container">
        <h1><?php echo htmlspecialchars($subject); ?> Reading Lessons</h1>
        <h2><?php echo htmlspecialchars($level); ?> Level</h2>

        <?php if (!empty($lessons)): ?>
            <div class="lessons-grid">
                <?php foreach ($lessons as $lesson): ?>
                    <div class="lesson-card">
                        <div class="lesson-thumbnail">
                            <?php if (!empty($lesson['cover_photo'])): ?>
                                <img src="admin/<?php echo htmlspecialchars($lesson['cover_photo']); ?>" alt="<?php echo htmlspecialchars($lesson['title']); ?> cover">
                            <?php else: ?>
                                <div class="no-cover">📚</div>
                            <?php endif; ?>
                        </div>
                        <div class="lesson-info">
                            <div class="lesson-title"><?php echo htmlspecialchars($lesson['title']); ?></div>
                            <div class="lesson-description"><?php echo htmlspecialchars($lesson['description']); ?></div>
                            <a href="read.php?subject=<?php echo urlencode($subject); ?>&lesson=<?php echo $lesson['id']; ?>" class="read-button">Read Lesson</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No lessons available for this subject and level yet.</p>
        <?php endif; ?>
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
        const burger = document.getElementById('burger');
        const navMenu = document.getElementById('nav-menu');

        burger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    </script>
</body>
</html>