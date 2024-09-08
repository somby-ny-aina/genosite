<?php
session_start();
$host = 'sql7.freesqldatabase.com';
$dbname = 'sql7729990';
$username = 'sql7729990';
$password = 'TpVkCzRwp3';

$conn = new mysqli($host, $username, $password, $dbname);

$loggedInUserId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$followingId = isset($_POST['following_id']) ? intval($_POST['following_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Handle follow action
if ($loggedInUserId > 0 && $followingId > 0) {
    if ($action == 'follow') {
        // Insert a new follow record
        $followQuery = "INSERT INTO follows (follower_id, following_id) VALUES ($loggedInUserId, $followingId)";
        $conn->query($followQuery);
    } elseif ($action == 'unfollow') {
        // Delete the follow record
        $unfollowQuery = "DELETE FROM follows WHERE follower_id = $loggedInUserId AND following_id = $followingId";
        $conn->query($unfollowQuery);
    }

    // Return success response (you can customize the response as needed)
    echo 'success';
} else {
    echo 'error';
}

$conn->close();
?>
