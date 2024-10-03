<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('includes/db_connect.inc');
    
    $petname = $_POST['petname'];
    $description = $_POST['description'];
    $caption = $_POST['caption'];
    $age = $_POST['age'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    
    // Handling file upload
    $image = $_FILES['image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO pets (petname, description, caption, age, type, location, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$petname, $description, $caption, $age, $type, $location, $image]);
        
        echo "Pet added successfully!";
    } else {
        echo "Error uploading image.";
    }
}
?>

<?php include('includes/header.inc'); ?>
<?php include('includes/nav.inc'); ?>

<main>
    <h2>Add a New Pet</h2>
    <form action="add.php" method="POST" enctype="multipart/form-data">
        <label>Pet Name:</label>
        <input type="text" name="petname" required>
        
        <label>Description:</label>
        <textarea name="description" required></textarea>
        
        <label>Caption:</label>
        <input type="text" name="caption" required>
        
        <label>Age (in months):</label>
        <input type="number" step="0.1" name="age" required>
        
        <label>Type:</label>
        <input type="text" name="type" required>
        
        <label>Location:</label>
        <input type="text" name="location" required>
        
        <label>Image:</label>
        <input type="file" name="image" required>
        
        <button type="submit">Add Pet</button>
    </form>
</main>

<?php include('includes/footer.inc'); ?>
