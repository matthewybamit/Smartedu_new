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
    <link rel="stylesheet" href="CSS/quiz_assignment.css">
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



    <main>
        
        <div class="background">
            <div class="readFrame">
                <div class="Quizzes">
                    <button class="modulebttn"> Module</button>
                    <button class="finishedbttn">Finished</button>
                    <h2>Quiz</h2>
                    <div class="scrollpanelquiz">
                        <div class="grid_quiz">
                            <button class="quiz_item">
                                <img src="photos/quiz.png" alt="Button Image">
                            </button>
                            <button class="quiz_item">
                                <img src="photos/quiz.png" alt="Button Image">
                            </button>
                            <button class="quiz_item">
                                <img src="photos/quiz.png" alt="Button Image">
                            </button>
                            <button class="quiz_item">
                                <img src="photos/quiz.png" alt="Button Image">
                            </button>
                            <button class="quiz_item">
                                <img src="photos/quiz.png" alt="Button Image">
                            </button>
                            <button class="quiz_item">
                                <img src="photos/quiz.png" alt="Button Image">
                            </button>
                            <button class="quiz_item">
                                <img src="photos/quiz.png" alt="Button Image">
                            </button>
                            <button class="quiz_item">
                                <img src="photos/quiz.png" alt="Button Image">
                            </button>
                        </div>  
                    </div>
                </div>
                
                <div class="Assignments">
                    <h2>Assignment</h2>
                <div class="scrollpanelassignment">
                    <div class="grid_assignment">
                        <button class="assignment_item">
                            <img src="photos/assignment.png" alt="Button Image">
                        </button>
                        <button class="assignment_item">
                            <img src="photos/assignment.png" alt="Button Image">
                        </button>
                        <button class="assignment_item">
                            <img src="photos/assignment.png" alt="Button Image">
                        </button>
                        <button class="assignment_item">
                            <img src="photos/assignment.png" alt="Button Image">
                        </button>
                        <button class="assignment_item">
                            <img src="photos/assignment.png" alt="Button Image">
                        </button>
                        <button class="assignment_item">
                            <img src="photos/assignment.png" alt="Button Image">
                        </button>
                        <button class="assignment_item">
                            <img src="photos/assignment.png" alt="Button Image">
                        </button>
                        <button class="assignment_item">
                            <img src="photos/assignment.png" alt="Button Image">
                        </button>
                    </div>
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