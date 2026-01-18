<?php
session_start();

$post_id = $_POST['post_id'];
$action = $_POST['action'];

// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Set your database password
$dbname = "blog_posts"; // Set your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postId = $_POST['post_id'] ?? null; // Get the post ID
    $action = $_POST['action'] ?? null; // Get the action
    $userId = $_SESSION['user_id']; // Assume user ID is stored in the session

    error_log("Received Post ID: " . var_export($postId, true)); // Log the post ID
    error_log("Received Action: " . var_export($action, true)); // Log the action

    if (!$postId || !$action) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit();
    }

    // Check if action already exists for this user and post
    $query = "SELECT action FROM post_likes_dislikes WHERE user_id = ? AND post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existingAction = $row['action'];

        // Prevent changing from like to dislike or vice versa
        echo json_encode(['success' => false, 'message' => 'You have already ' . $existingAction . 'd this post.']);
        exit();
    } else {
        // Insert new like or dislike record
        $insertActionQuery = "INSERT INTO post_likes_dislikes (user_id, post_id, action) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertActionQuery);
        $stmt->bind_param("iis", $userId, $postId, $action);
        $stmt->execute();

        // Update like or dislike count in the posts table
        if ($action == 'like') {
            $updateLikes = "UPDATE posts SET likes = likes + 1 WHERE id = ?";
            $stmt = $conn->prepare($updateLikes);
            $stmt->bind_param("i", $postId);
            $stmt->execute();
        } elseif ($action == 'dislike') {
            $updateDislikes = "UPDATE posts SET dislikes = dislikes + 1 WHERE id = ?";
            $stmt = $conn->prepare($updateDislikes);
            $stmt->bind_param("i", $postId);
            $stmt->execute();
        }

        // Response with updated counts
        $queryCounts = "SELECT likes, dislikes FROM posts WHERE id = ?";
        $stmt = $conn->prepare($queryCounts);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        $postCounts = $result->fetch_assoc();

        echo json_encode([
            'success' => true, 
            'message' => 'Action processed successfully', 
            'likes' => $postCounts['likes'], 
            'dislikes' => $postCounts['dislikes']
        ]);
    }

    $stmt->close();
}

$conn->close();
?>
