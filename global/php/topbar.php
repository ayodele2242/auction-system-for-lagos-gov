<?php

	session_start();

    $aid = $_SESSION['id'];
		if(isset($_SESSION['id'])) { //print HTML below if user is logged in
					if(!isset($profile_img)) {
						//get profile picture file name
						require_once 'connection.php';
						$result = mysqli_query(
							$conn,
							"SELECT profile_img ".
							"FROM user ".
							"WHERE account_id = $account_id_session"
						) or die("Query error: ".mysqli_error($conn));
						$profile_img = mysqli_fetch_row($result)[0];
					}
			?>
<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark blue scrolling-navbar">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand waves-effect showit" href="index">
      
		<img src="http://localhost:90/auction/augeo/global/img/logo.png" class="img-reponsive" width="40" height="40">
										
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

			

            <!-- Left -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link waves-effect" href="http://localhost:90/auction/augeo/index">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="http://localhost:90/auction/augeo/live" style="font-size:16px; font-weight:bolder;"><i class="fa fa-bell text-success" ></i> Live Options</a>
				</li>
				
				<li class="nav-item">
                    <a class="nav-link waves-effect" href="http://localhost:90/auction/augeo/browse/index">Browse</a>
				</li>
				
				<li class="nav-item">
				<button id="add-item" class="btn btn-default navbar-btn nav-link waves-effect" onclick="window.location = 'http://localhost:90/auction/augeo/item/add/index'">Add item</button>
                </li>

                <!-- Dropdown -->
                <!--<li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">Products</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="category">Catogory</a>
                  <a class="dropdown-item" href="add_product">Products</a>
                  <a class="dropdown-item" href="productapproval">Products Approval</a>
                </div>
              </li>-->

               <!-- Dropdown -->
               <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">Auctions</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="http://localhost:90/auction/augeo/user/auctions/index">Browse Auctions</a>
                  <a class="dropdown-item" href="#purgeauction">Purge Auctions</a>
                  
                 
                </div>
              </li>

   
               
            </ul>

            <!-- Right -->
            <ul class="navbar-nav nav-flex-icons">
               <!-- Dropdown -->
               <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
				  aria-expanded="false">
				  <img src="<?php echo $profile_img ?>" id="avatar" alt="Settings">
					<span class="caret" style="margin-left: 10px;"></span>
				</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="http://localhost:90/auction/augeo/user/account/index">My Account</a>
                <a class="dropdown-item" href="http://localhost:90/auction/augeo/user/auctions/index">My Auctions</a>
                  
                <a class="dropdown-item" href="http://localhost:90/auction/augeo/logout?logout=<?php echo $_SESSION['account_id']; ?>">Logout</a>
                </div>
              </li>
			
			</ul>
		

        </div>

    </div>
</nav>
<!-- Navbar -->
<?php } ?>

