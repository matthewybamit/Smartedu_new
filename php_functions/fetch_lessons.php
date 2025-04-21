<?php
require_once 'db_connection.php'; // Make sure to adjust the path

// Get POST data from JavaScript
$data = json_decode(file_get_contents('php://input'), true);

$subject = $data['subject'] ?? null;
$level = $data['level'] ?? null;

$lessons = [];
if ($subject && $level) {
    // Prepare SQL query using PDO
    $sql = "SELECT * FROM lessons WHERE subject = :subject AND level = :level ORDER BY date_created ASC";
    
    // Prepare the statement
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
    $stmt->bindParam(':level', $level, PDO::PARAM_STR);
    
    // Execute the statement
    $stmt->execute();
    
    // Fetch all the results
    $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Return lessons as JSON
echo json_encode($lessons);
?>
