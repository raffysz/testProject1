<?php

if (!isset($_SESSION['username']))
{
    require ('../db_connect/login_tools.php');
    load();
}

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    require('../db_connect/connection.php');
    $errors = array();

    if (!empty($_POST['title']) && !empty($_POST['description']))
    {
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