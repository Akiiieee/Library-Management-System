<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "integrative_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$ids = $data['ids'];

if (!empty($ids)) {
  foreach ($ids as $id) {

    $select_sql = "SELECT Student_name,email, book_name, Student_ID_picFront, Student_ID_picBack FROM requests WHERE id = $id";
    $result = mysqli_query($conn, $select_sql);
    $row = mysqli_fetch_assoc($result);
    
    $insert_sql = "INSERT INTO barrowed_books (Student_name,email, book_name, Student_ID_picFront, Student_ID_picBack) VALUES ('" . $row['Student_name'] ."', '" . $row['email']. "', '" . $row['book_name'] . "', '" . $row['Student_ID_picFront'] . "', '" . $row['Student_ID_picBack'] . "')";
    mysqli_query($conn, $insert_sql);
  }
  

  $ids_str = implode(',', $ids);
  $delete_sql = "DELETE FROM requests WHERE id IN ($ids_str)";

  if (mysqli_query($conn, $delete_sql)) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false]);
  }
} else {
  echo json_encode(['success' => false]);
}

mysqli_close($conn);
?>