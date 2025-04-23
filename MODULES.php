<?php
session_start();

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Styles - Lumin</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/MODULES.css">
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
                <li><a href="styles.php" class="active">Styles</a></li>
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
        <section class="styles-hero">
            <div class="styles-hero-content">
                <h1>Choose Your Subject</h1>
                <p>Select a subject to begin your personalized learning journey</p>
            </div>
        </section>

        <section class="subjects-grid">
            <div class="subject-card" data-subject="English">
                <div class="subject-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                </div>
                <h2>English</h2>
                <p>Grammar, Literature, Communication</p>
            </div>

            <div class="subject-card" data-subject="Mathematics">
                <div class="subject-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                </div>
                <h2>Mathematics</h2>
                <p>Algebra, Geometry, Calculus</p>
            </div>

            <div class="subject-card" data-subject="History">
                <div class="subject-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <h2>History</h2>
                <p>Ancient Civilizations, World Wars, Cultural History</p>
            </div>

            <div class="subject-card" data-subject="Science">
                <div class="subject-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                    </svg>
                </div>
                <h2>Science</h2>
                <p>Biology, Chemistry, Physics</p>
            </div>

            <div class="subject-card" data-subject="Geography">
                <div class="subject-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    </svg>
                </div>
                <h2>Geography</h2>
                <p>Physical Geography, Human Geography, Cartography</p>
            </div>

            <div class="subject-card" data-subject="Art">
                <div class="subject-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="4 7 4 4 20 4 20 7"></polyline>
                        <line x1="9" y1="20" x2="15" y2="20"></line>
                        <line x1="12" y1="4" x2="12" y2="20"></line>
                        <path d="M4 7H20"></path>
                    </svg>
                </div>
                <h2>Art</h2>
                <p>Drawing, Painting, Art History</p>
            </div>
        </section>

        <section class="why-choose">
            <div class="why-choose-content">
                <h2>Why Choose Your Learning Style?</h2>
                <p>Lumin uses advanced K-means clustering to analyze your learning patterns and provide personalized recommendations. We adapt to your preferred learning style to help you achieve better results.</p>
            </div>
            <div class="owl-mascot">
                <img src="photos/owl1.png" alt="Lumin Owl Mascot">
            </div>
        </section>
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

        // Add click event listeners to subject cards
        document.querySelectorAll('.subject-card').forEach(card => {
            card.addEventListener('click', function() {
                const subject = this.getAttribute('data-subject');
                window.location.href = `personalize.php?subject=${encodeURIComponent(subject)}`;
            });
        });
    </script>
</body>
</html>
