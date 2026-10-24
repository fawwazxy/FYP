<?php

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'tropicana aquarium';


$conn = new mysqli($db_host, $db_username, $db_password, $db_name);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Register 
if (isset($_POST['submit'])) {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    
    if (empty($full_name) || empty($username) || empty($email) || empty($password) || empty($address) || empty($phone) || empty($day) || empty($month) || empty($year)) {
        echo '<script>alert("Please fill in all fields.");</script>';
    } else {
        // Check if username or email already exists
        $sql_check_username = "SELECT * FROM register WHERE username = '$username'";
        $sql_check_email = "SELECT * FROM register WHERE email = '$email'";
        $result_check_username = $conn->query($sql_check_username);
        $result_check_email = $conn->query($sql_check_email);
        
        if ($result_check_username->num_rows > 0) {
            echo '<script>alert("Username already exists.");</script>';
        } elseif ($result_check_email->num_rows > 0) {
            echo '<script>alert("Email already exists.");</script>';
        } else {
            // Insert user data into database
            $dob = "$year-$month-$day"; 

            $sql = "INSERT INTO register (full_name, username, email, password, address, phone, dob) 
                    VALUES ('$full_name', '$username', '$email', '$password', '$address', '$phone', '$dob')";
            $result = $conn->query($sql);

            if ($result) {
                echo '<script>alert("Registration successful!");</script>';
            } else {
                echo '<p style="color: red;">Error: ' . $conn->error . '</p>';
            }
        }
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styling/register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Register</h1>
            <div class="input-box">
                <input type="text" placeholder="Full Name" required name="full_name">
                <i class='bx bx-user'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Username" required name="username">
                <i class='bx bx-user'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Email" required name="email">
                <i class='bx bx-envelope'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" required name="password">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Address" required name="address">
                <i class='bx bx-map'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Phone Number" required name="phone">
                <i class='bx bx-phone'></i>
            </div>
            <div class="input-box">
                <label for="date-select">Date of Birth:</label>
                <div class="date-select">
                    <select name="day" id="day-select"></select>
                    <select name="month" id="month-select"></select>
                    <select name="year" id="year-select"></select>
                </div>
            </div>
            <button type="submit" class="btn" name="submit">Register</button>
            <div class="register-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>

    <script>
        
        const daySelect = document.getElementById('day-select');
        for (let i = 1; i <= 31; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            daySelect.appendChild(option);
        }

        
        const monthSelect = document.getElementById('month-select');
        for (let i = 1; i <= 12; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            monthSelect.appendChild(option);
        }

        
        const yearSelect = document.getElementById('year-select');
        for (let i = 2024; i >= 1925; i--) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            yearSelect.appendChild(option);
        }
    </script>
</body>

</html>
