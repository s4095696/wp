<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable error reporting for debugging

include 'includes/db_connect.php'; // Include your database connection
include 'includes/header.php';
include 'includes/nav.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$pet = []; // Initialize pet variable

if (isset($_GET['id'])) {
    $petId = intval($_GET['id']);

    // Fetch pet details
    $stmt = $conn->prepare("SELECT * FROM pets WHERE petid = ? AND username = ?");
    $stmt->bind_param("is", $petId, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pet = $result->fetch_assoc(); // Get the pet details
    } else {
        echo "<div class='alert alert-warning'>Pet not found or you don't have permission to edit this pet.</div>";
        exit();
    }
}

// Process form submission for updating pet details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petName = $conn->real_escape_string($_POST['petname']);
    $description = $conn->real_escape_string($_POST['description']);
    $age = floatval($_POST['age']);
    $location = $conn->real_escape_string($_POST['location']);
    $type = $conn->real_escape_string($_POST['type']);
    $caption = $conn->real_escape_string($_POST['caption']); // Capture caption

    // Initialize SQL statement
    $updateSql = "UPDATE pets SET petname = ?, description = ?, age = ?, location = ?, type = ?, caption = ? WHERE petid = ? AND username = ?";
    $stmt = $conn->prepare($updateSql);
    
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssissssi", $petName, $description, $age, $location, $type, $caption, $petId, $username);
        
        // Execute the update statement
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Pet details updated successfully!";
            header("Location: user.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error updating record: " . $stmt->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>";
    }

    // Handle image upload if exists
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['image']['name'];
        $imageFileType = pathinfo($imageFileName, PATHINFO_EXTENSION);
        $newImageFileName = "images/{$petName}.$imageFileType"; // Create new file name
        
        // Move the uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $newImageFileName)) {
            // Update SQL to include image
            $updateImageSql = "UPDATE pets SET image = ? WHERE petid = ? AND username = ?";
            $imageStmt = $conn->prepare($updateImageSql);
            $imageStmt->bind_param("sis", $newImageFileName, $petId, $username);
            if ($imageStmt->execute()) {
                $_SESSION['success_message'] = "Pet details and image updated successfully!";
                header("Location: user.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error updating image: " . $imageStmt->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Image upload error: " . $_FILES['image']['error'] . "</div>";
        }
    }
}
?>

<div class="container">
    <h2>Edit Pet</h2>

    <!-- Display Success or Error Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?php echo $petId; ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="petname">Pet Name:</label>
            <input type="text" class="form-control" id="petname" name="petname" value="<?php echo htmlspecialchars($pet['petname'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($pet['description'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <small class="form-text text-muted">Leave blank if you don't want to change the image.</small>
        </div>
        <div class="form-group">
            <label for="caption">Caption:</label>
            <input type="text" class="form-control" id="caption" name="caption" value="<?php echo htmlspecialchars($pet['caption'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" step="0.1" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($pet['age'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($pet['location'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control" id="type" name="type" value="<?php echo htmlspecialchars($pet['type'] ?? ''); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Pet</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
