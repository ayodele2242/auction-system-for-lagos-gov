<?php include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php 
//include('links.php');
$currentPrice = "₦";

$query = "SELECT  auctions.auctionId, quantity, startPrice, reservePrice, startTime,
endTime, itemName, itemBrand, itemDescription, items.image, auctions.views,
item_categories.categoryName as subCategoryName, superCategoryName,auctions.highestBidderId,
item_categories.superCategoryId, item_categories.categoryId, users.username as sellerUsername,
conditionName, countryName, COUNT( DISTINCT (bids.bidId)) AS numBids,
COUNT(DISTINCT (auction_watches.watchId)) AS numWatches, COUNT( DISTINCT(sentFeedbackOn.username)) AS hasSellerFeedback,
MAX(bids.bidPrice) AS highestBid, MAX(bids.bidPrice)as currentPrice,
1 as sold

FROM auctions

LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
LEFT OUTER JOIN auction_watches ON auction_watches.auctionId = auctions.auctionId
JOIN items ON items.itemId = auctions.itemId
JOIN users ON items.userId = users.userId
JOIN item_categories ON items.categoryId = item_categories.categoryId
JOIN super_item_categories ON  item_categories.superCategoryId = super_item_categories.superCategoryId
JOIN item_conditions ON items.conditionId = item_conditions.conditionId
JOIN countries ON users.countryId = countries.countryId
LEFT JOIN feedbacks ON creatorId = feedbacks.creatorId AND feedbacks.auctionId = auctions.auctionId
LEFT JOIN users AS sentFeedbackOn ON feedbacks.receiverId = sentFeedbackOn.userId


WHERE auctions.endTime < now() AND auctions.highestBidderId = auctions.highestBidderId
AND auctions.auctionId IN ( SELECT bids.auctionId FROM bids where bids.userId = bids.userId GROUP BY bids.auctionId)

GROUP BY  auctions.auctionId

HAVING MAX(bids.bidPrice) > reservePrice

ORDER BY endTime ASC";

$result = mysqli_query($mysqli, $query);
?>
  <style>
.col-xs-3,.col-xs-2{
    padding: 9px;
}
  </style>
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h1><span>All Won Biddings </span></h1>         
            </div>



<section class="my-5" >

<?php 
$count = mysqli_num_rows($result);
if($count < 1){
    echo '<div class="alert alert-warning">No won biddings at the moment</div>';
}else{
    while($row = mysqli_fetch_array($result)){
        $uri = $row['image'];
        $mid = $row['highestBidderId'];
$s = mysqli_query($mysqli,"select firstName,lastName,phone,email from users where userId = '$mid'");
$rows = mysqli_fetch_array($s);
?>
<div class="row">
<div class="col-lg-2 col-md-2">
<img src="..<?php echo $uri; ?>" class="img-thumbnail" style="width: 200px; height: 180px;">
</div>
<div class="col-lg-5 col-md-5">
<h2 class="text-info" style="font-weight:bolder;" >
<a href="#"><?php echo $row['itemName']; ?> (Seller name: <?php echo $row['sellerUsername']; ?>)</a>
</h2>
<small>Brand: <?php echo $row['itemBrand']; ?></small>
<p><?php  echo  "Current Price: ". $currentPrice.number_format($row['currentPrice']); ?></p>
<h4>Highest Bidding: <?php echo number_format($row['highestBid']); ?></h4>
<p> 
<i class="fa fa-eye"></i> <?php if($row['views'] != '0' || $row['views'] != '' ) { echo $row['views']; }else{ echo "0";} ?> Views | <i class="fa fa-desktop"></i> <?php echo $row['numWatches']; //$auction->getNumWatches() ?> Watching </p>
</div>

<div class="col-lg-3 col-md-3">
<p><strong style="font-size:26px; font-weight:bolder;" class="text-info">Winner's Details:</strong></p>
<?php if($mid == $_SESSION['id']){ ?>
    <p ><h4 style="font-weight:bolder; color:green;"><?php echo "You won this auction"; ?></h4></p>
<?php }else{ ?>
<p><?php echo $rows['lastName'] .' '. $rows['firstName']; ?></p>
<?php } ?>
<p>Phone Number: <?php echo  $rows['phone']; ?></p>
<p>Email: <?php echo  $rows['email']; ?></p>
</div>


</div>
<?php
    }
}
?>
</section>

               

        </div>
     

<?php include('footer.php'); ?>    

   