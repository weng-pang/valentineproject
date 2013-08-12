<?php
require '../configurations/email_connection.php';
require 'image.php';
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
 * the ATTACHMENT must be stored as jpeg image only.
 * 
 */
$acceptableExt = array('jpg','jpeg','gif',);
$storageFolder = '../../valentine2014_files/'; // this storage is supposed to be as secure as possible
$sourceFolder = 'tmp/'; // This is a temporary storage folder only
// OPEN email connection
//$pop3->Statistics($messages, $size);
//$pop3->GetConnectionName($connection_name);
// Note that $messages and $size are output paramteres...
// prepare verberose mode...
echo "<PRE>There are $messages messages in the mail box with a total of $size bytes.</PRE>\n";
echo '<pre>';
// FETCH New message
if ($messages > 0){
	
	for($message = 1;$message <= $messages;$message++){
		echo '<pre>Processing message '.$message.'</pre>';
		$mime = new mime_parser_class;
		// RECEIVE email information from POP3 Object
		if ($pop3->RetrieveMessage($message,$headers,$body,-1) != ''){
			echo 'Message cannot achieve! Operation Halt!';
			exit;
		}
		// Store the message into the temprorary location
		$message_file = $sourceFolder.'temp.eml';
		$rawHandler = fopen($message_file, 'w');
		$rawContent = '';
		echo "<PRE>Message 1:\n---Message headers starts below---</PRE>\n";
		for($line=0;$line<count($headers);$line++)
			$rawContent .= $headers[$line].'
';
		echo "<PRE>---Message headers ends above---\n---Message body starts below---</PRE>\n";
		for($line=0;$line<count($body);$line++)
			$rawContent .= $body[$line].'
';
		echo "<PRE>---Message body ends above---</PRE>\n";
		fwrite($rawHandler,$rawContent);
		fclose($rawHandler);
		
		// RETRIEVE tmp file location and text content
		$mime->decode_bodies = 1;
		$parameters = array('File'=>$message_file,'SaveBody'=>$sourceFolder,'SkipBody'=>0);
		$success = $mime->Decode($parameters,$decoded);
		// CHECK for subject for invoice number, and attachment for image
		if (!$success){
			echo '<pre>Error opening the message</pre>';
			echo '<pre>'.HtmlSpecialChars($mime->error).'</pre>';
		} else {
			// deletion the raw file for security
			unlink($message_file);
			echo '<pre>'; // For Debug Use Only
			//var_dump($decoded);
			echo '</pre>';
			
			echo 'FOUND TITLE: ';
			var_dump($decoded[0]['Headers']['subject:']);
			// To find out the image, it requires some repetition over the PARTS...
			foreach ($decoded[0]['Parts'] as $part){
				// check whether there is a filename presence
				if (array_key_exists('FileName',$part)){
					echo '<br>IMAGE Name: '.$part['FileName'];
					echo '<br>IMAGE Location: '.preg_replace('/[^\-\d]*(\-?\d*).*/','$1',$part['BodyFile']);
					
					// check file extension
					$fileName = explode('.',$part['FileName']);
					$extension = $fileName[count($fileName)-1];
					echo '<br>EXTENSION: '.$extension;
					
					if (in_array($extension,$acceptableExt)){
						echo '<br>Perform Saving Procedures...';
						// prepare the target
						// REGISTER to DATABASE for new entry, then obtain the id to rename the image.
						$image = new image();
						// obtain new database id entry...
						$id = $image->getId();
						// attach DB id parameter...
						// STORE the image into designated area.
						$storageLocation = $storageFolder.$id.'.'.$extension;
						echo '<br>Preparing Destination '.$storageLocation;
						$storageHandler = fopen($storageLocation, 'w');
						// prepare the source
						$sourceLocation = $sourceFolder.preg_replace('/[^\-\d]*(\-?\d*).*/','$1',$part['BodyFile']);
						echo '<br>Opeing Source '.$sourceLocation;
						$sourceHandler = fopen($sourceLocation, 'r');
						$sourceData = fread($sourceHandler, filesize($sourceLocation));
						// place source into target
						fwrite($storageHandler,$sourceData);
						// Wraps all files up...
						fclose($sourceHandler);
						fclose($storageHandler);
						// Deletion the temporary file (image...)
						unlink($sourceLocation);
					}
					echo 'Processing completed. Perform temporary file deletion';
					$pop3 -> DeleteMessage($message);
					echo 'Proceed to next email message';
				}
			// GO Back to beginning until all messages are sorted out.
			}
		}
	} 
	
		
} else {
	echo 'No message found';
}
echo '</pre>';

// Close the email connection
$pop3->Close();