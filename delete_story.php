<?php
require 'database.php';

$story_id = $_POST['story_id'];

$stmt = $mysqli->prepare("DELETE FROM `stories` WHERE id = $story_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

// $stmt->bind_param('s', $story_id);

$stmt->execute();

$stmt->close();

// TODO: if this doesn't work, use form because of CSRF stuff and include hidden var as seen in feed
header("location: feed.php");
?>