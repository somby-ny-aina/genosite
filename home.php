<?php
session_start();
$host = 'sql7.freesqldatabase.com';
$dbname = 'sql7729990';
$username = 'sql7729990';
$password = 'TpVkCzRwp3';

$conn = new mysqli($host, $username, $password, $dbname);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch posts from the database
$post_query = "SELECT posts.*, users.fullname, users.profile_pic FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$post_result = $conn->query($post_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genosite: Genocide's social media</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function likePost(postId) {
            const likeButton = document.getElementById('like-btn-' + postId);
            const likesCountElement = document.getElementById('likes-count-' + postId);
            const isLiked = likeButton.classList.contains('liked');

            $.ajax({
                url: 'like_post.php',
                type: 'POST',
                data: {
                    post_id: postId,
                    action: isLiked ? 'unlike' : 'like'
                },
                success: function(response) {
                    const newLikeCount = response;
                    if (isLiked) {
                        likeButton.classList.remove('liked');
                    } else {
                        likeButton.classList.add('liked');
                    }
                    likesCountElement.innerHTML = newLikeCount + ' likes';
                }
            });
        }

        $(document).ready(function() {
            $('.like-btn').each(function() {
                const postId = $(this).data('post-id');
                const likeButton = $(this);

                $.ajax({
                    url: 'check_like.php',
                    type: 'POST',
                    data: {
                        post_id: postId
                    },
                    success: function(response) {
                        if (response === 'liked') {
                            likeButton.addClass('liked');
                        }
                    }
                });
            });
        });
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

    <!-- Display posts dynamically -->
    <?php if ($post_result->num_rows > 0): ?>
        <?php while ($post = $post_result->fetch_assoc()): ?>
        <div class="post-container">
            <div class="post-header">
                <img src="<?php echo htmlspecialchars($post['profile_pic']); ?>" alt="Profile Picture" class="profile-pic">
                <div class="user-info">
                    <h2 class="username"><?php echo htmlspecialchars($post['fullname']); ?></h2>
                    <p class="date"><?php echo date('F j, Y', strtotime($post['created_at'])); ?></p>
                </div>
            </div>

            <div class="post-caption">
                <p class="caption-text"><?php echo htmlspecialchars($post['caption']); ?></p>
            </div>

            <?php if ($post['image_url']): ?>
            <div class="post-image">
                <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="Post Image">
            </div>
            <?php endif; ?>

            <div class="post-footer">
                <p id="likes-count-<?php echo $post['id']; ?>" class="likes-count"><?php echo $post['likes']; ?> likes</p>
                <div class="post-actions">
                    <button id="like-btn-<?php echo $post['id']; ?>" class="like-btn" data-post-id="<?php echo $post['id']; ?>" onclick="likePost(<?php echo $post['id']; ?>)">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts available</p>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
