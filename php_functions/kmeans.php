<?php
/**
 * K-means clustering implementation for user learning analysis
 * 
 * This class implements the K-means clustering algorithm to group users
 * based on their learning performance and behavior.
 */
class KMeansClustering {
    private $k; // Number of clusters
    private $maxIterations;
    private $data; // Array of data points
    private $centroids; // Array of cluster centroids
    private $assignments; // Array of cluster assignments
    
    /**
     * Constructor
     * 
     * @param int $k Number of clusters
     * @param int $maxIterations Maximum number of iterations
     */
    public function __construct($k = 3, $maxIterations = 100) {
        $this->k = $k;
        $this->maxIterations = $maxIterations;
        $this->data = [];
        $this->centroids = [];
        $this->assignments = [];
    }
    
    /**
     * Add a data point to the dataset
     * 
     * @param array $point Data point (array of features)
     * @param string $id Identifier for the data point (e.g., user email)
     */
    public function addDataPoint($point, $id) {
        $this->data[$id] = $point;
    }
    
    /**
     * Calculate Euclidean distance between two points
     * 
     * @param array $point1 First point
     * @param array $point2 Second point
     * @return float Distance between points
     */
    private function distance($point1, $point2) {
        $sum = 0;
        foreach ($point1 as $key => $value) {
            if (isset($point2[$key])) {
                $sum += pow($value - $point2[$key], 2);
            }
        }
        return sqrt($sum);
    }
    
    /**
     * Initialize centroids randomly from the data points
     */
    private function initializeCentroids() {
        // Make a copy of the data to select random points
        $dataCopy = $this->data;
        
        // If we have fewer data points than k, adjust k
        if (count($dataCopy) < $this->k) {
            $this->k = count($dataCopy);
        }
        
        // Select k random points as initial centroids
        $this->centroids = [];
        $keys = array_keys($dataCopy);
        $randomKeys = array_rand($keys, $this->k);
        
        // If only one centroid, array_rand returns a single value, not an array
        if (!is_array($randomKeys)) {
            $randomKeys = [$randomKeys];
        }
        
        foreach ($randomKeys as $i) {
            $key = $keys[$i];
            $this->centroids[] = $dataCopy[$key];
        }
    }
    
    /**
     * Assign each data point to the nearest centroid
     * 
     * @return bool True if assignments changed, false otherwise
     */
    private function assignToClusters() {
        $changed = false;
        $newAssignments = [];
        
        foreach ($this->data as $id => $point) {
            $minDistance = PHP_FLOAT_MAX;
            $closestCluster = 0;
            
            // Find the closest centroid
            for ($i = 0; $i < count($this->centroids); $i++) {
                $distance = $this->distance($point, $this->centroids[$i]);
                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $closestCluster = $i;
                }
            }
            
            $newAssignments[$id] = $closestCluster;
            
            // Check if assignment changed
            if (!isset($this->assignments[$id]) || $this->assignments[$id] !== $closestCluster) {
                $changed = true;
            }
        }
        
