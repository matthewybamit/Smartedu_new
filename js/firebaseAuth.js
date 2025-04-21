// Import the Firebase libraries
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-app.js";
import { getAuth, signInWithPopup, GoogleAuthProvider, signOut } from "https://www.gstatic.com/firebasejs/10.1.0/firebase-auth.js";

// Fetch Firebase configuration from our PHP endpoint
let app, auth, provider;

async function initializeFirebase() {
    try {
        const response = await fetch('firebase-config.php');
        if (!response.ok) {
            throw new Error('Failed to load Firebase configuration');
        }
        
        const firebaseConfig = await response.json();
        
        // Initialize Firebase with the fetched config
        app = initializeApp(firebaseConfig);
        auth = getAuth(app);
        provider = new GoogleAuthProvider();
        
        // Setup event listener once Firebase is initialized
        setupGoogleSignIn();
    } catch (error) {
        console.error('Error initializing Firebase:', error);
        alert('Error loading authentication system. Please try again later.');
    }
}

// Function to set up Google Sign-In button event listener
function setupGoogleSignIn() {
    // Get the Google Sign-In button by its ID
    const googleSignInBtn = document.getElementById('googleSignIn');
    if (!googleSignInBtn) {
        console.error('Google Sign-In button not found');
        return;
    }
    
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
}

// Initialize Firebase when the document is loaded
document.addEventListener('DOMContentLoaded', initializeFirebase);