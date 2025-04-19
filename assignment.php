<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Page</title>
    <link rel="stylesheet" href="css/assignment.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
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
            <li><a href="#">Log Out</a></li>    
        </ul>
    </nav>
</header>


    <div class="container">
        <div class="quiz-card">
        
       
    <div class="quiz-question">
        facilisis mi, at vestibulum sapien porta ac. Phasellus eu neque in mi accumsan imperdiet. Aenean vel tellus
                fringilla, tincidunt orci sit amet, tempus libero. Mauris in urna euismod, sodales ex eu, vestibulum odio. Nunc vitae
                orci augue. Aliquam sollicitudin vel mi a rutrum. Ut rhoncus pellentesque congue.
    </div>

    <div class="quiz-options">
        <button class="quiz-option" id="option-a"><span class="option-circle">A</span> Answer</button>
        <button class="quiz-option" id="option-b"><span class="option-circle">B</span> Answer</button>
        <button class="quiz-option" id="option-c"><span class="option-circle">C</span> Answer</button>
        <button class="quiz-option" id="option-d"><span class="option-circle">D</span> Answer</button>
    </div>

    <div class="quiz-navigation">
        
        <div class="circle-check">
            <i class="fas fa-check"></i>
        </div>
        
    </div>
    
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
<script src="js/assignment.js"></script>
</body>
</html>
          
    