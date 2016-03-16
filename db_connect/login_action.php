<?php

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    require ('../db_connect/connection.php');

    require ('../db_connect/login_tools.php');

    list ($check, $data) =
        validate ($db, $_POST['un'], $_POST['passwd']);

    if ($check)
    {
        session_start();

        $_SESSION['uid']=$data['uid'];
        $_SESSION['user_name']=$data['user_name'];
        $_SESSION['email']=$data['email'];

        load ('../pages/home.php');
    }

    else {$errors = $data;}

    mysqli_close ($db);
}