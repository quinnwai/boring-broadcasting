<?php
require 'database.php';

//get details to update
$story_id = $_POST['story_id'];
$title = $_POST['title'];
$body = $_POST['body'];
$link = $_POST['link'];

$stmt = $mysqli->prepare("UPDATE `stories` SET (title, body, link) values (?,?,?)
WHERE id=$story_id ");

$stmt->bind_param('sss', $title, $body, $link);

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->close();

header("location: feed.php");

?>