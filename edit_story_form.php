<?php

//get details to display before update
$story_id = $_POST['story_id'];
$title = $_POST['title'];
$body = $_POST['body'];
$link = $_POST['link'];

?>

<form action ="edit_story.php" method="POST">
    <input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
    <input type="text" name="title" value="<?php printf($title); ?>"/>
    <input type="text" name="body" value="<?php printf($body); ?>"/>
    <input type="text" name="link" value="<?php printf($link); ?>"/>
    <input type="submit" name ="edit_story"/>
</form>



