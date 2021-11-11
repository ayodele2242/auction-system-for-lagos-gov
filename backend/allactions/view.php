<?php

if(isset($_POST["post_id"]))
{
    include('../../includes/functions.php');

 $query = "SELECT * FROM tbl_courier WHERE cid = '".$_POST["post_id"]."'";
 $result = mysqli_query($mysqli, $query);
 if(!$result){
     echo "Error occured: ".$mysqli->error;
 }else{
 while($row = mysqli_fetch_array($result))
 {
?>
<div class="alert alert-default">
<div class="col-lg-12" style="font-size:16px; color:#000; font-weight:bolder;">
Consignment Code: <?php echo $row['cons_no'];  ?>
</div>
<div class="col-lg-12" >
<table class="table table_view">

<tbody>
<tr>
<td col="3" style="font-size:16px; font-weight:bolder;">Sender Info  </td>
</tr>
<tr>
<td>Name</td>
<td><?php echo $row['ship_name'];  ?></td>
</tr>
<tr>
<td>Phone Number</td>
<td><?php echo $row['phone'];  ?></td>
</tr>
<tr>
<td>Address</td>
<td><?php echo $row['s_add'];  ?></td>
</tr>

<tr>
<td col="3" style="font-size:16px; font-weight:bolder;">Reciver Info  </td>
</tr>
<tr>
<td>Name</td>
<td><?php echo $row['rev_name'];  ?></td>
</tr>
<tr>
<td>Phone Number</td>
<td><?php echo $row['r_phone'];  ?></td>
</tr>
<tr>
<td>Address</td>
<td><?php echo $row['r_add'];  ?></td>
</tr>
<tr>

<tr>
<td col="3" style="font-size:16px; font-weight:bolder;">Region  </td>
</tr>
<tr>
<td>City</td>
<td><?php echo $row['city'];  ?></td>
</tr>
<tr>
<td>Country</td>
<td><?php echo $row['country'];  ?></td>
</tr>

<tr>
<td col="3" style="font-size:16px; font-weight:bolder;">Shipment Info  </td>
</tr>
<tr>
<td>Percel Type</td>
<td><?php echo $row['product_type'];  ?></td>
</tr>
<tr>
<td>Shipment Type</td>
<td><?php echo $row['type'];  ?></td>
</tr>
<tr>
<td>Weight</td>
<td><?php echo $row['weight'];  ?>Kg</td>
</tr>
<tr>
<td>Quantity</td>
<td><?php echo $row['qty'];  ?></td>
</tr>

<tr>
<td col="3" style="font-size:16px; font-weight:bolder;">Booking Info  </td>
</tr>

<tr>

<td><b>Amount Paid:</b> &nbsp; &nbsp; <span style="text-style:double-striped">N</span><?php echo number_format($row['freight']); ?></td>
<td><b>In Word:</b>  &nbsp; &nbsp;<?php echo convert_number_to_words($row['freight']);  ?> naira</td>
</tr>
<tr>
<?php
if($row['comments'] != ''){
?>
<tr>
<td col="3" style="font-size:16px; font-weight:bolder;">Comment  </td>
</tr>
<tr>
<td col="4">
<?php echo $row['comments'];  ?>
</td>

</tr>
 <?php } ?>




</tbody>

</thead>


</table>
</div>




     
</div>     
<?php  
}
}
    
}
?>

