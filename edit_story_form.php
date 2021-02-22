<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Edit Story Form</title>
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

//get details to display before update
$story_id = (int)$_POST['story_id'];
$title = (string)$_POST['title'];
$body = (string)$_POST['body'];
$link = (string)$_POST['link'];

//allow user to change their information
//Textarea sourced from W3Schools: https://www.w3schools.com/tags/tag_textarea.asp
?>
<form action ="edit_story.php" method="POST">
    <input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
    Title: <input type="text" name="title" value="<?php printf($title); ?>"/>
    <textarea id="" name="body" rows="4" cols="50" value="<?php printf($body); ?>"></textarea>
    Link: <input type="text" name="link" value="<?php printf($link); ?>"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="submit" value ="edit"/>
</form>
</body> 
</html>