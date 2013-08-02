<?php
/*
=========================================================
Kaugebra Aviation and Technology Service (KATS) 2012

   queue.php
   
The application is to display current token operation as form of period of time, exclusively for Valentine Project 2012
==========================================================
APPROACHES
1. All information will be obtained from data.

2. Analysis will be performed in the following.
	2a. Combine P1, P2, P3 and P4
	2b. Take out P4 and invoice information
	2c. Display the remainder as one column as NO defined time.
	2d. SORT out invoices as matter of time order.
	
3. Display all of information in order of orders above.

4. Refresh this page in each minute.
==========================================================
Methodology of Twin-Token System

1. All invoices must be initialisated into tokens by processing stations before proceeding to any further operations.
2. Each invoice has two tokens, they are the following: (First two white invoices respectively)
	2.1 Production token: first token to be used to create the product related to the invoice.
	2.2 Delivery token: second token to be used for delivery of that product.
3. When someone is holding that piece of token, he or she must oblige to follow task from the token related. For instance, 
	when the production token is held, the task of creating the product must be performed unless forwarded to others.
4. Tokens can be transferred at anytime given clear acknowledgement and communications are tendered.
5. When token of related of task has been fullfilled, it is essential to report to processing station for token relaxation.
6. Token relaxation may be lifted if new situation is arisen - for example the product is made incorrectly or incorrect develivery procedures are made.
7. For simplicity purpose, delivery token is always attached to production token until the production is completed.  
===========================================================
*/


function array_unique_merge() { 
       $func_args = func_get_args();
       return array_unique(call_user_func_array('array_merge', $func_args)); 
   } 
// Obtain location parameter
 $location = $_GET['location'];
if (substr($location,1,1) == "s"){
  //echo 'special triggered.';
	$location = intval($location);
	$location = $location.'%';}
// obtain all information from database
	// 取得系統組態
	include ("configure.php");
	// 連結資料庫
	include ("connect_db.php");
	$p1 = array();
	$p2 = array();
	$p3 = array();
	$p4 = array();
	// Obtain P1
	($location? $sql = "SELECT i.invoice_no FROM p1 p, invoices i WHERE p.invoice_no=i.invoice_no AND allocated_place LIKE '$location' ORDER BY invoice_no" : $sql = "SELECT invoice_no FROM p1 ORDER BY invoice_no");
	$rs = mysql_query($sql);
	$num_rows_p1 = mysql_num_rows($rs);

	for ( $i=0; $i<$num_rows_p1; $i++ ) {
	$p1[] =  mysql_fetch_row($rs);}
	
	// Obtain P2
	($location? $sql = "SELECT i.invoice_no FROM p2 p, invoices i WHERE p.invoice_no=i.invoice_no AND allocated_place LIKE '$location' ORDER BY invoice_no" : $sql = "SELECT invoice_no FROM p2 ORDER BY invoice_no");
	$rs = mysql_query($sql);
	$num_rows_p2 = mysql_num_rows($rs);
	$p2[0] =  mysql_fetch_row($rs);
	for ( $i=1; $i<$num_rows_p2; $i++ ) {
	$p2[$i] =  mysql_fetch_row($rs);}
	
	// Obtain P3
	($location? $sql = "SELECT i.invoice_no FROM p3 p, invoices i WHERE p.invoice_no=i.invoice_no AND allocated_place LIKE '$location' ORDER BY invoice_no" : $sql = "SELECT invoice_no FROM p3 ORDER BY invoice_no");
	$rs = mysql_query($sql);
	$num_rows_p3 = mysql_num_rows($rs);
	$p3[0] =  mysql_fetch_row($rs);
	for ( $i=1; $i<$num_rows_p3; $i++ ) {
	$p3[$i] =  mysql_fetch_row($rs);}
	
	// Obtain P4
	($location? $sql = "SELECT i.invoice_no FROM p4 p, invoices i WHERE p.invoice_no=i.invoice_no AND allocated_place LIKE '$location' ORDER BY invoice_no" : $sql = "SELECT invoice_no FROM p4 ORDER BY invoice_no");
	$rs = mysql_query($sql);
	$num_rows_p4 = mysql_num_rows($rs);
	$p4[0] =  mysql_fetch_row($rs);
	for ( $i=1; $i<$num_rows_p4; $i++ ) {
	$p4[$i] =  mysql_fetch_row($rs);}
	
	// Obtain invoice information
	($location? $sql = "SELECT invoice_no, start_time, end_time FROM invoices WHERE allocated_place LIKE '$location' ORDER BY invoice_no" : $sql = "SELECT invoice_no, start_time, end_time FROM invoices ORDER BY invoice_no");
	$rs = mysql_query($sql);
	$num_rows_invoice = mysql_num_rows($rs);
	
	for($i=0; $i<$num_rows_invoice; $i++) {
	$invoice[$i] = mysql_fetch_row($rs);}
	
	date_default_timezone_set('Asia/Macao');
	$current_time = time();
	
	// Convert Matrix to Array
	
	if ($p1[0][0] != null) $p1s[0] = $p1[0][0]; $p1s=array();
	if ($p2[0][0] != null) $p2s[0] = $p2[0][0]; $p2s=array();
	if ($p3[0][0] != null) $p3s[0] = $p3[0][0]; $p3s=array();
	if ($p4[0][0] != null) $p4s[0] = $p4[0][0]; $p4s=array();
	$pi = array();
	
	for($i=0; $i<$num_rows_p1; $i++) {
		$p1s[] = $p1[$i][0];
	}
	for($i=0; $i<$num_rows_p2; $i++) {
		$p2s[] = $p2[$i][0];
	}
	for($i=0; $i<$num_rows_p3; $i++) {
		$p3s[] = $p3[$i][0];
	}
	for($i=0; $i<$num_rows_p4; $i++) {
		$p4s[] = $p4[$i][0];
	}
	for($i=0; $i<sizeof($invoice); $i++) {
		if ($invoice[$i][1] > '10000' ||$invoice[$i][2] > '10000' ){
			$pi[] = $invoice[$i][0];
		}
	}
	$p1 = $p1s;
	$p2 = $p2s;
	$p3 = $p3s;
	$p4 = $p4s;
	
