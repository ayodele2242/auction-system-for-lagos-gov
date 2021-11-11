<?php 
require_once('../../includes/functions.php'); 


$output = array('data' => array());
$snam = $_SESSION['fname'];

$sql = "SELECT  auctions.auctionId as auctionId, quantity, startPrice, reservePrice, startTime,
endTime, itemName, itemBrand, itemDescription, views, items.image as image, auctions.views, items.clearance as clearance_image,items.itemId as itemid,
item_categories.categoryName as categoryName, conditionName, startTime <= NOW() AS hasStarted, users.userId, 
users.firstName as fname, users.lastName as lname, users.email as email, users.phone as phone, 
users.address as address, users.city as city, users.image as img, auctions.status as status, users.verified as verified,
users.isAdmin as admin
FROM auctions LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
JOIN items ON items.itemId = auctions.itemId
JOIN users ON items.userId = users.userId
JOIN item_categories ON items.categoryId = item_categories.categoryId
JOIN item_conditions ON items.conditionId = item_conditions.conditionId
JOIN countries ON users.countryId = countries.countryId
GROUP BY auctions.auctionId";
$query = $mysqli->query($sql);

$x = 1;
while ($row = $query->fetch_assoc()) {

	$status = $row['status'];

	$now = date_create('now')->format('Y-m-d H:i:s');

	if($row['endTime'] >= $now){
		$tstatus = '<span  class="text-success" style="font-weight:bolder;"><i class="fa fa-thumbs-up"></i> Still On</span>';
	}else{
		$tstatus = '<span  class="text-danger" style="font-weight:bolder;"><i class="fa fa-thumbs-down"></i> Expired</span>';
	}

	$img = '<img src="..'.$row['image'].'" class="img-thumbnail img-responsive">';

	if($row['clearance_image'] != ''){
	$cimg = '<a href="select?id='. $row["itemid"].'" target= "_blank" id="'. $row["itemid"].'" class="view_data"><img src="..'.$row['clearance_image'].'" class="img-thumbnail img-responsive"></a>';
}else{
	$cimg = "";
}
	
	



	if($row['status']=='inactive' || $row['status']=='')
	 {
	$sta = '
	<select id=code1_'.$row['auctionId'].' onchange="getcode1(this,'.$row['auctionId'].')" class="inactives oks">
		<option value="inactive"  selected>Inactivated</option>
		<option value="active">Activate</option>
	</select>
	';
	}elseif($row['status']=='active')
	 {
	$sta  = '
	<select id=code1_'.$row['auctionId'].' onchange="getcode1(this,'.$row['auctionId'].')" class="sta-active oks">
		<option value="active"  selected>Activated</option>
		<option value="inactive">Inactivate</option>
	</select>
	
	';
	 }
	

$actionButton = '
<a href="auction_view?id='.$row['auctionId'].'" class="btn btn-info btn-md" > <span class="fa fa-eye"></span></a>	    
	';
	
	$output['data'][] = array(
		$x,
		$img,
		$cimg,
		$row['lname'],
		$row['fname'],
		$row['phone'],
		$row['email'],
		$row['address'],
		$row['city'],
		$row['itemName'],
		$row['itemBrand'],
		number_format($row['startPrice']),
		number_format($row['reservePrice']),
		$row['views'],
		$tstatus,
		$sta,
		$actionButton
		
		
	);

	$x++;
}

// database connection close
$mysqli->close();

echo json_encode($output);