<?php
//include_once('class.php');
//include_once('smtp.php');


//------------------------------Final Code for emailing system. Don't touch.----------------------
//------------------------------------------------------------------------------------------------
function reset_password($email,$actn){
    $msg = "";
    switch ($actn){
        case 'employer':
        //reset
        $key = md5(time());
        $chk = new Sql (DBNAME,"select mail,confirm_no from employer where mail = '$email'");
        $if = $chk->getNumRows();
        if($if>0){
		$rs = $chk->getResult();
		$confirm_no = $rs[1];
		$identifier = substr($confirm_no ,0,1);
            $chk1 = new Sql(DBNAME,"update employer set activation_key='$key' where mail = '$email'");
            $msg = "Please <a href='http://osunjobcenter.org/reset-password.php?email=$email&HJYU=$key&id=$identifier'>Click here </a> to reset your password.\nThis message was sent to ".$email.", if you are receiving this wrongly, please ignore it. Thank you<br> O-Jobs Center Team.";
            $title = "Osun Jobs Center Password Reset Request";
            sendEmail($email,$msg,$title);
             $resp ="<div style='padding:30px; font:calibri;'>
        <div>
        <h4>Password Reset Response.</h4>
        <p>An email has been sent to you,<br/> follow the instruction in the message to <br/><em>reset</em> your password. <br/>Thank you.</p>
        <br/>
        </div>
        
        </div>
        ";
        }else{
            //echo '0';
            //not good
            $resp = "<div>
        <div>
            
        <p><h4>Email Not Found!</h4></p>
        <p>The email you supplied was not found on our system. Please verify the correctness of the email.</p>
        <p>Thank you.</p>
       
        
        </div>
        </div>";
        }
		return $resp;
        break;
        case 'jobseeker':
        //reset
        $key = md5(time());
        $sq = new Sql (DBNAME,"select mails,confirm_no from jobseeker where mails ='$email'");
        $if = $sq->getNumRows();
        if($if>0){
		$r = $sq->getResult();
		$confirm_no = $r[1];
		$identifier = substr($confirm_no ,0,1);
            $sq1 = new Sql(DBNAME,"update jobseeker set activation_key='$key' where mails = '$email'");
            $msg = "Please <a href='http://osunjobcenter.org/u/reset-password.php?email=$email&HJYU=$key&id=$identifier'>Click here </a> to reset your password.\nThis message was sent to ".$email.", if you are receiving this wrongly, please ignore it.<br> Thank you.<br>Osun Jobs Center Team.";
            $title = "Osun Jobs Center Password Reset Request";
            sendEmail($email,$msg,$title);
             $resp ="<div style='padding:30px; font:calibri;'>
             <div>
        <h4>Password Reset Response.</h4>
        <p>An email has been sent to you,<br/> follow the instruction in the message to <br/><em>reset</em> your password. <br/>Thank you.</p>
        <br/>
        </div>
        </div>";
        }else{
            //echo '0';
            //not good
            $resp = "<div>
        <div>
            
        <p><h4>Email Not Found!</h4></p>
        <p>The email you supplied was not found on our system. Please verify the correctness of the email.</p>
        <p>Thank you.</p>
       
        
        </div>
        </div>";
        }
        return $resp;
		break;
    }
    
}
function sendEmail($to,$msg,$title){
    Send_Email($msg,$to,$title);
        //$email = new Email();
        //$email->send($to,$msg,$title);
}
function GetToken($val){
    $chk = new Sql (DBNAME,"select activation_key from jobseeker where mails ='$val'");
    $if = $chk->getNumRows();
    if($if!=0){    
        $r = $chk->getResult();
        return $r[0];
    }else{
        return '0';    
    }    
}










function register_notification($email,$actn){





}
function notify_employer($email){
	$msg = "";
	//switch ($actn){
		
		//case '0':
		//activate -- siguUp
		
		$key = md5(time());
		
		$chk1 = new Sql(DBNAME,"update employer set activation_key='$key' where mail = '$email' and status=0");
		$raw = explode("@",$email);
		
		
		$msg = "<div style='font-size: 14px; font-family: Calibri;'>
		<p>Dear Sir/Ma,<br> Your account registration was successful. Your registration is undergoing screening and a notification shall be sent to you on approval of your account by Osun Jobs Center.</p>
		<p>However, <a target='_blank' href='http://osunjobcenter.org/confirmation_employer.php?email=".$email."&HJYU=".$key."'> Click here </a> to confirm your account.</p>
		<p>This message was sent to ".$email.", if you are receiving this wrongly please ignore it.<\p> 
		<p>Thanks. <br><span>Osun Jobs Center Team.</span></p></div>";
		
        $title = "Osun Jobs Account Confirmation Request";
		sendEmail($email,$msg,$title);
		$resp ='<div style="padding:15px; border:solid 1px #CCC"><span style="padding-bottom:35px; background-image:url(imaging/arrow.png); background-repeat:no-repeat; background-position:bottom left; margin-bottom:25px">
		Thank you for Registering. An email has been sent to '.$email.' for confirmation, please check your Email inbox.<br />
          <br />
          To access your account, please  Sign In. </span></div>
		';
		//echo $msg;
		//break;
	//}
	return $resp;
}


