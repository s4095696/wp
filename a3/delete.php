<?php
session_start();
include 'includes/db_connect.php'; // Database connection

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $petId = intval($_GET['id']);
    
    // Fetch pet details for confirmation
    $sql = "SELECT * FROM pets WHERE petid = $petId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $pet = $result->fetch_assoc();
    } else {
        echo "No pet found!";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete pet
    $deleteSql = "DELETE FROM pets WHERE petid = $petId";
    
    if ($conn->query($deleteSql) === TRUE) {
        // Optionally delete the image from the filesystem if necessary
        unlink($pet['image']); // Ensure this path is correct
        header("Location: pets.php"); // Redirect to pets page after deletion
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Pet</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

<div class="container">
    <h2>Delete Pet</h2>
    <p>Are you sure you want to delete the pet: <strong><?php echo htmlspecialchars($pet['petname']); ?></strong>?</p>
    <form method="POST" action="">
        <button type="submit" class="btn btn-danger">Delete Pet</button>
        <a href="pets.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
