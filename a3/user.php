<?php
include('includes/header.php');
include('includes/nav.php');
include('includes/db_connect.php');

if (!isset($_SESSION['username'])) {
    echo "<p>Please log in to view your created pets.</p>";
    include('includes/footer.php');
    exit();
}

$username = $_SESSION['username'];

$userPetsQuery = "SELECT * FROM pets WHERE username = ?";
$userPetsStmt = $conn->prepare($userPetsQuery);

if (!$userPetsStmt) {
    die("Prepare failed: " . $conn->error);
}

$userPetsStmt->bind_param("s", $username);
$userPetsStmt->execute();
$userPetsResult = $userPetsStmt->get_result();

$userPets = [];
while ($row = $userPetsResult->fetch_assoc()) {
    $userPets[] = $row;
}

$userPetsStmt->close();
$conn->close();
?>

<main>
    <h2>Your Created Pets</h2>
    <div class="user-pets">
        <?php if (!empty($userPets)): ?>
            <?php foreach ($userPets as $userPet): ?>
                <div class="user-pet">
                    <img src="<?php echo htmlspecialchars($userPet['image']); ?>" alt="<?php echo htmlspecialchars($userPet['petname']); ?>">
                    <h3><?php echo htmlspecialchars($userPet['petname']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($userPet['description'])); ?></p>

                    <div class="action-buttons">
                        <a href="edit.php?petid=<?php echo $userPet['petid']; ?>" class="btn btn-primary">Edit</a>
                        <a href="delete.php?id=<?php echo $userPet['petid']; ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No pets found created by you.</p>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>
