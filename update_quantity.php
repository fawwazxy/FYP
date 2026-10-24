// update_quantity.php
<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logged_in = true;

} else {
    header("Location: login.php");
    exit;
}

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the product ID and new quantity from the request
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

// Update the quantity in the cart table
$query = "UPDATE cart SET quantity = '$quantity' WHERE product_id = '$product_id' AND user_id = '$user_id'";
mysqli_query($conn, $query);

// Close the database connection
mysqli_close($conn);
?>