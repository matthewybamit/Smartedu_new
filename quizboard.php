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
    // First check if we can get recommendations from cluster-based approach
    if (!empty($userEmail)) {
        // Try to get user's cluster
        $clusterStmt = $pdo->prepare("
            SELECT cluster_id FROM user_clusters 
            WHERE user_email = ? 
            ORDER BY last_updated DESC 
            LIMIT 1
        ");
        $clusterStmt->execute([$userEmail]);
        $cluster = $clusterStmt->fetch();
        
        if ($cluster) {
            $clusterId = $cluster['cluster_id'];
            
            // Get performance stats to determine learning style preference
            $styleStmt = $pdo->prepare("
                SELECT learning_style, SUM(quizzes_taken) as count 
                FROM user_performance 
                WHERE user_email = ? 
                GROUP BY learning_style
                ORDER BY count DESC
            ");
            $styleStmt->execute([$userEmail]);
            $preferredStyle = null;
            
            if ($row = $styleStmt->fetch()) {
                $preferredStyle = $row['learning_style'];
            }
            
            // Get users in the same cluster
            $clusterUsersStmt = $pdo->prepare("
                SELECT user_email 
                FROM user_clusters 
                WHERE cluster_id = ? AND user_email != ? 
                LIMIT 10
            ");
            $clusterUsersStmt->execute([$clusterId, $userEmail]);
            $clusterUsers = $clusterUsersStmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (!empty($clusterUsers)) {
                // Find successful content among cluster users
                $placeholders = implode(',', array_fill(0, count($clusterUsers), '?'));
                $params = $clusterUsers;
                $params[] = 0.7; // 70% score threshold
                
                $popularContentStmt = $pdo->prepare("
                    SELECT qa.subject, qa.source, qa.quiz_id 
                    FROM quiz_attempts qa 
                    WHERE qa.user_email IN ({$placeholders}) 
                    AND (qa.score / qa.total_questions) > ?
                    GROUP BY qa.subject, qa.source, qa.quiz_id
                    ORDER BY COUNT(*) DESC
                    LIMIT 4
                ");
                $popularContentStmt->execute($params);
                
                while ($content = $popularContentStmt->fetch()) {
                    if ($content['source'] === 'video') {
                        // Get video details
                        $detailStmt = $pdo->prepare("
                            SELECT v.id, v.title, v.description, v.level
                            FROM video_lessons v
                            JOIN video_quizzes q ON v.id = q.video_id
                            WHERE q.id = ? AND v.subject = ?
                        ");
                        $detailStmt->execute([$content['quiz_id'], $content['subject']]);
                        
                        if ($detail = $detailStmt->fetch()) {
                            $recommendations[] = [
                                'id' => $detail['id'],
                                'title' => $detail['title'],
                                'desc' => substr($detail['description'], 0, 50) . '...',
                                'type' => 'video',
                                'source' => 'video',
                                'subject' => $content['subject'],
                                'level' => $detail['level']
                            ];
                        }
                    } else {
                        // Get lesson details
                        $detailStmt = $pdo->prepare("
                            SELECT l.id, l.title, l.description, l.level
                            FROM lessons l
                            JOIN quizzes q ON l.id = q.lesson_id
                            WHERE q.id = ? AND l.subject = ?
                        ");
                        $detailStmt->execute([$content['quiz_id'], $content['subject']]);
                        
                        if ($detail = $detailStmt->fetch()) {
                            $recommendations[] = [
                                'id' => $detail['id'],
                                'title' => $detail['title'],
                                'desc' => substr($detail['description'], 0, 50) . '...',
                                'type' => 'lesson',
                                'source' => 'reading',
                                'subject' => $content['subject'],
                                'level' => $detail['level']
                            ];
                        }
                    }
                }
            }
        }
    }
    
    // If we don't have enough recommendations from clustering, supplement with standard ones
    if (count($recommendations) < 4) {
        // Get a mix of lessons and videos based on the subject
        $limit = max(1, (4 - count($recommendations)) / 2);
        
        // First, get relevant lessons
        $lessonStmt = $pdo->prepare("
            SELECT id, title, description, 'lesson' as type, level
            FROM lessons 
            WHERE subject = :subject 
            ORDER BY RAND() 
            LIMIT :limit
        ");
        $lessonStmt->bindParam(':subject', $subject);
        $lessonStmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $lessonStmt->execute();
        
        while ($row = $lessonStmt->fetch(PDO::FETCH_ASSOC)) {
            $recommendations[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'desc' => substr($row['description'], 0, 50) . '...',
                'type' => 'lesson',
                'source' => 'reading',
                'subject' => $subject,
                'level' => $row['level']
            ];
        }
        
        // Then, get relevant videos
        $videoStmt = $pdo->prepare("
            SELECT id, title, description, 'video' as type, level
            FROM video_lessons 
            WHERE subject = :subject 
            ORDER BY RAND() 
            LIMIT :limit
        ");
        $videoStmt->bindParam(':subject', $subject);
        $videoStmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $videoStmt->execute();
        
        while ($row = $videoStmt->fetch(PDO::FETCH_ASSOC)) {
            $recommendations[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'desc' => substr($row['description'], 0, 50) . '...',
                'type' => 'video',
                'source' => 'video',
                'subject' => $subject,
                'level' => $row['level']
            ];
        }
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

// Get personalized strengths, weak areas, and cluster info based on our clustering analysis
$strengths = [];
$weakAreas = [];
$suggestedFocus = "";
$challengingQuestions = "";
$clusterInfo = null;

try {
    // First check if user is part of a cluster
    if (!empty($userEmail)) {
        // Try to get user's cluster
        $clusterStmt = $pdo->prepare("
            SELECT uc.cluster_id, 
                  COUNT(DISTINCT other_uc.user_email) as cluster_size
            FROM user_clusters uc
            LEFT JOIN user_clusters other_uc ON uc.cluster_id = other_uc.cluster_id
            WHERE uc.user_email = ?
            GROUP BY uc.cluster_id
            ORDER BY uc.last_updated DESC
            LIMIT 1
        ");
        $clusterStmt->execute([$userEmail]);
        $userClusterInfo = $clusterStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($userClusterInfo) {
            $clusterId = $userClusterInfo['cluster_id'];
            $clusterSize = $userClusterInfo['cluster_size'];
            
            // Get cluster learning characteristics
            $clusterCharacteristicsStmt = $pdo->prepare("
                SELECT up.learning_style, 
                      AVG(up.avg_score) as avg_cluster_score,
                      COUNT(*) as style_count
                FROM user_clusters uc
                JOIN user_performance up ON uc.user_email = up.user_email
                WHERE uc.cluster_id = ?
                GROUP BY up.learning_style
                ORDER BY style_count DESC
            ");
            $clusterCharacteristicsStmt->execute([$clusterId]);
            
            $clusterStyles = [];
            $clusterDominantStyle = null;
            $clusterAvgScore = 0;
            
            while ($characteristic = $clusterCharacteristicsStmt->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($characteristic['learning_style'])) {
                    $clusterStyles[$characteristic['learning_style']] = [
                        'count' => $characteristic['style_count'],
                        'avg_score' => $characteristic['avg_cluster_score']
                    ];
                    
                    if ($clusterDominantStyle === null || 
                        $characteristic['style_count'] > $clusterStyles[$clusterDominantStyle]['count']) {
                        $clusterDominantStyle = $characteristic['learning_style'];
                    }
                    
                    $clusterAvgScore += $characteristic['avg_cluster_score'] * $characteristic['style_count'];
                }
            }
            
            // Calculate average score for the cluster
            $totalStyles = array_sum(array_column($clusterStyles, 'count'));
            if ($totalStyles > 0) {
                $clusterAvgScore = $clusterAvgScore / $totalStyles;
            }
            
            // Store cluster information for display
            $clusterInfo = [
                'id' => $clusterId,
                'size' => $clusterSize,
                'dominant_style' => $clusterDominantStyle,
                'avg_score' => round($clusterAvgScore, 1),
                'styles' => $clusterStyles
            ];
        }
    }
    
    // Get user's performance data including quiz attempts
    $perfQuery = $pdo->prepare("
        SELECT up.subject, up.avg_score, qa.incorrect_questions
        FROM user_performance up
        LEFT JOIN quiz_attempts qa ON qa.user_email = up.user_email 
        AND qa.subject = up.subject
        WHERE up.user_email = :email
        ORDER BY qa.date_completed DESC, up.avg_score DESC
    ");
    $perfQuery->bindParam(':email', $userEmail);
    $perfQuery->execute();

    $highPerformanceSubjects = [];
    $lowPerformanceSubjects = [];
    $processedSubjects = [];
    while ($perf = $perfQuery->fetch(PDO::FETCH_ASSOC)) {
        // Only process each subject once
        if (!in_array($perf['subject'], $processedSubjects)) {
            if ($perf['avg_score'] >= 70) {
                $highPerformanceSubjects[] = $perf['subject'];
            } else {
                $lowPerformanceSubjects[] = $perf['subject'];
            }
            $processedSubjects[] = $perf['subject'];
        }

        // Get challenging questions from the most recent attempt
        if (!empty($perf['incorrect_questions']) && empty($challengingQuestions)) {
            $challengingQuestions = $perf['incorrect_questions'];
        }
    }

    // If no challenging questions found, get them from the latest quiz attempt
    if (empty($challengingQuestions)) {
        $latestQuizStmt = $pdo->prepare("
            SELECT incorrect_questions 
            FROM quiz_attempts 
            WHERE user_email = :email 
            AND subject = :subject
            ORDER BY date_completed DESC 
            LIMIT 1
        ");
        $latestQuizStmt->execute([
            ':email' => $userEmail,
            ':subject' => $subject
        ]);
        if ($latestQuiz = $latestQuizStmt->fetch()) {
            $challengingQuestions = $latestQuiz['incorrect_questions'];
        }
    }

    // Get learning style preference

    // Simple logic for strengths and weaknesses (replace with more sophisticated logic if needed)
    $strengths = $highPerformanceSubjects;
    $weakAreas = $lowPerformanceSubjects;
    if (empty($strengths)) {
        $strengths = ["General Knowledge"];
    }
    if (empty($weakAreas)) {
        $weakAreas = ["Specific Details", "Concept Application"];
    }
    $suggestedFocus = "Review fundamental concepts and study each topic more thoroughly";


} catch (PDOException $e) {
    error_log("Database error fetching performance data: " . $e->getMessage());
}

// If still no challenging questions found, create a meaningful message
if (empty($challengingQuestions)) {
    $challengingQuestions = "Complete more quizzes to identify challenging areas";
}

// Format strengths and weak areas for display
$strengthsText = implode(", ", $strengths);
$weakAreasText = implode(", ", $weakAreas);


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
    <link rel="stylesheet" href="css/recommendation_cards.css">
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

    <section class="recommendations-section">
        <h2 class="recommend-title">Personalized Recommendations</h2>
        <p>Based on your performance and learning style</p>
        
        <?php if (isset($clusterInfo)): ?>
        <div class="cluster-analytics">
            <div class="cluster-badge">
                <span class="cluster-label">Learning Profile Group</span>
                <span class="cluster-id"><?php echo $clusterInfo['id'] ?? 'N/A'; ?></span>
            </div>
            <div class="cluster-stats">
                <div class="cluster-stat">
                    <span class="stat-label">Group Size</span>
                    <span class="stat-value"><?php echo isset($clusterInfo['size']) ? $clusterInfo['size'] . ' learner' . ($clusterInfo['size'] != 1 ? 's' : '') : 'N/A'; ?></span>
                </div>
                <div class="cluster-stat">
                    <span class="stat-label">Avg. Score</span>
                    <span class="stat-value"><?php echo isset($clusterInfo['avg_score']) ? $clusterInfo['avg_score'] . '%' : 'N/A'; ?></span>
                </div>
                <div class="cluster-stat">
                    <span class="stat-label">Primary Learning Style</span>
                    <span class="stat-value"><?php echo isset($clusterInfo['dominant_style']) ? ucfirst($clusterInfo['dominant_style']) : 'Mixed'; ?></span>
                </div>
            </div>
            <p class="cluster-insight">Based on K-means clustering analysis, you have been matched with learners who have similar learning patterns and preferences.</p>
        </div>
        <?php endif; ?>
        
        <div class="recommendations">
            <?php foreach ($recommendations as $rec): ?>
            <div class="card <?php echo isset($rec['type']) ? $rec['type'] : ''; ?>">
                <div class="star"><i class="<?php echo isset($rec['type']) && $rec['type'] === 'video' ? 'fas fa-video' : 'fas fa-book'; ?>"></i></div>
                <h3><?php echo htmlspecialchars($rec['title']); ?></h3>
                
                <?php if (isset($rec['subject']) || isset($rec['level'])): ?>
                <div class="rec-meta">
                    <?php if (isset($rec['subject'])): ?>
                    <span class="subject"><?php echo htmlspecialchars($rec['subject']); ?></span>
                    <?php endif; ?>
                    
                    <?php if (isset($rec['level'])): ?>
                    <span class="level"><?php echo htmlspecialchars($rec['level']); ?></span>
                    <?php endif; ?>
                    
                    <span class="type"><?php echo isset($rec['type']) && $rec['type'] === 'video' ? 'Video' : 'Reading'; ?></span>
                </div>
                <?php endif; ?>
                
                <p><?php echo htmlspecialchars($rec['desc']); ?></p>
                
                <?php if (isset($rec['id'])): ?>
                    <?php if (isset($rec['type']) && $rec['type'] === 'video'): ?>
                        <button class="view-btn" onclick="window.location.href='video.php?subject=<?php echo urlencode($rec['subject'] ?? $subject); ?>&video=<?php echo $rec['id']; ?>'">Watch Now</button>
                    <?php else: ?>
                        <button class="view-btn" onclick="window.location.href='read.php?subject=<?php echo urlencode($rec['subject'] ?? $subject); ?>&lesson=<?php echo $rec['id']; ?>'">Read Now</button>
                    <?php endif; ?>
                <?php else: ?>
                    <button class="view-btn" onclick="window.location.href='<?php echo isset($rec['type']) && $rec['type'] === 'video' ? 'video.php' : 'read.php'; ?>?subject=<?php echo urlencode($subject); ?>'">View Now</button>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <p class="view-more">View More Recommendations</p>
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