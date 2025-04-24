<?php
// login_function.php
session_start(); // Must be the very first statement

include 'db_connection.php';

// Check if database connection exists after including the file
if (!isset($conn) && isset($pdo)) {
    $conn = $pdo; // Use $pdo if that's what your db_connection.php creates
} else if (!isset($conn)) {
    // If no connection variable exists, display an error
    die("Database connection not established. Check db_connection.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the input from the login form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query user by email
    $query = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(':email', $email);
    $query->execute();

    if ($query->rowCount() > 0) {
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // Verify password - changed 'password' to 'password_hash' to match your database column
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_displayName'] = $user['first_name'] . ' ' . $user['last_name'];
            // Optionally, if you store additional data like profile image:
            if(isset($user['profile_image'])) {
                $_SESSION['user_profileImage'] = $user['profile_image'];
            }

            // Redirect to dashboard.php after successful login
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['message'] = 'Invalid password!';
        }
    } else {
        $_SESSION['message'] = 'User not found!';
    }
}
?>