<?php
require 'database.php';

$comment_id = $_POST['comment_id'];
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("DELETE FROM `comments` WHERE id = $comment_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

// $stmt->bind_param('s', $comment_id);

$stmt->execute();

$stmt->close();

header("location: feed.php");
?>