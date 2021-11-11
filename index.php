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
    <!-- header logo start -->
    <?php include_once "includes/header.php";?>
            <!-- header logo end -->
    <!-- header end -->

    <!-- main START -->
<div class="container" style="margin-top:120px;">
<div class="row">

<div class="col-lg-3 col-md-3">	
<?php
$catx = mysqli_query($mysqli,"SELECT COUNT(item_categories.categoryName) cat_count, item_categories.categoryName as categoryName, 
items.categoryId FROM item_categories JOIN items ON items.categoryId = item_categories.categoryId GROUP BY items.categoryId ");

$countit = mysqli_num_rows($catx);
if($countit == 0){
echo '<div class="alert alert-warning">No categories to show</div>';

}else{

?>
<uk class="item_list">
<?php
while($mycat = mysqli_fetch_array($catx)){
?>
<li><a href="cat_list?id=<?php echo $mycat['categoryId']; ?>"><?php echo $mycat['categoryName']; ?> (<?php echo $mycat['cat_count']; ?>)  </li>

<?php } ?>   



</ul>



<?php } ?>


</div><!--End col-lg-5-->

<div class="col-lg-9 col-md-9">

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
    <script src="js/register.js"></script>	
</body>
</html>
