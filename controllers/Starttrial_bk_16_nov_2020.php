<?php 
require 'vendor/autoload.php';

				

				use net\authorize\api\contract\v1 as AnetAPI;

				use net\authorize\api\controller as AnetController;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Starttrial extends CI_Controller {



	function __construct(){

		parent::__construct();
		
		$this->load->model('trial_model');

	}

	

	public function index()

	{
		
		
		
		$folder_name = $_SERVER['CONTEXT_PREFIX'];
  		$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
   
	   $meta_slug = explode('/',$_SERVER['REQUEST_URI']);
	   
	   $meta_slug = $meta_slug[1];
		
		if(!empty($meta_slug)){
			$data['page_name'] = $this->query_model->getMetaPageName($meta_slug);
		}
		
		/*** code for get page data **/
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$data['trials'] = $this->query_model->getbySpecific("$tblspecialoffer", 'display_trial', 1);
		
		 $this->db->where('display_trial',1);
		 $data['free_trial'] = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 0);
			 
		 $this->db->where('display_trial',1);
		 $data['paid_trial'] = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 1);
		
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		$data['site_settings'] = $data['site_settings'][0];
		
		$data['settings'] = $data['site_settings'];
		
		$data['trials_value'] = $this->checktrials($data['free_trial'], $data['paid_trial']);
		$this->db->where("published", 1);
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		
		
		$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
		$data['contact_slug'] = $data['contact_slug'][0];
		
		
		$data['form_allLocations'] = $this->query_model->getFormAllLocations('include_main_location');
		
		$data['twilioApi'] = $this->query_model->getTwilioApiType();
		
		$data['all_programs'] = $this->query_model->getProgramLists();
		
		$setting = $this->query_model->getbyTable('tblsite');
		$setting = $setting[0];
			
		/*$this->db->order_by("pos","asc");
		$this->db->limit(2);
		$this->db->where("published", 1);
		$data['myTestimonials'] = $this->query_model->getbyTable("tbltestimonials"); */
		
		
		/** adding new things in trial **/
		$data['header'] = $this->query_model->getbySpecific('tbl_onlinespecial_header', 'id', 1);
		$data['header'] = !empty($data['header']) ? $data['header'][0] : array();
		
		$data['text_sections'] = $this->query_model->getbySpecific('tbl_onlinespecial_text_sections', 'id', 1);
		$data['text_sections'] = !empty($data['text_sections']) ? $data['text_sections'][0] : array();
		//echo '<pre>'; print_r($data['text_sections']); die;
		
		$data['myTestimonials'] = array();
		if(!empty($data['text_sections'])){
			$selectedTesti = !empty($data['text_sections']->testimonial_ids) ?  unserialize($data['text_sections']->testimonial_ids) : '';
			if(!empty($selectedTesti)){
				/*if(count($selectedTesti) > 2){
					$this->db->limit(2);
				} */
				$this->db->order_by("pos","asc");
				$this->db->where_in('id', $selectedTesti);
			}else{
				$this->db->limit(2);
				$this->db->where("published", 1);
			}
			$data['myTestimonials'] = $this->query_model->getbyTable("tbltestimonials");
		}
		
		$data['email_options'] = $this->query_model->getbySpecific('tbl_onlinespecial_email_options', 'id', 1);
		$data['email_options'] = !empty($data['email_options']) ? $data['email_options'][0] : array();

		$this->db->order_by('pos', 'asc');
		$this->db->where("published", 1);
		$data['onlinespecialRows'] = $this->query_model->getbySpecific('tbl_onlinespecial_rows', 'published', 1); 
		
		
		$isUniqueTrial = $this->query_model->isTrialOfferUnique();
		
		$this->db->order_by('pos', 'asc');
		$this->db->where("published", 1);
		if($isUniqueTrial == "unique_"){
			$this->db->where("type", 'unique_trial_box');
		}
		$data['trial_categories'] = $this->query_model->getbyTable('tbl_'.$isUniqueTrial.'onlinespecial_categories');
		
		
		$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
				
		
		/*** </code> ***/
		
		//echo '<pre>POST'; print_r($_POST); die;	
		
		$data['name']	= isset($_POST['name']) ? $_POST['name'] : '';
		$data['last_name']	= isset($_POST['last_name']) ? $_POST['last_name'] : '';
		$data['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : '';
		$data['phone']	= isset($_POST['phone']) ? $_POST['phone'] : '';
		$data['form_email_2'] = isset($_POST['form_email_2']) ? $_POST['form_email_2'] : '';

		$data['school_interest'] = isset($_POST['school_interest']) ? $_POST['school_interest'] : '';
		
		$data['miniform'] = isset($_POST['miniform']) ? $_POST['miniform'] : '';	
		$data['trial_cat_id'] = isset($_POST['trial_offer_id']) ? $_POST['trial_offer_id'] : 0;		
		
		
		
		if(!empty($data['name']) && !empty($data['form_email_2']) && ($data['miniform'] == true)){
			
			$sessionLeadsData = array('sessionLeadsData' => $_POST);
			$this->session->set_userdata($sessionLeadsData);
		
		
			// checking hunney Post
			 $this->query_model->checkHunneyPost($_POST);		
			
			

			$insertData['phone'] = $data['phone'];				

			$insertData['name'] = $data['name'];
			
			$insertData['last_name'] = $data['last_name'];

			$insertData['email'] = $data['form_email_2'];
			
			$orderData['phone'] = $data['phone'];	
			$orderData['name'] = $data['name'];
			$orderData['last_name'] = $data['last_name'];
			$orderData['email'] = $data['form_email_2'];
			$orderData['trial_cat_id'] = $data['trial_cat_id'];
			$orderData['created'] = date('Y-m-d h:i:s');
			$orderData['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
			
			$ipAddress = $this->query_model->getCountryNameToIpAddress();
			$orderData['ip_address'] = $ipAddress['client_ip_address'];
			$orderData['client_country_name'] = $ipAddress['client_country_name'];
			$orderData['gdpr_compliant_checkbox'] = isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : 0;
			$orderData['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : NULL;
			$orderData['request_detail'] = isset($_SERVER) ? serialize($_SERVER) : '';
			//$orderData['ip_address'] = $_SERVER['REMOTE_ADDR'];
			//$orderData['ip_address_status'] = 0;
			
			if($data['school_interest'] && $data['school_interest'] != 0){

				$qry = $this->db->query("select * from `tblcontact` where id = ".$data['school_interest']) or die(mysqli_error($this->db->conn_id));
	
				$location_data = $qry->row_array();
	
				$insertData['school_of_interest'] = $location_data['name'];
				
				$orderData['location_id'] = $data['school_interest'];
	
			}
				
				/*
				* checkFormModuleApplyAPI 				
				* this function for using apis according form model 				
				*/				
				
				$this->query_model->checkFormModuleApplyAPI($_POST);
				//$autoResponder = $this->query_model->checkFormModuleAutoResponder($_POST);				
				$this->query_model->saveFormDataOnMATApi($_POST);
				
				$sessionLeadsData = array('sessionLeadsData' => $_POST);
				$this->session->set_userdata($sessionLeadsData);
						
				$this->sendQuickEnquiry();	
		
			
			$this->query_model->insertData('tblpayments', $insertData);			
			
			$this->query_model->insertData('tblorders', $orderData);
			
			$order_id = $this->db->insert_id();
	
			if(!empty($order_id)){
				$current_email_info = $this->query_model->getOrderEmailInfo($_POST['form_email_2'], $_POST['name'],$orderData['page_url'],$order_id);
				
			}
		}
		
		

		
		// Third party url redirect
		$setting = $this->query_model->getbyTable('tblsite');
		$setting = $setting[0];
		
		
		//$thankyouMessage = $this->session->userdata('thankyouMessage');
		//echo '<pre>thankyouMessage'; print_r($thankyouMessage); die;
		
		if($setting->tiral_url_type == 1){
			
			$multi_location = $this->query_model->getbyTable("tblconfigcalendar");
			
			if($multi_location[0]->field_value == 1 && $multi_location[10]->field_value == 1){
				
				if(isset($_POST['school_interest']) && !empty($_POST['school_interest'])){
					$exitData = array();
					$exitData = $this->query_model->getbySpecific('tbl_multi_trial_offers','location_id',$_POST['school_interest']); 
					if(!empty($exitData)){
						$exitData = $exitData[0];
						//echo "<script>window.open('https://support.wwf.org.uk/earth_hour/index.php?type=individual','_blank');</script>";
						redirect($exitData->trial_offer_url);
					}else{
						//die('1');
						if(isset($_POST['trial_offer_id']) && !empty($_POST['trial_offer_id'])){
							$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
								$trialOfferDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_categories", 'id', $_POST['trial_offer_id']);
								
								if(!empty($trialOfferDetail)){
									$this->query_model->getAndUpdateMatApiIsAppiled($_POST);
									
									redirect('/'.$data['trial_offer_slug']->slug.'/'.$trialOfferDetail[0]->slug);
								}else{
									$this->load->view('trial-offer', $data);
								}
							}else{
								$this->load->view('trial-offer', $data);
							}
							
						
					}
				}
			}else{
				redirect($setting->another_trial_url);
			}
		}else{
			//echo '<pre>_POST'; print_r($_POST); die;
			//die('2');
			
			$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
			$start_trial_slug = $start_trial_slug[0];
			
			$dojocart_slug = $this->query_model->getbySpecific('tblmeta', 'id', 49);
			$dojocart_slug = $dojocart_slug[0];
			
			
			
			$redirect_url = $start_trial_slug->slug;
			
			if(isset($_POST['is_unique_trial']) && ($_POST['is_unique_trial'] == 1)){
				
				$program_id = isset($_POST['program_id']) ? $_POST['program_id'] : '';
				$program_cat_id = isset($_POST['program_cat_id']) ? $_POST['program_cat_id'] : '';
				$location = isset($_POST['school_interest']) ? $_POST['school_interest'] : '';
				
				
				$this->db->select(array('id','name','slug'));
				$locationDetail = $this->query_model->getBySpecific('tblcontact','id',$location);
				
				
				
				$this->db->where('program_cat_id',$program_cat_id);
				$this->db->where('unique_program_id',$program_id);
				$this->db->where('location_id',$location);
				$uniqueTrialCat = $this->query_model->getBySpecific('tbl_unique_onlinespecial_categories','type','trial_offer');
				
				$this->query_model->getAndUpdateMatApiIsAppiled($_POST);
				
				if(!empty($uniqueTrialCat)){
					$redirect_url = $start_trial_slug->slug.'/'.$uniqueTrialCat[0]->slug.'/'.$locationDetail[0]->slug;
				}else{
					$this->db->where('program_cat_id',$program_cat_id);
					$this->db->where('location_id',$location);
					if(!empty($program_id)){
						$this->db->where('unique_program_id',$program_id);
					}
					//$this->db->where('location_id','all');
					$uniqueTrialCat = $this->query_model->getBySpecific('tbl_unique_onlinespecial_categories','type','trial_offer');
					
					if(!empty($uniqueTrialCat)){
						$redirect_url = $start_trial_slug->slug.'/'.$uniqueTrialCat[0]->slug;
					}else{
						$this->db->where('program_cat_id',$program_cat_id);
						
						$this->db->where('location_id','all');
						$uniqueTrialCat = $this->query_model->getBySpecific('tbl_unique_onlinespecial_categories','type','trial_offer');
						if(!empty($uniqueTrialCat)){
							$redirect_url = $start_trial_slug->slug.'/'.$uniqueTrialCat[0]->slug;
						}
					}
					
					//echo '<pre>uniqueTrialCat'; print_r($uniqueTrialCat); die;
					
				}
				
				
				
				$redirect_url = base_url().$redirect_url;
				
				redirect($redirect_url);
			}
			
		
			
			if(isset($_POST['redirection_type']) && !empty($_POST['redirection_type'])){
			
				$redirect_url = '/'.$start_trial_slug->slug;
			
				if($_POST['redirection_type'] == "trial_offer" && isset($_POST['trial_offer_id']) && !empty($_POST['trial_offer_id'])){
					$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
					$trialOfferDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_categories", 'id', $_POST['trial_offer_id']);
					if(!empty($trialOfferDetail)){
						$redirect_url = '/'.$start_trial_slug->slug.'/'.$trialOfferDetail[0]->slug;
					}
				}elseif($_POST['redirection_type'] == "dojocart" && isset($_POST['dojocart_id']) && !empty($_POST['dojocart_id'])){
					$dojocartDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $_POST['dojocart_id']);
					if(!empty($dojocartDetail)){
						$redirect_url = '/'.$dojocart_slug->slug.'/'.$dojocartDetail[0]->slug;
					}
				}elseif($_POST['redirection_type'] == "thankyou_page" && isset($_POST['thankyou_page_id']) && !empty($_POST['thankyou_page_id'])){
					
					$this->query_model->getThankYouPageProgramPageMessage($_POST,$_POST['thankyou_page_id']);
					
					$program_thankyou_url = $this->query_model->getProgramThankyouUrl($_POST);
					
					redirect(@base_url().$program_thankyou_url);
					//redirect(@base_url().'site/thankyou');
				}elseif($_POST['redirection_type'] == "third_party_url" && isset($_POST['third_party_url']) && !empty($_POST['third_party_url'])){
					$redirect_url = $_POST['third_party_url'];
				}
				$this->query_model->getAndUpdateMatApiIsAppiled($_POST);
				redirect($redirect_url);
			}else{
				$this->load->view('trial-offer', $data);
			}
			
			/*if(isset($_POST['trial_offer_id']) && !empty($_POST['trial_offer_id'])){
				$trialOfferDetail = $this->query_model->getbySpecific('tbl_onlinespecial_categories', 'id', $_POST['trial_offer_id']);
				
				if(!empty($trialOfferDetail)){
					redirect('/'.$data['trial_offer_slug']->slug.'/'.$trialOfferDetail[0]->slug);
				}else{
					$this->load->view('trial-offer', $data);
				}
			}else{
				$this->load->view('trial-offer', $data);
			} */
		}

		

	}

	

	function sendQuickEnquiry(){
		
		/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST);
		
		// sending msg by twillio api
		$this->query_model->connectFormToTwillioAPi($_POST,'mini_and_full_form');
		
		$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'mini_and_full_form');
		
		
		$this->load->library("email");		

		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		//echo '<pre>'; print_r($check_mailchimp); die;
		$mailchimp_type = 0;
		$mailchimp_template_id = '';
		$mailchimp_api_key = '';
		if(!empty($check_mailchimp)){
			$mailchimp_type = $check_mailchimp[0]->type;
			$mailchimp_template_id = $check_mailchimp[0]->template_id;
			$mailchimp_api_key =  $check_mailchimp[0]->api_key;
		}
		
		
		/*********RainMark Code ******/
		//$this->query_model->saveWebLeadsOnRainMark($_POST);

		
		$query = $this->query_model->getbyTable('tblsite');

		$qry = $this->db->query("select * from `tblsite` limit 1") or die(mysqli_error($this->db->conn_id));

		$site_settings = $qry->row_array();		

		$site_email = $site_settings['email'];

		$site_title = $site_settings['title'];		
		

		$email = $this->input->post('form_email_2');

		$name	= $this->input->post('name');

		$phone	= $this->input->post('phone');

		$last_name = $this->input->post('last_name');

		$kicksite = $this->query_model->Check_KickSiteOn();

		$school_interest = $this->input->post('school_interest');		

		if($school_interest && $school_interest != 0){

			$qry = $this->db->query("select * from `tblcontact` where id = ".$school_interest) or die(mysqli_error($this->db->conn_id));

			$location_data = $qry->row_array();

			$location_email = $location_data['email'];
			
			 $noreply_email_address = $location_data['email'];
		
		} else{
			$main_location_id = $this->query_model->getMainLocation();
			$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));

			$location_data = $qry->row_array();
			
			$site_setting = $this->query_model->getbyTable('tblsite');	
			$noreply_email_address = $site_setting[0]->email;
		}
		
		
		
		$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
		if($multiLocationData[0]->field_value == 0){
			$siteSettingData = $this->query_model->getbyTable('tblsite');	
			$noreply_email_address = $siteSettingData[0]->email;
		}
		
		
	
		$config['charset'] = 'UTF-8';

		$config['wordwrap'] = TRUE;

		$config['mailtype'] = "html";

		
		// customer mail
		
		// email to customer
		if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){
			$subject = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
			
			$msg_body  = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';

			//$msg_body .= "<br/>";
			$msg_body .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';

			$this->email->initialize($config);

			$this->email->from($noreply_email_address);

			$this->email->reply_to($noreply_email_address, $site_title);

			$this->email->to($email);	

			$this->email->subject($subject);

			$this->email->message($msg_body);

			$this->email->send();
		}
		


		
		if(isset($emailAutoResponder['admin_email'])){
		// admin mail
				$subject =  isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				
				$msg_body  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
	
				$msg_body .= "<br/>";
			//	$msg_body .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';

				//echo $email.'==>'.$site_email.'==>'.$subject.'==>'.$msg_body; die;
				$config['charset'] = 'UTF-8';

				$config['wordwrap'] = TRUE;

				$config['mailtype'] = "html";
		
				$this->email->initialize($config);

				//$this->email->from('noreply@websitedojo.com');

				//$this->email->reply_to($email, $email);

				$this->email->to($noreply_email_address);	
						
				//$this->email->cc('leads@websitedojo.com');
				if(!empty($fromEmailId)){
					$this->email->from($fromEmailId);
				}
				if(!empty($email)){
					$this->email->reply_to($email);
				}
				if(!empty($cc_email)){
					$this->email->bcc($cc_email);
				}
				
				$this->email->subject($subject);

				$this->email->message($msg_body);
				
				$this->email->send();
		
		
		
		
		
		/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
		
		$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
		if($multiple_loc[0]->field_value == 1){
			$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$school_interest);
			if(!empty($loc_detail)){
			$text_address = $loc_detail[0]->text_address;
			}
		}else{
			$loc_detail = $this->query_model->getMainLocation("tblcontact");
			if(!empty($loc_detail)){
			$text_address = $loc_detail[0]->text_address;
			}
		}
		
		$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'mini_and_full_form');
		$subject = '';
		$msg_body  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


		if(!empty($text_address) && !empty($msg_body)){
			
			
			/*$subject =   isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

			$msg_body  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';

			$msg_body .= "<br/><br/>";*/
			//$msg_body .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
			

			$this->email->initialize($config);

			//$this->email->from('noreply@websitedojo.com');

			//$this->email->reply_to($email, $email);

			$this->email->to($text_address);	
					
			//$this->email->cc('leads@websitedojo.com');

		if(!empty($fromEmailId)){
			$this->email->from($fromEmailId);
		}
		if(!empty($email)){
			$this->email->reply_to($email);
		}
		if(!empty($cc_email)){
			$this->email->bcc($cc_email);
		}
			$this->email->subject($subject);

			$this->email->message($msg_body);
			
			$this->email->send();
		}	
	}	
		/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
	
		

	}

	
