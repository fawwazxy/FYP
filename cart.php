<?php
// cart.php
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

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM cart WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

$total_cost = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
}

        body {
            background: url('https://i.imgur.com/NpHVnvk.jpeg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
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
            margin: 20px auto 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
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

        h1 {
            text-align: center;
            color: #333;
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
            background-color: #007BFF;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .total-box {
            text-align: center;
            font-size: 1.2em;
            margin-bottom: 20px;
            padding: 20px;
            width: 300px;
            margin: 20px auto;
        }

        .btn {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .fadeIn {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hidden {
            display: none;
        }

        .slideIn {
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fadeOut {
            animation: fadeOut 0.5s ease-in-out;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(-20px);
            }
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
        <li><a href="homepage.php">Home</a></li>
        <li><a href="Product List.php">Shop</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="about us.php">About Us</a></li>
        <li><a href="cart.php" class="active">Cart</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php } else { ?>
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Shop</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="login.php">Login</a></li>
      <?php } ?>
    </ul>
</div>

<div class="container fadeIn">
    <div class="pathway">
        <a href="Product List.php">Products</a> > <a href="cart.php">Cart</a> > <a href="checkout.php">Checkout</a>
    </div>

    <h1>Shopping Cart</h1>
    
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price (RM)</th>
            <th>Subtotal (RM)</th>
            <th>Action</th>
        </tr>
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
            $total_cost += $subtotal;

            echo "<tr class='slideIn'>";
            echo "<td>$product_id</td>";
            echo "<td>$product_name</td>";
            echo "<td><input type='number' value='$quantity' style='width: 50px;' id='quantity-$product_id'> <button class='btn' onclick='updateQuantity($product_id, document.getElementById(\"quantity-$product_id\").value)'>Update</button></td>";
            echo "<td>RM $price</td>";
            echo "<td>RM $subtotal</td>";
            echo "<td><a href='remove_cart.php?product_id=$product_id' class='btn remove-btn'>Remove</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <div class="total-box">
        <p>Total Cost: RM <?php echo $total_cost; ?></p>
    </div>

    <p style="text-align: center;"><a href="checkout.php" class="btn">Checkout</a></p>
</div>

<script>
function updateQuantity(productId, quantity) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_quantity.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('product_id=' + productId + '&quantity=' + quantity);
    xhr.onload = function() {
        if (xhr.status === 200) {
            location.reload();
        }
    };
}

document.querySelectorAll('.remove-btn').forEach(btn => {
    btn.addEventListener('click', function(event) {
        event.preventDefault();
        var row = this.closest('tr');
        row.classList.add('fadeOut');
        setTimeout(() => {
            window.location.href = this.href;
        }, 500);
    });
});
</script>

</body>
</html>

<?php
mysqli_close($conn);
?>
