<?php
ob_start();
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
#session_start();
#error_reporting(0);
#ini_set('display_errors', '0');
date_default_timezone_set('Africa/Lagos');
set_time_limit(0);

#require_once ("../config/configs.php");
defined( "ROOT" ) ? null : define( "ROOT", "{$base_dir}" );
defined( "UPLOAD_PROFILE_IMAGE" ) ? null : define( "UPLOAD_PROFILE_IMAGE", "/images/profile_images/" );
defined( "UPLOAD_ITEM_IMAGE" ) ? null : define( "UPLOAD_ITEM_IMAGE", "/images/item_images/" );

#require 'en.php';

//Mysqli
#$db = parse_ini_file("../config/db.ini");
$dbhost = 'localhost'; //$db['host'];
$dbuser = 'root';//$db['user'];
$dbpass = '';//$db['pass'];
$dbname = 'auctionsystem';//$db['dbname'];

//Mysqli
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
	printf("MySQLi connection failed: ", mysqli_connect_error());
	exit();
}

// Change character set to utf8
if (!$mysqli->set_charset('utf8')) {
	printf('Error loading character set utf8: %s\n', $mysqli->error);
}




?>