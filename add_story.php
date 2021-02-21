<?php
require 'database.php';

//get details to update
$title = $_POST['title'];
$body = $_POST['body'];
$link = $_POST['link'];
$username = $_SESSION['username'];

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("INSERT INTO `stories`
( `username`, `title`, `body`, `link`) VALUES (?,?,?,?)");

$stmt->bind_param('ssss', $username, $title, $body, $link);

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->close();

header("location: feed.php");

?>