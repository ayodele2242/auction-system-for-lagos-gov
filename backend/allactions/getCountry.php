<?php
    
    include('../../includes/config.php');

    $q = strtolower($_GET["q"]);
    if (!$q) return;

    $sql = "select name as value from country WHERE name LIKE '$q%'";

    /*$sql = "SELECT class FROM class 
    WHERE class LIKE '%".$_GET['query']."%'
    LIMIT 10"; */
    $rsd = mysqli_query($mysqli, $sql); 
    while($rs = mysqli_fetch_assoc($rsd)) {
        $rows[]=$rs;
    }
    
    print json_encode($rows);
?>