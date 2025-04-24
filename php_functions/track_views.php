<?php
require_once 'db_connection.php';

function incrementViews($id, $type = 'video') {
    global $pdo;
    try {
        if ($type === 'video') {
            $stmt = $pdo->prepare("UPDATE video_lessons SET view_count = view_count + 1 WHERE id = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE lessons SET view_count = view_count + 1 WHERE id = :id");
        }
        $stmt->execute(['id' => $id]);
        return true;
    } catch (PDOException $e) {
        error_log("Error incrementing views: " . $e->getMessage());
        return false;
    }
}
