<?php
session_start();

// Define database config
$host       = '127.0.0.1';
$dbUsername = 'root';
$dbPassword = '';
$dbName     = 'Beauty_Saloon';

// Database configuration with Infinityfree
// $host       = 'sql105.infinityfree.com';
// $dbUsername = 'if0_38755242';
// $dbPassword = 'FUCKpassword77';
// $dbName     = 'if0_38755242_glamup_sql';

// Update session if user_id is passed via GET
if (isset($_GET['user_id'])) {
    $_SESSION['user_id'] = intval($_GET['user_id']);
}

$isArtist = false;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT apply_as_artist FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($dbIsArtist);
    $stmt->fetch();
    $isArtist = ($dbIsArtist == 1); // cast to boolean
    $stmt->close();
    $conn->close();
}

// echo "<pre>apply_as_artist: " . var_export($dbIsArtist, true) . "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlamUp - Template</title>
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
                <?php if (isset($_SESSION['user_id']) && $isArtist): ?>
                    <a href="booking_list.php">Bookings List</a>
                <?php else: ?>
                    <a href="booking.php">Booking</a>
                <?php endif; ?>
                <a href="contact.php">Contact</a>
                <a href="profile.php">Profile</a>
            </div>
            <div class="bottom-links">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="php/logout.php" id="logoutButton">Logout</a>
                <?php else: ?>
                    <a href="register.php" id="registerButton">Register</a>
                    <a href="login.php" id="loginButton">Login</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="main-content" id="editable-section">
            <h2>Content Section</h2>
            <p>This section is left empty for future content additions.</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>
            <p>More content to test scrolling...</p>

        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2025 GlamUp - All Rights Reserved</p>
    </div>
</body>
</html>

