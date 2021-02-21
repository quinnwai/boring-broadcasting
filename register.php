<!DOCTYPE html>
<html lang="en">
<head>
    <title>New User Registration</title>
</head>
<body>
<?php 
session_start();

//// 0: Setup ////
//connect to database  (require acts like an include to include code from other script into here)
require 'database.php';

//initialise all variables
$is_user = false;
$username = strtolower((string) $_POST['username']);
$first_name = (string) $_POST['first_name'];
$last_name = (string) $_POST['last_name'];
$password = (string) $_POST['password'];

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}


//// 1: Validate Username ////
//read from the users table
$stmt = $mysqli->prepare("select username from users");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();
$stmt->bind_result($username_db);

//for each username (row) in db, check if username already exists
while($stmt->fetch()){
    if ($username == strtolower($username_db)) {
        $is_user = true;
        break;
    }
}; 
$stmt->close();

//// 2: Add User to Table ////

//if username already exists, tell client and store nothing
if($username == "" || $first_name == "" || $last_name == "" || $password == ""){
    printf("Login failed. Please fill out all of the information in the boxes. <br>");
}
else if($is_user){
    printf("The username %s already exists! Please resubmit the form. <br>", htmlentities($username));
}
else {
    //else store all user data in new row
    $stmt = $mysqli->prepare("insert into users (username, first_name, last_name, password) values (?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('ssss', $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
    $stmt->execute();
    $stmt->close();

    printf("Welcome, %s %s! <br>", htmlentities($first_name), htmlentities($last_name));
}
?>

<form action="login.html">
    <label> Head back to login page </label>
    <input type="submit" value="login" />
</form>

</body> 
</html>