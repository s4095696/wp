<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<?php include 'includes/db_connect.php';?>

<div class="container-fluid carousel-welcome-section"> 
  <div class="row align-items-center" style="height: 50vh;">
    <div class="col-md-6 text-center">
      <div id="petCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <?php
          $query = "SELECT * FROM pets ORDER BY petid DESC LIMIT 4";
          $result = mysqli_query($conn, $query);

          if (!$result) {
              die("Database query failed: " . mysqli_error($conn));
          }

          $isFirst = true;
          while ($pet = mysqli_fetch_assoc($result)) {
              $activeClass = $isFirst ? 'active' : '';
              echo "<div class='carousel-item $activeClass'>";
              echo "<img src='{$pet['image']}' class='d-block' style='width: 500px; height: 300px;' alt='{$pet['petname']}'>"; // Use IMAGES directory
              echo "<div class='carousel-caption d-none d-md-block'>"; // Add caption if needed
              echo "</div></div>";
              $isFirst = false;
          }
          ?>
        </div>

        <a class="prev" href="#petCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="next" href="#petCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <div class="col-md-6 text-center">
      <div class="welcome-section">
        <h1><span style="color: orange;">PETS VICTORIA</span></h1>
        <h2>WELCOME TO PET ADOPTION</h2>
      </div>
    </div>
  </div>
</div>

<div class="search-section mt-4">
  <form action="search.php" method="GET">
    <div class="form-group row">
      <div class="col-sm-8">
        <input type="text" class="form-control" name="search_term" placeholder="I am looking for ...">
      </div>
      <div class="col-sm-2">
        <select class="form-control" name="pet_type">
          <option value="">Select your pet type</option>

          <?php
          $query = "SELECT DISTINCT type FROM pets";
          $result = mysqli_query($conn, $query);


          if ($result) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="' . htmlspecialchars($row['type']) . '">' . htmlspecialchars($row['type']) . '</option>';
              }
          } else {
              echo '<option value="">No pet types available</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-primary btn-block">Search</button>
      </div>
    </div>
  </form>
</div>

<div class="about-section mt-4">
  <h3>Discover Pets Victoria</h3>
  <p>Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. Our mission is to connect these deserving pets with caring families, creating lifelong bonds.</p>
</div>

<?php include 'includes/footer.php'; ?>
