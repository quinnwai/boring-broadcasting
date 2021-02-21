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

header("location: feed.php");
?>