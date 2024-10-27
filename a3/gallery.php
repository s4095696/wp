<?php
include('includes/header.php');
include('includes/nav.php');
include('includes/db_connect.php'); 

// Fetch all unique pet types from the database
$typeQuery = "SELECT DISTINCT type FROM pets";
$typeResult = mysqli_query($conn, $typeQuery);

$petTypes = [];
if ($typeResult) {
    while ($row = mysqli_fetch_assoc($typeResult)) {
        $petTypes[] = $row['type'];
    }
}

// Fetch all pets
$query = "SELECT * FROM pets";
$result = mysqli_query($conn, $query);

$pets = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pets[] = $row; 
    }
}
?>

<main>
    <h1 class="text-center">Pets Victoria has a lot to offer!</h1>
    <p>For almost two decades, Pets Victoria has helped in creating true social change by bringing pet adoption into the mainstream. Our work has helped make a difference to the Victorian rescue community and thousands of pets in need of rescue and rehabilitation. But, until every pet is safe, respected, and loved, we all still have big, hairy work to do.</p>

    <div class="text-center">
        <select id="petType" class="form-control w-25 mx-auto mb-3">
            <option value="all">Select type...</option>
            <?php foreach ($petTypes as $type): ?>
                <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="gallery">
    <?php foreach ($pets as $pet): ?>
        <div class="gallery-item" data-type="<?php echo strtolower($pet['type']); ?>">
            <a href="details.php?petid=<?php echo $pet['petid']; ?>" class="pet-link" data-petid="<?php echo $pet['petid']; ?>">
                <img src="<?php echo $pet['image']; ?>" alt="<?php echo $pet['petname']; ?>">
                <div class="pet-name"><?php echo $pet['petname']; ?></div>
            </a>
        </div>
    <?php endforeach; ?>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
<script src="script.js"></script>

<?php include('includes/footer.php'); ?>
