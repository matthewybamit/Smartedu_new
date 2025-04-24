<?php
session_start();
include 'php_functions/db_connection.php';

$isLoggedIn = isset($_SESSION['email']) || isset($_SESSION['user_email']);

// Get source and content ID from the URL parameters
$source = isset($_GET['source']) ? $_GET['source'] : 'unknown';
$contentId = isset($_GET['id']) ? intval($_GET['id']) : 1;
$subject = isset($_GET['subject']) ? $_GET['subject'] : 'General Knowledge';
$lesson = isset($_GET['lesson']) ? intval($_GET['lesson']) : 1;

// We'll initialize quiz variables
$quizTitle = "Quiz";
$quizQuestions = [];

// Fetch quiz and questions based on the source (video or reading)
try {
    if ($source === 'video') {
        // Fetch video quiz
        $quizQuery = $pdo->prepare("
            SELECT vq.*, vl.title AS video_title, vl.subject 
            FROM video_quizzes vq
            JOIN video_lessons vl ON vq.video_id = vl.id 
            WHERE vq.video_id = :video_id
            LIMIT 1
        ");
        $quizQuery->bindParam(':video_id', $contentId);
        $quizQuery->execute();
        
        if ($quizQuery->rowCount() > 0) {
            $quiz = $quizQuery->fetch(PDO::FETCH_ASSOC);
            $quizTitle = $quiz['title'] ?: "Quiz for " . $quiz['video_title'];
            $quizId = $quiz['id'];
            
            // Fetch questions for this quiz
            $questionsQuery = $pdo->prepare("
                SELECT * FROM video_questions 
                WHERE quiz_id = :quiz_id
                ORDER BY id ASC
            ");
            $questionsQuery->bindParam(':quiz_id', $quizId);
            $questionsQuery->execute();
            
            if ($questionsQuery->rowCount() > 0) {
                $questions = $questionsQuery->fetchAll(PDO::FETCH_ASSOC);
                
                // For each question, get its options
                foreach ($questions as $question) {
                    $optionsQuery = $pdo->prepare("
                        SELECT * FROM video_question_options 
                        WHERE question_id = :question_id
                        ORDER BY id ASC
                    ");
                    $optionsQuery->bindParam(':question_id', $question['id']);
                    $optionsQuery->execute();
                    
                    if ($optionsQuery->rowCount() > 0) {
                        $options = $optionsQuery->fetchAll(PDO::FETCH_ASSOC);
                        
                        // Format options for frontend
                        $formattedOptions = [];
                        $correctIndex = -1;
                        
                        foreach ($options as $index => $option) {
                            $formattedOptions[] = $option['option_text'];
                            if ($option['is_correct']) {
                                $correctIndex = $index;
                            }
                        }
                        
                        // Add question with its options to our questions array
                        $quizQuestions[] = [
                            'question' => $question['question_text'],
                            'options' => $formattedOptions,
                            'correct' => $correctIndex
                        ];
                    }
                }
            }
        }
    } else if ($source === 'read') {
        // Fetch reading quiz
        $quizQuery = $pdo->prepare("
            SELECT q.*, l.title AS lesson_title, l.subject 
            FROM quizzes q
            JOIN lessons l ON q.lesson_id = l.id 
            WHERE q.lesson_id = :lesson_id
            LIMIT 1
        ");
        $quizQuery->bindParam(':lesson_id', $lesson);
        $quizQuery->execute();
        
        if ($quizQuery->rowCount() > 0) {
            $quiz = $quizQuery->fetch(PDO::FETCH_ASSOC);
            $quizTitle = $quiz['title'] ?: "Quiz for " . $quiz['lesson_title'];
            $quizId = $quiz['id'];
            
            // Fetch questions for this quiz
            $questionsQuery = $pdo->prepare("
                SELECT * FROM questions 
                WHERE quiz_id = :quiz_id
                ORDER BY id ASC
            ");
            $questionsQuery->bindParam(':quiz_id', $quizId);
            $questionsQuery->execute();
            
            if ($questionsQuery->rowCount() > 0) {
                $questions = $questionsQuery->fetchAll(PDO::FETCH_ASSOC);
                
                // For each question, get its options
                foreach ($questions as $question) {
                    $optionsQuery = $pdo->prepare("
                        SELECT * FROM options 
                        WHERE question_id = :question_id
                        ORDER BY id ASC
                    ");
                    $optionsQuery->bindParam(':question_id', $question['id']);
                    $optionsQuery->execute();
                    
                    if ($optionsQuery->rowCount() > 0) {
                        $options = $optionsQuery->fetchAll(PDO::FETCH_ASSOC);
                        
                        // Format options for frontend
                        $formattedOptions = [];
                        $correctIndex = -1;
                        
                        foreach ($options as $index => $option) {
                            $formattedOptions[] = $option['option_text'];
                            if ($option['is_correct']) {
                                $correctIndex = $index;
                            }
                        }
                        
                        // Add question with its options to our questions array
                        $quizQuestions[] = [
                            'question' => $question['question_text'],
                            'options' => $formattedOptions,
                            'correct' => $correctIndex
                        ];
                    }
                }
            }
        }
    }
} catch (PDOException $e) {
    error_log("Error fetching quiz: " . $e->getMessage());
}


$questionsJSON = json_encode($quizQuestions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($quizTitle); ?> - Lumin</title>
    <link rel="stylesheet" href="css/quizone.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
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
    <div class="quiz-card">
        <h1 class="quiz-title"><?php echo htmlspecialchars($quizTitle); ?></h1>
        <div class="quiz-progress">
            <span id="current-question">1</span>/<span id="total-questions">5</span>
        </div>
        <div class="quiz-question" id="question-text">
            Loading question...
        </div>
        <div class="quiz-options" id="options-container">
            <button class="quiz-option" data-index="0">A. Loading...</button>
            <button class="quiz-option" data-index="1">B. Loading...</button>
            <button class="quiz-option" data-index="2">C. Loading...</button>
            <button class="quiz-option" data-index="3">D. Loading...</button>
        </div>
        <div class="quiz-navigation">
        
            <div class="circle-check" id="submit-btn">
                <i class="fas fa-check"></i>
            </div>
          
        </div>
        <div class="quiz-result" id="result-container" style="display: none;">
            <h2>Quiz Complete!</h2>
            <p>Your score: <span id="score">0</span>/<span id="max-score">5</span></p>
            <button id="finish-btn" class="finish-btn">Finish</button>
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

    // Quiz data from PHP
    const quizQuestions = <?php echo $questionsJSON; ?>;
    
    // Quiz state
    let currentQuestionIndex = 0;
    let userAnswers = new Array(quizQuestions.length).fill(-1);
    let quizSubmitted = false;
    
    // DOM elements
    const questionText = document.getElementById('question-text');
    const optionsContainer = document.getElementById('options-container');
    const optionButtons = document.querySelectorAll('.quiz-option');
    const currentQuestionSpan = document.getElementById('current-question');
    const totalQuestionsSpan = document.getElementById('total-questions');
    const prevButton = document.getElementById('prev-btn');
    const nextButton = document.getElementById('next-btn');
    const submitButton = document.getElementById('submit-btn');
    const resultContainer = document.getElementById('result-container');
    const scoreSpan = document.getElementById('score');
    const maxScoreSpan = document.getElementById('max-score');
    const finishButton = document.getElementById('finish-btn');
    
    // Initialize the quiz
    function initQuiz() {
        totalQuestionsSpan.textContent = quizQuestions.length;
        loadQuestion(0);
        
        // Event listeners
        optionButtons.forEach(button => {
            button.addEventListener('click', () => {
                const optionIndex = parseInt(button.getAttribute('data-index'));
                selectOption(optionIndex);
            });
        });
        
        prevButton.addEventListener('click', goToPrevQuestion);
        nextButton.addEventListener('click', goToNextQuestion);
        submitButton.addEventListener('click', checkAnswer);
        finishButton.addEventListener('click', finishQuiz);
    }
    
    // Load a question by index
    function loadQuestion(index) {
        const question = quizQuestions[index];
        questionText.textContent = question.question;
        
        // Update options
        optionButtons.forEach((button, i) => {
            if (i < question.options.length) {
                button.textContent = String.fromCharCode(65 + i) + '. ' + question.options[i];
                button.style.display = 'block';
            } else {
                button.style.display = 'none'; // Hide unused option buttons
            }
            
            // Reset styles
            button.classList.remove('selected', 'correct', 'incorrect');
            
            // If user already answered this question
            if (userAnswers[index] === i) {
                button.classList.add('selected');
            }
        });
        
        // Update navigation buttons
        prevButton.disabled = index === 0;
        nextButton.disabled = index === quizQuestions.length - 1;
        
        // Update progress
        currentQuestionIndex = index;
        currentQuestionSpan.textContent = index + 1;
    }
    
    // Select an option
    function selectOption(optionIndex) {
        // Clear previous selection
        optionButtons.forEach(button => {
            button.classList.remove('selected');
        });
        
        // Mark this option as selected
        optionButtons[optionIndex].classList.add('selected');
        
        // Store the user's answer
        userAnswers[currentQuestionIndex] = optionIndex;
    }
    
    // Go to previous question
    function goToPrevQuestion() {
        if (currentQuestionIndex > 0) {
            loadQuestion(currentQuestionIndex - 1);
        }
    }
    
    // Go to next question
    function goToNextQuestion() {
        if (currentQuestionIndex < quizQuestions.length - 1) {
            loadQuestion(currentQuestionIndex + 1);
        }
    }
    
    // Check the current answer
    function checkAnswer() {
        const currentQuestion = quizQuestions[currentQuestionIndex];
        const userAnswer = userAnswers[currentQuestionIndex];
        
        // If user hasn't selected an answer
        if (userAnswer === -1) {
            alert('Please select an answer before submitting.');
            return;
        }
        
        // Show correct/incorrect feedback
        optionButtons.forEach((button, index) => {
            if (index === currentQuestion.correct) {
                button.classList.add('correct');
            } else if (index === userAnswer && userAnswer !== currentQuestion.correct) {
                button.classList.add('incorrect');
            }
        });
        
        // If this is the last question, show results
        if (currentQuestionIndex === quizQuestions.length - 1) {
            setTimeout(showResults, 1500);
        } else {
            // Otherwise, go to the next question after a delay
            setTimeout(() => {
                goToNextQuestion();
            }, 1500);
        }
    }
    
    // Show quiz results
    function showResults() {
        let score = 0;
        
        // Calculate the score
        userAnswers.forEach((answer, index) => {
            if (answer === quizQuestions[index].correct) {
                score++;
            }
        });
        
        // Update the score display
        scoreSpan.textContent = score;
        maxScoreSpan.textContent = quizQuestions.length;
        
        // Hide the quiz content and show results
        questionText.style.display = 'none';
        optionsContainer.style.display = 'none';
        document.querySelector('.quiz-navigation').style.display = 'none';
        resultContainer.style.display = 'block';
    }
    
    // Finish the quiz and redirect
    function finishQuiz() {
        let score = 0;
        userAnswers.forEach((answer, index) => {
            if (answer === quizQuestions[index].correct) {
                score++;
            }
        });

        // Save quiz results to the database via AJAX
        const quizData = {
            score: score,
            total: quizQuestions.length,
            source: '<?php echo $source; ?>',
            subject: '<?php echo $subject; ?>',
            content_id: <?php echo $contentId; ?>,
            quiz_id: <?php echo isset($quizId) ? $quizId : 0; ?>
        };

        fetch('php_functions/save_quiz_result.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(quizData)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Quiz saved:', data);
            window.location.href = 'quizboard_kmeans.php?score=' + score + 
                                '&total=' + quizQuestions.length + 
                                '&source=' + quizData.source + 
                                '&subject=' + encodeURIComponent(quizData.subject) + 
                                '&id=' + quizData.content_id;
        })
        .catch(error => {
            console.error('Error saving quiz:', error);
            window.location.href = 'quizboard_kmeans.php?score=' + score + 
                                '&total=' + quizQuestions.length;
        });
    }
    
    // Start the quiz
    initQuiz();
</script>

</body>
</html>