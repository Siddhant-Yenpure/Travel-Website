<?php
session_start(); // Start the session

// Destroy the session and clear session variables
$_SESSION = []; // Clear all session variables
session_destroy(); // Destroy the session

// Redirect to the login page (or home page)
header('Location: login.php');
exit();
?>
