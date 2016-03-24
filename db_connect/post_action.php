<?php

session_start();

require ('../db_connect/login_tools.php');

if (!isset($_SESSION['username'])){load();}

$page_title = 'Submit Error';

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    require('../db_connect/connection.php');

    if (!empty($_POST['title']) && !empty($_POST['description']))
    {
        require('../db_connect/connection.php');
        $q = "INSERT INTO bugs (title, description, postDate, userID) VALUES ('{$_POST['title']}', '{$_POST['description']}', NOW(),'{$_SESSION['userID']}')";
        $r = mysqli_query($db, $q);
        if (mysqli_affected_rows($db) !=1)
        {
            load('../pages/errortitle.php');
        }
        else{
            load('../pages/submit_executed.php');
        }
        mysqli_close($db);
    }
}

?>