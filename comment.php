<?php
require "database.php";

$username = $_SESSION['username'];
$comment = $_POST['comment'];
$story_id = $_POST['story_id'];

$stmt = $mysqli->prepare("INSERT INTO `comments`(`username`, `comment`, `story_id`) 
VALUES ($username,$comment,$story_id");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sss', $username, $comment, $story_id);

$stmt->execute();

$stmt->close();

header("Location: feed.php");

?>