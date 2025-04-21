
<?php
// Include database connection
require_once 'db_connection.php';

/**
 * Create a new lesson
 * 
 * @param array $data Lesson data
 * @return int|bool The ID of the newly created lesson or false on failure
 */
function createLesson($data) {
    global $pdo;
    
    try {
        $sql = "INSERT INTO lessons (title, description, level, subject, cover_photo) 
                VALUES (:title, :description, :level, :subject, :cover_photo)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':level' => $data['level'],
            ':subject' => $data['subject'],
            ':cover_photo' => $data['cover_photo'] ?? null
        ]);
        
        return $pdo->lastInsertId();
        
    } catch (PDOException $e) {
        error_log("Error creating lesson: " . $e->getMessage());
        return false;
    }
}

/**
 * Update an existing lesson
 * 
 * @param int $id Lesson ID
 * @param array $data Updated lesson data
 * @return bool Success or failure
 */
function updateLesson($id, $data) {
    global $pdo;
    
    try {
        $sql = "UPDATE lessons 
                SET title = :title, 
                    description = :description, 
                    level = :level, 
                    subject = :subject";
        
        $params = [
            ':id' => $id,
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':level' => $data['level'],
            ':subject' => $data['subject']
        ];
        
        if (isset($data['cover_photo']) && !empty($data['cover_photo'])) {
            $sql .= ", cover_photo = :cover_photo";
            $params[':cover_photo'] = $data['cover_photo'];
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
        
    } catch (PDOException $e) {
        error_log("Error updating lesson: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete a lesson and all related content
 * 
 * @param int $id Lesson ID
 * @return bool Success or failure
 */
function deleteLesson($id) {
    global $pdo;
    
    try {
        $sql = "DELETE FROM lessons WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
        
    } catch (PDOException $e) {
        error_log("Error deleting lesson: " . $e->getMessage());
        return false;
    }
}

/**
 * Get all lessons
 * 
 * @return array List of lessons
 */
function getAllLessons() {
    global $pdo;
    
    try {
        $sql = "SELECT * FROM lessons ORDER BY date_created DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
        
    } catch (PDOException $e) {
        error_log("Error retrieving lessons: " . $e->getMessage());
        return [];
    }
}

/**
 * Get a single lesson by ID
 * 
 * @param int $id Lesson ID
 * @return array|bool Lesson data or false if not found
 */
function createVideoLesson($data) {
    global $pdo;
    
    try {
        $sql = "INSERT INTO video_lessons (title, description, youtube_url, level, subject, thumbnail_url) 
                VALUES (:title, :description, :youtube_url, :level, :subject, :thumbnail_url)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? '',
            ':youtube_url' => $data['youtube_url'],
            ':level' => $data['level'] ?? '',
            ':subject' => $data['subject'],
            ':thumbnail_url' => $data['thumbnail_url'] ?? ''
        ]);
        
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("Error creating video lesson: " . $e->getMessage());
        return false;
    }
}

function getVideoQuizById($id) {
    global $pdo;
    
    try {
    // 1) Fetch quiz + total points in one query
    $sql = "
        SELECT 
          vq.*, 
          COALESCE(SUM(vqu.points), 0) AS total_points 
        FROM video_quizzes AS vq
        LEFT JOIN video_questions AS vqu 
          ON vq.id = vqu.quiz_id
        WHERE vq.id = :id
        GROUP BY vq.id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $quiz = $stmt->fetch();

    if ($quiz) {
        // 2) Fetch all questions for this quiz
        $sql = "
            SELECT * 
              FROM video_questions 
             WHERE quiz_id = :quiz_id 
          ORDER BY id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':quiz_id' => $id]);
        $questions = $stmt->fetchAll();

        // 3) For each multiple‑choice question, fetch its options
        foreach ($questions as $key => $question) {
            if ($question['question_type'] === 'multiple-choice') {
                $sql = "
                    SELECT * 
                      FROM video_question_options 
                     WHERE question_id = :question_id 
                  ORDER BY id
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':question_id' => $question['id']]);
                $questions[$key]['options'] = $stmt->fetchAll();
            }
        }
        
        // 4) Attach questions back to quiz
        $quiz['questions'] = $questions;
    }
        return $quiz;
        
    } catch (PDOException $e) {
        error_log("Error retrieving video quiz: " . $e->getMessage());
        return false;
    }
}

function getVideoLessonById($id) {
    global $pdo;
    
    try {
        $sql = "SELECT * FROM video_lessons WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $video = $stmt->fetch();
        
        if ($video) {
            // Get associated quizzes with questions and options
            $sql = "SELECT * FROM video_quizzes WHERE video_id = :video_id ORDER BY time_stamp ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':video_id' => $id]);
            $quizzes = $stmt->fetchAll();
            
            foreach ($quizzes as $key => $quiz) {
                $quizzes[$key] = getVideoQuizById($quiz['id']);
            }
            
            $video['quizzes'] = $quizzes;
        }
        
        return $video;
        
    } catch (PDOException $e) {
        error_log("Error retrieving video lesson: " . $e->getMessage());
        return false;
    }
}

