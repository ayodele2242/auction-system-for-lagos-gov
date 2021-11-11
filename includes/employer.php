<?php 
include('../includes/functions.php'); 
if(!isset($_SESSION['id'])){
    header("Location: ../login?'".randnumber()."'&Error=Sign In details required");
}else{
$id = $_SESSION['id'];
$user = mysqli_query($mysqli, "select * from alumni_users where user_id='$id' ");
$detail = mysqli_fetch_assoc($user);
$_SESSION['name'] = $detail['last_name'] .' '. $detail['first_name'];


$email = $detail['email'];
$_SESSION['email'] =  $detail['email'];
$_SESSION['class'] =  $detail['grad_year'];

//User's details
$userFullName =$detail['last_name'] .' '. $detail['first_name'];




}//Else ends here

// Get Settings Data
$setSql = "SELECT * FROM sitesettings";
$setRes = mysqli_query($mysqli, $setSql) or die('site setting failed'.mysqli_error());
$set = mysqli_fetch_array($setRes);


// Logout
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'logout') {
        session_destroy();
        header("Location: ../login?'".randnumber()."'&Action=Signed Out");
    }
}


if (isset($_POST['submit']) && $_POST['submit'] == 'editPwd') {

    $id = $_SESSION['id'];
    $password = $_POST['old_password'];
    $newpassword = $_POST['new_password'];
    $confirmnewpassword = $_POST['con_newpassword'];

    // match user id with the id in the database
    $sql = "SELECT password FROM  alumni_users WHERE user_id = '$id'";

    $get = mysqli_query($mysqli, $sql);
    $pw = mysqli_fetch_assoc($get);

    if(empty($_POST['old_password'])){
        $msgBox = alertBox( "Please type your current password", "<i class='fa fa-warning'></i>", "warning");
           
    }else if(empty($newpassword) || empty($confirmnewpassword)){
        $msgBox = alertBox( "Enter your new password and confirmed password", "<i class='fa fa-warning'></i>", "warning");
           
    }else if($pw["password"] != encryptIt($password)){
        $msgBox = alertBox("Current password is wrong. Try again. ", "<i class='fa fa-warning'></i>", "warning");   
    }
    else if($pw["password"] == encryptIt($newpassword)){
        $msgBox = alertBox( "Your new password is the same as the current one. Enter something else.", "<i class='fa fa-warning'></i>", "warning");
           
    }else if(strlen($newpassword) < 8){
        $msgBox = alertBox("Password must be 8 characters in length ", "<i class='fa fa-warning'></i>", "warning");
           
    }else{
        $ps =  encryptIt($newpassword);
        $sql = "UPDATE alumni_users SET password = '$ps' WHERE user_id = '$id'";
        $let = mysqli_query($mysqli, $sql);
     if($let){
        $msgBox = alertBox( "Password Changed Successfully!", "<i class='fa  fa-check-square'></i>", "success");
        }else{
            $msgBox = alertBox( "Password could not be updated. ".  $mysqli->error, "<i class='fa fa-warning'></i>", "warning");
        }
    }

}   


    

?>