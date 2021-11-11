<?php require "header.php"; ?>
<?php
 require "topbar.php"; 
 $id = $_SESSION['id'];
 $now = date_create('now')->format('Y-m-d H:i:s');
 
 $currentPrice = "₦";

 if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$no_of_records_per_page = 40;
$offset = ($pageno-1) * $no_of_records_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM auctions  where endTime > now()  ";
$result = mysqli_query($mysqli,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);


$query = "SELECT  auctions.auctionId, quantity, startPrice, reservePrice, startTime,
endTime, itemName, itemBrand, itemDescription, items.image, auctions.views,
item_categories.categoryName as subCategoryName, superCategoryName, auctions.highestBidderId,
item_categories.superCategoryId, item_categories.categoryId,
users.userId, users.firstName, users.lastName, bids.userId AS mbid,
conditionName, countryName, COUNT(DISTINCT (bids.bidId)) AS numBids,
COUNT(DISTINCT (auction_watches.watchId)) AS numWatches,
MAX(bids.bidPrice) AS highestBid, MAX(bids.bidPrice) as currentPrice,
case
    when highestBidderId = '$id' THEN true
    else false
end as isUserWinning

FROM auctions

LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
LEFT OUTER JOIN auction_watches ON auction_watches.auctionId = auctions.auctionId
JOIN items ON items.itemId = auctions.itemId
JOIN users ON items.userId = users.userId
JOIN item_categories ON items.categoryId = item_categories.categoryId
JOIN super_item_categories ON  item_categories.superCategoryId = super_item_categories.superCategoryId
JOIN item_conditions ON items.conditionId = item_conditions.conditionId
JOIN countries ON users.countryId = countries.countryId

WHERE auctions.endTime > now() AND bids.userId='$id' AND auctions.auctionId IN ( SELECT bids.auctionId 
FROM bids where bids.userId = '$id' GROUP BY bids.auctionId) 
GROUP BY  auctions.auctionId,bids.userId
ORDER BY endTime ASC LIMIT $offset, $no_of_records_per_page";

$result = mysqli_query($mysqli, $query);
$setActive = 0;				

?>
		
        
        <div class="pt-5 mx-lg-5">
		

       <?php 
$count = mysqli_num_rows($result);
if($count < 1){
    echo '<div class="alert alert-warning">You have no biddings at the moment</div>';
}else{
    while($row = mysqli_fetch_array($result)){
        $bid = $row['mbid'];
        $uri = $row['image'];
        $aid = $row['auctionId'];
   $qu = mysqli_query($mysqli, "select userId,firstName,lastName,phone,email from users where userId='$bid'");
   $rows = mysqli_fetch_array($qu);     
   //get highest bidder
   $qus = mysqli_query($mysqli, "select MAX(bids.bidPrice) AS highestBid from bids where userId !=' $id' AND auctionId = '$aid'");
   $rowss = mysqli_fetch_array($qus);   
?>

<div class="bg-white row" style="margin-bottom:15px; padding:7px;">

<div class="col-lg-2 col-md-2">
<img src="..<?php echo $uri; ?>" class="img-thumbnail" style="width: 200px; height: 180px;">
</div>
<div class="col-lg-5 col-md-5">
<h2 class="text-info" style="font-weight:bolder;" >
<a href="#"><?php echo $row['itemName']; ?></a>
</h2>
<small>Brand: <?php echo $row['itemBrand']; ?></small>
<p><?php  echo  "Your Current Bid Price: ". $currentPrice.number_format($row['currentPrice']); ?></p>
<h4>Highest Bidding: <?php echo  $currentPrice.number_format($rowss['highestBid']); ?></h4>
<p> 
<i class="fa fa-eye"></i> <?php if($row['views'] != '0' || $row['views'] != '' ) { echo $row['views']; }else{ echo "0";} ?> Views | <i class="fa fa-desktop"></i> <?php echo $row['numWatches']; //$auction->getNumWatches() ?> Watching </p>
<p>Bidding Status: 
<?php if($row['isUserWinning']){ echo '<span class="text-success">User is winning the bid</span>';}else{ echo '<span class="text-success"></span>';} ?></p>
</div>

<div class="col-lg-3 col-md-3">
<?php
                   if($row['endTime'] >= $now){
                        if($row['highestBid'] > $rowss['highestBid']){?>
                            <p class="alert-success" style="padding: 7px 7px; border-radius: 3px;">You are currently the highest bidder!</p> <?php
                        }else{?>
                            <p class="alert-warning" style="padding: 7px 7px; border-radius: 3px;">Outbidded, bid again to win!</p> <?php
                        }
                    }
                    ?>
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


			
		</div>
		
		    <?php include "footer.php"; ?>

    </body>
</html>