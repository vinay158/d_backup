<?php 
//require 'vendor/autoload.php';
//require 'vendor/Mailchimp.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chargify_api extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		//$this->load->model("customcss_model");
		
	}
	
public function index(){
	
	
	$data['user_level']=$this->session->userdata['user_level'];
	$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			
			$chargifyDetail = $this->query_model->getbySpecific('tbl_chargify', 'id', 1);
			
			$chargify_permission = $this->query_model->getOtherPagePermissions($this->session->userdata("userid"), 'admin/chargify_api');
						
			if($chargify_permission == 1 && !empty($chargifyDetail) && $chargifyDetail[0]->type == 1){
				$subdomain = $chargifyDetail[0]->subdomain;
				$subscription_id = $chargifyDetail[0]->subscription_id;
				$sharedKey = $chargifyDetail[0]->shared_key;
				$token = '';
				
				$message = "update_payment--".$subscription_id."--".$sharedKey;
				$token = SHA1($message);
				$tokenNumber = substr($token, 0, 10);
				
				$subscriptionUrl = 'https://'.$subdomain.'.chargify.com/update_payment/'.$subscription_id.'/'.$tokenNumber;
										
				$data['subscriptionUrl'] = $subscriptionUrl;
			
				$this->load->view("admin/chargify_api", $data);
			}else{
				redirect('admin/dashboard');
			}
			
		}else{
			redirect('admin/login');
		}
	}
	

	
}