<?php 
require_once('../../config/configs.php'); 


$output = array('data' => array());
$snam = $_SESSION['fname'];

$sql = "SELECT * FROM users WHERE user_category = 'auctioner'";
$query = $mysqli->query($sql);

$x = 1;
while ($row = $query->fetch_assoc()) {

	//$status = $row['status'];

    $img = '<img src="..'.$row['image'].'" class="img-thumbnail img-responsive">';


	if($row['status']=='inactive' || $row['status']=='')
	 {
	$sta = '
	<select id=code1_'.$row['userId'].' onchange="getcode1(this,'.$row['userId'].')" class="inactives oks">
		<option value="inactive"  selected>De-activated</option>
		<option value="active">Activate</option>
	</select>
	';
	}elseif($row['status']=='active')
	 {
	$sta  = '
	<select id=code1_'.$row['userId'].' onchange="getcode1(this,'.$row['userId'].')" class="sta-active oks">
		<option value="active"  selected>Activated</option>
		<option value="inactive">De-activate</option>
	</select>
	
	';
	 }
	
$name  = $row['lname'] .' '. $row['fname'];
$actionButton = '
<a href="auction_view?id='.$row['userId'].'" class="btn btn-info btn-md" > <span class="fa fa-eye"></span></a>	    
	';
	
	$output['data'][] = array(
		$x,
		$name,
        $row['department'],
        $row['username'],
        $row['email'],
		$row['phone'],
		$row['city'],
		$row['address'],
		$sta
		
		
	);

	$x++;
}

// database connection close
$mysqli->close();

echo json_encode($output);