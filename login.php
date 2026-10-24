<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styling/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        function showAlert(message) {
            alert(message);
        }

        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</head>

<body>
    <div class="wrapper">
        <form method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bx-user'></i>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="checkbox">
                <input type="checkbox" id="show-password" onclick="togglePassword()">
                <label for="show-password">Show Password</label>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>Don't have an account?<a href="register.php">Register</a></p>
            </div>
        </form>
        
        <!-- Staff Login Option -->
        <div class="staff-login">
            <p>Are you staff? <a href="staff_login.php">Click here to login as staff</a></p>
        </div>
        
        <?php
       
        $db_host = 'localhost';
        $db_username = 'root';
        $db_password = '';
        $db_name = 'tropicana aquarium';

        
        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Login 
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            
            $username = mysqli_real_escape_string($conn, $username);
            $password = mysqli_real_escape_string($conn, $password);

            // Query to retrieve user data
            $sql = "SELECT * FROM register WHERE username = '$username' AND password = '$password'";
            $result = $conn->query($sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    $user_data = $result->fetch_assoc();

                    // Start session
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $user_data['user_id'];
                    $_SESSION['logged_in'] = true;
                    
                    
                    $_SESSION['login_success'] = true;
                    header('Location: homepage.php');
                    exit;
                } else {
                    echo '<script>showAlert("Invalid username or password");</script>';
                }
            } else {
                echo '<script>showAlert("Error: ' . mysqli_error($conn) . '");</script>';
            }
        }

        
        $conn->close();
        ?>
    </div>
</body>

</html>
