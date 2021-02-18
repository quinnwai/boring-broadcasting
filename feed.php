<?php
require 'database.php';

$stmt = $mysqli->prepare("select title, body, link from stories");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($title, $body, $link);

echo "<ul>\n";
while($stmt->fetch()){
	printf("\t<li>%s %s %s</li>\n",
		htmlspecialchars($title),
		htmlspecialchars($body),
        htmlspecialchars($link)
	);
}
echo "</ul>\n";
$stmt->close();
?>