<!DOCTYPE html>
<html>
<head>
  <title>Book Requests</title>
  <link rel="stylesheet" href="table.css">
</head>
<body>
  <h1>Book Requests</h1>

  <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "integrative_system";
  
      $conn = mysqli_connect($servername, $username, $password, $dbname);
  
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
  
      $sql = "SELECT * FROM requests";
      $result = mysqli_query($conn, $sql);
  
      if (mysqli_num_rows($result) > 0) {
          echo "<table>";
          echo "<tr>";
          echo "<th>Student Name</th>";
          echo "<th>Book Name</th>";
          echo "<th>Student ID (Front)</th>";
          echo "<th>Student ID (Back)</th>";
          echo "<th>Date of Request</th>";
          echo "</tr>";
  
          while ($row = mysqli_fetch_assoc($result)) {
            $idFrontImage = $row["Student_ID_picFront"];
            $idBackImage = $row["Student_ID_picBack"];
  
            echo "<tr>";
            echo "<td>" . $row["Student_name"] . "</td>";
            echo "<td>" . $row["book_name"] . "</td>";
            echo "<td>";
            if (!empty($idFrontImage)) {
              echo "<img src='" . $idFrontImage . "' alt='Student ID (Front)' style='width:auto;height:200px;'>";
            } else {
              echo "No image available";
            }
            echo "</td>";
            echo "<td>";
            if (!empty($idBackImage)) {
              echo "<img src='" . $idBackImage . "' alt='Student ID (Back)' style='width:auto;height: 200px;'>";
            } else {
              echo "No image available";
            }
            echo "</td>";
            echo "<td>" . $row["Date_of_request"] . "</td>";
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
