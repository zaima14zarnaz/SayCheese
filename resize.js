<?php

	$db = mysqli_connect("localhost","root","","photos");
	$q = "SELECT COUNT(image) FROM images";
	$num = mysqli_query($db,$q);
	$q = "DELETE FROM images WHERE ID <= $num - 7";
	$result = mysqli_query($db,$q);


?>