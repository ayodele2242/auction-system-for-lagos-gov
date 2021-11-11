<?php
include('../includes/fetch.php'); 
if(!isset($_SESSION['id'])){
    header('Location: sign-in');
}else{ //Login conditions
 $msgBox = '';
$activeAccount = '';
$nowActive = '';  


$t = date("Y-m-d H:i:s");
$tv = time(); 

$id = $_SESSION['id'];
$user = mysqli_query($mysqli, "select * from users where userId='$id' ");
$d = mysqli_fetch_assoc($user);
$ids = $d['userId'];
$fullname = $d['lastName'] .' '. $d['firstName'];
$uname = $d['username'];
$email = $d['email'];
$pri = $d['privilege'];
$tel = $d['phone'];

$_SESSION['fname'] = $fullname;
$_SESSION['uname'] = $uname;


$neverText = '';



// Logout
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'logout') {
          session_unset();
        session_destroy();
         header('Location: sign-in');
    }
}

		
		
		
		// Get Settings Data
		$setSql = "SELECT * FROM sitesettings";
		$setRes = mysqli_query($mysqli, $setSql) or die('site setting failed'.mysqli_error());
		$set = mysqli_fetch_array($setRes);

		$_SESSION['sch_name'] = $set['company_name'];
		

 //$cookie_name = "page";
//$cookie_value = "$_GET['a']";
//setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day






//get users within 2 month
/*function latestRegisteredUsers()
{
    global $mysqli;
	$sql = "SELECT * FROM alumni_users where status != 'active' AND  date_created >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH) ORDER BY user_id DESC";
	$result=mysqli_query($mysqli, $sql);
	$count = mysqli_num_rows($result);
	if($count < 1){
		echo '<div class="alert alert-warning stas">No latest registered user(s)</div>';
	}else{
		echo '<div class="col-lg-12 col-md-12 stas"  style="background:#fff; padding:10px; margin-bottom:15px;">
		<p style="font-size:16px; padding:10px; margin-bottom: 5px; font-weight: bolder; background:">Registered users which are yet to be activated</p>
		<div class="scrollbar" id="style-3">
		';
		while($row = mysqli_fetch_array($result)){
			$status = $row['status'];



			if($row['status']=='inactive' || $row['status']=='')
			 {
			$sta = '
			<select id=alumni_'.$row['user_id'].' onchange="getalumni(this,'.$row['user_id'].')" class="inactives oks">
				<option value="inactive"  selected >Inactivated</option>
				<option value="active">Activate</option>
				
			</select>
			';
			}elseif($row['status']=='active')
			 {
			$sta  = '
			<select id=alumni_'.$row['user_id'].' onchange="getalumni(this,'.$row['user_id'].')" class="sta-active oks">
				<option value="active"  selected >Activated</option>
				<option value="inactive"  >Inactivate</option>
				
			</select>
			
			';
			 }	
		echo '<div class="col-lg-3 col-md-4" style="margin-bottom:10px;"><a href="user_profile?uid='.$row['user_id'].'">'.$row['last_name'].' '.$row['maiden_name']. ' '.$row['first_name'].'</a></div>
		<div class="col-lg-1 col-md-1" style="margin-bottom:10px;">'.$row['grad_year']. '</div><div class="col-lg-2 col-md-2" style="margin-bottom:10px;">'.$sta.'</div>';
		}
	}

echo '</div></div>';

}*/


//get latest post title 24 hours
function latestPostTitle()
{
    global $mysqli;
	$sql = "SELECT * FROM mp_pages WHERE pdate >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY page_id DESC ";
	$result2 = mysqli_query($mysqli, $sql);
	$count = mysqli_num_rows($result2);
	if($count < 1){
		echo '<div class="alert alert-warning stas">No latest post available</div>';
	}else{
		echo '<div class="col-lg-12 col-md-12 stas"  style="background:#fff; padding:10px; margin-bottom:15px;">
		<p style="font-size:16px; padding:10px; margin-bottom: 5px; font-weight: bolder; background:">Latest Posts. You can only see posts within 24 hours here.</p>
		<div class="scrollbar" id="style-2">
		';
		while($row = mysqli_fetch_array($result2)){
			$status = $row['status'];



			/*if($row['status']=='inactive' || $row['status']=='')
			 {
			$sta = '
			<select id=alumni_'.$row['user_id'].' onchange="getalumni(this,'.$row['user_id'].')" class="inactives oks">
				<option value="inactive"  selected >Inactivated</option>
				<option value="active">Activate</option>
				
			</select>
			';
			}elseif($row['status']=='active')
			 {
			$sta  = '
			<select id=alumni_'.$row['user_id'].' onchange="getalumni(this,'.$row['user_id'].')" class="sta-active oks">
				<option value="active"  selected >Activated</option>
				<option value="inactive"  >Inactivate</option>
				
			</select>
			
			';
			 }	*/
		echo '<div class="col-lg-12 col-md-12" style="margin-bottom:10px;"><a href="readme?id='.$row['page_id'].'">'.$row['page_title'].'</a></div>
		';
		}
	}

echo '</div></div>';

	}	
	









