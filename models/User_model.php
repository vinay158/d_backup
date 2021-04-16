<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{	
	public function validate(){
		$user = (isset($_POST['user']) && !empty($_POST['user'])) ? $_POST['user'] : '';
		$password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : '';
		$rememberMe = isset($_POST['RememberMe']) ? $_POST['RememberMe'] : 0;
		$table = "tbladmin";
		// Vinay 03/11
		
		
		
		if(!empty($user) && !empty($password)){
				
				if($rememberMe == 1){
					setcookie('user', $user, time() + (86400 * 30), "/");
					setcookie('password', $password, time() + (86400 * 30), "/");
					$cookieUser = $_COOKIE['user'];
					$cookiePassword = $_COOKIE['password'];
				}else{
					setcookie('user', '', time() - (120 * 60), "/");
					setcookie('password', '', time() - (120 * 60), "/");
				}
				
				
				$query = $this->query_model->getbyUser($user,$password,$table);
				if(count($query) == 1){
					foreach($query as $row){
						
						$data = array(
						'user' => $row->user,
						'fname' => ucfirst($row->fname),
						'lname' => ucfirst($row->lname),
						'email' => $row->email,
						'userid' => $row->id, 
						'user_level' => $row->user_level,
						'is_logged_in' => true, // vinay 03/11
						'rememberMe' => $rememberMe, // vinay 03/11
						'login_time' => time()
						);
						
						//echo '<pre>'; print_r($data); die;
				
						$this->session->set_userdata($data);
						
						/**** code for switch user ****/
						// get the local secret key
						$str=rand();
						$secret_key = sha1($str);
						$user_access_data = $this->getUserAccessToken($secret_key,$data);
						
						$this->query_model->update('tbladmin', $data['userid'], $user_access_data);
						
						// curl for set data in laravel_crm
						
						$is_switch_to_crm =  $this->query_model->is_switch_to_crm_applied();
						
						if($is_switch_to_crm == 1){
							
							$userDetail = $this->query_model->getBySpecific('tbladmin','id',$data['userid']);
							$userDetail = !empty($userDetail) ? $userDetail[0] : '';
							
							if(!empty($userDetail)){
								$userDataArr = array();
								foreach($userDetail as $key => $val){
									
									if($key == "password"){
										$userDataArr[$key] = $password;
									}else{
										$userDataArr[$key] = $val;
									}
									
									//$userDataArr['_token'] = $this->getLaravalCsrfToken();
									//$userDataArr['_method'] = 'POST';
									$userDataArr['curl_action'] = 'crm_user_create';
								}
								
								$this->saveUserDataInCRM($userDataArr);
								
							}
						}
						
						
					}
				
				
				
				
					return  1;
				}else{
					return  0;
				}
				
			}else{
				return  0;
			}
			
		
		
	}


public function getUserAccessToken($secret, $user_data){
	
	$resultArr = array();
	$resultArr['secret_key'] = $secret;
	$resultArr['login_time'] = $user_data['login_time'];
	
	// Create the token header
	$header = json_encode([
		'typ' => 'JWT',
		'alg' => 'HS256'
	]);

	// Create the token payload
	
	
	$payload = json_encode([
		'user_id' => $user_data['userid'],
		'role' => $user_data['user_level'],
		'exp' => $user_data['login_time']
	]);

	// Encode Header
	$base64UrlHeader = $this->base64UrlEncode($header);

	// Encode Payload
	$base64UrlPayload = $this->base64UrlEncode($payload);

	// Create Signature Hash
	$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);

	// Encode Signature to Base64Url String
	$base64UrlSignature = $this->base64UrlEncode($signature);

	// Create JWT
	$resultArr['access_token'] = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

	return $resultArr;
}

	
public function base64UrlEncode($text){
    return str_replace(
        ['+', '/', '='],
        ['-', '_', ''],
        base64_encode($text)
    );
}
	
public function getLaravalCsrfToken(){
	
	$csrf_token = '';
	
	$this->db->select('dojo_crm_url');
	$site_setting = $this->query_model->getByTable('tblsite');
	
	$url = $site_setting[0]->dojo_crm_url.'/web-services/csrf-token';
	
	//echo '<pre>userDetail'; print_r($userDetail); die;
	
	$ch = curl_init();
	$request = curl_init($url); // initiate curl object
	curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
	//curl_setopt($request, CURLOPT_POSTFIELDS, $userDetail); // use HTTP POST to send form data
	curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
	curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
	
	$response = (string)curl_exec($request); // execute curl post and store results in $response
	$error_msg = curl_error($request);
	curl_close($request); // close curl object
	//echo $response; die;
	if(!empty($response)){
		$csrf_token = $response;
	}
	
	return $csrf_token;
}	

public function saveUserDataInCRM($userDetail){
	
	if(!empty($userDetail)){
		
		$this->db->select('dojo_crm_url');
		$site_setting = $this->query_model->getByTable('tblsite');
		
		$url = $site_setting[0]->dojo_crm_url.'/web-services/create-user';
		
		
		
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
	//	echo '<pre>response'; print_r($response); die;
		if(!empty($response)){
			
		}
	}
	
}

	



public function crossCheckCurlRequest($reffer_url, $site_domain){
	
	$is_spam_request = 1;
	if(!empty($reffer_url)){
		$domain_url = '';
		$pieces = parse_url($reffer_url);
		$domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
		if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
			$domain_url = strtolower($regs['domain']);
			$site_domain = strtolower($site_domain);
			
			if($domain_url == $site_domain){
				$is_spam_request = 0;
			}
		}
	
	}
	
	return $is_spam_request; 
	
}
	

} 
