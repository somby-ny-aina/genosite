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

$stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
$stmt->bind_param("ii", $user_id, $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo 'liked';
} else {
    echo 'not_liked';
}

$stmt->close();
$conn->close();
?>
