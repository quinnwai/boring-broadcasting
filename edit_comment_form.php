<?php
//get details to display before update
session_start();


//CSRF token validation
require 'get_token.php';

$comment_id = (int)$_POST['comment_id'];
$comment = (string)$_POST['comment'];
$story_id = (string)$_POST['story_id'];
?>

<form action ="edit_comment.php" method="POST">
    <input type="hidden" name="comment_id" value="<?php printf($comment_id); ?>"/>
    <input type="text" name="comment" value="<?php printf($comment); ?>"/>
    <input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
    <input type="submit" value ="edit"/>
</form>

