<?php
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

$successMsg = '';
$errorMsg = '';
$videoData = [
    'title' => '',
    'description' => '',
    'subject' => '',
    'video_url' => '',
    'level' => '' // Added level field
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = validateAndSanitize($_POST, ['title', 'subject', 'level']); // Added level to validation
    if (isset($data['error'])) {
        $errorMsg = $data['error'];
    } else {
        try {
            $pdo->beginTransaction();

            // Insert video
            $stmt = $pdo->prepare(
                "INSERT INTO video_lessons 
                   (title, description, subject, youtube_url, level)
                 VALUES 
                   (:title, :description, :subject, :youtube_url, :level)"
            );
            $stmt->execute([
                ':title' => $data['title'],
                ':description' => trim($_POST['description'] ?? ''),
                ':subject' => $data['subject'],
                ':youtube_url' => trim($_POST['video_url'] ?? ''),
                ':level' => $data['level'] // Added level field
            ]);
            $videoId = $pdo->lastInsertId();

            // Handle integrated quiz if enabled
            if (!empty($_POST['has_quiz']) && !empty($_POST['quiz_title'])) {
                $quizData = [
                    'video_id' => $videoId,
                    'title' => trim($_POST['quiz_title']),
                    'description' => trim($_POST['quiz_description'] ?? ''),
                    'time_stamp' => (int)($_POST['time_stamp'] ?? 0)
                ];

                $quizId = createVideoQuiz($quizData);

                if ($quizId) {
                    // Handle questions
                    $qs = $_POST['question_text'] ?? [];
                    $types = $_POST['question_type'] ?? [];
                    $pts = $_POST['points'] ?? [];

                    foreach ($qs as $i => $qText) {
                        if (trim($qText) === '') continue;

                        $stmt = $pdo->prepare(
                            "INSERT INTO video_questions 
                               (quiz_id, question_text, question_type, points)
                             VALUES 
                               (:quiz_id, :qtxt, :qtype, :points)"
                        );
                        $stmt->execute([
                            ':quiz_id' => $quizId,
                            ':qtxt' => htmlspecialchars(trim($qText)),
                            ':qtype' => $types[$i] ?? 'short-answer',
                            ':points' => (int)($pts[$i] ?? 1)
                        ]);

                        $questionId = $pdo->lastInsertId();

                        // Handle multiple choice options
                        if ($types[$i] === 'multiple-choice' && 
                            isset($_POST['option_text'][$i]) && 
                            is_array($_POST['option_text'][$i])) {

                            $opts = $_POST['option_text'][$i];
                            $correctIndex = (int)($_POST['correct_answer'][$i] ?? -1);

                            foreach ($opts as $j => $optText) {
                                if (trim($optText) === '') continue;

                                $stmt = $pdo->prepare(
                                    "INSERT INTO video_question_options 
                                       (question_id, option_text, is_correct)
                                     VALUES 
                                       (:qid, :otxt, :correct)"
                                );
                                $stmt->execute([
                                    ':qid' => $questionId,
                                    ':otxt' => htmlspecialchars(trim($optText)),
                                    ':correct' => ($j === $correctIndex) ? 1 : 0
                                ]);
                            }
                        }
                    }
                }
            }

            $pdo->commit();
            header("Location: edit_video.php?id={$videoId}&success=1");
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            $errorMsg = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Video Management</title>
    <link rel="stylesheet" href="css/quiz.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/admin_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'includes/sidebar.php'; ?>

<div class="admin-content">
    <h1>Create New Video Lesson</h1>

    <?php if (!empty($successMsg)): ?>
        <div class="status-message success">
            <i class="fas fa-check-circle"></i> <?php echo $successMsg; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errorMsg)): ?>
        <div class="status-message error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $errorMsg; ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <form method="post">
            <div class="form-section">
                <h3>Video Details</h3>

                <label for="title">Title *</label>
                <input type="text" id="title" name="title" required>

                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>

                <label for="video_url">Video URL *</label>
                <input type="url" id="video_url" name="video_url" required>

                <label for="level">Level *</label>
                <select id="level" name="level" required>
                    <option value="">Select Level</option>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                </select>

                <label for="subject">Subject *</label>
                <select id="subject" name="subject" required>
                    <option value="">Select Subject</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Science">Science</option>
                    <option value="English">English</option>
                    <option value="History">History</option>
                    <option value="Geography">Geography</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Art">Art</option>
                    <option value="Music">Music</option>
                    <option value="Physical Education">Physical Education</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-section">
                <h3>Quiz Integration</h3>
                <div class="quiz-toggle">
                    <label for="has_quiz">
                        <input type="checkbox" id="has_quiz" name="has_quiz" value="1">
                        Include a quiz for this video
                    </label>
                </div>

                <div id="quiz_section" style="display: none;">
                    <label for="quiz_title">Quiz Title *</label>
                    <input type="text" id="quiz_title" name="quiz_title">

                    <label for="quiz_description">Quiz Description</label>
                    <textarea id="quiz_description" name="quiz_description"></textarea>

                    <label for="time_stamp">Quiz Time Stamp (seconds)</label>
                    <input type="number" id="time_stamp" name="time_stamp" min="0" value="0">

                    <h4>Questions</h4>
                    <div id="questions_container"></div>

                    <button type="button" id="add_question_btn" class="btn btn-secondary">
                        <i class="fas fa-plus"></i> Add Question
                    </button>
                </div>
            </div>

            <div class="button-group">
                <a href="admin_videos.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Video Lesson
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hasQuizCheckbox = document.getElementById('has_quiz');
    const quizSection = document.getElementById('quiz_section');
    const addQuestionBtn = document.getElementById('add_question_btn');
    const questionsContainer = document.getElementById('questions_container');
    let questionCounter = 0;

    hasQuizCheckbox.addEventListener('change', function() {
        quizSection.style.display = this.checked ? 'block' : 'none';
        if (this.checked && questionsContainer.children.length === 0) {
            addQuestion();
        }
    });

    addQuestionBtn.addEventListener('click', addQuestion);

    function addQuestion() {
        const questionDiv = document.createElement('div');
        questionDiv.className = 'question-item';
        questionDiv.innerHTML = `
            <h5>Question ${questionCounter + 1}</h5>
            <button type="button" class="btn btn-danger remove-question-btn">
                <i class="fas fa-trash-alt"></i>
            </button>

            <label for="question_text_${questionCounter}">Question Text *</label>
            <textarea name="question_text[]" id="question_text_${questionCounter}" required></textarea>

            <div class="row">
                <div class="col">
                    <label for="question_type_${questionCounter}">Question Type *</label>
                    <select name="question_type[]" id="question_type_${questionCounter}" class="question-type-select" required>
                        <option value="multiple-choice">Multiple Choice</option>
                        <option value="true-false">True/False</option>
                        <option value="short-answer">Short Answer</option>
                    </select>
                </div>

                <div class="col">
                    <label for="points_${questionCounter}">Points *</label>
                    <input type="number" name="points[]" id="points_${questionCounter}" min="1" value="1" required>
                </div>
            </div>

            <div class="options-container" id="options_container_${questionCounter}"></div>

            <button type="button" class="btn btn-secondary add-option-btn" style="display: none;">
                <i class="fas fa-plus"></i> Add Option
            </button>
        `;

        questionsContainer.appendChild(questionDiv);

        const typeSelect = questionDiv.querySelector('.question-type-select');
        const optionsContainer = questionDiv.querySelector('.options-container');
        const addOptionBtn = questionDiv.querySelector('.add-option-btn');

        typeSelect.addEventListener('change', function() {
            if (this.value === 'multiple-choice') {
                addOptionBtn.style.display = 'block';
                if (optionsContainer.children.length === 0) {
                    addOption(optionsContainer, questionCounter);
                    addOption(optionsContainer, questionCounter);
                }
            } else {
                addOptionBtn.style.display = 'none';
                optionsContainer.innerHTML = '';
            }
        });

        if (typeSelect.value === 'multiple-choice') {
            addOptionBtn.style.display = 'block';
            addOption(optionsContainer, questionCounter);
            addOption(optionsContainer, questionCounter);
        }

        addOptionBtn.addEventListener('click', () => {
            addOption(optionsContainer, questionCounter);
        });

        questionDiv.querySelector('.remove-question-btn').addEventListener('click', function() {
            questionDiv.remove();
        });

        questionCounter++;
    }

    function addOption(container, qIndex) {
        const optionDiv = document.createElement('div');
        optionDiv.className = 'option-row';
        const oIndex = container.children.length;

        optionDiv.innerHTML = `
            <label>
                <input type="radio" name="correct_answer[${qIndex}]" value="${oIndex}"${oIndex === 0 ? ' checked' : ''}>
                Option ${oIndex + 1}
            </label>
            <input type="text" name="option_text[${qIndex}][]" placeholder="Enter option text" required>
            <button type="button" class="btn btn-danger remove-option-btn">
                <i class="fas fa-times"></i>
            </button>
        `;

        container.appendChild(optionDiv);

        optionDiv.querySelector('.remove-option-btn').addEventListener('click', function() {
            optionDiv.remove();
        });
    }
});
</script>

</body>
</html>