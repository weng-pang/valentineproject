<?php
session_start(); 
// 取得系統組態
include ("configure.php");

// 連結資料庫
include ("connect_db.php");
//Prepare date parameter
date_default_timezone_set('Asia/Macao');
$current_time = time();
$expected_date = "02/14/2012";
echo $_SESSION["progress_ses"].'<br>';
//Check button entry

if ($_POST['b1'] == 'Return'){
	// Go back to original form
	$_SESSION["progress_ses"] ='n';
	Header("location:prereg.php");
	exit;
}
echo 'Passed through check button.<br>';
//Obtain invoice and user Information
if ($_SESSION["progress_ses"]!= 'r' && $_SESSION["progress_ses"] != 's'){
	//No need to update if form is here
	
	$raw_input = $_POST['invoice_parameter'];} else {
		echo 'No need to update invoice no.<br>';
	$raw_input = $_SESSION["invoice_ses"];}
	
$userid=$_SESSION["userid_ses"];
$location=$_SESSION["location_ses"];

//Obtain further information if in registration mode.
if ($_SESSION["progress_ses"]== 'r' || $_SESSION["progress_ses"] == 's'){
	$start_delivery_str =mysql_escape_string( $_POST['start_parameter']);
	$end_delivery_str =mysql_escape_string( $_POST['end_parameter']);
	$gifts = (int)mysql_escape_string($_POST['gift_parameter']);
	$location = (int)mysql_escape_string($_POST['location_parameter']);
	echo 'start_delivery='.$start_delivery_str.'<br>end_delivery='.$end_delivery_str.'<br>';
	$start_delivery_str = $expected_date." ".$start_delivery_str;
	$end_delivery_str = $expected_date." ".$end_delivery_str;
	$start_delivery = strtotime($start_delivery_str);
	$end_delivery = strtotime($end_delivery_str);
	echo 'start_delivery='.$start_delivery.'<br>end_delivery='.$end_delivery.'<br>';
	if ($start_delivery == false){
		echo 'time failure';}
		// Validation : check correct data are entered.
		if ($start_delivery > $end_delivery || $end_delivery == null || $end_delivery =="0"){
			$_SESSION["messsage_ses"] = "Incorrect time entered.";
			// Throw back previously entered data.
			$pm[1] = $start_delivery;
			$pm[2] = $end_delivery;
			$pm[3] = $gifts;
			exit;
			}
			
		}

//Go back if nothing obtained, prereg.php will not do anything
$raw_input = intval($raw_input);
	if ( empty($raw_input) || $raw_input == 0 ) {
 		 Header("location:prereg.php");
 		
 		 exit;
	}
// Obtain working metadata

$work_code = intval(substr($raw_input,0,1));
if ($work_code !=3 && $work_code !=8){
$invoice = intval(substr($raw_input,1,5)); //retain for safe bet
} else {
	$invoice = $raw_input;
	}


echo 'passed through prepare procedures.<br>';
// Queries start here
if ($_SESSION["progress_ses"]!= 'r' && $_SESSION["progress_ses"] != 's'){
	echo 'Start to query.<br>';
	$sql = "SELECT invoice_no, start_time, end_time, gift, allocated_place FROM invoices WHERE invoice_no = $invoice";
	$rs = mysql_query($sql);
	$num_rows = mysql_num_rows($rs);
	//Check if going to r or r1
	if ($num_rows == '0'){
			//Checked nothing in database
			$_SESSION["progress_ses"]= 'r';}
		else {
			//something presented
			$_SESSION["progress_ses"]= 's';
			//Obtain further information
			$pm =  mysql_fetch_row($rs);
			$_SESSION["pm_ses"] = $pm;}
	$_SESSION["invoice_ses"] = $invoice;
} elseif($_SESSION["progress_ses"]== 'r') {
//Give information back to database.
	echo 'Insert info triggerer.<br>';
       $username = $_SESSION["userid_ses"] ;
	$sql = "INSERT INTO invoices (invoice_no,start_time,end_time,gift,allocated_place,user_id) VALUES ($invoice,$start_delivery,$end_delivery,$gifts,$location,$username)";;
	echo $sql;
	$rs = mysql_query($sql);
	$_SESSION["progress_ses"]= 'n';
	$_SESSION["invoice_ses"] = $invoice;
} elseif($_SESSION["progress_ses"]== 's') {
	echo 'Update current Information.<br>';
	$sql = "UPDATE invoices SET start_time=$start_delivery ,end_time=$end_delivery ,gift=$gifts ,allocated_place=$location WHERE invoice_no=$invoice";;
	$rs = mysql_query($sql);
	$_SESSION["progress_ses"]= 'n';
	$_SESSION["invoice_ses"] = $invoice;
	}
	echo mysql_error();
	if (!mysql_error()){
		echo 'SQL looks Good!';
		echo '<br>';
		
		}
echo '<br>';
echo $pm[0];
echo '<br>';
echo $invoice;
echo '<br>';
echo '<br>';
echo $userid;
echo '<br>';
echo $location;
// give out results
if (mysql_errno()) {
  $_SESSION['error_ses'] = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>";
$error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
  echo $error;
  
 }

// Tasks completed, return to prereg.php

Header("location:prereg.php");


?>
