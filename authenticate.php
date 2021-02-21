<?php 
session_start();

// IMPORTANT: Always use authenticate after using database.php so there is access to the tables //

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), password FROM users WHERE username=?");

// Bind the parameter (? becomes $username)
$user = strtolower($_POST['username']);
$stmt->bind_param('s', $user);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $pwd_hash);
$stmt->fetch();

$pwd_guess = $_POST['password'];
// Compare the submitted password to the actual password hash

if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	// set user_id, CSRF token, and boolean value for later reference
	$_SESSION['user_id'] = $user_id;
    $_SESSION['isUser'] = true;
    $_SESSION['token'] = bin2hex(random_bytes(32));

    printf("Welcome %s! \n <br><br>", htmlentities($user));
}
else{
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

// //// 0: Setup ////
// $is_user = false;

// //read in login info
// $username = strtolower((string) $_POST['username']);
// // $hash = password_hash((string) $_POST['password']);
// $pwd = (string) $_POST['password'];
// printf("username is %s \n", htmlentities($username));
// printf("password is %s \n", htmlentities($password));
// printf("hash is %s \n <br><br>", $hash);

// //// 1: Validate Username ////
// //read from the users table
// $stmt = $mysqli->prepare("select username, password from users");
// if(!$stmt){
// 	printf("Query Prep Failed: %s\n", $mysqli->error);
// 	exit;
// }

// $stmt->execute();
// $stmt->bind_result($username_db, $hash_db);

// //for each username (row) in db, check if username already exists
// while($stmt->fetch()){
//     printf("comparing user %s to %s which is %d \n", htmlentities($username), htmlentities($username_db), htmlentities($username == strtolower($username_db)));
//     printf("comparing hash %s to %s which is %d \n ", $hash, $hash_db, htmlentities($hash == $hash_db));
//     printf("total truth value is %d \n <br><br>", htmlentities($username == strtolower($username_db) && $hash == $hash_db));
//     if ($username == strtolower($username_db) && password_verify($password, $hash_db)){
//         $is_user = true;
//         $_SESSION['username'] = $username;
//         printf("setting isUser to true!!");
//         break;
//     }
// }; 
// $stmt->close();


// if(!$is_user){
//     //printf("Incorrect username or password \n");
//     ?>