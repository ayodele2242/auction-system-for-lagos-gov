 <!--Main Navigation-->
 <header>

<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark blue scrolling-navbar">
    <div class="container-fluid">

        <!-- Brand -->
       <a class="navbar-brand waves-effect showit" href="index">
        <?php
										if(empty($set['companyLogo'])){
										?>
										<img src="<?php echo $set['installUrl']; ?>logo/avatar.png" class="img-reponsive" width="40" height="40">
										<?php
										}else{
										?>
										<img id="profile_pics"  data-holder-rendered="true" src="<?php echo $set['installUrl']; ?>logo/<?php echo $set['companyLogo']; ?>" class="img-responsive"  width="40" height="40">
										<?php
										}
										?>
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
                    <a class="nav-link waves-effect" href="main">Dashboard
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                
                <!-- Dropdown -->
               <!-- <li class="nav-item dropdown">
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
                <a class="dropdown-item" href="create_auction">Create Auction</a>
                <a class="dropdown-item" href="auction_list">Auctions List</a>
                <a class="dropdown-item" href="watched_auction">Watched Auctions List</a>             
                </div>
              </li>

               <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">Biddings</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="bids">Bidders List</a>
                <a class="dropdown-item" href="won_auctions">Won Auctions</a>
                <!--<a class="dropdown-item" href="lost_auctions">Lost Auctions</a>-->             
                </div>
              </li>

            
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="notifications">Notifications</a>
                </li>

                 <!-- Dropdown -->
                 <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">Users</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="users_list">Auctioneers</a>
                  <a class="dropdown-item" href="bidders_list">Bidders</a>
            
                </div>
              </li>
                 <!-- Dropdown -->
                 <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">Logs</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="activities_logs">Admin Log</a>
                 <!-- <a class="dropdown-item" href="memberslog">Members Log</a>-->
            
                </div>
              </li>

              
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="settings" >Settings</a>
                </li>
               
            </ul>

            <!-- Right -->
            <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                    <a href="#" class="nav-link waves-effect" target="_blank">
                    <?php echo $email;  ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link waves-effect">
                   |
                    </a>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link waves-effect"><?php echo underscore($pri);  ?></a>
                </li>
                <li class="nav-item">
                <a href="#signOut" data-toggle="modal" data-target="#modalCookie1" class="toggle-signup nav-link waves-effect btn btn-sm btn-danger" title="Sign Out"><i class="fa fa-power-off"></i></a>
                
    
            </li>
            </ul>

        </div>

    </div>
</nav>
<!-- Navbar -->

<!-- Sidebar -->
<!--<div class="sidebar-fixed position-fixed">

    <a class="logo-wrapper waves-effect">
        <img src="https://mdbootstrap.com/img/logo/mdb-email.png" class="img-fluid" alt="">
    </a>

    <div class="list-group list-group-flush">
        <a href="#" class="list-group-item active waves-effect">
            <i class="fa fa-pie-chart mr-3"></i>Dashboard
        </a>
        <a href="#" class="list-group-item list-group-item-action waves-effect">
            <i class="fa fa-user mr-3"></i>Profile</a>
        <a href="#" class="list-group-item list-group-item-action waves-effect">
            <i class="fa fa-table mr-3"></i>Tables</a>
        <a href="#" class="list-group-item list-group-item-action waves-effect">
            <i class="fa fa-map mr-3"></i>Maps</a>
        <a href="#" class="list-group-item list-group-item-action waves-effect">
            <i class="fa fa-money mr-3"></i>Orders</a>
    </div>

</div>-->
<!-- Sidebar -->

</header>
<!--Main Navigation-->
