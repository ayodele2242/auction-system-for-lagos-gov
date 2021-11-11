<?php 
require_once("../includes/fetch.php");

if(!isset($_SESSION['id'])) { 
header("Location: ../main.php");
}else{
    $aid = $_SESSION['id'];
    $u = mysqli_query($mysqli, "select * from users where userId = '$aid'");

    $user = mysqli_fetch_array($u);

    $fullname = $user['lastName'] .' '.$user['firstName'];
}






?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $set['siteName'];  ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
		<!-- bootstrap -->
     <!-- Bootstrap core CSS -->
		 <link href="<?php echo $set['installUrl'];  ?>global/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
	<link href="<?php echo $set['installUrl'];  ?>global/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $set['installUrl'];  ?>global/afiles/css/bootstrap-material-datetimepicker.css" />
 
    <!-- Your custom styles (optional) -->
    <link href="../global/css/style.min.css" rel="stylesheet">
    <!-- Animation Css -->
    <link href="../global/afiles/plugins/animate-css/animate.css" rel="stylesheet" />
	<link href="../global/afiles/css/custom.css" rel="stylesheet" />	
	<link rel="stylesheet" href="../global/css/topbar.css">	
    <!--
    <link rel="stylesheet" href="global/css/footer.css">-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../global/css/default.css">
	<link href="../global/themes/css/bootstrappage.css" rel="stylesheet"/>

		
		
		<!-- global styles -->
		<!--<link href="global/themes/css/flexslider.css" rel="stylesheet"/>-->
		<link href="../global/themes/css/main.css" rel="stylesheet"/>

		<!-- scripts -->
		<script type="text/javascript" src="../afiles/js/jquery.min.js"></script>
    <script src="../afiles/js/jquery-1.9.1.js"></script>
         
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?php echo $set['installUrl'];  ?>js/jquery.countdown.min.js"></script>
	
    
   
	<!--[if lt IE 9]>			
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<script src="js/respond.min.js"></script>
		<![endif]-->
<style>
 /* Container holding the image and the text */
.error,#error{
    color:#f0a;
    font-weight: bolder; 
}
 .over {
	position: relative;
	padding: 0;
	margin-left: 15px;
}

.over img{
display: block;
max-width: 100%;
height: auto;
}

/* Bottom right text */
a.text-block:after {
    content: "";
position: absolute;
display: block;
left: 0;
top: 0;
width: 100%;
height: 100%;

z-index: 1;
} 

a.text-block {
display: block;
position: absolute;
width: 100%;
color: #fff;
background: rgba(0, 0, 0, .7);
left: 0;
bottom: 0;
padding: 1em;
font-weight: 700;
z-index: 2;
-webkit-box-sizing: border-box;
box-sizing: border-box;
}

</style>

<script type="text/javascript">
		function showPreview(objFileInput) {
			hideUploadOption();
			if (objFileInput.files[0]) {
				var fileReader = new FileReader();
				fileReader.onload = function (e) {
					$("#targetLayer").html('<img src="'+e.target.result+'" width="500px" height="200px" class="upload-preview" />');
					$("#targetLayer").css('opacity','0.7');
					$(".icon-choose-image").css('opacity','0.5');
				}
				fileReader.readAsDataURL(objFileInput.files[0]);
			}
		}
		function showUploadOption(){
			$("#profile-upload-option").css('display','block');
		}

		function hideUploadOption(){
			$("#profile-upload-option").css('display','none');
		}

		function removeProfilePhoto(){
			hideUploadOption();
			$("#userImage").val('');
			$.ajax({
				url: "remove.php",
				type: "POST",
				data:  new FormData(this),
				beforeSend: function(){$("#body-overlay").show();},
				contentType: false,
				processData:false,
				success: function(data)
				{				
				$("#targetLayer").html('');
				setInterval(function() {$("#body-overlay").hide(); },500);
				},
				error: function() 
				{
				} 	        
			});
		}
		$(document).ready(function (e) {
			$("#uploadForm").on('submit',(function(e) {
				e.preventDefault();
				$.ajax({
					url: "upload.php",
					type: "POST",
					data:  new FormData(this),
					beforeSend: function(){
					$("#error").fadeOut();
					$("#btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; processing ...');
					},
					contentType: false,
					processData:false,
					success: function(data)
					{
				 if(data=="updated"){
					$("#targetLayer").css('opacity','1');
                    setInterval(function() {$("#body-overlay").hide(); },500);
                    $("#error").fadeIn(1000, function(){
                        $("#error").html('<div class="alert alert-success removeMessages"><span class="fa fa-info-sign"></span> &nbsp; Updated Successfully.</div>');

                        $("#btn-submit").html('Upload Image');

                        });

					//setTimeout(' window.location.href = "account.php"; ',200);

					} else{		
                        $("#error").fadeIn(1000, function(){
                        $("#error").html('<div class="alert alert-danger removeMessages"><span class="fa fa-info-sign"></span> &nbsp; '+data+' !</div>');

                        $("#btn-submit").html('Upload Image');

                        });
					}
					},
					error: function() 
					{
					} 	        
			   });
			}));
		});
		</script>

<script type="text/javascript">
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');

    }
});
</script>

<script language="javascript" >
	 function isNumberKey(evt)
	 {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	
	return false;
	return true;
	 }  
	</script>

	<script>
var fade_out = function() {
  $(".removeMessages").fadeOut();
}
setTimeout(fade_out, 10000);
</script>

	</head>
    <body style="background:#f0f0f0;">		