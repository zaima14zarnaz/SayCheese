<?php
session_start();
$_SESSION['num2'] = 0;
$db = mysqli_connect("localhost","root","","user_registration");

$fetchpic = "SELECT * FROM users WHERE name = '".$_SESSION['un']."'";
	$result = mysqli_query($db,$fetchpic);

	while($row = mysqli_fetch_array($result))
	{
		$pro = $row['Profilepic'];
	}
$fetch = "SELECT * FROM currently_loggedin";
$result = mysqli_query($db,$fetch);
$name = "";
$pass = "";
$email = "";
while($row = mysqli_fetch_array($result))
{
	$name = $row['name'];
	$email = $row['email'];
	$pass = $row['password'];
	break;

}

?>

<?php

	$n = $_SESSION['uname'];
	$firstName = explode(" ", $n);
	$db = mysqli_connect("localhost","root","","photos");
	$getlikes = "SELECT id FROM likes WHERE name='".$n."'";
	$res = mysqli_query($db,$getlikes);
	$mylike = array();
	while($row = mysqli_fetch_array($res))
	{
		array_push($mylike,$row['id']);
		
	}

?>
<?php
	$db = mysqli_connect("localhost","root","","photos");

	

	$fetcheverything = "SELECT * FROM images WHERE username = '".$_SESSION['un']."'";
	$result = mysqli_query($db,$fetcheverything);

	



	$html = '';
	$counter = 0;
	while($row = mysqli_fetch_array($result))
	{
    // Assuming the db query returned an object, adapt for array otherwhise
		
			$x = $row['id'];
			$bb= "style='background-color:";
			if(in_array($x, $mylike)) 
			{
				$bb.="black;'";
			}
			else
			{
				$bb.="none;'";
			}
		if($row['type'] == 'web')
		{
					
			if(isset($_POST["clickphoto".$counter.""]))
			{
				$_SESSION['num2'] = $row['id'];
				header('Location:clickphotoprofile.php');
				break;
			}
			if(isset($_POST["liked".$counter.""]))
			{
				$i = $row['id'];
				
				if(in_array($i, $mylike)){
					$getUser = "DELETE FROM likes WHERE id=".$i." AND name='".$n."'";
					$res = mysqli_query($db,$getUser);
					$bb= "style='background-color:none;'";

					$key = array_search($i, $mylike);
					if (false !== $key) {
    					unset($mylike[$key]);


					}

					$decrlike = "UPDATE images SET likes=likes - 1 WHERE id=".$i;
					$res = mysqli_query($db,$decrlike);

				}
				else
				{
					$getUser = "INSERT INTO likes VALUES('$n',$i)";
					$res = mysqli_query($db,$getUser);
					array_push($mylike,$row['id']);
					$bb= "style='background-color:black;'";


					$decrlike = "UPDATE images SET likes=likes + 1 WHERE id=".$i;
					$res = mysqli_query($db,$decrlike);

				}
				
			}
			
			$html .= "<div class='item' style='width:300px;' id='item'><div class='content' style='background-color: hsl(0, 0%, 97%);'><form action='visitprofile.php' method='post'><button style='background-color:none;' name='liked".$counter."'><div ".$bb." id='like' onclick='selected(this)' class='likebtn' name='likebtn" .$counter."'><i class='fas fa-heart' style=''></i></div></button><button style='border:0px solid white;text-decoration:none;'  type='submit' class='imagebtn' name = 'clickphoto".$counter."'><div style='width:300px;border-radius:20px;'><img src='".$row['image']."' class='photo' ><div><h3 class='heading'>".$row['Title']."</h3><p class='details'>".$row['text']."</p></div></div></button></form></div></div>";
			$counter++;
			}
			else 
			{
					
			if(isset($_POST["clickphoto".$counter.""]))
			{
				$_SESSION['num2'] = $row['id'];
				header('Location:clickphotoprofile.php');
				break;
			}
			if(isset($_POST["liked".$counter.""]))
			{
				$i = $row['id'];
				
				if(in_array($i, $mylike)){
					$getUser = "DELETE FROM likes WHERE id=".$i." AND name='".$n."'";
					$res = mysqli_query($db,$getUser);
					$bb= "style='background-color:none;'";

					$key = array_search($i, $mylike);
					if (false !== $key) {
    					unset($mylike[$key]);


					}

					$decrlike = "UPDATE images SET likes=likes - 1 WHERE id=".$i;
					$res = mysqli_query($db,$decrlike);

				}
				else
				{
					$getUser = "INSERT INTO likes VALUES('$n',$i)";
					$res = mysqli_query($db,$getUser);
					array_push($mylike,$row['id']);
					$bb= "style='background-color:black;'";



					$decrlike = "UPDATE images SET likes=likes + 1 WHERE id=".$i;
					$res = mysqli_query($db,$decrlike);
				}
				
			}
			$html .= "<div class='item' style='width:300px;' id='item'><div class='content' style='background-color: hsl(0, 0%, 97%);'><form action='visitprofile.php' method='post'><button style='background-color:none;' name='liked".$counter."'><div ".$bb." id='like' onclick='selected(this)' class='likebtn' name='likebtn" .$counter."'><i class='fas fa-heart' style=''></i></div></button><button type='submit' style='border:0px solid white;text-decoration:none;' name = 'clickphoto".$counter."'><div style='width:300px;border-radius:20px;'><img src='uploads/".$row['image']."'  class='photo' ><div><h3 class='heading'>".$row['Title']."</h3><p class='details'>".$row['text']."</p></div></div></button></form></div></div>";
				}
			
			
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

<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="profile.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="index.css">
	<script>
		function resizeGridItem(item)
		{
			grid = document.getElementsByClassName("grid")[0];
			rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
			rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
			rowSpan = Math.ceil((item.querySelector('.content').getBoundingClientRect().height+rowGap)/(rowHeight+rowGap));
			item.style.gridRowEnd = "span "+rowSpan;
		}
		function resizeAllGridItems()
		{
			allItems = document.getElementsByClassName("item");
			for(x=0;x<allItems.length;x++){
				resizeGridItem(allItems[x]);
			}
		}

	</script>
</head>
<body style="background-color: hsl(0, 0%, 97%);" onload="window.onload = resizeAllGridItems(); window.addEventListener('resize', resizeAllGridItems);">
	<div style="position: sticky;top:0px;background-color: white;padding-bottom: 70px;box-shadow: 6px 6px 5px grey;">
		<nav class="navbar">
			<ul class="navlist" style="background-color: white;">
				<li style="display: inline;margin: 10px;padding-top: 15px;"><i class="fas fa-camera-retro" style="color: #a1695d;font-size: 30px;"><a href="home.php"></a></i></li>
				<li class="listitem"><form action="profile.php" method="post" style="display: inline;" ><input type="text" name="search" placeholder="Search" class="searchbar" style="width: 960px;"></li>
				<button name="searchbtn" style="border: 0px solid white;box-shadow: 0px white;"><li style="display: inline;"><i class="fas fa-search" style="padding: 10px;color: #a1695d;background-color: white;border: 0px solid white;box-shadow: 0px white;"></i></form></li></button>
				<li class="listitem" style="width: 50px;"><a href="home.php">Home</a></li>
				<li class="listitem" style="width: 50px;"><a href="profile.php"><?php echo $firstName[0]; ?> </a></li>
				<li class="listitem" style="width: 50px;"><form action="home.php" method="post" style="padding-right: 10px;display: inline;"><div style="padding-right: 10px;display: inline;"><input type="submit" name="logout" class="logoutbtn" value="Logout"></form</div></li>
			</ul>
		</nav>
		
	</div>
	<div class="userinfo" style="background-color: white;padding-bottom: 30px;">
		<div style="display: inline-block;width:50px;height:50px;border-radius: 50px;margin-top: 70px;float: left;"><img class="" src="<?php echo 'uploads/'.$pro?>" style="width:150px;height:150px;border-radius: 150px;"></div>
		<div style="display: inline-block;margin-left: 150px;">
		<div><h1 style="font-family: Courier new;padding-top: 120px;padding-left: 10px;"><?php echo $_SESSION['un']; ?></h1></div>
		<div><p style="font-family: Courier new;padding-top: 5px;padding-left: 10px;margin-bottom: 90px;"><strong><?php echo $counter." photos"; ?></strong></p></div>
	</div>
		



	</div>
	<div style="margin-left: 10px;margin-right: 10px;margin-top: 20px;">
			
			<div class="grid" >
			    
                <?php echo $html; ?>
                
            </div>
	</div>
		

		
</body>
</html>