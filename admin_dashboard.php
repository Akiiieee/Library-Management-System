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
          <a href="admin_dashboard.php" class="active"> 
            <i class="fas fa-dashboard"></i>
            <span >Dashboard</span>
          </a>
        </li>
        <li>
          <a href="books.php"> 
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

  <div class="button-container" id="borrowed-books-container" data-file="barrowed.php">
  <h2>Borrowed Books</h2>
  <span id="borrowed-books-count"></span>
</div>
<div class="button-container" id="books-container" data-file="books.php">
  <h2>Books</h2>
  <span id="books-count"></span>
</div>
<div class="button-container" id="registered-users-container" data-file="registered_user.php">
  <h2>Registered Users</h2>
  <span id="registered-users-count"></span>
</div>
<div class="button-container" id="requests-container" data-file="request.php">
  <h2>Requests</h2>
  <span id="requests-count"></span>
</div>
<div class="button-container" id="returned-books-container" data-file="return.php">
  <h2>Returned Books</h2>
  <span id="returned-books-count"></span>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function() {
    fetch('fetch_tables.php')
      .then(response => response.json())
      .then(data => {
        document.getElementById('borrowed-books-count').textContent = data.counts.borrowed_books;
        document.getElementById('books-count').textContent = data.counts.books;
        document.getElementById('registered-users-count').textContent = data.counts.registered_user;
        document.getElementById('requests-count').textContent = data.counts.requests;
        document.getElementById('returned-books-count').textContent = data.counts.returned_books;

        document.querySelectorAll('.button-container').forEach(button => {
        button.addEventListener('click', function() {
            const file = this.getAttribute('data-file');
            window.location.href = file; // Redirect to the PHP file specified in data-file attribute
          });
        });
      });
  });
</script>

</body>
</html>
