<?php 

function logout() {
    session_unset();
    session_destroy();
    echo json_encode(['status' => 'logged_out']); // Response for AJAX
}

// Check if logout is requested
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    header('Content-Type: application/json');  // Specify JSON content type
    logout();
    exit();
}
?>
