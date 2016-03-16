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
        $e=mysqli_real_escape_string($db, trim($un));
    }
}