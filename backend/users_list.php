<?php include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php //include('links.php');

$query = "select ";

$query = mysqli_query($mysqli, $query);

?>
  <style>
.col-xs-3,.col-xs-2{
    padding: 9px;
}
  </style>
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h2><span class="fa fa-users"></span> Auctioneers</h2>        
            </div>



<section class="my-5" >
<table id="uTable" class="table table-striped uTable ref">
<thead>
<tr>
<th>#ID</th>
<th>Image</th>
<th>Name</th>
<th>Department</th>
<th>Username</th>
<th>Email</th>
<th>Phone</th>
<th>City</th>
<th>Address</th>
<th>Status</th>

</tr>
</thead>

<tbody>
<?php  
$sql = "SELECT * FROM users WHERE user_category = 'auctioner'";
$query = $mysqli->query($sql);

$x = 1;
while ($row = $query->fetch_assoc()) {

	//$status = $row['status'];

    $img = '<img src="..'.$row['image'].'" class="img-thumbnail img-responsive" style="width:50px; height:50px;">';


	if($row['status']=='inactive' || $row['status']=='')
	 {
	$sta = '
	<select id=ucode1_'.$row['userId'].' onchange="ugetcode1(this,'.$row['userId'].')" class="inactives oks">
		<option value="inactive"  selected>De-activated</option>
		<option value="active">Activate</option>
	</select>
	';
	}elseif($row['status']=='active')
	 {
	$sta  = '<select id=ucode1_'.$row['userId'].' onchange="ugetcode1(this,'.$row['userId'].')" class="sta-active oks" >
		<option value="active"  selected>Activated</option>
		<option value="inactive">De-activate</option>
	</select>';
	 }
	
$name  = $row['lastName'] .' '. $row['firstName'];
$actionButton = '
<a href="auction_view?id='.$row['userId'].'" class="btn btn-info btn-md" > <span class="fa fa-eye"></span></a>	    
	';

?>
<tr>
<td><?php echo $x; ?></td>
<td><?php echo $img; ?></td>
<td><?php echo $name; ?></td>
<td><?php echo $row['department']; ?></td>
<td><?php echo $row['username']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['city']; ?></td>
<td><?php echo $row['address']; ?></td>
<td><?php echo $sta; ?></td>

</tr>
<?php
$x++;
}
?>
</tbody>
</table>



</section>

</div>




  <!--<script src="js/user.js"></script> -->    
    
<?php include('footer.php'); ?>    

   