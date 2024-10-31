<?php
include('includes/header.php');
include('includes/nav.php');
include('includes/db_connect.php');

$petName = $description = $age = $location = $type = $caption = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petName = mysqli_real_escape_string($conn, $_POST['petname']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'images/'; 
        $fileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); 
        $fileName = $petName . '.' . $fileType; 
        $uploadFile = $uploadDir . $fileName; 

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $sql = "INSERT INTO pets (petname, description, image, caption, age, location, type, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssdssss", $petName, $description, $uploadFile, $caption, $age, $location, $type, $_SESSION['username']);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Pet added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error adding pet.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error uploading image.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Image upload error: " . $_FILES['image']['error'] . "</div>";
    }
}
?>

<main>
    <h1>Add a Pet</h1>
    <form action="add.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="petname">Pet Name:</label>
            <input type="text" name="petname" id="petname" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="caption">Caption:</label>
            <input type="text" name="caption" id="caption" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" step="0.1" name="age" id="age" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" name="location" id="location" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" name="type" id="type" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Pet</button>
    </form>
</main>

<?php include('includes/footer.php'); ?>
