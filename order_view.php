<?php

$conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve unique order IDs from order_details
$query = "SELECT DISTINCT order_id FROM order_details";
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Error fetching orders: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
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
        .orders {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .order {
            margin-bottom: 20px;
            padding: 20px;
            border-bottom: 1px solid #ccc;
        }
        .order:last-child {
            border-bottom: none;
        }
        .customer-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .customer-name {
            font-weight: bold;
            color: #007bff; 
        }
        .order-date {
            color: #666;
        }
        .order-products {
            margin-top: 10px;
        }
        .product {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .product:last-child {
            border-bottom: none;
        }
        .product-name {
            width: 50%;
            color: #333; 
        }
        .product-price {
            width: 20%;
            text-align: right;
            color: #333; 
        }
        .product-quantity {
            width: 10%;
            text-align: center;
            color: #333; 
        }
        .total {
            font-weight: bold;
            margin-top: 10px;
            text-align: right;
            color: #007bff; 
        }
        h1 {
            text-align: center;
            color: #007bff; 
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
        <li><a href="logout.php">Log Out</a></li>
    </ul>
</div>

<div class="orders">
    <h1>View Orders</h1>
    <?php while($row = mysqli_fetch_assoc($result)) {?>
        <?php
        $order_id = $row['order_id'];

        // Query to fetch order details with product information
        $query2 = "SELECT od.*, p.name AS product_name, p.price,
                          (p.price * od.quantity) AS total_product_cost,
                          r.full_name AS customer_name
                   FROM order_details od
                   JOIN product p ON od.product_id = p.product_id
                   JOIN register r ON od.user_id = r.user_id
                   WHERE od.order_id = '$order_id'";
        $result2 = mysqli_query($conn, $query2);
        if (!$result2) {
            die('Error fetching product details: ' . mysqli_error($conn));
        }

        // Calculate total cost for the order
        $total_cost = 0;
        ?>
        <div class="order">
            <div class="customer-info">
                <?php if ($row2 = mysqli_fetch_assoc($result2)) { ?>
                    <div class="customer-name"><a href="customer_info.php?user_id=<?=$row2['user_id']?>"><?=$row2['customer_name']?></a></div>
                    <?php } ?>
                <div class="order-date">Order ID: <?=$order_id?></div>
            </div>
            <div class="order-products">
                <?php mysqli_data_seek($result2, 0); // Reset result pointer to fetch again ?>
                <?php while($row2 = mysqli_fetch_assoc($result2)) {?>
                    <div class="product">
                        <div class="product-name"><?=$row2['product_name']?></div>
                        <div class="product-price">RM<?=$row2['price']?></div>
                        <div class="product-quantity">Quantity: <?=$row2['quantity']?></div>
                    </div>
                    <?php 
                        $total_cost += $row2['total_product_cost'];
                    ?>
                <?php }?>
            </div>
            <div class="total">Total: RM<?=$total_cost?></div>
        </div>
    <?php }?>
</div>

</body>
</html>

<?php

mysqli_close($conn);
?>