        $this->assignments = $newAssignments;
        return $changed;
    }
    
    /**
     * Update centroids based on current assignments
     */
    private function updateCentroids() {
        $clusterSums = [];
        $clusterCounts = [];
        
        // Initialize arrays
        for ($i = 0; $i < $this->k; $i++) {
            $clusterSums[$i] = [];
            $clusterCounts[$i] = 0;
        }
        
        // Sum up the points in each cluster
        foreach ($this->data as $id => $point) {
            $clusterId = $this->assignments[$id];
            $clusterCounts[$clusterId]++;
            
            foreach ($point as $feature => $value) {
                if (!isset($clusterSums[$clusterId][$feature])) {
                    $clusterSums[$clusterId][$feature] = 0;
                }
                $clusterSums[$clusterId][$feature] += $value;
            }
        }
        
        // Calculate new centroids (average of points in each cluster)
        for ($i = 0; $i < $this->k; $i++) {
            if ($clusterCounts[$i] > 0) {
                foreach ($clusterSums[$i] as $feature => $sum) {
                    $this->centroids[$i][$feature] = $sum / $clusterCounts[$i];
                }
            }
        }
    }
    
    /**
     * Run the K-means clustering algorithm
     * 
     * @return array Cluster assignments
     */
    public function cluster() {
        // Check if we have data
        if (empty($this->data)) {
            return [];
        }
        
        // Initialize centroids
        $this->initializeCentroids();
        
        // Iterate until convergence or max iterations
        $changed = true;
        $iteration = 0;
        
        while ($changed && $iteration < $this->maxIterations) {
            $changed = $this->assignToClusters();
            $this->updateCentroids();
            $iteration++;
        }
        
        return $this->assignments;
    }
    
    /**
     * Get cluster centroids
     * 
     * @return array Centroids
     */
    public function getCentroids() {
        return $this->centroids;
    }
}

/**
 * Helper function to cluster users based on quiz performance
 * 
 * @param PDO $pdo Database connection
 * @return array Cluster assignments
 */
function clusterUsers($pdo) {
    // Initialize K-means with 3 clusters (low, medium, high performers)
    $kmeans = new KMeansClustering(3);
    
    try {
        // Get all users with performance data
        $query = $pdo->query("
            SELECT user_email, subject, avg_score, quizzes_taken, learning_style 
            FROM user_performance
        ");
        
        $users = [];
        while ($row = $query->fetch()) {
            $email = $row['user_email'];
            $subject = $row['subject'];
            
            if (!isset($users[$email])) {
                $users[$email] = [
                    'avg_overall_score' => 0,
                    'total_quizzes' => 0,
                    'subjects' => 0,
                    'learning_preference' => 0, // 0 for no preference, 1 for reading, 2 for video
                    'scores_by_subject' => []
                ];
            }
            
            // Update user data
            $users[$email]['scores_by_subject'][$subject] = $row['avg_score'];
            $users[$email]['avg_overall_score'] += $row['avg_score'] * $row['quizzes_taken'];
            $users[$email]['total_quizzes'] += $row['quizzes_taken'];
            $users[$email]['subjects']++;
            
            // Set learning preference based on style
            if ($row['learning_style'] === 'reading') {
                $users[$email]['learning_preference'] = 1;
            } else if ($row['learning_style'] === 'video') {
                $users[$email]['learning_preference'] = 2;
            }
        }
        
        // Finalize user features
        foreach ($users as $email => $data) {
            if ($data['total_quizzes'] > 0) {
                $users[$email]['avg_overall_score'] /= $data['total_quizzes'];
            }
            
            // Normalize features
            $features = [
                'avg_score' => $data['avg_overall_score'] / 100, // Normalize to 0-1
                'activity_level' => min($data['total_quizzes'] / 10, 1), // Normalize, cap at 10 quizzes
                'subject_diversity' => min($data['subjects'] / 6, 1), // Normalize by max subjects
                'learning_preference' => $data['learning_preference'] / 2 // Normalize to 0-1
            ];
            
            // Add data point to K-means
            $kmeans->addDataPoint($features, $email);
        }
        
        // Run clustering
        $clusterAssignments = $kmeans->cluster();
        
        // Update user_clusters table
        $stmt = $pdo->prepare("
            INSERT INTO user_clusters (user_email, cluster_id, last_updated)
            VALUES (?, ?, NOW())
            ON DUPLICATE KEY UPDATE 
            cluster_id = VALUES(cluster_id), 
            last_updated = VALUES(last_updated)
        ");
        
        foreach ($clusterAssignments as $email => $clusterId) {
            $stmt->execute([$email, $clusterId]);
        }
        
        return $clusterAssignments;
        
    } catch (PDOException $e) {
        error_log("Error in clusterUsers: " . $e->getMessage());
        return [];
    }
}
?>
