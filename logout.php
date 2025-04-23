<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logging Out</title>
  <style>
    /* -----------------------------------------
       Root Palette & Global Reset
       ----------------------------------------- */
    :root {
      --color-primary:    #122d64;
      --color-secondary:  #82a0dc;
      --color-accent:     #c97920;
      --color-surface:    #ffffff;
      --color-overlay:    rgba(0, 0, 0, 0.6);
      --spinner-size:     4rem;
      --transition-speed: 0.3s;
      --font-base:        'Manrope', Arial, sans-serif;
    }
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0; padding: 0;
    }
    html, body {
      height: 100%;
      width: 100%;
      font-family: var(--font-base);
      overflow: hidden; /* prevent scroll while logging out */
    }

    /* -----------------------------------------
       Full‑screen Overlay
       ----------------------------------------- */
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      background: var(--color-overlay);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      color: var(--color-surface);
      text-align: center;
    }

    /* -----------------------------------------
       Spinner
       ----------------------------------------- */
    .spinner {
      width: var(--spinner-size);
      height: var(--spinner-size);
      border: 4px solid var(--color-surface);
      border-top-color: var(--color-accent);
      border-radius: 50%;
      animation: spin 1s linear infinite; /* continuous rotation */ 
      margin-bottom: 1rem;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* -----------------------------------------
       Message
       ----------------------------------------- */
    .message {
      font-size: 1.25rem;
      font-weight: 500;
      transition: opacity var(--transition-speed);
    }
  </style>

  <script type="module">
    import { getAuth, signOut } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-auth.js";
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-app.js";
    
    // Initialize Firebase
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

    // Sign out and redirect
    signOut(auth).then(() => {
      window.location.href = "login.php";
    }).catch(() => {
      window.location.href = "login.php";
    });
  </script>
</head>
<body>
  <div class="overlay">
    <div class="spinner"></div>
    <div class="message">Logging you out...</div>
  </div>
</body>
</html>
