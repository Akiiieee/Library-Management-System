<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "integrative_system";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Create a new MySQLi connection
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Check if connection was successful
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Prepare the SQL query
    $sql = "SELECT * FROM registered_user WHERE email = ?";
    $stmt = $mysqli->prepare($sql);

    // Bind parameters and execute query
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if email exists
    if ($result->num_rows > 0) {
        // Email found
        echo "found";
    } else {
        // Email not found
        echo "not_found";
    }

    // Close statement and connection
    $stmt->close();
    $mysqli->close();
}
?>
