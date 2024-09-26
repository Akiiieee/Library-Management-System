<!DOCTYPE html>
<html>
<head>
  <title>Registered Users</title>
  <link rel="stylesheet" href="table.css">
</head>
<body>
  <h1>Books</h1>
  <button>Restock</button>
  <button>Delete</button>

  <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "integrative_system";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM books";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Name of the Books</th>";
        echo "<th>Books Info</th>";
        echo "<th>Stock of the Books</th>";
        echo "<th>Image of the Books</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result)) {
          $bookImage = $row["book_img"];

          echo "<tr>";
          echo "<td>" . $row["book_name"] . "</td>";
          echo "<td>" . $row["book_info"] . "</td>";
          echo "<td>" . $row["book_stock"] . "</td>";
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
</body>
</html>