/**
* Free Trial from online-special Page
**/
	public function buyspecial(){
		$_POST['submit'] = 'Purchase Now';
		//echo '<pre>23'; print_r($_POST); die;
		// checking hunney Post
		$this->query_model->checkHunneyPost($_POST);

		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$trial_detail = $this->query_model->getbySpecific("$tblspecialoffer", 'id' , $_POST['trial_id']);
		$trial_amount = $trial_detail[0]->amount;
		$trial_type = $trial_detail[0]->trial;

		$email	= $this->input->post('form_email_2');

		$data['post'] = $_POST;

		

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){

			echo "<script>alert('Invalid Email Address!')</script>";

			redirect("online-special");

		}

		

		$this->trial_model->addTrial_($data['post'], $trial_detail);


		

	}	

	

	function notifypayment(){

		

		$this->trial_model->handlePaypalResponse();

		

	}
	
	
	
	public function checktrials($free_trial, $paid_trial){
		//echo '<pre>free_trial'; print_r($free_trial); die;
		$currency_type = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
		$site_currency_type = $this->query_model->getSiteCurrencyType();
		
			$html = '';
			if(count($paid_trial) == 2){
				
				foreach($paid_trial as $paid){
					$features = unserialize($paid->features);
					
					$html .= '<div class="right-block">';
					$html .= ' <h3>'.$this->query_model->getMetaDescReplace($paid->offer_title).'</h3>';
					
					if(!empty($paid->large_offer_text)){
						$html .= '<h2>'.$this->query_model->getMetaDescReplace($paid->large_offer_text).'</h2>';
					}else{
						$html .= '<h2>'.$site_currency_type.$paid->amount.'</h2>';
					}
					
					if(!empty($features)){
						foreach($features as $feature){
							if(!empty($feature)){
									$html .= ' <p><span class="featureBullets">&#9679; </span> '.$this->query_model->getMetaDescReplace($feature).'</p>';
							}
						}
					}
					
					//$html .= ' </ul>';
					$html .= ' <div class="check-select trialButton"   offer="paid"  id="'.$paid->id.'" amount="'.$paid->amount.'" is_child_name="'.$paid->is_child_name.'">';
					$html .= ' <a id="check'.$paid->id.'"  class="btn-animate white-btn check " href="javascript:void(0)">';
					
					$html .= '<div class="control-group left-g"><label class="control control-checkbox"><span class="selectedOffer selectedTrial'.$paid->id.'">'.$this->query_model->getStaticTextTranslation('select').'</span><input type="checkbox" name=""class="trial_offer_checkbox" number="'.$paid->id.'"  id="checkbox_'.$paid->id.'" /><div class="control_indicator"></div></label></div>';
					
					$html .= ' </a>';
					$html .= ' </div>';
					$html .= ' </div>';
					
					
				
				}
				return $html;
			
			
			}  elseif(count($free_trial) == 2){
				
				foreach($free_trial as $free){
					$freefeatures = unserialize($free->features);
					$html .= '<div class="left-block">';
					$html .= ' <h3>'.$this->query_model->getMetaDescReplace($free->offer_title).'</h3>';
					
					if(!empty($free->large_offer_text)){
						$html .= '<h2>'.$this->query_model->getMetaDescReplace($free->large_offer_text).'</h2>';
					}else{
						$html .= '<h2>'.$this->query_model->getStaticTextTranslation('free').'</h2>';
					}
					
					if(!empty($freefeatures)){
						foreach($freefeatures as $feature){
							if(!empty($feature)){
									$html .= ' <p><span class="featureBullets">&#9679; </span> '.$this->query_model->getMetaDescReplace($feature).'</p>';
							}
						}
					}
					
					//$html .= ' </ul>';
					$html .= ' <div class="check-select trialButton"   offer="free"  id="'.$free->id.'" is_child_name="'.$free->is_child_name.'">';
					$html .= ' <a id="check'.$free->id.'"  class="btn-animate white-btn check " href="javascript:void(0)">';
					
					$html .= '<div class="control-group left-g"><label class="control control-checkbox"><span class="selectedOffer selectedTrial'.$free->id.'">'.$this->query_model->getStaticTextTranslation('select').'</span><input type="checkbox" name=""class="trial_offer_checkbox" number="'.$free->id.'"  id="checkbox_'.$free->id.'" /><div class="control_indicator"></div></label></div>';
					
					$html .= ' </a>';
					$html .= ' </div>';
					$html .= ' </div>';
					
				
				}
				return $html;
			
			
			} elseif(count($paid_trial) == 1 &&  count($free_trial) == 1){
			
				foreach($free_trial as $free){
					$freefeatures = unserialize($free->features);
					
					$html .= '<div class="left-block">';
					$html .= ' <h3>'.$this->query_model->getMetaDescReplace($free->offer_title).'</h3>';
					
					if(!empty($free->large_offer_text)){
						$html .= '<h2>'.$this->query_model->getMetaDescReplace($free->large_offer_text).'</h2>';
					}else{
						$html .= '<h2>'.$this->query_model->getStaticTextTranslation('free').'</h2>';
					}
					
					if(!empty($freefeatures)){
						foreach($freefeatures as $feature){
							if(!empty($feature)){
									$html .= ' <p><span class="featureBullets">&#9679; </span> '.$this->query_model->getMetaDescReplace($feature).'</p>';
							}
						}
					}
					
					//$html .= ' </ul>';
					$html .= ' <div class="check-select trialButton"   offer="free"  id="'.$free->id.'"  is_child_name="'.$free->is_child_name.'">';
					$html .= ' <a id="check'.$free->id.'"  class="btn-animate white-btn check " href="javascript:void(0)">';
					
					$html .= '<div class="control-group left-g"><label class="control control-checkbox"><span class="selectedOffer selectedTrial'.$free->id.'">'.$this->query_model->getStaticTextTranslation('select').'</span><input type="checkbox" name=""class="trial_offer_checkbox" number="'.$free->id.'"  id="checkbox_'.$free->id.'" /><div class="control_indicator"></div></label></div>';
					
					$html .= ' </a>';
					$html .= ' </div>';
					$html .= ' </div>';
					
				
				}
				
				foreach($paid_trial as $paid){
					$features = unserialize($paid->features);
					
					$html .= '<div class="right-block">';
					$html .= ' <h3>'.$this->query_model->getMetaDescReplace($paid->offer_title).'</h3>';
					
					if(!empty($paid->large_offer_text)){
						$html .= '<h2>'.$this->query_model->getMetaDescReplace($paid->large_offer_text).'</h2>';
					}else{
						$html .= '<h2>'.$site_currency_type.$paid->amount.'</h2>';
					}
					
					if(!empty($features)){
						foreach($features as $feature){
							if(!empty($feature)){
									$html .= ' <p><span class="featureBullets">&#9679; </span> '.$this->query_model->getMetaDescReplace($feature).'</p>';
							}
						}
					}
					
					//$html .= ' </ul>';
					$html .= ' <div class="check-select trialButton"   offer="paid"  id="'.$paid->id.'" amount="'.$paid->amount.'" is_child_name="'.$paid->is_child_name.'">';
					$html .= ' <a id="check'.$paid->id.'"  class="btn-animate white-btn check " href="javascript:void(0)">';
					
					$html .= '<div class="control-group left-g"><label class="control control-checkbox"><span class="selectedOffer selectedTrial'.$paid->id.'">'.$this->query_model->getStaticTextTranslation('select').'</span><input type="checkbox" name=""class="trial_offer_checkbox" number="'.$paid->id.'"  id="checkbox_'.$paid->id.'" /><div class="control_indicator"></div></label></div>';
					
					$html .= ' </a>';
					$html .= ' </div>';
					$html .= ' </div>';
					
					
				
				}
				
				
				return $html;
			
			} else {
				 if(count($free_trial) == 1){
					foreach($free_trial as $free){
					$freefeatures = unserialize($free->features);
					$html .= '<div class="col-sm-6 col-sm-offset-3 "><div class="left-block single_offer">';
					$html .= ' <h3>'.$free->offer_title.'</h3>';
					
					if(!empty($free->large_offer_text)){
						$html .= '<h2>'.$free->large_offer_text.'</h2>';
					}else{
						$html .= '<h2>'.$this->query_model->getStaticTextTranslation('free').'</h2>';
					}
					
					if(!empty($freefeatures)){
						foreach($freefeatures as $feature){
							if(!empty($feature)){
									$html .= ' <p><span class="featureBullets">&#9679; </span> '.$feature.'</p>';
							}
						}
					}
					
					//$html .= ' </ul>';
					$html .= ' <div class="check-select trialButton"   offer="free"  id="'.$free->id.'" is_child_name="'.$free->is_child_name.'">';
					$html .= ' <a id="check'.$free->id.'"  class="btn-animate white-btn check " href="javascript:void(0)">';
					
					$html .= '<div class="control-group left-g"><label class="control control-checkbox"><span class="selectedOffer selectedTrial'.$free->id.'">'.$this->query_model->getStaticTextTranslation('select').'</span><input type="checkbox" name=""class="trial_offer_checkbox" number="'.$free->id.'"  id="checkbox_'.$free->id.'" checked /><div class="control_indicator"></div></label></div>';
					
					$html .= ' </a>';
					$html .= ' </div>';
					$html .= ' </div>';
					$html .= ' </div>';
					
					
					}
				}
				
				
				if(count($paid_trial) == 1){
					foreach($paid_trial as $paid){
						$features = unserialize($paid->features);
						$html .= '<div class="col-sm-6 col-sm-offset-3 "><div class="right-block  single_offer">';
						$html .= ' <h3>'.$paid->offer_title.'</h3>';
						
						if(!empty($paid->large_offer_text)){
							$html .= '<h2>'.$paid->large_offer_text.'</h2>';
						}else{
							$html .= '<h2>'.$site_currency_type.$paid->amount.'</h2>';
						}
						
						if(!empty($features)){
							foreach($features as $feature){
								if(!empty($feature)){
										$html .= ' <p><span class="featureBullets">&#9679; </span> '.$feature.'</p>';
								}
							}
						}
						
						//$html .= ' </ul>';
						$html .= ' <div class="check-select trialButton"   offer="paid"  id="'.$paid->id.'" amount="'.$paid->amount.'" is_child_name="'.$paid->is_child_name.'">';
						$html .= ' <a id="check'.$paid->id.'"  class="btn-animate white-btn check " href="javascript:void(0)">';
						
						$html .= '<div class="control-group left-g"><label class="control control-checkbox"><span class="selectedOffer selectedTrial'.$paid->id.'">'.$this->query_model->getStaticTextTranslation('select').'</span><input type="checkbox" name=""class="trial_offer_checkbox" number="'.$paid->id.'"  id="checkbox_'.$paid->id.'" checked /><div class="control_indicator"></div></label></div>';
						
						$html .= ' </a>';
						$html .= ' </div>';
						$html .= ' </div>';
						$html .= ' </div>';
						
					
					}
				}
				
				return $html;
			}
				
			
	}
	
	
	public function authorize_payment(){
		
		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		//echo '<pre>'; print_r($check_mailchimp); die;
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

		}else{

			$main_location_detail = $this->query_model->getMainLocation();

			$location_id = $main_location_detail[0]->id;

			

		}	


		/*********RainMark Code ******/
				
			
				$this->query_model->saveWebLeadsOnRainMark($_POST);
			
			
			/******</End Code >*****/

		//$transaction = new AuthorizeNetAIM ('6yeF84nMc6g', '5vk435V2S82rQw7V');//local
		
		$transaction = new AuthorizeNetAIM ('4U9hx8S84', '68a95CFjF6K2Sq5G'); //live

		$LOGINKEY = '4U9hx8S84';// x_login

		$TRANSKEY = '68a95CFjF6K2Sq5G';//x_tran_key

		

		$firstName =urlencode( $_POST['name']);

		$lastName =urlencode($_POST['last_name']);

		//$creditCardType =urlencode( $_POST['cardtype']);

		$creditCardNumber = urlencode($_POST['credit_card_number']);

		$expDateMonth =urlencode( $_POST['exp_month']);		

		// Month must be padded with leading zero

		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);		

		$expDateYear =urlencode( $_POST['exp_year']);

		$cvv2Number = urlencode($_POST['cvv']);

		$address1 = urlencode($_POST['address']);

		$city = urlencode($_POST['city']);

		$state =urlencode( $_POST['state']);

		$zip = urlencode($_POST['zip']);

		//give the actual amount below

		$amount = $_POST['amount'];

		$currencyCode="USD";

		$paymentType="Trial";

		$date = $expDateMonth.$expDateYear;

		

	$post_values = array(

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



	//for test mode use the followin url

	$post_url = "https://test.authorize.net/gateway/transact.dll";

	//for live use this url

	//$post_url = "https://secure.authorize.net/gateway/transact.dll"; 



	$request = curl_init($post_url); // initiate curl object

	curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response

	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)

	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data

	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.

	$post_response = curl_exec($request); // execute curl post and store results in $post_response

	// additional options may be required depending upon your server configuration

	// you can find documentation on curl options at http://www.php.net/curl_setopt

	curl_close ($request); // close curl object

	//echo '<pre>'; echo 'Request values'; print_r($post_response);

	// This line takes the response and breaks it into an array using the specified delimiting character

	$response_array = explode($post_values["x_delim_char"],$post_response);

	

	//remove this line. i have used this just print the response array

	

	//$auth_response = $transaction->authorizeAndCapture ();

	

	/** Insert Data in order table **/

	$insertOrder = array();

	$insertOrder['name'] = $_POST['name'];

	$insertOrder['last_name'] = $_POST['last_name'];

	$insertOrder['address'] = $_POST['address'];

	$insertOrder['address_line2'] = $_POST['address_line2'];

	$insertOrder['city'] = $_POST['city'];

	$insertOrder['state'] = $_POST['state'];

	$insertOrder['zip'] = $_POST['zip'];

	$insertOrder['phone'] = $_POST['phone'];

	

	$insertOrder['amount'] = $_POST['amount'];

	$insertOrder['program_id'] = $_POST['program_id'];

	$insertOrder['location_id'] = $_POST['location_id'];

	$insertOrder['email'] = $_POST['email'];

	$insertOrder['applicant_signature'] = $_POST['applicant_signature'];

	$insertOrder['trial_id'] = $_POST['trial_id'];

	$insertOrder['trans_status'] = 'failed';

	$insertOrder['offer_type'] = 'Paid';

	$insertOrder['created'] = date('Y-m-d H:i:s');

	

	$this->query_model->insertData('tblorders', $insertOrder);

	$order_id = $this->db->insert_id();

	if($response_array[0]==2 || $response_array[0]==3) 

	{

		//success 

		$result['message'] = '<h1 class="payment_result">Payment Failure</h1>'.'<p class="payment_result">Error String: '.$response_array[3].'<br>Press back button to go back to the previous page</p>';
		

			
			/****************************************************************************************************************************/
			
			
			
		
				
					if(isset($_POST['school_interest']) && !empty($_POST['school_interest'])){

						$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
			
						$location_name = $location_info[0]->name;
			
						$location_email = $location_info[0]->email;
			
					}else{
			
						$location_name = '';
			
					}
					
					$name = $_POST['name'];
					$last_name = $_POST['last_name'];
					$email = $_POST['email'];
					$phone = $_POST['phone'];
					$message = 'Payment Failure';
					$program = $_POST['program_id'];

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
				
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}	
				
			if(!empty($text_address)){
				$type = "Paid Trial | ".$school_name.' | '.$name.' '.$last_name;
				
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					$this->email->initialize($config);
					$this->email->from($email);
					$this->email->to($text_address);
					$this->email->subject($type);

					$mes ="<html><head>";
					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";
					$mes.="<style>
					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}
					body{ text-align: left; }
					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px; margin: 5px 0;}
					h6{ font-size: 14px; color: #006699; line-height:14px;}
					strong{ color:#006699; font-weight:900; }
					.content{ margin-top: 10px!important;}
					.content .row{ margin: 5px 0;}
					.row .message{ width: 700px; padding-top: 10px; }
					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}
					label{ font-weight:400; }
					</style>";

					$mes .= "</head><body>";

					if(isset($location_name) && !empty($location_name)){
						$mes .= "<h1>".$school_name." - ".$location_name."</h1>";
					}else{
						$mes .= "<h1>".$school_name."</h1>";
					}
					$mes .= $message;
															
					//$mes .= '<div class="content">';
					$mes .=	'<div class="row"><strong>Name: </strong><label>'.$name.' '.$last_name.'</label></div><br/>';
					$mes .=	'<div class="row"><strong>Email: </strong><label>'.$email.'</label></div><br/>';
					$mes .=	'<div class="row"><strong>Phone: </strong><label>'.$phone.'</label></div><br/>';
					//$mes .=	'<div class="row"><strong>Age: &nbsp;</strong><label>'.$age.'</label></div>';

					if(isset($location_name) && !empty($location_name)){
						$mes .=	'<div class="row"><strong>School Of Interest: </strong><label>'.$school_name." - ".$location_name.'</label></div><br/>';
					}else{
						$mes .=	'<div class="row"><strong>School Of Interest: </strong><label>'.$school_name.'</label></div><br/>';
					}
					$mes .=	'<div class="row"><strong>Program Of Interest:  </strong><label>'.$program.'</label></div><br/>';
								
					$mes .= '<div class="row">';
					// vinay 16_2
					$mes .= "<br/>";
					$mes .= $site_setting[0]->title."<br/>";

					/*$mes .= $location_data['address'].' ';

					$mes .=  $location_data['suite']."<br/>";

					$mes .= $location_data['city'].", ".$location_data['state']." ".$location_data['zip']."<br/>";
		
					$mes .=  $location_data['phone']."<br/>";*/
					
					//$mes .= '</div>';
					$mes .= '</div>';

					$mes .= '</body></html>';

					$this->email->message($mes);
					$this->email->send();
			}					
		/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
				
					
					$type = "Paid Trial | ".$school_name.' | '.$name.' '.$last_name;

					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to($site_email);

					$this->email->subject($type);

										

					$mes ="<html><head>";

					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

					$mes.="<style>

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px; margin: 5px 0;}

					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					.content{ margin-top: 10px!important;}

					.content .row{ margin: 5px 0;}

					.row .message{ width: 700px; padding-top: 10px; }

					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}

					label{ font-weight:400; }

			

					</style>";

					$mes .= "</head><body>";

					if(isset($location_name) && !empty($location_name)){

						$mes .= "<h1>".$school_name." - ".$location_name."</h1>";

					}else{

						$mes .= "<h1>".$school_name."</h1>";

					}

					$mes .= $message;

															

					//$mes .= '<div class="content">';

					$mes .=	'<div class="row"><strong>Name: &nbsp;</strong><label>'.$name.' '.$last_name.'</label></div>';

					$mes .=	'<div class="row"><strong>Email: &nbsp;</strong><label>'.$email.'</label></div>';

					$mes .=	'<div class="row"><strong>Phone: &nbsp;</strong><label>'.$phone.'</label></div>';

					//$mes .=	'<div class="row"><strong>Age: &nbsp;</strong><label>'.$age.'</label></div>';

					if(isset($location_name) && !empty($location_name)){

						$mes .=	'<div class="row"><strong>School Of Interest: &nbsp;</strong><label>'.$school_name." - ".$location_name.'</label></div>';

					}else{

						$mes .=	'<div class="row"><strong>School Of Interest: &nbsp;</strong><label>'.$school_name.'</label></div>';

					}

					$mes .=	'<div class="row"><strong>Program Of Interest: &nbsp;</strong><label>'.$program.'</label></div>';

										

					$mes .= '<div class="row">';

					//$mes .= '<div class="message"><p>'.$message.'</p></div>';
					
					// vinay 16_2
					$mes .= "<br/><br/>";

					
					
					$mes .= $site_setting[0]->title."<br/>";

					/*$mes .= $location_data['address'].' ';

					$mes .=  $location_data['suite']."<br/>";

					$mes .= $location_data['city'].", ".$location_data['state']." ".$location_data['zip']."<br/>";
		
					$mes .=  $location_data['phone']."<br/>";*/
					
					//$mes .= '</div>';
					$mes .= '</div>';

					$mes .= '</body></html>';

						
					//echo '<pre>'; print_r($mes); die;						

					$this->email->message($mes);

					

					$this->email->send();

					

					// send email to websitedojo.com

					$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send();

					

					

					// Email to user
			if($mailchimp_type != 1){	
					$type = $school_name. "  | Trial Started";

					$cont = "Thank you, your request was accepted! A representative from our school will contact you shortly with more information."; 

					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					$from_email=trim($this->config->item('email_from'));

					

					if(!empty($from_email)){

						$this->email->from($from_email,$school_name);

					}else{

						$this->email->from($site_email,$school_name);

					}

					
					$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);
					$this->email->reply_to($reply_to_add);

					$this->email->to($email);

					$this->email->subject($type);

												

					$mes ="<html><head>";

					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

					$mes.="<style>

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px; margin: 5px 0;}

					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					.content{ margin-top: 5px;}

					.content .row{ margin: 5px 0;}

					.row .message{ width: 700px; padding-top: 10px; }

					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}

					label{ font-weight:400; }

			

					</style>";

					$mes .= "</head><body>";

					if(isset($location_name) && !empty($location_name)){

						//$mes .= "<h1>".$school_name." - ".$location_name."</h1>";

					}else{

						//$mes .= "<h1>".$school_name."</h1>";

					}

				//	$mes .= "<strong>Trial Status - Successful</strong>";
					$mes .= $message;
													

				//	$mes .= '<div class="row">';

					$mes .= '<div class="message"><p>'.$cont.'</p></div>';
					
					$mes .= $site_setting[0]->title."<br/>";

					$mes .= $location_data['address'].' ';

					$mes .=  $location_data['suite']."<br/>";

					$mes .= $location_data['city'].", ".$location_data['state']." ".$location_data['zip']."<br/>";
		
					$mes .=  $location_data['phone']."<br/>";
					
					$mes .= '</div>';
					$mes .= '</div>';

				 	$mes .= '</body></html>';

				

					$this->email->message($mes);

					$this->email->send();
		
				} else{
					
			
					include_once 'MailChimp.php';
					
					if (!empty($name) || !empty($email)) {
						
						$name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
						$email = filter_var($email, FILTER_SANITIZE_EMAIL);
						
						/*
						 * Place here your validation and other code you're using to process your contact form.
						*/
						$mc = new \Drewm\MailChimp($mailchimp_api_key);
						
						$mvars = array('optin_ip'=> $_SERVER['REMOTE_ADDR'], 'FNAME' => $name,'LNAME'=>$last_name,'TRIALOFFER' =>'PAID','PROGRAM' =>$program,'SCHOOL' =>$location_name);
						
						$result = $mc->call('lists/subscribe', array(
								'id'                => $mailchimp_template_id,
								'email'             => array('email'=>$email),
								'merge_vars'        => $mvars,
								'double_optin'      => false,
								'send_welcome'      => false
							)
						);
				
					//echo '<pre>'; print_r($result); die;
					
					}
		
				
				}
		
			/************************************************************************************************************************/

	}

	else

	{

		

		$ptid = $response_array[6];

		

		$ptidmd5 = $response_array[7];

		

		//echo $ptid."=====>".$ptidmd5; die;

		//2250745842=====>

		$insertTransaction = array();

		$insertTransaction['transaction_id'] = $ptid;

		$insertTransaction['amount'] = 	$_POST['amount'];	

		$insertTransaction['order_id'] = $order_id;

		$this->query_model->insertData('tbl_transaction', $insertTransaction);

		

		$orderUpdate = array('trans_status' => 'Success');

		$this->query_model->update('tblorders', $order_id, $orderUpdate);

		
		
		
		/** EMAIL SEND**/
				
					if(isset($_POST['school_interest']) && !empty($_POST['school_interest'])){

						$location_info = $this->query_model->getbyId("tblcontact", $_POST['location_id']);
			
						$location_name = $location_info[0]->name;
			
						$location_email = $location_info[0]->email;
			
					}else{
			
						$location_name = '';
			
					}
					
					$name = $_POST['name'];
					$last_name = $_POST['last_name'];
					$email = $_POST['email'];
					$phone = $_POST['phone'];
					$message = 'Payment Success';
					$program = $_POST['program_id'];

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
				
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$_POST['location_id']);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}
				
				if(!empty($text_address)){
					$type = "Paid Trial | ".$school_name.' | '.$name.' '.$last_name;

					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to($text_address);

					$this->email->subject($type);

										

					$mes ="<html><head>";

					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

					$mes.="<style>

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px; margin: 5px 0;}

					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					.content{ margin-top: 10px!important;}

					.content .row{ margin: 5px 0;}

					.row .message{ width: 700px; padding-top: 10px; }

					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}

					label{ font-weight:400; }

			

					</style>";
					
					$mes .= $message;

					$mes .= "</head><body>";

					if(isset($location_name) && !empty($location_name)){

						$mes .= "<h1>".$school_name." - ".$location_name."</h1>";

					}else{

						$mes .= "<h1>".$school_name."</h1>";

					}

					//$mes .= "<strong>Trial Status - Successful</strong>";

															

					//$mes .= '<div class="content">';

					$mes .=	'<div class="row"><strong>Name: </strong><label>'.$name.' '.$last_name.'</label></div><br/>';

					$mes .=	'<div class="row"><strong>Email: </strong><label>'.$email.'</label></div><br/>';

					$mes .=	'<div class="row"><strong>Phone: </strong><label>'.$phone.'</label></div><br/>';

					//$mes .=	'<div class="row"><strong>Age: &nbsp;</strong><label>'.$age.'</label></div>';

					if(isset($location_name) && !empty($location_name)){

						$mes .=	'<div class="row"><strong>School Of Interest: </strong><label>'.$school_name." - ".$location_name.'</label></div><br/>';

					}else{

						$mes .=	'<div class="row"><strong>School Of Interest: </strong><label>'.$school_name.'</label></div><br/>';

					}

					$mes .=	'<div class="row"><strong>Program Of Interest: </strong><label>'.$program.'</label></div><br/>';

					$mes .= '<div class="row">';

					$mes .= '<div class="message"><p>'.$message.'</p></div><br/>';
					
					// vinay 16_2
					$mes .= "<br/><br/>";
					
					$mes .= $site_setting[0]->title."<br/>";

					/*$mes .= $location_data['address'].' ';

					$mes .=  $location_data['suite']."<br/>";

					$mes .= $location_data['city'].", ".$location_data['state']." ".$location_data['zip']."<br/>";
		
					$mes .=  $location_data['phone']."<br/>";*/
					
					//$mes .= '</div>';
					$mes .= '</div>';

					$mes .= '</body></html>';
					//echo '<pre>'; print_r($mes); die;						

					$this->email->message($mes);

					$this->email->send();
				}
					
	/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/				
				
				
				
				
					
					$type = "Paid Trial | ".$school_name.' | '.$name.' '.$last_name;

					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to($site_email);

					$this->email->subject($type);

										

					$mes ="<html><head>";

					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

					$mes.="<style>

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px; margin: 5px 0;}

					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					.content{ margin-top: 10px!important;}

					.content .row{ margin: 5px 0;}

					.row .message{ width: 700px; padding-top: 10px; }

					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}

					label{ font-weight:400; }

			

					</style>";
					
					$mes .= $message;

					$mes .= "</head><body>";

					if(isset($location_name) && !empty($location_name)){

						$mes .= "<h1>".$school_name." - ".$location_name."</h1>";

					}else{

						$mes .= "<h1>".$school_name."</h1>";

					}

					//$mes .= "<strong>Trial Status - Successful</strong>";

															

					//$mes .= '<div class="content">';

					$mes .=	'<div class="row"><strong>Name: &nbsp;</strong><label>'.$name.' '.$last_name.'</label></div>';

					$mes .=	'<div class="row"><strong>Email: &nbsp;</strong><label>'.$email.'</label></div>';

					$mes .=	'<div class="row"><strong>Phone: &nbsp;</strong><label>'.$phone.'</label></div>';

					//$mes .=	'<div class="row"><strong>Age: &nbsp;</strong><label>'.$age.'</label></div>';

					if(isset($location_name) && !empty($location_name)){

						$mes .=	'<div class="row"><strong>School Of Interest: &nbsp;</strong><label>'.$school_name." - ".$location_name.'</label></div>';

					}else{

						$mes .=	'<div class="row"><strong>School Of Interest: &nbsp;</strong><label>'.$school_name.'</label></div>';

					}

					$mes .=	'<div class="row"><strong>Program Of Interest: &nbsp;</strong><label>'.$program.'</label></div>';

										

					$mes .= '<div class="row">';

					$mes .= '<div class="message"><p>'.$message.'</p></div>';
					
					// vinay 16_2
					$mes .= "<br/><br/>";

					
					
					$mes .= $site_setting[0]->title."<br/>";

					/*$mes .= $location_data['address'].' ';

					$mes .=  $location_data['suite']."<br/>";

					$mes .= $location_data['city'].", ".$location_data['state']." ".$location_data['zip']."<br/>";
		
					$mes .=  $location_data['phone']."<br/>";*/
					
					//$mes .= '</div>';
					$mes .= '</div>';

					$mes .= '</body></html>';

						
					//echo '<pre>'; print_r($mes); die;						

					$this->email->message($mes);

					

					$this->email->send();

					

					// send email to websitedojo.com

					$this->email->initialize($config);

					$this->email->from($email);

					$this->email->to('leads@websitedojo.com');

					$this->email->subject($type.' - '.$school_name);

					$this->email->message($mes);					

					$this->email->send();

					

					

					// Email to user
			if($mailchimp_type != 1){
					$type = $school_name. "  | Trial Started";

					$cont = "Payment Received! <br>Thank you, your trial was successfully started. A representative from our school will contact you shortly with more information."; 

					$config['charset'] = 'iso-8859-1';

					$config['wordwrap'] = TRUE;

					$config['mailtype']="html";

					$this->email->initialize($config);

					$from_email=trim($this->config->item('email_from'));

					

					if(!empty($from_email)){

						$this->email->from($from_email,$school_name);

					}else{

						$this->email->from($site_email,$school_name);

					}

					
					$reply_to_add = str_replace('webmaster','noreply',$_SERVER['SERVER_ADMIN']);
					$this->email->reply_to($reply_to_add);

					$this->email->to($email);

					$this->email->subject($type);

												

					$mes ="<html><head>";

					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

					$mes.="<style>

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px; margin: 5px 0;}

					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					.content{ margin-top: 5px;}

					.content .row{ margin: 5px 0;}

					.row .message{ width: 700px; padding-top: 10px; }

					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}

					label{ font-weight:400; }

			

					</style>";

					$mes .= "</head><body>";

					if(isset($location_name) && !empty($location_name)){

						//$mes .= "<h1>".$school_name." - ".$location_name."</h1>";

					}else{

						//$mes .= "<h1>".$school_name."</h1>";

					}

				//	$mes .= "<strong>Trial Status - Successful</strong>";

					$mes .= $message;								

					//$mes .= '<div class="row">';

					$mes .= '<div class="message"><p>'.$cont.'</p></div>';
					
					$mes .= $site_setting[0]->title."<br/>";

					$mes .= $location_data['address'].' ';

					$mes .=  $location_data['suite']."<br/>";

					$mes .= $location_data['city'].", ".$location_data['state']." ".$location_data['zip']."<br/>";
		
					$mes .=  $location_data['phone']."<br/>";
					
					$mes .= '</div>';
					$mes .= '</div>';

				 	$mes .= '</body></html>';

				

					$this->email->message($mes);

					$this->email->send();
		
				} else{
					
			
					include_once 'MailChimp.php';
					
					if (!empty($name) || !empty($email)) {
						
						$name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
						$email = filter_var($email, FILTER_SANITIZE_EMAIL);
						
						/*
						 * Place here your validation and other code you're using to process your contact form.
						*/
						$mc = new \Drewm\MailChimp($mailchimp_api_key);
						
						$mvars = array('optin_ip'=> $_SERVER['REMOTE_ADDR'], 'FNAME' => $name,'LNAME'=>$last_name,'TRIALOFFER' =>'PAID','PROGRAM' =>$program,'SCHOOL' =>$location_name);
						
						$result = $mc->call('lists/subscribe', array(
								'id'                => $mailchimp_template_id,
								'email'             => array('email'=>$email),
								'merge_vars'        => $mvars,
								'double_optin'      => false,
								'send_welcome'      => false
							)
						);
				
					//echo '<pre>'; print_r($result); die;
					
					}
		
				
				}
		/***********/

		$result['message'] = "<h1 class='payment_result'>Payment Received!</h1><p class='payment_result'>A representative from our school will contact you shortly with more information to start your trial.</p>";
		
		//echo $result['message']; die;

	}

	

		
		echo json_encode($result['message']); die;
		//$this->load->view('payement_result', $result);
		
		
		

	}
	
	
	
	
	
	public function saveLeadsByEmails(){
		
		if(isset($_POST['submitEmail']) && !empty($_POST['submitEmail'])){
			
			
		
			/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		
			//echo '<pre>POST'; print_r($_POST); die;	
				$folder_name = $_SERVER['CONTEXT_PREFIX'];
				$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
		   
			   $meta_slug = explode('/',$_SERVER['REQUEST_URI']);
			   
			   $meta_slug = $meta_slug[1];
				
				if(!empty($meta_slug)){
					$data['page_name'] = $this->query_model->getMetaPageName($meta_slug);
				}
				
				/*** code for get page data **/
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$data['trials'] = $this->query_model->getbySpecific("$tblspecialoffer", 'display_trial', 1);
				
				 $this->db->where('display_trial',1);
				 $data['free_trial'] = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 0);
					 
				 $this->db->where('display_trial',1);
				 $data['paid_trial'] = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 1);
				
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['site_settings'] = $data['site_settings'][0];
				
				$data['trials_value'] = $this->checktrials($data['free_trial'], $data['paid_trial']);
				$this->db->where("published", 1);
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
				$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
				
				
				$data['all_programs'] = $this->query_model->getProgramLists();
				
				
				//echo '<pre>POST'; print_r($_POST); die;	
				
				$data['name']	= $this->input->post('name');
				$data['last_name']	= $this->input->post('last_name');
				$data['program_id'] = $this->input->post('program_id');
				$data['phone']	= $this->input->post('phone');
				$data['form_email_2'] = $this->input->post('form_email_2');

				$data['school_interest'] = $this->input->post('school_interest');
				$data['trial_cat_id'] = isset($_POST['trial_offer_id']) ? $_POST['trial_offer_id'] : 0;
				
				$data['miniform'] = $this->input->post('miniform');	
				$data['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : '';
								
				
				
								
				if($data['miniform'] == true && isset($data['form_email_2']) && !empty($data['form_email_2'])){
					
					// checking hunney Post
					$this->query_model->checkHunneyPost($_POST);	
					
					$mainLocation = $this->query_model->getMainLocation("tblcontact");
					
					/*
					* checkFormModuleApplyAPI 				
					* this function for using apis according form model 				
					*/				
					$_POST['name'] = '';
					$_POST['last_name'] = '';
					$_POST['phone'] = '';
					$_POST['category_name'] = isset($_POST['category_name']) ? $_POST['category_name'] : '';
					$_POST['program_name'] = isset($_POST['program_name']) ? $_POST['program_name'] : '';
					$_POST['location_id'] = (isset($_POST['school_interest']) && !empty($_POST['school_interest'])) ? $_POST['school_interest'] : $mainLocation[0]->id;
					$_POST['trial_cat_id'] = isset($_POST['trial_offer_id']) ? $_POST['trial_offer_id'] : 0;
					$_POST['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : '';
					$_POST['ip_address'] = isset($_POST['ip_address']) ? $_POST['ip_address'] : '';
					$_POST['gdpr_compliant_checkbox'] = isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : 0;
				
					
					
					/**** Start Code for Email **/
					$qry = $this->db->query("select * from `tblsite` limit 1") or die(mysqli_error($this->db->conn_id));

					$site_settings = $qry->row_array();		

					$site_email = $site_settings['email'];

					$site_title = $site_settings['title'];
					$email = $data['form_email_2'];
					$school_interest = $_POST['location_id'];
					
					if($school_interest && $school_interest != 0){

						$qry = $this->db->query("select * from `tblcontact` where id = ".$school_interest) or die(mysqli_error($this->db->conn_id));

						$location_data = $qry->row_array();

						$location_email = $location_data['email'];
						
						 $noreply_email_address = $location_data['email'];
					
					} else{
						$main_location_id = $this->query_model->getMainLocation();
						$qry = $this->db->query("select * from `tblcontact` where id = ".$main_location_id[0]->id) or die(mysqli_error($this->db->conn_id));

						$location_data = $qry->row_array();
						
						$site_setting = $this->query_model->getbyTable('tblsite');	
						$noreply_email_address = $site_setting[0]->email;
					}
					
					
					$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
					if($multiLocationData[0]->field_value == 0){
						$siteSettingData = $this->query_model->getbyTable('tblsite');	
						$noreply_email_address = $siteSettingData[0]->email;
					}
					//echo $noreply_email_address; die;
					
					//echo $noreply_email_address; die;
					$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST);
					
					// sending msg by twillio api
					$this->query_model->connectFormToTwillioAPi($_POST,'mini_and_full_form');
					
					
					//echo '<pre>emailAutoResponder'; print_r($emailAutoResponder); die;
					$this->load->library("email");
					$config['charset'] = 'UTF-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = "html";

					// email to customer
					
					if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){
						$subject = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
						
						$msg_body  = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';

						//$msg_body .= "<br/>";
						$msg_body .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';

						$this->email->initialize($config);

						$this->email->from($noreply_email_address);

						$this->email->reply_to($noreply_email_address, $site_title);

						$this->email->to($email);	

						$this->email->subject($subject);

						$this->email->message($msg_body);

						$this->email->send();
					}
					
					
					

		
				if(isset($emailAutoResponder['admin_email'])){
				// admin mail
						$subject =  isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
						
						$msg_body  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
			
						$msg_body .= "<br/>";
						//$msg_body .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';

						//echo $email.'==>'.$site_email.'==>'.$subject.'==>'.$msg_body; die;
						$config['charset'] = 'UTF-8';

						$config['wordwrap'] = TRUE;

						$config['mailtype'] = "html";
				
						$this->email->initialize($config);

						//$this->email->from('noreply@websitedojo.com');

						//$this->email->reply_to($email, $email);

						$this->email->to($noreply_email_address);	
								
						//$this->email->cc('leads@websitedojo.com');
						
						
							if(!empty($fromEmailId)){
								$this->email->from($fromEmailId);
							}
							if(!empty($email)){
								$this->email->reply_to($email);
							}
							if(!empty($cc_email)){
								$this->email->bcc($cc_email);
							}

						$this->email->subject($subject);

						$this->email->message($msg_body);
						
						$this->email->send();
				
				
				
				
				
				/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
				
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$school_interest);
					if(!empty($loc_detail)){
					$text_address = $loc_detail[0]->text_address;
					}
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					if(!empty($loc_detail)){
					$text_address = $loc_detail[0]->text_address;
					}
				}
				
				$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'mini_and_full_form');
				$subject = '';
				$msg_body  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


				if(!empty($text_address) && !empty($msg_body)){	
					
					/*$subject =   isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';

					$msg_body  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';

					$msg_body .= "<br/><br/>";*/
					//$msg_body .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
					

					$this->email->initialize($config);

					//$this->email->from('noreply@websitedojo.com');

					//$this->email->reply_to($email, $email);

					$this->email->to($text_address);	
							
					//$this->email->cc('leads@websitedojo.com');
					
					if(!empty($fromEmailId)){
						$this->email->from($fromEmailId);
					}
					if(!empty($email)){
						$this->email->reply_to($email);
					}
					if(!empty($cc_email)){
						$this->email->bcc($cc_email);
					}


					$this->email->subject($subject);

					$this->email->message($msg_body);
					
					$this->email->send();
				}	
			}	
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
			
					


					
					/** end code ***/
					
					//echo '<pre>'; print_r($_POST); die;
					$this->query_model->checkFormModuleApplyAPI($_POST);
					$this->query_model->saveFormDataOnMATApi($_POST);
					
					//$autoResponder = $this->query_model->checkFormModuleAutoResponder($_POST);				


					$insertData['email'] = $data['form_email_2'];
					
					$orderData['email'] = $data['form_email_2'];
					$orderData['created'] = date('Y-m-d h:i:s');
					$orderData['page_url'] = (isset($_POST['page_url']) && !empty($_POST['page_url'])) ? $_POST['page_url'] : '';
					$orderData['trial_cat_id'] = isset($_POST['trial_offer_id']) ? $_POST['trial_offer_id'] : 0;
					$orderData['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : '';
					$orderData['location_id'] = isset($_POST['location_id']) ? $_POST['location_id'] : '';
					//$orderData['ip_address'] = isset($_POST['ip_address']) ? $_POST['ip_address'] : '';
					$orderData['gdpr_compliant_checkbox'] = isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : '';
					$ipAddress = $this->query_model->getCountryNameToIpAddress();
					$orderData['ip_address'] = $ipAddress['client_ip_address'];
					$orderData['client_country_name'] = $ipAddress['client_country_name'];
					$orderData['request_detail'] = isset($_SERVER) ? serialize($_SERVER) : '';
					
					//echo '<prE>orderData'; print_r($_POST); die;	
					$sessionLeadsData = array('sessionLeadsData' => $_POST);
					$this->session->set_userdata($sessionLeadsData);
					
					//$this->query_model->insertData('tblpayments', $insertData);			
					
					$this->query_model->insertData('tblorders', $orderData);
					
					$order_id = $this->db->insert_id();
	
					if(!empty($order_id)){
						$current_email_info = $this->query_model->getOrderEmailInfo($_POST['form_email_2'], $_POST['name'],$orderData['page_url'],$order_id);
						
					}
					
					
					$sessionLeadsData = array('sessionLeadsData' => $_POST);
					$this->session->set_userdata($sessionLeadsData);
					
					
					

			}
			
			$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
			$start_trial_slug = $start_trial_slug[0];
			
			$dojocart_slug = $this->query_model->getbySpecific('tblmeta', 'id', 49);
			$dojocart_slug = $dojocart_slug[0];
			
			
			$redirect_url = $start_trial_slug->slug;
			
			if(isset($_POST['is_unique_trial']) && ($_POST['is_unique_trial'] == 1)){
				//echo '<pre>POST'; print_r($_POST); die;
				$program_id = isset($_POST['program_id']) ? $_POST['program_id'] : '';
				$program_cat_id = isset($_POST['program_cat_id']) ? $_POST['program_cat_id'] : '';
				$location = isset($_POST['school_interest']) ? $_POST['school_interest'] : '';
				
				
				$this->db->select(array('id','name','slug'));
				$locationDetail = $this->query_model->getBySpecific('tblcontact','id',$location);
				
				
				
				$this->db->where('program_cat_id',$program_cat_id);
				$this->db->where('unique_program_id',$program_id);
				$this->db->where('location_id',$location);
				$uniqueTrialCat = $this->query_model->getBySpecific('tbl_unique_onlinespecial_categories','type','trial_offer');
				
				$this->query_model->getAndUpdateMatApiIsAppiled($_POST);
				
				if(!empty($uniqueTrialCat)){
					$redirect_url = $start_trial_slug->slug.'/'.$uniqueTrialCat[0]->slug.'/'.$locationDetail[0]->slug;
				}else{
					$this->db->where('program_cat_id',$program_cat_id);
					$this->db->where('location_id',$location);
					if(!empty($program_id)){
						$this->db->where('unique_program_id',$program_id);
					}
					//$this->db->where('location_id','all');
					$uniqueTrialCat = $this->query_model->getBySpecific('tbl_unique_onlinespecial_categories','type','trial_offer');
					
					if(!empty($uniqueTrialCat)){
						$redirect_url = $start_trial_slug->slug.'/'.$uniqueTrialCat[0]->slug;
					}else{
						$this->db->where('program_cat_id',$program_cat_id);
						
						$this->db->where('location_id','all');
						$uniqueTrialCat = $this->query_model->getBySpecific('tbl_unique_onlinespecial_categories','type','trial_offer');
						if(!empty($uniqueTrialCat)){
							$redirect_url = $start_trial_slug->slug.'/'.$uniqueTrialCat[0]->slug;
						}
					}
				}
				
				
				
				$redirect_url = base_url().$redirect_url;
				
				redirect($redirect_url);
			}
			
			
			
				if(isset($_POST['redirection_type']) && !empty($_POST['redirection_type'])){
					if($_POST['redirection_type'] == "trial_offer" && isset($_POST['trial_offer_id']) && !empty($_POST['trial_offer_id'])){
						
						$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
						
						$trialOfferDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_categories", 'id', $_POST['trial_offer_id']);
						if(!empty($trialOfferDetail)){
							
							$redirect_url = '/'.$start_trial_slug->slug.'/'.$trialOfferDetail[0]->slug;
						}
					}elseif($_POST['redirection_type'] == "dojocart" && isset($_POST['dojocart_id']) && !empty($_POST['dojocart_id'])){
						$dojocartDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $_POST['dojocart_id']);
						if(!empty($dojocartDetail)){
							$redirect_url = '/'.$dojocart_slug->slug.'/'.$dojocartDetail[0]->slug;
						}
					}elseif($_POST['redirection_type'] == "thankyou_page" && isset($_POST['thankyou_page_id']) && !empty($_POST['thankyou_page_id'])){
						
						$this->query_model->getThankYouPageProgramPageMessage($_POST,$_POST['thankyou_page_id']);
						$program_thankyou_url = $this->query_model->getProgramThankyouUrl($_POST);
					
						redirect(@base_url().$program_thankyou_url);
						//redirect(@base_url().'site/thankyou');
					}elseif($_POST['redirection_type'] == "third_party_url" && isset($_POST['third_party_url']) && !empty($_POST['third_party_url'])){
						$redirect_url = $_POST['third_party_url'];
					}
				}
			
			$this->query_model->getAndUpdateMatApiIsAppiled($_POST);
			
			redirect($redirect_url);
			
			/*if(isset($_POST['trial_offer_id']) && !empty($_POST['trial_offer_id'])){
				$trialOfferDetail = $this->query_model->getbySpecific('tbl_onlinespecial_categories', 'id', $_POST['trial_offer_id']);
				
				if(!empty($trialOfferDetail)){
					redirect('/'.$data['trial_offer_slug']->slug.'/'.$trialOfferDetail[0]->slug);
				}else{
					redirect('/trial-offer');
				}
			}else{
				redirect('/trial-offer');
			}*/
			
		
		}
		
	}

	
