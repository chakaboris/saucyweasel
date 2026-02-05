<?php

$host = "db host";
$username = "user with perms to db";
$password = "db user pass";
$db_name = "db name";

spl_autoload_register(function ($class) {
    require __DIR__ . "/func/$class.php";
});

function MakeWager($conn,$bettor,$event_id,$choice,$wager_amount)
{
    $makewager = "insert into wagers (bettor,event_id,choice,wager_amount) VALUES ('".$bettor."',".$event_id.",'".$choice."',".$wager_amount.")";
    $conn->query($makewager);
}

?>