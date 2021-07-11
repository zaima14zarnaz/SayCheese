<?php
session_start();
$lookfor = $_SESSION['seachfield'] ;
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
	$fetcheverything = "SELECT * FROM images";
	$result = mysqli_query($db,$fetcheverything);
	$html = '';
	$counter = 0;
	while($row = mysqli_fetch_array($result))
	{
    // Assuming the db query returned an object, adapt for array otherwhise
		if($row['privacy'] == 'public')
		{
		if( strpos( $row['hashtags'], $lookfor ) !== false){
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
				$_SESSION['num'] = $row['id'];
				header('Location:clickphoto.php');
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

					$incrlike = "UPDATE images SET likes=likes + 1 WHERE id=".$i;
					$res = mysqli_query($db,$incrlike);
				}
				
			}

			$html .= "<div class='item' style='width:300px;' id='item'><div class='content' style='background-color: hsl(0, 0%, 97%);'><form action='search.php' method='post'><button style='background-color:none;' name='liked".$counter."'><div ".$bb." id='like' onclick='selected(this)' class='likebtn' name='likebtn" .$counter."'><i class='fas fa-heart' style=''></i></div></button><button style='border:0px solid white;text-decoration:none;'  type='submit' class='imagebtn' name = 'clickphoto".$counter."'><div style='width:300px;border-radius:20px;'><img src='".$row['image']."' class='photo' ><div><h3 class='heading'>".$row['Title']."</h3><p class='details'>".$row['text']."</p></div></div></button></form></div></div>";
			
			
		}
		else
		{
			
			if(isset($_POST["clickphoto".$counter.""]))
			{
				$_SESSION['num'] = $row['id'];
				header('Location:clickphoto.php');
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

					$incrlike = "UPDATE images SET likes=likes + 1 WHERE id=".$i;
					$res = mysqli_query($db,$incrlike);
				}
				
			}
			$html .= "<div class='item' style='width:300px;' id='item'><div class='content' style='background-color: hsl(0, 0%, 97%);'><form action='search.php' method='post'><button style='background-color:none;' name='liked".$counter."'><div ".$bb." id='like' onclick='selected(this)' class='likebtn' name='likebtn" .$counter."'><i class='fas fa-heart' style=''></i></div></button><button type='submit' style='border:0px solid white;text-decoration:none;' name = 'clickphoto".$counter."'><div style='width:300px;border-radius:20px;'><img src='uploads/".$row['image']."'  class='photo' ><div><h3 class='heading'>".$row['Title']."</h3><p class='details'>".$row['text']."</p></div></div></button></form></div></div>";
		
	    }
	    $counter++;

	}

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
	<title>Search</title>
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-color: hsl(0, 0%, 97%);" onload="window.onload = resizeAllGridItems(); window.addEventListener('resize', resizeAllGridItems);">
	
	<div style="position: sticky;top:0px;background-color: white;padding-bottom: 70px;box-shadow: 6px 6px 5px grey;">
		<nav class="navbar" style="background-color: white;">
			<ul class="navlist" style="background-color: white;">
				<a href="home.php"><li style="display: inline;margin: 10px;padding-top: 15px;"><i class="fas fa-camera-retro" style="color: #735c57;font-size: 30px;"></i></li></a>
				<li class="listitem"><form action="search.php" method="post" style="display: inline;" ><input type="text" name="search" placeholder="Search" class="searchbar" style="width: 960px;">  </li>
				<button name="searchbtn" style="border: 0px solid white;box-shadow: 0px white;"><li style="display: inline;"><i class="fas fa-search" style="padding: 10px;color: #a1695d;background-color: white;border: 0px solid white;"></i></form></li></button>
				<li class="listitem" style="width: 50px;"><a href="home.php">Home</a></li>
				<li class="listitem" style="width: 50px;"><a href="profile.php"><?php echo $firstName[0]; ?> </a></li>
				<li class="listitem" style="width: 50px;"><form action="home.php" method="post" style="padding-right: 10px;display: inline;"><div style="padding-right: 10px;display: inline;"><input type="submit" name="logout" class="logoutbtn" value="Logout"></form</div></li>
			</ul>
		</nav>
		
	</div>
	<div style="margin-left: 10px;margin-right: 10px;margin-top: 30px;">
			
			<div class="grid" >
                <?php echo $html; ?>

            </div>
	</div>
	

</body>
</html>