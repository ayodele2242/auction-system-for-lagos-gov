<?php
session_start();
include_once '../config/configs.php';
if(!isset($_SESSION['id'])){
	header("Location: ../main.php?Denied=Enter your login details.");
}
//echo $_SESSION['id'];
if(is_array($_FILES)) {
	error_reporting(0);

	$image = ( $_FILES[ "userImage" ][ "tmp_name" ] );
	$image_name = $_FILES[ "userImage" ][ "name" ];
	$image_extension = strtolower( pathinfo( addslashes($image_name), PATHINFO_EXTENSION ) );
	$image_dimensions = getimagesize( $image );
	$image_size = $_FILES[ "userImage" ][ "size" ];
	$extensions = array( "jpeg", "jpg", "png" );


	if ( $_FILES[ "userImage" ][ "error" ] != UPLOAD_ERR_OK )
    {
       echo 'Please upload a valid image';
	}
	
	  // File is not an image
	 else if ( $image_dimensions == False )
	  {
		  echo 'Upload a valid image. Accepted image is either jpeg, jpg, png.';
	  }

	  // Image has wrong extension
	else  if ( in_array( $image_extension, $extensions ) === false )
	  {
		  echo 'Upload a valid image. Accepted image is either jpeg, jpg, png.';
	  }

	  // Image size is too large
	else  if ( $image_size > 512000 )
	  {
		  echo 'Uploaded image is too large. Image should not be more than 5mb';
	  }

else{

     // Create random image name
	 $newImageName = UPLOAD_PROFILE_IMAGE . uniqid( "", true ) . "." . $image_extension;
	 move_uploaded_file( $image, ROOT . $newImageName );
 
	 $sql_update = "UPDATE users set image = '$newImageName' where userId='".$_SESSION['id']."'";			
	$updated = mysqli_query($mysqli, $sql_update);
if($updated){
	echo "updated";
}else{
	echo "Not updated ". $mysqli-error;
}
}


	
	
	

}


?>