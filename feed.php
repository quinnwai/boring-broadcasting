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

echo "<ul>\n";
while($stmt->fetch()){
	printf("\t
	<li>Title: %s</a><br>
	Body: %s<br>
	Link: %s<br>
	</li>\n",
		htmlspecialchars($title),
		htmlspecialchars($body),
        htmlspecialchars($link)
	); 
	?>
	<div>
	<form action ="view_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
		<input type="submit" name ="view_story" value = "view"/>
    </form>
	<?php
	if($isUser){ ?>
	
	<form action ="delete_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" name ="delete_story" value = "delete"/>
    </form>
    <form action ="edit_story.php" method="POST">
        <input type="hidden" name="story_id" value="<?php printf($id); ?>"/>
		<input type="hidden" name="story_id" value="<?php printf($title); ?>"/>
		<input type="hidden" name="story_id" value="<?php printf($body); ?>"/>
		<input type="hidden" name="story_id" value="<?php printf($link); ?>"/>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" name ="edit_story" value = "edit"/>
    </form>
</div>
<?php 
}
}
echo "</ul>\n";
$stmt->close();
?>