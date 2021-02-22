<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Individual Story View</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="box">
	<h1>BBC News</h1>
</div>

<div>
<?php
session_start();

//CSRF token validation
require 'get_token.php';

//activate database
require 'database.php';

// save story_id for future use in queries
$story_id = (int)$_POST['story_id'];


//// print out story ////

//sql query needed
$stmt = $mysqli->prepare("SELECT s.title, u.first_name, u.last_name, s.body, s.link FROM stories AS s JOIN users AS u ON s.username = u.username WHERE s.id = ?");
$stmt->bind_param('s', $story_id);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

// specify what results to bind before binding
$stmt->execute();
$stmt->bind_result($title, $first_name, $last_name, $body, $link);
$stmt->fetch();
$stmt->close();

//actually print story w/ or without link
if(empty($link)){
    printf("
    <h1>%s</h1>
    <p>By %s %s</p>
    <p>%s<br></p>
    \n",
    htmlentities($title),
    htmlentities($first_name),
    htmlentities($last_name),
    htmlentities($body)
    );
}
else{
    printf("
    <h1>%s</h1>
    <p>By %s %s</p>
    <p>%s<br></p>
    <p>(<a href=%s>Link</a> to the original article) <br></p>
    \n",
    htmlentities($title),
    htmlentities($first_name),
    htmlentities($last_name),
    htmlentities($body),
    htmlentities($link)
    );
}


//// print out upvotes ////
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM upvotes WHERE story_id = ?");
$stmt->bind_param('s', $story_id);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

// specify what results to bind before binding
$stmt->execute();
$stmt->bind_result($num_upvotes);
$stmt->fetch();
$stmt->close();

//include upvotes button
?>
<form action ='upvote.php' method='POST'>
    <input type='hidden' name='story_id' value='<?php printf($story_id); ?>'/>
    <input type='hidden' name='token' value='<?php printf($_SESSION['token']); ?>' />
    <?php printf(htmlentities($num_upvotes)); ?> <input type='submit' value = '&#8679;'/>
</form>
</div>

<div>
<h1>Comments</h1>
<?php


//// print out comments ////

//get comments by story id
$stmt = $mysqli->prepare("SELECT id, username, post_date, comment FROM comments WHERE story_id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('i', $story_id);

//store in variables
$stmt->execute();
$stmt->bind_result($comment_id, $commenter, $post_date, $comment);

while($stmt->fetch()){
    printf("\t
	<p><b>%s</b>: %s (posted on %s)</p>
    \n",
    $commenter,
    $comment,
    substr($post_date, 0, -3));

    if($_SESSION['user'] == $commenter){
    ?>
    <form class = 'row' action ='edit_comment_form.php' method='POST'>
        <input type='hidden' name='comment_id' value='<?php printf($comment_id); ?>'/>
        <input type='hidden' name='comment' value='<?php printf($comment); ?>'/>
        <input type='hidden' name='story_id' value='<?php printf($story_id); ?>'/>
        <input type='hidden' name='token' value='<?php printf($_SESSION['token']); ?>' />
        <input type='submit' value = 'edit'/>
    </form>
    <form class = 'row' action ='delete_comment.php' method='POST'>
        <input type='hidden' name='comment_id' value='<?php printf($comment_id); ?>'/>
        <input type='hidden' name='story_id' value='<?php printf($story_id); ?>'/>
        <input type='hidden' name='token' value='<?php printf($_SESSION['token']); ?>' />
        <input type='submit' value = 'delete'/>
    </form>
    <?php
    }
}
?>
<br>
<form action ="add_comment.php" method="POST">
    <label>Add a new comment: <input type="text" name="comment" /></label>
    <input type="hidden" name="token" value="<?php printf($_SESSION['token']);?>" />
    <input type="hidden" name="story_id" value="<?php printf($story_id);?>" />
    <input type="submit" name ="add_comment"/>
</form>
</div>

<div>
<p> Want to head back to the news feed?</p>
<form action="feed.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />
</form>
</div>
</body> 
</html>