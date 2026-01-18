<?php
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

// Query to fetch posts from the database
$sql = "SELECT id, title, content, author, date, image, likes, dislikes FROM posts";
$result = $conn->query($sql);

$blogs = array();
if ($result->num_rows > 0) {
    // Fetch all the rows into an associative array
    while($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
}

// Return the posts in JSON format
header('Content-Type: application/json');
echo json_encode($blogs);

$conn->close();
?>
