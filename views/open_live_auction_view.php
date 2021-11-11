<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.helper_operator.php";
require_once "../scripts/user_session.php";
require_once "../classes/class.auction.php";
require_once "../classes/class.bid.php";
require_once "../classes/class.advanced_auction.php";
require_once "../classes/class.db_auction.php";
require_once "../classes/class.db_item.php";
require_once "../classes/class.db_bid.php";
require_once "../classes/class.db_auction_watch.php";


$auctionId = null;

if ( isset( $_GET[ "liveAuction" ] ) )
{

    $auctionId = $_GET[ "liveAuction" ];
}
else
{
    HelperOperator::redirectTo( "search_view.php" );
}


// to send the user back to the correct page (depending if the got here by search page or watch list)
$refer = array(null, null);
if(isset(  $_GET["o"])){
    $refer = array($_GET["o"]);
    switch ($refer[0]){
        case "search_view.php":
            $refer[] = "Back to Search Results";
            break;
        case "my_watch_list_view.php":
            $refer[] = "Back to My Watched Auctions";
            break;
        case "my_current_bids_view.php":
            $refer[] =  "Back to My Current Bids";
            break;
        case "my_successful_bids_view.php":
            $refer[] =  "Back to My Won Auctions";
            break;
        case "my_unsuccessful_bids_view.php":
            $refer[] =  "Back to My Lost Auctions";
            break;
    }

}

$auction = QueryOperator::getLiveAuction($auctionId);
$bids = QueryOperator::getAuctionBids($auction->getAuctionId());

$watches = QueryOperator::getAuctionWatches($auction->getAuctionId());

$isMyAuction = $auction -> getSellerUsername() == SessionOperator::getUser() -> getUsername();

//increment num_views of auction on database
$dbAuction = DbAuction::find($auctionId);
$dbAuction->setField("views", $dbAuction->getField("views") +1);
$dbAuction->save();

//increment views displayed on page
$views = $auction -> getViews() +1;

//is user watching this auction
$user= SessionOperator::getUser();
$alreadyWatching = DbAuctionWatch::withConditions("WHERE userId = ".$user->getUserId(). " AND auctionId =".$auctionId)->exists();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $auction -> getItemName() . " | E-Auction" ?></title>

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="../css/animate.css" rel="stylesheet" type="text/css">
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-notify.min.js"></script>
    <script src="../js/metisMenu.min.js"></script>
    <script src="../js/sb-admin-2.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <script src="../js/jquery.countdown.min.js"></script>
    <script src="../js/custom/search.js"></script>
    <script src="../js/custom/live_auction.js"></script>

</head>

<body>
<!-- display feedback (if available) start -->
<?php require_once "../includes/notification.php" ?>
<!-- display feedback (if available) end -->


