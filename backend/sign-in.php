<?php 
include('header2.php'); 

?>

<div class="row">

    <div class="col-lg-7 w1h1">
     <p class="mytext userLink">  
         Auction System
     <?php //echo $set['company_name']; ?><br/>
     Administrator Login

    </p>
        
        </div>

    <div class="col-lg-5">


    <div class="login-box  blue-gradient color-block mb-3 mx-auto  z-depth-1">
   
       <!-- <div class="logo image">
        
            <a href="javascript:void(0);"><img src="<?php //echo $set['installUrl']; ?>/logo/<?php //echo $set['companyLogo']; ?>" width="100" height="100"></a>
        </div>-->
        
        <div id="error">
        <!-- error will be shown here ! -->
        </div>

        <div class="card card-container bounceOutUp">
        <img id="profile-img" class="profile-img-card" src="../images/usericon.png" />
            <p id="profile-name" class="profile-name-card"></p>
                   
            <div class="body">
                <form id="login-form" >
                    <!--<div class="msg"><b></b></div>-->
                   
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control noAutoComplete" name="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 p-t-5">
                         <a href="pwd_recovery?<?php echo randnumber(); ?>&p=Recover your password" style="color: white;">Forgot Password?</a>
                     
                        </div>
                        <div class="col-xs-6">
                        <button type="submit" class="btn  btn-sm btnme waves-effect " name="btn-login" id="btn-login">
                        <span class="fa fa-sign-in"></span> &nbsp; Sign In
                        </button>  

                           
                        </div>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>

   </div>
</div>

   <?php include('footer2.php'); ?>