/*
	public function trial(){
		
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		$data['site_settings'] = $data['site_settings'][0];
		
		$data['settings'] = $data['site_settings'];
		
		
		$this->db->where("published", 1);
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		
		
		$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
		$data['contact_slug'] = $data['contact_slug'][0];
		
		$this->db->where("published", 1);
		$this->db->order_by("pos","asc");
		$data['form_allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		
		$data['all_programs'] = $this->query_model->getProgramLists();
		
		$setting = $this->query_model->getbyTable('tblsite');
		$setting = $setting[0];
			
		$this->db->order_by('id', 'desc');
		$this->db->limit(2);
		$this->db->where("published", 1);
		$data['myTestimonials'] = $this->query_model->getbyTable("tbltestimonials");
		
		$data['header'] = $this->query_model->getbySpecific('tbl_onlinespecial_header', 'id', 1);
		$data['header'] = !empty($data['header']) ? $data['header'][0] : array();
		
		$data['text_sections'] = $this->query_model->getbySpecific('tbl_onlinespecial_text_sections', 'id', 1);
		$data['text_sections'] = !empty($data['text_sections']) ? $data['text_sections'][0] : array();

		$data['email_options'] = $this->query_model->getbySpecific('tbl_onlinespecial_email_options', 'id', 1);
		$data['email_options'] = !empty($data['email_options']) ? $data['email_options'][0] : array();

		$this->db->order_by('pos', 'asc');
		$this->db->where("published", 1);
		$data['onlinespecialRows'] = $this->query_model->getbySpecific('tbl_onlinespecial_rows', 'published', 1); 
		
		$this->db->order_by('pos', 'asc');
		$this->db->where("status", 1);
		$data['trial_categories'] = $this->query_model->getbyTable('tbl_onlinespecial_categories');
				
		
		//echo '<pre>data'; print_r($data); die;
		$this->load->view('trial', $data);
		
	} */
	
	
	public function trial_offer_category(){
		
		if(!empty($this->uri->segment(2))){
			
			
			
		
			$isUniqueTrial = $this->query_model->isTrialOfferUnique();
			$special_offer_table = ($isUniqueTrial == "unique_") ? '_unique_specialoffer' : 'specialoffer';
			
			$this->db->where("published", 1);
			$this->db->where("slug", $this->uri->segment(2));
			$trial_offer_cat = $this->query_model->getbyTable('tbl_'.$isUniqueTrial.'onlinespecial_categories');
			$trial_offer_cat= !empty($trial_offer_cat) ? $trial_offer_cat[0] : array();
			
			$data['trial_offer_cat'] = $trial_offer_cat;
			
			//echo '<prE>trial_offer_cat'; print_r($trial_offer_cat); die;
			$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
			$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
			
			$data['twilioApi'] = $this->query_model->getTwilioApiType();
			
			
			//echo '<pre>trial_offer_cat'; print_r($trial_offer_cat); die;
			if(!empty($trial_offer_cat)){
						$folder_name = $_SERVER['CONTEXT_PREFIX'];
						$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
				   
					   $meta_slug = explode('/',$_SERVER['REQUEST_URI']);
					   
					   $meta_slug = $meta_slug[1];
						
						if(!empty($meta_slug)){
							$data['page_name'] = $this->query_model->getMetaPageName($meta_slug);
						}
						
						/*** code for get page data **/
						 $this->db->where('cat_id',$trial_offer_cat->id);
						$data['trials'] = $this->query_model->getbySpecific('tbl'.$special_offer_table, 'display_trial', 1);
						
						
						 $this->db->where('display_trial',1);
						 $this->db->where('cat_id',$trial_offer_cat->id);
						 $data['free_trial'] = $this->query_model->getbySpecific('tbl'.$special_offer_table, 'trial', 0);
							 
						 $this->db->where('display_trial',1);
						  $this->db->where('cat_id',$trial_offer_cat->id);
						 $data['paid_trial'] = $this->query_model->getbySpecific('tbl'.$special_offer_table, 'trial', 1);
						 
						 $data['show_trialoffer_coupons'] = $this->query_model->showCouponBoxForTrialOffers($trial_offer_cat->id);
						 
						
						$data['site_settings'] = $this->query_model->getbyTable("tblsite");
						$data['site_settings'] = $data['site_settings'][0];
						
						$data['settings'] = $data['site_settings'];
						
						$data['trials_value'] = $this->checktrials($data['free_trial'], $data['paid_trial']);
						
						/*if($this->query_model->checkMultiSchoolIsOn() == 1){
							$this->db->where("turn_on_nested_location", 0);  //not nested child locations
						}
						$this->db->where("published", 1);
						$data['allLocations'] = $this->query_model->getbyTable("tblcontact");*/
						
						$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
						
						$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
						
						
						
						$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
						$data['contact_slug'] = $data['contact_slug'][0];
						
						
						
						//$data['form_allLocations'] = $this->query_model->getFormAllLocations('include_main_location');
						
						//$data['all_programs'] = $this->query_model->getProgramLists();
						$allProgramsArr = array();
						$this->db->select("cat_id");
						$this->db->where('redirection_type',"trial_offer");
						$programCats = $this->query_model->getbySpecific('tblcategory', 'trial_offer_id', $trial_offer_cat->id);
						//echo "<prE>programCats"; print_r($programCats); die;
						if(!empty($programCats)){
							foreach($programCats as $program_cat){
								
								$this->db->select(array("id",'buttonName','category','program','program_slug','redirection_type','trial_offer_id','connect_trial_offer_id','show_location_type','locations'));
								$this->db->where('published',1);
								$programs = $this->query_model->getbySpecific('tblprogram', 'category', $program_cat->cat_id);
								
								if(!empty($programs)){
									foreach($programs as $program){
										$show_program = 0;
										/*if($program->redirection_type == "trial_offer"){
											if($program->connect_trial_offer_id == $trial_offer_cat->id){
													$show_program = 1;
											}
										}*/
										
										if($program->connect_trial_offer_id == $trial_offer_cat->id){
												$show_program = 1;
										}
										
										if($show_program == 1){
											$allProgramsArr[$program->id] = $program;
										}
										
									}
								}
							}
						}
						
						
						$this->db->select(array("id",'buttonName','category','program','program_slug','redirection_type','trial_offer_id','show_location_type','locations'));
						$this->db->where('published',1);
						//$this->db->where('redirection_type',"trial_offer");
						$other_programs = $this->query_model->getbySpecific('tblprogram', 'connect_trial_offer_id', $trial_offer_cat->id);
						if(!empty($other_programs)){
							foreach($other_programs as $program){
								$allProgramsArr[$program->id] = $program;
							}
						}
						
						$data['all_programs'] = $allProgramsArr;
						
						/************/
						
						$data['form_allLocations'] = $this->query_model->getFormAllLocations('include_main_location');
						
						if($this->query_model->checkMultiSchoolIsOn() == 1){
							$this->db->where("turn_on_nested_location", 0);  //not nested child locations
						}
						$this->db->where("published", 1);
						$page_allLocations = $this->query_model->getbyTable("tblcontact");
						$data['allLocations'] = $page_allLocations;
						$data['trialLocations'] = $page_allLocations;
					    
					    $selectedLocs = array();
					    
						$is_any_all_pro = 0;
						if(!empty($data['all_programs'])){
						    foreach($data['all_programs'] as $key => $progm){
						        if($progm->show_location_type == "show_all"){
						            $is_any_all_pro = 1;
						        }
						    }
						}
						
						if($is_any_all_pro == 0){
						    if(!empty($data['all_programs'])){
						        foreach($data['all_programs'] as $key => $progm){
    						        if($progm->show_location_type == "select_location"){
    						            $selectedLocationsArr = !empty($progm->locations) ? unserialize($progm->locations) : array();
    								
        								if(!empty($selectedLocationsArr)){
        								    foreach($page_allLocations as $k => $loc){
        								       
        								       if(in_array($loc->id,$selectedLocationsArr)){
            										$selectedLocs[$loc->id] = $loc;
            									} 
        								    }
        									$data['trialLocations'] = $selectedLocs;
        								}
    						        }
    						    }
    						}
						}
						/**************/
						/**************/
						
						
						$data['name']	= isset($_POST['name']) ? $_POST['name'] : '';
						$data['last_name']	=  isset($_POST['last_name']) ? $_POST['last_name'] : '';
						$data['program_id'] =  isset($_POST['program_id']) ? $_POST['program_id'] : '';
						$data['phone']	=  isset($_POST['phone']) ? $_POST['phone'] : '';
						$data['form_email_2'] =  isset($_POST['form_email_2']) ? $_POST['form_email_2'] : '';

						$data['school_interest'] =  isset($_POST['school_interest']) ? $_POST['school_interest'] : '';
						
						$data['miniform'] =  isset($_POST['miniform']) ? $_POST['miniform'] : '';	

						
						/*$sessionLeadsData = array('sessionLeadsData' => $_POST);
						$this->session->set_userdata($sessionLeadsData);
						
						
						if(!empty($data['name']) && !empty($data['form_email_2']) && ($data['miniform'] == true)){
							
							// checking hunney Post
							 $this->query_model->checkHunneyPost($_POST);		


							$insertData['phone'] = $data['phone'];				

							$insertData['name'] = $data['name'];
							
							$insertData['last_name'] = $data['last_name'];

							$insertData['email'] = $data['form_email_2'];
							
							$orderData['phone'] = $data['phone'];	
							$orderData['name'] = $data['name'];
							$orderData['last_name'] = $data['last_name'];
							$orderData['email'] = $data['form_email_2'];
							$orderData['created'] = date('Y-m-d h:i:s');
							//$orderData['ip_address'] = $_SERVER['REMOTE_ADDR'];
							//$orderData['ip_address_status'] = 0;
							
							if($data['school_interest'] && $data['school_interest'] != 0){

								$qry = $this->db->query("select * from `tblcontact` where id = ".$data['school_interest']) or die(mysqli_error($this->db->conn_id));
					
								$location_data = $qry->row_array();
					
								$insertData['school_of_interest'] = $location_data['name'];
								
								$orderData['location_id'] = $data['school_interest'];
					
							}
								
								
								$this->query_model->checkFormModuleApplyAPI($_POST);
										

							$this->sendQuickEnquiry();	
						
							
							$this->query_model->insertData('tblpayments', $insertData);			
							
							$this->query_model->insertData('tblorders', $orderData);
							
							$order_id = $this->db->insert_id();
							if(!empty($order_id)){
								$current_email_info = $this->query_model->getOrderEmailInfo($_POST['form_email_2'], $_POST['name'] );
							}
							
						}*/
					
					
					$clientToken = '';
					$brainTreeDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
					
					if(!empty($brainTreeDetail)){
						if($brainTreeDetail[0]->braintree_payment == 1  && !empty($data['paid_trial'])){
							
							$braintree_merchant_id = $brainTreeDetail[0]->braintree_merchant_id;
							$braintree_public_key = $brainTreeDetail[0]->braintree_public_key;
							$braintree_private_key = $brainTreeDetail[0]->braintree_private_key;
							
							include("./vendor/lib/Braintree.php");
							//$this->load->library('Braintree');
							
							/*$gateway = new Braintree_Gateway([
											'environment' => $brainTreeDetail[0]->braintree_payment_mode,
											'merchantId' => $braintree_merchant_id,
											'publicKey' => $braintree_public_key,
											'privateKey' => $braintree_private_key
										]);
							
							// or like this:
							$config = new Braintree_Configuration([
								'environment' => $brainTreeDetail[0]->braintree_payment_mode,
								'merchantId' => $braintree_merchant_id,
								'publicKey' => $braintree_public_key,
								'privateKey' => $braintree_private_key
							]);*/
							
							try {
								$gateway = new Braintree\Gateway([
												'environment' => $brainTreeDetail[0]->braintree_payment_mode,
												'merchantId' => $braintree_merchant_id,
												'publicKey' => $braintree_public_key,
												'privateKey' => $braintree_private_key
											]);
								
								$clientToken = $gateway->clientToken()->generate();
								
							} catch (Braintree\Exception\Authentication $e) {
								echo 'Authentication Error ! '. $e->getMessage(); die;
							}
							

							
							/*if($brainTreeDetail[0]->braintree_payment_mode == "production"){
								Braintree_Configuration::environment('production');
							}else{
								Braintree_Configuration::environment('sandbox');
							}

							Braintree_Configuration::merchantId($braintree_merchant_id);
							Braintree_Configuration::publicKey($braintree_public_key);
							Braintree_Configuration::privateKey($braintree_private_key);
				
							$clientToken = Braintree_ClientToken::generate();	*/						
						}
						
					}
					
					// Stripe SCA
					$data['stripePayment'] = $this->query_model->getStripePaymentKeys();
					
					
					
					$data['clientToken'] = $clientToken;	
						
					$this->load->view('start-trial', $data);

						
			}else{
				redirect($data['trial_offer_slug']->slug);
			}
					
		}
	}


	public function thankyou(){
		
		
					
		$thankyouPageDetail = $this->session->userdata('thankyouPageDetail');
		
		
		$this->query_model->saveFormDataOnMATApi($thankyouPageDetail);
		
		//$this->session->set_userdata('test1','vinay');
		//echo $this->session->userdata('test1');
		//echo '<pre>1-thankyouPageDetail=>'; print_r($thankyouPageDetail); die;
		$data['upsells'] =array();
		
		$data['twilioApi'] = $this->query_model->getTwilioApiType();
		
		if(!empty($thankyouPageDetail)){
			
			// Stripe SCA
			$data['stripePayment'] = $this->query_model->getStripePaymentKeys($thankyouPageDetail['postData']);
			
			$data['paymentDetail'] = $this->query_model->getbySpecific('tbl_payments','id',1);
			
			
			$data['thankyou_message'] = '';
			if(isset($thankyouPageDetail['thankyou_page_id'])){
				$this->db->where('status',1);
				$thankyouMessage = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', $thankyouPageDetail['thankyou_page_id']);
				
				if(!empty($thankyouMessage)){
					
					$data['thankyou_message'] = $thankyouMessage[0]->description;
					
					
				}
			}
			
			//$data['thankyou_message'] = !empty($thankyouPageDetail) ? $thankyouPageDetail['message'] : '';
			$data['postData'] = $thankyouPageDetail['postData'];
			
			if(isset($thankyouPageDetail['trial_id'])){
				
				$data['trial_id'] = $thankyouPageDetail['trial_id'];
				$data['order_id'] = $thankyouPageDetail['order_id'];
				$data['trial_type'] = $thankyouPageDetail['trial_type'];
				
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$this->db->where("id", $data['trial_id']);
				$trialOfferDetail = $this->query_model->getbyTable("$tblspecialoffer");
				$data['trialOfferDetail'] = !empty($trialOfferDetail) ? $trialOfferDetail[0] : '';
				
				if(!empty($data['trialOfferDetail']) && $data['trialOfferDetail']->upsale == 1){
					$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
					$data['upsells'] = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales",'trial_offer_id',$thankyouPageDetail['trial_id']);
				}
				
				
				
			}
			//echo '<pre>thankyouPageDetail'; print_r($thankyouPageDetail); 
			//echo '<pre>data'; print_r($data); die;
			$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
			$data['contact_slug'] = $data['contact_slug'][0];
		
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			
			$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
			$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
			
		
			$this->db->where("published", 1);
			if($data['multiSchool'] == 1){
				$this->db->where("main_location", 0);
			}
			$this->db->where("location_type", 'regular_link');
			$this->db->order_by("pos","asc");
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			
			
			
			$data['form_allLocations'] = $this->query_model->getFormAllLocations();
			
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			
				$clientToken = '';
					$brainTreeDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
					
					if(!empty($brainTreeDetail)){
						if($brainTreeDetail[0]->braintree_payment == 1){
							
							$braintree_merchant_id = $brainTreeDetail[0]->braintree_merchant_id;
							$braintree_public_key = $brainTreeDetail[0]->braintree_public_key;
							$braintree_private_key = $brainTreeDetail[0]->braintree_private_key;
							
							include("./vendor/lib/Braintree.php");
							//$this->load->library('Braintree');
							
							/*$gateway = new Braintree_Gateway([
											'environment' => $brainTreeDetail[0]->braintree_payment_mode,
											'merchantId' => $braintree_merchant_id,
											'publicKey' => $braintree_public_key,
											'privateKey' => $braintree_private_key
										]);
							
							// or like this:
							$config = new Braintree_Configuration([
								'environment' => $brainTreeDetail[0]->braintree_payment_mode,
								'merchantId' => $braintree_merchant_id,
								'publicKey' => $braintree_public_key,
								'privateKey' => $braintree_private_key
							]);*/
							
							try {
								$gateway = new Braintree\Gateway([
														'environment' => $brainTreeDetail[0]->braintree_payment_mode,
														'merchantId' => $braintree_merchant_id,
														'publicKey' => $braintree_public_key,
														'privateKey' => $braintree_private_key
													]);
								
								$clientToken = $gateway->clientToken()->generate();
							} catch (Braintree\Exception\Authentication $e) {
								echo 'Authentication Error ! '. $e->getMessage(); die;
							}
							
						
						}
						
					}
					
			$data['clientToken'] = $clientToken;
			
			$this->load->view('thankyou_trial', $data);
		}else{
			
			//$this->load->view('thankyou_trial', $data);
			redirect(base_url());
		}
	}


	public function unsetTrialSession(){
		$sessionData = $this->session->userdata('thankyouPageDetail');
		//$this->query_model->saveFormDataOnMATApi($sessionData);
		if(!empty($sessionData)){
			$orderDetail = $this->query_model->getBySpecific('tblorders','id',$sessionData['order_id']);
			
			if(!empty($orderDetail)){
				$updateOrderData['client_id'] = '';
				$updateOrderData['client_token'] = '';

				$this->query_model->update('tblorders',$orderDetail[0]->id, $updateOrderData);
			}
			
			$this->session->unset_userdata('thankyouPageDetail');
		
		
			$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
			$data['contact_slug'] = $data['contact_slug'][0];
		
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			
			
			$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
			$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		
			$this->db->where("published", 1);
			if($data['multiSchool'] == 1){
				$this->db->where("main_location", 0);
			}
			$this->db->where("location_type", 'regular_link');
			$this->db->order_by("pos","asc");
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			
			
			
			$data['form_allLocations'] = $this->query_model->getFormAllLocations();
			
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			$data['thankyouMessage'] = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 8);
			
			$data['twilioApi'] = $this->query_model->getTwilioApiType();
			
			$this->load->view('unset_trial_session', $data);
		}else{
			redirect(base_url());
		}
		
		//
	}

	
	
	
	public function distoryTrialSession(){
		$sessionData = $this->session->userdata('thankyouPageDetail');
		//echo '<pre>sessionData'; print_r($sessionData); die;
		//$this->query_model->saveFormDataOnMATApi($sessionData);
		if(!empty($sessionData) && isset($sessionData['order_id'])){
			$orderDetail = $this->query_model->getBySpecific('tblorders','id',$sessionData['order_id']);
			
			if(!empty($orderDetail)){
				$updateOrderData['client_id'] = '';
				$updateOrderData['client_token'] = '';

				$this->query_model->update('tblorders',$orderDetail[0]->id, $updateOrderData);
			}
			
			$this->session->unset_userdata('thankyouPageDetail');
		
		
			$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
			$data['contact_slug'] = $data['contact_slug'][0];
		
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			
			$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
			$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
	
	
			$this->db->where("published", 1);
			if($data['multiSchool'] == 1){
				$this->db->where("main_location", 0);
			}
			$this->db->where("location_type", 'regular_link');
			$this->db->order_by("pos","asc");
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			
			
			
			$data['form_allLocations'] = $this->query_model->getFormAllLocations();
			
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			$data['thankyouMessage'] = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', 8);
			
			$data['twilioApi'] = $this->query_model->getTwilioApiType();
			
			$this->load->view('unset_trial_session', $data);
		}else{
			redirect(base_url());
		}
		
		//
	}
	
	
	public function redirectEmailOptinForm(){
		
		if(isset($_POST['submitEmail'])){
			//echo "<pre>POST"; print_r($_POST); die;
				$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
				$start_trial_slug = $start_trial_slug[0];
				$redirect_url = '/'.$start_trial_slug->slug;
				if(isset($_POST['redirection_type']) && !empty($_POST['redirection_type'])){
					if($_POST['redirection_type'] == "trial_offer" && isset($_POST['trial_offer_id']) && !empty($_POST['trial_offer_id'])){
						
						$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
						
						$trialOfferDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_categories", 'id', $_POST['trial_offer_id']);
						if(!empty($trialOfferDetail)){
							$redirect_url = '/'.$start_trial_slug->slug.'/'.$trialOfferDetail[0]->slug;
						}
					}
				}
				//echo $redirect_url; die;
				redirect($redirect_url);
		}
	}
	
	
	public function unique_trial_offer_category(){
		
		if(!empty($this->uri->segment(2)) && !empty($this->uri->segment(3))){
			
			$isUniqueTrial = $this->query_model->isTrialOfferUnique();
			$special_offer_table = ($isUniqueTrial == "unique_") ? '_unique_specialoffer' : 'specialoffer';
			
			$this->db->where("published", 1);
			$this->db->where("slug", $this->uri->segment(2));
			$trial_offer_cat = $this->query_model->getbyTable('tbl_'.$isUniqueTrial.'onlinespecial_categories');
			$trial_offer_cat= !empty($trial_offer_cat) ? $trial_offer_cat[0] : array();
			
			$data['trial_offer_cat'] = $trial_offer_cat;
			
			//echo '<prE>trial_offer_cat'; print_r($trial_offer_cat); die;
			$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
			$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
			
			$data['twilioApi'] = $this->query_model->getTwilioApiType();
			
			
			//echo '<pre>trial_offer_cat'; print_r($trial_offer_cat); die;
			if(!empty($trial_offer_cat)){
						$folder_name = $_SERVER['CONTEXT_PREFIX'];
						$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
				   
					   $meta_slug = explode('/',$_SERVER['REQUEST_URI']);
					   
					   $meta_slug = $meta_slug[1];
						
						if(!empty($meta_slug)){
							$data['page_name'] = $this->query_model->getMetaPageName($meta_slug);
						}
						
						/*** code for get page data **/
						 $this->db->where('cat_id',$trial_offer_cat->id);
						$data['trials'] = $this->query_model->getbySpecific('tbl'.$special_offer_table, 'display_trial', 1);
						
						
						 $this->db->where('display_trial',1);
						 $this->db->where('cat_id',$trial_offer_cat->id);
						 $data['free_trial'] = $this->query_model->getbySpecific('tbl'.$special_offer_table, 'trial', 0);
							 
						 $this->db->where('display_trial',1);
						  $this->db->where('cat_id',$trial_offer_cat->id);
						 $data['paid_trial'] = $this->query_model->getbySpecific('tbl'.$special_offer_table, 'trial', 1);
						 
						 $data['show_trialoffer_coupons'] = $this->query_model->showCouponBoxForTrialOffers($trial_offer_cat->id);
						 
						
						$data['site_settings'] = $this->query_model->getbyTable("tblsite");
						$data['site_settings'] = $data['site_settings'][0];
						
						$data['settings'] = $data['site_settings'];
						
						$data['trials_value'] = $this->checktrials($data['free_trial'], $data['paid_trial']);
						
						$this->db->where("published", 1);
						$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
						
						$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
						
						$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
						
						
						
						$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
						$data['contact_slug'] = $data['contact_slug'][0];
						
						$this->db->where("published", 1);
						$this->db->order_by("pos","asc");
						$data['form_allLocations'] = $this->query_model->getbyTable("tblcontact");
						
						
						//$data['all_programs'] = $this->query_model->getProgramLists();
						$allProgramsArr = array();
						$this->db->select("cat_id");
						$this->db->where('redirection_type',"trial_offer");
						$programCats = $this->query_model->getbySpecific('tblcategory', 'trial_offer_id', $trial_offer_cat->id);
						//echo "<prE>programCats"; print_r($programCats); die;
						if(!empty($programCats)){
							foreach($programCats as $program_cat){
								
								$this->db->select(array("id",'buttonName','category','program','program_slug','redirection_type','trial_offer_id','connect_trial_offer_id'));
								$this->db->where('published',1);
								$programs = $this->query_model->getbySpecific('tblprogram', 'category', $program_cat->cat_id);
								
								if(!empty($programs)){
									foreach($programs as $program){
										$show_program = 0;
										/*if($program->redirection_type == "trial_offer"){
											if($program->connect_trial_offer_id == $trial_offer_cat->id){
													$show_program = 1;
											}
										}*/
										
										if($program->connect_trial_offer_id == $trial_offer_cat->id){
												$show_program = 1;
										}
										
										if($show_program == 1){
											$allProgramsArr[$program->id] = $program;
										}
										
									}
								}
							}
						}
						
						
						$this->db->select(array("id",'buttonName','category','program','program_slug','redirection_type','trial_offer_id'));
						$this->db->where('published',1);
						//$this->db->where('redirection_type',"trial_offer");
						$other_programs = $this->query_model->getbySpecific('tblprogram', 'connect_trial_offer_id', $trial_offer_cat->id);
						if(!empty($other_programs)){
							foreach($other_programs as $program){
								$allProgramsArr[$program->id] = $program;
							}
						}
						
						$data['all_programs'] = $allProgramsArr;
						
						$data['form_allLocations'] = $this->query_model->getFormAllLocations('include_main_location');
						
						if($this->query_model->checkMultiSchoolIsOn() == 1){
							$this->db->where("turn_on_nested_location", 0);  //not nested child locations
						}
						$this->db->where("published", 1);
						$page_allLocations = $this->query_model->getbyTable("tblcontact");
						$data['allLocations'] = $page_allLocations;
						$data['trialLocations'] = $page_allLocations;
					    
					    $selectedLocs = array();
					    
						
						$is_any_all_pro = 0;
						if(!empty($data['all_programs'])){
						    foreach($data['all_programs'] as $key => $progm){
						        if($progm->show_location_type == "show_all"){
						            $is_any_all_pro = 1;
						        }
						    }
						}
						
						if($is_any_all_pro == 0){
						    if(!empty($data['all_programs'])){
						        foreach($data['all_programs'] as $key => $progm){
    						        if($progm->show_location_type == "select_location"){
    						            $selectedLocationsArr = !empty($progm->locations) ? unserialize($progm->locations) : array();
    								
        								if(!empty($selectedLocationsArr)){
        								    foreach($page_allLocations as $k => $loc){
        								       
        								       if(in_array($loc->id,$selectedLocationsArr)){
            										$selectedLocs[$loc->id] = $loc;
            									} 
        								    }
        									$data['trialLocations'] = $selectedLocs;
        								}
    						        }
    						    }
    						}
						}
						
						
						$data['name']	= isset($_POST['name']) ? $_POST['name'] : '';
						$data['last_name']	=  isset($_POST['last_name']) ? $_POST['last_name'] : '';
						$data['program_id'] =  isset($_POST['program_id']) ? $_POST['program_id'] : '';
						$data['phone']	=  isset($_POST['phone']) ? $_POST['phone'] : '';
						$data['form_email_2'] =  isset($_POST['form_email_2']) ? $_POST['form_email_2'] : '';

						$data['school_interest'] =  isset($_POST['school_interest']) ? $_POST['school_interest'] : '';
						
						$data['miniform'] =  isset($_POST['miniform']) ? $_POST['miniform'] : '';			
						
						
						/*$sessionLeadsData = array('sessionLeadsData' => $_POST);
						$this->session->set_userdata($sessionLeadsData);
						
						
						if(!empty($data['name']) && !empty($data['form_email_2']) && ($data['miniform'] == true)){
							
							// checking hunney Post
							 $this->query_model->checkHunneyPost($_POST);		


							$insertData['phone'] = $data['phone'];				

							$insertData['name'] = $data['name'];
							
							$insertData['last_name'] = $data['last_name'];

							$insertData['email'] = $data['form_email_2'];
							
							$orderData['phone'] = $data['phone'];	
							$orderData['name'] = $data['name'];
							$orderData['last_name'] = $data['last_name'];
							$orderData['email'] = $data['form_email_2'];
							$orderData['created'] = date('Y-m-d h:i:s');
							//$orderData['ip_address'] = $_SERVER['REMOTE_ADDR'];
							//$orderData['ip_address_status'] = 0;
							
							if($data['school_interest'] && $data['school_interest'] != 0){

								$qry = $this->db->query("select * from `tblcontact` where id = ".$data['school_interest']) or die(mysqli_error($this->db->conn_id));
					
								$location_data = $qry->row_array();
					
								$insertData['school_of_interest'] = $location_data['name'];
								
								$orderData['location_id'] = $data['school_interest'];
					
							}
								
								
								$this->query_model->checkFormModuleApplyAPI($_POST);
										

							$this->sendQuickEnquiry();	
						
							
							$this->query_model->insertData('tblpayments', $insertData);			
							
							$this->query_model->insertData('tblorders', $orderData);
							
							$order_id = $this->db->insert_id();
							if(!empty($order_id)){
								$current_email_info = $this->query_model->getOrderEmailInfo($_POST['form_email_2'], $_POST['name'] );
							}
							
						}*/
					
					
					$clientToken = '';
					$brainTreeDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
					
					if(!empty($brainTreeDetail)){
						if($brainTreeDetail[0]->braintree_payment == 1){
							
							$braintree_merchant_id = $brainTreeDetail[0]->braintree_merchant_id;
							$braintree_public_key = $brainTreeDetail[0]->braintree_public_key;
							$braintree_private_key = $brainTreeDetail[0]->braintree_private_key;
							
							include("./vendor/Braintree.php");
							//$this->load->library('Braintree');
							
							if($brainTreeDetail[0]->braintree_payment_mode == "production"){
								Braintree_Configuration::environment('production');
							}else{
								Braintree_Configuration::environment('sandbox');
							}

						Braintree_Configuration::merchantId($braintree_merchant_id);
						Braintree_Configuration::publicKey($braintree_public_key);
						Braintree_Configuration::privateKey($braintree_private_key);
			
						$clientToken = Braintree_ClientToken::generate();							
						}
						
					}
					
					$data['clientToken'] = $clientToken;
					
					
					// Stripe SCA
					$data['stripePayment'] = $this->query_model->getStripePaymentKeys();
						
					$this->load->view('start-trial', $data);

						
			}else{
				redirect($data['trial_offer_slug']->slug);
			}
					
		}
	}

	
	public function thankyou_upsell(){
		$thankyouMessage = $this->session->userdata('thankyouMessage');
		$this->query_model->saveFormDataOnMATApi($thankyouMessage);
		
		if(!empty($thankyouMessage)){
			
			$data = $this->query_model->getThankyouPageData($thankyouMessage);
			
			$this->load->view('thankyou-page-message', $data);
		}else{
			redirect(base_url());
		}
	}
	
	
	
	public function ajaxStripePaymentIntent(){
		
		$result = array();
		$result['res'] = 0;
		if(isset($_POST['stripe_action']) && !empty($_POST['stripe_action'])){
			
			$stripePayment = $this->query_model->getStripePaymentKeys($_POST);
			
			if(!empty($stripePayment) &&  $stripePayment['stripe_payment'] == 1 &&  $stripePayment['stripe_sca_payment'] == 1 && isset($stripePayment['stripe_secret_key']) && !empty($stripePayment['stripe_secret_key'])){
					
					$stripe_action = $_POST['stripe_action'];
					$payment_intent_id = isset($_POST['payment_intent_id']) ? $_POST['payment_intent_id'] : '';
					$amount = (isset($_POST['amount']) && !empty($_POST['amount'])) ? $_POST['amount'] : 0;
					$currency = $this->query_model->getSiteCurrencyTypeForPaymentGateway();
					
					
					$postData  =array('stripe_secret_key'=> $stripePayment['stripe_secret_key'],'stripe_action'=>$stripe_action,'amount'=>$amount,'currency'=>$currency,'payment_method_types'=>'card','payment_intent_id'=>$payment_intent_id);
					$url = base_url().'vendor/stripe-latest/custom_stripe.php?stripe_secret_key='.$stripePayment['stripe_secret_key'];
					
					$request = curl_init($url); // initiate curl object
					curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
					curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
					curl_setopt($request, CURLOPT_POSTFIELDS, $postData); // use HTTP POST to send form data
					curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
					curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

					$response = (string)curl_exec($request); // execute curl post and store results in $response

					// additional options may be required depending upon your server configuration
					// you can find documentation on curl options at http://www.php.net/curl_setopt
					curl_close($request); // close curl object
					
					//echo '<pre>response'; print_r($response); die;
					$response = json_decode($response);
					
					
					
					$result['payment_intent_id'] = '';
					$result['client_secret'] = '';
					if(!empty($response) && isset($response->status) && $response->status == 1){
						if(isset($response->result->id) && !empty($response->result->id)){
							$result['payment_intent_id'] = $response->result->id;
						} 
						if(isset($response->result->client_secret) && !empty($response->result->client_secret)){
							$result['client_secret'] = $response->result->client_secret;
						}
						
						$result['res'] = 1;
					}
				}
		}
		
		echo  json_encode($result); die;
	}
	
	
}




/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */

