<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.user.php";


// Sign in button was clicked
if ( isset( $_POST[ "signIn" ] ) )
{
    require_once "../classes/class.query_operator.php";
    require_once "../classes/class.session_operator.php";
    $email = trim( $_POST[ "loginEmail" ] );
    $password = trim( $_POST[ "loginPassword" ] );

    // Login details correct
    if ( !is_null( $account = QueryOperator::checkAccount( $email, $password ) ) )
    {
        // Login user and redirect to home page
        SessionOperator::login( new User ( $account ) );
        HelperOperator::redirectTo( "../views/my_live_auctions_view.php" );
    }
    // Login failed
    else
    {
        // Create a session for the login inputs so that they can be recovered after the page reloads
        SessionOperator::setFormInput( [
                "loginEmail" => $email,
                "loginPassword" => $password ] );

        // Create a session for incorrect email and user details
        $message = "Invalid details entered or account not active at the moment.";
        SessionOperator::setInputErrors( [ "login" => $message ] );
    }
}

// Sign in button was not clicked or sign in failed
HelperOperator::redirectTo( "../auctioneer.php" );
