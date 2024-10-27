<?php
include('includes/header.php');
include('includes/nav.php');
include('includes/db_connect.php'); 

$searchResults = [];
$searchTerm = '';

// Check if a search term is provided in the URL
if (isset($_GET['search_term'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search_term']);

    // SQL query to search pets by name or type
    $query = "SELECT * FROM pets WHERE petname LIKE '%$searchTerm%' OR type LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $searchResults[] = $row;
        }
    } 
}
?>

<main>
    <div class="container">
        <h1 class="text-center">Search Results</h1>
        <?php if ($searchTerm): ?>
            <h2 class="text-center">Results for: <strong><?php echo htmlspecialchars($searchTerm); ?></strong></h2>
        <?php else: ?>
            <h2 class="text-center">Please enter a search term.</h2>
        <?php endif; ?>

        <?php if (!empty($searchResults)): ?>
            <div class="gallery">
                <?php foreach ($searchResults as $pet): ?>
                    <div class="gallery-item" data-type="<?php echo strtolower($pet['type']); ?>">
                        <a href="details.php?petid=<?php echo $pet['petid']; ?>">
                            <img src="<?php echo $pet['image']; ?>" alt="<?php echo $pet['petname']; ?>">
                            <div class="pet-name"><?php echo $pet['petname']; ?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">No results found for "<strong><?php echo htmlspecialchars($searchTerm); ?></strong>".</p>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>
