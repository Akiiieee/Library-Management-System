<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="request.css">
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
          <a href="books.php"> 
            <i class="fas fa-book"></i>
            <span>Books</span>
          </a>
        </li>
        <li>
          <a href="request.php"  class="active"> 
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
  <li>
    <button id="show-users-btn">
      <i class="fas fa-layer-group"></i>
      <span>Show Request</span>
    </button>
  </li>
  <div id="registered-users-section" style="display: none;">
    <h1>Request</h1>
    <button id="sort-btn">Sort (A-Z)</button>
    <button id="decline-btn">Decline Request</button>
    <button id="confirm-btn">Confirm Request</button>
    <div class="search--box">
      <button class="search" id="search-btn"><img src="search.gif"></button>
      <input class="inputsearch" type="text" placeholder="Search Student" id="search-bar">
    </div>

    <div id="request-table-container">
      <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "integrative_system";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM requests";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          echo "<table id='request-table'>";
          echo "<tr>";
          echo "<th>Student Name</th>";
          echo "<th>Email</th>";
          echo "<th>Book Name</th>";
          echo "<th>Student ID Picture (Front)</th>";
          echo "<th>Student ID Picture (Back)</th>";
          echo "<th>Date</th>";
          echo "<th>Time</th>";
          echo "<th><input type='checkbox' id='select-all'></th>";
          echo "</tr>";

          while ($row = mysqli_fetch_assoc($result)) {
            $dateTime = $row["Date_of_request"];
            $frontImagePath = $row["Student_ID_picFront"];
            $backImagePath = $row["Student_ID_picBack"];
            $date = date('Y-m-d', strtotime($dateTime));
            $time = date('H:i:s', strtotime($dateTime));

            echo "<tr>";
            echo "<td>" . $row["Student_name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["book_name"] . "</td>";

            if (!empty($frontImagePath)) {
              echo "<td><img src='" . $frontImagePath . "' alt='" . $row["Student_name"] . " front ID' style='width:100px;height:auto;'></td>";
            } else {
              echo "<td>No front ID image available</td>";
            }

            if (!empty($backImagePath)) {
              echo "<td><img src='" . $backImagePath . "' alt='" . $row["Student_name"] . " back ID' style='width:100px;height:auto;'></td>";
            } else {
              echo "<td>No back ID image available</td>";
            }

            echo "<td>" . $date . "</td>";
            echo "<td>" . $time . "</td>";
            echo "<td><input type='checkbox' class='category-checkbox' data-id='" . $row["id"] . "'></td>";
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

  <script src="request.js"></script>
</div>
</body>
</html>
