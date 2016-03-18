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

    echo "<h1>Bugs List</h1>
    <p>The following is the list of all reported bugs and their status</p>";
    
    require ('../db_connect/connection.php');

    $q = "SELECT bugID, title, postDate, fixDate, fixed FROM bugs";
    $r = mysqli_query( $db, $q);
    if (mysqli_num_rows($r) >0)
    {
        echo '<table align="centre"><tr><th>Bug ID</th>
        <th>Title</th><th>Post Date</th><th>Fix Date</th><th>Status</th></tr>';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
        {
            echo'<tr>
            <td>'.$row['bugID'].'</td>
            <td>'.$row['title'].'</td>
            <td>'.$row['postDate'].'</td>
            <td>'.$row['fixDate'].'</td>
            <td>'.$row['fixed'].'</td>
            </tr>';
        }
        echo '</table>';
    }
    else
    {
        echo '<p>Error retrieving data.</p>';
    }

    echo'<p>
        <a href="../pages/loggedin.php">Home</a> |
        <a href="../pages/submitbug.php">Submit New Bug</a> |
        <a href="../pages/retrievebug.php">Retrieve a Specific Bug</a> |
        <a href="../pages/comments.php">Leave a Comment</a> |
        <a href="../pages/upload.php">Upload a File</a> |
        <a href="../pages/logout.php">Logout</a> |</p>';

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
            <a href ="#">About</a> |
            <a href ="#">Useful Links</a> |
            <a href ="#">Copyright ©2016</a>
        </p>
    </nav>

</footer>
<!--END OF FOOTER -->

</body>
</html>
