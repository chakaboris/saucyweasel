<?php
include("bettings.php");
$conn = new mysqli($db_location, $db_user, $db_pass, $db_name);
// $json_data = file_get_contents('butt.txt');
// $mydata = json_decode($json_data);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

function GameDiv($nflgame, $conn)
{
	$bettime = new DateTime(gmdate("Y-m-d H:i:s"));
	$espnid =  $nflgame->competitions[0]->id;
	$homeshort = $nflgame->competitions[0]->competitors[0]->team->abbreviation;
	$awayshort = $nflgame->competitions[0]->competitors[1]->team->abbreviation;
	$hometeam = $nflgame->competitions[0]->competitors[0]->team->displayName;
	$homefavorite = $nflgame->competitions[0]->odds[0]->homeTeamOdds->favorite;
	if ($homefavorite != 1)
		$homefavorite = 0;
	$homespread = $nflgame->competitions[0]->odds[0]->homeTeamOdds->spreadOdds;
	$homemoneyline = $nflgame->competitions[0]->odds[0]->homeTeamOdds->moneyLine;
	$homescore = $nflgame->competitions[0]->competitors[0]->score;
	$awayteam = $nflgame->competitions[0]->competitors[1]->team->displayName;
	
	$awayfavorite = $nflgame->competitions[0]->odds[0]->awayTeamOdds->favorite;
	if ($awayfavorite != 1)
		$awayfavorite = 0;
	$awayspread = $nflgame->competitions[0]->odds[0]->awayTeamOdds->spreadOdds;
	$awaymoneyline = $nflgame->competitions[0]->odds[0]->awayTeamOdds->moneyLine;
	$awayscore = $nflgame->competitions[0]->competitors[1]->score;
	$spread = $nflgame->competitions[0]->odds[0]->spread;
	$ou = $nflgame->competitions[0]->odds[0]->overUnder;
	$gamedate = $nflgame->competitions[0]->date;
	$gametime = explode("T",$gamedate);
	$dbtime = $gametime[0]." ".str_replace("Z",":00",$gametime[1]);
	// $gtime = new DateTime($dbtime);

	// $gtime->setTimezone(new DateTimeZone('America/New_York'));
	// $bettime->setTimezone(new DateTimeZone('America/New_York'));

	// $addgame = "insert ignore into games (espnid, home_team, away_team, home_score, away_score, gametime) VALUES (".$espnid.",'".$homeshort."','".$awayshort."',0,0,'".$dbtime."')";
	// $conn->query($addgame);

	// $homequery = "select * from teams where shortname = '".$homeshort."'";
	// $homeresult = $conn->query($homequery);
	// $homearray = $homeresult->fetch_assoc();

	// $awayquery = "select * from teams where shortname = '".$awayshort."'";
	// $awayresult = $conn->query($awayquery);
	// $awayarray = $awayresult->fetch_assoc();

	$addgame = "INSERT IGNORE INTO `games`(`espnid`, `spread`, `home_team`, `home_favorite`, `home_moneyline`, `home_spread`, `away_team`, `away_favorite`, `away_moneyline`, `away_spread`, `home_score`, `away_score`, `gametime`) VALUES (".$espnid.",".$spread.",'".$homeshort."',".$homefavorite.",".$homemoneyline.",".$homespread.",'".$awayshort."',".$awayfavorite.",".$awaymoneyline.",".$awayspread.",0,0,'".$dbtime."')";
	$conn->query($addgame);
	// echo "<div class='gamediv'>";
	// //echo "<div class='stretcher'>".date("D m/d/Y h:ia", strtotime($dbtime))."</div>";
	// echo "<div class='stretcher'>".$gtime->format("D m/d/Y h:ia")." EST/EDT</div>";

	// echo "<div class='homediv' style='background-image: linear-gradient(45deg, ".$homearray["one_color"].", ".$homearray["one_color"].", ".$homearray["two_color"].", ".$homearray["two_color"].")'>";
	// echo $homearray["longname"]."<br>";
	// echo "<img src='img/".$homearray["icon"]."'>";
	
	// echo "</div>";
	// echo "<div class='awaydiv' style='background-image: linear-gradient(135deg, ".$awayarray["one_color"].", ".$awayarray["one_color"].", ".$awayarray["two_color"].", ".$awayarray["two_color"].")'>";
	// echo $awayarray["longname"]."<br>";
	// echo "<img src='img/".$awayarray["icon"]."'>";
	// echo "</div>";

	// echo "<div class='homediv' style='border-radius: 0px 0px 0px 15px;'>".$homescore."</div>";
	// echo "<div class='awaydiv' style='border-radius: 0px 0px 15px 0px;'>".$awayscore."</div>";
	// // echo "<div class='stretcher'>";
	// // //echo $nflgame->name." ".$dbtime."<br>";
	// // if ($gtime > $bettime)
	// // {
	// // 	echo $spread." | O/U: ".$ou;
	// // }
	// // else
	// // {
	// // 	echo $homescore." | ".$awayscore;
	// // }
	// // echo "</div>";
	// echo "</div>";
}

$response = curl_exec($curl);
$err = curl_error($curl);
$mydata = json_decode($response);
?>
<html>
	<head>
			<link rel="stylesheet" href="bets.css">

</head>
<body>
<div class='screenwrap'>
<?php
foreach($mydata->events as $nflgame)
{
	GameDiv($nflgame, $conn);
	// $espnid =  $nflgame->competitions[0]->id;
	// $homeshort = $nflgame->competitions[0]->competitors[0]->team->abbreviation;
	// $awayshort = $nflgame->competitions[0]->competitors[1]->team->abbreviation;
	// $hometeam = $nflgame->competitions[0]->competitors[0]->team->displayName;
	// $homescore = $nflgame->competitions[0]->competitors[0]->score;
	// $awayteam = $nflgame->competitions[0]->competitors[1]->team->displayName;
	// $awayscore = $nflgame->competitions[0]->competitors[1]->score;
	// $spread = $nflgame->competitions[0]->odds[0]->details;
	// $ou = $nflgame->competitions[0]->odds[0]->overUnder;
	// $gamedate = $nflgame->competitions[0]->date;
	// $gametime = explode("T",$gamedate);
	// $dbtime = $gametime[0]." ".str_replace("Z",":00",$gametime[1]);
	// $gtime = new DateTime($dbtime);
    // echo $nflgame->name." ".$dbtime."<br>";
	// if ($gtime > $bettime)
	// {
	// 	echo $spread." | O/U: ".$ou."<br>";
	// }
	// else
	// {
	// 	echo $hometeam." ".$homescore." | ".$awayteam." ".$awayscore."<br>";
	// }
	// echo "<br>";
	// $addgame = "insert ignore into games (espnid, home_team, away_team, home_score, away_score, gametime) VALUES (".$espnid.",'".$homeshort."','".$awayshort."',0,0,'".$dbtime."')";
	// $conn->query($addgame);
}

?>
</div>
</body>
</html>