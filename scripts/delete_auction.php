<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.email.php";

#require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_auction.php' );
#require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_item.php' );

require_once("{$base_dir}classes{$ds}class.db_auction.php");
require_once("{$base_dir}classes{$ds}class.db_item.php");


$auctionId = $_GET["id"];

// Prevent sql injection
if(!is_numeric($auctionId)){
    HelperOperator::redirectTo("../views/my_live_auctions_view.php");
}

/* @var User $user */
$user = SessionOperator::getUser();
$userId = $user->getUserId();

/* @var DbAuction $auction */
/* @var DbItem $item */
$auction = DbAuction::find($auctionId);
$item = DbItem::find($auction->getField("itemId"));

// User owns auction
if($item->getField("userId") == $userId)
{
    // Notifiy current highest bidder
    $highestBid = QueryOperator::getAuctionBids( $auctionId, 1 )[ 0 ];
    if ( !empty( $highestBid )  )
    {
        $comment  = "The auction \"" . $item->getField("itemName") . " " . $item->getField("itemBrand") . "\" with ";
        $comment .= "your current highest bid of " . $highestBid -> getBidPrice() . " GSP was deleted by " . $user -> getUsername() . ".";
        QueryOperator::addNotification( $highestBid -> getBidderId(), $comment, QueryOperator::NOTIFICATION_AUCTION_DELETED );
    }

    // Delete auction
    $auction->delete();
    if ( !empty( $imageName = $item -> getField( "image" ) ) )
    {
        unlink( ROOT . $imageName );
    }

    // Delete auction event
    QueryOperator::dropAuctionEvent( $auctionId );

    // Set feedback session
    SessionOperator::setNotification( SessionOperator::DELETED_AUCTION );
}

HelperOperator::redirectTo("../views/my_live_auctions_view.php");




