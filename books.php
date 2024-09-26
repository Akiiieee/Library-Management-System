<?php
session_start();
// if not logged in, redirect to admin.php
if (!isset($_SESSION['username'])) {
    header("location:admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="books_table.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="main--content">
  <div class="header--wrapper">
    <div class="header--title">
      <div class="button-container">
        <li>
          <a href="admin_dashboard.php"> 
            <i class="fas fa-dashboard"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="books.php"  class="active"> 
            <i class="fas fa-book"></i>
            <span>Books</span>
          </a>
        </li>
        <li>
          <a href="request.php"> 
            <i class="fas fa-bell"></i>
            <span>Request</span>
          </a>
        </li>
        <li>
          <a href="registered_user.php"> 
            <i class="fas fa-users"></i>
            <span>Registered Users</span>
          </a>
        </li>
        <li>
          <a href="barrowed.php"> 
            <i class="fas fa-hand-holding"></i>
            <span>Borrowed Books</span>
          </a>
        </li>
        <li>
          <a href="return.php"> 
            <i class="fas fa-hand-holding-hand"></i>
            <span>Returned Books</span>
          </a>
        </li>
        <li>
          <a id="logout" href="admin.php"> 
            <i class="fa-solid fa-right-from-bracket"></i>
          </a>
        </li>
      </div>
    </div>
    <div class="user--info">
      <img id="bg" src="ad.png" alt="">
    </div>
  </div>
  <div class="button-container">
    <li>
      <button id="show-users-btn">
        <i class="fas fa-book"></i>
        <span>Show Books</span>
      </button>
    </li>
    <button id="add-books-btn" class="icon-text">
        <i class="fas fa-plus"></i>
        <span>Add Books</span>
    </button>
  </div>
  <div id="registered-users-section" style="display: none;">
    <h1>Books</h1>
    <form id="update-stock-form" method="post" action="">
      <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "integrative_system";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (isset($_POST['delete_ids'])) {
            $delete_ids = $_POST['delete_ids'];
            $delete_ids = implode(",", array_map('intval', $delete_ids));

            $sql_delete = "DELETE FROM books WHERE id IN ($delete_ids)";
            if (mysqli_query($conn, $sql_delete)) {
              echo "Selected books have been deleted.";
            } else {
              echo "Error deleting records: " . mysqli_error($conn);
            }
          }

          if (isset($_POST['update_stock'])) {
            foreach ($_POST['update_stock'] as $book_id => $new_stock) {
              $book_id = intval($book_id);
              $new_stock = intval($new_stock);
              $sql_update = "UPDATE books SET book_stock = $new_stock WHERE id = $book_id";
              if (!mysqli_query($conn, $sql_update)) {
                echo "Error updating stock for book ID $book_id: " . mysqli_error($conn);
              }
            }
            echo "Stock updated successfully.";
          }
        }

        $sql = "SELECT * FROM books";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Select</th>";
            echo "<th>Name of the Books</th>";
            echo "<th>Books Info</th>";
            echo "<th>Stock of the Books</th>";
            echo "<th>Update Stock</th>";
            echo "<th>Image of the Books</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
              $bookImage = $row["book_img"];

              echo "<tr>";
              echo "<td><input type='checkbox' name='delete_ids[]' value='" . $row["id"] . "'></td>";
              echo "<td>" . $row["book_name"] . "</td>";
              echo "<td>" . $row["book_info"] . "</td>";
              echo "<td>" . $row["book_stock"] . "</td>";
              echo "<td><input type='number' name='update_stock[" . $row["id"] . "]' value='" . $row["book_stock"] . "' min='0'></td>";
              echo "<td>";
              if (!empty($bookImage)) {
                echo "<img src='" . $bookImage . "' alt='" . $row["book_name"] . " Book Image' style='width:100px;height:auto;'>";
              } else {
                echo "No image available";
              }
              echo "</td>";
              echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No records found";
        }
        mysqli_close($conn);
      ?>
      <div class="buttons-wrapper">
        <button type="submit" name="delete" id="delete-btn">Delete Selected</button>
        <button type="submit" name="update" id="update-btn">Update Stock</button>
      </div>
    </form>
  </div>
  
  <div id="response"></div>
  <div id="add-book-section" style="display: none;">
  <h1>Add a Book</h1>
  <form id="add-book-form" method="post" enctype="multipart/form-data">
    <label for="book_name">Book Name:</label>
    <input type="text" name="book_name" id="book_name" required>
    <br>
    <label for="book_info">Book Info:</label>
    <textarea name="book_info" id="book_info" required></textarea>
    <br>
    <label for="book_stock">Stock:</label>
    <input type="number" name="book_stock" id="book_stock" required min="0">
    <br>
    <label for="book_img">Book Image:</label>
    <input type="file" name="book_img" id="book_img" accept="image/*">
    <br>
    <button type="submit">Add Book</button>
    <button type="button" id="back-btn">Back</button>
  </form>
</div>

  <script src="books.js"></script>
</div>
</body>
</html>
