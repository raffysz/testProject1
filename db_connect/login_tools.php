<?php

function load($page='../pages/login.php')
{
    $url= 'http://'.$_SERVER['HTTP_HOST'].
        dirname($_SERVER['PHP_SELF']);

    $url = rtrim($url, '/\\');
    $url = '/'. $page;

    header ("location:$url");
    exit();
}

function validate($db, $un =", $passwd=")
{
    $errors = array();

    if (empty($un))
    {
        $errors[]='Enter your username.';
    }
    else
    {
        $un = mysqli_real_escape_string($db, trim($un));
    }

    if (empty($passwd))
    {
        $errors[] = 'Enter your password.';
    }
    else
    {
        $passwd = mysqli_real_escape_string($db, trim($passwd));
    }

    if (empty($errors))
    {
        $q = "SELECT uid, user_name, email FROM users WHERE user_name='$un' AND psswd=SHA1('$passwd')";
        $r = mysqli_query ($db, $q);
        if (mysqli_num_rows($r)==1)
        {
            $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
            return array (true, $row);
        }
        else
        {
            $errors[] = 'Username and/or password incorrect, please try again!.';
        }
    }

    return array (false, $errors);
}