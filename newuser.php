<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Bug & Job Tracking System</title>

    <link rel="stylesheet" href="style.css" type="text/css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>

<body>

<!--START OF HEADER -->
<header class="header">

    <h1 style="vertical-align:middle">Job Traking System</h1>
    <img style="vertical-align:middle" src="images/Robert-Gordon-University-logo.jpg" alt="Bug & Job Logo"/>

</header>
<!--END OF HEADER -->

<!--START OF MAIN -->
<main>

    <?php
    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
        require ('db_connect/connection.php');
        $errors = array();

        if (empty ($_POST['usernm']))
        {$errors[] = 'Enter a username.';}
        else
        {$email = mysqli_real_escape_string($db,
            trim($_POST['usernm']));}

        if (empty ($_POST['email']))
        {$errors[] = 'Enter your e-mail address.';}
        else
        {$email = mysqli_real_escape_string($db,
            trim($_POST['email']));}

        if (empty ($_POST['phonex']))
        {$errors[] = 'Enter your phone extension.';}
        else
        {$phonex = mysqli_real_escape_string($db,
            trim($_POST['phonex']));}

        if (!empty($_POST['passwd1']))
        {if ($_POST['passwd1']!=$_POST['passwd2'])
        {$errors[] = 'Passwords do not match.';}
        else
        {$passwd = mysqli_real_escape_string($db,
            trim($_POST['passwd1']));}
        }
        else{$errors[] = 'Enter your password.';}

        if (empty($errors))

        if (empty($errors))
        {$q = "INSERT INTO users (usernm, email, phonex, passwd)
        VALUES ('$usernm','$email','$phonex',SHA1('$passwd'))";
        $r = mysqli_query ($db,$q);
        if ($r)
        {echo '<h1>Form submitted successfully!</h1>
        <p>Your request of registration is now pending, an e-mail will inform you of any changes.</p>
        <p>For any iformation please contact the database administrator.</p>
        <p><a href="index.html">Home</a>   <a href="login.php">Login</a></p>';
        }
        mysqli_close($db);
        exit();
        }
            else
            {
                echo '<h1>Error!</h1>
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

    <h1>New User Form</h1>
    <form action="newuser.php" method="POST">
            <p>
                Username:   <input type="text" name="usernm"
                                         value="<?php if (isset($_POST['usernm']))
                                             echo $_POST['usernm'];?>">
            </p> <p>
            E-mail Address:   <input type="text" name="email"
                               value="<?php if (isset($_POST['email']))
                                   echo $_POST['email'];?>">
            </p> <p>
            Phone Extension:   <input type="text" name="phonex"
                               value="<?php if (isset($_POST['phonex']))
                                   echo $_POST['phonex'];?>">
            </p> <p>
            Choose a password:   <input type="text" name="passwd1"
                               value="<?php if (isset($_POST['passwd1']))
                                   echo $_POST['passwd1'];?>">
            </p> <p>
            Confirm Password:   <input type="text" name="passwd2"
                               value="<?php if (isset($_POST['passwd2']))
                                   echo $_POST['passwd2'];?>">
            </p> <p>
            <input type="submit" value="Submit Form"> </p>
    </form>

</main>
<!--END OF MAIN -->

<!--START OF FOOTER -->
<footer class="footer" style="text-align: center">

    <h2 style="vertical-align:middle">Connect with Us</h2>

    <a  href="http://www.rgu.ac.uk">
        <img style="vertical-align:middle" src="images/rgulogo.jpg" alt="RGU Logo" ></a>
    <a href="https://www.facebook.com/robertgordonuniversity">
        <img style="vertical-align:middle" src="images/facebooklogo.jpg" alt="Facebook Logo" ></a>
    <a href="https://twitter.com/RobertGordonUni?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor">
        <img style="vertical-align:middle" src="images/twitterlogo.jpg" alt="Twitter Logo" ></a>

    <nav>

        <p>
            <a href ="index.html">Home</a> |
            <a href ="#">About</a> |
            <a href ="#">Useful Links</a> |
            <a href ="#">Copyright ©2016</a>
        </p>
    </nav>

</footer>
<!--END OF FOOTER -->

</body>

</html>
