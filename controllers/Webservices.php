<?php 
require 'vendor/autoload.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webservices extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
	}
	
	public function switch_crm_user(){
		
		$is_switch_to_crm =  $this->query_model->is_switch_to_crm_applied();
		
		if($is_switch_to_crm == 1){
			
			$email = (isset($_GET['uEmail']) && !empty($_GET['uEmail'])) ? $_GET['uEmail'] : '';
			$user_name = (isset($_GET['uName']) && !empty($_GET['uName'])) ? $_GET['uName'] : '';
			$action = (isset($_GET['uAction']) && !empty($_GET['uAction'])) ? $_GET['uAction'] : '';
			$secret_key = (isset($_GET['uSecret_key']) && !empty($_GET['uSecret_key'])) ? $_GET['uSecret_key'] : '';
			$access_token = (isset($_GET['uAccessToken']) && !empty($_GET['uAccessToken'])) ? $_GET['uAccessToken'] : '';
			$u_id = (isset($_GET['uUserId']) && !empty($_GET['uUserId'])) ? $_GET['uUserId'] : '';
			$u_password = (isset($_GET['uPassword']) && !empty($_GET['uPassword'])) ? $_GET['uPassword'] : '';
			$uRo = (isset($_GET['uRo']) && !empty($_GET['uRo'])) ? $_GET['uRo'] : 2;
			
			
			if($_SERVER['HTTP_HOST'] != "localhost"){
			
				$http_reffer = (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
				$is_spam_request = $this->user_model->crossCheckCurlRequest($http_reffer, $_SERVER['HTTP_HOST']);
			
				if($is_spam_request == 1){
					
					$this->db->select('dojo_crm_url');
					$site_setting = $this->query_model->getByTable('tblsite');
					
					$user_dashboard = 'login';
					
					redirect($site_setting[0]->dojo_crm_url.'/'.$user_dashboard.'?switch_error_code=user-not-found');
				}
			}
			
			
			
			$error_msg = '';
			if(empty($u_id) && empty($u_password)){
				
				if($action == "crm-switch-user"){
					
					$this->db->where('secret_key',$secret_key);
					$this->db->where('access_token',$access_token);
					$user = $this->query_model->getBySpecific('tbladmin','user',$user_name);
					
					if(!empty($user)){
						
						$user = $user[0];
						
						$data = array(
							'user' => $user->user,
							'fname' => ucfirst($user->fname),
							'lname' => ucfirst($user->lname),
							'email' => $user->email,
							'userid' => $user->id, 
							'user_level' => $user->user_level,
							'is_logged_in' => true,
							'login_time' => time()
							);
						
							$str=rand();
							$secret_key = sha1($str);
							$user_access_data = $this->user_model->getUserAccessToken($secret_key,$data);
						
							$userDataArr = array('is_switched_user'=> 1,
												 'secret_key' =>  $user_access_data['secret_key'],
												 'access_token' =>  $user_access_data['access_token']
												);
							$this->query_model->update('tbladmin', $user->id, $userDataArr);

							$requestData = array(
								'user_name' => $user->user,
								'old_secret_key' =>  $user->secret_key,
								'old_access_token' =>  $user->access_token,
								'secret_key' =>  $user_access_data['secret_key'],
								'access_token' =>  $user_access_data['access_token'],
								'curl_action' =>  'update-switched-user-field',
								);
							//echo '<pre>requestData'; print_r($requestData); die;
							
							$this->updateIsSwitchedFieldCRM($requestData);	
							
							$this->session->set_userdata($data);
							
							redirect('admin/dashboard');
							
					}else{
						$error_msg = 'user-not-found';
					}
					
				}else{
					$error_msg = 'empty-fields';
				}
				
			}else{
				$error_msg = 'empty-fields';
			}
			
			if(!empty($error_msg)){
					
				$this->db->select('dojo_crm_url');
				$site_setting = $this->query_model->getByTable('tblsite');
				
				if($uRo == 1){
					$user_dashboard = 'admin/dashboard';
				}elseif($uRo == 2){
					$user_dashboard = 'member/dashboard';
				}else{
					$user_dashboard = 'login';
				}
				redirect($site_setting[0]->dojo_crm_url.'/'.$user_dashboard.'?switch_error_code='.$error_msg);
			}
			
		}
		
	}
	
	public function distory_access_token(){
		
		if(isset($_GET['curl_action']) && $_GET['curl_action'] == "distory-access-token"){
			
			//$email = (isset($_GET['email']) && !empty($_GET['email'])) ? $_GET['email'] : '';
			$user_name = (isset($_GET['user_name']) && !empty($_GET['user_name'])) ? $_GET['user_name'] : '';
			$secret_key = (isset($_GET['secret_key']) && !empty($_GET['secret_key'])) ? $_GET['secret_key'] : '';
			$access_token = (isset($_GET['access_token']) && !empty($_GET['access_token'])) ? $_GET['access_token'] : '';
			//echo '<pre>GET'; print_r($_GET); die;
			if(!empty($user_name) && !empty($secret_key)   && !empty($access_token)){
				
				$this->db->where('secret_key',$secret_key);
				$this->db->where('access_token',$access_token);
				$existUser = $this->query_model->getBySpecific('tbladmin','user',$user_name);
				//echo '<pre>existUser'; print_r($existUser); die;
				
				if(!empty($existUser)){
					
					$userDataArr = array(
								'secret_key'=> '',
								'access_token'=> ''
							);
					
					$this->query_model->update('tbladmin', $existUser[0]->id, $userDataArr);
				}
				
			}else{
				echo 'Something went wrong';
			}
			
		}
	}
	
	
	
	public function update_access_token(){
		
		$is_success = 0;
		if(isset($_GET['curl_action']) && $_GET['curl_action'] == "update-user-access-token"){
			
			$error_msg = '';
			
			//$email = (isset($_GET['email']) && !empty($_GET['email'])) ? $_GET['email'] : '';
			$user_name = (isset($_GET['user_name']) && !empty($_GET['user_name'])) ? $_GET['user_name'] : '';
			$secret_key = (isset($_GET['secret_key']) && !empty($_GET['secret_key'])) ? $_GET['secret_key'] : '';
			$access_token = (isset($_GET['access_token']) && !empty($_GET['access_token'])) ? $_GET['access_token'] : '';
			$login_time = (isset($_GET['login_time']) && !empty($_GET['login_time'])) ? $_GET['login_time'] : '';
			
			
			if(!empty($user_name) && !empty($secret_key)   && !empty($access_token)){
				
				$existUser = $this->query_model->getBySpecific('tbladmin','user',$user_name);
				
				if(!empty($existUser)){
					
					$userDataArr = array(
								'secret_key'=> $secret_key,
								'access_token'=> $access_token,
								'login_time'=> $login_time,
							);
					
					$this->query_model->update('tbladmin', $existUser[0]->id, $userDataArr);
					
					$is_success = 1;
					
				}else{
					$error_msg = 'user-not-found';
				}
				
			}else{
					$error_msg = 'empty-fields';
			}
			
			if(!empty($error_msg)){
				
				$this->db->select('dojo_crm_url');
				$site_setting = $this->query_model->getByTable('tblsite');
				
				redirect($site_setting[0]->dojo_crm_url.'/login?switch_error_code='.$error_msg);
			}else{
				
				if($is_success == 1){
					echo $is_success;
				}
				
			}
			
			
		}
	}
	
	
	public function update_switch_field(){
		
		if(isset($_GET['curl_action']) && $_GET['curl_action'] == "update-switched-user-field"){
			$error_msg = '';
			//$email = (isset($_GET['email']) && !empty($_GET['email'])) ? $_GET['email'] : '';
			$user_name = (isset($_GET['user_name']) && !empty($_GET['user_name'])) ? $_GET['user_name'] : '';
			$secret_key = (isset($_GET['secret_key']) && !empty($_GET['secret_key'])) ? $_GET['secret_key'] : '';
			$access_token = (isset($_GET['access_token']) && !empty($_GET['access_token'])) ? $_GET['access_token'] : '';
			
			$old_secret_key = (isset($_GET['old_secret_key']) && !empty($_GET['old_secret_key'])) ? $_GET['old_secret_key'] : '';
			$old_access_token = (isset($_GET['old_access_token']) && !empty($_GET['old_access_token'])) ? $_GET['old_access_token'] : '';
			//echo '<pre>GET'; print_r($_GET); die;
			if(!empty($user_name) && !empty($old_secret_key)   && !empty($old_access_token)   && !empty($secret_key)   && !empty($access_token)){
				
				$this->db->where('secret_key',$old_secret_key);
				$this->db->where('access_token',$old_access_token);
				$existUser = $this->query_model->getBySpecific('tbladmin','user',$user_name);
				
				
				if(!empty($existUser)){
					
					$userDataArr = array('is_switched_user'=> 1,'secret_key' => $secret_key,'access_token'=> $access_token);
					$this->query_model->update('tbladmin', $existUser[0]->id, $userDataArr);
				}else{
					$error_msg = 'user-not-found';
				}
				
			}else{
				
				$error_msg = 'empty-fields';
				
			}
			
			
			if(!empty($error_msg)){
				
				$this->db->select('dojo_crm_url');
				$site_setting = $this->query_model->getByTable('tblsite');
				
				redirect($site_setting[0]->dojo_crm_url.'/login?switch_error_code='.$error_msg);
			}
			
			
		}
	}
	
	
public function updateIsSwitchedFieldCRM($userDetail){
	
	if(!empty($userDetail)){
		
		$this->db->select('dojo_crm_url');
		$site_setting = $this->query_model->getByTable('tblsite');
		
		$url = $site_setting[0]->dojo_crm_url.'/web-services/update-switch-field';
		
		
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
