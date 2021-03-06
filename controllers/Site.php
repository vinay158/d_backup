<?php 
require 'vendor/autoload.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

	public function index()
	{
	
		
		$index_path = explode('/',$_SERVER['REQUEST_URI']);
		if(isset($index_path[1]) && $index_path[1] == 'index.php'){
			redirect('/','location',301);
		}
		
		if(isset($index_path[2]) && $index_path[2] == 'index.php'){
			redirect('/','location',301);
		}
		$my_location = $this->uri->segment(1);
		$tblmeta = $this->default_db->row('tblmeta',array('url'=>$my_location));
		//$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		/*if($tblmeta['display_status'] == "H"){
			//redirect(base_url());
		};*/
		
		$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
		$data['contact_slug'] = $data['contact_slug'][0];
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		
		
		$this->load->helper(array('url'));
		
		$this->db->limit(5);
		$this->db->order_by('pos asc, id desc');	
			
		$data['featured'] = $this->query_model->getbySpecific("tblprogram", "featured", 1);
		//echo '<pre>'; print_r($data['featured']); die;
		$data['tabs'] = $this->query_model->getbyTable("tbltab");		
		$this->db->order_by("timestamp", "DESC");
		$this->db->limit(6);
		$data['news_data'] = $this->query_model->getbySpecific("tblnews", "published", 1);
		$data['social'] = $this->query_model->getbyTable("tblcode");
		//$this->db->order_by("pos", "ASC");
		$this->db->order_by('pos asc, id desc');
		$data['slides'] = $this->query_model->getbySpecific("tblslider", "published", 1);
		
		$this->db->select('f.*, p.program, c.cat_name');
		$this->db->from('tblfeaturedprogram f');
		$this->db->join('tblprogram p', 'p.id = f.program_id', 'left');
		$this->db->join('tblcategory c', 'c.cat_id = p.category', 'left');
		$this->db->order_by("f.pos", "ASC");		
		$this->db->where('f.published', 1);
		$query = $this->db->get();
		$data['featuredprograms'] = $query->result();	
		//echo '<pre>'; print_r($data['featuredprograms']); die;
		$this->db->order_by('pos asc, id desc');
		$data['adverts'] = $this->query_model->getbyTable("tbladvert");	
		
		$this->db->where("id", 1);
		$data['about_us'] = $this->db->get("tbltab")->row_array();
		
		
		$this->db->where("id", 1);
		$data['gettips'] = $this->db->get("tblgettips")->row_array();

		$this->db->where("id", 1);
		$data['large_video'] = $this->query_model->getbyTable("tbl_large_video");
		
		$data['homePageEmailOption'] = $this->query_model->getbyTable("tbl_homepage_email_options");
		$data['homePageGettingStarted'] = $this->query_model->getbyTable("tbl_homepage_getting_started");
		$data['homePageGettingStarted'] = !empty($data['homePageGettingStarted']) ? $data['homePageGettingStarted'][0] : '';
		
		
		// vinay 19/11
		$this->db->where("published", 1);
		$this->db->order_by('pos asc, id desc');
		$data['myTestimonials'] = $this->query_model->getbyTable("tbltestimonials");
		
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		if($data['multiSchool'] == 1){
			$this->db->where("main_location", 0);
		}
		$this->db->order_by('pos', 'asc');
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		
		
		$data['form_allLocations'] = $this->query_model->getFormAllLocations();
		
		$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		$data['about_page_url'] = $this->query_model->getbySpecific("tblmeta", "id", 21);
		//$data['addCode'] = $this->default_db->row('tbladdcode',array('id'=>1));
		$this->db->order_by('pos asc, id desc');
		$this->db->where("published", 1);
		$data['feature_box'] = $this->query_model->getbyTable("tblads");
		
		$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
		$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
		$this->db->order_by('pos', 'asc');
		$this->db->where("status", 1);
		if($isUniqueSpecialOffer == 1){
			$this->db->where("type", "trial_offer");
		}
		$data['trial_categories'] = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
		
		
		$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
		
		$this->db->order_by('pos asc, id desc');
		$this->db->where("published", 1);
		$data['sliders'] = $this->query_model->getbyTable("tblslider");
		
		$this->db->where("page_id", 1);
		$this->db->order_by("pos","asc");
		$data['allHomepageSections'] = $this->query_model->getbyTable("tbl_homepage_sections");
		
		$data['uniqueStatesList'] = $this->query_model->getUniqueStatesList();
		//echo '<pre>'; print_r($data['uniqueStatesList']); die;
		$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
		
		$schoolMenu = $this->query_model->getSchoolMenu();
		
		$data['twilioApi'] = $this->query_model->getTwilioApiType();
		
		// code for get all list of location array
		/*
		$locationArr = array();
		if(!empty($data['uniqueStatesList'])){
			$i = 0;
			foreach($data['uniqueStatesList'] as $state){
				$locationArr[$i]['state'] = $state;
				
				$uniqueCitiesList = $this->query_model->getUniqueCitiesListByState($state->state);
				if(!empty($uniqueCitiesList)){
					$n = 0;
					foreach($uniqueCitiesList as $city){
						
						$locationArr[$i]['cities'][$n]['city'] = $city;
					
						$city_locations = $this->query_model->getLocationsListByCity($city->city);
						
						if(!empty($city_locations)){
							$locationArr[$i]['cities'][$n]['locations'] = $city_locations;
						
						}
					$n++;
					}
					
				}
				
			$i++;
			}
		}*/
		//echo '<pre>'; print_r($locationArr); die;
		$this->load->view('home', $data);
	}
	
	
	public function getSettingData(){
			$settingData = $this->query_model->getbyTable("tblsite");
			
			print_r(json_encode($settingData));
}

