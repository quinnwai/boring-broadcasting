<?php
session_start();

// FVA: edit story_form works, but redirect to here doesn't

//CSRF token validation
require 'get_token.php';

//activate database
require 'database.php';

//get details to update
$story_id = $_POST['story_id'];
$title = (string)$_POST['title'];
$body = (string)$_POST['body'];
$link = (string)$_POST['link'];

// FVA: might want to bind params here
$stmt = $mysqli->prepare("UPDATE `stories` SET title = ?, body = ?, link = ?
WHERE id = ?");

$stmt->bind_param('sssi', $title, $body, $link, $story_id);

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$stmt->close();
?>
<p> Success! Story has been edited. Want to return back to story? <p>
<form action ="feed.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />