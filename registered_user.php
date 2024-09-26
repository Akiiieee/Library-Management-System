<?php
session_start();
// if wala naka login para no error mo balik sa loginpage
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
  <link rel="stylesheet" href="registered_user_table.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="main--content">
  <div class="header--wrapper">
    <div class="header--title">
      <div class="button-container">
      <li >
          <a href="admin_dashboard.php"> 
            <i class="fas fa-dashboard"></i>
            <span>Dashboard</span>
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
          <a href="registered_user.php"  class="active"> 
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
        <li>
          <button id="show-users-btn">
            <i class="fas fa-users"></i>
            <span>Show Registered Users</span>
          </button>
        </li>

  <div id="registered-users-section" style="display: none;">
    <h1>Registered Users</h1>
    <button id="sort-btn">Sort (A-Z)</button>
    <button id="delete-btn">Delete</button>
    <div class="search--box">
      <button class="search" id=""><img src="search.gif"></button>
      <input class="inputsearch" type="text" placeholder="Search Username" id="search-bar">
    </div>

    <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "integrative_system";
    
      $conn = mysqli_connect($servername, $username, $password, $dbname);
    
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
    
      $sql = "SELECT username, email, Date_of_Registration FROM registered_user";
      $result = mysqli_query($conn, $sql);
    
      if (mysqli_num_rows($result) > 0) {
        echo "<table>";
          echo "<tr>";
            echo "<th>Username</th>";
            echo "<th>Email</th>";
            echo "<th>Date</th>";
            echo "<th>Time</th>";
            echo "<th><input type='checkbox' id='select-all'></th>"; 
          echo "</tr>";
        while($row = mysqli_fetch_assoc($result)) {
          $dateTime = $row["Date_of_Registration"]; 

          $date = date('Y-m-d', strtotime($dateTime));
          $time = date('H:i:s', strtotime($dateTime));

          echo "<tr class='user-row'>"; 
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $date . "</td>";
            echo "<td>" . $time . "</td>";
            echo "<td><input type='checkbox' class='user-checkbox'></td>";
          echo "</tr>";
        }
        echo "</table>";
      } else {
        echo "No records found";
      }
    
      mysqli_close($conn);
    ?>
  </div>
</div>

<script src="registered_user.js">  </script>
</body>
</html>
