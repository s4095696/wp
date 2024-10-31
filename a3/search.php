<?php 
include('includes/header.php');
include('includes/nav.php');
include('includes/db_connect.php'); 

$searchResults = [];
$searchTerm = '';
$petType = '';

if (!empty($_GET['search_term'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search_term']);
}

if (!empty($_GET['pet_type'])) {
    $petType = mysqli_real_escape_string($conn, $_GET['pet_type']);
}

$query = "SELECT * FROM pets WHERE 1=1"; 

if (!empty($searchTerm)) {
    $query .= " AND (petname LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%')";
}

if (!empty($petType)) {
    $query .= " AND type = '$petType'";
}

$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $searchResults[] = $row;
    }
}
?>

<main>
    <div class="container">
        <h1 class="text-center">Search Results</h1>
        
        <?php if (!empty($searchTerm) || !empty($petType)): ?>
            <h2 class="text-center">
                Results for: 
                <strong><?php echo htmlspecialchars($searchTerm); ?></strong>
                <?php if (!empty($petType)): ?>
                    <br>Pet Type: <strong><?php echo htmlspecialchars($petType); ?></strong>
                <?php endif; ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($searchResults)): ?>
            <div class="gallery">
                <?php foreach ($searchResults as $pet): ?>
                    <div class="gallery-item" data-type="<?php echo strtolower($pet['type']); ?>">
                        <a href="details.php?petid=<?php echo $pet['petid']; ?>">
                            <img src="<?php echo htmlspecialchars($pet['image']); ?>" alt="<?php echo htmlspecialchars($pet['petname']); ?>">
                            <div class="pet-name"><?php echo htmlspecialchars($pet['petname']); ?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif (empty($searchTerm) && empty($petType)): ?>
            <h2 class="text-center">Please enter a search term or select a pet type.</h2>
        <?php else: ?>
            <p class="text-center">No results found for "<strong><?php echo htmlspecialchars($searchTerm); ?></strong>".</p>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>
