<html>
<head>
<title>Valentine Project Register</title>
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

if ($_SESSION["progress_ses"] != 'r' && $_SESSION["progress_ses"] != 's'){
	echo '<body onload="document.entry.invoice_parameter.focus()">';
	} else {
	echo '<body onload="document.entry.start_parameter.focus()">';}
?>
<h1 align="center">Valentine Project 2012</h1>
<h3 align="center">
Registration Form
</h3>
<p align="center">
<?php
if ($_SESSION["progress_ses"] != 'r' && $_SESSION["progress_ses"] != 's'){
	echo '
	Please Enter Invoice Number to Continue...<br><table  border=1 align=center><tr><td>
<form method="post" name="entry" action="preinsert.php" align="center" style="font-family:verdana;">
Invoice Code:<input type="text" name="invoice_parameter" tabindex="1"><br>
<input type="submit" name="b1" value="Enter" tabindex="2"><br>
</form>
</td></tr>
</table>';
}
 elseif ($_SESSION["progress_ses"] == 'r'){
	//Register for NEW information
	echo 'New Invoice, Please Enter Information<br>
	<table  border=1 align=center><tr><td>
	<form method="post" name="entry" action="preinsert.php" align="center" style="font-family:verdana;">

	Invoice Code:'.$_SESSION["invoice_ses"].'<br>Start Delivery Time:<input type="text" name="start_parameter" tabindex="1"><br>
	End Delivery Time:<input type="text" name="end_parameter" tabindex="2"><br>
	Number of Gifts:<input type="text" name="gift_parameter" tabindex="3"><br>
	Location Offered:<input type="text" name="location_parameter" tabindex="4"><br>
	<input type="submit" name="b1" value="Enter" tabindex="5">
	<input type="submit" name="b1" value="Return" tabindex="6"><br>
	</form>
	</td></tr>
	</table>';} elseif($_SESSION["progress_ses"] == 's') {
	//Update CURRENT Information
	$pm = $_SESSION["pm_ses"];
	echo 'Current Invoice, Update Information
	<table  border=1 align=center><tr><td>
	<form method="post" name="entry" action="preinsert.php" align="center" style="font-family:verdana;">

	Invoice Code: '.$_SESSION["invoice_ses"].'<br>Start Delivery Time:<input type="text" name="start_parameter" value="'.date("H:i",$pm[1]).'" tabindex="1"><br>
	End Delivery Time:<input type="text" name="end_parameter" value="'.date("H:i",$pm[2]).'" tabindex="2"><br>
	Number of Gifts:<input type="text" name="gift_parameter" value="'.$pm[3].'" tabindex="3"><br>
	Location Offered:<input type="text" name="location_parameter" value="'.$pm[4].'" tabindex="4"><br>
	<input type="submit" name="b1" value="Enter" tabindex="5">
	<input type="submit" name="b1" value="Return" tabindex="6"><br>
	</form>
	</td></tr>
	</table>';}
?>
</p>
<hr>
<p align="center">Please Note: Time is always assumed as 14 February 2012. For all other dates, please do a manual update.</p>
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