<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="add_book.css"> </head>
<body>
    <img id="bg" src="add_bookBG.jpg!sw800">
    <h1>Add a Book</h1>
    <form action="add_book.php" method="post" enctype="multipart/form-data"> <label for="book_name">Book Name:</label>
        <input type="text" name="book_name" id="book_name" required>
        <br>
        <label for="book_info">Book Info:</label>
        <textarea name="book_info" id="book_info" required></textarea> <br>
        <label for="book_stock">Stock:</label>
        <input type="number" name="book_stock" id="book_stock" required min="0"> <br>
        <label for="book_img">Book Image:</label>
        <input type="file" name="book_img" id="book_img" accept="image/*"> <br>
        <button type="submit">Add Book</button>
        <button id="back">Back</button>
    </form>
    <script>
    const backButton = document.getElementById('back');
    backButton.addEventListener('click', function() {
      window.location.href = "admin_user.php";
    });
  </script>
</body>
</html>
