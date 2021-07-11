<?php
session_start();
$db = mysqli_connect("localhost","root","","user_registration");
$getUser = "SELECT * FROM currently_loggedin WHERE ID = 1";
$res = mysqli_query($db,$getUser);
$user = "";
while($row = mysqli_fetch_array($res))
{
	$_SESSION['un'] = $row['name'];
	break;
}

?>

<?php

	$firstName = explode(" ", $user);

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

<!DOCTYPE html>
<html>
<head>
	<title>Upload from web</title>

	<link rel="stylesheet" type="text/css" href="uploadfrompc.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<body>

<body style="background-color: hsl(0, 0%, 95%);">
	

	<div style="position: sticky;top:0px;background-color: white;padding-bottom: 70px;box-shadow: 6px 6px 5px grey;">
		<nav class="navbar" style="background-color: white;">
			<ul class="navlist" style="background-color: white;">
				<a href="home.php"><li style="display: inline;margin: 10px;padding-top: 15px;"><i class="fas fa-camera-retro" style="color: #735c57;font-size: 30px;"></i></li></a>
				<li class="listitem"><form action="uploadfromweb.php" method="post" style="display: inline;" ><input type="text" name="search" placeholder="Search" class="searchbar" style="width: 960px;"></li>
				<button name="searchbtn" style="border: 0px solid white;box-shadow: 0px white;"><li style="display: inline;"><i class="fas fa-search" style="padding: 10px;color: #a1695d;background-color: white;border: 0px solid white;"></i></form></li></button>
				<li class="listitem" style="width: 50px;"><a href="home.php">Home</a></li>
				<li class="listitem" style="width: 50px;"><a href="profile.php"><?php echo $firstName[0]; ?> </a></li>
				<li class="listitem" style="width: 50px;"><form action="uploadfrompc.php" method="post" style="padding-right: 10px;display: inline;"><div style="padding-right: 10px;display: inline;"><input type="submit" name="logout" class="logoutbtn" value="Logout"></form></div></li>
			</ul>
		</nav>
		
	</div>
	<form action="uploadfromweb.php" method="post" enctype="multipart/form-data" style="display: block;">


	
	
	<div style="background-color: white;width: 900px;margin: 0 auto;border-radius: 20px;height: 550px;margin-top: 30px;margin-bottom: 40px;">
	<div style="display: inline;float: left; width: 40%;background-color:  hsl(0, 0%, 97%);margin: 30px;border-radius: 20px;height: 370px;margin-top: 50px;">
		<?php 
		if(isset($_POST['submit'])) 
		{
			$_SESSION['li'] = $_POST['link'];
			echo "<img style='border-radius: 20px;width: 100%;border-color: white;object-fit:contain;' src='".$_POST['link']."';  alt='' /> ";
				
				
			

		} 
		else
		{
			echo "<div style='margin:10px;border:3px dashed grey;border-radius:20px;height:92%;'>";
			echo "<div style='display: block;width:360px;margin:0 auto;margin-top:140px;'>";
			echo "<div><input type='text' name='link' placeholder='Paste Your Link Here' class='linkbox'></div>";
			echo "<button class='uploadbtn' type='submit' name = 'submit' style='margin-top: 10px;'>Preview</button>";
			echo "</div>";
			echo "</div>";
			
			
			
		}
		echo "</div>";
		?>

	
	
	<div style="display: inline;float: right;width: 50%;">
		<div>
			<input type="radio" name="privacy" class="privacy"><p style="color: grey;font-size: 20px;font-family: Bradley Hand ITC;display: inline;margin-left: 10px;"><strong>Private</strong></p>
			
			<button name="savephoto" class="savebtn" style="cursor: pointer;"><i class="fas fa-thumbtack" style="padding-right: 8px;font-size: 15px;"></i><strong>Save
				<?php
				if(isset($_POST['savephoto']))
{
	
	
	$link = $_SESSION['li'];
	$db = mysqli_connect("localhost","root","","photos");
	$text = $_POST['text'];
	$title = $_POST['title'];
	$hashtags = $_POST['hashtags'];
	$str = explode("#", $hashtags);

	$b = $_SESSION['un'];



	if(isset($_POST['privacy'])) $privacy = "private";
	else $privacy = "public";
	for($i = 0 ; $i < sizeof($str) ; $i++)
	{
		if(empty($str[$i])) continue;
		$insert = "INSERT INTO tags(hashtags,username,image,privacy,title,text,type) VALUES ('$str[$i]','$b','$link','$privacy','$title','$text','web')";
		mysqli_query($db,$insert);

	}

	$insert = "INSERT INTO images(image,text,username,privacy,Title,hashtags,type) VALUES ('$link','$text','$b','$privacy','$title','$hashtags','web')";
	mysqli_query($db,$insert);
	echo "<script>
		alert('Your image has been added successfully!')
		</script>";

	echo "<script>
		window.location = 'profile.php'
		</script>";



}

?>

				
				</strong></button>
			<input type="text" name="title" placeholder="Add Your Title" class="titletext">
			<div style="margin-top: 40px;">
				<span><i class="fas fa-user-circle" style="display: inline;float: left;font-size: 40px;color: grey;padding-right: 10px;"></i></span>
				<span style="margin-left: 30px;padding-top: 2px;"><p style="font-family: Bradley Hand ITC;font-size: 20px;"><strong><?php echo $user; ?></strong></p></span>
			</div>
			<input type="text" name="text" placeholder="Tell everyone about your snap" class="phototext">
			<div><p style="text-align: left;font-size: 12px;font-family: Britannic bold;color: grey;padding-top: 10px;">Your first 50 characters is what usually shows up on your stories</p></div>
			<div>
				<input type="text" name="hashtags" placeholder="Add You Hastags here" class = "phototext">
			</div>
		<!--	<div style="text-align: left;font-size: 15px;font-family: Britannic bold;color: red;padding-top: 10px;"><?php echo $_SESSION['error']; ?></div>-->

	</div>
	
    </div>
</form>
    


</body>
</html>

