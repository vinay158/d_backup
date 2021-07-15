<?php 

 require 'vendor/autoload.php';

				

				use net\authorize\api\contract\v1 as AnetAPI;

				use net\authorize\api\controller as AnetController;

					

if ( ! defined('BASEPATH')) exit('No direct script access allowed');







class Trial_upsells_payment extends CI_Controller {

function __construct(){

		parent::__construct();

		$this->load->model('upsells_order_model');

	}
	

public function authorized_payment_gateway($product_id = null){
	
		if (empty($_POST) ) {
			redirect(base_url());
		}
		
		$_POST['submit'] = 'Purchase Now';
		
		if(isset($_POST['submit'])){
			
			
			
			$sessionData = $this->session->userdata('thankyouPageDetail');
			
			$_POST['name'] = !empty($sessionData) ? $sessionData['postData']['name'] : '';
			$_POST['last_name'] = !empty($sessionData) ? $sessionData['postData']['last_name'] : '';
			$_POST['email'] = !empty($sessionData) ? $sessionData['postData']['form_email_2'] : '';
			$_POST['phone'] = !empty($sessionData) ? $sessionData['postData']['phone'] : '';
			$_POST['program_id'] = !empty($sessionData) ? $sessionData['postData']['program_id'] : '';
			
			$mainLocation = $this->query_model->getMainLocation();
			$_POST['location_id'] = (!empty($sessionData) && isset($sessionData['postData']['location_id'])) ?  $sessionData['postData']['location_id'] : $mainLocation[0]->id;
			
			$trial_id = !empty($sessionData) ? $sessionData['trial_id'] : '';
			$order_id = !empty($sessionData) ? $sessionData['order_id'] : '';
			$trial_type = !empty($sessionData) ? $sessionData['trial_type'] : '';
			
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
		
			$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
			$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
			$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
			$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
			$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : 0;
			
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
				
				$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
				$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales", 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				if(!empty($upsell_title)){
					$upsell_title = $this->query_model->str_replace_trial_upsells($upsell_title, $upsellDetail[0]->id);
				}
				$upsellTitleArr .= '<label>'.$upsell_title.'</label><br>';
				$upsellTitleOrderArr .= $upsell_title;
				}

			$i++;	
			}

			
		}
		//echo $upsellTitleOrderArr; die;
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$productDetail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $product_id);
		$product_title =  isset($productDetail[0]->offer_title) ? $productDetail[0]->offer_title : '';
		
		
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

		/*$address1 = $_POST['address'];
		
		$address2 = isset($_POST['address_line2'])? $_POST['address_line2'] : '';

		$city = urlencode($_POST['city']);

		$state =urlencode( $_POST['state']);

		$zip = urlencode($_POST['zip']); */
		
		$address1 = !empty($_POST['address']) ? urlencode($_POST['address']) : '';
		
		$address2 = !empty($_POST['address_line2'])? urlencode($_POST['address_line2']) : '';
		
		$city = !empty($_POST['city']) ? urlencode($_POST['city']) : '';

		$state =!empty($_POST['state']) ?  urlencode( $_POST['state']) : '';

		$zip = !empty($_POST['zip']) ? urlencode($_POST['zip']) : '';

		$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 1;

		$term_condition = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;
	
		//give the actual amount below

		$amount = $_POST['amount'];

		$currencyCode="USD";

		$paymentType="Trial";

		$date = $expDateMonth.$expDateYear;

	// create customer and payement
	
	/* $offerDetail = $this->query_model->getByID('tblspecialoffer' , $trial_id);
	$offer_title = !empty($offerDetail) ?  preg_replace('/[^a-zA-Z0-9 \']/', '',$offerDetail[0]->title) : '';
	$offer_desc = !empty($offerDetail) ?  preg_replace('/[^a-zA-Z0-9 \']/', '',$offerDetail[0]->offer_title) : '';
	
	$paymentResponseArr['result'] = 0;	
	$paymentResponseArr['message'] = '';
	$customerProfileId = '';
	$customerPaymentProfileId = '';
	
	 
	$apiMode = 'testMode';
	if($authorizeDetail[0]->authorize_payment_mode == "production"){
		$apiMode = 'liveMode';
	}
	if($trial_type == 'paid'){
		$this->db->where('offer_type','Paid');
		$this->db->where('trial_id',$trial_id);
		$orderDetail = $this->query_model->getBySpecific('tblorders','id',$order_id);
		if(!empty($orderDetail)){
			$customerProfileId = $orderDetail[0]->client_id;
			$customerPaymentProfileId = $orderDetail[0]->client_token;
			
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
								"name": "'.$offer_title.'",
								"description": "'.$offer_desc.'",
								"quantity": "1",
								"unitPrice": "'.$amount.'"
							}
						}
					}
				}
			}';
			
			$payment_response = $this->query_model->authorizeNetApiRequests($customerPaymentData, $apiMode); 
		
			$updateOrderData['client_id'] = '';
			$updateOrderData['client_token'] = '';

			$this->query_model->update('tblorders',$orderDetail[0]->id, $updateOrderData);
			
			
			$deleteCustomerData = '{
							"deleteCustomerProfileRequest": {
								"merchantAuthentication": {
									"name": "'.$authorizeDetail[0]->authorize_loginkey.'",
									"transactionKey": "'.$authorizeDetail[0]->authorize_transkey.'"
								},
								"customerProfileId": "'.$customerProfileId.'"
							}
						}';
			
			$delete_customer = $this->query_model->authorizeNetApiRequests($deleteCustomerData, $apiMode); 
			//echo '<pre>delete_customer'; print_r($delete_customer); die;
			
		}
	
	
	}else{
		
		
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
}*/




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

	$response_array = explode($post_values["x_delim_char"],$post_response); */

