<?php
$host = 'localhost';
$user = 'root';
$pass = '';

try {
    // Create connection without database selected
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS lumin_admin";
    $pdo->exec($sql);

    // Select the database
    $pdo->exec("USE lumin_admin");
    
// Create users table first (since other tables reference it)
$pdo->exec("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    age INT(3),
    profile_pic VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
");



    // Create lessons table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS lessons (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            level VARCHAR(50),
            subject VARCHAR(100),
            cover_photo VARCHAR(255),
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");

    // Create quizzes table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS quizzes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            lesson_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            total_points INT DEFAULT 0,
            FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");

    // Create questions table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS questions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            quiz_id INT NOT NULL,
            question_text TEXT NOT NULL,
            question_type VARCHAR(50) NOT NULL,
            points INT NOT NULL DEFAULT 1,
            FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");

    // Create options table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS options (
            id INT AUTO_INCREMENT PRIMARY KEY,
            question_id INT NOT NULL,
            option_text TEXT NOT NULL,
            is_correct BOOLEAN NOT NULL DEFAULT 0,
            FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");

    // Create lesson_materials table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS lesson_materials (
            id INT AUTO_INCREMENT PRIMARY KEY,
            lesson_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            file_path VARCHAR(255),
            material_type VARCHAR(50),
            FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");

    // Create video lessons table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS video_lessons (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            youtube_url VARCHAR(255) NOT NULL,
            level VARCHAR(50),
            subject VARCHAR(100),
            thumbnail_url VARCHAR(255),
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");

    // Create video quizzes table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS video_quizzes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            video_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            total_points INT DEFAULT 0,
            time_stamp INT DEFAULT 0,
            FOREIGN KEY (video_id) REFERENCES video_lessons(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;

        CREATE TABLE IF NOT EXISTS video_questions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            quiz_id INT NOT NULL,
            question_text TEXT NOT NULL,
            question_type VARCHAR(50) NOT NULL,
            points INT NOT NULL DEFAULT 1,
            FOREIGN KEY (quiz_id) REFERENCES video_quizzes(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;

        CREATE TABLE IF NOT EXISTS video_question_options (
            id INT AUTO_INCREMENT PRIMARY KEY,
            question_id INT NOT NULL,
            option_text TEXT NOT NULL,
            is_correct BOOLEAN NOT NULL DEFAULT 0,
            FOREIGN KEY (question_id) REFERENCES video_questions(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");

    echo "Database and tables created successfully!";

} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

