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

<h2> Add Story </h2>

<div>
<?php
session_start();

require 'database.php';
require 'get_token.php';

//get details to update
$title = (string)$_POST['title'];
$body = (string)$_POST['body'];
$link = (string)$_POST['link'];
$user = $_SESSION['user'];

if($title == "" || $body == ""){
	echo "<p> Story was not saved. Make sure to fill out the title and body. </p>";
}
else{
	$stmt = $mysqli->prepare("INSERT INTO `stories`
	( `username`, `title`, `body`, `link`) VALUES (?,?,?,?)");
	
	$stmt->bind_param('ssss', $user, $title, $body, $link);
	
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	
	$stmt->execute();
	
	$stmt->close();
	
	
	echo "<p> Story successfully added. </p>";
}
?>

<form action="feed.php" method="POST">
Return to feed? <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />
</div>
</body> 
</html>