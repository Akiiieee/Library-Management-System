<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "integrative_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$data = json_decode(file_get_contents('php://input'), true);
if (!empty($data['usernames'])) {
  $usernames = $data['usernames'];
  $placeholders = implode(',', array_fill(0, count($usernames), '?'));

  $stmt = $conn->prepare("DELETE FROM registered_user WHERE username IN ($placeholders)");
  $types = str_repeat('s', count($usernames));
  $stmt->bind_param($types, ...$usernames);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
  }

  $stmt->close();
} else {
  echo json_encode(['success' => false, 'error' => 'No usernames provided']);
}

mysqli_close($conn);
?>
