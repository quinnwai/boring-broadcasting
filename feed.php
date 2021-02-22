
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Newsfeed</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<?php
session_start();

//activate database
require 'database.php';
require 'get_token.php';

if($_SESSION['isUser']){
	printf("<h2> Welcome %s! \n </h2>", htmlentities($_SESSION['user']));
}

//get all stories
$stmt = $mysqli->prepare("SELECT s.username, s.id, s.title, s.body, s.link, COUNT(u.username) AS number_of_upvotes FROM stories AS s LEFT JOIN upvotes AS u ON u.story_id = s.id GROUP BY s.id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}


$stmt->execute();

$stmt->bind_result($author, $id, $title, $body, $link, $upvotes);


if($_SESSION['isUser']){
	?>
	<form action ="add_story_form.php" method="POST">
		Add your own story! <input type="submit" name ="add_story" value = "Add"/>
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
	</form>
	<form action ="user_details.php" method="POST">
		Go to your profile page <input type="submit" name ="view_details" value = "View profile page"/>
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
	</form>
	<?php
}
else {
	printf("<p> Logged in as guest </p>");
}	
?>
<form action="logout.php">
Logout and return to sign in page? <input type="submit" value = "Logout"/>
</form>

<h2> Stories from your news feed: </h2>
<?php
echo "<ul>\n";
while($stmt->fetch()){
	printf("\t
	<li>Title: %s</a><br>
	Author: %s<br>
	Body: %s<br>
	Upvotes: %s<br>
	</li>\n",
		htmlspecialchars($title),
		htmlspecialchars($author),
		htmlspecialchars($body),
		htmlspecialchars($upvotes)
	); 
	?>
	<div>
	<form class = "row" action ="view_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<input type="submit" name ="view_story" value = "view"/>
    </form>

	<?php
	if($_SESSION['user'] == $author){ ?>
	<form class = "row" action="edit_story_form.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
		<input type="hidden" name="title" value="<?php printf($title); ?>"/>
		<input type="hidden" name="body" value="<?php printf($body); ?>"/>
		<input type="hidden" name="link" value="<?php printf($link); ?>"/>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" name ="edit_story" value = "edit"/>
    </form>

	<form class = "row" action ="delete_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" name ="delete_story" value = "delete"/>
    </form>
	</div>
	<?php 
	}
}
echo "</ul>\n";
$stmt->close();
?>
</body> 
</html>