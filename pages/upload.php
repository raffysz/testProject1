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
				<dl class="btn"><a href="../pages/upload.php" title="Upload">Upload a file</a></dl>
				<dl class="btn"><a href="../pages/logout.php" title="Logout">Logout</a></dl>
			</ul></nav>	
		</div>';

    $page_title = 'Upload Tool';

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
            {$errors[] = 'Invalid bug ID, to upload a file please input a valid associated bug ID from: <a href="../pages/listbugs.php">Bugs List</a>.';}
        }

        if (empty($errors)) {
            if (isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
                $filename = $_FILES['userfile']['name'];
                $tmpname = $_FILES['userfile']['tmp_name'];
                $filesize = $_FILES['userfile']['size'];
                $filetype = $_FILES['userfile']['type'];

                $fp = fopen($tmpname, 'r');
                $content = fread($fp, filesize($tmpname));
                $content = addslashes($content);
                fclose($fp);

                if (!get_magic_quotes_gpc()) {
                    $filename = addslashes($filename);
                }

                $q = "INSERT INTO attachments (name, type, size, content, userID, bugID) VALUES ('$filename','$filesize','$filetype','$content','{$_SESSION['userID']}','$bugid')";
                mysqli_query($q);
                if ($r) {
                    echo "<h1>Successful!</h1>
        <p>The file $filename was uploaded successfully and can now be view by selecting the bug ID here:</p>";
                    echo '<p><a href="../pages/retrievebug.php">Retrieve a Specific Bug</a></p>';
                }
                mysqli_close($db);
                exit();
            } else {
                echo '<h1 id="errmsg">Error!</h1>
                <p id="errmsg">The following error(S) occurred:<br>';
                foreach ($errors as $msg) {
                    echo " - $msg<br>";
                }
                echo 'Please try again.</p>';
                mysqli_close($db);
            }
        }
    }

    ?>

    <h1>Upload utility</h1>
    <p>Please check the correct bug ID before uploading a file here:</p>
    <p><a href="../pages/listbugs.php">View List Of Reported Bugs</a></p>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <p>
            Bug ID: <input type="text" name="bugid" required="required"
                           value="<?php if (isset($_POST['bugid']))
                               echo $_POST['bugid'];?>">
        </p> <p>
            File to be uploaded (max 16Mb):
            <br><input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            <input name="userfile" type="file" id="userfile"></p>
        <p><input type="submit" name="upload" value="Upload"></p>
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
