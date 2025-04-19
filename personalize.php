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
    <link rel="stylesheet" href="CSS/personalize.CSS">
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
            <h1 class="modules-txt">PERSONALIZE YOUR LEARNING</h1>
            <div class="levels">
                <img src="photos/1.png" class="a1">
                <h2>SELECT LEVEL</h2>
                <button class="beginner">Beginner</button>
                <h3>Basics & guidance</h3>
                <button class="intermediate">Intermediate</button>
                <h3>Fundamentals & problem-solving</h3>
                <button class="advanced">Advanced</button>
                <h3>Deep comprehension & analysis</h3>
            </div>
            
            <div class="c_styles">
                <img src="photos/2.png"  class="numbertwo">
                <h2>CHOOSE STYLE</h2>
                <button class="watching"><img src="photos/watching.png"  alt="button image"></button>
                <button class="reading"><img src="photos/reading.png"  alt="button image"></button>
            </div>
            <div class="subjects">
                <img src="photos/3.png"  class="a3">
                <h2>SELECT SUBJECT(S)</h2>
                <div class="checkbox-list">
                    <label>
                        <input type="checkbox" >
                        <span>Art</span>
                    </label>
                    <label>
                        <input type="checkbox" >
                        <span>English</span>
                    </label>
                    <label>
                        <input type="checkbox" >
                        <span>Filipino</span>
                    </label>
                    <label>
                        <input type="checkbox" >
                        <span>Math</span>
                    </label>
                    <label>
                        <input type="checkbox" >
                        <span>Science</span>
                    </label>
                </div>
                <button class="skip">SKIP</button>
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
