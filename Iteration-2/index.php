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
    <title>GlamUp - Home</title>
    <link rel="stylesheet" href="styles/styles.css">
    <style>
    /* Additional styling for the sections */
    .featured-services,
    .special-offers,
    .latest-news {
      margin: 20px;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .featured-services h3,
    .special-offers h3,
    .latest-news h3 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }
    .service-list,
    .offers-list,
    .news-list {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .service-item,
    .offer-item,
    .news-item {
      flex: 0 1 300px;
      border: 1px solid #ccc;
      padding: 15px;
      background-color: #fafafa;
      text-align: center;
    }
    .service-item h4,
    .offer-item h4,
    .news-item h4 {
      margin-top: 10px;
      color: #e91e63;
    }
    /* Ensure images are responsive */
    .service-item img,
    .offer-item img,
    .news-item img {
      width: 100%;
      height: auto;
      margin-bottom: 10px;
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
        
        <div class="main-content" id="editable-section">
            <h2>Welcome to GlamUp</h2>
            <p>Discover our top-notch beauty services designed to enhance your style and confidence.</p>
            
            <!-- Featured Services with Images -->
            <section class="featured-services">
                <h3>Featured Services</h3>
                <div class="service-list">
                <div class="service-item">
                    <img src="images/makeup.jpg" alt="Makeup &amp; Styling">
                    <h4>Makeup &amp; Styling</h4>
                    <p>Achieve a stunning look for any event with professional makeup and styling services.</p>
                </div>
                <div class="service-item">
                    <img src="images/massage.jpg" alt="Massage Therapy">
                    <h4>Massage Therapy</h4>
                    <p>Rejuvenate your body and mind with our relaxing massage therapy sessions.</p>
                </div>
                <div class="service-item">
                    <img src="images/facials.jpg" alt="Facials">
                    <h4>Facials</h4>
                    <p>Enjoy a refreshing facial treatment for glowing, healthy skin.</p>
                </div>
                </div>
            </section>
            
            <!-- Special Offers with Images -->
            <section class="special-offers">
                <h3>Special Offers</h3>
                <div class="offers-list">
                <div class="offer-item">
                    <h4>50% Off on First Visit</h4>
                    <p>Enjoy an exclusive discount on your first service appointment with us.</p>
                </div>
                <div class="offer-item">
                    <h4>Seasonal Package</h4>
                    <p>Avail our special seasonal packages for a complete beauty makeover.</p>
                </div>
                <div class="offer-item">
                    <h4>Referral Bonus</h4>
                    <p>Refer a friend and enjoy additional discounts on your next service.</p>
                </div>
                </div>
            </section>
            
            <!-- Latest News with Images -->
            <section class="latest-news">
                <h3>Latest News</h3>
                <div class="news-list">
                <div class="news-item">
                    <h4>New Makeup Trends 2025</h4>
                    <p>Explore the latest makeup trends and techniques to stay ahead in style.</p>
                </div>
                <div class="news-item">
                    <h4>Interview with Our Head Stylist</h4>
                    <p>Get insider tips and beauty secrets from our lead stylist.</p>
                </div>
                <div class="news-item">
                    <h4>Summer Skincare Tips</h4>
                    <p>Learn how to protect and nourish your skin during the hot summer months.</p>
                </div>
                </div>
            </section>
        </div>

    </div>
    
    <div class="footer">
        <p>&copy; 2025 GlamUp - All Rights Reserved</p>
    </div>
</body>
</html>

