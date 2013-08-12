<?php
require('../configurations/db_connection.php');
class image{
	
	private $id = '';
	private $invoice_id = '';

	// The consturctor communicates with database immediately and a new id may be assigned if needed
	// Alternatively, for current records an id must be given to continue on further actions.
	function __construct($id = null){
		//
		global $mysql;
		if (is_null($id) && is_integer($id)){
			// communicating with database for a new id
		} else {
			if (!$mysql->IsConnected()){
				$mysql->Open();
			}
			// check with database for the id
			// create insert query
			$sql="INSERT INTO images (uploaded) Values ('".date('Y-m-d H:i:s',time())."')";
			$mysql->Query($sql);
			echo 'DB Insert Completed<br>';
			$this->id = $mysql->GetLastInsertID();
			echo 'DB Id= '.$this->id.'<br>';
			//$mysql->TransactionEnd();
			//$this->mysql->Kill();
		}
	}
	/*
	 * assign
	 * 
	 * This is used for a given object without an invoice id, once it is assigned the coresponding database record will also be reflected.
	 * 
	 * 
	 * 
	 */
	function assign($invoice_id){
		// modify the invoice table
	}
	/*
	 *  findImage
	 *  
	 *  
	 *  This method fetches the id of the image against the invoice id entered.
	 *  To approach this task, a query towards the invoice table is taken, then the result will be shown thereafter.
	 *  
	 *  Note that a '0' response is given in case there is no image from the invoice intended.
	 * 
	 * 
	 */
	function findImage($invoice_id){
		// query one invoice table
	}
	/*
	 *  findInvoice
	*
	*  This method fetches the id of the invoice against this image object.
	*  To approach this task, a query towards the invoice table is taken, then the result will be shown thereafter.
	*
	*  Note that a '0' response is given in case there is no invoice from the invoice table (Possibly this is not assigned).
	*
	*
	*/
	function findInvoice(){
		// query on invoice table
	}
	
	function getId(){
		return $this->id;
		
	}
	
}