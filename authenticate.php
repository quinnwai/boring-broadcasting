<?php 
session_start();

// IMPORTANT: Always use authenticate after using database.php so there is access to the tables //

// TODO: 
//// 0: Setup ////
$is_user = false;

//read in login info
$username = strtolower((string) $_POST['username']);
$hash = password_hash((string) $_POST['password']);

//// 1: Validate Username ////
//read from the users table
$stmt = $mysqli->prepare("select username, password from users");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();
$stmt->bind_result($username_db, $hash_db);

//for each username (row) in db, check if username already exists
while($stmt->fetch()){
    if ($username == strtolower($username_db) && $hash == $hash_db){
        $is_user = true;
        break;
    }
}; 
$stmt->close();


if(!$is_user){
    printf("Incorrect username or password \n");
    ?>

    <form action="login.html">
        <label> Head back to login page? </label>
        <input type="submit" value="login" />
    </form>
    
    <?php
    exit();
}
?>