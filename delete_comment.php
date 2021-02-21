<?php
session_start();
require 'database.php';
require 'get_token.php';

$comment_id = $_POST['comment_id'];


$stmt = $mysqli->prepare("DELETE FROM `comments` WHERE id = $comment_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

// $stmt->bind_param('s', $comment_id);

$stmt->execute();

$stmt->close();
?>

<p> Success! Comment has been deleted. Want to return back to story? <p>
<form action ="view_story.php" method="POST">
<input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />