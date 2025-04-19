<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartEdu</title>
    <link rel="stylesheet" href="css/admin_quiz.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/sidebar.css">
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
            
        </ul>
    </nav>

    <div class="sidebar" id="sidebar">
    <ul class="sidebar__menu">
        <div class="logo"> <img src="photos/blue.png" class="blue1"></div>
        <li class="sidebar__item"> <!-- Make this item active -->
            <a href="admin_dashboard.php" class="sidebar__link">
                <i class="fas fa-tasks"></i> <!-- Icon for PLANNER -->
                <span class="sidebar__text">Dashboard</span>
            </a>
        </li>
        <li class="sidebar__item active">
            <a href="#" class="sidebar__link">
                <i class="fas fa-plus"></i> <!-- Icon for CREATE TASK -->
                <span class="sidebar__text">Materials</span>
            </a>
        </li>
        <li class="sidebar__item">
            <a href="settings.php" class="sidebar__link">
                <i class="fas fa-sticky-note"></i> <!-- Icon for NOTE -->
                <span class="sidebar__text">Settings</span>
            </a>
        </li>
    </ul>
</div>
</header>

<main class="quiz-content">
  <h2>QUIZ</h2>
  <div class="quiz-container">
    <div class="quiz-left">
      <h3>EDIT</h3>
      <label>Title</label>
      <input type="text" placeholder="Enter title">

      <div class="triple-row">
        <div>
          <label>Level</label>
          <select><option>Select</option></select>
        </div>
        <div>
          <label>Style</label>
          <select><option>Select</option></select>
        </div>
        <div>
          <label>Subject</label>
          <select><option>Select</option></select>
        </div>
      </div>

      <div class="triple-row">
        <div>
          <label>Type</label>
          <select><option>Select</option></select>
        </div>
        <div>
          <label>Item</label>
          <select><option>Select</option></select>
        </div>
        <div>
          <label>Points</label>
          <select><option>Select</option></select>
        </div>
      </div>

      <label>Question</label>
      <input type="text" placeholder="Enter question">

      <div class="double-row">
        <div>
          <label>Choices</label>
          <select><option>Select</option></select>
        </div>
        <div>
          <label>Answer</label>
          <select><option>Select</option></select>
        </div>
      </div>
    </div>

    <div class="quiz-right">
      <label>Cover Photo</label>
      <div class="cover-box"></div>
      <input type="file">
    </div>

    <!-- Buttons moved inside -->
    <div class="quiz-buttons">
      <button class="cancel-btn">Cancel</button>
      <button class="upload-btn">Upload</button>
    </div>
  </div>
</main>




    
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
