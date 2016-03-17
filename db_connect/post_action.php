<?php

session_start();

require ('../db_connect/login_tools.php');

if (!isset($_SESSION['username'])) {load();}

$page_title='Post Error';

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    if (empty($_POST['title']))
    {
        echo '<p>Please enter a Title for this bug.</p>';

        if (empty($_POST['description']))
        {
            echo '<p>Please enter a description for this bug.</p>';
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
            load('../pages/submitted.php');
        }

        mysqli_close($db);
    }
}

echo '<p><a href="../pages/loggedin.php">Home</a></p>';

?>