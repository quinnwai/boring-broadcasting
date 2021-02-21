<?php
require 'database.php';

$story_id = $_POST['story_id'];
$title = $_POST['title'];
$body = $_POST['body'];
$link = $_POST['link'];

$stmt = $mysqli->prepare("UPDATE `stories` SET `title`=$title,
`body`=$body,`link`=$link WHERE id=$story_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->close();

header("location: feed.php");

?>