<?php
session_start();

//CSRF token validation
require 'get_token.php';

//activate database
require 'database.php';

// save story_id for future use in queries
$story_id = $_POST['story_id'];


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
$stmt = $mysqli->prepare("SELECT id, username, post_date, comment FROM comments WHERE story_id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
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

    if($_SESSION['user'] == $commenter){
    ?>
    <form action ='edit_comment_form.php' method='POST'>
        <input type='hidden' name='comment_id' value='<?php printf($comment_id); ?>'/>
        <input type='hidden' name='comment' value='<?php printf($comment); ?>'/>
        <input type='hidden' name='story_id' value='<?php printf($story_id); ?>'/>
        <input type='hidden' name='token' value='<?php printf($_SESSION['token']); ?>' />
        <input type='submit' value = 'edit'/>
    </form>
    <form action ='delete_comment.php' method='POST'>
        <input type='hidden' name='comment_id' value='<?php printf($comment_id); ?>'/>
        <input type='hidden' name='token' value='<?php printf($_SESSION['token']); ?>' />
        <input type='submit' value = 'delete'/>
    </form>
    <?php
    }
}

//TODO: make sure logged in still as user rather than guest
// (prolly need to change feed.php with authentication business)
?>
<br><br>
<p> Want to head back to the news feed?</p>
<form action="feed.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />