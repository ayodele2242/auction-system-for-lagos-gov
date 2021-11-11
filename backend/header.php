<?php

include('../includes/admins.php');  


// Set your cookie before redirecting to the login page
setcookie("redirect","", time()-3600);

$current_page = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$expire=time() + (86400 * 30);
setcookie("redirect", $current_page, $expire, "/");

//$_COOKIE['redirect_to'] = $current_page;

//$cookie_name = $current_page;
//$cookie_value = $current_page;
//setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/", "http://localhost:90/totallight/", 0); // 86400 = 1 day
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
     <meta name="description" content="Automating your company work.">
    <meta name="author" content="<?php echo $set['siteName']; ?>">
    <meta name="keyword" content="content, management, system, goexpress, goexpress cargo management system,  chat, link, linkedln, <?php echo $set['siteName']; ?>">
    <link rel="icon"  href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>" type="image" />
    <title><?php echo $fullname;  ?></title>
    
    <!-- Favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="icon" type="image/png" sizes="192x192"href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>">
    <link rel="manifest" href="images/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>"">
    <meta name="theme-color" content="">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Bootstrap core CSS -->
    <link href="../css2/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../css2/mdb.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="../css2/style.min.css" rel="stylesheet">
    <!-- Animation Css -->
    <link href="../afiles/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="../afiles/css/custom.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="../css/demo.css" />
	

	<link rel="stylesheet" href="../afiles/css/bootstrap-material-datetimepicker.css" />

<!-- JQuery DataTable Css -->
<link href="../afiles/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<!--<link rel="stylesheet" href="../afiles/plugins/ckeditor/samples/css/samples.css">-->
<!--<link rel="stylesheet" href="../afiles/plugins/ckeditor/sample/toolbarconfigurator/lib/codemirror/neo.css">-->

<!-- file input css -->
<link rel="stylesheet" type="text/css" href="../afiles/assets/fileinput/css/fileinput.min.css">
<link href="../afiles/css/autocomplete.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="../afiles/css/style.css" rel="stylesheet" />
    <link href="../afiles/css/printer.css" rel="stylesheet"  />

    <link rel="stylesheet" type="text/css" href="../afiles/css/tokenfield-typeahead.css">
    <link rel="stylesheet" type="text/css" href="../afiles/css/bootstrap-tokenfield.css">
    <link rel="stylesheet" href="../froala_editor/css/froala_editor.css">
  <link rel="stylesheet" href="../froala_editor/css/froala_style.css">
  <link rel="stylesheet" href="../froala_editor/css/plugins/code_view.css">
  <link rel="stylesheet" href="../froala_editor/css/plugins/image_manager.css">
  <link rel="stylesheet" href="../froala_editor/css/plugins/image.css">
  <link rel="stylesheet" href="../froala_editor/css/plugins/table.css">
  <link rel="stylesheet" href="../froala_editor/css/plugins/video.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
  <link href="../css/bootstrap-select.css" rel="stylesheet">
  <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
  <link href="../css/main.css" rel="stylesheet">
      <!-- Include Editor style. -->
 <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
 <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_style.min.css' rel='stylesheet' type='text/css' />
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
  
      
    
    <script type="text/javascript" src="../afiles/js/jquery.min.js"></script>
    <script src="../afiles/js/jquery-1.9.1.js"></script>
         
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/froala_editor.min.js'></script>
    <script src="../js/jquery.countdown.min.js"></script>
    <script src="../js/bootstrap.file-input.js"></script>
    <script src="../js/moment.min.js"></script>
    <script type="text/javascript" src="../afiles/js/bootstrap-material-datetimepicker.js"></script>
    <script src="../js/custom/search.js"></script>
    <script src="js/addbid.js"></script>	
    
    <!-- Include JS file. -->
   

 


    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script type="text/javascript" src="../afiles/js/jquery.min.js"></script>
	 <script src="../afiles/js/jquery-1.11.2.min.js"></script>
    <script src="../afiles/js/jquery.min-11.1.js"></script>
   <script src="../afiles/js/jquery-1.9.1.js"></script>
    <script src="../afiles/js/jquery-1.12.4.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    -->
<script src='https://maps.google.com/maps/api/js' type='text/javascript'></script>

<style>
.table thead th{
background:#1C2331;
color: #fff;
font-weight: bolder;
font-size: 14px;
}
.table {
    table-layout:fixed;
    border-collapse: collapse;
    background: #fff;
 }

.table td {
    text-overflow:ellipsis;
    overflow:hidden;
    white-space:nowrap;
}

.btn-default{
    color: #000;
}
.mbody{
    margin-bottom: 15px;
}

.ebody{
    margin-bottom: 15px;
    border: solid 1px #dd2c00;
}

.input-file-container {
  position: relative;
  width: 225px;
} 
.js .input-file-trigger {
  display: block;
  padding: 14px 45px;
  background: #39D2B4;
  color: #fff;
  font-size: 1em;
  transition: all .4s;
  cursor: pointer;
}
.js .input-file {
  position: absolute;
  top: 0; left: 0;
  width: 225px;
  opacity: 0;
  padding: 14px 0;
  cursor: pointer;
}
.js .input-file:hover + .input-file-trigger,
.js .input-file:focus + .input-file-trigger,
.js .input-file-trigger:hover,
.js .input-file-trigger:focus {
  background: #34495E;
  color: #39D2B4;
}

