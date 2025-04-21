<?php
session_start();
include 'php_functions/db_connection.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);

// If user is not logged in, redirect to login page
if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

// Get score and total from URL parameters (if available)
$score = isset($_GET['score']) ? intval($_GET['score']) : 0;
$total = isset($_GET['total']) ? intval($_GET['total']) : 5;
$source = isset($_GET['source']) ? $_GET['source'] : 'unknown';
$subject = isset($_GET['subject']) ? $_GET['subject'] : 'General Knowledge';
$contentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if we have user's email in session
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '');

// Fetch user's quiz history
$userQuizzes = [];
if (!empty($userEmail)) {
    try {
        // This assumes you have a quiz_attempts table in your database
        // If not, we'll continue with URL parameter data
        $stmt = $pdo->prepare("
            SELECT * FROM quiz_attempts 
            WHERE user_email = :email 
            ORDER BY date_completed DESC 
            LIMIT 1
        ");
        $stmt->bindParam(':email', $userEmail);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $latestQuiz = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Update the current quiz data with the latest attempt
            $score = $latestQuiz['score'];
            $total = $latestQuiz['total_questions'];
            $subject = $latestQuiz['subject'];
            
            // If we have a valid quiz_id, try to get more details
            if (!empty($latestQuiz['quiz_id'])) {
                // Get quiz details based on the source (video or reading)
                if ($latestQuiz['source'] === 'video') {
                    $quizQuery = $pdo->prepare("
                        SELECT vq.*, vl.title AS subject_title, vl.subject 
                        FROM video_quizzes vq
                        JOIN video_lessons vl ON vq.video_id = vl.id 
                        WHERE vq.id = :quiz_id
                    ");
                } else {
                    $quizQuery = $pdo->prepare("
                        SELECT q.*, l.title AS subject_title, l.subject 
                        FROM quizzes q
                        JOIN lessons l ON q.lesson_id = l.id 
                        WHERE q.id = :quiz_id
                    ");
                }
                
                $quizQuery->bindParam(':quiz_id', $latestQuiz['quiz_id']);
                $quizQuery->execute();
                
                if ($quizQuery->rowCount() > 0) {
                    $quizDetails = $quizQuery->fetch(PDO::FETCH_ASSOC);
                    $subject = $quizDetails['subject'] ?: $subject;
                }
            }
        }
    } catch (PDOException $e) {
        error_log("Database error fetching quiz attempts: " . $e->getMessage());
    }
}

// Calculate percentage
$percentage = ($total > 0) ? round(($score / $total) * 100) : 0;

// Determine badge based on score percentage
$badgeImage = "photos/star-fill.png"; // Default
$badgeText = "Participant";

if ($percentage >= 90) {
    $badgeImage = "photos/goldmedal.png";
    $badgeText = "Gold Medal";
} else if ($percentage >= 70) {
    $badgeImage = "photos/goldmedal.png"; // Use silver medal image if available
    $badgeText = "Silver Medal";
} else if ($percentage >= 50) {
    $badgeImage = "photos/goldmedal.png"; // Use bronze medal image if available
    $badgeText = "Bronze Medal";
}

// Performance assessment
$performanceLevel = "Needs Improvement";
if ($percentage >= 90) {
    $performanceLevel = "Excellent";
} else if ($percentage >= 70) {
    $performanceLevel = "Good";
} else if ($percentage >= 50) {
    $performanceLevel = "Average";
}

// Try to get personalized recommendations from the database
$recommendations = [];
try {
    // This would ideally be based on user's learning history, 
    // but for simplicity we'll just get content by subject
    $stmt = $pdo->prepare("
        SELECT id, title, description 
        FROM lessons 
        WHERE subject = :subject 
        ORDER BY RAND() 
        LIMIT 4
    ");
    $stmt->bindParam(':subject', $subject);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $recommendations[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'desc' => substr($row['description'], 0, 50) . '...'
        ];
    }
} catch (PDOException $e) {
    error_log("Database error fetching recommendations: " . $e->getMessage());
}

// If we couldn't get recommendations from DB, use the default ones
if (empty($recommendations)) {
    switch (strtolower($subject)) {
        case 'english':
            $recommendations = [
                ['title' => 'Vocabulary Builder', 'desc' => 'Enhance your word power'],
                ['title' => 'Grammar Master', 'desc' => 'Perfect your writing skills'],
                ['title' => 'Reading Comprehension', 'desc' => 'Improve understanding and analysis'],
                ['title' => 'Creative Writing', 'desc' => 'Express yourself better']
            ];
            break;
        case 'mathematics':
            $recommendations = [
                ['title' => 'Algebra Fundamentals', 'desc' => 'Master core concepts'],
                ['title' => 'Geometry Essentials', 'desc' => 'Understand shapes and space'],
                ['title' => 'Calculus Prep', 'desc' => 'Prepare for advanced math'],
                ['title' => 'Problem Solving', 'desc' => 'Enhance logical thinking']
            ];
            break;
        case 'history':
            $recommendations = [
                ['title' => 'Ancient Civilizations', 'desc' => 'Explore the ancient world'],
                ['title' => 'Modern History', 'desc' => 'Understand recent events'],
                ['title' => 'World Wars', 'desc' => 'Study global conflicts'],
                ['title' => 'Cultural History', 'desc' => 'Learn about diverse traditions']
            ];
            break;
        case 'science':
            $recommendations = [
                ['title' => 'Biology Basics', 'desc' => 'Explore living systems'],
                ['title' => 'Chemistry Fundamentals', 'desc' => 'Understand matter and reactions'],
                ['title' => 'Physics Concepts', 'desc' => 'Learn about forces and energy'],
                ['title' => 'Earth Science', 'desc' => 'Discover our planet']
            ];
            break;
        default:
            $recommendations = [
                ['title' => 'Core Concepts', 'desc' => 'Strengthen your foundation'],
                ['title' => 'Advanced Topics', 'desc' => 'Challenge yourself further'],
                ['title' => 'Practical Applications', 'desc' => 'See real-world connections'],
                ['title' => 'Study Techniques', 'desc' => 'Improve learning efficiency']
            ];
    }
}

// Determine strengths and weak areas based on score
$strengths = [];
$weakAreas = [];
$suggestedFocus = "";

if ($subject === 'English') {
    if ($percentage >= 70) {
        $strengths = ["Vocabulary", "Reading Comprehension"];
        $weakAreas = ["Grammar", "Writing"];
        $suggestedFocus = "Practice grammar exercises and writing short essays";
    } else {
        $strengths = ["Basic Communication"];
        $weakAreas = ["Vocabulary", "Grammar", "Comprehension"];
        $suggestedFocus = "Work on expanding vocabulary and understanding sentence structure";
    }
} else if ($subject === 'Mathematics') {
    if ($percentage >= 70) {
        $strengths = ["Calculations", "Basic Formulas"];
        $weakAreas = ["Word Problems", "Advanced Concepts"];
        $suggestedFocus = "Practice more complex word problems and applications";
    } else {
        $strengths = ["Simple Arithmetic"];
        $weakAreas = ["Algebra", "Geometry", "Problem-Solving"];
        $suggestedFocus = "Review foundational math concepts and problem-solving strategies";
    }
} else {
    if ($percentage >= 70) {
        $strengths = ["Core Concepts", "Basic Principles"];
        $weakAreas = ["Advanced Applications", "Complex Topics"];
        $suggestedFocus = "Tackle more challenging topics and practical applications";
    } else {
        $strengths = ["General Knowledge"];
        $weakAreas = ["Specific Details", "Concept Application"];
        $suggestedFocus = "Review fundamental concepts and study each topic more thoroughly";
    }
}

// Format strengths and weak areas for display
$strengthsText = implode(", ", $strengths);
$weakAreasText = implode(", ", $weakAreas);

// Generate challenging questions (in a real implementation, this would come from actual question data)
$challengingQuestions = "Q" . rand(1, 5) . ", Q" . rand(6, 10) . ", Q" . rand(11, 15);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - Lumin</title>
    <link rel="stylesheet" href="css/quizboard.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
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
    <div class="quiz-card"></div>
    <div class="module">
        <a href="<?php echo $source === 'video' ? 'styles.php' : 'MODULES.php'; ?>">
            <span class="pointer">←</span> Back to <?php echo $source === 'video' ? 'Videos' : 'Modules'; ?>
        </a>
    </div>
    <div class="quiz-header">
        <h1>QUIZ INSIGHT BOARD</h1>
        <div class="congrats-section">
            <h2>CONGRATS!</h2>
            <p>You Just Completed</p>
            <p><?php echo htmlspecialchars($subject); ?> Quiz</p>
        </div>
    
    <div class="quiz-badge">
        <img src="<?php echo $badgeImage; ?>" alt="<?php echo $badgeText; ?>" class="badge-image">
    </div>
    <div class="quiz-stats">
        <div class="stat">
            <h2><?php echo $percentage; ?>%</h2>
            <p>SCORE</p>
        </div>
        <div class="stat">
            <h2><?php echo $score; ?>/<?php echo $total; ?></h2>
            <p>CORRECT</p>
        </div>
        <div class="stat">
            <h2><?php echo $performanceLevel; ?></h2>
            <p>LEVEL</p>
        </div>
    </div>
    <table>
        <tr>
            <th>TOP STRENGTHS</th>
            <th>CHALLENGING QUESTIONS</th>
            <th>WEAK AREAS</th>
            <th>SUGGESTED FOCUS</th>
        </tr>
        <tr>
            <td><?php echo $strengthsText; ?></td>
            <td><?php echo $challengingQuestions; ?></td>
            <td><?php echo $weakAreasText; ?></td>
            <td><?php echo $suggestedFocus; ?></td>
        </tr>
    </table>

    <section class="recommendations-container">
        <h2 class="recommend-title">Recommendations</h2>
        
        <div class="recommendations">
            <?php foreach ($recommendations as $rec): ?>
            <div class="card">
                <div class="star"><i class="fas fa-star"></i></div>
                <h3><?php echo htmlspecialchars($rec['title']); ?></h3>
                <p><?php echo htmlspecialchars($rec['desc']); ?></p>
                <button class="view-btn" <?php if (isset($rec['id'])): ?>onclick="window.location.href='read.php?subject=<?php echo urlencode($subject); ?>&lesson=<?php echo $rec['id']; ?>'"<?php endif; ?>>View</button>
            </div>
            <?php endforeach; ?>
        </div>

        <p class="view-more">View More</p>
    </section>

    <div class="action-buttons">
        <button class="continue-btn" onclick="window.location.href='<?php echo $source === 'video' ? 'styles.php' : 'MODULES.php'; ?>'">Continue Learning</button>
        <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
    </div>
</div>


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