<?php
include('includes/db_connect.php');
include('includes/header.php');
include('includes/nav.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify password
        if ($user && sha1($password) === $user['password']) {
            $_SESSION['logged_in'] = true; 
            $_SESSION['userID'] = $user['userID']; 
            $_SESSION['username'] = $user['username'];
            header("Location: index.php"); 
            exit();
        } else {
            $login_error = "Invalid username or password.";
        }
    } elseif (isset($_POST['register'])) {
        $new_username = $_POST['username'];
        $new_password = sha1($_POST['password']);

        // Check if the username already exists
        $checkSql = "SELECT * FROM users WHERE username = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $new_username);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $register_error = "Username already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password, reg_date) VALUES (?, ?, NOW())");
            $stmt->bind_param("ss", $new_username, $new_password);
            if ($stmt->execute()) {
                $register_success = "Registration successful! You can log in now.";
            } else {
                $register_error = "Error in registration.";
            }
        }
    }
}
?>

<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
            <button type="submit" name="register" class="btn btn-secondary">Register</button>
        </form>

        <?php if (isset($register_error)) echo "<p class='error'>$register_error</p>"; ?>
        <?php if (isset($register_success)) echo "<p class='success'>$register_success</p>"; ?>
    </div>
</body>
</html>
<?php include('includes/footer.php'); ?>
