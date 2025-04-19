<?php
// login.php

// Optionally, start a session if you plan to use session variables later
// session_start();

$loginError = "";

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database configuration
    $host       = '127.0.0.1';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName     = 'Beauty_Saloon';

    // Database configuration with Infinityfree
    // $host       = 'sql105.infinityfree.com';
    // $dbUsername = 'if0_38755242';
    // $dbPassword = 'FUCKpassword77';
    // $dbName     = 'if0_38755242_glamup_sql';

    // Create a new MySQLi connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input from POST
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Prepare SQL to fetch user record based on email
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user with that email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $hashed_password);
        $stmt->fetch();

        // Verify the password using password_verify
        if (password_verify($password, $hashed_password)) {
            // Successful login: redirect user to profile.php with their user_id
            $stmt->close();
            $conn->close();
            header("Location: index.php?user_id=" . urlencode($userId));
            exit();
        } else {
            $loginError = "Invalid email or password.";
        }
    } else {
        $loginError = "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlamUp - Login</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="header">
        <img src="https://via.placeholder.com/50" alt="Logo">
        <h1>GlamUp - Online Beauty Booking</h1>
    </div>
    
    <div class="container">
        <div class="sidebar">
            <h2>Menu</h2>
            <div class="menu-links">
                <a href="index.php">Home</a>
                <a href="services.php">Services</a>
                <a href="booking.php">Booking</a>
                <a href="contact.php">Contact</a>
                <!-- For the profile link, you may leave it as a placeholder -->
                <a href="profile.php">Profile</a>
            </div>
            <div class="bottom-links">
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            </div>
        </div>
        
        <div class="main-content" id="editable-section">
            <h2>Login</h2>
            <!-- Display any login error message -->
            <?php
            if (!empty($loginError)) {
                echo "<div class='update-message' style='color: red; margin-bottom: 10px;'>" . htmlspecialchars($loginError) . "</div>";
            }
            ?>
            <form action="login.php" method="post" class="registration-form">
                <div class="form-group">
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required placeholder="example@gmail.com">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password" required placeholder="Enter password">
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2025 GlamUp - All Rights Reserved</p>
    </div>
</body>
</html>
