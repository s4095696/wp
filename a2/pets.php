<?php include('includes/header.inc'); ?>
<?php include('includes/nav.inc'); ?>
<?php include('includes/db_connect.inc'); ?>

<main>
    <h2>Our Pets</h2>
    <table>
        <tr>
            <th>Pet Name</th>
            <th>Age</th>
            <th>Type</th>
            <th>Location</th>
            <th>Caption</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT petid, petname, age, type, location, caption FROM pets");
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td><a href='details.php?id=" . $row['petid'] . "'>" . $row['petname'] . "</a></td>";
            echo "<td>" . $row['age'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['location'] . "</td>";
            echo "<td>" . $row['caption'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</main>

<?php include('includes/footer.inc'); ?>
