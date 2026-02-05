<?php
// Initialize the session - is required to check the login state.
session_start();
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['google_loggedin']) && !isset($_SESSION['weasel_loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'bettings.php';
include 'func/users.php';
$conn = new mysqli($host, $username, $password, $db_name);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

$playername = $_SESSION['weasel_name'];
$player = new Player($playername);

$user = $player->GetName();
$blankit = true;
function GameDiv($nflgame, $conn, $leaguepick)
{
	$bettime = new DateTime(gmdate("Y-m-d H:i:s"));

	$espnid =  $nflgame["espnid"];
	$homeshort = $nflgame["home_team"];
	$awayshort = $nflgame["away_team"];
	

	$homespread = $nflgame["home_spread"];
	$awayspread = $nflgame["away_spread"];
	
	$dbtime = $nflgame["gametime"];
	
	$gtime = new DateTime($dbtime);

	$gtime->setTimezone(new DateTimeZone('America/New_York'));
	$bettime->setTimezone(new DateTimeZone('America/New_York'));


	$hplus = "";
	if($homespread > 0)
		$hplus = "+";
	$aplus = "";
	if($awayspread > 0)
		$aplus = "+";
	$homequery = "select * from teams where shortname = '".$homeshort."' and league = '".$leaguepick."'";
	$homeresult = $conn->query($homequery);
	$homearray = $homeresult->fetch_assoc();
	//echo $homeshort." ";
	$awayquery = "select * from teams where shortname = '".$awayshort."' and league = '".$leaguepick."'";
	$awayresult = $conn->query($awayquery);
	$awayarray = $awayresult->fetch_assoc();
	//echo $awayshort."<br>";

	
	if(($gtime > $bettime) && $awayresult->num_rows > 0 && $homeresult->num_rows > 0)
		{
	echo "<div class='gamediv'>";
	//echo "<div class='stretcher'>".date("D m/d/Y h:ia", strtotime($dbtime))."</div>";
	echo "<div class='stretcher'>".$gtime->format("D m/d/Y h:ia")." EST/EDT</div>";
	echo "<div class='gamescontainer'>";
	echo "<div class='awaydiv' style='cursor:pointer;background-image: linear-gradient(135deg, ".$awayarray["one_color"].", ".$awayarray["one_color"].", ".$awayarray["two_color"].", ".$awayarray["two_color"].");' onClick='ShowBetform(\"".$awayarray['shortname']."\",\"".$espnid."\",\"".$awayspread."\")'>";
	echo $awayarray["longname"]."<br>";
	//echo "<img src='img/".$awayarray["icon"]."'>";
	echo $aplus.$awayspread;
	echo "</div>";
	echo "<div class='homediv' style='cursor:pointer;background-image: linear-gradient(45deg, ".$homearray["one_color"].", ".$homearray["one_color"].", ".$homearray["two_color"].", ".$homearray["two_color"].");' onClick='ShowBetform(\"".$homearray['shortname']."\",\"".$espnid."\",\"".$homespread."\")'>";
	echo $homearray["longname"]."<br>";
	//echo "<img src='img/".$homearray["icon"]."'>";
	echo $hplus.$homespread;
	echo "</div>";
	echo "</div>";
	echo "<div class='awaydiv' style='border-radius: 0px 0px 0px 15px;'>&nbsp; </div>";
		echo "<div class='homediv' style='border-radius: 0px 0px 15px 0px;'>&nbsp; </div>";
		echo "</div>";
		}

}
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
<li class="picked"><a href="index.php">Games</a></li>
<li><a href="mypage.php">Stats</a></li>
</ul>
<?php
$leagues = "Select * from leagues";
$leaguesresult = $conn->query($leagues);
while($lgs = $leaguesresult->fetch_assoc())
	{
		$leaguepick = $lgs["league"];
$getgames = "select * from games where league = '".$leaguepick."' and NOT EXISTS (select * from wagers where event_id = games.espnid and bettor = '".$user."') and exists (select * from teams where shortname = games.home_team)";
$gameslist = $conn->query($getgames);
if($gameslist->num_rows > 0)
	{ 
		$blankit = false;
		echo "<center><h2>".$leaguepick."</h2></center>";
while($row = $gameslist->fetch_assoc())
{
	GameDiv($row, $conn,$leaguepick);

}
	}
	}
?>

<?php
if($blankit)
	{
		echo "There are no games to pick at the moment!";
	}
?>
		
				</div>
<div class="betform" id="betform">
	<div class="betarea">
	<h1 id="mybet"></h1>
	<center><img src='img/saucebet.png'></center>
<form method="post" action="makewager.php">
<input type="hidden" name="wager" id="wager">
<input type="hidden" name="gameid" id="gameid" value="">
<input type="hidden" name="team" id="team" value="">
<input type="hidden" name="spread" id="spread" value="">
<input type="submit" value="Make Wager" id="makebet" class="betbutton">
<br><br>
<input type="button" value="Cancel" class="cancelbutton" onClick="HideBetform()">
</form>
</div>
</div>
<script>
				function ShowBetform(choice,espnid,spread)
				{
					if(spread >= 0)
					{
						spread = "+"+spread;
					}
					document.getElementById('wager').value = "";
					document.getElementById('gameid').value = espnid;
					document.getElementById('team').value = choice;
					document.getElementById('spread').value = spread;
					document.getElementById('betform').style.display = 'block';
					document.getElementById('makebet').value = "Pick " + choice + " " + spread;
					// document.getElementById('mybet').innerHTML = "I'm betting on " + choice + " and the game id is " + espnid + " and of course the spread is " + spread;
				}

				function HideBetform()
				{
					document.getElementById('wager').value = "";
					document.getElementById('gameid').value = "";
					document.getElementById('team').value = "";
					document.getElementById('spread').value = "";
					document.getElementById('betform').style.display = 'none';
					document.getElementById('mybet').innerHTML = "";
				}

				function HideMessage()
				{
					document.getElementByID('msg').style.visibility = 'hidden';
				}
			</script>

</body>
</html>