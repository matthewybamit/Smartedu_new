<?php
// Output JSON with Firebase configuration, leveraging environment variables
header('Content-Type: application/json');

// Access environment variables 
echo json_encode([
    'apiKey' => getenv('FIREBASE_API_KEY'),
    'projectId' => getenv('FIREBASE_PROJECT_ID'),
    'appId' => getenv('FIREBASE_APP_ID'),
    'authDomain' => getenv('FIREBASE_PROJECT_ID') . '.firebaseapp.com',
    'storageBucket' => getenv('FIREBASE_PROJECT_ID') . '.appspot.com',
]);
?>