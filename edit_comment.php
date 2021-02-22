<?php
session_start();

require 'database.php';

//CSRF token validation
require 'get_token.php';

//get details to update
$comment_id = (int)$_POST['comment_id'];
$comment = (string)$_POST['comment'];
$story_id = (string)$_POST['story_id'];
// printf("story id is: %s", $story_id);

$stmt = $mysqli->prepare("UPDATE comments SET comment = ? WHERE id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ss', $comment, $comment_id);

$stmt->execute();
$stmt->close();


?>
<p> Success! Comment has been changed. Want to return back to story? <p>
<form action ="view_story.php" method="POST">
<input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />