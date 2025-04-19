<?php
include 'php_functions/db_connection.php';
session_start();  // Must be at the very top

// Check if the user is logged in
if (!isset($_SESSION['email']) && !isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}
// Optional: for navigation purposes
$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);
// Query the database to get the user's age using the email stored in session
$userAge = null;
$query = $conn->prepare("SELECT age FROM users WHERE email = :email");
$query->bindParam(':email', $_SESSION['email']);
$query->execute();
if ($query->rowCount() > 0) {
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $userAge = $result['age'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Website</title>
    <link rel="stylesheet" href="CSS/dashboard.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <h1 class="modules-txt">DASHBOARD</h1>
    <div class="topbox">
        <!-- Profile Image Placeholder (using session data) -->
        <label for="fileInput" class="circle-button">
            <img src="<?php echo htmlspecialchars($_SESSION['user_profileImage'] ?? 'photos/default-avatar.png'); ?>" alt="Profile Image" id="profileImage" class="button-image">
        </label>
        
        <div class="info">
            <!-- Name and Email displayed from session data -->
            <h3 class="name1" id="userName"><?php echo htmlspecialchars($_SESSION['user_displayName'] ?? 'Name'); ?></h3>
            <h3 class="age2" id="age"><?php echo htmlspecialchars($userAge ?? 'Age'); ?></h3>
        </div>

        <div class="score-section">
            <div class="average-score">
                <h1>87.8</h1>
                <p>Average Score</p>
            </div>
            <div class="progress-bars">
                <div class="progress-item">
                    <div class="circle" data-percentage="77">
                        <span>77%</span>
                    </div>
                    <p>Grades</p>
                </div>
                <div class="progress-item">
                    <div class="circle" data-percentage="77">
                        <span>77%</span>
                    </div>
                    <p>Progress</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="leftbox">
        <h1>Recent Module</h1>
        <div class="scroll_leftbox">
            <div class="leftbox_grid">  
                <div class="recent_module">
                    <h1>There are many variations</h1>
                </div>
                <div class="recent_module">
                    <h1>There are many variations</h1>
                </div>
                <div class="recent_module">
                    <h1>There are many variations</h1>
                </div>
                <div class="recent_module">
                    <h1>There are many variations</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="topmid">
        <h1>Recent Activity</h1>
        <div class="scroll_topmid">
            <div class="grid_topmid">
                <img src="photos/quiz.png" class="quiz">
                <img src="photos/quiz.png" class="quiz">
                <img src="photos/quiz.png" class="quiz">
                <img src="photos/quiz.png" class="quiz">
            </div>
        </div>
    </div>
    
    <div class="profile-box">
        <div class="profile-row">
            <a href="#" class="edit-label">Edit Name</a>
            <span class="value-label" id="displayName"><?php echo htmlspecialchars($_SESSION['user_displayName'] ?? 'Name'); ?></span>
        </div>
        <div class="profile-row">
            <a href="#" class="edit-label">Edit Email</a>
            <span class="value-label" id="displayEmail"><?php echo htmlspecialchars($_SESSION['email'] ?? 'Email'); ?></span>
        </div>
        <div class="profile-row">
            <a href="#" class="edit-label">Edit Username</a>
            <span class="value-label" id="displayUsername">
                <?php 
                    // Assuming you want to display the email prefix as the username
                    echo htmlspecialchars(isset($_SESSION['email']) ? explode('@', $_SESSION['email'])[0] : 'Username'); 
                ?>
            </span>
        </div>
        <div class="profile-row">
            <a href="#" class="edit-label">Edit Password</a>
            <span class="value-label">*******</span>
        </div>
    </div>
    
    <div class="overall-section">
        <h2>Overall</h2>
        <canvas id="overallChart" width="300" height="300"></canvas>
        <div class="chart-labels">
            <div><span class="color-box" style="background-color: #FFC107;"></span>Quizzes 52.1%</div>
            <div><span class="color-box" style="background-color: #FF5722;"></span>Assignments 31.3%</div>
            <div><span class="color-box" style="background-color: #4CAF50;"></span>Category 5.2%</div>
            <div><span class="color-box" style="background-color: #4CAF50;"></span>Subject 10.4%</div>
        </div>
    </div>
</div>
    
<script src="js/firebaseAuth.js"></script> 
<script>
    // Initialize the pie chart
    const ctx = document.getElementById('overallChart').getContext('2d');
    const overallChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Quizzes', 'Assignments', 'Category', 'Subject'],
            datasets: [{
                data: [52.1, 31.3, 5.2, 10.4],
                backgroundColor: ['#FFC107', '#FF5722', '#fd5c63', '#4CAF50'],
                borderWidth: 0
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false  // Hide default legend
                }
            }
        }
    });
</script>

<script>
    // Toggle the visibility of the burger menu
    const burger = document.getElementById('burger');
    const navMenu = document.getElementById('nav-menu');
    burger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
</script>

</body>
</html>
