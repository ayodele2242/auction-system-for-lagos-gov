
<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark blue scrolling-navbar">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand waves-effect showit" href="user">
      
		<img src="<?php echo $set['installUrl'].'logo/'.$set['companyLogo']; ?>" class="img-reponsive" width="40" height="40">
										
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
                    <a class="nav-link waves-effect" href="user">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
              
				
				<li class="nav-item">
                    <a class="nav-link waves-effect" href="my_bidding">My Biddings</a>
				</li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="my_won_auctions">My Won Auctions</a>
				</li>
				
               
            </ul>

            <!-- Right -->
            <ul class="navbar-nav nav-flex-icons">
            <li class="nav-item">
            <a class="nav-link waves-effect" href="#">
                 <?php
                // 24-hour format of an hour without leading zeros (0 through 23)
                $Hour = date('G');

                if ( $Hour >= 5 && $Hour <= 11 ) {
                    echo 'Good Morning: <span class="maroon" style="font-weight:bolder;"><i class="fa fa-user"></i> ' . $fullname;
                } else if ( $Hour >= 12 && $Hour <= 18 ) {
                    echo 'Good Afternoon: <span class="maroon" style="font-weight:bolder;"><i class="fa fa-user"></i> ' . $fullname;
                } else if ( $Hour >= 19 || $Hour <= 4 ) {
                    echo 'Good Evening: <span class="maroon" style="font-weight:bolder;"><i class="fa fa-user"></i> ' . $fullname;
                }
                ?>
                </a>
 </li>

  <li class="nav-item">
                    <a class="nav-link waves-effect" href="">|</a>
			</li>
            <li class="nav-item">
                    <a class="nav-link waves-effect" href="account">My Account</a>
			</li>
            <li class="nav-item">
                    <a class="nav-link waves-effect"href="logout">Logout</a>
			</li>

              
			
			</ul>
		

        </div>

    </div>
</nav>