<div id="wrapper">

    <!-- navigation start -->
    <?php include_once "../includes/navigation.php" ?>
    <!-- navigation end -->


    <!-- main start -->
    <div id="page-wrapper">

        <!-- back start -->
        <div class="row">
            <?php if ( !empty( $refer ) ) : ?>
                <div class="col-xs-12" id="go-back-navigation">
                    <a href="<?=$refer[0]?>" class="btn btn-primary"><i class="fa fa-chevron-left"></i></a>
                    <a href="<?=$refer[0]?>"> <?=$refer[1]?></a>
                </div>
            <?php endif ?>
        </div>
        <!-- back end -->


        <!-- display item related input errors (if available) start -->
        <?php if ( ( $error = SessionOperator::getInputErrors( "bidPrice" ) ) != null ) :  ?>
            <div class="alert alert-danger fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Input error!</strong> <?= $error ?>
            </div>
        <?php endif ?>
        <!-- display item related input errors (if available) end -->


        <!-- live auction start -->
        <div class="row">

            <!-- item image start -->
            <div class="col-xs-3">
                <img src="../<?= $auction->getImage() ?>" class="img-responsive img-rounded">
            </div>
            <!-- item image end -->

            <!-- auction info start -->
            <div class="col-xs-9">

                <div class="row">
                    <div class="col-xs-12">
                        <h3 id="live-auction">
                            <?= $auction -> getItemName() ?> - <?= $auction -> getItemBrand() ?>
                        </h3>
                        <p class="text-info">
                            <i class="fa fa-eye"></i> <strong>Views <?= $views ?></strong> |
                            <i class="fa fa-desktop"></i> <strong>Watching <?= $watches ?></strong>
                        </p>
                    </div>
                </div><hr id="live-auction">

                <div class="row">
                    <div class="move-in">
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-plus-square"></i> Condition</p></div>
                        <div class="col-xs-9"><p class="p-info"><?= $auction -> getConditionName() ?></p></div>
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-clock-o"></i> Time Left</p></div>
                        <div class="col-xs-9"><p class="p-info"><strong><span class="text-danger" id="timer"></span></strong></p></div>
                    </div>
                    <script type="text/javascript">
                        var timerId = "#timer";
                        var endTime = <?= json_encode( $auction -> getEndTime() ) ?>;
                        $(timerId).countdown( endTime, function(event) {
                            $(this).text(
                                event.strftime('%D days %H:%M:%S')
                            );
                        });
                    </script>

                    <div class="col-xs-12" id="bid-box">
                        <div class="col-xs-3">
                            <p class="p-title" style="padding-top:4px;"><i class="fa fa-money"></i>
                                <?php if ( empty( $bids ) ) { echo "Starting Bid"; } else { echo "Current Bid"; } ?></p>
                        </div>

                        <div class="col-xs-5">
                            <div class="col-xs-8"><p class="p-info bid-price" style="margin-top: 0">₦
                                    <?php
                                    $bid = null;
                                    if ( empty( $bids ) ) {
                                        $bid  = $auction -> getStartPrice();
                                        if ( !$isMyAuction ) {
                                            $bid .= "<br><small>Enter ₦" . $auction->getStartPrice() . " or more</small>";
                                        }
                                    } else {
                                        $bid  = $bids[ 0 ] -> getBidPrice();
                                        if( !$isMyAuction ) {
                                            $bid .= "<br><small>Enter ₦ " . ($bid + HelperOperator::getIncrement($bid)) . " or more</small>";
                                        }
                                    }
                                    echo $bid
                                    ?></p>
                            </div>
                            <div class="col-xs-4">
                                <p class="p-info text-info" style="padding-top:4px;"><?= count( $bids ) ?> bids</p>
                            </div>
                            <?php if( !$isMyAuction ) { ?>
                                <form method="GET" action="../scripts/place_bid.php">
                                    <div class="col-xs-8">
                                        <input type="hidden" name="auctionId" value="<?= $auction -> getAuctionId() ?>">
                                        <input type="text" class="form-control" name="bidPrice" maxlength="11" style="height: 30px"
                                            <?php echo 'value = "' . SessionOperator::getFormInput( "bidPrice" ) . '"'; ?> ><br>
                                    </div>
                                    <div class="col-xs-4">
                                        <button type="submit" class="btn btn-primary" style="height: 30px; padding: 4px 12px">Place Bid</button>
                                    </div>
                                </form>

                                <div class="col-xs-12">
                                    <?php

                                    if(!$alreadyWatching){
                                        $href = '"../scripts/create_watch.php?'.$_SERVER['QUERY_STRING'].'"';
                                        echo '<a href='.$href.'><i class="fa fa-eye"></i> Add to watch list</a>';
                                    }else{
                                        echo "<a class=\"text-success\" href=\"my_watch_list_view.php#auction{$auction -> getAuctionId()}\"><i class=\"fa fa-eye\"></i> Watching</a>";
                                    }
                                    ?>

                                </div>
                            <?php } else { ?>
                                <div class="col-xs-12">
                                    <a href="my_live_auctions_view.php#auction<?= $auction -> getAuctionId() ?>">This is your auction</a>
                                </div>
                            <?php }
                            if ( $auction -> getHighestBidderId() == $user -> getUserId() ) { ?>
                                <div class="col-xs-12">
                                    <p class="text-success"><i class="fa fa-smile-o"></i> Currently the highest bidder</p>
                                </div>
                            <?php }
                            ?>
                        </div>

                        <div class="col-xs-4">
                            <div class="panel panel-default" id="seller-info">
                                <div class="panel-body">
                                    <h4>Seller Information</h4>
                                    <p>
                                        <a href="<?php echo '../views/my_feedbacks_view.php?username=' . $auction -> getSellerUsername() ?>">
                                            <?= $auction -> getSellerUsername() ?>
                                        </a><br>
                                        <a href="<?php echo '../views/my_feedbacks_view.php?username=' . $auction -> getSellerUsername() ?>">
                                            <?php if ($auction->getAvgSellerFeedbackPercentage() != null){?>
                                                <?=$auction->getAvgSellerFeedbackPercentage()."% Posotive Feedback" ?>

                                            <?php } ?>
                                        </a><br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="move-in">
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-shopping-cart"></i> Quantity</p></div>
                        <div class="col-xs-9"><p class="p-info"><?= $auction -> getQuantity() ?></p></div>
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-tags"></i> Category</p></div>
                        <div class="col-xs-9"><p class="p-info"><?= $auction -> getCategoryName() ?></p></div>
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-money"></i> Start Price</p></div>
                        <div class="col-xs-9"><p class="p-info"><?= $auction -> getStartPrice() ?></p></div>
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-calendar-check-o"></i> Start Time</p></div>
                        <div class="col-xs-9"><p class="p-info"><?= date_create( $auction -> getStartTime() ) -> format( 'd-m-Y h:i' ) ?></p></div>
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-list"></i> Description</p></div>
                        <div class="col-xs-9"><p class="p-info text-justify"><?= $auction -> getItemDescription() ?></p></div>
                    </div>
                </div>

            </div>
            <!-- live auction end -->

        </div>
        <!-- main end -->


        <!-- footer start -->
        <div class="footer">
            <div class="container">
            </div>
        </div>
        <!-- footer end -->

    </div>
    <!-- main end -->


</div>
<!-- /#wrapper -->

</body>

</html>