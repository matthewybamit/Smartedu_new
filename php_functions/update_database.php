<?php
/**
 * Update database schema for K-means clustering and user performance tracking
 */

require_once 'db_connection.php';

try {
    // Create quiz_attempts table if not exists
     // 4. Ensure quiz_attempts table exists with necessary structure
     $pdo->exec("
     CREATE TABLE IF NOT EXISTS quiz_attempts (
         id INT AUTO_INCREMENT PRIMARY KEY,
         user_email VARCHAR(120) NOT NULL,
         quiz_id INT NOT NULL,
         score INT NOT NULL,
         total_questions INT NOT NULL,
         source VARCHAR(20) NOT NULL,
         subject VARCHAR(64) NOT NULL,
         content_id INT,
         date_completed DATETIME,
         INDEX (user_email),
         INDEX (quiz_id),
         INDEX (subject),
         INDEX (source)
     )
 ");
 
    
    // Create user_clusters table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_clusters (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_email VARCHAR(150) NOT NULL,
            cluster_id INT NOT NULL,
            last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");
    
    // Create user_performance table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_performance (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_email VARCHAR(150) NOT NULL,
            subject VARCHAR(100) NOT NULL,
            avg_score FLOAT DEFAULT 0,
            quizzes_taken INT DEFAULT 0,
            learning_style VARCHAR(50),
            last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY (user_email, subject)
        ) ENGINE=InnoDB;
    ");
    
    // Create recommendations table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS recommendations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_email VARCHAR(150) NOT NULL,
            content_type VARCHAR(20) NOT NULL,
            content_id INT NOT NULL,
            priority INT DEFAULT 3,
            is_viewed BOOLEAN DEFAULT 0,
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");
    
    echo "Database schema updated successfully!";
} catch (PDOException $e) {
    die("Error updating database schema: " . $e->getMessage());
}
?>