function createVideoQuiz($data) {
    global $pdo;
    
    try {
        $sql = "INSERT INTO video_quizzes (video_id, title, description, time_stamp) 
                VALUES (:video_id, :title, :description, :time_stamp)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':video_id' => $data['video_id'],
            ':title' => $data['title'],
            ':description' => $data['description'] ?? '',
            ':time_stamp' => $data['time_stamp'] ?? 0
        ]);
        
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("Error creating video quiz: " . $e->getMessage());
        return false;
    }
}

function getLessonById($id) {
    global $pdo;
    
    try {
        $sql = "SELECT * FROM lessons WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $lesson = $stmt->fetch();
        
        if ($lesson) {
            // Get associated quizzes
            $sql = "SELECT * FROM quizzes WHERE lesson_id = :lesson_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':lesson_id' => $id]);
            $lesson['quizzes'] = $stmt->fetchAll();
            
            // Get associated materials
            $sql = "SELECT * FROM lesson_materials WHERE lesson_id = :lesson_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':lesson_id' => $id]);
            $lesson['materials'] = $stmt->fetchAll();
        }
        
        return $lesson;
        
    } catch (PDOException $e) {
        error_log("Error retrieving lesson: " . $e->getMessage());
        return false;
    }
}

/**
 * Create a new quiz
 * 
 * @param array $data Quiz data
 * @return int|bool The ID of the newly created quiz or false on failure
 */
function createQuiz($data) {
    global $pdo;
    
    try {
        $sql = "INSERT INTO quizzes (lesson_id, title, description) 
                VALUES (:lesson_id, :title, :description)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':lesson_id' => $data['lesson_id'],
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null
        ]);
        
        return $pdo->lastInsertId();
        
    } catch (PDOException $e) {
        error_log("Error creating quiz: " . $e->getMessage());
        return false;
    }
}

/**
 * Update quiz's total points
 * 
 * @param int $quizId Quiz ID
 * @return bool Success or failure
 */
function updateQuizPoints($quizId) {
    global $pdo;
    
    try {
        $sql = "UPDATE quizzes SET total_points = (
                SELECT COALESCE(SUM(points), 0) FROM questions WHERE quiz_id = :quiz_id
                ) WHERE id = :quiz_id";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':quiz_id' => $quizId]);
        
    } catch (PDOException $e) {
        error_log("Error updating quiz points: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete a quiz
 * 
 * @param int $id Quiz ID
 * @return bool Success or failure
 */
function deleteQuiz($id) {
    global $pdo;
    
    try {
        $sql = "DELETE FROM quizzes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
        
    } catch (PDOException $e) {
        error_log("Error deleting quiz: " . $e->getMessage());
        return false;
    }
}

/**
 * Get a quiz by ID with all its questions and options
 * 
 * @param int $id Quiz ID
 * @return array|bool Quiz data or false if not found
 */
function getQuizById($id) {
    global $pdo;
    
    try {
        // Get quiz data
        $sql = "SELECT * FROM quizzes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $quiz = $stmt->fetch();
        
        if ($quiz) {
            // Get questions
            $sql = "SELECT * FROM questions WHERE quiz_id = :quiz_id ORDER BY id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':quiz_id' => $id]);
            $questions = $stmt->fetchAll();
            
            // For each question, get options
            foreach ($questions as $key => $question) {
                $sql = "SELECT * FROM options WHERE question_id = :question_id ORDER BY id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':question_id' => $question['id']]);
                $questions[$key]['options'] = $stmt->fetchAll();
            }
            
            $quiz['questions'] = $questions;
        }
        
        return $quiz;
        
    } catch (PDOException $e) {
        error_log("Error retrieving quiz: " . $e->getMessage());
        return false;
    }
}

/**
 * Create a new question
 * 
 * @param array $data Question data
 * @return int|bool The ID of the newly created question or false on failure
 */
function createQuestion($data) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        $sql = "INSERT INTO questions (quiz_id, question_text, question_type, points) 
                VALUES (:quiz_id, :question_text, :question_type, :points)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':quiz_id' => $data['quiz_id'],
            ':question_text' => $data['question_text'],
            ':question_type' => $data['question_type'],
            ':points' => $data['points'] ?? 1
        ]);
        
        $questionId = $pdo->lastInsertId();
        
        // Update quiz total points
        updateQuizPoints($data['quiz_id']);
        
        $pdo->commit();
        return $questionId;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Error creating question: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete a question
 * 
 * @param int $id Question ID
 * @return bool Success or failure
 */
