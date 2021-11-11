<?php
require_once "../classes/class.session_operator.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="../theme/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="../css/animate.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap-select.css" rel="stylesheet" type="text/css">
    <link href="../css/index.css" rel="stylesheet" type="text/css">
    <link href="../theme/css/mdb.min.css" rel="stylesheet">
    <link href="../theme/css/style.css" rel="stylesheet">

    <!-- JS -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-notify.min.js"></script>
</head>
<body>

    <!-- header start -->
    <div class="navbar navbar-default navbar-static-top">
        <div class="container header_container">

            <!-- header logo start -->
           <?php //include_once "../includes/header.php";?>
            <!-- header logo end -->

        </div>
    </div>
    <!-- header end -->

    <!-- main START -->
    <div class="container">

        <!-- instructions start -->
        <div class="col-xs-12">
            <h2>
                <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                Forgot your password
            </h2>
            <p class="p_instructions">
                If you forgot your password for your account, enter your email and click the 'Reset Password' button. You will then
                receive an email to change your password.
            </p>
        </div>
        <!-- instructions end -->

        <!-- forgot password start -->
        <form method="post" action="../scripts/password.php" class="row">
            <div class="col-lg-7 form-group-lg">
                <label class="text-danger">&nbsp
                    <?php echo SessionOperator::getInputErrors( "email" ); ?>
                </label>
                <input type="text" name="email" class="form-control" id="email" maxlength="45" placeholder="Enter your email here"
                    <?php echo 'value = "' . SessionOperator::getFormInput( "email" ) . '"'; ?> required>
            </div>
            <div class="col-lg-3">
                <label>&nbsp</label><br>
                <button type="submit" name="resetPassword" id="resetPassword" class="btn btn-success btn-sm">Reset Password</button>
            </div>
            <div class="col-lg-12" style="font-weight:bold;"><i class="fa fa-arrow-back"></i> <a href="../auctioneer">Back to Login Page</a></div>
        </form>
        <!-- forgot password end -->

    </div>
    <!-- main end -->

    <!-- footer start -->
    <?php //include_once "../includes/footer.php";?>
    <!-- footer end -->

</body>
</html>