<?php

#echo $_SERVER['DOCUMENT_ROOT']."/config/config.php";

require_once "classes/class.session_operator.php" ;
require_once "classes/class.query_operator.php" ;
#require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once "config/config.php";
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
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $set['siteName']; ?></title>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
    <!--<script src="js/bootstrap-select.min.js"></script>-->
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/custom/search.js"></script>
    <script src="js/custom/live_auction.js"></script>
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

        </style>

    <!--<style>
 .carousel-inner .item img {
  min-width: 100%;
  height: 300px;
}
.carousel, 
.carousel-inner, 
.carousel-inner .item {
    height: 100%;
}
.carousel-caption{
    padding:9px; 
    background:rgba(0,0,0,.9);
}

.carousel-caption {
  transform: translateY(-50%);
  bottom: 0;
  top: 50%;
}
</style>-->
</head>

<body>
    <!-- display feedback (if available) start -->
    <?php require_once "includes/notification.php" ?>
    <!-- display feedback (if available) end -->


    <!-- header start -->
 <!--Navbar -->
 <nav class="mb-1 unique-color-default navbar navbar-expand-lg fixed-top navbar-default z-depth-5" style="background: rgb(5, 99, 161);">
      <a class="navbar-brand" href="index" style="padding:3px;">
      <img src=<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?> alt="<?php echo $set['siteName'];?>"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-3"
        aria-controls="navbarSupportedContent-3" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
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
          
           <li id="login" class="nav-item " >
             <!-- login start -->
            
                <form method="post" action="scripts/login.php" role="form">
                    <label class="text-danger col-lg-12" style="font-weight:bolder;color:#CC0000;">
                    <?php echo SessionOperator::getInputErrors( "login" ) ?>
                    </label>
                    <div class="row">
                    <div class="input-group col-lg-4" style="padding: 1pt;">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" placeholder="Email" class="form-control" maxlength="30" name="loginEmail" id="loginEmail"
                            <?php echo 'value = "' . SessionOperator::getFormInput( "loginEmail" ) . '"'; ?> required>
                    </div>
                    <div class="input-group col-lg-4" style="padding: 1pt;">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" placeholder="Password" class="form-control" maxlength="30" name="loginPassword" id="loginPassword"
                            <?php echo 'value = "' . SessionOperator::getFormInput( "loginPassword" ) . '"'; ?> required>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm col-lg-2" name="signIn" id="signIn" >Sign In</button>
                    <a class="col-xs-offset-6 col-xs-5" href="views/forgot_password_view.php" id="forgotPassword" style="color:#fff;">Forgot your password?</a>
            
                
                    </div>
                </form>
                
            <!-- login end -->
          </li>
         
                  </ul>
      </div>
    </nav>
    <!--/.Navbar -->

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
                                            <a href="#">
                                            <?php echo $row['itemName']; ?><br>
                                                <small><?php echo $row['itemBrand']; ?></small>
                                            </a>
                                        </h5>
                                        <h5>
                                            <strong>
                                                ₦<?php echo number_format($row['startPrice']); ?> 


                                            </strong><button type="button" class="btn btn-sm btn-warning " data-toggle="modal" data-target="#basicExampleModal">
Bid Now
</button>
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
              <i style="font-weight:bolder;"> Welcome auctioneer!</i> Please register if you are yet to. An activation code will be sent to your email address for you to activate your newly created account.
            </p>
</div>
<div class="col-lg-12">
<form method="post" action="scripts/registration.php" class="row">

                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "username" ) ?>
                        </label>
                        <input type="text" name="username" class="form-control" id="username"  placeholder="Pick a username"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'username' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "email" ) ?>
                        </label>
                        <input type="text" name="email" class="form-control" id="email"  placeholder="Email"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'email' ) . '"'; ?> >
                    </div>
                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "firstName" ) ?>
                        </label>
                        <input type="text" name="firstName" class="form-control" id="firstName"  placeholder="First Name"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'firstName' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "lastName" ) ?>
                        </label>
                        <input type="text" name="lastName" class="form-control" id="lastName"  placeholder="Last Name"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'lastName' ) . '"'; ?> >
                    </div>

                    
                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "address" ) ?>
                        </label>
                        <input type="text" name="address" class="form-control" id="address" maxlength="90" placeholder="Address"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'address' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "postcode" ) ?>
                        </label>
                        <input type="text" name="postcode" class="form-control" id="postcode"  placeholder="Postcode"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'postcode' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "city" ) ?>
                        </label>
                        <input type="text" name="city" class="form-control" id="city"  placeholder="City"
                            <?php echo 'value = "' . SessionOperator::getFormInput( "city" ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "country" ) ?>
                        </label><br>
                        <select name="country" class="selectpicker form-control" data-dropup-auto="false">
                            <option default>Country</option>
                            <?php
                                $country = SessionOperator::getFormInput( "country" );
                                $countries = QueryOperator::getCountriesList();
                                foreach( $countries as $value ) {
                                    $value = htmlspecialchars( $value );
                                    $selected = "";
                                    if ($value == $country) {
                                      $selected = "selected";
                                    }
                            ?>
                            <option value="<?= $value ?>" title="<?= $value ?>" <?= $selected ?> ><?= $value ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "password1" ) ?>
                        </label>
                        <input type="password" name="password1" class="form-control" id="password1" maxlength="23" placeholder="Create a password"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'password1' ) . '"'; ?> >
                    </div>

                    <div class="form-group-lg col-lg-6">
                        <label class="text-danger">&nbsp
                            <?php echo SessionOperator::getInputErrors( "password2" ) ?>
                        </label>
                        <input type="password" name="password2" class="form-control" id="password2" maxlength="23" placeholder="Repeat password"
                            <?php echo 'value = "' . SessionOperator::getFormInput( 'password2' ) . '"'; ?> >
                    </div>

                      <div class="col-xs-12">
                <p class="pull-right">
                    By clicking this 'Sign up for <?php echo $set['siteName'];  ?>' button, you agree to our <a href="">terms of service</a> and <a href="">privacy policy</a>
                </p>
            </div>

            <div class="form-group col-xs-12" id="sign_up_button">
                <button type="submit" name="signUp" id="signUp" class="btn btn-success btn-lg pull-right">Sign up</button>
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

</body>
</html>
