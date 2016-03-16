<?php

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    require ('../db_connect/connection.php');

    require ('../db_connect/login_tools.php');

    list ($check, $data) =
        validate ($db, $_POST['username'], $_POST['password']);

    if ($check)
    {
        session_start();

        $_SESSION['userID']=$data['userID'];
        $_SESSION['username']=$data['username'];
        $_SESSION['email']=$data['email'];

        load ('../pages/loggedin.php');
    }

    else {$errors = $data;}

    mysqli_close ($db);
}

include ('../pages/login.php');