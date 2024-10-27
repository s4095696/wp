<?php
include('includes/header.php');
include('includes/nav.php');
include('includes/db_connect.php');

// Initialize variables for form data and error messages
$petName = $petType = $description = $caption = $age = $location = "";
$errors = [];

// Process the form if it's submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $petName = mysqli_real_escape_string($conn, $_POST['petName']);
    $petType = mysqli_real_escape_string($conn, $_POST['petType']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $age = (int)$_POST['age'];
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    // Sanitize the pet name to use in the file name
    $sanitizedPetName = preg_replace('/[^A-Za-z0-9]/', '', $petName); // Remove special characters
    $targetDir = "images/"; // Directory for saving uploaded images
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . $sanitizedPetName . '.' . $imageFileType;

    // Check if image file is a valid image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $errors[] = "File is not an image.";
    }

    // Check file size (limit to 2MB)
    if ($_FILES["image"]["size"] > 2000000) {
        $errors[] = "Sorry, your file is too large.";
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // If no errors, try to upload the file
    if (empty($errors)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Update the caption to match the new filename
            $caption = basename($targetFile); // e.g., petname.jpg

            // Prepare the SQL statement with the updated caption and image path
            $sql = "INSERT INTO pets (petname, type, description, image, caption, age, location) 
                    VALUES ('$petName', '$petType', '$description', '$targetFile', '$caption', $age, '$location')";
            
            if (mysqli_query($conn, $sql)) {
                // Redirect to the gallery page after successful insertion
                header("Location: gallery.php");
                exit();
            } else {
                $errors[] = "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            $errors[] = "Sorry, there was an error uploading your file.";
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<style>
    main {
        padding: 20px; /* Adjust padding as needed */
    }
</style>

<main>
    <h1 class="text-center">Add a Pet</h1>
    <p class="text-center">You can add a new pet here.</p>

    <form action="register.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="petName">Pet Name <span class="text-danger">*</span></label>
            <input type="text" name="petName" id="petName" class="form-control" required alt="PROVIDE A NAME FOR THE PET" value="<?php echo htmlspecialchars($petName); ?>">
        </div>
        <div class="form-group">
            <label for="petType">Type <span class="text-danger">*</span></label>
            <select name="petType" id="petType" class="form-control" required alt="--CHOOSE AN OPTION--">
                <option value="">--CHOOSE AN OPTION--</option>
                <option value="cat" <?php echo ($petType == 'cat') ? 'selected' : ''; ?>>Cats</option>
                <option value="dog" <?php echo ($petType == 'dog') ? 'selected' : ''; ?>>Dogs</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description <span class="text-danger">*</span></label>
            <textarea name="description" id="description" class="form-control" required alt="DESCRIBE THE PET BRIEFLY"><?php echo htmlspecialchars($description); ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Select an Image <span class="text-danger">*</span></label>
            <input type="file" name="image" id="image" class="form-control" required alt="SELECT AN IMAGE:">
        </div>
        <div class="form-group">
            <label for="caption">Image Caption <span class="text-danger">*</span></label>
            <input type="text" name="caption" id="caption" class="form-control" required alt="DESCRIBE THE IMAGE IN ONE WORD" value="<?php echo htmlspecialchars($caption); ?>">
        </div>
        <div class="form-group">
            <label for="age">Age <span class="text-danger">*</span></label>
            <input type="number" name="age" id="age" class="form-control" required alt="AGE OF THE PET" value="<?php echo htmlspecialchars($age); ?>">
        </div>
        <div class="form-group">
            <label for="location">Location <span class="text-danger">*</span></label>
            <input type="text" name="location" id="location" class="form-control" required alt="LOCATION OF THE PET" value="<?php echo htmlspecialchars($location); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Add Pet</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include('includes/footer.php'); ?>
