<?php
require_once('connect.php');

function sanitizeInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $student_name = sanitizeInput($_POST['student-name']);
  $email = sanitizeInput($_POST['email']);
  $book_name = sanitizeInput($_POST['book-name']);

  $student_id_front_tmp = $_FILES['student-id-front']['tmp_name'];
  $student_id_back_tmp = $_FILES['student-id-back']['tmp_name'];

  $target_dir = "uploads/"; // Ensure this directory exists and is writable
  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
  }

  $student_id_front = $target_dir . basename($_FILES['student-id-front']['name']);
  $student_id_back = $target_dir . basename($_FILES['student-id-back']['name']);

  if (move_uploaded_file($student_id_front_tmp, $student_id_front) && move_uploaded_file($student_id_back_tmp, $student_id_back)) {
    $stmt = $conn->prepare("INSERT INTO requests (Student_name, email, book_name, Student_ID_picFront, Student_ID_picBack) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $student_name, $email, $book_name, $student_id_front, $student_id_back);

    if ($stmt->execute()) {
      $stmt_update_stock = $conn->prepare("UPDATE books SET book_stock = book_stock - 1 WHERE book_name = ? AND book_stock > 0");
      $stmt_update_stock->bind_param("s", $book_name);

      if ($stmt_update_stock->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Request submitted successfully']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Request submitted, but there was an error updating book stock: ' . $conn->error]);
      }

      $stmt_update_stock->close();
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }

    $stmt->close();
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error uploading your files.']);
  }

  $conn->close();
} else {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
