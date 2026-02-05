<?php
session_start();
if(isset($_GET["newuser"]))
{
    $newuser = true;
}
else
{
    include 'config.php';
    $newuser = false;
    $userneeded = false;
    $grundle = "";
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        $password = hash('sha256',stripslashes($_POST["password"]));
        //clean the username
        $username = stripslashes($_POST["username"]);

        $trylogin = "Select playername from weasels where playername = '".$username."' and password = '".$password."'";
        $loginresult = $conn->query($trylogin);
        if($loginresult->num_rows > 0)
        {
            $login = $loginresult->fetch_assoc();
            $_SESSION['weasel_loggedin'] = TRUE;
            $_SESSION['weasel_name'] = $login["playername"];

            header("Location:index.php");
        }
    }
    
}
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
                Login

            </h1>
            <form method="post" action="swauth.php">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <input type="submit" value="Login with SaucyWeasel">
            </form>

            <a href="swauth.php?newuser=weasel" style="color:blue;">New to SaucyWeasel? Sign up</a>
            <?php } else { ?>
                <h1>Sign Up</h1>
                <?php 
                    if(isset($_GET["msg"]))
                        {
                            echo "<span style='color:red;'>".str_replace('_',' ',$_GET["msg"])."</span><br><br>";
                        }
                        ?>
                <form method="post" action="signup.php">
                <label for="email">Email:</label>
                <input type="email" name="email" required><br>
                <label for="playername">Username:</label>
                <input type="text" name="playername" required><br>
                <label for="password">Password:</label>
                <input type="password" name="password" required><br>
                <input type="submit" value="Create SaucyWeasel Account">
            </form>
            
            <?php } ?>
               
		</div>

	</body>
</html>
