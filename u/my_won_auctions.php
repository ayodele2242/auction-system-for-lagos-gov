<?php require "header.php"; ?>
<?php
 require "topbar.php"; 

$mid = $_SESSION['id']; 
 if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$no_of_records_per_page = 40;
$offset = ($pageno-1) * $no_of_records_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM auctions  where endTime < now() AND auctions.highestBidderId = '$mid'  ";
$result = mysqli_query($mysqli,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);


$query = "SELECT  auctions.auctionId, quantity, startPrice, reservePrice, startTime,
endTime, itemName, itemBrand, itemDescription, items.image, auctions.views,
item_categories.categoryName as subCategoryName, superCategoryName,
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
LEFT JOIN feedbacks ON creatorId = '$mid' AND feedbacks.auctionId = auctions.auctionId
LEFT JOIN users AS sentFeedbackOn ON feedbacks.receiverId = sentFeedbackOn.userId


WHERE auctions.endTime < now() AND auctions.highestBidderId = '$mid'
AND auctions.auctionId IN ( SELECT bids.auctionId FROM bids where bids.userId = '$mid' GROUP BY bids.auctionId)

GROUP BY  auctions.auctionId

HAVING MAX(bids.bidPrice) > reservePrice

ORDER BY endTime ASC LIMIT $offset, $no_of_records_per_page";

$result = mysqli_query($mysqli, $query);
$count = mysqli_num_rows($result);
$setActive = 0;				

?>
		
        
        <div class="pt-5 mx-lg-5">

   

			<section class="main-content" >
			
			<div class="row ">

            <?php if($count < 1){  ?>
<div class="col-lg-12 alert alert-warning">You have not won any action</div>
<?php }else{ ?>

       <div class="col-lg-12 text-center row ">
       <?php 		
				while( $row = mysqli_fetch_assoc($result)){	
				
                         $uri = $row['image'];
                        $uri = ltrim($uri, '/');	
                        ?>
<div class="row">
<div class="col-lg-3">
<div class=" recommendations">
<a href="../views/open_live_auction_view.php?liveAuction=<?php echo $row['auctionId'] ?>">
<img src="../<?php echo $uri; ?>" class="img-thumbnail" style="width: 200px; height: 180px;">
</a>
</div>
</div><!--#END col-lg-3 -->

<div class="col-lg-8">
<div class="col-lg-12 alert alert-info" tyle="font-weight:bolder; font-size:23px;"><?php echo $row['itemName'];  ?></div>
<table class="table table-responsive table-striped">
<tr>
<td>Brand</td>
<td><?php echo  $row['itemBrand']; ?></td>
<td>Category</td>
<td><?php echo  $row['categoryName']; ?></td>
<td>Condition</td>
<td><?php echo  $row['conditionName']; ?></td>

</tr>
<tr>
<td colspan="15">
<?php echo  $row['itemDescription']; ?>
</td>

</tr>


</table>
</div><!--#END col-lg-8 -->

</div>
						


 
 
 <?php } ?>

												
	  

		</div><!--#END col-lg-8 -->


<?php } ?>

			</div>	

			</section>
               
			
		</div>
		
		    <?php include "footer.php"; ?>

    </body>
</html>