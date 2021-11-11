<?php
 error_reporting(0);
#echo $_SERVER['DOCUMENT_ROOT']."/config/config.php";
#require_once "classes/class.session_operator.php" ;
#require_once "classes/class.query_operator.php" ;
#require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once "config/config.php";
require_once "includes/functions.php";
require_once "includes/sitedetails.php";

if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$no_of_records_per_page = 6;
$offset = ($pageno-1) * $no_of_records_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM auctions  where endTime > now()  ";
$result = mysqli_query($mysqli,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);


$query = "SELECT  auctions.auctionId as auctionId, quantity, startPrice, reservePrice, startTime,
endTime, itemName, itemBrand, itemDescription, items.image as image, auctions.views,
item_categories.categoryName as categoryName,
conditionName, startTime <= NOW() AS hasStarted

FROM auctions

LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
JOIN items ON items.itemId = auctions.itemId
JOIN users ON items.userId = users.userId
JOIN item_categories ON items.categoryId = item_categories.categoryId
JOIN item_conditions ON items.conditionId = item_conditions.conditionId
JOIN countries ON users.countryId = countries.countryId
WHERE auctions.endTime > now() AND auctions.status = 'active'
GROUP BY auctions.auctionId
ORDER BY    hasStarted DESC, endTime DESC LIMIT $offset, $no_of_records_per_page";

$result = mysqli_query($mysqli, $query);
$setActive = 0;				


?>
<?php
if (isset($_POST['submit']) && $_POST['submit'] == 'meIn') {
$username = $mysqli->real_escape_string($_POST['username']);
$user_password = encryptIt($_POST['password']);

$password = $user_password;

    $stmt = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$username' OR email='$username' OR phone='$username' AND password='$password'");
    $row = mysqli_fetch_array($stmt);
    
    
    if($row['password']==$password AND  $row['username']==$username || $row['email']==$username || $row['phone']==$username AND $row['status'] == 'active'){
        
        header("Location: u/user"); // log in
        
        //$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
        
        $_SESSION['id'] = $row['userId'];
        $d = $_SESSION['id'];
        $uname  = $row['username'];
        $fname  = $row['lastName'] .' '. $row['firstName'];
        $act = 'login';
        $t = date("Y-m-d H:i:s");
        $tv = time();

        mysqli_query($mysqli, "insert into user_log (username,name,action,time, user_id, mydate, mtime)values('$uname','$fname','$act', '$tv', '$d', '$t', '$tv')");
        
        mysqli_query($mysqli, "UPDATE users SET lastVisited = '$t', timeVisited = '$tv' WHERE userId = '$d'");
        
    }
    else if ($row['password']==$password AND $row['username']==$username || $row['email']==$username || $row['phone']==$username  AND $row['status'] == 'suspended') {
        // If the account is not suspended, show a message
        $error = "Your account is suspended";
     } else if ($row['password']==$password AND  $row['username']==$username || $row['email']==$username || $row['phone']==$username AND $row['status'] == 'inactive') {
        // If the account is not active, show a message
        $error = "Your account is inactive at the moment";
        }
        else {
            // No account found
            $error = "Incorrect Username or Password";
        
}
}
?>

<!DOCTYPE html>
<html>

<head>
<title><?php echo $set['siteName']; ?> </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>" type="image/x-icon">
    <!-- Font -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">

       <!-- CSS -->
    <link href="theme/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-select.css" rel="stylesheet" type="text/css">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link href="theme/css/mdb.min.css" rel="stylesheet">
    <link href="theme/css/style.css" rel="stylesheet">
 
    <!--<link href="css/mdb.css" rel="stylesheet" type="text/css">-->
 
    <!-- JS -->
    <!--<script src="js/bootstrap.min.js"></script>-->
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
     <script src="js/bootstrap-notify.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/custom/search.js"></script>
    <!--<script src="js/custom/live_auction.js"></script>-->
   
    
    <!--<link href="css/main.css" rel="stylesheet">-->

    <style>
