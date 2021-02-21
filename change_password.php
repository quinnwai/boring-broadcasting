<?php
session_start();
require 'database.php';
require 'get_token.php';

$old_pwd = (string)$_POST['old_password'];
$new_pwd = (string)$_POST['new_password'];
$user = $_SESSION['user'];

$stmt = $mysqli->prepare("SELECT password FROM users WHERE username = $user");

$stmt->execute();

// Bind the results
$stmt->bind_result($pwd_hash);
$stmt->fetch();

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

if (password_verify($old_pwd, $pwd_hash)) {
    $stmt2 = $mysqli->prepare("UPDATE `users` SET 
    `password`= $new_pwd WHERE username = $user");
if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt2->execute();
$stmt2->close();
echo "Success your password has been successfully changed";
}
else {
    echo "Sorry your old password did not match the original password. Please resubmit";
}

// $stmt->bind_param('s', $story_id);

$stmt->execute();

$stmt->close();

// TODO: if this doesn't work, use form because of CSRF stuff and include hidden var as seen in feed
?>
<p> Return back to your profile page? <p>
<form action ="user_details.php" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />