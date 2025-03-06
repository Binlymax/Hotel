<?php
include("database/connection.php");

$comment_text = $_POST['comment_text'];
$room_id = $_POST['room_id'];
$rating = $_POST['rating'];
$username = $_COOKIE['username'];

$sql_add_comment = "INSERT INTO `room_rating` (`id`, `room_id`, `username`, `comment`, `comment_time`, `rating`) VALUES (NULL, '{$room_id}', '{$username}', '{$comment_text}', now(), '{$rating}')";
$result = $conn->query($sql_add_comment);
if($result === true){
    header("location:book-page.php?room_id=".$room_id);
}
else{
    echo "Error";
}