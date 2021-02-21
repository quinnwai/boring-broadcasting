<?php

//activate database
require 'database.php';

// save story_id for future use in queries
$story_id = $_POST['story_id'];
 if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

//// print out story ////

//sql query needed
$stmt = $mysqli->prepare("SELECT s.title, u.first_name, u.last_name, s.body, s.link FROM stories AS s JOIN users AS u ON s.username = u.username WHERE id = ?");
$stmt->bind_param('s', $story_id);

// specify what results to bind before binding
$stmt->execute();
$stmt->bind_result($title, $first_name, $last_name, $body, $link);
$stmt->fetch();

printf("
<h1>%s</h1>
<p>By %s %s</p>
<p>%s<br></p>
<a href=%s>Link</a> to the original article <br></p>
\n",
htmlspecialchars($title),
htmlspecialchars($first_name),
htmlspecialchars($last_name),
htmlspecialchars($body),
htmlspecialchars($link)
);

$stmt->close();


//// print out comments ////

//get comments by story id
$stmt = $mysqli->prepare("SELECT c.id, c.username, c.post_date, c.comment FROM stories as s JOIN comments as c ON s.id = c.story_id WHERE s.id = ?");
$stmt->bind_param('s', $story_id);

//store in variables
$stmt->execute();
$stmt->bind_result($comment_id, $commenter, $post_date, $comment);

while($stmt->fetch()){
    printf("\t
	<p><b>%s</b>: %s (posted on %s)</p>
    \n",
    $commenter,
    $comment,
    substr($post_date, 5, 5));

    ?>
    <form action ="edit_story.php" method="POST">
        <input type="hidden" name="comment_id" value="<?php printf($comment_id); ?>"/>
		<input type="hidden" name="story_id" value="<?php printf($title); ?>"/>
		<input type="hidden" name="story_id" value="<?php printf($body); ?>"/>
		<input type="hidden" name="story_id" value="<?php printf($link); ?>"/>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" name ="edit_story" value = "edit"/>
    <?php

}

?>
<br><br>
<p> Want to head back to the news feed?</p>
<form action="feed.php">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />