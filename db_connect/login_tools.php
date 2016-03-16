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

function validate($db, $user ='', $pwd='')
{
    $errors = array();

    if (empty($user))
    {
        $errors[]='Enter your username.';
    }
    else
    {
        $username = mysqli_real_escape_string($db, trim($user));
    }

    if (empty($pwd))
    {
        $errors[] = 'Enter your password.';
    }
    else
    {
        $password = mysqli_real_escape_string($db, trim($pwd));
    }

    if (empty($errors))
    {

        $q = "SELECT userID, username, email FROM users WHERE username='$username' AND password=SHA1('$password')";
        $r = mysqli_query ($db, $q);
        var_dump($r);
        if (mysqli_num_rows($r)==1)
        {
            $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
            return array (true, $row);
        }
        else
        {
            var_dump($errors);
            $errors[] = 'Username and/or password incorrect, please try again!.';
        }
    }

    return array (false, $errors);
}