<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>Admin</h1>
      <img src="ad.png" alt="Admin Icon">
    </header>
    <main>
      <form action="admin_login.php" method="post">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" name="username" id="username" required placeholder="Enter admin username">
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" required placeholder="Enter admin password">
        </div>
        <div class="error-message">
          <?php
            if (isset($_GET['error'])) { echo $_GET['error']; }
          ?>
        </div>
        <button type="submit">Login</button>
        <button id="back" type="button">Back</button>
      </form>
    </main>
  </div>
  <script>
    const backButton = document.getElementById('back');
    backButton.addEventListener('click', function() {
      window.location.href = "admin_user.html";
    });
  </script>
</body>
</html>
