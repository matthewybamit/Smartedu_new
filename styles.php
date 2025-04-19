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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <script defer src="js/carouselvid.js"></script>
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




    <div class="container">
        <div class="search-bar">
            <input type="text" placeholder="Search...">
            <button><img src="photos/search.png" alt="Search"></button>
        </div>
        <h2>VIDEOS</h2>
        <div class="carousel-wrapper">
            <button class="prev"><img src="photos/caret-left-fill.png"></button>
            <div class="carousel">
            <div class="video-item">
            <iframe width="300" height="200" src="https://www.youtube.com/embed/2ePf9rue1Ao" frameborder="0" allowfullscreen></iframe>
            <p>English - Improve Your Vocabulary</p>
            </div>
            <div class="video-item">
            <iframe width="300" height="200" src="https://www.youtube.com/embed/9D05ej8u-gU" frameborder="0" allowfullscreen></iframe>
            <p>Science - The Solar System</p>
            </div>
            <div class="video-item">
            <iframe width="300" height="200" src="https://www.youtube.com/embed/5MgBikgcWnY" frameborder="0" allowfullscreen></iframe>
            <p>Mathematics - Algebra Basics</p>
            </div>
            <div class="video-item">
            <iframe width="300" height="200" src="https://www.youtube.com/embed/3JZ_D3ELwOQ" frameborder="0" allowfullscreen></iframe>
            <p>History - Ancient Civilizations</p>
            </div>
            <div class="video-item">
            <iframe width="300" height="200" src="https://www.youtube.com/embed/kKKM8Y-u7ds" frameborder="0" allowfullscreen></iframe>
            <p>Physics - Laws of Motion</p>
            </div>
            <div class="video-item">
            <iframe width="300" height="200" src="https://www.youtube.com/embed/0fKBhvDjuy0" frameborder="0" allowfullscreen></iframe>
            <p>Chemistry - Periodic Table</p>
            </div>
            <div class="video-item">
            <iframe width="300" height="200" src="https://www.youtube.com/embed/8ZZ6GrzWkw0" frameborder="0" allowfullscreen></iframe>
            <p>Geography - Climate Zones</p>
            </div>
            <div class="video-item">
            <iframe width="300" height="200" src="https://www.youtube.com/embed/ZK3O402wf1c" frameborder="0" allowfullscreen></iframe>
            <p>Biology - Human Anatomy</p>
            </div>
            </div>
            <button class="next"><img src="photos/caret-right-fill.png" alt=""></button>
        </div>

        <div class="books-container">
            <div class="booktitle">BOOKS</div>
            <div class="books-grid">
            <div class="book-item">
                <img src="https://m.media-amazon.com/images/I/81zwMtN5ziL._AC_UF1000,1000_QL80_.jpg" alt="History Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                <p>History - Ancient Civilizations</p>
            </div>
            <div class="book-item">
                <img src="https://worldscientific.com/cms/10.1142/13807/asset/190d9865-4019-d986-1401-0d9865140190/13807.cover.jpg" alt="Science Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                <p>Science - The Wonders of Science</p>
            </div>
            <div class="book-item">
                <img src="https://m.media-amazon.com/images/I/71TOWmvvvPL._AC_UF1000,1000_QL80_.jpg" alt="Mathematics Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                <p>Mathematics - Algebra Essentials</p>
            </div>
            <div class="book-item">
                <img src="https://m.media-amazon.com/images/I/71LM5u45AlL._AC_UF1000,1000_QL80_.jpg" alt="English Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                <p>English - Mastering Vocabulary</p>
            </div>
            <div class="book-item">
                <img src="https://m.media-amazon.com/images/I/81kC4TNqsKL._AC_UF1000,1000_QL80_.jpg" alt="History Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                <p>History - World Wars</p>
            </div>
            <div class="book-item">
                <img src="https://m.media-amazon.com/images/I/616iPSSOSsL._AC_UF1000,1000_QL80_.jpg" alt="Science Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                <p>Science - Exploring Space</p>
            </div>
            <div class="book-item">
                <img src="https://m.media-amazon.com/images/I/81Wc7IlIOmL._AC_UF1000,1000_QL80_.jpg" alt="Mathematics Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                <p>Mathematics - Geometry Basics</p>
            </div>
            <div class="book-item">
                <img src="https://m.media-amazon.com/images/I/71tOHn1AG5L.jpg" alt="English Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                <p>English - Grammar Rules</p>
            </div>
        
    </div>
    </div> <!-- Closing books-container -->

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
    </script>

    </body>
    </html>
