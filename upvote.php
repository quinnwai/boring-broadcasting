<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Upvote</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
</head>
<body>
<div id="box">
	<h1>BBC News</h1>
</div>

<?php
session_start();

//CSRF token validation
require 'get_token.php';

//activate database
require 'database.php';

//store relevant variables
$story_id = (int)$_POST['story_id'];

//if not a user, not allowed to upvote
if(!$_SESSION['isUser']){
    echo "Sorry, only users can upvote comments. <br>";
}
else{
    //// see if username has already upvoted ////
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM upvotes WHERE story_id = ? AND username = ?");
    $stmt->bind_param('ss', $story_id, $_SESSION['user']);
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    // specify what results to bind before binding
    $stmt->execute();
    $stmt->bind_result($isUpvoted);
    $stmt->fetch();
    $stmt->close();

    //if no row coresponding to user for this story, add row
    //else, indicate that they have already upvoted
    if($isUpvoted == 0){
        //add username to table
        $stmt = $mysqli->prepare("INSERT INTO upvotes (story_id, username) values (?, ?)");if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('is', $story_id, $_SESSION['user']);
        $stmt->execute();
        $stmt->close();
        
        printf("Success! You have upvoted the story. <br>");
    }
    else {
        printf("You've already upvoted this story! <br>");
    }
}
?>

<p> Head back to story? <p>
<form action ="view_story.php" method="POST">
<input type="hidden" name="story_id" value="<?php printf($story_id); ?>"/>
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<input type="submit" value="return" />
</body> 
</html>