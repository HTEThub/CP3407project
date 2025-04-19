<?php
// submit_registration.php

// Database configuration - update with your actual credentials.
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

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data from POST (add your own validation/sanitization as needed)
$email       = isset($_POST['email']) ? $_POST['email'] : '';
$password    = isset($_POST['password']) ? $_POST['password'] : '';
$phone       = isset($_POST['phone']) ? $_POST['phone'] : '';
$fullAddress = isset($_POST['fullAddress']) ? $_POST['fullAddress'] : '';
$zip         = isset($_POST['zip']) ? $_POST['zip'] : '';
$cardNumber  = isset($_POST['cardNumber']) ? $_POST['cardNumber'] : '';
$expiryDate  = isset($_POST['expiryDate']) ? $_POST['expiryDate'] : '';
$cvv         = isset($_POST['cvv']) ? $_POST['cvv'] : '';

// Check if a user with this email already exists
$checkSql = "SELECT id FROM users WHERE email = ?";
$checkStmt = $conn->prepare($checkSql);
if($checkStmt === false) {
    die("Prepare failed: " . $conn->error);
}

$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if($checkStmt->num_rows > 0) {
    // A user with this email already exists. Inform the user and exit.
    echo "A user with that email already exists. Please try again with a different email address.";
    $checkStmt->close();
    $conn->close();
    exit();
}
$checkStmt->close();

// Hash the password for secure storage
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL INSERT statement using placeholders
$sql = "INSERT INTO users (email, password, phone, full_address, zip, card_number, expiry_date, cvv) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameters (all fields are passed as strings)
$stmt->bind_param("ssssssss", 
    $email, 
    $hashedPassword, 
    $phone, 
    $fullAddress, 
    $zip, 
    $cardNumber, 
    $expiryDate, 
    $cvv
);

// Execute the query and check for success
if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Clean up by closing the statement and connection
$stmt->close();
$conn->close();
?>
