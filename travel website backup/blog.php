<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Database connection (already included in this file)
$servername = "localhost";
$username = "root";
$password = ""; // For XAMPP, the default password is empty
$dbname = "blog_posts"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch posts from the database
$query = "SELECT id, title, content, likes, dislikes FROM posts";
$result = $conn->query($query);



// Close the connection
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        .restaurant, .places_to_stay, .means_of_transport {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Space between tiles */
        }

        .restaurant img, .places_to_stay img, .means_of_transport img {
            max-width: 150px; /* Set a specific width */
    height: 150px; /* Set a specific height */
    object-fit: cover; /* Ensure images maintain their aspect ratio */
    border-radius: 8px;
    margin-bottom: 10px;
    display: block; /* Make the images block-level elements */
    margin-left: auto; /* Center the image horizontally */
    margin-right: auto; /* Center the image horizontally */
        }

        .restaurant div, .places_to_stay div, .means_of_transport div {
            flex: 1;
            min-width: 200px; /* Set a minimum width for each tile */
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center the text within each tile */

        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
            border: 1px solid var(--primary-color);
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
            text-align: center;
        }

        .back-link:hover {
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .info-card img {
                height: auto; /* Adjust image height for smaller screens */
            }

            .back-link {
                display: block;
                width: 100%;
                text-align: center;
            }
        }

        .blog-post {
            margin-bottom: 30px;
        }

        .blog-post .card {
            border: none; /* Remove default border */
            border-radius: 10px;
            overflow: hidden; /* Ensures rounded corners on the image */
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .blog-post .card:hover {
            transform: translateY(-5px); /* Subtle lift effect on hover */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Shadow effect on hover */
        }

        .blog-post img {
            height: 200px; /* Set a specific height for the blog images */
            object-fit: cover; /* Maintain aspect ratio */
        }

        .blog-post .card-title {
            color: var(--primary-color);
            font-size: 1.5em; /* Increased font size for better visibility */
            margin-top: 15px;
        }

        .blog-post .card-text {
            font-size: 0.95em; /* Slightly smaller font size for the text */
            color: var(--text-color);
            margin-bottom: 15px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .info-card img {
                height: auto; /* Adjust image height for smaller screens */
            }

            .back-link {
                display: block;
                width: 100%;
                text-align: center;
            }

            .blog-post img {
                height: 150px; /* Adjust height for smaller screens */
            }
        }

        .like-dislike-container {
        display: flex;
        justify-content: flex-start;
        gap: 10px; /* Space between the buttons */
        margin-top: 10px;
    }

    .like-btn, .dislike-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9rem;
        transition: background-color 0.3s ease-in-out;
    }

    .like-btn:hover {
        background-color: #28a745; /* Darker green on hover */
        color: white;
    }

    .dislike-btn:hover {
        background-color: #dc3545; /* Darker red on hover */
        color: white;
    }

      

    </style>
</head>
<body>
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
        <div class="container mt-5">
            <h1 class="text-center">Travel Blogs</h1>
            <div id="blog-posts" class="row">
    <!-- Blogs will be injected here by jQuery -->
    <button class="like-btn" data-post-id="1">Like</button>
    <button class="dislike-btn" data-post-id="1">Dislike</button>
</div>



            <form action="submitblog.php" method="POST">
    <button type="submit" class="btn btn-primary btn-block">Submit Blog</button>
</form>
<br>
<form action="logout.php" method="POST">
    <button type="submit" class="btn btn-danger">Logout</button>
</form>

            

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

<script>
    $(document).ready(function () {
        // Load blog posts
        $.ajax({
            url: 'fill.php', 
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                let blogHTML = '';
                $.each(data, function (i, blog) {
                    let imagePath = blog.image;
                    let shortContent = blog.content.substring(0, 100) + '...';
                    let postId = blog.id;

                    blogHTML += `
                    <div class="col-md-6 blog-post mb-4" data-post-id="${postId}">
                        <div class="card">
                            <img src="${imagePath}" class="card-img-top" alt="${blog.title}" 
                                onerror="this.onerror=null; this.src='path/to/default/image.png';">
                            <div class="card-body">
                                <h5 class="card-title">${blog.title}</h5>
                                <p class="card-text">${shortContent}</p>
                                <p class="text-muted">By ${blog.author} on ${blog.date}</p>
                                <div class="like-dislike-container">
                                    <button class="like-btn btn btn-sm btn-success" data-post-id="${postId}">Like (${blog.likes})</button>
                                    <button class="dislike-btn btn btn-sm btn-danger" data-post-id="${postId}">Dislike (${blog.dislikes})</button>
                                </div>
                                <a href="post.html?id=${postId}" class="btn btn-primary mt-2">Read More</a>
                            </div>
                        </div>
                    </div>`;
                });

                $('#blog-posts').html(blogHTML);

                // After loading the posts, check the user's actions
                checkUserActions();
            },
            error: function (xhr, status, error) {
                console.log("Error fetching data: " + error);
            }
        });

        // Check user's like/dislike actions for all posts
        function checkUserActions() {
            $('.blog-post').each(function () {
                var postId = $(this).data('post-id');
                var likeBtn = $(this).find('.like-btn');
                var dislikeBtn = $(this).find('.dislike-btn');

                $.ajax({
                    url: 'check_action.php',
                    method: 'POST',
                    data: { post_id: postId },
                    success: function (response) {
                        var res = JSON.parse(response);
                        if (res.action === 'like') {
                            likeBtn.prop('disabled', true).text('Liked!');
                            dislikeBtn.prop('disabled', true);
                        } else if (res.action === 'dislike') {
                            dislikeBtn.prop('disabled', true).text('Disliked!');
                            likeBtn.prop('disabled', true);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error checking action: " + error);
                    }
                });
            });
        }

        // Delegated event listeners for like and dislike buttons
        $('#blog-posts').on('click', '.like-btn', function () {
            var postId = $(this).data('post-id');
            processAction(postId, 'like', $(this));
        });

        $('#blog-posts').on('click', '.dislike-btn', function () {
            var postId = $(this).data('post-id');
            processAction(postId, 'dislike', $(this));
        });

        // Function to process like/dislike action
        function processAction(postId, action, button) {
            $.ajax({
                url: 'like_dislike.php',
                method: 'POST',
                data: { post_id: postId, action: action },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.success) {
                        button.prop('disabled', true).text(action.charAt(0).toUpperCase() + action.slice(1) + 'd!');
                        button.siblings('button').prop('disabled', true);
                    } else {
                        alert(res.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error processing action: " + error);
                }
            });
        }
    });
</script>


    



</body>
</html>

   



