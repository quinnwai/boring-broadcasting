<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Guest Authentication</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="box">
    <h1> BBC News </h1>
</div>

<?php 
session_start();
$_SESSION['user'] = "";
$_SESSION['isUser'] = false;
$_SESSION['token'] = bin2hex(random_bytes(32));
?>

<div id="main">
<p>
    Continue to feed as guest?
</p>

<form action="feed.php" method="POST">
    <input type="submit" value="Continue to feed"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />   
</form>
</div>

<div id="main">
<p>
    Want to return to sign in page? 
</p>
<form action="login.html">
        <input type="submit" value="Return to Login"/>
</form>
</div>
</body> 
</html>