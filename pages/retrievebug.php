<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Bug & Job Tracking System</title>

    <link rel="stylesheet" href="../style.css" type="text/css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>

<body>

<!--START OF HEADER -->
<header class="header">

    <h1 style="vertical-align:middle">Job Traking System</h1>
    <img style="vertical-align:middle" src="../images/Robert-Gordon-University-logo.jpg" alt="Bug & Job Logo"/>

</header>
<!--END OF HEADER -->

<!--START OF MAIN -->
<main>

    <?php

    $page_title = 'Bug List';

    session_start();

    if (!isset($_SESSION['username']))
    {
        require ('../db_connect/login_tools.php');
        load();
    }

    echo '<div id="sidebar">
			<nav id="navigation"><ul>
				<dl class="btn"><a href="../pages/loggedin.php" title="Home">Home</a></dl>
				<dl class="btn"><a href="../pages/submitbug.php" title="New Bug">Submit new bug</a></dl>
				<dl class="btn"><a href="../pages/listbugs.php" title="List All">List all bugs</a></dl>
				<dl class="btn"><a href="../pages/retrievebug.php" title="Retrieve">Retrieve all bug info</a></dl>
				<dl class="btn"><a href="../pages/comments.php" title="Post">Post a comment</a></dl>
				<dl class="btn"><a href="../pages/upload.php" title="Upload">Upload a file</a></dl>
				<dl class="btn"><a href="../pages/logout.php" title="Logout">Logout</a></dl>
			</ul></nav>	
		</div>';

    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
        require('../db_connect/connection.php');
        $errors = array();

        if (empty ($_POST['bug']))
        {$errors[] = 'Enter a bug ID.';}
        else
        {$bugid = mysqli_real_escape_string($db,
            trim($_POST['bug']));}

        if (empty($errors))
        {
            $q = "SELECT bugID, title, description, postDate, fixDate, fixed, userID FROM bugs WHERE bugID='$bugid'";
            $r = mysqli_query($db, $q);
            if (mysqli_num_rows($r) > 0) {
                echo '<table class="centre"><tr><th>Bug ID</th>
        <th>Title</th><th>Description</th><th>Post Date</th><th>Fix Date</th><th>Status</th><th>User ID</th></tr>';
                while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                    echo '<tr>
            <td>' . $row['bugID'] . '</td>
            <td>' . $row['title'] . '</td>
            <td>' . $row['description'] . '</td>
            <td>' . $row['postDate'] . '</td>
            <td>' . $row['fixDate'] . '</td>
            <td>' . $row['fixed'] . '</td>
            <td>' . $row['userID'] . '</td>
            </tr>';
                }
                echo '</table>';
            } else {
                echo '<p>Incorrect or nonexistent bug ID.</p>';
            }
        }
        else
        {
            echo '<p id="errmsg">An error has occurred, please try again.</p>
            <p id="errmsg">If the problem persist please contact a system administrator.</p>';
        }

        echo '<br>';

        if (empty($errors))
        {
            $q = "SELECT commentID, description, postDate, userID FROM comments WHERE bugID='$bugid'";
            $r = mysqli_query($db, $q);
            if (mysqli_num_rows($r) > 0) {
                echo '<table class="centre"><tr><th>Comment ID</th>
        <th>Comment</th><th>postDate</th><th>userID</th></tr>';
                while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                    echo '<tr>
            <td>' . $row['commentID'] . '</td>
            <td>' . $row['description'] . '</td>
            <td>' . $row['postDate'] . '</td>
            <td>' . $row['userID'] . '</td>
            </tr>';
                }
                echo '</table>';
            }
        }
        else
        {
            echo '<p id="errmsg">An error has occurred, please try again.</p>
            <p id="errmsg">If the problem persist please contact a system administrator.</p>';
        }

    }

    ?>

    <h1>Bug Details</h1>
    <p>Here youcan retrieve all information about a specific bug.</p>
    <p>If you don't know the bug ID please consult: <a href='../pages/listbugs.php'>List Of Reported Bugs</a></p>

    <form action="../pages/retrievebug.php" method="POST">
        <p>
            Bug ID:   <input type="text" name="bug"
                             value="<?php if (isset($_POST['bug']))
                                 echo $_POST['bug'];?>">
        </p> <p>
            <input type="submit" value="Submit Form"> </p>
    </form>

</main>
<!--END OF MAIN -->

<!--START OF FOOTER -->
<footer class="footer" style="text-align: center">

    <h2 style="vertical-align:middle">Connect with Us</h2>

    <a  href="http://www.rgu.ac.uk">
        <img style="vertical-align:middle" src="../images/rgulogo.jpg" alt="RGU Logo" ></a>
    <a href="https://www.facebook.com/robertgordonuniversity">
        <img style="vertical-align:middle" src="../images/facebooklogo.jpg" alt="Facebook Logo" ></a>
    <a href="https://twitter.com/RobertGordonUni?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor">
        <img style="vertical-align:middle" src="../images/twitterlogo.jpg" alt="Twitter Logo" ></a>

    <nav>

        <p>
            <a href ="#">About</a> |
            <a href ="#">Useful Links</a> |
            <a href ="#">Copyright ©2016</a>
        </p>
    </nav>

</footer>
<!--END OF FOOTER -->

</body>
</html>

