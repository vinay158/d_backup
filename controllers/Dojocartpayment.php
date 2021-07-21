<?php 

 require 'vendor/autoload.php';

				

				use net\authorize\api\contract\v1 as AnetAPI;

				use net\authorize\api\controller as AnetController;

					

if ( ! defined('BASEPATH')) exit('No direct script access allowed');







class Dojocartpayment extends CI_Controller {

function __construct(){

		parent::__construct();

		$this->load->model('cartorder_model');

	}
	

public function authorized_payment_gateway($product_id = null){
	$_POST['submit'] = 'Purchase Now';
		

		if(isset($_POST['submit'])){
			//echo '<pre>_POST'; print_r($_POST); die;
			date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			
			// kz multi_item
			$is_multi_item_dojocart = (isset($_POST['is_multi_item_dojocart']) && $_POST['is_multi_item_dojocart'] == 1) ? $_POST['is_multi_item_dojocart'] : 0;
			if($is_multi_item_dojocart == 1){
				$_POST['name'] = isset($_POST['contact_name'][1]) ? $_POST['contact_name'][1] : '';
				$_POST['last_name'] = isset($_POST['contact_last_name'][1]) ? $_POST['contact_last_name'][1] : '';
			}
			
			/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		
			$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
			$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
			$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
			$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
			$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
			
			$upsellTitleArr = '';
			$upsellTitleOrderArr = '';
			$dojocartUpsalesIdsArr = array();
			/*if( isset($_POST['upsale_id']) && !empty($_POST['upsale_id']) ){
				$upsale_ids = $_POST['upsale_id'];
				if ( empty($upsale_ids[0]) ) {
					unset($upsale_ids[0]);
				}				
				
			$i = 1;
			foreach ($upsale_ids as $id ) {
				if ( !empty($id) ){
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
					}
				}

			$i++;	
			}

			
		}*/
		
		
		$upsellsArr = array();
		$upsellsOrderArr = array();
		if( isset($_POST['upsell']) && !empty($_POST['upsell']) ){
			$i = 1; 
			foreach($_POST['upsell'] as $key => $upsell){
			 if (isset($upsell['id']) && !empty($upsell['id']) && isset($upsell['is_active']) && $upsell['is_active'] == 1){
				
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $upsell['id']);
				$qty = (isset($upsell['qty']) && !empty($upsell['qty'])) ? $upsell['qty'] : 0;
				if($qty > 1 && !empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 0){
					$qty = 1;
				}
				
				
				$amount = (isset($upsell['amount']) && !empty($upsell['amount'])) ? $upsell['amount'] : 0;
				$total_amount = $amount * $qty;
				$dojocart_upsale_title = !empty($upsellDetail) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 1){
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'(qty='.$qty.'&amount='.$site_currency_type.$amount.'&total='.$site_currency_type.$total_amount.')' : '';
					
				}else{
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'('.$site_currency_type.$total_amount.')' : '';
				}
				
				//$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleArr .= 'Upsell #'.$i.': '.$dojocart_upsale_title.'<br/>';
				$upsellTitleArr .= 'Amount: '.$site_currency_type.$amount.'<br/>';
				$upsellTitleArr .= 'Qty: '.$qty.'<br/>';
				$upsellTitleArr .= 'Total: '.$site_currency_type.$total_amount.'<br/><br/>';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
						
						$upsellsArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']]['qty'] = $qty;
						$upsellsOrderArr[$upsell['id']]['title'] = $upsellDetail[0]->up_title;
					}
					
					$i++;
				}
			}
		}
	
	
	
		
		
		// kz multi_item
		$dojocartItemsText = '';
		if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
			$dojocartItemsText .= '<br>';
			foreach($_POST['dojocartItem'] as $contact_number => $dojocart_item){
				if(!empty($dojocart_item)){
					foreach($dojocart_item as $item_id => $item){
						$dojocartItemsText .= $item['item_full_text'].' <br>'; 
					}	
				}
			}
		}
		
		$dojocart_custom_fields = (isset($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : '';
		$dojocart_custom_fields_serialize = !empty($dojocart_custom_fields) ? serialize($dojocart_custom_fields) : '';
		
		
		$dojocart_upsale_ids = !empty($dojocartUpsalesIdsArr) ? serialize($dojocartUpsalesIdsArr) : '';
		//echo '<pre>dojocartUpsalesIdsArr'; print_r($dojocartUpsalesIdsArr); die;
		//echo $upsellTitleOrderArr; die;
		
		$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $product_id);
		$product_title =  isset($productDetail[0]->product_title) ? $productDetail[0]->product_title : '';
		
		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);

		$mailchimp_type = 0;
		$mailchimp_template_id = '';
		$mailchimp_api_key = '';
		if(!empty($check_mailchimp)){
			$mailchimp_type = $check_mailchimp[0]->type;
			$mailchimp_template_id = $check_mailchimp[0]->template_id;
			$mailchimp_api_key =  $check_mailchimp[0]->api_key;
		}
		
		if(isset($_POST['program_id'])){

			$program_detail = $this->query_model->getbySpecific('tblprogram','id',$_POST['program_id']);

		}

		

		if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

			$location_detail = $this->query_model->getbySpecific('tblcontact','id',$_POST['location_id']);

			$location_id = $location_detail[0]->id;

			 $noreply_email_address = $location_detail[0]->email;	
		
		}else{

			$main_location_detail = $this->query_model->getMainLocation();

			$location_id = $main_location_detail[0]->id;

			
			$site_setting = $this->query_model->getbyTable('tblsite');	
			$noreply_email_address = $site_setting[0]->email;

		}	

		
	
		
		$authorizeDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
		
		
		//$transaction = new AuthorizeNetAIM ($authorizeDetail[0]->authorize_loginkey, $authorizeDetail[0]->authorize_transkey); //local
		
		$LOGINKEY = $authorizeDetail[0]->authorize_loginkey;// x_login

		$TRANSKEY = $authorizeDetail[0]->authorize_transkey;//x_tran_key
		

		$firstName =urlencode( $_POST['name']);

		$lastName =urlencode($_POST['last_name']);

		$creditCardNumber = urlencode($_POST['credit_card_number']);

		$expDateMonth =urlencode( $_POST['exp_month']);		

		// Month must be padded with leading zero

		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);		

		$expDateYear =urlencode( $_POST['exp_year']);

		$cvv2Number = urlencode($_POST['cvv']);

		$address1 = $_POST['address'];
		
		$address2 = isset($_POST['address_line2'])? $_POST['address_line2'] : '';

		$city = urlencode($_POST['city']);

		$state =urlencode( $_POST['state']);

		$zip = urlencode($_POST['zip']);

		$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;

		$term_condition = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;
	
		//give the actual amount below

		$amount = $_POST['amount'];

		$currencyCode="USD";

		$paymentType="Trial";

		$date = $expDateMonth.$expDateYear;

		

/*$post_values = array(

	 	"x_login"			=> "$LOGINKEY",

		"x_tran_key"		=> "$TRANSKEY",

	 	"x_version"			=> "3.1",

		"x_delim_data"		=> "TRUE",

		"x_delim_char"		=> "|",

		"x_relay_response"	=> "FALSE",

		//"x_market_type"		=> "2",

		"x_device_type"		=> "1",

	  	"x_type"			=> "AUTH_CAPTURE",

		"x_method"			=> "CC",

		"x_card_num"		=> $creditCardNumber,

		//"x_exp_date"		=> "0115",

		"x_exp_date"		=> $date,

	 	"x_amount"			=> $amount,

		//"x_description"		=> "Sample Transaction",

	 	"x_first_name"		=> $firstName,

		"x_last_name"		=> $lastName,

		"x_address"			=> $address1,

		"x_state"			=> $state,

		"x_response_format"	=> "1",

	 	"x_zip"				=> $zip

		// Additional fields can be added here as outlined in the AIM integration

		// guide at: http://developer.authorize.net

	);

	//comment the above line. i have given this just for testing purpose.
	$post_string = "";

	foreach( $post_values as $key => $value )$post_string .= "$key=" . urlencode( $value ) . "&";

	$post_string = rtrim($post_string,"& ");



		//for test mode use the followin url
		$post_url = "https://test.authorize.net/gateway/transact.dll";
		
		if($authorizeDetail[0]->authorize_payment_mode == "production"){
			//for live use this url
			$post_url = "https://secure.authorize.net/gateway/transact.dll"; 
		}
	

	$request = curl_init($post_url); // initiate curl object

	curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response

	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)

	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data

	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.

	$post_response = curl_exec($request); // execute curl post and store results in $post_response

	// additional options may be required depending upon your server configuration

	// you can find documentation on curl options at http://www.php.net/curl_setopt

	curl_close ($request); // close curl object

	

	// This line takes the response and breaks it into an array using the specified delimiting character

	$response_array = explode($post_values["x_delim_char"],$post_response);*/


	//remove this line. i have used this just print the response array

	//$auth_response = $transaction->authorizeAndCapture ();


	

 /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
	   
	$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName($LOGINKEY);
	$merchantAuthentication->setTransactionKey($TRANSKEY);
    
    // Set the transaction's refId
	$time = time();
    $refId = 'ref' . $time;
    
	
    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($creditCardNumber);
	$creditCard->setExpirationDate($expDateYear."-".$padDateMonth);
	$creditCard->setCardCode($cvv2Number);

    // Add the payment data to a paymentType object
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);

    // Create order information
    $order = new AnetAPI\OrderType();
    $order->setInvoiceNumber($time);
	$offer_title = $this->query_model->getMetaDescReplace($product_title);
	$order->setDescription("Dojocart: ".$offer_title);
	
	
	 // Set the customer's Bill To address
	$customerAddress = new AnetAPI\CustomerAddressType();
	$customerAddress->setFirstName($firstName);
	$customerAddress->setLastName($lastName);

    // Set the customer's identifying information
    $customerData = new AnetAPI\CustomerDataType();
	$customerData->setType("individual");
	$customerData->setId($time);
	$customerData->setEmail($_POST['email']);

    // Create a TransactionRequestType object and add the previous objects to it
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("authCaptureTransaction");
    $transactionRequestType->setAmount($amount);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);
    $transactionRequestType->setBillTo($customerAddress);
    $transactionRequestType->setCustomer($customerData);

    // Assemble the complete transaction request
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest($transactionRequestType);
	
    // Create the controller and get the response
    $controller = new AnetController\CreateTransactionController($request);
    $authorize_payment_url = \net\authorize\api\constants\ANetEnvironment::SANDBOX;
	if($authorizeDetail[0]->authorize_payment_mode == "production"){
		$authorize_payment_url = \net\authorize\api\constants\ANetEnvironment::PRODUCTION;
	}
	
    $response = $controller->executeWithApiResponse($authorize_payment_url);
	
	$paymentResult = '';
	$payment_status_code = 0;
	$payment_status_type = 'failed';
	$transaction_id = '';
	
    if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
        if ($response->getMessages()->getResultCode() == "Ok") {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getMessages() != null) {
                $trans_text = "<br/> Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
               
				$p_result = ucfirst($response->getMessages()->getMessage()[0]->getText());
				$transaction_id = $tresponse->getTransId();	
				$payment_status_code = 1;
				$payment_status_type = $p_result;
				$paymentResult = $this->query_model->getStaticTextTranslation('payment').' '.$p_result;
				
            } else {
               
                if ($tresponse->getErrors() != null) {
                    $paymentResult = $this->query_model->getStaticTextTranslation('payment_failure').': '.$tresponse->getErrors()[0]->getErrorText();
                }
            }
            // Or, print errors if the API request wasn't successful
        } else {
           
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getErrors() != null) {
                //echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
               // echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
				$paymentResult = $this->query_model->getStaticTextTranslation('payment_failure').': '.$tresponse->getErrors()[0]->getErrorText();
            } else {
				
				$error_msg = $this->query_model->getAuthorizedPaymentCardError($response->getMessages()->getMessage()[0]->getText());
				
               $paymentResult = $this->query_model->getStaticTextTranslation('payment_failure').': '.$error_msg;
            }
        }
    }
	
	//echo '<pre>paymentResult'; print_r($paymentResult); die;

	/** Insert Data in tbl_dojocart_orders table **/

	$insertOrder = array();

	$insertOrder['product_id'] = $_POST['product_id'];

	$insertOrder['name'] = $_POST['name'];

	$insertOrder['last_name'] = $_POST['last_name'];

	$insertOrder['address'] = $_POST['address'];

	$insertOrder['address_line2'] = isset($_POST['address_line2'])? $_POST['address_line2'] : '';

	$insertOrder['city'] = $_POST['city'];

	$insertOrder['state'] = $_POST['state'];

	$insertOrder['zip'] = !empty($_POST['zip']) ? $_POST['zip'] : 0;

	$insertOrder['phone'] = $_POST['phone'];

	

	$insertOrder['amount'] = $_POST['amount'];

	//$insertOrder['program_id'] = $_POST['program_id'];

	//$insertOrder['location_id'] = $_POST['location_id'];

	$insertOrder['email'] = $_POST['email'];

	//$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

	//$insertOrder['trial_id'] = $_POST['trial_id'];

	$insertOrder['trans_status'] = 'failed';

	$insertOrder['offer_type'] = 'Paid';

	$insertOrder['created'] = date('Y-m-d H:i:s');
	$insertOrder['product_id'] = isset($_POST['product_id'])? $_POST['product_id'] : 0;
	$insertOrder['quantity'] = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;
	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	$insertOrder['is_multi_item_dojocart'] = $is_multi_item_dojocart; //multi_item
	$insertOrder['items_list'] = $dojocartItemsText; //multi_item
	$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['upsale_ids'] = $dojocart_upsale_ids;
	$insertOrder['custom_fields'] = $dojocart_custom_fields_serialize;
	$insertOrder['upsells'] = !empty($upsellsArr) ? serialize($upsellsArr) : '';
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
	

	$this->query_model->insertData('tbl_dojocart_orders', $insertOrder);

	$order_id = $this->db->insert_id();
	
	if(!empty($order_id)){
		
		$this->query_model->updateOrderForKabanLeads($order_id,'tbl_dojocart_orders','Dojo Cart Purchase',$_POST);
	}
	
	
	// multi_item save order items 
	if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
		$this->query_model->save_dojocart_order_items($_POST['dojocartItem'], $order_id,$product_id);
	}
	
	// upsell qty save order upsells 
	if(!empty($upsellsOrderArr)){
		$this->query_model->save_dojocart_order_upsells($upsellsOrderArr, $order_id,$product_id);
	}

		/*		
		* checkFormModuleApplyAPI 						
		* this function for using apis according form model 						
		*/
		/*$paymentResult = '';
		if($response_array[0]==2 || $response_array[0]==3){
			$paymentResult = 'Payment Failure: '.$response_array[3];
		}else{
			$paymentResult = 'Payment Success';
		}*/
		
		/*$paymentResult = '';
		if($response_array[0] != 1){
			$paymentResult = $this->query_model->getStaticTextTranslation('payment_failure').': '.$response_array[3];
		}else{
			$paymentResult = $this->query_model->getStaticTextTranslation('payment_success');
		}*/
		
		$this->query_model->checkFormModuleApplyAPI($_POST);
		
		
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		$extraContentArr  = array('dojocart_title' => $product_title, 'dojocart_quantity' => $quantity, 'dojocart_amount'=> $site_currency_type.$amount, 'upsell_list'=>$upsellTitleArr, 'paymentResult' => $paymentResult,'dojocart_coupon_name'=>$coupon_code,'dojocart_coupon_discount'=>$coupon_discount,'dojocart_custom_fields'=>$dojocart_custom_fields,'dojocart_item_list'=>$dojocartItemsText);
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);

		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'dojocart',$extraContentArr);
		
	//echo $response_array[6]; die;

	if($payment_status_code != 1) 

	{

		//success 
		$results['result'] = 0;
		$results['error_msg'] = $paymentResult;
		$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$this->query_model->getStaticTextTranslation('error_string').': '.$paymentResult.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
		//echo 'fail'.$results['error_message']; 
		/*echo '<b>Payment Failure</b>. <br>';

		echo '<b>Error String</b>: '.$response_array[3];

		echo '<br><br>Press back button to go back to the previous page';*/
			
			/****************************************************************************************************************************/
			
			
			
		
				
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
			
						$location_name = $location_info[0]->name;
			
						$location_email = $location_info[0]->email;
			
					}else{
			
						$location_name = '';
			
					}
					
					$name = $_POST['name'];
					$last_name = $_POST['last_name'];
					$email = $_POST['email'];
					$phone = str_replace(' ', '-', $_POST['phone']);

					$message = $this->query_model->getStaticTextTranslation('payment_failure');
					$program = isset($_POST['program_id'])? $_POST['program_id']:0;

						if($program != 0){
				
							$program_info = $this->query_model->getbyId("tblprogram", $program);
				
							$program = $program_info[0]->program;	
				
						}else{
				
							$program = '';
				
						}
					
					$site_setting = $this->query_model->getbyTable('tblsite');
						
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
							
							$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
							
							$loc_email = $location_data['email'];
					
					} else{
							$main_location_id = $this->query_model->getMainLocation();
							$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
					}
					
					
					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

						$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;
					
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$site_email = $loc_email;

					}
					
					
					//echo $site_email; die;
					
				/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
				$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';
				
			if(isset($emailAutoResponder['admin_email'])){	
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			
				$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
				$type = '';
				$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($mes)){
					
				//$type =  isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				
					$config['charset'] = 'UTF-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					
					
					$this->email->to($text_address);
					$this->email->subject($type);
										//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
										//$mes .= "<br/>";					
										//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					$this->email->message($mes);
					$this->email->send();
			}	

		/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
			// Mail to admin (Payment Failure)
					
					$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'UTF-8';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					
					$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
					
					$this->email->to($site_email);

					$this->email->subject($type);

					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
					$mes .= "<br/>";					
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';															

					$this->email->message($mes);

					

					$this->email->send();
			}
					

					// send email to websitedojo.com

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

				// Email to user (Payment Failure)
			if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){					
			$type =  isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
			//$cont = "Thank you, your order was accepted! A representative from our school will contact you shortly with more information."; 
			$cont = $message;	
			$config['charset'] = 'UTF-8';
			$config['wordwrap'] = TRUE;	
			$config['mailtype']="html";		
			$this->email->initialize($config);	
			$from_email=trim($this->config->item('email_from'));
			/*if(!empty($from_email)){	
			$this->email->from($from_email,$school_name);
			}else{	
			$this->email->from($site_email,$school_name);
			}	*/														
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
			/************************************************************************************************************************/

	}

	else

	{
		$results['result'] = 1;
		//$ptid = $paymentResponseArr['transHash'];
		$ptid = $transaction_id;
		//$ptidmd5 = $response_array[7];

		//echo $ptid."=====>".$ptidmd5; die;

		//2250745842=====>

		$insertTransaction = array();

		$insertTransaction['transaction_id'] = $ptid;

		$insertTransaction['amount'] = 	$_POST['amount'];	

		$insertTransaction['order_id'] = $order_id;
		$insertTransaction['payment_type'] = "dojocart";

		$this->query_model->insertData('tbl_transaction', $insertTransaction);

		

		$orderUpdate = array('trans_status' => 'Success');

		$this->query_model->update('tbl_dojocart_orders', $order_id, $orderUpdate);

		
		
		
		/** EMAIL SEND**/
				
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
			
						$location_name = $location_info[0]->name;
			
						$location_email = $location_info[0]->email;
			
					}else{
			
						$location_name = '';
			
					}
					
					$name = $_POST['name'];
					$last_name = $_POST['last_name'];
					$email = $_POST['email'];
					$phone = str_replace(' ', '-', $_POST['phone']);
					$message = 'Payment Success';
					$program = isset($_POST['program_id'])? $_POST['program_id']:0;

						if($program != 0){
				
							$program_info = $this->query_model->getbyId("tblprogram", $program);
				
							$program = $program_info[0]->program;	
				
						}else{
				
							$program = '';
				
						}
					
					$site_setting = $this->query_model->getbyTable('tblsite');
						
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
							
							$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
							
							$loc_email = $location_data['email'];
					
					} else{
							$main_location_id = $this->query_model->getMainLocation();
							$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
					}
					
					
					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

						$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;
					
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$site_email = $loc_email;

					}
					
			
			/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
			$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

			

			if(isset($emailAutoResponder['admin_email'])){	
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					//$text_address = $loc_detail[0]->text_address;
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}
				
				$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
				$type = '';
				$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($mes)){
					
					//$type =  isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'UTF-8';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}

					$this->email->to($text_address);

					$this->email->subject($type);
															
					/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
					$mes .= "<br/>";*/
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';	
					
					$this->email->message($mes);

					$this->email->send();
				}
					
	/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
				
				
				
				// Mail to admin (Payment Success)
					
					//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
					$type =  isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'UTF-8';

					$config['wordwrap'] = TRUE;

					$config['mailtype']= "html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					
					$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
					
					$this->email->to($site_email);

					$this->email->subject($type);

					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';					
					$mes .= "<br/>";					
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';

					$this->email->message($mes);	

					$this->email->send();
			}
					

					// send email to websitedojo.com

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

			// Email to user (Payment Success)
			if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){
					$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';

					$cont = "Thank you, your order was accepted! A representative from our school will contact you shortly with more information."; 

					$config['charset'] = 'UTF-8';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					$from_email=trim($this->config->item('email_from'));

					

					/*if(!empty($from_email)){

						$this->email->from($from_email,$school_name);

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
		/***********/

		$results['error_message'] = "<p class='payment_result'>Thank you, your order was accepted! A representative from our school will contact you shortly with more information.</p>";

		$this->query_model->getThankYouPageMessage($_POST);
		
		$dojocart_thankyou_url = $this->query_model->getDojocartThankyouUrl($productDetail[0]->slug);
				
		redirect(@base_url().$dojocart_thankyou_url);
		//redirect(@base_url().'site/thankyou'); 
	}

	

		//$this->load->view('dojo_payment_result', $results);
		//$this->load->view("dojocart-trial-sent", $results);
		if(isset($results['result']) && $results['result'] == 0){
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 12);
			
			$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
			
			$this->load->view("upsell_thankyou_page", $results);
		}
		
		}

	}

	


