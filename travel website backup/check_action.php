<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['action' => null]);
    exit();
}

$userId = $_SESSION['user_id'];
$postId = $_POST['post_id'];

$servername = "localhost";
$username = "root";
$password = ""; // Set your database password
$dbname = "blog_posts";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT action FROM post_likes_dislikes WHERE user_id = ? AND post_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $userId, $postId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['action' => $row['action']]);
} else {
    echo json_encode(['action' => null]);
}

$stmt->close();
$conn->close();
?>
