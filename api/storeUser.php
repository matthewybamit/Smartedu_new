<?php
// storeUser.php
session_start();
require_once '../php_functions/db_connection.php';
// Get JSON data from the request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);
// Validate data
if (!$data || !isset($data['email']) || !isset($data['displayName'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}
// Save to session for use with clustering
$_SESSION['email'] = $data['email'];
$_SESSION['user_email'] = $data['email']; // For compatibility with any code using user_email
$_SESSION['first_name'] = explode(' ', $data['displayName'])[0];
$_SESSION['last_name'] = count(explode(' ', $data['displayName'])) > 1 ? explode(' ', $data['displayName'])[1] : '';
try {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        // Insert new user
        $insertStmt = $pdo->prepare(
            "INSERT INTO users (email, first_name, last_name, profile_image, date_registered) 
             VALUES (:email, :first_name, :last_name, :profile_image, NOW())"
        );
        
        $firstName = explode(' ', $data['displayName'])[0];
        $lastName = count(explode(' ', $data['displayName'])) > 1 ? explode(' ', $data['displayName'])[1] : '';
        
        $insertStmt->bindParam(':email', $data['email']);
        $insertStmt->bindParam(':first_name', $firstName);
        $insertStmt->bindParam(':last_name', $lastName);
        $insertStmt->bindParam(':profile_image', $data['photoURL']);
        $insertStmt->execute();
    } else {
        // Update existing user
        $updateStmt = $pdo->prepare(
            "UPDATE users 
             SET first_name = :first_name, 
                 last_name = :last_name, 
                 profile_image = :profile_image 
             WHERE email = :email"
        );
        
        $firstName = explode(' ', $data['displayName'])[0];
        $lastName = count(explode(' ', $data['displayName'])) > 1 ? explode(' ', $data['displayName'])[1] : '';
        
        $updateStmt->bindParam(':email', $data['email']);
        $updateStmt->bindParam(':first_name', $firstName);
        $updateStmt->bindParam(':last_name', $lastName);
        $updateStmt->bindParam(':profile_image', $data['photoURL']);
        $updateStmt->execute();
    }
    
    echo json_encode(['success' => true, 'message' => 'User data stored successfully']);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error', 'message' => $e->getMessage()]);
}
?>