//echo '<prE>response_array'; print_r($response_array); die;
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
	$upsell_offer_text = 'Upsell: '.$upsellTitleOrderArr.' (Trial Offer:'.$product_title.' )';
	$upsell_offer_text = $this->query_model->getMetaDescReplace($upsell_offer_text);
	$order->setDescription($upsell_offer_text);
	
	
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
	

	/** Insert Data in tbl_dojocart_orders table **/

	$insertOrder = array();

	//$insertOrder['product_id'] = $_POST['product_id'];

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

	$insertOrder['created'] = date('Y-m-d h-i-s');
	$insertOrder['trial_id'] = isset($_POST['trial_id'])? $_POST['trial_id'] : 0;
	//$insertOrder['quantity'] = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;
	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	//$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	//$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	//$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location_id'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0;
	$insertOrder['last_order_id'] = $order_id;
	$insertOrder['is_unique_trial'] = $this->query_model->isUniqueSpecialOffer();
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];

	$this->query_model->insertData('tblorders', $insertOrder);

	
	$order_id = $this->db->insert_id();

	if(!empty($order_id)){
		//$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
		
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
		$extraContentArr  = array('trial_upsell_name' => $upsellTitleOrderArr, 'trial_upsell_amount'=> $site_currency_type.$_POST['amount'], 'paymentResult' => $paymentResult);
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);

		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'upsell_trial',$extraContentArr);
		
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
			if(isset($emailAutoResponder['admin_email'])){
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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
					

					$this->email->to($site_email);

					$this->email->subject($type);

															$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';					$mes .= "<br/>";					
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
			}	 */
			
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
		$insertTransaction['payment_type'] = "upsell_trial_offer";

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
				
				$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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
		
		$this->session->unset_userdata('thankyouPageDetail');
		
		$this->query_model->getThankYouPageMessage($_POST);
		$upsell_thankyou_url = $this->query_model->getTrialUpsellThankyouUrl($_POST);

		redirect(@base_url().$upsell_thankyou_url);	

	}

	
		if(isset($results['result']) && $results['result'] == 1){
			$thankyoupage = $this->query_model->getOtherThankYouPageMessage($_POST);
		}else{
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 10);
		}
		
		$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
		
		$this->load->view("upsell_thankyou_page", $results);
		
		}

	}

	


