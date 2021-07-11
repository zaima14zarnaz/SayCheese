<?php
session_start();
$id = $_SESSION['id'];

echo $id;
$db = mysqli_connect("localhost","root","","photos");
$fetch = "DELETE FROM images WHERE ID = $id";
$res = mysqli_query($db,$fetch);

$incrlike = "UPDATE images SET saves=saves - 1 WHERE id=".$id;
$res = mysqli_query($db,$incrlike);

header('Location:profile.php');
?>