<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.db_feedback.php";
require_once "../classes/class.db_user.php";
require_once "../classes/class.db_auction.php";
require_once "../classes/class.db_item.php";
#require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}config{$ds}config.php");


// Only process when start auction button was clicked
if ( !isset( $_POST[ "createFeedback" ] ) )
{
    HelperOperator::redirectTo( "../views/my_sold_auctions_view.php" );
}

$origin = $_POST[ "origin" ];
if($origin == "won"){
    $redirectUrl = "../views/my_successful_bids_view.php";
}elseif ($origin == "sold"){
    $redirectUrl = "../views/my_sold_auctions_view.php";
}else{
    $redirectUrl = "../views/my_sold_auctions_view.php";
}



// Validate feedback input
$feedback = [ "score" => $_POST[ "score"], "comment" => $_POST[ "comment" ] ];
if ( ValidationOperator::hasEmtpyFields( $feedback ) ) {
    // Create a session for all inputs so that they can be recovered after the page returns
    SessionOperator::setFormInput( $feedback );

    // Redirect back
    HelperOperator::redirectTo( $redirectUrl );
}


$auctionId =  $_POST[ "auctionId" ];
$creatorId = SessionOperator::getUser()->getUserId();

//get the id of receiver
$receiverUsername = $_POST[ "receiverUsername" ];
/* @var DbUser $receiver */
$receiver = DbUser::withConditions("WHERE username = '". $receiverUsername ."'")->first();


//check receiver exists AND there is no existing feedback (we only allow one)
if($receiver == null or DbFeedback::withConditions
    ("WHERE auctionId = ". $auctionId . " AND creatorId = ". $creatorId . " AND receiverId = ". $receiver->getId())->exists()){
    HelperOperator::redirectTo( $redirectUrl );
}

// Create Feedback
$now = new DateTime( "now", new DateTimeZone( TIMEZONE ) );
$feedback = new DbFeedback(array(
    "auctionId" => $_POST[ "auctionId" ],
    "creatorId" => SessionOperator::getUser()->getUserId(),
    "receiverId" => $receiver->getId(),
    "score" => $_POST[ "score" ],
    "comment" => $_POST[ "comment" ],
    "time" =>$now->format('Y-m-d H:i:s')
));
$feedback->create();

// Notify receiver
$auction = DbAuction::find($auctionId);
$item = DbItem::find($auction->getField("itemId"));
$comment  = "You received a feedback from \"" . SessionOperator::getUser() -> getUserName() . "\" in your participation in \"";
$comment .= $item -> getField( "itemName" ) . " - " .  $item -> getField( "itemBrand" ) . "\".";
QueryOperator::addNotification( $receiver->getId(), $comment, QueryOperator::NOTIFICATION_FEEDBACK_RECEIVED );

// Set feedback session
SessionOperator::setNotification( SessionOperator::FEEDBACK_SENT );

// Return to page
HelperOperator::redirectTo( $redirectUrl );





