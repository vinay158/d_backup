<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Upsells_order_model extends CI_Model {

	

	var $table = 'tblpayments';

	

	function addTrialNew_($data, $product_id){
		
		date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$offer_detail = array();
		$this->db->limit(1);
		$offer_detail = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 0);
		
		$upsellTitleArr = '';
			$upsellTitleOrderArr = '';
			if( isset($_POST['upsale_id']) && !empty($_POST['upsale_id']) ){
				$upsale_ids = $_POST['upsale_id'];
				if ( empty($upsale_ids[0]) ) {
					unset($upsale_ids[0]);
				}				
				
			$i = 1;
			foreach ($upsale_ids as $id ) {
				if ( !empty($id) ){
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				$upsellTitleArr .= '<strong>Upsell Added-'.$i.': </strong><label>'.$upsell_title.'</label><br>';
				$upsellTitleOrderArr .= 'Upsell-'.$i.': '.$upsell_title."\r\n";
				}

			$i++;	
			}

			
		}
		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$productDetail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $product_id);
		$product_title =  isset($productDetail[0]->title) ? $productDetail[0]->title : '';
		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		
		
		$mailchimp_type = 0;
		$mailchimp_template_id = '';
		$mailchimp_api_key = '';
		if(!empty($check_mailchimp)){
			$mailchimp_type = $check_mailchimp[0]->type;
			$mailchimp_template_id = $check_mailchimp[0]->template_id;
			$mailchimp_api_key =  $check_mailchimp[0]->api_key;
		}

			/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		
		
		
		$name = $_POST['name'];
		$last_name = $_POST['last_name'];

		$phone = str_replace(' ', '-', $_POST['phone']);
		$email = trim($_POST['email']);
		
		$address1 = $_POST['address'];

		$address2 = isset($_POST['address_line2'])? $_POST['address_line2'] : '';

		$city = $_POST['city'];

		$state = $_POST['state'];

		$zip = $_POST['zip'];

		$program = isset($_POST['program']) ? $_POST['program'] : '';

		

		//echo $program;


		/*
		* checkFormModuleApplyAPI 				
		* this function for using apis according form model 				
		*/				
		
		$this->query_model->checkFormModuleApplyAPI($_POST);
		
		$extraContentArr  = array('dojocart_title' => $product_title, 'dojocart_quantity' => $quantity, 'dojocart_amount'=> '$'.$amount, 'upsell_list'=>$upsellTitleArr, 'paymentResult' => $paymentResult);
		
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST);	
		

		if($program != 0){

			$program_info = $this->query_model->getbyId("tblprogram", $program);

			$program = $program_info[0]->program;	

		}else{

			$program = '';

		}



		

		/* New added */

		if(isset($_POST['school_interest']) && !empty($_POST['school_interest'])){

			$location_info = $this->query_model->getbyId("tblcontact", $_POST['school_interest']);

			$location_name = $location_info[0]->name;

			$location_email = $location_info[0]->email;
			
			

		}else{

			$location_name = '';
			
			

		}


		//echo $noreply_email_address; die;
		
		// vinay 16_2
		$site_setting = $this->query_model->getbyTable('tblsite');
		
		if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
				
				$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));

				$location_data = $qry->row_array();
				
				$site_email = $location_data['email'];
				
				$noreply_email_address = $location_data['email'];
		
		} else{
				$main_location_id = $this->query_model->getMainLocation();
				$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));

				$location_data = $qry->row_array();
				$query1 = $this->query_model->getbyTable('tblsite');
				
				$site_email = trim($query1[0]->email);
				
				$site_setting = $this->query_model->getbyTable('tblsite');	
				$noreply_email_address = $site_setting[0]->email;
		}
		//echo 'noreply_email_address=>'.$noreply_email_address; die;
		
		
		
		/* End */

		$message = '';

		$amount = !empty($offer_detail) ? $offer_detail[0]->amount : 0;

		$paypalEmail = 'info@websitedojo.com';

								
				
				if(!empty($offer_detail) && $offer_detail[0]->trial==1){
					

					$data = array("name" => $name,"last_name"=>$last_name, "phone" => $phone, "email" => $email, "program_of_interest" => $program,"school_of_interest" => $location_name, "amount" => $amount, "message" => $message);

				}

				else{

					$data = array("name" => $name,"last_name"=>$last_name, "phone" => $phone, "email" => $email,  "program_of_interest" => $program,"school_of_interest" => $location_name,"message" => $message);					

					

					$record = $this->query_model->getbySpecific($this->table, 'email', $email);

					if($record){

						

						//$this->query_model->update($this->table, '', $data);	

						$this->db->where('email', $email);

						$this->db->update($this->table, $data);

						

					}else{

						$this->query_model->insertData($this->table, $data);	

					}



			/*** Save Order in tbl_dojocart_orders table **/
		
			$insertOrder = array();
			$insertOrder['name'] =$this->input->post('name');
			$insertOrder['last_name'] =$this->input->post('last_name');
			$insertOrder['email'] =$this->input->post('email');
			$insertOrder['phone'] =$this->input->post('phone');
			//$insertOrder['product_id'] = $product_id;
			$insertOrder['address'] =$this->input->post('address');
			$insertOrder['address_line2'] =$this->input->post('address_line2');
			$insertOrder['city'] =$this->input->post('city');
			$insertOrder['state'] =$this->input->post('state');
			$insertOrder['zip'] =$this->input->post('zip');
			$insertOrder['term_condition'] = $this->input->post('term_condition');
			
			$insertOrder['trans_status'] = 'Success';
			$insertOrder['created'] = date('Y-m-d H:i:s');
			
			//$insertOrder['product_id'] = isset($_POST['product_id'])? $_POST['product_id'] : 0;
			
			$insertOrder['location_id'] = $location_data['id'];
			$insertOrder['trial_id'] = isset($_POST['trial_id'])? $_POST['trial_id'] : 0;
			$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;
			$insertOrder['upsells_title'] = $upsellTitleOrderArr;
			$insertOrder['offer_type'] = 'Paid';
			$ipAddress = $this->query_model->getCountryNameToIpAddress();
			$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
			$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
			$this->query_model->insertData('tblorders', $insertOrder);	
			$order_id = $this->db->insert_id();

			if(!empty($order_id)){
				$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
				
			}
			

					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

					//	$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;

					$multi_calendar_qry = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_location'");
				$multi_calendar_result = $multi_calendar_qry->result();
				$multi_calendar = $multi_calendar_result[0];				 
				
	
			/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
				//echo $_POST['location_id']; die;
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1 && isset($_POST['location_id'])){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}
				
				//echo 'text_address=>'.$text_address; die;
				//echo str_replace(' ','_',"Free Trial | ".$school_name.' | '.$name.' '.$last_name); die;
				if(!empty($text_address)){	
					
					$type =  isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
					
					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
		if(!empty($fromEmailId)){
			$this->email->from($fromEmailId);
		}
		if(!empty($replyEmailId)){
			$this->email->reply_to($replyEmailId);
		}
		if(!empty($cc_email)){
			$this->email->bcc($cc_email);
		}
		
		

					$this->email->to($text_address);

					$this->email->subject($type);

					
					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';

					$mes .= "<br/>";
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';

					
					
					
					$this->email->message($mes);

					$this->email->send();

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send(); */
			}		
/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
					
				//Mail to admin	
					
					$type =  isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
		if(!empty($fromEmailId)){
			$this->email->from($fromEmailId);
		}
		if(!empty($replyEmailId)){
			$this->email->reply_to($replyEmailId);
		}
		if(!empty($cc_email)){
			$this->email->bcc($cc_email);
		}
		
		

					$this->email->to($site_email);

					$this->email->subject($type);

										

					
					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';

					$mes .= "<br/>";
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					

					$this->email->message($mes);

					

					$this->email->send();

					

					// send email to websitedojo.com

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

					// Email to user
				
				
				if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){
					
					$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';

					$cont = "Thank you, your order was accepted! A representative from our school will contact you shortly with more information."; 

					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					$from_email=trim($this->config->item('email_from'));

					

					/*if(!empty($from_email)){

						$this->email->from($noreply_email_address,$school_name);

					}else{

						$this->email->from($site_email,$school_name);

					} */

					
					$this->email->from($noreply_email_address, $school_name);
					$this->email->reply_to($noreply_email_address, $school_name);

					$this->email->to($email);

					$this->email->subject($type);

												
					$mes  = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';

					//$mes .= "<br/>";
					$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';



					$this->email->message($mes);

					$this->email->send();
					
				}
				
				
				
				$this->load->view("dojocart-trial-sent");


				}

				

			

			

		

	}	

	

	

	

	function handlePaypalResponse(){

		

		$file='payment_test';

		$log_title = "Response from paypal::I";	

		$this->fnMakeLog($log_title,$_POST,$file);

		$this->fnMakeLog($log_title,$_GET,$file);

		

		if (isset($_POST["txn_id"]) && isset($_POST["txn_type"])){

			

			$data['payment_status'] 	= $_POST['payment_status'];

			$data['txnid']			= $_POST['txn_id'];

			$email 		= $_POST['custom'];

			

			$this->db->where('email', $email);

			$this->db->update($this->table, $data);			

			$this->load->library("email");					

			$query = $this->query_model->getbyTable('tblsite');					

			$qry = $this->db->query("select * from `tblsite` limit 1") or die(mysqli_error($this->db->conn_id));	

			$site_settings = $qry->row_array();

			//echo '<pre>'; print_r($site_settings); echo '</pre>';

			$site_email = $site_settings['email'];	

			$site_title = $site_settings['title'];	

			$config['charset'] = 'iso-8859-1';

			$config['wordwrap'] = TRUE;	

			$config['mailtype'] = "html";					

			// email to customer

	

			$subject = 'Paid Trial Acknowledgement | '.$site_title;

	

			$msg_body  = "Thank you for signing up for the ".$site_title." trial offer. You will receive a separate email with your payment receipt.";
			$msg_body .= "<br/><br/>";
			$msg_body .= "A representative will contact you to schedule your first class. You may also contact the school directly using the contact information at the bottom of this email.";			

	

			$msg_body .= "<br/><br/>";

	

			$msg_body .= $site_title."<br/>";

	

			$msg_body .= $site_settings['phone']."<br/>";

	

			$msg_body .= $site_settings['address']."<br/>";

	

			$msg_body .= $site_settings['city'].", ".$site_settings['state']." ".$site_settings['zip'];

	

			$this->email->initialize($config);

	

			$this->email->from('noreply@websitedojo.com');

	

			$this->email->reply_to($site_email, $site_title);

	

			$this->email->to($email);	

	

			$this->email->subject($subject);	

			$this->email->message($msg_body);	

			$this->email->send();
			

			// email to admin
			
			// get payer detail
			
			$this->db->select('tblpayments.*, tblprogram.program');
			$this->db->from('tblpayments');
			$this->db->join('tblprogram', 'tblprogram.id = tblpayments.program_of_interest', 'left');
			$this->db->where('tblpayments.email', $email);
			$this->db->limit(1);
			
			$query = $this->db->get();		

			$payer_data = $query->row_array();			
			
			$sql = $this->db->last_query();

			$msg_body ="<html><head>";

			$msg_body .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

			$msg_body.="<style>

			*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif;}

			body{ text-align: left; }

			h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px;margin-top: 5px;}

			h6{ font-size: 14px; color: #006699; line-height:14px;}

			strong{ color:#006699; font-weight:900; }

			</style>";

			$msg_body .= "</head><body>";

			$subject = 'Paid Trial Lead Notification | '.$site_title;
	

		$msg_body  = "<strong>Paid Trial Lead</strong>";		

		$msg_body .= "<br/><br/>";

		$msg_body .= "<strong>Name:</strong> ".$payer_data['name']."<br/>";

		$msg_body .= "<strong>Phone:</strong> ".$payer_data['phone']."<br/>";

		$msg_body .= "<strong>Email:</strong> ".$payer_data['email']."<br/>";

		$msg_body .= "<strong>Age:</strong> ".$payer_data['age']."<br/>";		

		//$msg_body .= "<strong>Paypal email:</strong> ".$_post['payer_email']."<br/>";

		$msg_body .= "<strong>School of Interest:</strong> ".$payer_data['school_of_interest']."<br/>";
		
		$msg_body .= "<strong>Program of Interest:</strong> ".$payer_data['program_of_interest']."<br/>";		

		$msg_body .= "<strong>Message:</strong> ".$payer_data['message']."<br/>";
		
		$msg_body .= "<strong>Payment Amount:</strong> $".$_POST['mc_gross']."<br/>";		

		$msg_body .= '</body></html>';

			$this->email->initialize($config);	

			$this->email->from('noreply@websitedojo.com');	

			$this->email->reply_to($site_email, $site_title);

			$this->email->to($site_email);	
                        
                        $this->email->cc('leads@websitedojo.com');	

			$this->email->subject($subject);

			$this->email->message($msg_body);

			$this->email->send();	

		}

		

	}

	

	function handlePaypalResponse_(){

		$file='payment_test';	



		$log_title = "Response from paypal::I";	

		$this->fnMakeLog($log_title,$_POST,$file);

		$this->fnMakeLog($log_title,$_GET,$file);	

			

		// Check if paypal request or response

		if (isset($_POST["txn_id"]) && isset($_POST["txn_type"])){

					

			// Response from PayPal

			// assign posted variables to local variables

			$data['item_number'] 		= $_POST['item_number'];

			$data['payment_status'] 	= $_POST['payment_status'];

			$data['payment_amount'] 	= $_POST['mc_gross'];

			$data['txn_id']			= $_POST['txn_id'];

			$data['custom'] 		= $_POST['custom'];

			

			///log for testing

			$log_message=array();

	    	$log_title = "Response from paypal::II";	    	

		    $log_message=$data;

		    $this->fnMakeLog($log_title,$log_message,$file);			

		

			// Validate payment (Check unique txnid & correct price)

			$valid_txnid = $this->check_txnid($data['txn_id']);

 			$valid_price = $this->check_price($data['payment_amount'], $data['item_number']);

 			

			// PAYMENT VALIDATED & VERIFIED!

			if($valid_txnid && $valid_price){

				$log_message=array();

	    		$log_title = "Payment verified";	    	

		    	$log_message['valid_txnid']=$valid_txnid;

		    	$log_message['valid_price']=$valid_price;

			    $this->fnMakeLog($log_title,$log_message,$file);

				

				$orderid = $this->editTrial($data, $data['custom']);

				if($orderid){



					$name = $email = $phone = $age = $program = $message = $site_email = $school_name = '';



					$payment_info = $this->getTransactionDetails($data['txn_id']);

											

					if($payment_info) {

						$name = $payment_info['name'];

 						$email = trim($payment_info['email']);

	  					$phone = $payment_info['phone'];

						$age = $payment_info['age'];

						$program = $payment_info['program_of_interest'];

						$location_name = $payment_info['school_of_interest'];

						

						/*$program_info = $this->query_model->getbyId("tblprogram", $payment_info['program_of_interest']);

						$program = $program_info[0]->program;

									

						$location_info = $this->query_model->getbyId("tblcontact", $payment_info['school_of_interest']);

						$location_name = $location_info[0]->name;*/

						

						$location_info = $this->query_model->getbySpecific("tblcontact", "name",$payment_info['school_of_interest']);

						$location_email = $location_info[0]->email;

									

						$query = $this->query_model->getbyTable('tblsite');

						foreach($query as $row):

							$site_email = trim($row->email);

							$school_name = $row->title;

						endforeach;	

							

						if($location_name != ""){

							$site_email = trim($location_email);

						}

						

						$message = $payment_info['message'];

						

						$log_message=array();

						$log_title = "Payment info";

			    		$log_message=$payment_info;

				    	$this->fnMakeLog($log_title,$log_message,$file);

						

					}

							

					// Payment has been made & successfully inserted into the Database

					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

						$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;



					// Email to site owner

					$type = "Start Trial: $program";

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

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px;margin-top: 5px;}

					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					.content{ margin-top: 10px!important;}

					.content .row{ margin: 5px 0;}

					.row .message{ width: 700px; padding-top: 10px; }

					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}

					label{ font-weight:400; }

			

					</style>";

					$mes .= "</head><body>";

					if(isset($location_name) && !empty($location_name)){

						$mes .= "<h1>".$school_name." - ".$location_name."</h1>";	

					}else{

						$mes .= "<h1>".$school_name."</h1>";

					}	

					$mes .= "<strong>Payment Status - Successful</strong>";

										

					$mes .= '<div class="content">';

					$mes .=	'<div class="row"><strong>Name: &nbsp;</strong><label>'.$name.'</label></div>';

					$mes .=	'<div class="row"><strong>Email: &nbsp;</strong><label>'.$email.'</label></div>';

					$mes .=	'<div class="row"><strong>Phone: &nbsp;</strong><label>'.$phone.'</label></div>';

					$mes .=	'<div class="row"><strong>Age: &nbsp;</strong><label>'.$age.'</label></div>';

					if(isset($location_name) && !empty($location_name)){

						$mes .=	'<div class="row"><strong>School Of Interest: &nbsp;</strong><label>'.$school_name.' - '.$location_name.'</label></div>';

					}else{

						$mes .=	'<div class="row"><strong>School Of Interest: &nbsp;</strong><label>'.$school_name.'</label></div>';

					}

					$mes .=	'<div class="row"><strong>Program Of Interest: &nbsp;</strong><label>'.$program.'</label></div>';

										

					$mes .= '<div class="row">';

					$mes .= '<div class="message"><p>'.$message.'</p></div>';

					$mes .= '</div></div>';

				  	$mes .= '</body></html>';

											

					$this->email->message($mes);

					

					$this->email->send();

					

					$log_message=array();

					$log_title = "Email 1";

		    		$log_message['Site owener']='sent';

		    		$log_message['From']=$name;

		    		$log_message['To']=$site_email;		    		

			    	$this->fnMakeLog($log_title,$log_message,$file);

					

					// Email to user

					$type = "$school_name - Start trial";

					$cont = "Congratulations! Your Payment was accepted! A representative from our school will contact you shortly with more information."; 

					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					$from_email=$this->config->item('email_from');					

					if(!empty($from_email)){

						$this->email->from($from_email,$school_name);

					}else{

						$this->email->from($site_email,$school_name);

					}					

					

					$this->email->reply_to($site_email);					

					$this->email->to($email);				

					

					$this->email->subject($type);

												

					$mes ="<html><head>";

					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

					$mes.="<style>

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px;margin: 5px 0;}

					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					.content{ margin-top: 5px;}

					.content .row{ margin: 5px 0;}

					.row .message{ width: 700px; padding-top: 10px; }

					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}

					label{ font-weight:400; }

			

					</style>";

					$mes .= "</head><body>";

					$mes .= "<h1>".$school_name."</h1>";

					$mes .= "<strong>Payment Status - Successful</strong>";

													

					$mes .= '<div class="row">';

					$mes .= '<div class="message"><p>'.$cont.'</p></div>';

					$mes .= '</div></div>';

				 	$mes .= '</body></html>';

								

					$this->email->message($mes);

					

					$this->email->send();

					

					$log_message=array();

					$log_title = "Email 2";

		    		$log_message['Customer']='sent';

		    		$log_message['From']=$from_email;

		    		$log_message['To']=$email;

			    	$this->fnMakeLog($log_title,$log_message,$file);

				}

			}

		}	

	}

		

	public function editTrial($data,$last_id){

		if(is_array($data)){

	        $sql = mysqli_query($this->db->conn_id,"UPDATE ".$this->table." SET `txnid`='".$data['txn_id']."',`payment_status`='".$data['payment_status']."' WHERE id='$last_id'");

		    return true;

	    }

	    return false;

	}

	

	function getTransactionDetails($tnxid) {		

		$sql = mysqli_query($this->db->conn_id,"SELECT * FROM ".$this->table." WHERE txnid = '$tnxid'");
		
	    if (mysqli_num_rows($sql) != 0) {

			while ($row = mysqli_fetch_array($sql)) {

				return $row;

			}

	    }

	    

	    return false;

	}

	

	function check_txnid($tnxid){

		$valid_txnid = true;

	    $sql = mysqli_query($this->db->conn_id,"SELECT * FROM ".$this->table." WHERE txnid = '$tnxid'");

		if($row = mysqli_fetch_array($sql)) {

	        $valid_txnid = false;

		}

	    return $valid_txnid;

	}

	

	function check_price($price, $id){

	    $valid_price = false;



	    //you could use the below to check whether the correct price has been paid for the product

		//if so uncomment the below code

	

		$sql = mysqli_query($this->db->conn_id,"SELECT amount FROM ".$this->table." WHERE id = '$id'");

	    if (mysqli_num_rows($sql) != 0) {

			while ($row = mysqli_fetch_array($sql)) {

				$num = (float)$row['amount'];

				if($num == $price){

					$valid_price = true;

				}

			}

	    }

		return $valid_price;

	}

	

	public function fnMakeLog($title,$message_arr,$file) {

		

		$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/demov2/".$file.".log", "a+");



		if($handle){			

			$message = "[".date("Y-m-d H:i:s")."] ".$title."\n";

			fwrite($handle,$message);

			foreach($message_arr as $field=>$value){

				$message = $field." => ".$value."\n";

				fwrite($handle,$message);

			}

			$message = "\n".str_repeat("=",90)."\n";

			fwrite($handle,$message);

			fclose($handle);	

		}

		

		return true; 

	}

}