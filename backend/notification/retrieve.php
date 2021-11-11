<?php 
require_once('../../includes/functions.php'); 


$output = array('data' => array());


$sql = "SELECT n.notificationId, n.message, n.time, ncat.categoryName, ncat.categoryIcon, u.firstName,u.lastName, u.department,
u.phone, u.email  FROM notifications n LEFT OUTER JOIN notification_categories ncat ON n.categoryId = ncat.categoryId
INNER JOIN users u ON u.userId = n.userId";
$query = $mysqli->query($sql);

$x = 1;
while ($row = $query->fetch_assoc()) {
	$name = $row['lastName'] .' '.$row['firstName'];
	
	$actionButton = '
	<!--<a type="button" data-toggle="modal" data-target="#editMemberModal" class="btn btn-info btn-sm" onclick="editMember('.$row['notificationId'].')"> <span class="glyphicon glyphicon-edit"></span></a>-->
	<a type="button" data-toggle="modal" title="Delete" data-target="#classModal" class="text-danger btn-sm" onclick="removeClass('.$row['notificationId'].')"> <span class="fa fa-trash"></span></a>	    
	
		';

	$output['data'][] = array(
		$x,
		$name,
		$row['department'],
	    $row['email'],
		$row['phone'],
		$row['message'],
		$row['time'],
	    $actionButton
	);

	$x++;
}

// database connection close
$mysqli->close();

echo json_encode($output);