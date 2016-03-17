<?php

session_start();

require ('../db_connect/login_tools.php');

if (!isset($_SESSION['username'])) {load();}

$page_title='Post Error';

if (isset($errors)&& !empty($errors))
{
    echo '<p id="errmsg">There was a problem with the form:<br>';
    foreach ($errors as $msg)
    {
        echo" - $msg<br>";
    }
    echo 'Please check that all the fields are completed correctly!</p>';
}

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    if (empty ($_POST['title']))
    {$errors[] = 'Enter a title for this bug.';}
    else
    {$title = mysqli_real_escape_string($db,
        trim($_POST['title']));}

    if (empty ($_POST['description']))
    {$errors[] = 'Enter a description for this bug.';}

    if (empty($errors)) {
        require('../db_connect/connection.php');
        $q = "SELECT title FROM bugs WHERE title='$title'";
        $r = mysqli_query($db, $q);
        if (mysqli_num_rows($r) != 0) {
            $errors[] = 'Title already exist, please use another.';
        }
    }

    if (!empty($_POST['title'])&& !empty($_POST['description']))
    {
        require('../db_connect/connection.php');
        $q = "INSERT INTO bugs (title,description,userID,postDate) VALUES ('{$_POST['title']}','{$_POST['description']}','{$_SESSION['userID']}',NOW())";
        $r = mysqli_query ($db, $q);

        if (mysqli_affected_rows($db)!=1)
        {
            echo '<p>Error</p>'.mysqli_error($db);
        }
        else
        {
            load('../pages/submit_executed.php');
        }

        mysqli_close($db);
    }
}

echo '<p><a href="../pages/loggedin.php">Home</a></p>';

?>