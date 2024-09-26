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
  $ids_str = implode(',', $ids);
  $sql = "DELETE FROM requests WHERE id IN ($ids_str)";

  if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false]);
  }
} else {
  echo json_encode(['success' => false]);
}

mysqli_close($conn);
?>
