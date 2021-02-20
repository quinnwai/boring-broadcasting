<?php
require "database.php";


$stmt = $mysqli->prepare("select id,title, body, link, 
comments.comment, comments.post_date from stories 
join comments on (comments.story_id = stories.id)
Group by story_id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($id, $title, $body, $link, $comments, $post_date);

echo "<ul>\n";
while($stmt->fetch()){
	printf("\t<li>Title: %s <br> 
	Body: %s <br> 
	Link: %s <br>
    <ul>\n
	\t<li>Comment : %s <br>
	Post Date: %s",
		htmlspecialchars($title),
		htmlspecialchars($body),
        htmlspecialchars($link),
		htmlspecialchars($comments),
		htmlspecialchars($post_date)
	); 
    
    ?>
    <form action ="delete_comment.php" method="POST">
        <input type="hidden" name="filename" value="<?php printf($files[$i]); ?>"/>
        <input type="submit" value ="delete"/>
    </form>
    <form action ="edit_comment.php" method="POST">
        <input type="hidden" name="filename" value="<?php printf($files[$i]); ?>"/>
        <input type="submit" value ="delete"/>
    </form>
    <?php echo "</li>" ?>
    <?php echo "</ul\n>" ?>
	
    <form action ="delete_story.php" method="POST">
        <input type="hidden" name="filename" value="<?php printf($files[$i]); ?>"/>
        <input type="submit" value ="delete"/>
    </form>
    <form action ="edit_story.php" method="POST">
        <input type="hidden" name="filename" value="<?php printf($files[$i]); ?>"/>
        <input type="submit" value ="delete"/>
    </form>
    <?php echo "</li>" ?>
	<?php 
}
echo "</ul>\n";
$stmt->close();

?>