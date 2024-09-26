<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "integrative_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

function send_response($status, $message)
{
  header('Content-Type: application/json');
  echo json_encode(array(
    'status' => $status,
    'message' => $message
  ));
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];

  if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
    echo json_encode(array(
      "status" => "error",
      "message" => "Invalid username"
    ));
    exit();
  }

  $extension = "@evsu.edu.ph";
  if (!str_ends_with($email, $extension)) {
    echo json_encode(array(
      "status" => "error",
      "message" => "Not an EVSU email!"
    ));
    exit();
  }

  savetodb($conn, $username, $password, $email);
} else {
  echo json_encode(array(
    "status" => "error",
    "message" => "Daot na"
  ));
}

function savetodb($conn, $username, $password, $email) {
  $sql = "INSERT INTO registered_user (`username`, `password`,`email`) VALUES (?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    send_response("error", "Something went wrong: " . mysqli_error($conn));
    exit();
  }
  mysqli_stmt_bind_param($stmt, "sss", $username, $password, $email);

  if (!mysqli_stmt_execute($stmt)) {
    send_response("error", "Registration failed: " . mysqli_error($conn));
    exit();
  }

  mysqli_stmt_close($stmt);
  send_response("success", "Registered Successfully!");
}
?>
