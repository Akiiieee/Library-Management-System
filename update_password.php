<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "integrative_system";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $newPassword = $_POST["new_password"];

    // Create a new MySQLi connection
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Check if connection was successful
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Prepare the SQL query to update the password
    $sql = "UPDATE registered_user SET password = ? WHERE email = ?";
    $stmt = $mysqli->prepare($sql);

    // Bind parameters and execute query
    $stmt->bind_param("ss", $newPassword, $email);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Password updated successfully
        echo "Password updated successfully.";
    } else {
        // No rows affected, password update failed
        echo "Password update failed.";
    }

    // Close statement and connection
    $stmt->close();
    $mysqli->close();
}
?>
