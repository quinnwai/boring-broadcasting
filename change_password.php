<?php
session_start();
require 'database.php';
require 'get_token.php';

$pwd = (string)$_POST['pwd'];
$user = $_SESSION['user'];

// TODO: Make sure this works
$stmt = $mysqli->prepare("UPDATE users SET password= ? WHERE username = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('ss', password_hash($pwd, PASSWORD_DEFAULT), $username);
$stmt->execute();
$stmt->close();
echo "Success your password has been successfully changed";

?>
<p> Return back to your profile page? <p>
<form action ="user_details.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />