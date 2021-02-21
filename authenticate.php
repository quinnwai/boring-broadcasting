<?php 
// IMPORTANT: Always use authenticate after using database.php so there is access to the tables //

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
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
else{
    $_SESSION['user'] = "";
    $_SESSION['isUser'] = false;
    ?>
    <form action="login.html">
    <p>Logged in as guest </p>
    <label>Try logging in as user?</label>
    <input type="submit" value="login" />
</form>

<?php
}
$stmt->close();

?>