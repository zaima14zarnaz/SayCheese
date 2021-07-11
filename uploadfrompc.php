<?php
session_start();
$ok = true;
$fileNameNew = "";

if(!isset($_POST['savephoto']))
{
	$ok = false;
	$fileNameNew = "";
	$user = "";
	$_SESSION['error'] = "";

}


if(isset($_POST['submit']))
{
	$db = mysqli_connect("localhost","root","","user_registration");
	$getUser = "SELECT * FROM currently_loggedin WHERE ID = 1";
	$res = mysqli_query($db,$getUser);
	$user = "";
	while($row = mysqli_fetch_array($res))
	{
		$user = $row['name'];
		break;
	}
	
	$file = $_FILES['file'];
	$filename = $_FILES['file']['name'];
	$filetmpname = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileErr = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	$fileExt = explode('.', $filename);
	$fExt = strtolower(end($fileExt));

	$allowed = array('jpg','jpeg','png');
	

	if(in_array($fExt, $allowed))
	{
		if($fileErr === 0)
		{
			if($fileSize < 1000000)
			{

				$x = uniqid('',true);
				$fileNameNew = $x.".".$fExt;
				$_SESSION['filename'] = $fileNameNew;
				$_SESSION['usern'] = $user;
				$fileDestination = 'uploads/'.$fileNameNew;
				move_uploaded_file($filetmpname, $fileDestination);

				
				
				$ok = true;
	
				
				

			}
			else
			{
				echo "You file is to Big!";
			}
		}
		else
		{
			echo "There was an error uploading your file";
		}
	}
	else
	{
		echo "You cannot upload files of this type";
	}
}

				


			



?>


<?php
$db = mysqli_connect("localhost","root","","user_registration");
	$getUser = "SELECT * FROM currently_loggedin WHERE ID = 1";
	$res = mysqli_query($db,$getUser);
	$user = "";
	while($row = mysqli_fetch_array($res))
	{
		$user = $row['name'];
		break;
	}
	$firstName = explode(" ", $user);

?>
<?php
if(isset($_POST['logout']))
{
	setcookie('name',"",time()-3600);
	$db = mysqli_connect("localhost","root","","user_registration");
	$deletUser = "DELETE FROM currently_loggedin WHERE ID = 1";
	mysqli_query($db,$deletUser);
	session_destroy();
	header('Location:index.php');
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
	<title>Uload From PC</title>
	<link rel="stylesheet" type="text/css" href="uploadfrompc.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<body style="background-color: hsl(0, 0%, 95%);">
	

	<div style="position: sticky;top:0px;background-color: white;padding-bottom: 70px;box-shadow: 6px 6px 5px grey;">
		<nav class="navbar" style="background-color: white;">
			<ul class="navlist" style="background-color: white;">
				<a href="home.php"><li style="display: inline;margin: 10px;padding-top: 15px;"><i class="fas fa-camera-retro" style="color: #735c57;font-size: 30px;"></i></li></a>
				<li class="listitem"><form action="uploadfrompc.php" method="post" style="display: inline;" ><input type="text" name="search" placeholder="Search" class="searchbar" style="width: 960px;"></li>
				<button name="searchbtn" style="border: 0px solid white;box-shadow: 0px white;"><li style="display: inline;"><i class="fas fa-search" style="padding: 10px;color: #a1695d;background-color: white;border: 0px solid white;"></i></form></li></button>
				<li class="listitem" style="width: 50px;"><a href="home.php">Home</a></li>
				<li class="listitem" style="width: 50px;"><a href="profile.php"><?php echo $firstName[0]; ?> </a></li>
				<li class="listitem" style="width: 50px;"><form action="uploadfrompc.php" method="post" style="padding-right: 10px;display: inline;"><div style="padding-right: 10px;display: inline;"><input type="submit" name="logout" class="logoutbtn" value="Logout"></form></div></li>
			</ul>
		</nav>
		
	</div>
	<form action="uploadfrompc.php" method="post" enctype="multipart/form-data" style="display: block;">


	
	
	<div style="background-color: white;width: 900px;margin: 0 auto;border-radius: 20px;height: 550px;margin-top: 30px;margin-bottom: 40px;box-shadow: 6px 6px 5px grey;">
	<div style="display: inline;float: left; width: 40%;background-color:  hsl(0, 0%, 97%);margin: 30px;border-radius: 20px;height: 370px;margin-top: 50px;">
		<?php 
		if(isset($_POST['submit'])) 
		{
			if($ok == true) 
			{

				echo "<img style='border-radius: 20px;width: 100%;border-color: white;object-fit:contain;' src='".$fileDestination."';  alt='' /> ";
				
				
			}

		} 
		else
		{
			echo "<div style='margin:10px;border:3px dashed grey;border-radius:20px;height:92%;'>";
			echo "<div style='display: block;width:360px;margin:0 auto;margin-top:140px;'>";
			echo "<div style='margin-left:145px;'><label for='file-upload' class='custom-file-upload'><i class='fas fa-arrow-circle-up' style='color:grey;font-size: 30px;'></i><input id='file-upload' type='file' name='file'/><i></label></div>";
			
			echo "<p style='margin-left:120px;font-family:Bradley Hand ITC;'>Click to Upload</p>";
			echo "<button class='uploadbtn' type='submit' name = 'submit' style='margin-top: 160px;'>Preview</button>";
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
				if(isset($_POST['savephoto']) and $ok == true)
				{
					$text = $_POST['text'];
					$title = $_POST['title'];
					$hashtags = $_POST['hastags'];
					
					
						$str = explode("#", $hashtags);
						$a = $_SESSION['filename'];
						$b = $_SESSION['usern'];

						if(isset($_POST['privacy'])) $privacy = "private";
						else $privacy = "public";

						$db = mysqli_connect("localhost","root","","photos");
						for($i = 0 ; $i < sizeof($str) ; $i++)
						{
							if(empty($str[$i])) continue;
							$insert = "INSERT INTO tags(hashtags,username,image,privacy,title,text) VALUES ('$str[$i]','$b','$a','$privacy','$title','$text')";
							mysqli_query($db,$insert);
						}
						
						$insert = "INSERT INTO images(image,text,username,privacy,Title,hashtags) VALUES ('$a','$text','$b','$privacy','$title','$hashtags')";
						mysqli_query($db,$insert);
					
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
				<input type="text" name="hastags" placeholder="Add You Hastags here" class = "phototext">
			</div>
			<div style="text-align: left;font-size: 15px;font-family: Britannic bold;color: red;padding-top: 10px;"><?php echo $_SESSION['error']; ?></div>

	</div>
	
    </div>
</form>
    


</body>
</html>

