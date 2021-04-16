<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trial_model extends CI_Model{
	
	var $table = 'tblpayments';
	
	function addTrial($data){
		
		$name = $_POST['name'];
		$phone = $_POST['phone1']."-".$_POST['phone2']."-".$_POST['phone3'];
		$email = $_POST['email'];
		$age = $_POST['age'];
		$program = $_POST['program'];
		$message = $_POST['message'];
		$amount = $_POST['trial_amount'];
		$paypalEmail = $_POST['email_address'];

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				echo "<script>alert('Invalid Email Address!')</script>";
			}else{
				$data = array("name" => $name, "phone" => $phone, "email" => $email, "age" => $age, "program_of_interest" => $program, "amount" => $amount, "message" => $message);
				if($this->query_model->insertData($this->table, $data)):
					$last_id = mysql_insert_id();	
					
					// PayPal settings
					$paypal_email = $paypalEmail;

					$paypal_email = $paypalEmail;					
					$return_url =  @base_url().'starttrialsent?status=suc';
					$cancel_url =  @base_url().'starttrialsent?status=can';
					$notify_url =  @base_url();
						
					// Check if paypal request or response
					if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
					
						// Firstly Append paypal account to querystring
						$querystring = "?business=".urlencode($paypal_email)."&";
					
						// Append amount& currency (£) to quersytring so it cannot be edited in html
					
						//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
						$querystring .= "item_name=".urlencode("Start Trial")."&";
						$querystring .= "amount=".urlencode($amount)."&";
						$querystring .= "receiver_email=".urlencode($email)."&";

						// Append querystring with custom field
						$querystring .= "custom=".urlencode($last_id)."&";
					
						//loop for posted values and append to querystring
						foreach($_POST as $key => $value){
							$value = urlencode(stripslashes($value));
							$querystring .= "$key=$value&";
						}
					
						// Append paypal return addresses
						$querystring .= "return=".urlencode(stripslashes($return_url))."&";
						$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
						$querystring .= "notify_url=".urlencode($notify_url);
						
						// Redirect to paypal IPN
						header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
						exit();
					
					}
					
				endif;	
			}
		
	}	
	
	function handlePaypalResponse(){
		
		// Check if paypal request or response
		if (isset($_POST["txn_id"]) && isset($_POST["txn_type"])){
					
			// Response from PayPal
			// assign posted variables to local variables
			$data['item_number'] 		= $_POST['item_number'];
			$data['payment_status'] 	= $_POST['payment_status'];
			$data['payment_amount'] 	= $_POST['mc_gross'];
			$data['txn_id']				= $_POST['txn_id'];
			$data['custom'] 			= $_POST['custom'];
		
			// Validate payment (Check unique txnid & correct price)
			$valid_txnid = $this->check_txnid($data['txn_id']);
			$valid_price = $this->check_price($data['payment_amount'], $data['item_number']);

			// PAYMENT VALIDATED & VERIFIED!
			if($valid_txnid && $valid_price){
				
				$orderid = $this->editTrial($data, $data['custom']);
				if($orderid){

					$name = $email = $phone = $program = $message = $site_email = $school_name = ''; 
								
					$payment_info = $this->getTransactionDetails($data['txn_id']);
											
					if($payment_info) {
						$name = $payment_info['name'];
						$email = $payment_info['email'];
						$phone = $payment_info['phone'];
									
						$program_info = $this->query_model->getbyId("tblprogram", $payment_info['program_of_interest']);
						$program = $program_info[0]->program;
									
						$message = $payment_info['message']; 
					}
							
					// Payment has been made & successfully inserted into the Database
					$this->load->library("email");
					$query = $this->query_model->getbyTable('tblsite');
					foreach($query as $row):
						$site_email = $row->email;
						$school_name = $row->title;
					endforeach;

					// Email to site owner
					$type = "Payment was successful";
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					$this->email->from($email);
					$this->email->to($site_email);
					$this->email->subject($type);
										
					$mes ="<html><head>";
					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";
					$mes.="<style>
								*{ margin: 0; padding: 0; font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}
										body{ margin: 5px;text-align: left;  }
										h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif;}
										h6{ font-size: 14px; color: #006699}
										strong{ color:#006699; font-weight:900; }
										.content{ margin-top: 50px;}
										.content .row{ margin: 5px 0;}
										.row .message{ width: 700px; padding-top: 10px; }
										.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px; text-indent: 20px;}
										label{ font-weight:400; }
										</style>";
					$mes .= "</head><body>";
					$mes .= "<h1>".$school_name."</h1>";
					$mes .= "<h6>Payment Status - Successful</h6>";
										
					$mes .= '<div class="content">';
					$mes .=	'<div class="row"><strong>Name: &nbsp;</strong><label>'.$name.'</label></div>';
					$mes .=	'<div class="row"><strong>Email: &nbsp;</strong><label>'.$email.'</label></div>';
					$mes .=	'<div class="row"><strong>Phone: &nbsp;</strong><label>'.$phone.'</label></div>';
					$mes .=	'<div class="row"><strong>Program Of Interest: &nbsp;</strong><label>'.$program.'</label></div>';
										
					$mes .= '<div class="row">';
					$mes .= '<div class="message"><p>'.$message.'</p></div>';
					$mes .= '</div></div>';
					$mes .= '</body></html>';
											
					$this->email->message($mes);
					
					$this->email->send();
												
					// Email to user
					$type = "Payment was successful";
					$cont = "Congratulations! Your Payment was accepted! A representative from our school will contact you shortly with more information."; 
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					$this->email->from($site_email);
					$this->email->to($email);
					$this->email->subject($type);
												
					$mes ="<html><head>";
					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";
					$mes.="<style>
									*{ margin: 0; padding: 0; font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}
									body{ margin: 5px; text-align: left;  }
									h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif;}
									h6{ font-size: 14px; color: #006699}
									strong{ color:#006699; font-weight:900; }
									.content{ margin-top: 50px;}
									.content .row{ margin: 5px 0;}
									.row .message{ width: 700px; padding-top: 10px; }
									.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px; text-indent: 20px;}
									label{ font-weight:400; }
									</style>";
					$mes .= "</head><body>";
					$mes .= "<h1>".$school_name."</h1>";
					$mes .= "<h6>Payment Status - Successful</h6>";
													
					$mes .= '<div class="row">';
					$mes .= '<div class="message"><p>'.$cont.'</p></div>';
					$mes .= '</div></div>';
					$mes .= '</body></html>';
								
					$this->email->message($mes);
					
					$this->email->send();
				}
			}
		}
	}	
		
	public function editTrial($data,$last_id){
		if(is_array($data)){
	        $sql = mysql_query("UPDATE ".$this->table." SET `txnid`='".$data['txn_id']."',`payment_status`='".$data['payment_status']."' WHERE id='$last_id'");
		    return true;
	    }
	    return false;
	}
	
	function getTransactionDetails($tnxid) {		
		$sql = mysql_query("SELECT * FROM ".$this->table." WHERE txnid = '$tnxid'");
	    if (mysql_numrows($sql) != 0) {
			while ($row = mysql_fetch_array($sql)) {
				return $row;
			}
	    }
	    
	    return false;
	}
	
	function check_txnid($tnxid){
		$valid_txnid = true;
	    $sql = mysql_query("SELECT * FROM ".$this->table." WHERE txnid = '$tnxid'");
		if($row = mysql_fetch_array($sql)) {
	        $valid_txnid = false;
		}
	    return $valid_txnid;
	}
	
	function check_price($price, $id){
	    $valid_price = false;

	    //you could use the below to check whether the correct price has been paid for the product
		//if so uncomment the below code
	
		$sql = mysql_query("SELECT amount FROM ".$this->table." WHERE id = '$id'");
	    if (mysql_numrows($sql) != 0) {
			while ($row = mysql_fetch_array($sql)) {
				$num = (float)$row['amount'];
				if($num == $price){
					$valid_price = true;
				}
			}
	    }
		return $valid_price;
	}
	
	function _test_email() {
					$this->load->library("email");
					// Email to site owner
					$type = "Payment was successful";
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					$this->email->from('noreply@websitedojo.com');
					$this->email->to('himanshu@lamp-technolgies.com');
					$this->email->subject($type);
										
					$mes ="<html><head>";
					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";
					$mes.="<style>
								*{ margin: 0; padding: 0; font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}
										body{ margin: 5px;text-align: left; }
										h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif;}
										h6{ font-size: 14px; color: #006699}
										strong{ color:#006699; font-weight:900; }
										.content{ margin-top: 50px;}
										.content .row{ margin: 5px 0;}
										.row .message{ width: 700px; padding-top: 10px; }
										.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px; text-indent: 20px;}
										label{ font-weight:400; }
										</style>";
					$mes .= "</head><body>";
					$mes .= "<h1>School Name</h1>";
					$mes .= "<h6>Payment Status - Successful</h6>";
										
					$mes .= '<div class="content">';
					$mes .=	'<div class="row"><strong>Name: &nbsp;</strong><label>Nilesh</label></div>';
					$mes .=	'<div class="row"><strong>Email: &nbsp;</strong><label>Nilesh.gamit@gmail.com</label></div>';
					$mes .=	'<div class="row"><strong>Phone: &nbsp;</strong><label>888888888</label></div>';
					$mes .=	'<div class="row"><strong>Program Of Interest: &nbsp;</strong><label>Sr. Karate Class</label></div>';
										
					$mes .= '<div class="row">';
					$mes .= '<div class="message"><p>This is test message</p></div>';
					$mes .= '</div></div>';
					$mes .= '</body></html>';											
					$this->email->message($mes);				
					
					$this->email->send();
												
					// Email to user
					$type = "Payment was successful";
					$cont = "Congratulations! Your Payment was accepted! A representative from our school will contact you shortly with more information."; 
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					$this->email->from('noreply@websitedojo.com');
					$this->email->to('nilesh.gamit@gmail.com');
					$this->email->subject($type);
												
					$mes ="<html><head>";
					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";
					$mes.="<style>
									*{ margin: 0; padding: 0; font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}
									body{ margin: 5px;text-align: left;  }
									h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif;}
									h6{ font-size: 14px; color: #006699}
									strong{ color:#006699; font-weight:900; }
									.content{ margin-top: 50px;}
									.content .row{ margin: 5px 0;}
									.row .message{ width: 700px; padding-top: 10px; }
									.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px; text-indent: 20px;}
									label{ font-weight:400; }
									</style>";
					$mes .= "</head><body>";
					$mes .= "<h1>School Name</h1>";
					$mes .= "<h6>Payment Status - Successful</h6>";
													
					$mes .= '<div class="row">';
					$mes .= '<div class="message"><p>'.$cont.'</p></div>';
					$mes .= '</div></div>';
					$mes .= '</body></html>';
								
					$this->email->message($mes);
					
					$this->email->send();
		
	}
	
}