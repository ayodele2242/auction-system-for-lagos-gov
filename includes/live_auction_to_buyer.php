<?php
require_once "../classes/class.auction.php";
require_once "../classes/class.bid.php";
require_once "../classes/class.advanced_auction.php";
#require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}config{$ds}config.php");


/* @var Auction $auction */
/* @var String $origin */


$refer = "&o=".basename($_SERVER["REQUEST_URI"]);
$stillAlive = new DateTime($auction->getEndTime(), new DateTimeZone( TIMEZONE )) > new DateTime( "now", new DateTimeZone( TIMEZONE ));
?>

<div class="row" style="padding-right: 15px" id="auction<?= $auction -> getAuctionId() ?>">
    <div class="col-xs-12 live-auction-to-buyer">

        <div class="col-xs-3 auction-img">
            <img src="..<?= $auction->getImage() ?>" class="img-responsive" style="height:150px">
        </div>

        <div class="col-xs-9 auction-info">

            <div class="row">
                <div class="<?php if ($origin == "won" ){echo "col-xs-6";}else{ echo "col-xs-8";}?>">
                    <h4>
                        <?php
                        if ($stillAlive){
                            echo ('<a href="../views/open_live_auction_view.php?liveAuction='
                                . $auction -> getAuctionId() .$refer.'">'.$auction->getItemName().'</a><br>');

                        }else{
                            echo ( $auction->getItemName().'<br>');
                        }
                        ?>
                        <small><?= $auction -> getItemBrand() ?></small>
                    </h4>
                </div>
                <?php
                if($origin == "watches"){
                    include "../includes/remove_watch.php";
                }
                ?>
            </div>

            <div class="row clearfix">

                <div class="col-xs-6">
                    <h4>
                        <strong>
                            <?php
                            $currentPrice = "₦";
                            if ( empty( $auction->getHighestBid() ) ) {
                                $currentPrice .= number_format($auction -> getStartPrice());
                            } else {
                                $currentPrice .= number_format($auction->getHighestBid());
                            }

                            if($auction->getSold() == 1){
                                echo "<span class='text-success'>SOLD FOR " . $currentPrice . "</span>";
                            } else if(!$stillAlive) {
                                echo "<span class='text-danger'>UNSOLD - LAST PRICE " . $currentPrice . "</span>";
                            } else {
                                echo $currentPrice;
                            }
                            ?>
                        </strong><br>
                        <small> <?= $auction->getNumBids() ?> Bids</small>
                    </h4>
                </div>

                <?php if ($stillAlive) { ?>
                <div class="col-xs-6">
                        <h5 class="text-danger"><span id="timer<?= $auction ->getAuctionId()?>"></span> left</h5>

                        <script type="text/javascript">
                            var timerId = "#timer" + <?= json_encode( $auction -> getAuctionId() ) ?>;
                            var endTime = <?= json_encode( $auction -> getEndTime() ) ?>;
                            $(timerId).countdown( endTime )
                                .on('update.countdown', function(event) {
                                    $(this).html(
                                        event.strftime('%D days %H:%M:%S')
                                    );
                                })
                                .on('finish.countdown', function(event) {
                                    $("#auction" + <?= json_encode( $auction -> getAuctionId() ) ?>).remove();
                                });
                        </script>
                </div>
                <?php } else { ?>
                    <div class="col-xs-3">
                        <div class="panel panel-default" id="seller-info">
                            <div class="panel-body">
                                <h4>Seller</h4>
                                <p>
                                    <a href="<?php echo '../views/my_feedbacks_view.php?username=' . $auction -> getSellerUsername() ?>">
                                        <?= $auction -> getSellerUsername() ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

            <div class="row">
                <div class="col-xs-6">
                    <p><i class="fa fa-eye"></i> Views <?= $auction->getViews() ?> | <i class="fa fa-desktop"></i> Watching <?= $auction->getNumWatches() ?></p>
                </div>
                <div class="col-xs-6">
                    <p><i class="fa fa-flag"></i> <?= $auction -> getCountryName() ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <?php
                    if($origin == "liveWithBid"){
                        if($auction->getIsUserWinning()){?>
                            <p class="alert-success" style="padding: 7px 7px; border-radius: 3px;">Currently the highest bidder!</p> <?php
                        }else{?>
                            <p class="alert-warning" style="padding: 7px 7px; border-radius: 3px;">Outbidded, bid again to win!</p> <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <?php if( $origin == "won") {
                $feedbackReceiverUsername = $auction->getSellerUsername();
                if ($auction->getHasSellerFeedback()){?>
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="text-info">Thank you for leaving feedback for seller <a href="../views/my_feedbacks_view.php?username=<?=$auction->getSellerUsername()?>"> <?=$auction->getSellerUsername()?></a></a></p>
                        </div>
                    </div>
                <?php } else {
                    $feedbackType = "Leave Seller Feedback";
                    include "feedback_form.php";
                }
            } ?>

        </div>
    </div>

</div>