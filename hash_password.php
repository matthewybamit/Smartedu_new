
<?php
header('Content-Type: text/plain');

$data = json_decode(file_get_contents('php:input'), true);
$password = $data['password'] ?? '';

if (empty($password)) {
    http_response_code(400);
    echo 'Password required';
    exit;
}

echo password_hash($password, PASSWORD_DEFAULT);
?>