//Get total number of unverified users
function inactiveusers()
{
    global $mysqli;
    $sql =  "SELECT COUNT(*) FROM users, unverified_users WHERE users.userId = unverified_users.userId";
    if ($result=mysqli_query($mysqli, $sql)){
        $row= mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}

//Get total number of verified users
function activeusers()
{
    global $mysqli;
    $sql =  "SELECT COUNT(*) FROM users WHERE userId NOT IN (SELECT userId FROM unverified_users)";
    if ($result=mysqli_query($mysqli, $sql)){
        $row= mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}

//Get total number of auctions
function auctions()
{
    global $mysqli;
    $sql =  "SELECT COUNT(*) FROM auctions";
    if ($result=mysqli_query($mysqli, $sql)){
        $row= mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}

//Get total number of items
function items()
{
    global $mysqli;
    $sql =  "SELECT COUNT(*) FROM items";
    if ($result=mysqli_query($mysqli, $sql)){
        $row= mysqli_fetch_array($result);
        $rowcount = $row[0];
        mysqli_free_result($result);
    }
    return $rowcount;
}

//Get items categories
function getItemCat(){
	global $mysqli;
	$ccsql="SELECT * FROM item_categories";
		$ccsql_run = mysqli_query($mysqli, $ccsql);
		while ($row=mysqli_fetch_array($ccsql_run)) {

			$selected = $_POST['categoryId'] == $row['categoryId'] ? 'selected' : '';
			echo '<option ' . $selected . ' value="' . htmlspecialchars($row['categoryId']) . '">' . htmlspecialchars($row['categoryName']) . '</option>';
	}
}

//Get items condition
function getItemCon(){
	global $mysqli;
	$ccsql="SELECT * FROM item_conditions";
		$ccsql_run = mysqli_query($mysqli, $ccsql);
		while ($row=mysqli_fetch_array($ccsql_run)) {

			$selected = $_POST['conditionId'] == $row['conditionId'] ? 'selected' : '';
			echo '<option ' . $selected . ' value="' . htmlspecialchars($row['conditionId']) . '">' . htmlspecialchars($row['conditionName']) . '</option>';
	}
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



//Get live auctions
if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$no_of_records_per_page = 6;
$offset = ($pageno-1) * $no_of_records_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM auctions  where endTime > now()  ";
$result = mysqli_query($mysqli,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);


$query = "SELECT  auctions.auctionId as auctionId, quantity, startPrice, reservePrice, startTime,
endTime, itemName, itemBrand, itemDescription, views, items.image as image, auctions.views,
item_categories.categoryName as categoryName,
conditionName, startTime > NOW() AS hasStarted

FROM auctions

LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
JOIN items ON items.itemId = auctions.itemId
JOIN users ON items.userId = users.userId
JOIN item_categories ON items.categoryId = item_categories.categoryId
JOIN item_conditions ON items.conditionId = item_conditions.conditionId
JOIN countries ON users.countryId = countries.countryId
WHERE auctions.endTime > now()
GROUP BY auctions.auctionId
ORDER BY    hasStarted DESC, endTime DESC LIMIT $offset, $no_of_records_per_page";
$result = mysqli_query($mysqli, $query);


//Get expired auctions
if (isset($_GET['spageno'])) {
	$spageno = $_GET['spageno'];
} else {
	$spageno = 1;
}
$no_of_records_per_pages = 6;
$offsets = ($spageno-1) * $no_of_records_per_pages;

$total_pages_sqls = "SELECT COUNT(*) FROM auctions  where endTime > now()  ";
$resultss = mysqli_query($mysqli,$total_pages_sqls);
$total_rowss = mysqli_fetch_array($resultss)[0];
$total_pagess = ceil($total_rowss / $no_of_records_per_pages);


$query = "SELECT  auctions.auctionId as auctionId, quantity, startPrice, reservePrice, startTime,
endTime, itemName, itemBrand, itemDescription, views, items.image as image, auctions.views,
item_categories.categoryName as categoryName,
conditionName, startTime <= NOW() AS hasStarted

FROM auctions

LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
JOIN items ON items.itemId = auctions.itemId
JOIN users ON items.userId = users.userId
JOIN item_categories ON items.categoryId = item_categories.categoryId
JOIN item_conditions ON items.conditionId = item_conditions.conditionId
JOIN countries ON users.countryId = countries.countryId
WHERE auctions.endTime < now()
GROUP BY auctions.auctionId
ORDER BY    hasStarted DESC, endTime DESC LIMIT $offsets, $no_of_records_per_pages";

$results = mysqli_query($mysqli, $query);

?>