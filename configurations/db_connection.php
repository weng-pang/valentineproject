<?php
/*
 * ==================================================
 * KAUGEBRA AVIATION AND TECHNOLOGY SERVICES (KATS) 2013
 * VALENTINE PROJECT 2014
 * 
 * 	db_connection.php
 * 
 * This application will generate an obejct known as $mysql,
 * This object serves as a sole connection channel between the application and database
 * ==================================================
 * 
 * The mysql connection classs is obtained through ultimatemysql from phpclass.org. 
 * 
 * ==================================================
 * NOTE for USERS
 * 
 * $mysql
 * 
 * Access to the database can be made only by communicating through $mysql only
 * 
 * for furhter assistance please check documentation via ultimatemysql from phpclass.org
 */
// seek all object class and configurations
include('utility/mysql.class.php');
include('db_configurations.php');
include('page_configuration.php');
// create the $mysql object
global $mysql;
$mysql = new MySQL(true,$cfgDB_NAME,$cfgDB_HOST,$cfgDB_USERNAME,$cfgDB_PASSWORD);
// The rest of functionalities will be utilised by the controllers...
// Add instruction samples here...