function deleteQuestion($id) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Get the quiz_id before deleting
        $sql = "SELECT quiz_id FROM questions WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $quizId = $stmt->fetchColumn();
        
        // Delete the question
        $sql = "DELETE FROM questions WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        // Update quiz total points
        if ($quizId) {
            updateQuizPoints($quizId);
        }
        
        $pdo->commit();
        return true;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Error deleting question: " . $e->getMessage());
        return false;
    }
}

/**
 * Create a new option for a question
 * 
 * @param array $data Option data
 * @return int|bool The ID of the newly created option or false on failure
 */
function createOption($data) {
    global $pdo;
    
    try {
        $sql = "INSERT INTO options (question_id, option_text, is_correct) 
                VALUES (:question_id, :option_text, :is_correct)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':question_id' => $data['question_id'],
            ':option_text' => $data['option_text'],
            ':is_correct' => $data['is_correct'] ?? false
        ]);
        
        return $pdo->lastInsertId();
        
    } catch (PDOException $e) {
        error_log("Error creating option: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete an option
 * 
 * @param int $id Option ID
 * @return bool Success or failure
 */
function deleteOption($id) {
    global $pdo;
    
    try {
        $sql = "DELETE FROM options WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
        
    } catch (PDOException $e) {
        error_log("Error deleting option: " . $e->getMessage());
        return false;
    }
}

/**
 * Upload a file
 * 
 * @param array $file $_FILES array item
 * @param string $targetDir Directory to save the file
 * @return string|bool The file path on success or false on failure
 */
function uploadFile($file, $targetDir = 'uploads/') {
    // Create directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    
    // Generate unique filename
    $fileName = uniqid() . '_' . basename($file['name']);
    $targetPath = $targetDir . $fileName;
    
    // Check if file is an actual image
    if (strpos($file['type'], 'image/') === 0) {
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            return false;
        }
    }
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $targetPath;
    }
    
    return false;
}

/**
 * Add lesson material
 * 
 * @param array $data Material data
 * @return int|bool The ID of the newly created material or false on failure
 */
function addLessonMaterial($data) {
    global $pdo;
    
    try {
        $sql = "INSERT INTO lesson_materials (lesson_id, title, file_path, material_type) 
                VALUES (:lesson_id, :title, :file_path, :material_type)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':lesson_id' => $data['lesson_id'],
            ':title' => $data['title'],
            ':file_path' => $data['file_path'] ?? null,
            ':material_type' => $data['material_type'] ?? 'document'
        ]);
        
        return $pdo->lastInsertId();
        
    } catch (PDOException $e) {
        error_log("Error adding lesson material: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete lesson material
 * 
 * @param int $id Material ID
 * @return bool Success or failure
 */
function deleteLessonMaterial($id) {
    global $pdo;
    
    try {
        // First, get the file path to delete the actual file
        $sql = "SELECT file_path FROM lesson_materials WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $filePath = $stmt->fetchColumn();
        
        // Delete from database
        $sql = "DELETE FROM lesson_materials WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([':id' => $id]);
        
        // Delete file if it exists
        if ($success && $filePath && file_exists($filePath)) {
            unlink($filePath);
        }
        
        return $success;
        
    } catch (PDOException $e) {
        error_log("Error deleting lesson material: " . $e->getMessage());
        return false;
    }
}

/**
 * Handle form validation and sanitization
 * 
 * @param array $data Form data
 * @param array $required List of required fields
 * @return array Sanitized data or array with 'error' key if validation fails
 */
function validateAndSanitize($data, $required = []) {
    $sanitized = [];
    $errors = [];
    
    foreach ($data as $key => $value) {
        // Skip validation for arrays except required check
        if (is_array($value)) {
            $sanitized[$key] = $value;
            continue;
        }

        // Check required fields
        if (in_array($key, $required) && empty($value)) {
            $errors[] = ucfirst($key) . " is required.";
            continue;
        }
        
        // Sanitize based on field type
        switch ($key) {
            case 'id':
            case 'lesson_id':
            case 'quiz_id':
            case 'question_id':
            case 'points':
                $sanitized[$key] = filter_var($value, FILTER_VALIDATE_INT);
                if ($sanitized[$key] === false) {
                    $errors[] = ucfirst($key) . " must be a valid integer.";
                }
                break;
                
            case 'is_correct':
                $sanitized[$key] = (bool)$value;
                break;
                
            case 'description':
            case 'question_text':
            case 'option_text':
                $sanitized[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
                break;
                
            default:
                $sanitized[$key] = trim($value);
                break;
        }
    }
    
    if (!empty($errors)) {
        return ['error' => implode(' ', $errors)];
    }
    
    return $sanitized;
}
?>
