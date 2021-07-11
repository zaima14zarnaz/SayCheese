<?php
session_start();
$db = mysqli_connect("localhost","root","","user_registration");
$getUser = "SELECT * FROM currently_loggedin WHERE ID = 1";
$res = mysqli_query($db,$getUser);
$user = $pass = "";
while($row = mysqli_fetch_array($res))
{
	$user = $row['name'];
	$pass = $row['password'];
	break;
}
$getinfo = "SELECT * FROM users WHERE name='$user'";
$res = mysqli_query($db,$getinfo);
$na = $fn = $ln = $mnth = $pic = $em = "";
$da = $yr = 0;
while($row = mysqli_fetch_array($res))
{
	$na = $row['name'];
	$fn = $row['Firstname'];
	$ln = $row['Lastname'];
	$da = $row['Day'];
	$mnth = $row['Month'];
	$yr = $row['Year'];
	$pic = $row['Profilepic'];
	$em = $row['email']; 
}


if(isset($_POST['submit']))
{
	
	echo $user;
	$fileNameNew = "";
	
	$file = $_FILES['file'];
	$filename = $_FILES['file']['name'];
	$filetmpname = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileErr = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	$fileExt = explode('.', $filename);
	$fExt = strtolower(end($fileExt));

	$allowed = array('jpg','jpeg','png');
	

	if(in_array($fExt, $allowed) || empty($filename))
	{
		if($fileErr === 0 || empty($filename))
		{
			if($fileSize < 1000000 || empty($filename))
			{
				if(!empty($filename)){
				$x = uniqid('',true);
				$fileNameNew = $x.".".$fExt;
				$_SESSION['filename'] = $fileNameNew;
				$_SESSION['usern'] = $user;
				$fileDestination = 'uploads/'.$fileNameNew;
				move_uploaded_file($filetmpname, $fileDestination);
			}
			$username = "";
				if(!empty($_POST['username'])) $username = $_POST['username'];
				else $username= $user;

				$db = mysqli_connect("localhost","root","","user_registration");

				$find = "SELECT * FROM users WHERE name='$username'";

				$res = mysqli_query($db,$find);
				if (!$res) 
				{
    				printf("Error: %s\n", mysqli_error($db));
    				exit();
				}
				$match = $oldfname = $oldlname = $oldmonth = $oldemail = $oldpropic = $fname = $lname = $email = $month = $oldpass = "";
				$oldday = $oldyear = $day = $year = 0;
				
				$i = 0;
				$num_rows = mysqli_num_rows($res);
				echo $num_rows;
				if($num_rows > 0)
				{
					while($row = mysqli_fetch_array($res))
				{
					$match = $row['name'];
					$oldfname = $row['Firstname'];
					$oldlname = $row['Lastname'];
					$oldday = $row['Day'];
					$oldmonth = $row['Month'];
					$oldyear = $row['Year'];
					$oldpropic = $row['Profilepic'];
					$oldemail = $row['email']; 
					break;
					$i = $i + 1;
				}
						
					if($match == $user)
					{
						echo "same dude";
						if(!empty($_POST['firstname'])) $fname = $_POST['firstname'];
						else $fname = $oldfname;
						if(!empty($_POST['lastname'])) $lname = $_POST['lastname'];
						else $lname = $oldlname;
						if($_POST['day'] != 0) $day = $_POST['day'];
						else $day = $oldday;
						if($_POST['month'] != 0) $month= $_POST['month'];
						else $month = $oldmonth;
						if($_POST['year'] != 0) $year = $_POST['year'];
						else $year = $oldyear;
						if(!empty($_POST['email'])) $email = $_POST['email'];
						else $email = $oldemail;
						$delete = "DELETE FROM users WHERE name = '$user'";
						$insert = "INSERT INTO users(Firstname,Lastname,Day,Month,Year,Profilepic,name,email) VALUES ('$fname','$lname',$day,'$month',$year,'$fileNameNew','$username','$email')";
						mysqli_query($db,$delete);
						mysqli_query($db,$insert);
					}
					else
					{
						echo "Username Already Exists.";
						//header('Location:editprofile.php');
					}
				}
			
				else
				{
					if(!empty($_POST['firstname'])) $fname = $_POST['firstname'];
					
					if(!empty($_POST['lastname'])) $lname = $_POST['lastname'];
					
					if($_POST['day'] != 0) $day = $_POST['day'];
					
					if($_POST['month'] != 0) $month= $_POST['month'];
					
					if($_POST['year'] != 0) $year = $_POST['year'];
					
					if(!empty($_POST['email'])) $email = $_POST['email'];

					$delete = "DELETE FROM currently_loggedin WHERE ID = 1";
					$insert = "INSERT INTO currently_loggedin VALUES(1,'$username','$pass','$email')";
					$res = mysqli_query($db,$delete);
					
					$res = mysqli_query($db,$insert);
					
					if (!$res) 
				{
    				printf("Error: %s\n", mysqli_error($db));
    				exit();
				}


					
					$delete = "DELETE FROM users WHERE name = '$user'";
					$insert = "INSERT INTO users(Firstname,Lastname,Day,Month,Year,Profilepic,name,email) VALUES ('$fname','$lname',$day,'$month',$year,'$fileNameNew','$username','$email')";
					$res = mysqli_query($db,$delete);
					
					$res = mysqli_query($db,$insert);
					
					if (!$res) 
				{
    				printf("Error: %s\n", mysqli_error($db));
    				exit();
				}

				}
				
				
				$ok = true;
	
				
				header('Location:profile.php');

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

<!DOCTYPE html>
<html>
<head>
	<title>Say Cheese</title>
	<link rel="stylesheet" type="text/css" href="editprofile.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	<script>
        function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    </script>
    <script>
    	function onpgload()
        {
        	var na = <?php echo $na ?>;
        	var fn = <?php echo $fn ?>;
        	var ln = <?php echo $ln ?>;
        	var da = <?php echo $da ?>;
        	var mnth = <?php echo $mnth ?>;
        	var yr = <?php echo $yr ?>;
        	var pic = <?php echo $pic ?>;
        	var em = <?php echo $em ?>;
        	console.log(na);
        	console.log(fn);
        	console.log(ln);
        	console.log(mnth);
        	console.log(pic);
        	console.log(yr);
        	console.log("hklhk");
        	document.getElementById("check").innerHTML = "ghjkhgkjh";

        	if(na.length != 0) document.getElementById("username").value = na;
        	if(fn.length != 0)document.getElementById("company_name").value = "value";
        	if(ln.length != 0)document.getElementById("company_name").value = "value";
        	if(mnth.length != 0)document.getElementById("company_name").value = "value";
        	if(pic.length != 0)document.getElementById("company_name").value = "value";
        	if(em.length != 0)document.getElementById("company_name").value = "value";
        	if(da != 0)document.getElementById("company_name").value = "value";
        	if(yt != 0)document.getElementById("company_name").value = "value";
        }
    
    window.onload = onpgload;
    	
    </script>
	
</head>
<body style="background-color: #a1695d;" >
	<div style="background-color: white;margin:100px;height: 1000px;margin-right: 100px;border-radius: 10px;box-shadow: 15px 20px 10px #6f483f;">
		<div style="float: left;width: 35%;display: inline;">
			
			<div style="margin: 0 auto;width: 200px;margin-top: 100px;height: 200px; border-radius: 200px; " id="div1">
				<form method="post" action="editprofile.php" enctype="multipart/form-data" >
					<div style="width: 200px;height: 200px;border-radius: 200px;">
					<label for='file-upload' class='custom-file-upload' style="display: inline;width: 200px;height: 200px;border-radius: 200px;">
						<div style="width: 200px;height: 200px;border-radius: 200px;box-shadow: 5px 5px 2px grey;" id="imgholder" class="imgholder"><img id="blah" class='profilepic' src="<?php if(!empty($pic)) echo 'uploads/'.$pic; ?>"></div>
						<input id='file-upload' type='file' name='file' onchange="readURL(this);" style="width: 200px;height: 200px;border-radius: 200px;"/>

					</label>
				</div>
				<input type="submit" name="submit" class="save" value="save">
				
					
			
			
			</div>
		</div>
		<div style="float: left;width: 65%;display: inline;">
			<div style="margin-top: 100px;">
				<div style="width: 100%;">
					<div style="width: 45%;display: inline-block;">
						<p style="display: inline;" class="guide">First Name</p>
					</div>
					<div style="width: 45%;display: inline-block;">
						<p style="display: inline;" class="guide">Last Name</p>
					</div>
				</div>
				<div>
			        	<div style="width: 45%;display: inline-block;"><input type="text" name="firstname" id="firstname" class="name" placeholder="<?php echo $fn;?>"></div>
			        	<div style="width: 45%;display: inline-block;"><input type="text" name="lastname" id="lastname" class="name" placeholder="<?php echo $ln;?>"></div>
				    
	            </div>
			</div>
			<div style="margin-top: 100px;">
					<p class="guide">Username</p>
					<div> <input type="text" name="username" id="username" class="name" placeholder="<?php echo $na;?>" style="width: 73%;"></div>
				
			</div>
			<div style="margin-top: 100px;">
					<p class="guide">E-mail</p>
					<div> <input type="text" name="email" id="email" class="name" placeholder="<?php echo $em;?>" style="width: 73%;"></div>
				
			</div>
			<div style="margin-top: 100px;">
				<div><p class="guide">Birthday</p></div>
			</div>
				<div style="margin-left: 25px;margin-top: 20px;">
					<div style="display: inline-block;width: 30%;">
						<select class="select-css" name="day" id="day" value="<?php echo $da;?>">
							<option value="0" <?php if($da == 0) echo "selected";?> >Day</option>
							<option value="1" <?php if($da == 1) echo "selected";?>>1</option>
							<option value="2" <?php if($da == 2) echo "selected";?>>2</option>
							<option value="3" <?php if($da == 3) echo "selected";?>>3</option>
							<option value="4" <?php if($da == 4) echo "selected";?>>4</option>
							<option value="5" <?php if($da == 5) echo "selected";?>>5</option>
							<option value="6"<?php if($da == 6) echo "selected";?>>6</option>
							<option value="7" <?php if($da == 7) echo "selected";?>>7</option>
							<option value="8" <?php if($da == 8) echo "selected";?>>8</option>
							<option value="9" <?php if($da == 9) echo "selected";?>>9</option>
							<option value="10" <?php if($da == 10) echo "selected";?>>10</option>
							<option value="11" <?php if($da == 11) echo "selected";?>>11</option>
							<option value="12" <?php if($da == 12) echo "selected";?>>12</option>
							<option value="13" <?php if($da == 13) echo "selected";?>>13</option>
							<option value="14" <?php if($da == 14) echo "selected";?>>14</option>
							<option value="15" <?php if($da == 15) echo "selected";?>>15</option>
							<option value="16" <?php if($da == 16) echo "selected";?> >16</option>
							<option value="17" <?php if($da == 17) echo "selected";?>>17</option>
							<option value="18" <?php if($da == 18) echo "selected";?>>18</option>
							<option value="19" <?php if($da == 19) echo "selected";?>>19</option>
							<option value="20" <?php if($da == 20) echo "selected";?>>20</option>
							<option value="21" <?php if($da == 21) echo "selected";?>>21</option>
							<option value="22" <?php if($da == 22) echo "selected";?>>22</option>
							<option value="23" <?php if($da == 23) echo "selected";?>>23</option>
							<option value="24" <?php if($da == 24) echo "selected";?>>24</option>
							<option value="25" <?php if($da == 25) echo "selected";?>>25</option>
							<option value="26" <?php if($da == 26) echo "selected";?>>26</option>
							<option value="27" <?php if($da == 27) echo "selected";?>>27</option>
							<option value="28" <?php if($da == 28) echo "selected";?>>28</option>
							<option value="29" <?php if($da == 29) echo "selected";?>>29</option>
							<option value="30" <?php if($da == 30) echo "selected";?>>30</option>
							<option value="31" <?php if($da == 31) echo "selected";?>>31</option>
						</select>
					</div>
					<div style="display: inline-block;width: 30%;">
						<select class="select-css" name="month" id="month">
							<option value="null">Month</option>
							<option value="jan">Januray</option>
							<option value="February">February</option>
							<option value="March">March</option>
							<option value="April">April</option>
							<option value="May">May</option>
							<option value="June">June</option>
							<option value="July">July</option>
							<option value="August">August</option>
							<option value="September">September</option>
							<option value="October">October</option>
							<option value="November">November</option>
							<option value="December">December</option>
						</select>
					</div>
					<div style="display: inline-block;width: 30%;">
						<select class="select-css" name="year" id="year">
							<option value="0">Year</option>
							<option value="2019" <?php if($yr == 2019) echo "selected";?>>2019</option>
							<option value="2018" <?php if($yr == 2018) echo "selected";?>>2018</option>
							<option value="2017" <?php if($yr == 2017) echo "selected";?>>2017</option>
							<option value="2016" <?php if($yr == 2016) echo "selected";?>>2016</option>
							<option value="2015" <?php if($yr == 2015) echo "selected";?>>2015</option>
							<option value="2014" <?php if($yr == 2014) echo "selected";?>>2014</option>
							<option value="2013" <?php if($yr == 2013) echo "selected";?>>2013</option>
							<option value="2012" <?php if($yr == 2012) echo "selected";?>>2012</option>
							<option value="2011" <?php if($yr == 2011) echo "selected";?>>2011</option>
							<option value="2010" <?php if($yr == 2010) echo "selected";?>>2010</option>
							<option value="2009" <?php if($yr == 2009) echo "selected";?>>2009</option>
							<option value="2008" <?php if($yr == 2008) echo "selected";?>>2008</option>
							<option value="2007" <?php if($yr == 2007) echo "selected";?>>2007</option>
							<option value="2006" <?php if($yr == 2006) echo "selected";?>>2006</option>
							<option value="2005" <?php if($yr == 2005) echo "selected";?>>2005</option>
							<option value="2004" <?php if($yr == 2004) echo "selected";?>>2004</option>
							<option value="2003" <?php if($yr == 2003) echo "selected";?>>2003</option>
							<option value="2002" <?php if($yr == 2002) echo "selected";?>>2002</option>
							<option value="2001" <?php if($yr == 2001) echo "selected";?>>2001</option>
							<option value="2000" <?php if($yr == 2000) echo "selected";?>>2000</option>
							<option value="1999" <?php if($yr == 1999) echo "selected";?>>1999</option>
							<option value="1998" <?php if($yr == 1998) echo "selected";?>>1998</option>
							<option value="1997" <?php if($yr == 1997) echo "selected";?>>1997</option>
							<option value="1996" <?php if($yr == 1996) echo "selected";?>>1996</option>
						</select>
						</form>
					</div>
					</div>

					
		</div>

	</div>
	<p id="check"></p>


</body>
</html>