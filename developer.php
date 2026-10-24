<?php
// homepage.php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

// Check for login success alert
if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
  echo '<script>alert("Login successful!");</script>';
  // Unset the session variable after displaying the alert
  unset($_SESSION['login_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizational Chart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://i.imgur.com/NpHVnvk.jpeg');
            background-size: cover;
            background-position: center;
            color: #333; /* Text color */
        }

        .header {
            background-color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed; /* Fixed position to stick at the top */
            top: 0; /* Align to the top of the viewport */
            z-index: 1000; /* Ensure it's above other content */
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

        .org-chart {
            text-align: center;
            color: #fff; /* Text color for cards */
            margin-top: 200px; /* Adjust for the height of the fixed header */
            margin-bottom: 100px; /* Added margin at the bottom */
            max-width: 800px; /* Adjust as needed */
            padding: 20px;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Box shadow for depth */
            margin: auto; /* Center horizontally */
            position: absolute; /* Positioning to center */
            left: 0;
            right: 0;
            width: 50%; /* Adjust width as needed */
            bottom: 10%;
        }

        .org-chart ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .org-chart ul ul {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            padding-left: 0;
        }

        .org-chart li {
            display: inline-block;
            margin: 0 20px;
            position: relative;
            width: 250px; /* Card width increased */
            transition: transform 0.3s ease;
        }

        .org-chart li:hover {
            transform: translateY(-10px); /* Lift on hover */
        }

        /* Different hover styles for each card */
        .org-chart .card:nth-child(odd):hover {
            background-color: #ffa07a; /* Light salmon */
            transform: scale(1.05); /* Scale effect */
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        .org-chart .card:nth-child(even):hover {
            background-color: #add8e6; /* Light blue */
            transform: scale(1.05); /* Scale effect */
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        .org-chart .card:nth-child(3):hover {
            background-color: #90ee90; /* Light green */
            transform: scale(1.05); /* Scale effect */
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        .org-chart .card:nth-child(4):hover {
            background-color: #ffb6c1; /* Light pink */
            transform: scale(1.05); /* Scale effect */
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        .org-chart .card h2 {
            font-weight: bold;
            margin: 0 0 10px;
            font-size: 18px;
            color: #007bff; /* Heading color */
        }

        .org-chart .card p {
            font-size: 15px;
            color: white;
            margin: 5px 0;
        }

        .node-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 10px auto; /* Center images */
            display: block;
            object-fit: cover;
            border: 3px solid #007bff; /* Border around images */
            transition: transform 0.3s ease;
        }

        .node-image:hover {
            transform: scale(1.1); /* Scale image on hover */
        }

        .org-chart h3 {
            font-size: 40px;
            margin: 0 0 30px;
            color: #fff;
            text-shadow: -2px -2px 0 #000, 2px -2px 0 #000, -2px 2px 0 #000, 2px 2px 0 #000; /* Text shadow for title */
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
            <li><a href="homepage.php">Home</a></li>
            <li><a href="Product List.php">Shop</a></li>
            <li><a href="developer.php">Our Team</a></li>
            <li><a href="about us.php">About Us</a></li>
            <li><a href="login.php">Login</a></li>
          <?php } ?>
        </ul>
    </div>

    <div class="org-chart">
        <h3>Our Development Team</h3>
        <ul>
            <li>
                <div class="card">
                    <h2>Project Manager</h2>
                    <img src="e2e4977c0a5912c8a43fd69a6c06b745.png" alt="Syazwan Daniel" class="node-image">
                    <p>Muhammad Fawwaz Ruzain Bin Fakhrol Ruzi</p>
                    <p>fawwazsenget@gmail.com</p>
                </div>
                <ul>
                    <li>
                        <div class="card">
                            <h2>UI Designer</h2>
                            <img src="7efabce43b10b25f2c9b6d4e4a429a5d.png" alt="Hakimi" class="node-image">
                            <p>Muhammad Fitri bin Abdul Wahab</p>
                            <p>fitri@gmail.com</p>
                        </div>
                    </li>
                    <li>
                        <div class="card">
                            <h2>System Analyst</h2>
                            <img src="565208986f114393da6de77240144222.png" alt="Ahmad Hafiz" class="node-image">
                            <p>Muhammad Firdaus bin Syahrul Anuar</p>
                            <p>firdaussyah@gmail.com</p>
                        </div>
                    </li>
                    <li>
                        <div class="card">
                            <h2>Programmer</h2>
                            <img src="019dbca6fb5b812e97eba8ae5f73d6b8.png" alt="Zakwan 'Irfan" class="node-image">
                            <p>Wan Muhammad Yusof bin Wan Yahya</p>
                            <p>usop@gmail.com</p>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</body>
</html>
