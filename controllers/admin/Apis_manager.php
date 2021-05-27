<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/sparkpost_autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class Apis_manager extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("sparkpost_mail_model");
		
	}
	
	public function index(){
	
	$data['user_level']=$this->session->userdata['user_level'];
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!empty($is_logged_in) && $is_logged_in == true){
		$data['title'] = "Apis Manager";
		//$data['setting'] = $this->query_model->getbyTable("tblsite");
		$data['apis_spamcheck'] = $this->apis_spamcheck();
		$data['apis_mailchimp'] = $this->apis_mailchimp();
		$data['apis_rainmaker'] = $this->apis_rainmaker();
		$data['apis_perfectmind'] = $this->apis_perfectmind();
		$data['apis_kicksite'] = $this->apis_kicksite();
		$data['apis_mystudio'] = $this->apis_mystudio();
		$data['apis_authorize_net_payment'] = $this->apis_authorize_net_payment();
		$data['apis_braintree_payment'] = $this->apis_braintree_payment();
		$data['apis_active_campaign'] = $this->apis_active_campaign();
		$data['apis_stripe_payment_gateway'] = $this->apis_stripe_payment_gateway();
		$data['apis_stripe_ideal_payment_gateway'] = $this->apis_stripe_ideal_payment_gateway();
		$data['apis_chargify'] = $this->apis_chargify();
		$data['apis_fb_messenger'] = $this->apis_fb_messenger();
		$data['apis_email_marketing'] = $this->apis_email_marketing();
		
		$this->db->select(array('id','api_name','published'));
		$data['webhook_apis'] = $this->query_model->getByTable('tbl_webhook_apis');
		
		$this->db->select(array('id','api_name','published'));
		$data['webhook_apis_incoming_leads'] = $this->query_model->getByTable('tbl_webhook_apis_incoming');
		$data['apis_tinyjpg'] = $this->apis_tinyjpg();
		$data['apis_email_ids_manager'] = $this->apis_email_ids_manager();
		$data['apis_velocify'] = $this->apis_velocify();
		$data['apis_mat'] = $this->apis_mat();
		$data['apis_twilio'] = $this->apis_twilio();
		$data['apis_twilio_chat'] = $this->apis_twilio_chat();
		$data['apis_analytics'] = $this->apis_analytics();
		$data['apis_rank_trackr'] = $this->apis_rank_trackr();
		$data['apis_paypal_payment'] = $this->apis_paypal_payment();
		$data['apis_google_captcha'] = $this->apis_google_captcha();
		$data['apis_sparkpost_mail'] = $this->apis_sparkpost_mail();
		//echo '<pre>'; print_r($data); die;
		
			$this->load->view("admin/api_manager_index", $data);
		}else{
			redirect('admin/login');
		}
	}
	
	public function apis_google_captcha(){
		
		$data['detail'] =  $this->query_model->getbySpecific('tbl_google_captcha', 'id', 1);
			
		if(!empty($data['detail'])){
			$data['detail'] = $data['detail'][0];
		} else{
			$data['detail'] = array();
		}
	
		if(isset($_POST['google_recaptcha_update'])){
			
			if(!empty($data['detail'])){
				
				$updateData['type']  = $_POST['type'];
				$updateData['google_captcha_site_key']  = $_POST['google_captcha_site_key'];
				$updateData['google_captcha_secret_key']  = $_POST['google_captcha_secret_key'];
				$updateData['form_types']  = (isset($_POST['form_types']) && !empty($_POST['form_types'])) ? serialize($_POST['form_types']) : '';
				$this->query_model->update('tbl_google_captcha', 1, $updateData);
			} else{
				
				$insertData['type']  = $_POST['type'];
				$insertData['google_captcha_site_key']  = $_POST['google_captcha_site_key'];
				$insertData['google_captcha_secret_key']  = $_POST['google_captcha_secret_key'];
				$insertData['form_types']  = (isset($_POST['form_types']) && !empty($_POST['form_types'])) ? serialize($_POST['form_types']) : '';
				$this->query_model->insertData('tbl_google_captcha',$insertData);
			}
			
			redirect('admin/apis_manager');
		}
		
		return $data;
	}
	/**
	*  function for Mailchimp API
	*/
	public function apis_mailchimp(){
		
			$data['detail'] =  $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
			
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
			
			$data['template_lists'] = array();
			if(!empty($data['detail']) && $data['detail']->type == 1){
			
				$this->load->library('mailchimp_library');	
				$mailchimp  = new Mailchimp_library($data['detail']->api_key);
				$datacenter = explode('-',$data['detail']->api_key);
				$datacenter = isset($datacenter[1]) ? $datacenter[1] : 'us9';
			
				$listsArray = array();
				$tamplete_lists_data = $this->getMailChampData('https://'.$datacenter.'.api.mailchimp.com/3.0/lists?offset=0&count=100',$data['detail']->api_key,$data['detail']->email,$data['detail']->first_name);
				
					$i = 1;
					if(isset($tamplete_lists_data->lists)){
						foreach($tamplete_lists_data->lists as $template_list){
							$listsArray[$i]['id'] = $template_list->id;
							$listsArray[$i]['name'] = $template_list->name;
							
							$i++;
						}
					}
				
				$data['template_lists'] = $listsArray;
			}
			
			//echo '<pre>POST'; print_r($data['template_lists']); die;
			if(isset($_POST['mailchimp_update'])){
				
				if(!empty($data['detail'])){
					$updateData['type']  = $_POST['type'];
					$updateData['template_id']  = $_POST['template_id'];
					$updateData['api_key']  = $_POST['api_key'];
					$updateData['email']  = $_POST['email'];
					$updateData['first_name']  = $_POST['first_name'];
					$this->query_model->update('tblmailchimp', 1, $updateData);
				} else{
					$insertData['type']  = $_POST['type'];
					$insertData['template_id']  = $_POST['template_id'];
					$insertData['api_key']  = $_POST['api_key'];
					$insertData['email']  = $_POST['email'];
					$insertData['first_name']  = $_POST['first_name'];
					$this->query_model->insertData('tblmailchimp',$insertData);
				}
				
				redirect('admin/apis_manager');
			}
			
			return $data;
	}
	
	

/**
	*  function for Mailchimp API
	*/
	public function apis_spamcheck(){
		
			$data['detail'] =  $this->query_model->getbySpecific('tbl_spam_api', 'id', 1);
			
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
			
			
			
			if(isset($_POST['spamcheck_update'])){
				
				if(!empty($data['detail'])){
					$updateData['type']  = $_POST['type'];
					$updateData['api_key']  = $_POST['api_key'];
					$this->query_model->update('tbl_spam_api', 1, $updateData);
				} else{
					$insertData['type']  = $_POST['type'];
					$insertData['api_key']  = $_POST['api_key'];
					$this->query_model->insertData('tbl_spam_api',$insertData);
				}
				
				redirect('admin/apis_manager');
			}
			
			return $data;
	}
	
	


	
	/**
	*  functions for rainmaker
	**/
	public function apis_rainmaker(){
			
			$this->db->where('id',1);
			$data['multi_location'] =  $this->query_model->getbyTable('tblconfigcalendar');
			
			$data['detail'] =  $this->query_model->getbySpecific('tblrainmaker', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
			//echo '<pre>data'; print_r($data); die;
			
			if(isset($_POST['rainmaker_update'])){
				//echo '<pre>post'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['type']  = isset($_POST['type'])?$_POST['type']:'';
					$updateData['s_id']  = isset($_POST['s_id'])?$_POST['s_id']:'';
					$updateData['api_key']  = isset($_POST['api_key'])?$_POST['api_key']:'';
					$updateData['multi_rainmaker_check']  = isset($_POST['multi_rainmaker_check'])?$_POST['multi_rainmaker_check']:'';
					$updateData['created'] = time();
					
					$this->query_model->update('tblrainmaker', 1, $updateData);
				} else{
					$insertData['type']  = isset($_POST['type'])?$_POST['type']:'';
					$insertData['s_id']  = isset($_POST['s_id'])?$_POST['s_id']:'';
					$insertData['api_key']  = isset($_POST['api_key'])?$_POST['api_key']:'';
					$insertData['multi_rainmaker_check']  = isset($_POST['multi_rainmaker_check'])?$_POST['multi_rainmaker_check']:'';
					$insertData['created'] = time();
					$this->query_model->insertData('tblrainmaker',$insertData);
				}
				redirect('admin/apis_manager');
			}
			
			return $data;
	}
	
	
	public function apis_rank_trackr(){
		
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_rank_trackr', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		
			
			if(isset($_POST['rank_trackr_update'])){
				// '<pre>post'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['type']  = isset($_POST['type'])?$_POST['type']:'';
					$updateData['email']  = isset($_POST['email'])?$_POST['email']:'';
					$updateData['password']  = isset($_POST['password'])?$_POST['password']:'';
					$updateData['search_url']  = isset($_POST['search_url'])?$_POST['search_url']:'';
					
					$this->query_model->update('tbl_rank_trackr', 1, $updateData);
				} else{
					$insertData['type']  = isset($_POST['type'])?$_POST['type']:'';
					$insertData['email']  = isset($_POST['email'])?$_POST['email']:'';
					$insertData['password']  = isset($_POST['password'])?$_POST['password']:'';
					$insertData['search_url']  = isset($_POST['search_url'])?$_POST['search_url']:'';
					
					$this->query_model->insertData('tbl_rank_trackr',$insertData);
				}
				redirect('admin/apis_manager');
			}
			
			return $data;
	}
	
	
	public function apis_analytics(){
		
			
			$data['detail'] =  $this->query_model->getbySpecific('tblgoogleanaytics', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		
			
			if(isset($_POST['analytics_update'])){
				
				$updateData['analytics_report_type']  = isset($_POST['analytics_report_type'])?$_POST['analytics_report_type']:'';
				$updateData['client_id']  = isset($_POST['client_id'])?$_POST['client_id']:'';
				$updateData['client_secret']  = isset($_POST['client_secret'])?$_POST['client_secret']:'';
				
				$this->query_model->update('tblgoogleanaytics', 1, $updateData);
				redirect('admin/apis_manager');
			}
			
			return $data;
	}
	
	/**
	*  functions for perfectmind
	**/
	public function apis_perfectmind(){
			
			$this->db->where('id',1);
			$data['multi_location'] =  $this->query_model->getbyTable('tblconfigcalendar');
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_perfectmind_api', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		
			
			if(isset($_POST['perfectmind_update'])){
				//echo '<pre>post'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['type']  = isset($_POST['type'])?$_POST['type']:0;
					$updateData['subdomain']  = isset($_POST['subdomain'])?$_POST['subdomain']:'';
					$updateData['perfectmind_access_key']  = isset($_POST['perfectmind_access_key'])?$_POST['perfectmind_access_key']:'';
					$updateData['perfectmind_client_number']  = isset($_POST['perfectmind_client_number'])?$_POST['perfectmind_client_number']:'';
					$updateData['multi_perfectmind_check']  = isset($_POST['multi_perfectmind_check'])?$_POST['multi_perfectmind_check']:0;
					//$updateData['created'] = time();
					
					$this->query_model->update('tbl_perfectmind_api', 1, $updateData);
				} else{
					$insertData['type']  = isset($_POST['type'])?$_POST['type']:0;
					$insertData['subdomain']  = isset($_POST['subdomain'])?$_POST['subdomain']:'';
					$insertData['perfectmind_access_key']  = isset($_POST['perfectmind_access_key'])?$_POST['perfectmind_access_key']:'';
					$insertData['perfectmind_client_number']  = isset($_POST['perfectmind_client_number'])?$_POST['perfectmind_client_number']:'';
					$insertData['multi_perfectmind_check']  = isset($_POST['multi_perfectmind_check'])?$_POST['multi_perfectmind_check']:0;
					//$insertData['created'] = time();
					$this->query_model->insertData('tbl_perfectmind_api',$insertData);
				}
				redirect('admin/apis_manager');
			}
			
			return $data;
	}
	
	
	
	
	
	/**
	*  functions for active campaign
	**/
	public function apis_active_campaign(){
		
			$this->db->where('id',1);
			$data['multi_location'] =  $this->query_model->getbyTable('tblconfigcalendar');
			
			$data['active_campagin_lists_list'] = array();
			$data['detail'] =  $this->query_model->getbySpecific('tbl_active_campaign', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
					
					if($data['detail']->type == 1){
						$data['active_campagin_lists_list'] = $this->getActiveCampignLists($data['detail']->account_name,$data['detail']->api_key);
					}
					
					//$data['active_campagin_automation_list'] = $this->getActiveCampignAutomationLists($data['detail']->account_name,$data['detail']->api_key);
					
				} else{
					$data['detail'] = array();
				}
		
			
			if(isset($_POST['active_campaign_update'])){
				//echo '<pre>post'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['type']  = isset($_POST['type'])?$_POST['type']:'';
					$updateData['account_name']  = isset($_POST['account_name'])?$_POST['account_name']:'';
					$updateData['user_name']  = isset($_POST['user_name'])?$_POST['user_name']:'admin';
					$updateData['api_key']  = isset($_POST['api_key'])?$_POST['api_key']:'';
					$updateData['list_id']  = isset($_POST['list_id'])?$_POST['list_id']:0;
					$updateData['automation_id']  = isset($_POST['automation_id'])?$_POST['automation_id']:0;
					//$updateData['multi_active_campaign_check']  = isset($_POST['multi_active_campaign_check'])?$_POST['multi_active_campaign_check']:0;
					$updateData['created'] = time();
					
					$this->query_model->update('tbl_active_campaign', 1, $updateData);
				} else{
					$insertData['type']  = isset($_POST['type'])?$_POST['type']:'';
					$insertData['account_name']  = isset($_POST['account_name'])?$_POST['account_name']:'';
					$insertData['user_name']  = isset($_POST['user_name'])?$_POST['user_name']:'admin';
					$insertData['api_key']  = isset($_POST['api_key'])?$_POST['api_key']:'';
					$insertData['list_id']  = isset($_POST['list_id'])?$_POST['list_id']:0;
					$insertData['automation_id']  = isset($_POST['automation_id'])?$_POST['automation_id']:0;
					//$insertData['multi_active_campaign_check']  = isset($_POST['multi_active_campaign_check'])?$_POST['multi_active_campaign_check']:0;
					$insertData['created'] = time();
					$this->query_model->insertData('tbl_active_campaign',$insertData);
				}
				redirect('admin/apis_manager');
			}
			
			return $data;
	}
	
	
	
	public function apis_kicksite(){
			$this->db->where('id',1);
			$data['multi_location'] =  $this->query_model->getbyTable('tblconfigcalendar');
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_kicksite', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['kicksite_update'])){
					
					if(!empty($data['detail'])){
						$updateData['type']  = isset($_POST['type'])?$_POST['type']:'';
						$updateData['ks_url']  = isset($_POST['ks_url'])?$_POST['ks_url']:'';
						$updateData['ks_token']  = isset($_POST['ks_token'])?$_POST['ks_token']:'';
						$updateData['multi_kicksite_check']  = isset($_POST['multi_kicksite_check'])?$_POST['multi_kicksite_check']:'0';
						$updateData['created'] = time();
						
						$this->query_model->update('tbl_kicksite', 1, $updateData);
					} else{
						$insertData['type']  = isset($_POST['type'])?$_POST['type']:'';
						$insertData['ks_url']  = isset($_POST['ks_url'])?$_POST['ks_url']:'';
						$insertData['ks_token']  = isset($_POST['ks_token'])?$_POST['ks_token']:'';
						$insertData['multi_kicksite_check']  = isset($_POST['multi_kicksite_check'])?$_POST['multi_kicksite_check']:'0';
						$insertData['created'] = time();
						$this->query_model->insertData('tbl_kicksite',$insertData);
					}
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	public function apis_mystudio(){
		
			$this->db->where('id',1);
			
			$data['multi_location'] =  $this->query_model->getbyTable('tblconfigcalendar');
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_mystudio', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['mystudio_update'])){
					
					if(!empty($data['detail'])){
						$updateData['type']  = isset($_POST['type'])?$_POST['type']:'';
						$updateData['ms_url']  = isset($_POST['ms_url'])?$_POST['ms_url']:'';
						$updateData['multi_mystudio_check']  = isset($_POST['multi_mystudio_check'])?$_POST['multi_mystudio_check']:'0';
						$updateData['created'] = date('Y-m-d H:i:s');
						
						$this->query_model->update('tbl_mystudio', 1, $updateData);
					} else{
						$insertData['type']  = isset($_POST['type'])?$_POST['type']:'';
						$insertData['ms_url']  = isset($_POST['ms_url'])?$_POST['ms_url']:'';
						$insertData['multi_mystudio_check']  = isset($_POST['multi_mystudio_check'])?$_POST['multi_mystudio_check']:'0';
						$insertData['created'] =  date('Y-m-d H:i:s');
						$this->query_model->insertData('tbl_mystudio',$insertData);
					}
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	public function apis_velocify(){
			//$data['multi_location'] =  $this->query_model->getbyTable('tblconfigcalendar');
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_velocify', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['velocify_update'])){
					
					if(!empty($data['detail'])){
						$updateData['type']  = isset($_POST['type'])?$_POST['type']:0;
						$updateData['url']  = isset($_POST['url'])?$_POST['url']:'';
						
						$this->query_model->update('tbl_velocify', 1, $updateData);
					} else{
						$insertData['type']  = isset($_POST['type'])?$_POST['type']:0;
						$insertData['url']  = isset($_POST['url'])?$_POST['url']:'';
						$this->query_model->insertData('tbl_velocify',$insertData);
					}
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	public function apis_mat(){
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_mat_api', 'id', 1);
			
			$this->db->select(array('id','name'));
			$data['allContacts'] = $this->query_model->getbyTable("tblcontact");
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		
			
				
				if(isset($_POST['mat_update'])){
					//echo '<pre>POST'; print_r($_POST); die;
					if(!empty($data['detail'])){
						$updateData['type']  = isset($_POST['type'])?$_POST['type']:0;
						$updateData['url']  = isset($_POST['url'])?$_POST['url']:'';
						$updateData['username']  = isset($_POST['username'])?$_POST['username']:'';
						$updateData['password']  = isset($_POST['password'])?$_POST['password']:'';
						$updateData['club_id']  = (isset($_POST['club_id']) && !empty($_POST['club_id']))?$_POST['club_id']:0;
						$updateData['api_mode']  = isset($_POST['api_mode'])?$_POST['api_mode']:'';
						$updateData['location_club_id']  = (isset($_POST['location_club_id']) && !empty($_POST['location_club_id']))?serialize($_POST['location_club_id']):'';
						$updateData['map_categories']  = isset($_POST['mat_cats'])?serialize($_POST['mat_cats']):'';
						$updateData['default_cat_id']  = (isset($_POST['default_cat_id']) && !empty($_POST['default_cat_id']))?$_POST['default_cat_id']:0;
						$updateData['multi_mat_check']  = (isset($_POST['multi_mat_check']) && !empty($_POST['multi_mat_check']))?$_POST['multi_mat_check']:0;
						
						$this->query_model->update('tbl_mat_api', 1, $updateData);
					} else{
						$insertData['type']  = isset($_POST['type'])?$_POST['type']:0;
						$insertData['url']  = isset($_POST['url'])?$_POST['url']:'';
						$insertData['username']  = isset($_POST['username'])?$_POST['username']:'';
						$insertData['password']  = isset($_POST['password'])?$_POST['password']:'';
						$insertData['club_id']  = (isset($_POST['club_id']) && !empty($_POST['club_id']))?$_POST['club_id']:0;
						$insertData['api_mode']  = isset($_POST['api_mode'])?$_POST['api_mode']:'';
						$insertData['map_categories']  = isset($_POST['mat_cats'])?serialize($_POST['mat_cats']):'';
						$insertData['default_cat_id']  = (isset($_POST['default_cat_id']) && !empty($_POST['default_cat_id']))?$_POST['default_cat_id']:0;
						$insertData['multi_mat_check']  = (isset($_POST['multi_mat_check']) && !empty($_POST['multi_mat_check']))?$_POST['multi_mat_check']:0;
						$insertData['location_club_id']  = (isset($_POST['location_club_id']) && !empty($_POST['location_club_id']))?serialize($_POST['location_club_id']):'';
						
						$this->query_model->insertData('tbl_mat_api',$insertData);
					}
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	public function apis_paypal_payment(){
			
			$data['detail'] = $this->query_model->getbySpecific('tbl_payments','id', 1);
			$data['detail'] = $data['detail'][0];
			
			
			if(isset($_POST['paypalPaymentUpdate'])){
				//echo '<pre>'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['paypal_payment']  = $_POST['paypal_payment'];
					$updateData['paypal_client_id']  = $_POST['paypal_client_id'];
					$updateData['paypal_secret_key']  = $_POST['paypal_secret_key'];
					$updateData['paypal_payment_mode']  = isset($_POST['paypal_payment_mode']) ? $_POST['paypal_payment_mode'] : 'sandbox';
					
					if($_POST['paypal_payment'] == 1){
						$updateData['braintree_payment']  = 0;
						$updateData['stripe_payment']  = 0;
						$updateData['stripe_ideal_payment']  = 0;
						$updateData['authorize_net_payment']  = 0;
					}
					
					
					$this->query_model->update('tbl_payments', 1, $updateData);
					
					if($_POST['paypal_payment'] == 0 && $data['detail']->braintree_payment == 0 && $data['detail']->stripe_payment == 0 && $data['detail']->stripe_ideal_payment == 0 && $data['detail']->authorize_net_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
				}else{
					
					$insertData['paypal_payment']  = $_POST['paypal_payment'];
					$insertData['paypal_client_id']  = $_POST['paypal_client_id'];
					$insertData['paypal_secret_key']  = $_POST['paypal_secret_key'];
					$insertData['paypal_payment_mode']  = isset($_POST['paypal_payment_mode']) ? $_POST['paypal_payment_mode'] : 'sandbox';
					
					//echo 'hello2'; die;
					$this->query_model->insertData('tbl_payments',$insertData);
					
					if($_POST['paypal_payment'] == 0 && $data['detail']->braintree_payment == 0 && $data['detail']->stripe_payment == 0 && $data['detail']->stripe_ideal_payment == 0 && $data['detail']->authorize_net_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
					
				}
				
				redirect('admin/apis_manager');
			}
			
		return $data;
	}
	
	public function apis_authorize_net_payment(){
			
			$data['detail'] = $this->query_model->getbySpecific('tbl_payments','id', 1);
			$data['detail'] = $data['detail'][0];
			
			
			if(isset($_POST['authorizePaymentUpdate'])){
				//echo '<pre>'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['authorize_net_payment']  = $_POST['authorize_net_payment'];
					$updateData['authorize_loginkey']  = $_POST['authorize_loginkey'];
					$updateData['authorize_transkey']  = $_POST['authorize_transkey'];
					$updateData['authorize_payment_mode']  = isset($_POST['authorize_payment_mode']) ? $_POST['authorize_payment_mode'] : 'sandbox';
					
					if($_POST['authorize_net_payment'] == 1){
						$updateData['braintree_payment']  = 0;
						$updateData['stripe_payment']  = 0;
						$updateData['stripe_ideal_payment']  = 0;
						$updateData['paypal_payment']  = 0;
					}
					
					
					$this->query_model->update('tbl_payments', 1, $updateData);
					
					if($_POST['authorize_net_payment'] == 0 && $data['detail']->braintree_payment == 0 && $data['detail']->stripe_payment == 0 && $data['detail']->stripe_ideal_payment == 0 && $data['detail']->paypal_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
				}else{
					$insertData['authorize_net_payment']  = $_POST['authorize_net_payment'];
					$insertData['authorize_loginkey']  = $_POST['authorize_loginkey'];
					$insertData['authorize_transkey']  = $_POST['authorize_transkey'];
					$insertData['authorize_payment_mode']  = isset($_POST['authorize_payment_mode']) ? $_POST['authorize_payment_mode'] : 'sandbox';
					//echo 'hello2'; die;
					$this->query_model->insertData('tbl_payments',$insertData);
					
					if($_POST['authorize_net_payment'] == 0 && $data['detail']->braintree_payment == 0 && $data['detail']->stripe_payment == 0 && $data['detail']->stripe_ideal_payment == 0 && $data['detail']->paypal_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
					
				}
				
				redirect('admin/apis_manager');
			}
			
		return $data;
	}
	
	
	public function apis_braintree_payment(){
			
			
			$data['detail'] = $this->query_model->getbySpecific('tbl_payments','id', 1);
			$data['detail'] = $data['detail'][0];
			
			if(isset($_POST['braintreePaymentUpdate'])){
				//echo '<pre>'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['braintree_payment']  = $_POST['braintree_payment'];
					$updateData['braintree_merchant_id']  = $_POST['braintree_merchant_id'];
					$updateData['braintree_public_key']  = $_POST['braintree_public_key'];
					$updateData['braintree_private_key']  = $_POST['braintree_private_key'];
					$updateData['braintree_payment_mode']  = isset($_POST['braintree_payment_mode']) ? $_POST['braintree_payment_mode'] : 'sandbox';
					
					if( $_POST['braintree_payment'] == 1){
						$updateData['authorize_net_payment']  = 0;
						$updateData['stripe_payment']  = 0;
						$updateData['stripe_ideal_payment']  = 0;
						$updateData['paypal_payment']  = 0;
					}
					
					
					$this->query_model->update('tbl_payments', 1, $updateData);
					
					if( $data['detail']->authorize_net_payment == 0 && $_POST['braintree_payment'] == 0 && $data['detail']->stripe_payment == 0 && $data['detail']->stripe_ideal_payment == 0 && $data['detail']->paypal_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
				}else{
					$insertData['braintree_payment']  = $_POST['braintree_payment'];
					$insertData['braintree_merchant_id']  = $_POST['braintree_merchant_id'];
					$insertData['braintree_public_key']  = $_POST['braintree_public_key'];
					$insertData['braintree_private_key']  = $_POST['braintree_private_key'];
					$insertData['braintree_payment_mode']  = isset($_POST['braintree_payment_mode']) ? $_POST['braintree_payment_mode'] : 'sandbox';
					//echo 'hello2'; die;
					$this->query_model->insertData('tbl_payments',$insertData);
					
					if($data['detail']->authorize_net_payment == 0 && $_POST['braintree_payment'] == 0 && $data['detail']->stripe_payment == 0 && $data['detail']->stripe_ideal_payment == 0 && $data['detail']->paypal_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
					
				}
				
				redirect('admin/apis_manager');
			}
		return $data;
	}
	
	
	
	public function apis_stripe_payment_gateway(){
			
			$data['detail'] = $this->query_model->getbySpecific('tbl_payments','id', 1);
			$data['detail'] = $data['detail'][0];
			
			
			if(isset($_POST['stripePaymentUpdate'])){
				//echo '<pre>'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['stripe_payment']  = $_POST['stripe_payment'];
					$updateData['stripe_secret_key']  = $_POST['stripe_secret_key'];
					$updateData['stripe_publishable_key']  = $_POST['stripe_publishable_key'];
					$updateData['stripe_payment_mode']  = isset($_POST['stripe_payment_mode']) ? $_POST['stripe_payment_mode'] : 'sandbox';
					$updateData['multi_stripe_check']  = isset($_POST['multi_stripe_check']) ? $_POST['multi_stripe_check'] : 0;
					$updateData['stripe_sca_payment']  = isset($_POST['stripe_sca_payment']) ? $_POST['stripe_sca_payment'] : 0;
						
					if($_POST['stripe_payment'] == 1){
						$updateData['braintree_payment']  = 0;
						$updateData['authorize_net_payment']  = 0;
						$updateData['stripe_ideal_payment']  = 0;
						$updateData['paypal_payment']  = 0;
					}
					
					
					$this->query_model->update('tbl_payments', 1, $updateData);
					
					if($_POST['stripe_payment'] == 0 && $data['detail']->braintree_payment == 0 && $data['detail']->authorize_net_payment == 0 && $data['detail']->stripe_ideal_payment == 0 && $data['detail']->paypal_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
				}else{
					$insertData['stripe_payment']  = $_POST['stripe_payment'];
					$insertData['stripe_secret_key']  = $_POST['stripe_secret_key'];
					$insertData['stripe_publishable_key']  = $_POST['stripe_publishable_key'];
					$insertData['stripe_payment_mode']  = isset($_POST['stripe_payment_mode']) ? $_POST['stripe_payment_mode'] : 'sandbox';
					$insertData['multi_stripe_check']  = isset($_POST['multi_stripe_check']) ? $_POST['multi_stripe_check'] : 0;
					$insertData['stripe_sca_payment']  = isset($_POST['stripe_sca_payment']) ? $_POST['stripe_sca_payment'] : 0;
					
					//echo 'hello2'; die;
					$this->query_model->insertData('tbl_payments',$insertData);
					
					if($_POST['stripe_payment'] == 0 && $data['detail']->braintree_payment == 0 && $data['detail']->authorize_net_payment == 0 && $data['detail']->stripe_ideal_payment == 0 && $data['detail']->paypal_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
					
				}
				
				redirect('admin/apis_manager');
			}
			
		return $data;
	}
	
		
	
		public function apis_stripe_ideal_payment_gateway(){
			
			$data['detail'] = $this->query_model->getbySpecific('tbl_payments','id', 1);
			$data['detail'] = $data['detail'][0];
			
			
			if(isset($_POST['stripeIdealPaymentUpdate'])){
				//echo '<pre>'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['stripe_ideal_payment']  = $_POST['stripe_ideal_payment'];
					$updateData['stripe_ideal_secret_key']  = $_POST['stripe_ideal_secret_key'];
					$updateData['stripe_ideal_publishable_key']  = $_POST['stripe_ideal_publishable_key'];
					$updateData['stripe_ideal_payment_mode']  = isset($_POST['stripe_ideal_payment_mode']) ? $_POST['stripe_ideal_payment_mode'] : 'sandbox';
					//$updateData['multi_stripe_ideal_check']  = isset($_POST['multi_stripe_ideal_check']) ? $_POST['multi_stripe_ideal_check'] : 0;
						
					if($_POST['stripe_ideal_payment'] == 1){
						$updateData['braintree_payment']  = 0;
						$updateData['authorize_net_payment']  = 0;
						$updateData['stripe_payment']  = 0;
						$updateData['paypal_payment']  = 0;
					}
					
					
					$this->query_model->update('tbl_payments', 1, $updateData);
					
					if($_POST['stripe_ideal_payment'] == 0 && $data['detail']->braintree_payment == 0 && $data['detail']->authorize_net_payment == 0 && $data['detail']->stripe_payment == 0 && $data['detail']->paypal_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
				}else{
					$insertData['stripe_ideal_payment']  = $_POST['stripe_ideal_payment'];
					$insertData['stripe_ideal_secret_key']  = $_POST['stripe_ideal_secret_key'];
					$insertData['stripe_ideal_publishable_key']  = $_POST['stripe_ideal_publishable_key'];
					$insertData['stripe_ideal_payment_mode']  = isset($_POST['stripe_ideal_payment_mode']) ? $_POST['stripe_ideal_payment_mode'] : 'sandbox';
					//$insertData['multi_stripe_ideal_check']  = isset($_POST['multi_stripe_ideal_check']) ? $_POST['multi_stripe_ideal_check'] : 0;
					
					//echo 'hello2'; die;
					$this->query_model->insertData('tbl_payments',$insertData);
					
					if($_POST['stripe_ideal_payment'] == 0 && $data['detail']->braintree_payment == 0 && $data['detail']->authorize_net_payment == 0 && $data['detail']->stripe_payment == 0 && $data['detail']->paypal_payment == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData($this->query_model->getTrialSpecialOffersTableName(),'id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
					
				}
				
				redirect('admin/apis_manager');
			}
			
		return $data;
	}
	
	
	
	// other relative function to apis		
		
 function getMailChampData($url, $apikey, $email, $fname){
	
			
		//$apikey = '38416ee8dfba9d6ccf0f8359705cbb5c-us9';
		//$email = 'info@websitedojo.com';
        $auth = base64_encode( 'user:'.$apikey );
		
		$datacenter = explode('-',$apikey);
		$datacenter = isset($datacenter[1]) ? $datacenter[1] : 'us9';
		

        $data = array(
            'apikey'        => $apikey,
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => array(
                'FNAME' => $fname
            )
        );
        $json_data = json_encode($data);
		//https://us9.api.mailchimp.com/3.0/campaigns?offset=0&count=10
		 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://'.$datacenter.'.api.mailchimp.com/3.0/lists?offset=0&count=1000');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$auth));
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                                                                                  

        $result = curl_exec($ch);
	
		return json_decode($result);
	}
	
	
	
	public function get_rainmark_data($url) {
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
	}	

	public function getActiveCampignAutomationLists($account_name, $api_key){
		
					$listsArray = array();
					error_reporting(0);
					define("ACTIVECAMPAIGN_URL", "https://".$account_name.".api-us1.com");
					define("ACTIVECAMPAIGN_API_KEY", $api_key);
					$this->load->library('activecampaign/includes/ActiveCampaign');
					//require_once("../activecampaign-api-php/includes/ActiveCampaign.class.php");
					$ac = new ActiveCampaign(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);
					$automations = $ac->api("automation/list?offset=0&limit=500");
			
					if(!empty($automations)){
						$listsArray = array();
						$i = 1;
						foreach($automations as $automation_list){
							if(isset($automation_list->id) && isset($automation_list->name) ){
								$listsArray[$i]['id'] = $automation_list->id;
								$listsArray[$i]['name'] = $automation_list->name;
							}
							$i++;
						}
					}
					
			return $listsArray;
	} 
	
	public function getActiveCampignLists($account_name, $api_key){
		$listsArray = array();
					error_reporting(0);
					
				// By default, this sample code is designed to get the result from your ActiveCampaign installation and print out the result
				$url = 'http://'.$account_name.'.api-us1.com';
				
				$params = array(

					// the API Key can be found on the "Your Settings" page under the "API" tab.
					// replace this with your API Key
					'api_key'      => $api_key,

					// this is the action that fetches a list info based on the ID you provide
					'api_action'   => 'list_list',

					// define the type of output you wish to get back
					// possible values:
					// - 'xml'  :      you have to write your own XML parser
					// - 'json' :      data is returned in JSON format and can be decoded with
					//                 json_decode() function (included in PHP since 5.2.0)
					// - 'serialize' : data is returned in a serialized format and can be decoded with
					//                 a native unserialize() function
					'api_output'   => 'serialize',

					// a comma-separated list of IDs of lists you wish to fetch
					'ids'          => 'all',

					// filters: supply filters that will narrow down the results
					//'filters[name]'      => 'General',  // perform a pattern match (LIKE) for List Name

					// include global custom fields? by default, it does not
					//'global_fields'      => true,

					// whether or not to return ALL data, or an abbreviated portion (set to 0 for abbreviated)
					'full'         => 0,
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
					die('JSON not supported. (introduced in PHP 5.2.0)');
				}

				// define a final API request - GET
				$api = $url . '/admin/api.php?' . $query;

				$request = curl_init($api); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

				$response = (string)curl_exec($request); // execute curl fetch and store results in $response

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

				// Result info that is always returned
				if(isset($result['result_code']) && $result['result_code'] == 1){
					$i = 1;
						foreach($result as $list){
							if(isset($list['id']) && isset($list['name']) ){
								$listsArray[$i]['id'] = $list['id'];
								$listsArray[$i]['name'] = $list['name'];
							}
							$i++;
						}
				}
			
			return $listsArray;
	}
	
	
	
	
	/********** Webhook Apis ***********/
	
	public function addWebhookApi(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = "Add Webhook Api";
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		$data['multiWebhook'] = $this->query_model->checkMultiWebhookIsOn();
		
		if($data['multiSchool'] == 1){
			$this->db->where("main_location", 0);
		}
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$this->db->select(array('id','api_name'));
		$this->db->where('parent_id',0);
		$data['allWebhooks'] = $this->query_model->getbyTable("tbl_webhook_apis");
		
		
		
		
			if(isset($_POST['update'])):
				$postData['api_name'] = isset($_POST['api_name']) ? trim($_POST['api_name']) : '';
				$postData['api_url'] = isset($_POST['api_url']) ? trim($_POST['api_url']) : '';
				$postData['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
				$postData['api_method'] = isset($_POST['api_method']) ? $_POST['api_method'] : 'POST';
				
				
				$postData['name_key'] = !empty($_POST['first_name']) ? $_POST['first_name'] : '';
				$postData['last_name_key'] = !empty($_POST['last_name']) ? $_POST['last_name'] : '';
				$postData['email_key'] = !empty($_POST['email']) ? $_POST['email'] : '';
				$postData['phone_key'] = !empty($_POST['phone']) ? $_POST['phone'] : '';
				$postData['location_key'] = !empty($_POST['location']) ? $_POST['location'] : '';
				$postData['message_key'] = !empty($_POST['message']) ? $_POST['message'] : '';
				$postData['program_key'] = !empty($_POST['program']) ? $_POST['program'] : '';
				$postData['tag_key'] = !empty($_POST['tag']) ? $_POST['tag'] : '';
				$postData['trial_name_key'] = !empty($_POST['trial_name']) ? $_POST['trial_name'] : '';
				$postData['trial_type_key'] = !empty($_POST['trial_type']) ? $_POST['trial_type'] : '';
				$postData['total_amount_key'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '';
				$postData['page_url_key'] = !empty($_POST['page_url']) ? $_POST['page_url'] : '';
				//$postData['tag_values'] = !empty($_POST['tag_values']) ? $_POST['tag_values'] : '';
				$postData['api_type'] = isset($_POST['api_type']) ? $_POST['api_type'] : '';
				$postData['parent_id'] = (isset($_POST['parent_id']) && !empty($_POST['parent_id'])) ? $_POST['parent_id'] : 0;
				$postData['location_id'] = (isset($_POST['location_id']) && !empty($_POST['location_id'])) ? $_POST['location_id'] : 0;
				
				$postData['created'] = date('Y-m-d h:i:s');
				
				$this->db->insert('tbl_webhook_apis',$postData);
				$lastInsertedId  = $this->db->insert_id();
				if($lastInsertedId > 0 ){
					if(isset($_POST['apiKeyValue']) && !empty($_POST['apiKeyValue'])){
						foreach($_POST['apiKeyValue'] as $apiKeyValue){
							if(!empty($apiKeyValue['key']) && !empty($apiKeyValue['value'])){
								$postData2['webook_api_id'] = $lastInsertedId;
								$postData2['keys'] = $apiKeyValue['key'];
								$postData2['values'] = $apiKeyValue['value'];
								
								$this->db->insert('tbl_webhook_api_key_value',$postData2);
							}
							
						}
					}
				}
				redirect("admin/apis_manager/#webhook-api");
			endif;
			$this->load->view("admin/add_webhook_api", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	
	
	
	public function editWebhookApi(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true &&  $this->uri->segment(4) != NULL )
		{
		$data['title'] = "Edit Webhook Api";
		
		$data['webhook_api_detail'] = $this->query_model->getbySpecific('tbl_webhook_apis','id', $this->uri->segment(4));
		$data['webhook_api_detail'] = $data['webhook_api_detail'][0];
		
		$data['webhook_api_detail_key_values'] = $this->query_model->getbySpecific('tbl_webhook_api_key_value','webook_api_id', $this->uri->segment(4));
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		$data['multiWebhook'] = $this->query_model->checkMultiWebhookIsOn();
		
		if($data['multiSchool'] == 1){
			$this->db->where("main_location", 0);
		}
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$this->db->select(array('id','api_name'));
		$this->db->where('parent_id',0);
		$data['allWebhooks'] = $this->query_model->getbyTable("tbl_webhook_apis");
		//echo '<pre>webhook'; print_r($_POST); die;
		
			if(isset($_POST['update'])):
				$postData['api_name'] = isset($_POST['api_name']) ? trim($_POST['api_name']) : '';
				$postData['api_url'] = isset($_POST['api_url']) ? trim($_POST['api_url']) : '';
				$postData['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
				$postData['api_method'] = isset($_POST['api_method']) ? $_POST['api_method'] : 'POST';
				$postData['created'] = date('Y-m-d h:i:s');
				
				$postData['name_key'] = !empty($_POST['first_name']) ? $_POST['first_name'] : '';
				$postData['last_name_key'] = !empty($_POST['last_name']) ? $_POST['last_name'] : '';
				$postData['email_key'] = !empty($_POST['email']) ? $_POST['email'] : '';
				$postData['phone_key'] = !empty($_POST['phone']) ? $_POST['phone'] : '';
				$postData['location_key'] = !empty($_POST['location']) ? $_POST['location'] : '';
				$postData['message_key'] = !empty($_POST['message']) ? $_POST['message'] : '';
				$postData['program_key'] = !empty($_POST['program']) ? $_POST['program'] : '';
				$postData['trial_name_key'] = !empty($_POST['trial_name']) ? $_POST['trial_name'] : '';
				$postData['trial_type_key'] = !empty($_POST['trial_type']) ? $_POST['trial_type'] : '';
				$postData['total_amount_key'] = !empty($_POST['total_amount']) ? $_POST['total_amount'] : '';
				$postData['page_url_key'] = !empty($_POST['page_url']) ? $_POST['page_url'] : '';
				$postData['tag_key'] = !empty($_POST['tag']) ? $_POST['tag'] : '';
				//$postData['tag_values'] = !empty($_POST['tag_values']) ? $_POST['tag_values'] : '';
				$postData['api_type'] = isset($_POST['api_type']) ? $_POST['api_type'] : '';
				$postData['parent_id'] = (isset($_POST['parent_id']) && !empty($_POST['parent_id'])) ? $_POST['parent_id'] : 0;
				$postData['location_id'] = (isset($_POST['location_id']) && !empty($_POST['location_id'])) ? $_POST['location_id'] : 0;
				
				
				//echo '<pre>'; print_r($postData); die;
				
				$this->query_model->updateData('tbl_webhook_apis','id',$this->uri->segment(4), $postData);
				
				$this->query_model->deletebySpecific('tbl_webhook_api_key_value','webook_api_id',$this->uri->segment(4));
					if(isset($_POST['apiKeyValue']) && !empty($_POST['apiKeyValue'])){
						
						foreach($_POST['apiKeyValue'] as $apiKeyValue){
							if(!empty($apiKeyValue['key']) && !empty($apiKeyValue['value'])){
								$postData2['webook_api_id'] = $this->uri->segment(4);
								$postData2['keys'] = $apiKeyValue['key'];
								$postData2['values'] = $apiKeyValue['value'];
								
								$this->db->insert('tbl_webhook_api_key_value',$postData2);
							}
							
						}
					}
				redirect("admin/apis_manager/#webhook-api");
			endif;
			$this->load->view("admin/edit_webhook_api", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	
	public function publishWebhookApi(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tbl_webhook_apis", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	
		public function deleteitemWebhookApi(){
			$id = $_POST['delete-item-id'];
			$this->db->where("id", $id);
			if($this->db->delete("tbl_webhook_apis"))
			{
				
				$this->query_model->deletebySpecific('tbl_webhook_api_key_value','webook_api_id',$id);
			
				redirect("admin/apis_manager/#webhook-api");
			}
			else
			{
			echo "<script language='javascript'>alert('Unable to delete webhook api');</script>";
			redirect("admin/apis_manager/#webhook-api");
			}
		}
		
			
	
	public function apis_email_ids_manager(){
			$this->db->select(array('from_email','replyto_email','cc_email'));
			$data['detail'] =  $this->query_model->getbySpecific('tblsite', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['email_ids_manager_update'])){
					
					if(!empty($data['detail'])){
						$updateData['from_email']  = isset($_POST['from_email'])?$_POST['from_email']:'';
						$updateData['replyto_email']  = isset($_POST['replyto_email'])?$_POST['replyto_email']:'';
						$updateData['cc_email']  = isset($_POST['cc_email'])?$_POST['cc_email']:'';
						
						$this->query_model->update('tblsite', 1, $updateData);
					}  
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	public function apis_tinyjpg(){
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_chargify', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['tinyjpg_update'])){
					
					if(!empty($data['detail'])){
						$updateData['tinyjpg_key']  = isset($_POST['tinyjpg_key'])?$_POST['tinyjpg_key']:'';
						
						$this->query_model->update('tbl_chargify', 1, $updateData);
					} else{
						$insertData['tinyjpg_key']  = isset($_POST['tinyjpg_key'])?$_POST['tinyjpg_key']:'';
						
						$this->query_model->insertData('tbl_chargify',$insertData);
					} 
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	public function apis_email_marketing(){
			
			$this->db->select(array('email_marketing'));
			$data['detail'] =  $this->query_model->getbyTable("tblsite");
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['email_marketing_update'])){
					//echo '<pre>POST'; print_r($_POST); die;
					if(!empty($data['detail'])){
						$updateData['email_marketing']  = isset($_POST['email_marketing'])?$_POST['email_marketing']: 0;
						$this->query_model->update('tblsite', 1, $updateData);
					}
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	public function apis_chargify(){
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_chargify', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['chargify_update'])){
					
					if(!empty($data['detail'])){
						$updateData['type']  = isset($_POST['type'])?$_POST['type']:'';
						$updateData['subdomain']  = isset($_POST['subdomain'])?$_POST['subdomain']:'';
						$updateData['shared_key']  = isset($_POST['shared_key'])?$_POST['shared_key']:'';
						$updateData['subscription_id']  = isset($_POST['subscription_id'])?$_POST['subscription_id']:'';
						
						$this->query_model->update('tbl_chargify', 1, $updateData);
					} else{
						$insertData['type']  = isset($_POST['type'])?$_POST['type']:'';
						$insertData['subdomain']  = isset($_POST['subdomain'])?$_POST['subdomain']:'';
						$insertData['shared_key']  = isset($_POST['shared_key'])?$_POST['shared_key']:'';
						$insertData['subscription_id']  = isset($_POST['subscription_id'])?$_POST['subscription_id']:'';
						
						$this->query_model->insertData('tbl_chargify',$insertData);
					} 
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	
	public function apis_fb_messenger(){
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_fb_messenger', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['fb_messenger_update'])){
					
					if(!empty($data['detail'])){
						$updateData['type']  = isset($_POST['type'])?$_POST['type']:0;
						$updateData['app_id']  = isset($_POST['app_id'])?$_POST['app_id']:'';
						$updateData['page_id']  = isset($_POST['page_id'])?$_POST['page_id']:'';
						
						$this->query_model->update('tbl_fb_messenger', 1, $updateData);
					} else{
						$insertData['type']  = isset($_POST['type'])?$_POST['type']:0;
						$insertData['app_id']  = isset($_POST['app_id'])?$_POST['app_id']:'';
						$insertData['page_id']  = isset($_POST['page_id'])?$_POST['page_id']:'';
						
						$this->query_model->insertData('tbl_fb_messenger',$insertData);
					} 
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	
	
	public function apis_twilio(){
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_twilio', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['twilio_update'])){
					
					if(!empty($data['detail'])){
						$updateData['type']  = isset($_POST['type'])?$_POST['type']:0;
						$updateData['checkbox_text']  = (isset($_POST['checkbox_text']) && !empty($_POST['checkbox_text'])) ? $_POST['checkbox_text']:'';
						//$updateData['ac_tag_name']  = (isset($_POST['ac_tag_name']) && !empty($_POST['ac_tag_name'])) ? $_POST['ac_tag_name']:'';
						$updateData['sid']  = (isset($_POST['sid']) && !empty($_POST['sid'])) ? $_POST['sid']:'';
						$updateData['token']  = (isset($_POST['token']) && !empty($_POST['token'])) ? $_POST['token']:'';
						$updateData['from_phone_number']  = (isset($_POST['from_phone_number']) && !empty($_POST['from_phone_number'])) ? $_POST['from_phone_number']:'';
						$updateData['multi_twilio_check']  = (isset($_POST['multi_twilio_check']) && !empty($_POST['multi_twilio_check'])) ? $_POST['multi_twilio_check']: 0;
						$updateData['twilio_cell_number']  = (isset($_POST['twilio_cell_number']) && !empty($_POST['twilio_cell_number'])) ? $_POST['twilio_cell_number']: '';
						
						if($updateData['type'] == 0){
							$updateData['send_admin_msg'] = 0;
							$updateData['send_user_msg'] = 0;
						}
						
						$this->query_model->update('tbl_twilio',1, $updateData);
					} else{
						$insertData['type']  = isset($_POST['type'])?$_POST['type']:0;
						$insertData['checkbox_text']  = (isset($_POST['checkbox_text']) && !empty($_POST['checkbox_text'])) ? $_POST['checkbox_text']:'';
						$insertData['ac_tag_name']  = (isset($_POST['ac_tag_name']) && !empty($_POST['ac_tag_name'])) ? $_POST['ac_tag_name']:'';
						$insertData['sid']  = (isset($_POST['sid']) && !empty($_POST['sid'])) ? $_POST['sid']:'';
						$insertData['token']  = (isset($_POST['token']) && !empty($_POST['token'])) ? $_POST['token']:'';
						$insertData['from_phone_number']  = (isset($_POST['from_phone_number']) && !empty($_POST['from_phone_number'])) ? $_POST['from_phone_number']:'';
						$insertData['multi_twilio_check']  = (isset($_POST['multi_twilio_check']) && !empty($_POST['multi_twilio_check'])) ? $_POST['multi_twilio_check']: 0;
						$insertData['twilio_cell_number']  = (isset($_POST['twilio_cell_number']) && !empty($_POST['twilio_cell_number'])) ? $_POST['twilio_cell_number']: '';
						
						
						if($insertData['type'] == 0){
							$insertData['send_admin_msg'] = 0;
							$insertData['send_user_msg'] = 0;
						}
						
						$this->query_model->insertData('tbl_twilio',$insertData);
					} 
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	
	
	public function apis_twilio_chat(){
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_twilio_chat_api', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['twilio_chat_update'])){
					
					if(!empty($data['detail'])){
						$updateData['type']  = isset($_POST['type'])?$_POST['type']:0;
						//$updateData['checkbox_text']  = (isset($_POST['checkbox_text']) && !empty($_POST['checkbox_text'])) ? $_POST['checkbox_text']:'';
						//$updateData['ac_tag_name']  = (isset($_POST['ac_tag_name']) && !empty($_POST['ac_tag_name'])) ? $_POST['ac_tag_name']:'';
						$updateData['sid']  = (isset($_POST['sid']) && !empty($_POST['sid'])) ? $_POST['sid']:'';
						$updateData['token']  = (isset($_POST['token']) && !empty($_POST['token'])) ? $_POST['token']:'';
						$updateData['from_phone_number']  = (isset($_POST['from_phone_number']) && !empty($_POST['from_phone_number'])) ? $_POST['from_phone_number']:'';
						$updateData['country_phone_code']  = (isset($_POST['country_phone_code']) && !empty($_POST['country_phone_code'])) ? $_POST['country_phone_code']:'';
						$updateData['timezone']  = (isset($_POST['timezone']) && !empty($_POST['timezone'])) ? $_POST['timezone']:'';
						$updateData['twilio_admin_phone_number']  = (isset($_POST['twilio_admin_phone_number']) && !empty($_POST['twilio_admin_phone_number'])) ? $_POST['twilio_admin_phone_number']: '';
						
						//$updateData['multi_twilio_check']  = (isset($_POST['multi_twilio_check']) && !empty($_POST['multi_twilio_check'])) ? $_POST['multi_twilio_check']: 0;
						//$updateData['twilio_cell_number']  = (isset($_POST['twilio_cell_number']) && !empty($_POST['twilio_cell_number'])) ? $_POST['twilio_cell_number']: '';
						
						/*if($updateData['type'] == 0){
							$updateData['send_admin_msg'] = 0;
							$updateData['send_user_msg'] = 0;
						}*/
						
						$this->query_model->update('tbl_twilio_chat_api',1, $updateData);
					} else{
						$insertData['type']  = isset($_POST['type'])?$_POST['type']:0;
						//$insertData['checkbox_text']  = (isset($_POST['checkbox_text']) && !empty($_POST['checkbox_text'])) ? $_POST['checkbox_text']:'';
						//$insertData['ac_tag_name']  = (isset($_POST['ac_tag_name']) && !empty($_POST['ac_tag_name'])) ? $_POST['ac_tag_name']:'';
						$insertData['sid']  = (isset($_POST['sid']) && !empty($_POST['sid'])) ? $_POST['sid']:'';
						$insertData['token']  = (isset($_POST['token']) && !empty($_POST['token'])) ? $_POST['token']:'';
						$insertData['from_phone_number']  = (isset($_POST['from_phone_number']) && !empty($_POST['from_phone_number'])) ? $_POST['from_phone_number']:'';
						$insertData['country_phone_code']  = (isset($_POST['country_phone_code']) && !empty($_POST['country_phone_code'])) ? $_POST['country_phone_code']:'';
						$insertData['timezone']  = (isset($_POST['timezone']) && !empty($_POST['timezone'])) ? $_POST['timezone']:'';
						$insertData['twilio_admin_phone_number']  = (isset($_POST['twilio_admin_phone_number']) && !empty($_POST['twilio_admin_phone_number'])) ? $_POST['twilio_admin_phone_number']: '';
						//$insertData['multi_twilio_check']  = (isset($_POST['multi_twilio_check']) && !empty($_POST['multi_twilio_check'])) ? $_POST['multi_twilio_check']: 0;
						//$insertData['twilio_cell_number']  = (isset($_POST['twilio_cell_number']) && !empty($_POST['twilio_cell_number'])) ? $_POST['twilio_cell_number']: '';
						
						
						/*if($insertData['type'] == 0){
							$insertData['send_admin_msg'] = 0;
							$insertData['send_user_msg'] = 0;
						}*/
						
						$this->query_model->insertData('tbl_twilio_chat_api',$insertData);
					} 
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	
	/********** Webhook Apis Incoming Leads ***********/
	
	public function addWebhookApiIncomingLeads(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = "Add Webhook Api";
		
		
		
			if(isset($_POST['update'])):
				$postData['api_name'] = isset($_POST['api_name']) ? trim($_POST['api_name']) : '';
				$postData['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
				$postData['required_mapping_fields'] = isset($_POST['required_mapping_fields']) ? $_POST['required_mapping_fields'] : 0;
				
				
				$postData['name_key'] = !empty($_POST['first_name']) ? $_POST['first_name'] : '';
				$postData['last_name_key'] = !empty($_POST['last_name']) ? $_POST['last_name'] : '';
				$postData['email_key'] = !empty($_POST['email']) ? $_POST['email'] : '';
				$postData['phone_key'] = !empty($_POST['phone']) ? $_POST['phone'] : '';
				$postData['location_key'] = !empty($_POST['location']) ? $_POST['location'] : '';
				$postData['message_key'] = !empty($_POST['message']) ? $_POST['message'] : '';
				$postData['program_key'] = !empty($_POST['program']) ? $_POST['program'] : '';
				$postData['ip_address_key'] = !empty($_POST['ip_address']) ? $_POST['ip_address'] : '';
				$postData['page_name_key'] = !empty($_POST['page_name']) ? $_POST['page_name'] : '';
				$postData['page_id_key'] = !empty($_POST['page_id']) ? $_POST['page_id'] : '';
				$postData['page_url_key'] = !empty($_POST['page_url']) ? $_POST['page_url'] : '';
				$postData['variant_key'] = !empty($_POST['variant']) ? $_POST['variant'] : '';
				$postData['type'] = !empty($_POST['type']) ? $_POST['type'] : 'unbounce';
				$postData['created'] = date('Y-m-d h:i:s');
				
				$postData['school_name_key'] = !empty($_POST['school_name']) ? $_POST['school_name'] : '';
				$postData['school_url_key'] = !empty($_POST['school_url']) ? $_POST['school_url'] : '';
				$postData['inquiry_date_key'] = !empty($_POST['inquiry_date']) ? $_POST['inquiry_date'] : '';
				$postData['last_updated_key'] = !empty($_POST['last_updated']) ? $_POST['last_updated'] : '';
				
				$this->db->insert('tbl_webhook_apis_incoming',$postData);
				redirect("admin/apis_manager/#webhook-api-incoming");
			endif;
			$this->load->view("admin/add_webhook_api_incoming_leads", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	
	
	
	public function editWebhookApiIncomingLeads(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true &&  $this->uri->segment(4) != NULL )
		{
		$data['title'] = "Edit Webhook Api";
		
		$data['webhook_api_detail'] = $this->query_model->getbySpecific('tbl_webhook_apis_incoming','id', $this->uri->segment(4));
		$data['webhook_api_detail'] = $data['webhook_api_detail'][0];
		
		
			if(isset($_POST['update'])):
				$postData['api_name'] = isset($_POST['api_name']) ? trim($_POST['api_name']) : '';
				$postData['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
				$postData['created'] = date('Y-m-d h:i:s');
				$postData['required_mapping_fields'] = isset($_POST['required_mapping_fields']) ? $_POST['required_mapping_fields'] : 0;
				
				$postData['name_key'] = !empty($_POST['first_name']) ? $_POST['first_name'] : '';
				$postData['last_name_key'] = !empty($_POST['last_name']) ? $_POST['last_name'] : '';
				$postData['email_key'] = !empty($_POST['email']) ? $_POST['email'] : '';
				$postData['phone_key'] = !empty($_POST['phone']) ? $_POST['phone'] : '';
				$postData['location_key'] = !empty($_POST['location']) ? $_POST['location'] : '';
				$postData['message_key'] = !empty($_POST['message']) ? $_POST['message'] : '';
				$postData['program_key'] = !empty($_POST['program']) ? $_POST['program'] : '';
				$postData['type'] = !empty($_POST['type']) ? $_POST['type'] : 'unbounce';
				
				
				$postData['ip_address_key'] = !empty($_POST['ip_address']) ? $_POST['ip_address'] : '';
				$postData['page_name_key'] = !empty($_POST['page_name']) ? $_POST['page_name'] : '';
				$postData['page_id_key'] = !empty($_POST['page_id']) ? $_POST['page_id'] : '';
				$postData['page_url_key'] = !empty($_POST['page_url']) ? $_POST['page_url'] : '';
				$postData['variant_key'] = !empty($_POST['variant']) ? $_POST['variant'] : '';
				$postData['school_name_key'] = !empty($_POST['school_name']) ? $_POST['school_name'] : '';
				$postData['school_url_key'] = !empty($_POST['school_url']) ? $_POST['school_url'] : '';
				$postData['inquiry_date_key'] = !empty($_POST['inquiry_date']) ? $_POST['inquiry_date'] : '';
				$postData['last_updated_key'] = !empty($_POST['last_updated']) ? $_POST['last_updated'] : '';
				
				$this->query_model->updateData('tbl_webhook_apis_incoming','id',$this->uri->segment(4), $postData);
				//echo '<pre>'; print_r($postData); die;
				
				
				redirect("admin/apis_manager/#webhook-api-incoming");
			endif;
			$this->load->view("admin/edit_webhook_api_incoming_leads", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	
	public function publishWebhookApiIncomingLeads(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tbl_webhook_apis_incoming", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	
		public function deleteitemWebhookApiIncomingLeads(){
			$id = $_POST['delete-item-id'];
			$this->db->where("id", $id);
			if($this->db->delete("tbl_webhook_apis_incoming"))
			{
				
				//$this->query_model->deletebySpecific('tbl_webhook_api_key_value','webook_api_id',$id);
			
				redirect("admin/apis_manager/#webhook-api-incoming");
			}
			else
			{
			echo "<script language='javascript'>alert('Unable to delete webhook api');</script>";
			redirect("admin/apis_manager/#webhook-api-incoming");
			}
		}
			
		
	
		public function ajax_delete_webhook_apis(){
		
				parse_str($_POST['formData'], $searcharray);
				//echo '<pre>searcharray'; print_r($searcharray); die;
				$id = isset($searcharray['delete-item-id']) ? $searcharray['delete-item-id'] : 0;
				$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
				
				if(!empty($id) && !empty($table_name)){
					$this->db->where("id", $id);
					if($this->db->delete($table_name))
					{
						if($table_name == "tbl_webhook_apis"){
							$this->query_model->deletebySpecific('tbl_webhook_api_key_value','webook_api_id',$id);
						}
						
						echo 1;
					}
					else
					{
						echo 0;
					}
				}else{
					echo 1;
				}
				
				exit();	
	}
	
	public function ajaxPublishWebhookApi(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		$table_name = $_POST['table_name'];
		$this->db->where("id", $id);
		if($this->db->update($table_name, array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	public function ajax_full_alternate_popup(){
		
		if(isset($_POST['action_type']) && !empty($_POST['action_type'])){
			$records = array();
			$records['webhook_api_detail'] = array();
			$records['action_type'] = $_POST['action_type'];
			$records['item_id'] = $_POST['item_id'];
			$records['table_name'] = $_POST['table_name'];
			$records['form_type'] = $_POST['form_type'];
			
			if($records['action_type'] == "edit" && !empty($records['item_id'])){
				
				$this->db->where("id", $records['item_id']);
				$webhook_api_detail = $this->query_model->getbyTable($records['table_name']);
				if(!empty($webhook_api_detail)){
					
					$records['webhook_api_detail'] = $webhook_api_detail[0];
					
					if($records['form_type'] == "little_row" ){
						
						$records['webhook_api_detail_key_values'] = $this->query_model->getbySpecific('tbl_webhook_api_key_value','webook_api_id', $records['item_id']);
					}
				}
			}
			
			
			
			if($records['form_type'] == "little_row" ){
				
				//$records['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->db->where('id',12);
				$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
				$records['multiSchool'] = isset($multiSchool[0]) ? $multiSchool[0]->field_value : 0;
				
				$records['multiWebhook'] = $this->query_model->checkMultiWebhookIsOn();
				
				if($records['multiSchool'] == 1){
					$this->db->where("main_location", 0);
				}
				$this->db->select(array('id','name'));
				$records['allLocations'] = $this->query_model->getbyTable("tblcontact");
				
				$this->db->select(array('id','api_name'));
				$this->db->where('parent_id',0);
				$records['allWebhooks'] = $this->query_model->getbyTable("tbl_webhook_apis");
				
				//echo '<pre>records'; print_r($records); die;
				
				$this->load->view("admin/ajax_webhook_api_outgoing_form", $records);
			}else{
				$this->load->view("admin/ajax_webhook_api_incoming_form", $records);
			}
			
			
		}
	}
	
	
	public function ajax_save_full_alternate_row(){
		
		parse_str($_POST['formData'], $searcharray);
		//echo '<pre>searcharray'; print_r($_POST); die;
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['update'])){
				
				$item_id = isset($searcharray['item_id']) ? $searcharray['item_id'] : '';
				$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
				$form_type = isset($searcharray['form_type']) ? $searcharray['form_type'] : '';
				
				if($form_type == "little_row"){
					$postData['api_name'] = isset($searcharray['api_name']) ? trim($searcharray['api_name']) : '';
					$postData['api_url'] = isset($searcharray['api_url']) ? trim($searcharray['api_url']) : '';
					if(empty($item_id)){
						$postData['published'] = 1;
					}
					
					$postData['api_method'] = isset($searcharray['api_method']) ? $searcharray['api_method'] : 'POST';
					$postData['created'] = date('Y-m-d h:i:s');
					
					$postData['name_key'] = !empty($searcharray['first_name']) ? $searcharray['first_name'] : '';
					$postData['last_name_key'] = !empty($searcharray['last_name']) ? $searcharray['last_name'] : '';
					$postData['email_key'] = !empty($searcharray['email']) ? $searcharray['email'] : '';
					$postData['phone_key'] = !empty($searcharray['phone']) ? $searcharray['phone'] : '';
					$postData['location_key'] = !empty($searcharray['location']) ? $searcharray['location'] : '';
					$postData['message_key'] = !empty($searcharray['message']) ? $searcharray['message'] : '';
					$postData['program_key'] = !empty($searcharray['program']) ? $searcharray['program'] : '';
					$postData['trial_name_key'] = !empty($searcharray['trial_name']) ? $searcharray['trial_name'] : '';
					$postData['trial_type_key'] = !empty($searcharray['trial_type']) ? $searcharray['trial_type'] : '';
					$postData['total_amount_key'] = !empty($searcharray['total_amount']) ? $searcharray['total_amount'] : '';
					$postData['page_url_key'] = !empty($searcharray['page_url']) ? $searcharray['page_url'] : '';
					$postData['tag_key'] = !empty($searcharray['tag']) ? $searcharray['tag'] : '';
					//$postData['tag_values'] = !empty($searcharray['tag_values']) ? $searcharray['tag_values'] : '';
					$postData['api_type'] = isset($searcharray['api_type']) ? $searcharray['api_type'] : '';
					$postData['parent_id'] = (isset($searcharray['parent_id']) && !empty($searcharray['parent_id'])) ? $searcharray['parent_id'] : 0;
					$postData['location_id'] = (isset($searcharray['location_id']) && !empty($searcharray['location_id'])) ? $searcharray['location_id'] : 0;
				
				}else{
					
					
					$postData['api_name'] = isset($searcharray['api_name']) ? trim($searcharray['api_name']) : '';
					if(empty($item_id)){
						$postData['published'] = 1;
					}
					
					$postData['created'] = date('Y-m-d h:i:s');
					$postData['required_mapping_fields'] = isset($_POST['required_mapping_fields']) ? $_POST['required_mapping_fields'] : 0;
					$postData['name_key'] = !empty($searcharray['first_name']) ? $searcharray['first_name'] : '';
					$postData['last_name_key'] = !empty($searcharray['last_name']) ? $searcharray['last_name'] : '';
					$postData['email_key'] = !empty($searcharray['email']) ? $searcharray['email'] : '';
					$postData['phone_key'] = !empty($searcharray['phone']) ? $searcharray['phone'] : '';
					$postData['location_key'] = !empty($searcharray['location']) ? $searcharray['location'] : '';
					$postData['message_key'] = !empty($searcharray['message']) ? $searcharray['message'] : '';
					$postData['program_key'] = !empty($searcharray['program']) ? $searcharray['program'] : '';
					$postData['type'] = !empty($searcharray['type']) ? $searcharray['type'] : 'unbounce';
					
					$postData['ip_address_key'] = !empty($searcharray['ip_address']) ? $searcharray['ip_address'] : '';
					$postData['page_name_key'] = !empty($searcharray['page_name']) ? $searcharray['page_name'] : '';
					$postData['page_id_key'] = !empty($searcharray['page_id']) ? $searcharray['page_id'] : '';
					$postData['page_url_key'] = !empty($searcharray['page_url']) ? $searcharray['page_url'] : '';
					$postData['variant_key'] = !empty($searcharray['variant']) ? $searcharray['variant'] : '';
					$postData['school_name_key'] = !empty($searcharray['school_name']) ? $searcharray['school_name'] : '';
					$postData['school_url_key'] = !empty($searcharray['school_url']) ? $searcharray['school_url'] : '';
					$postData['inquiry_date_key'] = !empty($searcharray['inquiry_date']) ? $searcharray['inquiry_date'] : '';
					$postData['last_updated_key'] = !empty($searcharray['last_updated']) ? $searcharray['last_updated'] : '';
					
				}
				//echo '<pre>postData'; print_r($postData); die;
				if(!empty($item_id)){
					
					$this->query_model->updateData($table_name,'id',$item_id, $postData);
					$insert_id = $item_id;
					$result['form_action'] = 'edit';
				}else{
					$this->query_model->insertData($table_name, $postData);
					$insert_id = $this->db->insert_id();
					$result['form_action'] = 'add';
				}
				
				if($form_type == "little_row"){
					$this->query_model->deletebySpecific('tbl_webhook_api_key_value','webook_api_id',$insert_id);
					if(isset($searcharray['apiKeyValue']) && !empty($searcharray['apiKeyValue'])){
						
						foreach($searcharray['apiKeyValue'] as $apiKeyValue){
							if(!empty($apiKeyValue['key']) && !empty($apiKeyValue['value'])){
								$postData2['webook_api_id'] = $insert_id;
								$postData2['keys'] = $apiKeyValue['key'];
								$postData2['values'] = $apiKeyValue['value'];
								
								$this->db->insert('tbl_webhook_api_key_value',$postData2);
							}
							
						}
					}
				}
					
					$result['res'] = 1;
					$result['id'] = $insert_id;
					$result['title'] = $postData['api_name'];
					$result['form_type'] = $form_type;
					$result['table_name'] = $table_name;
					$result['photo_side'] = '';
					
				
			}
		echo json_encode($result); 	
	}
	
	
	
	
	public function apis_sparkpost_mail(){
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_sparkpost_mail', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

				
				if(isset($_POST['sparkpost_update'])){
					//echo '<prE>POST'; print_r($_POST); die;
					if(!empty($data['detail'])){
						$updateData['type']  = isset($_POST['type'])?$_POST['type']:'';
						$updateData['api_key']  = isset($_POST['api_key'])?$_POST['api_key']:'';
						$updateData['from_email']  = isset($_POST['from_email'])?$_POST['from_email']:'';
						$updateData['reply_to_email']  = isset($_POST['reply_to_email'])?$_POST['reply_to_email']:'';
						
						$this->query_model->update('tbl_sparkpost_mail', 1, $updateData);
					} else{
						$insertData['type']  = isset($_POST['type'])?$_POST['type']:'';
						$insertData['api_key']  = isset($_POST['api_key'])?$_POST['api_key']:'';
						$insertData['from_email']  = isset($_POST['from_email'])?$_POST['from_email']:'';
						$insertData['reply_to_email']  = isset($_POST['reply_to_email'])?$_POST['reply_to_email']:'';
						
						$this->query_model->insertData('tbl_sparkpost_mail',$insertData);
					}
					
					if(isset($_POST['type']) && $_POST['type'] == 1){
						$this->db->select('id');
						$this->db->where('template_id','');
						$sparkpost_blank_templates = $this->query_model->getbyTable('tbl_sparkpost_mail_templates');
						
						if(!empty($sparkpost_blank_templates)){
							foreach($sparkpost_blank_templates as $sparkpost_blank_template){
								
								$this->addTemplateToSparkPostApi($sparkpost_blank_template->id);
								
							}
						}
						
						$this->db->select(array('id','template_id','subject','description','mail_flow_id','title'));
						$sparkpost_mail_templates = $this->query_model->getbyTable('tbl_sparkpost_mail_templates');
						//echo '<prE>sparkpost_mail_templates'; print_r($sparkpost_mail_templates); die;
						if(!empty($sparkpost_mail_templates)){
							
							//$sparkpost_mail_api =  $this->query_model->getbySpecific('tbl_sparkpost_mail', 'id', 1);
							
							foreach($sparkpost_mail_templates as $sparkpost_mail_template){
								
								$this->db->select(array('title'));
								$flow_detail = $this->query_model->getBySpecific('tbl_sparkpost_mail_flows','id',$sparkpost_mail_template->mail_flow_id);
								
								
								$mail_subject = $this->query_model->replaceSparkpostEmailVaribles($sparkpost_mail_template->subject);
								$mail_template = $this->query_model->replaceSparkpostEmailVaribles($sparkpost_mail_template->description);
								
								$requestData = array(
												'template_id' => $sparkpost_mail_template->template_id,
												'title'=>$flow_detail[0]->title.' ~ '. $sparkpost_mail_template->title,
												'subject'=>$mail_subject,
												'description'=>$mail_template,
												);
								
								$request_result = $this->sparkpost_mail_model->requestSparkPostApi('update_template_setting',$requestData);
							}
						}
						
					}
					
					
					
				redirect('admin/apis_manager');
				}
			return $data;
	}
	
	
	
	public function addTemplateToSparkPostApi($template_duplicate_id){
		
									
		$template_detail = $this->query_model->getBySpecific('tbl_sparkpost_mail_templates','id',$template_duplicate_id);
		
		if(!empty($template_detail)){
			$flow_detail = $this->query_model->getBySpecific('tbl_sparkpost_mail_flows','id',$template_detail[0]->mail_flow_id);
			
			if(!empty($flow_detail)){
				
				$requestData = array(
									'title'=>$flow_detail[0]->title.' ~ '. $template_detail[0]->title,
									'subject'=>$template_detail[0]->subject,
									'description'=>$template_detail[0]->description
								);
			
				
				$request_result = $this->sparkpost_mail_model->requestSparkPostApi('add_template',$requestData);
				
				if(isset($request_result['response']) && $request_result['response'] == 1){
					
					if(isset($request_result['template_id']) && !empty($request_result['template_id'])){
						$updateData = array();
						$updateData['template_id'] = $request_result['template_id'];
						
						$this->query_model->updateData('tbl_sparkpost_mail_templates','id',$template_duplicate_id, $updateData);
					}
				}
			}
		}
	}
	
	
	
	
}
