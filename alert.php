<?php
/*
=========================================================
Kaugebra Aviation and Technology Service (KATS) 2012

   alert.php
   
The application is to display current token operation, exclusively for Valentine Project 2012
==========================================================
APPROACHES
1. All information will be obtained from data.

2. Analysis will be performed in the following.
	2a. Progression line to be printed P1 -> P2, P2 -> P3, P3 -> P4
	2b. Time reminder for upcoming invoice tokens (particularly to P2 and P3 requirements.
	2c. Warn for irregularities (P2 P3 and P4 direct registration without P1, or no time information...)
	2d. Check for separation of pre-invoice and immediate invoices.
	
3. Display all of information in order of orders above.

4. Refresh this page in each minute.
==========================================================
Methodology of Twin-Token System

1. All invoices must be initialisated into tokens by processing stations before any further operations.
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
if (isset($_GET['location'])) {
 $location = intval($_GET['location']);
} else {
	$location = 0;
}

// obtain all information from database
	include ("configurations/page_configuration.php");
	include("controllers/fetch_progression.php");

// Display them respectively (test platform)
/*
	 print_r($p1);
	 echo '<br>';
	 print_r($p2);
	 echo '<br>';
	 print_r($p3);
	 echo '<br>';
	 print_r($p4);
	 echo '<br>';
	 print_r($p2_ir);
	 echo '<br>';
	 print_r($p3_ir);
	 echo '<br>';
	 print_r($invoice);
	 echo '<br>startnow = ';
	 print_r($startnow);
	 echo '<br>start30 = ';
	 print_r($start30);
	 echo '<br>start60 = ';
	 print_r($start60);
	 echo '<br>endnow = ';
	 print_r($endnow);
	 echo '<br>end30 = ';
	 print_r($end30);
	 echo '<br>end60 = ';
	 print_r($end60);
        echo '<br>invoice list =';
	 print_r($pt);


echo '<br>';
echo 'P1='.$num_rows_p1.'<br>';
echo 'P2='.$num_rows_p2.'<br>';
echo 'P3='.$num_rows_p3.'<br>';
echo 'P4='.$num_rows_p4.'<br>';

*/

// Dislpay Platform
echo '<html><head><meta http-equiv="refresh" content="20" ><link rel="stylesheet" type="text/css" href="info.css" /><title>Valentine Project Display Platform</title></head>
<body><h1>PROGRESSION REPORT</h1><table><tr><td>
<h2>POST REGISTRATIONS</h2></td><td><h2>TIME ALERTS</h2></td></tr><td>
<table border = 1>
<tr><td>P1</td><td>P2</td><td>P3</td><td>P4</td></tr><tr><td>';
echo '<table border = 0>';
for($i = 0;$i<sizeof($p1); $i++) {
	echo '<tr><td>'.$p1[$i].'</td></tr>';
}
echo '</table></td><td>';

echo '<table border = 0>';
for($i = 0;$i<sizeof($p2); $i++) {
	echo '<tr><td>'.$p2[$i].'</td></tr>';
}
echo '</table></td><td>';
echo '<table border = 0>';
for($i = 0;$i<sizeof($p3); $i++) {
	echo '<tr><td>'.$p3[$i].'</td></tr>';
}
echo '</table></td><td>';
echo '<table border = 0>';
for($i = 0;$i<sizeof($p4); $i++) {
	echo '<tr><td>'.$p4[$i].'</td></tr>';
}
echo '</table><tr><td>'.$num_rows_p1.'</td><td>'.$num_rows_p2.'</td><td>'.$num_rows_p3.'</td><td>'.$num_rows_p4.'</td></tr>
<tr><td colspan ="3">Working Now = '.($num_rows_p1+$num_rows_p2+$num_rows_p3).'</td></tr>
<tr><td colspan ="4">TRI = '.sizeof($invoice).'</td></tr>
<tr><td colspan ="4">TI = '.($num_rows_p1+$num_rows_p2+$num_rows_p3+$num_rows_p4).'</td></tr>';
echo '</td></tr></table></td>


<td>
<table border = 1>
<tr><td>Start Now</td><td>Start 30 Minutes</td><td>Start 60 Minutes</td></tr><tr><td>';
echo '<table border = 0>';
for($i = 0;$i<sizeof($startnow); $i++) {
	echo '<tr><td>'.$startnow[$i][0].'</td><td>'.date("H:i m/d",$startnow[$i][1]).'</tr>';
}
echo '</table></td><td>';

echo '<table border = 0>';
for($i = 0;$i<sizeof($start30); $i++) {
	echo '<tr><td>'.$start30[$i][0].'</td><td>'.date("H:i m/d",$start30[$i][1]).'</tr>';
}
echo '</table></td><td>';
echo '<table border = 0>';
for($i = 0;$i<sizeof($start60); $i++) {
	echo '<tr><td>'.$start60[$i][0].'</td><td>'.date("H:i m/d",$start60[$i][1]).'</tr>';
}
echo '</table></td></tr>';
echo '<tr><td>'.sizeof($startnow).'</td><td>'.sizeof($start30).'</td><td>'.sizeof($start60).'</td></tr>';
echo '</td></tr>
<tr><td>END NOW</td><td>END 30 Minutes</td><td>END 60 Minutes</td></tr><tr><td>';
echo '<table border = 0>';
for($i = 0;$i<sizeof($endnow); $i++) {
	echo '<tr><td>'.$endnow[$i][0].'</td><td>'.date("H:i m/d",$endnow[$i][1]).'</tr>';
}
echo '</table></td><td>';

echo '<table border = 0>';
for($i = 0;$i<sizeof($end30); $i++) {
	echo '<tr><td>'.$end30[$i][0].'</td><td>'.date("H:i m/d",$end30[$i][1]).'</tr>';
}
echo '</table></td><td>';
echo '<table border = 0>';
for($i = 0;$i<sizeof($end60); $i++) {
	echo '<tr><td>'.$end60[$i][0].'</td><td>'.date("H:i m/d",$end60[$i][1]).'</tr>';
}
echo '</table></td></tr>';
echo '<tr><td>'.sizeof($endnow).'</td><td>'.sizeof($end30).'</td><td>'.sizeof($end60).'</td></tr>';
echo '</td></tr></table>
</td></table>
<h2>IRREGULARITIES</h2><table border="1">
<tr><td>P2 ONLY</td><td>P3 ONLY</td></tr>
<tr><td><table border="0">';
for($i = 0;$i<sizeof($p2_ir); $i++) {
	echo '<tr><td>'.$p2_ir[$i].'</td></tr>';}
echo '</table></td><td>
<table border="0">';
for($i = 0;$i<sizeof($p3_ir); $i++) {
	echo '<tr><td>'.$p3_ir[$i].'</td></tr>';}
echo '</table></td></tr><tr><td colspan ="2"><b>MISSING INVOICES BETWEEN</b></td></tr><tr><td colspan ="2"><table border = "0">';

for($i=0; $i<sizeof($pt)-1; $i++){
if (intval($pt[$i+1])-intval($pt[$i]) != 1){
echo '<tr><td><h2>'.$pt[$i].' AND ';


echo $pt[$i+1].'</h2></td></tr>';

}
}
echo '</table></td></tr></table><br><hr>Updated Time: '.
date("d/m/y H:i:s",time()).'
</body></html>';
?>