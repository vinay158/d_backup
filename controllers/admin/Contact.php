<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
        $this->load->model('contact_model');
	}
	
	public function index()
	{
		redirect('admin/contact/view');
	}
	public function view(){
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "Contact Us";
			$data['multi_calendar'] = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_calendar'");
			$data['multi_calendar'] = $data['multi_calendar']->result();
			$data['multi_calendar'] = $data['multi_calendar'][0];
			
			$data['multi_location'] = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_location'");
			$data['multi_location'] = $data['multi_location']->result_array();
			$data['multi_location'] = $data['multi_location'][0];
			
			
			
			
			
			$this->db->where("main_location", 0);
			$allContacts = $this->query_model->getbyTable("tblcontact");
			
			$multi_school_minimum_locations = $this->query_model->multi_school_minimum_locations();
			
			if(empty($allContacts) || count($allContacts) < $multi_school_minimum_locations){
				$multi_schools = 0;
				$sql = "Update tblconfigcalendar Set field_value = ".$multi_schools." Where field_name = 'multi_schools'";
				$this->db->query($sql);
			}
			
			$data['link_type'] = "contact";
			/*$this->db->order_by("pos", "ASC");
			$data['contact'] = $this->contact_model->getAll();*/
			
			$this->db->select(array('id','name','slug','school_location_type','turn_on_nested_location','parent_id','main_location','published'));
			$this->db->order_by("pos", "ASC");
			$this->db->where("school_location_type", 'default');
			//$this->db->where("school_location_type", 'default');  //not nested child locations
			$data['contactMainLocations'] = $this->contact_model->getAll();
			
			$contact  = array();
			if(!empty($data['contactMainLocations'])){
				foreach($data['contactMainLocations'] as $contact_location){
					
					$contact[$contact_location->id] = $contact_location;
					
					$this->db->select(array('id','name','slug','school_location_type','turn_on_nested_location','parent_id','main_location','published'));
					$this->db->order_by("pos", "ASC");
					$this->db->where("school_location_type", 'nested');
					$this->db->where("parent_id", $contact_location->id);
					$childLocations = $this->contact_model->getAll();
					if(!empty($childLocations)){
						
						foreach($childLocations as $child_location){
							$contact[$child_location->id] = $child_location;
						}
					}
					
				}
			}
			$data['contact'] = $contact;
			//echo '<pre>data'; print_r($data); die;
			$this->load->view("admin/contact_index", $data);
		}else{
			redirect("admin/login");
		}
	}

