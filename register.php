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
$username = (string) $_POST['username'];
$first_name = (string) $_POST['first_name'];
$last_name = (string) $_POST['last_name'];
$password = (string) $_POST['password'];


//// 1: Validate Username ////
//read from the users table
$stmt = $mysqli->prepare("select username from users");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();
$stmt->bind_result($u_list);
while($stmt->fetch()); // this does the hard work to get data row by row
$stmt->close();

//check if username already exists
foreach($u_list as $u){
    if ($username == $u) {
        $is_user = true;
        break;
    }
}

//if username already exists, say so and store nothing
if($is_user){
    echo "The username already exists! Please resubmit the form. <br>";

    //TODO: make sure redirect is right
}
else {
    //// 2: Add User to Table ////
    $stmt = $mysqli->prepare("insert into users (username, first_name, last_name, password) values (?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('ssss', $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
    $stmt->execute();
    $stmt->close();

    printf("Welcome, %s %s! <br>", $first_name, $last_name);
}
?>

<form action="login.html">
    <label> Head back to login page </label>
    <input type="submit" value="login" />
</form>

</body> 
</html>