<?php
session_start();

//CSRF token validation
require 'get_token.php';

//get details to display before update
$story_id = $_POST['story_id'];
$title = $_POST['title'];
$body = $_POST['body'];
$link = $_POST['link'];

//allow user to change their information
?>
<form action ="edit_story.php" method="POST">
    <input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
    Title: <input type="text" name="title" value="<?php printf($title); ?>"/>
    Body: <input type="text" name="body" value="<?php printf($body); ?>"/>
    Link: <input type="text" name="link" value="<?php printf($link); ?>"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="submit" name ="edit_story"/>
</form>



