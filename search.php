<?php
session_start(); // Start the session to access session variables

$host = 'sql7.freesqldatabase.com';
$dbname = 'sql7729990';
$username = 'sql7729990';
$password = 'TpVkCzRwp3';

$conn = new mysqli($host, $username, $password, $dbname);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script>
        function redirectToProfile() {
            var userId = document.getElementById('user_id').value;
            if (userId) {
                window.location.href = 'profile.php?id=' + encodeURIComponent(userId);
            } else {
                alert('Please enter a user ID.');
            }
        }
    </script>
</head>

<body>
    <div class="header">
        <div>
          <strong>G E N O S I T E</strong>
          <br><br>
        </div>
        <div class="menu">
            <a href="home.php" class="menu-item">
                <i class="fas fa-home"></i>
            </a>
            <a href="post.php" class="menu-item">
                <i class="fas fa-edit"></i>
            </a>
            <a href="profile.php" class="menu-item">
                <i class="fas fa-user"></i>
            </a>
            <a href="setting.php" class="menu-item">
                <i class="fas fa-cog"></i>
            </a>
            <a href="search.php" class="menu-item">
                <i class="fas fa-search"></i>
            </a>
            <a href="logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>

    <div class="npost">
        <h1>Search</h1>
        <label for="user">Type the user ID:</label><br>
        <input type="number" id="user_id" placeholder="Type user ID here."/><br><br>
        <button type="button" onclick="redirectToProfile()">Search</button>
    </div>
</body>
</html>
