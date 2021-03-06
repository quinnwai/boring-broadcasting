# CSE330
## Group Members
Vishal Agarwal --- 488422 --- avishal-cyber

Quinn Wai Wong --- 475704 --- quinnwai

Link to Site: http://ec2-18-219-113-131.us-east-2.compute.amazonaws.com/~qwong/m3_grp/login.html

## Login Details: 
Username: qwong

Password: quinniewaiwai

You can always register your own user too :)

## Creative Portion: 
Upvotes:
 * Allows stories to be upvoted 
 * Used JOIN, GROUP BY, and ORDER BY to sort news articles on the feed by popularity (based on upvote)
 * Ensures only registered users can upvote and only one upvote is allowed per user.
 * Delete story removes associated upvotes and comments before deleting story to ensure there is no extraneous data.

User Profile Page:
 * Added a user profile (user_details) page which stores and displays the stories the user have posted.
 * The user is able to view,edit, and delete his stories from his profile page as well as the news feed directly.
 * The user is shown details about his profile such as registered name and username and can logout directly from this page as well. 
 * Here, user can also change password which updates the SQL table accordingly.

More Functionality
 * Added functionality for being able to navigate to feed and logout from various pages for ease of use.
 * Ensured that added and edited stories/comments have relevant data filled out before storing into the database (eg comment, body, title)

Graded 3/6/2021. 100%
