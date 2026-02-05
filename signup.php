<?php
include 'config.php';
include 'func/users.php';

if(isset($_POST["email"]) && isset($_POST["playername"]) && isset($_POST["password"]))
{
    $email = hash('sha256',$_POST["email"]);
    $playername = stripslashes($_POST["playername"]);
    $password = hash('sha256',$_POST["password"]);

    if(user_exists($conn,$email))
    {
        //do something besides just exiting
        header("Location:swauth.php?newuser=weasel&msg=Email_already_exists");
        exit;
    }

    if(player_exists($conn,$playername))
        {
            header("Location:swauth.php?newuser=weasel&msg=Username_already_exists");
        exit;
        }
    $adduser = "insert into weasels (user, password, playername, start_date) values ";
    $adduser .= "('".$email."','".$password."','".$playername."', NOW())";
    $conn->query($adduser);
    header("Location:index.php");
}

?>