// analysis of obtained data
	// Combine all POST Records
	$ps = array_unique_merge($p1,$p2);
	
	$ps = array_unique_merge($ps,$p3);
	
	$ps = array_unique_merge($ps,$p4);
	// Kick out P4 items from POST
$ps_size = sizeof($ps);
	for ($i=0; $i<$ps_size; $i++ ) {
			for ($j=0; $j<sizeof($p4); $j++ ) {
				if ($ps[$i] == $p4[$j] && (array_key_exists($i, $ps))){
					unset($ps[$i]);
					break;
				}
			}
		}
	$ps = array_values($ps);
$ps_size = sizeof($ps);
	// Kick out registered invoices from NRI list
	for ($i=0; $i<$ps_size; $i++ ) {
			for ($j=0; $j<sizeof($pi); $j++ ) {
				if ($ps[$i] == $pi[$j] && (array_key_exists($i, $ps))){
					unset($ps[$i]);
					break;
				}
			}
		}
	asort($ps);
	$ps = array_values($ps);
	// Kick out P4 items from invoice list
$invoice_size = sizeof($invoice);
	for ($i=0; $i<$invoice_size; $i++ ) {
			for ($j=0; $j<sizeof($p4); $j++ ) {
				if ($invoice[$i][0] == $p4[$j] && (array_key_exists($i, $invoice))){
					unset($invoice[$i]);
					break;
				}
			}
		}
		$invoice = array_values($invoice);
        // Kick out P2 items from invoice list
$invoice_size = sizeof($invoice);
	for ($i=0; $i<$invoice_size; $i++ ) {
			for ($j=0; $j<sizeof($p2); $j++ ) {
				if ($invoice[$i][0] == $p2[$j] && (array_key_exists($i, $invoice))){
					unset($invoice[$i]);
					break;
				}
			}
		}
                $invoice = array_values($invoice);
	// Show RI in time orders ( Always USE START as production, END for delivery)
	$invoice_start = array();
	$invoice_end = array();
	for($i=0; $i<sizeof($invoice); $i++) {
		$invoice_start[$i][0] = $invoice[$i][0];
		$invoice_start[$i][1] = $invoice[$i][1];
		$invoice_end[$i][0] = $invoice[$i][0];
		$invoice_end[$i][1] = $invoice[$i][2];
	}
	
//Test Platform
/*
print_r($ps);
echo '<br>';
print_r($pi);
echo '<br>';
print_r($invoice_start);
echo '<br>';
print_r($invoice_end);

*/
// Dislpay Platform
echo '<html><head><meta http-equiv="refresh" content="20" ><link rel="stylesheet" type="text/css" href="info.css" /><title>Valentine Project Display Platform - Production Queues</title></head>
<body><h1>PRODUCTION QUEUES</h1>
<table border="1"><tr><td>NRI</td><td>Allocated</td></tr><tr><td>
<table border="0">';
// PART 1: NRI
for($i=0; $i<sizeof($ps); $i++) {
	echo '<tr><td>'.$ps[$i];
	echo '</td></tr>';
}

