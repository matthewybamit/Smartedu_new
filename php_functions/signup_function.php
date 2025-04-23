<?php
include 'db_connection.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['fname']);
    $lastName = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $userName = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $emailCheckQuery = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $emailCheckQuery->bindParam(':email', $email);
    $emailCheckQuery->execute();

    if ($emailCheckQuery->rowCount() > 0) {
        $message = 'Email already exists!';
    } else {
        // Insert user data into the database
        $sql = "INSERT INTO users (first_name, last_name, email, username, password) 
                VALUES (:first_name, :last_name, :email, :username, :password)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $userName);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            header('Location: login.php');
            exit();
        } else {
            $message = 'Error creating account!';
        }
    }
}
?>