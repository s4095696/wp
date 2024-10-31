<?php
session_start();  

// Function to handle logout
function logout() {
    session_unset();   // Unset all session variables
    session_destroy(); // Destroy the session
}

// Check if logout is requested
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout(); // Call logout function
    // Redirect to home page after logout
    header("Location: index.php");
    exit();
}

// If the action isn't specified, redirect to home
header("Location: index.php");
exit();
?>
