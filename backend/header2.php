<?php
include('../includes/fetch.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Automating your cargo work.">
    <meta name="author" content="<?php echo $set['siteName']; ?>">
    <meta name="keyword" content="content, management, system, cargo, auction management system, auction, chat, link, linkedln, <?php echo $set['siteName']; ?>">
    <link rel="icon"  href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>" type="image/x-icon" />

    <title><?php echo $set['siteName']; ?> - <?php if(isset($_GET['p'])){ $p = $_GET['p']; echo $p; }else { echo "Admin Sign In"; }   ?></title>

    

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap Core Css -->
    <link href="../afiles/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../afiles/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../afiles/css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../afiles/css/style.css" rel="stylesheet">

    <script src="../afiles/js/jquery.min.js"></script>
   
    <script type="text/javascript" src="../afiles/js/jquery-1.11.3-jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="../afiles/js/validation.min.js"></script>
    <script type="text/javascript" src="../afiles/js/signin.js"></script>

    <style>
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: rgb(249,249,249);
    
}

.loader p{
margin-top: 18%;
margin-left:37%;
}
    </style>

    
        <script type="text/javascript">
            $(window).load(function() {
                $(".loader").fadeOut("slow");
            });
            </script>

            <script type="text/javascript" language="javascript">
    jQuery(function() {
        jQuery('input').attr('autocomplete', 'off');
    });
</script>

<script>
$(document).ready(function(){
    setTimeout(function() {
    $('#error').fadeOut('fast');
}, 1000); 
});
    </script>
 
 <script>
  $(document).ready(function(){
    $(':input').live('focus',function(){
        $(this).attr('autocomplete', 'off');
    });
});
</script>

</head>

<body class="login-page">

    <!-- Page Loader -->
    <div class="loader" style="background-color: #d7e610;">
    <p>
    <div align="center"><span style="font-weight:bolder; font-size:26px;"><?php echo strtoupper($set['company_name']); ?></span></div>
    <div align="center"> Please wait</div>
    </p>
    
    </div>
    <!-- #END# Page Loader -->

    
    
    