<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebooklogin extends CI_Controller {

	public function __construct(){
		parent::__construct();

        // To use site_url and redirect on this controller.
        $this->load->helper('url');
		$this->load->library('facebook');
		$this->load->model("query_model");
	}

	public function login(){
		//die;
		//$this->load->library('facebook'); // Automatically picks appId and secret from config
        // OR
        // You can pass different one like this
		$apiKey = $this->query_model->getbySpecific('tblapikey','id', 1);
		$apiKey = $apiKey[0];
		
       $this->load->library('facebook', array(
          								  'appId' => $apiKey->facebook_api_id,
          								 'secret' => $apiKey->facebook_secret_id,
								 ));
								 
	/*$this->load->library('facebook', array(
          								  'appId' => '1652310411719618',
          								 'secret' => 'fcad006bd48441fc919a8b8db3d09d8f',
								 ));*/

		$user = $this->facebook->getUser();
		
		//echo $this->facebook->getUser(); die;
    //print_r($user); die;
        if ($user) {
            try {
                $user_profile = $this->facebook->api('/me?fields=name,email');
				$user_email = $user_profile['email'];
				$user_name = explode(' ',$user_profile['name']);
				$exitUserRecord = $this->query_model->getbySpecific('tbladmin','facebook_email',$user_email);
				
				if(count($exitUserRecord) == 1){
					foreach($exitUserRecord as $row){
						$data = array(
						'user' => $user_profile['name'],
						'fname' => ucfirst($user_name[0]),
						'lname' => ucfirst($user_name[1]),
						'email' => $user_profile['email'],
						'userid' => $row->id, 
						'user_level' => $row->user_level,
						'is_logged_in' => true,
						'user_type' => 'facebook'
						);
					}
					
					
					$this->session->set_userdata($data);	
					redirect("admin/dashboard");
				} else{
					$logOut = $this->facebook->getLogoutUrl();
					 $this->session->set_flashdata('facebookError',  '<p class="facebookErrorText">Incorrect Facebook Login</p><p>The facebook login you entered does not have access to this CMS. </p><p>Please try using the facebook account we connected to your CMS.</p><p>Contact Website Dojo Support if you need assistance, <span class="emailAddress"><a href="mailto:support@websitedojo.com?Subject=Incorrect Facebook Login" class="button scroll">support@websitedojo.com</a><span>.</p><p class="logoutFBtext"><a href="'.$logOut.'" TARGET = "_blank" class="facebookLogout">Try Again</a></p><p class="tryAgain" style="display:none;">Try Again</p>');
					
					/*$fb_key = 'fbsr_1652310411719618';
					setcookie($fbkey, '',time()-3600);*/
					
					$this->facebook->destroySession();
					
					redirect('admin/login'); die;
					
				}
					
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }else {
            // Solves first time login issue. (Issue: #10)
           $this->facebook->destroySession();
        }
		
		if ($user) {
			
            $data['logout_url'] = site_url('facebooklogin/logout'); // Logs off application
            // OR 
            // Logs off FB!
            // $data['logout_url'] = $this->facebook->getLogoutUrl();

        } else {
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('admin/facebooklogin/login'), 
                'scope' => array("email") // permissions here
            ));
			
			$this->load->view('admin/facebook_login',$data);
        } 
		//echo '<pre>';print_r($data); die;
       

	}

    public function logout(){
		
        $this->load->library('facebook');

        // Logs off session from website
        $this->facebook->destroySession();
        // Make sure you destory website session as well.

        redirect('admin/login');
    }

}

