<?php
session_start();

// Database connection
$host = 'sql7.freesqldatabase.com';
$dbname = 'sql7729990';
$username = 'sql7729990';
$password = 'TpVkCzRwp3';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['save'])) {
    $user_id = $_SESSION['user_id'];
    
    $name = $conn->real_escape_string($_POST['name']);
    $username = $conn->real_escape_string($_POST['username']);
    
    $profile_pic = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_name = basename($_FILES['photo']['name']);
        $upload_file = $upload_dir . $file_name;

        if (move_uploaded_file($file_tmp, $upload_file)) {
            $profile_pic = $upload_file;
        }
    }

    if ($profile_pic) {
        $stmt = $conn->prepare("UPDATE users SET fullname = ?, username = ?, profile_pic = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $username, $profile_pic, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET fullname = ?, username = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $username, $user_id);
    }

    if ($stmt->execute()) {
        header('Location: profile.php');
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
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
        </div>
    </div>

    <div class="npost">
        <h1>Settings</h1>
        <form action="setting.php" method="post" enctype="multipart/form-data">
            <label for="name">Your name:</label><br>
            <input type="text" name="name" style="height: 30px" placeholder="Your name" value=""><br><br>
            
            <label for="username">Your username:</label><br>
            <input type="text" name="username" style="height: 30px" placeholder="Your username" value=""><br><br>
            
            <label for="photo">Your profile photo:</label>
            <input type="file" name="photo" accept="image/*"/><br><br>
            
            <button type="submit" name="save">Save</button>
        </form>
    </div>
</body>
</html>

