<?php
header('Content-Type: application/json');
require 'db_connection.php';

try {
    // Get all video lessons
    $stmt = $pdo->query("SELECT id, title, subject, youtube_url FROM video_lessons ORDER BY date_created DESC");
    $lessons = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // The youtube_url is already the video ID (e.g., 3JZ_D3ELwOQ)
        $video_id = $row['youtube_url'];

        if ($video_id) {
            $row['video_id'] = $video_id;
            $row['thumbnail_url'] = "https://img.youtube.com/vi/{$video_id}/0.jpg"; // Thumbnail URL for YouTube video
            $lessons[] = $row;
        }
    }

    echo json_encode($lessons);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
