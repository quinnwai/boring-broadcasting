<?php
session_start();

require 'database.php';
require 'get_token.php';

//get details to update
$user = (string)$_SESSION['user'];

$stmt = $mysqli->prepare("SELECT last_name, first_name
FROM users WHERE username=?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $user);

$stmt->execute();
$stmt->bind_result($last, $first);


echo "Welcome " . $user . "<br>";
echo "Please find below your name according to our records: ";

echo "<ul>\n";
while($stmt->fetch()){
	printf("\t<li>%s %s</li>\n",
		htmlspecialchars($first),
		htmlspecialchars($last)
	);
}
echo "</ul>\n";

$stmt->close();

?>

<p> Want to change your password? </p>
<form action="change_password.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<label>New Password: <input type="password" name="pwd"/> </label>
<input type="submit" value="return" />
</form>

<p> Want to head back to the news feed?</p>
<form action="feed.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />
</form>