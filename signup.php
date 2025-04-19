<?php
include 'php_functions/signup_function.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign-up</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/signup_modal.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Bigelow+Rules&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <h2>Create Your Learning Account</h2>
          
            <form action="" method="post">
                <label for="firstname" class="fname">First Name</label>
                <input type="text" id="fname" name="fname" required>

                <div class="row"> 
                    <div class="column">
                        <label for="lastname" class="lname">Last Name</label>
                        <input type="text" id="lname" name="lname" required>
                    </div>
            
                    <div class="column">
                        <label for="age" class="age">Age</label>
                        <input type="number" id="age" name="age" required>
                    </div>
                </div>

                <label for="password" class="pass">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="username" class="user">Username</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password" class="pass">Password</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit" class="sign-in">Sign Up</button>
            </form>
            <p class="signup-text">Already have an account? <a href="login.php">Sign In</a></p>
        </div>
        <div class="right-section">
            <div class="logo">
                <h1>Lumin</h1>
                <div class="owlogo">
                    <img src="photos/orange.png" class="owlorange"> 
                    <img src="photos/blue.png" class="owl">
                </div>
            </div>
        </div>
    </div>






  <!-- Modal -->
  <div id="myModal" class="modal">
        <div class="modal-content <?php echo $message == 'Account created successfully!' ? 'success' : 'error'; ?>">
            <p class="modal-message"><?php echo $message; ?></p>
            <button class="close-btn" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        // Show the modal if a message exists
        var message = "<?php echo $message; ?>";
        if (message) {
            document.getElementById('myModal').style.display = 'block';
        }

        // Close the modal
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }
    </script>


</body>
</html>
