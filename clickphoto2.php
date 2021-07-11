<?php
session_start();
$id = $_SESSION['num2'];
$link = $username = $title = $text = $hashtags = "";
$db = mysqli_connect("localhost","root","","photos");
$fetch = "SELECT * FROM images WHERE ID = $id";
$res = mysqli_query($db,$fetch);
$type = "";

while($row = mysqli_fetch_array($res))
{
	$link = $row['image'];
	$username = $row['username'];
	$title = $row['Title'];
	$text = $row['text'];
	$hashtags = $row['hashtags'];
	$type = $row['type'];
	break;
}
					
					
$_SESSION['l'] = $link;
$_SESSION['un'] = $username;
$_SESSION['ti'] = $title;
$_SESSION['tex'] = $text;
$_SESSION['hashtags'] = $hashtags;
$_SESSION['type'] = $type;
?>
<?php

$db = mysqli_connect("localhost","root","","user_registration");
$getUser = "SELECT * FROM currently_loggedin WHERE ID = 1";
$res = mysqli_query($db,$getUser);
while($row = mysqli_fetch_array($res)){
$_SESSION['uname'] = $row['name'];
$_SESSION['uemail'] = $row['email'];
}
if(isset($_POST['logout']))
{
	setcookie('name',"",time()-3600);
	$db = mysqli_connect("localhost","root","","user_registration");
	$deletUser = "DELETE FROM currently_loggedin WHERE ID = 1";
	mysqli_query($db,$deletUser);
	session_destroy();
	header('Location:index.php');
}
else if(isset($_POST['user']))
{
	header("Location:profile.php");
}
?>
<?php
if(isset($_POST['searchbtn']))
{
	$_SESSION['seachfield'] = $_POST['search'];
	if(!empty($_SESSION['seachfield']))
	{
		header('Location:search.php');
	}
}
?>


<?php

	$n = $_SESSION['uname'];
	$firstName = explode(" ", $n);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Click Photo</title>
	<title>Pinterest</title>
	<link rel="stylesheet" type="text/css" href="clickphoto.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-color: hsl(0, 0%, 90%);">

	<div style="position: sticky;background-color: white;padding-bottom: 70px;">
		<nav class="navbar" style="background-color: white;">
			<ul class="navlist" style="background-color: white;">
				<li style="display: inline;margin: 10px;padding-top: 15px;"><i class="fas fa-camera-retro" style="color: #a1695d;font-size: 30px;"><a href="home.php"></a></i></li>
				<li class="listitem"><form action="clickphoto.php" method="post" style="display: inline;" ><input type="text" name="search" placeholder="Search" class="searchbar" style="width: 960px;"> </form> </li>
				<button name="searchbtn" style="border: 0px solid white;box-shadow: 0px white;"><li style="display: inline;"><i class="fas fa-search" style="padding: 10px;color: #a1695d;background-color: white;border: 0px solid white;"></i></form></li></button>
				<li class="listitem" style="width: 50px;"><a href="home.php">Home</a></li>
				<li class="listitem" style="width: 50px;"><a href="profile.php"><?php echo $firstName[0]; ?> </a></li>
				<li class="listitem" style="width: 50px;"><form action="home.php" method="post" style="padding-right: 10px;display: inline;"><div style="padding-right: 10px;display: inline;"><input type="submit" name="logout" class="logoutbtn" value="Logout"></form</div></li>
			</ul>
		</nav>
		
	</div>

<div style="background-color: white;width: 800px;height: 450px;  margin: 0 auto;border-radius: 20px;margin-top: 40px;margin-bottom: 40px;">
	<div style="width: 50%;display: inline;float: left;height: 80%;">
		<img src="
		<?php
		if($type == 'web') 
		echo $link;
		else
		echo 'uploads/'.$link; ?>" class="imagetile">
	</div>
	<div style="display: inline;float: right;width: 50%;margin-top: 20px;">
		
			<span style="cursor: pointer;" class="savebtn" ><a href="temp.php" style="text-decoration: none;color: white"><i class="fas fa-thumbtack" style="padding-right: 8px;font-size: 15px;"></i><strong>Save</strong></a></span>
		
		<p style="font-size: 40px;font-family: Bradley Hand ITC;padding-left: 40px;width: 70%;margin-top: 50px;"><strong><?php echo $title ?></strong></p>
		<div style="margin-top: 40px;border-bottom: 2px solid grey;margin: 20px;margin-top: 60px;width: 70%;margin-left:40px;padding-bottom: 20px;">
				<span><i class="fas fa-user-circle" style="display: inline;float: left;font-size: 40px;color: grey;padding-right: 10px;"></i></span>
				<span style="margin-left: 30px;padding-top: 2px;"><p style="font-family: Bradley Hand ITC;font-size: 20px;"><strong><?php echo $_SESSION['un']; ?></strong></p></span>
		</div>
		
			<div style="width: 70%;padding-top: 20px;margin-left: 40px;font-size: 18px;font-family: Bradley Hand ITC;color: grey;margin-right: 20px;"><strong><?php echo $_SESSION['tex']; ?></strong></div>
			
			<div style="width: 70%;margin-top: 5px;margin-left: 40px;font-size: 18px;font-family: Bradley Hand ITC;color: #a1695d;margin-right: 20px;"><strong><p><?php echo $_SESSION['hashtags']; ?></p></strong></div>
		
		
	</div>	

	
		 
</div>

</body>
</html>