<?php
session_start();
$post_id = $_POST['post_id'];

// Check if the user has already liked the post in the session
if (isset($_SESSION['liked_posts'][$post_id]) && $_SESSION['liked_posts'][$post_id] === true) {
    echo json_encode(['liked' => true]);
} else {
    echo json_encode(['liked' => false]);
}
?>
