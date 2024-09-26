<!DOCTYPE html>
<html>
<head>
  <title>Registered Users</title>
  <link rel="stylesheet" href="table.css"> 
</head>
<body>
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

  <script>
    const sortBtn = document.getElementById('sort-btn');
    const selectAllCheckbox = document.getElementById('select-all');
    const deleteBtn = document.getElementById('delete-btn');
    const userRows = document.querySelectorAll('.user-row'); 
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const searchBar = document.getElementById('search-bar');

    function sortTable() {
      const users = Array.from(userRows).map(row => ({
        username: row.querySelector('td:nth-child(1)').textContent,
        row 
      }));

      users.sort((a, b) => a.username.localeCompare(b.username)); 

      userRows.forEach((row, index) => {
        row.parentNode.appendChild(users[index].row);
      });
    }

    sortBtn.addEventListener('click', sortTable);

    selectAllCheckbox.addEventListener('change', (event) => {
      userCheckboxes.forEach(checkbox => checkbox.checked = event.target.checked);
    });

    deleteBtn.addEventListener('click', function() {
      const selectedUsernames = [];
      userCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
          const username = checkbox.parentNode.parentNode.querySelector('td:nth-child(1)').textContent;
          selectedUsernames.push(username);
        }
      });

      if (selectedUsernames.length === 0) {
        alert('Please select users to delete');
        return;
      }

      const xhr = new XMLHttpRequest();
      xhr.open("POST", "delete_users.php", true);
      xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            alert('Users deleted successfully');
            location.reload();
          } else {
            alert('Failed to delete users');
          }
        }
      };
      xhr.send(JSON.stringify({ usernames: selectedUsernames }));
    });

    searchBar.addEventListener('input', function() {
      const filter = searchBar.value.toLowerCase();
      userRows.forEach(row => {
        const username = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
        if (username.includes(filter)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  </script>
</body>
</html>
