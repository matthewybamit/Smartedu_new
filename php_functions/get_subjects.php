<?php
header('Content-Type: application/json');
require 'db_connection.php'; // or include, depending on your structure

try {
    $stmt = $pdo->query("SELECT DISTINCT subject FROM lessons WHERE subject IS NOT NULL AND subject != '' ORDER BY subject ASC");
    $subjects = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($subjects);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
