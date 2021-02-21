<?php

//get details to display before update
$story_id = $_POST['story_id'];
$title = $_POST['title'];
$body = $_POST['body'];
$link = $_POST['link'];

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

?>

<form action ="edit_story.php" method="POST">
    <input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
    <input type="text" name="title" value="<?php printf($title); ?>"/>
    <input type="text" name="body" value="<?php printf($body); ?>"/>
    <input type="text" name="link" value="<?php printf($link); ?>"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="submit" name ="edit_story"/>
</form>



