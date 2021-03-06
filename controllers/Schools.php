<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schools extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		
		
		$this->load->library('session');
		$this->load->helper('url');	
		$this->load->database();
		
	}
	
	function index($slug=''){
		
		if($this->query_model->checkMultiSchoolIsOn() == 0){
			redirect('/','location',301);
		}
		
		$folder_name = $_SERVER['CONTEXT_PREFIX'];
  		$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
   
	   $meta_slug = explode('/',$_SERVER['REQUEST_URI']);
	   //echo '<pre>'; print_r($meta_slug); die;
	   $meta_slug = $meta_slug[1];
		if(!empty($meta_slug)){
			$data['page_name'] = $this->query_model->getMetaPageName($meta_slug);
		}
		
		$my_location = $this->uri->segment(1);
		$tblmeta = $this->default_db->row('tblmeta',array('url'=>$my_location));
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		if($this->query_model->checkMultiSchoolIsOn() == 1){
			$this->db->where("turn_on_nested_location", 0);  //not nested child locations
		}
		$this->db->where("published", 1);
		$this->db->order_by("state","asc");
		$data['form_allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		$data['program_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 30);
		$data['program_slug'] = $data['program_slug'][0]->slug;
		
		$data['twilioApi'] = $this->query_model->getTwilioApiType();
		
		if($this->uri->segment(2) != ''){
				$location_slug = str_replace('%27',"'",$this->uri->segment(2));

				$this->db->where("slug", $location_slug);
				$data['locationDetail'] = $this->query_model->getbyTable("tblcontact");
				$data['originalLocation'] = $data['locationDetail'];
				$data['original_location_id'] = $data['originalLocation'][0]->id;
				
				$data['is_nested_main'] = 0;
				$data['is_child_location'] = 0;
				$data['nested_child_locations'] = array();
				if($data['locationDetail'][0]->school_location_type == "default" && $data['locationDetail'][0]->turn_on_nested_location == 1){
					$data['is_nested_main'] = 1;
					$this->db->where("parent_id", $data['locationDetail'][0]->id);
					$this->db->where("published", 1);
					$this->db->where("main_location", 0);
					$this->db->where("school_location_type", 'nested');
					$this->db->select(array('id','name','slug','city','state','zip'));
					
					$data['nested_child_locations'] = $this->query_model->getbyTable("tblcontact");
				}
				
				
				if ( isset($data['locationDetail']) && !empty($data['locationDetail']) ){
					
					if($data['locationDetail'][0]->school_location_type == "nested" && $data['locationDetail'][0]->parent_id != 0 ){
						$this->db->where("id", $data['locationDetail'][0]->parent_id);
						$this->db->where("school_location_type", 'default');
						$this->db->where("turn_on_nested_location", 1);
						$this->db->where("published", 1);
						$parentLocation = $this->query_model->getbyTable("tblcontact");
						if(!empty($parentLocation)){
							$data['locationDetail'] = $parentLocation;
							$data['is_child_location'] = 1;
						}
					}
					
					$location_id = $data['locationDetail'][0]->id;

					$data['location_id'] = $location_id;

					$data['selectedLocaiton'] = $location_id;
				
				// contact times
				$data['contactTime'] = $this->query_model->getbySpecific('tblcontact_time', 'location_id', $data['original_location_id']);
				$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 38);
				$data['contact_slug'] = $data['contact_slug'][0];
				
				
				$data['school_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 51);
				$data['school_slug'] = $data['school_slug'][0];
				
				// team members
				$this->db->order_by('pos asc, id desc');
				$this->db->where("published", 1);
				$this->db->where("location_id", $data['original_location_id']);
				$data['teamMembers'] = $this->query_model->getbyTable("tbl_team_members");
				
				// School Video Section
				$this->db->where("location_id", $location_id);
				$data['schoolHeader'] = $this->query_model->getbyTable("tblaboutschoolheader");
				
				// About Our School Content
				$this->db->where("location_id", $location_id);
				$data['aboutContent'] = $this->query_model->getbyTable("tblschool_about_school");
				
				// Instructor Our School Content
				$this->db->where("location_id", $data['original_location_id']);
				$this->db->where("published", 1);
				$this->db->order_by('pos asc, id desc');
				$data['ourStaffs'] = $this->query_model->getbyTable("tblschool_staff");
				
				// School Rows
				$this->db->where("location_id", $location_id);
				$this->db->where("published", 1);
				$this->db->order_by('pos asc, id desc');
				$data['schoolRows'] = $this->query_model->getbyTable("tbl_school_rows");
				
				// School Video Section
				$this->db->where("location_id", $location_id);
				$data['schoolVideoSection'] = $this->query_model->getbyTable("tbl_school_video_section");
				
				
				// School Text Section
				$this->db->where("location_id", $location_id);
				$data['schoolTextSection'] = $this->query_model->getbyTable("tbl_school_text_sections");
				
				
				
				$schoolPrograms = array();
				$schoolProgramsArr = array();
				$schoolTestimonials = array();
				$schoolOfferCategories = array();
				if(!empty($data['schoolTextSection'])){
					$programsLists = !empty($data['schoolTextSection'][0]->program_ids) ? unserialize($data['schoolTextSection'][0]->program_ids) : '';
					
					$unique_testimonial = !empty($data['schoolTextSection'][0]->unique_testimonial) ? $data['schoolTextSection'][0]->unique_testimonial : 0;
					$testimonialsLists = !empty($data['schoolTextSection'][0]->testimonial_ids) ? unserialize($data['schoolTextSection'][0]->testimonial_ids) : '';
					
					$unique_trial_offer = !empty($data['schoolTextSection'][0]->unique_trial_offer) ? $data['schoolTextSection'][0]->unique_trial_offer : 0;
					$trialOffersLists = !empty($data['schoolTextSection'][0]->trial_offer_ids) ? unserialize($data['schoolTextSection'][0]->trial_offer_ids) : '';
					
					if(!empty($programsLists)){
						$is_order_number = 0;
						//$this->db->where_in('id', $programsLists);
						//$this->db->order_by("pos","asc");
						foreach($programsLists as $programsList){
							if(isset($programsList['program_id']) && !empty($programsList['program_id'])){
								$is_order_number = 1;
								$this->db->select(array('id','featured_program_img','category','featured_program_img_alt_text','program','ages','program_slug','landing_program','landing_page_url','show_learn_more','landing_checkbox'));
								$this->db->where('published', 1);
								$this->db->where('id', $programsList['program_id']);
								$schoolProgramsArr[$programsList['order_number']][] = $this->query_model->getbyTable("tblprogram");
							}else{
								$this->db->select(array('id','featured_program_img','category','featured_program_img_alt_text','program','ages','program_slug','landing_checkbox','landing_program','landing_page_url','show_learn_more','landing_checkbox'));
								$this->db->where('published', 1);
								$this->db->where('id', $programsList);
								$schoolPrograms[] = $this->query_model->getbyTable("tblprogram");
							}
						}
						
						if($is_order_number == 1){
							ksort($schoolProgramsArr);
							$schoolPrograms = array();
							//$i = 0;
							foreach($schoolProgramsArr as $key => $schoolProgram){
								
								foreach($schoolProgram as $selected_program){
									$schoolPrograms[] = $selected_program;
								}
								
							//$i++;
							}
						}
						
					}
					//echo '<pre>programsLists'; print_r($programsLists); 
					//echo '<pre>schoolPrograms'; print_r($schoolPrograms); die;
					if($unique_testimonial != 1){
						if(!empty($testimonialsLists)){
							
							$this->db->where_in('id', $testimonialsLists);
							$this->db->where("published", 1);
							$this->db->order_by('pos asc, id desc');
							$schoolTestimonials = $this->query_model->getbyTable("tbltestimonials");
						}
					}else{
						$this->db->where("location_id", $location_id);
						$this->db->where("published", 1);
						$this->db->order_by('pos asc, id desc');
						$schoolTestimonials = $this->query_model->getbyTable("tbl_school_testimonials");
					}
					
					
					if($unique_trial_offer == 1){
						if(!empty($trialOffersLists)){
							$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
							$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
		
							$this->db->where_in('id', $trialOffersLists);
							$this->db->where("published", 1);
							$this->db->order_by("pos","asc");
							if($isUniqueSpecialOffer == 1){
								$this->db->where("type", "trial_offer");
							}
							$schoolOfferCategories = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
						}
					}else{
						$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
						$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
						
						$this->db->where("hide_from_trial_page", 0);
						$this->db->where("published", 1);
						$this->db->order_by("pos","asc");
						if($isUniqueSpecialOffer == 1){
								$this->db->where("type", "trial_offer");
							}
						$schoolOfferCategories = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
					}
					
					
				}
				
				$data['schoolPrograms'] = $schoolPrograms;
				$data['schoolTestimonials'] = $schoolTestimonials;
				$data['schoolOfferCategories'] = $schoolOfferCategories;
				
				$data['apiKeys'] = $this->query_model->getbySpecific('tblschool_apikey','location_id', $location_id);
				$data['apiKeys'] = !empty($data['apiKeys']) ? $data['apiKeys'] : '';
				
				$this->db->where("id",  $data['original_location_id']);
				$data['contactDetail'] = $this->query_model->getbyTable("tblcontact");
				$data['contactDetail'] = $data['contactDetail'][0];
				
				$this->db->select(array('id','name','slug','school_location_type','turn_on_nested_location','parent_id','main_location'));
				$this->db->order_by('pos asc, id desc');
				$this->db->where("school_location_type", 'nested');
				$data['child_locations'] = $this->query_model->getBySpecific('tblcontact','parent_id',$location_id);
		
				
				
				$this->load->view('schools', $data);
				
				
				}else{
					redirect('/','location',301);
				}
			
		}
		
		
	}
	


	
	
	public function get_school_social_news_data(){
		$data = array();
		$data['location_id'] = $this->uri->segment(3);
		//echo $data['location_id']; die;
		$this->load->view('get_school_social_news_data', $data);
	}



		public function getCityData(){
		$data['stateName'] = $this->input->post('stateName');
		$data['cityName'] = $this->input->post('cityName');
		
		$this->db->where("state", $this->input->post('stateName'));
		//$this->db->group_by('city');
		$this->db->where("published", 1);
		$this->db->where("location_type !=", 'coming_soon_location');
		$data['city_lists'] = $this->query_model->getbyTable("tblcontact");

		//$this->getLocationAccordingState($this->input->post('stateName'), 'state');

/*		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		$this->db->where("state", $this->input->post('stateName'));
		$this->db->order_by("pos","asc");
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");*/

		$this->load->view('get_city_data', $data);



		//echo '<pre>'; print_r($data['city_lists']);die;
		
	}
	
	
	
	public function get_school_location_detail(){
		if(isset($_POST['location']) && !empty($_POST['location'])){
			$location_id = $_POST['location'];
			$this->db->where("id",  $location_id);
			$data['contactDetail'] = $this->query_model->getbyTable("tblcontact");
			$data['contactDetail'] = $data['contactDetail'][0];
			
			// team members
			$this->db->order_by("pos","asc");
			$this->db->where("published", 1);
			$this->db->where("location_id", $location_id);
			$data['teamMembers'] = $this->query_model->getbyTable("tbl_team_members");
			
			$data['contactTime'] = $this->query_model->getbySpecific('tblcontact_time', 'location_id', $location_id);
			
			$this->load->view('get_school_location_detail', $data);
			
		} 
	}

	
	public function get_instructors_list(){
		
		if(isset($_POST['location']) && !empty($_POST['location'])){
			
			$location_id = $_POST['location'];
			// Instructor Our School Content
			$this->db->where("location_id", $location_id);
			$this->db->where("published", 1);
			$this->db->order_by("pos","asc");
			$data['ourStaffs'] = $this->query_model->getbyTable("tblschool_staff");
			
			$this->load->view('get_instructors_list', $data);
		}
	}
	
}
