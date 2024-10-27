<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

<div class="container-fluid carousel-welcome-section"> <!-- Added cream background for this section -->
  <div class="row align-items-center" style="height: 50vh;"> <!-- Adjusts to 50% of the viewport height -->
    <!-- Left Column: Carousel for recent pet images -->
    <div class="col-md-6 text-center">
      <div id="petCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="images/cat1.jpeg" class="d-block" style="width: 500px; height: 300px;" alt="Pet 1">
          </div>
          <div class="carousel-item">
            <img src="images/dog1.jpeg" class="d-block" style="width: 500px; height: 300px;" alt="Pet 2">
          </div>
          <!-- More carousel items -->
        </div>
        <a class="carousel-control-prev" href="#petCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#petCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <!-- Right Column: Welcome section -->
    <div class="col-md-6 text-center">
      <div class="welcome-section">
        <h1><span style="color: orange;">PETS VICTORIA</span></h1>
        <h2>WELCOME TO PET ADOPTION</h2>
      </div>
    </div>
  </div>
</div>

<!-- Search bar and filters -->
<div class="search-section mt-4">
  <form action="search.php" method="GET">
    <div class="form-group row">
      <div class="col-sm-8">
        <input type="text" class="form-control" name="search_term" placeholder="I am looking for ...">
      </div>
      <div class="col-sm-2">
        <select class="form-control" name="pet_type">
          <option value="">Select your pet type</option>
          <option value="dog">Dog</option>
          <option value="cat">Cat</option>
        </select>
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-primary btn-block">Search</button>
      </div>
    </div>
  </form>
</div>

<!-- Introduction to Pets Victoria -->
<div class="about-section mt-4">
  <h3>Discover Pets Victoria</h3>
  <p>Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. Our mission is to connect these deserving pets with caring families, creating lifelong bonds.</p>
</div>

<?php include 'includes/footer.php'; ?>
