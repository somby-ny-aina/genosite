<?php
session_start();
$host = 'sql7.freesqldatabase.com';
$dbname = 'sql7729990';
$username = 'sql7729990';
$password = 'TpVkCzRwp3';

$conn = new mysqli($host, $username, $password, $dbname);

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'like') {
    // Check if the user has already liked this post
    $stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->bind_param("ii", $user_id, $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // User has not liked the post yet, so insert the like
        $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
        $stmt->close();
        
        // Increase the like count
        $stmt = $conn->prepare("UPDATE posts SET likes = likes + 1 WHERE id = ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->close();
    }
} elseif ($action === 'unlike') {
    // Check if the user has liked this post
    $stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->bind_param("ii", $user_id, $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User has liked the post, so remove the like
        $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
        $stmt->close();
        
        // Decrease the like count
        $stmt = $conn->prepare("UPDATE posts SET likes = likes - 1 WHERE id = ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->close();
    }
} else {
    echo "Invalid action.";
    exit;
}

// Fetch the updated like count
$stmt = $conn->prepare("SELECT likes FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$like_count = $row['likes'];
$stmt->close();

echo $like_count;
$conn->close();
?>
