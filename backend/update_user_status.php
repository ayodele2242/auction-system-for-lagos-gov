<?php
   include("../config/configs.php");
  $id = $_POST['userId'];
  $status = $_POST['status'];
  $query = "UPDATE users SET status = '$status' where userId =".$id;
  $update = mysqli_query($mysqli, $query);
  ?>