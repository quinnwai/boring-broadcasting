<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Edit Comment</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="box">
	<h1>BBC News</h1>
</div>
<h2>Edit Comment</h2>

<?php
session_start();

require 'database.php';

//CSRF token validation
require 'get_token.php';

//get details to update
$comment_id = (int)$_POST['comment_id'];
$comment = (string)$_POST['comment'];
$story_id = (int)$_POST['story_id'];

$stmt = $mysqli->prepare("UPDATE comments SET comment = ? WHERE id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('si', $comment, $comment_id);

$stmt->execute();
$stmt->close();


?>
<p> Success! Comment has been changed. Want to return back to story? <p>
<form action ="view_story.php" method="POST">
<input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />
</body> 
</html>