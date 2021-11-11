<?php include('header.php'); ?>
<?php  require "topbar.php";  ?>
<?php //include('links.php');
$id = $_GET['id'];
 $now = date_create('now')->format('Y-m-d H:i:s');
 $currentPrice = "₦";
$query = "SELECT a.auctionId, a.quantity, a.startPrice, a.reservePrice, a.startTime, a.endTime,
a.highestBidderId, i.itemName, i.itemBrand, i.itemDescription,
i.image, cat.categoryName, con.conditionName, u.username as sellerUsername, u.userId as sellerId,  a.views,
FORMAT (AVG(f.score) / 5, 2)*100 as avgSellerFeedbackPercentage, COUNT(f.score) as numFeedbacksForSeller,
COUNT(DISTINCT (auction_watches.watchId)) AS numWatches, COUNT(DISTINCT (bids.bidId)) AS numBids

FROM auctions a JOIN items i ON a.itemId = i.itemId
JOIN bids ON bids.auctionId = a.auctionId
JOIN item_categories cat ON cat.categoryId = i.categoryId
JOIN item_conditions con ON con.conditionId = i.conditionId
JOIN auction_watches ON auction_watches.auctionId = a.auctionId
JOIN users u ON u.userId = i.userId
LEFT JOIN feedbacks f ON f.receiverId = i.userId


WHERE a.auctionId = '$id'";

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
            <!--<h2><span class="fa fa-eye"></span> Info</h2>-->         
            </div>



