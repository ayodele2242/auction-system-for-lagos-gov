<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['account_id'])) {
    $redir_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    header($_SERVER['SERVER_PROTOCOL']." 302 Found");
    header("Location: http://localhost/augeo/login?redir=".$redir_link);
    exit();
}
elseif(isset($_GET['logout'])) {
    require_once "connection.php";
    $id = $_SESSION['account_id'];
    $log_id = $_SESSION['log_id'];
    setcookie("account_id", $id, time() - (86400 * 30), "/");
    $date = date_create();
    $date = date_format($date, 'Y-m-d H:i:s');
    mysqli_query($conn,"UPDATE user_logtime set user_logtime.logout_time = '$date' WHERE logtime_id = '$log_id'");
    unset($_SESSION['account_id']);
    session_destroy();
    header("Location: http://localhost/augeo/login");
    exit();
}
elseif(isset($_SESSION['account_id'])) {
    $account_id_session = $_SESSION['account_id'];
}

?>