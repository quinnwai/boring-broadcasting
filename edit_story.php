<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Edit Story</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="box">
	<h1>BBC News</h1>
</div>
<h2>Edit Story</h2>
<?php
session_start();

//CSRF token validation
require 'get_token.php';

//activate database
require 'database.php';

//get details to update
$story_id = (int)$_POST['story_id'];
$title = (string)$_POST['title'];
$body = (string)$_POST['body'];
$link = (string)$_POST['link'];

var_dump($story_id);

//update current story with given info
$stmt = $mysqli->prepare("UPDATE stories SET title = ?, body = ?, link = ? WHERE id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

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
</body> 
</html>