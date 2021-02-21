<?php
require 'database.php';

$comment_id = $_POST['comment_id'];

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