.file-return {
  margin: 0;
}
.file-return:not(:empty) {
  margin: 1em 0;
}
.js .file-return {
  font-style: italic;
  font-size: .9em;
  font-weight: bold;
}
.js .file-return:not(:empty):before {
  content: "Selected file: ";
  font-style: normal;
  font-weight: normal;
}


</style>


<script>
<script>  
 $(document).ready(function(){  
      $('.view_data').click(function(){  
           var employee_id = $(this).attr("id");  
           $.ajax({  
                url:"select.php",  
                method:"post",  
                data:{employee_id:employee_id},  
                success:function(data){  
                     $('#employee_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
      });  
 });  
 </script>
</script>

<script>
var fade_out = function() {
  $(".removeMessages").fadeOut().empty();
}
setTimeout(fade_out, 10000);
</script>

<script>
var fade_out = function() {
  $(".errors").fadeOut().empty();
}
setTimeout(fade_out, 10000);
</script>

<script>
$(document).ready(function () {
    //called when key is pressed in textbox
     $(".digit").keypress(function (e) {
       //if the letter is not digit then display error and don't type anything
       if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          //display error message
          $(".derror").html("Only digits allow").show().fadeOut("slow");
                 return false;
      }
     });
  });
</script>


    <script type="text/javascript">
   function changeAlias() {
        var title = $.trim($("#page_title").val());
        title = title.replace(/[^a-zA-Z0-9-]+/g, '-');
        $("#page_alias").val(title.toLowerCase());
    }
</script>

 <script type="text/javascript">
   function changeContent() {
        var cont = $.trim($("#ckeditor").val());
        cont = cont.replace(/[^a-zA-Z0-9-]+/g, '-');
        $("#mycont").val(cont.toLowerCase());
    }
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            if($(this).attr("value")=="Teacher"){
                $(".boxy").not(".Teacher").hide();
                $(".Teacher").show();
            }
            else if($(this).attr("value")=="Driver"){
                $(".boxy").not(".Driver").hide();
                $(".Driver").show();
            }
            else if($(this).attr("value")=="event"){
                $(".boxy").not(".event").hide();
                $(".event").show();
            }

            else{
                $(".boxy").hide();
            }
        });
    }).change();
});
</script>

    
		<script type="text/javascript">
		function showPreview(objFileInput) {
			hideUploadOption();
			if (objFileInput.files[0]) {
				var fileReader = new FileReader();
				fileReader.onload = function (e) {
					$("#targetLayer").html('<img src="'+e.target.result+'" width="200px" height="200px" class="upload-preview" />');
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
					$(".btn-submit").html('<img src="../img/processing.gif" width="30" /> &nbsp; processing ...');
					},
					contentType: false,
					processData:false,
					success: function(data)
					{
						if(data==0){
					$(".btn-submit").html('Try again');
					$("#error").fadeIn(1000, function(){
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Invalid/Empty file uploaded. Please upload a valid file.</div>');
						
					});
				}else if(data==1){
					$(".btn-submit").html('Try again');
					$("#error").fadeIn(1000, function(){
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; File too large. Compress the file before uploading. File size should not be more than 1mb.</div>');
						
					});

					} else{		
					$("#targetLayer").css('opacity','1');
					setInterval(function() {$("#body-overlay").hide(); },500);
					$(".showit").html('<img src="'+e.target.result+'"  class="img" />');
					

					$(".myimg").load(location.href + " .myimg");
					$(".myimg2").load(location.href + " .myimg2");
					$(".btn-submit").html('Updated');
					//setTimeout(' window.location.href = "main"; ',200);
					$("#error").fadeIn(1000, function(){
						$("#error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-check"></span> &nbsp; Logo Updated Successfully.</div>');
						
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
   

<script type='text/javascript'>
    $(document).ready(function() {
        $('.countit').keyup(function() {
            var len = this.value.length;
            if (len >= 60) {
                this.value = this.value.substring(0, 60);
            }
            $('#charLeft').text(60 - len);
        });
    });
  </script>


  
 <script type="text/javascript">
	 function getcode1(value,auctionId) {
     var value = $('#code1_'+auctionId).val();

            $.ajax({
                type: "POST",
                url: "update_auction_status.php",
                data:'status='+value+'&auctionId='+auctionId,
                success: function(data){
                    $("#auctions").DataTable().ajax.reload(null, false);
              }
            });
     return true;
     };
    </script>
    <script type="text/javascript">
	 function ugetcode1(value,userId) {
     var value = $('#ucode1_'+userId).val();
          $.ajax({
                type: "POST",
                url: "update_user_status.php",
                data:'status='+value+'&userId='+userId,
                success: function(data){
                    $(".ref").load(location.href + " .ref");
              }
            });
     return true;
     };
    </script>

    <script type="text/javascript">
	 function usgetcode1(value,userId) {
     var value = $('#uscode1_'+userId).val();

            $.ajax({
                type: "POST",
                url: "update_user_status.php",
                data:'status='+value+'&userId='+userId,
                success: function(data){
                    $(".refresh").load(location.href + " .refresh");

              }
            });
     return true;
     };
    </script>
</head>

<body class="grey lighten-3">