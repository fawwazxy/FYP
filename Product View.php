<?php
// product_view.php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logged_in = true;
} 

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the product ID from the URL
$product_id = $_GET['product_id'];

// Retrieve the product data from the database
$query = "SELECT * FROM product WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $query);

// Check if the product exists
if (mysqli_num_rows($result) > 0) {
    $product_data = mysqli_fetch_assoc($result);
} else {
    header(""); // redirect to 404 page if product not found
    exit;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="styling/product view.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <style>
        /* Additional styles can go here if needed */
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="logo.jpg" alt="Tropicana Aquarium Logo" > 
        </div>
        <ul class="nav">
        <?php if (isset($_SESSION['user_id'])) { ?>
          <li><a href="homepage.php">Home</a></li>
          <li><a href="Product List.php">Shop</a></li>
          <li><a href="about us.php">About Us</a></li>
          <li><a href="profile.php">Account</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php } else { ?>
          <li><a href="homepage.php">Home</a></li>
          <li><a href="Product List.php">Shop</a></li>
          <li><a href="about us.php">About Us</a></li>
          <li><a href="login.php">Login</a></li>
        <?php } ?>
      </ul>
    </div>

    <div class="product-details">
        <h1><?php echo $product_data['name']; ?></h1>
        <img src="<?php echo $product_data['image']; ?>" alt="<?php echo $product_data['name']; ?>">
        
        <div class="price">Price: RM<?php echo $product_data['price']; ?></div>
        <div class="stock">Stock: <?php echo $product_data['stock_quantity']; ?> pieces available</div>
        
        <div class="description">
            <p>Description:</p>
            <p><?php echo nl2br($product_data['description']); ?></p>
        </div>

        <form action="add_to_cart.php" method="post">
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product_data['stock_quantity']; ?>">

    <div class="button-container">
        <button type="submit" name="add-to-cart">Add to Cart</button>
    </div>

    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <input type="hidden" name="product_name" value="<?php echo $product_data['name']; ?>">
    <input type="hidden" name="product_price" value="<?php echo $product_data['price']; ?>">
    <input type="hidden" name="product_image" value="<?php echo $product_data['image']; ?>">
</form>
    </div>



</body>
</html>
