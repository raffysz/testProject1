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

    $page_title = 'Welcome!';

    session_start();

    if (!isset($_SESSION['username']))
    {
        require ('../db_connect/login_tools.php');
        load();
    }

    echo '<div id="sidebar">
			<nav id="navigation"><ul id="ul">
				<li id="list" class="active">
				<a href="home.html">Home</a>
				<a href="About_Us.html">About Us</a>
				<a href="f.a.q.html">F.A.Q</a>
				<a href="Links.html">Links</a>
				</li>
			</ul></nav>	
		</div>';

    echo "<h1>Welcome</h1>
    <p id='logged'>You are now logged in as
    {$_SESSION['username']},{$_SESSION['email']}
    </p>
    <p id='logged'>Please select one of the following options:</p>";

    echo "
    <form action=\"../pages/submitbug.php\">
        <input type=\"submit\" value=\"Submit New Bug\">
    </form>

    <form action=\"../pages/listbugs.php\">
        <input type=\"submit\" value=\"View List Of Reported Bugs\">
    </form>
    
    <form action=\"../pages/retrievebug.php\">
        <input type=\"submit\" value=\"Retrieve a Specific Bug\">
    </form>
    
    <form action=\"../pages/comments.php\">
        <input type=\"submit\" value=\"Leave a Comment\">
    </form>

      <form action=\"../pages/upload.php\">
        <input type=\"submit\" value=\"Upload a File\">
    </form>

    <form action=\"../pages/logout.php\">
        <input type=\"submit\" value=\"Logout\">
    </form>"

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
