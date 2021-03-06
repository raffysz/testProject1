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

    $page_title = 'File Upload!';

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

    if ($_SERVER['REQUEST_METHOD']=='POST') {
    
        require ('../db_connect/connection.php');

        if (empty ($_POST['bugid']))
        {$errors[] = 'Enter a bug ID.';}
        else
        {$bugid = mysqli_real_escape_string($db,
            trim($_POST['bugid']));}
    
        $q = "SELECT bugID FROM bugs WHERE bugID='$bugid'";
        $r = mysqli_query($db, $q);
        if (mysqli_num_rows($r)!=1)
        {$errors[] = 'Invalid bug ID, to leave a comment please input a valid bug ID from: <a href="../pages/listbugs.php">Bugs List</a>.';}

        if (empty($errors) && isset($_FILES['upload'])){
        $errors= array();
        $file_name = $_FILES['upload']['name'];
        $file_size =$_FILES['upload']['size'];
        $file_tmp =$_FILES['upload']['tmp_name'];
        $file_type=$_FILES['upload']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['upload']['name'])));

        $expensions= array("txt");

        if(in_array($file_ext,$expensions)=== false){
            $errors[]="extension not allowed, please choose a TXT file.";
        }

        if($file_size > 2097152){
            $errors[]='File size must not exceed 2 MB';
        }

            if (empty($errors)) {
                $q = "SELECT url FROM attachments WHERE url='http://raffaele-rgu-demo.azurewebsites.net/uploads/$file_name'";
                $r = mysqli_query($db, $q);
                if (mysqli_num_rows($r) != 0) {
                    $errors[] = 'Filename already in use, please select another.';
                }
            }

        if(empty($errors)==true){
            move_uploaded_file($file_tmp,"../uploads/".$file_name);
            echo "Upload successful!";
        }else{
            $errors;
        }
        }


        if (empty($errors)) {
            $q = "INSERT INTO attachments (url, userID, bugID) VALUES ('http://raffaele-rgu-demo.azurewebsites.net/uploads/$file_name','{$_SESSION['userID']}','$bugid')";
            $r = mysqli_query($db, $q);
            if ($r) {
                echo '<h1>File submitted successfully!</h1>
        <p>Your file has been submitted successfully and can now be retrieved by selecting the bug ID here:</p>
        <p><a href="../pages/retrievebug.php">Retrieve a Specific Bug</a></p>';
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

    ?>

    <h1>Upload tool</h1>
    <p>Please check the correct bug ID before uploading a file here:</p>
    <p><a href="../pages/listbugs.php">View List Of Reported Bugs</a></p>

    <form action="" method="POST" enctype="multipart/form-data">

        <p>
            Bug ID: <input type="text" name="bugid" required="required">
        </p><p>Please select a file to upload:</p>
        <input type="file" name="upload" />
        <input type="submit"/>
        <br><p>Only accept .txt files with a maximum size of 2Mb</p>
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
