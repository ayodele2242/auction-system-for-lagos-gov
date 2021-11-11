<?php
//session_start();
require_once "../includes/functions.php";
//require_once "../../global/php/encrypt.php";


//if(isset($_POST['regme']))
//{
	$lname = clean($_POST['lname']);
	$fname = clean($_POST['fname']);
	$email = clean($_POST['email']);
	$username = clean($_POST['uname']);
	$password = encryptIt($_POST['pass']);
	$userType = "bidder";
	$sta = 'active';

	// check if entered username is in the database
	$result = mysqli_query($mysqli,"SELECT username, email from users where username = '$username' or email = '$email' ");
	if(mysqli_num_rows($result) > 0){
	   	echo "Username/Email address already in use";
	}
	
	else{

		$query = mysqli_query($mysqli,"insert into users(username, email, firstName, lastName, password,status, user_category)
		values('$username', '$email', '$fname', '$lname', '$password', '$sta', '$userType')");

		if($query){
			echo "registered";
		}else{
			echo "Error occured: ". $mysqli->error;
		}
		
		

	}


	//}

?>