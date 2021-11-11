<?php
 error_reporting(0);
#echo $_SERVER['DOCUMENT_ROOT']."/config/config.php";
#require_once "classes/class.session_operator.php" ;
#require_once "classes/class.query_operator.php" ;
#require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once "config/config.php";
require_once "includes/functions.php";
require_once "includes/sitedetails.php";

if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} 

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
$setActive = 0;				


?>


<!DOCTYPE html>
<html>

<head>
    <title><?php echo $set['siteName']; ?> </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>" type="image/x-icon">
    <!-- Font -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">

    <!-- CSS -->
    <link href="theme/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-select.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="theme/css/mdb.min.css" rel="stylesheet">
    <link href="theme/css/style.css" rel="stylesheet">
 
    <!-- JS -->
    <!--<script src="js/bootstrap.min.js"></script>-->
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
     <script src="js/bootstrap-notify.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/custom/search.js"></script>
    <!--<script src="js/custom/live_auction.js"></script>-->
   
    
    <!--<link href="css/main.css" rel="stylesheet">-->

    <style>
.carousel-inner{
    > .item{
      transition: 500ms ease-in-out left;
    }
    .active{
      &.left{
        left:-33%;
      }
      &.right{
        left:33%;
      }
    }
    .next{
      left: 33%;
    }
    .prev{
      left: -33%;
    }
    @media all and (transform-3d), (-webkit-transform-3d) {
      > .item{
        // use your favourite prefixer here
        transition: 500ms ease-in-out left;
        transition: 500ms ease-in-out all;
        backface-visibility: visible;
        transform: none!important;
      }
    }
  }
  .carouse-control{
    &.left, &.right{
      background-image: none;
    }
  }

  .text-danger{
      color: #f0a;
  }
.error,#error{
    color:#CC0000;
    font-weight:bolder;
}
        </style>

<script>
var fade_out = function() {
  $(".removeMessages").fadeOut().empty();
}
setTimeout(fade_out, 10000);
</script>
</head>

<body>
  


    <!-- header start -->
    <!-- header logo start -->
    <?php include_once "includes/header.php";?>
            <!-- header logo end -->
    <!-- header end -->

    <!-- main START -->
<div class="container" style="margin-top:120px;">
<div class="row">

<section class="my-5" >
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
                <img src="<?php echo $set['installUrl'].$row['image']; ?>" class="img-responsive img-rounded img-fluid img-thumbnail" style="width:300px; height:200px;">
 </div>
 <!-- item image end -->
 <div class="col-lg-8" style="margin-left:4%;">
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
                        
                        <div class="col-xs-3 col-lg-6"><i class="fa fa-money"></i> Start Price: <?php echo number_format($row['startPrice']); ?></div>
                        
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
                                        <input type="hidden" name="bidP" id="bidP" value="<?php echo number_format($row['startPrice']); ?>">
                                        <div class="alert alert-danger">
                                        You need to log in before you can bid for this item.
                                        </div>
                                    </div>
                                    
                                </form>

                            <?php } else { ?>
                                <div class="col-lg-12">
                                    <a href="#">This is your auction</a>
                                </div>
                            
                            <?php }
                            ?>
                             <div class="panel panel-default" id="seller-info">
                                <div class="panel-body">
                                    <h4>Seller:  <?php echo $row['sellerUsername']; ?></h4>
                                   
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
</div>




    <!-- footer start -->
    <?php include_once "includes/footer.php";?>
   
    <!-- footer end -->
    <script src="js/register.js"></script>	
</body>
</html>
