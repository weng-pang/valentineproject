<html>
<head>
<title>Valentine Project Register</title>
<style type="text/css">
table {text-align:center;
margin-left:auto;
margin-right:auto;
width:50%;}

</style>
<!-- All Rights Reserved. KATS 2011 -->
</head>
<?php
// 啟用 Session
session_start();

// 將未登入者，導向至首頁
$username=$_SESSION["username_ses"];
$location=$_SESSION["location_ses"];
if ( empty($_SESSION["username_ses"]) ) {
  Header("location:index.html");
  exit;
}
// Queries go here...
$progress = $_SESSION["progress_ses"];
?>

<body onload="document.entry.invoice_parameter.focus()">

<h1 align="center">Valentine Project 2012</h1>
<h3 align="center">
<?php

switch($progress){
	case 'n':
		break;
	case 'r':
		break;
	case 'q':
	//query
		//Obtain previous information
		$p1 = $_SESSION["p1_ses"];
		$p2 = $_SESSION["p2_ses"];
		$p3 = $_SESSION["p3_ses"];
		$p4 = $_SESSION["p4_ses"];
		$pm = $_SESSION["pm_ses"];
		// List them out
		//p1
		echo 'Invoice:'.$_SESSION["invoice_ses"].'<br>';
		echo 'P1<br><table border="1"><tr><td>TIME</td><td>LOCATION</td><td>USER</td></tr>';
		for ( $i=0; $i<sizeof($p1); $i++ ) {
			echo '<td>'.date("H:i m/d",$p1[$i][0]).'</td><td>'.$p1[$i][1].'</td><td>'.$p1[$i][2].'</td></tr>';}
		echo '</table>';
		//p2
		echo 'P2<br><table border="1"><tr><td>TIME</td><td>LOCATION</td><td>USER</td></tr>';
		for ( $i=0; $i<sizeof($p2); $i++ ) {
			echo '<td>'.date("H:i m/d",$p2[$i][0]).'</td><td>'.$p2[$i][1].'</td><td>'.$p2[$i][2].'</td></tr>';}
		echo '</table>';
		//p3
		echo 'P3<br><table border="1"><tr><td>TIME</td><td>LOCATION</td><td>USER</td></tr>';
		for ( $i=0; $i<sizeof($p3); $i++ ) {
			echo '<td>'.date("H:i m/d",$p3[$i][0]).'</td><td>'.$p3[$i][1].'</td><td>'.$p3[$i][2].'</td></tr>';}
		echo '</table>';
		//p4
		echo 'P4<br><table border="1"><tr><td>TIME</td><td>LOCATION</td><td>USER</td></tr>';
		for ( $i=0; $i<sizeof($p4); $i++ ) {
			echo '<td>'.date("H:i m/d",$p4[$i][0]).'</td><td>'.$p4[$i][1].'</td><td>'.$p4[$i][2].'</td></tr>';}
		echo '</table>';
		// metadata
		echo 'Metadata<br><table border="1"><tr><td>Start Delivery</td><td>'.date("H:i m/d",$pm[0]).
		'</td></tr><tr><td>End Delivery</td><td>'.date("H:i m/d",$pm[1]).'</td></tr><tr><td>Queried</td><td>'.$pm[2].
		'</td></tr><tr><td>Gifts</td><td>'.$pm[3].'</td></tr><tr><td>Allocated Place</td><td>'.$pm[4].'</td></tr></table>';
		if ($pm[0]=='0' && $pm[1]=='0'){
		 echo 'Possible Empty Invoice!! Please Update!!';}
		break;
   case 'u':
	//update
		echo $_SESSION["invoice_ses"].' has request';
		if ($_SESSION["rows_ses"] >= '1') {
			echo '.Update Success';
		} else {
			echo '.Update Failed!';
			echo $_SESSION['error_ses'].'<br>';
			}
		break;
}
?>
</h3>
<table  border=1 align=center><tr><td>
<form method="post" name="entry" action="insert.php" align="middle" style="font-family:verdana;">
Invoice Code:<input type="text" name="invoice_parameter" tabindex="1"><br>
<input type="submit" name="b1" value="Enter" tabindex="2"><br>
</form>
</td></tr>
</table>
<hr>
<p align=center>Username:
<?php
echo $username.'<br>';
echo "Location:".$location;
echo '<br>';
echo date("d/m/y H:i:s",time());
?>
</p>
</body>

</html>