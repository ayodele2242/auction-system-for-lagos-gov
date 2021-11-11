<?php
 include('../../includes/functions.php');

 //$date = new DateTime( "now", new DateTimeZone( TIMEZONE ) );
 $date = date('Y-m-d H:i:s');

 $auctionId = $_POST[ "auctionId" ];
 $bidP = $_POST[ "bidP" ];
 $bidPrice = $_POST[ "bidPrice" ];
 $userId = $_POST[ "userId" ];

 if($bidPrice <= $bidP){
     echo "unacceptable";
 }else{
 //QueryOperator::placeBid( $auctionId, $userId, $bidPrice );
 $m = mysqli_query($mysqli, "insert into bids(userId, auctionId, bidTime, bidPrice)values('$userId','$auctionId','$date','$bidPrice')");
 if($m){
     echo "bid";
 }else{
     echo "Error occured: ". $mysqli->error;
 }

}

?>