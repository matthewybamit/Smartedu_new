<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Logging Out</title>
    <script type="module">
        import { getAuth, signOut } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-auth.js";
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-app.js";
        
        const firebaseConfig = {
            apiKey: "AIzaSyCpgVuo3sAsdbdVIZ1W6X54CY7DrvvX5hA",
            authDomain: "compaq-2f7b9.firebaseapp.com",
            projectId: "compaq-2f7b9",
            storageBucket: "compaq-2f7b9.appspot.com",
            messagingSenderId: "938797418930",
            appId: "1:938797418930:web:d7400d0f460b4c9038bcab"
        };
        
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        
        // Sign out from Firebase
        signOut(auth).then(() => {
            console.log("Signed out successfully");
            // Redirect after signout
            window.location.href = "login.php";
        }).catch((error) => {
            console.error("Sign out error:", error);
            // Redirect anyway
            window.location.href = "login.php";
        });
    </script>
</head>
<body>
    <p>Logging you out...</p>
</body>
</html>