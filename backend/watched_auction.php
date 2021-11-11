<?php 
error_reporting(0);
include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php //include('links.php'); 
        //get watched Auctions
        //watchIds belonging to user _it was found this was alot faster than a subquery in the other query
        $now = date_create('now')->format('Y-m-d H:i:s');
        $currentPrice = "₦";
        $query = "SELECT auction_watches.watchId
                  FROM auctions JOIN auction_watches ON auctions.auctionId = auction_watches.auctionId
                  WHERE auction_watches.userId = auction_watches.userId";
        $getid = mysqli_query($mysqli, $query);

        while ($row = $getid->fetch_assoc()){
            $watchedIds = $row["watchId"];
        }
        if($watchedIds ==0 ){ //empty
            return array();
        }
        $watchedIds =  $watchedIds;

        $query2 = "SELECT auctions.auctionId, quantity, startPrice, reservePrice, startTime,
        endTime, itemName, itemBrand, itemDescription, items.image as image, auctions.views,
        item_categories.categoryName as subCategoryName, superCategoryName,
        item_categories.superCategoryId, item_categories.categoryId, users.username as sellerUsername, 
        users.firstName as fname, users.lastName as lname, users.email as email, users.phone as phone, 
         users.address as address, users.city as city, 
        conditionName, countryName, auction_watches.watchId, COUNT(DISTINCT (bids.bidId)) AS numBids,
        MAX(bids.bidPrice) AS highestBid,  COUNT(DISTINCT (auction_watches.watchId)) AS numWatches,
        case
            when MAX(bids.bidPrice) is not null THEN MAX(bids.bidPrice)
            else startPrice
        end as currentPrice,
        case
            when MAX(bids.bidPrice) > auctions.reservePrice AND auctions.endTime < now() then 1
            else 0
        end as sold
        FROM auctions
            LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
            JOIN auction_watches ON auction_watches.auctionId = auctions.auctionId
            JOIN items ON items.itemId = auctions.itemId
            JOIN users ON items.userId = users.userId
            JOIN item_categories ON items.categoryId = item_categories.categoryId
            JOIN super_item_categories ON  item_categories.superCategoryId = super_item_categories.superCategoryId
            JOIN item_conditions ON items.conditionId = item_conditions.conditionId
            JOIN countries ON users.countryId = countries.countryId

        WHERE auction_watches.watchId IN( '$watchedIds' )

        GROUP BY auctions.auctionId, quantity, startPrice, reservePrice, startTime,
        endTime, itemName, itemBrand, itemDescription, items.image, auctions.views,
         subCategoryName, superCategoryName,
        item_categories.superCategoryId, item_categories.categoryId, sellerUsername,
        conditionName, countryName, auction_watches.watchId 

        ORDER BY CASE WHEN auctions.endTime > now() THEN 0 ELSE 1 END ASC, auctions.endTime ASC
        ";

        $gall = mysqli_query($mysqli, $query2);

        ?>
  <style>
.col-xs-3,.col-xs-2{
    padding: 9px;
}
  </style>
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h1><span>List of Watched Auctions  </span></h1>         
            </div>



<section class="my-5">
<div class="row">
<?php
$count = mysqli_num_rows($gall);
if($count < 1){
    echo '<div class="alert alert-warning">No user watching any item at the moment' . $watchedIds.'</div>';
}else{

while($row = mysqli_fetch_array($gall)){
    $uri = $row['image'];

   // $sele = mysqli_query($mysqli,"select * from bids where ")

?>

<div class="row" id="auction<?php echo $row['auctionId'] ?>" style="margin-bottom:12px; padding:6px;">

<div class="col-sm">
    <img src="..<?php echo $uri; ?>" class="img-thumbnail" style="width: 200px; height: 180px;">
</div>
    <div class="col-sm">
    <div class="caption">
                                        <h2 class="text-info" style="font-weight:bolder;" >
                                            <a href="#">
                                            <?php echo $row['itemName']; ?><br>
                                               
                                            </a>
                                        </h2>
                                        <?php
                                        if($row['endTime'] >  $now) {
                                         ?>
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

                                        <?php
                                        }else{
                                            echo '<span style="font-weight:bolder; font-size:24px;color:#3E4551;">Expired</span>';
                                        }
                                        ?>

                                        <small>Brand: <?php echo $row['itemBrand']; ?></small>
                                        <h4>
                                        <?php
                                        
                                        if($row['sold'] == 1){
                                            echo "<span class='text-success'>SOLD FOR " . number_format($row['currentPrice']) . "</span>";
                                        } else if($row['endTime'] < $now) {
                                            echo "<span class='text-danger'>UNSOLD - LAST PRICE " . number_format($row['currentPrice']) . "</span>";
                                        } else {
                                            echo $currentPrice;
                                        }

                                         ?>
                                        </h4>
                                        <h5><?php 
                                        if($row['numBids'] == 0){
                                            echo '<strong class="text-danger">This item has no bid at the moment</stong>';
                                        }else{
                                        echo $row['numBids'].  " Bids";
                                        }
                                        ?></h5>
                                        <h5>
                                            <strong style="color:#000;">
                                                <?php
                                                
                                                if ( empty( $row['highestBid'] ) ) {
                               echo  "Start Price: ". $currentPrice.number_format($row['startPrice']);
                            } else {
                                echo "Highest Bid: ".$currentPrice.number_format($row['highestBid']);
                            }
                                  
                            ?>
                                                | 
                                                
                                                <i class="fa fa-eye"></i> <?php if($row['views'] != '0') { echo $row['views']; }else{ echo "0";} ?> Views | 
                                                <i class="fa fa-desktop"></i> <?php echo $row['numWatches']; //$auction->getNumWatches() ?> Watching 
                                            </strong>
                                        </h5>
                                    </div>
    </div>
    <div class="col-sm">
    <div class="row text-center">
    <div class="col-md-12 blue-gradient" style="padding:9px; text-align:center; font-size:18px; margin-bottom:10px;">
Seller Details
    </div>

    <div class="col-md-12" style="padding:9px; text-align:center; font-size:28px; margin-bottom:10px;">
    <?php echo $row['lname'] .' '. $row['fname']; ?>

    </div>

        <div class="col-md-4">
          <a class="btn-floating blue accent-1">
            <i class="fa fa-map-marker"></i>
          </a>
          <p><?php if(!empty($row['address'])){ echo $row['address']; }
          else{
              echo "Address not available";
          } ?></p>
          <p class="mb-md-0"><?php echo $row['city']; ?></p>
        </div>
        <div class="col-md-4">
          <a class="btn-floating blue accent-1">
            <i class="fa fa-phone"></i>
          </a>
          <p><?php if(!empty($row['phone'])){ echo $row['phone']; }
          else{
              echo "Phone number not available";
          } ?></p>
         
        </div>
        <div class="col-md-4">
          <a class="btn-floating blue accent-1">
            <i class="fa fa-envelope"></i>
          </a>
          <p><?php if(!empty($row['email'])){ echo $row['email']; }
          else{
              echo "Email not available";
          } ?></p>
          
        </div>
      </div>

    </div>
    <!-- Grid column -->
    </div>



</div>
</div>
<?php
}
}
?>

</div>
</section>

               

</div>
     

<?php include('footer.php'); ?>    

   