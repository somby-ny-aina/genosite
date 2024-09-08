<?php
session_start();
$host = 'sql7.freesqldatabase.com';
$dbname = 'sql7729990';
$username = 'sql7729990';
$password = 'TpVkCzRwp3';

$conn = new mysqli($host, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $post_text = $_POST['post_text'];
    $image_url = '';

    if ($_FILES['post_image']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["post_image"]["name"]);
        move_uploaded_file($_FILES["post_image"]["tmp_name"], $target_file);
        $image_url = $target_file;
    }

    $sql = "INSERT INTO posts (user_id, caption, image_url) VALUES ('$user_id', '$post_text', '$image_url')";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: profile.php');
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
    <title>New Post</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <strong>G E N O S I T E</strong>
        <br><br>
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
        <h1>New Post</h1>
        <form action="post.php" method="POST" enctype="multipart/form-data">
            <label for="Description">Post text:</label><br>
            <textarea name="post_text" placeholder="Type your text here." required></textarea><br>
            <label for="photo">Post photo:</label>
            <input type="file" name="post_image" accept="image/*"/><br><br>
            <button type="submit">Publish</button>
        </form>
    </div>
</body>
</html>
