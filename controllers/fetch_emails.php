<?php
include '../configurations/db_configurations.php';
include '../configurations/connect_db.php';
include '../configurations/email_configurations.php';
/*
 * ==================================================
 * KAUGEBRA AVIATION AND TECHNOLOGY SERVICES (KATS) 2013
 * VALENTINE PROJECT 2014
 * 
 * 	fetch_emails.php
 * 
 * This application will fetch a desginated email account for raw invoice images, and 
 * the Content is renamed according to Database parameters, and
 * It will be stored in designated area.
 * ==================================================
 * 
 * See configurations/email_configurations.php for email account settings.
 * 
 * This applicaton is expected to run under CONSOLE mode. 
 * 
 * ==================================================
 * NOTE for USERS
 * 
 * Please take extra care about naming convention, or the automation and display feature may be nullified - 
 * the SUBJECT must be the invoice number only.
 * the ATTACHMENT must be stored as jpeg or gif image only.
 * 
 */

// OPEN email connection

// FETCH New message
// CHECK for subject for invoice number, and attachment as image
// REGISTER to DATABASE for new entry, then obtain the id to rename the image.
// STORE the image into designated area.
