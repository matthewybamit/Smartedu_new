<?php
function getEnglishModuleDetails($conn) {
    $query = "SELECT title, description FROM module_english WHERE chapter = '1' LIMIT 1";
    
    try {
        $stmt = $conn->prepare($query);  // Prepare the SQL query
        $stmt->execute();                // Execute the query
        $row = $stmt->fetch(PDO::FETCH_ASSOC);  // Fetch the result as an associative array
        
        if ($row) {
            return $row;  // Return both title and description
        } else {
            return array('title' => 'No title available', 'description' => 'No description available for Chapter 1.');  // Fallback message if no result found
        }
    } catch (PDOException $e) {
        return array('title' => 'Error', 'description' => "Error: " . $e->getMessage());  // Handle errors gracefully
    }
}
?>
