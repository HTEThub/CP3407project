<?php
session_start();

$bookingMessage = "";

// Process booking form submission if the user is logged in.
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

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

    // Create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // If the form is submitted, save the booking.
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Get service, date, and time from the POST data.
        $service = $_POST['service'];
        $booking_date = $_POST['booking_date']; // Expected format: YYYY-MM-DD
        $booking_time = $_POST['booking_time']; // Expected format: HH:MM
        $appointment_datetime = $booking_date . ' ' . $booking_time . ':00';

        // Retrieve the user's current information
        $selectSql = "SELECT email, phone, full_address, zip, card_number, expiry_date, cvv FROM users WHERE id = ?";
        $stmt = $conn->prepare($selectSql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($email, $phone, $fullAddress, $zip, $cardNumber, $expiryDate, $cvv);
        if (!$stmt->fetch()) {
            die("User not found.");
        }
        $stmt->close();

        // Insert booking record into the database
        $insertSql = "INSERT INTO bookings (user_id, email, service, appointment_datetime, phone, full_address, zip, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($insertSql);
        if ($stmt2 === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt2->bind_param("isssssssss", $userId, $email, $service, $appointment_datetime, $phone, $fullAddress, $zip, $cardNumber, $expiryDate, $cvv);
        if ($stmt2->execute()) {
            $bookingMessage = "Booking successful!";
        } else {
            $bookingMessage = "Error saving booking: " . $stmt2->error;
        }
        $stmt2->close();
    } else {
        // For GET requests, retrieve user's information
        $selectSql = "SELECT email, phone, full_address, zip, card_number, expiry_date, cvv FROM users WHERE id = ?";
        $stmt = $conn->prepare($selectSql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($email, $phone, $fullAddress, $zip, $cardNumber, $expiryDate, $cvv);
        if (!$stmt->fetch()) {
            die("User not found.");
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlamUp - Booking</title>
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
                <a href="profile.php">Profile</a>
            </div>
            <div class="bottom-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="php/logout.php" id="logoutButton">Logout</a>
                <?php else: ?>
                    <a href="register.php" id="registerButton">Register</a>
                    <a href="login.php" id="loginButton">Login</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="main-content" id="editable-section">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <h2>You are not logged in</h2>
                <p>Please <a href="login.php">Login</a> or <a href="register.php">Register</a> to book a service.</p>
            <?php else: ?>
                <h2>Book a Service</h2>
                <?php
                if (!empty($bookingMessage)) {
                    echo "<div class='update-message' style='margin-bottom: 10px;'>" . htmlspecialchars($bookingMessage) . "</div>";
                }
                ?>
                <!-- We re-use the registration-form class for a consistent look -->
                <form action="booking.php" method="post" class="registration-form">
                    <!-- Service selection dropdown -->
                    <div class="form-group">
                        <label for="service">Select Service:</label>
                        <select id="service" name="service">
                            <option value="haircut">Haircut</option>
                            <option value="makeup">Makeup</option>
                            <option value="manicure">Manicure</option>
                            <option value="pedicure">Pedicure</option>
                            <option value="facial">Facial</option>
                        </select>
                    </div>
                    
                    <!-- Date & Time selection -->
                    <div class="form-group">
                        <label for="booking_date">Select Date:</label>
                        <input type="date" id="booking_date" name="booking_date" required>
                    </div>
                    <div class="form-group">
                        <label for="booking_time">Select Time:</label>
                        <input type="time" id="booking_time" name="booking_time" required>
                    </div>
                    
                    <!-- User's information (display only) -->
                    <div class="user-info" style="margin-top:20px; text-align: left;">
                        <h3>Your Information</h3>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($fullAddress . ", " . $zip); ?></p>
                        <p>
                            <strong>Payment Information:</strong>
                            <?php echo htmlspecialchars($cardNumber); ?> 
                            (Exp: <?php echo htmlspecialchars($expiryDate); ?>,
                            CVV: <?php echo htmlspecialchars($cvv); ?>)
                        </p>
                    </div>
                    
                    <button type="submit">Book Service</button>
                    <!-- TODO: Further implement booking functionality if necessary -->
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2025 GlamUp - All Rights Reserved</p>
    </div>
</body>
</html>
