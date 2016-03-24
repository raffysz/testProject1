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
				<dl class="btn"><a href="../pages/fileupload.php" title="Upload">Upload a file</a></dl>
				<dl class="btn"><a href="../pages/fixbug.php" title="Report Fix">Report a Fix</a></dl>
				<dl class="btn"><a href="../pages/logout.php" title="Logout">Logout</a></dl>
			</ul></nav>	
		</div>';

    $page_title = 'Comments Form';

    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
        require('../db_connect/connection.php');
        $errors = array();

        if (empty ($_POST['bugid']))
        {$errors[] = 'Enter a bug ID.';}
        else
        {$bugid = mysqli_real_escape_string($db,
            trim($_POST['bugid']));}

        if (empty($errors))
        {$q = "SELECT bugID FROM bugs WHERE bugID='$bugid'";
            $r = mysqli_query($db, $q);
            if (mysqli_num_rows($r)!=1)
            {$errors[] = 'Invalid bug ID, to leave a comment please input a valid bug ID from: <a href="../pages/listbugs.php">Bugs List</a>.';}
        }

        if (empty($errors) && !empty($_POST['comment']))
        {
            $q = "INSERT INTO comments (description, postDate, userID, bugID) VALUES ('{$_POST['comment']}',NOW(),'{$_SESSION['userID']}','$bugid')";
            $r = mysqli_query ($db, $q);
            if ($r)
            {echo '<h1>Form submitted successfully!</h1>
        <p>Your comment is been submitted successfully and can now be view by selecting the bug ID here:</p>
        <p><a href="../pages/retrievebug.php">Retrieve a Specific Bug</a></p>';
            }
            mysqli_close($db);
            exit();
        }
        else
        {
            echo '<h1 id="errmsg">Error!</h1>
                <p id="errmsg">The following error(S) occurred:<br>';
            foreach ($errors as $msg)
            {
                echo " - $msg<br>";
            }
            echo 'Please try again.</p>';
            mysqli_close ($db);
        }
    }
    
    ?>

    <h1>Comment form</h1>
    <p>Please check the correct bug ID before leaving a comment here:</p>
    <p><a href="../pages/listbugs.php">View List Of Reported Bugs</a></p>

    <form action="comments.php" method="POST">
        <p>
            Bug ID: <input type="text" name="bugid" required="required"
                       value="<?php if (isset($_POST['bugid']))
                           echo $_POST['bugid'];?>">
        </p> <p>
            Comment:
            <br><textarea name="comment" required="required" rows="15" cols="50"></textarea></p>
        <p><input type="submit" value="Submit"></p>
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
            <a href ="../index.html">Home</a> |
            <a href ="#">About</a> |
            <a href ="#">Useful Links</a> |
            <a href ="#">Copyright ©2016</a>
        </p>
    </nav>

</footer>
<!--END OF FOOTER -->

</body>

</html>
