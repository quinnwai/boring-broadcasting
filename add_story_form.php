<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Add Story Form</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="box">
	<h1>BBC News</h1>
</div>
<?php
session_start();

//CSRF token validation
require 'get_token.php';

?>
<h2> Add Story </h2>

<form action ="add_story.php" method="POST">
    Title: <input type="text" name="title" />
    Body: <input type="text" name="body"/>
    Link: <input type="text" name="link"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="submit" name ="add_story"/>
</form>
</body> 
</html>