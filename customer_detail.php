<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");


if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

// Retrieve all customer information
$query = "SELECT * FROM register";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://i.imgur.com/NpHVnvk.jpeg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0px;
        }
        .header {
            background-color: #fff;
            padding: 5px;
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


        h1 {
            text-align: center;
            color: #007bff; 
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #007bff; 
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2; 
        }
        table tr:hover {
            background-color: #ddd; 
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
    <h1>Customer Details</h1>
    <table>
        <tr>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone</th>
            <th>DOB</th>
        </tr>
        <?php while ($customer = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $customer['full_name']; ?></td>
                <td><?php echo $customer['username']; ?></td>
                <td><?php echo $customer['email']; ?></td>
                <td><?php echo $customer['address']; ?></td>
                <td><?php echo $customer['phone']; ?></td>
                <td><?php echo $customer['dob']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
mysqli_close($conn);
?>
