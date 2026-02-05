<?php
// Initialize the session - is required to check the login state.
session_start();
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['google_loggedin']) && !isset($_SESSION['weasel_loggedin'])) {
    header('Location: login.php');
    exit;
}
include 'config.php';
include 'func/users.php';
logging_in($conn);
$username = "";
$msg = "";

// Retrieve session variables
$google_loggedin = $_SESSION['google_loggedin'];
$google_email = $_SESSION['google_email'];
$google_name = $_SESSION['google_name'];
$google_picture = $_SESSION['google_picture'];
$email = hash('sha256',$google_email);




if(isset($_POST["newname"]))
{
    $username = stripslashes($_POST["newname"]);
    $namequery = "Select * from weasels where playername = '".$username."'";

    if ($namecheck->num_rows < 1)
    {
        $addname = "Update weasels set playername = '".$username."' where user = '".$email."'";
        $conn->query($addname);
        header("Location:index.php");
    }
    else
    {
        $msg = $username." is unavailable. Please create another name.";
    }
}

$namecheck = "Select * from weasels where user = '".$email."' and playername IS NOT NULL";
$nameresult = $conn->query($namecheck);

if($nameresult->num_rows < 1)
{

?>

<!DOCTYPE html>
<html translate="no" lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Login with SaucyWeasel</title>
		<link href="bets.css" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/x-icon" href="/img/favicon.ico">

	</head>
	<body>
<center><img src='img/saucy2.png'></center>
		<div class="content">
        <?php if(!$newuser)
        {
            ?>
			<h1>
                Create a Username
                <?php echo $msg; ?>

            </h1>
            <form method="post" action="gameslist.php">
            <label for="username">Username:</label>
            <input type="text" name="newname" value="<?php echo $username; ?>"><br><br>
            <input type="submit" value="Create Username">
            </form>

            <?php } ?>
               
		</div>

	</body>
</html>
<?php } else { 
    $playinfo = $nameresult->fetch_assoc();
    $_SESSION["weasel_name"] = $playinfo["playername"];
    header("Location:index.php"); 
} 

?>