<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";


// Only process when start auction button was clicked
if ( !isset( $_POST[ "startAuction" ] ) )
{
    HelperOperator::redirectTo( "../views/create_auction_view.php" );
}


// Store POST values
$new_auction = [
    "item"            => $_POST[ "item" ],
    "itemName"        => $_POST[ "itemName" ],
    "itemBrand"       => $_POST[ "itemBrand" ],
    "itemCategory"    => $_POST[ "itemCategory" ],
    "itemCondition"   => $_POST[ "itemCondition" ],
    "itemDescription" => $_POST[ "itemDescription" ],
    "quantity"        => $_POST[ "quantity" ],
    "startPrice"      => $_POST[ "startPrice" ],
    "reservePrice"    => $_POST[ "reservePrice" ],
    "startTime"       => $_POST[ "startTime" ],
    "endTime"         => $_POST[ "endTime" ],
];


// Add empty string for default selects
if ( $new_auction[ "itemCategory" ] == "Select" )
{
    $new_auction[ "itemCategory" ]  = "";
}
if ( $new_auction[ "itemCondition" ] == "Select" )
{
    $new_auction[ "itemCondition" ]  = "";
}



// Check inputs
if ( ValidationOperator::hasEmtpyFields( $new_auction ) ||
     ( $upload = ValidationOperator::checkImage() ) == null || ($uploads = ValidationOperator::checkImages() ) == null ||
     !ValidationOperator::checkPrizes( $new_auction[ "startPrice" ], $new_auction[ "reservePrice" ] ) )
{
    // Create a session for all inputs so that they can be recovered after the page returns
    SessionOperator::setFormInput( $new_auction );

    // Redirect back
    HelperOperator::redirectTo( "../views/create_auction_view.php" );
}
// Form valid - store auction
else
{
    // Create random image name
    $newImageName = UPLOAD_ITEM_IMAGE . uniqid( "", true ) . "." . $upload[ "imageExtension" ];

    // Cannot upload image to file system, otherwise, image uploaded
    if ( !move_uploaded_file( $upload[ "image" ], ROOT . $newImageName ) )
    {
        $error[ "upload" ] = "Image cannot be uploaded ";
        SessionOperator::setInputErrors( $error );
        HelperOperator::redirectTo( "../views/create_auction_view.php" );
    }

     // Create random image name
     $mnewImageName = UPLOAD_ITEM_IMAGE . uniqid( "", true ) . "." . $uploads[ "imageExtension" ];

     // Cannot upload image to file system, otherwise, image uploaded
     if ( !move_uploaded_file( $uploads[ "image" ], ROOT . $mnewImageName ) )
     {
         $error[ "upload" ] = "Image Clearance cannot be uploaded ".$mnewImageName;
         SessionOperator::setInputErrors( $error );
         HelperOperator::redirectTo( "../views/create_auction_view.php" );
     }

   

    // Get item category and condition id
    $ids = QueryOperator::getItemRelatedIds(addslashes( $new_auction[ "itemCategory" ]), $new_auction[ "itemCondition" ] );


    // Prepare item parameters
    $item[] = SessionOperator::getUser() -> getUserId();
    $item[] = $new_auction[ "itemName" ];
    $item[] = $new_auction[ "itemBrand" ];
    $item[] = $ids[ "categoryId" ];
    $item[] = $ids[ "conditionId" ];
    $item[] = $new_auction[ "itemDescription" ];
    $item[] = $newImageName;
    $item[] = $mnewImageName;

    // Prepare auction parameters
    $startTime = date_create($new_auction[ "startTime" ]) -> format('Y-m-d H:i:s');
    $endTime = date_create($new_auction[ "endTime" ]) -> format('Y-m-d H:i:s');
    $auction[] = "";
    $auction[] = $new_auction[ "quantity" ];
    $auction[] = $new_auction[ "startPrice" ];
    $auction[] = $new_auction[ "reservePrice" ];
    $auction[] = $startTime;
    $auction[] = $endTime;

    // Store auction in database
    $ids = QueryOperator::addAuction( $item, $auction );

    // Set event timer
    QueryOperator::addAuctionEvent( $endTime, SessionOperator::getUser() -> getUserId(), $ids[ "auctionId" ] );

    // Store image name in database
    QueryOperator::uploadImage( $ids[ "itemId" ], $newImageName, "items" );
    QueryOperator::uploadImages( $ids[ "itemId" ], $mnewImageName, "items" );

    // Set feedback session
    SessionOperator::setNotification( SessionOperator::CREATED_AUCTION );

    // Return to live auctions page
    HelperOperator::redirectTo( "../views/my_live_auctions_view.php" );
}



