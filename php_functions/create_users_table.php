<?php
/**
 * Create users table in the database
 * This script ensures the users table is properly structured for the K-means clustering
 */

// Include database connection
require_once 'db_connection.php';

try {
    // Begin transaction
    $pdo->beginTransaction();
    
    // Create users table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(120) NOT NULL UNIQUE,
            first_name VARCHAR(64) NOT NULL,
            last_name VARCHAR(64) NOT NULL,
            password_hash VARCHAR(256),
            profile_image VARCHAR(256),
            date_registered DATETIME DEFAULT CURRENT_TIMESTAMP,
            last_login DATETIME DEFAULT NULL,
            is_active TINYINT(1) DEFAULT 1,
            INDEX (email)
        )
    ");
    
    echo "Users table created/updated successfully.\n";
    
    // Check if there's at least one test user
    $checkUser = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $checkUser->fetch(PDO::FETCH_ASSOC)['count'];
    
    if ($userCount == 0) {
        // Add a test user if no users exist
        $insertStmt = $pdo->prepare("
            INSERT INTO users (email, first_name, last_name, date_registered)
            VALUES ('test@example.com', 'Test', 'User', NOW())
        ");
        $insertStmt->execute();
        echo "Test user created. You can use email: test@example.com for testing.\n";
    }
    
    // Commit transaction
    $pdo->commit();
    echo "Database setup completed successfully.\n";
    
} catch (PDOException $e) {
    // Rollback on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    echo "Error setting up users table: " . $e->getMessage() . "\n";
}
?>