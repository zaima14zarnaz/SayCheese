<?php
session_start();

$con = mysqli_connect('localhost','root','');
mysqli_select_db($con , 'User_Registration');

$namemsg = $emailmsg = $passmsg = $gendermsg = "";
$overallmsg = "";

if(isset($_POST['submit'])){
$name = $_POST['nusername'];
$email = $_POST['nemail'];
$password = $_POST['npass'];
$gender = $_POST['gender'];

if(empty($name) or empty($email) or empty($password) or empty($gender))
{
	$overallmsg = "All fields must be filled";
}


else{
$s = "select * from users where name = '$name'";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);
if($num == 1)
{
	$namemsg = "Username already taken";
}
else if($num == 0)
{
	$reg = "insert into users(name, email, password,gender) values ('$name','$email','$password','$gender')";
	mysqli_query($con,$reg);
	header('Location:index.php');
}
}
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>SayCheese</title>
	<link rel="stylesheet" type="text/css" href="loginPageDesign.css">
</head>
<body>
	<div style="height: 100%;width: 100%;position: relative;right: 0px;">
		
		<div class="signup" style="display: inline-block;">
			<p style="width: 450px;text-align: center;color: white;margin-top: 150px;font-family: Bradley Hand ITC,monospace;font-size: 30px;font-style: cursive;"><strong>Create  An  Account</strong></p>
			<form autocomplete="off" action="SignUp.php" method="post" style="margin-left: 60px;" >
				<div><input type="text" name="nusername" class="namefield" placeholder="Username" autocomplete="off"></div>
				<div class="messeges"><?php echo $namemsg; ?></div>
				<div><input type="text" name="nemail" class="emailfield" placeholder="E-mail" autocomplete="off"></div>
				<div class="messeges"><?php echo $emailmsg; ?></div>
				<div><input type="password" name="npass" class="passfield" placeholder="Password" autocomplete="off"></div>
				<div class="messeges"><?php echo $passmsg; ?></div>
				<div><input type="text" name="gender" class="passfield" placeholder="Gender" autocomplete="off"></div>
				<div class="messeges"><?php echo $gendermsg; ?></div>
				<div class="messeges"><?php echo $overallmsg; ?></div>
				<div><input type="submit" name="submit" value="Sign Up" class="submitbtn"></div>
			</form>
		</div>
		<div style="display: inline-block;" class="container">
			<p style="width:700px;text-align: center;color: white;margin-top: 120px;font-family: Bradley Hand ITC;font-size: 25px;"><b>A Photograph is The Pause Button of Life</b></p><br>
			<p style="width:700px;text-align: center;color: white;margin-top: 10px;font-family: Bradley Hand ITC;font-size: 20px;">Share your moments with the world</p>
		</div>
	</div>



</body>
</html>