public function brainTreePaymentGateway($product_id = null){
		$_POST['submit'] = 'Purchase Now';

		if(isset($_POST['submit'])){
			date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
			//echo '<pre>POST'; print_r($_POST); die;
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
			
			// kz multi_item
			$is_multi_item_dojocart = (isset($_POST['is_multi_item_dojocart']) && $_POST['is_multi_item_dojocart'] == 1) ? $_POST['is_multi_item_dojocart'] : 0;
			if($is_multi_item_dojocart == 1){
				$_POST['name'] = isset($_POST['contact_name'][1]) ? $_POST['contact_name'][1] : '';
				$_POST['last_name'] = isset($_POST['contact_last_name'][1]) ? $_POST['contact_last_name'][1] : '';
			}
			
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
		$site_currency_type = $this->query_model->getSiteCurrencyType();
			/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		
			$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
			$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
			$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
			$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
			$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
			$amount = $_POST['amount'];
			$upsellTitleArr = '';
			$upsellTitleOrderArr = '';
			$dojocartUpsalesIdsArr = array();
			
			/*if( isset($_POST['upsale_id']) && !empty($_POST['upsale_id']) ){
				$upsale_ids = $_POST['upsale_id'];
				if ( empty($upsale_ids[0]) ) {
					unset($upsale_ids[0]);
				}
				
			$i = 1;
			foreach ($upsale_ids as $id ) {
				if ( !empty($id) ){
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
					}
				}

			$i++;	
			}
			
		}*/
		
		
		$upsellsArr = array();
		$upsellsOrderArr = array();
		if( isset($_POST['upsell']) && !empty($_POST['upsell']) ){
			$i = 1; 
			foreach($_POST['upsell'] as $key => $upsell){
			 if (isset($upsell['id']) && !empty($upsell['id']) && isset($upsell['is_active']) && $upsell['is_active'] == 1){
				
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $upsell['id']);
				$qty = (isset($upsell['qty']) && !empty($upsell['qty'])) ? $upsell['qty'] : 0;
				if($qty > 1 && !empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 0){
					$qty = 1;
				}
				
				
				$amount = (isset($upsell['amount']) && !empty($upsell['amount'])) ? $upsell['amount'] : 0;
				$total_amount = $amount * $qty;
				$dojocart_upsale_title = !empty($upsellDetail) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 1){
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'(qty='.$qty.'&amount='.$site_currency_type.$amount.'&total='.$site_currency_type.$total_amount.')' : '';
					
				}else{
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'('.$site_currency_type.$total_amount.')' : '';
				}
				
				//$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleArr .= 'Upsell #'.$i.': '.$dojocart_upsale_title.'<br/>';
				$upsellTitleArr .= 'Amount: '.$site_currency_type.$amount.'<br/>';
				$upsellTitleArr .= 'Qty: '.$qty.'<br/>';
				$upsellTitleArr .= 'Total: '.$site_currency_type.$total_amount.'<br/><br/>';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
						
						$upsellsArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']]['qty'] = $qty;
						$upsellsOrderArr[$upsell['id']]['title'] = $upsellDetail[0]->up_title;
					}
					
					$i++;
				}
			}
		}
	
	
	$amount = $_POST['amount'];
	
		
		
		// kz multi_item
		$dojocartItemsText = '';
		if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
			$dojocartItemsText .= '<br>';
			foreach($_POST['dojocartItem'] as $contact_number => $dojocart_item){
				if(!empty($dojocart_item)){
					foreach($dojocart_item as $item_id => $item){
						$dojocartItemsText .= $item['item_full_text'].' <br>'; 
					}	
				}
			}
		}
		
		$dojocart_custom_fields = (isset($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : '';
		$dojocart_custom_fields_serialize = !empty($dojocart_custom_fields) ? serialize($dojocart_custom_fields) : '';
		
		
		$dojocart_upsale_ids = !empty($dojocartUpsalesIdsArr) ? serialize($dojocartUpsalesIdsArr) : '';

		

		$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $product_id);
		$product_title =  isset($productDetail[0]->product_title) ? $productDetail[0]->product_title : '';
		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		
		$mailchimp_type = 0;
		$mailchimp_template_id = '';
		$mailchimp_api_key = '';
		if(!empty($check_mailchimp)){
			$mailchimp_type = $check_mailchimp[0]->type;
			$mailchimp_template_id = $check_mailchimp[0]->template_id;
			$mailchimp_api_key =  $check_mailchimp[0]->api_key;
		}
		
		if(isset($_POST['program_id'])){

			$program_detail = $this->query_model->getbySpecific('tblprogram','id',$_POST['program_id']);

		}

		

		if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

			$location_detail = $this->query_model->getbySpecific('tblcontact','id',$_POST['location_id']);

			$location_id = $location_detail[0]->id;
			
			$noreply_email_address = $location_detail[0]->email;

		}else{

			$main_location_detail = $this->query_model->getMainLocation();

			$location_id = $main_location_detail[0]->id;

			$site_setting = $this->query_model->getbyTable('tblsite');	
			$noreply_email_address = $site_setting[0]->email;

		}	


	
		
		

		
		$brainTreeDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
		
		$braintree_merchant_id = $brainTreeDetail[0]->braintree_merchant_id;
		$braintree_public_key = $brainTreeDetail[0]->braintree_public_key;
		$braintree_private_key = $brainTreeDetail[0]->braintree_private_key;
		
			
			
			/****************Vinay new 22 july 2016*******************/
			
					$card_info = [
							'cardholderName' =>mysqli_real_escape_string($this->db->conn_id,$_POST['card_name']),
							'number' =>mysqli_real_escape_string($this->db->conn_id,$_POST['credit_card_number']),
							'expirationMonth' =>mysqli_real_escape_string($this->db->conn_id,$_POST['exp_month']),
							'expirationYear' =>mysqli_real_escape_string($this->db->conn_id,$_POST['exp_year']),
							'cvv' =>mysqli_real_escape_string($this->db->conn_id,$_POST['cvv']),
							 'options' => [
									'verifyCard' => true
								]
						];

						
						
						/*include("./vendor/Braintree.php");

						if($brainTreeDetail[0]->braintree_payment_mode == "production"){
							Braintree_Configuration::environment('production');
						}else{
							Braintree_Configuration::environment('sandbox');
						}
						
						Braintree_Configuration::merchantId($braintree_merchant_id);
						Braintree_Configuration::publicKey($braintree_public_key);
						Braintree_Configuration::privateKey($braintree_private_key);
			
						$payment_result = Braintree_Transaction::sale(['amount'=>$_POST['amount'],
							'creditCard'=>$card_info,
							'customer' => [
									'firstName' => $_POST['name'],
									'lastName' => $_POST['last_name'],
									'email' => $_POST['email']
								  ],
							//'billing' => $billing,
							'options'=>['submitForSettlement' => true]
						]);*/
						
						include("./vendor/lib/Braintree.php");
							//$this->load->library('Braintree');
							
							/*$gateway = new Braintree_Gateway([
											'environment' => $brainTreeDetail[0]->braintree_payment_mode,
											'merchantId' => $braintree_merchant_id,
											'publicKey' => $braintree_public_key,
											'privateKey' => $braintree_private_key
										]);
							
							// or like this:
							$braintree_config = new Braintree_Configuration([
								'environment' => $brainTreeDetail[0]->braintree_payment_mode,
								'merchantId' => $braintree_merchant_id,
								'publicKey' => $braintree_public_key,
								'privateKey' => $braintree_private_key
							]);*/
							
							$gateway = new Braintree\Gateway([
											'environment' => $brainTreeDetail[0]->braintree_payment_mode,
											'merchantId' => $braintree_merchant_id,
											'publicKey' => $braintree_public_key,
											'privateKey' => $braintree_private_key
										]);
							
							$clientToken = $gateway->clientToken()->generate();
							
							$payment_method_nonce = isset($_POST['payment_method_nonce']) ? $_POST['payment_method_nonce'] : '';
							
							$nonceFromTheClient = $payment_method_nonce;
						
							$braintree_useremail = isset($_POST['email']) ? $_POST['email'] : '';
							$braintree_userphone = isset($_POST['phone']) ? $_POST['phone'] : '';
						
							$result = $gateway->customer()->create([
								'firstName' => $_POST['name'],
								'lastName' => $_POST['last_name'],
								'email' => $braintree_useremail,
								'phone' => $braintree_userphone,
								'creditCard' => $card_info,
								'paymentMethodNonce' => $nonceFromTheClient
							]);
							
							$clientId = '';
							$clientToken = '';
							$payment_result = array();
							$paymentError = '';
							if ($result->success) {
								
									 $clientId = $result->customer->id;
									 $clientToken = $result->customer->paymentMethods[0]->token;
									  $description = 'Dojo Cart:- '.$product_title;
									  
									 
									 $payment_result = $gateway->transaction()->sale(['amount'=>$_POST['amount'],
										//'creditCard'=>$card_info,
										'orderId' => $description,
										'customer' => [
												'firstName' => $_POST['name'],
												'lastName' => $_POST['last_name'],
												'email' => $_POST['email']
											  ],
										'paymentMethodToken' => $clientToken,
										//'paymentMethodNonce' => $nonceFromTheClient,
										//'billing' => $billing,
										'options'=>[
													'submitForSettlement' => true, 
													'storeInVaultOnSuccess' => true,
													['amexRewards' => ['currencyIsoCode' =>$currency_type,'currencyAmount'=>$_POST['amount']]]
												]
									]);
								
								
							}else{
								$paymentError = $result->message;
							}
						
						/*echo '<pre>nonceFromTheClient=>'; print_r($nonceFromTheClient);
						echo '<pre>paymentError=>'; print_r($paymentError);
						echo '<pre>customer=>'; print_r($result);
						echo '<pre>payment_result=>'; print_r($payment_result);
						die('1');*/
			
			/**********************************************/
			

		
		/// <end code for brain tree//
		
	//remove this line. i have used this just print the response array

	

	//$auth_response = $transaction->authorizeAndCapture ();

	

	/** Insert Data in tbl_dojocart_orders table **/

	$insertOrder = array();

	$insertOrder['name'] = $_POST['name'];

	$insertOrder['last_name'] = $_POST['last_name'];

	$insertOrder['address'] = $_POST['address'];


	$insertOrder['address_line2'] =  isset($_POST['address_line2'])? $_POST['address_line2'] : '';

	$insertOrder['city'] = $_POST['city'];

	$insertOrder['state'] = $_POST['state'];

	$insertOrder['zip'] = $_POST['zip'];

	$insertOrder['phone'] = $_POST['phone'];

	

	$insertOrder['amount'] = $_POST['amount'];

	$insertOrder['email'] = $_POST['email'];

	//$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

	//$insertOrder['trial_id'] = $_POST['trial_id'];

	$insertOrder['trans_status'] = 'failed';

	$insertOrder['offer_type'] = 'Paid';

	$insertOrder['created'] = date('Y-m-d H:i:s');

	$insertOrder['quantity'] = isset($_POST['quantity'])? $_POST['quantity'] : 0;

	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;

	$insertOrder['product_id'] = isset($_POST['product_id'])? $_POST['product_id'] : 0;
	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	$insertOrder['is_multi_item_dojocart'] = $is_multi_item_dojocart; //multi_item
	$insertOrder['items_list'] = $dojocartItemsText; //multi_item
	$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['upsale_ids'] = $dojocart_upsale_ids;
	$insertOrder['upsells'] = !empty($upsellsArr) ? serialize($upsellsArr) : '';
	$insertOrder['custom_fields'] = $dojocart_custom_fields_serialize;
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
	
	$this->query_model->insertData('tbl_dojocart_orders', $insertOrder);

	$order_id = $this->db->insert_id();
	//echo '<pre>'; print_r($payment_result); die;
	
	if(!empty($order_id)){
		
		$this->query_model->updateOrderForKabanLeads($order_id,'tbl_dojocart_orders','Dojo Cart Purchase',$_POST);
	}
	
	
	// multi_item save order items 
	if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
		$this->query_model->save_dojocart_order_items($_POST['dojocartItem'], $order_id,$product_id);
	}
	
	// upsell qty save order upsells 
	if(!empty($upsellsOrderArr)){
		$this->query_model->save_dojocart_order_upsells($upsellsOrderArr, $order_id,$product_id);
	}
	
		/*		
		* checkFormModuleApplyAPI 						
		* this function for using apis according form model 						
		*/
		$paymentResult = '';
		if(isset($payment_result->success) && isset($payment_result->transaction->id)){
			if($payment_result->success && $payment_result->transaction->id){
				$paymentResult = $this->query_model->getStaticTextTranslation('payment_success').': ';
			}
		}else{
			$p_error = (isset($payment_result->_attributes['message']) && !empty($payment_result->_attributes['message'])) ? $payment_result->_attributes['message'] : $paymentError;
			$paymentResult = $this->query_model->getStaticTextTranslation('payment_failure').': '.$p_error;
		}
		
		$this->query_model->checkFormModuleApplyAPI($_POST);
		
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		$extraContentArr  = array('dojocart_title' => $product_title, 'dojocart_quantity' => $quantity, 'dojocart_amount'=> $site_currency_type.$amount, 'upsell_list'=>$upsellTitleArr, 'paymentResult' => $paymentResult,'dojocart_coupon_name'=>$coupon_code,'dojocart_coupon_discount'=>$coupon_discount,'dojocart_custom_fields'=>$dojocart_custom_fields,'dojocart_item_list'=>$dojocartItemsText);
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'dojocart',$extraContentArr);
		
		
	if (isset($payment_result->success) && !empty($payment_result->success)) 
	{
			if($payment_result->transaction->id)
				{
					
					//payment submitForSettlement 
					$sattlement_result = $gateway->transaction()->submitForSettlement($payment_result->transaction->id);
						
					if ($sattlement_result->success) {
						$settledTransaction = $sattlement_result->transaction;
					} else {
						//print_r($sattlement_result->errors);
					}
					
					$results['result'] = 1;
					$braintreeCode=$payment_result->transaction->id;
					
			
					$ptid = $braintreeCode;
			
					
			
					//$ptidmd5 = $response_array[7];
			
					
			
					//echo $ptid."=====>".$ptidmd5; die;
			
			
					//2250745842=====>
			
					$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $ptid;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					$insertTransaction['payment_type'] = "dojocart";
			
					$this->query_model->insertData('tbl_transaction', $insertTransaction);
			
					
			
					$orderUpdate = array('trans_status' => 'Success');
			
					$this->query_model->update('tbl_dojocart_orders', $order_id, $orderUpdate);
			
					
					
					
					/** EMAIL SEND**/
							
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
						
									$location_name = $location_info[0]->name;
						
									$location_email = $location_info[0]->email;
						
								}else{
						
									$location_name = '';
						
								}
								
								//echo $location_name; die;
								
								$name = $_POST['name'];
								$last_name = $_POST['last_name'];
								$email = $_POST['email'];
								$phone = str_replace(' ', '-', $_POST['phone']);
								$message = 'Payment Success';
								$program = isset($_POST['program_id'])? $_POST['program_id']:0;
			
									if($program != 0){
							
										$program_info = $this->query_model->getbyId("tblprogram", $program);
							
										$program = $program_info[0]->program;	
							
									}else{
							
										$program = '';
							
									}
								
								$site_setting = $this->query_model->getbyTable('tblsite');
									
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
										
										$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
						
										$location_data = $qry->row_array();
										
										$loc_email = $location_data['email'];
								
								} else{
										$main_location_id = $this->query_model->getMainLocation();
										$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
						
										$location_data = $qry->row_array();
								}
								
								
								$this->load->library("email");
			
								$query = $this->query_model->getbyTable('tblsite');
			
								foreach($query as $row):
			
									$site_email = trim($row->email);
			
									$school_name = $row->title;
			
								endforeach;
								
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$site_email = $loc_email;
			
								}
								
						
						/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
						$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

						
						if(isset($emailAutoResponder['admin_email'])){	
							$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiple_loc[0]->field_value == 1){
								$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
								//$text_address = $loc_detail[0]->text_address;
								$text_address = 0;
							}else{
								$loc_detail = $this->query_model->getMainLocation("tblcontact");
								$text_address = $loc_detail[0]->text_address;
							}
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
							$type = '';
							$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


							if(!empty($text_address) && !empty($mes)){
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
												
									if(!empty($fromEmailId)){
										$this->email->from($fromEmailId);
									}
									if(!empty($email)){
										$this->email->reply_to($email);
									}
									if(!empty($cc_email)){
										$this->email->bcc($cc_email);
									}
			
								$this->email->to($text_address);
			
								$this->email->subject($type);
			
							//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
							//$mes .= "<br/>";	
							//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
							
			
								$this->email->message($mes);
			
								$this->email->send();
							}
								
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
							
							
							// Mail to admin (Payment Success)
							
								
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
								
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
						$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
								$this->email->to($site_email);
			
								$this->email->subject($type);
			
								$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';								$mes .= "<br/>";								
								//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';								
			
								$this->email->message($mes);
			
								
			
								$this->email->send();
						}
								
			
								// send email to websitedojo.com
			
								/*$this->email->initialize($config);
			
								$this->email->from($email);
			
								$this->email->to('leads@websitedojo.com');
			
								$this->email->subject($type.' - '.$school_name);
			
								$this->email->message($mes);					
			
								$this->email->send(); */
			
								
			
								
			
						// Email to user (Payment Success)
					if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
						$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
						$cont = "Thank you, your order was accepted! A representative from our school will contact you shortly with more information.";
						$config['charset'] = 'UTF-8';	
						$config['wordwrap'] = TRUE;	
						$config['mailtype']="html";	
						$this->email->initialize($config);											$from_email=trim($this->config->item('email_from'));																				/*		if(!empty($from_email)){	
						$this->email->from($from_email,$school_name);
						}else{					
							$this->email->from($site_email,$school_name);											
						}	 */
						
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
					/***********/
			
					$results['error_message'] = "<p class='payment_result'>Thank you, your order was accepted! A representative from our school will contact you shortly with more information.</p>";
					
						$this->query_model->getThankYouPageMessage($_POST);
						$dojocart_thankyou_url = $this->query_model->getDojocartThankyouUrl($productDetail[0]->slug);
				
						redirect(@base_url().$dojocart_thankyou_url);
						//redirect(@base_url().'site/thankyou'); 
					}
							
							
						
	}else{	

		//success
		$p_error = (isset($payment_result->_attributes['message']) && !empty($payment_result->_attributes['message'])) ? $payment_result->_attributes['message'] : $paymentError;
		
		$results['result'] = 0;
		$results['error_msg'] = $p_error;
		
		$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$p_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
		
			
			/****************************************************************************************************************************/
			
			
			
		
				
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
			
						$location_name = $location_info[0]->name;
			
						$location_email = $location_info[0]->email;
			
					}else{
			
						$location_name = '';
			
					}
					
					$name = $_POST['name'];
					$last_name = $_POST['last_name'];
					$email = $_POST['email'];
					$phone = str_replace(' ', '-', $_POST['phone']);
					$message = $this->query_model->getStaticTextTranslation('payment_failure');

					
					$site_setting = $this->query_model->getbyTable('tblsite');
						
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
							
							$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
							
							$loc_email = $location_data['email'];
					
					} else{
							$main_location_id = $this->query_model->getMainLocation();
							$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
					}
					
					
					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

						$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;
					
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$site_email = $loc_email;

					}
					
					
					//echo $site_email; die;
					
				/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
				$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

			if(isset($emailAutoResponder['admin_email'])){	
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
				$type = '';
				$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($mes)){
					
				//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				
					$config['charset'] = 'UTF-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					$this->email->to($text_address);
					$this->email->subject($type);

					//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
					//$mes .= "<br/>";	
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					

					$this->email->message($mes);
					$this->email->send();
			}					
		/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
				
				// Mail to Admin (Payment Failure)

					$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';


					$config['charset'] = 'UTF-8';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					
					$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
					$this->email->to($site_email);

					$this->email->subject($type);

										
					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';					
					$mes .= "<br/>";					
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					$this->email->message($mes);

					

					$this->email->send();
			}
					

					// send email to websitedojo.com

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

			// Email to user (Payment Failure)
			if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){									
					$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';					
					$cont = $message; 					
					$config['charset'] = 'UTF-8';					
					$config['wordwrap'] = TRUE;					
					$config['mailtype']="html";					
					$this->email->initialize($config);					
					$from_email=trim($this->config->item('email_from'));										
					/*if(!empty($from_email)){						
						$this->email->from($from_email,$school_name);					
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
				
				$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$p_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
			/************************************************************************************************************************/

	
	
	
	}
	
		//$this->load->view('dojo_payment_result', $results);
		//$this->load->view("dojocart-trial-sent", $results);
		if(isset($results['result']) && $results['result'] == 0){
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 12);
			
			$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
			
			$this->load->view("upsell_thankyou_page", $results);
		}
		
		}

	}

	// Payment Section End Here
	
	
/******************************************************** THIRD PARTY FORM    ***********************************************************/

	public function thirdPartyUrl(){
				
				
				if($_POST['website'] != ''){

					die("An error occurred, please try again");

				}

		
				$trial_detail = $this->query_model->getbySpecific('tblspecialoffer', 'id' , $_POST['trial_id']);
				$trial_amount = $trial_detail[0]->amount;
				$trial_type = $trial_detail[0]->trial;

				$email	= $this->input->post('form_email_2');

				$data['post'] = $_POST;

				

				if (!filter_var($email, FILTER_VALIDATE_EMAIL)){

					echo "<script>alert('Invalid Email Address!')</script>";

					redirect("online-special");

				}
				
				
				$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		
		$mailchimp_type = 0;
		$mailchimp_template_id = '';
		$mailchimp_api_key = '';
		if(!empty($check_mailchimp)){
			$mailchimp_type = $check_mailchimp[0]->type;
			$mailchimp_template_id = $check_mailchimp[0]->template_id;
			$mailchimp_api_key =  $check_mailchimp[0]->api_key;
		}
			
		
		
		$name = $_POST['name'];
		$last_name = $_POST['last_name'];
		//$phone = $_POST['phone1']."-".$_POST['phone2']."-".$_POST['phone3'];
		$phone = $_POST['phone'];
		$email = trim($_POST['form_email_2']);
		//echo $last_name; die;
		//$age = $_POST['age'];

		$program = $_POST['program'];

		

		//echo $program;

		/*		* checkFormModuleApplyAPI 						
		* this function for using apis according form model 
		*/								
		$this->query_model->checkFormModuleApplyAPI($_POST);	
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
		
		//$amount = $offer_detail[0]->amount;

		$paypalEmail = 'info@websitedojo.com';

			

			/*** Save Order in orders table **/
		
			$insertOrder = array();
			$insertOrder['name'] =$this->input->post('name');
			$insertOrder['last_name'] =$this->input->post('last_name');
			$insertOrder['email'] =$this->input->post('form_email_2');
			$insertOrder['phone'] =$this->input->post('phone');
			$insertOrder['program_id'] =$this->input->post('program');
			$insertOrder['location_id'] =$this->input->post('location_id');
			$insertOrder['trial_id'] =$this->input->post('trial_id');
			$insertOrder['offer_type'] = 'Paid';
			$insertOrder['trans_status'] = 'Third Party Url';
			$insertOrder['created'] = date('Y-m-d H:i:s');
			
			$this->query_model->insertData('tbl_dojocart_orders', $insertOrder);	


					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

					//	$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;

					$multi_calendar_qry = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_location'");
					$multi_calendar_result = $multi_calendar_qry->result();
					$multi_calendar = $multi_calendar_result[0];				 
					
					
						if($site_setting[0]->third_party_tiral_url_type == 1 && !empty($site_setting[0]->third_party_trial_url)){
							redirect($site_setting[0]->third_party_trial_url);
						}else{
							redirect($_SERVER['HTTP_REFERER']);
						}
					
					
					
					
					
					//redirect(@base_url().'starttrialsent?status=suc&mode=free');


	}


/**
* If Mode of payment
* Free than it will call buyspecial function
**/
		public function buyspecial(){
		
		$_POST['submit'] = 'Purchase Now';
		// checking hunney Post
		$this->query_model->checkHunneyPost($_POST);
		

		
		$product_id = $this->uri->segment(3);
		$email	= $this->input->post('email');

		$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
		$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
		$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
		$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
		$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
		$data['post'] = $_POST;
			//echo '<pre>'; print_r($data);

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				echo "<script>alert('Invalid Email Address!')</script>";
				redirect("dojocartpayment");
			}

			
			$this->cartorder_model->addTrialNew_($data['post'],$product_id);
		

	}




/**
* If Mode of payment
* Free than it will call buyspecial function
**/
		public function dojocart_buyspecial(){
				
		
		$_POST['submit'] = 'Purchase Now';
		//echo '<pre>post'; print_R($_POST); die;
		
		if(isset($_POST['custom_field']) && !empty($_POST['custom_field'])){
			$customFieldNames = $this->query_model->getCustomFieldNames($_POST['custom_field']);
			$_POST['name'] = isset($customFieldNames['name']) ? $customFieldNames['name'] : '';
			$_POST['email'] = isset($customFieldNames['email']) ? $customFieldNames['email'] : '';
		}
		
		//echo '<pre>'; print_r($_POST); die;
		//$_POST['email'] = isset($_POST['email']) ? $_POST['email'] : '';
		// checking hunney Post
		$this->query_model->checkHunneyPost($_POST);
		
		$product_id = $this->uri->segment(3);
		
		
		$data['post'] = $_POST;
		//echo '<pre>data'; print_R($data); die;
		
		/******* CODE FOR GENERATE AND SAVE PDF *********/
		$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $product_id);
		$dojocart_custom_fields = (isset($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : '';
			$pdfLink = '';
			if($productDetail[0]->is_unique_dojocart == 1){
				
				$pdf_contant = '';
				$site_logo = '';
				$form_bottom_text = !empty($productDetail[0]->form_bottom_text) ? $productDetail[0]->form_bottom_text : '';
				$website_settings = $this->query_model->getSiteSetting();
				$website_settings = $website_settings[0];
				if($productDetail[0]->override_logo != ''){
					$dojo_cart_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $productDetail[0]->override_logo);
							
					if(!empty($dojo_cart_logo) && !empty($dojo_cart_logo[0]->logos)){
						$site_logo = base_url().'upload/override_logos/'.$dojo_cart_logo[0]->logos;
					}else{
						$site_logo = base_url().$website_settings->sitelogo;
					}
					
				}
			
			$custom_fields = $this->query_model->getBySpecific('tbl_dojocart_custom_fields','dojocart_id',$productDetail[0]->id);
			$dojocartCustomFieldArr = array();
			if(!empty($custom_fields)){
				foreach($custom_fields as $custom_field){
					$dojocartCustomFieldArr[$custom_field->id]['id'] = $custom_field->id;
					$dojocartCustomFieldArr[$custom_field->id]['label_text'] = $custom_field->label_text;
					$dojocartCustomFieldArr[$custom_field->id]['type'] = $custom_field->type;
					$dojocartCustomFieldArr[$custom_field->id]['dropdown_values'] = $custom_field->dropdown_values;
					$dojocartCustomFieldArr[$custom_field->id]['field_coloumn_class'] = $custom_field->field_coloumn_class;
					$dojocartCustomFieldArr[$custom_field->id]['right_sidebar'] = $custom_field->right_sidebar;
					$dojocartCustomFieldArr[$custom_field->id]['values'] = isset($dojocart_custom_fields[$custom_field->id]) ? $dojocart_custom_fields[$custom_field->id] : '';
				}
			}
			
		
		$pdf_contant = '';
		$pdf_contant .= '<table style="width:100%; max-width:1130px; margin:20px auto 20px auto;" valign="top" class="">
  <tr>
    <td colspan="3" align="center">
    <img src="'.$site_logo.'" class="img-responsive centerlogo" alt="School Name">
    <br/><h2 style="color: #dd1e25;     color: rgb(221, 30, 37); margin-top:0" class="mainhead">REGIONAL TOURNAMENT REGISTRATION</h2></td>
  </tr>
  <tr>
    <td height="30px"></td>
  </tr>
  <tr>';
  
  $pdf_contant .= '
    <td  width="65%" class="form-group">
      <table style="width:100%; ">
      <tr>
        <td colspan="3" >
          <h2 style="font-size:50px">COMPETITOR INFORMATION:</h2>
        </td>
      </tr><tr> <td height="10px"></td></tr><tr>';
	  
	  /** $pdf_contant .=  $table_height_tr.'<tr>
			<td colspan="'.$colspan.'"  width="'.$width.'">
			  <input type="text" class="form-control" id="firstName" value="'.$custom_field['label_text'].': '.$custom_field['values'].$colspan.$width.'" >
			</td>
		  </tr>'; **/
		  
	
		  
	   if(!empty($dojocartCustomFieldArr)){
		$i = 0;
	  foreach($dojocartCustomFieldArr as $custom_field){
		 // echo '<pre>custom_field'; print_r($custom_field); die;
		 if($custom_field['type'] != "checkbox" && $custom_field['right_sidebar'] != 1){
			
			if($i % 2 == 0){
				 $pdf_contant .= '<tr> <td height="10px"></td></tr><tr>';
			}
		 
		 $colspan = '';
		 $width = '50%';
		 /*if($custom_field['field_coloumn_class'] == "col-md-12" || $custom_field['field_coloumn_class'] == ""){
			  $colspan = '';
			  $width = '50%';
		 }*/
		 
		 $pdf_input_class = ($custom_field['type'] == "radio") ? 'pdf_input_radio' : 'pdf_input_text';
		 if($custom_field['type'] == 'radio'){
			
			$dropdownValues = !empty($custom_field['dropdown_values']) ? unserialize($custom_field['dropdown_values']) : '';
			
			$pdf_contant .=  '<td class="radiobtn '.$pdf_input_class.'" width="35%" valign="top"><h2 style="font-size:40px"><label for="firstName" >'.$custom_field['label_text'].':&nbsp;&nbsp;</label>';
			
			if(!empty($dropdownValues)){
				foreach($dropdownValues as $value){
					if(!empty($value)){
					$checked = ($custom_field['values'] == $value) ? 'checked=checked' : '';
					$value = ucfirst($value);
					
						$pdf_contant .= '<input type="radio" class="custom-control-input" name="m" id="same-address" '.$checked.' ><label class="custom-control-label" for="same-address">&nbsp;&nbsp;'.$value.'&nbsp;&nbsp;&nbsp;</label>';
					}
				}
			}
			$pdf_contant .= '<h2></td>';
		 }else{
			 $pdf_contant .=  '<td  class="'.$pdf_input_class.'" colspan="'.$colspan.'"  width="'.$width.'" >
			 <div class="form-group" style="font-size:40px">'.$custom_field['label_text'].': '.$custom_field['values'].'</div>
			</td>';
		 }
			
		  
		  if($i % 2 == 0){
				 $pdf_contant .= '</tr>';
			}
		  
			$i++;
		 }	
	  }
	}
      
    $pdf_contant .= '<tr> <td height="50px"></td></tr><tr>
        <td colspan="3" width="100%"  class="greyspace">
		<h2 class=""  style="font-size:35px; margin: 20px">'.$form_bottom_text.'</h2>
		 
        </td>
      </tr><tr><td class="pdf_input_checkbox" ><div style="width:100%;color:#fff;border:0;border-bottom:1px solid #fff;background:none"><input type="text" class="" id="" style="width:100%;color:#fff;border:0;border-bottom:1px solid #fff;background:none"></div></td><td class="pdf_input_checkbox" ><div style="width:100%;color:#fff;border:0;border-bottom:1px solid #fff;background:none"><input type="text" class="" id="" style="width:100%;color:#fff;border:0;border-bottom:1px solid #fff;background:none"></div></td></tr>  </table>
    </td>';
	
	
	$pdf_contant .= '<td width="5%"></td>';
	$pdf_contant .= '<td width="30%" valign="top" class="sidebar">
       <table width="100%">';
	
	if(!empty($dojocartCustomFieldArr)){
		$i = 1;
	  foreach($dojocartCustomFieldArr as $custom_field){
		 if($custom_field['type'] == "checkbox" && $custom_field['right_sidebar'] != 1){
			$dropdownValues = !empty($custom_field['dropdown_values']) ? unserialize($custom_field['dropdown_values']) : '';
			
			$pdf_contant .=  '<tr><td width="100%" colspan=""> <h2 style="font-size:50px">'.$custom_field['label_text'].':</h2>
          </td></tr><tr><td height="10px"></td></tr>';
		 
			$seleceted_values = !empty($custom_field['values']) ? $custom_field['values'] : ''; 
			if(!empty($dropdownValues)){
				foreach($dropdownValues as $value){
					if(!empty($value)){
					$checked = (in_array($value,$seleceted_values)) ? 'checked=checked' : '';
					$value = ucfirst($value);
						
						$pdf_contant .= '<tr> <td class="pdf_input_checkbox" >
            <h2 style="font-size:40px"><input type="checkbox" class="custom-control-input " id="same-address" '.$checked.' style="font-size:40px">
            <label class="custom-control-label" for="same-address">'.$value.'</label></h2>
          </td></tr><tr><td height="10px"></td></tr>';
					}
				}
			}
		 }
	  }
	}
    
        //<tr> <td class="pdf_input_checkbox" ><h2><input type="text" class="form-control" id="same-address" style="font-size:35px"></h2></td></tr><tr><td height="10px"></td></tr>
		
		$pdf_contant .= '<tr><td class="pdf_input_checkbox" ><div style="width:100%;color:#fff;border:0;border-bottom:1px solid #fff;background:none"><input type="text" class="" id="" style="width:100%;color:#fff;border:0;border-bottom:1px solid #fff;background:none"></div></td></tr><tr><td height="10px"></td></tr><tr>  <td  class="greyspace">  <table><tbody>';
		
		if($productDetail[0]->template == "novice_blank"){
			$pdf_contant .= ' <tr> <td>'.$productDetail[0]->form_right_side_text.' </td> </tr>';
		}else{
			
			if(!empty($dojocartCustomFieldArr)){
		
			foreach($dojocartCustomFieldArr as $custom_field){
				// echo '<pre>custom_field'; print_r($custom_field); die;
				if($custom_field['type'] == "checkbox" && $custom_field['right_sidebar'] == 1){
					$dropdownValues = !empty($custom_field['dropdown_values']) ? unserialize($custom_field['dropdown_values']) : '';
			
					$pdf_contant .=  '<tr><td width="100%" colspan=""> <h3 style="font-size:40px">'.$custom_field['label_text'].':</h3>';
					
					if($productDetail[0]->template == "traditional_blank"){
					 $pdf_contant .=  '<p style="font-size:30px">PLEASE CHECK THE APPROPRIATE COMPETITION DIVISION</p>';
					}
				  $pdf_contant .=  '</td></tr><tr><td height="10px"></td></tr>';
				 
					$seleceted_values = !empty($custom_field['values']) ? $custom_field['values'] : ''; 
					if(!empty($dropdownValues)){
						foreach($dropdownValues as $value){
							if(!empty($value)){
							$checked = (in_array($value,$seleceted_values)) ? 'checked=checked' : '';
							$value = ucfirst($value);
							
						
				  
							$pdf_contant .= '<tr> <td class="pdf_input_checkbox" >
							
								<h2 style="font-size:40px"><input type="checkbox" class="custom-control-input " id="same-address" '.$checked.' style="font-size:40px">
								<label class="custom-control-label" for="same-address">'.$value.'</label></h2></td></tr><tr><td height="10px"></td></tr>';
				  
							}
						}
					}
				}else{
					
					if($custom_field['right_sidebar'] == 1){
						$pdf_contant .= '<tr>
							<td class="form-group pdf_input_text">
							<div  style="font-size:40px"> 
							 '.$custom_field['label_text'].': '.$custom_field['values'].'</div>
							</td>
						  </tr>
						   <tr>
							<td height="10px"></td>
							</tr>
						';
					}
				}
			}
		 }
			
		}
       
			  
       $pdf_contant .= ' </tbody></table></td></tr> </table></td>';
	
	
	$pdf_contant .= '</tr></table>';
	
	//echo $pdf_contant; die;
  
  
		
               // error_reporting(2);
				$pdf_name = $productDetail[0]->product_title.' - '.uniqid();
				//echo 'pdf_name=>'.$pdf_name; die;
				
				ob_end_clean();
				
				include("./vendor/mpdf/mpdf.php");
				
				$mpdf = new mPDF('utf-8');
				//echo '<pre>mpdf'; print_r($mpdf); die;
				
				$mpdf->debug = true;
			
				$mpdf->SetHTMLHeader('');

				$mpdf->SetHTMLFooter('');
				//$mpdf->setAutoTopMargin="pad";
				//$mpdf->setAutoBottomMargin="pad";
				//$mpdf->SetDirectionality('ltr');
				$mpdf->SetDisplayMode('fullpage');
				$mpdf->SetAutoFont();
				
				//$stylesheet = file_get_contents(base_url().'css/v5/form.css');
				$stylesheet  = '';
				
				$stylesheet .= file_get_contents(base_url().'css/v5/bootstrap.min.css');
				$stylesheet .= file_get_contents(base_url().'css/v5/form.css');
				$stylesheet .= file_get_contents(base_url().'css/v5/pdf.css');
				
				$mpdf->WriteHTML($stylesheet,1);
				$mpdf->WriteHTML($pdf_contant, 2);
				//$mpdf->Output();
			
				
				//die('12');
				
				$mpdf->Output('upload/dojocart_pdfs/'.$pdf_name.'.pdf','F');
				
				$pdf_url = base_url().'upload/dojocart_pdfs/'.$pdf_name.'.pdf';
				$pdf_file_path = 'upload/dojocart_pdfs/'.$pdf_name.'.pdf';
				
				
				if(file_exists($pdf_file_path)){
					$pdfLink = $pdf_url;
				}
			}
			
		//echo 'pdfLink'.$pdfLink; die;	
			
		$this->cartorder_model->saveNewDojocartForms($data['post'],$product_id,$pdfLink);
		

	}


public function stripe_payment_gateway($product_id = null){
	
		$_POST['submit'] = 'Purchase Now';
		//echo '<pre>POST'; print_r($_POST); die;
		if(isset($_POST['submit'])){
			date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
			$stripeData = $this->query_model->getStripePaymentKeys();
			
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
			
			// kz multi_item
			$is_multi_item_dojocart = (isset($_POST['is_multi_item_dojocart']) && $_POST['is_multi_item_dojocart'] == 1) ? $_POST['is_multi_item_dojocart'] : 0;
			if($is_multi_item_dojocart == 1){
				$_POST['name'] = isset($_POST['contact_name'][1]) ? $_POST['contact_name'][1] : '';
				$_POST['last_name'] = isset($_POST['contact_last_name'][1]) ? $_POST['contact_last_name'][1] : '';
			}
			
			
			/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
					$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
			$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
			$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
			$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
			$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
			$amount = $_POST['amount'];
			$upsellTitleArr = '';
			$upsellTitleOrderArr = '';
			$dojocartUpsalesIdsArr = array();
			/*if( isset($_POST['upsale_id']) && !empty($_POST['upsale_id']) ){
				$upsale_ids = $_POST['upsale_id'];
				if ( empty($upsale_ids[0]) ) {
					unset($upsale_ids[0]);
				}
				
			$i = 1;
			foreach ($upsale_ids as $id ) {
				if ( !empty($id) ){
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
					}
				}

			$i++;	
			}
			
		}*/
		
		$upsellsArr = array();
		$upsellsOrderArr = array();
		if( isset($_POST['upsell']) && !empty($_POST['upsell']) ){
			$i = 1; 
			foreach($_POST['upsell'] as $key => $upsell){
			 if (isset($upsell['id']) && !empty($upsell['id']) && isset($upsell['is_active']) && $upsell['is_active'] == 1){
				
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $upsell['id']);
				$qty = (isset($upsell['qty']) && !empty($upsell['qty'])) ? $upsell['qty'] : 0;
				if($qty > 1 && !empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 0){
					$qty = 1;
				}
				
				
				$amount = (isset($upsell['amount']) && !empty($upsell['amount'])) ? $upsell['amount'] : 0;
				$total_amount = $amount * $qty;
				$dojocart_upsale_title = !empty($upsellDetail) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 1){
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'(qty='.$qty.'&amount='.$site_currency_type.$amount.'&total='.$site_currency_type.$total_amount.')' : '';
					
				}else{
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'('.$site_currency_type.$total_amount.')' : '';
				}
				
				//$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleArr .= 'Upsell #'.$i.': '.$dojocart_upsale_title.'<br/>';
				$upsellTitleArr .= 'Amount: '.$site_currency_type.$amount.'<br/>';
				$upsellTitleArr .= 'Qty: '.$qty.'<br/>';
				$upsellTitleArr .= 'Total: '.$site_currency_type.$total_amount.'<br/><br/>';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
						
						$upsellsArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']]['qty'] = $qty;
						$upsellsOrderArr[$upsell['id']]['title'] = $upsellDetail[0]->up_title;
					}
					
					$i++;
				}
			}
		}
	
	$amount = $_POST['amount'];
	
		// kz multi_item
		$dojocartItemsText = '';
		if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
			$dojocartItemsText .= '<br>';
			foreach($_POST['dojocartItem'] as $contact_number => $dojocart_item){
				if(!empty($dojocart_item)){
					foreach($dojocart_item as $item_id => $item){
						$dojocartItemsText .= $item['item_full_text'].' <br>'; 
					}	
				}
			}
		}
		
		$dojocart_custom_fields = (isset($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : '';
		$dojocart_custom_fields_serialize = !empty($dojocart_custom_fields) ? serialize($dojocart_custom_fields) : '';
		
		
		$dojocart_upsale_ids = !empty($dojocartUpsalesIdsArr) ? serialize($dojocartUpsalesIdsArr) : '';

		$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $product_id);
		$product_title =  isset($productDetail[0]->product_title) ? $productDetail[0]->product_title : '';
		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		
		$mailchimp_type = 0;
		$mailchimp_template_id = '';
		$mailchimp_api_key = '';
		if(!empty($check_mailchimp)){
			$mailchimp_type = $check_mailchimp[0]->type;
			$mailchimp_template_id = $check_mailchimp[0]->template_id;
			$mailchimp_api_key =  $check_mailchimp[0]->api_key;
		}
		
		if(isset($_POST['program_id'])){

			$program_detail = $this->query_model->getbySpecific('tblprogram','id',$_POST['program_id']);

		}

		

		if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

			$location_detail = $this->query_model->getbySpecific('tblcontact','id',$_POST['location_id']);

			$location_id = $location_detail[0]->id;
			
			$noreply_email_address = $location_detail[0]->email;

		}else{

			$main_location_detail = $this->query_model->getMainLocation();

			$location_id = $main_location_detail[0]->id;

			$site_setting = $this->query_model->getbyTable('tblsite');	
			$noreply_email_address = $site_setting[0]->email;

		}	


		// SCA Payment //
		
		$payment_intent_status_result = 0;
		if($stripeData['stripe_payment'] == 1 && $stripeData['stripe_sca_payment'] == 1){
				
				$description = $description = 'Dojo Cart:- '.$product_title;
					
				$paymentIntentResult = $this->query_model->retrive_payment_intent($_POST, $stripeData['stripe_secret_key'],$description);
				//echo '<pre>paymentIntentResult'; print_r($paymentIntentResult);
				
				if(!empty($paymentIntentResult) && $paymentIntentResult['status'] == "succeeded"){
					$payment_intent_status_result = 2;
					
				}else{
					$payment_intent_status_result = 1;
					die("something went wrong");
				}
				
		}
		
		//SCA Stripe Payment
		$balance_transaction = '';
		$payment_status = '';
		$clientId = '';
		$clientToken = '';
				
		if($payment_intent_status_result == 2){
			$balance_transaction = $paymentIntentResult['balance_transaction'];
			$payment_status = $paymentIntentResult['status'];
		}elseif($payment_intent_status_result == 0){

		$stripePaymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
		
		$stripe_payment = $stripePaymentDetail[0]->stripe_payment;
		$multi_stripe_check = $stripePaymentDetail[0]->multi_stripe_check;
		
		$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
		
		if($multiLocationData[0]->field_value == 1 && $multi_stripe_check == 1){
			$contact_detail = $this->query_model->getbySpecific('tblcontact','id',$location_id);
			if(!empty($contact_detail)){
				$stripe_secret_key = $contact_detail[0]->stripe_secret_key;
				$stripe_publishable_key = $contact_detail[0]->stripe_publishable_key;
			}
		}else{
			$stripe_secret_key = $stripePaymentDetail[0]->stripe_secret_key;
			$stripe_publishable_key = $stripePaymentDetail[0]->stripe_publishable_key;
		}
		
		
		
			
			
			/****************Stripe payment*******************/
			
		//	include("./vendor/Stripe.php");
			
					$card_info = [
							'cardholderName' =>mysqli_real_escape_string($this->db->conn_id,$_POST['card_name']),
							'number' =>mysqli_real_escape_string($this->db->conn_id,$_POST['credit_card_number']),
							'expirationMonth' =>mysqli_real_escape_string($this->db->conn_id,$_POST['exp_month']),
							'expirationYear' =>mysqli_real_escape_string($this->db->conn_id,$_POST['exp_year']),
							'cvv' =>mysqli_real_escape_string($this->db->conn_id,$_POST['cvv']),
						];

					
				/*$params = array(
						"testmode"   => "on",
						//"private_live_key" => "sk_live_xxxxxxxxxxxxxxxxxxxxx",
						//"public_live_key"  => "pk_live_xxxxxxxxxxxxxxxxxxxxx",
						"private_test_key" => "sk_test_szzy8u1USeSA26M6hs77c0gh",
						"public_test_key"  => "pk_test_RDm9fKSZOjt1n6ZJnAePyL7t"
					);	

				if ($params['testmode'] == "on") {
					Stripe::setApiKey($params['private_test_key']);
					$pubkey = $params['public_test_key'];
				} else {
					Stripe::setApiKey($params['private_live_key']);
					$pubkey = $params['public_live_key'];
				} */
				
				include('./vendor/stripe-latest/init.php');
				
				$params = array(
						"private_test_key" => $stripe_secret_key,
						"public_test_key"  => $stripe_publishable_key
					);	

				\Stripe\Stripe::setApiKey($params['private_test_key']);
				$pubkey = $params['public_test_key'];
				
				$payment_error = '';
				$card_error = 0;
				
				try{
					$generateToken = \Stripe\Token::create(
						array(
							"card" => array(
								"name" => mysqli_real_escape_string($this->db->conn_id,$_POST['card_name']),
								"number" => mysqli_real_escape_string($this->db->conn_id,$_POST['credit_card_number']),
								"exp_month" =>mysqli_real_escape_string($this->db->conn_id,$_POST['exp_month']),
								"exp_year" =>mysqli_real_escape_string($this->db->conn_id,$_POST['exp_year']),
								"cvc" => mysqli_real_escape_string($this->db->conn_id,$_POST['cvv']),
							)
						)
					);
				} catch(Stripe\Error\Card $e) {			

						$payment_error = $e->getMessage();
						$results['result'] = 0;
						$results['error_msg'] = $payment_error;
						$card_error = 1;
					
				}
				
			
				//$stripeToken = isset($generateToken['id']) ? $generateToken['id'] : '';
				if($card_error == 0){
					$stripeToken = isset($generateToken->id) ? $generateToken->id : ''; 
					$description = 'Dojo Cart:- '.$product_title;	
					$stripe_username = isset($_POST['name']) ? $_POST['name'] : '';		
					$stripe_userphone = isset($_POST['phone']) ? $_POST['phone'] : '';
					$customer = \Stripe\Customer::create(array(
										'source'   => $stripeToken,
										'email'    => $_POST['email'],
										'name'    => $stripe_username,
										'phone'    => $stripe_userphone,
										'description'     => $description,
										//'account_balance' => $amount_cents,
									)
								);
						//echo '<pre>customer'; print_r($customer); die;	
						$clientId = !empty($customer) ? $customer->id : '';
						$stripeToken = isset($generateToken->id) ? $generateToken->id : '';
						
				}
				
				
				if(isset($stripeToken) && !empty($stripeToken) && $card_error == 0)
				{
				
				//$trialDetail = $this->query_model->getBySpecific('tblspecialoffer','id',$_POST['trial_id']);
				//$trialTitle = !empty($trialDetail) ? $trialDetail[0]->title : '';
					$_POST['amount'] = number_format($_POST['amount'],2);
					
					$amount_cents = str_replace(".","",$_POST['amount']);  // Chargeble amount
					
					//$invoiceid = mt_rand( 10000000, 99999999);                      // Invoice ID
					$description = 'Dojo Cart:- '.$product_title;
					try {
						$payment_result = \Stripe\Charge::create(array(		 
							  "amount" => $amount_cents,
							  "currency" => $currency_type,
							 // 'email'    => $_POST['email'],
							  //"source" => $stripeToken,
							  "customer" => $clientId,
							  "receipt_email" => $_POST['email'],
							  "description" => $description)			  
						);
					
						// Payment has succeeded, no exceptions were thrown or otherwise caught				
						
						if(!empty($payment_result)){
							if(isset($payment_result->balance_transaction) && $payment_result->balance_transaction != ''){	
								$balance_transaction = $payment_result->balance_transaction;
								$payment_status = $payment_result->status;
							}
						}
						
					} catch(Stripe\Error\InvalidRequest $e) {			

						$payment_error = $e->getMessage();
					
					} 
					
			}else{
				$results['result'] = 0;
				$results['error_msg'] = $payment_error;
				$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
			}
		}
				//echo '<pre>payment_result'; print_r($payment_result); die;
					
			/**********************************************/
			
		/*$paymentResult = '';
		if(!empty($payment_result) && $payment_result->status == "succeeded" && $payment_result->balance_transaction != ''){
			$paymentResult = 'Payment Success: ';
		}else{
			$paymentResult = 'Payment Failure: '.$payment_error;
		}*/
		
		
		$paymentResult = '';
		$payment_status_code = 0;
		$payment_status_type = 'failed';
		
		if(!empty($payment_result) || $payment_intent_status_result == 2){
			if(isset($balance_transaction) && $balance_transaction != ''){
				
				$payment_status = strtolower($payment_status);
				
				$paymentStatusArr = array('succeeded','pending','paid','success','successful');
				if(in_array($payment_status,$paymentStatusArr)){
					$p_result = ucfirst($payment_status);
					
					$payment_status_code = 1;
					$payment_status_type = $p_result;
					$paymentResult = $this->query_model->getStaticTextTranslation('payment').' '.$p_result.' : ';
				}
			}
			
		}else{
			$paymentResult = $this->query_model->getStaticTextTranslation('payment_failure').': '.$payment_error;
		}
	
	
	/*echo $payment_status_type;
	echo $paymentResult;	*/
	

	/** Insert Data in tbl_dojocart_orders table **/

	$insertOrder = array();

	$insertOrder['name'] = $_POST['name'];

	$insertOrder['last_name'] = $_POST['last_name'];

	$insertOrder['address'] = $_POST['address'];


	$insertOrder['address_line2'] =  isset($_POST['address_line2'])? $_POST['address_line2'] : '';

	$insertOrder['city'] = $_POST['city'];

	$insertOrder['state'] = $_POST['state'];

	$insertOrder['zip'] = $_POST['zip'];

	$insertOrder['phone'] = $_POST['phone'];

	

	$insertOrder['amount'] = $_POST['amount'];

	$insertOrder['email'] = $_POST['email'];

	//$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

	//$insertOrder['trial_id'] = $_POST['trial_id'];

	$insertOrder['trans_status'] = $payment_status_type;

	$insertOrder['offer_type'] = 'Paid';

	$insertOrder['created'] = date('Y-m-d H:i:s');

	$insertOrder['quantity'] = isset($_POST['quantity'])? $_POST['quantity'] : 0;
	$insertOrder['product_id'] = isset($_POST['product_id'])? $_POST['product_id'] : 0;

	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;

	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	$insertOrder['is_multi_item_dojocart'] = $is_multi_item_dojocart; //multi_item
	$insertOrder['items_list'] = $dojocartItemsText; //multi_item
	$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['upsale_ids'] = $dojocart_upsale_ids;
	$insertOrder['upsells'] = !empty($upsellsArr) ? serialize($upsellsArr) : '';
		$insertOrder['custom_fields'] = $dojocart_custom_fields_serialize;
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
		
	//echo '<pre>insertOrder'; print_r($insertOrder);
	$this->query_model->insertData('tbl_dojocart_orders', $insertOrder);
