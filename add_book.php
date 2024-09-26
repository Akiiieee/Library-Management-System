<?php

require_once('connect.php');

function sanitizeInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function sendResponse($status, $message) {
  header('Content-Type: application/json');
  echo json_encode(array(
    'status' => $status,
    'message' => $message
  ));
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $book_name = sanitizeInput($_POST["book_name"]);
  $book_info = sanitizeInput($_POST["book_info"]);
  $book_stock = (int)$_POST["book_stock"];

  if (!isset($_FILES["book_img"])) {
    sendResponse("error", "No image file uploaded.");
  }

  $target_dir = "uploads/";
  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
  }

  $target_file = $target_dir . basename($_FILES["book_img"]["name"]);
  $uploadOk = true;

  $check = getimagesize($_FILES["book_img"]["tmp_name"]);
  if ($check === false) {
    sendResponse("error", "File is not an image.");
  }

  // if (file_exists($target_file)) {
  //   sendResponse("error", "Sorry, file already exists.");
  // }

  if (!move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file)) {
    sendResponse("error", "Sorry, there was an error uploading your file.");
  }

  $sql = "INSERT INTO books (book_name, book_info, book_stock, book_img)
          VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt) {
    sendResponse("error", "Error preparing statement: " . mysqli_error($conn));
  }

  mysqli_stmt_bind_param($stmt, "ssis", $book_name, $book_info, $book_stock, $target_file);

  if (!mysqli_stmt_execute($stmt)) {
    sendResponse("error", "Error executing statement: " . mysqli_error($conn));
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  sendResponse("success", "New record created successfully");
} else {
  sendResponse("error", "Invalid request method.");
}

?>
