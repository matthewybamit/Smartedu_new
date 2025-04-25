
<?php
session_start();
include 'php_functions/db_connection.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);

if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['user_email'];

try {
    // Get all quiz attempts for the user
    $stmt = $pdo->prepare("
        SELECT qa.*, 
               CASE 
                   WHEN qa.source = 'video' THEN vl.title 
                   ELSE l.title 
               END as content_title,
               qa.source,
               qa.content_id
        FROM quiz_attempts qa
        LEFT JOIN video_lessons vl ON qa.source = 'video' AND qa.content_id = vl.id
        LEFT JOIN lessons l ON qa.source = 'reading' AND qa.content_id = l.id
        WHERE qa.user_email = :email
        ORDER BY qa.date_completed DESC
    ");
    
    $stmt->execute(['email' => $userEmail]);
    $quizHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching quiz history: " . $e->getMessage());
    $error = "An error occurred while fetching your quiz history.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz History - Lumin</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/quiz_history.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main class="quiz-history-container">
        <h1>Your Quiz History</h1>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php else: ?>
            <div class="quiz-history-list">
                <?php foreach ($quizHistory as $attempt): ?>
                    <div class="quiz-attempt-card">
                        <div class="attempt-header">
                            <div class="content-type">
                                <i class="fas <?php echo $attempt['source'] === 'video' ? 'fa-video' : 'fa-book'; ?>"></i>
                                <?php echo ucfirst($attempt['source']); ?>
                            </div>
                            <div class="attempt-date">
                                <?php echo date('F j, Y, g:i a', strtotime($attempt['date_completed'])); ?>
                            </div>
                        </div>
                        
                        <div class="attempt-content">
                            <h3><?php echo htmlspecialchars($attempt['content_title']); ?></h3>
                            <div class="attempt-details">
                                <div class="subject"><?php echo htmlspecialchars($attempt['subject']); ?></div>
                                <div class="score">
                                    Score: <?php echo $attempt['score']; ?>/<?php echo $attempt['total_questions']; ?>
                                    (<?php echo round(($attempt['score'] / $attempt['total_questions']) * 100); ?>%)
                                </div>
                            </div>
                        </div>
                        
                        <div class="attempt-actions">
                            <?php if ($attempt['source'] === 'video'): ?>
                                <a href="video.php?id=<?php echo $attempt['content_id']; ?>" class="review-btn">
                                    Review Video
                                </a>
                            <?php else: ?>
                                <a href="read.php?subject=<?php echo urlencode($attempt['subject']); ?>&lesson=<?php echo $attempt['content_id']; ?>" class="review-btn">
                                    Review Lesson
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

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
