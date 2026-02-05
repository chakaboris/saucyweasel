<?php
// Initialize the session - is required to check the login state.
session_start();
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['google_loggedin']) && !isset($_SESSION['weasel_loggedin'])) {
    header('Location: login.php');
    exit;
}
include("bettings.php");
include 'func/users.php';
$conn = new mysqli($host, $username, $password, $db_name);


$playername = $_SESSION['weasel_name'];
$player = new Player($playername);

?>
<html translate="no" lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bets.css">
        <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
</head>
<body>
    	<div class='rightbox'>
	<a href='logout.php'>Log Out</a>
</div>
    <center><img src='img/saucy2.png'></center>
    <div class="content">
        <ul>
<li><a href="index.php">Games</a></li>
<li class="picked"><a href="mypage.php">Stats</a></li>
</ul>
<?php
$bettor = $player->GetName();
$wins = 0;
$losses = 0;
$tally = 0;
$percentagequery = "select * from wagers where bettor = '".$bettor."' and resolved <> 'no'";
$percenta = $conn->query($percentagequery);
while($prow = $percenta->fetch_assoc())
    {
        if (strcmp($prow["resolved"],"win") == 0)
            {
                $wins++;
            }
        if (strcmp($prow["resolved"],"lose") == 0)
            {
                $losses++;
            }
        $tally++;
    }
echo "<center><h2>".$bettor."</h2></center";
if($tally > 0)
    {
        
        echo "<center><h2>".number_format((($wins/($wins+$losses)) * 100),1)."%</h2>";
        echo "(Win/Loss | ".$wins."/".$losses.")</center>";
    }
echo "<br>";

if(isset($_GET["msg"]))
    {
        $message = str_replace('_',' ',$_GET["msg"]);
        echo "<center><span style='color:green;'>".$message."</span></center><br><br>";
    }
$unresolveds = "select wagers.*,games_archive.home_team, games_archive.away_team, games_archive.gametime from wagers ";
$unresolveds .= "inner join games_archive on games_archive.espnid = wagers.event_id where wagers.bettor = '".$bettor."' and wagers.resolved = 'no'";
$unresolved = $conn->query($unresolveds);
//echo"<br><br>".$unresolveds;
if($unresolved->num_rows > 0)
    {
        echo "<table><tr><th colspan = '5' class='tabletop'>Unresolved Picks</th></tr>";
        echo "<th>Away Team</th><th></th><th>Home Team</th><th>Game Time</th><th>Pick</th>";
    }
while($urow = $unresolved->fetch_assoc())
    {
        $dbtime = $urow["gametime"];
        $gtime = new DateTime($dbtime);
        $splus = "";
        if($urow["spread"] >= 0)
            $splus="+";
	    $gtime->setTimezone(new DateTimeZone('America/New_York'));
        echo "<tr><td>".$urow["away_team"]."</td><td>@</td><td>".$urow["home_team"]."</td><td>".$gtime->format("D m/d/Y h:ia")."</td><td>".$urow["team"]." ".$splus.$urow["spread"]."</td></tr>";
    }
    if($unresolved->num_rows > 0)
        {
            echo "</table><br><br>";
        }
        else if ($tally == 0)
    {
        echo "<br><h2>You havent picked any games yet!</h2><br>";
    }



$mywagers = "select wagers.*, finals.gametime,finals.home_team, finals.home_score, finals.away_team, finals.away_score, finals.gametime from wagers inner join finals on wagers.event_id = finals.espnid where wagers.bettor = '".$bettor."' and wagers.resolved <> 'no'";
$results = $conn->query($mywagers);
if($results->num_rows > 0)
    echo "<table><tr><th colspan='5' class='tabletop'>Resolved Picks</th></tr><th>Away Team</th><th></th><th>Home Team</th><th>Game Time</th><th>Pick</th>";
while($row = $results->fetch_assoc())
    {
        if(strcmp($row["resolved"],"win") == 0)
            $bgc = "style='background-color:green;'";
        if(strcmp($row["resolved"],"lose") == 0)
            $bgc = "style='background-color:red;'";
        if(strcmp($row["resolved"],"draw") == 0)
            $bgc = "style='background-color:gray;'";
        $dbtime = $row["gametime"];
        $gtime = new DateTime($dbtime);

	    $gtime->setTimezone(new DateTimeZone('America/New_York'));
        $splus = "";
        if($row["spread"] >= 0)
            $splus="+";
        echo "<tr><td>".$row["away_team"].": ".$row["away_score"]."</td><td>@</td><td>";
        echo $row["home_team"].": ".$row["home_score"]."</td><td>".$gtime->format("D m/d/Y h:ia")."</td><td ".$bgc.">".$row["team"]." ".$splus.$row["spread"]."</td></tr>";
    }
if($results->num_rows > 0)
{    
    echo "</table>";
}


?>
</div>
</body>
</html>