<?php 
session_start(); 
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Pets Victoria</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pets.php">Pets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gallery.php">Gallery</a>
            </li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <li class="nav-item">
                    <a class="nav-link" href="add.php">Add</a> <!-- Show Add link if logged in -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php?action=logout">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a> <!-- Show Login link if not logged in -->
                </li>
            <?php endif; ?>
        </ul>
        <form class="d-flex" action="search.php" method="GET" style="margin-left:auto;">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_term" required>
            <button class="btn btn-outline-success" type="submit">
                <span class="material-symbols-outlined">search</span>
            </button>
        </form>
    </div>
</nav>
