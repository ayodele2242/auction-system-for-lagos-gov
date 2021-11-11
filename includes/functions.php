<?php
session_start();
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
require_once("{$base_dir}config{$ds}configs.php");
include_once('en.php');
include_once('paginator.php');

	/*
     * Functions to format Dates and/or Times from the database
	 * http://php.net/manual/en/function.date.php for a full list of format characters
	 * Uncomment (remove the double slash - //) from the one you want to use
	 * Comment (Add a double slash - //) to the front of the ones you do NOT to use
	 * If you have any questions at all, please contact me through my CodeCanyon profile.
	 * http://codecanyon.net/user/Luminary
     *
     * @param string $v   		The database value (ie. 2014-10-31 20:00:00)
     * @return string           The formatted Date and/or Time
     */
	 function randnumber(){
	$length = 1000;
	return $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);	 
	 }

	 function underscore($str) {
		return ucwords(str_replace("_", " ", $str));
	}
	 
	 function currency(){
	 $currency = 'Naira';
	 return $currency;
	 }
	 
	 //adding seperator to money in thousand, million etc
	 function parseCurrency($value) {
    if ( intval($value) == $value ) {
        $return = number_format($value, 0, ".", ",");
    }
    else {
        $return = number_format($value, 2, ".", ",");
        /*
        If you don't want to remove trailing zeros from decimals,
        eg. 19.90 to become: 19.9, remove the next line
        */
        $return = rtrim($return, 0);
    }

    return $return;
}
	 
	function dateFormat($v) {
		// $theDate = date("Y-m-d",strtotime($v));				// 2014-10-31
		// $theDate = date("m-d-Y",strtotime($v));				// 10-31-2014
		$theDate = date("F d, Y",strtotime($v));				// October 31, 2014
		return $theDate;
	}
	function dateTimeFormat($v) {
		// $theDateTime = date("Y-m-d g:i a",strtotime($v));	// 2014-10-31 8:00 pm
		// $theDateTime = date("m-d-Y g:i a",strtotime($v));	// 10-31-2014 8:00 pm
		$theDateTime = date("F d, Y at g:i a",strtotime($v));	// October 31, 2014 8:00 pm
		return $theDateTime;
	}
	function timeFormat($v) {
		$theTime = date("g:i a",strtotime($v));					// 8:00 pm
		return $theTime;
	}
	function dbDateFormat($v) {
		$theTime = date("Y-m-d",strtotime($v));					// 2014-10-31
		return $theTime;
	}
	function dbTimeFormat($v) {
		$theTime = date("H:i",strtotime($v));		// 20:00
		return $theTime;
	}

    /*
     * Function to show an Alert type Message Box
     *
     * @param string $message   The Alert Message
     * @param string $icon      The Font Awesome Icon
     * @param string $type      The CSS style to apply
     * @return string           The Alert Box
     */
    function alertBox($message, $icon = "", $type = "") {
        return "<div class=\"alertMsg alert-dismissible $type\" id=\"fades\"><span>$icon</span> $message </div>";
	}
	

//Encryption function
function easy_crypt($string) {
    return base64_encode($string . "_@#!@");
}

//Decodes encryption
function easy_decrypt($str) {
    $str = base64_decode($str);
    return str_replace("_@#!@", "", $str);
}

function getParentCategoryName($id) {
    global $db_con;
    $sql = "SELECT * FROM mp_pages WHERE 1 AND page_id = :id";
    try {
        $stmt = $db_con->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $results = $stmt->fetchAll();
    } catch (Exception $ex) {
        echo errorMessage($ex->getMessage());
    }
    
   return ($results[0]["page_title"] <> "" ) ? $results[0]["page_title"] : "None";
}

