<?php
$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
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

    // Retrieve and sanitize form data
    $email       = trim($_POST['email'] ?? '');
    $password    = $_POST['password'] ?? '';
    $phone       = trim($_POST['phone'] ?? '');
    $fullAddress = trim($_POST['fullAddress'] ?? '');
    $zip         = trim($_POST['zip'] ?? '');
    $cardNumber  = trim($_POST['cardNumber'] ?? '');
    $expiryDate  = trim($_POST['expiryDate'] ?? '');
    $cvv         = trim($_POST['cvv'] ?? '');
    $applyAsArtist = isset($_POST['apply_as_artist']) ? 1 : 0;
    $artistBio     = trim($_POST['artist_bio'] ?? '');

    // Handle resume upload (optional)
    $resumeFileName = null;
    if ($applyAsArtist && isset($_FILES['resume_file']) && $_FILES['resume_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $resumeFileName = $uploadDir . basename($_FILES['resume_file']['name']);
        move_uploaded_file($_FILES['resume_file']['tmp_name'], $resumeFileName);
    }

    // Check if a user with this email already exists
    $checkSql = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkSql);
    if ($checkStmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $message = "A user with that email already exists. Please try again with a different email address.";
        $checkStmt->close();
    } else {
        $checkStmt->close();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // INSERT with artist fields
        $insertSql = "INSERT INTO users (email, password, phone, full_address, zip, card_number, expiry_date, cvv, apply_as_artist, artist_bio, resume_path) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssssssssiss", 
            $email, 
            $hashedPassword, 
            $phone, 
            $fullAddress, 
            $zip, 
            $cardNumber, 
            $expiryDate, 
            $cvv,
            $applyAsArtist,
            $artistBio,
            $resumeFileName
        );
        if ($stmt->execute()) {
            $message = "Registration successful! You can now <a href='login.php'>Login</a>.";
        } else {
            $message = "Error registering user: " . $stmt->error;
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
    <title>GlamUp - Register</title>
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
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            </div>
        </div>

        <div class="main-content" id="editable-section">
            <h2>Register</h2>
            <?php if (!empty($message)): ?>
                <div class='update-message' style='margin-bottom: 10px;'><?= $message ?></div>
            <?php endif; ?>

            <form action="register.php" method="post" enctype="multipart/form-data" class="registration-form">
                <div class="form-group">
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label><br>
                    <input type="tel" id="phone" name="phone" placeholder="Enter phone number">
                </div>

                <fieldset class="address-info">
                    <legend>Address Information</legend>
                    <div class="form-group">
                        <label for="fullAddress">Full Address:</label><br>
                        <input type="text" id="fullAddress" name="fullAddress" required>
                    </div>
                    <div class="form-group">
                        <label for="zip">Zip Code:</label><br>
                        <input type="text" id="zip" name="zip" required>
                    </div>
                </fieldset>

                <fieldset class="payment-info">
                    <legend>Payment Information</legend>
                    <div class="form-group">
                        <label for="cardNumber">Card Number:</label><br>
                        <input type="text" id="cardNumber" name="cardNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="expiryDate">Expiry Date:</label><br>
                        <input type="text" id="expiryDate" name="expiryDate" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV:</label><br>
                        <input type="text" id="cvv" name="cvv" required>
                    </div>
                </fieldset>

                <fieldset class="artist-application">
                    <legend>Work With Us</legend>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="applyArtistCheckbox" name="apply_as_artist">
                            Want to be hired as an Artist?
                        </label>
                    </div>

                    <div id="artistDetails" style="display: none; margin-top: 10px;">
                        <div class="form-group">
                            <label for="artistBio">Tell us about yourself:</label><br>
                            <textarea id="artistBio" name="artist_bio" rows="5" style="width: 100%;" placeholder="Write your experience, skills, and what makes you a great artist..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="resumeUpload">Upload your resume (PDF/DOC):</label><br>
                            <input type="file" id="resumeUpload" name="resume_file" accept=".pdf,.doc,.docx">
                        </div>
                    </div>
                </fieldset>

                <button type="submit">Register</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 GlamUp - All Rights Reserved</p>
    </div>

    <script>
        document.getElementById('applyArtistCheckbox').addEventListener('change', function () {
            document.getElementById('artistDetails').style.display = this.checked ? 'block' : 'none';
        });
    </script>
</body>
</html>
