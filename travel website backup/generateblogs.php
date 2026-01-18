<?php
// Database connection
$servername = "localhost";
$username = "root"; // Adjust as needed
$password = "";     // Adjust as needed
$dbname = "blog_posts";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts ORDER BY date DESC";
$result = $conn->query($sql);

$blogs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogs[] = [
            'title' => $row['title'],
            'author' => $row['author'],
            'content' => $row['content'],
            'date' => $row['date'],
            'image' => $row['image']
        ];
    }
}

file_put_contents('blogs.json', json_encode($blogs, JSON_PRETTY_PRINT));

echo "Blogs JSON file generated successfully.";

$conn->close();
?>
