<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "integrative_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

function send_response($status, $message, $username = null, $email = null) {
  header('Content-Type: application/json');
  $response = array(
    'status' => $status,
    'message' => $message
  );
  
  if ($username && $email) {
    $response['username'] = $username;
    $response['email'] = $email;
  }

  echo json_encode($response);
  exit();
}

function savetodb($conn, $username, $password, $email) {
    $sql = "SELECT * FROM registered_user WHERE username=? AND password=? AND email=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      send_response("error", "Something went wrong: " . mysqli_error($conn));
      exit();
    }
    
    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $email);

    if (!mysqli_stmt_execute($stmt)) {
      send_response("error", "Login failed: " . mysqli_error($conn));
      exit();
    }
    
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = $result->fetch_assoc()) {
      mysqli_stmt_close($stmt);
      send_response("success", "", $row['username'], $row['email']);
    } else {
      mysqli_stmt_close($stmt);
      send_response("error", "Incorrect credentials");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];

  if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
    send_response("error", "Invalid username");
  }

  $extension = "@evsu.edu.ph";
  if (!str_ends_with($email, $extension)) {
    send_response("error", "Not an EVSU email!");
  }
  
  savetodb($conn, $username, $password, $email);
} else {
  send_response("error", "Invalid request method");
}
?>
