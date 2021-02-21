<?php
//get details to display before update
$comment_id = $_POST['comment_id'];
$comment = $_POST['comment'];
?>

<form action ="edit_story.php" method="POST">
    <input type="hidden" name="comment_id" value="<?php printf($comment_id); ?>"/>
    <input type="text" name="comment" value="<?php printf($comment); ?>"/>
    <input type="submit" name ="edit_story"/>
</form>

