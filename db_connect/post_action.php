<?php

session_start();

require ('../db_connect/login_tools.php');

if (!isset($_SESSION['username'])){load();}

$page_title = 'Submit Error';

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    
    
    if (!empty($_POST['title']))
    {
        require('../db_connect/connection.php');
        $q = "SELECT title FROM bugs WHERE title='{$_POST['title']}'";
        $r = mysqli_query($db, $q);
        if (mysqli_num_rows($r)!=0)
        {$errors[] = 'Title already in use, please check the bugs IDs and Titles page: <a href="../pages/listbugs.php">List of all bugs</a>';}
    }

    if (!empty($_POST['title']) && !empty($_POST['description']) && empty($errors))
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

    return array (false, $errors);
}

return array (false, $errors);

?>