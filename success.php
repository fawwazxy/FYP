<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logged_in = true;

} 
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successfully</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://i.imgur.com/NpHVnvk.jpeg');
            background-size: cover;
            background-position: center;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #007bff;
            text-align: center;
        }
        p {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }
        .btn-container {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Successfully Placed!</h1>
        <p>Your order has been successfully processed.</p>
        <div class="btn-container">
            <a href="Product List.php" class="btn">Continue Shopping</a>
            <a href="receipt.php" class="btn">Click Here to View Your Receipt</a>
        </div>
    </div>
</body>
</html>
