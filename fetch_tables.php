<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:admin.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "integrative_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchData($conn, $table) {
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

function fetchCount($conn, $table) {
    $sql = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($sql);

    $count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    }
    return $count;
}

$borrowed_books = fetchData($conn, "barrowed_books");
$books = fetchData($conn, "books");
$registered_user = fetchData($conn, "registered_user");
$requests = fetchData($conn, "requests");
$returned_books = fetchData($conn, "returned_books");

$borrowed_books_count = fetchCount($conn, "barrowed_books");
$books_count = fetchCount($conn, "books");
$registered_user_count = fetchCount($conn, "registered_user");
$requests_count = fetchCount($conn, "requests");
$returned_books_count = fetchCount($conn, "returned_books");

$conn->close();

echo json_encode([
    'borrowed_books' => $borrowed_books,
    'books' => $books,
    'registered_user' => $registered_user,
    'requests' => $requests,
    'returned_books' => $returned_books,
    'counts' => [
        'borrowed_books' => $borrowed_books_count,
        'books' => $books_count,
        'registered_user' => $registered_user_count,
        'requests' => $requests_count,
        'returned_books' => $returned_books_count
    ]
]);
?>
