// Import the Firebase libraries
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-app.js";
import { getAuth, signInWithPopup, GoogleAuthProvider, signOut } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-auth.js";

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
const provider = new GoogleAuthProvider();

// Get the Google Sign-In button by its ID
const googleSignInBtn = document.getElementById('googleSignIn');
// (Optional elements for UI handling)
const loginSection = document.getElementById('loginSection');
const profileSection = document.getElementById('profileSection');
const profileImage = document.getElementById('profileImage');
const profileName = document.getElementById('profileName');

// Google Sign-In Button Event Listener
googleSignInBtn.addEventListener('click', () => {
    signInWithPopup(auth, provider)
        .then((result) => {
            // Retrieve user info from result
            const user = result.user;
            console.log('User Info:', user);

            // Optionally, store user profile info in localStorage
            localStorage.setItem('userProfileImage', user.photoURL);
            localStorage.setItem('userName', user.displayName);
            localStorage.setItem('userEmail', user.email);

            // Prepare the data to be sent to the backend
            const userData = {
                email: user.email,
                displayName: user.displayName,
                photoURL: user.photoURL,
                // Since OAuth does not provide age, we default it to 0.
                age: 0
            };

            // POST the user data to the PHP endpoint in the api folder
            fetch('api/storeUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
                // Redirect after successful storage
                window.location.href = 'dashboard.php';
            })
            .catch(error => {
                console.error('Error while storing user data:', error);
                alert('An error occurred while saving your data.');
            });
        })
        .catch((error) => {
            console.error('Login Error:', error);
            alert('Failed to login. Please try again.');
        });
});
