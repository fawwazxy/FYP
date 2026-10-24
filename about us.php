<?php
session_start(); // Start PHP session

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tropicana Aquarium</title>
    <link rel="stylesheet" href="styling/aboutus.css"> <!-- Adjust CSS file path as needed -->
</head>
<body>

<div class="header">
    <div class="logo">
        <img src="logo.jpg" alt="Tropicana Aquarium Logo"> 
    </div>
    <ul class="nav">
      <?php if (isset($_SESSION['user_id'])) { ?>
        <li><a href="homepage.php">Home</a></li>
        <li><a href="Product List.php">Shop</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="about us.php">About Us</a></li>
        <li><a href="cart.php" class="active">Cart</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php } else { ?>
        <li><a href="homepage.php">Home</a></li>
        <li><a href="Product List.php">Shop</a></li>
        <li><a href="about us.php">About Us</a></li>
        <li><a href="login.php">Login</a></li>
      <?php } ?>
    </ul>
</div>

<main>
    <!-- Your main content goes here -->
    <section id="vision">
        <img src="image1.jpg" alt="Vision Image">
        <h2>Our Vision</h2>
        <p>To be the leading destination for pet and fishing enthusiasts, offering a wide range of high-quality products and exceptional customer service.</p>
    </section>
    <section id="mission">
        <img src="image2.jpg" alt="Mission Image">
        <h2>Our Mission</h2>
        <p>Our mission is to provide customers with the best pet and fishing products, outstanding service, and a welcoming environment. We are dedicated to meeting the needs of our community by continuously improving our offerings and supporting the hobbies we all love.</p>
    </section>
    <section id="description">
        <img src="image3.jpg" alt="Shop Description Image">
        <h2>About Our Shop</h2>
        <p>Tropicana Aquarium focuses on both pet and fishing related products, We have Animal feeds for commercially breed animals, like chicken, cows, and so on they also sell Pet foods such as cat and dog kibbles, small pet food for hamster, gerbil sugar gliders. Apart from that, Tropicana Aquarium sells Aquariums and pond related accessories, pump, lightings and filtration system, Live Aquarium fishes, aquatic plants, small animals such as hamsters. For Fishing sections, They have varieties and full range of fishing equipments, from fishing rods, reels to lure, and many more accessories, They also do minor rods and reels repairs and related services.</p>
    </section>
</main>

<footer>
<?php
include "footer.php";
?>
</footer>

</body>
</html>
