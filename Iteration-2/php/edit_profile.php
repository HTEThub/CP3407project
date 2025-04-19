<?php
// edit_profile.php

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

// Create new MySQLi connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$updateMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process form submission for updating user information
    $userId      = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $email       = isset($_POST['email']) ? $_POST['email'] : '';
    $phone       = isset($_POST['phone']) ? $_POST['phone'] : '';
    $fullAddress = isset($_POST['fullAddress']) ? $_POST['fullAddress'] : '';
    $zip         = isset($_POST['zip']) ? $_POST['zip'] : '';
    $cardNumber  = isset($_POST['cardNumber']) ? $_POST['cardNumber'] : '';
    $expiryDate  = isset($_POST['expiryDate']) ? $_POST['expiryDate'] : '';
    $cvv         = isset($_POST['cvv']) ? $_POST['cvv'] : '';
    $newPassword = isset($_POST['password']) ? $_POST['password'] : '';

    // Check whether the new email is already used by a different user.
    $checkEmailSql = "SELECT id FROM users WHERE email = ? AND id <> ?";
    $checkStmt = $conn->prepare($checkEmailSql);
    if ($checkStmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $checkStmt->bind_param("si", $email, $userId);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if($checkStmt->num_rows > 0) {
        // Email is taken by another user
        $updateMessage = "This email is already in use by another account. Please choose a different email.";
        $checkStmt->close();
    } else {
        $checkStmt->close();
        // Proceed with update.
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE users SET email = ?, phone = ?, full_address = ?, zip = ?, card_number = ?, expiry_date = ?, cvv = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($updateSql);
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ssssssssi", $email, $phone, $fullAddress, $zip, $cardNumber, $expiryDate, $cvv, $hashedPassword, $userId);
        } else {
            $updateSql = "UPDATE users SET email = ?, phone = ?, full_address = ?, zip = ?, card_number = ?, expiry_date = ?, cvv = ? WHERE id = ?";
            $stmt = $conn->prepare($updateSql);
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("sssssssi", $email, $phone, $fullAddress, $zip, $cardNumber, $expiryDate, $cvv, $userId);
        }
        
        if ($stmt->execute()) {
            $updateMessage = "Profile updated successfully!";
        } else {
            $updateMessage = "Error updating profile: " . $stmt->error;
        }
        $stmt->close();
    }
    // Redirect back to the profile page with an update message.
    header("Location: ../profile.php?user_id=" . urlencode($userId) . "&updateMessage=" . urlencode($updateMessage));
    exit();
} else {
    // For GET requests, simply redirect to the profile page.
    if (!isset($_GET['user_id'])) {
        die("User ID not provided.");
    }
    $userId = $_GET['user_id'];
    header("Location: profile.php?user_id=" . urlencode($userId));
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile - GlamUp</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
  <div class="header">
      <img src="https://via.placeholder.com/50" alt="Logo">
      <h1>Edit Profile - GlamUp</h1>
  </div>
  <div class="container">
      <div class="main-content">
          <h2>Edit Your Information</h2>
          <?php
          // Display the update message if set (could be success or email conflict error)
          if (!empty($updateMessage)) {
              echo "<div class='update-message' style='color: green; margin-bottom: 10px;'>" . htmlspecialchars($updateMessage) . "</div>";
          }
          ?>
          <form action="edit_profile.php" method="post" class="registration-form">
              <!-- Hidden field for user ID -->
              <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
              <div class="form-group">
                  <label for="email">Email:</label><br>
                  <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
              </div>
              <div class="form-group">
                  <label for="password">New Password (leave blank to keep unchanged):</label><br>
                  <input type="password" id="password" name="password" placeholder="Enter new password">
              </div>
              <div class="form-group">
                  <label for="phone">Phone:</label><br>
                  <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
              </div>
              <fieldset class="address-info">
                  <legend>Address Information</legend>
                  <div class="form-group">
                      <label for="fullAddress">Full Address:</label><br>
                      <input type="text" id="fullAddress" name="fullAddress" required value="<?php echo htmlspecialchars($fullAddress); ?>">
                  </div>
                  <div class="form-group">
                      <label for="zip">Zip Code:</label><br>
                      <input type="text" id="zip" name="zip" required value="<?php echo htmlspecialchars($zip); ?>">
                  </div>
              </fieldset>
              <fieldset class="payment-info">
                  <legend>Payment Information</legend>
                  <div class="form-group">
                      <label for="cardNumber">Card Number:</label><br>
                      <input type="text" id="cardNumber" name="cardNumber" required value="<?php echo htmlspecialchars($cardNumber); ?>">
                  </div>
                  <div class="form-group">
                      <label for="expiryDate">Expiry Date:</label><br>
                      <input type="text" id="expiryDate" name="expiryDate" required value="<?php echo htmlspecialchars($expiryDate); ?>">
                  </div>
                  <div class="form-group">
                      <label for="cvv">CVV:</label><br>
                      <input type="text" id="cvv" name="cvv" required value="<?php echo htmlspecialchars($cvv); ?>">
                  </div>
              </fieldset>
              <button type="submit">Save Changes</button>
          </form>
      </div>
  </div>
  <div class="footer">
      <p>&copy; 2025 GlamUp - All Rights Reserved</p>
  </div>
</body>
</html>

<?php
$conn->close();
?>