//die('pass');
	$order_id = $this->db->insert_id();
	
	if(!empty($order_id)){
		
		$this->query_model->updateOrderForKabanLeads($order_id,'tbl_dojocart_orders','Dojo Cart Purchase',$_POST);
	}
	
	//echo '<pre>'; print_r($order_id); die;
	
	// multi_item save order items 
	if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
		$this->query_model->save_dojocart_order_items($_POST['dojocartItem'], $order_id,$product_id);
	}
	
	// upsell qty save order upsells 
	if(!empty($upsellsOrderArr)){
		$this->query_model->save_dojocart_order_upsells($upsellsOrderArr, $order_id,$product_id);
	}
	
		/*		
		* checkFormModuleApplyAPI 						
		* this function for using apis according form model 						
		*/
		
		
		$this->query_model->checkFormModuleApplyAPI($_POST);
		
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		$extraContentArr  = array('dojocart_title' => $product_title, 'dojocart_quantity' => $quantity, 'dojocart_amount'=> $site_currency_type.$amount, 'upsell_list'=>$upsellTitleArr, 'paymentResult' => $paymentResult,'dojocart_coupon_name'=>$coupon_code,'dojocart_coupon_discount'=>$coupon_discount,'dojocart_custom_fields'=>$dojocart_custom_fields,'dojocart_item_list'=>$dojocartItemsText); //multi_item
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'dojocart',$extraContentArr);
		
		
		
	if ($payment_status_code == 1) 
	{
			if($balance_transaction)
				{
					$results['result'] = 1;
					$txnId = $balance_transaction;
					
			
			
					$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $txnId;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					
					$insertTransaction['payment_type'] = "dojocart";
			
					$this->query_model->insertData('tbl_transaction', $insertTransaction);
			
					
			
					/*$orderUpdate = array('trans_status' => 'Success');
			
					$this->query_model->update('tbl_dojocart_orders', $order_id, $orderUpdate);*/
			
					
					
					
					/** EMAIL SEND**/
							
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
						
									$location_name = $location_info[0]->name;
						
									$location_email = $location_info[0]->email;
						
								}else{
						
									$location_name = '';
						
								}
								
								//echo $location_name; die;
								
								$name = $_POST['name'];
								$last_name = $_POST['last_name'];
								$email = $_POST['email'];
								$phone = str_replace(' ', '-', $_POST['phone']);
								$message = 'Payment Success';
								$program = isset($_POST['program_id'])? $_POST['program_id']:0;
			
									if($program != 0){
							
										$program_info = $this->query_model->getbyId("tblprogram", $program);
							
										$program = $program_info[0]->program;	
							
									}else{
							
										$program = '';
							
									}
								
								$site_setting = $this->query_model->getbyTable('tblsite');
									
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
										
										$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
						
										$location_data = $qry->row_array();
										
										$loc_email = $location_data['email'];
								
								} else{
										$main_location_id = $this->query_model->getMainLocation();
										$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
						
										$location_data = $qry->row_array();
								}
								
								
								$this->load->library("email");
			
								$query = $this->query_model->getbyTable('tblsite');
			
								foreach($query as $row):
			
									$site_email = trim($row->email);
			
									$school_name = $row->title;
			
								endforeach;
								
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$site_email = $loc_email;
			
								}
								
						
						/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
						$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

						
						if(isset($emailAutoResponder['admin_email'])){	
							$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiple_loc[0]->field_value == 1){
								$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
								//$text_address = $loc_detail[0]->text_address;
								$text_address = 0;
							}else{
								$loc_detail = $this->query_model->getMainLocation("tblcontact");
								$text_address = $loc_detail[0]->text_address;
							}
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
							$type = '';
							$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


							if(!empty($text_address) && !empty($mes)){
								
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
								
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
			
								$this->email->to($text_address);
			
								$this->email->subject($type);
			
									//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
									//$mes .= "<br/>";	
									//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
									
			
								$this->email->message($mes);
			
								$this->email->send();
							}
								
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
							
							
							// Mail to admin (Payment Success)
							
								
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
								
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
			
			$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
								$this->email->to($site_email);
			
								$this->email->subject($type);
	
						$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
						$mes .= "<br/>";	
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';			
					
	
								$this->email->message($mes);
			
								
			
								$this->email->send();
						}
								
			
								// send email to websitedojo.com
			
								/*$this->email->initialize($config);
			
								$this->email->from($email);
			
								$this->email->to('leads@websitedojo.com');
			
								$this->email->subject($type.' - '.$school_name);
			
								$this->email->message($mes);					
			
								$this->email->send(); */
			
								
			
								
			
						// Email to user (Payment Success)
						if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
						$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
						$cont = "Thank you, your order was accepted! A representative from our school will contact you shortly with more information.";
						$config['charset'] = 'UTF-8';	
						$config['wordwrap'] = TRUE;		
						$config['mailtype']="html";	

						$this->email->initialize($config);
						$from_email=trim($this->config->item('email_from'));
						/*if(!empty($from_email)){		
						$this->email->from($from_email,$school_name);
						}else{		
						$this->email->from($site_email,$school_name);
						}	 */																		
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
					/***********/
			
					$results['error_message'] = "<p class='payment_result'>Thank you, your order was accepted! A representative from our school will contact you shortly with more information.</p>";
					
					$this->query_model->getThankYouPageMessage($_POST);
						
						$dojocart_thankyou_url = $this->query_model->getDojocartThankyouUrl($productDetail[0]->slug);
				
						redirect(@base_url().$dojocart_thankyou_url);
						//redirect(@base_url().'site/thankyou'); 
						
					}
							
							
						
	}else{	

		//success 
		$results['result'] = 0;
		$results['error_msg'] = $payment_error;
		
		$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		

			
			/****************************************************************************************************************************/
			
			
			
		
				
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
			
						$location_name = $location_info[0]->name;
			
						$location_email = $location_info[0]->email;
			
					}else{
			
						$location_name = '';
			
					}
					
					$name = $_POST['name'];
					$last_name = $_POST['last_name'];
					$email = $_POST['email'];
					$phone = str_replace(' ', '-', $_POST['phone']);
					$message = $this->query_model->getStaticTextTranslation('payment_failure');

					
					$site_setting = $this->query_model->getbyTable('tblsite');
						
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
							
							$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
							
							$loc_email = $location_data['email'];
					
					} else{
							$main_location_id = $this->query_model->getMainLocation();
							$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
					}
					
					
					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

						$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;
					
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$site_email = $loc_email;

					}
					
					
					//echo $site_email; die;
					
				/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
				$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

				if(isset($emailAutoResponder['admin_email'])){
					
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
				$type = '';
				$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($mes)){
				//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				
					$config['charset'] = 'UTF-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					
					$this->email->to($text_address);
					$this->email->subject($type);

						//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
						//$mes .= "<br/>";		
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
						

					$this->email->message($mes);
					$this->email->send();
			}					
		/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
				
				// Mail to Admin (Payment Failure)

					$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'UTF-8';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}

					$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
					
					$this->email->to($site_email);

					$this->email->subject($type);

										
					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
					$mes .= "<br/>";			
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					
					$this->email->message($mes);

					

					$this->email->send();
				
				}
					

					// send email to websitedojo.com

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

			// Email to user (Payment Failure)
			if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){									
					$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';					
					$cont = $message; 					
					$config['charset'] = 'UTF-8';					
					$config['wordwrap'] = TRUE;					
					$config['mailtype']="html";					
					$this->email->initialize($config);					
					$from_email=trim($this->config->item('email_from'));										
					/*if(!empty($from_email)){						
						$this->email->from($from_email,$school_name);					
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
				
				$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
			/************************************************************************************************************************/

			}
		
	//echo "<pre>results"; print_r($results); die;
		//$this->load->view('dojo_payment_result', $results);
		//$this->load->view("dojocart-trial-sent", $results);
		if(isset($results['result']) && $results['result'] == 0){
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 12);
			
			$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
			
			$this->load->view("upsell_thankyou_page", $results);
		}
		
		}

	}


	public function stripe_ideal_payment_gateway(){
		
		$_POST['submit'] = 'Purchase Now';
		//echo '<pre>$_POST'; print_r($_POST); die;
		if(isset($_POST['submit'])){
			
			if(!isset($_POST['account_holder_name']) || !isset($_POST['bank_name'])){
				redirect('/site/page_not_found');
			}
			
			date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
			
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
			// kz multi_item
			$is_multi_item_dojocart = (isset($_POST['is_multi_item_dojocart']) && $_POST['is_multi_item_dojocart'] == 1) ? $_POST['is_multi_item_dojocart'] : 0;
			if($is_multi_item_dojocart == 1){
				$_POST['name'] = isset($_POST['contact_name'][1]) ? $_POST['contact_name'][1] : '';
				$_POST['last_name'] = isset($_POST['contact_last_name'][1]) ? $_POST['contact_last_name'][1] : '';
			}
			
			$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
			$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
			$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
			$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
			$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
			$amount = $_POST['amount'];
			
			$stripePaymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
		
			$stripe_payment = $stripePaymentDetail[0]->stripe_ideal_payment;
			
			
			$stripe_secret_key = $stripePaymentDetail[0]->stripe_ideal_secret_key;
			$stripe_publishable_key = $stripePaymentDetail[0]->stripe_ideal_publishable_key;
			
				
			/****************Stripe payment*******************/
			
				$params = array(
						"private_test_key" => $stripe_secret_key,
						"public_test_key"  => $stripe_publishable_key
					);	
				
				include('./vendor/stripe-latest/init.php');
				
				\Stripe\Stripe::setApiKey($params['private_test_key']);

				$owner_name = isset($_POST['account_holder_name']) ? $_POST['account_holder_name'] : '';
				$owner_email = isset($_POST['email']) ? $_POST['email'] : '';
				$owner_phone = isset($_POST['phone']) ? $_POST['phone'] : '';
				$owner_bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : '';
				$_POST['amount'] = number_format($_POST['amount'],2);
				$amount_cents = str_replace(".","",$_POST['amount']);  // Chargeble amount
					
				$createSource = \Stripe\Source::create([
				  "type" => "ideal",
				  "amount" => $amount_cents,
				  "currency" => $currency_type,
				  "ideal" => [
					'bank' => $owner_bank_name
					],
				"redirect" => [
					'return_url' => base_url().'dojocartpayment/mwalteSpIdlPymSvdj'
					//'return_url' => base_url().'dojocartpayment/stripe_ideal_payment_webhook'
					],
				  "owner" => [
					"name" => $owner_name,
					"email" => $owner_email,
					"phone" => $owner_phone,
					"verified_name" => $owner_name,
					"verified_email" => $owner_email,
					"verified_phone" => $owner_phone,
				  ]
				]);
			
			
			//echo '<pre>createSource'; print_r($createSource); die;
			if(!empty($createSource)){
				$stripeIdealDojocartFormData = array('stripeIdealDojocartFormData' => $_POST);
				$this->session->set_userdata($stripeIdealDojocartFormData);
				
				if(isset($createSource->redirect->url) && !empty($createSource->redirect->url)){
					redirect($createSource->redirect->url);
				}
			}
		}
	}

	public function mwalteSpIdlPymSvdj(){
		$source_id = (isset($_GET['source']) && !empty($_GET['source'])) ? $_GET['source'] : '';
		
		date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
		
		$_POST = $this->session->userdata('stripeIdealDojocartFormData');
		//echo '<pre>_POST'; print_R($_POST); die;
		$this->session->unset_userdata('stripeIdealDojocartFormData');
		if(isset($_POST['submit'])){
			
			if(!isset($_POST['account_holder_name']) || !isset($_POST['bank_name'])){
				redirect('/site/page_not_found');
			}
			
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
			
			if(!empty($source_id)){
				
			// kz multi_item
			$is_multi_item_dojocart = (isset($_POST['is_multi_item_dojocart']) && $_POST['is_multi_item_dojocart'] == 1) ? $_POST['is_multi_item_dojocart'] : 0;
			if($is_multi_item_dojocart == 1){
				$_POST['name'] = isset($_POST['contact_name'][1]) ? $_POST['contact_name'][1] : '';
				$_POST['last_name'] = isset($_POST['contact_last_name'][1]) ? $_POST['contact_last_name'][1] : '';
			}
			
			$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
			$amount = $_POST['amount'];
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			$stripePaymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
		
			$stripe_secret_key = $stripePaymentDetail[0]->stripe_ideal_secret_key;
			$stripe_publishable_key = $stripePaymentDetail[0]->stripe_ideal_publishable_key;
			
			$params = array(
					"private_test_key" => $stripe_secret_key,
					"public_test_key"  => $stripe_publishable_key
				);	

			include('./vendor/stripe-latest/init.php');

			\Stripe\Stripe::setApiKey($params['private_test_key']);
			$sourceData = \Stripe\Source::retrieve($source_id);
			
			$paymentResult = '';
			$payment_status_code = 0;
			$payment_status_type = 'failed';
			$payment_error = '';
			$clientId = '';
			$clientToken = '';
			
			if(!empty($sourceData)){
				if(isset($sourceData->status) && $sourceData->status == "chargeable"){
					try {
					$payment_result = \Stripe\Charge::create([
					  "amount" => $sourceData->amount,
					  "currency" => $currency_type,
					  "source" => $source_id,
					]);
				} catch(Stripe_CardError $e) {			

						$payment_error = $e->getMessage();
					
				} 
		      }
			  
			  	/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
			  $upsellTitleArr = '';
			$upsellTitleOrderArr = '';
			$dojocartUpsalesIdsArr = array();
			/*if( isset($_POST['upsale_id']) && !empty($_POST['upsale_id']) ){
				$upsale_ids = $_POST['upsale_id'];
				if ( empty($upsale_ids[0]) ) {
					unset($upsale_ids[0]);
				}
				
			$i = 1;
			foreach ($upsale_ids as $id ) {
				if ( !empty($id) ){
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
					}
				}

			$i++;	
			}
			
		}*/
		
		
		
		$upsellsArr = array();
		$upsellsOrderArr = array();
		if( isset($_POST['upsell']) && !empty($_POST['upsell']) ){
			foreach($_POST['upsell'] as $key => $upsell){
			 if (isset($upsell['id']) && !empty($upsell['id']) && isset($upsell['is_active']) && $upsell['is_active'] == 1){
				
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $upsell['id']);
				$qty = (isset($upsell['qty']) && !empty($upsell['qty'])) ? $upsell['qty'] : 0;
				if($qty > 1 && !empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 0){
					$qty = 1;
				}
				
				
				$amount = (isset($upsell['amount']) && !empty($upsell['amount'])) ? $upsell['amount'] : 0;
				$total_amount = $amount * $qty;
				$dojocart_upsale_title = !empty($upsellDetail) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 1){
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'(qty='.$qty.'&amount='.$site_currency_type.$amount.'&total='.$site_currency_type.$total_amount.')' : '';
					
				}else{
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'('.$site_currency_type.$total_amount.')' : '';
				}
				
				//$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleArr .= 'Upsell: '.$dojocart_upsale_title.'<br/>';
				$upsellTitleArr .= 'Amount: '.$site_currency_type.$amount.'<br/>';
				$upsellTitleArr .= 'Qty: '.$qty.'<br/>';
				$upsellTitleArr .= 'Total: '.$site_currency_type.$total_amount.'<br/><br/>';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
						
						$upsellsArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']]['qty'] = $qty;
						$upsellsOrderArr[$upsell['id']]['title'] = $upsellDetail[0]->up_title;
					}
				}
			}
		}
	
	$amount = $_POST['amount'];
		
		// kz multi_item
		$dojocartItemsText = '';
		if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
			$dojocartItemsText .= '<br>';
			foreach($_POST['dojocartItem'] as $contact_number => $dojocart_item){
				if(!empty($dojocart_item)){
					foreach($dojocart_item as $item_id => $item){
						$dojocartItemsText .= $item['item_full_text'].' <br>'; 
					}	
				}
			}
		}
		
		
		$dojocart_custom_fields = (isset($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : '';
		$dojocart_custom_fields_serialize = !empty($dojocart_custom_fields) ? serialize($dojocart_custom_fields) : '';
		
		
		$dojocart_upsale_ids = !empty($dojocartUpsalesIdsArr) ? serialize($dojocartUpsalesIdsArr) : '';

		$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $product_id);
		$product_title =  isset($productDetail[0]->product_title) ? $productDetail[0]->product_title : '';
		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		
		$mailchimp_type = 0;
		$mailchimp_template_id = '';
		$mailchimp_api_key = '';
		if(!empty($check_mailchimp)){
			$mailchimp_type = $check_mailchimp[0]->type;
			$mailchimp_template_id = $check_mailchimp[0]->template_id;
			$mailchimp_api_key =  $check_mailchimp[0]->api_key;
		}
		
		if(isset($_POST['program_id'])){

			$program_detail = $this->query_model->getbySpecific('tblprogram','id',$_POST['program_id']);

		}

		

		if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

			$location_detail = $this->query_model->getbySpecific('tblcontact','id',$_POST['location_id']);

			$location_id = $location_detail[0]->id;
			
			$noreply_email_address = $location_detail[0]->email;

		}else{

			$main_location_detail = $this->query_model->getMainLocation();

			$location_id = $main_location_detail[0]->id;

			$site_setting = $this->query_model->getbyTable('tblsite');	
			$noreply_email_address = $site_setting[0]->email;

		}	


		$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
		
		
		//echo '<pre>payment_result'; print_r($payment_result); die;
		
		if(!empty($payment_result)){
			if(isset($payment_result->balance_transaction) && $payment_result->balance_transaction != ''){
				
				$payment_result->status = strtolower($payment_result->status);
				
				$paymentStatusArr = array('succeeded','pending','paid','success','successful');
				if(in_array($payment_result->status,$paymentStatusArr)){
					$p_result = ucfirst($payment_result->status);
					
					$payment_status_code = 1;
					$payment_status_type = $p_result;
					$paymentResult = $this->query_model->getStaticTextTranslation('payment').' '.$p_result.' : ';
				}
			}
			
		}else{
			$paymentResult = $this->query_model->getStaticTextTranslation('payment_failure').': '.$payment_error;
		}
	
		

	/** Insert Data in tbl_dojocart_orders table **/

	$insertOrder = array();

	$insertOrder['name'] = $_POST['name'];

	$insertOrder['last_name'] = $_POST['last_name'];

	$insertOrder['address'] = $_POST['address'];


	$insertOrder['address_line2'] =  isset($_POST['address_line2'])? $_POST['address_line2'] : '';

	$insertOrder['city'] = $_POST['city'];

	$insertOrder['state'] = $_POST['state'];

	$insertOrder['zip'] = $_POST['zip'];

	$insertOrder['phone'] = $_POST['phone'];

	

	$insertOrder['amount'] = $_POST['amount'];

	$insertOrder['email'] = $_POST['email'];

	//$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

	//$insertOrder['trial_id'] = $_POST['trial_id'];

	$insertOrder['trans_status'] = $payment_status_type;

	$insertOrder['offer_type'] = 'Paid';

	$insertOrder['created'] = date('Y-m-d H:i:s');

	$insertOrder['quantity'] = isset($_POST['quantity'])? $_POST['quantity'] : 0;
	$insertOrder['product_id'] = isset($_POST['product_id'])? $_POST['product_id'] : 0;

	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;

	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	$insertOrder['is_multi_item_dojocart'] = $is_multi_item_dojocart; //multi_item
	$insertOrder['items_list'] = $dojocartItemsText; //multi_item
	$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['upsale_ids'] = $dojocart_upsale_ids;
		$insertOrder['custom_fields'] = $dojocart_custom_fields_serialize;
		$insertOrder['source_id'] = $source_id;
		$insertOrder['upsells'] = !empty($upsellsArr) ? serialize($upsellsArr) : '';
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
		
	$this->query_model->insertData('tbl_dojocart_orders', $insertOrder);

	$order_id = $this->db->insert_id();
	
	if(!empty($order_id)){
		
		$this->query_model->updateOrderForKabanLeads($order_id,'tbl_dojocart_orders','Dojo Cart Purchase',$_POST);
	}
	
	//echo '<pre>'; print_r($order_id); die;
	
	// multi_item save order items 
	if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
		$this->query_model->save_dojocart_order_items($_POST['dojocartItem'], $order_id,$product_id);
	}
	
	
	// upsell qty save order upsells 
	if(!empty($upsellsOrderArr)){
		$this->query_model->save_dojocart_order_upsells($upsellsOrderArr, $order_id,$product_id);
	}
	
	
		/*		
		* checkFormModuleApplyAPI 						
		* this function for using apis according form model 						
		*/
		
		
		$this->query_model->checkFormModuleApplyAPI($_POST);
		
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		$extraContentArr  = array('dojocart_title' => $product_title, 'dojocart_quantity' => $quantity, 'dojocart_amount'=> $site_currency_type.$amount, 'upsell_list'=>$upsellTitleArr, 'paymentResult' => $paymentResult,'dojocart_coupon_name'=>$coupon_code,'dojocart_coupon_discount'=>$coupon_discount,'dojocart_custom_fields'=>$dojocart_custom_fields,'dojocart_item_list'=>$dojocartItemsText);
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'dojocart',$extraContentArr);
		
		
			
		
	if ($payment_status_code == 1) 
	{
			if($payment_result->balance_transaction)
				{
					$results['result'] = 1;
					$txnId = $payment_result->balance_transaction;
					
			
			
					$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $txnId;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					
					$insertTransaction['payment_type'] = "dojocart";
			
					$this->query_model->insertData('tbl_transaction', $insertTransaction);
			
					
			
					/*$orderUpdate = array('trans_status' => 'Success');
			
					$this->query_model->update('tbl_dojocart_orders', $order_id, $orderUpdate);*/
			
					
					
					
					/** EMAIL SEND**/
							
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
						
									$location_name = $location_info[0]->name;
						
									$location_email = $location_info[0]->email;
						
								}else{
						
									$location_name = '';
						
								}
								
								//echo $location_name; die;
								
								$name = $_POST['name'];
								$last_name = $_POST['last_name'];
								$email = $_POST['email'];
								$phone = str_replace(' ', '-', $_POST['phone']);
								$message = 'Payment Success';
								$program = isset($_POST['program_id'])? $_POST['program_id']:0;
			
									if($program != 0){
							
										$program_info = $this->query_model->getbyId("tblprogram", $program);
							
										$program = $program_info[0]->program;	
							
									}else{
							
										$program = '';
							
									}
								
								$site_setting = $this->query_model->getbyTable('tblsite');
									
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
										
										$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
						
										$location_data = $qry->row_array();
										
										$loc_email = $location_data['email'];
								
								} else{
										$main_location_id = $this->query_model->getMainLocation();
										$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
						
										$location_data = $qry->row_array();
								}
								
								
								$this->load->library("email");
			
								$query = $this->query_model->getbyTable('tblsite');
			
								foreach($query as $row):
			
									$site_email = trim($row->email);
			
									$school_name = $row->title;
			
								endforeach;
								
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$site_email = $loc_email;
			
								}
								
						
						/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
						$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

						
						if(isset($emailAutoResponder['admin_email'])){	
							$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiple_loc[0]->field_value == 1){
								$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
								//$text_address = $loc_detail[0]->text_address;
								$text_address = 0;
							}else{
								$loc_detail = $this->query_model->getMainLocation("tblcontact");
								$text_address = $loc_detail[0]->text_address;
							}
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
				$type = '';
				$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($mes)){
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
								
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
			
								$this->email->to($text_address);
			
								$this->email->subject($type);
			
									//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
									//$mes .= "<br/>";	
									//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
									
			
								$this->email->message($mes);
			
								$this->email->send();
							}
								
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
							
							
							// Mail to admin (Payment Success)
							
								
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
								
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
			$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
								$this->email->to($site_email);
			
								$this->email->subject($type);
	
						$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
						$mes .= "<br/>";	
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';			
					
	
								$this->email->message($mes);
			
								
			
								$this->email->send();
						}
								
			
								// send email to websitedojo.com
			
								/*$this->email->initialize($config);
			
								$this->email->from($email);
			
								$this->email->to('leads@websitedojo.com');
			
								$this->email->subject($type.' - '.$school_name);
			
								$this->email->message($mes);					
			
								$this->email->send(); */
			
								
			
								
			
						// Email to user (Payment Success)
						if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
						$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
						$cont = "Thank you, your order was accepted! A representative from our school will contact you shortly with more information.";
						$config['charset'] = 'UTF-8';	
						$config['wordwrap'] = TRUE;		
						$config['mailtype']="html";	

						$this->email->initialize($config);
						$from_email=trim($this->config->item('email_from'));
						/*if(!empty($from_email)){		
						$this->email->from($from_email,$school_name);
						}else{		
						$this->email->from($site_email,$school_name);
						}	 */																		
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
					/***********/
			
					$results['error_message'] = "<p class='payment_result'>Thank you, your order was accepted! A representative from our school will contact you shortly with more information.</p>";
					//echo '<pre>results'; print_r($results); die;
					$this->query_model->getThankYouPageMessage($_POST);
					
					$dojocart_thankyou_url = $this->query_model->getDojocartThankyouUrl($productDetail[0]->slug);
				
				redirect(@base_url().$dojocart_thankyou_url);
						//redirect(@base_url().'site/thankyou'); 
						
					}
							
							
						
	}else{	

		//success 
		$results['result'] = 0;
		$results['error_msg'] = $payment_error;
		
		$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		

			
			/****************************************************************************************************************************/
			
			
			
		
				
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
			
						$location_name = $location_info[0]->name;
			
						$location_email = $location_info[0]->email;
			
					}else{
			
						$location_name = '';
			
					}
					
					$name = $_POST['name'];
					$last_name = $_POST['last_name'];
					$email = $_POST['email'];
					$phone = str_replace(' ', '-', $_POST['phone']);
					$message = $this->query_model->getStaticTextTranslation('payment_failure');

					
					$site_setting = $this->query_model->getbyTable('tblsite');
						
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
							
							$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
							
							$loc_email = $location_data['email'];
					
					} else{
							$main_location_id = $this->query_model->getMainLocation();
							$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
					}
					
					
					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

						$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;
					
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$site_email = $loc_email;

					}
					
					
					//echo $site_email; die;
					
				/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
				$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

				
				if(isset($emailAutoResponder['admin_email'])){
					
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
				$type = '';
				$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($mes)){
				//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				
					$config['charset'] = 'UTF-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					
					$this->email->to($text_address);
					$this->email->subject($type);

					//	$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
					//	$mes .= "<br/>";		
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
						

					$this->email->message($mes);
					$this->email->send();
			}					
		/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
				
				// Mail to Admin (Payment Failure)

					$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'UTF-8';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}

					$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
					$this->email->to($site_email);

					$this->email->subject($type);

										
					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
					$mes .= "<br/>";			
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					
					$this->email->message($mes);

					

					$this->email->send();
				
				}
					

					// send email to websitedojo.com

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

			// Email to user (Payment Failure)
			if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){									
					$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';					
					$cont = $message; 					
					$config['charset'] = 'UTF-8';					
					$config['wordwrap'] = TRUE;					
					$config['mailtype']="html";					
					$this->email->initialize($config);					
					$from_email=trim($this->config->item('email_from'));										
					/*if(!empty($from_email)){						
						$this->email->from($from_email,$school_name);					
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
				
				$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
			/************************************************************************************************************************/

			}
			
			if(isset($results['result']) && $results['result'] == 0){
				$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 12);
				
				$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
				
				$this->load->view("upsell_thankyou_page", $results);
			}
			  
			  
			
				}
			}
		}
	}

	
	public function stripe_ideal_payment_webhook(){
		
		date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
		
		$source_id = (isset($_GET['source']) && !empty($_GET['source'])) ? $_GET['source'] : '';

		if(!empty($source_id)){
			$orderDetail = $this->query_model->getBySpecific('tbl_dojocart_orders', 'source_id',$source_id);
			
			if(!empty($orderDetail)){
				$orderDetail = $orderDetail[0];
				$payment_status = strtolower($orderDetail->trans_status);
				//$payment_status = 'pending';
				$paymentStatusArr = array('succeeded','paid','success','successful');
				
				if(in_array($payment_status,$paymentStatusArr)){
					// just checking
				}else{
					$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $orderDetail->product_id);
					
					$_POST = array();
					$_POST['page_url'] = '/promo/'.$productDetail[0]->slug;
					$_POST['name'] = $orderDetail->name;
					$_POST['last_name'] = $orderDetail->last_name;
					$_POST['product_id'] = $orderDetail->product_id;
					$_POST['email'] = $orderDetail->email;
					
					$_POST['phone'] = $orderDetail->phone;
					$_POST['location_id'] = $orderDetail->location;
					
					$_POST['quantity'] = $orderDetail->quantity;
					$_POST['hide_quantity'] = $orderDetail->quantity;
					$_POST['yes'] = $orderDetail->term_condition;
					
					
					$_POST['amount'] = $orderDetail->amount;
					$_POST['total_tax_amount'] = $orderDetail->tax;
					$_POST['address'] = $orderDetail->address;
					$_POST['address_line2'] = $orderDetail->address_line2;
					$_POST['city'] = $orderDetail->city;
					$_POST['state'] = $orderDetail->state;
					$_POST['zip'] = $orderDetail->zip;
					$_POST['coupon_code'] = $orderDetail->coupon_code;
					$_POST['coupon_discount'] = $orderDetail->coupon_discount;
					$_POST['upsale_id'] = !empty($orderDetail->upsale_ids) ? unserialize($orderDetail->upsale_ids) : '';
					$_POST['upsell'] = !empty($orderDetail->upsells) ? unserialize($orderDetail->upsells) : '';
					$_POST['custom_field'] = !empty($orderDetail->custom_fields) ? unserialize($orderDetail->custom_fields) : '';
					$order_id = $orderDetail->id;
					

					$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
			$amount = $_POST['amount'];
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			$stripePaymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
		
			$stripe_secret_key = $stripePaymentDetail[0]->stripe_ideal_secret_key;
			$stripe_publishable_key = $stripePaymentDetail[0]->stripe_ideal_publishable_key;
			
			$params = array(
					"private_test_key" => $stripe_secret_key,
					"public_test_key"  => $stripe_publishable_key
				);	

			include('./vendor/stripe-latest/init.php');

			\Stripe\Stripe::setApiKey($params['private_test_key']);
			$sourceData = \Stripe\Source::retrieve($source_id);
			//echo '<pre>sourceData'; print_R($sourceData); die;
			$paymentResult = '';
			$payment_status_code = 0;
			$payment_status_type = 'failed';
			$payment_error = '';
			$clientId = '';
			$clientToken = '';
			
			if(!empty($sourceData)){
				if(isset($sourceData->status) && $sourceData->status == "chargeable"){
					try {
					$payment_result = \Stripe\Charge::create([
					  "amount" => $sourceData->amount,
					  "currency" => $currency_type,
					  "source" => $source_id,
					]);
				} catch(Stripe_CardError $e) {			

						$payment_error = $e->getMessage();
					
				} 
		      }
			  
			  	/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
			  $upsellTitleArr = '';
			$upsellTitleOrderArr = '';
			$dojocartUpsalesIdsArr = array();
			/*if( isset($_POST['upsale_id']) && !empty($_POST['upsale_id']) ){
				$upsale_ids = $_POST['upsale_id'];
				if ( empty($upsale_ids[0]) ) {
					unset($upsale_ids[0]);
				}
				
			$i = 1;
			foreach ($upsale_ids as $id ) {
				if ( !empty($id) ){
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
					}
				}

			$i++;	
			}
			
		}*/
		
		
		$upsellsArr = array();
		$upsellsOrderArr = array();
		if( isset($_POST['upsell']) && !empty($_POST['upsell']) ){
			$i = 1; 
			foreach($_POST['upsell'] as $key => $upsell){
			 if (isset($upsell['id']) && !empty($upsell['id']) && isset($upsell['is_active']) && $upsell['is_active'] == 1){
				
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $upsell['id']);
				$qty = (isset($upsell['qty']) && !empty($upsell['qty'])) ? $upsell['qty'] : 0;
				if($qty > 1 && !empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 0){
					$qty = 1;
				}
				
				
				$amount = (isset($upsell['amount']) && !empty($upsell['amount'])) ? $upsell['amount'] : 0;
				$total_amount = $amount * $qty;
				$dojocart_upsale_title = !empty($upsellDetail) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 1){
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'(qty='.$qty.'&amount='.$site_currency_type.$amount.'&total='.$site_currency_type.$total_amount.')' : '';
					
				}else{
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'('.$site_currency_type.$total_amount.')' : '';
				}
				
				//$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleArr .= 'Upsell #'.$i.': '.$dojocart_upsale_title.'<br/>';
				$upsellTitleArr .= 'Amount: '.$site_currency_type.$amount.'<br/>';
				$upsellTitleArr .= 'Qty: '.$qty.'<br/>';
				$upsellTitleArr .= 'Total: '.$site_currency_type.$total_amount.'<br/><br/>';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
						
						$upsellsArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']]['qty'] = $qty;
						$upsellsOrderArr[$upsell['id']]['title'] = $upsellDetail[0]->up_title;
					}
					
					$i++;
				}
			}
		}
	
	
	$amount = $_POST['amount'];
		
		
		$dojocart_custom_fields = (isset($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : '';
		$dojocart_custom_fields_serialize = !empty($dojocart_custom_fields) ? serialize($dojocart_custom_fields) : '';
		
		
		$dojocart_upsale_ids = !empty($dojocartUpsalesIdsArr) ? serialize($dojocartUpsalesIdsArr) : '';

		$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $product_id);
		$product_title =  isset($productDetail[0]->product_title) ? $productDetail[0]->product_title : '';
		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		
		$mailchimp_type = 0;
		$mailchimp_template_id = '';
		$mailchimp_api_key = '';
		if(!empty($check_mailchimp)){
			$mailchimp_type = $check_mailchimp[0]->type;
			$mailchimp_template_id = $check_mailchimp[0]->template_id;
			$mailchimp_api_key =  $check_mailchimp[0]->api_key;
		}
		
		if(isset($_POST['program_id'])){

			$program_detail = $this->query_model->getbySpecific('tblprogram','id',$_POST['program_id']);

		}

		

		if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

			$location_detail = $this->query_model->getbySpecific('tblcontact','id',$_POST['location_id']);

			$location_id = $location_detail[0]->id;
			
			$noreply_email_address = $location_detail[0]->email;

		}else{

			$main_location_detail = $this->query_model->getMainLocation();

			$location_id = $main_location_detail[0]->id;

			$site_setting = $this->query_model->getbyTable('tblsite');	
			$noreply_email_address = $site_setting[0]->email;

		}	


		$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
		
		
		//echo '<pre>payment_result'; print_r($payment_result); die;
		
		if(!empty($payment_result)){
			if(isset($payment_result->balance_transaction) && $payment_result->balance_transaction != ''){
				
				$payment_result->status = strtolower($payment_result->status);
				
				$paymentStatusArr = array('succeeded','paid','success','successful');
				if(in_array($payment_result->status,$paymentStatusArr)){
					$p_result = ucfirst($payment_result->status);
					
					$payment_status_code = 1;
					$payment_status_type = $p_result;
					$paymentResult = $this->query_model->getStaticTextTranslation('payment').' '.$p_result.' : ';
				}
			}
			
		}else{
			$paymentResult = $this->query_model->getStaticTextTranslation('payment_failure').': '.$payment_error;
		}
	
	
	/*		
		* checkFormModuleApplyAPI 						
		* this function for using apis according form model 						
		*/
		
		
		$this->query_model->checkFormModuleApplyAPI($_POST);
		
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		$extraContentArr  = array('dojocart_title' => $product_title, 'dojocart_quantity' => $quantity, 'dojocart_amount'=> $site_currency_type.$amount, 'upsell_list'=>$upsellTitleArr, 'paymentResult' => $paymentResult,'dojocart_coupon_name'=>$coupon_code,'dojocart_coupon_discount'=>$coupon_discount,'dojocart_custom_fields'=>$dojocart_custom_fields);
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'dojocart',$extraContentArr);
		
		
				
			
		
	if ($payment_status_code == 1) 
	{
			if($payment_result->balance_transaction)
				{
					$results['result'] = 1;
					$txnId = $payment_result->balance_transaction;
					
			
			
					/*$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $txnId;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					
					$insertTransaction['payment_type'] = "dojocart";
			
					$this->query_model->insertData('tbl_transaction', $insertTransaction);*/
			
					
			
					$orderUpdate = array('trans_status' => $payment_status_type);
			
					$this->query_model->update('tbl_dojocart_orders', $order_id, $orderUpdate);
			
					
					
					
					/** EMAIL SEND**/
							
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
						
									$location_name = $location_info[0]->name;
						
									$location_email = $location_info[0]->email;
						
								}else{
						
									$location_name = '';
						
								}
								
								//echo $location_name; die;
								
								$name = $_POST['name'];
								$last_name = $_POST['last_name'];
								$email = $_POST['email'];
								$phone = str_replace(' ', '-', $_POST['phone']);
								$message = 'Payment Success';
								$program = isset($_POST['program_id'])? $_POST['program_id']:0;
			
									if($program != 0){
							
										$program_info = $this->query_model->getbyId("tblprogram", $program);
							
										$program = $program_info[0]->program;	
							
									}else{
							
										$program = '';
							
									}
								
								$site_setting = $this->query_model->getbyTable('tblsite');
									
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
										
										$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
						
										$location_data = $qry->row_array();
										
										$loc_email = $location_data['email'];
								
								} else{
										$main_location_id = $this->query_model->getMainLocation();
										$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
						
										$location_data = $qry->row_array();
								}
								
								
								$this->load->library("email");
			
								$query = $this->query_model->getbyTable('tblsite');
			
								foreach($query as $row):
			
									$site_email = trim($row->email);
			
									$school_name = $row->title;
			
								endforeach;
								
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$site_email = $loc_email;
			
								}
								
						
						/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
						$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

						
						if(isset($emailAutoResponder['admin_email'])){	
							$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiple_loc[0]->field_value == 1){
								$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
								//$text_address = $loc_detail[0]->text_address;
								$text_address = 0;
							}else{
								$loc_detail = $this->query_model->getMainLocation("tblcontact");
								$text_address = $loc_detail[0]->text_address;
							}
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
				$type = '';
				$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($mes)){
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
								
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
			
								$this->email->to($text_address);
			
								$this->email->subject($type);
			
									//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
									//$mes .= "<br/>";	
									//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
									
			
								$this->email->message($mes);
			
								$this->email->send();
							}
								
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
							
							
							// Mail to admin (Payment Success)
							
								
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
								
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
			
			$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
								$this->email->to($site_email);
			
								$this->email->subject($type);
	
						$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
						$mes .= "<br/>";	
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';			
					
	
								$this->email->message($mes);
			
								
			
								$this->email->send();
						}
								
			
								// send email to websitedojo.com
			
								/*$this->email->initialize($config);
			
								$this->email->from($email);
			
								$this->email->to('leads@websitedojo.com');
			
								$this->email->subject($type.' - '.$school_name);
			
								$this->email->message($mes);					
			
								$this->email->send(); */
			
								
			
								
			
						// Email to user (Payment Success)
						if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
						$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
						$cont = "Thank you, your order was accepted! A representative from our school will contact you shortly with more information.";
						$config['charset'] = 'UTF-8';	
						$config['wordwrap'] = TRUE;		
						$config['mailtype']="html";	

						$this->email->initialize($config);
						$from_email=trim($this->config->item('email_from'));
						/*if(!empty($from_email)){		
						$this->email->from($from_email,$school_name);
						}else{		
						$this->email->from($site_email,$school_name);
						}	 */																		
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
					/***********/
			
					$results['error_message'] = "<p class='payment_result'>Thank you, your order was accepted! A representative from our school will contact you shortly with more information.</p>";
					//echo '<pre>results'; print_r($results); die;
					//$this->query_model->getThankYouPageMessage($_POST);
						//redirect(@base_url().'site/thankyou');
						
					}
							
							
						
	}else{	

		//success 
		$results['result'] = 0;
		$results['error_msg'] = $payment_error;
		
		$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		

			
			/****************************************************************************************************************************/
			
			
			
		
				
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
			
						$location_name = $location_info[0]->name;
			
						$location_email = $location_info[0]->email;
			
					}else{
			
						$location_name = '';
			
					}
					
					$name = $_POST['name'];
					$last_name = $_POST['last_name'];
					$email = $_POST['email'];
					$phone = str_replace(' ', '-', $_POST['phone']);
					$message = $this->query_model->getStaticTextTranslation('payment_failure');

					
					$site_setting = $this->query_model->getbyTable('tblsite');
						
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
							
							$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
							
							$loc_email = $location_data['email'];
					
					} else{
							$main_location_id = $this->query_model->getMainLocation();
							$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));
			
							$location_data = $qry->row_array();
					}
					
					
					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

						$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;
					
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$site_email = $loc_email;

					}
					
					
					//echo $site_email; die;
					
				/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
				$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

				if(isset($emailAutoResponder['admin_email'])){
					
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
				$type = '';
				$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($mes)){
				//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				
					$config['charset'] = 'UTF-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					
					$this->email->to($text_address);
					$this->email->subject($type);

						//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
						//$mes .= "<br/>";		
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
						

					$this->email->message($mes);
					$this->email->send();
			}					
		/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
				
				// Mail to Admin (Payment Failure)

					$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'UTF-8';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
	
					$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
					
					$this->email->to($site_email);

					$this->email->subject($type);

										
					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
					$mes .= "<br/>";			
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					
					$this->email->message($mes);

					

					$this->email->send();
				
				}
					

					// send email to websitedojo.com

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

			// Email to user (Payment Failure)
			if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){									
					$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';					
					$cont = $message; 					
					$config['charset'] = 'UTF-8';					
					$config['wordwrap'] = TRUE;					
					$config['mailtype']="html";					
					$this->email->initialize($config);					
					$from_email=trim($this->config->item('email_from'));										
					/*if(!empty($from_email)){						
						$this->email->from($from_email,$school_name);					
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
				
				$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
			/************************************************************************************************************************/

			}


					/*echo '<pre>results'; print_r($results); 
					echo '<pre>payment_result'; print_r($payment_result); 
					echo '<pre>_POST'; print_r($_POST); 
					echo '<pre>orderDetail'; print_r($orderDetail); die;*/


				}
				
				}
			}
			
		}
	}
	
	
	
	public function paypal_payment_gateway($product_id = null){
		
		
		$_POST['submit'] = 'Purchase Now';

		if(isset($_POST['submit'])){
			
			date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
			
			// kz multi_item
			$is_multi_item_dojocart = (isset($_POST['is_multi_item_dojocart']) && $_POST['is_multi_item_dojocart'] == 1) ? $_POST['is_multi_item_dojocart'] : 0;
			if($is_multi_item_dojocart == 1){
				$_POST['name'] = isset($_POST['contact_name'][1]) ? $_POST['contact_name'][1] : '';
				$_POST['last_name'] = isset($_POST['contact_last_name'][1]) ? $_POST['contact_last_name'][1] : '';
			}
			
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
		$site_currency_type = $this->query_model->getSiteCurrencyType();
			
		
		
			$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
			$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
			$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
			$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
			$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
			$amount = $_POST['amount'];
			$upsellTitleArr = '';
			$upsellTitleOrderArr = '';
			$dojocartUpsalesIdsArr = array();
			
			
		
		$upsellsArr = array();
		$upsellsOrderArr = array();
		if( isset($_POST['upsell']) && !empty($_POST['upsell']) ){
			$i = 1; 
			foreach($_POST['upsell'] as $key => $upsell){ 
			 if (isset($upsell['id']) && !empty($upsell['id']) && isset($upsell['is_active']) && $upsell['is_active'] == 1){
				
				$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $upsell['id']);
				
				$qty = (isset($upsell['qty']) && !empty($upsell['qty'])) ? $upsell['qty'] : 0;
				if($qty > 1 && !empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 0){
					$qty = 1;
				}
				
				
				$amount = (isset($upsell['amount']) && !empty($upsell['amount'])) ? $upsell['amount'] : 0;
				$total_amount = $amount * $qty;
				$dojocart_upsale_title = !empty($upsellDetail) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 1){
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'(qty='.$qty.'&amount='.$site_currency_type.$amount.'&total='.$site_currency_type.$total_amount.')' : '';
					
				}else{
					$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'('.$site_currency_type.$total_amount.')' : '';
				}
				
				//$upsellTitleArr .= $upsell_title.', ';
				$upsellTitleArr .= 'Upsell #'.$i.': '.$dojocart_upsale_title.'<br/>';
				$upsellTitleArr .= 'Amount: '.$site_currency_type.$amount.'<br/>';
				$upsellTitleArr .= 'Qty: '.$qty.'<br/>';
				$upsellTitleArr .= 'Total: '.$site_currency_type.$total_amount.'<br/><br/>';
				$upsellTitleOrderArr .= $upsell_title.", ";
					if(!empty($upsellDetail)){
						$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
						
						$upsellsArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']] = $upsell;
						$upsellsOrderArr[$upsell['id']]['qty'] = $qty;
						$upsellsOrderArr[$upsell['id']]['title'] = $upsellDetail[0]->up_title;
					}
					
					$i++;
				}
			}
		}
	
	
		$amount = $_POST['amount'];
	
		
		
		// kz multi_item
		$dojocartItemsText = '';
		if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
			$dojocartItemsText .= '<br>';
			foreach($_POST['dojocartItem'] as $contact_number => $dojocart_item){
				if(!empty($dojocart_item)){
					foreach($dojocart_item as $item_id => $item){
						$dojocartItemsText .= $item['item_full_text'].' <br>'; 
					}	
				}
			}
		}
		
		$dojocart_custom_fields = (isset($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : '';
		$dojocart_custom_fields_serialize = !empty($dojocart_custom_fields) ? serialize($dojocart_custom_fields) : '';
		
		
		$dojocart_upsale_ids = !empty($dojocartUpsalesIdsArr) ? serialize($dojocartUpsalesIdsArr) : '';

		

		$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $product_id);
		$product_title =  isset($productDetail[0]->product_title) ? $productDetail[0]->product_title : '';
		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		
		$mailchimp_type = 0;
		$mailchimp_template_id = '';
		$mailchimp_api_key = '';
		if(!empty($check_mailchimp)){
			$mailchimp_type = $check_mailchimp[0]->type;
			$mailchimp_template_id = $check_mailchimp[0]->template_id;
			$mailchimp_api_key =  $check_mailchimp[0]->api_key;
		}
		
		if(isset($_POST['program_id'])){

			$program_detail = $this->query_model->getbySpecific('tblprogram','id',$_POST['program_id']);

		}

		

		if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

			$location_detail = $this->query_model->getbySpecific('tblcontact','id',$_POST['location_id']);

			$location_id = $location_detail[0]->id;
			
			$noreply_email_address = $location_detail[0]->email;

		}else{

			$main_location_detail = $this->query_model->getMainLocation();

			$location_id = $main_location_detail[0]->id;

			$site_setting = $this->query_model->getbyTable('tblsite');	
			$noreply_email_address = $site_setting[0]->email;

		}	


	
		
		
			/****************Vinay new 22 july 2016*******************/
			
			
			$paypalDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
			
			$paypal_payment = $paypalDetail[0]->paypal_payment;
			$paypal_payment_mode = $paypalDetail[0]->paypal_payment_mode;
			$paypal_client_id = $paypalDetail[0]->paypal_client_id;
			$paypal_secret_key = $paypalDetail[0]->paypal_secret_key;
			
			$uniqueID = uniqid();
			
			if(isset($_POST) && !empty($_POST)){
				
				$unwanted_fields = array('card_name','credit_card_number','cvv','exp_month','exp_year','fax','miniform','website','payment_method_nonce');
				foreach($_POST as $k => $v){
					
					if(!in_array($k,$unwanted_fields)){
						$insertPostData = array();
						$insertPostData['order_unique_id'] = $uniqueID;
						$insertPostData['field'] = $k;
						$insertPostData['value'] = (!empty($v) && is_array($v)) ? serialize($v) :  $v;
						$this->query_model->insertData('tbl_paypal_custom_fields',$insertPostData);
					}
					
				}
			}
			
			$paypal_order_unique_id = array('paypal_order_unique_id' => $uniqueID);
			$this->session->set_userdata($paypal_order_unique_id);
			$cookie_name = "paypal_order_unique_id";
			$cookie_value = $uniqueID;
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			
			
					require 'vendor/PayPal-PHP-SDK/autoload.php';
					$paypal_setting = array(
							'mode' => $paypal_payment_mode,
							'http.ConnectionTimeOut' => 1000, //Specify the max request time in seconds
							'log.LogEnabled' => true, //Whether want to log to a file
							'log.FileName' => 'application/logs/paypal.log', //Specify the file that want to write on
							'log.LogLevel' => 'FINE' //Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
						);

					$apiContext = new \PayPal\Rest\ApiContext(
									new \PayPal\Auth\OAuthTokenCredential(
										$paypal_client_id,     // ClientID
										$paypal_secret_key      // ClientSecret
									)
							);
							
					$apiContext->setConfig($paypal_setting);
						
					$payer = new \PayPal\Api\Payer();
					$payer->setPaymentMethod('paypal');
					
					$description = 'Dojo Cart:- '.$product_title;
					$total_amount = $_POST['amount'];
					
					$item = new \PayPal\Api\Item();
					$item->setName($description) 
					->setCurrency($currency_type)
					->setQuantity(1)
					->setPrice($total_amount); 
					
					$item_list = new \PayPal\Api\ItemList();
					$item_list->setItems(array($item));
					
					$amount = new \PayPal\Api\Amount();
					$amount->setCurrency($currency_type)
						->setTotal($total_amount);
						
					$transaction = new \PayPal\Api\Transaction();
					$transaction->setAmount($amount)
						->setItemList($item_list)
						->setDescription($description)
						->setCustom($uniqueID);
					
					$redirect_urls = new \PayPal\Api\RedirectUrls();
					$redirect_urls->setReturnUrl(base_url().'dojocartpayment/paypal_success') /** Specify return URL **/
						->setCancelUrl(base_url().'dojocartpayment/paypal_cancel');

					 $payment = new \PayPal\Api\Payment();
					 $payment->setIntent('Sale')
							->setPayer($payer)
							->setRedirectUrls($redirect_urls)
							->setTransactions(array($transaction));
							
					//echo '<pre>payment'; print_r($payment); die;

					$p_error = '';
					try {
						$payment->create($apiContext);
						//echo '<pre>payment'.print_r($payment); 

						//echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
					}
					catch (\PayPal\Exception\PayPalConnectionException $ex) {
						// This will print the detailed information on the exception.
						//REALLY HELPFUL FOR DEBUGGING
						//echo '<prE>ex'; print_r($ex); die;
						$p_error = $ex->getData(); 
					}


					if(!empty($payment->getLinks())){
						foreach($payment->getLinks() as $link) {
							if($link->getRel() == 'approval_url') {
								$redirect_url = $link->getHref();
								break;
							}
						}
					}		
					
			
			/**********************************************/
			

		
	

	/** Insert Data in tbl_dojocart_orders table **/

	$insertOrder = array();

	$insertOrder['name'] = $_POST['name'];

	$insertOrder['last_name'] = $_POST['last_name'];

	$insertOrder['address'] = $_POST['address'];


	$insertOrder['address_line2'] =  isset($_POST['address_line2'])? $_POST['address_line2'] : '';

	$insertOrder['city'] = $_POST['city'];

	$insertOrder['state'] = $_POST['state'];

	$insertOrder['zip'] = $_POST['zip'];

	$insertOrder['phone'] = $_POST['phone'];

	

	$insertOrder['amount'] = $_POST['amount'];

	$insertOrder['email'] = $_POST['email'];

	//$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

	//$insertOrder['trial_id'] = $_POST['trial_id'];

	$insertOrder['trans_status'] = 'failed';

	$insertOrder['offer_type'] = 'Paid';

	$insertOrder['created'] = date('Y-m-d H:i:s');

	$insertOrder['quantity'] = isset($_POST['quantity'])? $_POST['quantity'] : 0;

	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;

	$insertOrder['product_id'] = isset($_POST['product_id'])? $_POST['product_id'] : 0;
	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	$insertOrder['is_multi_item_dojocart'] = $is_multi_item_dojocart; //multi_item
	$insertOrder['items_list'] = $dojocartItemsText; //multi_item
	$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['upsale_ids'] = $dojocart_upsale_ids;
	$insertOrder['upsells'] = !empty($upsellsArr) ? serialize($upsellsArr) : '';
	$insertOrder['custom_fields'] = $dojocart_custom_fields_serialize;
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
	
	$this->query_model->insertData('tbl_dojocart_orders', $insertOrder);

	$order_id = $this->db->insert_id();
	
	if(!empty($order_id)){
		
		$this->query_model->updateOrderForKabanLeads($order_id,'tbl_dojocart_orders','Dojo Cart Purchase',$_POST);
	}
	
	//echo '<pre>'; print_r($payment_result); die;
	
	// multi_item save order items 
	if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
		$this->query_model->save_dojocart_order_items($_POST['dojocartItem'], $order_id,$product_id);
	}
	
	// upsell qty save order upsells 
	if(!empty($upsellsOrderArr)){
		$this->query_model->save_dojocart_order_upsells($upsellsOrderArr, $order_id,$product_id);
	}
	
		$orderRecord = array('order_type'=>'dojocart','order_id'=>$order_id,'created_date'=>date('Y-m-d H:i:s'));
		foreach($orderRecord as $k => $v){
			$insertPostData = array();
			$insertPostData['order_unique_id'] = $uniqueID;
			$insertPostData['field'] = $k;
			$insertPostData['value'] = $v;
			$this->query_model->insertData('tbl_paypal_custom_fields',$insertPostData);
		}
		
		
		
		if(isset($redirect_url) && !empty($redirect_url)) {
			
			redirect($redirect_url);
			
		}else{
			
			$results['result'] = 0;
			$results['error_msg'] = $p_error;
			$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$p_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
			
			if(isset($results['result']) && $results['result'] == 0){
				$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 12);
			
				$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
				
				$this->load->view("upsell_thankyou_page", $results);
			}
		}
		
		
		
		
		}
	}
	
	
	public function paypal_success(){
		
		date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
		
		$paypalDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
			
		$paypal_payment = $paypalDetail[0]->paypal_payment;
		$paypal_payment_mode = $paypalDetail[0]->paypal_payment_mode;
		$paypal_client_id = $paypalDetail[0]->paypal_client_id;
		$paypal_secret_key = $paypalDetail[0]->paypal_secret_key;
		
		$payment_id = (isset($_GET['paymentId']) && !empty($_GET['paymentId'])) ? $_GET['paymentId'] : '';
		$payer_id = (isset($_GET['PayerID']) && !empty($_GET['PayerID'])) ? $_GET['PayerID'] : '';
		$token = (isset($_GET['token']) && !empty($_GET['token'])) ? $_GET['token'] : '';
		
		if(!empty($payment_id) &&  !empty($payer_id)){
			
			require 'vendor/PayPal-PHP-SDK/autoload.php';
			
			$paypal_setting = array(
					'mode' => $paypal_payment_mode,
					'http.ConnectionTimeOut' => 1000, //Specify the max request time in seconds
					'log.LogEnabled' => true, //Whether want to log to a file
					'log.FileName' => 'application/logs/paypal.log', //Specify the file that want to write on
					'log.LogLevel' => 'FINE' //Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
				);

			$apiContext = new \PayPal\Rest\ApiContext(
							new \PayPal\Auth\OAuthTokenCredential(
								$paypal_client_id,     // ClientID
								$paypal_secret_key      // ClientSecret
							)
					);
						
			$apiContext->setConfig($paypal_setting);
			
			$payment = new \PayPal\Api\Payment();
			$payment = $payment->get($payment_id, $apiContext);
			$execution = new \PayPal\Api\PaymentExecution();
			$execution->setPayerId($payer_id);
			/**Execute the payment **/
			$result = $payment->execute($execution, $apiContext);
			
			
			
			if(isset($result->transactions[0]->custom) && !empty($result->transactions[0]->custom)){
				$order_unique_id = $result->transactions[0]->custom;
				
				$this->db->select(array('field','value'));	
				$postFields = $this->query_model->getBySpecific('tbl_paypal_custom_fields','order_unique_id',$order_unique_id);
				
				
				if(!empty($postFields)){
					foreach($postFields as $key => $val){
						
						$p_data = @unserialize($val->value);
						if ($val->value === 'b:0;' || $p_data !== false) {
							$_POST[$val->field] = unserialize($val->value);
						} else {
							$_POST[$val->field] = $val->value;
						}
					}
				}
			//echo '<pre>result'; print_r($result);	
			//echo '<pre>post'; print_r($_POST); die;	
				if (!empty($_POST) && $result->getState() == 'approved') {
					
					$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
					
					$is_multi_item_dojocart = (isset($_POST['is_multi_item_dojocart']) && $_POST['is_multi_item_dojocart'] == 1) ? $_POST['is_multi_item_dojocart'] : 0;
					if($is_multi_item_dojocart == 1){
						$_POST['name'] = isset($_POST['contact_name'][1]) ? $_POST['contact_name'][1] : '';
						$_POST['last_name'] = isset($_POST['contact_last_name'][1]) ? $_POST['contact_last_name'][1] : '';
					}
					
					$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
				$site_currency_type = $this->query_model->getSiteCurrencyType();
					/** geting from, replyto and cc email address **/
				$emailIdManager = $this->query_model->getbyTable('tblsite');
				
				$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
				
				$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
				
				$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
				/*** end  code **/
				
				
					$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
					$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
					$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
					$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
					$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
					$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
					$amount = $_POST['amount'];
					$upsellTitleArr = '';
					$upsellTitleOrderArr = '';
					$dojocartUpsalesIdsArr = array();
					
					
				
				$upsellsArr = array();
				$upsellsOrderArr = array();
				if( isset($_POST['upsell']) && !empty($_POST['upsell']) ){
					$i = 1; 
					foreach($_POST['upsell'] as $key => $upsell){
					 if (isset($upsell['id']) && !empty($upsell['id']) && isset($upsell['is_active']) && $upsell['is_active'] == 1){
						
						$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $upsell['id']);
						$qty = (isset($upsell['qty']) && !empty($upsell['qty'])) ? $upsell['qty'] : 0;
						if($qty > 1 && !empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 0){
							$qty = 1;
						}
						
						
						$amount = (isset($upsell['amount']) && !empty($upsell['amount'])) ? $upsell['amount'] : 0;
						$total_amount = $amount * $qty;
						$dojocart_upsale_title = !empty($upsellDetail) ? $upsellDetail[0]->up_title : '';
						
						if(!empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 1){
							$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'(qty='.$qty.'&amount='.$site_currency_type.$amount.'&total='.$site_currency_type.$total_amount.')' : '';
							
						}else{
							$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'('.$site_currency_type.$total_amount.')' : '';
						}
						
						//$upsellTitleArr .= $upsell_title.', ';
						$upsellTitleArr .= 'Upsell #'.$i.': '.$dojocart_upsale_title.'<br/>';
						$upsellTitleArr .= 'Amount: '.$site_currency_type.$amount.'<br/>';
						$upsellTitleArr .= 'Qty: '.$qty.'<br/>';
						$upsellTitleArr .= 'Total: '.$site_currency_type.$total_amount.'<br/><br/>';
						$upsellTitleOrderArr .= $upsell_title.", ";
							if(!empty($upsellDetail)){
								$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
								
								$upsellsArr[$upsell['id']] = $upsell;
								$upsellsOrderArr[$upsell['id']] = $upsell;
								$upsellsOrderArr[$upsell['id']]['qty'] = $qty;
								$upsellsOrderArr[$upsell['id']]['title'] = $upsellDetail[0]->up_title;
							}
							
							$i++;
						}
					}
				}
			
			
					$amount = $_POST['amount'];
	
		
		
						// kz multi_item
						$dojocartItemsText = '';
						if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
							$dojocartItemsText .= '<br>';
							foreach($_POST['dojocartItem'] as $contact_number => $dojocart_item){
								if(!empty($dojocart_item)){
									foreach($dojocart_item as $item_id => $item){
										$dojocartItemsText .= $item['item_full_text'].' <br>'; 
									}	
								}
							}
						}
						
						$dojocart_custom_fields = (isset($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : '';
						$dojocart_custom_fields_serialize = !empty($dojocart_custom_fields) ? serialize($dojocart_custom_fields) : '';
						
						
						$dojocart_upsale_ids = !empty($dojocartUpsalesIdsArr) ? serialize($dojocartUpsalesIdsArr) : '';

						

						$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $product_id);
						$product_title =  isset($productDetail[0]->product_title) ? $productDetail[0]->product_title : '';
						$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
						
						$mailchimp_type = 0;
						$mailchimp_template_id = '';
						$mailchimp_api_key = '';
						if(!empty($check_mailchimp)){
							$mailchimp_type = $check_mailchimp[0]->type;
							$mailchimp_template_id = $check_mailchimp[0]->template_id;
							$mailchimp_api_key =  $check_mailchimp[0]->api_key;
						}
						
						if(isset($_POST['program_id'])){

							$program_detail = $this->query_model->getbySpecific('tblprogram','id',$_POST['program_id']);

						}

						

						if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

							$location_detail = $this->query_model->getbySpecific('tblcontact','id',$_POST['location_id']);

							$location_id = $location_detail[0]->id;
							
							$noreply_email_address = $location_detail[0]->email;

						}else{

							$main_location_detail = $this->query_model->getMainLocation();

							$location_id = $main_location_detail[0]->id;

							$site_setting = $this->query_model->getbyTable('tblsite');	
							$noreply_email_address = $site_setting[0]->email;

						}	



						$paymentResult = $this->query_model->getStaticTextTranslation('payment_success');
						
						$this->query_model->checkFormModuleApplyAPI($_POST);
						
						$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
						$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
						$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
						
						$extraContentArr  = array('dojocart_title' => $product_title, 'dojocart_quantity' => $quantity, 'dojocart_amount'=> $site_currency_type.$amount, 'upsell_list'=>$upsellTitleArr, 'paymentResult' => $paymentResult,'dojocart_coupon_name'=>$coupon_code,'dojocart_coupon_discount'=>$coupon_discount,'dojocart_custom_fields'=>$dojocart_custom_fields,'dojocart_item_list'=>$dojocartItemsText);
						$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);
						
						// sending msg by twillio api
						$this->query_model->connectFormToTwillioAPi($_POST,'dojocart',$extraContentArr);
		
					
					
					$results['result'] = 1;
					
					$ptid = $payment_id;
			
			
					$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $ptid;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					$insertTransaction['payment_type'] = "dojocart";
			
					$this->query_model->insertData('tbl_transaction', $insertTransaction);
			
					
			
					$orderUpdate = array('trans_status' => 'Success');
			
					$this->query_model->update('tbl_dojocart_orders', $order_id, $orderUpdate);
			
					
					
					
					/** EMAIL SEND**/
							
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
						
									$location_name = $location_info[0]->name;
						
									$location_email = $location_info[0]->email;
						
								}else{
						
									$location_name = '';
						
								}
								
								//echo $location_name; die;
								
								$name = $_POST['name'];
								$last_name = $_POST['last_name'];
								$email = $_POST['email'];
								$phone = str_replace(' ', '-', $_POST['phone']);
								$message = 'Payment Success';
								$program = isset($_POST['program_id'])? $_POST['program_id']:0;
			
									if($program != 0){
							
										$program_info = $this->query_model->getbyId("tblprogram", $program);
							
										$program = $program_info[0]->program;	
							
									}else{
							
										$program = '';
							
									}
								
								$site_setting = $this->query_model->getbyTable('tblsite');
									
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
										
										$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysql_error());
						
										$location_data = $qry->row_array();
										
										$loc_email = $location_data['email'];
								
								} else{
										$main_location_id = $this->query_model->getMainLocation();
										$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysql_error());
						
										$location_data = $qry->row_array();
								}
								
								
								$this->load->library("email");
			
								$query = $this->query_model->getbyTable('tblsite');
			
								foreach($query as $row):
			
									$site_email = trim($row->email);
			
									$school_name = $row->title;
			
								endforeach;
								
								if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			
									$site_email = $loc_email;
			
								}
								
						
						/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
						$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

						
						if(isset($emailAutoResponder['admin_email'])){	
							$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiple_loc[0]->field_value == 1){
								$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
								//$text_address = $loc_detail[0]->text_address;
								$text_address = 0;
							}else{
								$loc_detail = $this->query_model->getMainLocation("tblcontact");
								$text_address = $loc_detail[0]->text_address;
							}
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
							$type = '';
							$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


							if(!empty($text_address) && !empty($mes)){
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
												
									if(!empty($fromEmailId)){
										$this->email->from($fromEmailId);
									}
									if(!empty($email)){
										$this->email->reply_to($email);
									}
									if(!empty($cc_email)){
										$this->email->bcc($cc_email);
									}
			
								$this->email->to($text_address);
			
								$this->email->subject($type);
			
							//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
							//$mes .= "<br/>";	
							//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
							
			
								$this->email->message($mes);
			
								$this->email->send();
							}
								
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
							
							
							// Mail to admin (Payment Success)
							
								
								//$type = $product_title." | ".$school_name.' | '.$name.' '.$last_name;
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
								$config['wordwrap'] = TRUE;
			
								$config['mailtype']="html";
			
								$this->email->initialize($config);
			
								//$this->email->from($email);
								
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
						$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
								$this->email->to($site_email);
			
								$this->email->subject($type);
			
								$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';								$mes .= "<br/>";								
								//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';								
			
								$this->email->message($mes);
			
								
			
								$this->email->send();
						}
								
			
								// send email to websitedojo.com
			
								/*$this->email->initialize($config);
			
								$this->email->from($email);
			
								$this->email->to('leads@websitedojo.com');
			
								$this->email->subject($type.' - '.$school_name);
			
								$this->email->message($mes);					
			
								$this->email->send(); */
			
								
			
								
			
						// Email to user (Payment Success)
					if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
						$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
						$cont = "Thank you, your order was accepted! A representative from our school will contact you shortly with more information.";
						$config['charset'] = 'UTF-8';	
						$config['wordwrap'] = TRUE;	
						$config['mailtype']="html";	
						$this->email->initialize($config);
						$from_email=trim($this->config->item('email_from'));																				/*		if(!empty($from_email)){	
						$this->email->from($from_email,$school_name);
						}else{					
							$this->email->from($site_email,$school_name);											
						}	 */
						
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
					/***********/
			
					$results['error_message'] = "<p class='payment_result'>Thank you, your order was accepted! A representative from our school will contact you shortly with more information.</p>";
					
						$this->query_model->getThankYouPageMessage($_POST);
						$dojocart_thankyou_url = $this->query_model->getDojocartThankyouUrl($productDetail[0]->slug);
						
						redirect(@base_url().$dojocart_thankyou_url);
							
							
				}
			}
			
			
		}
	
		
		
	}
	
	
	
	public function paypal_cancel(){
		
		date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
		
		$paypalDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
			
		$paypal_payment = $paypalDetail[0]->paypal_payment;
		$paypal_payment_mode = $paypalDetail[0]->paypal_payment_mode;
		$paypal_client_id = $paypalDetail[0]->paypal_client_id;
		$paypal_secret_key = $paypalDetail[0]->paypal_secret_key;
		
		$token = (isset($_GET['token']) && !empty($_GET['token'])) ? $_GET['token'] : 'EC-4T703949T6758723A';
		
		
		$order_unique_id = $this->session->userdata('paypal_order_unique_id');
		if(empty($order_unique_id)){
			$order_unique_id = isset($_COOKIE['paypal_order_unique_id']) ? $_COOKIE['paypal_order_unique_id'] : '';
		}
		
		if(!empty($order_unique_id)){
			
			$this->db->select(array('field','value'));	
			$postFields = $this->query_model->getBySpecific('tbl_paypal_custom_fields','order_unique_id',$order_unique_id);
			
			
			if(!empty($postFields)){
				foreach($postFields as $key => $val){
					
					$p_data = @unserialize($val->value);
					if ($val->value === 'b:0;' || $p_data !== false) {
						$_POST[$val->field] = unserialize($val->value);
					} else {
						$_POST[$val->field] = $val->value;
					}
				}
			}
			//echo '<pre>_POST'; print_r($_POST); die;
			if (!empty($_POST)){
				
					$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : 0;
					
					$is_multi_item_dojocart = (isset($_POST['is_multi_item_dojocart']) && $_POST['is_multi_item_dojocart'] == 1) ? $_POST['is_multi_item_dojocart'] : 0;
					if($is_multi_item_dojocart == 1){
						$_POST['name'] = isset($_POST['contact_name'][1]) ? $_POST['contact_name'][1] : '';
						$_POST['last_name'] = isset($_POST['contact_last_name'][1]) ? $_POST['contact_last_name'][1] : '';
					}
					
					$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
				$site_currency_type = $this->query_model->getSiteCurrencyType();
					/** geting from, replyto and cc email address **/
				$emailIdManager = $this->query_model->getbyTable('tblsite');
				
				$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
				
				$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
				
				$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
				/*** end  code **/
				
				
					$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
					$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
					$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
					$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
					$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
					$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
					$amount = $_POST['amount'];
					$upsellTitleArr = '';
					$upsellTitleOrderArr = '';
					$dojocartUpsalesIdsArr = array();
					
					
				
				$upsellsArr = array();
				$upsellsOrderArr = array();
				if( isset($_POST['upsell']) && !empty($_POST['upsell']) ){
					$i = 1; 
					foreach($_POST['upsell'] as $key => $upsell){
					 if (isset($upsell['id']) && !empty($upsell['id']) && isset($upsell['is_active']) && $upsell['is_active'] == 1){
						
						$upsellDetail = $this->query_model->getbySpecific('tbl_dojocart_upsales', 'id', $upsell['id']);
						$qty = (isset($upsell['qty']) && !empty($upsell['qty'])) ? $upsell['qty'] : 0;
						if($qty > 1 && !empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 0){
							$qty = 1;
						}
						
						
						$amount = (isset($upsell['amount']) && !empty($upsell['amount'])) ? $upsell['amount'] : 0;
						$total_amount = $amount * $qty;
						$dojocart_upsale_title = !empty($upsellDetail) ? $upsellDetail[0]->up_title : '';
						
						if(!empty($upsellDetail) &&  $upsellDetail[0]->is_qty_apply == 1){
							$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'(qty='.$qty.'&amount='.$site_currency_type.$amount.'&total='.$site_currency_type.$total_amount.')' : '';
							
						}else{
							$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title .'('.$site_currency_type.$total_amount.')' : '';
						}
						
						//$upsellTitleArr .= $upsell_title.', ';
						$upsellTitleArr .= 'Upsell #'.$i.': '.$dojocart_upsale_title.'<br/>';
						$upsellTitleArr .= 'Amount: '.$site_currency_type.$amount.'<br/>';
						$upsellTitleArr .= 'Qty: '.$qty.'<br/>';
						$upsellTitleArr .= 'Total: '.$site_currency_type.$total_amount.'<br/><br/>';
						$upsellTitleOrderArr .= $upsell_title.", ";
							if(!empty($upsellDetail)){
								$dojocartUpsalesIdsArr[$upsellDetail[0]->id] = $upsellDetail[0]->id;
								
								$upsellsArr[$upsell['id']] = $upsell;
								$upsellsOrderArr[$upsell['id']] = $upsell;
								$upsellsOrderArr[$upsell['id']]['qty'] = $qty;
								$upsellsOrderArr[$upsell['id']]['title'] = $upsellDetail[0]->up_title;
							}
							
							$i++;
						}
					}
				}
			
			
					$amount = $_POST['amount'];
	
		
		
						// kz multi_item
						$dojocartItemsText = '';
						if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
							$dojocartItemsText .= '<br>';
							foreach($_POST['dojocartItem'] as $contact_number => $dojocart_item){
								if(!empty($dojocart_item)){
									foreach($dojocart_item as $item_id => $item){
										$dojocartItemsText .= $item['item_full_text'].' <br>'; 
									}	
								}
							}
						}
						
						$dojocart_custom_fields = (isset($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : '';
						$dojocart_custom_fields_serialize = !empty($dojocart_custom_fields) ? serialize($dojocart_custom_fields) : '';
						
						
						$dojocart_upsale_ids = !empty($dojocartUpsalesIdsArr) ? serialize($dojocartUpsalesIdsArr) : '';

						

						$productDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $product_id);
						$product_title =  isset($productDetail[0]->product_title) ? $productDetail[0]->product_title : '';
						$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
						
						$mailchimp_type = 0;
						$mailchimp_template_id = '';
						$mailchimp_api_key = '';
						if(!empty($check_mailchimp)){
							$mailchimp_type = $check_mailchimp[0]->type;
							$mailchimp_template_id = $check_mailchimp[0]->template_id;
							$mailchimp_api_key =  $check_mailchimp[0]->api_key;
						}
						
						if(isset($_POST['program_id'])){

							$program_detail = $this->query_model->getbySpecific('tblprogram','id',$_POST['program_id']);

						}

						

						if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

							$location_detail = $this->query_model->getbySpecific('tblcontact','id',$_POST['location_id']);

							$location_id = $location_detail[0]->id;
							
							$noreply_email_address = $location_detail[0]->email;

						}else{

							$main_location_detail = $this->query_model->getMainLocation();

							$location_id = $main_location_detail[0]->id;

							$site_setting = $this->query_model->getbyTable('tblsite');	
							$noreply_email_address = $site_setting[0]->email;

						}	



						$paymentResult = $this->query_model->getStaticTextTranslation('payment_failure');
						
						$this->query_model->checkFormModuleApplyAPI($_POST);
						
						$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
						$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
						$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
						
						$extraContentArr  = array('dojocart_title' => $product_title, 'dojocart_quantity' => $quantity, 'dojocart_amount'=> $site_currency_type.$amount, 'upsell_list'=>$upsellTitleArr, 'paymentResult' => $paymentResult,'dojocart_coupon_name'=>$coupon_code,'dojocart_coupon_discount'=>$coupon_discount,'dojocart_custom_fields'=>$dojocart_custom_fields,'dojocart_item_list'=>$dojocartItemsText);
						//echo '<pre>extraContentArr'; print_r($extraContentArr);
						$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);
						//echo '<pre>emailAutoResponder'; print_r($emailAutoResponder); die;
						// sending msg by twillio api
						$this->query_model->connectFormToTwillioAPi($_POST,'dojocart',$extraContentArr);
					
					$payment_error = 'payment cancelled';	
					$results['result'] = 0;
					$results['error_msg'] = $payment_error;
					$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
					
					
				
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
			
						$location_name = $location_info[0]->name;
			
						$location_email = $location_info[0]->email;
			
					}else{
			
						$location_name = '';
			
					}
					
					$name = $_POST['name'];
					$last_name = $_POST['last_name'];
					$email = $_POST['email'];
					$phone = str_replace(' ', '-', $_POST['phone']);
					$message = $this->query_model->getStaticTextTranslation('payment_failure');

					
					$site_setting = $this->query_model->getbyTable('tblsite');
						
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
							
							$qry = $this->db->query("select * from `tblcontact` where id = ".$_POST['location_id']) or die(mysql_error());
			
							$location_data = $qry->row_array();
							
							$loc_email = $location_data['email'];
					
					} else{
							$main_location_id = $this->query_model->getMainLocation();
							$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysql_error());
			
							$location_data = $qry->row_array();
					}
					
					
					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

						$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;
					
					if(isset($_POST['location_id']) && !empty($_POST['location_id'])){

						$site_email = $loc_email;

					}
					
					
					//echo $site_email; die;
					
				/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
				$unique_email_address = !empty($productDetail[0]->unique_email_address) ? $productDetail[0]->unique_email_address : '';

			if(isset($emailAutoResponder['admin_email'])){	
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'dojocart',$extraContentArr);
				$type = '';
				$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($mes)){
					
				//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				
					$config['charset'] = 'UTF-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					$this->email->to($text_address);
					$this->email->subject($type);

					//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
					//$mes .= "<br/>";	
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					

					$this->email->message($mes);
					$this->email->send();
			}					
		/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
				
				// Mail to Admin (Payment Failure)

					$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'UTF-8';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					//$this->email->from($email);
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					
					$site_email = !empty($unique_email_address) ? $unique_email_address : $site_email;
					$this->email->to($site_email);

					$this->email->subject($type);

										
					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';					
					$mes .= "<br/>";					
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					$this->email->message($mes);

					

					$this->email->send();
			}
					

					// send email to websitedojo.com

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

			// Email to user (Payment Failure)
			if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){									
					$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';					
					$cont = $message; 					
					$config['charset'] = 'UTF-8';					
					$config['wordwrap'] = TRUE;					
					$config['mailtype']="html";					
					$this->email->initialize($config);					
					$from_email=trim($this->config->item('email_from'));										
					/*if(!empty($from_email)){						
						$this->email->from($from_email,$school_name);					
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
				
					$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
				//echo '<pre>results'; print_r($results); die;
				if(isset($results['result']) && $results['result'] == 0){
					
					$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 12);
					
					$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
					
					$this->session->unset_userdata('paypal_order_unique_id');
					if (isset($_COOKIE['paypal_order_unique_id'])) {
						unset($_COOKIE['paypal_order_unique_id']); 
						setcookie('paypal_order_unique_id', null, -1, '/'); 
					}
					
					$this->load->view("upsell_thankyou_page", $results);
				}
				
										
				}
			
			
		}else{
			redirect('/site/page_not_found');
		}
		
		
	}
	
	
	
}