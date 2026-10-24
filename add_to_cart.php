<?php


if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logged_in = true;

} 
$conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");

if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

// Retrieve the product ID from the POST request
$product_id = $_POST['product_id'];

// Retrieve the quantity from the POST request
$quantity = $_POST['quantity'];

$user_id = $_SESSION['user_id'];

// Check if the user is logged in
if (!isset($user_id)) {
    header("Location: login.php");
    exit;
}

// Check if the product exists in the cart already
$query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Product is already in the cart, update the quantity
    $cart_data = mysqli_fetch_assoc($result);
    $new_quantity = $cart_data['quantity'] + $quantity;
    $query = "UPDATE cart SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'";
    mysqli_query($conn, $query);
    echo "<script>alert('Product quantity updated successfully!'); window.location.href='Product List.php';</script>";
} else {
    // Product is not in the cart, add it
    $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
    mysqli_query($conn, $query);
    echo "<script>alert('Product added to cart successfully!'); window.location.href='Product List.php';</script>";
}

mysqli_close($conn);

?>