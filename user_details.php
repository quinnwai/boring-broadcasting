<?php
session_start();

require 'database.php';
require 'get_token.php';

//get details to update
$user = $_SESSION['user'];

$stmt = $mysqli->prepare("SELECT `last_name`, `first_name`, `password` 
FROM `users` WHERE username = ?");

$stmt->bind_param('s', $user);

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();
$stmt->bind_result($last, $first, $password);

$stmt->close();

echo "Welcome " . $user . "<br>";
echo "Your full name according to our records is " . $first . " " . $last;
?>

<p> Want to change your password? </p>
<form action="change_password.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<label>Old Password: <input type="password" name="old_password"/> </label>
<label>New Password: <input type="password" name="new_password"/> </label>
<input type="submit" value="return" />

