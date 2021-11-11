<?php include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php //include('links.php'); 
#require_once ("../config/configs.php");
defined( "ROOT" ) ? null : define( "ROOT", "{$base_dir}" );
defined( "UPLOAD_PROFILE_IMAGE" ) ? null : define( "UPLOAD_PROFILE_IMAGE", "/images/profile_images/" );
defined( "UPLOAD_ITEM_IMAGE" ) ? null : define( "UPLOAD_ITEM_IMAGE", "/images/item_images/" );
if(isset($_POST['startAuction']))
{
    $uid = $_SESSION['id'];
	
    $image = null;
    $image_name = null;
    $image_extension = null;
    //$error = [];

    $item           = $_POST["item"];
    $itemName       = clean($_POST["itemName"]);
    $itemBrand       = $_POST["itemBrand"];
    $itemCategory    = $_POST["itemCategory"];
    $itemCondition   = $_POST["itemCondition"];
    $itemDescription = clean($_POST["itemDescription"]);
    $quantity        = $_POST["quantity"];
    $startPrice      = $_POST["startPrice"].'00';
    $reservePrice    = $_POST["reservePrice"].'00';
    $startTime       = new DateTime($_POST["startTime"]);
    $endTime         = new DateTime($_POST["endTime"]);

    $startTimec = $startTime -> format('Y-m-d H:i:s');
    $endTimec = $endTime -> format('Y-m-d H:i:s');

     /*if(!empty($reservePrice) and !empty($startPrice)){
         if($startPrice > $reservePrice){
        $error = 'Start Price cannot be greater than Reserve Price.';
     }
     }*/
    // No file selected
    if ( $_FILES[ "image" ][ "error" ] != UPLOAD_ERR_OK )
    {
        $error = 'Please upload a valid image';
    }
    else
    {
        $image = ( $_FILES[ "image" ][ "tmp_name" ] );
        $image_name = $_FILES[ "image" ][ "name" ];
        $image_extension = strtolower( pathinfo( addslashes($image_name), PATHINFO_EXTENSION ) );
        $image_dimensions = getimagesize( $image );
        $image_size = $_FILES[ "image" ][ "size" ];
        $extensions = array( "jpeg", "jpg", "png" );

        // File is not an image
        if ( empty( $error ) && $image_dimensions == False )
        {
            $error = 'Upload a valid image. Accepted image is either jpeg, jpg, png.';
        }

        // Image has wrong extension
        if ( empty( $error ) &&  in_array( $image_extension, $extensions ) === false )
        {
            $error = 'Upload a valid image. Accepted image is either jpeg, jpg, png.';
        }

        // Image size is too large
        if ( $image_size > 512000 )
        {
            $error = 'Uploaded image is too large. Image should not be more than 5mb';
        }
    }


    if (empty($error))
    {
        // Create random image name
    $newImageName = UPLOAD_ITEM_IMAGE . uniqid( "", true ) . "." . $image_extension;
    move_uploaded_file( $image, ROOT . $newImageName );

    //$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
    $itemQuery = mysqli_query($mysqli, "INSERT INTO items(userId, itemName, itemBrand, categoryId, conditionId, itemDescription, image) 
    VALUES ('$uid', '$itemName', '$itemBrand', '$itemCategory', '$itemCondition', '$itemDescription', '$newImageName')")  or die(mysqli_error($mysqli));
    

//Get the last inserted item id by this user from items table
    $query_auc = "SELECT MAX(itemId) as itemId FROM items WHERE userId = '$uid'";
	$querylatestauc = mysqli_query($mysqli, $query_auc);
    $rowi = mysqli_fetch_array($querylatestauc);

    
    /*var_dump($rowi);
$myVar= intval($myVar);
var_dump($myVar);*/
    
    $itemid = $rowi["itemId"];

    // SQL query for inserting auction
    $auctionQuery = "INSERT INTO auctions ( itemId, quantity, startPrice, reservePrice, startTime, endTime ) 
    VALUES ( '$itemid', '$quantity', '$startPrice', '$reservePrice', '$startTimec', '$endTimec' )";
      
    $auctionIns = mysqli_query($mysqli, $auctionQuery);
       
    if($itemQuery && $auctionIns){
        $success = 'Query executed successfully.';
        
    }else{
        $error2 = 'Error occured: ' . $mysqli->error;
    }

    }

    // Display errors
    /*if ( !empty( $error ) )
    {
        SessionOperator::setInputErrors( $error );
        return null;
    }*/

    // No errors
   /* return [ "image" => $image, "imageExtension" => $image_extension ];*/



}



?>
  <style>
.col-xs-3,.col-xs-2{
    padding: 9px;
}
  </style>
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h1><span>Create New Auction</span></h1>         
            </div>



<section class="my-5" >
<?php
if(isset($error)){
    echo '<div class="alert alert-warning errors">' .$error. '</div>';
}
else if(isset($error2)){
    echo '<div class="alert alert-warning errors">' .$error2. '</div>';
}
else if(isset($success)){
       
       echo '<div class="alert alert-success disappear">' . $success. '</div>';
}

?>
<form action="" method="post"  role="form"  enctype="multipart/form-data" style="padding-left:2%;padding-right:2%;">
<div class="clearfix row">
<div class="col-lg-5">
 <div class="form-group">
                <label>Create a new item or use one of your existing ones</label>
                <select class="selectpicker form-control" name="item">
                    <option default>New Item</option>
                </select>
            </div>

            <div class="form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" name="itemName" maxlength="45" values="<?php if(isset($_POST['itemName'])){ echo $_POST['itemName']; }  ?>" required>
            </div>

            <div class="form-group">
                <label>Brand</label>
                <input type="text" class="form-control" name="itemBrand" maxlength="45"
                values="<?php if(isset($_POST['itemBrand'])){ echo $_POST['itemBrand']; }  ?>" required>
            </div>

            <div class="form-group">
                <label>Category</label>
                <select class="selectpicker form-control" name="itemCategory"  data-dropup-auto="false" required>
                    <option>Select</option>

                    <?php
                    echo getItemCat();
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Condition</label>
                <select class="selectpicker form-control" name="itemCondition"  data-dropup-auto="false" required>
                    <option>Select</option>
                    <?php
                   echo getItemCon();
                    ?>
                </select>
            </div>
            <!-- left column end -->
            

            <!-- right column start -->
            <div class="form-group">
                <div class="input-file-container">  
    <input name="image" class="input-file" id="my-file" type="file" required>
    <label tabindex="0" for="my-file" class="input-file-trigger">Select a file...</label>
  </div>
  <p class="file-return"></p>
            </div>
            <!-- right column end -->

</div> <!-- col-lg-5 end -->

<div class="col-lg-7">
<div class="form-group">
                <label>Description</label>
                <textarea class="form-control editor" id="itemDescription" rows="24" name="itemDescription" placeholder="Enter a description" 
                maxlength="2000" required><?php if(isset($_POST["itemDescription"])) echo $_POST["itemDescription"]; ?></textarea>
                <h6 class="pull-right" id="counter"></h6>
            </div>
</div>

<div class="col-lg-12">
<div class="panel-body row">

        <div class="col-xs-2">
            <label>Item quantity</label>
            <div class="form-group">
                
         <input type="number" name="quantity" class="form-control input-number" required>
                   
            </div>
        </div>

        
        <div class="col-xs-2">
            <label>Start price</label>
            <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">₦</span>
  </div>
  <input type="text" class="form-control digit"  name="startPrice" placeholder="10" required> 
  <div class="input-group-append">
    <span class="input-group-text">.00</span>
  </div>
</div>
</div>

<div class="col-xs-2">
 <label>Reserve price (optional)</label>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">₦</span>
  </div>
  <input type="text" class="form-control digit" name="reservePrice" placeholder="100" maxlength="10" >
  <div class="input-group-append">
    <span class="input-group-text">.00</span>
  </div>                   
</div>
</div>


         <div class="col-xs-3">
            <label>Start Time</label>
            <div class="form-group mb-3">
                <div class='input-group-prepend'>
                    <input type='text' id="datetimepickerStart" class="form-control  date3" name="startTime" required>
                    <span class="input-group-text">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
            </div>
        </div>


         <div class="col-xs-3">
            <label>End Time</label>
            <div class="form-group mb-3">
                <div class='input-group-prepend date'>
                <input type='text' class="form-control datetimepickerEnd date3" name="endTime" required>
                    <span class="input-group-text">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
            </div>
        </div>


        <!-- submit auction start -->
<div class="form-group">

    <button type="submit" class="btn btn-primary pull-right" name="startAuction">
        <span class="fa fa-play-circle"></span> Start Auction
    </button>
</div>
<!-- submit auction end -->


</div>
</div>


</div> 
</form>
</section>

               

        </div>
     

<?php include('footer.php'); ?>    

   