<?php include('includes/header.inc'); ?>
<?php include('includes/nav.inc'); ?>
<?php include('includes/db_connect.inc'); ?>

<main>
    <?php
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("SELECT * FROM pets WHERE petid = ?");
        $stmt->execute([$_GET['id']]);
        $pet = $stmt->fetch();
        
        if ($pet) {
            echo "<h2>" . $pet['petname'] . "</h2>";
            echo "<img src='images/" . $pet['image'] . "' alt='" . $pet['caption'] . "'>";
            echo "<p><strong>Description:</strong> " . $pet['description'] . "</p>";
            echo "<p><strong>Age:</strong> " . $pet['age'] . " months</p>";
            echo "<p><strong>Type:</strong> " . $pet['type'] . "</p>";
            echo "<p><strong>Location:</strong> " . $pet['location'] . "</p>";
        } else {
            echo "<p>Pet not found!</p>";
        }
    } else {
        echo "<p>No pet selected!</p>";
    }
    ?>
</main>

<?php include('includes/footer.inc'); ?>