function getPageDetailsByName($pageAlias) {
    global $db_con;
    $rs = array();
    $sql = "SELECT * FROM mp_pages WHERE 1 AND page_alias = :pname";
    
    try {
        $stmt = $db_con->prepare($sql);
        $stmt->bindValue(":pname", $pageAlias);
        $stmt->execute();
        $results = $stmt->fetchAll();
    } catch (Exception $ex) {
        echo errorMessage($ex->getMessage());
    }

    if (count($results) > 0) {
       $rs =  $results[0];
    }
    return $rs;
}	

function strlimit($value, $limit = 250, $end = '...')
{
    if (mb_strwidth($value, 'UTF-8') <= $limit) {
        return $value;
    }

    return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
}


    /*
     * Function to ellipse-ify text to a specific length
     *
     * @param string $text      The text to be ellipsified
     * @param int    $max       The maximum number of characters (to the word) that should be allowed
     * @param string $append    The text to append to $text
     * @return string           The shortened text
     */
    function ellipsis($text, $max = '', $append = '&hellip;') {
        if (strlen($text) <= $max) return $text;

        $replacements = array(
            '|<br /><br />|' => ' ',
            '|&nbsp;|' => ' ',
            '|&rsquo;|' => '\'',
            '|&lsquo;|' => '\'',
            '|&ldquo;|' => '"',
            '|&rdquo;|' => '"',
        );

        $patterns = array_keys($replacements);
        $replacements = array_values($replacements);

        // Convert double newlines to spaces.
        $text = preg_replace($patterns, $replacements, $text);
        // Remove any HTML.  We only want text.
        $text = strip_tags($text);
        $out = substr($text, 0, $max);
        if (strpos($text, ' ') === false) return $out.$append;
        return preg_replace('/(\W)&(\W)/', '$1&amp;$2', (preg_replace('/\W+$/', ' ', preg_replace('/\w+$/', '', $out)))).$append;
    }

    /*
     * Function to Encrypt sensitive data for storing in the database
     *
     * @param string	$value		The text to be encrypted
	 * @param 			$encodeKey	The Key to use in the encryption
     * @return						The encrypted text
     */
	function encryptIt($value) {
		// The encodeKey MUST match the decodeKey
		$encodeKey = 'swGn@7q#5y0z%E4!C#5y@9Tx@';
		$encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($encodeKey), $value, MCRYPT_MODE_CBC, md5(md5($encodeKey))));
		return($encoded);
	}

    /*
     * Function to decrypt sensitive data from the database for displaying
     *
     * @param string	$value		The text to be decrypted
	 * @param 			$decodeKey	The Key to use for decryption
     * @return						The decrypted text
     */
	function decryptIt($value) {
		// The decodeKey MUST match the encodeKey
		$decodeKey = 'swGn@7q#5y0z%E4!C#5y@9Tx@';
		$decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($decodeKey), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($decodeKey))), "\0");
		return($decoded);
	}

	/*
     * Function to strip slashes for displaying database content
     *
     * @param string	$value		The string to be stripped
     * @return						The stripped text
     */
	function clean($value) {
		$str = str_replace('\\', '', $value);
		return $str;
	}
	
	function slug($text){ 

  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}

