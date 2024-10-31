<?php
include('includes/header.php');
include('includes/nav.php');
include('includes/db_connect.php');

// Check if `petid` is provided in the URL
if (!isset($_GET['petid'])) {
    echo "<p>Pet ID not specified. Please go back and select a pet to view details.</p>";
    include('includes/footer.php');
    exit();
}

// Sanitize and fetch the `petid` from the URL
$petid = intval($_GET['petid']); // Ensures petid is an integer

// Fetch pet details using prepared statements
$petQuery = "SELECT * FROM pets WHERE petid = ?";
$petStmt = $conn->prepare($petQuery);

if (!$petStmt) {
    die("Prepare failed: " . $conn->error);
}

$petStmt->bind_param("i", $petid);
$petStmt->execute();
$petResult = $petStmt->get_result();

if ($petResult->num_rows == 0) {
    echo "<p>No pet found with the specified ID.</p>";
    include('includes/footer.php');
    exit();
}

$pet = $petResult->fetch_assoc(); // Get the pet details

// Close the statement and connection
$petStmt->close();
$conn->close();
?>

<main>
    <h2><?php echo htmlspecialchars($pet['petname']); ?></h2>
    <div class="pet-details">
        <img src="<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['petname']); ?>">
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($pet['description'])); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> years old</p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($pet['location']); ?></p>
    </div>
</main>

<?php include('includes/footer.php'); ?>
