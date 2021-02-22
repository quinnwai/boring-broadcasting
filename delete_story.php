<?php
session_start();
require 'database.php';
require 'get_token.php';

$story_id = (int)$_POST['story_id'];

$stmt = $mysqli->prepare("DELETE FROM `stories` WHERE id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $story_id);

$stmt->execute();

$stmt->close();

// TODO: if this doesn't work, use form because of CSRF stuff and include hidden var as seen in feed
?>
<p> Success! Story has been deleted. Want to return back to story? <p>
<form action ="feed.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />