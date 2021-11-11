<?php include('header.php'); ?>
<?php include('top-nav.php'); ?>
<?php	
if(isset($_POST['auctionit'])){
	//required data
	$auc_itemname = '';
	$auc_expiretime = 0;
	$auc_initprice = 0;
	//others
	$auc_expirerange = $_POST['expirerange']; //shouldnt need cleaning
	$auc_buyout = 0;
	$auc_itemdesc = '';
	$auc_imgname = '';
		
	//cleans the required data, stripping php, html and sql stuff
	if (!empty($_POST['itemname'])) {
		$auc_itemname = strip_tags($mysqli->real_escape_string($_POST['itemname']));
	}
	if (!empty($_POST['expiretime'])) {
		$auc_expiretime = abs((int) strip_tags($mysqli->real_escape_string($_POST['expiretime'])));
	}
	if (!empty($_POST['initprice'])) {
		$auc_initprice = abs(0.00 + strip_tags($mysqli->real_escape_string($_POST['initprice'])));
	}
	//cleans optional data
	$auc_buyout = abs(0.00 + strip_tags($mysqli->real_escape_string($_POST['buyout'])));
	$auc_itemdesc = strip_tags($mysqli->real_escape_string($_POST['itemdesc']));
	$auc_imgname = strip_tags($mysqli->real_escape_string($_FILES['incoming']['name']));
	
	//picture upload stuff
	if (!empty($_FILES['incoming'])) {
	if ($_FILES['incoming']['error'] == UPLOAD_ERR_OK && //checking stuff
	substr($_FILES['incoming']['name'], -4) == ".jpg" && //has extension .jpg
	$_FILES['incoming']['size'] < 100000) { //under 100,000 bytes in size
			
		  $imageinfo = getimagesize($_FILES['incoming']['tmp_name']);
		  if ($imageinfo['mime'] == 'image/jpeg' || 'image/png' || 'image/jpg') { // and is actually an image

			move_uploaded_file($_FILES['incoming']['tmp_name'],
				"images/".$_FILES['incoming']['name']);
		}
	} else {
	        
		$message ='<div class="alert alert-warning" role="alert">
            <h1>Failure:</h1>
			<p>You should really upload an image that complies with the specifications.</p>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
			</div>';
    
	}
	}
	
	//inserts data into TCusers table
	$insert = "insert into TCauctions (itemname, imgurl, expiretime, initprice, itemdesc, buyout, expired) 
		values ('$auc_itemname', '$auc_imgname', TIMESTAMPADD($auc_expirerange, $auc_expiretime, NOW()), $auc_initprice, '$auc_itemdesc',
					$auc_buyout, 0);"; 

	$result = mysqli_query($mysqli, $insert);
//Log it
$act = "inserted '".$_POST['itemname']."' into auction table";
	mysqli_query($mysqli, "insert into user_log (username,name,action,time, user_id, mydate, mtime)values('$uname','$fullname','$act', '$tv', '',$ids '$t', '$tv')");
				
	
	$query_auc = "SELECT MAX(auctionid) FROM TCauctions;";
	$querylatestauc = mysqli_query($mysqli,$query_auc);
	$row = mysqli_fetch_array($querylatestauc);
	//insert into the TCtrades table for users vs auctions
	$inserttrade = "insert into TCtrades (tradeid, sellerid) values (".$row['MAX(auctionid)'].", '".$_SESSION['uname']."');";
	$resulttrade = mysqli_query($mysqli,$inserttrade);
	//if the insert is successful (1) then return with a success page, otherwise return a fail page.
	if (($result == 1) && ($resulttrade == 1)) { 

		$message ='<div class="alert alert-success" role="alert">
		<h1>You have successfully listed an auction!</h1>
		<p>Wait and see who will buy it!.<br>
		Auction #: ' .$row['MAX(auctionid)'] .'<br>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true">&times;</span>
  </button>
		</div>';

	
	} else { 

		$message ='<div class="alert alert-warning" role="alert">
		<h1>Failure:</h1>
		<p>You must enter an item name, initial price and set a timeframe for your auction. </p>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true">&times;</span>
  </button>
		</div>';
		 }
		}
?>
   <!--Main layout-->
  
        <div class="container-fluid mt-5 pt-5">
            <div class="block-header">
            <h2><span>Products</span></h2> 
			<hr />        
            </div>


        
        <div class="row">
		<div class="col-md-2">
			
		</div>
		<div class="col-md-8">
		<?php
			if(isset($message)){ echo $message; }
			?>



			
			<form method="POST" name="add_product" enctype="multipart/form-data">
				<h5>Product Name: </h5>
				<div class="form-group">
					<input type="text" class="form-control" name="itemname" id="itemname" required>
	    		</div>
				
				<div class="form-group">
					<div class="row">
						<div class="col-md-2">
							<h5>Image</h5>
						</div>
						<div class="col-md-6">
							<input id="upload" class="" type="file" name="incoming" required>
						</div>
					</div>
				</div>

				<h5>Starting Price(Initial): </h5>
				<div class="form-group">
					<input type="text" class="form-control" name="initprice" id="initprice" value="1.00" required>
				</div>	

				<h5>Set a buyout (optional): </h5>
				<div class="form-group">
					<input type="text" class="form-control" name="buyout" id="buyout">
				</div>
				
				<h5>List for how long?: </h5>
				<div class="form-group">
					<input type="text" class="form-control" name="expiretime" id="expiretime" value="5" required>
				<input name="expirerange" type="radio" id="radbtn" value="MINUTE" checked> Minutes<br>
				<input type="radio" name="expirerange" id="radbtn" value="HOUR"> Hours<br>
				<input type="radio" name="expirerange" id="radbtn" value="DAY"> Days<br>
				</div>
				
		

				
				<h5>Category</h5>
				<div class="form-group">
					<select name="category" class="form-control">
						
						<?php 
						$look_for_category = "SELECT * FROM product_category";
						$view_category = mysqli_query($mysqli, $look_for_category) or die("Some error has been occured! .".mysqli_error($mysqli));
						while($got_category = mysqli_fetch_array($view_category)){
							?>
							<option value="<?php echo $got_category['name'];?>"><?php echo $got_category['name'];?></option>
							<?php
						}
						
						?>
					</select>
				</div>
				
				<h5 for="exampleFormControlTextarea1">Product Description(Be precise as possible)</h5>
					<div class="form-group">
					<textarea class="form-control" name="itemdesc" id="itemdesc" rows="10"></textarea>
				</div>

			
			<div class="form-group">
			<button class="btn btn-primary btn-sm my-2 my-sm-0 mt-3" name="auctionit" type="submit"><span class="mr-sm-2"><i class="fa fa-plus-circle mr-sm-2 fa-lg"></i>Auction It</span></button>
        
					</div>
			</form>
		</div>
		<div class="col-md-2">
			
		</div>
	</div>
</div>

        </div>


<?php include('footer.php'); ?>    

   