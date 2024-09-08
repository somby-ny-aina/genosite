<?php
session_start();
$host = 'sql7.freesqldatabase.com';
$dbname = 'sql7729990';
$username = 'sql7729990';
$password = 'TpVkCzRwp3';

$conn = new mysqli($host, $username, $password, $dbname);

$user_id = isset($_GET['id']) ? intval($_GET['id']) : $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
    $username = $user['username'];
    $fullname = $user['fullname'];
    $followers = $user['followers'];
    $profile_pic = $user['profile_pic'];
} else {
    echo "User not found.";
}

// Fetch posts by the user
$post_query = "SELECT * FROM posts WHERE user_id = $user_id";
$post_result = $conn->query($post_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $fullname; ?>'s Profile</title>
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
            <a href="logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>

    <div class="profile">
        <div class="pic">
            <img src="<?php echo $profile_pic; ?>" alt="Profile Picture">
        </div>

        <div class="info">
            <strong><?php echo $fullname; ?></strong>
            <p>@<?php echo $username; ?></p>
        </div>
        <hr>
    </div>

    <?php while ($post = $post_result->fetch_assoc()): ?>
    <div class="post-container">
        <div class="post-header">
            <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="profile-pic">
            <div class="user-info">
                <h2 class="username"><?php echo $fullname; ?></h2>
                <p class="date"><?php echo date('F j, Y', strtotime($post['created_at'])); ?></p>
            </div>
        </div>

        <div class="post-caption">
            <p class="caption-text"><?php echo htmlspecialchars($post['caption']); ?></p>
        </div>
        <?php if ($post['image_url']): ?>
        <div class="post-image">
            <img src="<?php echo $post['image_url']; ?>" alt="Post Image">
        </div>
        <?php endif; ?>
        <div class="post-footer">
            <p class="likes-count"><?php echo $post['likes']; ?> likes</p>
            <div class="post-actions">
                <button class="like-btn"><i class="fas fa-heart"></i></button>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</body>
</html>

<?php
$conn->close();
?>
