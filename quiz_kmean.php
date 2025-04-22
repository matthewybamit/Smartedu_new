<?php
/**
 * Run K-means clustering on user performance data
 * This script can be executed via cron job (e.g., daily)
 */

// Include required files
require_once 'php_functions/db_connection.php';
require_once 'php_functions/kmeans_clustering.php';

// Log start time
$startTime = microtime(true);
echo "Starting clustering process at " . date('Y-m-d H:i:s') . "\n";

// Check if clustering is needed
if (shouldRunClustering($pdo)) {
    echo "Clustering is needed. Running algorithm...\n";
    
    // Get user performance data
    $users = getUserPerformanceData($pdo);
    
    if (count($users) < 2) {
        echo "Not enough users for meaningful clustering (minimum 2 required, found " . count($users) . ").\n";
    } else {
        // Normalize features
        $featureVectors = normalizeFeatures($users);
        
        // Determine optimal k (between 2 and 5)
        $k = min(max(2, intval(count($featureVectors) / 5)), 5);
        echo "Using k=" . $k . " for clustering " . count($featureVectors) . " users.\n";
        
        // Run k-means clustering
        $clusteringResults = kMeansClustering($featureVectors, $k);
        
        // Save results to database
        $success = saveClusteringResults($pdo, $clusteringResults);
        
        if ($success) {
            echo "Clustering results saved successfully.\n";
            
            // Generate recommendations for each user
            echo "Generating recommendations...\n";
            
            // Get all users with cluster assignments
            $userQuery = $pdo->query("
                SELECT DISTINCT user_email 
                FROM user_clusters
            ");
            
            while ($user = $userQuery->fetch(PDO::FETCH_ASSOC)) {
                $userEmail = $user['user_email'];
                
                // Clear old recommendations
                $clearStmt = $pdo->prepare("
                    DELETE FROM recommendations 
                    WHERE user_email = :email
                ");
                $clearStmt->bindParam(':email', $userEmail);
                $clearStmt->execute();
                
                // Generate new recommendations
                $recommendations = getClusterBasedRecommendations($pdo, $userEmail, 10);
                
                // Insert new recommendations
                if (!empty($recommendations)) {
                    $insertStmt = $pdo->prepare("
                        INSERT INTO recommendations (
                            user_email, content_type, content_id, priority, is_viewed, date_created
                        ) VALUES (
                            :email, :content_type, :content_id, :priority, 0, NOW()
                        )
                    ");
                    
                    foreach ($recommendations as $index => $rec) {
                        $contentType = $rec['source'];
                        $contentId = $rec['id'];
                        $priority = 10 - min($index, 9); // Higher priority for first recommendations
                        
                        $insertStmt->bindParam(':email', $userEmail);
                        $insertStmt->bindParam(':content_type', $contentType);
                        $insertStmt->bindParam(':content_id', $contentId);
                        $insertStmt->bindParam(':priority', $priority);
                        $insertStmt->execute();
                    }
                }
            }
            
            echo "Recommendations generated successfully.\n";
        } else {
            echo "Error saving clustering results.\n";
        }
    }
} else {
    echo "Clustering is not needed at this time.\n";
}

// Log end time and execution duration
$endTime = microtime(true);
$executionTime = round($endTime - $startTime, 2);
echo "Clustering process completed in " . $executionTime . " seconds at " . date('Y-m-d H:i:s') . "\n";
?>