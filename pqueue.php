<?php
include ("configurations/page_configuration.php");
echo '<html><head><meta http-equiv="refresh" content="20" ><link rel="stylesheet" type="text/css" href="info.css" /><title>Valentine Project Display Platform - Production Queues</title></head>
<body>';
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


// Obtain location parameter
 if (isset($GET['location'])) {
 	$location = $_GET['location'];
 } else {
 	$location = 0;
 }
if (substr($location,1,1) == "s"){
  //echo 'special triggered.';
	$location = intval($location);
	$location = $location.'%';}
	
	include("controllers/fetch_progression.php");
	
// Dislpay Platform
'<h1>PRODUCTION QUEUES</h1>
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