<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $logged_in = true;
} else {
    header("Location: login.php");
    exit;
}

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");

// Check connection
if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

// Retrieve customer information
$query = "SELECT * FROM register WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$customer = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        .header {
            background-color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            z-index: 1000;
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
            margin: 0;
            padding: 0;
        }

        .nav li {
            margin-left: 20px;
            margin-right: 20px;
        }

        .nav a {
            text-decoration: none;
            color: #333;
            transition: color 0.2s ease;
        }

        .nav a:hover {
            color: #666;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://i.imgur.com/NpHVnvk.jpeg') center;
            background-size: cover;
            background-position: center;
        }

        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .profile-info {
            padding: 20px;
        }

        .profile-info label {
            display: block;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .profile-info input[type="text"],
        .profile-info input[type="email"],
        .profile-info input[type="tel"],
        .profile-info input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f9fa;
            color: #495057;
            font-size: 16px;
        }

        .profile-info input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .profile-info input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .profile-info form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const updateStatus = urlParams.get('update');
            if (updateStatus === 'success') {
                alert('Profile updated successfully!');
            } else if (updateStatus === 'failure') {
                alert('Failed to update profile. Please try again.');
            }
        });
    </script>
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
    <div class="profile-container">
        <div class="profile-header">
            <h2>Profile</h2>
        </div>
        <div class="profile-info">
            <form action="update_profile.php" method="POST">
                <label for="full-name">Full Name:</label>
                <input type="text" id="full-name" name="full_name" value="<?php echo $customer['full_name']; ?>">

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $customer['username']; ?>">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $customer['email']; ?>">

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $customer['address']; ?>">

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $customer['phone']; ?>">

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $customer['dob']; ?>">

                <input type="submit" value="Save Changes">
            </form>
        </div>
    </div>
</body>
</html>
