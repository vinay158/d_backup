<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		
		
		$this->load->library('session');
		$this->load->helper('url');	
		$this->load->database();
		
	}
	
	function index($slug=''){
		//echo '<pre>SERVER'; print_r($_SERVER); die;
		$folder_name = $_SERVER['CONTEXT_PREFIX'];
  		$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
   //echo $_SERVER['REQUEST_URI']; die;
	   $meta_slug = explode('/',$_SERVER['REQUEST_URI']);
	   
	   
		/** 13 jan 2017 **/
	    $checkLocationUrl = $this->query_model->checkLocationUrl($meta_slug[2]);
		
		/*if($checkLocationUrl == 0){
			redirect('/','location',301);
		} */
	   /** end code **/
	   
	   $meta_slug = $meta_slug[1];
	   
		if(!empty($meta_slug)){
			$data['page_name'] = $this->query_model->getMetaPageName($meta_slug);
		}
		
		
		$my_location = $this->uri->segment(1);
		
		$tblmeta = $this->default_db->row('tblmeta',array('url'=>$my_location));
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		
		$data['featured'] = $this->query_model->getbySpecific("tblprogram", "featured", 1);
		$this->db->where("published", 1);
		$this->db->order_by('pos asc, id desc');
		$data['myTestimonials'] = $this->query_model->getbyTable("tbltestimonials");
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		$multi_about_us = $this->query_model->multi_about_us();
				
		
		
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		if($data['multiSchool'] == 1){
			$this->db->where("main_location", 0);
		}
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$data['form_allLocations'] = $this->query_model->getFormAllLocations();
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
	   
		
		$this->db->where("id", 3);
		$data['multiStaff'] = $this->query_model->getbyTable("tblconfigcalendar");
		//$data['multiLocation'] = $data['multiStaff'][0]->field_value;
		
		$this->db->where("published", 1);
		$this->db->order_by('pos asc, id desc');
		$data['myTestimonials'] = $this->query_model->getbyTable("tbltestimonials");
		
		$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
		
		
		
		$this->db->select('f.*, p.program, c.cat_name');
		$this->db->from('tblfeaturedprogram f');
		$this->db->join('tblprogram p', 'p.id = f.program_id', 'left');
		$this->db->join('tblcategory c', 'c.cat_id = p.category', 'left');
		$this->db->order_by("f.pos", "ASC");		
		$this->db->where('f.published', 1);
		$query = $this->db->get();
		$data['featuredprograms'] = $query->result();
		
		$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
		$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
		$this->db->order_by('pos', 'asc');
		if($isUniqueSpecialOffer == 1){
			$this->db->where("type", "trial_offer");
		}
		$this->db->where("published", 1);
		$this->db->where("hide_from_trial_page", 0);
		$data['trial_categories'] = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
		
		
		$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
		
		$my_mainLocation = $this->query_model->getMainLocation();
		$my_mainLocation = $my_mainLocation[0]->id;
		
		$multiSchool = isset($data['multiLocation'][11]) ? $data['multiLocation'][11]->field_value : 0;
		$data['twilioApi'] = $this->query_model->getTwilioApiType();
		
			
			//echo $data['multiLocation'][0]->field_value.'==>'.$multiSchool; die;
		//$data['multiLocation'][0]->field_value == 0 || $multiSchool == 1
		
		// if no any location slug or cityname in url then it would be redirect
		$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
		$data['aboutus_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
		$data['aboutus_slug'] = $data['aboutus_slug'][0];
		if($this->uri->segment(2) == ""){
			if($data['multiLocation'][0]->field_value == 0 || $data['multiLocation'][1]->field_value == 0 || $data['multiLocation'][7]->field_value == 1){
				$location_url = strtolower(str_replace(' ','-',$data['mainLocation'][0]->city));
				
			}else{
				$location_url = $data['mainLocation'][0]->slug;
				
			}
			redirect('/'.$data['aboutus_slug']->slug.'/'.$location_url);
		}
		
		if($multi_about_us == 0){
			/** About **/
			
			
			
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			//echo '<pre>'; print_r($data['mainLocation']); die;
			$location_id = $my_mainLocation;
			
			$data['selectedLocaiton'] = $location_id;
			
			$social_feed_location_id = $location_id;
			//echo '<pre>v'; print_r($location_id); die;
			$this->db->where("location_id", $my_mainLocation);
			$data['aboutHeader'] = $this->query_model->getbyTable("tblaboutheader");
			
			
			$this->db->where("location_id", $location_id);
			$data['aboutUs'] = $this->query_model->getbyTable("tbl_about_us");
			
			
			$this->db->where("location_id", $location_id);
			$data['aboutEmailOption'] = $this->query_model->getbyTable("tbl_about_email_options");
			
			$this->db->order_by('pos asc, id desc');
			$this->db->where("location_id", $location_id);
			$this->db->where("published", 1);
			$data['aboutusRows'] = $this->query_model->getbyTable("tbl_aboutus_rows");
			
			/*$this->db->where("published", 1);
			$this->db->where("location_id", $my_mainLocation);
			$data['aboutVideo'] = $this->query_model->getbyTable("tblvideo");
			$data['aboutVideo'] = $data['aboutVideo'][0];*/
			//echo '<pre>'; print_r($data['aboutVideo']); die;
			
			$this->db->where("location_id", $my_mainLocation);
			$data['aboutContent'] = $this->query_model->getbyTable("tblaboutourschool");
			
			$this->db->where("location_id", $my_mainLocation);
			$this->db->where("published", 1);
			$this->db->order_by('pos asc, id desc');
			$data['ourStaffs'] = $this->query_model->getbyTable("tblstaff");
			
			$this->db->where("location_id", $my_mainLocation);
			$data['seoContent'] = $this->db->get("tblseo")->row_array();
			
			$data['about_ContactDetail'] = $this->query_model->getMainLocation("tblcontact");
			
			$this->db->where("location_id", $my_mainLocation);
			$data['aboutTheAta'] = $this->query_model->getbyTable("tbl_about_the_ata");
		
		} else {
			if($this->uri->segment(2) != ''){
				
				
			
				$location_slug = str_replace('%27',"'",$this->uri->segment(2));
				$this->db->where("slug", $location_slug);
				$this->db->where('published', 1);
				$data['locationDetail'] = $this->query_model->getbyTable("tblcontact");
				
				if(empty($data['locationDetail'])){
					redirect(base_url(),'location',301);
				}
				
				$location_id = $data['locationDetail'][0]->id;
				$data['selectedLocaiton'] = $location_id;
				
				
				$social_feed_data = $this->query_model->getbyTable("tblconfigcalendar");
				$social_feed_data = $social_feed_data[9]->field_value;
				if($social_feed_data == 0){
					$social_feed_location_id = $this->query_model->getMainLocation("tblcontact");
					$social_feed_location_id = $social_feed_location_id[0]->id;
				}else{
					$social_feed_location_id = $location_id;
				}
				//echo '<pre>'; print_r($social_feed_location_id); die;
			}else {
				$location_id = $my_mainLocation;
				$social_feed_location_id = $my_mainLocation;
			}
			$this->db->where("id", $location_id);
			$data['mainLocation'] = $this->query_model->getbyTable("tblcontact");
			
			
			$this->db->where("location_id", $location_id);
			$data['aboutHeader'] = $this->query_model->getbyTable("tblaboutheader");
			
			$this->db->where("location_id", $location_id);
			$data['aboutTheAta'] = $this->query_model->getbyTable("tbl_about_the_ata");
			
			$this->db->where("location_id", $location_id);
			$data['aboutUs'] = $this->query_model->getbyTable("tbl_about_us");
			
			$this->db->where("location_id", $location_id);
			$data['aboutEmailOption'] = $this->query_model->getbyTable("tbl_about_email_options");
			
			$this->db->order_by('pos asc, id desc');
			$this->db->where("location_id", $location_id);
			$this->db->where("published", 1);
			$data['aboutusRows'] = $this->query_model->getbyTable("tbl_aboutus_rows");
			
			if($data['multiStaff'][0]->field_value == 0){
				$this->db->where("location_id", $my_mainLocation);
			} else {
				$this->db->where("location_id", $location_id);
			}
			
			$this->db->where("published", 1);
			$this->db->order_by('pos asc, id desc');
			$data['ourStaffs'] = $this->query_model->getbyTable("tblstaff");
			
			$this->db->where("location_id", $location_id);
			$data['aboutContent'] = $this->query_model->getbyTable("tblaboutourschool");
			$this->db->where("location_id", $location_id);
			$data['seoContent'] = $this->db->get("tblseo")->row_array();
			
			$data['about_ContactDetail'] = $this->db->query('select * from `tblcontact`  where  id= "'.$location_id.'"') or die(mysqli_error($this->db->conn_id));
			$data['about_ContactDetail']=$data['about_ContactDetail']->result();
			//echo '<pre>'; print_r($data['about_ContactDetail']); die;
			
			/*$this->db->where("published", 1);
			$this->db->where("location_id", $location_id);
			$data['aboutVideo'] = $this->query_model->getbyTable("tblvideo");
			if(!empty($data['aboutVideo'])){
				$data['aboutVideo'] = $data['aboutVideo'][0];
			}*/
			
			
			
		}
		
		$contact_slug = str_replace('%27',"'",$this->uri->segment(2));
		//echo $contact_slug; die;
		if($data['multiLocation'][0]->field_value == 1 && $multiSchool == 0){
			$data['contactDetail'] = $this->query_model->getbyTable("tblcontact");
			$data['contactDetail'] = $data['contactDetail'][0];
		} else{
			$data['contactDetail'] = $this->query_model->getMainLocation();
			$data['contactDetail'] = $data['contactDetail'][0];
		}
		
		
		
		//echo '<pre>'; print_r($location_id); die;
		$data['location_id'] = $social_feed_location_id;
		$data['page_location_id'] = $location_id;
		//echo 'final location:===>'.$data['location_id']; die;
		$data['apiKeys'] = $this->query_model->getbySpecific('tblapikey','location_id', $location_id);
		//$data['apiKeys'] = $data['apiKeys'][0];
		if(!empty($data['apiKeys'])){
			$data['apiKeys'] = $data['apiKeys'][0];
		}else{
			$data['apiKeys'] = array();
		}
		
		$data['uniqueStatesList'] = $this->query_model->getUniqueStatesList();
		
		
		//echo '<pre>'; print_r($data['about_ContactDetail']); die;
		//echo '<pre>'; print_r($data['apiKeys']); die;
		//$limit = 200;
		// instragram images //1257058025.1677ed0.afcac0f6cfcf4b21a82761d2e37c7464
		//$data['instragram_images'] = $this->query_model->userMedia('1257058025', '1257058025.1677ed0.afcac0f6cfcf4b21a82761d2e37c7464');
		
		/*if($data['apiKeys']->facebook_user_id != '' &&  $data['apiKeys']->facebook_access_token != ''){
			$data['facebook'] = $this->facebookUserMedia($data['apiKeys']->facebook_user_id,  $data['apiKeys']->facebook_access_token, $limit);
		} else {
			$data['facebook'] = array();
		}*/	//CAAXexH8mM8IBANKpJvZBccdItfycOPeewK97gnPTnMlyQaCrQGOhvrtPOX9kuZALSlvkTSh3uT7vVPXIfmpQ6G0T5SjHar3V4hnpsMabmLLFtEaHMV060dBWoCYZBS3oAb6cJgmgmwiP9rdZCjyH9SAV2LdggalZB8pgHU4ZCeIvPCEePcZBqL8mUPVsrHGXwNRhAgS0G5W1AZDZD
		
		
		/*if($data['apiKeys']->google_plus_id != '' && $data['apiKeys']->google_plus_api_key != ''){
	   		$data['googlePlus'] = $this->googlePlusUserMedia( $data['apiKeys']->google_plus_id , $data['apiKeys']->google_plus_api_key);
		}else {
			$data['googlePlus'] = array();
		}*/
		
		
	/*	 $filePath = base_url().'twitter/index.php';
		 $twitter_posts = file_get_contents($filePath);
		$data['twitterss'] = json_decode($twitter_posts);
		if($data['apiKeys']->youtube_channel_id != '' && $data['apiKeys']->youtube_api_key != ''){
			$data['youtube'] = $this->youtubeUserMedia( $data['apiKeys']->youtube_channel_id , $data['apiKeys']->youtube_api_key);
			$youtubeDetails = array(); 
			if(!empty($data['youtube']['items'])){
					foreach($data['youtube']['items'] as $youtube_video){	
						if(isset($youtube_video['id']['videoId'])){
							$url = 'http://www.youtube.com/watch?v='.$youtube_video['id']['videoId'];
							$detail = $this->get_youtube($url);
							$detail['video_id'] = $youtube_video['id']['videoId'];
							$youtubeDetails[] = $detail;
						}
					}
				}
			$data['youtubeDetails'] = $youtubeDetails;
		} else {
			$data['youtubeDetails'] = array();
		}*/
		
		//echo '<pre>data'; print_r($data); die;
		$this->load->view('about', $data);
	}
	

	public function get_staff_detail(){
		$staff_id = $_POST['staff_id'];
		
		$data['staffDetail'] = $this->query_model->getbyId('tblstaff',$staff_id);
		
		$this->load->view('get_staff_detail', $data);
	}
	
	
	public function get_social_news_data(){
		$data = array();
		$data['location_id'] = $this->uri->segment(3);
		$this->load->view('get_social_news_data', $data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */