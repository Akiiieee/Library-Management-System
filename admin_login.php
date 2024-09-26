<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$servername = "localhost";
$user = "root";
$pass = "";
$dbname = "integrative_system";

$conn = new mysqli($servername, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $_SESSION['username'] = $username;
    header("Location: admin_dashboard.php");
    exit;
} else {
    header("Location: admin.php?error=" . urlencode("incorrect username or password!"));
}

$stmt->close();
$conn->close();
?>
