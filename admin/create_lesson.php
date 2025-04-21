<?php
// create_lesson.php

// 1. Bootstrap & Helpers
require_once 'includes/db_connection.php';  // must set up $pdo (PDO)
require_once 'includes/functions.php';      // for validateAndSanitize()

$successMsg = '';
$errorMsg   = '';
$lessonData = [
    'title'       => '',
    'description' => '',
    'level'       => '',
    'subject'     => '',
    'cover_photo' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate basic lesson fields
    $data = validateAndSanitize($_POST, ['title', 'subject']);
    if (isset($data['error'])) {
        $errorMsg = $data['error'];
    } else {
        // Populate lessonData
        $lessonData['title']       = $data['title'];
        $lessonData['description'] = trim($_POST['description'] ?? '');
        $lessonData['level']       = $_POST['level'] ?? '';
        $lessonData['subject']     = $data['subject'];

        // Handle cover photo upload
        if (!empty($_FILES['cover_photo']['tmp_name']) && 
            $_FILES['cover_photo']['error'] === UPLOAD_ERR_OK) {
            if (!is_dir('uploads/covers')) {
                mkdir('uploads/covers', 0755, true);
            }
            $fname = uniqid() . '_' . basename($_FILES['cover_photo']['name']);
            $dest  = 'uploads/covers/' . $fname;
            if (move_uploaded_file($_FILES['cover_photo']['tmp_name'], $dest)) {
                $lessonData['cover_photo'] = $dest;
            }
        }

        try {
            // Begin transaction
            $pdo->beginTransaction();

            // 2. Insert lesson
            $stmt = $pdo->prepare(
                "INSERT INTO lessons 
                   (title, description, level, subject, cover_photo)
                 VALUES
                   (:title, :description, :level, :subject, :cover_photo)"
            );
            $stmt->execute([
                ':title'       => $lessonData['title'],
                ':description' => $lessonData['description'] ?: null,
                ':level'       => $lessonData['level']   ?: null,
                ':subject'     => $lessonData['subject'],
                ':cover_photo' => $lessonData['cover_photo'] ?: null,
            ]);
            $lessonId = $pdo->lastInsertId();

            // 3. If quiz section is toggled on, insert quiz + questions + options
            if (!empty($_POST['has_quiz']) && !empty($_POST['quiz_title'])) {
                // Insert quiz
                $stmt = $pdo->prepare(
                    "INSERT INTO quizzes 
                       (lesson_id, title, description)
                     VALUES
                       (:lesson_id, :qtitle, :qdesc)"
                );
                $stmt->execute([
                    ':lesson_id' => $lessonId,
                    ':qtitle'    => trim($_POST['quiz_title']),
                    ':qdesc'     => trim($_POST['quiz_description'] ?? ''),
                ]);
                $quizId = $pdo->lastInsertId();

                // Loop questions[]
                $qs    = $_POST['question_text']  ?? [];
                $types = $_POST['question_type']  ?? [];
                $pts   = $_POST['points']         ?? [];
                foreach ($qs as $i => $qText) {
                    $qText = trim($qText);
                    if ($qText === '') {
                        continue;
                    }
                    $stmtQ = $pdo->prepare(
                        "INSERT INTO questions
                           (quiz_id, question_text, question_type, points)
                         VALUES
                           (:qid, :qtxt, :qtype, :qpts)"
                    );
                    $stmtQ->execute([
                        ':qid'   => $quizId,
                        ':qtxt'  => htmlspecialchars($qText, ENT_QUOTES, 'UTF-8'),
                        ':qtype' => $types[$i] ?? 'short-answer',
                        ':qpts'  => (int) ($pts[$i] ?? 1),
                    ]);
                    $questionId = $pdo->lastInsertId();

                    // If MCQ, insert its options[]
                    if ($types[$i] === 'multiple-choice'
                        && isset($_POST['option_text'][$i])
                        && is_array($_POST['option_text'][$i])) {
                        $opts   = $_POST['option_text'][$i];
                        $correctIndex = (int) ($_POST['correct_answer'][$i] ?? -1);
                        foreach ($opts as $j => $optText) {
                            $optText = trim($optText);
                            if ($optText === '') continue;
                            $stmtO = $pdo->prepare(
                                "INSERT INTO options
                                   (question_id, option_text, is_correct)
                                 VALUES
                                   (:qid_o, :otxt, :isc)"
                            );
                            $stmtO->execute([
                                ':qid_o' => $questionId,
                                ':otxt'  => htmlspecialchars($optText, ENT_QUOTES, 'UTF-8'),
                                ':isc'   => ($j === $correctIndex) ? 1 : 0,
                            ]);
                        }
                    }
                }

                // 4. Update quiz total_points with unique placeholders
                $sql = "
                  UPDATE quizzes
                     SET total_points = (
                       SELECT COALESCE(SUM(points),0)
                         FROM questions 
                        WHERE quiz_id = :sum_qid
                     )
                   WHERE id = :where_qid
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':sum_qid'   => $quizId,
                    ':where_qid' => $quizId,
                ]);
            }

            // Commit all
            $pdo->commit();
            $successMsg = "Lesson&nbsp;+&nbsp;quiz&nbsp;+&nbsp;questions saved successfully!";
            header("Location: edit_lesson.php?id={$lessonId}&success=1");
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
    <title>Admin - Lesson Management</title>
    <link rel="stylesheet" href="css/quiz.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/admin_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'includes/sidebar.php'; ?>

    <div class="admin-content">
        <h1>Create New Lesson</h1>
        
        <!-- Status Messages -->
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
        
        <!-- Lesson Form -->
        <div class="container">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create_lesson">
                
                <div class="form-section">
                    <h3>Lesson Details</h3>
                    
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($lessonData['title']); ?>" required>
                    
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($lessonData['description']); ?></textarea>
                    
                    <div class="row">
                        <div class="col">
                            <label for="level">Level</label>
                            <select id="level" name="level">
                                <option value="">Select Level</option>
                                <option value="Beginner" <?php if ($lessonData['level'] === 'Beginner') echo 'selected'; ?>>Beginner</option>
                                <option value="Intermediate" <?php if ($lessonData['level'] === 'Intermediate') echo 'selected'; ?>>Intermediate</option>
                                <option value="Advanced" <?php if ($lessonData['level'] === 'Advanced') echo 'selected'; ?>>Advanced</option>
                            </select>
                        </div>
                        
                        <div class="col">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required>
                                <option value="">Select Subject</option>
                                <option value="Mathematics" <?php if ($lessonData['subject'] === 'Mathematics') echo 'selected'; ?>>Mathematics</option>
                                <option value="Science" <?php if ($lessonData['subject'] === 'Science') echo 'selected'; ?>>Science</option>
                                <option value="English" <?php if ($lessonData['subject'] === 'English') echo 'selected'; ?>>English</option>
                                <option value="History" <?php if ($lessonData['subject'] === 'History') echo 'selected'; ?>>History</option>
                                <option value="Geography" <?php if ($lessonData['subject'] === 'Geography') echo 'selected'; ?>>Geography</option>
                                <option value="Computer Science" <?php if ($lessonData['subject'] === 'Computer Science') echo 'selected'; ?>>Computer Science</option>
                                <option value="Art" <?php if ($lessonData['subject'] === 'Art') echo 'selected'; ?>>Art</option>
                                <option value="Music" <?php if ($lessonData['subject'] === 'Music') echo 'selected'; ?>>Music</option>
                                <option value="Physical Education" <?php if ($lessonData['subject'] === 'Physical Education') echo 'selected'; ?>>Physical Education</option>
                                <option value="Other" <?php if ($lessonData['subject'] === 'Other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <label for="cover_photo">Cover Photo</label>
                    <div class="file-upload-area">
                        <input type="file" id="cover_photo" name="cover_photo" accept="image/*">
                        <p>Drag and drop an image here, or click to select a file</p>
                    </div>
                    
                    <div id="preview_container" style="display: none;">
                        <img id="preview_image" class="preview-image">
                    </div>
                </div>
                
                <!-- Integrated Quiz Section -->
                <div class="form-section">
                    <h3>Quiz Details</h3>
                    <p>Add a quiz to this lesson (optional)</p>
                    
                    <div class="quiz-toggle">
                        <label for="has_quiz">
                            <input type="checkbox" id="has_quiz" name="has_quiz" value="1"> Include a quiz with this lesson
                        </label>
                    </div>
                    
                    <div id="quiz_section" style="display: none;">
                        <label for="quiz_title">Quiz Title</label>
                        <input type="text" id="quiz_title" name="quiz_title">
                        
                        <label for="quiz_description">Quiz Description</label>
                        <textarea id="quiz_description" name="quiz_description"></textarea>
                        
                        <h4>Questions</h4>
                        <div id="questions_container">
                            <!-- Question template will be added dynamically -->
                        </div>
                        
                        <button type="button" id="add_question_btn" class="btn btn-secondary">
                            <i class="fas fa-plus"></i> Add Question
                        </button>
                    </div>
                </div>
                
                <div class="button-group">
                    <a href="admin_lessons.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Lesson
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Templates for dynamic content -->
        <template id="question_template">
            <div class="question-item">
                <h5>Question {num}</h5>
                <button type="button" class="btn btn-danger remove-question-btn">
                    <i class="fas fa-trash-alt"></i>
                </button>
                
                <label for="question_text_{num}">Question Text *</label>
                <textarea name="question_text[]" id="question_text_{num}" required></textarea>
                
                <div class="row">
                    <div class="col">
                        <label for="question_type_{num}">Question Type *</label>
                        <select name="question_type[]" id="question_type_{num}" class="question-type-select" required>
                            <option value="multiple-choice">Multiple Choice</option>
                            <option value="short-answer">Short Answer</option>
                        </select>
                    </div>
                    
                    <div class="col">
                        <label for="points_{num}">Points *</label>
                        <input type="number" name="points[]" id="points_{num}" min="1" value="1" required>
                    </div>
                </div>
                
                <div class="options-container" id="options_container_{num}">
                    <!-- Options will be added here for multiple choice questions -->
                </div>
                
                <button type="button" class="btn btn-secondary add-option-btn" data-question="{num}" style="display: none;">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>
        </template>
        
        <template id="option_template">
            <div class="option-row">
                <label>
                    <input type="radio" name="correct_answer[{qnum}]" value="{onum}"> 
                    Option {onum+1}
                </label>
                <input type="text" name="option_text[{qnum}][]" placeholder="Enter option text" required>
                <button type="button" class="btn btn-danger remove-option-btn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </template>
    </div>
    
    <script>
        // Preview uploaded image
        const coverPhotoInput = document.getElementById('cover_photo');
        const previewContainer = document.getElementById('preview_container');
        const previewImage = document.getElementById('preview_image');
        
        coverPhotoInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    previewImage.setAttribute('src', this.result);
                    previewContainer.style.display = 'block';
                });
                
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
        
        // Drag and drop functionality
        const uploadArea = document.querySelector('.file-upload-area');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            uploadArea.classList.add('highlight');
        }
        
        function unhighlight() {
            uploadArea.classList.remove('highlight');
        }
        
        uploadArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            coverPhotoInput.files = files;
            
            // Trigger change event
            const event = new Event('change');
            coverPhotoInput.dispatchEvent(event);
        }
        
        // Quiz functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Quiz toggle
            const hasQuizCheckbox = document.getElementById('has_quiz');
            const quizSection = document.getElementById('quiz_section');
            
            hasQuizCheckbox.addEventListener('change', function() {
                quizSection.style.display = this.checked ? 'block' : 'none';
            });
            
            // Question management
            const addQuestionBtn = document.getElementById('add_question_btn');
            const questionsContainer = document.getElementById('questions_container');
            const questionTemplate = document.getElementById('question_template').innerHTML;
            const optionTemplate = document.getElementById('option_template').innerHTML;
            let questionCounter = 0;
            
            // Add question button functionality
            addQuestionBtn.addEventListener('click', function() {
                addQuestion();
            });
            
            // Add a new question
            function addQuestion() {
                // Replace placeholders in the template with actual values
                const questionHtml = questionTemplate
                    .replace(/{num}/g, questionCounter);
                
                // Create a div element to hold the question
                const questionDiv = document.createElement('div');
                questionDiv.innerHTML = questionHtml;
                questionDiv.classList.add('question-item');
                questionDiv.dataset.questionIndex = questionCounter;
                
                // Add the question to the container
                questionsContainer.appendChild(questionDiv);
                
                // Set up event listeners for the new question
                setupQuestionEventListeners(questionDiv, questionCounter);
                
                // Increment question counter for next addition
                questionCounter++;
            }
            
            // Set up event listeners for a question
            function setupQuestionEventListeners(questionDiv, questionIndex) {
                // Type selection change
                const typeSelect = questionDiv.querySelector('.question-type-select');
                const optionsContainer = questionDiv.querySelector('.options-container');
                const addOptionBtn = questionDiv.querySelector('.add-option-btn');
                
                typeSelect.addEventListener('change', function() {
                    if (this.value === 'multiple-choice') {
                        addOptionBtn.style.display = 'block';
                        // Add initial options
                        if (optionsContainer.children.length === 0) {
                            addOption(optionsContainer, questionIndex, 0);
                            addOption(optionsContainer, questionIndex, 1);
                        }
                    } else {
                        addOptionBtn.style.display = 'none';
                        // Clear options for non-multiple choice questions
                        optionsContainer.innerHTML = '';
                    }
                });
                
                // Initial trigger for type selection
                if (typeSelect.value === 'multiple-choice') {
                    addOptionBtn.style.display = 'block';
                    // Add initial options
                    addOption(optionsContainer, questionIndex, 0);
                    addOption(optionsContainer, questionIndex, 1);
                }
                
                // Add option button
                addOptionBtn.addEventListener('click', function() {
                    addOption(optionsContainer, questionIndex, optionsContainer.children.length);
                });
                
                // Remove question button
                const removeQuestionBtn = questionDiv.querySelector('.remove-question-btn');
                removeQuestionBtn.addEventListener('click', function() {
                    questionDiv.remove();
                });
            }
            
            // Add a new option to a question
            function addOption(container, questionIndex, optionIndex) {
                // Replace placeholders in the template
                const optionHtml = optionTemplate
                    .replace(/{qnum}/g, questionIndex)
                    .replace(/{onum}/g, optionIndex)
                    .replace(/{onum\+1}/g, optionIndex + 1);
                
                // Create a div for the option
                const optionDiv = document.createElement('div');
                optionDiv.innerHTML = optionHtml;
                optionDiv.classList.add('option-item');
                
                // Add to container
                container.appendChild(optionDiv);
                
                // Set up remove option button
                const removeOptionBtn = optionDiv.querySelector('.remove-option-btn');
                removeOptionBtn.addEventListener('click', function() {
                    optionDiv.remove();
                });
                
                // If this is the first option, make it selected by default
                if (optionIndex === 0) {
                    const radioBtn = optionDiv.querySelector('input[type="radio"]');
                    radioBtn.checked = true;
                }
            }
            
            // Add first question by default when quiz is enabled
            hasQuizCheckbox.addEventListener('change', function() {
                if (this.checked && questionsContainer.children.length === 0) {
                    addQuestion();
                }
            });
        });
    </script>
    

</body>
</html>