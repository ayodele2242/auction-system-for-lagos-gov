<?php
   include("../config/configs.php");
  $id = $_POST['auctionId'];
  $status = $_POST['status'];
  $query = "UPDATE auctions SET status = '$status' where auctionId =".$id;
  $update = mysqli_query($mysqli, $query);
  ?>