.carousel-inner{
    > .item{
      transition: 500ms ease-in-out left;
    }
    .active{
      &.left{
        left:-33%;
      }
      &.right{
        left:33%;
      }
    }
    .next{
      left: 33%;
    }
    .prev{
      left: -33%;
    }
    @media all and (transform-3d), (-webkit-transform-3d) {
      > .item{
        // use your favourite prefixer here
        transition: 500ms ease-in-out left;
        transition: 500ms ease-in-out all;
        backface-visibility: visible;
        transform: none!important;
      }
    }
  }
  .carouse-control{
    &.left, &.right{
      background-image: none;
    }
  }

  .text-danger{
      color: #f0a;
  }
.error,#error{
    color:#CC0000;
    font-weight:bolder;
}

@media (max-width: 375px) {
    .mimg{
width:200px;
}
}

        </style>

<script>
var fade_out = function() {
  $(".removeMessages").fadeOut().empty();
}
setTimeout(fade_out, 10000);
</script>
</head>

<body>
  


    <!-- header start -->
    <!--Navbar -->
 <nav class="mb-1 unique-color-default navbar navbar-expand-lg fixed-top navbar-default z-depth-5" style="background: rgb(5, 99, 161);">
      <a class="navbar-brand" href="index" style="padding:3px;">
      <img src=<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?> alt="<?php echo $set['siteName'];?>" class="img-thumbnail img-responsive mimg"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-3"
        aria-controls="navbarSupportedContent-3" aria-expanded="false" aria-label="Toggle navigation">
        <!--<span class="navbar-toggler-icon"></span>-->
<img src="img/menu.png" class="img-thumbnail img-responsive" width="30" height="30">
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-3">
        <ul class="navbar-nav mr-auto">
         <!-- <li class="nav-item active">
            <a class="nav-link" href="index">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>-->
         

           <!--<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">About Us
            </a>
            <div class="dropdown-menu"  >
              <a class="dropdown-item" href="about-us">About Us</a>
              <a class="dropdown-item" href="contact">Contact US</a>
              
            </div>
          </li>-->


          

        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
          
           <li class="nav-item " >
             <!-- login start -->
            
                <form method="post" action="" role="form">
                    <label class="text-danger col-lg-12" style="font-weight:bolder;color:#CC0000;">
                    <?php  
                        if(isset($error)){
                            echo $error;
                        }
                        ?>
                    </label>
                    <div class="row">
                    <div class="input-group col-lg-4" style="padding: 1pt;">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" placeholder="Username/Email/Phone" class="form-control" maxlength="30" name="username" id="loginEmail"
                           required>
                    </div>
                    <div class="input-group col-lg-4" style="padding: 1pt;">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" placeholder="Password" class="form-control" maxlength="30" name="password" id="loginPassword"
                            required>
                    </div>
                  
                    <button type="submit" class="btn btn-success btn-sm col-lg-2" name="submit" value="meIn" id="signIn" >Log In</button><br>
                    </div>
                </form>
                
            <!-- login end -->
          </li>
         
                  </ul>
      </div>
    </nav>
    <!--/.Navbar -->





<!--<div class="navbar-header pull-left" >
     <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#login">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
     </button>

     <a class="navbar-brand" href="index">
         <img src=<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?> alt="logo">
     </a>
</div>-->
    <!-- header end -->

    <!-- main START -->
    <div class="container" style="margin-top:120px;">
<div class="row">

<div class="col-lg-5 col-md-5">	
<?php 		

$count = mysqli_num_rows($result);
if($count < 1){
    echo '<div class="alert alert-warning" style="padding:13px; font-weight:bolder; text-align:center;">No auctions available</div>';
}else{
				while( $row = mysqli_fetch_assoc($result)){	
						$activeClass = "";			
						if(!$setActive) {
							$setActive = 1;
							$activeClass = 'active';						
                        }	
                         $uri = $row['image'];
                        $uri = ltrim($uri, '/');	
                        ?>

						

						<div class="col-xs-6" id="auction<?php echo $row['auctionId'] ?>" >
                        <div style="text-align:center;max-height:22%;">
                                    <div class=" recommendations">
                                        <a href="<?php echo $row['auctionId']; ?>">
                                        <img src="<?php echo $uri; ?>" class="img-thumbnail" style="width: 200px; height: 180px;">
                                        </a>
                                    </div>
                                    <h5 class="text-danger" style="font-weight:bolder;"><span id="timer<?php echo $row['auctionId'] ?>"></span> left</h5>
   <script type="text/javascript">
    var timerId = "#timer" + <?php echo json_encode($row['auctionId']) ?>;
    var endTime = <?php echo json_encode($row['endTime']) ?>;
    $(timerId).countdown( endTime )
        .on('update.countdown', function(event) {
            $(this).html(
                event.strftime('%D days %H:%M:%S')
            );
        })
        .on('finish.countdown', function(event) {
            $("#auction" + <?php echo json_encode($row['auctionId']) ?>).remove();
        });
     </script>
                                    <div class="caption">
                                        <h5 class="text-info"style="font-weight:bolder;" >
                                        <a href="item_details?id=<?php echo $row['auctionId'];  ?>">
                                            <?php echo $row['itemName']; ?><br>
                                                <small><?php echo $row['itemBrand']; ?></small>
                                            </a>
                                        </h5>
                                        <h5>
                                            <strong>
                                                ₦<?php echo number_format($row['startPrice']); ?> 


                                            </strong>
                                            <a href="item_details?id=<?php echo $row['auctionId'];  ?>" class="btn btn-sm btn-warning ">
                                            Bid Now
                                            </a>
                                        </h5>
                                    </div>
                                </div>

                        </div>

                        
                  <?php      				
                    }
                }
					?>			

 
 <div class="col-lg-12">
    <ul class="pagination pg-blue">
        <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
            <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
            <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
	</div>


</div><!--End col-lg-5-->

<div class="col-lg-7 col-md-7">
<div class="col-lg-12">
<h2>
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                Sign Up
            </h2>
            <p class="p_instructions text-justify alert alert-info">
                Do you want to buy auctions in real time? On our platform you can do that. All you need to do is to register real
                quickly, then sign into your new account and you are ready to go.
            </p>
</div>
<div class="col-lg-12">
<form method="post" id="register-form">
			<div class="row"><!--row-->	
			<div class="col-lg-6">
			<div class="form-group">
			<input type="text" class="form-control" name="lname" id="lname"  placeholder="Last Name">
			</div>	
		   </div>
		   <div class="col-lg-6">
			<div class="form-group">
			<input type="text" class="form-control" name="fname" id="fname"  placeholder="First Name">
			</div>	
           </div>


</div><!--#END row-->
<div class="form-group">
					<input type="text" class="form-control" name="email" id="email"  placeholder="Email Address">
</div>	
				<div class="form-group">
					<input type="text" class="form-control" name="uname" id="uname"  placeholder="Username">
</div>

<div class="row">
<div class="col-lg-6">
<div class="form-group">	
					<input type="password" class="form-control" name="pass" id="pass"  placeholder="Password">
					<span class="help-block" id="uname_error"></span>
				</div>
</div>
<div class="col-lg-6">

                <div class="form-group">	
					<input type="password" class="form-control" name="cpass" id="cpass"  placeholder="Confirm Password">
					<span class="help-block" id="uname_error"></span>
				</div>   
</div>                

</div>


	<div class="form-group">
	<button type="submit" class="btn btn-info btn-sm btns" name="regme" id="btn-submit">
	<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
	</button> 
	</div> 
    <span class="form-group" id="error" class="removeMessages"></span> 
	<div class="form-group"> By clicking this 'Sign up for E-Auction' button, you agree to our <a href="">terms of service</a> and <a href="">privacy policy</a>
        </div>
	
			</form>
</div>



       
</div>


        </div><!-- row end -->
    </div>
    <!-- main end -->




    <!-- Modal -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hello E-Auction User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <p class="alert alert-info" style="font-weight:bold;"> If you are a new user, please register and login to your page to start bidding else login to your existing account to get started.</p>
       <p style="font-weight:bolder;">Happy bidding.</p>
      </div>
      
    </div>
  </div>
</div>




    <!-- footer start -->
    <?php include_once "includes/footer.php";?>
    <!-- footer end -->
   <!-- <script type="text/javascript" src="theme/js/jquery-3.3.1.min.js"></script>
   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 
  <script type="text/javascript" src="theme/js/popper.min.js"></script>
  <script type="text/javascript" src="afiles/js/bootstrap-material-datetimepicker.js"></script>
 
  <script type="text/javascript" src="theme/js/bootstrap.min.js"></script>
 
  <script type="text/javascript" src="theme/js/mdb.min.js"></script>-->
 
    <script src="js/register.js"></script>	
</body>
</html>
