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
    <title>GlamUp - Services</title>
    <link rel="stylesheet" href="styles/styles.css">
        <!-- Additional CSS for new content sections -->
    <style>
        /* Container sections styling for Our Services */
        .services-section {
        margin: 20px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .services-section h2 {
        margin-top: 0;
        color: #e91e63;
        }
        .services-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        }
        .service-item {
        flex: 1 1 300px;
        border: 1px solid #ccc;
        padding: 15px;
        background-color: #f9f9f9;
        }
        .service-item h3 {
        margin-top: 0;
        color: #e91e63;
        }
        
        /* Wrapper for side-by-side layout of About and Testimonials */
        .info-testimonial-container {
        display: flex;
        gap: 20px;
        margin: 20px;
        }
        /* Both sections will have equal width and similar styling */
        .info-testimonial-container section {
        flex: 1;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin: 0;
        }
        
        /* About Our Services Section - Align text to the left */
        .additional-info {
        text-align: left;
        }
        .additional-info h2 {
        margin-top: 0;
        color: #e91e63;
        }
        .additional-info ul {
        list-style: none;
        padding: 0;
        }
        .additional-info ul li {
        margin: 5px 0;
        }
        
        /* Testimonials Section */
        .testimonials h2 {
        margin-top: 0;
        color: #333;
        }
        .testimonial {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #ddd;
        }
        .testimonial:last-child {
        border-bottom: none;
        }
        
        /* Responsive: stack columns on small screens */
        @media (max-width: 768px) {
        .info-testimonial-container {
            flex-direction: column;
        }
        }
    </style>
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
        
        <!-- Main Content Area with Updated Sections -->
        <div class="main-content" id="editable-section">
            <!-- Our Services Section -->
            <section class="services-section">
                <h2>Our Services</h2>
                <p>At GlamUp, we offer a range of premium beauty and wellness services designed to help you look and feel your best. Explore our offerings below:</p>
                <div class="services-list">
                <div class="service-item">
                    <h3>Makeup &amp; Styling</h3>
                    <p>Enhance your look with professional makeup artists and stylists who use the latest trends to suit your individual style.</p>
                </div>
                <div class="service-item">
                    <h3>Hair Care</h3>
                    <p>Experience top-quality haircuts, coloring, and styling services tailored for a modern, chic look.</p>
                </div>
                <div class="service-item">
                    <h3>Massage Therapy</h3>
                    <p>Relax and unwind with our rejuvenating massage treatments designed to alleviate stress and tension.</p>
                </div>
                <div class="service-item">
                    <h3>Facials &amp; Skincare</h3>
                    <p>Rejuvenate your skin with personalized facial treatments and advanced skincare solutions.</p>
                </div>
                </div>
            </section>
            
            <!-- About Our Services and Testimonials Side-by-Side -->
            <div class="info-testimonial-container">
                <!-- About Our Services Section -->
                <section class="additional-info">
                <h2>About Our Services</h2>
                <p>Our team of certified professionals is dedicated to providing you with an exceptional experience every time. We use state-of-the-art techniques and premium products to ensure that you leave our salon feeling refreshed and confident.</p>
                <ul>
                    <li>Skilled and certified staff</li>
                    <li>Customized beauty treatments</li>
                    <li>Modern facilities with a relaxing atmosphere</li>
                    <li>Commitment to your satisfaction</li>
                </ul>
                </section>
                
                <!-- Testimonials Section -->
                <section class="testimonials">
                <h2>Testimonials</h2>
                <div class="testimonial">
                    <p>"GlamUp transformed my look! The staff were professional and the service exceeded my expectations."</p>
                    <p><strong>- Jane Doe</strong></p>
                </div>
                <div class="testimonial">
                    <p>"I always leave feeling refreshed and rejuvenated. Their skincare treatments are simply the best!"</p>
                    <p><strong>- Sarah Smith</strong></p>
                </div>
                </section>
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2025 GlamUp - All Rights Reserved</p>
    </div>
</body>
</html>

