<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection details
    $servername = "localhost";
    $dbUsername = "root"; // Set your database username
    $dbPassword = ""; // Set your database password
    $dbname = "blog_posts"; // Set your actual database name

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the query to check if the username exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user's data from the database
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set user session
            $_SESSION['user_id'] = $user['id']; // Store user id in session
            $_SESSION['username'] = $user['username']; // Store username in session

            // Redirect to the blog submission page
            header('Location: blog.php');
            exit();
        } else {
            echo "Invalid password. <a href='login.php'>Try again</a>";
        }
    } else {
        echo "Username not found. <a href='login.php'>Try again</a>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    :root {
        --primary-color: #C8102E; /* Crimson Red */
        --secondary-color: #212121; /* Pearl White */
        --bg-color: #F5F5F5; /* Light Gray Background for a Classy Look */
        --text-color: #333; /* Darker Gray for Text */
        --highlight-color: #A60026; /* Darker Crimson Red */
        --accent-color: #4A773C; /* Zen Garden Green */
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column; /* Align items vertically */
        height: 100vh;
        background-color: var(--bg-color);
        color: var(--text-color);
        margin: 0;
        font-family: 'Helvetica Neue', Arial, sans-serif;
    }

    .login-container {
        background: white;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        margin: 0 auto; /* Center the container */
    }

    h1 {
        margin-bottom: 1.5rem;
        text-align: center;
    }

    label {
        font-weight: bold;
    }

    @media (max-width: 576px) {
        .login-container {
            padding: 1rem;
        }
    }

    .icon {
        width: 200px;
        height: 100px;
        margin: 20px auto; /* Center the icon horizontally and add top margin */
        font-size: 20px;
        transition: color 0.3s ease-in-out;
    }

    .icon:hover {
        color: var(--highlight-color); /* Darker Crimson Red Hover */
        transform: scale(1.02);
    }

    .navbar-nav .nav-link,
    .navbar-brand {
        font-size: 21px;
        color: black !important;
        margin-right: 50px;
    }

    .navbar-nav .nav-link:hover,
    .navbar-brand .logo:hover {
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
</style>

</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="register.php" class="btn btn-secondary">Sign Up</a> <!-- Register button -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


