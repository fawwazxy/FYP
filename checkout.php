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
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the user's ID from the session
$user_id = $_SESSION['user_id'];

// Retrieve the user details
$user_query = "SELECT full_name, address, phone, email FROM register WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Retrieve the cart items for the current user
$query = "SELECT * FROM cart WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

// Initialize the total cost
$total_cost = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            background: url('https://i.imgur.com/NpHVnvk.jpeg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        }

        .nav li {
            margin-left: 40px;
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

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #007BFF;
            color: white;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .total-cost {
            text-align: right;
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .checkout-section {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hidden {
            display: none;
        }

        .fade {
            animation: fadeIn 0.5s ease-in-out;
        }

        .pathway {
            margin: 20px 0;
            padding: 10px 0;
            text-align: center;
            background-color: #f0f4f8;
            border-radius: 5px;
        }

        .pathway a {
            margin: 0 10px;
            color: #007BFF;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .pathway a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="logo">
        <img src="logo.jpg" alt="Tropicana Aquarium Logo"> 
    </div>
    <ul class="nav">
        <?php if (isset($_SESSION['user_id'])) { ?>
            <li><a href="#">Home</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="cart.php">Cart</a></li>
        <?php } else { ?>
            <li><a href="#">Home</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="login.php">Login</a></li>
        <?php } ?>
    </ul>
</div>

<div class="container">
    <div class="pathway">
        <a href="Product List.php">Products</a> > <a href="cart.php">Cart</a> > <a href="checkout.php">Checkout</a>
    </div>

    <h1>Checkout</h1>
    <table>
        <tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>
        <?php
        while ($cart_item = mysqli_fetch_assoc($result)) {
            $product_id = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];

            // Retrieve the product details
            $product_query = "SELECT * FROM product WHERE product_id = '$product_id'";
            $product_result = mysqli_query($conn, $product_query);
            $product_data = mysqli_fetch_assoc($product_result);

            $product_name = $product_data['name'];
            $price = $product_data['price'];

            // Calculate the subtotal
            $subtotal = $price * $quantity;

            // Add to the total cost
            $total_cost += $subtotal;

            echo "<tr>";
            echo "<td>$product_name</td>";
            echo "<td>$quantity</td>";
            echo "<td>RM $price</td>";
            echo "<td>RM $subtotal</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <p class="total-cost">Total Cost: RM <?php echo $total_cost; ?></p>

    <form id="checkout-form" method="POST">
        <div class="checkout-section">
            <h2>Shipping Method</h2>
            <label for="shipping-method">Shipping Method:</label>
            <select id="shipping-method" name="shipping-method" required>
                <option value="delivery">Delivery</option>
                <option value="pickup">Pickup</option>
            </select>
        </div>

        <div class="checkout-section hidden" id="delivery-details">
            <h2>Delivery Details</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user_data['full_name']; ?>" required>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $user_data['address']; ?>" required>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $user_data['phone']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" required>
        </div>

        <div class="checkout-section hidden fade" id="pickup-details">
            <h2>Pickup Details</h2>
            <label for="pickup-name">Name:</label>
            <input type="text" id="pickup-name" name="name" value="<?php echo $user_data['full_name']; ?>" required>
            <label for="pickup-phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $user_data['phone']; ?>" required>
            <label for="pickup-email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" required>
        </div>

        <div class="checkout-section">
            <h2>Payment Method</h2>
            <label for="payment-method">Payment Method:</label>
            <select id="payment-method" name="payment-method" required>
                <option value="credit-card">Credit Card</option>
            </select>
        </div>

        <div class="checkout-section fade">
            <h2>Credit Card Details</h2>
            <label for="credit-card-number">Credit Card Number:</label>
            <input type="text" id="credit-card-number" name="credit-card-number" required>
        </div>

        <div class="checkout-section hidden fade" id="pickup-payment-options">
            <h2>Pickup Payment Options</h2>
            <label for="pickup-payment-method">Payment Method:</label>
            <select id="pickup-payment-method" name="pickup-payment-method">
                <option value="pay-at-counter">Pay at Counter</option>
                <option value="pay-now">Pay Now</option>
            </select>
        </div>

        <div class="checkout-section">
            <h2>Place Order</h2>
            <input type="submit" value="Place Order">
        </div>
    </form>
</div>

<?php

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $shipping_method = $_POST['shipping-method'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $credit_card_number = $_POST['credit-card-number'];
    $pickup_payment_method = $_POST['pickup-payment-method'];

    // Insert the order into the database
    $query = "INSERT INTO order_detail (user_id, name, email, address, phone, shipping_method, payment_method, total_cost) VALUES ('$user_id', '$name', '$email', '$address', '$phone', '$shipping_method', 'credit-card', '$total_cost')";
    mysqli_query($conn, $query);

    // Get the order ID
    $order_id = mysqli_insert_id($conn);

    // Insert the order details into the order_details table
    mysqli_data_seek($result, 0); // Reset result pointer to the beginning
    while ($cart_item = mysqli_fetch_assoc($result)) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];

        // Update the product quantity in the database
        $product_query = "SELECT stock_quantity FROM product WHERE product_id = '$product_id'";
        $product_result = mysqli_query($conn, $product_query);
        $product_data = mysqli_fetch_assoc($product_result);
        $current_quantity = $product_data['stock_quantity'];
        $new_quantity = $current_quantity - $quantity;
        $update_query = "UPDATE product SET stock_quantity = '$new_quantity' WHERE product_id = '$product_id'";
        mysqli_query($conn, $update_query);

        // Insert the order details into the order_details table
        $query = "INSERT INTO order_details (order_id, user_id, product_id, name, price, quantity) VALUES ('$order_id', '$user_id', '$product_id', '$product_name', '$price', '$quantity')";
        mysqli_query($conn, $query);

        
    }

    // Clear the cart
    $query = "DELETE FROM cart WHERE user_id = '$user_id'";
    mysqli_query($conn, $query);

    // Display a success message
    echo "<p style='color: green; text-align: center;'>Order placed successfully!</p>";
    echo '<script>';
echo 'alert("Order placed successfully!");';
echo 'window.location.href = "success.php";'; // Redirect to success.php
echo '</script>';

    // Close the database connection
    mysqli_close($conn);
}

?>

<script>
document.getElementById('shipping-method').addEventListener('change', function() {
    var shippingMethod = this.value;
    var deliveryDetails = document.getElementById('delivery-details');
    var pickupDetails = document.getElementById('pickup-details');
    var pickupPaymentOptions = document.getElementById('pickup-payment-options');

    if (shippingMethod === 'delivery') {
        deliveryDetails.classList.remove('hidden');
        deliveryDetails.classList.add('fade');
        pickupDetails.classList.add('hidden');
        pickupPaymentOptions.classList.add('hidden');
    } else if (shippingMethod === 'pickup') {
        pickupDetails.classList.remove('hidden');
        pickupDetails.classList.add('fade');
        pickupPaymentOptions.classList.remove('hidden');
        pickupPaymentOptions.classList.add('fade');
        deliveryDetails.classList.add('hidden');
    }
});

// Set the initial visibility based on the default selected option
document.addEventListener('DOMContentLoaded', function() {
    var shippingMethod = document.getElementById('shipping-method').value;
    var deliveryDetails = document.getElementById('delivery-details');
    var pickupDetails = document.getElementById('pickup-details');
    var pickupPaymentOptions = document.getElementById('pickup-payment-options');

    if (shippingMethod === 'delivery') {
        deliveryDetails.classList.remove('hidden');
        pickupDetails.classList.add('hidden');
        pickupPaymentOptions.classList.add('hidden');
    } else if (shippingMethod === 'pickup') {
        pickupDetails.classList.remove('hidden');
        pickupPaymentOptions.classList.remove('hidden');
        deliveryDetails.classList.add('hidden');
    }
});

document.getElementById('payment-method').addEventListener('change', function() {
    var paymentMethod = this.value;
    var creditCardNumber = document.getElementById('credit-card-number');

    if (paymentMethod === 'credit-card') {
        creditCardNumber.style.display = 'block';
        creditCardNumber.classList.add('fade');
    }
});

document.getElementById('pickup-payment-method').addEventListener('change', function() {
    var pickupPaymentMethod = this.value;
    var creditCardNumber = document.getElementById('credit-card-number');

    if (pickupPaymentMethod === 'pay-now') {
        creditCardNumber.style.display = 'block';
        creditCardNumber.classList.add('fade');
    } else {
        creditCardNumber.style.display = 'none';
    }
});


</script>
</body>
</html>
