<?php
/**
 * Database setup script
 * This script will set up all necessary tables and sample data for Lumin educational platform
 */

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Setting up Lumin Database</h1>";
echo "<p>This script will create all necessary tables and sample data for the Lumin educational platform.</p>";

// Create the php_functions directory if it doesn't exist
if (!file_exists('php_functions')) {
    mkdir('php_functions');
    echo "<p>Created php_functions directory.</p>";
}

// Include necessary files
echo "<h2>Creating/updating database tables...</h2>";
include 'php_functions/create_users_table.php';
include 'php_functions/update_database.php';
include 'php_functions/add_sample_content.php';

echo "<h2>Database setup complete!</h2>";
echo "<p>You can now use the Lumin educational platform. Make sure to:</p>";
echo "<ol>";
echo "<li>Take quizzes through either video or reading lessons</li>";
echo "<li>Check your dashboard to see your performance</li>";
echo "<li>Explore personalized recommendations based on the K-means clustering algorithm</li>";
echo "</ol>";

echo "<p><a href='dashboard.php' style='padding: 10px 20px; background-color: #ff8800; color: white; text-decoration: none; border-radius: 5px;'>Go to Dashboard</a></p>";
?>