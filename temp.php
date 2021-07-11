
<?php

	session_start();




	
	$i = $_SESSION['i'];
	$link = $_SESSION['l'];
	$username = $_SESSION['uname'];
	$title = $_SESSION['ti'];
	$text = $_SESSION['tex']; 
	$hashtags = $_SESSION['hashtags'];
	$type = $_SESSION['type'];





	$db = mysqli_connect("localhost","root","","photos");

	$incrlike = "UPDATE images SET saves=saves + 1 WHERE id=".$i;
	$res = mysqli_query($db,$incrlike);

	if($type === "web")
	{
		$add = "INSERT INTO images(image,text,username,privacy,Title,hashtags,type) VALUES ('$link','$text','$username','public','$title','$hashtags','web')";
	}
	else
	{
		$add = "INSERT INTO images(image,text,username,privacy,Title,hashtags,type) VALUES ('$link','$text','$username','public','$title','$hashtags','pc')";
	} 

	mysqli_query($db,$add);

	header('Location:profile.php');



?>