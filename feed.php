<?php
session_start();

//activate database
require 'database.php';

//Check CSRF token if already logged in, else login (for either user or guest)
if($_SESSION['user']){
	require 'get_token.php';
}
else{
	require "authenticate.php";
}

if($_SESSION['isUser']){
	printf("Welcome %s! \n <br><br>", htmlentities($_SESSION['user']));
}

//get all stories
$stmt = $mysqli->prepare("SELECT username, id, title, body, link FROM stories");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}


$stmt->execute();

$stmt->bind_result($author, $id, $title, $body, $link);

echo "<ul>\n";
while($stmt->fetch()){
	printf("\t
	<li>Title: %s</a><br>
	Author: %s<br>
	Body: %s<br>
	</li>\n",
		htmlspecialchars($title),
		htmlspecialchars($author),
		htmlspecialchars($body)
	); 
	?>
	<div>
	<form action ="view_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<input type="submit" name ="view_story" value = "view"/>
    </form>
	<?php
	if($_SESSION['user'] == $author){ ?>
	
	<form action ="delete_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" name ="delete_story" value = "delete"/>
    </form>
    <form action="edit_story_form.php" method="POST">
        <input type="hidden" name="id" value="<?php printf($id); ?>"/>
		<input type="hidden" name="title" value="<?php printf($title); ?>"/>
		<input type="hidden" name="body" value="<?php printf($body); ?>"/>
		<input type="hidden" name="link" value="<?php printf($link); ?>"/>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" name ="edit_story" value = "edit"/>
    </form>
	</div>
	<?php 
	}
}
echo "</ul>\n";
$stmt->close();

if($_SESSION['isUser']){
	?>
	<form action ="add_story_form.php" method="POST">
		Add your own story! <input type="submit" name ="view_story" value = "add"/>
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
	</form>
	
	<?php
}	
?>


<p> Return to login?</p>
<form action="logout.php">
<input type="submit" value = "return"/>