<?php require "header.php"; ?>
<?php
 require "topbar.php"; 

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


$query = "SELECT  auctions.auctionId as auctionId, quantity, startPrice, reservePrice, startTime,
endTime, itemName, itemBrand, itemDescription, items.image as image, auctions.views,
item_categories.categoryName as categoryName,
conditionName, startTime <= NOW() AS hasStarted

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

$result = mysqli_query($mysqli, $query);
$setActive = 0;				

?>
		
        
        <div class="pt-5 mx-lg-5">
		

			<section class="">



				<!--<span><span class="text"><span class="line">AN <strong>AUCTIONING WEBSITE</strong></span></span></span>-->
			</section>

			<section class="main-content" >
			
			<div class="row ">
		<div class="col-lg-3"><!--col-lg-3 -->

		
		</div><!--#END col-lg-3 -->
		<div class="col-lg-8"><!--col-lg-8 -->
       <div class="col-lg-12 row">
       <?php 		
				while( $row = mysqli_fetch_assoc($result)){	
						$activeClass = "";			
						if(!$setActive) {
							$setActive = 1;
							$activeClass = 'active';						
                        }	
                         $uri = $row['image'];
                        $uri = ltrim($uri, '/');	
                        ?>

						

						<div class="col-xs-6" id="auction<?php echo $row['auctionId'] ?>" >
                        <div style="text-align:center;max-height:22%;">
                                    <div class=" recommendations">
                                        <a href="../views/open_live_auction_view.php?liveAuction=<?php echo $row['auctionId'] ?>">
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
                                        <h5 class="text-info"style="font-weight:bolder;" >
                                            <a href="../views/open_live_auction_view.php?liveAuction=<?php echo $row['auctionId'] ?>">
                                            <?php echo $row['itemName']; ?><br>
                                                <small><?php echo $row['itemBrand']; ?></small>
                                            </a>
                                        </h5>
                                        <h5>
                                            <strong>
                                                ₦<?php echo number_format($row['startPrice']); ?> 


                                            </strong> <br>
                                            <a href="../views/open_live_auction_view.php?liveAuction=<?php echo $row['auctionId'] ?>"
                                            class="btn btn-info">Bid
    </a>
                                        </h5>
                                    </div>
                                </div>

                        </div>

                        
                  <?php      				
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


       <div class="col-lg-12"></div>


		</div><!--#END col-lg-8 -->

			</div>	

			</section>
			
		</div>
		
		    <?php include "footer.php"; ?>

    </body>
</html>