<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA_Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Staff Login</title>
    <link rel="stylesheet" href="styling/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .error {
            display: none;
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h1>Staff Login</h1>
            <div class="input-box">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <i class='bx bx-user'></i>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db_host = 'localhost';
        $db_username = 'root';
        $db_password = '';
        $db_name = 'tropicana aquarium';

        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate input
        if (empty($username) || empty($password)) {
            echo '<script>alert("Please enter both username and password");</script>';
        } else {

            $username = mysqli_real_escape_string($conn, $username);
            $password = mysqli_real_escape_string($conn, $password);

            // Query to check credentials
            $sql = "SELECT * FROM staff WHERE username = '$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $user_data = $result->fetch_assoc();
                // Verify password
                if ($password == $user_data['password']) {
                    $conn->close();
                    echo '<script>alert("Login successful"); window.location.replace("staff_dashboard.php");</script>';
                    exit; 
                } else {
                    echo '<script>alert("Incorrect password");</script>';
                }
            } else {
                echo '<script>alert("Invalid username or password");</script>';
            }
        }

        $conn->close();
    }
    ?>
</body>

</html>
