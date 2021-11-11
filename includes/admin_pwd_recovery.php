<?php
	require_once '../includes/fetch.php';

    if(isset($_POST['reset']))
{
	$userEmail_address = $mysqli->real_escape_string($_POST['email']);
	$sql="SELECT count(*) as total FROM users WHERE userEmail = '$userEmail_address'";
	$result=mysqli_query($mysqli, $sql);
	$row=mysqli_fetch_array($result);
	
	if($row['total'] != 0)
	{

	$sql="SELECT *  FROM users WHERE userEmail = '$userEmail_address'";
	$result=mysqli_query($mysqli, $sql);
	$row=mysqli_fetch_assoc($result);
	$name = $row['userLast'] .'  ' . $row['userFirst'];
    
   		$newpassword = rand(100000,10000000);
		$storepassword =  encryptIt($newpassword);
		
		$sql = "UPDATE users SET password = '$storepassword' WHERE userEmail = '$userEmail_address'";
		$result = mysqli_query($mysqli, $sql);
		

		$to = $userEmail_address;
		$site_name = $set['school_name'];
		$subject = 'Password Successfully Changed';
		$link = $set['siteEmail'];
		
		$from_mail = $site_name.'<'.$link.'>';
		
		$message = "";
        $message .= '<html><body><div style="width:100%; background:rgba(255,0,0,0.1); padding:2px;">
        <p style="text-align:center; padding:1px;"> <img src="https://osunjobcenter.org/imaging/banner.png"/></p>
		<p style="color:#842A2A; padding:6px; font-weight:bolder;"><span>'.strtoupper($name).'</span></p>
		
		<p>You have successfully changed you password. Please do find your new password below.</p>
		<p><span>New Password: <b>'.$newpassword.'</b></span></p>
		<p>For security purpose, change your password when you log in to your account.</p>
		<p></p>
		<p></p>
		<p></p>
		<p><b>'.$set['school_name'].'</b></p>
		</div></body></html>';
		
		$from = $from_mail;
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();	
		
		if(@mail($to, $subject, $message, $headers))
		{
			echo "sent";
		}
		else
		{
			echo "e";
		}		
	}
	else
	{
		echo "There is no user with this email address.";
	}
}
?>