public function missing_page_redirection(){
	redirect('/','location',301);
}

public function error_page(){
		$data['title'] = 'Error';
		$this->load->view('error_page', $data);
}


	
	
public function ajaxApplyCoupon(){
	
	$result = array('status' => 0, 'discount' => '','coupon_id' =>'');
	$is_updated_cart = (isset($_POST['is_updated_cart']) && !empty($_POST['is_updated_cart'])) ? $_POST['is_updated_cart'] : 0;
	if(isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])){
		
		$total_amount = (isset($_POST['total_amount']) && !empty($_POST['total_amount'])) ? $_POST['total_amount'] : 0;
		
			$this->db->where('coupon_code_name', $_POST['coupon_code']);
			$coupon = $this->query_model->getbySpecific("tbl_dojocart_coupons",'dojocart_id',$_POST['dojocart_id']);
			
			$currentDate = date('Y-m-d'); 
					
			if(!empty($coupon)){
				
				if(!empty($coupon[0]->expiry_date) && $coupon[0]->expiry_date >= $currentDate){
					$discountAmount = $coupon[0]->coupon_discount_amount;
					if($coupon[0]->coupon_discount_type == "percent"){
						$discountAmount = $coupon[0]->coupon_discount_percent * $total_amount;
						$discountAmount = number_format($discountAmount,2);
					}
					
					if($discountAmount <= $total_amount){
						$result = array('status' => 1,'discount_type'=> $coupon[0]->coupon_discount_type,'discount_percent'=> $coupon[0]->coupon_discount_percent,  'discount' => $coupon[0]->coupon_discount_amount,'coupon_id' =>$coupon[0]->id);
					}else{
						$result = array('status' => 4, 'discount' => '','coupon_id' =>'');
					}
					
				}else{
					$result = array('status' => 2, 'discount' => '','coupon_id' =>'');
				}
			}
		
	}else{
		
		if($is_updated_cart == 1){
			$result = array('status' => 3, 'discount' => '','coupon_id' =>'');
		}
	}
	
	echo json_encode($result); exit();
}



		
public function ajaxApplyCouponTrialOffers(){
	
	$result = array('status' => 0, 'discount' => '','coupon_id' =>'');
	if(isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])){
		$this->db->where('published', 1);
		$coupon = $this->query_model->getbySpecific("tbl_onlinespecial_promo_codes",'title',$_POST['coupon_code']);
		
		$currentDate = date('Y-m-d'); 
		
		if(!empty($coupon)){
		  if(!empty($coupon[0]->expiry_date) && $coupon[0]->expiry_date >= $currentDate){
			 
			if($coupon[0]->connect_to_trials == "all_trials"){
				$result = array('status' => 1,'discount_type'=> $coupon[0]->discount_type,'discount_percent'=> $coupon[0]->discount_percent, 'discount' => $coupon[0]->discount_amount,'coupon_id' =>$coupon[0]->id);
			}else{
				$trialOffers = !empty($coupon[0]->trial_offers) ? unserialize($coupon[0]->trial_offers) : '';
				//echo '<pre>trialOffers'; print_r($trialOffers); die;
				if(!empty($trialOffers)){
					if(in_array($_POST['trial_id'], $trialOffers)){
						$result = array('status' => 1,'discount_type'=> $coupon[0]->discount_type,'discount_percent'=> $coupon[0]->discount_percent, 'discount' => $coupon[0]->discount_amount,'coupon_id' =>$coupon[0]->id);
					}
				}
			}
		  }else{
			  $result = array('status' => 2, 'discount' => '','coupon_id' =>'');
	
		  }

		}

	}
	echo json_encode($result); exit();
}

