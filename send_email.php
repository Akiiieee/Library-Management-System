<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
</head>
<body>

<h2>Send Email</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="to">To:</label><br>
    <input type="email" id="to" name="to" required><br><br>
    <label for="subject">Subject:</label><br>
    <input type="text" id="subject" name="subject" required><br><br>
    <label for="message">Message:</label><br>
    <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>
    <input type="submit" name="submit" value="Send Email">
</form>

<?php
ini_set("SMTP", "smtp.example.com");
ini_set("smtp_port", "587"); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST['to'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $headers = "From: christianpaulcolo19@gmail.com\r\n";
    $headers .= "Reply-To: christianpaulcolo19@gmail.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Email sending failed.";
    }
}
?>

</body>
</html>
