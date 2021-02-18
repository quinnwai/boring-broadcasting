<?php
require 'database.php';

$first = $_POST['first'];
$last = $_POST['last'];
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("insert into users (username, first_name, last_name, password) values (?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
// not safe to use register yet, need to figure out hash password
//$stmt->bind_param('sss', $first, $last, $username, $password);

$stmt->execute();

$stmt->close();
?>