<?php
session_start(); // Start the session to access session variables

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog_posts";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $content = $_POST['content'] ?? '';
    $date = date('Y-m-d H:i:s');
    $likes = 0; // Initialize likes to 0
    $dislikes = 0; // Initialize dislikes to 0

    // Check if 'image' is set in $_FILES
    if (isset($_FILES['image'])) {
        // Handle file upload
        $targetDir = "uploads/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . uniqid() . "_" . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Validate and upload file
        $uploadOk = 1;

        // Check if the uploaded file is an image
        if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["image"]["size"] > 500000000000000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Check file type
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
        } else {
            echo "Error uploading file: " . $_FILES["image"]["error"];
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // Insert into MySQL database, including likes and dislikes
                $sql = "INSERT INTO posts (title, author, content, date, image, likes, dislikes) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssss", $title, $author, $content, $date, $targetFilePath, $likes, $dislikes);

                if ($stmt->execute()) {
                    echo "Blog submitted successfully!";

                    // Fetch the newly inserted blog post
                    $postId = $stmt->insert_id;
                    $sql = "SELECT * FROM posts WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $postId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $newPost = $result->fetch_assoc();

                    // Prepare the blog post for JSON file
                    $newBlogPost = [
                        'title' => $newPost['title'],
                        'author' => $newPost['author'],
                        'content' => $newPost['content'],
                        'date' => $newPost['date'],
                        'image' => $newPost['image'],
                        'likes' => $newPost['likes'],  // Include likes
                        'dislikes' => $newPost['dislikes']  // Include dislikes
                    ];

                    // Read the existing JSON file
                    $jsonFile = 'blogs.json';
                    $blogData = json_decode(file_get_contents($jsonFile), true);

                    if ($blogData === null) {
                        $blogData = []; // Initialize if JSON is empty
                    }

                    // Append the new blog post to the JSON data
                    $blogData[] = $newBlogPost;

                    // Write the updated data back to blogs.json
                    file_put_contents($jsonFile, json_encode($blogData, JSON_PRETTY_PRINT));

                    echo " and added to blogs.json!";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your image.";
            }
        }
    } else {
     
    }
}

$conn->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
   
    </script>
    <style>
        /* Color Variables */
        :root {
            --primary-color: #C8102E; /* Crimson Red */
            --secondary-color: #212121; /* Pearl White */
            --bg-color: #F5F5F5; /* Light Gray Background for a Classy Look */
            --text-color: #333; /* Darker Gray for Text */
            --highlight-color: #A60026; /* Darker Crimson Red */
            --accent-color: #4A773C; /* Zen Garden Green */
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        .icon {
    width: 200px;
    height: 100px;
    margin-left: 20px;
    margin-top: 40px;
    font-size: 20px;
    transition: color 0.3s ease-in-out;
}

.icon:hover {
    color: var(--highlight-color); /* Darker Crimson Red Hover */
    transform: scale(1.02);
}
        .navbar-nav .nav-link, .navbar-brand  {
    font-size: 21px;
    color: black !important;
    margin-right: 50px;


}

.navbar-nav .nav-link:hover, .navbar-brand .logo:hover {
    color: crimson !important;
}

        header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .info-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .info-card img:hover {
            transform: scale(1.01);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .info-card img {
            width: 100%;
            height: 300px; /* Adjusted height for a balanced look */
            object-fit: cover; /* Ensures image maintains aspect ratio */
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .info-card h2 {
            color: var(--primary-color);
            margin-top: 0;
            font-size: 1.6em; /* Adjusted font size */
        }

        .info-box {
            background-color: #f9f9f9;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #eee;
        }

        .info-box p {
            margin: 0;
            color: var(--text-color);
            line-height: 1.6;
        }

        .info-box h3 {
            margin-top: 0;
            color: var(--primary-color);
            font-size: 1.4em;
        }

        .info-box img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
        }
        
        body {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    background-color: var(--bg-color);
    color: var(--text-color);
}

.info-card {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.info-card h1 {
    color: var(--primary-color);
    text-align: center;
    margin-bottom: 20px;
}

.info-card input,
.info-card textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.info-card button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100%;
}

.info-card button:hover {
    background-color: var(--highlight-color);
}

.back-link {
    display: block;
    margin-top: 20px;
    text-align: center;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: bold;
    border: 1px solid var(--primary-color);
    padding: 10px 15px;
    border-radius: 4px;
    transition: background-color 0.3s, color 0.3s;
}

.back-link:hover {
    background-color: var(--primary-color);
    color: white;
}

@media (max-width: 768px) {
    .info-card {
        padding: 15px;
    }
}
      

    </style>
</head>
<div class="main">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand icon" href="main.php">
                    <h2 class="logo text-shadow">XPLORE</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="main.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="main.php#destinations">Destinations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#news">Tours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#news">Travel Tips</a>
                        </li>
                        <li class="nav-item"></li>
                            <a class="nav-link" aria-current="page" href="blog.php">Blog</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                More
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#contactform">About Us</a></li>
                                <li><a class="dropdown-item" href="#contactform">Contact Us</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2 srch" type="search" placeholder="Search destinations" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    <div class="container">
        <div class="info-card" id="info-card">
            <h1>Submit Your Blog Post</h1>
            <form action="submitblog.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Blog Title" required>
        <input type="text" name="author" placeholder="Author Name" required>
        <textarea name="content" placeholder="Blog Content" required></textarea>
        <input type="file" name="image" accept="image/*" required> <!-- This input must have the name 'image' -->
        <button type="submit" class="btn btn-primary">Submit Blog</button>
    </form>       </div>
    </div>
    <div class="section"  id="news">
        <h2 class="section-title">Latest News</h2>
        <div class="news-grid">
            <div class="news-item">
                <img src="fuji.jpg" alt="News Image 1" class="news-image">
                <p class="news-text">Discover the top hidden travel gems in Japan for 2024.</p>
            </div>
            <div class="news-item">
                <img src="cherry blossom.jpeg" alt="News Image 2" class="news-image">
                <p class="news-text">Explore Japan's cherry blossom season highlights and best viewing spots.</p>
            </div>
            <div class="news-item">
                <img src="hot springs.jpeg" alt="News Image 3" class="news-image">
                <p class="news-text">Guide to Japan's most picturesque onsen (hot springs) for relaxation and rejuvenation.</p>
            </div>
        </div>
        
    </div>

    <div class="contact-form" id="contactform">
        <h2>Contact Us</h2>
        <form action="#" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            
            <button type="submit" class="btn">Send</button>
        </form>
    </div>

    <footer>
        <p>By using our Website, you agree to abide by our terms and conditions. For more details, please review our full Terms and Conditions.</p>
        <p>&copy; 2024 Plane Showcase. All rights reserved.</p>
    </footer>
</div>
