<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>User Authentication</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
    <div id="box">
        <h1> BBC News </h1>
    </div>
    
<?php 
session_start();
// IMPORTANT: Always use authenticate after using database.php so there is access to the tables //
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), password FROM users WHERE username=?");

// Bind the parameter (? becomes $username)
$user = strtolower((string)($_POST['username']));
$stmt->bind_param('s', $user);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $pwd_hash);
$stmt->fetch();

$pwd_guess = (string)$_POST['password'];
?>     
<div id="main">
<?php
// Compare the submitted password to the actual password hash
if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	// set user, CSRF token, and boolean value for later reference
	$_SESSION['user'] = $user;
    $_SESSION['isUser'] = true;
    $_SESSION['token'] = bin2hex(random_bytes(32)); ?>
    <form action="feed.php" method="POST">
    <?php printf("<p> Log-in complete. Continue to feed as $user? </p>")?> <input type="submit" value="Continue to feed"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form>
    <?php
}
else{
    printf("<p>Looks like your username and password did not match. Please log in again</p>");
    ?>
<?php
} ?>
<form action="login.html">
Return to sign in page? <input type="submit" value="Return to Login"/>
</form>
</div>
<?php
$stmt->close();
?>
</body> 
</html>