<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION['preferred_subject'] = $_POST['subject'];
    $_SESSION['preferred_level'] = $_POST['level'];
    $_SESSION['preferred_style'] = $_POST['style'];

    echo json_encode(['status' => 'success']);
    exit();
}

echo json_encode(['status' => 'error']);
