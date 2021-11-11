<?php
if (!isset($_COOKIE["redirect"])){
    header("Location: main");
} else {
    header("Location: ".$_COOKIE["redirect"]);
}

?>