$count = array();
$count2 = array();
for($i = 0; $i < '12';$i++) {
	$count[] = '0';
	$count2[] = '0';
}
echo '</table></td><td rowspan="2"><table border="1">
<tr><td>-0800</td><td>0800</td><td>0900</td><td>1000</td><td>1100</td><td>1200</td></tr>
<tr><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] < strtotime("02/14/2012 09:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[0] = $count[0]+'1';
	}
	if ($invoice_end[$i][1] < strtotime("02/14/2012 09:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[0] = $count2[0]+'1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 09:00") && $invoice_start[$i][1] < strtotime("02/14/2012 10:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[1] = $count[1] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 09:00") && $invoice_end[$i][1] < strtotime("02/14/2012 10:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[1] = $count2[1] + '1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 10:00") && $invoice_start[$i][1] < strtotime("02/14/2012 11:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[2] = $count[2] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 10:00") && $invoice_end[$i][1] < strtotime("02/14/2012 11:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[2] = $count2[2] + '1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 11:00") && $invoice_start[$i][1] < strtotime("02/14/2012 12:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[3] = $count[3] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 11:00") && $invoice_end[$i][1] < strtotime("02/14/2012 12:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[3] = $count2[3] + '1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 12:00") && $invoice_start[$i][1] < strtotime("02/14/2012 13:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[4] = $count[4] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 12:00") && $invoice_end[$i][1] < strtotime("02/14/2012 13:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[4] = $count2[4] + '1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 13:00") && $invoice_start[$i][1] < strtotime("02/14/2012 14:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[5] = $count[5] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 13:00") && $invoice_end[$i][1] < strtotime("02/14/2012 14:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[5] = $count2[5] + '1';
	}
}
echo '</table></td></tr><tr>';
for($i=0; $i<=5;$i++) {
	echo '<td>R'.$count2[$i].' G'.$count[$i].'</td>';
}
echo '</tr><tr><td>1300</td><td>1400</td><td>1500</td><td>1600</td><td>1700</td><td>1800-</td></tr>
<tr><tr><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 14:00") && $invoice_start[$i][1] < strtotime("02/14/2012 15:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[6] = $count[6] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 14:00") && $invoice_end[$i][1] < strtotime("02/14/2012 15:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[6] = $count2[6] + '1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 15:00") && $invoice_start[$i][1] < strtotime("02/14/2012 16:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[7] = $count[7] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 15:00") && $invoice_end[$i][1] < strtotime("02/14/2012 16:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[7] = $count2[7] + '1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 16:00") && $invoice_start[$i][1] < strtotime("02/14/2012 17:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[8] = $count[8] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 16:00") && $invoice_end[$i][1] < strtotime("02/14/2012 17:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[8] = $count2[8] + '1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 17:00") && $invoice_start[$i][1] < strtotime("02/14/2012 18:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[9] = $count[9] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 17:00") && $invoice_end[$i][1] < strtotime("02/14/2012 18:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[9] = $count2[9] + '1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 18:00") && $invoice_start[$i][1] < strtotime("02/14/2012 19:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[10] = $count[10] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 18:00") && $invoice_end[$i][1] < strtotime("02/14/2012 19:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[10] = $count2[10] + '1';
	}
}
echo '</table></td><td><table border="0">';
for($i=0; $i<sizeof($invoice);$i++) {
	if ($invoice_start[$i][1] >= strtotime("02/14/2012 19:00")){
		echo '<tr><td bgcolor="green">'.$invoice_start[$i][0].'</td><td>'.date("H:i m/d",$invoice_start[$i][1]).'</td></tr>';
		$count[11] = $count[11] + '1';
	}
	if ($invoice_end[$i][1] >= strtotime("02/14/2012 19:00")){
		echo '<tr><td bgcolor="red">'.$invoice_end[$i][0].'</td><td>'.date("H:i m/d",$invoice_end[$i][1]).'</td></tr>';
		$count2[11] = $count2[11] + '1';
	}
}
echo '</table></td></tr><tr>';
for($i=6; $i<12;$i++) {
	echo '<td>R'.$count2[$i].' G'.$count[$i].'</td>';
}
echo '</tr></table></td></tr><tr><td>'.sizeof($ps).'</td></tr></table>
<hr>Updated Time: '.
date("d/m/y H:i:s",time()).'
</body></html>';
?>