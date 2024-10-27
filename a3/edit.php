<?php
session_start();
include 'includes/db_connect.php'; // Database connection

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


if (isset($_GET['id'])) {
    $petId = intval($_GET['id']);
    
    // Fetch pet details
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
    // Update pet details
    $petName = $conn->real_escape_string($_POST['petname']);
    $description = $conn->real_escape_string($_POST['description']);
    $age = intval($_POST['age']);
    $location = $conn->real_escape_string($_POST['location']);
    $type = $conn->real_escape_string($_POST['type']);

    $updateSql = "UPDATE pets SET petname='$petName', description='$description', age='$age', location='$location', type='$type' WHERE petid = $petId";
    
    if ($conn->query($updateSql) === TRUE) {
        header("Location: pets.php"); // Redirect to pets page after updating
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Pet</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

<div class="container">
    <h2>Edit Pet</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="petname">Pet Name:</label>
            <input type="text" class="form-control" id="petname" name="petname" value="<?php echo htmlspecialchars($pet['petname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($pet['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($pet['age']); ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($pet['location']); ?>" required>
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo htmlspecialchars($pet['type']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Pet</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
