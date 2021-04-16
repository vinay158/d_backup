<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Multilocation extends CI_Controller {
	
	function __construct(){		
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
	}
	
	public function index()
	{
		$data = array();
		$data['title'] = "Multi-location";
		$data['multi_calendar'] = $this->db->query("SELECT * FROM tblconfigcalendar");
		$multi_data = $data['multi_calendar']->result();		
		
		foreach($multi_data as $m => $k){
			$data[$k->field_name] = $k->field_value;
		}
		
				
		$this->load->view('admin/multilocation_index',$data);
	}
	
	public function set_multicalendar(){
		
		$this->load->database();
		
		$multi_location = isset($_POST["multi_location"]) ? $_POST["multi_location"] : '0';
		
		
		$sql = "Update tblconfigcalendar Set field_value = ".$multi_location." Where field_name = 'multi_location'";
		$this->db->query($sql);				
		
		if($multi_location == 1){
			
			$multi_map = isset($_POST["multi_map"]) ? $_POST["multi_map"] : '0';
					
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_map." Where field_name = 'multi_map'";
			$this->db->query($sql);	
				
			if($multi_map == 1){	
				
				$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_calendar'";
				$this->db->query($sql);	
			}else{
			
				$multi_calendar = isset($_POST["multi_calendar"]) ? $_POST["multi_calendar"] : '0';
				
				$sql = "Update tblconfigcalendar Set field_value = ".$multi_calendar." Where field_name = 'multi_calendar'";
				$this->db->query($sql);	
				
			}
			
			
			$multi_staff = isset($_POST["multi_staff"]) ? $_POST["multi_staff"] : '0';
			
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_staff." Where field_name = 'multi_staff'";
			$this->db->query($sql);	
			
			$location_display = isset($_POST["location_display"]) ? $_POST["location_display"] : '0';
			
			$sql = "Update tblconfigcalendar Set field_value = ".$location_display." Where field_name = 'location_display'";
			$this->db->query($sql);
			
			
			
			$location_position = isset($_POST["location_position"]) ? $_POST["location_position"] : 'top';
			
			$sql = "Update tblconfigcalendar Set field_value = '".$location_position."' Where field_name = 'location_position'";
			$this->db->query($sql);	
			
			
			$multi_social_icon = isset($_POST["multi_social_icon"]) ? $_POST["multi_social_icon"] : '0';
			
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_social_icon." Where field_name = 'multi_social_icon'";
			$this->db->query($sql);
			
			$multi_social_feeds = isset($_POST["multi_social_feeds"]) ? $_POST["multi_social_feeds"] : '0';
			
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_social_feeds." Where field_name = 'multi_social_feeds'";
			$this->db->query($sql);
			
			$multi_trial_offers = isset($_POST["multi_trial_offers"]) ? $_POST["multi_trial_offers"] : '0';
			
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_trial_offers." Where field_name = 'multi_trial_offers'";
			$this->db->query($sql);
			
			$multi_unique_trial_offers = isset($_POST["multi_trial_offers"]) ? $_POST["multi_unique_trial_offers"] : '0';
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_unique_trial_offers." Where field_name = 'multi_unique_trial_offers'";
			$this->db->query($sql);
			
			$this->db->where("main_location", 0);
			$allContacts = $this->query_model->getbyTable("tblcontact");
			$multi_school_minimum_locations = $this->query_model->multi_school_minimum_locations();
			
			if(!empty($allContacts) && count($allContacts) >= $multi_school_minimum_locations){
				$multi_schools = isset($_POST["multi_schools"]) ? $_POST["multi_schools"] : '0';
			}else{
				$multi_schools = 0;
			}

			
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_schools." Where field_name = 'multi_schools'";
			$this->db->query($sql);
			
			if($multi_schools == 1){
				$multi_facility = 0;
			}else{
				$multi_facility = isset($_POST["multi_facility"]) ? $_POST["multi_facility"] : '0';
			}
			
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_facility." Where field_name = 'multi_facility'";
			$this->db->query($sql);	
			
			
			
			$multi_webhook = isset($_POST["multi_webhook"]) ? $_POST["multi_webhook"] : '0';
			
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_webhook." Where field_name = 'multi_webhook'";
			$this->db->query($sql);
			
			
			$multi_student_password = isset($_POST["multi_student_password"]) ? $_POST["multi_student_password"] : '0';
			
			$sql = "Update tblconfigcalendar Set field_value = ".$multi_student_password." Where field_name = 'multi_student_password'";
			$this->db->query($sql);
			
			
		}else{
			
			
			
			// if multi location off, all multi settings should be off
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_map'";
			$this->db->query($sql);				
			
			// if multi location off, all multi settings should be off
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_facility'";
			$this->db->query($sql);	
			
			// if multi location off, all multi settings should be off
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_staff'";
			$this->db->query($sql);	
			
			// if multi location off, all multi settings should be off
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'location_display'";
			$this->db->query($sql);	
			
			// if multi location off, all multi settings should be off
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_social_icon'";
			$this->db->query($sql);	
			
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_social_feeds'";
			$this->db->query($sql);
			
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_trial_offers'";
			$this->db->query($sql);	
			
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_unique_trial_offers'";
			$this->db->query($sql);	
			
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_schools'";
			$this->db->query($sql);	
			
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_webhook'";
			$this->db->query($sql);	
			
			
			$sql = "Update tblconfigcalendar Set field_value = 0 Where field_name = 'multi_student_password'";
			$this->db->query($sql);
			
			$sql = "Update tbl_payments Set multi_stripe_check = 0 Where id = 1";
			$this->db->query($sql);
			
		// new code for update site setting email in main location when we are turning off multi location	
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		$mainLocation = $this->query_model->getMainLocation("tblcontact");
		$site_setting =  $this->query_model->getbyTable("tblsite");
		
		//if($multiLocation[0]->field_value == 1){
			$email = $site_setting[0]->email;
			$location_id = $mainLocation[0]->id;
			//echo "UPDATE `tblcontact` SET `email` = '$email' WHERE `id` = $location_id"; die;
			$sql = "UPDATE `tblcontact` SET `email` = '$email' WHERE `id` = $location_id";
			$this->db->query($sql);	
		//} 
		
		
		//updated all multi location apis with multi_location 0 like rainmaker, kicksite etc etc
		
			//rainmaker api
			$sql = "Update tblrainmaker Set multi_rainmaker_check = 0 Where id = 1";
			$this->db->query($sql);
			
			//kicksite api
			$sql = "Update tbl_kicksite Set multi_kicksite_check = 0 Where id = 1";
			$this->db->query($sql);
				
			
			//perfectmind api
			$sql = "Update tbl_perfectmind_api Set multi_perfectmind_check = 0 Where id = 1";
			$this->db->query($sql);
		
			//mystudio api
			$sql = "Update tbl_mystudio Set multi_mystudio_check = 0 Where id = 1";
			$this->db->query($sql);
			
			//stripe payment api
			$sql = "Update tbl_payments Set multi_stripe_check = 0 Where id = 1";
			$this->db->query($sql);
		}
		
	}
	
	
	public function set_muti_student_section(){
			$student_section = $_POST['student_section_value'];
			$sql = "Update tblconfigcalendar Set field_value = ".$student_section." Where field_name = 'student_section'";
			$this->db->query($sql);	
			echo '1'; die;
	}
}
?>
