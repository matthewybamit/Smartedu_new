<?php
include_once 'php_functions/module_function.php';  // Include the function to fetch title and description
include_once 'php_functions/db_connection.php';  // Include the database connection file

session_start();

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);


// Fetch both title and description
$moduleDetails = getEnglishModuleDetails($conn);

// Extract title and description from the result
$title = $moduleDetails['title'];
$description = $moduleDetails['description'];
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Website</title>
    <link rel="stylesheet" href="CSS/read.css">
    <link rel="stylesheet" href="css/navbar.css">
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


    <main>

        <div class="background">
            <div class="readFrame">
                <div class="chapters">
                    <H1>Chapters</H1>
                    <div class="scroll-chapters">
                        <div class="grid-grid">
                            <div class="grid-num">
                                <h2>01</h2>
                                <h2>02</h2>
                                <h2>03</h2>
                                <h2>04</h2>
                                <h2>05</h2>
                                <h2>06</h2>
                                <h2>07</h2>
                                <h2>08</h2>
                                <h2>09</h2>
                            </div>
                            <div class="grid-title">
                                <h3><?php echo htmlspecialchars($title); ?></h3>
                                <h3>Title</h3>
                                <h3>Title</h3>
                                <h3>Title</h3>
                                <h3>Title</h3>
                                <h3>Title</h3>
                                <h3>Title</h3>
                                <h3>Title</h3>
                                <h3>Title</h3>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="readcontent">

                    <button class="save">Save</button>
                    <button class="finish">Finished</button>
                    <button class="start" onclick="location.href='quizone.php';">Start Quiz</button>

                    <div class="scroll-read">
                        <h2>01</h2>
                        <h1><?php echo htmlspecialchars($title); ?></h1> <!-- Display the title -->

                        <!-- Display the description fetched from the database -->
                        <p><?php echo htmlspecialchars($description); ?></p> <!-- Display the description -->
                    </div>
                </div>

                <div class="content">
                    <h1></h1>
                    <h2></h2>
                    <h3></h3>

                </div>




            </div>
        </div>
    </main>
    <footer>

    </footer>

    <script src="scripts.js"></script>


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