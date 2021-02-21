<?php

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
?>

<form action ="add_story.php" method="POST">
    <input type="text" name="title" />
    <input type="text" name="body"/>
    <input type="text" name="link"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="submit" name ="add_story"/>
</form>
