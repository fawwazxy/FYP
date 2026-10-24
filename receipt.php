<?php
if (!isset($_SESSION)) {
    session_start();
}

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tropicana aquarium";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function formatCurrency($amount) {
    return 'RM' . number_format($amount, 2);
}

// Get the latest order ID for the user
$query = "SELECT MAX(order_id) AS latest_order_id FROM order_detail WHERE user_id = '$user_id'";
$result = $conn->query($query);

// Check if query executed successfully
if ($result && $result->num_rows > 0) {
    $order_data = $result->fetch_assoc();
    $order_id = $order_data['latest_order_id'];

    // Query to retrieve order details and products
    $query = "SELECT o.*, op.product_id, p.name AS product_name, p.price, op.quantity
              FROM `order_detail` o
              JOIN `order_details` op ON o.order_id = op.order_id
              JOIN `product` p ON op.product_id = p.product_id
              WHERE o.user_id = '$user_id' AND o.order_id = '$order_id'";

    $result = $conn->query($query);

    // Check if order details exist
    if ($result && $result->num_rows > 0) {
        $order_data = $result->fetch_assoc();

        // Extract customer information
        $name = $order_data['name'];
        $email = $order_data['email'];
        $address = $order_data['address'];
        $phone = $order_data['phone'];
        $shipping_method = $order_data['shipping_method'];
        $payment_method = $order_data['payment_method'];
        $total_cost = $order_data['total_cost'];

        // Extract products
        $products = array();
        do {
            $products[] = array(
                'product_id' => $order_data['product_id'],
                'product_name' => $order_data['product_name'],
                'price' => $order_data['price'],
                'quantity' => $order_data['quantity']
            );
        } while ($order_data = $result->fetch_assoc()); // Fetch all products

        $company_name = 'Tropicana Aquarium';
        $company_address = 'Jalan Pasir Akar, Lubok Kawah, 22000 Besut, Terengganu 22000 Jerteh Terengganu';
        $company_phone = '09-693 0105';

        $conn->close();
    } else {
        // No order details found for this user
        $conn->close();
        echo "No order details found.";
        exit;
    }
} else {
    // No orders found for this user
    $conn->close();
    echo "No orders found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://i.imgur.com/NpHVnvk.jpeg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 20px;
        }
        .receipt-container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header h1 {
            color: #007bff;
        }
        .customer-info, .order-info, .product-list, .company-info {
            margin-bottom: 30px;
        }
        .customer-info h2, .order-info h2, .product-list h2, .company-info h2 {
            color: #007bff;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .customer-info p, .order-info p, .product-list ul, .company-info p {
            margin: 10px 0;
        }
        .product-list ul {
            padding-left: 20px;
        }
        .total-cost {
            text-align: right;
            margin-top: 20px;
            font-size: 1.2em;
            font-weight: bold;
        }
        .thank-you {
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
            color: #555;
        }
        .print-button {
            text-align: center;
            margin-top: 20px;
        }
        .print-button button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-button button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>Receipt</h1>
            <p>Thank you for your purchase!</p>
        </div>

        <div class="customer-info">
            <h2>Customer Information</h2>
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Address:</strong> <?php echo $address; ?></p>
            <p><strong>Phone:</strong> <?php echo $phone; ?></p>
        </div>

        <div class="order-info">
            <h2>Order Details</h2>
            <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
            <p><strong>Shipping Method:</strong> <?php echo $shipping_method; ?></p>
            <p><strong>Payment Method:</strong> <?php echo $payment_method; ?></p>
        </div>

        <div class="product-list">
            <h2>Products</h2>
            <ul>
                <?php foreach ($products as $product) { ?>
                    <li>
                        <span><?php echo $product['product_name']; ?></span>
                        <span>x <?php echo $product['quantity']; ?></span>
                        <span><?php echo formatCurrency($product['price']); ?> each</span>
                    </li>
                <?php } ?>
            </ul>
            <div class="total-cost">
                <p><strong>Total Cost:</strong> <?php echo formatCurrency($total_cost); ?></p>
            </div>
        </div>

        <div class="company-info">
            <h2>Company Information</h2>
            <p><strong>Company Name:</strong> <?php echo $company_name; ?></p>
            <p><strong>Address:</strong> <?php echo $company_address; ?></p>
            <p><strong>Phone:</strong> <?php echo $company_phone; ?></p>
        </div>

        <p class="thank-you">Thank you for choosing <?php echo $company_name; ?>!</p>
        <div class="print-button">
            <button onclick="printReceipt()">Print</button>
        </div>
    </div>
</body>
</html>