function approve_employer($email){
	$msg = "";
	//switch ($actn){
		
		//case '0':
		//activate -- siguUp
		
		//$key = md5(time());
		
		//$chk1 = new Sql(DBNAME,"update employer set activation_key='$key' where mail = '$email' and status=1");
		//$raw = explode("@",$email);
		
		
		$msg = "<div style='font-size: 14px; font-family: Calibri;'>
		<p>Dear Sir/Ma,<br> Congratulations! Your account has been approved. You can now proceed to signin and start posting jobs.</p>
		<!--<p>However, <a target='_blank' href='http://osunjobcenter.org/u/confirmation_employer.php?email=".$email."&HJYU=".$key."'> Click here </a> to activate your account.</p>-->
		<p>This message was sent to ".$email.", if you are receiving this wrongly please ignore it.<\p> 
		<p>Thanks. <br><span>Osun Jobs Center Team.</span></p></div>";
		
        $title = "Osun Jobs Account Approval Notification";
		sendEmail($email,$msg,$title);
		/*$resp ='<div style="padding:15px; border:solid 1px #CCC"><span style="padding-bottom:35px; background-image:url(imaging/arrow.png); background-repeat:no-repeat; background-position:bottom left; margin-bottom:25px">
		Thank you for Registering. An email has been sent to '.$email.' for activation, please check your Email inbox.<br />
          <br />
          To access your account, please  Sign In. </span></div>
		';
		//echo $msg;
		//break;
	//}
	return $resp;*/
}
function reject_employer($email){
	$msg = "";
	//switch ($actn){
		
		//case '0':
		//activate -- siguUp
		
		//$key = md5(time());
		
		//$chk1 = new Sql(DBNAME,"update employer set activation_key='$key' where mail = '$email' and status=1");
		//$raw = explode("@",$email);
		
		
		$msg = "<div style='font-size: 14px; font-family: Calibri;'>
		<p>Dear Sir/Ma,<br>  Your account has been disapproved. Kindly contact us to get more details.</p>
		<!--<p>However, <a target='_blank' href='http://osunjobcenter.org/u/confirmation_employer.php?email=".$email."&HJYU=".$key."'> Click here </a> to activate your account.</p>-->
		<p>This message was sent to ".$email.", if you are receiving this wrongly please ignore it.<\p> 
		<p>Thanks. <br><span>Osun Jobs Center Team.</span></p></div>";
		
        $title = "Osun Jobs Account Disapproval Notification";
		sendEmail($email,$msg,$title);
		/*$resp ='<div style="padding:15px; border:solid 1px #CCC"><span style="padding-bottom:35px; background-image:url(imaging/arrow.png); background-repeat:no-repeat; background-position:bottom left; margin-bottom:25px">
		Thank you for Registering. An email has been sent to '.$email.' for activation, please check your Email inbox.<br />
          <br />
          To access your account, please  Sign In. </span></div>
		';
		//echo $msg;
		//break;
	//}
	return $resp;*/
}
function CheckUserAction($email){
	$msg = "";
	//switch ($ac){
		
		//case '0':
		//activate -- siguUp
		$tr = GetToken($email);
		if(strlen($tr)>0){
			$key = $tr;
		}else{
			$key = md5(time());
		}
		$chk1 = new Sql(DBNAME,"update jobseeker set activation_key='$key' where mails = '$email' and status=0");
		$raw = explode("@",$email);
		
		
		$msg = "<div style='font-size: 14px; font-family: Calibri;'><p>Please <a target='_blank' href='http://osunjobcenter.org/u/confirmation.php?email=".$email."&HJYU=".$key."'> Click here </a> to  confirm your account.</p>
		<p>This message was sent to ".$email.", if you are receiving this wrongly please ignore it.<\p> 
		<p>Thanks. <br><span>Osun Jobs Center Team.</span></p></div>";
		
        $title = "Osun Jobs Account Confirmation Request";
		sendEmail($email,$msg,$title);
		$resp ='<div style="padding:15px; border:solid 1px #CCC"><span style="padding-bottom:35px; background-image:url(imaging/arrow.png); background-repeat:no-repeat; background-position:bottom left; margin-bottom:25px">
		Thank you for Registering. An email has been sent to '.$email.' for confirmation, please check your Email inbox.<br />
          <br />
          To access your account, please  Sign In. </span></div>
		';
		//echo $msg;
		//break;
	//}
	return $resp;
}
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------

?>