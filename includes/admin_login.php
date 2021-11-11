<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}includes{$ds}functions.php");

#require_once '../includes/functions.php';

	if(isset($_POST['btn-login']))
	{
		
		$username = $mysqli->real_escape_string($_POST['username']);
		$user_password = encryptIt($_POST['password']);
		
		$password = $user_password;
		
			$stmt = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$username' OR email='$username' OR phone='$username' AND password='$password'");
			$row = mysqli_fetch_array($stmt);
			
			
			if($row['password']==$password AND  $row['username']==$username || $row['email']==$username || $row['phone']==$username AND $row['isAdmin']=='1' AND $row['status'] == 'active'){
				
				echo "yes"; // log in
				
				//$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
                
				$_SESSION['id'] = $row['userId'];
				$d = $_SESSION['id'];
                $uname  = $row['username'];
				$fname  = $row['lastName'] .' '. $row['firstName'];
				$act = 'login';
				$t = date("Y-m-d H:i:s");
				$tv = time();

                mysqli_query($mysqli, "insert into user_log (username,name,action,time, user_id, mydate, mtime)values('$uname','$fname','$act', '$tv', '$d', '$t', '$tv')");
				
                mysqli_query($mysqli, "UPDATE users SET lastVisited = '$t', timeVisited = '$tv' WHERE userId = '$d'");
				
			}
			else if ($row['password']==$password AND $row['username']==$username || $row['email']==$username || $row['phone']==$username  AND $row['status'] == 'suspended') {
                // If the account is not suspended, show a message
                echo "s";
             } else if ($row['password']==$password AND  $row['username']==$username || $row['email']==$username || $row['phone']==$username AND $row['status'] == 'inactive') {
                // If the account is not active, show a message
                echo "i";
                }
				else {
                    // No account found
                    echo "Invalid login details entered.";
                
     }
							
		
	}

?>