<?php
session_start();
header('Content-Type: application/json');

// Include database connection
include '../php_functions/db_connection.php';

// Read the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No data provided']);
    exit;
}

// Retrieve the user data from the request
$email = isset($data['email']) ? trim($data['email']) : '';
$displayName = isset($data['displayName']) ? trim($data['displayName']) : '';
$photoURL = isset($data['photoURL']) ? trim($data['photoURL']) : '';
$age = isset($data['age']) ? (int)$data['age'] : 0;

// Validate required fields
if (empty($email) || empty($displayName)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

// Extract first and last names from displayName
$nameParts = explode(" ", $displayName);
$firstName = $nameParts[0];
$lastName = count($nameParts) > 1 ? implode(" ", array_slice($nameParts, 1)) : '';

// Derive a username (for example, using the email prefix)
$usernameDerived = strstr($email, '@', true);
if (!$usernameDerived) {
    $usernameDerived = $email;
}

// Since OAuth users do not require a password, we assign a default dummy password
// (You might later ask the user to set one or disable password-based login for these accounts)
$dummyPassword = password_hash("OAUTH_USER", PASSWORD_DEFAULT);

try {
    // Check if the user already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // If user exists, update the information (optional)
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, username = ?, age = ? WHERE email = ?");
        $stmt->execute([$firstName, $lastName, $usernameDerived, $age, $email]);
    } else {
        // Insert a new user record
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, username, password, age) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $usernameDerived, $dummyPassword, $age]);
    }

    // Set session variables for later use (e.g., displaying on dashboard)
    $_SESSION['user_email'] = $email;
    $_SESSION['user_displayName'] = $displayName;
    $_SESSION['user_username'] = $usernameDerived;
    $_SESSION['user_age'] = $age;
    $_SESSION['user_profileImage'] = $photoURL;

    echo json_encode(['status' => 'success', 'message' => 'User stored successfully']);
} catch (PDOException $e) {
    // Check if the error is related to the users table not existing
    if (strpos($e->getMessage(), "Table 'lumin_admin.users' doesn't exist") !== false) {
        // Create the users table
        try {
            $createTable = "CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50),
                email VARCHAR(100) UNIQUE NOT NULL,
                username VARCHAR(50) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                age INT,
                profile_image VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($createTable);
            
            // Try inserting the user again
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, username, password, age) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$firstName, $lastName, $email, $usernameDerived, $dummyPassword, $age]);
            
            // Set session variables
            $_SESSION['user_email'] = $email;
            $_SESSION['user_displayName'] = $displayName;
            $_SESSION['user_username'] = $usernameDerived;
            $_SESSION['user_age'] = $age;
            $_SESSION['user_profileImage'] = $photoURL;
            
            echo json_encode(['status' => 'success', 'message' => 'User table created and user stored successfully']);
        } catch (PDOException $createError) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create users table: ' . $createError->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>