<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sales Report</title>
    <link rel="stylesheet" href="styling/report.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://i.imgur.com/NpHVnvk.jpeg');
            background-size: cover;
            background-position: center;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: #fff;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
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

        .current-month-sales {
            margin-top: 20px;
            text-align: center;
        }

        .current-month-sales h2 {
            color: #007bff;
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
        function printReport() {
            window.print();
        }
    </script>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="logo.jpg" alt="Tropicana Aquarium Logo">
        </div>
        <ul class="nav">
            <li><a href="staff_dashboard.php">Dashboard</a></li>
            <li><a href="homepage.php">Log Out</a></li>
        </ul>
    </div>
    <div class="wrapper">
        <h1> Sales Report</h1>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Total Products Purchased</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Configuration
                $db_host = 'localhost';
                $db_username = 'root';
                $db_password = '';
                $db_name = 'tropicana aquarium';

                // Create connection
                $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to retrieve customers who have purchased a lot of products and total sales
                $sql = "
                    SELECT 
                        c.user_id,
                        c.full_name AS customer_name, 
                        SUM(od.quantity) AS total_products_purchased, 
                        SUM(od.quantity * od.price) AS total_sales
                    FROM 
                        register c
                    JOIN 
                        order_details od ON c.user_id = od.user_id
                    GROUP BY 
                        c.user_id, c.full_name
                    ORDER BY 
                        total_products_purchased DESC
                ";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_products_purchased']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_sales']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No data found</td></tr>";
                }

                // Calculate total sales for the current month 
                $sql_current_month_sales = "
                    SELECT 
                        SUM(od.quantity * od.price) AS total_current_month_sales
                    FROM 
                        order_details od
                ";

                $result_current_month_sales = $conn->query($sql_current_month_sales);
                $row_current_month_sales = $result_current_month_sales->fetch_assoc();
                $current_month_sales = $row_current_month_sales['total_current_month_sales'];

                
                $conn->close();
                ?>
            </tbody>
        </table>
        <div class="current-month-sales">
            <h2>Current Month Sales: RM <?php echo htmlspecialchars($current_month_sales); ?></h2>
        </div>
        <div class="print-button">
            <button onclick="printReport()">Print Report</button>
        </div>
    </div>
</body>

</html>
