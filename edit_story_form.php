<?php
session_start();

//CSRF token validation
require 'get_token.php';

//get details to display before update
$story_id = (int)$_POST['story_id'];
$title = (string)$_POST['title'];
$body = (string)$_POST['body'];
$link = (string)$_POST['link'];
printf("this is in fact story %s", $story_id);

//allow user to change their information
?>
<form action ="edit_story.php" method="POST">
    <input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
    Title: <input type="text" name="title" value="<?php printf($title); ?>"/>
    Body: <input type="text" name="body" value="<?php printf($body); ?>"/>
    Link: <input type="text" name="link" value="<?php printf($link); ?>"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="submit" value ="edit"/>
</form>



