<?php
session_start();

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);

// Get the values from the URL (query string)
$subject = $_GET['subject'] ?? null;
$level = $_GET['level'] ?? null;
$style = $_GET['style'] ?? null;
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

            <!-- Chapters Sidebar -->
            <div class="chapters">
                
                <h1>Chapters</h1>
                <div class="scroll-chapters">
                    <div id="chapters-grid" class="grid-grid"></div>
                </div>
            </div>

            <!-- Lesson Content Area -->
            <div class="readcontent">
                <button class="save">Save</button>
                <button class="finish">Finished</button>
                <button class="start" onclick="location.href='quizone.php';">Start Quiz</button>

                <!-- Title and Number -->
                <div id="lesson-title" class="scroll-read">
                    <h2></h2> <!-- For Chapter Number -->
                    <h1></h1> <!-- For Chapter Title -->
                    <p></p>
                </div>

                <!-- Lesson Description -->
                <div id="lesson-description" class="content">
                    <p></p>
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

    // Get PHP session variables
    const subject = '<?php echo $subject; ?>';
    const level = '<?php echo $level; ?>';

    // Fetch lessons from the server
    async function fetchLessons() {
        try {
            const response = await fetch('php_functions/fetch_lessons.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ subject, level })
            });

            const lessons = await response.json();

            if (lessons.length > 0) {
                populateChaptersGrid(lessons);
                displayLessonContent(lessons[0], 0); // Display first lesson by default
            } else {
                console.warn('No lessons found.');
            }

        } catch (error) {
            console.error('Error fetching lessons:', error);
        }
    }

    // Populate the chapters sidebar
    function populateChaptersGrid(lessons) {
        const chaptersGrid = document.getElementById('chapters-grid');
        chaptersGrid.innerHTML = ''; // Clear existing

        lessons.forEach((lesson, index) => {
            const chapterNumber = String(index + 1).padStart(2, '0');
            const chapterTitle = lesson.title;

            const chapterDiv = document.createElement('div');
            chapterDiv.classList.add('chapter');
            chapterDiv.innerHTML = `
                <h2>${chapterNumber}</h2>
                <h3>${chapterTitle}</h3>
            `;

            chapterDiv.addEventListener('click', () => {
                displayLessonContent(lesson, index);
            });

            chaptersGrid.appendChild(chapterDiv);
        });
    }

    // Display the selected lesson
    function displayLessonContent(lesson, index = 0) {
        const lessonTitle = document.getElementById('lesson-title');
        const lessonDescription = document.getElementById('lesson-description');

        const chapterNumber = String(index + 1).padStart(2, '0');

        // Update scroll-read
        lessonTitle.querySelector('h2').textContent = chapterNumber;
        lessonTitle.querySelector('h1').textContent = lesson.title;

        // Update content
        lessonTitle.querySelector('p').textContent = lesson.description;
    }

    // Initial fetch
    fetchLessons();
    </script>

</body>

</html>