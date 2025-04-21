<?php
header('Content-Type: application/json');
require 'db_connection.php'; // adjust path if needed

try {
    $stmt = $pdo->query("SELECT id, title, subject, cover_photo FROM lessons ORDER BY date_created DESC");
    $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($lessons);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>