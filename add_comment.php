<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Add Comment</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="box">
	<h1>BBC News</h1>
</div>
<h2> Add Comment </h2>

<div>
<?php
session_start();

require 'database.php';
require 'get_token.php';

//get details to update
$comment = (string)$_POST['comment'];
$story_id = (int)$_POST['story_id'];
$user = $_SESSION['user'];

if($comment == ""){
	echo "<p> Comment was not saved. Make sure to fill out the comment section! </p>";
}
else{
	$stmt = $mysqli->prepare("INSERT INTO comments
	(username, comment, story_id) VALUES (?,?,?)");

	$stmt->bind_param('ssi', $user, $comment, $story_id);

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->execute();
	$stmt->close();

	echo "<p> Success! Comment has been added. </p>";
}

?>

<form action ="view_story.php" method="POST">
<input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<label> Want to return back to story? <input type="submit" value="return" /> </label>
</form>
</div>
</body> 
</html>