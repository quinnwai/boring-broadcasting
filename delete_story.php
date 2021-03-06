<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Delete Story</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="box">
	<h1>BBC News</h1>
</div>
<h2>Delete Story</h2>
<?php
session_start();
require 'database.php';
require 'get_token.php';

$story_id = (int)$_POST['story_id'];


$stmt1 = $mysqli->prepare("DELETE FROM comments WHERE story_id = ?");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt1->bind_param('s', $story_id);

$stmt1->execute();

$stmt1->close();

$stmt2 = $mysqli->prepare("DELETE FROM upvotes WHERE story_id = ?");
if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt2->bind_param('s', $story_id);

$stmt2->execute();

$stmt2->close();

$stmt = $mysqli->prepare("DELETE FROM `stories` WHERE id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $story_id);

$stmt->execute();

$stmt->close();

// TODO: if this doesn't work, use form because of CSRF stuff and include hidden var as seen in feed
?>
<p> Success! Story has been deleted. Want to return back to story? <p>
<form action ="feed.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />
</body> 
</html>