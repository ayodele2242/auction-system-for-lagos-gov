 <?php
require_once('../../includes/functions.php'); 

$mode=$_POST['mode'];
$pid=$_POST['id'];
if ($mode=='true') //mode is true when button is enabled 
{
	$str=$mysqli->query("update portal_user_login SET status='active' where id=$pid");
    $message='User is enableed!!';
    $success='Enabled';
    echo json_encode(array('message'=>$message,'$success'=>$success));
}

else if ($mode=='false') 
{
	$str=$mysqli->query("update portal_user_login SET status='inactive' where id=$pid");
    $message='User is disabled!!';
    $success='Disabled';
    echo json_encode(array('message'=>$message,'success'=>$success));

} 
 ?>