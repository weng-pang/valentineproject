<?php
session_start(); 
// 取得系統組態
include ("configure.php");



// 連結資料庫
include ("connect_db.php");


//Obtain invoice and user Information
$raw_input = $_POST['invoice_parameter'];
$userid=$_SESSION["userid_ses"];
$location=$_SESSION["location_ses"];


//Go back if nothing obtained, register.php will not update anything
$raw_input = intval($raw_input);
	if ( empty($raw_input) || $raw_input == 0 ) {
 		 Header("location:register.php");
 		 
 		 exit;
	}
// Obtain working metadata
date_default_timezone_set('Asia/Macao');
$work_code = intval(substr($raw_input,0,1));
$invoice = intval(substr($raw_input,1,5));
$current_time = time();
switch ($work_code) {
	case 2:
	// initialisaion triggered
		$sql = "INSERT INTO p1 (invoice_no,p1_time,p1_location,user_id) VALUES ($invoice,$current_time,$location,$userid)";;
		$rs = mysql_query($sql);
		
		break;
	case 3:
		//return to original invoice number
		$invoice = $invoice +'30000';
              echo 'P3 triggered.<br>';
		// query on post tables
		//p1
		$sql = "SELECT p1_time,place_name ,user_name FROM p1 p, users u, places l WHERE p.user_id = u.user_id AND p.p1_location=l.place_id AND invoice_no = $invoice ORDER BY p1_time";
		$rs = mysql_query($sql);
		$num_rows = mysql_num_rows($rs);
		 for ( $i=0; $i<$num_rows; $i++ ) {
			$p1[$i]= mysql_fetch_row($rs);}
		//p2	
		$sql = "SELECT p2_time,p2_location,user_name FROM p2 p, users u WHERE p.user_id = u.user_id AND invoice_no = $invoice ORDER BY p2_time";
		$rs = mysql_query($sql);
		$num_rows = mysql_num_rows($rs);
		 for ( $i=0; $i<$num_rows; $i++ ) {
			$p2[$i]= mysql_fetch_row($rs);}
		//p3
		$sql = "SELECT p3_time,p3_location,user_name FROM p3 p, users u WHERE p.user_id = u.user_id AND invoice_no = $invoice ORDER BY p3_time";
		$rs = mysql_query($sql);
		$num_rows = mysql_num_rows($rs);
		 for ( $i=0; $i<$num_rows; $i++ ) {
			$p3[$i]= mysql_fetch_row($rs);}
		//p4
		$sql = "SELECT p4_time,p4_location,user_name FROM p4 p, users u WHERE p.user_id = u.user_id AND invoice_no = $invoice ORDER BY p4_time";
		$rs = mysql_query($sql);
		$num_rows = mysql_num_rows($rs);
		 for ( $i=0; $i<$num_rows; $i++ ) {
			$p4[$i]= mysql_fetch_row($rs);}
		//metadata
		$sql = "SELECT start_time,end_time,print_out,gift,allocated_place FROM invoices WHERE invoice_no = $invoice";
              echo $sql.'<br>';
		$rs = mysql_query($sql);
		//insert new one if not exist
		if (mysql_num_rows($rs)=='0'){
			$sql = "INSERT INTO invoices (invoice_no,start_time,end_time,print_out,gift) VALUES($invoice,'0','0','1','0')";
			$rs = mysql_query($sql);
			//check again
			$sql = "SELECT start_time,end_time,print_out,gift,allocated_place FROM invoices WHERE invoice_no = $invoice";
			$rs = mysql_query($sql);
		} else{
			$sql = "UPDATE invoices SET print_out=print_out+1 WHERE invoice_no = $invoice";
                     echo $sql.'<br>';
			$rs = mysql_query($sql);
			//check again
			$sql = "SELECT start_time,end_time,print_out,gift,allocated_place FROM invoices WHERE invoice_no = $invoice";
			$rs = mysql_query($sql);
		}
		$pm = mysql_fetch_row($rs);
		//store back to register.php
		$_SESSION["p1_ses"] = $p1;
		$_SESSION["p2_ses"] = $p2;
		$_SESSION["p3_ses"] = $p3;
		$_SESSION["p4_ses"] = $p4;
		$_SESSION["pm_ses"] = $pm;
		$_SESSION["invoice_ses"] = $invoice;
		$_SESSION["progress_ses"] = 'q';
		break;
	case 4:
	// product is completed
		$sql = "INSERT INTO p2 (invoice_no,p2_time,p2_location,user_id) VALUES ($invoice,$current_time,$location,$userid)";;
		$rs = mysql_query($sql);
		break;
	case 6:
	// product is sent for delivery
		$sql = "INSERT INTO p3 (invoice_no,p3_time,p3_location,user_id) VALUES ($invoice,$current_time,$location,$userid)";;
		$rs = mysql_query($sql);
		break;
        case 8:
		//return to original invoice number
		$invoice = $invoice +'80000';
              echo 'P3 triggered.<br>';
		// query on post tables
		//p1
		$sql = "SELECT p1_time,place_name ,user_name FROM p1 p, users u, places l WHERE p.user_id = u.user_id AND p.p1_location=l.place_id AND invoice_no = $invoice ORDER BY p1_time";
		$rs = mysql_query($sql);
		$num_rows = mysql_num_rows($rs);
		 for ( $i=0; $i<$num_rows; $i++ ) {
			$p1[$i]= mysql_fetch_row($rs);}
		//p2	
		$sql = "SELECT p2_time,p2_location,user_name FROM p2 p, users u WHERE p.user_id = u.user_id AND invoice_no = $invoice ORDER BY p2_time";
		$rs = mysql_query($sql);
		$num_rows = mysql_num_rows($rs);
		 for ( $i=0; $i<$num_rows; $i++ ) {
			$p2[$i]= mysql_fetch_row($rs);}
		//p3
		$sql = "SELECT p3_time,p3_location,user_name FROM p3 p, users u WHERE p.user_id = u.user_id AND invoice_no = $invoice ORDER BY p3_time";
		$rs = mysql_query($sql);
		$num_rows = mysql_num_rows($rs);
		 for ( $i=0; $i<$num_rows; $i++ ) {
			$p3[$i]= mysql_fetch_row($rs);}
		//p4
		$sql = "SELECT p4_time,p4_location,user_name FROM p4 p, users u WHERE p.user_id = u.user_id AND invoice_no = $invoice ORDER BY p4_time";
		$rs = mysql_query($sql);
		$num_rows = mysql_num_rows($rs);
		 for ( $i=0; $i<$num_rows; $i++ ) {
			$p4[$i]= mysql_fetch_row($rs);}
		//metadata
		$sql = "SELECT start_time,end_time,print_out,gift,allocated_place FROM invoices WHERE invoice_no = $invoice";
              echo $sql.'<br>';
		$rs = mysql_query($sql);
		//insert new one if not exist
		if (mysql_num_rows($rs)=='0'){
			$sql = "INSERT INTO invoices (invoice_no,start_time,end_time,print_out,gift) VALUES($invoice,'0','0','1','0')";
			$rs = mysql_query($sql);
			//check again
			$sql = "SELECT start_time,end_time,print_out,gift,allocated_place FROM invoices WHERE invoice_no = $invoice";
			$rs = mysql_query($sql);
		} else{
			$sql = "UPDATE invoices SET print_out=print_out+1 WHERE invoice_no = $invoice";
                     echo $sql.'<br>';
			$rs = mysql_query($sql);
			//check again
			$sql = "SELECT start_time,end_time,print_out,gift,allocated_place FROM invoices WHERE invoice_no = $invoice";
			$rs = mysql_query($sql);
		}
		$pm = mysql_fetch_row($rs);
		//store back to register.php
		$_SESSION["p1_ses"] = $p1;
		$_SESSION["p2_ses"] = $p2;
		$_SESSION["p3_ses"] = $p3;
		$_SESSION["p4_ses"] = $p4;
		$_SESSION["pm_ses"] = $pm;
		$_SESSION["invoice_ses"] = $invoice;
		$_SESSION["progress_ses"] = 'q';
		break;
	case 9:
	// invocie is completed
		$sql = "INSERT INTO p4 (invoice_no,p4_time,p4_location,user_id) VALUES ($invoice,$current_time,$location,$userid)";;
		$rs = mysql_query($sql);
		break;
	default:
	//nothing, just return to register.php
	 	 Header("location:register.php");
	 	 $_SESSION["progress_ses"]= 'n';
 		 exit;
}
if ($work_code != 3 && $work_code != 8){
$rows_affected = mysql_affected_rows($link);
$_SESSION["rows_ses"] = $rows_affected; 
$_SESSION["progress_ses"]= 'u';
$_SESSION["invoice_ses"] = $invoice;
if (mysql_errno()) {
  $_SESSION['error_ses'] = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>";
$error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
  echo $error;
  
 } 
 }
echo '<br>';
echo $rows_affected;
echo '<br>';
echo $invoice;
echo '<br>';
echo $work_code;
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
// Tasks completed, return to register.php

Header("location:register.php");


?>
