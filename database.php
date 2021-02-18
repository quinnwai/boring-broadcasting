<?php
// Content of database.php

$mysqli = new mysqli('qwong@ec2-18-219-113-131.us-east-2.compute.amazonaws.com'
, 'news_admin', 'news_pass', 'news');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
