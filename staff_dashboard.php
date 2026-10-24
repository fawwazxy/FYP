<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://i.imgur.com/NpHVnvk.jpeg');
            background-size: cover;
            background-position: center;
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

        /* Navigation styles */
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
        .dashboard {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background: linear-gradient(to right, #2c3e50, #3498db); /* Gradient background */
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .option {
            margin-bottom: 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        .option:hover {
            transform: translateY(-5px); /* Hover effect */
        }
        .button {
            background-color: #3498db;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #2980b9;
        }
        h1, h2 {
            color: #fff;
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
    <div class="dashboard">
        <h1 style="text-align: center;">Staff Dashboard</h1>
        <div class="option">
            <h2>View Customer Details</h2>
            <button class="button" onclick="location.href='customer_detail.php'">View Customers</button>
        </div>
        <div class="option">
            <h2>Manage Products</h2>
            <button class="button" onclick="location.href='Add Product.php'">Manage Products</button>
        </div>
        <div class="option">
            <h2>View Customer Orders</h2>
            <button class="button" onclick="location.href='order_view.php'">View Orders</button>
        </div>
        <div class="option">
            <h2>View Sales Report</h2>
            <button class="button" onclick="location.href='report.php'">View Sales Report</button>
        </div>
    </div>
</body>
</html>
