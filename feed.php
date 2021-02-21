<?php
require 'database.php';
require "authenticate.php";

$stmt = $mysqli->prepare("select s.id, s.title, s.body, s.link, c.comment, c.post_date from stories as s join comments as c on c.story_id = s.id");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($id, $title, $body, $link, $comments, $post_date);

if ($isUser)  { ?>
	<a href="user_data.php"> Want to edit/delete your own stories or comments </a>
<?php  }

echo "<ul>\n";
while($stmt->fetch()){
	printf("\t<li>Title: %s <br> 
	Body: %s <br> 
	Link: %s <br>
    <ul>\n
	\t<li>Comment : %s <br>
	Post Date: %s
	</li></li>
    <ul>\n",
		htmlspecialchars($title),
		htmlspecialchars($body),
        htmlspecialchars($link),
		htmlspecialchars($comments),
		htmlspecialchars($post_date)
	);
	if ($isUser) { ?>
		<form action="comment.php">
			<label> Add a comment:<input type = "text" name="comment"/> </label>
			<input type="hidden" name = "story_id" value = <?php $id  ?>>
			<input type="submit" />
		</form>
	<?php }
}
echo "</ul>\n";
$stmt->close();

//if isUser, display a tab at top of screen -> Edit comments/stroies
//redirect to page with stories and comments from only that user.
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