public function brainTreePaymentGateway($product_id = null){
		if (empty($_POST) ) {
			redirect(base_url());
		}
		$_POST['submit'] = 'Purchase Now';
		//echo '<pre>POST'; print_r($_POST); die;
		if(isset($_POST['submit'])){
			$sessionData = $this->session->userdata('thankyouPageDetail');
		
			$_POST['name'] = !empty($sessionData) ? $sessionData['postData']['name'] : '';
			$_POST['last_name'] = !empty($sessionData) ? $sessionData['postData']['last_name'] : '';
			$_POST['email'] = !empty($sessionData) ? $sessionData['postData']['form_email_2'] : '';
			$_POST['phone'] = !empty($sessionData) ? $sessionData['postData']['phone'] : '';
			$_POST['program_id'] = !empty($sessionData) ? $sessionData['postData']['program_id'] : '';
			$mainLocation = $this->query_model->getMainLocation();
			$_POST['location_id'] = (!empty($sessionData) && isset($sessionData['postData']['location_id'])) ?  $sessionData['postData']['location_id'] : $mainLocation[0]->id;
			
			$trial_id = !empty($sessionData) ? $sessionData['trial_id'] : '';
			$order_id = !empty($sessionData) ? $sessionData['order_id'] : '';
			$trial_type = !empty($sessionData) ? $sessionData['trial_type'] : '';
			
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
		
			$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
			$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
			$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
			$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
			$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 1;
			$amount = $_POST['amount'];
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
				$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
				$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales", 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsell_title)){
					$upsell_title = $this->query_model->str_replace_trial_upsells($upsell_title, $upsellDetail[0]->id);
				}
				
				$upsellTitleArr .= '<label>'.$upsell_title.'</label><br>';
				$upsellTitleOrderArr .= $upsell_title;
				}

			$i++;	
			}
			
		}

		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$productDetail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $product_id);
		$product_title =  isset($productDetail[0]->offer_title) ? $productDetail[0]->offer_title : '';
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
			if($trial_type != 'paid'){
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

			}
			
						/*include("./vendor/Braintree.php");

						if($brainTreeDetail[0]->braintree_payment_mode == "production"){
							Braintree_Configuration::environment('production');
						}else{
							Braintree_Configuration::environment('sandbox');
						}
						
						Braintree_Configuration::merchantId($braintree_merchant_id);
						Braintree_Configuration::publicKey($braintree_public_key);
						Braintree_Configuration::privateKey($braintree_private_key);*/
						
						//$customer = Braintree_Customer::find('258188849');
						//echo '<pre>customer'; print_r($customer); die;
						
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
					
					
					
					
					$payment_result = array();
					$paymentError = '';
					
					if($trial_type == 'paid'){
						$this->db->where('offer_type','Paid');
						$this->db->where('trial_id',$trial_id);
						$orderDetail = $this->query_model->getBySpecific('tblorders','id',$order_id);
						//echo '<prE>orderDetail'; print_r($orderDetail); die;
						if(!empty($orderDetail)){
							
							$description = 'Trial Offer Upsell:- '.$product_title;
							
							$payment_result = $gateway->transaction()->sale(['amount'=>$_POST['amount'],
							//'creditCard'=>$card_info,
							
							'orderId' => $description,
							'customer' => [
									'firstName' => $_POST['name'],
									'lastName' => $_POST['last_name'],
									'email' => $_POST['email'],
								  ],
							'paymentMethodToken' => $orderDetail[0]->client_token,
							//'paymentMethodNonce' => $nonceFromTheClient,
							//'billing' => $billing,
							'options'=>[
										'submitForSettlement' => true, 
										'storeInVaultOnSuccess' => true,
										['amexRewards' => ['currencyIsoCode' =>$currency_type,'currencyAmount'=>$_POST['amount']]]
									]
						]); 
							
							//$customerDelete = $gateway->customer()->delete($orderDetail[0]->client_id);
							
							$updateOrderData['client_id'] = '';
							$updateOrderData['client_token'] = '';

							$this->query_model->update('tblorders',$orderDetail[0]->id, $updateOrderData);
						}
						
						
					}else{
						
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
						
						if ($result->success) {
							
								 $clientId = $result->customer->id;
								 $clientToken = $result->customer->paymentMethods[0]->token;
								 
								  $description = 'Trial Offer Upsell:- '.$product_title;
								  
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
						
						
					}	
				
				
			
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

	$insertOrder['created'] = date('Y-m-d h-i-s');

	//$insertOrder['quantity'] = isset($_POST['quantity'])? $_POST['quantity'] : 0;

	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;

	$insertOrder['trial_id'] = isset($_POST['trial_id'])? $_POST['trial_id'] : 0;
	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	//$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	//$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	//$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location_id'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0;
	$insertOrder['last_order_id'] = $order_id;
	$insertOrder['is_unique_trial'] = $this->query_model->isUniqueSpecialOffer();
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
	$this->query_model->insertData('tblorders', $insertOrder);

	
	$order_id = $this->db->insert_id();

	if(!empty($order_id)){
		//$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
		
	}
	//echo '<pre>'; print_r($payment_result); die;
	
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
		$extraContentArr  = array('trial_upsell_name' => $upsellTitleOrderArr, 'trial_upsell_amount'=> $site_currency_type.$_POST['amount'], 'paymentResult' => $paymentResult);
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'upsell_trial',$extraContentArr);
		
		
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
					$insertTransaction['payment_type'] = "upsell_trial_offer";
			
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
							
				$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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
			
							/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
							$mes .= "<br/>";	*/
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
						$this->email->initialize($config);											$from_email=trim($this->config->item('email_from'));																				
						
						/*		if(!empty($from_email)){	
						$this->email->from($from_email,$school_name);
						}else{					
							$this->email->from($site_email,$school_name);											
						}	 */	
					$this->email->from($noreply_email_address, $school_name);
						
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
					
					$this->session->unset_userdata('thankyouPageDetail');
					
					$this->query_model->getThankYouPageMessage($_POST);
					$upsell_thankyou_url = $this->query_model->getTrialUpsellThankyouUrl($_POST);

					redirect(@base_url().$upsell_thankyou_url);	
					
					
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
				if(isset($emailAutoResponder['admin_email'])){
					
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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

					/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
					$mes .= "<br/>";*/	
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
	
	
		if(isset($results['result']) && $results['result'] == 1){
			$thankyoupage = $this->query_model->getOtherThankYouPageMessage($_POST);
		}else{
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 10);
		}
		
		$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
		
		
		//$this->load->view('dojo_payment_result', $results);
		$this->load->view("upsell_thankyou_page", $results);
		
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

		$sessionData = $this->session->userdata('thankyouPageDetail');
		
		$_POST['name'] = !empty($sessionData) ? $sessionData['postData']['name'] : '';
		$_POST['last_name'] = !empty($sessionData) ? $sessionData['postData']['last_name'] : '';
		$_POST['email'] = !empty($sessionData) ? $sessionData['postData']['form_email_2'] : '';
		$_POST['phone'] = !empty($sessionData) ? $sessionData['postData']['phone'] : '';
		$_POST['program_id'] = !empty($sessionData) ? $sessionData['postData']['program_id'] : '';
		$_POST['location_id'] = !empty($sessionData) ? $sessionData['postData']['location_id'] : '';
		
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
		//echo '<pre>'; print_r($_POST); die;

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				echo "<script>alert('Invalid Email Address!')</script>";
				redirect("dojocartpayment");
			}

			
			$this->upsells_order_model->addTrialNew_($data['post'],$product_id);
		

	}





