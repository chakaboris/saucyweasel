<?php
//session_start();

function logging_in($conn)
{
    $google_loggedin = $_SESSION['google_loggedin'];
    $google_email = $_SESSION['google_email'];
    $google_name = $_SESSION['google_name'];
    $google_picture = $_SESSION['google_picture'];


    $smothername = hash('sha256', $google_email);
    $adduser = "insert ignore into weasels (user, start_date) values ('".$smothername."',NOW())";
    $conn->query($adduser);
}

function user_exists($conn,$namestring)
{

    $namesearch = "Select * from weasels where user = '".$namestring."'";
    $nameresult = $conn->query($namesearch);
    if($nameresult->num_rows > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function player_exists($conn,$namestring)
{

    $namesearch = "Select * from weasels where playername = '".$namestring."'";
    $nameresult = $conn->query($namesearch);
    if($nameresult->num_rows > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

?>