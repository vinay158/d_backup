<?php 
//require 'vendor/autoload.php';
//require 'vendor/Mailchimp.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_marketing extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		//$this->load->model("customcss_model");
		
	}
	
public function index(){
	
	
	
	$_SERVER['REMOTE_ADDR'] = '71.61.74.22';
	
	$data['user_level']=$this->session->userdata['user_level'];
	$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
			
			$activeCampaignDetail =  $this->query_model->getbySpecific('tbl_active_campaign', 'id', 1);
			//echo '<pre>activeCampaignDetail'; print_r($activeCampaignDetail); die;
			$email_marketing_permission = $this->query_model->getOtherPagePermissions($this->session->userdata("userid"), 'admin/email_marketing');
			
			
			if($email_marketing_permission == 1 && !empty($activeCampaignDetail) && $activeCampaignDetail[0]->type == 1){
					
					// By default, this sample code is designed to get the result from your ActiveCampaign installation and print out the result
					$url = 'https://'.$activeCampaignDetail[0]->account_name.'.api-us1.com';


					$params = array(

						// the API Key can be found on the "Your Settings" page under the "API" tab.
						// replace this with your API Key
						'api_key'      => $activeCampaignDetail[0]->api_key,

						// this is the action that signs in a user
						'api_action'   => 'singlesignon',

						// define the type of output you wish to get back
						// possible values:
						// - 'xml'  :      you have to write your own XML parser
						// - 'json' :      data is returned in JSON format and can be decoded with
						//                 json_decode() function (included in PHP since 5.2.0)
						// - 'serialize' : data is returned in a serialized format and can be decoded with
						//                 a native unserialize() function
						'api_output'   => 'serialize',

						// this is the IP address user uses to access the server
						'sso_addr'     => $_SERVER['REMOTE_ADDR'], // this can also be $_SERVER['REMOTE_ADDR'] if this script is ran by user
						// this is the user you are logging in as
						'sso_user'     => $activeCampaignDetail[0]->user_name,

						// optionally, you can provide the duration of his token (in minutes; default is 15)
						'sso_duration' => 600,
					);

					// This section takes the input fields and converts them to the proper format
					$query = "";
					foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
					$query = rtrim($query, '& ');

					// clean up the url
					$url = rtrim($url, '/ ');

					// This sample code uses the CURL library for php to establish a connection,
					// submit your request, and show (print out) the response.
					if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

					// If JSON is used, check if json_decode is present (PHP 5.2.0+)
					if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
						//die('JSON not supported. (introduced in PHP 5.2.0)');
					}

					// define a final API request - GET
					$api = $url . '/api.php?' . $query;

					$request = curl_init($api); // initiate curl object
					curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
					curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
					//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
					curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

					$response = (string)curl_exec($request); // execute curl post and store results in $response

					// additional options may be required depending upon your server configuration
					// you can find documentation on curl options at http://www.php.net/curl_setopt
					curl_close($request); // close curl object

					if ( !$response ) {
						//die('Nothing was returned. Do you have a connection to Email Marketing server?');
					}

					// This line takes the response and breaks it into an array using:
					// JSON decoder
					//$result = json_decode($response);
					// unserializer
					$result = unserialize($response);
					// XML parser...
					// ...

					//echo '<pre>result'; print_r($result); die;
					
					if ( $result['result_code'] ) {
						// a sample url printed out
						$autoLoginUrl = $url . '/admin/main.php?_ssot=' . $result['token'];
						
						$data['response'] = 1;
						$data['autoLoginUrl'] = $autoLoginUrl;
						//redirect($autoLoginUrl);
						
						//echo 'A sample link your visitor can use to auto-login:<br />';
						//echo '<a href="' . $autoLoginUrl . '">' . $autoLoginUrl . '</a>'; die;
						//print_r($result);
						
					}else{
						$data['response'] = 0;
						$data['error_msg'] = $result['result_message'];
						
					}
					$this->load->view("admin/email_marketing", $data);				
				
			}else{
				redirect('admin/dashboard');
			}
			
		}else{
			redirect('admin/login');
		}
	}
	

	
}