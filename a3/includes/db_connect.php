<?php
if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "petsvictoria";
    $conn = "";
} else {
    $servername = "talsprddb02.int.its.rmit.edu.au";
    $username = "s4095696";
    $password = "Vaughan27!@#";
    $dbname = "s4095696";
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
