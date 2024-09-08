<?php
$host = 'sql7.freesqldatabase.com';
$dbname = 'sql7729990';
$username = 'sql7729990';
$password = 'TpVkCzRwp3';

$conn = new mysqli($host, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = $_POST['uname'];
    $fullname = $_POST['fullname'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);  // Hash the password

    $sql = "INSERT INTO users (username, fullname, password) VALUES ('$uname', '$fullname', '$pass')";
    
    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully.";
        header('Location: login.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register: Create an account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="container" class="container">
    <h1>Register</h1>
    <form action="register.php" method="POST">
        <label for="username">Your username:</label><br>
        <input type="text" name="uname" placeholder="Eg: somby" required><br><br>
        <label for="fullname">Your name:</label><br>
        <input type="text" name="fullname" placeholder="Eg: Somby Ny Aina" required><br><br>
        <label for="password">Your password:</label><br>
        <input type="password" name="pass" placeholder="Eg: +&Somby_(€733" required><br><br>
        <button type="submit">Register</button>
    </form>
  </div>
</body>
</html>
