<?php
session_start();

// FVA: edit story_form works, but redirect to here doesn't

//CSRF token validation
require 'get_token.php';

//activate database
require 'database.php';

//get details to update
$story_id = (string)$_POST['story_id'];
$title = (string)$_POST['title'];
$body = (string)$_POST['body'];
$link = (string)$_POST['link'];

// FVA: might want to bind params here
$stmt = $mysqli->prepare("UPDATE `stories` SET (title, body, link) values (?,?,?)
WHERE id=$story_id");

$stmt->bind_param('sss', $title, $body, $link);

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->close();

header("location: feed.php");

?>