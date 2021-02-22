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
// Compare the submitted password to the actual password hash


if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	// set user, CSRF token, and boolean value for later reference
	$_SESSION['user'] = $user;
    $_SESSION['isUser'] = true;
    $_SESSION['token'] = bin2hex(random_bytes(32)); ?>
    <form action="feed.php" method="POST">
    <?php printf("Want to continue to feed as $user")?> <input type="submit" value="Continue to feed"/>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form>
    <?php
}
else{
    printf("<p>Looks like your username and password did not match. Please try re logging in</p>");
    ?>
<?php
} ?>
    <form action="login.html">
    Want to return to sign in page? <input type="submit" value="Retrun to Login"/>
    </form>
    <?php
$stmt->close();
?>
