<?php
session_start();

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Website</title>
    <link rel="stylesheet" href="CSS/MODULES.CSS">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/navbar.css">
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


    <div class="background">
        <h1 class="modules-txt">MODULES</h1>
        <div class="Modules">
            <a class="quiz" href="quiz_assignment.php">Quizzes</a>

            <button class="assignments">Assignments</button>

            <div class="content">
                <div class="grid-content">
                    <a href="read.php">
                        <div class="quiz-content">
                            <img src="https://m.media-amazon.com/images/I/618JU+EmlBL._AC_UF1000,1000_QL80_.jpg" alt="English Cover" class="quiz-cover" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                            <h1>English</h1>
                        </div>
                    </a>
                    <div class="quiz-content">
                        <h1>Mathematics</h1>
                    </div>
                    <div class="quiz-content">
                        <h1>History</h1>
                    </div>
                    <div class="quiz-content">
                        <h1>Science</h1>
                    </div>
                    <div class="quiz-content">
                        <h1>Geography</h1>
                    </div>
                    <div class="quiz-content">
                        <h1>Art</h1>
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