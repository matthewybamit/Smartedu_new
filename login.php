<?php 
include 'php_functions/login_function.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InkCognitos Login</title>
    <link rel="stylesheet" href="css/login.css">
    <script type="module" src="js/firebaseAuth.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="left-section">
            <div class="logo">
                <h1>Lumin</h1>
                <div class="owlogo">
                    <img src="photos/orange.png" class="owl" alt="Logo">
                </div>
            </div>
        </div>

        <div class="right-section">
            <h2>Hello, Welcome!</h2>
            <button id="googleSignIn" class="google-signin">
                <img src="photos/google.png" alt="Google Logo">
                Sign In with Google
            </button>
            
            <div class="separator">
                <span>OR</span>
            </div>
            
            <!-- The form now uses "email" as the input name -->
            <form method="POST" action="">
                <label for="email" class="user">Email</label>
                <input type="text" id="email" name="email" required>
                
                <label for="password" class="pass">Password</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit" class="sign-in">Sign In</button>
            </form>
            <p class="signup-text">Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>

</body>
</html>
