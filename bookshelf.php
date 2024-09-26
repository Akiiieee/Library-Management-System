<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookshelf</title>
  <link rel="stylesheet" href="bookshelf.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
  <img id="bookshelf_bg" src="wood.jpg">

  <header>BOOKSHELF</header>
  <li>
    <a href="register_interface.html"> 
      <i class="fa-solid fa-right-from-bracket"></i>
      <span></span>
    </a>
  </li>
  <div id="search-container">
    <input type="text" id="search-input" placeholder="Search for a book..." onkeyup="searchBooks()">
    <button class="search" id=""><img src="search.gif"></button>
  </div>

  <div id="books-container">
    <?php
      require_once('connect.php');
      $sql = "SELECT * FROM books";
      $result = mysqli_query($conn, $sql);

      if (!$result) {
        echo "Error retrieving books: " . mysqli_error($conn);
      } else {
        while ($row = mysqli_fetch_assoc($result)) {
          $book_id = $row['id'];
          $book_name = $row['book_name'];
          $book_info = $row['book_info'];
          $book_stock = $row['book_stock'];
          $book_img = $row['book_img'];

          echo "<div class='book'>";
          if (!empty($book_img)) {
            echo "<img src='$book_img' alt='$book_name' onclick='showModal(this)'>";
          } else {
            echo "<p>No image available</p>";
          }
          echo "<div class='book-details' style='display: none;'>";
          echo "<h2>$book_name</h2>";
          echo "<p>$book_info</p>";
          echo "<span class='stock'>Available Stock of this Book: $book_stock</span>";
          
          if ($book_stock > 0) {
            echo "<button class='borrow-button' onclick='showBorrowForm($book_id, \"$book_name\")'>Borrow</button>";
          } else {
            echo "<button class='borrow-button' disabled>Borrow</button>";
          }
          
          echo "</div>";
          echo "</div>";
        }
      }
      mysqli_close($conn);
    ?>
  </div>

  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <img id="modal-img" src="" alt="">
      <div id="modal-details"></div>
    </div>
  </div>

  <div id="borrowModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeBorrowModal()">&times;</span>
    <form id="borrowForm" enctype="multipart/form-data" action="send_request.php" method="POST">
      <h2>Please fill out the form below</h2>
      <input type="hidden" id="book-id" name="book-id">
      <label for="student-name">Student Name:</label>
      <input type="text" id="student-name" name="student-name" readonly>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" readonly>
      <label for="book-name">Book Name:</label>
      <input type="text" id="book-name" name="book-name" readonly>
      <label for="student-id-front">Student ID Picture Front:</label>
      <input type="file" id="student-id-front" name="student-id-front" accept="image/*" required>
      <label for="student-id-back">Student ID Picture Back:</label>
      <input type="file" id="student-id-back" name="student-id-back" accept="image/*" required>
      <button type="submit">Confirm Request</button>
    </form>
  </div>
</div>


  <script src="bookshelf.js"></script>
</body>
</html>
