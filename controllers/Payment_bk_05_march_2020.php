<?php 

 require 'vendor/autoload.php';

			

				use net\authorize\api\contract\v1 as AnetAPI;

				use net\authorize\api\controller as AnetController;
				
				use \net\authorize\api\constants\ANetEnvironment;
				

					

if ( ! defined('BASEPATH')) exit('No direct script access allowed');







class Payment extends CI_Controller {







	public function buyoffer() {
		
			if ( !isset($_POST['submit']) && empty($_POST['submit'] ) ) {
				redirect('online-special','refresh');
			}
			

			if($_POST['website'] != ''){

				die("An error occurred, please try again");

			}

			

			

			$data['page_title'] = 'Payment';


		if(isset($_POST['refferal'])){ 
				$this->session->set_userdata('refferal_url',$_POST['refferal']);
		}
			

			if(isset($_POST['trial_id'])){

				if(isset($_POST['location_id'])){

					$data['location_detail'] = $this->query_model->getbySpecific('tblcontact', 'id', $_POST['location_id']);

				} else{

					$data['location_detail'] = $this->query_model->getMainLocation();

				}

				
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$data['offer_detail'] = $this->query_model->getbySpecific("$tblspecialoffer",'id', $_POST['trial_id']);

				$data['offer_detail'] = $data['offer_detail'][0];

				

				$this->db->where("published", 1);
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");

				$data['site_setting'] = $this->query_model->getbyTable("tblsite");

				$this->load->view('buyoffer', $data);

			} else{

				die("An error occurred, please try again");

			}

	}



	

public function authorized_payment_gateway(){
$_POST['submit'] = 'Purchase Now';
		
		if(isset($_POST['submit'])){
			
			if(!isset($_POST['credit_card_number']) || !isset($_POST['exp_month']) || !isset($_POST['exp_year']) || !isset($_POST['cvv'])){
				redirect('/site/page_not_found');
			}
			
		//echo '<pre>_POST'; print_r($_POST); die;
		// checking hunney Post
		$this->query_model->checkHunneyPost($_POST);
		
		$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
		$site_currency_type = $this->query_model->getSiteCurrencyType();

		/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		
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

		$_POST['location_id'] = $location_id;		

		
		$authorizeDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
	

		//$getCustomer = $customerProfile->getCustomerProfile(1502512958); 
		
		//$deleteCustomer = $customerProfile->deleteCustomerProfile($customerProfileID); 
		
		//echo $getCustomer->xml['profile']->customerProfileId; die;
		//$getCustomer->xml['profile']->customerProfileId
		//$getCustomer->xml['messages']->resultCode == "OK"
	//	echo '<pre>create customer=>'; print_r($createCustomer);
		//echo '<pre>get customer=>'; print_r($getCustomer);
	//	echo '<pre>delete customer=>'; print_r($deleteCustomer);
		//die;
		
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		//$transaction = new AuthorizeNetAIM ($authorizeDetail[0]->authorize_loginkey, $authorizeDetail[0]->authorize_transkey);
		
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

		$address1 = isset($_POST['address']) ? urlencode($_POST['address']) : '';

		$city = isset($_POST['city']) ? urlencode($_POST['city']) : '';

		$state =isset($_POST['state']) ?  urlencode( $_POST['state']) : '';

		$zip = isset($_POST['zip']) ? urlencode($_POST['zip']) : '';
		
		

		//give the actual amount below

		$amount = $_POST['amount'];

		$currencyCode="USD";

		$paymentType="Trial";

		$date = $expDateMonth.$expDateYear;
		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$offer_detail = $this->query_model->getbySpecific("$tblspecialoffer", 'id' , $_POST['trial_id']);
		$trial_offer_name = !empty($offer_detail) ? $offer_detail[0]->offer_title : '';
		$trial_offer_amount = (!empty($offer_detail) && $offer_detail[0]->trial == 1) ? $site_currency_type.$offer_detail[0]->amount : '';
		

		
		
	/** create customer profile **/
	/*$customerProfile = new AuthorizeNetCIM ($authorizeDetail[0]->authorize_loginkey, $authorizeDetail[0]->authorize_transkey);
	
	$offerDetail = $this->query_model->getByID('tblspecialoffer' , $_POST['trial_id']);
	$offer_title = !empty($offerDetail) ?  preg_replace('/[^a-zA-Z0-9 \']/', '',$offerDetail[0]->title) : '';
	$offer_desc = !empty($offerDetail) ?  preg_replace('/[^a-zA-Z0-9 \']/', '',$offerDetail[0]->offer_title) : '';

	
	// createing customer
	//$_POST['email'] = 'test000909809@gmail.com';
$paymentResponseArr['result'] = 0;	
$paymentResponseArr['message'] = '';
$customerProfileId = '';
$customerPaymentProfileId = '';

$apiMode = 'testMode';
if($authorizeDetail[0]->authorize_payment_mode == "production"){
	$apiMode = 'liveMode';
}

 $createCustomerData = '{
    "createCustomerProfileRequest": {
        "merchantAuthentication": {
             "name": "'.$authorizeDetail[0]->authorize_loginkey.'",
			 "transactionKey": "'.$authorizeDetail[0]->authorize_transkey.'"
        },
        "profile": {
            "merchantCustomerId": "'.mt_rand(10000000, 99999999).'",
            "description": "'.$offer_title.'",
            "email": "'.$_POST['email'].'",
            "paymentProfiles": {
                "customerType": "individual",
                "payment": {
                    "creditCard": {
                        "cardNumber": "'.$_POST['credit_card_number'].'",
                        "expirationDate": "'.$_POST['exp_year'].'-'.$_POST['exp_month'].'",
						"cardCode": "'.$_POST['cvv'].'"
                    }
                }
            }
        },
        "validationMode": "'.$apiMode.'"
    }
}';

$responseCreateCustomer = $this->query_model->authorizeNetApiRequests($createCustomerData, $apiMode); 

$getCustomer = array();

if(!empty($responseCreateCustomer)){
	if(isset($responseCreateCustomer[0]->messages->resultCode) && $responseCreateCustomer[0]->messages->resultCode == "Ok"){
		$paymentResponseArr['result'] = 1;
		$paymentResponseArr['message'] = $responseCreateCustomer[0]->messages->message[0]->text;
	}else{
		$paymentResponseArr['result'] = 0;
		$paymentResponseArr['message'] = $responseCreateCustomer[0]->messages->message[0]->text;
	}
}

if($paymentResponseArr['result'] == 1){
	// getting customer data
	$customerProfileData = '{
		"getCustomerPaymentProfileRequest": {
			"merchantAuthentication": {
				 "name": "'.$authorizeDetail[0]->authorize_loginkey.'",
				 "transactionKey": "'.$authorizeDetail[0]->authorize_transkey.'"
			},
			"customerProfileId": "'.$responseCreateCustomer[0]->customerProfileId.'",
			"customerPaymentProfileId": "'.$responseCreateCustomer[0]->customerPaymentProfileIdList[0].'"
		}
	}';
	
	$getCustomer = $this->query_model->authorizeNetApiRequests($customerProfileData, $apiMode); 
	
}

if(!empty($getCustomer)){
	if(isset($getCustomer[0]->messages->resultCode) && $getCustomer[0]->messages->resultCode == "Ok"){
		$paymentResponseArr['result'] = 1;
		$paymentResponseArr['message'] = $getCustomer[0]->messages->message[0]->text;
	}else{
		$paymentResponseArr['result'] = 0;
		$paymentResponseArr['message'] = $getCustomer[0]->messages->message[0]->text;
	}
}



	
	if($paymentResponseArr['result'] == 1){
		
		
		$customerProfileId = $getCustomer[0]->paymentProfile->customerProfileId; 
		$customerPaymentProfileId = $getCustomer[0]->paymentProfile->customerPaymentProfileId; 
		
		$customerPaymentData = '{
				"createTransactionRequest": {
					"merchantAuthentication": {
						"name": "'.$authorizeDetail[0]->authorize_loginkey.'",
						"transactionKey": "'.$authorizeDetail[0]->authorize_transkey.'"
					},
					"refId": "'.mt_rand(10000000, 99999999).'",
					"transactionRequest": {
						"transactionType": "authCaptureTransaction",
						"amount": "'.$amount.'",
						  "profile": {
							"customerProfileId": "'.$customerProfileId.'",
							"paymentProfile": { "paymentProfileId": "'.$customerPaymentProfileId.'" }
						},
						"lineItems": {
							"lineItem": {
								"itemId": "1",
								"name": "Trial Offer",
								"description": "'.$offer_desc.'",
								"quantity": "1",
								"unitPrice": "'.$amount.'"
							}
						}
					}
				}
			}';
		$payment_response = $this->query_model->authorizeNetApiRequests($customerPaymentData, $apiMode); 
		
	} 
	
	
$paymentResponseArr['transHash'] = '';	
if(!empty($payment_response)){
	if(isset($payment_response[0]->messages->resultCode) && $payment_response[0]->messages->resultCode == "Ok"){
		$paymentResponseArr['result'] = 1;
		$paymentResponseArr['message'] = $payment_response[0]->transactionResponse->messages[0]->description;
		$paymentResponseArr['transHash'] = $payment_response[0]->transactionResponse->transId;
		
	}else{
		$paymentResponseArr['result'] = 0;
		$paymentResponseArr['message'] = $payment_response[0]->messages->message[0]->text;
		
	}
}
 */
	

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

		"x_card_code"		=> $cvv2Number,
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

	//for test mode use the following url
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
	//echo $cvv2Number;
	//echo '<pre>response_array'; print_r($response_array); die;
	

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
	$offer_title = $this->query_model->getMetaDescReplace($trial_offer_name);
	$order->setDescription("Trial Offer: ".$offer_title);
	
	
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
                /*echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
                echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
                echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
                echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";
                echo " Payment Status: " . $response->getMessages()->getMessage()[0]->getText() . "\n";*/
				
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
	
	//echo $paymentResult; die;

	/** Insert Data in order table **/

	$insertOrder = array();

	$insertOrder['name'] = $_POST['name'];

	$insertOrder['last_name'] = $_POST['last_name'];

	$insertOrder['address'] = isset($_POST['address']) ? $_POST['address'] : '';

	$insertOrder['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';

	$insertOrder['city'] = isset($_POST['city']) ? $_POST['city'] : '';

	$insertOrder['state'] = isset($_POST['state']) ? $_POST['state'] : '';

	$insertOrder['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';

	$insertOrder['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';

	

	$insertOrder['amount'] = $_POST['amount'];

	$insertOrder['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0;

	$insertOrder['location_id'] = $_POST['location_id'];

	$insertOrder['email'] = $_POST['email'];

	//$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

	$insertOrder['trial_id'] = $_POST['trial_id'];

	$insertOrder['trans_status'] = $payment_status_type;

	$insertOrder['offer_type'] = 'Paid';

	$insertOrder['created'] = date('Y-m-d h-i-s');
	
	$insertOrder['ip_address'] =isset($_POST['ip_address']) ? $_POST['ip_address'] : '';
	$insertOrder['gdpr_compliant_checkbox'] =isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : 0;

	$insertOrder['client_id'] = $time;
	//$insertOrder['client_id'] = $response_array[6];
	//$insertOrder['client_token'] = $response_array[6];
	$insertOrder['last_order_id'] = 0;
	$insertOrder['coupon_code'] = $coupon_code;
	$insertOrder['coupon_discount'] = $coupon_discount;
	$insertOrder['is_unique_trial'] = $this->query_model->isUniqueSpecialOffer();
	$insertOrder['child_name'] =(isset($_POST['child_name']) && !empty($_POST['child_name'])) ? $_POST['child_name'] : '';
	$insertOrder['child_age'] =(isset($_POST['child_age']) && !empty($_POST['child_age'])) ? $_POST['child_age'] : '';
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
	
	/*		
	* checkFormModuleApplyAPI 						
	* this function for using apis according form model 						
	*/
		/*
		$paymentResult = '';
		if($response_array[0]==2 || $response_array[0]==3){
			$paymentResult = 'Payment Failure: '.$response_array[3];
		}else{
			$paymentResult = 'Payment Success';
		}*/
		
		
		
	//echo '<pre>response_array'; print_r($response_array); die;
	$extraContentArr  = array('paymentResult' => $paymentResult,'trial_offer_name' => $trial_offer_name, 'trial_offer_amount' => $trial_offer_amount, 'trial_offer_type'=> 'PAID','trial_coupon_name' => $coupon_code,'trial_coupon_discount' => $coupon_discount);	
	
	$this->query_model->checkFormModuleApplyAPI($_POST);		
	$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
	
	// sending msg by twillio api
	$this->query_model->connectFormToTwillioAPi($_POST,'paid_trial',$extraContentArr);
		
	$this->query_model->insertData('tblorders', $insertOrder);

	$order_id = $this->db->insert_id();
	
	if(!empty($order_id)){
		$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
		
	}
	

	//echo $response_array[6]; die;

	if($payment_status_code != 1) 

	{

		//success 
		$results['result'] = 0;
		$results['error_msg'] = $paymentResult;
		$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$this->query_model->getStaticTextTranslation('error_string').': '.$paymentResult.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
			
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
					$phone = $_POST['phone'];
					$message = $this->query_model->getStaticTextTranslation('payment_failure'); 
					$program = $_POST['program_id'];

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
			if(isset($emailAutoResponder['admin_email'])){	
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'paid_trial',$extraContentArr);
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
					if(!empty($replyEmailId)){
						$this->email->reply_to($replyEmailId);
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

				// Mail to admin (Payment Failure) 

					
					$type =  isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'UTF-8';

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
				$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';					
				$cont = "Thank you, your request was accepted! A representative from our school will contact you shortly with more information."; 
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
				$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';					$this->email->message($mes);					$this->email->send();			}
		
			/************************************************************************************************************************/

	}

	else

	{

		
		$results['result'] = 1;
		//$ptid = $paymentResponseArr['transHash'];
		$ptid = $transaction_id;
		//$ptidmd5 = $response_array[7];



		//2250745842=====>

		$insertTransaction = array();

		$insertTransaction['transaction_id'] = $ptid;

		$insertTransaction['amount'] = 	$_POST['amount'];	

		$insertTransaction['order_id'] = $order_id;
		$insertTransaction['payment_type'] = "trial_offer";

		$this->query_model->insertData('tbl_transaction', $insertTransaction);


		$orderUpdate = array('trans_status' => 'Success');

		$this->query_model->update('tblorders', $order_id, $orderUpdate);

		
		
		
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
					$phone = $_POST['phone'];
					$message = 'Payment Success';
					$program = $_POST['program_id'];

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
			if(isset($emailAutoResponder['admin_email'])){	
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}
				$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'paid_trial',$extraContentArr);
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
					if(!empty($replyEmailId)){
						$this->email->reply_to($replyEmailId);
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
				
					
					$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$config['charset'] = 'UTF-8';

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

					$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';					$mes .= "<br/>";					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';				

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

					

					

			// Email to user (Payment Success)

			
				if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){
					$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';

					$cont = "Payment Received! <br>Thank you, your trial was successfully started. A representative from our school will contact you shortly with more information."; 

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

		//$results['error_message'] = "<h1 class='payment_result'>Payment Received!</h1><p class='payment_result'>A representative from our school will contact you shortly with more information to start your trial.</p>";
	//	echo '<pass>'.$results['error_message'];
		//echo $result['message']; die;
		
		$_POST['order_id'] = $order_id;
		$thankYouPageDetail = $this->query_model->getFormModuleThankYouPage($_POST, 'paid');
		//redirect(@base_url().'starttrial/thankyou');
		
		$trial_offer_thankyou_url = $this->query_model->getTrialOfferThankyouUrl($_POST);
		redirect(@base_url().$trial_offer_thankyou_url);

	}

	
	if(isset($results['result']) && $results['result'] == 0){
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 9);
			
			$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
			
			$this->load->view("upsell_thankyou_page", $results);
		}
		
		//$this->load->view('payement_result', $results);
		
		}

	}

	


public function brainTreebuyoffer(){
	if ( !isset($_POST['submit']) && empty($_POST['submit'] ) ) {
		redirect('online-special','refresh');
	}
		
		// checking hunney Post
		$this->query_model->checkHunneyPost($_POST);
		$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
		$site_currency_type = $this->query_model->getSiteCurrencyType();

			
	 $data['page_title'] = 'Payment';

			
		if(isset($_POST['refferal'])){ 
				$this->session->set_userdata('refferal_url',$_POST['refferal']);
		}
			

			if(isset($_POST['trial_id'])){

				if(isset($_POST['location_id'])){

					$data['location_detail'] = $this->query_model->getbySpecific('tblcontact', 'id', $_POST['location_id']);

				} else{

					$data['location_detail'] = $this->query_model->getMainLocation();

				}

				
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$data['offer_detail'] = $this->query_model->getbySpecific("$tblspecialoffer",'id', $_POST['trial_id']);

				$data['offer_detail'] = $data['offer_detail'][0];

				

				$this->db->where("published", 1);

				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");

				

				$data['site_setting'] = $this->query_model->getbyTable("tblsite");

				//echo '<pre>'; print_r($data['site_setting'][0]->sitelogo); die;

				$this->load->view('brain_tree_buy_offer', $data);

			} else{

				die("An error occurred, please try again");

			}

	
}

public function brainTreePaymentGateway(){
			$_POST['submit'] = 'Purchase Now';

		if(isset($_POST['submit'])){
			
		
			if(!isset($_POST['credit_card_number']) || !isset($_POST['exp_month']) || !isset($_POST['exp_year']) || !isset($_POST['cvv'])){
				redirect('/site/page_not_found');
			}
		
		
		$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
		$site_currency_type = $this->query_model->getSiteCurrencyType();
		
			/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		
		//echo '<pre>'; print_r($_POST); die;
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
		$_POST['location_id'] = $location_id;

		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		
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
						//$this->load->library('Braintree');
						
						if($brainTreeDetail[0]->braintree_payment_mode == "production"){
							Braintree_Configuration::environment('production');
						}else{
							Braintree_Configuration::environment('sandbox');
						}
						
						
						
						Braintree_Configuration::merchantId($braintree_merchant_id);
						Braintree_Configuration::publicKey($braintree_public_key);
						Braintree_Configuration::privateKey($braintree_private_key);
						
			
						$clientToken = Braintree_ClientToken::generate();*/
						
						include("./vendor/lib/Braintree.php");
							//$this->load->library('Braintree');
							
							$gateway = new Braintree_Gateway([
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
							]);
							$gateway = new Braintree\Gateway($braintree_config);
						
							$clientToken = $gateway->clientToken()->generate();
							
							/*$collection = $gateway->creditCardVerification()->search([
											  Braintree_CreditCardVerificationSearch::creditCardCardholderName()->is($card_info['cardholderName']),
											  Braintree_CreditCardVerificationSearch::creditCardExpirationDate()->is($card_info['expirationMonth'].'/2017'),
											  Braintree_CreditCardVerificationSearch::creditCardNumber()->startsWith("4111"),
											  Braintree_CreditCardVerificationSearch::creditCardNumber()->endsWith("1111"),
											 //Braintree_CreditCardVerificationSearch::creditCardCardType()->is(Braintree_CreditCard::VISA),
											  //Braintree_CreditCardVerificationSearch::creditCardExpirationDate()->is("02/16"),
											]);
											
							foreach($collection as $verification) {
								echo 'verification===>'.$verification->status;
							}
							echo '<pre>card_info'; print_r($card_info); 
							echo '<pre>collection'; print_r($collection); die;*/
							
						
						//8fdb993b-7b8a-00cd-1e26-e36880ed750c
						//$paymentMethod = Braintree_PaymentMethod::find('57a2cc32-a8e9-0f0a-15a0-70da8c8609c3');
						//$result = Braintree_PaymentMethodNonce::create('57a2cc32-a8e9-0f0a-15a0-70da8c8609c3');
						//echo '<pre>paymentMethod'; print_r($paymentMethod); die;
						//$nonce = $result->paymentMethodNonce->nonce;

						//ba184238-9d7c-0962-1cd9-6143d133eda6
						//57a2cc32-a8e9-0f0a-15a0-70da8c8609c3
						
						$payment_method_nonce = isset($_POST['payment_method_nonce']) ? $_POST['payment_method_nonce'] : '';
						
						
						$nonceFromTheClient = $payment_method_nonce;
						
						
						
						$result = $gateway->customer()->create([
							'firstName' => $_POST['name'],
							'lastName' => $_POST['last_name'],
							'creditCard' => $card_info,
							'paymentMethodNonce' => $nonceFromTheClient
						]);
						//echo '<pre>result'; print_r($result); die;
						$clientId = '';
						$clientToken = '';
						$payment_result = array();
						$paymentError = '';
						if ($result->success) {
							
								 $clientId = $result->customer->id;
								 $clientToken = $result->customer->paymentMethods[0]->token;
								 
								 $payment_result = $gateway->transaction()->sale(['amount'=>$_POST['amount'],
									//'creditCard'=>$card_info,
									'orderId' => 'trial offer',
									'customer' => [
											'firstName' => $_POST['name'],
											'lastName' => $_POST['last_name'],
											'email' => $_POST['email'],
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
						//$paymentMethod = Braintree_PaymentMethod::find($clientToken);
						
							
						
						
						//echo '<pre>'; print_r($payment_result); die;
			
			/**********************************************/
			
		
		
		/// <end code for brain tree//
		
	//remove this line. i have used this just print the response array

	

	//$auth_response = $transaction->authorizeAndCapture ();

	

	/** Insert Data in order table **/

	$insertOrder = array();

	$insertOrder['name'] = $_POST['name'];

	$insertOrder['last_name'] = $_POST['last_name'];
	
	$insertOrder['address'] = isset($_POST['address']) ? $_POST['address'] : '';

	$insertOrder['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';

	$insertOrder['city'] = isset($_POST['city']) ? $_POST['city'] : '';

	$insertOrder['state'] = isset($_POST['state']) ? $_POST['state'] : '';

	$insertOrder['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';

	$insertOrder['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';

	

	$insertOrder['amount'] = $_POST['amount'];

	$insertOrder['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0;

	$insertOrder['location_id'] = $_POST['location_id'];

	$insertOrder['email'] = $_POST['email'];

	//$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

	$insertOrder['trial_id'] = $_POST['trial_id'];

	$insertOrder['trans_status'] = 'failed';

	$insertOrder['offer_type'] = 'Paid';
	
	$insertOrder['ip_address'] =isset($_POST['ip_address']) ? $_POST['ip_address'] : '';
	$insertOrder['gdpr_compliant_checkbox'] =isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : 0;

	$insertOrder['created'] = date('Y-m-d h-i-s');
	$insertOrder['client_id'] = $clientId;
	$insertOrder['client_token'] = $clientToken;
	$insertOrder['last_order_id'] = 0;
	$insertOrder['coupon_code'] = $coupon_code;
	$insertOrder['coupon_discount'] = $coupon_discount;
	$insertOrder['is_unique_trial'] = $this->query_model->isUniqueSpecialOffer();
	$insertOrder['child_name'] =(isset($_POST['child_name']) && !empty($_POST['child_name'])) ? $_POST['child_name'] : '';
	$insertOrder['child_age'] =(isset($_POST['child_age']) && !empty($_POST['child_age'])) ? $_POST['child_age'] : '';
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];

	$this->query_model->insertData('tblorders', $insertOrder);

	$order_id = $this->db->insert_id();
		if(!empty($order_id)){
		$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
		
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
		
		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$offer_detail = $this->query_model->getbySpecific("$tblspecialoffer", 'id' , $_POST['trial_id']);
		$trial_offer_name = !empty($offer_detail) ? $offer_detail[0]->offer_title : '';
		$trial_offer_amount = (!empty($offer_detail) && $offer_detail[0]->trial == 1) ? $site_currency_type.$offer_detail[0]->amount : '';
		$extraContentArr  = array('paymentResult' => $paymentResult,'trial_offer_name' => $trial_offer_name, 'trial_offer_amount' => $trial_offer_amount, 'trial_offer_type'=> 'PAID','trial_coupon_name' => $coupon_code,'trial_coupon_discount' => $coupon_discount);	
		
		$this->query_model->checkFormModuleApplyAPI($_POST);		
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'paid_trial',$extraContentArr);
		
	
	if (isset($payment_result->success) && !empty($payment_result->success)) 
	{
		
			if($payment_result->transaction->id)
				{
					
					//payment submitForSettlement 
						$sattlement_result = $gateway->transaction()->submitForSettlement($payment_result->transaction->id);
						//echo '<pre>sattlement_result'; print_r($sattlement_result); die;
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
					$insertTransaction['payment_type'] = "trial_offer";
			
					$this->query_model->insertData('tbl_transaction', $insertTransaction);
			
					
			
					$orderUpdate = array('trans_status' => 'Success');
			
					$this->query_model->update('tblorders', $order_id, $orderUpdate);
			
					
					
					
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
								$phone = $_POST['phone'];
								$message = 'Payment Success';
								$program = $_POST['program_id'];
			
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
						if(isset($emailAutoResponder['admin_email'])){
							
							$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiple_loc[0]->field_value == 1){
								$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
								$text_address = $loc_detail[0]->text_address;
							}else{
								$loc_detail = $this->query_model->getMainLocation("tblcontact");
								$text_address = $loc_detail[0]->text_address;
							}
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'paid_trial',$extraContentArr);
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
								if(!empty($replyEmailId)){
									$this->email->reply_to($replyEmailId);
								}
								if(!empty($cc_email)){
									$this->email->bcc($cc_email);
								}
			
								$this->email->to($text_address);
			
								$this->email->subject($type);
			
								/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';							
								$mes .= "<br/>";	*/
								
								//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
			
								$this->email->message($mes);
			
								$this->email->send();
							}
								
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
							
							
							// Mail to admin (Payment Success)
							
								
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
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
							}
								
			
								// send email to websitedojo.com
			
								/*$this->email->initialize($config);
			
								$this->email->from($email);
			
								$this->email->to('leads@websitedojo.com');
			
								$this->email->subject($type);
			
								$this->email->message($mes);					
			
								$this->email->send(); */
			
								
			
								
			
						// Email to user (Payment Success)
						if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){								$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';											$cont = "Payment Received! <br>Thank you, your trial was successfully started. A representative from our school will contact you shortly with more information."; 											$config['charset'] = 'UTF-8';											$config['wordwrap'] = TRUE;											$config['mailtype']="html";											$this->email->initialize($config);											$from_email=trim($this->config->item('email_from'));																					
						/*if(!empty($from_email)){												$this->email->from($from_email,$school_name);											}else{							$this->email->from($site_email,$school_name);	
						} */

						$this->email->from($noreply_email_address, $school_name);
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								
						//$this->email->reply_to($reply_to_add);								
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
			
					//$results['error_message'] = "<h1 class='payment_result'>Payment Received!</h1><p class='payment_result'>A representative from our school will contact you shortly with more information to start your trial.</p>";
						$_POST['order_id'] = $order_id;
						$thankYouPageDetail = $this->query_model->getFormModuleThankYouPage($_POST, 'paid');
						//redirect(@base_url().'starttrial/thankyou');
						$trial_offer_thankyou_url = $this->query_model->getTrialOfferThankyouUrl($_POST);
							redirect(@base_url().$trial_offer_thankyou_url);
				
							}
							
							
							
	}else{
	
		

		//Fail 
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
					$phone = $_POST['phone'];
					$message = $this->query_model->getStaticTextTranslation('payment_failure');
					$program = $_POST['program_id'];

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
			if(isset($emailAutoResponder['admin_email'])){	
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'paid_trial',$extraContentArr);
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
					if(!empty($replyEmailId)){
						$this->email->reply_to($replyEmailId);
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
					if(!empty($replyEmailId)){
						$this->email->reply_to($replyEmailId);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}

					$this->email->to($site_email);

					$this->email->subject($type);

															$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';					$mes .= "<br/>";					
															//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';	
																	
						$this->email->message($mes);
					$this->email->send();
			}

					// send email to websitedojo.com

				/*	$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

			// Email to user (Payment Failure)

							if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
							$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';	
							$cont = "Thank you, your request was accepted! A representative from our school will contact you shortly with more information."; 					$config['charset'] = 'UTF-8';	
							$config['wordwrap'] = TRUE;		
							$config['mailtype']="html";		
							$this->email->initialize($config);	
							$from_email=trim($this->config->item('email_from'));
							/*if(!empty($from_email)){	
							$this->email->from($from_email,$school_name);	
							}else{		
							$this->email->from($site_email,$school_name);	
							}	 */
							$this->email->from($noreply_email_address, $school_name);
							
							$this->email->reply_to($noreply_email_address, $school_name);
							$this->email->to($email);	
							$this->email->subject($type);
							$mes  = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';					
							//$mes .= "<br/>";					
							$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';					$this->email->message($mes);					$this->email->send();					}
				
				
				$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$p_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
			/************************************************************************************************************************/

	
	
	
	}
	
	//echo $results['error_message']; die;
	
		//$this->load->view('payement_result', $results);
		if(isset($results['result']) && $results['result'] == 0){
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 9);
			
			$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
			
			$this->load->view("upsell_thankyou_page", $results);
		}
		
		
		}

	}
	
	
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


		$program = $_POST['program'];

		/*********RainMark Code ******/
	
		$this->query_model->saveWebLeadsOnRainMark($_POST);
		
		

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
			$insertOrder['created'] = date('Y-m-d h-i-s');
			
			$this->query_model->insertData('tblorders', $insertOrder);	


					$this->load->library("email");

					$query = $this->query_model->getbyTable('tblsite');

					foreach($query as $row):

					//	$site_email = trim($row->email);

						$school_name = $row->title;

					endforeach;

					$multi_calendar_qry = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_location'");
				$multi_calendar_result = $multi_calendar_qry->result();
				$multi_calendar = $multi_calendar_result[0];				 
				
				
				
			
					include_once 'MailChimp.php';
					
					if (!empty($name) || !empty($email)) {
						
						$name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
						$email = filter_var($email, FILTER_SANITIZE_EMAIL);
						
						/*
						 * Place here your validation and other code you're using to process your contact form.
						*/
						$mc = new \Drewm\MailChimp($mailchimp_api_key);
						
						$mvars = array('optin_ip'=> $_SERVER['REMOTE_ADDR'], 'FNAME' => $name,'LNAME'=>$last_name,'TRIALOFFER' =>'FREE','PROGRAM' =>$program,'SCHOOL' =>$location_data['name']);
						
						$result = $mc->call('lists/subscribe', array(
								'id'                => $mailchimp_template_id,
								'email'             => array('email'=>$email),
								'merge_vars'        => $mvars,
								'double_optin'      => false,
								'send_welcome'      => false
							)
						);
				
					
					
					
						if($site_setting[0]->third_party_tiral_url_type == 1 && !empty($site_setting[0]->third_party_trial_url)){
							redirect($site_setting[0]->third_party_trial_url);
						}else{
							redirect($_SERVER['HTTP_REFERER']);
						}
					
					
					
					}
					
					
					
					//redirect(@base_url().'starttrialsent?status=suc&mode=free');


	}
	
	
	/**
	* Student Section Login 
	* from header front pages
	* checkstudentlogin work on jquey onclick event
	* and checkstudentloginToEnterKey work on enter press
	**/
	
	public function checkstudentlogin(){
			if(isset($_POST['password'])){
				$password  =md5($_POST['password']);
				$location_id  =isset($_POST['location_id']) ? $_POST['location_id'] : '';
				
				$multi_student_password = $this->query_model->getbySpecific("tblconfigcalendar",'id',15);
				$multi_student_password = !empty($multi_student_password) ? $multi_student_password[0]->field_value : 0;
				
				if($multi_student_password == 1){
					$checkpassword = $this->query_model->checkMultiStudentPassword('tblcontact', $password, $location_id);
				}else{
					$checkpassword = $this->query_model->checkStudentPassword('tbl_password_pro', $password);
				}
				
				if(!empty($checkpassword)){
					$student_session_login = array('student_session_login' => 1);
					$this->session->set_userdata($student_session_login);
					echo '1';
				} else{
					
					echo '0';
				}
				
			}
	}
	
	
	public function checkstudentloginToEnterKey(){
			if(isset($_POST['password'])){
				$password  =md5($_POST['password']);
				$location_id  =isset($_POST['location_id']) ? $_POST['location_id'] : '';
				
				$multi_student_password = $this->query_model->getbySpecific("tblconfigcalendar",'id',15);
				$multi_student_password = !empty($multi_student_password) ? $multi_student_password[0]->field_value : 0;
				
				if($multi_student_password == 1){
					$checkpassword = $this->query_model->checkMultiStudentPassword('tblcontact', $password, $location_id);
				}else{
					$checkpassword = $this->query_model->checkStudentPassword('tbl_password_pro', $password);
				}
				
				if(!empty($checkpassword)){
					$student_session_login = array('student_session_login' => 1);
					$this->session->set_userdata($student_session_login);
					$this->session->unset_userdata('error_message');
					redirect('studentsection');
				} else{
					//$error_message =  'Password is wrong. please try again';
					
					$this->session->set_userdata('error_message', 1);
					redirect(base_url());
				}
				
			}
	}
	
	
	
	
	/************************** Stripe Payment Gateway *************/
	


	public function stripePaymentbuyoffer() {
		
			if ( !isset($_POST['submit']) && empty($_POST['submit'] ) ) {
				redirect('online-special','refresh');
			}
			

			if($_POST['website'] != ''){

				die("An error occurred, please try again");

			}

			

			

		$data['page_title'] = 'Payment';


		if(isset($_POST['refferal'])){ 
				$this->session->set_userdata('refferal_url',$_POST['refferal']);
		}
			

			if(isset($_POST['trial_id'])){

				if(isset($_POST['location_id'])){

					$data['location_detail'] = $this->query_model->getbySpecific('tblcontact', 'id', $_POST['location_id']);

				} else{

					$data['location_detail'] = $this->query_model->getMainLocation();

				}

				
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$data['offer_detail'] = $this->query_model->getbySpecific("$tblspecialoffer",'id', $_POST['trial_id']);

				$data['offer_detail'] = $data['offer_detail'][0];

				

				$this->db->where("published", 1);
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");

				$data['site_setting'] = $this->query_model->getbyTable("tblsite");

				$this->load->view('stripe_payment_buyoffer', $data);

			} else{

				die("An error occurred, please try again");

			}

	}



	

	

public function stripe_payment_gateway(){
		$_POST['submit'] = 'Purchase Now';	
	//echo '<pre>'; print_r($_POST); die;
		if(isset($_POST['submit'])){
			$stripeData = $this->query_model->getStripePaymentKeys();
			if($stripeData['stripe_sca_payment'] == 0){
				if(!isset($_POST['credit_card_number']) || !isset($_POST['exp_month']) || !isset($_POST['exp_year']) || !isset($_POST['cvv'])){
					redirect('/site/page_not_found');
				}
			}
		
		$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
		$site_currency_type = $this->query_model->getSiteCurrencyType();
		//echo $currency_type.'==>'.$site_currency_type; die;
		/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		
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
		
		$_POST['location_id'] = $location_id;
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		
		$stripePaymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
		
		$stripe_payment = $stripePaymentDetail[0]->stripe_payment;
		$multi_stripe_check = $stripePaymentDetail[0]->multi_stripe_check;
		
		$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
		
		
		// SCA Payment //
		
		$payment_intent_status_result = 0;
		if($stripeData['stripe_payment'] == 1 && $stripeData['stripe_sca_payment'] == 1){
				
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$trialDetail = $this->query_model->getBySpecific("$tblspecialoffer",'id',$_POST['trial_id']);
				$trialTitle = !empty($trialDetail) ? $trialDetail[0]->offer_title : '';
					$invoiceid = mt_rand( 10000000, 99999999);                      // Invoice ID
					$description = 'Trial Offer:- '.$trialTitle;
					
				$paymentIntentResult = $this->query_model->retrive_payment_intent($_POST, $stripeData['stripe_secret_key'],$description);
				
				
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
			// normal stripe payment
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
		
			
			include("./vendor/Stripe.php");
			
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
				
				$params = array(
						"private_test_key" => $stripe_secret_key,
						"public_test_key"  => $stripe_publishable_key
					);	
				
				Stripe::setApiKey($params['private_test_key']);
				$pubkey = $params['public_test_key'];
				
				$payment_error = '';
				$card_error = 0;
				try{
					$generateToken = Stripe_Token::create(
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
				} catch(Stripe_CardError $e) {	
						
						$payment_error = $e->getMessage();
						$results['result'] = 0;
						$results['error_msg'] = $payment_error;
						$card_error = 1;
				}
				
				
				
				$stripeToken = isset($generateToken['id']) ? $generateToken['id'] : '';
				
				
				
				if(isset($stripeToken) && !empty($stripeToken) && $card_error == 0)
				{
				
					$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
					$trialDetail = $this->query_model->getBySpecific("$tblspecialoffer",'id',$_POST['trial_id']);
					$trialTitle = !empty($trialDetail) ? $trialDetail[0]->offer_title : '';
						$_POST['amount'] = number_format($_POST['amount'],2);
						$amount_cents = str_replace(".","",$_POST['amount']);  // Chargeble amount
						$invoiceid = mt_rand( 10000000, 99999999);                      // Invoice ID
						$description = 'Trial Offer:- '.$trialTitle;
					
					$customer = Stripe_Customer::create(array(
								'source'   => $stripeToken,
								'email'    => $_POST['form_email_2'],
								'description'     => $description,
								//'account_balance' => $amount_cents,
							)
						);
					
					$clientId = !empty($customer) ? $customer->id : '';
					$clientToken = $stripeToken;
					
					
					try {
						
							
						$payment_result = Stripe_Charge::create(array(		 
							  "amount" => $amount_cents,
							  "currency" => $currency_type,
							 // "source" => $stripeToken,
							   "customer" => $clientId,
							   "receipt_email" => $_POST['form_email_2'],
							  "description" => $description)			  
						);
					
						// Payment has succeeded, no exceptions were thrown or otherwise caught				
						if(!empty($payment_result)){
							if(isset($payment_result->balance_transaction) && $payment_result->balance_transaction != ''){	
								$balance_transaction = $payment_result->balance_transaction;
								$payment_status = $payment_result->status;
							}
						}
						
					} catch(Stripe_CardError $e) {			

						$payment_error = $e->getMessage();
					
					}
				}else{
					$results['result'] = 0;
					$results['error_msg'] = $payment_error;
					$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
				 }
	 
		}
		
					
			//	echo $payment_error; 
				//echo '<pre>payment_result'; print_r($payment_result); die;
					
			/**********************************************/
			
		
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
	echo $paymentResult;*/
	//echo $payment_status_code.'===>'.$payment_status_type; die;
	

	/** Insert Data in order table **/

	$insertOrder = array();

	$insertOrder['name'] = $_POST['name'];

	$insertOrder['last_name'] = $_POST['last_name'];

	$insertOrder['address'] = isset($_POST['address']) ? $_POST['address'] : '';

	$insertOrder['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';

	$insertOrder['city'] = isset($_POST['city']) ? $_POST['city'] : '';

	$insertOrder['state'] = isset($_POST['state']) ? $_POST['state'] : '';

	$insertOrder['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';

	$insertOrder['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';

	

	$insertOrder['amount'] = $_POST['amount'];

	$insertOrder['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0; 

	$insertOrder['location_id'] = $_POST['location_id'];

	$insertOrder['email'] = $_POST['email'];

	//$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

	$insertOrder['trial_id'] = $_POST['trial_id'];

	$insertOrder['trans_status'] = $payment_status_type;

	$insertOrder['offer_type'] = 'Paid';

	$insertOrder['created'] = date('Y-m-d h-i-s');
	
	$insertOrder['ip_address'] =isset($_POST['ip_address']) ? $_POST['ip_address'] : '';
	$insertOrder['gdpr_compliant_checkbox'] =isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : 0;

	$insertOrder['client_id'] = $clientId;
	$insertOrder['client_token'] = $clientToken;
	$insertOrder['last_order_id'] = 0;
	$insertOrder['coupon_code'] = $coupon_code;
	$insertOrder['coupon_discount'] = $coupon_discount;
	$insertOrder['is_unique_trial'] = $this->query_model->isUniqueSpecialOffer();
	$insertOrder['child_name'] =(isset($_POST['child_name']) && !empty($_POST['child_name'])) ? $_POST['child_name'] : '';
	$insertOrder['child_age'] =(isset($_POST['child_age']) && !empty($_POST['child_age'])) ? $_POST['child_age'] : '';
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
	//echo '<pre>insertOrder'; print_r($insertOrder);
	$this->query_model->insertData('tblorders', $insertOrder);
//die('pass');
	$order_id = $this->db->insert_id();
		if(!empty($order_id)){
		$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
		
	}

		/*		
		* checkFormModuleApplyAPI 						
		* this function for using apis according form model 						
		*/	
		
		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$offer_detail = $this->query_model->getbySpecific("$tblspecialoffer", 'id' , $_POST['trial_id']);
		$trial_offer_name = !empty($offer_detail) ? $offer_detail[0]->offer_title : '';
		$trial_offer_amount = (!empty($offer_detail) && $offer_detail[0]->trial == 1) ? $site_currency_type.$offer_detail[0]->amount : '';
		$extraContentArr  = array('paymentResult' => $paymentResult,'trial_offer_name' => $trial_offer_name, 'trial_offer_amount' => $trial_offer_amount, 'trial_offer_type'=> 'PAID','trial_coupon_name' => $coupon_code,'trial_coupon_discount' => $coupon_discount);	
		
		
		$this->query_model->checkFormModuleApplyAPI($_POST);		
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'paid_trial',$extraContentArr);

		
		
	
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
					$insertTransaction['payment_type'] = "trial_offer";
			
					$this->query_model->insertData('tbl_transaction', $insertTransaction);
			
					
			
					/*$orderUpdate = array('trans_status' => 'Success');
			
					$this->query_model->update('tblorders', $order_id, $orderUpdate);*/
			
					
					
					
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
								$phone = $_POST['phone'];
								$message = 'Payment Success';
								$program = $_POST['program_id'];
			
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
						if(isset($emailAutoResponder['admin_email'])){	
							$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiple_loc[0]->field_value == 1){
								$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
								$text_address = $loc_detail[0]->text_address;
							}else{
								$loc_detail = $this->query_model->getMainLocation("tblcontact");
								$text_address = $loc_detail[0]->text_address;
							}
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'paid_trial',$extraContentArr);
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
								if(!empty($replyEmailId)){
									$this->email->reply_to($replyEmailId);
								}
								if(!empty($cc_email)){
									$this->email->bcc($cc_email);
								}
			
								$this->email->to($text_address);
			
								$this->email->subject($type);
			
								/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
								$mes .= "<br/>";	*/							
								//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
			
								$this->email->message($mes);
			
								$this->email->send();
							}
								
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
							
							
							// Mail to admin (Payment Success)
							
								
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
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
						}
								
			
								// send email to websitedojo.com
			
								/*$this->email->initialize($config);
			
								$this->email->from($email);
			
								$this->email->to('leads@websitedojo.com');
			
								$this->email->subject($type);
			
								$this->email->message($mes);					
			
								$this->email->send(); */
			
								
			
								
			
						// Email to user (Payment Success)
		if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
		$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
		$cont = "Payment Received! <br>Thank you, your trial was successfully started. A representative from our school will contact you shortly with more information."; 
		
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
		//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								
		//$this->email->reply_to($reply_to_add);								
		$this->email->reply_to($noreply_email_address, $school_name);																$this->email->to($email);											$this->email->subject($type);																			$mes  = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';								
		//$mes .= "<br/>";								
		$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';								$this->email->message($mes);											$this->email->send();
					}
					/***********/
			
					//$results['error_message'] = "<h1 class='payment_result'>Payment Received!</h1><p class='payment_result'>A representative from our school will contact you shortly with more information to start your trial.</p>";
				
						$_POST['order_id'] = $order_id;
						$thankYouPageDetail = $this->query_model->getFormModuleThankYouPage($_POST, 'paid');
						//redirect(@base_url().'starttrial/thankyou');
				
						$trial_offer_thankyou_url = $this->query_model->getTrialOfferThankyouUrl($_POST);
							redirect(@base_url().$trial_offer_thankyou_url);
							}
							
							
							
	}else{
	
		

		//Fail 
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
					$phone = $_POST['phone'];
					$message = $this->query_model->getStaticTextTranslation('payment_failure');
					$program = $_POST['program_id'];

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
				if(isset($emailAutoResponder['admin_email'])){
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'paid_trial',$extraContentArr);
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
					if(!empty($replyEmailId)){
						$this->email->reply_to($replyEmailId);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}
					$this->email->to($text_address);
					$this->email->subject($type);
					/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';					
					$mes .= "<br/>";	*/				
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
					
				}

					// send email to websitedojo.com

					/*$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

			// Email to user (Payment Failure)

							if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){					$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';					$cont = "Thank you, your request was accepted! A representative from our school will contact you shortly with more information."; 					$config['charset'] = 'UTF-8';					$config['wordwrap'] = TRUE;					$config['mailtype']="html";					$this->email->initialize($config);					$from_email=trim($this->config->item('email_from'));										
							/*if(!empty($from_email)){						$this->email->from($from_email,$school_name);					}else{						$this->email->from($site_email,$school_name);	
							} */
							
							$this->email->from($noreply_email_address, $school_name);
							$this->email->reply_to($noreply_email_address, $school_name);										$this->email->to($email);					$this->email->subject($type);																						$mes  = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';					
						//	$mes .= "<br/>";					
							$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';					$this->email->message($mes);					$this->email->send();					}
				
				
				$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">'.$payment_error.'<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
		
			/************************************************************************************************************************/

	
	
	
	}
	
	
	
		
		//$this->load->view('payement_result', $results);
		if(isset($results['result']) && $results['result'] == 0){
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 9);
			
			$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
			
			$this->load->view("upsell_thankyou_page", $results);
		}
		
	
		}

	}
	
	
	

	

	

	

public function stripe_ideal_payment_gateway(){
		$_POST['submit'] = 'Purchase Now';	
	//echo '<pre>'; print_r($_POST); die;
		if(isset($_POST['submit'])){
			
			if(!isset($_POST['account_holder_name']) || !isset($_POST['bank_name'])){
				redirect('/site/page_not_found');
			}
		// checking hunney Post
		$this->query_model->checkHunneyPost($_POST);
		$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
		$site_currency_type = $this->query_model->getSiteCurrencyType();
		
		
		

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
		
		$_POST['location_id'] = $location_id;
		
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
				$owner_email = isset($_POST['form_email_2']) ? $_POST['form_email_2'] : '';
				$owner_phone = isset($_POST['phone']) ? $_POST['phone'] : '';
				$owner_bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : '';
				$_POST['amount'] = number_format($_POST['amount'],2);
				$amount_cents = str_replace(".","",$_POST['amount']);  // Chargeble amount
					
				$createSource = \Stripe\Source::create([
				  "type" => "ideal",
				  "amount" => $amount_cents,
				  "currency" => "eur",
				  "ideal" => [
					'bank' => $owner_bank_name
					],
				"redirect" => [
					'return_url' => base_url().'payment/mwalteSpIdlPymSvdj'
					//'return_url' => base_url().'payment/stripe_ideal_payment_webhook'
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
			
			
			if(!empty($createSource)){
				//echo '<pre>createSource'; print_r($createSource); die;
				
				$stripeIdealFormData = array('stripeIdealFormData' => $_POST);
				
				$this->session->set_userdata($stripeIdealFormData);
				
				if(isset($createSource->redirect->url) && !empty($createSource->redirect->url)){
					redirect($createSource->redirect->url);
				}
			}
		}

	}
	
	
	
public function mwalteSpIdlPymSvdj(){
	
	$source_id = (isset($_GET['source']) && !empty($_GET['source'])) ? $_GET['source'] : '';
	
	$_POST = $this->session->userdata('stripeIdealFormData');
	
	$this->session->unset_userdata('stripeIdealFormData');
	
	if(isset($_POST['submit'])){
		
		if(!isset($_POST['account_holder_name']) || !isset($_POST['bank_name'])){
			redirect('/site/page_not_found');
		}
		
		// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
		if(!empty($source_id)){
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
					  "currency" => "eur",
					  "source" => $source_id,
					]);
				} catch(Stripe_CardError $e) {			

						$payment_error = $e->getMessage();
					
				} 
			}
			
		//echo '<pre>payment_result'; print_r($payment_result); die;	
			
			$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		
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
		
		$_POST['location_id'] = $location_id;
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		
			$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
			
			
				
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
			
			
			$insertOrder = array();

			$insertOrder['name'] = $_POST['name'];

			$insertOrder['last_name'] = $_POST['last_name'];

			$insertOrder['address'] = isset($_POST['address']) ? $_POST['address'] : '';

			$insertOrder['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';

			$insertOrder['city'] = isset($_POST['city']) ? $_POST['city'] : '';

			$insertOrder['state'] = isset($_POST['state']) ? $_POST['state'] : '';

			$insertOrder['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';

			$insertOrder['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';

			

			$insertOrder['amount'] = $_POST['amount'];

			$insertOrder['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0; 

			$insertOrder['location_id'] = $_POST['location_id'];

			$insertOrder['email'] = $_POST['email'];

			//$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

			$insertOrder['trial_id'] = $_POST['trial_id'];

			$insertOrder['trans_status'] = $payment_status_type;

			$insertOrder['offer_type'] = 'Paid';

			$insertOrder['created'] = date('Y-m-d h-i-s');
			
			$insertOrder['ip_address'] =isset($_POST['ip_address']) ? $_POST['ip_address'] : '';
			$insertOrder['gdpr_compliant_checkbox'] =isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : 0;

			$insertOrder['client_id'] = $clientId;
			$insertOrder['client_token'] = $clientToken;
			$insertOrder['last_order_id'] = 0;
			$insertOrder['coupon_code'] = $coupon_code;
			$insertOrder['coupon_discount'] = $coupon_discount;
			$insertOrder['source_id'] = $source_id;
			$insertOrder['is_unique_trial'] = $this->query_model->isUniqueSpecialOffer();
			$insertOrder['child_name'] =(isset($_POST['child_name']) && !empty($_POST['child_name'])) ? $_POST['child_name'] : '';
			$insertOrder['child_age'] =(isset($_POST['child_age']) && !empty($_POST['child_age'])) ? $_POST['child_age'] : '';
			$ipAddress = $this->query_model->getCountryNameToIpAddress();
			$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
			$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
			
			$this->query_model->insertData('tblorders', $insertOrder);

			$order_id = $this->db->insert_id();
				if(!empty($order_id)){
				$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
				
			}

				/*		
				* checkFormModuleApplyAPI 						
				* this function for using apis according form model 						
				*/	
				
				
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$offer_detail = $this->query_model->getbySpecific("$tblspecialoffer", 'id' , $_POST['trial_id']);
				$trial_offer_name = !empty($offer_detail) ? $offer_detail[0]->offer_title : '';
				$trial_offer_amount = (!empty($offer_detail) && $offer_detail[0]->trial == 1) ? $site_currency_type.$offer_detail[0]->amount : '';
				$extraContentArr  = array('paymentResult' => $paymentResult,'trial_offer_name' => $trial_offer_name, 'trial_offer_amount' => $trial_offer_amount, 'trial_offer_type'=> 'PAID','trial_coupon_name' => $coupon_code,'trial_coupon_discount' => $coupon_discount);	
				
				
				$this->query_model->checkFormModuleApplyAPI($_POST);		
				$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
				//echo '<pre>emailAutoResponder'; print_R($emailAutoResponder); die;
				// sending msg by twillio api
				$this->query_model->connectFormToTwillioAPi($_POST,'paid_trial',$extraContentArr);

				
				
	if ($payment_status_code == 1) 
	{
			if($payment_result->balance_transaction)
				{
					$results['result'] = 1;
					$braintreeCode=$payment_result->balance_transaction;
					
			
					$ptid = $braintreeCode;
			
					
			
					//$ptidmd5 = $response_array[7];
			
					
			
					//echo $ptid."=====>".$ptidmd5; die;
			
			
					//2250745842=====>
			
					$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $ptid;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					$insertTransaction['payment_type'] = "trial_offer";
			
					$this->query_model->insertData('tbl_transaction', $insertTransaction);
			
					
			
					$orderUpdate = array('trans_status' => $payment_status_type);
			
					$this->query_model->update('tblorders', $order_id, $orderUpdate);
			
					
					
					
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
								$phone = $_POST['phone'];
								$message = 'Payment Success';
								$program = $_POST['program_id'];
			
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
						if(isset($emailAutoResponder['admin_email'])){
							
							$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiple_loc[0]->field_value == 1){
								$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
								$text_address = $loc_detail[0]->text_address;
							}else{
								$loc_detail = $this->query_model->getMainLocation("tblcontact");
								$text_address = $loc_detail[0]->text_address;
							}
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'paid_trial',$extraContentArr);
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
								if(!empty($replyEmailId)){
									$this->email->reply_to($replyEmailId);
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
							
								
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
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
							}
								
			
								// send email to websitedojo.com
			
								/*$this->email->initialize($config);
			
								$this->email->from($email);
			
								$this->email->to('leads@websitedojo.com');
			
								$this->email->subject($type);
			
								$this->email->message($mes);					
			
								$this->email->send(); */
			
								
			
								
			
						// Email to user (Payment Success)
						if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){								$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';											$cont = "Payment Received! <br>Thank you, your trial was successfully started. A representative from our school will contact you shortly with more information."; 											$config['charset'] = 'UTF-8';											$config['wordwrap'] = TRUE;											$config['mailtype']="html";											$this->email->initialize($config);											$from_email=trim($this->config->item('email_from'));																					
						/*if(!empty($from_email)){												$this->email->from($from_email,$school_name);											}else{							$this->email->from($site_email,$school_name);	
						} */

						$this->email->from($noreply_email_address, $school_name);
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								
						//$this->email->reply_to($reply_to_add);								
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
			
					//$results['error_message'] = "<h1 class='payment_result'>Payment Received!</h1><p class='payment_result'>A representative from our school will contact you shortly with more information to start your trial.</p>";
						$_POST['order_id'] = $order_id;
						$thankYouPageDetail = $this->query_model->getFormModuleThankYouPage($_POST, 'paid');
						//redirect(@base_url().'starttrial/thankyou');
						$trial_offer_thankyou_url = $this->query_model->getTrialOfferThankyouUrl($_POST);
							redirect(@base_url().$trial_offer_thankyou_url);
				
							}
							
							
							
	}else{
	
		

		//Fail 
		$results['result'] = 0;
		$results['error_msg'] = 'FAILED';
		$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">FAILED<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
		
		//echo '<pre>results'; print_r($results); die;
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
					$phone = $_POST['phone'];
					$message = $this->query_model->getStaticTextTranslation('payment_failure');
					$program = isset($_POST['program_id']) ? $_POST['program_id'] : 0;

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
			if(isset($emailAutoResponder['admin_email'])){	
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'paid_trial',$extraContentArr);
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
					if(!empty($replyEmailId)){
						$this->email->reply_to($replyEmailId);
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
					if(!empty($replyEmailId)){
						$this->email->reply_to($replyEmailId);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}

					$this->email->to($site_email);

					$this->email->subject($type);

															$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';					$mes .= "<br/>";					
															//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';	
																	
						$this->email->message($mes);
					$this->email->send();
			}

					// send email to websitedojo.com

				/*	$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type);

					$this->email->message($mes);					

					$this->email->send(); */

					

					

			// Email to user (Payment Failure)

							if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
							$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';	
							$cont = "Thank you, your request was accepted! A representative from our school will contact you shortly with more information."; 					$config['charset'] = 'UTF-8';	
							$config['wordwrap'] = TRUE;		
							$config['mailtype']="html";		
							$this->email->initialize($config);	
							$from_email=trim($this->config->item('email_from'));
							/*if(!empty($from_email)){	
							$this->email->from($from_email,$school_name);	
							}else{		
							$this->email->from($site_email,$school_name);	
							}	 */
							$this->email->from($noreply_email_address, $school_name);
							
							$this->email->reply_to($noreply_email_address, $school_name);
							$this->email->to($email);	
							$this->email->subject($type);
							$mes  = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';					
							//$mes .= "<br/>";					
							$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';					$this->email->message($mes);					$this->email->send();					}
				
				
				$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">Failed<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
			/************************************************************************************************************************/

	
	
	
	}
	
			//echo $results['error_message']; die;
			
				//$this->load->view('payement_result', $results);
				if(isset($results['result']) && $results['result'] == 0){
					$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 9);
					
					$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
					
					$this->load->view("upsell_thankyou_page", $results);
				}
					
				}
				
				
		}
	}else{
		die("Something went wrong. Please try again!");
	}
	
}
	
	public function stripe_ideal_payment_webhook(){
		
		$source_id = (isset($_GET['source']) && !empty($_GET['source'])) ? $_GET['source'] : '';
		
		if(!empty($source_id)){
			
			$orderDetail = $this->query_model->getBySpecific('tblorders', 'source_id',$source_id);
			
			if(!empty($orderDetail)){
				$orderDetail = $orderDetail[0];
				$payment_status = strtolower($orderDetail->trans_status);
				//$payment_status = 'pending';
				$paymentStatusArr = array('succeeded','paid','success','successful');
				
				if(in_array($payment_status,$paymentStatusArr)){
					// just checking
				}else{
					$_POST = array();
					$_POST['name'] = $orderDetail->name;
					$_POST['last_name'] = $orderDetail->last_name;
					$_POST['form_email_2'] = $orderDetail->email;
					$_POST['email'] = $orderDetail->email;
					$_POST['phone'] = $orderDetail->phone;
					$_POST['location_id'] = $orderDetail->location_id;
					$_POST['program_id'] = $orderDetail->program_id;
					$_POST['trial_offer_cat_id'] = $orderDetail->trial_cat_id;
					$_POST['trial_id'] = $orderDetail->trial_id;
					$_POST['coupon_code'] = $orderDetail->coupon_code;
					$_POST['coupon_discount'] = $orderDetail->coupon_discount;
					$_POST['amount'] = $orderDetail->amount;
					$_POST['child_name'] = $orderDetail->child_name;
					$_POST['child_age'] = $orderDetail->child_age;
					$_POST['page_url'] = '/payment/stripeIdealPaymentbuyoffer';
					$_POST['refferal'] = base_url();
					$order_id = $orderDetail->id;
					
					
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
					//echo '<pre>sourceData'; print_r($sourceData); die;
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
							  "currency" => "eur",
							  "source" => $source_id,
							]);
						} catch(Stripe_CardError $e) {			

								$payment_error = $e->getMessage();
							
						} 
					}
					
				//echo '<pre>paymentResult'; print_r($sourceData); die;
				
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		
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
		
		$_POST['location_id'] = $location_id;
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
		$coupon_discount = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
		
		
			$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
			
			
				
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
			
			
			$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
			$offer_detail = $this->query_model->getbySpecific("$tblspecialoffer", 'id' , $_POST['trial_id']);
		
				$trial_offer_name = !empty($offer_detail) ? $offer_detail[0]->offer_title : '';
				$trial_offer_amount = (!empty($offer_detail) && $offer_detail[0]->trial == 1) ? $site_currency_type.$offer_detail[0]->amount : '';
				$extraContentArr  = array('paymentResult' => $paymentResult,'trial_offer_name' => $trial_offer_name, 'trial_offer_amount' => $trial_offer_amount, 'trial_offer_type'=> 'PAID','trial_coupon_name' => $coupon_code,'trial_coupon_discount' => $coupon_discount);	
				
				
				$this->query_model->checkFormModuleApplyAPI($_POST);		
				$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
				//echo '<pre>emailAutoResponder'; print_R($emailAutoResponder); die;
				// sending msg by twillio api
				$this->query_model->connectFormToTwillioAPi($_POST,'paid_trial',$extraContentArr);
				
				
							
	if ($payment_status_code == 1) 
	{
			if($payment_result->balance_transaction)
				{
					$results['result'] = 1;
					$braintreeCode=$payment_result->balance_transaction;
					
			
					$ptid = $braintreeCode;
			
			
					/*$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $ptid;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					$insertTransaction['payment_type'] = "trial_offer";
			
					$this->query_model->insertData('tbl_transaction', $insertTransaction);*/
			
					
			
					$orderUpdate = array('trans_status' => $payment_status_type);
			
					$this->query_model->update('tblorders', $order_id, $orderUpdate);
			
					
					
					
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
								$phone = $_POST['phone'];
								$message = 'Payment Success';
								$program = $_POST['program_id'];
			
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
						if(isset($emailAutoResponder['admin_email'])){
							
							$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiple_loc[0]->field_value == 1){
								$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
								$text_address = $loc_detail[0]->text_address;
							}else{
								$loc_detail = $this->query_model->getMainLocation("tblcontact");
								$text_address = $loc_detail[0]->text_address;
							}
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'mini_and_full_form');
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
								if(!empty($replyEmailId)){
									$this->email->reply_to($replyEmailId);
								}
								if(!empty($cc_email)){
									$this->email->bcc($cc_email);
								}
			
								$this->email->to($text_address);
			
								$this->email->subject($type);
			
								/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
								$mes .= "<br/>";	*/							
								//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
			
								$this->email->message($mes);
			
								$this->email->send();
							}
								
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
							
							
							// Mail to admin (Payment Success)
							
								
								$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			
								$config['charset'] = 'UTF-8';
			
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
							}
								
			
								// send email to websitedojo.com
			
								/*$this->email->initialize($config);
			
								$this->email->from($email);
			
								$this->email->to('leads@websitedojo.com');
			
								$this->email->subject($type);
			
								$this->email->message($mes);					
			
								$this->email->send(); */
			
								
			
								
			
						// Email to user (Payment Success)
						if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){								$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';											$cont = "Payment Received! <br>Thank you, your trial was successfully started. A representative from our school will contact you shortly with more information."; 											$config['charset'] = 'UTF-8';											$config['wordwrap'] = TRUE;											$config['mailtype']="html";											$this->email->initialize($config);											$from_email=trim($this->config->item('email_from'));																					
						/*if(!empty($from_email)){												$this->email->from($from_email,$school_name);											}else{							$this->email->from($site_email,$school_name);	
						} */

						$this->email->from($noreply_email_address, $school_name);
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								
						//$this->email->reply_to($reply_to_add);								
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
			
					$results['error_message'] = "<h1 class='payment_result'>Payment Received!</h1><p class='payment_result'>A representative from our school will contact you shortly with more information to start your trial.</p>";
						//$_POST['order_id'] = $order_id;
						//$thankYouPageDetail = $this->query_model->getFormModuleThankYouPage($_POST, 'paid');
						//redirect(@base_url().'starttrial/thankyou');
			
				
							}
							
							
							
	}else{
	
		

		//Fail 
		$results['result'] = 0;
		$results['error_msg'] = 'FAILED';
		$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">FAILED<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
		
		//echo '<pre>results'; print_r($results); die;
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
					$phone = $_POST['phone'];
					$message = $this->query_model->getStaticTextTranslation('payment_failure');
					$program = isset($_POST['program_id']) ? $_POST['program_id'] : 0;

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
			if(isset($emailAutoResponder['admin_email'])){	
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'mini_and_full_form');
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
					if(!empty($replyEmailId)){
						$this->email->reply_to($replyEmailId);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}

					$this->email->to($text_address);
					$this->email->subject($type);
					/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';				
					$mes .= "<br/>";	*/				
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
					if(!empty($replyEmailId)){
						$this->email->reply_to($replyEmailId);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}

					$this->email->to($site_email);

					$this->email->subject($type);

						$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';					$mes .= "<br/>";					
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';	
																	
						$this->email->message($mes);
					$this->email->send();
			}

				

			// Email to user (Payment Failure)

							if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
							$type = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';	
							$cont = "Thank you, your request was accepted! A representative from our school will contact you shortly with more information."; 					$config['charset'] = 'UTF-8';	
							$config['wordwrap'] = TRUE;		
							$config['mailtype']="html";		
							$this->email->initialize($config);	
							$from_email=trim($this->config->item('email_from'));
							/*if(!empty($from_email)){	
							$this->email->from($from_email,$school_name);	
							}else{		
							$this->email->from($site_email,$school_name);	
							}	 */
							$this->email->from($noreply_email_address, $school_name);
							
							$this->email->reply_to($noreply_email_address, $school_name);
							$this->email->to($email);	
							$this->email->subject($type);
							$mes  = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';					
							//$mes .= "<br/>";					
							$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';					$this->email->message($mes);					$this->email->send();					}
				
				
				$results['error_message'] = '<h1 class="payment_result">'.$this->query_model->getStaticTextTranslation('payment_failure').'</h1>'.'<p class="payment_result">Failed<br>'.$this->query_model->getStaticTextTranslation('press_go_back_button').'</p>';
		
			
			}
	
	
		//echo '<pre>payment_result'; print_R($payment_result); 
		//echo '<pre>results'; print_R($results); die;
				// end source data
				}
					
					
					
					
					
					
					
				}
				
			}
			
		}
	}
	
}