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

    $page_title = 'Submission Form';

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

        if (empty ($_POST['title']))
        {$errors[] = 'Enter a bug title.';}
        else
        {$bugid = mysqli_real_escape_string($db,
            trim($_POST['title']));}

        if (empty($errors))
        {$q = "SELECT title FROM bugs WHERE title='$title'";
            $r = mysqli_query($db, $q);
            if (mysqli_num_rows($r)!=0)
            {$errors[] = 'Title already in use, please use another';}
        }

        if (empty($errors) && !empty($_POST['description']))
        {
            $q = "INSERT INTO bugs (title, description, postDate, userID) VALUES ('$title', '{$_POST['description']}', NOW(),'{$_SESSION['userID']}')";
            $r = mysqli_query ($db, $q);
            if ($r)
            {
                load ('../pages/submit_executed.php');
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

    <h1>Report a newbub</h1>
    <p>Please complete the form below to report a new bug:</p>

    <form action="submitbug.php" method="POST">
        <p>
            Bug Title: <input type="text" name="title" required="required"
                           value="<?php if (isset($_POST['title']))
                               echo $_POST['title'];?>">
        </p> <p>
            Description:
            <br><textarea name="description" required="required" rows="15" cols="50"></textarea></p>
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
            <a href ="#">About</a> |
            <a href ="#">Useful Links</a> |
            <a href ="#">Copyright ©2016</a>
        </p>
    </nav>

</footer>
<!--END OF FOOTER -->

</body>
</html>
