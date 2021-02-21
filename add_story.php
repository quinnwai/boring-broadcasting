<?php
session_start();

require 'database.php';
require 'get_token.php';

//get details to update
$title = $_POST['title'];
$body = $_POST['body'];
$link = $_POST['link'];
$user = $_SESSION['user'];

$stmt = $mysqli->prepare("INSERT INTO `stories`
( `username`, `title`, `body`, `link`) VALUES (?,?,?,?)");

$stmt->bind_param('ssss', $user, $title, $body, $link);

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->close();

?>

<p> Story successfully added. Return to feed </p>
<form action="feed.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />

