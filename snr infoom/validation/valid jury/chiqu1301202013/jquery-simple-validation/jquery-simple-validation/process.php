<?php
// author: http://istockphp.com
$fname 		= trim($_POST['fname']); // trim remove white space
$lname 		= trim($_POST['lname']);
$email 		= trim($_POST['email']);
$password 	= trim($_POST['password']);
$phone 		= trim($_POST['phone']);
$birth 		= $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
$gender 	= $_POST['gender'];
// do something. mysql_query
//header("Location: index.php");
//exit();
?>