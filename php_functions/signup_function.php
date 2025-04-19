<?php
include 'db_connection.php';

function verifyEmail($email) {
    // MailboxLayer API URL with your API key
    $apiKey = '2a3743a2dc21790e749628633bb7bc1c';
    $url = "http://apilayer.net/api/check?access_key=$apiKey&email=$email&smtp=1&format=1";

    // Use cURL to call the API
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    if ($response) {
        $response = json_decode($response, true);

        // Check if the email is valid based on the response from MailboxLayer
        return isset($response['smtp_check']) && $response['smtp_check'] === true;
    } else {
        return false;  // API call failed, treat as invalid email
    }
}

$message = '';  // Store the result message (success or error)

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $userName = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $age = $_POST['age'];

    // Check if the email exists on the internet using the email verification function
    if (!verifyEmail($email)) {
        $message = 'Invalid email address! Please provide a valid one.';
    } else {
        // Check if email already exists in your local database
        $emailCheckQuery = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $emailCheckQuery->bindParam(':email', $email);
        $emailCheckQuery->execute();

        if ($emailCheckQuery->rowCount() > 0) {
            $message = 'Email already exists!';
        } else {
            // Insert user data into the database
            $sql = "INSERT INTO users (first_name, last_name, email, username, password, age) 
                    VALUES (:first_name, :last_name, :email, :username, :password, :age)";
            $stmt = $conn->prepare($sql);

            // Bind parameters to the query
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $userName);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':age', $age);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect to the landing page after successful registration
                header('Location: landing_logout.php');
                exit();
            } else {
                $message = 'Error creating account!';
            }
        }
    }
}
?>
