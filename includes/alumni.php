<?php
include('../includes/alumni-fetch.php'); 
if(!isset($_SESSION['id'])){
    header('Location: sign-in');
}else{ //Login conditions
 $msgBox = '';
$activeAccount = '';
$nowActive = '';  
$t = date("Y-m-d H:i:s");
$tv = time(); 

$id = $_SESSION['id'];
$user = mysqli_query($mysqli, "select * from users where user_id='$id' ");
$d = mysqli_fetch_assoc($user);
$ids = $d['user_id'];
$fullname = $d['last_name'] .' '. $d['first_name'];
$uname = $d['user_name'];
$email = $d['email'];
//$pri = $d['privilege'];
$tel = $d['cell_phone'];

$_SESSION['fname'] = $fullname;
$_SESSION['uname'] = $uname;


$neverText = '';





//Redirect to previous page
if(isset($_GET['a']) /*you can validate the link here*/){
    $_SESSION['link']=$_GET['a'];
 }
 
 
       
		
		
		// Get Settings Data
		$setSql = "SELECT * FROM sitesettings";
		$setRes = mysqli_query($mysqli, $setSql) or die('site setting failed'.mysqli_error());
		$set = mysqli_fetch_array($setRes);

		$_SESSION['sch_name'] = $set['school_name'];
		

 //$cookie_name = "page";
//$cookie_value = "$_GET['a']";
//setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

//Expire the session if user is inactive for 30
//minutes or more.
$expireAfter = 30;
 //Check to see if our "last action" session
//variable has been set.
if(isset($_SESSION['last_action'])){
    //Figure out how many seconds have passed
    //since the user was last active.
    $secondsInactive = time() - $_SESSION['last_action'];
     //Convert our minutes into seconds.
    $expireAfterSeconds = $expireAfter * 60;
     //Check to see if they have been inactive for too long.
    if($secondsInactive >= $expireAfterSeconds){
        //User has been inactive for too long.
        //Kill their session.
		$act = 'user session destroyed';
			
        session_unset();
        session_destroy();
        header("Location: sign-in");
		
		 mysqli_query($mysqli, "insert into user_log (username,name,action,time, user_id, mydate, mtime)values('$uname','$fullname','$act', '$tv', '$id', '$t', '$tv')");
   }
}
//Assign the current timestamp as the user's
//latest activity
$_SESSION['last_action'] = time();




//Get total number of admin users
function adminUsers()
{
    global $mysqli;
    $sql = "SELECT COUNT(*) FROM users";
    if ($result=mysqli_query($mysqli, $sql)){
        $row= mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}

//Get total number of graduates
function graduates()
{
    global $mysqli;
    $sql = "SELECT COUNT(*) FROM jobseeker WHERE confirm_no LIKE 'G%'";
    if ($result=mysqli_query($mysqli, $sql)){
        $row= mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}


//Get total number of artisans
function artisans()
{
    global $mysqli;
    $sql = "SELECT COUNT(*) FROM jobseeker WHERE confirm_no LIKE 'A%'";
    if ($result=mysqli_query($mysqli, $sql)){
        $row= mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}


//Get total number of employers
function employers()
{
    global $mysqli;
    $sql = "SELECT COUNT(*) FROM employer";
    if ($result=mysqli_query($mysqli, $sql)){
        $row= mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}

	// Settings Data
	
	if ($set['allowRegistrations'] == '1') { $allowRegistrations = 'selected'; } else { $allowRegistrations = ''; }
	if ($set['enableWeather'] == '1') {
		$enableWeather = 'selected';
		$set['enableWeather'] = '1';
	} else {
		$enableWeather = '';
		$set['enableWeather'] = '0';
	}
	if ($set['enableCalendar'] == '1') {
		$enableCalendar = 'selected';
		$set['enableCalendar'] = '1';
	} else {
		$enableCalendar = '';
		$set['enableCalendar'] = '0';
	}
	
	if ($set['localization'] == 'ar') { $ar = 'selected'; } else { $ar = ''; }
	if ($set['localization'] == 'bg') { $bg = 'selected'; } else { $bg = ''; }
	if ($set['localization'] == 'ce') { $ce = 'selected'; } else { $ce = ''; }
	if ($set['localization'] == 'cs') { $cs = 'selected'; } else { $cs = ''; }
	if ($set['localization'] == 'da') { $da = 'selected'; } else { $da = ''; }
	if ($set['localization'] == 'en') { $en = 'selected'; } else { $en = ''; }
	if ($set['localization'] == 'en-ca') { $en_ca = 'selected'; } else { $en_ca = ''; }
	if ($set['localization'] == 'en-gb') { $en_gb = 'selected'; } else { $en_gb = ''; }
	if ($set['localization'] == 'es') { $es = 'selected'; } else { $es = ''; }
	if ($set['localization'] == 'fr') { $fr = 'selected'; } else { $fr = ''; }
	if ($set['localization'] == 'ge') { $ge = 'selected'; } else { $ge = ''; }
	if ($set['localization'] == 'hr') { $hr = 'selected'; } else { $hr = ''; }
	if ($set['localization'] == 'hu') { $hu = 'selected'; } else { $hu = ''; }
	if ($set['localization'] == 'hy') { $hy = 'selected'; } else { $hy = ''; }
	if ($set['localization'] == 'id') { $id = 'selected'; } else { $id = ''; }
	if ($set['localization'] == 'it') { $it = 'selected'; } else { $it = ''; }
	if ($set['localization'] == 'ja') { $ja = 'selected'; } else { $ja = ''; }
	if ($set['localization'] == 'ko') { $ko = 'selected'; } else { $ko = ''; }
	if ($set['localization'] == 'nl') { $nl = 'selected'; } else { $nl = ''; }
	if ($set['localization'] == 'pt') { $pt = 'selected'; } else { $pt = ''; }
	if ($set['localization'] == 'ro') { $ro = 'selected'; } else { $ro = ''; }
	if ($set['localization'] == 'sv') { $sv = 'selected'; } else { $sv = ''; }
	if ($set['localization'] == 'th') { $th = 'selected'; } else { $th = ''; }
	if ($set['localization'] == 'vi') { $vi = 'selected'; } else { $vi = ''; }
	if ($set['localization'] == 'yue') { $yue = 'selected'; } else { $yue = ''; }



// Edit Account
	if (isset($_POST['submit']) && $_POST['submit'] == 'editProfile') {
		if($_POST['userFirst'] == "") {
            $msgBox = alertBox($yourFisrtNameReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['userLast'] == "") {
            $msgBox = alertBox($yourLastNameReq, "<i class='fa fa-times-circle'></i>", "danger");
        } else if($_POST['userEmail'] == "") {
            $msgBox = alertBox($yourEmailReq, "<i class='fa fa-times-circle'></i>", "danger");
		} else if($_POST['passwordNew'] != $_POST['passwordRepeat']) {
			$msgBox = alertBox($passwordsNotMatchMsg, "<i class='fa fa-warning'></i>", "warning");
		} else {
			if($_POST['currentPass'] != '') {
				$currPass = encryptIt($_POST['currentPass']);
			} else {
				$currPass = '';
			}
			
			if($_POST['currentPass'] == '') {
				$userFirst = $mysqli->real_escape_string($_POST['userFirst']);
				$userLast = $mysqli->real_escape_string($_POST['userLast']);
				$userEmail = $mysqli->real_escape_string($_POST['userEmail']);
				$newPassword = $_POST['passwordOld'];
				if ($set['enableWeather'] == '1') {
					$weatherLoc = $mysqli->real_escape_string($_POST['weatherLoc']);
				} else {
					$weatherLoc = '';
				}
				
				// Update the $_SESSION variables
				$_SESSION["userFirst"]	= $userFirst;
				$_SESSION["userLast"] 	= $userLast;
				$_SESSION["userEmail"] 	= $userEmail;
				$_SESSION["weatherLoc"] = $weatherLoc;

				$stmt = $mysqli->prepare("UPDATE
											users
										SET
											userEmail = ?,
											password = ?,
											userFirst = ?,
											userLast = ?,
											weatherLoc = ?
										WHERE
											userId = ?"
				);
				$stmt->bind_param('ssssss',
									$userEmail,
									$newPassword,
									$userFirst,
									$userLast,
									$weatherLoc,
									$userId
				);
				$stmt->execute();
				$msgBox = alertBox($accountProfileUpdatedMsg, "<i class='fa fa-check-square'></i>", "success");
				$stmt->close();
			} else if ($_POST['currentPass'] != '' && encryptIt($_POST['currentPass']) == $_POST['passwordOld']) {
				$newPassword = encryptIt($_POST['passwordNew']);
				$userFirst = $mysqli->real_escape_string($_POST['userFirst']);
				$userLast = $mysqli->real_escape_string($_POST['userLast']);
				$userEmail = $mysqli->real_escape_string($_POST['userEmail']);
				if ($set['enableWeather'] == '1') {
					$weatherLoc = $mysqli->real_escape_string($_POST['weatherLoc']);
				} else {
					$weatherLoc = '';
				}
				
				// Update the $_SESSION variables
				$_SESSION["userFirst"]	= $userFirst;
				$_SESSION["userLast"] 	= $userLast;
				$_SESSION["userEmail"] 	= $userEmail;
				$_SESSION["weatherLoc"] = $weatherLoc;

				$stmt = $mysqli->prepare("UPDATE
											users
										SET
											userEmail = ?,
											password = ?,
											userFirst = ?,
											userLast = ?,
											weatherLoc = ?
										WHERE
											userId = ?"
				);
				$stmt->bind_param('ssssss',
									$userEmail,
									$newPassword,
									$userFirst,
									$userLast,
									$weatherLoc,
									$userId
				);
				$stmt->execute();
				$msgBox = alertBox($accountProfileUpdatedMsg, "<i class='fa fa-check-square'></i>", "success");
				$stmt->close();
			} else {
				$msgBox = alertBox($currentPassError, "<i class='fa fa-warning'></i>", "warning");
			}
		}
	}



}//Login conditions end 



?>