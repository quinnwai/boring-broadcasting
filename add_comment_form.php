<?php
session_start();

$story_id = $_POST['story_id'];
$user = $_SESSION['user'];

//CSRF token validation
require 'get_token.php';

?>

<form action ="add_comment.php" method="POST">
    Comment: <input type="text" name="comment" />
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="hidden" name="story_id" value="<?php echo $story_id?>" />
    <input type="submit" name ="add_comment"/>
</form>
