<?php include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php //include('links.php'); 

/*$query2 = "SELECT  auctions.auctionId as auctionId, quantity, startPrice, reservePrice, startTime,
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
$results = mysqli_query($mysqli, $query2);
$chart_data = '';
while($rowy = mysqli_fetch_array($results))
{
 $chart_data .= "{ itemName:'".$rowy["itemName"]."', startPrice:".$rowy["startPrice"].", endTime:".$rowy["endTime"].", views:".$rowy["views"]."}, ";
}
$chart_data = substr($chart_data, 0, -2);*/
?>


   
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h1><span>Dashboard</span></h1>         
            </div>

<div class="screen">
<!-- Widgets -->
<div >
<div class="clearfix row">
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                    <div class="info-box bg-orange pills-deep-purple">
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="members">
                        <div class="content">
                            <div class="text">Unverified Users</div>
                            <div class="number"><?php echo inactiveusers(); ?></div>
                        </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink ">
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="post">
                        <div class="content">
                            <div class="text">Verified Users</div>
                            <div class="number count-to"><?php echo activeusers(); ?></div>
                        </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green">
                        <div class="icon">
                        <i class="fa fa-gavel"></i>
                        </div>
                        <a href="comments">
                        <div class="content">
                            <div class="text">Total Auctions</div>
                            <div class="number count-to"><?php echo auctions(); ?></div>
                        </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="fa fa-assistive-listening-systems "></i>
                        </div>
                        <div class="content">
                            <div class="text">Total Items</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo items(); ?></div>
                        </div>
                    </div>
                </div>

               
            
            </div>
            <!-- #END# Widgets -->

<section class="text-center my-5">
<div class="row">

</div>
</section>



<section class="text-center my-5 rgba-lime-strong"  style="overflow:hidden;">
<div class="row">
<div class="col-lg-12 text-success" style="font-weight:bolder; font-size:27px;" >Live Auctions</div>
<?php
$countlive = mysqli_num_rows($result);
if($countlive < 1){
echo '<div class="alert alert-danger">No Live Auction Available at the Moment</div>';
}else{
				while( $row = mysqli_fetch_assoc($result)){	
                        $uri = $row['image'];
                        $uri = ltrim($uri, '/');	
                        ?>
					<div class="col-sm" id="auction<?php echo $row['auctionId'] ?>" >
                        <div style="text-align:center;max-height:22%;">
                                    <div class=" recommendations">
                                        <a href="<?php echo $row['auctionId']; ?>" >
                                        <img src="../<?php echo $uri; ?>" class="img-thumbnail" style="width: 200px; height: 180px;">
                                        </a>
                                    </div>
                                    <h5 class="text-danger" style="font-weight:bolder;"><span id="timer<?php echo $row['auctionId'] ?>"></span> left</h5>
   <script type="text/javascript">
    var timerId = "#timer" + <?php echo json_encode($row['auctionId']) ?>;
    var endTime = <?php echo json_encode($row['endTime']) ?>;
    $(timerId).countdown( endTime )
        .on('update.countdown', function(event) {
            $(this).html(
                event.strftime('%D days %H:%M:%S')
            );
        })
        .on('finish.countdown', function(event) {
            $("#auction" + <?php echo json_encode($row['auctionId']) ?>).remove();
        });
     </script>
                                    <div class="caption">
                                        <h5 class="text-info" style="font-weight:bolder;" >
                                            <a href="#">
                                            <?php echo $row['itemName']; ?><br>
                                                <small><?php echo $row['itemBrand']; ?></small>
                                            </a>
                                        </h5>
                                        <h5>
                                            <strong style="color:#000;">
                                                ₦<?php echo number_format($row['startPrice']); ?>  | <i class="fa fa-eye"></i> Views(<?php if($row['views'] != '0') { echo $row['views']; }else{ echo "0";} ?>)


                                            </strong>
                                        </h5>
                                    </div>
                                </div>

                        </div>

                        
                  <?php      				
                    }
                }
					?>			

 
 <div class="col-lg-12">
    <ul class="pagination pg-blue">
        <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
            <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
            <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
	</div>
</div><!--#end row-->

 
</section><!--#END section-->


<section class="text-center my-5 rgba-orange-light" style="overflow:hidden;">
<div class="row">
<div class="col-lg-12 text-danger" style="font-weight:bolder; font-size:27px; " >Expired Auctions</div>
<?php
$countlives = mysqli_num_rows($results);
if($countlives < 1){
echo '<div class="alert alert-danger">No Expired Auctions Available at the Moment</div>';
}else{
				while( $rows = mysqli_fetch_assoc($results)){	
                         $uri = $rows['image'];
                         $uri = ltrim($uri, '/');	
                        ?>
					<div class="col-sm" id="auction<?php echo $rows['auctionId'] ?>" >
                        <div style="text-align:center;max-height:22%;">
                                    <div class=" recommendations">
                                        <a href="<?php echo $rows['auctionId']; ?>" >
                                        <img src="../<?php echo $uri; ?>" class="img-thumbnail" style="width: 200px; height: 180px;">
                                        </a>
                                    </div>
                                   <span style="color:#a1887f; font-weight:bolder; font-size:16px;">Expired</span> 
   
                                    <div class="caption">
                                        <h5 class="text-info" style="font-weight:bolder;" >
                                            <a href="#">
                                            <?php echo $rows['itemName']; ?><br>
                                                <small><?php echo $rows['itemBrand']; ?></small>
                                            </a>
                                        </h5>
                                        <h5>
                                            <strong style="color:#000;">
                                                ₦<?php echo number_format($rows['startPrice']); ?>  | <i class="fa fa-eye"></i> Views(<?php if($rows['views'] != '0') { echo $rows['views']; }else{ echo "0";} ?>)


                                            </strong>
                                        </h5>
                                    </div>
                                </div>

                        </div>

                        
                  <?php      				
                    }
                }
					?>			

 
 <div class="col-lg-12">
    <ul class="pagination pg-blue">
        <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
            <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
            <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
	</div>
</div><!--#end row-->

 
</section><!--#END section-->

        <div class="clearfix">
        <div class="alert bg-orange">
        <?php
        $user_os        = getOS();
        $user_browser   = getBrowser();

$device_details = "<strong>Browser: </strong>".$user_browser."<br /><strong>Operating System: </strong>".$user_os."";

print_r($device_details);

echo("<br />".$_SERVER['HTTP_USER_AGENT']."");



?>
        </div>
        </div>

        </div>




<?php include('footer.php'); ?>    

   