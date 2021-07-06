<?php 
session_start();
require 'vendor/Facebook/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebooklogin extends CI_Controller {

	public function __construct(){
		parent::__construct();

        // To use site_url and redirect on this controller.
        $this->load->helper('url');
		
		$this->load->model("query_model");
	}

	public function login(){
		
		$apiKey = $this->query_model->getbySpecific('tblapikey','id', 1);
		$apiKey = $apiKey[0];
		
		if(!empty($apiKey->facebook_api_id) && !empty($apiKey->facebook_secret_id)){
		
			// init app with app id and secret
			FacebookSession::setDefaultApplication( $apiKey->facebook_api_id,$apiKey->facebook_secret_id );
			// login helper with redirect_uri
			$helper = new FacebookRedirectLoginHelper(site_url('admin/facebooklogin/login'));
			
			try {
			  $session = $helper->getSessionFromRedirect();
			} catch( FacebookRequestException $ex ) {
			  // When Facebook returns an error
			} catch( Exception $ex ) {
			  // When validation fails or other local issues
			}
			
			// see if we have a session
			if ( isset( $session ) ) {
			  // graph api request for user data
			  $request = new FacebookRequest( $session, 'GET', '/me?fields=id,name,first_name,last_name,picture,email' );
			  $response = $request->execute();
			  // get response
			  $graphObject = $response->getGraphObject();
			 
				$fb_id = $graphObject->getProperty('id');              // To Get Facebook ID
				$fb_fullname = $graphObject->getProperty('name'); // To Get Facebook full name
				$fb_email = $graphObject->getProperty('email');
				$fb_first_name = $graphObject->getProperty('first_name');
				$fb_last_name = $graphObject->getProperty('last_name');
				
			  $exitUserRecord = $this->query_model->getbySpecific('tbladmin','facebook_email',$user_email);
			  
			  if(count($exitUserRecord) == 1){
					foreach($exitUserRecord as $row){
						$data = array(
						'user' => $fbfullname,
						'fname' => ucfirst($fb_first_name),
						'lname' => ucfirst($fb_last_name),
						'email' => $fb_email,
						'userid' => $row->id, 
						'user_level' => $row->user_level,
						'is_logged_in' => true,
						'user_type' => 'facebook'
						);
					}
					
					
					$this->session->set_userdata($data);	
					redirect("admin/dashboard");
				} else{
					
					$logoutUrl = $helper->getLogoutUrl($session,site_url('admin/facebooklogin/login'));
					
					
					 $this->session->set_flashdata('facebookError',  '<p class="facebookErrorText">Incorrect Facebook Login</p><p>The facebook login you entered does not have access to this CMS. </p><p>Please try using the facebook account we connected to your CMS.</p><p>Contact Website Dojo Support if you need assistance, <span class="emailAddress"><a href="mailto:support@websitedojo.com?Subject=Incorrect Facebook Login" class="button scroll">support@websitedojo.com</a><span>.</p><p class="logoutFBtext"><a href="'.$logoutUrl.'" TARGET = "_blank" class="facebookLogout">Try Again</a></p><p class="tryAgain" style="display:none;">Try Again</p>');
					
					
					
					redirect('admin/login'); die;
					
				}
				/*	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
					$fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
					$femail = $graphObject->getProperty('email');    // To Get Facebook email ID
					$_SESSION['FBID'] = $fbid;           
					$_SESSION['FULLNAME'] = $fbfullname;
					$_SESSION['EMAIL'] =  $femail; */
				/* ---- header location after session ----*/
			  header("Location: index.php");
			} else {
			  $loginUrl = $helper->getLoginUrl(array(
			   'scope' => 'email'
			 ));
			 header("Location: ".$loginUrl);
			}
		}
		

	}

    
}

