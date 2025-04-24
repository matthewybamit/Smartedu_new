<?php
include 'db_connection.php';

function verifyEmail($email) {
    $apiKey = '2a3743a2dc21790e749628633bb7bc1c';
    $url = "http://apilayer.net/api/check?access_key=" . $apiKey . "&email=" . urlencode($email) . "&smtp=1&format=1";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $result = json_decode($response, true);
        return isset($result['format_valid']) && $result['format_valid'] && 
               isset($result['smtp_check']) && $result['smtp_check'];
    }
    return false;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($fname) || empty($lname) || empty($email) || empty($username) || empty($password)) {
        $message = 'All fields are required';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address format';
    } else if (strlen($password) < 6) {
        $message = 'Password must be at least 6 characters long';
    } else {
        // Verify email existence using API
        if (!verifyEmail($email)) {
            $message = 'Invalid or non-existent email address';
        } else {
            try {
                // Check if email exists in database
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->execute([$email]);

                if ($stmt->rowCount() > 0) {
                    $message = 'Email already registered';
                } else {
                    // Check username
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
                    $stmt->execute([$username]);

                    if ($stmt->rowCount() > 0) {
                        $message = 'Username already taken';
                    } else {
                        // Hash password
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        // Insert user - removed age from the query
                        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, username, password_hash, date_registered) VALUES (?, ?, ?, ?, ?, NOW())");
                        if ($stmt->execute([$fname, $lname, $email, $username, $hashed_password])) {
                            // Start session
                            session_start();
                            $_SESSION['email'] = $email;
                            $_SESSION['username'] = $username;
                            $_SESSION['first_name'] = $fname;

                            // Redirect to dashboard
                            header("Location: dashboard.php");
                            exit();
                        } else {
                            $message = 'Error creating account';
                        }
                    }
                }
            } catch (PDOException $e) {
                $message = 'Database error: ' . $e->getMessage();
            }
        }
    }
}
?>