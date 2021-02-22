<?php
session_start();

require 'database.php';
require 'get_token.php';

//get details to update
$comment = $_POST['comment'];
$story_id = $_POST['story_id'];
$user = $_SESSION['user'];

$stmt = $mysqli->prepare("INSERT INTO comments
(username, comment, story_id) VALUES (?,?,?)");

$stmt->bind_param('sss', $user, $comment, $story_id);

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->close();

?>

<p> Success! Comment has been added. Want to return back to story? <p>
<form action ="view_story.php" method="POST">
<input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />

