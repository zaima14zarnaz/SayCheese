<?php
session_start();
if(isset($_COOKIE['name']))
{
	header('Location:home.php');
}
else
{

$con = mysqli_connect('localhost','root','');
mysqli_select_db($con , 'User_Registration');

$namemsg = $passmsg = "";
$overallmsg = "";

if(isset($_POST['submit'])){
$name = $_POST['username'];
$password = $_POST['pass'];
if(empty($name) or empty($password))
{
	$overallmsg = "All fields must be filled";
}


else{
$s = "select name,password from users where name = '$name' && password = '$password'";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);

$deleteUser = "DELETE FROM currently_loggedin WHERE ID = 1";
mysqli_query($con,$deleteUser);

$saveUser = "INSERT INTO currently_loggedin(name,password,email) VALUES('$name','$password','$email')";
mysqli_query($con,$saveUser);
$findEmail = "Select * from users where name = '$name'";
$found = mysqli_query($con,$findEmail);
while($x = mysqli_fetch_array($found))
{
	$email = $x['email'];
	break;
}

if($num == 1)
{
	if(isset($_POST['remember']))
	{
	setcookie('name',$name,time() + 86400*30);
	setcookie('password',$password,time() + 86400*30);

    }
    header('Location: home.php');


}
else if($num == 0)
{
	$overallmsg = "Wrong username or password";
}
}
}

else if(isset($_POST['submit2']))
{
	header('Location: SignUp.php');
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>SayCheese</title>
	<link rel="stylesheet" type="text/css" href="signInPage.css">
</head>
<body>
	<div style="height: 100%;width: 100%;position: relative;right: 0px;">
		
		<div class="signup" style="display: inline-block;">
			<p style="width: 450px;text-align: center;color: white;margin-top: 150px;font-family: Bradley Hand ITC,monospace;font-size: 30px;font-style: cursive;"><strong>Welcome  To  SayCheese</strong></p>

			<form autocomplete="off" action="index.php" method="post" style="margin-left: 60px;">
				<div><input type="text" name="username" class="namefield" placeholder="Username" autocomplete="off"></div>
				<div class="messeges"><?php echo $namemsg; ?></div>
				<div><input type="password" name="pass" class="passfield" placeholder="Password" autocomplete="off"></div>
				<div class="messeges"><?php echo $passmsg; ?></div>
				<div class="messeges"><?php echo $overallmsg; ?></div>
				<div><input type="checkbox" name="remember"  style="color: white;padding: 20px;padding-left: 5px;"><span style="color: white;
				padding: 20px;">Remeber Me</span></div>
				<div><input type="submit" name="submit" value="Sign In" class="submitbtn" autocomplete="off"></div>
				<div><input type="submit" name="submit2" value="Sign Up" class="submitbtn2"></div>
				
			</form>
		</div>
		<div style="display: inline-block;" class="container">
			<p style="width:700px;text-align: center;color: white;margin-top: 120px;font-family: Bradley Hand ITC;font-size: 25px;"><b>A Photograph is The Pause Button of Life</b></p><br>
			<p style="width:700px;text-align: center;color: white;margin-top: 10px;font-family: Bradley Hand ITC;font-size: 20px;">Share your moments with the world</p>
		</div>
	</div>



</body>
</html>
<?php
}
?>