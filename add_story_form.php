<?php
session_start();

//CSRF token validation
require 'get_token.php';

?>

<form action ="add_story.php" method="POST">
    Title: <input type="text" name="title" />
    Body: <input type="text" name="body"/>
    Link: <input type="text" name="link"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="submit" name ="add_story"/>
</form>