<section class="my-5" style="padding:2%;">
<?php 
$count = mysqli_num_rows($query);
if($count < 1){
    echo '<div class="alert alert-warning" style="text-align:center; font-weight:bolder; font-size:26px;padding:30px;">No info available for this search</div>';
}else{
    while($row = mysqli_fetch_array($query)){
        $aid = $row['auctionId'];
        $bidsQuery  = mysqli_query($mysqli,"SELECT u.username AS bidderName, u.userId AS bidderId, b.bidTime, b.bidPrice FROM auctions a, bids b, users u 
        WHERE a.auctionId = b.auctionId AND b.userId = u.userId AND a.auctionId = '$aid' ORDER BY b.bidId DESC");

$row2 = mysqli_fetch_array($bidsQuery);
    
 ?>

<!-- main start -->
<div id="container">
<div class="row">
 <!-- item image start -->
 <div class="col-lg-3">
                <img src="../<?php echo $row['image']; ?>" class="img-responsive img-rounded img-fluid img-thumbnail" style="width:200px; height:200px;">
 </div>
 <!-- item image end -->
 <div class="col-xs-9" style="margin-left:4%;">
<div class="row">
<div class="col-lg-12">
<h3 id="live-auction">
                            <?php  echo $row['itemName']; ?> - <?php echo $row['itemBrand']; ?>
                        </h3>
                        <p class="text-info">
                            <i class="fa fa-eye"></i> <strong><?php echo $row['views']; ?> Views </strong> |
                            <i class="fa fa-desktop"></i> <strong><?php echo $row['numWatches']; ?> Watching</strong>
                        </p>

</div>
<div class="col-lg-12">
<div class="row">
<div class="col-lg-6">
<div class="col-xs-3"><p class="p-title"><i class="fa fa-plus-square"></i> Condition: <?php echo $row['conditionName']; ?> </p></div>
                        
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-clock-o"></i> Time Left : <strong><span class="text-danger" id="timer"></span></strong></p></div>
                       
                        <script type="text/javascript">
                        var timerId = "#timer";
                        var endTime = <?php echo json_encode( $row['endTime'] ) ?>;
                        $(timerId).countdown( endTime, function(event) {
                            $(this).text(
                                event.strftime('%D days %H:%M:%S')
                            );
                        });
                    </script>
</div>

<div class="col-lg-6">
                        <div class="col-xs-6">
                            <p class="p-title" style="padding-top:4px;"><i class="fa fa-money"></i>
                                <?php if (empty($row['bidPrice'])) { echo "Starting Bid"; } else { echo "Current Bid"; } ?></p>
                        </div>

                         <div class="col-xs-6">
                         <p class="p-info bid-price" style="margin-top: 0">₦<?php
                                    $bid = null;
                                    if ( empty( $row['bidPrice'] ) ) {
                                        $bid  = $row['startPrice'];
                                        if ( $row['auctionId'] != $_SESSION['id'] ) {
                                            $bid .= "<br><small>Enter ₦" . number_format($row['startPrice']) . " or more</small>";
                                        }
                                    } else {
                                        $bid  = $row['bidPrice'];
                                        if ( $row['auctionId'] != $_SESSION['id'] ) {
                                            $bid .= "<br><small>Enter ₦ " . number_format(($bid + getIncrement($bid))) . " or more</small>";
                                        }
                                    }
                                    echo $bid;
                                    ?></p>
                            </div>
                            <div class="col-xs-12">
                                <p class="p-info text-info" style="padding-top:4px;"><?php echo $row['numBids']; ?> bids</p>
                            </div>
                            
</div>

</div>
</div>


</div>
</div>
<div class="col-lg-12">
<div class="row">
<div class="col-lg-8">

 <div class="move-in">
 <div class="row">
                        <div class="col-xs-3 col-lg-6"><i class="fa fa-shopping-cart"></i> Quantity: <?php echo $row['quantity']; ?></div>
                        
                        <div class="col-xs-3 col-lg-6"><i class="fa fa-tags"></i> Category: <?php echo $row['categoryName']; ?></div>
                        
                        <div class="col-xs-3 col-lg-6"><i class="fa fa-money"></i> Start Price: <?php echo $row['startPrice']; ?></div>
                        
                        <div class="col-xs-3 col-lg-6"><i class="fa fa-calendar-check-o"></i> Start Time: <?php echo $row['startTime']; ?></div>
                
                        <div class="col-xs-3 col-lg-12"><i class="fa fa-list"></i> Description</div>
                        <div class="col-xs-12 col-lg-12"><p class="p-info text-justify"><?php echo $row['itemDescription']; ?></p></div>
                    </div>
                    </div>
</div>

<div class="col-lg-4">
<?php  if ( $row['auctionId'] != $_SESSION['id'] ) { ?>
                                <form id="addbid">
                                    <div class="col-lg-12">
                                        <input type="hidden" name="auctionId" value="<?php echo $row['auctionId']; ?>">
                                        <input type="hidden" name="userId" value="<?php echo $_SESSION['id']; ?>">
                                        <input type="hidden" name="bidP" id="bidP" value="<?php echo $row['startPrice']; ?>">
                                        <div class="form-group">
                                        <input type="text" class="form-control" name="bidPrice" id="bidPrice" maxlength="11" style="height: 30px"
                                           value="" 
                                            ></div>
                                    </div>
                                    <div id="merror"></div>
                                    <div id="error"></div>
                                    <div class="col-xs-4">
                                        <button type="submit" id="btn-submit" class="btn btn-primary" style="height: 30px; padding: 4px 12px">Place Bid</button>
                                    </div>
                                </form>

                            <?php } else { ?>
                                <div class="col-lg-12">
                                    <a href="#">This is your auction</a>
                                </div>
                            <?php }
                            if ( $row['highestBidderId']  == $_SESSION['id']) { ?>
                                <div class="col-lg-12">
                                    <p class="text-success"><i class="fa fa-smile-o"></i> Currently the highest bidder</p>
                                </div>
                            <?php }
                            ?>
                             <div class="panel panel-default" id="seller-info">
                                <div class="panel-body">
                                    <h4>Seller Information</h4>
                                    <p>
                                        <a href="#<?php echo '../views/my_feedbacks_view.php?username=' . $row['sellerUsername']; ?>">
                                            <?php echo $row['sellerUsername']; ?>
                                        </a><br>
                                        <br>
                                    </p>
                                </div>
                            </div>


</div>




</div>
</div>
 


</div><!-- row end -->
</div>
<!-- container end -->



 <?php       
    }
}

?>



</section>

</div>




     
     <script src="js/notification.js"></script>
<?php include('footer.php'); ?>    

   