<?php
// Logout
include('../includes/admins.php');  
if (isset($_GET['action'])) {
    $action = $_GET['action'];
	$act = "User Logged Out";
    if ($action == 'logout') {
        session_destroy();
        header("Location: sign-in");
		 mysqli_query($mysqli, "insert into user_log (username,name,action,time, user_id, mydate, mtime)values('$uname','$fullname','$act', '$tv', '$id', '$t', '$tv')");
    }
}

?>