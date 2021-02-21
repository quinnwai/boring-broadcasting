<?php
//get details to display before update
$comment_id = $_POST['comment_id'];
$comment = $_POST['comment'];

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
?>

<form action ="edit_comment.php" method="POST">
    <input type="hidden" name="comment_id" value="<?php printf($comment_id); ?>"/>
    <input type="text" name="comment" value="<?php printf($comment); ?>"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="submit" name ="edit_story"/>
</form>

