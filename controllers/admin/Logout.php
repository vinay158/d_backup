<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function __construct(){
		parent::__construct();

        // To use site_url and redirect on this controller.
        $this->load->helper('url');
		$this->load->library('facebook');
	}
	public function index()
	{
		$userDetail = $this->query_model->getBySpecific('tbladmin','id',$this->session->userdata("userid"));
		
		if(!empty($userDetail)){
			
			/*$requestData = array(
							'user_name' => $userDetail[0]->user,
							'secret_key' =>  $userDetail[0]->secret_key,
							'access_token' =>  $userDetail[0]->access_token,
							'curl_action' =>  'distory-access-token',
							);
			
			$this->deleteAccessFromCRM($requestData);*/
			
			
			//$updateUserData = array('secret_key'=>'','access_token'=>'');
			$updateUserData = array('is_switched_user'=> 0);
			$this->query_model->update('tbladmin', $this->session->userdata("userid"), $updateUserData);
			
			
		}
		
		$this->session->sess_destroy();
		$this->facebook->destroySession();
		redirect('admin');
	}
	
	
	
public function deleteAccessFromCRM($userDetail){
	
	if(!empty($userDetail)){
		
		$this->db->select('dojo_crm_url');
		$site_setting = $this->query_model->getByTable('tblsite');
		
		$url = $site_setting[0]->dojo_crm_url.'/web-services/distory-access-token';
		
		
		$query = "";
		foreach( $userDetail as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');
		
		$api_url = $url.'?' . $query;
		
		$ch = curl_init();
		$request = curl_init($api_url); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		//curl_setopt($request, CURLOPT_POSTFIELDS, $userDetail); // use HTTP POST to send form data
		curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
		
		$response = (string)curl_exec($request); // execute curl post and store results in $response
		$error_msg = curl_error($request);
		curl_close($request); // close curl object
		
		//echo '<prE>error_msg=>'; print_r($error_msg); 
		//echo '<pre>response'; print_r($response); die;
		if(!empty($response)){
			
		}
	}
	
}


}