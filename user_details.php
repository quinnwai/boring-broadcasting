<?php
session_start();

require 'database.php';
require 'get_token.php';

//get details to update
$user = (string)$_SESSION['user'];

$stmt = $mysqli->prepare("SELECT last_name, first_name FROM users WHERE username=?");

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

$stmt2 = $mysqli->prepare("SELECT id, title, body, link FROM stories WHERE username = ?");
if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt2->bind_param('s', $user);

$stmt2->execute();

$stmt2->bind_result($id, $title, $body, $link);

?>
<form action="logout.php">
Logout and return to sign in page? <input type="submit" value = "Logout"/>
</form>

<?php
echo "<ul>\n";
while($stmt2->fetch()){
	printf("\t
	<li>Title: %s</a><br>
	Body: %s<br>
	</li>\n",
		htmlspecialchars($title),
		htmlspecialchars($body)
	); 
	?>
	<div>
	<form action ="view_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<input type="submit" name ="view_story" value = "view"/>
    </form>
	<form action ="delete_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" name ="delete_story" value = "delete"/>
    </form>
    <form action="edit_story_form.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
		<input type="hidden" name="title" value="<?php printf($title); ?>"/>
		<input type="hidden" name="body" value="<?php printf($body); ?>"/>
		<input type="hidden" name="link" value="<?php printf($link); ?>"/>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" name ="edit_story" value = "edit"/>
    </form>
	</div>
	<?php 
}
echo "</ul>\n";
$stmt2->close();

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