function get_timeago( $ptime )
{
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $mysqlidition = array(
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $mysqlidition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}

function class_maillist($class) {

	$emails = array();

	$query = "SELECT email FROM users WHERE grad_year = '$class'";
	$result = mysqli_query($mysqli, $query);
	$j = mysqli_fetch_array($result);
	$emails[] = $j['email'];
	while($row = mysqli_fetch_array($result)) {
		$emails[] .= implode("\t", $row);
	}
	$emails = implode(",", $emails);
	return $emails;
	
}

function echo_class_maillist($class) {

	$emails = array();

	$query = "SELECT email FROM users WHERE grad_year = '$class'";
	$result = mysqli_query($mysqli, $query);
	$j = mysqli_fetch_array($result);
	$emails[] = $j['email'];
	while($row = mysqli_fetch_array($result)) {
		$emails[] .= implode("\t", $row);
	}
	$emails = implode(",", $emails);
	echo $emails;
	
}

function getSlider(){
	global $mysqli;
	$get_slider = "select * from slider";
	$run_slider = mysqli_query($mysqli, $get_slider);
	while($row_slider=mysqli_fetch_array($run_slider)){
		//$slider_id = $row_slider['slider_id'];
		$slider_file = $row_slider['slider_file'];
		$slider_img_text = $row_slider['slider_img_text'];
		echo "<li><img src='image/img/$slider_file' title='$slider_img_text'></li>";
	}
}


function getNotice1(){
	global $mysqli;
	$getright = "SELECT * FROM `notice` WHERE `notice_cat` = '1' ORDER BY `notice`.`notice_id` DESC LIMIT 3 ";
	$getright_run = mysqli_query($mysqli, $getright);
	while($getright_row = mysqli_fetch_array($getright_run)){
		$notice_name = $getright_row['notice_name'];
		$notice_date = $getright_row['notice_date'];
		$notice_path = $getright_row['notice_path'];
		echo "<a href='$notice_path' style='color: rgb(6, 49, 102);'><div class='right'>
						<div class='rname'>
							<h3>$notice_name</h3>
						</div>
						<div class='rdate'>
							Date: $notice_date
						</div>
						
					</div></a>";
	}
}


function getNotice2(){
	global $mysqli;
	$getright = "SELECT * FROM `notice` WHERE `notice_cat` = '2' ORDER BY `notice`.`notice_id` DESC LIMIT 3 ";
	$getright_run = mysqli_query($mysqli, $getright);
	while($getright_row = mysqli_fetch_array($getright_run)){
		$notice_name = $getright_row['notice_name'];
		$notice_date = $getright_row['notice_date'];
		$notice_path = $getright_row['notice_path'];
		echo "<a href='$notice_path' style='color: rgb(6, 49, 102);'><div class='right'>
						<div class='rname'>
							<h3>$notice_name</h3>
						</div>
						<div class='rdate'>
							Date: $notice_date
						</div>
						
					</div></a>";
	}
}

function getNotice3(){
	global $mysqli;
	$getright = "SELECT * FROM `notice` WHERE `notice_cat` = '3' ORDER BY `notice`.`notice_id` DESC LIMIT 3 ";
	$getright_run = mysqli_query($mysqli, $getright);
	while($getright_row = mysqli_fetch_array($getright_run)){
		$notice_name = $getright_row['notice_name'];
		$notice_date = $getright_row['notice_date'];
		$notice_path = $getright_row['notice_path'];
		echo "<a href='$notice_path' style='color: rgb(6, 49, 102);'><div class='right'>
						<div class='rname'>
							<h3>$notice_name</h3>
						</div>
						<div class='rdate'>
							Date: $notice_date
						</div>
						
					</div></a>";
	}
}


function getNotice4(){
	global $mysqli;
	$getright = "SELECT * FROM `notice` WHERE `notice_cat` = '4' ORDER BY `notice`.`notice_id` DESC LIMIT 3 ";
	$getright_run = mysqli_query($mysqli, $getright);
	while($getright_row = mysqli_fetch_array($getright_run)){
		$notice_name = $getright_row['notice_name'];
		$notice_date = $getright_row['notice_date'];
		$notice_path = $getright_row['notice_path'];
		echo "<a href='$notice_path' style='color: rgb(6, 49, 102);'><div class='right'>
						<div class='rname'>
							<h3>$notice_name</h3>
						</div>
						<div class='rdate'>
							Date: $notice_date
						</div>
						
					</div></a>";
	}
}


function getNotice5(){
	global $mysqli;
	$getright = "SELECT * FROM `notice` WHERE `notice_cat` = '5' ORDER BY `notice`.`notice_id` DESC LIMIT 3 ";
	$getright_run = mysqli_query($mysqli, $getright);
	while($getright_row = mysqli_fetch_array($getright_run)){
		$notice_name = $getright_row['notice_name'];
		$notice_date = $getright_row['notice_date'];
		$notice_path = $getright_row['notice_path'];
		echo "<a href='$notice_path' style='color: rgb(6, 49, 102);'><div class='right'>
						<div class='rname'>
							<h3>$notice_name</h3>
						</div>
						<div class='rdate'>
							Date: $notice_date
						</div>
						
					</div></a>";
	}
}



function getSMSGroup(){
	global $mysqli;
	$ccsql="SELECT * FROM `sms_group` ";
		$ccsql_run = mysqli_query($mysqli, $ccsql);

		while ($ccsql_get=mysqli_fetch_array($ccsql_run)) {
			$id = $ccsql_get['id'];
			$class_name = $ccsql_get['group_name'];
			echo "<option value=".$id.">$class_name</option>";
	}
}


function getClassN(){
	global $mysqli;
	$ccsql="SELECT * FROM `class` ";
		$ccsql_run = mysqli_query($mysqli, $ccsql);

		while ($ccsql_get=mysqli_fetch_array($ccsql_run)) {
			$class_name = $ccsql_get['class'];
			//$numeric_value = $ccsql_get['numeric_value'];
			echo "<option value='".$class_name."'>$class_name</option>";
	}
}


function getFrom(){
	global $mysqli;
	$ccsql="SELECT distinct(present_loc) as loc FROM `routes` ";
		$ccsql_run = mysqli_query($mysqli, $ccsql);

		while ($ccsql_get=mysqli_fetch_array($ccsql_run)) {
			$class_name = $ccsql_get['loc'];
			echo "<option>$class_name</option>";
	}
}

function getExamtype(){
	global $mysqli;
	$ccsql="SELECT * FROM `exam_type` ";
		$ccsql_run = mysqli_query($mysqli, $ccsql);

		while ($ccsql_get=mysqli_fetch_array($ccsql_run)) {
			$class_name = $ccsql_get['exam_type'];
			echo "<option>$class_name</option>";
	}
}
function getGroup(){
	global $mysqli;
	$ccsql="SELECT * FROM `group_type` ";
		$ccsql_run = mysqli_query($mysqli, $ccsql);

		while ($ccsql_get=mysqli_fetch_array($ccsql_run)) {
			$class_name = $ccsql_get['group_name'];
			echo "<option>$class_name</option>";
	}
}

function getAccount(){
	global $mysqli;
	$ccsql="SELECT * FROM `account_info` ";
		$ccsql_run = mysqli_query($mysqli, $ccsql);

		while ($ccsql_get=mysqli_fetch_array($ccsql_run)) {
			$class_name = $ccsql_get['ac_number'];
			echo "<option>$class_name</option>";
	}
}




function getGrade($mark){
	if($mark>=80){
		$grade = 'A+';
	}else if($mark<=79&&$mark>=70){
		$grade = 'A';
	}else if($mark<=69&&$mark>=60){
		$grade = 'A-';
	}else if($mark<=59&&$mark>=50){
		$grade = 'B';
	}else if($mark<=49&&$mark>=40){
		$grade = 'C';
	}else if($mark<=39&&$mark>=33){
		$grade = 'D';
	}else if($mark<=32&&$mark>=0){
		$grade = 'F';
	}

	return $grade;
}



function getMonth(){
	echo '<option value="01">January</option>
	<option value="02">February</option>
	<option value="03">March</option>
	<option value="04">April</option>
	<option value="05">May</option>
	<option value="06">June</option>
	<option value="07">July</option>
	<option value="08">August</option>
	<option value="09">September</option>
	<option value="10">October</option>
	<option value="11">November</option>
	<option value="12">December</option>';
}

function getMonthName($month){
	if ($month == 1) {
		$month_name = "January";
	}else if ($month == 2) {
		$month_name = "February";
	}else if ($month == 3) {
		$month_name = "March";
	}else if ($month == 4) {
		$month_name = "April";
	}else if ($month == 5) {
		$month_name = "May";
	}else if ($month == 6) {
		$month_name = "June";
	}else if ($month == 7) {
		$month_name = "July";
	}else if ($month == 8) {
		$month_name = "August";
	}else if ($month == 9) {
		$month_name = "September";
	}else if ($month == 10) {
		$month_name = "October";
	}else if ($month == 11) {
		$month_name = "November";
	}else if ($month == 12) {
		$month_name = "December";
	}
	return $month_name;
}

function sendShortSMS($sms,$num){
	global $mysqli;
	$sql="SELECT * FROM `sms_config` ";
	$sql_run = mysqli_query($mysqli, $sql);
	$sql_get=mysqli_fetch_array($sql_run);

		$username = $sql_get['username'];
		$pass = $sql_get['pass'];
		$sender = $sql_get['sender'];
		$sms = urlencode($sms);

		//$str = file("http://app.itsolutionbd.net/api/sendsms/plain?user=".$username."&password=".$pass."&sender=".$sender."&SMSText=".$sms."&GSM=".$num."");
		//var_dump($str);
}



function sendLongSMS($sms,$num){
	global $mysqli;
	$sql="SELECT * FROM `sms_config` ";
	$sql_run = mysqli_query($mysqli, $sql);
	$sql_get=mysqli_fetch_array($sql_run);

		$username = $sql_get['username'];
		$pass = $sql_get['pass'];
		$sender = $sql_get['sender'];
		$sms = urlencode($sms);

		//$str = file("http://app.itsolutionbd.net/api/v3/sendsms/plain?user=".$username."&password=".$pass."&sender=".$sender."&SMSText=".$sms."&GSM=".$num."&type=longSMS");
		//var_dump($str);
}




$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}




//Money to words
function convertNumberToWordsForIndia($number){
	//A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
	$words = array(
	'0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
	'6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
	'11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
	'16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
	'30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
	'80' => 'eighty','90' => 'ninty');
	
	//First find the length of the number
	$number_length = strlen($number);
	//Initialize an empty array
	$number_array = array(0,0,0,0,0,0,0,0,0);        
	$received_number_array = array();
	
	//Store all received numbers into an array
	for($i=0;$i<$number_length;$i++){    $received_number_array[$i] = substr($number,$i,1);    }

	//Populate the empty array with the numbers received - most critical operation
	for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ $number_array[$i] = $received_number_array[$j]; }
	$number_to_words_string = "";        
	//Finding out whether it is teen ? and then multiplying by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
	for($i=0,$j=1;$i<9;$i++,$j++){
		if($i==0 || $i==2 || $i==4 || $i==7){
			if($number_array[$i]=="1"){
				$number_array[$j] = 10+$number_array[$j];
				$number_array[$i] = 0;
			}        
		}
	}
	
	$value = "";
	for($i=0;$i<9;$i++){
		if($i==0 || $i==2 || $i==4 || $i==7){    $value = $number_array[$i]*10; }
		else{ $value = $number_array[$i];    }            
		if($value!=0){ $number_to_words_string.= $words["$value"]." "; }
		if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
		if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
		if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
		if($i==6 && $value!=0){    $number_to_words_string.= "Hundred &amp; "; }
	}
	if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
	return ucwords(strtolower($number_to_words_string)." Only.");
}




function convert_number_to_words($number) {
    $hyphen      = ' ';
    $mysqlijunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    if (!is_numeric($number)) {
        return false;
    }
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }
    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    $string = $fraction = null;
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $mysqlijunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $mysqlijunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}

	 
function getNavigation($row){
	//global $mysqli;
 echo "<li class='nav-item'><a class='nav-link' href=index.php?nav_id={$row['id']}&parent_id={$row['parent_id']}";
 if(isset($_GET['nav_id'])
 && $_GET['nav_id']==($row['id'])){
 echo " class=\"selected\"";
 }
 /*
 if(isset($_GET['parent_id']) 
 && $_GET['parent_id']==($row['id'])){
 echo " class=\"selected\"";
 }*/
 echo ">".$row['name']."</a>";
 $select_subnav="select * from navigation_bar where parent_id=".$row['id']. " order
  by position ";
 $run_subnav=mysqli_query($mysqli,$select_subnav);
 if(mysqli_num_rows($run_subnav)>0){
	 echo "<ul>";
	 while($row=mysqli_fetch_array($run_subnav)){
		  getNavigation($row);
		 }
	 echo "</ul>";
	 }
	 echo "</li>";
	}
	
	
	// getting category list
	function cat_list($p_id=0,$space=''){  
     global $mysqli;
    $q="SELECT * FROM navigation_bar WHERE parent_id='$p_id' order by position ASC ";  
$r=mysqli_query($mysqli,$q);  
 $count=mysqli_num_rows($r);  
 
if($p_id==0){  
    $space='';  
}else{  
   $white_space= "&nbsp; &nbsp; &nbsp;";
   
    $space = $space . $white_space;
}  
if($count > 0){  
      
    while($row=mysqli_fetch_array($r)){  
	    
        echo "<option value=".$row['id'].">".$space.$row['name']."</option>";  
          
        cat_list($row['id'],$space);  
    }  
      
}  
  
  
}  	

function edit_cat_list($p_id=0,$space=''){  
     global $mysqli;
    $q="SELECT * FROM navigation_bar WHERE parent_id='$p_id' order by position ASC ";  
$r=mysqli_query($mysqli,$q);  
 $count=mysqli_num_rows($r);  
 
if($p_id==0){  
    $space='';  
}else{  
   $white_space= "&nbsp; &nbsp; &nbsp;";
   
    $space = $space . $white_space;
}  
if($count > 0){  
      
    while($row=mysqli_fetch_array($r)){ 
	    
	    $edit_navid=$row['id'];
        echo "<option value=".$row['id']."";
		// selected menu for edit navigation
		if(isset($_GET['parent_id'])){
		$pid=$_GET['parent_id'];
		if($pid==$edit_navid){
		echo " selected ";
		}else{echo " ";}
		}
		// selected menu for edit post
		if(isset($_GET['menu_id'])){
			$menu_id=$_GET['menu_id'];
			if($menu_id==$edit_navid ){
				echo " selected " ;
				}else{echo "";}
			}	
					
		echo ">".$space.$row['name']."</option>";  
        edit_cat_list($row['id'],$space);  
    }  
 }  
} 


function selected_parent($p_id=0,$space=''){  
     global $mysqli;
    $q="SELECT * FROM navigation_bar WHERE parent_id='$p_id' order by position ASC ";  
$r=mysqli_query($mysqli,$q);  
 $count=mysqli_num_rows($r);  
 
if($p_id==0){  
    $space='';  
}else{  
   $white_space= "&nbsp; &nbsp; &nbsp;";
   
    $space = $space . $white_space;
}  
if($count > 0){  
      
    while($row=mysqli_fetch_array($r)){  
	    $nav_id=$row['id'];
        echo "<option value=".$row['id']."";
		if(isset($_GET['select_pid'])){
			$select_pid=$_GET['select_pid'];
			if($select_pid==$nav_id){
				echo " selected " ;
				
				}else{echo "";}
			}
		echo ">".$space.$row['name']."</option>";  
          
        selected_parent($row['id'],$space);  
    }  
   }  
 }  

 //Generate invoice number
 function invoice_num ($input, $pad_len = 7, $prefix = null) {
    if ($pad_len <= strlen($input))
        trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

    if (is_string($prefix))
        return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

    return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
}

