<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<?php include 'includes/db_connect.php'; // Include your database connection ?>

<div class="container-fluid">
    <h2 class="text-center mt-4">Discover Pets Victoria</h2>
    <p class="text-center">
        Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to connect these deserving pets with caring individuals and families, creating lifelong bonds. The organization offers a range of services, including adoption counseling, pet education, and community support programs, all aimed at promoting responsible pet ownership and reducing the number of homeless animals.
    </p>

    <div class="row mt-4">
        <!-- Left Column: Image -->
        <div class="col-md-6 text-center">
            <img src="images/pets.jpeg" alt="Pets" style="width: 600px; height: 400px;" class="img-fluid">
        </div>

        <!-- Right Column: Pets Table -->
        <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Pet ID</th>
                        <th>Pet Name</th>
                        <th>Description</th>
                        <th>Age</th>
                        <th>Location</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetching pets from the database
                    $sql = "SELECT * FROM pets";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data for each pet
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['petid']}</td>
                                    <td>{$row['petname']}</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['age']}</td>
                                    <td>{$row['location']}</td>
                                    <td>{$row['type']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No pets available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
