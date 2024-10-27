<footer class="footer bg-orange text-white text-center py-3">
    <p>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="details.php" class="text-white"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
        <?php endif; ?>
    </p>
    <p>s4095696 Joshua Di Vito &copy; <?php echo date("Y"); ?> All Rights Reserved | Designed for Pets Victoria</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
