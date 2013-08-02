<?php
$a=4;
$b=6;

echo $a;
$expected_date = "2/14/2012";
$start_delivery_str="12:00";
$end_delivery_str="13:00";

	$start_delivery_str = $expected_date." ".$start_delivery_str;
	$end_delivery_str = $expected_date." ".$end_delivery_str;
	echo 'start_delivery='.$start_delivery_str.'<br>end_delivery='.$end_delivery_str.'<br>';	
	
	
	if (($timestamp = strtotime($start_delivery_str)) !== false) {
    echo"Obtained a valid $timestamp; start_delivery_str is valid.<br>";
} else {
    echo "start_delivery_str is invalid.<br>";
}

	$start_delivery = strtotime($start_delivery_str);
	$end_delivery = strtotime($end_delivery_str);
		echo 'start_delivery='.$start_delivery.'<br>end_delivery='.$end_delivery.'<br>';





?>

<?php

for( $i=1; $i<=100; $i++ )
{
echo $i;
echo "<br>";
}

?> 