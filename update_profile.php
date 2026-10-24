<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "tropicana aquarium");

// Check connection
if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);

    $update_query = "UPDATE register SET full_name='$full_name', username='$username', email='$email', address='$address', phone='$phone', dob='$dob' WHERE user_id='$user_id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: profile.php?update=success");
    } else {
        header("Location: profile.php?update=failure");
    }
}

mysqli_close($conn);
?>