//Generate from database
$query = "SELECT MAX(CAST(cid as decimal))cid from tbl_courier";
			if($result = mysqli_query($mysqli,$query))
			{
				$rowy = mysqli_fetch_assoc($result);
				$count = $rowy['cid'];
				$count = $count+1;
				$code_no = str_pad($count, 4, "0", STR_PAD_LEFT);
			}
			$str = substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 3);	

			function assign_rand_value($num)
{
// accepts 1 - 36
  switch($num)
  {
    case "1":
     $rand_value = "a";
    break;
    case "2":
     $rand_value = "b";
    break;
    case "3":
     $rand_value = "c";
    break;
    case "4":
     $rand_value = "d";
    break;
    case "5":
     $rand_value = "e";
    break;
    case "6":
     $rand_value = "f";
    break;
    case "7":
     $rand_value = "g";
    break;
    case "8":
     $rand_value = "h";
    break;
    case "9":
     $rand_value = "i";
    break;
    case "10":
     $rand_value = "j";
    break;
    case "11":
     $rand_value = "k";
    break;
    case "12":
     $rand_value = "l";
    break;
    case "13":
     $rand_value = "m";
    break;
    case "14":
     $rand_value = "n";
    break;
    case "15":
     $rand_value = "o";
    break;
    case "16":
     $rand_value = "p";
    break;
    case "17":
     $rand_value = "q";
    break;
    case "18":
     $rand_value = "r";
    break;
    case "19":
     $rand_value = "s";
    break;
    case "20":
     $rand_value = "t";
    break;
    case "21":
     $rand_value = "u";
    break;
    case "22":
     $rand_value = "v";
    break;
    case "23":
     $rand_value = "w";
    break;
    case "24":
     $rand_value = "x";
    break;
    case "25":
     $rand_value = "y";
    break;
    case "26":
     $rand_value = "z";
    break;
    case "27":
     $rand_value = "0";
    break;
    case "28":
     $rand_value = "1";
    break;
    case "29":
     $rand_value = "2";
    break;
    case "30":
     $rand_value = "3";
    break;
    case "31":
     $rand_value = "4";
    break;
    case "32":
     $rand_value = "5";
    break;
    case "33":
     $rand_value = "6";
    break;
    case "34":
     $rand_value = "7";
    break;
    case "35":
     $rand_value = "8";
    break;
    case "36":
     $rand_value = "9";
    break;
  }
return $rand_value;
}

function get_rand_id($length)
			{
			  if($length>0) 
			  { 
			  $rand_id="";
			   for($i=1; $i<=$length; $i++)
			   {
			   mt_srand((double)microtime() * 1000000);
			   $num = mt_rand(1,36);
			   $rand_id .= assign_rand_value($num);
			   }
			  }
			return $rand_id;
            } 	
            
            
 //Biding system

 // Get increment for a current bid price
  function getIncrement( $current )
 {
     $increment = null;

     if ( 0.01 <= $current && $current <= 0.99 )
     {
         $increment = 0.05;
     }
     else if ( 1.00 <= $current && $current <= 4.99 )
     {
         $increment = 0.20;
     }
     else if ( 5.00 <= $current && $current <= 14.99 )
     {
         $increment = 0.50;
     }
     else if ( 15.00 <= $current && $current <= 59.99 )
     {
         $increment = 1.00;
     }
     else if ( 60.00 <= $current && $current <= 149.99 )
     {
         $increment = 2.00;
     }
     else if ( 150.00 <= $current && $current <= 299.99 )
     {
         $increment = 5.00;
     }
     else if ( 300.00 <= $current && $current <= 599.99 )
     {
         $increment = 10.00;
     }
     else if ( 300.00 <= $current && $current <= 599.99 )
     {
         $increment = 10.00;
     }
     else if ( 600.00 <= $current && $current <= 1499.99 )
     {
         $increment = 20.00;
     }
     else if ( 1500.00 <= $current && $current <= 2999.99 )
     {
         $increment = 50.00;
     }
     else
     {
         $increment = 100.00;
     }


     return $increment;
 }

            
?>