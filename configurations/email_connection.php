<?php
/*
 * ==================================================
* KAUGEBRA AVIATION AND TECHNOLOGY SERVICES (KATS) 2013
* VALENTINE PROJECT 2014
*
* 	email_connection.php
*
* This application will generate an obejct known as $email,
* This object serves as a sole connection channel between the application and email server
* for RECEIVING email messages.
* ==================================================
*
* The email connection classs is obtained through PHP POP3 and MIME Parser classes by Manuel Lemo from phpclass.org.
*
* ==================================================
* NOTE for USERS
*
* $pop3
*
* Access to the email server can be made only by communicating through $pop3 only
* REMEMBER! Close the conenction by calling $pop3->Close() after use!!
* 
* for furhter assistance please check documentation via POP3 and MIME Parser classes by Manuel Lemo from phpclass.org
*/
// seek all object classes and configurations
require('email_configurations.php');
require('utility/mime_parser.php');
require('utility/rfc822_addresses.php');
require('utility/pop3.php');
// increase maximum time limitation as a precaution
set_time_limit(180); // 90 seconds
// Generate $pop3 object
$pop3=new pop3_class;

$pop3->tls = 0;
$pop3->hostname = $email_HOST;
$pop3->port = $email_PORT;

$pop3->html_debug = 1;
$pop3->join_continuation_header_lines=1;

$apop = 0; /* Use APOP authentication */
// Initialise connection
$pop3->Open();

$pop3->Login($email_USERNAME,$email_PASSWORD,$apop);

if ($pop3->Statistics($messages,$size)!= ""){
	echo '<pre>Statistics looks Wrong. Operation Halt</pre>';
	exit;
}
// The rest of work will handover to controller
// Add instruction samples here...
