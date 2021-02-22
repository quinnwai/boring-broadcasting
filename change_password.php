<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Change Password</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="box">
	<h1>BBC News</h1>
</div>
<h2>Change Password</h2>
<?php
session_start();
require 'database.php';
require 'get_token.php';

$pwd = (string)$_POST['pwd'];
$user = $_SESSION['user'];


// update password so long as it is not null
if($pwd != ""){
	$stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE username = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('ss', password_hash($pwd, PASSWORD_DEFAULT), $user);
	$stmt->execute();
	$stmt->close();
	echo "<p>Success! Your password has been successfully changed.</p>";
}
else{
	echo "<p>Please enter in a password that is not null.</p>";
}

?>
	<p> Return back to your profile page? <p>
	<form action ="user_details.php" method="POST">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
	<input type="submit" value="return" />
	</form>

<p> Head back to the news feed?</p>
<form action="feed.php" method="POST">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
	<input type="submit" value="return" />
</form>
</body> 
</html>