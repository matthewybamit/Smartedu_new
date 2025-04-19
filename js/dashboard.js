// Import Firebase libraries
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-app.js";
import { getAuth } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-auth.js";

// Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyCpgVuo3sAsdbdVIZ1W6X54CY7DrvvX5hA",
    authDomain: "compaq-2f7b9.firebaseapp.com",
    projectId: "compaq-2f7b9",
    storageBucket: "compaq-2f7b9.appspot.com",
    messagingSenderId: "938797418930",
    appId: "1:938797418930:web:d7400d0f460b4c9038bcab"
};


// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// Get elements from the DOM
const profileImage = document.getElementById('profileImage');
const userName = document.getElementById('userName');
const userAge = document.getElementById('userAge'); // Make sure to define a way to store or retrieve the user's age

// Check if the user is logged in
onAuthStateChanged(auth, (user) => {
    if (user) {
        // User is logged in, now you can display the user information
        console.log('User logged in:', user);

        // Display the user's profile image
        profileImage.src = user.photoURL || 'photos/default-avatar.png';  // Default avatar if no photoURL
        
        // Display the user's name
        userName.textContent = user.displayName || 'Anonymous';
        
        // Age: If you have it stored in a database or localStorage
        const userStoredAge = localStorage.getItem('userAge'); // For example
        userAge.textContent = userStoredAge || 'Unknown Age'; // Update with actual logic to retrieve age
    } else {
        // No user is logged in, handle accordingly (maybe redirect to login)
        console.log('No user is logged in');
        window.location.href = 'landing_login.php'; // Redirect to login if needed
    }
});