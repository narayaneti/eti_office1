<?php
include('../myproject/security.php');
if(isset($_POST['email']))
{
	require('../myproject/mydb.php');
	$email=validate($_POST['email'],50,$con);
	$qry="SELECT * FROM `madical_register` WHERE `email`='$email'";
	$result=mysqli_query($con,$qry);
	if(mysqli_num_rows($result) > 0)
{
	echo 'yes';
}
else
{
	
}
}
?>