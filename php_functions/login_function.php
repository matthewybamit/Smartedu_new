<?php
// login_function.php
session_start(); // Must be the very first statement

include 'db_connection.php'; // Include your database connection

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

        // Verify password
        if (password_verify($password, $user['password'])) {
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
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = 'User not found!';
        header("Location: login.php");
        exit();
    }
}
?>
