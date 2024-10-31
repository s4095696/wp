<?php
include 'includes/db_connect.php'; 
include 'includes/header.php'; 
include 'includes/nav.php'; 

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
    $deleteSql = "DELETE FROM pets WHERE petid = $petId";
    
    if ($conn->query($deleteSql) === TRUE) {
        unlink($pet['image']);
        header("Location: pets.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

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
