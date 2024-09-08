<?php
session_start();
$host = 'sql7.freesqldatabase.com';
$dbname = 'sql7729990';
$username = 'sql7729990';
$password = 'TpVkCzRwp3';

$conn = new mysqli($host, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    // Hash the password and verify it
    $sql = "SELECT * FROM users WHERE username = '$uname'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: profile.php');
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in to your account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="container" class="container">
    <h1>Log in</h1>
    <form action="login.php" method="POST">
        <label for="username">Your username:</label><br>
        <input type="text" name="uname" placeholder="Eg: somby" required><br><br>
        <label for="password">Your password:</label><br>
        <input type="password" name="pass" placeholder="Eg: +&Somby_(€733" required><br><br>
        <button type="submit">Log in</button>
    </form>
  </div>
</body>
</html>
