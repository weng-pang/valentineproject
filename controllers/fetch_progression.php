<?php

function array_unique_merge() {
	$func_args = func_get_args();
	return array_unique(call_user_func_array('array_merge', $func_args));
}
include ("configurations/page_configuration.php");

// 取得系統組態
include ("configure.php");

// 連結資料庫
include ("connect_db.php");
$p1 = array();
$p2 = array();
$p3 = array();
$p4 = array();
$invoice = array();
// Obtain P1
($location? $sql = "SELECT i.invoice_no FROM p1 p, invoices i WHERE p.invoice_no=i.invoice_no AND allocated_place=$location ORDER BY invoice_no" : $sql = "SELECT invoice_no FROM p1 ORDER BY invoice_no");
$rs = mysql_query($sql);
$num_rows_p1 = mysql_num_rows($rs);

for ( $i=0; $i<$num_rows_p1; $i++ ) {
	$p1[] =  mysql_fetch_row($rs);}

	// Obtain P2
	($location? $sql = "SELECT i.invoice_no FROM p2 p, invoices i WHERE p.invoice_no=i.invoice_no AND allocated_place=$location ORDER BY invoice_no" : $sql = "SELECT invoice_no FROM p2 ORDER BY invoice_no");
	$rs = mysql_query($sql);
	$num_rows_p2 = mysql_num_rows($rs);
	$p2[0] =  mysql_fetch_row($rs);
	for ( $i=1; $i<$num_rows_p2; $i++ ) {
		$p2[$i] =  mysql_fetch_row($rs);}

		// Obtain P3
		($location? $sql = "SELECT i.invoice_no FROM p3 p, invoices i WHERE p.invoice_no=i.invoice_no AND allocated_place=$location ORDER BY invoice_no" : $sql = "SELECT invoice_no FROM p3 ORDER BY invoice_no");
		$rs = mysql_query($sql);
		$num_rows_p3 = mysql_num_rows($rs);
		$p3[0] =  mysql_fetch_row($rs);
		for ( $i=1; $i<$num_rows_p3; $i++ ) {
			$p3[$i] =  mysql_fetch_row($rs);}

			// Obtain P4
			($location? $sql = "SELECT i.invoice_no FROM p4 p, invoices i WHERE p.invoice_no=i.invoice_no AND allocated_place=$location ORDER BY invoice_no" : $sql = "SELECT invoice_no FROM p4 ORDER BY invoice_no");
			$rs = mysql_query($sql);
			$num_rows_p4 = mysql_num_rows($rs);
			$p4[0] =  mysql_fetch_row($rs);
			for ( $i=1; $i<$num_rows_p4; $i++ ) {
				$p4[$i] =  mysql_fetch_row($rs);}

				// Obtain invoice information
				($location? $sql = "SELECT invoice_no, start_time, end_time FROM invoices WHERE allocated_place = $location ORDER BY invoice_no" : $sql = "SELECT invoice_no, start_time, end_time FROM invoices ORDER BY invoice_no");
				$rs = mysql_query($sql);
				$num_rows_invoice = mysql_num_rows($rs);

				for($i=0; $i<$num_rows_invoice; $i++) {
					$invoice[$i] = mysql_fetch_row($rs);}



					// Convert Matrix to Array

					if (isset($p1[0][0]) && $p1[0][0] != null) $p1s[0] = $p1[0][0]; $p1s=array();
					if (isset($p2[0][0]) && $p2[0][0] != null) $p2s[0] = $p2[0][0]; $p2s=array();
					if (isset($p3[0][0]) && $p3[0][0] != null) $p3s[0] = $p3[0][0]; $p3s=array();
					if (isset($p4[0][0]) && $p4[0][0] != null) $p4s[0] = $p4[0][0]; $p4s=array();
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
						$pi[] = $invoice[$i][0];
					}
					$p1 = $p1s;
					$p2 = $p2s;
					$p3 = $p3s;
					$p4 = $p4s;

					// analysis of obtained data
					// Find irregularities
					// Register WITHOUT previous post
					$p2_ir = array();
					$p3_ir = array();
					// P2 without P1,
					for ($i=0; $i<sizeof($p2); $i++ ) {
						$found = false;
						for ($j=0; $j<sizeof($p1); $j++ ) {
							if ($p2[$i] == $p1[$j]){
								// Find correct registration
								$found = true;
								break;
							}
						}
						if (!$found){
							$p2_ir[] = $p2[$i];
						}
					}

					// P3 without P2
					for ($i=0; $i<sizeof($p3); $i++ ) {
						$found = false;
						for ($j=0; $j<sizeof($p2); $j++ ) {
							if ($p3[$i] == $p2[$j]){
								// Find correct registration
								$found = true;
								break;
							}
						}
						if (!$found){
							$p3_ir[] = $p3[$i];
						}
					}


					// Eliminate repeated data

					//P1

					$p1 = array_unique($p1);
					$p1 = array_values($p1);
					//P2
					$p2 = array_unique($p2);
					$p2 = array_values($p2);
					//P3
					$p3 = array_unique($p3);
					$p3 = array_values($p3);
					//P4
					$p4 = array_unique($p4);
					$p4 = array_values($p4);

					// Eliminate post repeats and null value
					//P1 -> P2

					$p1_size = sizeof($p1);
					for ($i=0; $i<$p1_size; $i++ ) {

						for ($j=0; $j<sizeof($p2); $j++ ) {
							//echo('$i='.$i.'$j='.$j.'<br>');
							if ($p1[$i] == $p2[$j] && (array_key_exists($i, $p1))){
								unset($p1[$i]);
								break;
							}
						}
					}
					$p1 = array_values($p1);
					$p2_size = sizeof($p2);
					//P2 -> P3
					for ($i=0; $i<$p2_size; $i++ ) {
						for ($j=0; $j<sizeof($p3); $j++ ) {
							if ($p2[$i] == $p3[$j] && (array_key_exists($i, $p2))){
								unset($p2[$i]);
								break;
							}
						}
					}
					$p2 = array_values($p2);
					$p3_size = sizeof($p3);
					//P3 -> P4
					for ($i=0; $i<$p3_size; $i++ ) {
						for ($j=0; $j<sizeof($p4); $j++ ) {
							if ($p3[$i] == $p4[$j] && (array_key_exists($i, $p3))){
								unset($p3[$i]);
								break;
							}
						}
					}
					$p3 = array_values($p3);
					$p2_size = sizeof($p2);
					//P2 -> P4
					for ($i=0; $i<$p2_size; $i++ ) {
						for ($j=0; $j<sizeof($p4); $j++ ) {
							if ($p2[$i] == $p4[$j] && (array_key_exists($i, $p2))){
								unset($p2[$i]);
								break;
							}
						}
					}
					$p2 = array_values($p2);
					$p2_size = sizeof($p2);
					//P1 -> P4
					for ($i=0; $i<$p2_size; $i++ ) {
						for ($j=0; $j<sizeof($p4); $j++ ) {
							if ($p1[$i] == $p4[$j] && (array_key_exists($i, $p1))){
								unset($p1[$i]);
								break;
							}
						}
					}
					$p1 = array_values($p1);
					// Count progressions
					$num_rows_p1 = count($p1);
					$num_rows_p2 = count($p2);
					$num_rows_p3 = count($p3);
					$num_rows_p4 = count($p4);

					//Time alert
					/* 6 Types of variables:
					 start in 0 minute
					start in 30 minutes
					start in 60 minutes
					end in 0 minute
					end in 30 minute
					end in 60 minute
					*/
					$startnow = array();
					$start30 = array();
					$start60 = array();
					$endnow = array();
					$end30 = array();
					$end60 = array();
					for($i=0; $i<sizeof($invoice); $i++) {
						// Compare each invoice with time
						if ($invoice[$i][1] - $current_time < 0 && !(in_array($invoice[$i][0], $p4 , $strict = null))){
							// Time is here
							array_push($startnow, array(0 => $invoice[$i][0], 1 => $invoice[$i][1]));
								
						}elseif($invoice[$i][1] - $current_time < 1800 && !(in_array($invoice[$i][0], $p4 , $strict = null))) {
							// Half and hour to go
							array_push($start30, array(0 => $invoice[$i][0], 1 => $invoice[$i][1]));
								
						}elseif($invoice[$i][1] - $current_time < 3600 && !(in_array($invoice[$i][0], $p4 , $strict = null))) {
							// One Hour to go
							array_push($start60, array(0 => $invoice[$i][0], 1 => $invoice[$i][1]));
						}


						if ($invoice[$i][2] - $current_time < 0 && !(in_array($invoice[$i][0], $p4 , $strict = null))){
							// Time is here
							array_push($endnow, array(0 => $invoice[$i][0], 1 => $invoice[$i][2]));
								
						}elseif($invoice[$i][2] - $current_time < 1800 && !(in_array($invoice[$i][0], $p4 , $strict = null))) {
							// Half and hour to go
							array_push($end30, array(0 => $invoice[$i][0], 1 => $invoice[$i][2]));
								
								
						}elseif($invoice[$i][2] - $current_time < 3600 && !(in_array($invoice[$i][0], $p4 , $strict = null))) {
							// One Hour to go
							array_push($end60, array(0 => $invoice[$i][0], 1 => $invoice[$i][2]));
						}
					}
					// merge entire invoice table
					$pt = array();
					$pt = array_merge($p1, $p2, $p3, $p4, $pi);
					$pt = array_unique($pt);
					sort($pt);
					$pt = array_values($pt);
					
//==============================================================
					// analysis of obtained data
					// Combine all POST Records
					$ps = array_unique_merge($p1,$p2);
					
					$ps = array_unique_merge($ps,$p3);
					
					$ps = array_unique_merge($ps,$p4);
					// Kick out P4 items from POST
					$ps_size = sizeof($ps);
					//echo count($ps);
					for ($i=0; $i<$ps_size; $i++ ) {
						for ($j=0; $j<sizeof($p4); $j++ ) {
							//echo('$i='.$i.'$j='.$j.'<br>');
							if (isset($ps[$i]) && $ps[$i] == $p4[$j] && (array_key_exists($i, $ps))){
								//echo "reduced<br>";
								unset($ps[$i]);
								break;
							}
						}
					}
					$ps = array_values($ps);
					$ps_size = count($ps);
					//echo count($ps);
					// Kick out registered invoices from NRI list
					for ($i=0; $i<$ps_size; $i++ ) {
						for ($j=0; $j<sizeof($pi); $j++ ) {
							if (isset($ps[$i]) && $ps[$i] == $pi[$j] && (array_key_exists($i, $ps))){
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
							if (isset($invoice[$i]) && $invoice[$i][0] == $p4[$j] && (array_key_exists($i, $invoice))){
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
					