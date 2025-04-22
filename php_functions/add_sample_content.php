<?php
/**
 * Add sample content to the database for testing and demonstration
 * This includes video lessons, reading lessons, and quizzes
 */

// Include database connection
require_once 'db_connection.php';

try {
    // Begin transaction
    $pdo->beginTransaction();
    
    // Add sample subjects
    $subjects = ['Mathematics', 'English', 'Science', 'History', 'Programming'];
    $levels = ['Beginner', 'Intermediate', 'Advanced'];
    
    echo "Adding sample content...\n";
    
    // Sample video lessons
    $videoLessons = [
        [
            'title' => 'Introduction to Algebra',
            'subject' => 'Mathematics',
            'level' => 'Beginner',
            'description' => 'Learn the basics of algebra including variables, expressions, and equations.',
            'youtube_url' => 'https://www.youtube.com/watch?v=NybHckSEQBI',
            'thumbnail_url' => 'https://img.youtube.com/vi/NybHckSEQBI/mqdefault.jpg'
        ],
        [
            'title' => 'Advanced Algebra Concepts',
            'subject' => 'Mathematics',
            'level' => 'Intermediate',
            'description' => 'Dive deeper into algebraic concepts including quadratic equations and functions.',
            'youtube_url' => 'https://www.youtube.com/watch?v=LwCRRUa8yTU',
            'thumbnail_url' => 'https://img.youtube.com/vi/LwCRRUa8yTU/mqdefault.jpg'
        ],
        [
            'title' => 'Introduction to HTML and CSS',
            'subject' => 'Programming',
            'level' => 'Beginner',
            'description' => 'Learn the basics of HTML and CSS for web development.',
            'youtube_url' => 'https://www.youtube.com/watch?v=G3e-cpL7ofc',
            'thumbnail_url' => 'https://img.youtube.com/vi/G3e-cpL7ofc/mqdefault.jpg'
        ],
        [
            'title' => 'Introduction to JavaScript',
            'subject' => 'Programming',
            'level' => 'Beginner',
            'description' => 'Learn the basics of JavaScript programming language.',
            'youtube_url' => 'https://www.youtube.com/watch?v=jS4aFq5-91M',
            'thumbnail_url' => 'https://img.youtube.com/vi/jS4aFq5-91M/mqdefault.jpg'
        ],
        [
            'title' => 'The Basics of Physics',
            'subject' => 'Science',
            'level' => 'Beginner',
            'description' => 'Introduction to fundamental concepts in physics.',
            'youtube_url' => 'https://www.youtube.com/watch?v=ZM8ECpBuQYE',
            'thumbnail_url' => 'https://img.youtube.com/vi/ZM8ECpBuQYE/mqdefault.jpg'
        ]
    ];
    
    // Check if video lessons already exist
    $checkVideos = $pdo->query("SELECT COUNT(*) as count FROM video_lessons");
    $videoCount = $checkVideos->fetch(PDO::FETCH_ASSOC)['count'];
    
    if ($videoCount == 0) {
        // Insert video lessons
        $videoStmt = $pdo->prepare("
            INSERT INTO video_lessons (title, subject, level, description, youtube_url, thumbnail_url, created_at)
            VALUES (:title, :subject, :level, :description, :youtube_url, :thumbnail_url, NOW())
        ");
        
        foreach ($videoLessons as $video) {
            $videoStmt->bindParam(':title', $video['title']);
            $videoStmt->bindParam(':subject', $video['subject']);
            $videoStmt->bindParam(':level', $video['level']);
            $videoStmt->bindParam(':description', $video['description']);
            $videoStmt->bindParam(':youtube_url', $video['youtube_url']);
            $videoStmt->bindParam(':thumbnail_url', $video['thumbnail_url']);
            $videoStmt->execute();
            
            $videoId = $pdo->lastInsertId();
            
            // Create a sample quiz for each video
            $quizTitle = "Quiz on " . $video['title'];
            
            $quizStmt = $pdo->prepare("
                INSERT INTO video_quizzes (video_id, title, description, created_at)
                VALUES (:video_id, :title, :description, NOW())
            ");
            
            $quizStmt->bindParam(':video_id', $videoId);
            $quizStmt->bindParam(':title', $quizTitle);
            $quizStmt->bindParam(':description', $video['description']);
            $quizStmt->execute();
            
            $quizId = $pdo->lastInsertId();
            
            // Add sample questions for this quiz
            $questionsStmt = $pdo->prepare("
                INSERT INTO video_questions (quiz_id, question_text, created_at)
                VALUES (:quiz_id, :question_text, NOW())
            ");
            
            for ($i = 1; $i <= 5; $i++) {
                $questionText = "Sample question $i for " . $video['title'];
                $questionsStmt->bindParam(':quiz_id', $quizId);
                $questionsStmt->bindParam(':question_text', $questionText);
                $questionsStmt->execute();
                
                $questionId = $pdo->lastInsertId();
                
                // Add options for this question
                $optionsStmt = $pdo->prepare("
                    INSERT INTO video_question_options (question_id, option_text, is_correct)
                    VALUES (:question_id, :option_text, :is_correct)
                ");
                
                for ($j = 1; $j <= 4; $j++) {
                    $optionText = "Option $j for question $i";
                    $isCorrect = ($j == 1) ? 1 : 0; // Make first option correct for simplicity
                    
                    $optionsStmt->bindParam(':question_id', $questionId);
                    $optionsStmt->bindParam(':option_text', $optionText);
                    $optionsStmt->bindParam(':is_correct', $isCorrect);
                    $optionsStmt->execute();
                }
            }
        }
        
        echo "Added " . count($videoLessons) . " video lessons with quizzes and questions.\n";
    } else {
        echo "Video lessons already exist. Skipping sample content creation.\n";
    }
    
    // Sample reading lessons
    $readingLessons = [
        [
            'title' => 'Introduction to Writing Essays',
            'subject' => 'English',
            'level' => 'Beginner',
            'description' => 'Learn the basics of essay writing including structure and organization.',
            'content' => '<p>An essay is a common form of academic writing that you\'ll likely be asked to do in multiple classes. Before you start writing your essay, make sure you understand the details of the assignment so that you know how to approach the essay and what your focus should be.</p><p>Once you\'ve chosen a topic, do some research and narrow down the main argument(s) you\'d like to make. From there, you\'ll need to write an outline and flesh out your essay, which should consist of an introduction, body, and conclusion. After your essay is drafted, spend some time revising it to ensure your writing is as strong as possible.</p><h3>Essay Structure</h3><p>The typical essay format consists of an introduction, a body, and a conclusion. The introduction should grab the reader\'s attention and provide background information on the topic. The body paragraphs should each focus on a single idea that supports your thesis statement. The conclusion should summarize your main points and restate your thesis in a new way.</p>'
        ],
        [
            'title' => 'World War II Overview',
            'subject' => 'History',
            'level' => 'Intermediate',
            'description' => 'An overview of the causes, major events, and aftermath of World War II.',
            'content' => '<p>World War II was a global war that lasted from 1939 to 1945. It involved the vast majority of the world\'s countries—including all of the great powers—forming two opposing military alliances: the Allies and the Axis. In a state of total war, directly involving more than 100 million personnel from more than 30 countries, the major participants threw their entire economic, industrial, and scientific capabilities behind the war effort, blurring the distinction between civilian and military resources.</p><p>World War II was the deadliest conflict in human history, resulting in 70 to 85 million fatalities, with more civilians than military personnel killed. Tens of millions of people died due to genocides (including the Holocaust), starvation, massacres, and disease. Aircraft played a major role in the conflict, including in strategic bombing of population centres, the development of nuclear weapons, and the only two uses of such in warfare.</p><h3>Causes of World War II</h3><p>The causes of World War II can be traced back to the Treaty of Versailles, which ended World War I. The treaty placed blame for the war on Germany and imposed harsh economic penalties, which led to economic collapse in Germany. This, combined with the rise of fascism in Europe, especially in Germany under Adolf Hitler, set the stage for World War II.</p>'
        ],
        [
            'title' => 'Basic HTML Tutorial',
            'subject' => 'Programming',
            'level' => 'Beginner',
            'description' => 'Learn the basics of HTML including tags, attributes, and document structure.',
            'content' => '<p>HTML (HyperText Markup Language) is the standard markup language for documents designed to be displayed in a web browser. It can be assisted by technologies such as Cascading Style Sheets (CSS) and scripting languages such as JavaScript.</p><p>HTML consists of a series of elements, which you use to enclose, or wrap, different parts of the content to make it appear a certain way, or act a certain way. The enclosing tags can make a word or image hyperlink to somewhere else, can italicize words, can make the font bigger or smaller, and so on.</p><h3>Basic HTML Document Structure</h3><p>A basic HTML document structure looks like this:</p><pre>&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;title&gt;Page Title&lt;/title&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;h1&gt;My First Heading&lt;/h1&gt;\n    &lt;p&gt;My first paragraph.&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;</pre><p>The &lt;!DOCTYPE html&gt; declaration defines that this document is an HTML5 document. The &lt;html&gt; element is the root element of an HTML page. The &lt;head&gt; element contains meta information about the HTML page. The &lt;title&gt; element specifies a title for the HTML page (which is shown in the browser\'s title bar or in the page\'s tab). The &lt;body&gt; element defines the document\'s body, and is a container for all the visible contents, such as headings, paragraphs, images, hyperlinks, tables, lists, etc.</p>'
        ]
    ];
    
    // Check if reading lessons already exist
    $checkLessons = $pdo->query("SELECT COUNT(*) as count FROM lessons");
    $lessonCount = $checkLessons->fetch(PDO::FETCH_ASSOC)['count'];
    
    if ($lessonCount == 0) {
        // Insert reading lessons
        $lessonStmt = $pdo->prepare("
            INSERT INTO lessons (title, subject, level, description, content, created_at)
            VALUES (:title, :subject, :level, :description, :content, NOW())
        ");
        
        foreach ($readingLessons as $lesson) {
            $lessonStmt->bindParam(':title', $lesson['title']);
            $lessonStmt->bindParam(':subject', $lesson['subject']);
            $lessonStmt->bindParam(':level', $lesson['level']);
            $lessonStmt->bindParam(':description', $lesson['description']);
            $lessonStmt->bindParam(':content', $lesson['content']);
            $lessonStmt->execute();
            
            $lessonId = $pdo->lastInsertId();
            
            // Create a sample quiz for each lesson
            $quizTitle = "Quiz on " . $lesson['title'];
            
            $quizStmt = $pdo->prepare("
                INSERT INTO quizzes (lesson_id, title, description, created_at)
                VALUES (:lesson_id, :title, :description, NOW())
            ");
            
            $quizStmt->bindParam(':lesson_id', $lessonId);
            $quizStmt->bindParam(':title', $quizTitle);
            $quizStmt->bindParam(':description', $lesson['description']);
            $quizStmt->execute();
            
            $quizId = $pdo->lastInsertId();
            
            // Add sample questions for this quiz
            $questionsStmt = $pdo->prepare("
                INSERT INTO questions (quiz_id, question_text, created_at)
                VALUES (:quiz_id, :question_text, NOW())
            ");
            
            for ($i = 1; $i <= 5; $i++) {
                $questionText = "Sample question $i for " . $lesson['title'];
                $questionsStmt->bindParam(':quiz_id', $quizId);
                $questionsStmt->bindParam(':question_text', $questionText);
                $questionsStmt->execute();
                
                $questionId = $pdo->lastInsertId();
                
                // Add options for this question
                $optionsStmt = $pdo->prepare("
                    INSERT INTO options (question_id, option_text, is_correct)
                    VALUES (:question_id, :option_text, :is_correct)
                ");
                
                for ($j = 1; $j <= 4; $j++) {
                    $optionText = "Option $j for question $i";
                    $isCorrect = ($j == 1) ? 1 : 0; // Make first option correct for simplicity
                    
                    $optionsStmt->bindParam(':question_id', $questionId);
                    $optionsStmt->bindParam(':option_text', $optionText);
                    $optionsStmt->bindParam(':is_correct', $isCorrect);
                    $optionsStmt->execute();
                }
            }
        }
        
        echo "Added " . count($readingLessons) . " reading lessons with quizzes and questions.\n";
    } else {
        echo "Reading lessons already exist. Skipping sample content creation.\n";
    }
    
    // Check if questions and options tables exist, create if not
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS questions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            quiz_id INT NOT NULL,
            question_text TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX (quiz_id)
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS options (
            id INT AUTO_INCREMENT PRIMARY KEY,
            question_id INT NOT NULL,
            option_text TEXT NOT NULL,
            is_correct TINYINT(1) DEFAULT 0,
            INDEX (question_id)
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS video_questions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            quiz_id INT NOT NULL,
            question_text TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX (quiz_id)
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS video_question_options (
            id INT AUTO_INCREMENT PRIMARY KEY,
            question_id INT NOT NULL,
            option_text TEXT NOT NULL,
            is_correct TINYINT(1) DEFAULT 0,
            INDEX (question_id)
        )
    ");
    
    // Commit transaction
    $pdo->commit();
    echo "Sample content setup completed successfully.\n";
    
} catch (PDOException $e) {
    // Rollback on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    echo "Error setting up sample content: " . $e->getMessage() . "\n";
}
?>