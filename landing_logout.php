<?php
session_start();
require_once 'config.php';
$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartEdu</title>
    <link rel="stylesheet" href="css/landing.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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

    <div class="all_container">
        <div class="hero">
            <div class="hero-text">
                <div class="wt">WELCOME TO</div>
                <div class="se">Lumin</div>
                <div class="p1">Where Learning Becomes an Adventure!</div>
                <hr>
                <br>
                <div class="parag1"> Personalized learning powered by K-means clustering and <br>
                    analytics for data-driven education.</div>
                <button onclick="location.href='styles.php'">Get Started</button>
            </div>
            <div class="hero-image">
                <img src="photos/owl1.png" alt="Owl Mascot" class="owlmascot">
            </div>
        </div>
        <div class="container">
            <div class="left-section">
                <div class="cy">CHOOSE YOUR <br> LEARNING STYLE</div>

                <div class="text-box">
                    <div class="owls"><img src="photos/book 1.png" alt="Owl with a book" class="owl-img"></div>

                    <div class="highlight">Learn your way with <br> Read Mode or Video <br> Mode.</div>
                </div>
            </div>
            <div class="right-section">
                <div class="top">
                    <div class="option">

                        <div class="video-icon"><img src="photos/collection-play-fill.png" class="viddd"></div>
                        <div class="option-text">
                            <div class="vid">Video</div>

                        </div>

                    </div>
                    <div class="top-p">Offers engaging videos that <br>simplify complex concepts.</div>
                </div>

                <div class="bot">
                    <div class="option">
                        <div class="read-icon"><img src="photos/book-half.png" class="readdd"></div>
                        <div class="option-text">
                            <div class="rid">Read</div>

                        </div>

                    </div>
                    <div class="bot-p">Helps you learn through detailed text, ideal for readers and writers.</div>
                </div>
            </div>
            <div class="container2">
                <div class="pt">Popular Topics</div>
                <div class="topics-container">
                    <div class="topic-card">
                        <span class="star"><img src="photos/star-fill.png" class="stars"></span>
                        <h3>HTML/CSS</h3>
                        <p>Lorem ipsum dolor sit amet</p>
                        <div class="btn-align"><button class="view-btn">View</button></div>
                    </div>
                    <div class="topic-card">
                        <span class="star"><img src="photos/star-fill.png" class="stars"></span>
                        <h3>JAVASCRIPT</h3>
                        <p>Lorem ipsum dolor sit amet</p>
                        <div class="btn-align"><button class="view-btn">View</button></div>
                    </div>
                    <div class="topic-card">
                        <span class="star"><img src="photos/star-fill.png" class="stars"></span>
                        <h3>SWIFT</h3>
                        <p>Lorem ipsum dolor sit amet</p>
                        <div class="btn-align"><button class="view-btn">View</button></div>
                    </div>
                    <div class="topic-card">
                        <span class="star"><img src="photos/star-fill.png" class="stars"></span>
                        <h3>PYTHON</h3>
                        <p>Lorem ipsum dolor sit amet</p>
                        <div class="btn-align"><button class="view-btn">View</button></div>
                    </div>
                </div>

                <div class="vmore">
                    <div class="view-more">View More</div>
                </div>

                <div class="customization-section">

                    <div class="lefty">
                        <div class="paragraph">Your learning experience is customized through study plans, learning techniques, study guides, and course recommendations based on your performance, learning style, and strengths. The system uses K-means clustering to group similar learners, tracks progress through quizzes and assignments, and provides real-time insights for continuous improvement.</div>
                        <div class="persobutton"><button class="personalize-btn">Personalize</button></div>
                    </div>

                    <div class="rightright">
                        <div class="mascot">
                            <div class="owlezgo"><img src="photos/lets-go 1.png" alt="Mascot" class="lezgo"></div>
                        </div>
                    </div>

                </div>
            </div>
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