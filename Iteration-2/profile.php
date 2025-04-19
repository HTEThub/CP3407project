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
$updateMessage = "";

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    // Connect to DB once
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get artist status
    $stmt = $conn->prepare("SELECT apply_as_artist FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($dbIsArtist);
    $stmt->fetch();
    $isArtist = ($dbIsArtist == 1);
    $stmt->close();

    // Get update message from GET (if any)
    if (isset($_GET['updateMessage'])) {
        $updateMessage = $_GET['updateMessage'];
    }

    // Get full user profile data
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
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GlamUp - User Profile</title>
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
              <!-- All three buttons remain in the DOM; their visibility is toggled with JS -->
              <a href="register.php" id="registerButton">Register</a>
              <a href="login.php" id="loginButton">Login</a>
              <a href="php/logout.php" id="logoutButton">Logout</a>
          </div>
      </div>
      
      <div class="main-content" id="editable-section">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <h2>You are not logged in</h2>
          <p>Please <a href="login.php">Login</a> or <a href="register.html">Register</a> to view your profile.</p>
        <?php else: 
          // User is logged in; retrieve user info from the database.
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
          
          // Retrieve update message from GET if provided (for feedback purposes)
          $updateMessage = "";
          if (isset($_GET['updateMessage'])) {
              $updateMessage = $_GET['updateMessage'];
          }
          
          // Retrieve current user data from the database
          $selectSql = "SELECT email, phone, full_address, zip, card_number, expiry_date, cvv FROM users WHERE id = ?";
          $stmt = $conn->prepare($selectSql);
          if ($stmt === false) {
              die("Prepare failed: " . $conn->error);
          }
          $stmt->bind_param("i", $userId);
          $stmt->execute();
          $stmt->bind_result($email, $phone, $fullAddress, $zip, $cardNumber, $expiryDate, $cvv);
          if (!$stmt->fetch()) {
              echo "<p>User not found.</p>";
              $stmt->close();
              $conn->close();
          } else {
              $stmt->close();
              $conn->close();
          }
          ?>
          <h2>Edit Your Information</h2>
          <?php
          if (!empty($updateMessage)) {
              echo "<div class='update-message' style='color: green; margin-bottom: 10px;'>" . htmlspecialchars($updateMessage) . "</div>";
          }
          ?>
          <form action="php/edit_profile.php" method="post" class="registration-form">
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
        <?php endif; ?>
      </div>
  </div>
  
  <div class="footer">
      <p>&copy; 2025 GlamUp - All Rights Reserved</p>
  </div>
  
  <!-- JavaScript to toggle bottom-links visibility dynamically based on login state -->
  <script>
      // Convert PHP boolean to JavaScript boolean.
      var loggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
      if (loggedIn) {
          document.getElementById('registerButton').style.display = 'none';
          document.getElementById('loginButton').style.display = 'none';
          document.getElementById('logoutButton').style.display = 'block';
      } else {
          document.getElementById('registerButton').style.display = 'block';
          document.getElementById('loginButton').style.display = 'block';
          document.getElementById('logoutButton').style.display = 'none';
      }
  </script>
</body>
</html>