public function thankyou(){
		$thankyouMessage = $this->session->userdata('thankyouMessage');
		$this->query_model->saveFormDataOnMATApi($thankyouMessage);
		//echo '<pre>thankyouMessage=>'; print_r($thankyouMessage); die;
		if(!empty($thankyouMessage)){
			
			$data['thankyou_message'] = '';
			if(isset($thankyouMessage['thankyou_page_id'])){
				$this->db->where('status',1);
				$thankyouPageDetail = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', $thankyouMessage['thankyou_page_id']);
				
				if(!empty($thankyouPageDetail)){
					
					$data['thankyou_message'] = $thankyouPageDetail[0]->description;
					
					
				}
			}
			
			
			$data['postData'] = $thankyouMessage['postData'];
			$data['twilioApi'] = $this->query_model->getTwilioApiType();
			
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
			
			
			
			$this->load->view('thankyou-page-message', $data);
		}else{
			redirect(base_url());
		}
	}


	
	public function get_school_staff_detail(){
		$staff_id = $_POST['staff_id'];
		
		$data['staffDetail'] = $this->query_model->getbyId('tblschool_staff',$staff_id);
		
		$this->load->view('get_school_staff_detail', $data);
	}
	
	
	public function getCityData(){
		$data = array();
		$state_name = (isset($_POST['stateName']) && !empty($_POST['stateName'])) ?  $_POST['stateName'] : '';
		$data['cityName'] = isset($_POST['cityName']) ? $_POST['cityName'] : '';
		if(!empty($state_name)){
			$data['city_lists'] = $this->query_model->getUniqueCitiesListByState($state_name);
		}
		
		$this->load->view('get_city_data', $data);
	}
	
	public function testTwilioMsg(){
		/*require_once './vendor/Twilio/autoload.php';
		include("./vendor/Twilio/Rest/Client.php");
		
		// Your Account Sid and Auth Token from twilio.com/console
		$sid    = "AC29d85172e097290ad0fa0fa0f04722f0"; # test sid
		$token  = "1a3110ede3e6d6d450bfe964eee2da8b";# test token
		$twilio = new Twilio\Rest\Client($sid, $token);
		$message = $twilio->messages
						  ->create("+918561860309",
								   array(
									   "body" => "Let's grab lunch at Milliways tomorrow!",
									   "from" => "+15005550006",
									   "mediaUrl" => "http://www.example.com/cheeseburger.png"
								   )
						  );

		print($message->sid); die; */
	}
	
	
	public function checkExpiredTrialOfferCoupons(){
		
			if(isset($_POST['type']) && $_POST['type'] == "checkExpiredTrialOffer"){
				$currentDate = date('Y-m-d'); 
				$this->db->where('published', 1);
				$coupons = $this->query_model->getbySpecific("tbl_onlinespecial_promo_codes",'expiry_date <',$currentDate);
				
				if(!empty($coupons)){
					foreach($coupons as $coupon){
						$updateData['published'] = 0;
						$this->query_model->updateData('tbl_onlinespecial_promo_codes','id',$coupon->id, $updateData);
					}
				}
				
				$cron_data = array('execute_date' => $currentDate);
				$this->query_model->updateData('tbl_coupons_cronjobs','type','trial_offer', $cron_data);
		
			}
		
	}
	
	
	
	public function checkExpiredDojocartCoupons(){
		
			if(isset($_POST['type']) && $_POST['type'] == "checkExpiredDojocart"){
				$currentDate = date('Y-m-d'); 
				$coupons = $this->query_model->getbySpecific("tbl_dojocart_coupons",'expiry_date <',$currentDate);
				
				if(!empty($coupons)){
					foreach($coupons as $coupon){
						$this->db->where("id", $coupon->id);
						$this->db->delete("tbl_dojocart_coupons");
					}
				}
				
			$cron_data = array('execute_date' => $currentDate);
			$this->query_model->updateData('tbl_coupons_cronjobs','type','dojocart', $cron_data);
			}
		
	}
	
	public function page_not_found(){
		$data = array();
		
		$this->load->view('page_not_found', $data);
	}
	
	
	public function get_location_ids_by_program_id(){
		$form_allLocations = '';
		if(isset($_POST['program_id']) && !empty($_POST['program_id'])){
			$form_allLocations = $this->query_model->getLocationIdsByProgramId($_POST['program_id']);
		
		}
		
		$form_allLocations = !empty($form_allLocations) ? json_encode($form_allLocations) : '';
		
		echo $form_allLocations; exit();
	}
	
	
	public function get_program_ids_by_location_id(){
		$form_programs = '';
		if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
			$form_programs = $this->query_model->getProgramIdsByLocationId($_POST['location_id']);
		
		}
		
		$form_programs = !empty($form_programs) ? json_encode($form_programs) : '';
		
		echo $form_programs; exit();
	}
	
	
	public function get_program_ids_by_location_id_for_trialoffer(){
		$all_programs = array();
		if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
				
				if(isset($_POST['trial_cat_id']) && !empty($_POST['trial_cat_id'])){
					$allProgramsArr = array();
						$this->db->select("cat_id");
						$this->db->where('redirection_type',"trial_offer");
						$programCats = $this->query_model->getbySpecific('tblcategory', 'trial_offer_id', $_POST['trial_cat_id']);
						
						if(!empty($programCats)){
							foreach($programCats as $program_cat){
								
								$this->db->select(array("id",'buttonName','category','program','program_slug','redirection_type','trial_offer_id','connect_trial_offer_id','show_location_type','locations'));
								$this->db->where('published',1);
								$programs = $this->query_model->getbySpecific('tblprogram', 'category', $program_cat->cat_id);
								
								if(!empty($programs)){
									foreach($programs as $program){
										$show_program = 0;
										
										if($program->connect_trial_offer_id == $_POST['trial_cat_id']){
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
						$other_programs = $this->query_model->getbySpecific('tblprogram', 'connect_trial_offer_id', $_POST['trial_cat_id']);
						if(!empty($other_programs)){
							foreach($other_programs as $program){
								$allProgramsArr[$program->id] = $program;
							}
						}
						
					//echo '<pre>allProgramsArr'; print_r($allProgramsArr); die;	
					if(!empty($allProgramsArr)){
						foreach($allProgramsArr as $program){
							
							if($program->show_location_type == "show_all"){
								$all_programs[$program->id]['id'] = $program->id;
								$all_programs[$program->id]['program'] = $program->program;
							}elseif($program->show_location_type == "select_location"){
								
								$selectedLocationsArr = !empty($program->locations) ? unserialize($program->locations) : array();
								
								if(!empty($selectedLocationsArr)){
									if(in_array($_POST['location_id'],$selectedLocationsArr)){
										$all_programs[$program->id]['id'] = $program->id;
										$all_programs[$program->id]['program'] = $program->program;
										
									}
								}
								
							}
						}
					}
				}
		}
		
		$all_programs = !empty($all_programs) ? json_encode($all_programs) : '';
		
		echo $all_programs; exit();
	}

	
	public function set_location_id_form(){
		
		if(isset($_POST['school_interest']) && !empty($_POST['school_interest'])){
			
			$sessionLeadsData = array('sessionLeadsData' => $_POST);
			$this->session->set_userdata($sessionLeadsData);
			
			if(isset($_POST['redirect_url']) && !empty($_POST['redirect_url'])){
				redirect($_POST['redirect_url']);
			}
		}
		
			$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
			$start_trial_slug = $start_trial_slug[0];
			$redirect_url = $start_trial_slug->slug;
			
			$redirect_url = base_url().$redirect_url;
				
			redirect($redirect_url);
		
	}
	
	
	
public function save_mat_api_lead_data(){
	
	
	$mat_result = $this->query_model->getbyTable("tbl_mat_api");
	
	if(!empty($mat_result)){
		$data['mat_api'] = $mat_result[0];
		$data['mat_category_id'] = (isset($_GET['mat_category_id']) && !empty($_GET['mat_category_id'])) ? $_GET['mat_category_id'] : 0;
		$data['club_id'] = (isset($_GET['club_id']) && !empty($_GET['club_id'])) ? $_GET['club_id'] : 0;
		
		
		if($mat_result[0]->type == 1){
			$this->load->view('save_mat_api_lead_data', $data);
		}
		
	}
}


public function ajaxPopupForNestedSchool(){
	//$_POST['location_id'] = 55;
	if(isset($_POST['location_id']) && !empty($_POST['location_id'])){
		$data = array();
		
		$this->db->select(array('override_logo','override_nav_bar_logo','sitelogo','logo_alt'));
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		
		$data['school_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 51);
		$data['school_slug'] = $data['school_slug'][0];
				
				
		$data['is_nested_main'] = 0;
		
		$this->db->where('id',$_POST['location_id']);
		$this->db->select(array('id','school_location_type','turn_on_nested_location'));
		$data['locationDetail'] = $this->query_model->getbyTable("tblcontact");
		
		if($data['locationDetail'][0]->school_location_type == "default" && $data['locationDetail'][0]->turn_on_nested_location == 1){
			$data['is_nested_main'] = 1;
			$this->db->where("parent_id", $data['locationDetail'][0]->id);
			$this->db->where("published", 1);
			$this->db->where("main_location", 0);
			$this->db->where("school_location_type", 'nested');
			$this->db->select(array('id','name','slug','city','state','zip'));
			
			$data['nested_child_locations'] = $this->query_model->getbyTable("tblcontact");
		}
		
		$this->load->view('get_popup_nested_school', $data);
	}
	
}

public function thank_you(){
	
	if($this->session->userdata('hunneypot_error_msg')){
		
		
		$data['hunneypot_error_msg'] = $this->session->userdata('hunneypot_error_msg');
		$data['twilioApi'] = $this->query_model->getTwilioApiType();
		
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
		
		
		
		$this->load->view('hunneypot_thankyou', $data);
		
	}else{
		redirect(base_url());
	}
}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
