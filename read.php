<?php
session_start();
include 'php_functions/db_connection.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);

// Get the values from the URL (query string)
$subject = $_GET['subject'] ?? null;
$level = $_GET['level'] ?? null;
$style = $_GET['style'] ?? null;

// Get list of lessons directly from the database
$lessons = [];
try {
    $query = $pdo->prepare("SELECT * FROM lessons WHERE subject = :subject ORDER BY id ASC");
    $query->bindParam(':subject', $subject);
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
    <title>Lumin - Reading Module</title>
    <link rel="stylesheet" href="CSS/read.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
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


<main>
    <div class="background">
        <div class="readFrame">

            <!-- Lessons Sidebar -->
            <div class="chapters">
                <h1>Lessons</h1>
                <div class="scroll-chapters">
                    <div id="lessons-grid" class="grid-grid">
                        <?php if (!empty($lessons)): ?>
                            <?php foreach ($lessons as $index => $lesson): ?>
                                <div class="chapter lesson-item" data-id="<?php echo $lesson['id']; ?>" data-index="<?php echo $index; ?>">
                                    <h2><?php echo sprintf("%02d", $index + 1); ?></h2>
                                    <h3><?php echo htmlspecialchars($lesson['title']); ?></h3>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-lessons">
                                <p>No lessons available for this subject yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Lesson Content Area -->
            <div class="readcontent">
                <button class="start" id="startQuizBtn">Start Quiz</button>

                <!-- Title and Number -->
                <div id="lesson-title" class="scroll-read">
                    <h2>01</h2> <!-- For Lesson Number -->
                    <h1><?php echo !empty($lessons) ? htmlspecialchars($lessons[0]['title']) : 'No Lesson Selected'; ?></h1>
                    <p></p>
                </div>

                <!-- Lesson Description -->
                <div id="lesson-description" class="content">
                    <p><?php echo !empty($lessons) ? htmlspecialchars($lessons[0]['description']) : 'Select a lesson to view its content.'; ?></p>
                </div>
            </div>

        </div>
    </div>
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
    // Toggle the visibility of the menu
    const burger = document.getElementById('burger');
    const navMenu = document.getElementById('nav-menu');

    burger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });

    // Get the lessons from the server-side PHP
    const lessons = <?php echo json_encode($lessons ?: []); ?>;
    
    // Current lesson tracking
    let currentLessonId = lessons.length > 0 ? lessons[0].id : 1;
    let currentLessonIndex = 0;

    // Function to display a lesson's content
    function displayLessonContent(lesson, index) {
        const lessonTitle = document.getElementById('lesson-title');
        const lessonDescription = document.getElementById('lesson-description');

        // Use the formatted index for the number display
        const lessonNumber = String(index + 1).padStart(2, '0');
        
        // Update current lesson tracking
        currentLessonId = lesson.id;
        currentLessonIndex = index;

        // Update title section
        lessonTitle.querySelector('h2').textContent = lessonNumber;
        lessonTitle.querySelector('h1').textContent = lesson.title;

        // Update content
        lessonDescription.querySelector('p').textContent = lesson.description;
    }

    // Add click event handlers to each lesson item
    document.querySelectorAll('.lesson-item').forEach(item => {
        item.addEventListener('click', function() {
            const lessonId = parseInt(this.getAttribute('data-id'));
            const index = parseInt(this.getAttribute('data-index'));
            
            // Find the lesson in our array
            const lesson = lessons.find(l => l.id === lessonId);
            if (lesson) {
                displayLessonContent(lesson, index);
            }
            
            // Highlight the selected lesson
            document.querySelectorAll('.lesson-item').forEach(el => {
                el.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Handle Start Quiz button
    document.getElementById('startQuizBtn').addEventListener('click', function() {
        window.location.href = `quizone.php?source=read&subject=${encodeURIComponent('<?php echo $subject; ?>')}&lesson=${currentLessonId}`;
    });
</script>

</body>

</html>