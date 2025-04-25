<?php
session_start();
include 'php_functions/db_connection.php';
include 'php_functions/performance_analyzer.php';
include 'php_functions/recommendation_engine.php';
include 'php_functions/kmeans.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$userEmail = $_SESSION['email'];
$isLoggedIn = true;

// Get user data
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$userEmail]);
    $user = $stmt->fetch();

    if (!$user) {
        header('Location: logout.php');
        exit;
    }

    // Get performance metrics
    $performance = getUserPerformanceMetrics($pdo, $userEmail);

    // Run clustering if needed (periodically)
    $shouldCluster = false;

    $lastClusterStmt = $pdo->prepare("
        SELECT last_updated FROM user_clusters 
        WHERE user_email = ? 
        ORDER BY last_updated DESC 
        LIMIT 1
    ");
    $lastClusterStmt->execute([$userEmail]);
    $lastCluster = $lastClusterStmt->fetch();

    if (!$lastCluster) {
        $shouldCluster = true;
    } else {
        $lastUpdate = strtotime($lastCluster['last_updated']);
        $now = time();
        $daysSinceUpdate = ($now - $lastUpdate) / (60 * 60 * 24);

        if ($daysSinceUpdate > 1) { // Refresh clustering every day
            $shouldCluster = true;
        }
    }

    if ($shouldCluster) {
        // Run clustering in background (would be better with a job queue in production)
        clusterUsers($pdo);
    }

    // Generate recommendations
    $recommendations = generateUserRecommendations($pdo, $userEmail, 6);
    saveUserRecommendations($pdo, $userEmail, $recommendations);

    // Get recent quiz attempts
    $quizStmt = $pdo->prepare("
        SELECT * FROM quiz_attempts 
        WHERE user_email = ? 
        ORDER BY date_completed DESC 
        LIMIT 5
    ");
    $quizStmt->execute([$userEmail]);
    $recentQuizzes = $quizStmt->fetchAll();

} catch (PDOException $e) {
    error_log("Dashboard error: " . $e->getMessage());
    $error = "An error occurred loading your dashboard. Please try again later.";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lumin Learning</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<style>.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item.clickable {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
    padding-right: 2.5rem;
}

.activity-item.clickable:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.activity-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #ff8800;
    opacity: 0;
    transition: opacity 0.2s;
}

.activity-item.clickable:hover .activity-arrow {
    opacity: 1;
}

.full-width {
    grid-column: 1 / -1;
}

.see-all-link {
    display: block;
    text-align: right;
    margin-top: 1rem;
    color: #ff8800;
    text-decoration: none;
    font-weight: 500;
}

.see-all-link:hover {
    text-decoration: underline;
}</style>
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
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="dashboard-container">
            <div class="welcome-section">
                <div class="user-info">
                    <h1>Welcome back, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>
                    <p>Let's continue your learning journey.</p>
                </div>
                <div class="mascot">
                    <img src="photos/owl1.png" alt="Lumin Owl">
                </div>
            </div>

            <div class="dashboard-grid">
                <!-- Left Column -->
                <div class="dashboard-column">
                    <div class="dashboard-card performance-card">
                        <h2><i class="fas fa-chart-line"></i> Your Performance</h2>

                        <div class="performance-stats">
                            <div class="stat-item">
                                <div class="stat-value"><?php echo $performance['total_quizzes']; ?></div>
                                <div class="stat-label">Quizzes Taken</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo $performance['overall_avg_score']; ?>%</div>
                                <div class="stat-label">Average Score</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value"><?php echo count($performance['subjects']); ?></div>
                                <div class="stat-label">Subjects</div>
                            </div>
                        </div>

                        <div class="subject-performance">
                            <h3>Subject Performance</h3>

                            <?php if (empty($performance['subjects'])): ?>
                                <p class="empty-state">Complete quizzes to see your performance by subject.</p>
                            <?php else: ?>
                                <?php foreach($performance['subjects'] as $subject => $data): ?>
                                <div class="subject-progress">
                                    <div class="subject-label"><?php echo htmlspecialchars($subject); ?></div>
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: <?php echo $data['avg_score']; ?>%"></div>
                                    </div>
                                    <div class="progress-value"><?php echo $data['avg_score']; ?>%</div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="dashboard-card recent-activity">
                        <h2><i class="fas fa-history"></i> Recent Activity</h2>

                        <?php if (empty($recentQuizzes)): ?>
                            <p class="empty-state">You haven't completed any quizzes yet. Start learning!</p>
                        <?php else: ?>
                            <div class="activity-list">
                                <?php foreach($recentQuizzes as $quiz): ?>
                                            <div class="activity-item" onclick="window.location.href='<?php echo $quiz['source'] === 'video' ? 'video.php?id=' : 'read.php?lesson='; ?><?php echo $quiz['content_id']; ?>'">
                                     
                                        <div class="activity-icon">
                                            <i class="<?php echo $quiz['source'] === 'reading' ? 'fas fa-book' : 'fas fa-video'; ?>"></i>
                                        </div>
                                        <div class="activity-details">
                                            <div class="activity-title"><?php echo htmlspecialchars($quiz['subject']); ?> Quiz</div>
                                            <div class="activity-meta">
                                                <span class="score"><?php echo $quiz['score']; ?>/<?php echo $quiz['total_questions']; ?> points</span>
                                                <span class="date"><?php echo date('M j, Y', strtotime($quiz['date_completed'])); ?></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                <?php endforeach; ?>
                            </div>
                           <?php endif; ?>
                           <div>
                            <a href="quiz_history.php" class="see-all-link">See all activities <i class="fas fa-arrow-right"></i></a>
                            </div>
                    </div>
                </div>
          
                <!-- Right Column -->
                <div class="dashboard-column">
                    <div class="dashboard-card recommendations">
                        <h2><i class="fas fa-lightbulb"></i> Personalized Recommendations</h2>
                        <p class="recommendation-info">Based on your learning style and performance</p>

                        <?php if (empty($recommendations)): ?>
                            <p class="empty-state">Complete more quizzes to get personalized recommendations.</p>
                        <?php else: ?>
                            <div class="recommendation-list">
                                <?php foreach($recommendations as $rec): ?>
                                    <div class="recommendation-item">
                                        <div class="rec-icon">
                                            <i class="<?php echo $rec['type'] === 'lesson' ? 'fas fa-book' : 'fas fa-video'; ?>"></i>
                                        </div>
                                        <div class="rec-content">
                                            <div class="rec-title"><?php echo htmlspecialchars($rec['title']); ?></div>
                                            <div class="rec-meta">
                                                <span class="subject"><?php echo htmlspecialchars($rec['subject']); ?></span>
                                                <span class="level"><?php echo htmlspecialchars($rec['level']); ?></span>
                                                <span class="learning-type <?php echo $rec['type']; ?>"><?php echo $rec['type'] === 'lesson' ? 'Reading' : 'Video'; ?></span>
                                            </div>
                                            <p class="rec-desc"><?php echo htmlspecialchars($rec['description']); ?></p>
                                            <?php if ($rec['type'] === 'lesson'): ?>
                                                <a href="read.php?subject=<?php echo urlencode($rec['subject']); ?>&lesson=<?php echo $rec['id']; ?>" class="rec-button">Read Now</a>
                                            <?php else: ?>
                                                <a href="video.php?id=<?php echo $rec['id']; ?>" class="rec-button">Watch Now</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="dashboard-card learning-insights">
                        <h2><i class="fas fa-brain"></i> Learning Insights</h2>

                        <?php if ($performance['total_quizzes'] < 3): ?>
                            <p class="empty-state">Complete at least 3 quizzes to unlock your learning insights.</p>
                        <?php else: ?>
                            <div class="insight-item">
                                <h3>Learning Style</h3>
                                <p>You seem to prefer <strong><?php echo isset($styleCount) && $styleCount['reading'] > $styleCount['video'] ? 'reading' : 'video'; ?> lessons</strong>. We'll prioritize this format in your recommendations.</p>
                            </div>

                            <div class="insight-item">
                                <h3>Strengths</h3>
                                <p>
                                    <?php 
                                    $strengths = [];
                                    foreach($performance['subjects'] as $subject => $data) {
                                        if ($data['avg_score'] >= 70) {
                                            $strengths[] = $subject;
                                        }
                                    }

                                    if (empty($strengths)) {
                                        echo "Keep practicing to develop your strengths!";
                                    } else {
                                        echo "You're doing well in: <strong>" . implode(", ", $strengths) . "</strong>";
                                    }
                                    ?>
                                </p>
                            </div>

                            <div class="insight-item">
                                <h3>Areas for Improvement</h3>
                                <p>
                                    <?php 
                                    $weaknesses = [];
                                    foreach($performance['subjects'] as $subject => $data) {
                                        if ($data['avg_score'] < 70) {
                                            $weaknesses[] = $subject;
                                        }
                                    }

                                    if (empty($weaknesses)) {
                                        echo "Great job! You're performing well across all subjects.";
                                    } else {
                                        echo "Focus more on: <strong>" . implode(", ", $weaknesses) . "</strong>";
                                    }
                                    ?>
                                </p>
                            </div>
                        <?php endif; ?>
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

    <script src="js/dashboard.js"></script>
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