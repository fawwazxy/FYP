<?php

$conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");


if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

// Retrieve customer ID from GET parameter
$user_id = $_GET['user_id'];

// Retrieve customer information from database
$query = "SELECT * FROM order_detail WHERE user_id = '$user_id' ORDER BY order_id DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Display customer information
$name = $row['name'];
$email = $row['email'];
$address = $row['address'];
$phone = $row['phone'];
$shipping_method = $row['shipping_method'];
$payment_method = $row['payment_method'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://i.imgur.com/NpHVnvk.jpeg');
            background-size: cover;
            background-position: center;
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

        /* Logo styles */
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

       .customer-info {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
       .customer-info h1 {
            text-align: center;
            color: #007bff; 
        }
       .customer-details {
            margin-top: 20px;
        }
       .customer-details label {
            width: 20%;
            display: inline-block;
            margin-bottom: 10px;
        }
       .customer-details input[type="text"],.customer-details input[type="email"],.customer-details input[type="tel"] {
            width: 60%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }
       .customer-details input[type="text"]:focus,.customer-details input[type="email"]:focus,.customer-details input[type="tel"]:focus {
            border-color: #007bff;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="logo">
      <img src="logo.jpg" alt="Tropicana Aquarium Logo" > 
    </div>
    <ul class="nav">
      <li><a href="staff_dashboard.php">Dashboard</a></li>
      <li><a href="homepage.php">Log Out</a></li>
    </ul>
  </div> 
    <div class="customer-info">
        <h1>Customer Information</h1>
        <div class="customer-details">
            <label for="name">Name:</label>
            <input type="text" id="name" value="<?=$name?>" readonly>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" value="<?=$email?>" readonly>
            <br>
            <label for="address">Address:</label>
            <input type="text" id="address" value="<?=$address?>" readonly>
            <br>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" value="<?=$phone?>" readonly>
            <br>
            <label for="shipping_method">Shipping Method:</label>
            <input type="text" id="shipping_method" value="<?=$shipping_method?>" readonly>
            <br>
            <label for="payment_method">Payment Method:</label>
            <input type="text" id="payment_method" value="<?=$payment_method?>" readonly>
        </div>
    </div>
</body>
</html>

<?php

mysqli_close($conn);
?>