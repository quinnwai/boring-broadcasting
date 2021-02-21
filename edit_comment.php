<?php
require 'database.php';

//get details to update
$comment_id = $_POST['comment_id'];
$comment = $_POST['comment'];

$stmt = $mysqli->prepare("UPDATE `comments` SET `comment`=$comment
 WHERE id=$comment_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();
$stmt->close();

header("location: feed.php");

?>