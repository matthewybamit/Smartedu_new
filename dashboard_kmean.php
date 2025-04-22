<?php
// Include database connection and clustering functions
require_once 'php_functions/db_connection.php';
require_once 'php_functions/kmeans_clustering.php';

// Get user email from session
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['user_email'];

// Check if the user has a cluster assignment
$clusterStmt = $pdo->prepare("
    SELECT cluster_id 
    FROM user_clusters 
    WHERE user_email = :email
");
$clusterStmt->bindParam(':email', $userEmail);
$clusterStmt->execute();

$hasCluster = $clusterStmt->rowCount() > 0;
$clusterId = $hasCluster ? $clusterStmt->fetch(PDO::FETCH_ASSOC)['cluster_id'] : -1;

// Get user's preferred learning style
$styleStmt = $pdo->prepare("
    SELECT learning_style 
    FROM user_performance 
    WHERE user_email = :email 
    GROUP BY learning_style 
    ORDER BY COUNT(*) DESC
    LIMIT 1
");
$styleStmt->bindParam(':email', $userEmail);
$styleStmt->execute();

$preferredStyle = $styleStmt->rowCount() > 0 ? 
    $styleStmt->fetch(PDO::FETCH_ASSOC)['learning_style'] : 'Not enough data';

// Get quiz performance data
$performanceStmt = $pdo->prepare("
    SELECT 
        subject,
        avg_score,
        quizzes_taken,
        learning_style
    FROM 
        user_performance
    WHERE 
        user_email = :email
    ORDER BY 
        avg_score DESC
");
$performanceStmt->bindParam(':email', $userEmail);
$performanceStmt->execute();

$performanceData = $performanceStmt->fetchAll(PDO::FETCH_ASSOC);

// Get recommendations for the user
$recommendations = [];
if ($hasCluster) {
    $recommendations = getClusterBasedRecommendations($pdo, $userEmail, 5);
} else {
    // Get popular content as recommendations
    $recommendations = getPopularContent($pdo, 5);
}

// Get cluster statistics
$clusterStats = [];
if ($hasCluster) {
    $statsStmt = $pdo->prepare("
        SELECT 
            COUNT(DISTINCT uc.user_email) as user_count,
            AVG(up.avg_score) as avg_cluster_score,
            MAX(CASE WHEN up.learning_style = 'video' THEN 1 ELSE 0 END) * 100 /
                COUNT(DISTINCT uc.user_email) as video_preference_percent,
            MAX(CASE WHEN up.learning_style = 'read' THEN 1 ELSE 0 END) * 100 /
                COUNT(DISTINCT uc.user_email) as reading_preference_percent
        FROM 
            user_clusters uc
        JOIN 
            user_performance up ON uc.user_email = up.user_email
        WHERE 
            uc.cluster_id = :cluster_id
    ");
    $statsStmt->bindParam(':cluster_id', $clusterId);
    $statsStmt->execute();
    
    $clusterStats = $statsStmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="dashboard-section">
    <h2>Your Learning Profile</h2>
    
    <div class="learning-profile">
        <div class="profile-card">
            <div class="profile-header">
                <h3>Learning Style Preference</h3>
                <div class="profile-icon">
                    <?php if ($preferredStyle === 'video'): ?>
                        <i class="fa fa-video"></i>
                    <?php elseif ($preferredStyle === 'read'): ?>
                        <i class="fa fa-book"></i>
                    <?php else: ?>
                        <i class="fa fa-question"></i>
                    <?php endif; ?>
                </div>
            </div>
            <div class="profile-body">
                <div class="preference-label">
                    <?php if ($preferredStyle === 'video'): ?>
                        You learn best through <strong>Video Content</strong>
                    <?php elseif ($preferredStyle === 'read'): ?>
                        You learn best through <strong>Reading Materials</strong>
                    <?php else: ?>
                        <strong>Complete more quizzes</strong> to determine your learning style
                    <?php endif; ?>
                </div>
                
                <div class="style-progress">
                    <?php if ($preferredStyle === 'video'): ?>
                        <div class="progress-bar">
                            <div class="progress" style="width: 75%;"></div>
                        </div>
                        <div class="progress-label">75% Video Preference</div>
                    <?php elseif ($preferredStyle === 'read'): ?>
                        <div class="progress-bar">
                            <div class="progress" style="width: 75%;"></div>
                        </div>
                        <div class="progress-label">75% Reading Preference</div>
                    <?php else: ?>
                        <div class="progress-bar">
                            <div class="progress" style="width: 0%;"></div>
                        </div>
                        <div class="progress-label">Need more data</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="profile-card">
            <div class="profile-header">
                <h3>Learning Group</h3>
                <div class="profile-icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
            <div class="profile-body">
                <?php if ($hasCluster): ?>
                    <div class="cluster-info">
                        <div class="cluster-label">Group <?php echo $clusterId + 1; ?></div>
                        <div class="cluster-description">
                            You are in a learning group with <?php echo $clusterStats['user_count'] - 1; ?> other students
                        </div>
                        
                        <div class="cluster-stats">
                            <div class="stat">
                                <div class="stat-value"><?php echo round($clusterStats['avg_cluster_score'], 1); ?>%</div>
                                <div class="stat-label">Avg. Score</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value"><?php echo round($clusterStats['video_preference_percent']); ?>%</div>
                                <div class="stat-label">Video Learners</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value"><?php echo round($clusterStats['reading_preference_percent']); ?>%</div>
                                <div class="stat-label">Reading Learners</div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="no-cluster">
                        <div class="cluster-description">
                            Complete more quizzes to be placed in a learning group
                        </div>
                        <a href="styles.php" class="btn-primary">Take Quizzes</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-section">
    <h2>Performance by Subject</h2>
    
    <?php if (!empty($performanceData)): ?>
        <div class="performance-cards">
            <?php foreach ($performanceData as $performance): ?>
                <div class="subject-card">
                    <div class="subject-header">
                        <h3><?php echo htmlspecialchars($performance['subject']); ?></h3>
                        <div class="subject-score">
                            <?php echo round($performance['avg_score'], 1); ?>%
                        </div>
                    </div>
                    <div class="subject-body">
                        <div class="progress-bar">
                            <div class="progress" style="width: <?php echo min(100, round($performance['avg_score'])); ?>%;"></div>
                        </div>
                        <div class="subject-details">
                            <div class="detail">
                                <span class="detail-label">Quizzes:</span>
                                <span class="detail-value"><?php echo $performance['quizzes_taken']; ?></span>
                            </div>
                            <div class="detail">
                                <span class="detail-label">Learning Style:</span>
                                <span class="detail-value">
                                    <?php echo ucfirst($performance['learning_style'] ?: 'Not set'); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-data">
            <p>No performance data available yet. Take quizzes to see your progress.</p>
            <a href="styles.php" class="btn-primary">Start Learning</a>
        </div>
    <?php endif; ?>
</div>

<div class="dashboard-section">
    <h2>Personalized Recommendations</h2>
    
    <?php if (!empty($recommendations)): ?>
        <div class="recommendations">
            <?php foreach ($recommendations as $rec): ?>
                <div class="recommendation-card">
                    <div class="rec-thumbnail">
                        <?php if ($rec['source'] === 'video'): ?>
                            <?php 
                            $videoId = "";
                            if (isset($rec['url']) && preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $rec['url'], $matches)) {
                                $videoId = $matches[1];
                            }
                            ?>
                            <img src="<?php echo !empty($rec['thumbnail_url']) ? htmlspecialchars($rec['thumbnail_url']) : 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg'; ?>" alt="Video Thumbnail">
                            <div class="rec-icon">▶</div>
                        <?php else: ?>
                            <div class="rec-placeholder">
                                <span>📚</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="rec-details">
                        <div class="rec-title"><?php echo htmlspecialchars($rec['title'] ?? 'Untitled Content'); ?></div>
                        <div class="rec-subject">
                            <?php echo htmlspecialchars($rec['subject'] ?? 'General'); ?> | 
                            <?php echo htmlspecialchars($rec['level'] ?? 'All Levels'); ?>
                        </div>
                        <div class="rec-type">
                            <?php if ($rec['source'] === 'video'): ?>
                                <span class="badge video">Video</span>
                            <?php else: ?>
                                <span class="badge reading">Reading</span>
                            <?php endif; ?>
                        </div>
                        <div class="rec-description">
                            <?php echo htmlspecialchars(substr($rec['description'], 0, 80)) . '...'; ?>
                        </div>
                        <?php if ($rec['source'] === 'video'): ?>
                            <a href="video.php?id=<?php echo $rec['id']; ?>" class="btn-secondary">Watch Now</a>
                        <?php else: ?>
                            <a href="read.php?lesson=<?php echo $rec['id']; ?>" class="btn-secondary">Read Now</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-data">
            <p>No recommendations available yet. Complete more quizzes to get personalized content suggestions.</p>
            <a href="styles.php" class="btn-primary">Start Learning</a>
        </div>
    <?php endif; ?>
</div>

<style>
.dashboard-section {
    margin-bottom: 40px;
}

.dashboard-section h2 {
    margin-bottom: 20px;
    color: #333;
    border-bottom: 2px solid #ff8800;
    padding-bottom: 10px;
}

.learning-profile {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.profile-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.profile-header {
    background-color: #ff8800;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.profile-header h3 {
    margin: 0;
    font-size: 1.2rem;
}

.profile-icon {
    width: 40px;
    height: 40px;
    background-color: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.profile-body {
    padding: 20px;
}

.preference-label {
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.style-progress {
    margin-top: 20px;
}

.progress-bar {
    height: 10px;
    background-color: #f2f2f2;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 5px;
}

.progress {
    height: 100%;
    background-color: #ff8800;
}

.progress-label {
    font-size: 0.9rem;
    color: #666;
}

.cluster-info {
    text-align: center;
}

.cluster-label {
    font-size: 1.8rem;
    font-weight: 600;
    color: #ff8800;
    margin-bottom: 10px;
}

.cluster-description {
    margin-bottom: 20px;
    font-size: 1rem;
    color: #444;
}

.cluster-stats {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.stat {
    text-align: center;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
}

.stat-label {
    font-size: 0.8rem;
    color: #666;
}

.no-cluster {
    text-align: center;
}

.btn-primary {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ff8800;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 15px;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #e67800;
}

.performance-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.subject-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.subject-header {
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f2f2f2;
}

.subject-header h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #333;
}

.subject-score {
    font-size: 1.3rem;
    font-weight: 600;
    color: #ff8800;
}

.subject-body {
    padding: 20px;
}

.subject-details {
    margin-top: 15px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.detail {
    font-size: 0.9rem;
    color: #666;
}

.detail-label {
    font-weight: 500;
}

.no-data {
    text-align: center;
    padding: 30px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.recommendations {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.recommendation-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.rec-thumbnail {
    height: 150px;
    position: relative;
    overflow: hidden;
}

.rec-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.rec-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 50px;
    height: 50px;
    background-color: rgba(255,136,0,0.8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.rec-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f5f5f5;
    font-size: 40px;
    color: #ff8800;
}

.rec-details {
    padding: 15px;
}

.rec-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 5px;
    color: #333;
}

.rec-subject {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.rec-type {
    margin-bottom: 10px;
}

.badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.badge.video {
    background-color: #f0f7ff;
    color: #0066cc;
}

.badge.reading {
    background-color: #f6f0ff;
    color: #6600cc;
}

.rec-description {
    color: #444;
    font-size: 0.9rem;
    margin-bottom: 15px;
    height: 40px;
    overflow: hidden;
}

.btn-secondary {
    display: inline-block;
    padding: 8px 15px;
    background-color: #f2f2f2;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background-color: #ff8800;
    color: white;
}

@media (max-width: 768px) {
    .learning-profile {
        grid-template-columns: 1fr;
    }
    
    .performance-cards,
    .recommendations {
        grid-template-columns: 1fr;
    }
}
</style>