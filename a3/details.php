<?php
include('includes/header.php');
include('includes/nav.php');
include('includes/db_connect.php'); 

// Fetch the pet details based on the pet ID from the URL
$petId = isset($_GET['petid']) ? $_GET['petid'] : null;

if ($petId) {
    $query = "SELECT * FROM pets WHERE petid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $petId);
    $stmt->execute();
    $result = $stmt->get_result();
    $pet = $result->fetch_assoc();
}

// Get selected pets from session storage
$selectedPets = json_decode($_SESSION['selectedPets'] ?? '[]', true);

// Fetch additional selected pet details if needed
$selectedPetDetails = [];
if (!empty($selectedPets)) {
    $placeholders = implode(',', array_fill(0, count($selectedPets), '?'));
    $query = "SELECT * FROM pets WHERE petid IN ($placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($selectedPets)), ...$selectedPets);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $selectedPetDetails[] = $row;
    }
}
?>

<main>
    <h1><?php echo $pet['petname']; ?></h1>
    <img src="<?php echo $pet['image']; ?>" alt="<?php echo $pet['petname']; ?>">
    <p><?php echo $pet['description']; ?></p>

    <h2>Your Selected Pets</h2>
    <div class="selected-pets">
        <?php if (!empty($selectedPetDetails)): ?>
            <?php foreach ($selectedPetDetails as $selectedPet): ?>
                <div class="selected-pet">
                    <img src="<?php echo $selectedPet['image']; ?>" alt="<?php echo $selectedPet['petname']; ?>">
                    <div><?php echo $selectedPet['petname']; ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No selected pets yet.</p>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>
