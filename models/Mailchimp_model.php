<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailchimp_model extends CI_Model{	
	
	
	
 public function saveSubscriberData($data){
 		
		// change this path if the class file isn't in the same directory!
//include_once 'MailChimp.php';


$alertclass = 'alert-warning';
$msg = '';
$name = '';
$email = '';

	echo '<pre>'; print_r($_POST); die;
	if (empty($_POST['name']) || empty($_POST['email'])) {
		$msg = 'Please enter a name and email address.';
	} else {
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		/*
		 * Place here your validation and other code you're using to process your contact form.
		*/
		$mc = new \Drewm\MailChimp('YOUR_API_KEY');
		$mvars = array('optin_ip'=> $_SERVER['REMOTE_ADDR'], 'FNAME' => $name);
		$result = $mc->call('lists/subscribe', array(
				'id'                => 'YOUR_LIST_ID',
				'email'             => array('email'=>$email),
				'merge_vars'        => $mvars,
				'double_optin'      => true,
				'update_existing'   => false,
				'replace_interests' => false,
				'send_welcome'      => false
			)
		);
		
		return $result;
	}

 	
 }
	
	
}