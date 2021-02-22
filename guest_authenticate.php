<?php 
session_start();
    $_SESSION['user'] = "";
    $_SESSION['isUser'] = false;
    $_SESSION['token'] = bin2hex(random_bytes(32)); ?>
    <form action="feed.php" method="POST">
    <?php printf("Want to continue to feed as guest?")?> <input type="submit" value="Continue to feed"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />   
    </form>
    <?php
?>
<form action="login.html">
    Want to return to sign in page? <input type="submit" value="Retrun to Login"/>
</form>