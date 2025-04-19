<?php
session_start();

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartEdu</title>
<<<<<<<< HEAD:video.php
    <link rel="stylesheet" href="css/video.css">
========
    <link rel="stylesheet" href="css/admin_dashboard.css">
>>>>>>>> ff4c5ca (dashboard, unfinished materials part):admin_dashboard.php
    <link rel="stylesheet" href="css/navbar.css">
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
<<<<<<<< HEAD:video.php
========

    <div class="sidebar" id="sidebar">
    <ul class="sidebar__menu">
        <div class="logo"> <img src="photos/blue.png" class="blue1"></div>
        <li class="sidebar__item active"> <!-- Make this item active -->
            <a href="#" class="sidebar__link">
                <i class="fas fa-tasks"></i> <!-- Icon for PLANNER -->
                <span class="sidebar__text">Dashboard</span>
            </a>
        </li>
        <li class="sidebar__item">
            <a href="materials.php" class="sidebar__link">
                <i class="fas fa-plus"></i> <!-- Icon for CREATE TASK -->
                <span class="sidebar__text">Materials</span>
            </a>
        </li>
        <li class="sidebar__item">
            <a href="notes.php" class="sidebar__link">
                <i class="fas fa-sticky-note"></i> <!-- Icon for NOTE -->
                <span class="sidebar__text">Settings</span>
            </a>
        </li>
    </ul>
</div>
>>>>>>>> ff4c5ca (dashboard, unfinished materials part):admin_dashboard.php
</header>

<main class="admin-container">
    <div class="admintitle">ADMIN </div>
    <div class="admin-header">
        <div class="admin-profile">
            <div class="profile-image">Image</div>
            <div class="profile-info">
                <p class="admin-name">Name</p>
                <p class="admin-position">Position</p>
            </div>
        </div>
        <div class="admin-score">
            <h1>87.8</h1>
            <div class="progress-circles">
                <div class="circle">
                    <span>77%</span>
                </div>
                <div class="circle">
                    <span>77%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-panels">
        <div class="panel recent-activity">
            <h3>Recent Activity</h3>
            <div class="activity-box">
                <p>There are many variations</p>
            </div>
        </div>
        <div class="panel users-chart">
            <h3>Users</h3>
            <div class="chart-placeholder">[Chart Here]</div>
        </div>
        <div class="panel overall-pie">
            <h3>Overall</h3>
            <div class="pie-chart-placeholder">[Pie Chart Here]</div>
        </div>
    </div>
</main>


    <div class="container">
        <div class="title"> Recognizing Shapes </div>
        <div class="video-container"> </div>
        <div class="container2">
            <div class="abt">ABOUT</div>
            <div class="parag">Learn about recognizing and naming different shapes, such as circles, ovals, triangles, and various types of quadrilaterals like rectangles, squares, rhombuses, and trapezoids. The video explains the properties of each shape and how to distinguish them from one another. </div>
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
