
<?php
session_start();
include 'php_functions/db_connection.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);

// Get the lesson ID from URL
// Get the lesson ID from URL
$lessonId = $_GET['lesson'] ?? null;
$subject = $_GET['subject'] ?? null;

// Get specific lesson from database
$lesson = null;
try {
    if ($lessonId) {
        $query = $pdo->prepare("SELECT * FROM lessons WHERE id = ?");
        $query->execute([$lessonId]);
        $lesson = $query->fetch(PDO::FETCH_ASSOC);

        if ($lesson) {
            // Increment view count
            require_once 'php_functions/track_views.php';
            incrementViews($lessonId, 'reading');
        }
    }
} catch (PDOException $e) {
    error_log("Error fetching lesson: " . $e->getMessage());
}

try {
    $query = $pdo->prepare("SELECT * FROM lessons WHERE id = :id");
    $query->bindParam(':id', $lessonId);
    $query->execute();
    $lesson = $query->fetch(PDO::FETCH_ASSOC);

    if ($lesson) {
        // Increment view count
        require_once 'php_functions/track_views.php';
        incrementViews($lessonId, 'reading');
    } 

    // Get related lessons from the same subject (excluding current lesson)
    $relatedQuery = $pdo->prepare("
        SELECT * FROM lessons 
        WHERE subject = :subject AND id != :current_id 
        ORDER BY RAND() 
        LIMIT 3
    ");
    $relatedQuery->bindParam(':subject', $lesson['subject']);
    $relatedQuery->bindParam(':current_id', $lessonId);
    $relatedQuery->execute();
    $relatedLessons = $relatedQuery->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching lesson: " . $e->getMessage());
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
    <style>
        .related-lessons {
            margin-top: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .related-lessons h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .related-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .related-card:hover {
            transform: translateY(-5px);
        }
        .related-title {
            font-weight: 600;
            margin-bottom: 10px;
        }
        .related-link {
            display: inline-block;
            margin-top: 10px;
            color: #ff8800;
            text-decoration: none;
        }
        .related-link:hover {
            text-decoration: underline;
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

<main>
    <div class="background">
        <div class="readFrame">
            <!-- Lessons Sidebar -->
            <div class="chapters">
                <h1>Lessons</h1>
                <div class="scroll-chapters">
                    <div id="lessons-grid" class="grid-grid">
                        <?php if (!empty($lesson)): ?>
                            <div class="chapter lesson-item active" data-id="<?php echo $lesson['id']; ?>" data-index="0">
                          
                                <h3><?php echo htmlspecialchars($lesson['title']); ?></h3>
                            </div>
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
                 
                    <h1><?php echo !empty($lesson) ? htmlspecialchars($lesson['title']) : 'No Lesson Selected'; ?></h1>
                    <p></p>
                </div>

                <!-- Lesson Description -->
                <div id="lesson-description" class="content">
                    <p><?php echo !empty($lesson) ? htmlspecialchars($lesson['description']) : 'Select a lesson to view its content.'; ?></p>
                </div>

                <!-- Related Lessons Section -->
                <?php if (!empty($relatedLessons)): ?>
                <div class="related-lessons">
                    <h2>Related Lessons in <?php echo htmlspecialchars($lesson['subject']); ?></h2>
                    <div class="related-grid">
                        <?php foreach ($relatedLessons as $related): ?>
                        <div class="related-card">
                            <div class="related-title"><?php echo htmlspecialchars($related['title']); ?></div>
                            <p><?php echo htmlspecialchars(substr($related['description'], 0, 100)) . '...'; ?></p>
                            <a href="read.php?subject=<?php echo urlencode($related['subject']); ?>&lesson=<?php echo $related['id']; ?>" class="related-link">Read this lesson →</a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
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

    // Get the lesson from the server-side PHP
    const lesson = <?php echo json_encode($lesson ?: null); ?>;

    // Current lesson tracking
    let currentLessonId = lesson ? lesson.id : null;

    // Function to display a lesson's content
    function displayLessonContent(lesson) {
        const lessonTitle = document.getElementById('lesson-title');
        const lessonDescription = document.getElementById('lesson-description');

        // Update title section
        lessonTitle.querySelector('h2').textContent = "01";
        lessonTitle.querySelector('h1').textContent = lesson.title;

        // Update content
        lessonDescription.querySelector('p').textContent = lesson.description;
    }

    // Handle Start Quiz button
    document.getElementById('startQuizBtn').addEventListener('click', function() {
        if (currentLessonId) {
            window.location.href = `quizone.php?source=read&subject=${encodeURIComponent('<?php echo $subject; ?>')}&lesson=${currentLessonId}&id=${currentLessonId}`;
        } else {
            alert("Please select a lesson.");
        }
    });

    // Initial display of lesson content if a lesson exists
    if (lesson) {
        displayLessonContent(lesson);
    }
</script>

</body>
</html>
