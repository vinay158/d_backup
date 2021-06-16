<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
        $this->load->model('school_model');
        $this->load->model('contact_model');
	}
	
	public function index()
	{
		redirect('admin/school/view');
	}

	public function view(){
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "Locations";
			$data['multi_calendar'] = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_calendar'");
			$data['multi_calendar'] = $data['multi_calendar']->result();
			$data['multi_calendar'] = $data['multi_calendar'][0];
			
			$data['multi_location'] = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_location'");
			$data['multi_location'] = $data['multi_location']->result_array();
			$data['multi_location'] = $data['multi_location'][0];
			
			
			$data['link_type'] = "school";
			
			$this->db->select(array('id','name','slug','school_location_type','turn_on_nested_location','parent_id','main_location'));
			$this->db->order_by("pos", "ASC");
			$this->db->where("main_location", 0);
			$this->db->where("school_location_type", 'default');
			//$this->db->where("school_location_type", 'default');  //not nested child locations
			$data['contactMainLocations'] = $this->school_model->getAll();
			
			$contact  = array();
			if(!empty($data['contactMainLocations'])){
				foreach($data['contactMainLocations'] as $contact_location){
					
					$contact[$contact_location->id] = $contact_location;
					
					$this->db->select(array('id','name','slug','school_location_type','turn_on_nested_location','parent_id','main_location'));
					$this->db->order_by("pos", "ASC");
					$this->db->where("school_location_type", 'nested');
					$this->db->where("parent_id", $contact_location->id);
					$childLocations = $this->school_model->getAll();
					if(!empty($childLocations)){
						
						foreach($childLocations as $child_location){
							$contact[$child_location->id] = $child_location;
						}
					}
					
				}
			}
			$data['contact'] = $contact;
			//echo '<pre>data'; print_r($data); die;
			$this->load->view("admin/school_index", $data);
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


public function sortthisstaff(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tblschool_staff` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
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



		public function about_school_header(){

		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		
		 $my_mainLocation = $this->uri->segment(4);

			$records['title'] = 'About Header';
			$this->db->where("location_id", $my_mainLocation);
			$records['pagedetails'] = $this->db->get("tblaboutschoolheader")->result();
			$records['site_setting'] = $this->query_model->getbyTable('tblsite');
			$records['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			$records['location_id'] = $my_mainLocation;
			
			$records['pages'] = $this->query_model->getAllPagesWithLinks();
			
			
					
			if(isset($_POST['update'])){
				
				// update query
				
					$data['title'] = $this->input->post('title'); 
						$data['background_color'] = $this->input->post('background_color'); 
						$data['override_logo'] = $this->input->post('override_logo'); 
						$data['location_id'] = $this->uri->segment(4); 
						$data['description'] = isset($_POST['description']) ? $_POST['description'] : ''; 
						$data['buttons'] = isset($_POST['buttons']) ? $_POST['buttons'] : ''; 
						$data['link_button1'] = isset($_POST['link_button1']) ? $_POST['link_button1'] : ''; 
						$data['button1_text'] = isset($_POST['button1_text']) ? $_POST['button1_text'] : ''; 
						$data['button1_link'] = isset($_POST['button1_link']) ? $_POST['button1_link'] : ''; 
						$data['button1_page_link'] = isset($_POST['button1_page_link']) ? $_POST['button1_page_link'] : ''; 
						$data['button1_link_target'] = isset($_POST['button1_link_target']) ? $_POST['button1_link_target'] : ''; 
						$data['link_button2'] = isset($_POST['link_button2']) ? $_POST['link_button2'] : ''; 
						$data['button2_text'] = isset($_POST['button2_text']) ? $_POST['button2_text'] : ''; 
						$data['button2_link'] = isset($_POST['button2_link']) ? $_POST['button2_link'] : ''; 
						$data['button2_link_target'] = isset($_POST['button2_link_target']) ? $_POST['button2_link_target'] : '';
						$data['button2_page_link'] = isset($_POST['button2_page_link']) ? $_POST['button2_page_link'] : ''; 						
						
						$data['header_summery'] = isset($_POST['header_summery']) ? $_POST['header_summery'] : ''; 
						$data['opt1_title'] = isset($_POST['opt1_title']) ? $_POST['opt1_title'] : ''; 
						$data['opt1_text'] = isset($_POST['opt1_text']) ? $_POST['opt1_text'] : ''; 
						$data['opt1_btn_text'] = isset($_POST['opt1_btn_text']) ? $_POST['opt1_btn_text'] : ''; 
						$data['show_full_form_1'] = isset($_POST['show_full_form_1']) ? $_POST['show_full_form_1'] : 0; 
						$data['opt_2_title'] = isset($_POST['opt_2_title']) ? $_POST['opt_2_title'] : ''; 
						$data['opt_2_text'] = isset($_POST['opt_2_text']) ? $_POST['opt_2_text'] : ''; 
						$data['show_full_form_2'] = isset($_POST['show_full_form_2']) ? $_POST['show_full_form_2'] : 0; 
						$data['body_id'] = isset($_POST['body_id']) ? $_POST['body_id'] : ''; 
						$data['show_email_opt_form'] = isset($_POST['show_email_opt_form']) ? $_POST['show_email_opt_form'] : 0; 
						
						
						if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){

						$this->load->library('image_lib');

			
						$config['upload_path'] = 'upload/about_school_header/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('left_photo')){
							$image_data = $this->upload->data();
							$data['left_photo'] = $image_data['file_name'];

						}

						$resize_config['source_image'] = 'upload/about_school_header/'.$data['left_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_school_header/thumb/'.$data['left_photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/about_school_header/'.$data['left_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/about_school_header/thumb/'.$data['left_photo']);
										
					}
					
					
					$exitRecord = $this->query_model->getbySpecific('tblaboutschoolheader','location_id',$this->uri->segment(4));
					if(!empty($exitRecord)){
						$this->query_model->updateData('tblaboutschoolheader','location_id',$this->uri->segment(4), $data);
					}else{

						$this->query_model->insertData('tblaboutschoolheader',$data);
					}
		
					//echo '<pre>'; print_r($data); die;
					
					redirect('admin/school/about_school_header/'.$this->uri->segment(4));
					
					
				
		
		
			}
			
			$this->load->view("admin/about_school_header_multi", $records);
		}
	}

	// Delete Image Through ajax action

		public function deleteAboutImgMultiLocation(){
		
		
		if(count($_POST)>0){			
						
			$location_id = $_POST['location_id'];
			$photo = $_POST['photo'];
			//echo $_POST['image_path'];die;
			$this->db->where("location_id", $location_id);
			
			if($photo == 'right_photo'){
				$query = $this->db->query("update tblaboutschoolheader set right_photo='' where location_id=".$location_id."");
			}else {
				$query = $this->db->query("update tblaboutschoolheader set left_photo='' where location_id=".$location_id."");
			}
			if($query)
			{	
				$dir=pathinfo(BASEPATH);
				//print_r($dir) ; die;
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);					
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


	// API Key section

		public function school_apikeys(){
			
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
			
			
			if($this->uri->segment(4) != ''){
				//echo '<pre>vinay'; echo $this->uri->segment(5); die;
				$data['title'] = "Authentication";
				$data['location_id'] = $this->uri->segment(4);
				$data['apiKey'] = $this->query_model->getbySpecific('tblschool_apikey','location_id', $data['location_id']);
				if(!empty($data['apiKey'])){
					$data['apiKey'] = $data['apiKey'][0];
				}else{
					$data['apiKey'] = '';
				}
				
				
				
				if(isset($_POST['update'])){

					if(!empty($data['apiKey'])){
							$post_data['youtube_channel_id'] = $_POST['youtube_channel_id'];
							$post_data['youtube_api_key'] = $_POST['youtube_api_key'];
							$post_data['google_plus_id'] = $_POST['google_plus_id'];
							$post_data['google_plus_api_key'] = $_POST['google_plus_api_key'];
							$post_data['facebook_user_id'] = $_POST['facebook_user_id'];
							$post_data['facebook_access_token'] = $_POST['facebook_access_token'];
							$post_data['twitter_user_name'] = $_POST['twitter_user_name'];
							$post_data['twitter_consumer_key'] = $_POST['twitter_consumer_key'];
							$post_data['twitter_consumer_secret'] = $_POST['twitter_consumer_secret'];
							$post_data['twitter_access_token'] = $_POST['twitter_access_token'];
							$post_data['twitter_access_token_secret'] = $_POST['twitter_access_token_secret'];
							$post_data['facebook_page_id'] = $_POST['facebook_page_id'];
							$post_data['instragram_user_id'] = $_POST['instragram_user_id'];
							$post_data['instragram_access_token'] = $_POST['instragram_access_token'];
							
					
							if($this->query_model->updateData('tblschool_apikey', 'location_id',$this->uri->segment(4), $post_data)){
							 redirect('admin/school/school_apikeys/'.$this->uri->segment(4));
							}
						}else{
							$post_data['youtube_channel_id'] = $_POST['youtube_channel_id'];
							$post_data['youtube_api_key'] = $_POST['youtube_api_key'];
							$post_data['google_plus_id'] = $_POST['google_plus_id'];
							$post_data['google_plus_api_key'] = $_POST['google_plus_api_key'];
							$post_data['facebook_user_id'] = $_POST['facebook_user_id'];
							$post_data['facebook_access_token'] = $_POST['facebook_access_token'];
							$post_data['twitter_user_name'] = $_POST['twitter_user_name'];
							$post_data['twitter_consumer_key'] = $_POST['twitter_consumer_key'];
							$post_data['twitter_consumer_secret'] = $_POST['twitter_consumer_secret'];
							$post_data['twitter_access_token'] = $_POST['twitter_access_token'];
							$post_data['twitter_access_token_secret'] = $_POST['twitter_access_token_secret'];
							$post_data['facebook_page_id'] = $_POST['facebook_page_id'];
							$post_data['instragram_user_id'] = $_POST['instragram_user_id'];
							$post_data['instragram_access_token'] = $_POST['instragram_access_token'];
							$post_data['location_id'] = $_POST['location_id'];
							//echo '<pre>'; print_r($post_data); die;
							if($this->query_model->insertData('tblschool_apikey', $post_data)){
							 redirect('admin/school/school_apikeys/'.$this->uri->segment(4));
							}
						}
					
				}
				
				$this->load->view("admin/school_apikeys", $data);
			}
		
	
		}else{
				redirect('admin/login');
			}
	}
	

// About Our School

		public function about_ourschool(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			//echo $this->uri->segment(4);die("GOT IT");
			if($this->uri->segment(4) != ''){
				
				
				$data['title'] = 'School About Us';
				$data['link_type'] = 'school';
				$data['location_id'] = $this->uri->segment(4);
				$this->db->where("location_id", $this->uri->segment(4));
				$data['pagedetails'] = $this->db->get("tblschool_about_school")->result();
				
				$this->db->order_by("pos", 'asc');
				$this->db->where("location_id", $this->uri->segment(4));
				$this->db->select(array('id','title','photo_side','location_id','published','pos'));
				$data['schoolRows'] = $this->query_model->getbyTable('tbl_school_rows');
				
				//echo '<prE>data'; print_r($data); die;
				
				if(isset($_POST['update'])){
					$postDataArr = array();
					
						$postDataArr['title'] = rtrim(ltrim($_POST['title']));
						$postDataArr['sub_title'] = isset($_POST['sub_title']) ? $_POST['sub_title'] : '';	// vinay 01/12				
						$postDataArr['location_id'] = $_POST['location_id'];
						
						
						$postDataArr['image_alt'] = $_POST['image_alt'];
						$postDataArr['img_top_spacing'] = isset($_POST['img_top_spacing']) ? $_POST['img_top_spacing'] : '';
						$postDataArr['description'] = isset($_POST['description']) ? $_POST['description'] : '';
						
						$postDataArr['photo'] = isset($_POST['last-photo']) ? $_POST['last-photo'] : '';
						/*****/
						//echo '<pre>'; print_r($_FILES); die;
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){

							$this->load->library('image_lib');

							$config['upload_path'] = 'upload/school_about_us/';
							$config['allowed_types'] = 'gif|jpg|png';

							$this->load->library('upload', $config);

							if ( $this->upload->do_upload('userfile')){
								$image_data = $this->upload->data();
								$img['photo'] = $image_data['file_name'];
							}

							$resize_config['source_image'] = 'upload/school_about_us/'.$img['photo'];
							$get_size = getimagesize($resize_config['source_image']);

							$image_info = array(
								'width' => $get_size[0],
								'height' => $get_size[1]
							);

							$resize_config['create_thumb'] = FALSE;

							$resize_config['new_image'] = 'upload/school_about_us/thumb/'.$img['photo'];
							
							//echo '<pre>'; print_r($image_info); echo '</pre>';
						

							if($image_info['width']  >= 130){				
								$new_width = 130;
								$new_height = round((130/$image_info['width'])*$image_info['height']);				
								
								$resize_config['width'] = $new_width;
								$resize_config['height'] = $new_height;
								$this->image_lib->initialize($resize_config);
								$this->image_lib->resize();	
							}
							$postDataArr['photo'] = $img['photo']; 
							// Tiny Image Campress and resize
							$this->query_model->tinyImageCampressAndResize('upload/school_about_us/'.$img['photo']);
							
							$this->query_model->tinyImageCampressAndResize('upload/school_about_us/thumb/'.$img['photo']);
						}
									
					
					if(!empty($data['pagedetails'])){
						$this->query_model->updateData('tblschool_about_school','location_id',$this->uri->segment(4), $postDataArr);
					}else{
						$this->query_model->insertData('tblschool_about_school', $postDataArr);
					}
					
					
					redirect('admin/school/about_ourschool/'.$_POST['location_id']);
					
				}
				
			$this->load->view("admin/school_our_school_multi", $data);		
			
			}
		}else
		{
			redirect('admin/login');
		}
	}

// delete ajax image on school_our_school_multi

		public function deleteAboutImg(){
		
		//echo '<pre>'; print_r($_POST); die;
		if(count($_POST)>0){			
						
			$location_id = $_POST['location_id'];
			$this->db->where("location_id", $location_id);
			
			if($this->db->query("update tblschool_about_school set photo='' where location_id=".$location_id.""))
			{	
				/*$dir=pathinfo(BASEPATH);
				//echo $dir; die;
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img); */					
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
	
	
	
	public function deleteVideoSectionImg(){
		
		//echo '<pre>'; print_r($_POST); die;
		if(count($_POST)>0){			
						
			$location_id = $_POST['location_id'];
			$this->db->where("location_id", $location_id);
			
			if($this->db->query("update tbl_school_video_section set photo='' where location_id=".$location_id.""))
			{	
				/*$dir=pathinfo(BASEPATH);
				//echo $dir; die;
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img); */					
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
	
	
	
	
	public function deleteTextSectionBoxImg(){
		
		//echo '<pre>'; print_r($_POST); die;
		if(count($_POST)>0){			
						
			$location_id = $_POST['location_id'];
			$this->db->where("location_id", $location_id);
			
			if($this->db->query("update tbl_school_text_sections set left_photo='' where location_id=".$location_id.""))
			{	
				/*$dir=pathinfo(BASEPATH);
				//echo $dir; die;
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img); */					
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
	
	

// Our Instructor School Section

		public function school_staff_index(){

		$is_logged_in = $this->session->userdata('is_logged_in');
		
				if(!empty($is_logged_in) && $is_logged_in == true)
				{
					$data['title'] = 'Our School Instructors';
						$data['link_type'] = 'school';
						//echo $this->uri->segment(4); die;
						$this->db->order_by('pos asc, id desc');
						$this->db->select(array('id','name','photo','published','location_id','pos'));
						$data['staff'] = $this->query_model->getbySpecific("tblschool_staff", 'location_id',$this->uri->segment(4));
						
						$IsAllowMultiStaff = $this->school_model->IsAllowMultiStaff();
						$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;			
						
						$locations = $this->school_model->getSpecificLocationStaffMeta($this->uri->segment(4));
						
						$data['locations'] = $locations;
						//echo '<pre>'; print_r($data['staff']); die;
						$data['location_id'] = $this->uri->segment(4);		
						
						//echo '<pre>data'; print_r($data); die;
					
						if(isset($_POST['update'])):
						
							$title = trim($_POST['title']);
					
							$content = $_POST['text'];		
							$content = htmlentities($content);
					
							$data = array("title" => $title, "content" => $content);
							$this->query_model->update("tblpages", 6, $data);
							redirect("admin/school/school_staff_index");
						endif;
						
						$this->load->view("admin/school_staff_index", $data);
					
				}else
				{
					redirect('admin/login');
				}
		}


	// Add Instructor for tblschool_staff

			public function add(){
		
			$is_logged_in = $this->session->userdata('is_logged_in');
			$this->load->helper('form');
			
			if(!empty($is_logged_in) && $is_logged_in == true){
				
				$data['title'] = "Our Instructors";
				
				$IsAllowMultiStaff = $this->school_model->IsAllowMultiStaff();
				$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;
				
				$blank_location = array('0' => 'Select Location');
				$locations = $this->school_model->getLocations();
				
				$data['locations'] = $blank_location + $locations;	
				$data['location_id'] = $this->uri->segment(4);
				if(isset($_POST['update'])):
					//echo '<pre>'; print_r($_POST); die('yes');
							$this->school_model->addStaff();
				endif;
				
				$this->load->view("admin/school_staff_add", $data);	
			}else{
				redirect('admin/login');
			}
	
	}


	// Edit Instructor for tblschool_staff

		public function staff_edit(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$this->load->helper('form');
		
		if(!empty($is_logged_in) && $is_logged_in == true){

			
			if($this->uri->segment(4) != NULL){
				
				$data['title'] = 'Our Instructors';
				$data['details'] = $this->school_model->getStaffbyId($this->uri->segment(4));
				
				$IsAllowMultiStaff = $this->school_model->IsAllowMultiStaff();
				$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;
				
				$blank_location = array('0' => 'Select Location');
				$locations = $this->school_model->getLocations();
				
				$data['locations'] = $blank_location + $locations;	

				//echo '<pre>'; print_r($data); die('yes');	
		
				
				if(isset($_POST['update'])):
					$this->school_model->updateStaff();
				endif;
				
				$this->load->view("admin/school_staff_edit", $data);
			
			}else{ 
				redirect("admin/school");
			}
		}else{ 
			redirect("admin/login");
		}
	}


		public function staff_img_delete(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['staff_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblschool_staff set photo='' where id=".$id.""))
			{	
				$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);					
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

	
	
	
	public function delete_staff_lightbox_photo(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['staff_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblschool_staff set lightbox_photo='' where id=".$id.""))
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
	
	

	public function school_staff_publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tblschool_staff", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}


	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$location_id = $_POST['category_loc'];
	
	$this->db->where("id", $id);
	if($this->db->delete("tblschool_staff"))
	{
	redirect('admin/school/school_staff_index/'.$location_id);
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete staff');</script>";
	redirect('admin/school/school_staff_index/'.$location_id);
	}
	}



	// Team Members Section

		public function team_member_index(){

		$is_logged_in = $this->session->userdata('is_logged_in');
		
				if(!empty($is_logged_in) && $is_logged_in == true)
				{
					$data['title'] = 'School Team Members';
						$data['link_type'] = 'school';
						//echo $this->uri->segment(4); die;
						$this->db->order_by("pos","asc");
						$data['team'] = $this->query_model->getbySpecific("tbl_team_members", 'location_id',$this->uri->segment(4));
						
						//$IsAllowMultiStaff = $this->school_model->IsAllowMultiStaff();
						//$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;			
						
						//$locations = $this->school_model->getSpecificLocationStaffMeta($this->uri->segment(4));
						
						//$data['locations'] = $locations;
						//echo '<pre>'; print_r($data['staff']); die;
						$data['location_id'] = $this->uri->segment(4);		
						
					//echo '<pre>data'; print_r($data); die;	
					
						if(isset($_POST['update'])):
						
							$title = trim($_POST['title']);
					
							$content = $_POST['text'];		
							$content = htmlentities($content);
					
							$data = array("title" => $title, "content" => $content);
							$this->query_model->update("tblpages", 6, $data);
							redirect("admin/school/team_member_index");
						endif;
						
					$this->load->view("admin/team_member_index", $data);
					
				}else
				{
					redirect('admin/login');
				}
		}


	// Add Instructor for tblschool_staff

			public function team_member_add(){
		
			$is_logged_in = $this->session->userdata('is_logged_in');
			$this->load->helper('form');
			
			if(!empty($is_logged_in) && $is_logged_in == true){
				
				$data['title'] = "Team Members";
				
				//$IsAllowMultiStaff = $this->school_model->IsAllowMultiStaff();
				//$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;
				
				//$blank_location = array('0' => 'Select Location');
				//$locations = $this->school_model->getLocations();
				
				//$data['locations'] = $blank_location + $locations;	

				$data['location_id'] = $this->uri->segment(4);
				if(isset($_POST['update'])):
					//echo '<pre>'; print_r($_POST); die('yes');
							$this->school_model->addTeam();
				endif;
				
				$this->load->view("admin/team_member_add", $data);	
			}else{
				redirect('admin/login');
			}
	
	}


	// Edit Instructor for tblschool_staff

		public function team_member_edit(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$this->load->helper('form');
		
		if(!empty($is_logged_in) && $is_logged_in == true){

			
			if($this->uri->segment(4) != NULL){
				
				$data['title'] = 'Team Members';
				$data['details'] = $this->school_model->getMemberbyId($this->uri->segment(4));
				
				//$IsAllowMultiStaff = $this->school_model->IsAllowMultiStaff();
				//$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;
				
				//$blank_location = array('0' => 'Select Location');
				//$locations = $this->school_model->getLocations();
				
				//$data['locations'] = $blank_location + $locations;	

				//echo '<pre>'; print_r($data); die('yes');	
		
				$this->load->view("admin/team_member_edit", $data);
			
				if(isset($_POST['update'])):
					$this->school_model->update_team();
				endif;
			}else{ 
				redirect("admin/school");
			}
		}else{ 
			redirect("admin/login");
		}
	}



	public function team_member_publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tbl_team_members", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}

	
	public function sort_team_member(){
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_team_members` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'   AND `location_id`='" . $this->uri->segment(4) . "'  ") or die(mysqli_error($this->db->conn_id));
		}
	}

	public function team_member_deleteitem(){
	$id = $this->uri->segment(4);
	$location_id = $this->uri->segment(5);
	
	$this->db->where("id", $id);
	if($this->db->delete("tbl_team_members"))
	{
	redirect('admin/school/team_member_index/'.$location_id);
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete team');</script>";
	redirect('admin/school/team_member_index/'.$location_id);
	}
	}
	
	
	
	
	
	
	public function add_school_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				
			$records['title'] = 'Add School Row';
			$records['link_type'] = 'school';
			
			$records['location_id'] = $this->uri->segment(4);
			
			
			if(isset($_POST['update'])){
				//echo '<pre>'; print_r($_POST); die;
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						$data['button_text'] = $this->input->post('button_text');						
						$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						$data['location_id'] = $this->input->post('location_id'); 
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/school_about_us/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/school_about_us/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/school_about_us/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/school_about_us/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/school_about_us/thumb/'.$data['photo']);
												
					}
					
				
					
					$this->query_model->insertData('tbl_school_rows', $data);
					
						redirect("admin/school/about_ourschool/".$_POST['location_id']);
						
				//echo '<pre>'; print_r($_POST); die;
				//echo '<pre>'; print_r($_POST); die;
			}
			
			$this->load->view("admin/add_school_row", $records);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
		
	public function edit_school_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Add School Row';
			$records['link_type'] = 'school';
			
			
			$this->db->where("id", $this->uri->segment(4));
			$records['pagedetails'] = $this->query_model->getbyTable('tbl_school_rows');
			
			
			
			if(isset($_POST['update'])){
				
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						$data['button_text'] = $this->input->post('button_text');						
						$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						$data['location_id'] = $this->input->post('location_id'); 
						//echo '<pre>data'; print_r($data); die;
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/school_about_us/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/school_about_us/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/school_about_us/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/school_about_us/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/school_about_us/thumb/'.$data['photo']);						
					}
					
				
					$this->query_model->updateData('tbl_school_rows','id',$this->uri->segment(4), $data);
					
					//$this->query_model->insertData('tbl_aboutus_rows', $data);
					
						redirect("admin/school/about_ourschool/".$_POST['location_id']);
						
				//echo '<pre>'; print_r($_POST); die;
			}
			
			$this->load->view("admin/edit_school_row", $records);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function delete_aboutus_row(){
		
		$id = $_POST['delete-item-id'];
			$this->db->where("id", $id);
			if($this->db->delete("tbl_school_rows"))
			{
				redirect("admin/school/about_ourschool/".$_POST['location-id']);
			}
			else
			{
				redirect("admin/school/about_ourschool/".$_POST['location-id']);
			}
	}
	
	
	
	public function deleteSchoolRowImage(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['id'];
			$query = $this->db->query("update tbl_school_rows set photo='' where id=".$id."");
			echo 1;
		}else{
				echo 0;
		}
	
	}
	
	
	
	public function sortSchoolRows(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_school_rows` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'   AND `location_id`='" . $this->uri->segment(4) . "'  ") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	public function publishSchoolRows(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tbl_school_rows", array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	
	
	public function video_section(){
	
	$metaVaribles = $this->query_model->getbyTable("tblmetavariable");
	//echo '<pre>metaVaribles'; print_r($metaVaribles[0]->meta_school_name); die;
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				$data['title'] = 'Edit Video';
				$data['location_id'] = $this->uri->segment(4);
				$this->db->where("location_id", $this->uri->segment(4));
				$data['pagedetails'] = $this->db->get("tbl_school_video_section")->result();
				
				
				if(isset($_POST['update'])){
					//echo '<pre>'; print_r($_POST); die;
					$postDataArr = array();
					
					$postDataArr['title'] = rtrim(ltrim($_POST['title']));
						$content = isset($_POST['text']) ? $_POST['text'] : '';	
						$postDataArr['content'] = htmlentities($content);	
						$postDataArr['sub_title'] = isset($_POST['sub_title']) ? $_POST['sub_title'] :'' ;	// vinay 01/12				
						$postDataArr['location_id'] = $_POST['location_id'];
						$postDataArr['video_type'] = isset($_POST['video_type']) ? $_POST['video_type'] : '';
						$postDataArr['youtube_video'] = isset($_POST['youtube_video']) ? $_POST['youtube_video'] : '';
						$postDataArr['vimeo_video'] = isset($_POST['vimeo_video']) ? $_POST['vimeo_video'] : '';
						
						$postDataArr['image_video'] = isset($_POST['image_video']) ? $_POST['image_video'] : '';
						$postDataArr['image_alt'] = isset($_POST['image_alt']) ? $_POST['image_alt'] : '';
						
						$postDataArr['photo'] =isset( $_POST['last-photo']) ?  $_POST['last-photo'] : '';
						$postDataArr['video_section'] = isset($_POST['video_section']) ? $_POST['video_section'] : 0;
						
						//$this->db->where("id", $location_id);
						//$locationDetail = $this->db->get("tblcontact")->result();
						$meta_title = '';
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){

							$this->load->library('image_lib');

							$config['upload_path'] = 'upload/school_about_us/';
							$config['allowed_types'] = 'gif|jpg|png';

							$this->load->library('upload', $config);

							if ( $this->upload->do_upload('userfile')){
								$image_data = $this->upload->data();
								$img['photo'] = $image_data['file_name'];
							}

							$resize_config['source_image'] = 'upload/school_about_us/'.$img['photo'];
							$get_size = getimagesize($resize_config['source_image']);

							$image_info = array(
								'width' => $get_size[0],
								'height' => $get_size[1]
							);

							$resize_config['create_thumb'] = FALSE;

							$resize_config['new_image'] = 'upload/school_about_us/thumb/'.$img['photo'];
							
							//echo '<pre>'; print_r($image_info); echo '</pre>';
						

							if($image_info['width']  >= 130){				
								$new_width = 130;
								$new_height = round((130/$image_info['width'])*$image_info['height']);				
								
								$resize_config['width'] = $new_width;
								$resize_config['height'] = $new_height;
								$this->image_lib->initialize($resize_config);
								$this->image_lib->resize();	
							}
							
							$postDataArr['photo'] = $img['photo'];
							
							// Tiny Image Campress and resize
								$this->query_model->tinyImageCampressAndResize('upload/school_about_us/'.$img['photo']);
								
								$this->query_model->tinyImageCampressAndResize('upload/school_about_us/thumb/'.$img['photo']);
								
							$postDataArr['photo'] = $img['photo']; 						
						}
					
					
					if(!empty($data['pagedetails'])){
						
						$this->query_model->updateData('tbl_school_video_section','location_id',$this->uri->segment(4), $postDataArr);
						redirect('admin/school/video_section/'.$_POST['location_id']);
					
					} else{
						
						$this->query_model->insertData('tbl_school_video_section', $postDataArr);
						redirect('admin/school/video_section/'.$_POST['location_id']);
					}
				}
				
			$this->load->view("admin/school_video_section", $data);	
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function text_sections(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		
		$my_mainLocation = $this->query_model->getMainLocation();
		$my_mainLocation = $my_mainLocation[0]->id;
		
		
			
				
			$records['title'] = 'Location About / Programs';
			$records['link_type'] = 'school';
			$this->db->where("location_id", $this->uri->segment(4));
			$records['pagedetails'] = $this->db->get("tbl_school_text_sections")->result();
			$records['site_setting'] = $this->query_model->getbyTable('tblsite');
			$records['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			$records['location_id'] = $this->uri->segment(4);
			$records['programPages'] = $this->getProgramsList();
			
			
			//echo '<pre>'; print_r($data['pagedetails']); die;
			
					
			if(isset($_POST['update'])):
				// update query
					//unset($records['pagedetails']);
					
					
				
						$data['background_color'] = $this->input->post('background_color'); 
						$data['location_id'] = $this->uri->segment(4); 
						//$data['override_logo'] = $this->input->post('override_logo'); 
						$data['box_title'] = $this->input->post('box_title'); 
						$data['box_description'] = isset($_POST['box_description']) ? $_POST['box_description'] : ''; 
						$data['box_1_text'] = $this->input->post('box_1_text'); 
						$data['box_2_text'] = $this->input->post('box_2_text'); 
						$data['box_3_text'] = $this->input->post('box_3_text'); 
						$data['full_box_title'] = isset($_POST['full_box_title']) ? $_POST['full_box_title'] : '';  
						 
						$data['full_box_1_text'] = $this->input->post('full_box_1_text'); 
						$data['full_box_2_text'] = $this->input->post('full_box_2_text'); 
						$data['full_box_3_text'] = $this->input->post('full_box_3_text'); 
						$data['description'] = $this->input->post('description'); 
						$data['show_timeline'] = isset($_POST['show_timeline']) ? $_POST['show_timeline'] : 0;  
						$data['timeline_title'] = (isset($_POST['timeline_title']) && !empty($_POST['timeline_title'])) ? $_POST['timeline_title'] : 'ATA Timeline';  
						$data['timeline_text'] = (isset($_POST['timeline_text']) && !empty($_POST['timeline_text'])) ? $_POST['timeline_text'] : '';  
						 
						$data['getting_started_title'] = isset($_POST['getting_started_title']) ? $_POST['getting_started_title'] : ''; 
						$data['getting_started_box_1_text'] = isset($_POST['getting_started_box_1_text']) ? $_POST['getting_started_box_1_text'] : ''; 
						$data['getting_started_box_2_text'] = isset($_POST['getting_started_box_2_text']) ? $_POST['getting_started_box_2_text'] : ''; 
						$data['getting_started_box_3_text'] = isset($_POST['getting_started_box_3_text']) ? $_POST['getting_started_box_3_text'] : ''; 
						
						$selectedProgram_ids = array();
						if(isset($_POST['program_ids']) && !empty($_POST['program_ids'])){
							$i = 1;
							foreach($_POST['program_ids'] as $program_ids){
								if(isset($program_ids['program_id']) && !empty($program_ids['program_id'])){
									$selectedProgram_ids[$program_ids['program_id']]['program_id'] = $program_ids['program_id'];
									
									$selectedProgram_ids[$program_ids['program_id']]['order_number'] = !empty($program_ids['order_number']) ? $program_ids['order_number'] : $i;
								
								$i++;
								}
							}
						}
						
						//echo '<pre>selectedProgram_ids'; print_R($selectedProgram_ids); die;
						$data['program_ids'] = !empty($selectedProgram_ids) ? serialize($selectedProgram_ids) : ''; 
						
						
						if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/school_about_us/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('left_photo')){
							$image_data = $this->upload->data();
							$data['left_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/school_about_us/'.$data['left_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/school_about_us/thumb/'.$data['left_photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/school_about_us/'.$data['left_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/school_about_us/thumb/'.$data['left_photo']);
										
					}
					
					
					
				if(!empty($records['pagedetails'])){
				
					$this->query_model->updateData('tbl_school_text_sections','location_id',$this->uri->segment(4), $data);
					redirect('admin/school/text_sections/'.$_POST['location_id']);
					
				}else {
					
					$this->query_model->insertData('tbl_school_text_sections', $data);
					
					redirect("admin/school/text_sections/".$_POST['location_id']);
					
				}
				
				
				endif;
			
			$this->load->view("admin/school_text_sections", $records);
		
		
		}else
		{
			redirect('admin/login');
		}
	}

	public function getProgramsList(){
		$pages = array();
		
		$program_nav = $this->query_model->getCategory("programs");
			if(!empty($program_nav)){
				$col = 1;
					foreach($program_nav as $nav_item_prog){
					$this->db->where('published',1);
					$query_subcat=$this->db->query("select `id` from tblprogram where category=".$nav_item_prog->cat_id."");
									$query_subcat=$query_subcat->result();
									
									$cat_name=str_replace(" ",'-',trim($nav_item_prog->cat_name));
									
									
									$published = 1;
									$this->db->order_by("pos","asc");
									$query_sub = $this->query_model->getbySpecificRecord("tblprogram", "category", $nav_item_prog->cat_id,$published);
									
									if(isset($query_sub) && !empty($query_sub)) {
										$n = 1;
										foreach($query_sub as $subnav_item_prog){						
											$pages[$subnav_item_prog->id]['program_title'] = $subnav_item_prog->buttonName;
											$pages[$subnav_item_prog->id]['program_id'] = $subnav_item_prog->id;
											if($n == 1){
												$pages[$subnav_item_prog->id]['category'] = $nav_item_prog->cat_name;
											}
											
											$n++;
										}
											 
									}
							$col++; 
						}
		
					}
					
		return $pages;
		//echo '<pre>pages'; print_r($pages); die;
	}
	
	
	public function testimonial_sections(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				
			$records['title'] = 'Testimonial / Trial Offer';
			$records['link_type'] = 'school';
			$this->db->where("location_id", $this->uri->segment(4));
			$records['pagedetails'] = $this->db->get("tbl_school_text_sections")->result();
			$records['location_id'] = $this->uri->segment(4);
			//echo '<prE>pagedetails'; print_r($records['pagedetails']); die;
			$this->db->order_by('id', 'desc');
			$this->db->where("published", 1);
			$records['testimonials'] = $this->query_model->getbyTable("tbltestimonials");
			
			$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
			$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
			$this->db->order_by('pos', 'asc');
			$this->db->where("published", 1);
			$this->db->where("location_id", $this->uri->segment(4));
			$this->db->or_where("location_id", 'all');
			if($isUniqueSpecialOffer == 1){
				$this->db->where("type", "trial_offer");
			}
			$records['all_trial_categories'] = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
			//echo '<pre>all_trial_categories'; print_r($data['all_trial_categories']); die;
				
			$this->db->where("location_id", $this->uri->segment(4));
			$this->db->order_by('pos asc, id desc');
			$records['schoolTestimonials'] = $this->db->get("tbl_school_testimonials")->result();
			
			
			
			if(isset($_POST['update'])){
				$location_id = isset($_POST['location_id']) ? $_POST['location_id'] : '';
				$form_type = isset($_POST['form_type']) ? $_POST['form_type'] : 'testimonial';
				//echo $form_type; die;
				$postData = array();
				
				if($form_type == "trial_offer"){
					$postData['unique_trial_offer'] = isset($_POST['unique_trial_offer']) ? $_POST['unique_trial_offer'] : 0;
					$postData['trial_offer_ids'] = (isset($_POST['trial_offer_ids']) && !empty($_POST['trial_offer_ids'])) ? serialize($_POST['trial_offer_ids']) : '';
				}else{
					$postData['unique_testimonial'] = isset($_POST['unique_testimonial']) ? $_POST['unique_testimonial'] : 0;
					$postData['testimonial_ids'] = (isset($_POST['testimonial_ids']) && !empty($_POST['testimonial_ids'])) ? serialize($_POST['testimonial_ids']) : '';
					
				}
				//echo '<pre>postData'; print_r($postData); die;
				if(!empty($records['pagedetails'])){
					
					$this->query_model->updateData('tbl_school_text_sections','location_id',$location_id, $postData);
				}else{
					$postData['location_id'] = $location_id;
				
					$this->query_model->insertData('tbl_school_text_sections', $postData);
				}
				
				redirect("admin/school/testimonial_sections/".$location_id);
			}
			
			$this->load->view("admin/school_testimonial_sections", $records);
			
		}
	}
	
	
	public function save_unique_testimonial(){
		$result = 0;
		if(isset($_POST['type']) && $_POST['type'] == "uniqueTestimonial"){
			$location_id = (isset($_POST['location_id']) && !empty($_POST['location_id'])) ? $_POST['location_id'] : '';
			
			if(!empty($location_id)){
				$unique_testimonial = (isset($_POST['unique_testimonial']) && !empty($_POST['unique_testimonial'])) ? $_POST['unique_testimonial'] : 0;
				
				$this->db->where("location_id", $location_id);
				$existRecord = $this->db->get("tbl_school_text_sections")->result();
				
				$postData = array();
				$postData['unique_testimonial'] = $unique_testimonial;
				if(!empty($existRecord)){
					$this->query_model->updateData('tbl_school_text_sections','location_id',$location_id, $postData);
				}else{
					$postData['location_id'] = $location_id;
					$this->query_model->insertData('tbl_school_text_sections', $postData);
				}
				
				$result = 1;
			}
			
		}
		echo $result; exit();
	}
	
	
	
	public function save_unique_trialoffer(){
		$result = 0;
		if(isset($_POST['type']) && $_POST['type'] == "uniqueTestimonial"){
			$location_id = (isset($_POST['location_id']) && !empty($_POST['location_id'])) ? $_POST['location_id'] : '';
			
			if(!empty($location_id)){
				$unique_trial_offer = (isset($_POST['unique_trial_offer']) && !empty($_POST['unique_testimonial'])) ? $_POST['unique_trial_offer'] : 0;
				
				$this->db->where("location_id", $location_id);
				$existRecord = $this->db->get("tbl_school_text_sections")->result();
				
				$postData = array();
				$postData['unique_trial_offer'] = $unique_trial_offer;
				if(!empty($existRecord)){
					$this->query_model->updateData('tbl_school_text_sections','location_id',$location_id, $postData);
				}else{
					$postData['location_id'] = $location_id;
					$this->query_model->insertData('tbl_school_text_sections', $postData);
				}
				
				$result = 1;
			}
			
		}
		echo $result; exit();
	}
	
	public function edit_school_testimonial(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$this->load->helper('form');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if($this->uri->segment(4) != NULL){
				
				$data['title'] = 'Edit School Testimonial';
				$records['location_id'] = $this->uri->segment(4);
				
				$data['details'] = $this->query_model->getBySpecific('tbl_school_testimonials','id',$this->uri->segment(4));
				
				
			
				if(isset($_POST['update'])):
			$postData  =array();
				$image = isset($_FILES['userfile']['name']) ? $_FILES['userfile']['name'] : '';
				$postData['photo'] = isset($_POST['last-photo']) ? $_POST['last-photo'] : '';
				$postData['name'] = isset($_POST['name']) ?  trim($_POST['name']) : '';
				
				$postData['content'] = isset($_POST['text']) ? $_POST['text'] : '';		
				$postData['content'] = htmlentities($postData['content']);
						
				$postData['title'] = isset($_POST['title']) ? $_POST['title'] : '';
				$postData['published'] = isset($_POST['publish']) ? $_POST['publish'] : 1;
				$location_id = isset($_POST['location_id']) ? $_POST['location_id'] : '';
				
				if(!empty($image)){
					$this->load->model('upload_model');
					$path = "upload/school_testimonials/";
					if($a = $this->upload_model->upload_image($path)){
						$postData['photo'] = $a;
					}	
				}
				
				
				$this->query_model->update('tbl_school_testimonials',$this->uri->segment(4),$postData);
				redirect("admin/school/testimonial_sections/".$location_id);
				
				endif;
				
				$this->load->view("admin/school_testimonial_edit", $data);
				
			}else{ 
				//redirect("admin/school/testimonial_sections/");
			}
		}else{ 
			redirect("admin/login");
		}
	}
	
	public function add_school_testimonial(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$this->load->helper('form');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			$records['title'] = "Add School Testimonial";	
			$records['location_id'] = $this->uri->segment(4);
			
					
				
			if(isset($_POST['update'])):
			$postData  =array();
				$postData['photo'] = isset($_FILES['userfile']['name']) ? $_FILES['userfile']['name'] : '';
				$postData['name'] = isset($_POST['name']) ?  trim($_POST['name']) : '';
				
				$postData['content'] = isset($_POST['text']) ? $_POST['text'] : '';		
				$postData['content'] = htmlentities($postData['content']);
						
				$postData['title'] = isset($_POST['title']) ? $_POST['title'] : '';
				$postData['published'] = 1;
				$postData['location_id'] = isset($_POST['location_id']) ? $_POST['location_id'] : $this->uri->segment(4);
				
				if(!empty($postData['photo'])){
					$this->load->model('upload_model');
					$path = "upload/school_testimonials/";
					if($a = $this->upload_model->upload_image($path)){
						$postData['photo'] = $a;
					}	
				}
				
				
				$this->query_model->insertData('tbl_school_testimonials',$postData);
				redirect("admin/school/testimonial_sections/".$postData['location_id']);
				
				endif;
			
			$this->load->view("admin/school_testimonial_add", $records);	
			
		}else{
			redirect('admin/login');
		}
	
	}
	
	
	public function delete_testimonial_img(){
		if(count($_POST)>0){			
						
			$id = $_POST['testimonials_id'];
			//$this->db->where("id", $id);
			
			if($this->db->query("update tbl_school_testimonials set photo='' where id=".$id.""))
			{	
				/*$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
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
	
	
	
	public function sortSchoolTestimonials(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_school_testimonials` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'   AND `location_id`='" . $this->uri->segment(4) . "'  ") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	public function publishSchoolTestimonials(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tbl_school_testimonials", array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	
	
	public function delete_school_testimonial(){
		
		$id = $_POST['delete-item-id'];
			$this->db->where("id", $id);
			if($this->db->delete("tbl_school_testimonials"))
			{
				redirect("admin/school/testimonial_sections/".$_POST['location-id']);
			}
			else
			{
				redirect("admin/school/testimonial_sections/".$_POST['location-id']);
			}
	}
	
	
	
	public function ajax_team_member_popup(){
		
		if(isset($_POST['action_type']) && !empty($_POST['action_type'])){
			$records = array();
			$records['detail'] = array();
			$records['action_type'] = $_POST['action_type'];
			$records['item_id'] = $_POST['item_id'];
			$records['table_name'] = $_POST['table_name'];
			$records['form_type'] = $_POST['form_type'];
			$records['location_id'] = $_POST['location_id'];
			
			if($records['action_type'] == "edit" && !empty($records['item_id'])){
				
				$this->db->where("id", $records['item_id']);
				$detail = $this->query_model->getbyTable($records['table_name']);
				if(!empty($detail)){
					
					$records['detail'] = $detail[0];
					
				}
			}
			
			
			$this->load->view("admin/ajax_team_member_form", $records);
			
			
		}
	}
	
	
	public function ajax_save_team_member(){
		
		parse_str($_POST['formData'], $searcharray);
		//echo '<pre>searcharray'; print_r($_POST); die;
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['update'])){
				
				$item_id = isset($searcharray['item_id']) ? $searcharray['item_id'] : '';
				$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
				$form_type = isset($searcharray['form_type']) ? $searcharray['form_type'] : '';
					
					$postData['name'] = isset($searcharray['name']) ? trim($searcharray['name']) : '';
					$postData['designation'] = isset($searcharray['designation']) ? trim($searcharray['designation']) : '';
					$postData['location_id'] = isset($searcharray['location_id']) ? trim($searcharray['location_id']) : 0;
					$postData['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
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
				
					
					$result['res'] = 1;
					$result['id'] = $insert_id;
					$result['title'] = $postData['name'];
					$result['form_type'] = $form_type;
					$result['table_name'] = $table_name;
					$result['designation'] = $postData['designation'];
					$result['published'] = $postData['published'];
					
				
			}
		echo json_encode($result); 	
	}
	
	
	
	
	
}
