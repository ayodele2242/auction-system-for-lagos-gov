<?php
session_start();
$id = $_SESSION['account_id'];
include($_SERVER['DOCUMENT_ROOT']."/augeo/global/php/connection.php");

$result = mysqli_query($conn,"SELECT * FrOm augeo_user_end.user where augeo_user_end.user.account_id = '$id' ");
          $found = mysqli_fetch_array($result);
echo $found['profile_img'];


          ?>