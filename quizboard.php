<?php
session_start();

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Page</title>
    <link rel="stylesheet" href="css/quizboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <span class="pointer">←</span> Module
        </div>
        <div class="quiz-header">
            <h1>QUIZ INSIGHT BOARD</h1>
            <div class="congrats-section">
                <h2>CONGRATS!</h2>
                <p>You Just Completed</p>
                <p>Quiz 1</p>
            </div>
        
        <div class="quiz-badge">
            <img src="image/goldmedal.png" alt="Gold Medal" class="badge-image">
        </div>
        <div class="quiz-stats">
            <div class="stat">
                <h2>70%</h2>
                <p>INVENUES</p>
            </div>
            <div class="stat">
                <h2>7/10</h2>
                <p>SECRET</p>
            </div>
            <div class="stat">
                <h2>HIGH</h2>
                <p>RECLINARY</p>
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
                <td>Multiplication, Geometry</td>
                <td>Q5, Q12, Q18</td>
                <td>Algebra, Word Problems</td>
                <td>Review algebra formulas and problem-solving strategies</td>
            </tr>
        </table>

        <section class="recommendations-container">
            <h2 class="recommend-title">Recommendations</h2>
            
            <div class="recommendations">
                <div class="card">
                    <div class="star"><i class="fas fa-star"></i></div>

                    <h3>HTML/CSS</h3>
                    <p>Lorem ipsum dolor sit amet</p>
                    <button class="view-btn">View</button>
                </div>
    
                <div class="card">
                    <div class="star"><i class="fas fa-star"></i></div>

                    <h3>JAVASCRIPT</h3>
                    <p>Lorem ipsum dolor sit amet</p>
                    <button class="view-btn">View</button>
                </div>
    
                <div class="card">
                    <div class="star"><i class="fas fa-star"></i></div>

                    <h3>SWIFT</h3>
                    <p>Lorem ipsum dolor sit amet</p>
                    <button class="view-btn">View</button>
                </div>
    
                <div class="card">
                    <div class="star"><i class="fas fa-star"></i></div>

                    <h3>PYTHON</h3>
                    <p>Lorem ipsum dolor sit amet</p>
                    <button class="view-btn">View</button>
                </div>
            </div>
    
            <p class="view-more">View More</p>
        </section>
    
        <script>
    // Toggle the visibility of the menu
    const burger = document.getElementById('burger');
    const navMenu = document.getElementById('nav-menu');

    burger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
</script>

        <body>
        </html>