public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tblcontact` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function info(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$this->db->where("id", 9);
		$data['title'] = 'Pages';
		$data['pagedetails'] = $this->db->get("tblpages")->result();
		$this->load->view("admin/page_edit", $data);
		
		if(isset($_POST['update'])):
		
		$title = strtolower(rtrim(ltrim($_POST['title'])));
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
				
		$data = array("title" => $title, "content" => $content);
			$this->query_model->update("tblpages", 9, $data);
			redirect("admin/contact/info");
		endif;
		}else
		{
			redirect('admin/login');
		}
	}
	
	public function edit(){
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			if($this->uri->segment(4) != NULL){
				$this->db->select(array('international_phone_fields'));
				$data['setting'] = $this->query_model->getbyTable("tblsite");
				$contact_data=$this->db->query("select count(*) as total_record from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));
				$data['contact']=$contact_data->result();
				$data['count'] = $data['contact'][0]->total_record;
				
				$data['title'] = "Contact Us";
				$data['link_type'] = "contact";
				$data['details'] = $this->query_model->getbyId("tblcontact", $this->uri->segment(4));
				
				
				$data['mat_api'] = $this->query_model->getbyTable("tbl_mat_api");
				$data['rain_maker'] = $this->query_model->getbyTable("tblrainmaker");
				$data['perfectmind_api'] = $this->query_model->getbyTable("tbl_perfectmind_api");
				$data['kicksite'] = $this->query_model->getbyTable("tbl_kicksite");
				$data['mystudio'] = $this->query_model->getbyTable("tbl_mystudio");
				$data['payments'] = $this->query_model->getbyTable("tbl_payments");
				$data['twilio'] = $this->query_model->getbyTable("tbl_twilio");
				
				
				
				$selectedClubIds = !empty($data['mat_api'][0]->location_club_id) ? unserialize($data['mat_api'][0]->location_club_id) : '';
				$data['club_id'] = isset($selectedClubIds[$this->uri->segment(4)]) ? $selectedClubIds[$this->uri->segment(4)] : '';
				
				//$data['active_campaign'] = $this->query_model->getbyTable("tbl_active_campaign");
				
				$multi_calendar_qry = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_location'");
				$multi_calendar_result = $multi_calendar_qry->result();
				$multi_calendar = $multi_calendar_result[0];
				
				$data['multi_location'] = $multi_calendar->field_value;
				
				$data['multiLoc'] = $this->db->query("SELECT * FROM tblconfigcalendar");
				$data['multiLoc'] = $data['multiLoc']->result();
				
				$data['multiSchool'] = isset($data['multiLoc'][11]) ? $data['multiLoc'][11]->field_value : 0;
				
				$data['multi_student_password'] = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_student_password'");
				$data['multi_student_password'] = $data['multi_student_password']->result_array();
				$data['multi_student_password'] = $data['multi_student_password'][0];
				
				
				/*$contactTimes = $this->query_model->getbySpecific("tblcontact_time", 'location_id', $this->uri->segment(4));
				$weekDays  = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday'); 
				
				foreach($contactTimes as $key => $contact_time){
					$data[$weekDays[$key]][0] = $contact_time;
				}*/
				
				$contactTimes = $this->query_model->getbySpecific("tblcontact_time", 'location_id', $this->uri->segment(4));
				$weekDays  = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday'); 
				
				foreach($contactTimes as $key => $contact_time){
					$data['contact_time'][$weekDays[$key]] = $contact_time;
				}
				
				//echo '<pre>data'; print_r($data); die;
				
				
				
				if(isset($_POST['update'])):
						$this->contact_model->editContact();
				endif;
			
				$this->load->view("admin/contact_edit", $data);
				
			}else{
				redirect("admin/contact");}
		}else{
			redirect("admin/login");
		}
	}
	
	public function add(){
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$this->db->select(array('international_phone_fields'));
			$data['setting'] = $this->query_model->getbyTable("tblsite");
			$contact_data=$this->db->query("select count(*) as total_record from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));
			$data['contact']=$contact_data->result();
			$data['count'] = $data['contact'][0]->total_record;
			
			$data['title'] = "Contact Us";
			$data['link_type'] = "contact";
			
			$multi_calendar_qry = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_location'");
			$multi_calendar_result = $multi_calendar_qry->result();
			$multi_calendar = $multi_calendar_result[0];
			
			$data['rain_maker'] = $this->query_model->getbyTable("tblrainmaker");
			$data['perfectmind_api'] = $this->query_model->getbyTable("tbl_perfectmind_api");
			//$data['active_campaign'] = $this->query_model->getbyTable("tbl_active_campaign");
			$data['kicksite'] = $this->query_model->getbyTable("tbl_kicksite");
			$data['mystudio'] = $this->query_model->getbyTable("tbl_mystudio");
			$data['payments'] = $this->query_model->getbyTable("tbl_payments");
			$data['twilio'] = $this->query_model->getbyTable("tbl_twilio");
			$data['mat_api'] = $this->query_model->getbyTable("tbl_mat_api");
			//echo '<pre>sas'; print_r($data['active_campaign']); die;
				$data['multiLoc'] = $this->db->query("SELECT * FROM tblconfigcalendar");
				$data['multiLoc'] = $data['multiLoc']->result();
				
				$data['multiSchool'] = isset($data['multiLoc'][11]) ? $data['multiLoc'][11]->field_value : 0;
			
			$data['multi_location'] = $multi_calendar->field_value;
			
			
			$data['multi_student_password'] = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_student_password'");
			$data['multi_student_password'] = $data['multi_student_password']->result_array();
			$data['multi_student_password'] = $data['multi_student_password'][0];
			
			//echo '<pre>POST'; print_r($data); die;
			if(isset($_POST['update'])):
			
				//die;
					$contact_id = $this->contact_model->addContact();
					
					// check if multi location enabled
					$this->load->model('facility_model');
					$IsAllowMultiFacility = $this->facility_model->IsAllowMultiFacility();
					if($IsAllowMultiFacility){
						if($contact_id){
							// add facility
							$name = $_POST['name'].' Facility';
							if(preg_match('/\s/',$name)){
								$slug = str_replace(" ","-",strtolower($_POST['name']));
							}else{
								$slug = strtolower($_POST['name']);
							}
							$data = array(
							   'title' => $name,
							   'location_id' => $contact_id,							   
							   'slug' => $slug
							);	
							
							$result = $this->db->insert('tblfacilities', $data); 
						}
					}
				redirect('admin/contact/view');		
			endif;
			
			$this->load->view("admin/contact_add", $data);
			//redirect('admin/contact/view');
		}else{
			redirect("admin/login");
		}
	}
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tblcontact", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	public function featured(){
		$id = $_POST['pub_id'];
		$featured = $_POST['featured_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tblcontact", array("featured" => $featured)))
		{	
			echo 1;
			
		}
	}
	
	public function deleteitem(){
		$id = $_POST['delete-item-id'];
		$this->db->where("id", $id);
		if($this->db->delete("tblcontact"))
		{
			// check if multi location enabled
			$this->load->model('facility_model');
			$IsAllowMultiFacility = $this->facility_model->IsAllowMultiFacility();
			if($IsAllowMultiFacility){
				$this->db->where("location_id", $id);
				$this->db->delete("tblfacilities");
			}
			
			redirect($this->index());
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete category');</script>";
			redirect($this->index());
		}
	}
	
	
	// vinay 18/11
	public function selectMainLocation(){
		$location_id = $_POST['location_id'];
		
		$data['contact'] = $this->contact_model->getAll();
		
		
		foreach($data['contact'] as $contact){
			
			if($contact->id == $location_id){
				$this->db->where("id", $contact->id);
				$this->db->update("tblcontact", array("main_location" => 1));
			}else{
				$this->db->where("id", $contact->id);
				$this->db->update("tblcontact", array("main_location" => 0));
			}	
		} 
		/*$message = 'Successfully change main location.';
		echo $message;*/  die;
		
	}
	
	// vinay 19/11
	public function makeMainLocation(){
		$location_id = $_POST['location_id'];
		
		$data['contact'] = $this->contact_model->getAll();
		
		if(count($data['contact']) >0){
			$checkMainLocation = array();
			foreach($data['contact'] as $contactLocation){
					if($contactLocation->main_location != 0){
						$checkMainLocation[] = $contactLocation;
					}
			}
			$multipleLocaion =  count($checkMainLocation);
	
			if($multipleLocaion == 0){
				$this->db->where("id", $data['contact'][0]->id);
				$this->db->update("tblcontact", array("main_location" => 1));
			}
		}
		 die;
		
	}
	
	
	public function delete_contact_img(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['location_id'];
			//$this->db->where("id", $id);
			
			if($this->db->query("update tblcontact set photo='' where id=".$id.""))
			{	
				/*$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['lightbox_photo'];				
				unlink($img);	 */				
				echo 1;
			}
			else
			{
				echo 0;
			}
		}else{
				echo 0;
		}
	}
	
	
	
	public function duplicate_contact(){
		parse_str($_POST['formData'], $searcharray);
		$_POST = $searcharray;
	
		$contact_id =  (isset($_POST['item_id']) && !empty($_POST['item_id'])) ? $_POST['item_id'] : '';
		$action =  (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
		if(isset($action) && $action == "duplicate_record"){
			
			if(isset($contact_id) && !empty($contact_id) ){
				$details = $this->query_model->getbySpecific('tblcontact','id', $contact_id);
				
				$multiSchool = $this->query_model->getBySpecific("tblconfigcalendar", 'id',12);
				$multiSchool = isset($multiSchool[0]) ? $multiSchool[0]->field_value : 0;
				
				
				if(!empty($details)){
					$contactArr  = array();
					unset($details[0]->id);
					
					$location_name = (isset($_POST['title']) && !empty($_POST['title'])) ? $_POST['title'] : '';
					$location_name = !empty($location_name) ? $location_name : $details[0]->name;
					$contactArr['name'] = trim($location_name);
					
					foreach($details[0] as $key => $detail){
						if($key == "name"){
							if($detail == $location_name){
								$contactArr[$key] = $location_name .' Duplicate';
							}
						}elseif($key == "main_location" || $key == "turn_on_nested_location" ||  $key ==  "default_cat_id"){
							$contactArr[$key] = 0;
						}elseif($key == "school_location_type"){
							$contactArr[$key] = 'default';
						}elseif($key == "slug"){
							$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$contactArr['name']);
							$slug = str_replace(' ', '-',strtolower($replce_slug));
							$contactArr[$key] = str_replace('--', '-',strtolower($slug));
						}else{
							$contactArr[$key] = $detail;
						}
						
					}
					
					
					
					$this->query_model->insertData('tblcontact', $contactArr);
					$duplicate_contact_id = $this->db->insert_id();
					
					//$duplicate_contact_id = 67;
					
					// saving  code other tables
					if($multiSchool == 1){
						$tables = array('tblcontact_time','tblaboutschoolheader','tblschool_apikey','tblschool_about_school','tbl_school_video_section','tbl_school_text_sections','tblschool_staff','tbl_team_members','tbl_school_rows','tbl_school_testimonials');
					}else{
						$tables = array('tblcontact_time');
					}
					
					foreach($tables as $table_name){
						
						$records = $this->query_model->getbySpecific($table_name,'location_id', $contact_id);
						
						if(!empty($records)){
							foreach($records as $record){
								$dataArr = array();
									
								foreach($record as $key => $val){
									if($key == "id"){
										unset($key);
									}elseif($key == "location_id"){
										$dataArr[$key] = $duplicate_contact_id;
									}else{
										$dataArr[$key] = $val;
									}
								}
								
								$this->query_model->insertData($table_name, $dataArr);
							}
							
						}
					}
					
					
				}
			}
			
			echo 1;
			
			//redirect("admin/contact/view");
		}
	}
	
	
}
