<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Database config
$host       = 'sql105.infinityfree.com';
$dbUsername = 'if0_38755242';
$dbPassword = 'FUCKpassword77';
$dbName     = 'if0_38755242_glamup_sql';

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is an artist
$isArtist = false;
$stmt = $conn->prepare("SELECT apply_as_artist FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($isArtist);
$stmt->fetch();
$stmt->close();

if (!$isArtist) {
    echo "<h2>Access Denied</h2><p>You are not an artist.</p>";
    exit;
}

// Handle status update (POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['booking_id'], $_POST['status'])) {
        // Update booking status
        $bookingId = $_POST['booking_id'];
        $status = $_POST['status'];
        $update = $conn->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
        $update->bind_param("si", $status, $bookingId);
        $update->execute();
        $update->close();
    } elseif (isset($_POST['delete_booking_id'])) {
        // Delete booking
        $deleteId = $_POST['delete_booking_id'];
        $delete = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
        $delete->bind_param("i", $deleteId);
        $delete->execute();
        $delete->close();
    }
}

// Get bookings
$results = $conn->query("SELECT booking_id, service, appointment_datetime, email, phone, full_address, zip, created_at, status 
                         FROM bookings ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookings List - GlamUp Artist</title>
    <link rel="stylesheet" href="styles/styles.css">
    <style>
        .delete-button {
            float: right;
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="images/logo.png" alt="GlamUp Logo" style="width:100px; height:100px;">
        <h1>GlamUp - Artist Dashboard</h1>
    </div>

    <div class="container">
        <div class="sidebar">
            <h2>Menu</h2>
            <div class="menu-links">
                <a href="index.php">Home</a>
                <a href="services.php">Services</a>
                <a href="booking_list.php">Bookings List</a>
                <a href="contact.php">Contact</a>
                <a href="profile.php">Profile</a>
            </div>
            <div class="bottom-links">
                <a href="php/logout.php">Logout</a>
            </div>
        </div>

        <div class="main-content">
            <h2>Customer Bookings</h2>
            <?php if ($results->num_rows === 0): ?>
                <p>No bookings yet.</p>
            <?php else: ?>
                <?php while ($row = $results->fetch_assoc()): ?>
                    <div class="booking-card" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; text-align: left; border-radius: 6px; background-color: #fefefe; position: relative;">
                        
                        <!-- Delete Button -->
                        <form method="post" style="position: absolute; top: 10px; right: 10px;">
                            <input type="hidden" name="delete_booking_id" value="<?= $row['booking_id'] ?>">
                            <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this booking?');">X</button>
                        </form>

                        <p><strong>Service:</strong> <?= htmlspecialchars($row['service']) ?></p>
                        <p><strong>Appointment:</strong> <?= htmlspecialchars($row['appointment_datetime']) ?></p>
                        <p><strong>Customer Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($row['full_address'] . ', ' . $row['zip']) ?></p>
                        <p><strong>Created:</strong> <?= htmlspecialchars($row['created_at']) ?></p>

                        <form method="post">
                            <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                            <label><input type="radio" name="status" value="accepted" <?= $row['status'] === 'accepted' ? 'checked' : '' ?>> Accept</label>
                            <label><input type="radio" name="status" value="finished" <?= $row['status'] === 'finished' ? 'checked' : '' ?>> Finish</label>
                            <label><input type="radio" name="status" value="cancelled" <?= $row['status'] === 'cancelled' ? 'checked' : '' ?>> Cancel</label>
                            <br><br>
                            <button type="submit">Update Status</button>
                        </form>

                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2025 GlamUp - All Rights Reserved</p>
    </div>
</body>
</html>
