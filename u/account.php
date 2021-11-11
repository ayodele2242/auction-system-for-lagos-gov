<?php require "header.php"; ?>
<?php
 require "topbar.php"; 
 $id = $_SESSION['id'];
$sel = mysqli_query($mysqli,"select * from users where userId='$id'");
$user = mysqli_fetch_array($sel);

?>
		
        
        <div class="pt-5 mx-lg-5">
		

			<section class="text-info" style="margin-bottom:25px; font-weight:bolder; font-size:26px;">
            <span class="fa fa-user"></span>  Account Details
			</section>


<section class="main-content" >
<div class="container">
<div class="col-lg-12">
<?php if($user['image'] == ''){ ?>
    <p class="osun header alert-warning">You are seeing this message because you are yet to update your profile picture. Click on <img src="photo.png" alt="Smiley face" width="42" height="42" align="middle"> on the image below to see menu for updating your profile picture.</p>
     <?php } ?>
</div>
<div id="error"></div>
<!--File update-->
<div id="body-overlay"><div><img src="loading.gif" width="64px" height="64px"/></div></div>
		<div class="bgColor">
			<form id="uploadForm" action="upload.php" method="post">
				 <div id="targetOuter">
					<div id="targetLayer">
                    <?php if($user['image'] == ''){?>
                    <img src="../images/profile_images/blank_profile.png"  style="width:100%" height="200px" class="upload-preview img-responsive" />
                    <?php }else{?>
                        <img src="../<?php echo $user['image']; ?>"  style="width:100%" height="200px" class="upload-preview img-responsive" />

                    <?php } ?>
                    </div>
                    
					<img src="photo.png"  class="icon-choose-image"/>
					<div class="icon-choose-image" onClick="showUploadOption()"></div>
					<div id="profile-upload-option">
						<div class="profile-upload-option-list"><input name="userImage" id="userImage" type="file" class="inputFile" onChange="showPreview(this);"></input><span>Fetch Image</span></div>
						<!--<div class="profile-upload-option-list" onClick="hideUploadOption();">Cancel</div>-->
					</div>
                  
				</div>	
				<div>
                   
                <input type="submit" name="myupdate" id="btn-submit" value="Upload Image"  class="btnSubmit" onClick="hideUploadOption();"/>
                
				</div>
			</form>
		</div>	
        <!--File update end-->

<div class="row">
<div class="col-lg-12" style="margin-bottom:25px; font-weight:bolder;">
<table class="table table-striped">
<tbody>
<tr>
<td style="width:20%">Name:</td>
<td><?php echo $user['lastName'] .' '. $user['firstName']; ?></td>
</tr>
<tr>
<td style="width:20%">Username:</td>
<td><?php echo $user['username']; ?></td>
</tr>
<tr>
<td style="width:20%">Email Address:</td>
<td><?php echo $user['email']; ?></td>
</tr>
</tbody>
</table>
</div>

<div class="col-lg-12" >

<?php
if (isset($_POST['submit']) && $_POST['submit'] == 'editPassword') {
    $pwd = $_POST['password'];
    $opwd = $_POST['hpassword'];
    $npwd = $_POST['npassword'];
    $cpwd = $_POST['cpassword'];

}

?>
<form method="post" action="">
<?php //echo exec('getmac'); ?>
<?php
if (isset($_POST['submit']) && $_POST['submit'] == 'editUser') {
$phone = $mysqli->real_escape_string($_POST['phone']);
$address = $mysqli->real_escape_string($_POST['address']);
$city = $mysqli->real_escape_string($_POST['city']);

$query = mysqli_query($mysqli, "UPDATE users set phone ='$phone', address='$address', city='$city'  WHERE userId='$id' ");
if($query){
    echo '<div class="alert alert-success">Updated Successfully</div>';
}else{
    echo '<div class="alert alert-danger">An error occured: '.$mysqli->error.'</div>';
}



}
?>

                        <div class="form-group row">
						<label class="col-sm-2 control-label">Phone Number</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" required name="phone" id="phone" value="<?php echo $user['phone']; ?>" />
						</div>
					</div>

                     <div class="form-group row">
						<label class="col-sm-2 control-label">Address</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" required name="address" id="address" value="<?php echo $user['address']; ?>" />
						</div>
					</div>

                    <div class="form-group row">
						<label class="col-sm-2 control-label">City</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" required name="city" id="city" value="<?php echo $user['city']; ?>" />
						</div>
					</div>
                    <div class="form-group">
				<div id="message" class="mymsg"></div>
				
				<div align="center">
				<button type="input" name="submit" value="editUser" class="btn btn-success btn-md btn-icon mt-10 " id="btn-submit"><i class="fa fa-check-square-o"></i> <?php echo $saveChangesBtn; ?></button>
				</div>
			</div>
            </form>
            <form method="post" action="">
                    <hr />
                     <div class="form-group row">
                    <h4 class="text-info">Password Update</h4>
                   
                      </div>

                     <div class="form-group row">
						<label class="col-sm-2 control-label">Old Password</label>
						<div class="col-sm-6">
                        <input class="form-control" type="hidden" name="hpassword" id="password" value="<?php echo $user['password']; ?>" />
						
							<input class="form-control" type="password" name="password" id="password" value="" />
						</div>
					</div>

                    <div class="form-group row">
						<label class="col-sm-2 control-label">New Password</label>
						<div class="col-sm-6">
                       	<input class="form-control" type="password"  name="npassword" id="password" value="" />
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-sm-2 control-label">Confirm Password</label>
						<div class="col-sm-6">
                      		<input class="form-control" type="password" name="cpassword" id="password" value="" />
						</div>
					</div>

                <div class="form-group">
				<div id="message" class="mymsg"></div>
				
				<div align="center">
				<button type="input" name="submit" value="editPassword" class="btn btn-success btn-md btn-icon mt-10 " id="btn-submit"><i class="fa fa-lock"></i> Change Password</button>
				</div>
			</div>

</div>

</div>

</div>
</div><!--#END container -->

			

			</section>
			
		</div>

		    <?php include "footer.php"; ?>

    </body>
</html>