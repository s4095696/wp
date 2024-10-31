<?php
session_start();  


function logout() {
    session_unset();   
    session_destroy(); 
}


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout(); 

    header("Location: index.php");
    exit();
}

header("Location: index.php");
exit();
?>
