<?php
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
				$fileDestination = 'uploads/'.$fileNameNew;
				move_uploaded_file($filetmpname, $fileDestination);

				$db = mysqli_connect("localhost","root","","photos");
				$text = $_POST['text'];


				$text = $_POST['text'];
				
				$insert = "INSERT INTO images(image,text,username,privacy) VALUES ('$fileNameNew','$text','$user','public')";
				mysqli_query($db,$insert);
			 	header("Location:home.php?uploadsuccess");

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

else if(isset($_POST['upload']))
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
	
	$link = $_POST['imagelink'];
	$db = mysqli_connect("localhost","root","","photos");
	$text = $_POST['text'];
	$insert = "INSERT INTO images(image,text,type,username) VALUES ('$link','$text','web','$user')";
	mysqli_query($db,$insert);
	header('Location:home.php');


}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div>
		<?php
		$db = mysqli_connect("localhost","root","","photos");
		$fetch = "SELECT * FROM images";
		$result = mysqli_query($db,$fetch);

		while($row = mysqli_fetch_array($result))
		{
			if($row['type'] == "pc")
			{
			echo "<div id = 'img_div'>";
			echo "<img src ='uploads/".$row['image']."' >";
			echo "<p>".$row['text']."</p>";
			echo "</div>";
		    }
		    else if($row['type'] == "web")
		    {
		    	echo "<div id = 'img_div'>";
		    	echo "<img src ='".$row['image']."' >";
		    	echo "<p>".$row['username']."</p>";
		    	echo "<p>".$row['text']."</p>";
		    	echo "</div>";
		    }

		}
		?>
	</div>
	<form action="upload.php" method="post" style="display: block" enctype="multipart/form-data">
		<div>
			<input type="text" name="imagelink" style="width: 600px;">
		</div>
		<div>
	    	<textarea name = "text" cols = "40" rows = "4" placeholder="Say somethings about this photo"></textarea>
	    </div>
		<button type="submit" name = "upload">Upload</button>
	</form>
	<form action="upload.php" method="post" enctype="multipart/form-data" style="display: block;">
		<div>
			<input type="file" name="file">
	    </div>
	    <div>
	    	<textarea name = "text" cols = "40" rows = "4" placeholder="Say somethings about this photo"></textarea>
	    </div>
		<button type="submit" name = "submit">Upload</button>

	</form>

</body>
</html>

