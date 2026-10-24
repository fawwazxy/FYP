<?php
// homepage.php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

// Check for login success alert
if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
  echo '<script>alert("Login successful!");</script>';
  // Unset the session variable after displaying the alert
  unset($_SESSION['login_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA_Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tropicana Aquarium</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
  <style>
    /* Global Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #333;
      background: url('https://i.imgur.com/NpHVnvk.jpeg') no-repeat center center fixed;
      background-size: cover;
    }

    /* Header Styles */
    .header {
      background-color: #fff;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      position: fixed;
      top: 0;
      z-index: 1000;
    }

    .logo {
      font-weight: bold;
      font-size: 1.5rem;
      margin-right: 20px;
    }

    .logo img {
      max-width: 40%;
      height: auto;
    }

    .nav {
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .nav li {
      margin-left: 30px;
      margin-right: 30px;
    }

    .nav a {
      text-decoration: none;
      color: #333;
      transition: color 0.2s ease;
    }

    .nav a:hover {
      color: #666;
    }

    /* Hero Section Styles */
    .hero {
      position: relative;
      text-align: center;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: #fff;
      margin-top: 60px;
      background: rgba(0, 0, 0, 0.5);
    }

    .hero h1, .hero p {
      z-index: 2;
    }

    .hero h1 {
      font-size: 48px;
      font-weight: bold;
      margin-bottom: 20px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .hero p {
      font-size: 18px;
      margin-bottom: 40px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .shop-now-btn {
      padding: 10px 20px;
      background-color: #FFC107;
      color: #333;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
      z-index: 2;
    }

    .shop-now-btn:hover {
      background-color: #FFA07A;
    }

    /* Slideshow Styles */
    .slideshow-container {
      width: 80%; /* Adjust as needed */
      max-width: 1200px; /* Maximum width */
      margin: auto; /* Center the container */
      overflow: hidden; /* Hide overflow to prevent scrollbars */
    }

    .slideshow {
      width: 100%;
      margin: 0;
      padding: 0;
    }

    .slide {
      background-size: cover;
      background-position: center;
      height: 400px; /* Adjust the height as needed */
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      position: relative;
    }

    .slide-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .slide-content {
      position: relative;
      z-index: 2;
      text-align: center;
    }

    .slide-content h2 {
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .slide-content p {
      font-size: 18px;
      margin-bottom: 40px;
    }

    /* Categories Section */
    .categories {
      display: flex;
      justify-content: space-around;
      margin: 40px 0;
      padding: 0 20px;
    }

    .category {
      text-align: center;
      flex: 1;
      margin: 0 20px;
    }

    .category img {
      width: 100%;
      border-radius: 10px;
      max-width: 300px;
    }

    .category h3 {
      margin-top: 10px;
      font-size: 1.5em;
    }

    /* Testimonials Section */
    .testimonials {
      background: rgba(255, 255, 255, 0.8);
      padding: 40px 20px;
      text-align: center;
      margin: 40px 0;
    }

    .testimonial {
      margin: 20px 0;
    }

    .testimonial p {
      font-style: italic;
      margin: 10px 0;
    }

    .testimonial .author {
      font-weight: bold;
      color: #333;
    }

    /* Newsletter Section */
    .newsletter {
      background: #333;
      color: #fff;
      padding: 40px 20px;
      text-align: center;
    }

    .newsletter h2 {
      font-size: 2em;
      margin-bottom: 20px;
    }

    .newsletter input[type="email"] {
      padding: 10px;
      width: 300px;
      max-width: 100%;
      margin-right: 10px;
      border: none;
      border-radius: 5px;
    }

    .newsletter .btn {
      padding: 10px 20px;
      background-color: #FFC107;
      color: #333;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .newsletter .btn:hover {
      background-color: #FFA07A;
    }
  </style>
</head>
<body>
  <header>
    <div class="header">
      <div class="logo">
        <img src="logo.jpg" alt="Tropicana Aquarium Logo"> 
      </div>
      <ul class="nav">
        <?php if (isset($_SESSION['user_id'])) { ?>
          <li><a href="#">Home</a></li>
          <li><a href="Product List.php">Shop</a></li>
          <li><a href="about us.php">About Us</a></li>
          <li><a href="developer.php">Our Team</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="cart.php">Cart</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
          <li><a href="homepage.php">Home</a></li>
          <li><a href="Product List.php">Shop</a></li>
          <li><a href="developer.php">Our Team</a></li>
          <li><a href="about us.php">About Us</a></li>
          <li><a href="login.php">Login</a></li>
        <?php } ?>
      </ul>
    </div>
  </header>
  
  <section class="hero">
    <div class="hero-overlay">
      <h1>Welcome to Tropicana Aquarium</h1>
      <p>Dont know how find best quality aquarium acceccories?? Dont make you brain tired thinking of that things! Just discover our website!!</p>
      <a href="Product List.php"><button class="shop-now-btn">Shop Now</button></a>
      </div>
  </section>
  
  <main>
    <div class="slideshow-container">
      <section class="slideshow">
        <div class="slide" style="background-image: url('images/2.jpg');">
          <div class="slide-overlay">
            <div class="slide-content">

            </div>
          </div>
        </div>
        <div class="slide" style="background-image: url('images/1.jpg');">
          <div class="slide-overlay">
            <div class="slide-content">
            </div>
          </div>
        </div>
        <div class="slide" style="background-image: url('images/4.jpg');">
          <div class="slide-overlay">
            <div class="slide-content">
            </div>
          </div>
        </div>
      </section>
    </div>
    

    
    <section class="testimonials">
      <h2>What Our Customers Say</h2>
      <div class="testimonial">
        <p>"Memang produk dekat sini memang tip top semua. Lepas ini saya takkan pergi ke kedai lagi!"</p>
        <div class="author">- Haikimi</div>
      </div>
      <div class="testimonial">
        <p>"Memang terbaik!"</p>
        <div class="author">- Firdaus</div>
      </div>
    </section>
    

  </main>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.slideshow').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000
      });
    });
  </script>

<?php
  include "footer.php";

?>

</body>
</html>
