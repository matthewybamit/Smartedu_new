<?php
session_start();
include 'php_functions/db_connection.php';
include 'php_functions/kmeans_clustering.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);

// Run k-means clustering if user is logged in
if ($isLoggedIn) {
    $userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['user_email'];

    // Check if clustering needs to be run
    $shouldRunClustering = false;
    try {
        $lastClusterStmt = $pdo->prepare("
            SELECT last_updated FROM user_clusters 
            WHERE user_email = ? 
            ORDER BY last_updated DESC 
            LIMIT 1
        ");
        $lastClusterStmt->execute([$userEmail]);
        $lastCluster = $lastClusterStmt->fetch();

        if (!$lastCluster) {
            $shouldRunClustering = true;
        } else {
            $lastUpdate = strtotime($lastCluster['last_updated']);
            $now = time();
            $daysSinceUpdate = ($now - $lastUpdate) / (60 * 60 * 24);

            if ($daysSinceUpdate > 1) { // Refresh clustering every day
                $shouldRunClustering = true;
            }
        }

        if ($shouldRunClustering) {
            // Run the clustering algorithm
            $success = runClustering($pdo);
            if ($success) {
                error_log("K-means clustering successfully run for user: $userEmail");
            }
        }

        // Get user's cluster information for display
        $userClusterQuery = $pdo->prepare("
            SELECT uc.cluster_id, 
                  COUNT(DISTINCT other_uc.user_email) as cluster_size
            FROM user_clusters uc
            LEFT JOIN user_clusters other_uc ON uc.cluster_id = other_uc.cluster_id
            WHERE uc.user_email = ?
            GROUP BY uc.cluster_id
            ORDER BY uc.last_updated DESC
            LIMIT 1
        ");
        $userClusterQuery->execute([$userEmail]);

        if ($userClusterResult = $userClusterQuery->fetch(PDO::FETCH_ASSOC)) {
            $clusterInfo = [
                'id' => $userClusterResult['cluster_id'],
                'size' => $userClusterResult['cluster_size']
            ];

            // Get dominant learning style in this cluster
            $clusterStyleQuery = $pdo->prepare("
                SELECT up.learning_style, COUNT(*) as count
                FROM user_clusters uc
                JOIN user_performance up ON uc.user_email = up.user_email
                WHERE uc.cluster_id = ?
                GROUP BY up.learning_style
                ORDER BY count DESC
                LIMIT 1
            ");
            $clusterStyleQuery->execute([$clusterInfo['id']]);

            if ($styleResult = $clusterStyleQuery->fetch(PDO::FETCH_ASSOC)) {
                $clusterInfo['dominant_style'] = $styleResult['learning_style'];
            }

            // Get user's performance data
            $userPerfQuery = $pdo->prepare("
                SELECT AVG(avg_score) as user_avg_score
                FROM user_performance
                WHERE user_email = ?
            ");
            $userPerfQuery->execute([$userEmail]);
            $userPerf = $userPerfQuery->fetch(PDO::FETCH_ASSOC);

            // Get cluster's average performance
            $clusterPerfQuery = $pdo->prepare("
                SELECT AVG(up.avg_score) as cluster_avg_score
                FROM user_clusters uc
                JOIN user_performance up ON uc.user_email = up.user_email
                WHERE uc.cluster_id = ?
            ");
            $clusterPerfQuery->execute([$clusterInfo['id']]);
            $clusterPerf = $clusterPerfQuery->fetch(PDO::FETCH_ASSOC);

            $clusterInfo['user_avg_score'] = round($userPerf['user_avg_score'], 1);
            $clusterInfo['cluster_avg_score'] = round($clusterPerf['cluster_avg_score'], 1);
        }
    } catch (PDOException $e) {
        error_log("Error with clustering in styles.php: " . $e->getMessage());
    }
}

// Get user's preferred subjects based on performance or history
$preferredSubjects = [];
if ($isLoggedIn) {
    try {
        // Get subjects ordered by the user's performance
        $userSubjectsQuery = $pdo->prepare("
            SELECT subject, AVG(avg_score) as avg_score, COUNT(*) as count
            FROM user_performance
            WHERE user_email = ?
            GROUP BY subject
            ORDER BY count DESC, avg_score DESC
        ");
        $userSubjectsQuery->execute([$userEmail]);

        while ($row = $userSubjectsQuery->fetch(PDO::FETCH_ASSOC)) {
            $preferredSubjects[] = $row['subject'];
        }
    } catch (PDOException $e) {
        error_log("Error fetching user's preferred subjects: " . $e->getMessage());
    }
}

// Fetch video lessons from the database
$videos = [];
try {
    if (!empty($preferredSubjects)) {
        // Prioritize videos from preferred subjects
        $placeholders = implode(',', array_fill(0, count($preferredSubjects), '?'));
        $query = $pdo->prepare("
            (SELECT * FROM video_lessons WHERE subject IN ($placeholders) ORDER BY subject, id ASC)
            UNION
            (SELECT * FROM video_lessons WHERE subject NOT IN ($placeholders) ORDER BY subject, id ASC)
        ");
        $query->execute(array_merge($preferredSubjects, $preferredSubjects));
    } else {
        // Default order if no preferences
        $query = $pdo->query("SELECT * FROM video_lessons ORDER BY subject, id ASC");
    }
    $videos = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching videos: " . $e->getMessage());
}

// Fetch regular lessons (modules) from the database
$modules = [];
try {
    if (!empty($preferredSubjects)) {
        // Prioritize modules from preferred subjects
        $placeholders = implode(',', array_fill(0, count($preferredSubjects), '?'));
        $query = $pdo->prepare("
            (SELECT * FROM lessons WHERE subject IN ($placeholders) ORDER BY subject, id ASC)
            UNION
            (SELECT * FROM lessons WHERE subject NOT IN ($placeholders) ORDER BY subject, id ASC)
        ");
        $query->execute(array_merge($preferredSubjects, $preferredSubjects));
    } else {
        // Default order if no preferences
        $query = $pdo->query("SELECT * FROM lessons ORDER BY subject, id ASC");
    }
    $modules = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching modules: " . $e->getMessage());
}

// Group videos and modules by subject for better organization
$videosBySubject = [];
foreach ($videos as $video) {
    $subject = $video['subject'];
    if (!isset($videosBySubject[$subject])) {
        $videosBySubject[$subject] = [];
    }
    $videosBySubject[$subject][] = $video;
}

$modulesBySubject = [];
foreach ($modules as $module) {
    $subject = $module['subject'];
    if (!isset($modulesBySubject[$subject])) {
        $modulesBySubject[$subject] = [];
    }
    $modulesBySubject[$subject][] = $module;
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
    <link rel="stylesheet" href="css/recommendation_cards.css">
    <script defer src="js/carouselvid.js"></script>
    <script defer src="js/videoHandler.js"></script>
    
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
    <?php if ($isLoggedIn && isset($clusterInfo)): ?>
    <div class="kmeans-banner">
        <h3>Your Learning Profile</h3>
        <div class="cluster-overview">
            <div class="cluster-detail">
                <div class="cluster-label">Learning Group</div>
                <div class="cluster-value">Group <?php echo $clusterInfo['id']; ?></div>
            </div>
            <div class="cluster-detail">
                <div class="cluster-label">Group Size</div>
                <div class="cluster-value"><?php echo $clusterInfo['size']; ?> Learners</div>
            </div>
            <div class="cluster-detail">
                <div class="cluster-label">Your Performance</div>
                <div class="cluster-value"><?php echo $clusterInfo['user_avg_score']; ?>%</div>
            </div>
            <div class="cluster-detail">
                <div class="cluster-label">Group Average</div>
                <div class="cluster-value"><?php echo $clusterInfo['cluster_avg_score']; ?>%</div>
            </div>
            <div class="cluster-detail">
                <div class="cluster-label">Preferred Style</div>
                <div class="cluster-value"><?php echo ucfirst($clusterInfo['dominant_style'] ?? 'Mixed'); ?></div>
            </div>
        </div>
        <div class="cluster-summary">
            <p>Our K-means clustering algorithm has analyzed your learning patterns and placed you in Group <?php echo $clusterInfo['id']; ?>. 
            This helps us provide personalized recommendations based on similar learners' success.</p>

            <?php
            // Compare user's score with cluster average
            $scoreDiff = $clusterInfo['user_avg_score'] - $clusterInfo['cluster_avg_score'];
            if ($scoreDiff > 5):
            ?>
                <p>You're performing above your group's average! Keep up the great work.</p>
            <?php elseif ($scoreDiff < -5): ?>
                <p>You have room to improve compared to others in your group. Check out our personalized recommendations.</p>
            <?php else: ?>
                <p>You're performing at a similar level to others in your learning group.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php
    // Get personalized recommendations based on cluster
    $recommendations = [];
    try {
        $recommendations = getClusterBasedRecommendations($pdo, $userEmail, 4);
    } catch (Exception $e) {
        error_log("Error getting recommendations: " . $e->getMessage());
    }

    if (!empty($recommendations)):
    ?>
    <div class="recommendations-section">
        <h3>Recommended For You</h3>
        <div class="recommendations-grid">
            <?php foreach ($recommendations as $rec): ?>
            <div class="recommendation-card rec-<?php echo isset($rec['source']) && $rec['source'] === 'video' ? 'video' : 'reading'; ?>">
                <div class="rec-header">
                    <div class="rec-icon">
                        <i class="<?php echo isset($rec['source']) && $rec['source'] === 'video' ? 'fas fa-video' : 'fas fa-book'; ?>"></i>
                    </div>
                    <div class="rec-title"><?php echo htmlspecialchars($rec['title']); ?></div>
                </div>
                <div class="rec-body">
                    <div class="rec-meta">
                        <span><?php echo htmlspecialchars($rec['subject']); ?></span>
                        <span><?php echo htmlspecialchars($rec['level']); ?></span>
                        <span><?php echo isset($rec['source']) && $rec['source'] === 'video' ? 'Video' : 'Reading'; ?></span>
                    </div>
                    <div class="rec-desc"><?php echo htmlspecialchars(substr($rec['description'], 0, 120) . '...'); ?></div>
                    <div class="rec-action">
                        <?php if (isset($rec['source']) && $rec['source'] === 'video'): ?>
                            <a href="video.php?subject=<?php echo urlencode($rec['subject']); ?>&video=<?php echo $rec['id']; ?>" class="rec-btn">Watch Now</a>
                        <?php else: ?>
                            <a href="read.php?subject=<?php echo urlencode($rec['subject']); ?>&lesson=<?php echo $rec['id']; ?>" class="rec-btn">Read Now</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    
    <?php if ($isLoggedIn && !isset($clusterInfo)): ?>
    <div class="cluster-notice">
        <div class="notice-content">
            <h3> Complete Your Learning Profile!</h3>
            <p>Take a quick quiz to help us personalize your learning experience. This will allow us to:</p>
            <ul>
                <li>Recommend content tailored to your needs</li>
                <li>Match you with similar learners</li>
                <li>Track your progress effectively</li>
            </ul>
     
        </div>
    </div>
    <?php endif; ?>

    <div class="search-and-sort">
        <div class="search-bar">
            <input type="text" placeholder="Search..." id="searchInput">
            <button><img src="photos/search.png" alt="Search"></button>
        </div>
        <div class="sort-controls">

        </div>
    </div>


    <?php if ($isLoggedIn && !empty($preferredSubjects)): ?>
    <!-- Display preferred subjects message -->
    <div class="preferred-subjects">
        <h3>Your Preferred Subjects</h3>
        <p>Based on your history, we've prioritized content from: 
            <span class="subject-tags">
                <?php foreach(array_slice($preferredSubjects, 0, 3) as $subject): ?>
                    <span class="subject-tag"><?php echo htmlspecialchars($subject); ?></span>
                <?php endforeach; ?>
            </span>
        </p>
    </div>
    <?php endif; ?>

    <h2>VIDEOS</h2>

    <?php if (!empty($videosBySubject)): ?>
        <?php 
        // Display preferred subjects first
        $displayedSubjects = [];
        if (!empty($preferredSubjects)) {
            foreach ($preferredSubjects as $subject) {
                if (isset($videosBySubject[$subject])) {
                    $displayedSubjects[] = $subject;
        ?>
            <div class="subject-section preferred">
                <h3 class="subject-title">
                    <?php echo htmlspecialchars($subject); ?> 
                    <?php if (in_array($subject, $preferredSubjects)): ?>
                        <span class="preferred-badge">Preferred</span>
                    <?php endif; ?>
                </h3>
                <div class="carousel-wrapper">
                    <button class="prev"><img src="photos/caret-left-fill.png"></button>
                    <div class="carousel">
                        <?php foreach ($videosBySubject[$subject] as $video): ?>
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
                    </div>
                    <button class="next"><img src="photos/caret-right-fill.png" alt=""></button>
                </div>
            </div>
        <?php 
                }
            }
        }

        // Display remaining subjects
        foreach ($videosBySubject as $subject => $subjectVideos) {
            if (!in_array($subject, $displayedSubjects)) {
        ?>
            <div class="subject-section">
                <h3 class="subject-title"><?php echo htmlspecialchars($subject); ?></h3>
                <div class="carousel-wrapper">
                    <button class="prev"><img src="photos/caret-left-fill.png"></button>
                    <div class="carousel">
                        <?php foreach ($subjectVideos as $video): ?>
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
                    </div>
                    <button class="next"><img src="photos/caret-right-fill.png" alt=""></button>
                </div>
            </div>
        <?php 
            }
        }
        ?>
    <?php else: ?>
        <!-- Fallback content if no videos in database -->
        <div class="carousel-wrapper">
            <button class="prev"><img src="photos/caret-left-fill.png"></button>
            <div class="carousel">
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
            </div>
            <button class="next"><img src="photos/caret-right-fill.png" alt=""></button>
        </div>
    <?php endif; ?>

    <div class="booktitle">MODULES</div>

    <?php if (!empty($modulesBySubject)): ?>
        <div class="books-container">
            <?php 
            // Display preferred subjects first
            $displayedSubjects = [];
            if (!empty($preferredSubjects)) {
                foreach ($preferredSubjects as $subject) {
                    if (isset($modulesBySubject[$subject])) {
                        $displayedSubjects[] = $subject;
            ?>
                <div class="subject-modules preferred">
                    <h3 class="subject-title">
                        <?php echo htmlspecialchars($subject); ?> 
                        <?php if (in_array($subject, $preferredSubjects)): ?>
                            <span class="preferred-badge">Preferred</span>
                        <?php endif; ?>
                    </h3>
                    <div class="books-grid">
                        <?php foreach ($modulesBySubject[$subject] as $module): ?>
                            <div class="book-item" onclick="window.location.href='read.php?subject=<?php echo urlencode($module['subject']); ?>&lesson=<?php echo $module['id']; ?>'">
                                <img src="admin/<?php echo !empty($module['cover_photo']) ? htmlspecialchars($module['cover_photo']) : 'https://via.placeholder.com/150x200'; ?>" alt="<?php echo htmlspecialchars($module['title']); ?> Cover" class="book-cover" style="width: 150px; height: 200px;">
                                <p><?php echo htmlspecialchars($module['title']); ?></p>
                                <span class="module-level"><?php echo htmlspecialchars($module['level']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php 
                    }
                }
            }

            // Display remaining subjects
            foreach ($modulesBySubject as $subject => $subjectModules) {
                if (!in_array($subject, $displayedSubjects)) {
            ?>
                <div class="subject-modules">
                    <h3 class="subject-title"><?php echo htmlspecialchars($subject); ?></h3>
                    <div class="books-grid">
                        <?php foreach ($subjectModules as $module): ?>
                            <div class="book-item" onclick="window.location.href='read.php?subject=<?php echo urlencode($module['subject']); ?>&lesson=<?php echo $module['id']; ?>'">
                                <img src="admin/<?php echo !empty($module['cover_photo']) ? htmlspecialchars($module['cover_photo']) : 'https://via.placeholder.com/150x200'; ?>" alt="<?php echo htmlspecialchars($module['title']); ?> Cover" class="book-cover" style="width: 150px; height: 200px;">
                                <p><?php echo htmlspecialchars($module['title']); ?></p>
                                <span class="module-level"><?php echo htmlspecialchars($module['level']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php 
                }
            }
            ?>
        </div>
    <?php else: ?>
        <!-- Fallback content if no modules in database -->
        <div class="books-grid">
            <div class="book-item" onclick="openModule('History', 'Intermediate')">
                <img src="https://m.media-amazon.com/images/I/81zwMtN5ziL._AC_UF1000,1000,1000_QL80_.jpg" alt="History Book Cover" class="book-cover" style="width: 150px; height: 200px;">
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
        </div>
    <?php endif; ?>

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