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

    if (empty ($_POST['title']))
    {$errors[] = 'Enter a title for this bug.';}
    else
    {$title = mysqli_real_escape_string($db,
        trim($_POST['title']));}

    if (empty ($_POST['description']))
    {$errors[] = 'Enter a description for this bug.';}

    if (isset($errors)&& !empty($errors))
    {
        echo '<p id="errmsg">There was a problem with the form:<br>';
        foreach ($errors as $msg)
        {
            echo" - $msg<br>";
        }
        echo 'Please check that all the fields are completed correctly!</p>';
    }

    echo "<p id='logged'>Logged in as
    {$_SESSION['username']},{$_SESSION['email']}
    </p>";

    echo '<form action="../db_connect/post_action.php" method="POST" accept-charset="utf-8">
    <p>Title:<br>
    <input name="title" type="text" size="64"></p>
    <p>Description:<br>
    <textarea name="description" rows="15" cols="50">
    </textarea></p>
    <p><input type="submit" value="Submit"></p>
    </form>';

        echo'<p>
        <a href="../pages/loggedin.php">Home</a> |
        <a href="../pages/logout.php">Logout</a> |
        </p>';

    ?>

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
