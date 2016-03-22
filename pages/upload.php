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

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        require('../db_connect/connection.php');
        $errors = array();

        if (empty ($_POST['bugid'])) {
            $errors[] = 'Enter a bug ID.';
        } else {
            $bugid = mysqli_real_escape_string($db,
                trim($_POST['bugid']));
        }

        if (empty($errors)) {
            $q = "SELECT bugID FROM bugs WHERE bugID='$bugid'";
            $r = mysqli_query($db, $q);
            if (mysqli_num_rows($r) != 1) {
                $errors[] = 'Invalid bug ID, to leave a comment please input a valid bug ID from: <a href="../pages/listbugs.php">Bugs List</a>.';
            }

            if (isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
                $fileName = $_FILES['userfile']['name'];
                $tmpName = $_FILES['userfile']['tmp_name'];
                $fileSize = $_FILES['userfile']['size'];
                $fileType = $_FILES['userfile']['type'];

                $fp = fopen($tmpName, 'r');
                $content = fread($fp, filesize($tmpName));
                $content = addslashes($content);
                fclose($fp);

                if (!get_magic_quotes_gpc()) {
                    $fileName = addslashes($fileName);
                }

                $query = "INSERT INTO attachments (name, size, type, content, userID, bugID) 
        VALUES ('$fileName', '$fileSize', '$fileType', '$content','{$_SESSION['userID']}')";

                mysql_query($query) or die('Error, query failed');

                echo "<br>File $fileName uploaded<br>";
            }
        }
    }

    ?>

    <h1>Upload utility</h1>
    <p>Please check the correct bug ID before uploading a file here:</p>
    <p><a href="../pages/listbugs.php">View List Of Reported Bugs</a></p>

    <form method="post" enctype="multipart/form-data">
        <p>
            Bug ID: <input type="text" name="bugid" required="required"
                           value="<?php if (isset($_POST['bugid']))
                               echo $_POST['bugid'];?>">
        </p>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <input name="userfile" type="file" id="userfile">
               
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