public function stripe_payment_gateway($product_id = null){
		if (empty($_POST) ) {
			redirect(base_url());
		}
		$_POST['submit'] = 'Purchase Now';

		if(isset($_POST['submit'])){
			
			$stripeData = $this->query_model->getStripePaymentKeys();
			//echo '<pre>POST'; print_r($_POST); die;
			$sessionData = $this->session->userdata('thankyouPageDetail');
			
			$_POST['name'] = !empty($sessionData) ? $sessionData['postData']['name'] : '';
			$_POST['last_name'] = !empty($sessionData) ? $sessionData['postData']['last_name'] : '';
			$_POST['email'] = !empty($sessionData) ? $sessionData['postData']['form_email_2'] : '';
			$_POST['phone'] = !empty($sessionData) ? $sessionData['postData']['phone'] : '';
			$_POST['program_id'] = !empty($sessionData) ? $sessionData['postData']['program_id'] : '';
			$mainLocation = $this->query_model->getMainLocation();
			$_POST['location_id'] = (!empty($sessionData) && isset($sessionData['postData']['location_id'])) ?  $sessionData['postData']['location_id'] : $mainLocation[0]->id;
			
			$trial_id = !empty($sessionData) ? $sessionData['trial_id'] : '';
			$order_id = !empty($sessionData) ? $sessionData['order_id'] : '';
			$trial_type = !empty($sessionData) ? $sessionData['trial_type'] : '';
			
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
			$site_currency_type = $this->query_model->getSiteCurrencyType();
		
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
		
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

			if( isset($_POST['upsale_id']) && !empty($_POST['upsale_id']) ){
				$upsale_ids = $_POST['upsale_id'];
				if ( empty($upsale_ids[0]) ) {
					unset($upsale_ids[0]);
				}
				
			$i = 1;
			foreach ($upsale_ids as $id ) {
				if ( !empty($id) ){
				$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
				$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales", 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				if(!empty($upsell_title)){
					$upsell_title = $this->query_model->str_replace_trial_upsells($upsell_title, $upsellDetail[0]->id);
				}
				
				$upsellTitleArr .= '<label>'.$upsell_title.'</label><br>';
				$upsellTitleOrderArr .= $upsell_title;
				}

			$i++;	
			}
			
		}

		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$productDetail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $product_id);
		$product_title =  isset($productDetail[0]->offer_title) ? $productDetail[0]->offer_title : '';
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
				
				$description = 'Trial Offer Upsells:- '.$product_title;
				
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
			
			//include("./vendor/Stripe.php");
				
				
					
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
				$payment_result = array();
				$orderDetail = array();
				$clientId = '';
				$clientToken = '';
				$card_error = 0;
				
				
				if($trial_type == 'paid'){
					$this->db->where('offer_type','Paid');
					$this->db->where('trial_id',$trial_id);
					$orderDetail = $this->query_model->getBySpecific('tblorders','id',$order_id);
					
					if(!empty($orderDetail)){
						if(!empty($orderDetail[0]->client_id)){
							$clientId = $orderDetail[0]->client_id;
							$stripeToken = $orderDetail[0]->client_token;
						}
					}
				}else{
					
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
					
					if($card_error == 0){
						$stripeToken =  isset($generateToken->id) ? $generateToken->id : '';
						$description = 'Trial Offer Upsells:- '.$product_title;			
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
								
						$clientId = !empty($customer) ? $customer->id : '';
						$stripeToken =  isset($generateToken->id) ? $generateToken->id : '';
					}
				}
				
				
				//echo $clientId; die;
				if(isset($stripeToken) && !empty($stripeToken) && $card_error == 0)
				{
					
				//$trialDetail = $this->query_model->getBySpecific('tblspecialoffer','id',$_POST['trial_id']);
				//$trialTitle = !empty($trialDetail) ? $trialDetail[0]->title : '';
					$_POST['amount'] = number_format($_POST['amount'],2);
					
					$amount_cents = str_replace(".","",$_POST['amount']);  // Chargeble amount
					
					//$invoiceid = mt_rand( 10000000, 99999999);                      // Invoice ID
					$description = 'Trial Offer Upsells:- '.$product_title;
					try {
						$payment_result = \Stripe\Charge::create(array(		 
							  "amount" => $amount_cents,
							  "currency" => $currency_type,
							 // "source" => $stripeToken,
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
						
						if(!empty($orderDetail)){	
							$updateOrderData['client_id'] = '';
							$updateOrderData['client_token'] = '';

							$this->query_model->update('tblorders',$orderDetail[0]->id, $updateOrderData);
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
				
		/*echo '<pre>payment_error'; print_r($payment_error);
		echo '<pre>payment_result'; print_r($payment_result); die;*/
		
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

	$insertOrder['created'] = date('Y-m-d h-i-s');

	//$insertOrder['quantity'] = isset($_POST['quantity'])? $_POST['quantity'] : 0;
	$insertOrder['trial_id'] = isset($_POST['trial_id'])? $_POST['trial_id'] : 0;

	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;

	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	//$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	//$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	//$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location_id'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0;
	$insertOrder['last_order_id'] = $order_id;
	$insertOrder['is_unique_trial'] = $this->query_model->isUniqueSpecialOffer();
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
	//echo '<pre>insertOrder'; print_r($insertOrder);
	$this->query_model->insertData('tblorders', $insertOrder);

	
	$order_id = $this->db->insert_id();

	if(!empty($order_id)){
		//$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
		
	}
	
	//echo '<pre>'; print_r($order_id); die;
	
		/*		
		* checkFormModuleApplyAPI 						
		* this function for using apis according form model 						
		*/
		
		
		$this->query_model->checkFormModuleApplyAPI($_POST);
		$extraContentArr  = array('trial_upsell_name' => $upsellTitleOrderArr, 'trial_upsell_amount'=> $site_currency_type.$_POST['amount'], 'paymentResult' => $paymentResult);
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'upsell_trial',$extraContentArr);
		
	if ($payment_status_code == 1 ) 
	{
			if($balance_transaction)
				{
					
					$results['result'] = 1;
					$txnId = $balance_transaction;
					
			
			
					$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $txnId;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					
					$insertTransaction['payment_type'] = "upsell_trial_offer";
			
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
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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
								
			
								$this->email->to($site_email);
			
								$this->email->subject($type);
	
						$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
						$mes .= "<br/>";	
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';			
					
	
								$this->email->message($mes);
			
								
			
								$this->email->send();
			
						}		
			
								// send email to websitedojo.com
			
							/*	$this->email->initialize($config);
			
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
						
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
						
						$this->session->unset_userdata('thankyouPageDetail');
						
						$this->query_model->getThankYouPageMessage($_POST);
						$upsell_thankyou_url = $this->query_model->getTrialUpsellThankyouUrl($_POST);

						redirect(@base_url().$upsell_thankyou_url);	
						
						
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
				if(isset($emailAutoResponder['admin_email'])){
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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

						/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
						$mes .= "<br/>";*/		
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
		
	
	
	
		if(isset($results['result']) && $results['result'] == 1){
			$thankyoupage = $this->query_model->getOtherThankYouPageMessage($_POST);
		}else{
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 10);
		}
		
		$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
		
		
		//$this->load->view('dojo_payment_result', $results);
		$this->load->view("upsell_thankyou_page", $results);
		
		//$dojocart_thankyou_url = $this->query_model->getDojocartThankyouUrl($productDetail[0]->slug);
				
		//redirect(@base_url().$dojocart_thankyou_url);
		
		}

	}


	public function stripe_ideal_payment_gateway(){
		if (empty($_POST) ) {
			redirect(base_url());
		}
		$_POST['submit'] = 'Purchase Now';

		if(isset($_POST['submit'])){
			if(!isset($_POST['account_holder_name']) || !isset($_POST['bank_name'])){
				redirect('/site/page_not_found');
			}
			
			$sessionData = $this->session->userdata('thankyouPageDetail');
			
			$_POST['name'] = !empty($sessionData) ? $sessionData['postData']['name'] : '';
			$_POST['last_name'] = !empty($sessionData) ? $sessionData['postData']['last_name'] : '';
			$_POST['email'] = !empty($sessionData) ? $sessionData['postData']['form_email_2'] : '';
			$_POST['phone'] = !empty($sessionData) ? $sessionData['postData']['phone'] : '';
			$_POST['program_id'] = !empty($sessionData['postData']['program_id']) ? $sessionData['postData']['program_id'] : '';
			
			$mainLocation = $this->query_model->getMainLocation();
			$_POST['location_id'] = (!empty($sessionData) && isset($sessionData['postData']['location_id'])) ?  $sessionData['postData']['location_id'] : $mainLocation[0]->id;
			$_POST['trial_id'] = !empty($sessionData) ? $sessionData['trial_id'] : '';
			$_POST['order_id'] = !empty($sessionData) ? $sessionData['order_id'] : '';
			$_POST['trial_type'] = !empty($sessionData) ? $sessionData['trial_type'] : '';
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
			
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
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
				'return_url' => base_url().'trial_upsells_payment/mwalteSpIdlPymSvdj'
				//'return_url' => base_url().'trial_upsells_payment/stripe_ideal_payment_webhook'
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
			$stripeIdealTrialUpsellFormData = array('stripeIdealTrialUpsellFormData' => $_POST);
			$this->session->set_userdata($stripeIdealTrialUpsellFormData);
			
			if(isset($createSource->redirect->url) && !empty($createSource->redirect->url)){
				redirect($createSource->redirect->url);
			}
		}
			
		}
	}
	
	
	
	public function mwalteSpIdlPymSvdj(){
		
		$source_id = (isset($_GET['source']) && !empty($_GET['source'])) ? $_GET['source'] : '';
	
		$_POST = $this->session->userdata('stripeIdealTrialUpsellFormData');
		
		$this->session->unset_userdata('stripeIdealFormData');
		
		if(isset($_POST['submit'])){
			
			if(!isset($_POST['account_holder_name']) || !isset($_POST['bank_name'])){
				redirect('/site/page_not_found');
			}
			
		if(!empty($source_id)){
			$product_id = isset($_POST['trial_id']) ? $_POST['trial_id'] : 0;
			$trial_id = isset($_POST['trial_id']) ? $_POST['trial_id'] : '';
			$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
			$trial_type = isset($_POST['trial_type']) ? $_POST['trial_type'] : '';
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
			
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
			
			
			$card_error = 0;
			$payment_result = array();
			$orderDetail = array();
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
			
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
			$amount = $_POST['amount'];
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
				
				$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
				$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales", 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				if(!empty($upsell_title)){
					$upsell_title = $this->query_model->str_replace_trial_upsells($upsell_title, $upsellDetail[0]->id);
				}
				
				$upsellTitleArr .= '<label>'.$upsell_title.'</label><br>';
				$upsellTitleOrderArr .= $upsell_title;
				}

			$i++;	
			}
			
		}
		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$productDetail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $product_id);
		$product_title =  isset($productDetail[0]->offer_title) ? $productDetail[0]->offer_title : '';
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

	$insertOrder['created'] = date('Y-m-d h-i-s');

	//$insertOrder['quantity'] = isset($_POST['quantity'])? $_POST['quantity'] : 0;
	$insertOrder['trial_id'] = isset($_POST['trial_id'])? $_POST['trial_id'] : 0;

	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;

	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	//$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	//$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	//$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location_id'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0;
	$insertOrder['last_order_id'] = $order_id;
	$insertOrder['source_id'] = $source_id;
	$insertOrder['is_unique_trial'] = $this->query_model->isUniqueSpecialOffer();
	$ipAddress = $this->query_model->getCountryNameToIpAddress();
	$insertOrder['ip_address'] = $ipAddress['client_ip_address'];
	$insertOrder['client_country_name'] = $ipAddress['client_country_name'];
	$this->query_model->insertData('tblorders', $insertOrder);

	
	$order_id = $this->db->insert_id();

	if(!empty($order_id)){
		//$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
		
	}
	
	/*		
		* checkFormModuleApplyAPI 						
		* this function for using apis according form model 						
		*/
		
		
		$this->query_model->checkFormModuleApplyAPI($_POST);
		$extraContentArr  = array('trial_upsell_name' => $upsellTitleOrderArr, 'trial_upsell_amount'=> $site_currency_type.$_POST['amount'], 'paymentResult' => $paymentResult);
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'upsell_trial',$extraContentArr);
		
	if ($payment_status_code == 1 ) 
	{
			if($payment_result->balance_transaction)
				{
					
					$results['result'] = 1;
					$txnId = $payment_result->balance_transaction;
					
			
			
					$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $txnId;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					
					$insertTransaction['payment_type'] = "upsell_trial_offer";
			
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
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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
								
			
								$this->email->to($site_email);
			
								$this->email->subject($type);
	
						$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
						$mes .= "<br/>";	
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';			
					
	
								$this->email->message($mes);
			
								
			
								$this->email->send();
			
						}		
			
								// send email to websitedojo.com
			
							/*	$this->email->initialize($config);
			
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
						
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
						
						$this->session->unset_userdata('thankyouPageDetail');
						
					$upsell_thankyou_url = $this->query_model->getTrialUpsellThankyouUrl($_POST);

					redirect(@base_url().$upsell_thankyou_url);	

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
				if(isset($emailAutoResponder['admin_email'])){
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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

			
	
		if(isset($results['result']) && $results['result'] == 1){
			$thankyoupage = $this->query_model->getOtherThankYouPageMessage($_POST);
		}else{
			$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 10);
		}
		
		$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
		
		
		//$this->load->view('dojo_payment_result', $results);
		$this->load->view("upsell_thankyou_page", $results);

			
			
			}
		  }else{
				die("Something went wrong. Please try again!");
			}
		}
	}


	
	public function stripe_ideal_payment_webhook(){
		
		$source_id = (isset($_GET['source']) && !empty($_GET['source'])) ? $_GET['source'] : '';
		
		if(!empty($source_id)){
			$orderData = $this->query_model->getBySpecific('tblorders', 'source_id',$source_id);
			
			if(!empty($orderData)){
				$orderData = $orderData[0];
				$payment_status = strtolower($orderData->trans_status);
				//$payment_status = 'pending';
				$paymentStatusArr = array('succeeded','paid','success','successful');
				
				if(in_array($payment_status,$paymentStatusArr)){
					// just checking
				}else{
					$_POST = array();
					$_POST['trial_id'] = $orderData->trial_id;
					$_POST['order_id'] = $orderData->id;
					$_POST['trialOfferId'] = $orderData->trial_id;
					$_POST['amount'] = $orderData->amount;
					$_POST['website'] = '';
					$_POST['page_url'] = '/trial_upsells_payment/stripe_ideal_payment_gateway/'.$orderData->trial_id;
					$_POST['name'] = $orderData->name;
					$_POST['last_name'] = $orderData->last_name;
					$_POST['form_email_2'] = $orderData->email;
					$_POST['email'] = $orderData->email;
					$_POST['phone'] = $orderData->phone;
					$_POST['location_id'] = $orderData->location_id;
					$_POST['program_id'] = $orderData->program_id;
					$_POST['amount'] = $orderData->amount;
					$_POST['address'] = $orderData->address;
					$_POST['address_line2'] = $orderData->address_line2;
					$_POST['city'] = $orderData->city;
					$_POST['state'] = $orderData->state;
					$_POST['zip'] = $orderData->zip;
					$_POST['trial_type'] = strtolower($orderData->offer_type);
					$order_id = $orderData->id;
					$product_id = isset($_POST['trial_id']) ? $_POST['trial_id'] : 0;
					$trial_id = isset($_POST['trial_id']) ? $_POST['trial_id'] : '';
					$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
					$trial_type = isset($_POST['trial_type']) ? $_POST['trial_type'] : '';
					if(!empty($orderData->upsells_title)){
						
						$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
						$this->db->where('trial_offer_id', $orderData->trial_id);
						$upsellDetail = $this->query_model->getBySpecific("$tbl_onlinespecial_upsales",'up_title',$orderData->upsells_title);
						if(!empty($upsellDetail)){
							$_POST['upsale_id'][0] = $upsellDetail[0]->id;
						}
					}

					
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
			
			
			$card_error = 0;
			$payment_result = array();
			$orderDetail = array();
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
			
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 0;
			$amount = $_POST['amount'];
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
					
				$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
				$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales", 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				if(!empty($upsell_title)){
					$upsell_title = $this->query_model->str_replace_trial_upsells($upsell_title, $upsellDetail[0]->id);
				}
				
				$upsellTitleArr .= '<label>'.$upsell_title.'</label><br>';
				$upsellTitleOrderArr .= $upsell_title;
				}

			$i++;	
			}
			
		}
		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$productDetail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $product_id);
		$product_title =  isset($productDetail[0]->offer_title) ? $productDetail[0]->offer_title : '';
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
			
			/*		
			* checkFormModuleApplyAPI 						
			* this function for using apis according form model 						
			*/
			
			
			$this->query_model->checkFormModuleApplyAPI($_POST);
			$extraContentArr  = array('trial_upsell_name' => $upsellTitleOrderArr, 'trial_upsell_amount'=> $site_currency_type.$_POST['amount'], 'paymentResult' => $paymentResult);
			$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
			
			// sending msg by twillio api
			$this->query_model->connectFormToTwillioAPi($_POST,'upsell_trial',$extraContentArr);
			
			if ($payment_status_code == 1 ) 
	{
			if($payment_result->balance_transaction)
				{
					
					$results['result'] = 1;
					$txnId = $payment_result->balance_transaction;
					
			
			
			
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
							
							$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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
								
			
								$this->email->to($site_email);
			
								$this->email->subject($type);
	
						$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
						$mes .= "<br/>";	
						//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';			
					
	
								$this->email->message($mes);
			
								
			
								$this->email->send();
			
						}		
			
								// send email to websitedojo.com
			
							/*	$this->email->initialize($config);
			
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
						
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
						
						//$this->session->unset_userdata('thankyouPageDetail');
						
						
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
				if(isset($emailAutoResponder['admin_email'])){
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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
		

			}
					
					
					
					}	
				}
			}
		}
		
	}
	
	
	public function paypal_payment_gateway($product_id = null){
		if (empty($_POST) ) {
			redirect(base_url());
		}
		$_POST['submit'] = 'Purchase Now';
		
		if(isset($_POST['submit'])){
			$sessionData = $this->session->userdata('thankyouPageDetail');
		
			$_POST['name'] = !empty($sessionData) ? $sessionData['postData']['name'] : '';
			$_POST['last_name'] = !empty($sessionData) ? $sessionData['postData']['last_name'] : '';
			$_POST['email'] = !empty($sessionData) ? $sessionData['postData']['form_email_2'] : '';
			$_POST['phone'] = !empty($sessionData) ? $sessionData['postData']['phone'] : '';
			$_POST['program_id'] = (!empty($sessionData) && isset($sessionData['postData']['program_id'])) ? $sessionData['postData']['program_id'] : '';
			$mainLocation = $this->query_model->getMainLocation();
			$_POST['location_id'] = (!empty($sessionData) && isset($sessionData['postData']['location_id'])) ?  $sessionData['postData']['location_id'] : $mainLocation[0]->id;
			
			$trial_id = !empty($sessionData) ? $sessionData['trial_id'] : '';
			$order_id = !empty($sessionData) ? $sessionData['order_id'] : '';
			$trial_type = !empty($sessionData) ? $sessionData['trial_type'] : '';
			
			$_POST['trial_id'] = $trial_id;
			$_POST['order_id'] = $order_id;
			$_POST['trial_type'] = $trial_type;
			$_POST['product_id'] = $product_id;
			
			
			// checking hunney Post
			$this->query_model->checkHunneyPost($_POST);
			
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
		$site_currency_type = $this->query_model->getSiteCurrencyType();
			
		
			$_POST['address'] = isset($_POST['address']) ? $_POST['address'] : '';
			$_POST['address_line2'] = isset($_POST['address_line2']) ? $_POST['address_line2'] : '';
			$_POST['city'] = isset($_POST['city']) ? $_POST['city'] : '';
			$_POST['state'] = isset($_POST['state']) ? $_POST['state'] : '';
			$_POST['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 1;
			$amount = $_POST['amount'];
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
				$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
				$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales", 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsell_title)){
					$upsell_title = $this->query_model->str_replace_trial_upsells($upsell_title, $upsellDetail[0]->id);
				}
				
				$upsellTitleArr .= '<label>'.$upsell_title.'</label><br>';
				$upsellTitleOrderArr .= $upsell_title;
				}

			$i++;	
			}
			
		}

		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$productDetail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $product_id);
		$product_title =  isset($productDetail[0]->offer_title) ? $productDetail[0]->offer_title : '';
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
					
					$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
					$trialDetail = $this->query_model->getBySpecific("$tblspecialoffer",'id',$_POST['trial_id']);
					$trialTitle = !empty($trialDetail) ? $trialDetail[0]->offer_title : '';
					$description = 'Trial Offer Upsell:- '.$trialTitle;
					
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
					$redirect_urls->setReturnUrl(base_url().'trial_upsells_payment/paypal_success') /** Specify return URL **/
						->setCancelUrl(base_url().'trial_upsells_payment/paypal_cancel');

					 $payment = new \PayPal\Api\Payment();
					 $payment->setIntent('Sale')
							->setPayer($payer)
							->setRedirectUrls($redirect_urls)
							->setTransactions(array($transaction));


					//echo '<pre>payment==>'; print_r($payment); die;
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

	$insertOrder['created'] = date('Y-m-d h-i-s');

	//$insertOrder['quantity'] = isset($_POST['quantity'])? $_POST['quantity'] : 0;

	$insertOrder['term_condition'] = isset($_POST['term_condition'])? $_POST['term_condition'] : 0;

	$insertOrder['trial_id'] = isset($_POST['trial_id'])? $_POST['trial_id'] : 0;
	$insertOrder['upsells_title'] = $upsellTitleOrderArr;
	//$insertOrder['tax'] = isset($_POST['total_tax_amount']) ? $_POST['total_tax_amount'] : 0;
	//$insertOrder['coupon_code'] = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';
	//$insertOrder['coupon_discount'] = isset($_POST['coupon_discount']) ? $_POST['coupon_discount'] : '';
	$insertOrder['location_id'] = !empty($location_id) ? $location_id : 0;
	$insertOrder['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0;
	$insertOrder['last_order_id'] = $order_id;
	$insertOrder['is_unique_trial'] = $this->query_model->isUniqueSpecialOffer();
	
	$this->query_model->insertData('tblorders', $insertOrder);

	
	$order_id = $this->db->insert_id();

	if(!empty($order_id)){
		//$current_email_info = $this->query_model->getOrderEmailInfo($_POST['email'], $_POST['name'] );
		
	}
		
		$orderRecord = array('order_type'=>'trial_upsell','order_id'=>$order_id,'created_date'=>date('Y-m-d H:i:s'));
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
					$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 10);
					
					$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
					
					$this->load->view("upsell_thankyou_page", $results);
				}
			}
	
		
		}
	}
	
	
	public function paypal_success(){
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
			
			//echo '<prE>result'; print_r($result); die;
			
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
			
			
			if (!empty($_POST) && $result->getState() == 'approved') {
			
	/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/			
					
			$product_id = $_POST['product_id'];
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 1;
			$amount = $_POST['amount'];
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
				$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
				$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales", 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsell_title)){
					$upsell_title = $this->query_model->str_replace_trial_upsells($upsell_title, $upsellDetail[0]->id);
				}
				
				$upsellTitleArr .= '<label>'.$upsell_title.'</label><br>';
				$upsellTitleOrderArr .= $upsell_title;
				}

			$i++;	
			}
			
		}

		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$productDetail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $product_id);
		$product_title =  isset($productDetail[0]->offer_title) ? $productDetail[0]->offer_title : '';
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

				$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
				$paymentResult = $this->query_model->getStaticTextTranslation('payment_success');
				
				$this->query_model->checkFormModuleApplyAPI($_POST);
				$extraContentArr  = array('trial_upsell_name' => $upsellTitleOrderArr, 'trial_upsell_amount'=> $site_currency_type.$_POST['amount'], 'paymentResult' => $paymentResult);
				$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
				// sending msg by twillio api
				$this->query_model->connectFormToTwillioAPi($_POST,'upsell_trial',$extraContentArr);
				
				
					
					$results['result'] = 1;
					
					$ptid = $payment_id;
					
					$insertTransaction = array();
			
					$insertTransaction['transaction_id'] = $ptid;
			
					$insertTransaction['amount'] = 	$_POST['amount'];	
			
					$insertTransaction['order_id'] = $order_id;
					$insertTransaction['payment_type'] = "upsell_trial_offer";
			
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
							
				$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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
			
							/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
							$mes .= "<br/>";	*/
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
						$this->email->initialize($config);											$from_email=trim($this->config->item('email_from'));																				
						
						/*		if(!empty($from_email)){	
						$this->email->from($from_email,$school_name);
						}else{					
							$this->email->from($site_email,$school_name);											
						}	 */	
					$this->email->from($noreply_email_address, $school_name);
						
						//$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);								//$this->email->reply_to($reply_to_add);	
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
					
					$this->session->unset_userdata('thankyouPageDetail');
					
					$this->query_model->getThankYouPageMessage($_POST);
					$upsell_thankyou_url = $this->query_model->getTrialUpsellThankyouUrl($_POST);

					redirect(@base_url().$upsell_thankyou_url);	
					
			}
		}
			
			
		}	
	}
	
	public function paypal_cancel(){
		
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
			
			if (!empty($_POST)){/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/			
					
			$product_id = $_POST['product_id'];
			$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			
			$quantity = isset($_POST['quantity'])? $_POST['quantity'] : 1;
			$amount = $_POST['amount'];
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
				$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
				$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales", 'id', $id);
				$upsell_title =  isset($upsellDetail[0]->up_title) ? $upsellDetail[0]->up_title : '';
				
				if(!empty($upsell_title)){
					$upsell_title = $this->query_model->str_replace_trial_upsells($upsell_title, $upsellDetail[0]->id);
				}
				
				$upsellTitleArr .= '<label>'.$upsell_title.'</label><br>';
				$upsellTitleOrderArr .= $upsell_title;
				}

			$i++;	
			}
			
		}

		
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$productDetail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $product_id);
		$product_title =  isset($productDetail[0]->offer_title) ? $productDetail[0]->offer_title : '';
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

				$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
				$paymentResult = $this->query_model->getStaticTextTranslation('payment_failure');
				
				$this->query_model->checkFormModuleApplyAPI($_POST);
				$extraContentArr  = array('trial_upsell_name' => $upsellTitleOrderArr, 'trial_upsell_amount'=> $site_currency_type.$_POST['amount'], 'paymentResult' => $paymentResult);
				$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST, $extraContentArr);	
				// sending msg by twillio api
				
				$this->query_model->connectFormToTwillioAPi($_POST,'upsell_trial',$extraContentArr);
				
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
				if(isset($emailAutoResponder['admin_email'])){
					
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){

					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',0);
					$text_address = 0;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'upsell_trial',$extraContentArr);
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

					/*$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';	
					$mes .= "<br/>";*/	
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
				
				$thankyoupage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 10);
		
				$results['thankyou_msg'] = !empty($thankyoupage) ? $thankyoupage[0]->description : '';
				
				$this->session->unset_userdata('paypal_order_unique_id');
					if (isset($_COOKIE['paypal_order_unique_id'])) {
						unset($_COOKIE['paypal_order_unique_id']); 
						setcookie('paypal_order_unique_id', null, -1, '/'); 
					}
					
				$this->load->view("upsell_thankyou_page", $results);						
		}
			
			
		}else{
			redirect('/site/page_not_found');
		}
		
	}
	
}