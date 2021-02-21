<?php
require 'database.php';
require "authenticate.php";

$stmt = $mysqli->prepare("select id, title, body, link from stories");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($id, $title, $body, $link);

if ($isUser)  { ?>
	<a href="user_data.php"> Want to edit/delete your own stories or comments </a>
<?php  }

echo "<ul>\n";
while($stmt->fetch()){
	printf("\t
	<li>Title: <a href='user_data.php#targetanchor'>%s</a><br>
	Body: %s <br>
	Link: %s<br>
	</li>\n",
		htmlspecialchars($title),
		htmlspecialchars($body),
        htmlspecialchars($link)
	); ?>
	<div>
	<form action ="delete_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
        <input type="submit" name ="delete_story" value = "delete story"/>
    </form>
    <form action ="edit_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
		<input type="hidden" name="story_id" value="<?php printf($title); ?>"/>
		<input type="hidden" name="story_id" value="<?php printf($body); ?>"/>
		<input type="hidden" name="story_id" value="<?php printf($link); ?>"/>
        <input type="submit" name ="edit_story" value = "edit story"/>
    </form>
</div>
<?php }
echo "</ul>\n";
$stmt->close();

if ($isUser) {
	echo "The dude's a user";
}
else if (!$isUser) {
	echo "The dude aint a user";
}
else {
	echo "Bruh. No idea";
	echo $isUser;
}
?>