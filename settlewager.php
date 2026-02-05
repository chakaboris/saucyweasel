<?php
include("bettings.php");
$conn = new mysqli($db_location, $db_user, $db_pass, $db_name);

$findwagers = "select * from wagers where resolved = 'no' and exists (select * from finals where espnid = wagers.event_id)";
$wagerresult = $conn->query($findwagers);
while($wager = $wagerresult->fetch_assoc())
    {
        $gid = $wager["event_id"];
        $pick = $wager["team"];
        $spread = $wager["spread"];
        $bettor = $wager["bettor"];
        $betstatus = "no";
        $mather = "select * from finals where espnid = ".$gid;
        $results = $conn->query($mather);
        $gameresult = $results->fetch_assoc();

        if(strcmp($gameresult["home_team"],$pick) == 0)
            {
                if(($gameresult["home_score"] + $spread) == $gameresult["away_score"])
                    {
                        $betstatus = "draw";
                    }
                if(($gameresult["home_score"] + $spread) > $gameresult["away_score"])
                    {
                        $betstatus = "win";
                    }
                if(($gameresult["home_score"] + $spread) < $gameresult["away_score"])
                        {
                            $betstatus = "lose";
                        }

            }
        if(strcmp($gameresult["away_team"],$pick) == 0)
            {
                if(($gameresult["away_score"] + $spread) == $gameresult["home_score"])
                    {
                        $betstatus = "draw";
                    }
                if(($gameresult["away_score"] + $spread) > $gameresult["home_score"])
                    {
                        $betstatus = "win";
                    }
                if(($gameresult["away_score"] + $spread) < $gameresult["home_score"])
                        {
                            $betstatus = "lose";
                        }
            }

        $settler = "update wagers set resolved = '".$betstatus."' where event_id = ".$gid." AND bettor = '".$bettor."'";
        $conn->query($settler);
    }