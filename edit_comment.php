<?php
session_start();

require 'database.php';

//get details to update
$comment_id = (int)$_POST['comment_id'];
$comment = (string)$_POST['comment'];
$story_id = (string)$_POST['story_id'];
// printf("story id is: %s", $story_id);

//CSRF token validation
require 'get_token.php';

$stmt = $mysqli->prepare("UPDATE comments SET comment = ? WHERE id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ss', $comment, $comment_id);

$stmt->execute();
$stmt->close();

// TODO: change to form because not view_story stuff
?>
<p> Success! Comment has been changed. Want to return back to story? <p>
<form action ="view_story.php" method="POST">
<input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
<input type="submit" value="return" />