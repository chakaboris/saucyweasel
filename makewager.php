<?php
// Initialize the session - is required to check the login state.
session_start();
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['google_loggedin']) && !isset($_SESSION['weasel_loggedin'])) {
    header('Location: login.php');
    exit;
}
include("bettings.php");
$conn = new mysqli($host, $username, $password, $db_name);
if(isset($_POST["gameid"]))
    {
        $gameid = $_POST["gameid"];
        //timecheck
        $timecheck = "select * from games_archive where espnid = ".$gameid;
        $timerez = $conn->query($timecheck);
        $timebet = $timerez->fetch_assoc();
        $gt = $timebet["gametime"];
        $gametime = new DateTime($gt);
        $bettime = new DateTime(gmdate("Y-m-d H:i:s"));


        if($gametime > $bettime)
            {
                $team = $_POST["team"];
                $spread = $_POST["spread"];
                $playername = $_SESSION['weasel_name'];
                $player = new Player($playername);
                $user = $player->GetName();
                $msg = $team." ".$spread." picked!";
                //$msg = $gametime."_".$bettime;
                $addwager = "insert ignore into wagers (bettor,event_id,team,spread,resolved) VALUES ('".$user."',".$gameid.",'".$team."',".$spread.",'no')";
                $conn->query($addwager);
                header("location:mypage.php?msg=".$msg);
            }
            else
            {
                header("location:index.php?msg=Game_already_started...");
            }
    }
    else
        {
            header("location:index.php");
        }
?>