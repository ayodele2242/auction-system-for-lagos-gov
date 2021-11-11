<?php  
 include('../config/configs.php');  
$id = $_GET['id'];
 $sel =   mysqli_query($mysqli,"select itemName, clearance from items where itemId = '$id'");
while ($row = mysqli_fetch_array($sel)){
 ?>
<?php echo $row['itemName']; ?>
 <img src="..<?php echo $row['clearance']; ?>">

 <?php } ?>