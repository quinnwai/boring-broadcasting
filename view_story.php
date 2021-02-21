<?php

//activate database
require 'database.php';

// save story_id for future use in queries
$story_id = $_POST['story_id'];

//// print out story ////

//sql query needed
$stmt = $mysqli->prepare("SELECT title, username, body, link FROM stories WHERE id = ?");
$stmt->bind_param('s', $story_id);

// specify what results to bind before binding
$stmt->execute();
$stmt->bind_result($title, $author, $body, $link);
$stmt->fetch();

printf("
<h1>Title: %s</h1>
<p>By %s<br>
Body: %s<br>
See the original story <a href=%s>here</a>! <br></p>
\n",
htmlspecialchars($title),
htmlspecialchars($author),
htmlspecialchars($body),
htmlspecialchars($link)
);

$stmt->close();


//// print out comments ////

//get comments by story id
$stmt = $mysqli->prepare("SELECT c.username, c.post_date, c.comment FROM stories as s JOIN comments as c ON s.id = c.story_id WHERE s.id = ?");
$stmt->bind_param('s', $story_id);

//store in variables
$stmt->execute();
$stmt->bind_result($commenter, $post_date, $comment);

while($stmt->fetch()){
    printf("\t
	<p><b>%s</b>: %s (posted on %s)</p>
    \n",
    $commenter,
    $comment,
    substr($post_date, 5, 5)
);
}

?>