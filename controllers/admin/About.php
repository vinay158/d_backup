<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
        $this->load->model('blog_model');        
		
	}
	
	public function index()
	{
		redirect('/admin/about/ourschool');
	}	 
	 
	public function ourschool(){
	
	$metaVaribles = $this->query_model->getbyTable("tblmetavariable");
	//echo '<pre>metaVaribles'; print_r($metaVaribles[0]->meta_school_name); die;
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			if($this->uri->segment(5) == ''){
				$my_mainLocation = $this->query_model->getMainLocation();
				$my_mainLocation = $my_mainLocation[0]->id;
				$this->db->where("location_id", $my_mainLocation);
				$data['pagedetails'] = $this->db->get("tblaboutourschool")->result();
				$data['title'] = 'Pages';
				
				
						
				if(isset($_POST['update'])):
				
				$title = rtrim(ltrim($_POST['title']));
				
				$content = $_POST['text'];	
				$sub_title = $_POST['sub_title'];	// vinay 01/12				
				$content = htmlentities($content);
				$video_type = $_POST['video_type'];
				$youtube_video = $_POST['youtube_video'];
				$vimeo_video = $_POST['vimeo_video'];
				$video_section = isset($_POST['video_section']) ? $_POST['video_section'] : 0;
				$location_id = $my_mainLocation;
				
				$this->db->where("id", $my_mainLocation);
				$locationDetail = $this->db->get("tblcontact")->result();
				$meta_title = '';
				//$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : 'About Us | '.$metaVaribles[0]->meta_main_martial_arts_style.' school in '.$locationDetail[0]->city.' | '.$metaVaribles[0]->meta_school_name. ' '.$locationDetail[0]->name;
				$data = array("title" => $title, "content" => $content, "sub_title" => $sub_title, 'location_id' => $location_id, 'video_type'=> $video_type,'youtube_video'=> $youtube_video,'vimeo_video'=> $vimeo_video,'meta_title' => $meta_title,'video_section' => $video_section);// vinay 01/12		
					$this->query_model->updateData('tblaboutourschool','location_id',$my_mainLocation, $data);
					redirect("admin/about/ourschool");
				endif;
				
				$this->load->view("admin/page_edit", $data);
				
			} else{
				
				$data['title'] = 'Pages';
				$data['location_id'] = $this->uri->segment(5);
				$this->db->where("location_id", $this->uri->segment(5));
				$data['pagedetails'] = $this->db->get("tblaboutourschool")->result();
				//echo '<pre>data'; print_r($data); die;
					
				
				if(isset($_POST['update'])){
					//echo '<pre>'; print_r($_POST); die;
					if(!empty($data['pagedetails'])){
						$title = rtrim(ltrim($_POST['title']));
						$content = $_POST['text'];	
						$content = htmlentities($content);	
						$sub_title = $_POST['sub_title'];	// vinay 01/12				
						$location_id = $_POST['location_id'];
						$video_type = $_POST['video_type'];
						$youtube_video = $_POST['youtube_video'];
						$vimeo_video = $_POST['vimeo_video'];
						
						$image_video = $_POST['image_video'];
						$image_alt = $_POST['image_alt'];
						
						$image_name = $_POST['last-photo'];
						$video_section = isset($_POST['video_section']) ? $_POST['video_section'] : 0;
						
						$this->db->where("id", $location_id);
						$locationDetail = $this->db->get("tblcontact")->result();
						$meta_title = '';
						//$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] :  'About Us | '.$metaVaribles[0]->meta_main_martial_arts_style.' school in '.$locationDetail[0]->city.' | '.$metaVaribles[0]->meta_school_name. ' '.$locationDetail[0]->name;
						/*****/
						//echo '<pre>'; print_r($_FILES); die;
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){

			$this->load->library('image_lib');

			$config['upload_path'] = 'upload/about_us/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('userfile')){
				$image_data = $this->upload->data();
				$img['photo'] = $image_data['file_name'];
			}

			$resize_config['source_image'] = 'upload/about_us/'.$img['photo'];
			$get_size = getimagesize($resize_config['source_image']);

			$image_info = array(
				'width' => $get_size[0],
				'height' => $get_size[1]
			);

			$resize_config['create_thumb'] = FALSE;

			$resize_config['new_image'] = 'upload/about_us/thumb/'.$img['photo'];
			
			//echo '<pre>'; print_r($image_info); echo '</pre>';
		

			if($image_info['width']  >= 130){				
				$new_width = 130;
				$new_height = round((130/$image_info['width'])*$image_info['height']);				
				
				$resize_config['width'] = $new_width;
				$resize_config['height'] = $new_height;
				$this->image_lib->initialize($resize_config);
				$this->image_lib->resize();	
			}
			
			// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/about_us/'.$img['photo']);
				
				$this->query_model->tinyImageCampressAndResize('upload/about_us/thumb/'.$img['photo']);
				
			$image_name = $img['photo']; 						
		}
					
					
						/****/
						$datas = array("title" => $title,'photo' => $image_name,'content' => $content,'sub_title' => $sub_title,'location_id' => $location_id, 'video_type'=> $video_type,'youtube_video'=> $youtube_video,'vimeo_video'=> $vimeo_video,'image_video'=>$image_video,'image_alt'=>$image_alt,'meta_title'=>$meta_title,'video_section' => $video_section);	// vinay 01/12
						$this->query_model->updateData('tblaboutourschool','location_id',$this->uri->segment(5), $datas);
						redirect('admin/about/ourschool/multilocation/'.$_POST['location_id']);
					} else{
						$title = rtrim(ltrim($_POST['title']));
						$content = $_POST['text'];	
						$content = htmlentities($content);	
						$sub_title = $_POST['sub_title'];	// vinay 01/12	
						$location_id = $_POST['location_id'];
						$video_type = $_POST['video_type'];
						$youtube_video = $_POST['youtube_video'];
						$vimeo_video = $_POST['vimeo_video'];
						$image_video = $_POST['image_video'];
						$image_alt = $_POST['image_alt'];
						$video_section = isset($_POST['video_section']) ? $_POST['video_section'] : 0;
						$this->db->where("id", $location_id);
						$locationDetail = $this->db->get("tblcontact")->result();
						$meta_title = '';
						//$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] :  'About Us | '.$metaVaribles[0]->meta_main_martial_arts_style.' school in '.$locationDetail[0]->city.' | '.$metaVaribles[0]->meta_school_name. ' '.$locationDetail[0]->name;
						
						//$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : $title;
						$image_name = '';
						
						
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){

			$this->load->library('image_lib');

			$config['upload_path'] = 'upload/about_us/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('userfile')){
				$image_data = $this->upload->data();
				$img['photo'] = $image_data['file_name'];
			}

			$resize_config['source_image'] = 'upload/about_us/'.$img['photo'];
			$get_size = getimagesize($resize_config['source_image']);

			$image_info = array(
				'width' => $get_size[0],
				'height' => $get_size[1]
			);

			$resize_config['create_thumb'] = FALSE;

			$resize_config['new_image'] = 'upload/about_us/thumb/'.$img['photo'];
			
			//echo '<pre>'; print_r($image_info); echo '</pre>';
		

			if($image_info['width']  >= 130){				
				$new_width = 130;
				$new_height = round((130/$image_info['width'])*$image_info['height']);				
				
				$resize_config['width'] = $new_width;
				$resize_config['height'] = $new_height;
				$this->image_lib->initialize($resize_config);
				$this->image_lib->resize();	
			}
			
			
			$image_name = $img['photo']; 
									
		}
					
						
						//echo '<pre>'; print_r('sadfdsa'); die;
						
						$datas = array("title" => $title,'photo' => $image_name, 'content' => $content,'sub_title' =>$sub_title,'location_id' => $location_id, 'video_type'=> $video_type,'youtube_video'=> $youtube_video,'vimeo_video'=> $vimeo_video,'image_video'=>$image_video,'image_alt'=>$image_alt,'meta_title'=>$meta_title,'video_section' => $video_section);	// vinay 01/12
						$this->query_model->insertData('tblaboutourschool', $datas);
						redirect('admin/about/ourschool/multilocation/'.$_POST['location_id']);
					}
				}
				
				$this->load->view("admin/our_school_multi", $data);
					
			}
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
	
	/** vinay 18/11 **/
	public function deleteAboutImg(){
		
		
		if(count($_POST)>0){			
						
			$id = $_POST['id'];
			$photo = $_POST['photo'];
			$this->db->where("id", $id);
			
			if($photo == 'right_photo'){
				$query = $this->db->query("update tblaboutheader set right_photo='' where id=".$id."");
			}else {
				$query = $this->db->query("update tblaboutheader set left_photo='' where id=".$id."");
			}
			if($query)
			{	
				$dir=pathinfo(BASEPATH);
				//echo $dir; die;
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
	
	
	//**
	//	@delete About Image for Multiple Location
	//
	//**
	
	public function deleteAboutImgMultiLocation(){
		
		
		if(count($_POST)>0){			
						
			$location_id = $_POST['location_id'];
			$photo = $_POST['photo'];
			$this->db->where("location_id", $location_id);
			
			if($photo == 'right_photo'){
				$query = $this->db->query("update tblaboutheader set right_photo='' where location_id=".$location_id."");
			}else {
				$query = $this->db->query("update tblaboutheader set left_photo='' where location_id=".$location_id."");
			}
			if($query)
			{	
				$dir=pathinfo(BASEPATH);
				//echo $dir; die;
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
	
	
	
	public function deleteAboutTheATAImage(){
		
		
		if(count($_POST)>0){			
						
			$location_id = $_POST['location_id'];
			$photo = $_POST['photo'];
			$this->db->where("location_id", $location_id);
			
			if($photo == 'right_photo'){
				$query = $this->db->query("update tbl_about_the_ata set right_photo='' where location_id=".$location_id."");
			}else {
				$query = $this->db->query("update tbl_about_the_ata set left_photo='' where location_id=".$location_id."");
			}
			if($query)
			{	
				/*$dir=pathinfo(BASEPATH);
				//echo $dir; die;
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);	*/				
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
	
	
	
	public function facility(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(empty($is_logged_in) && $is_logged_in == true){
			redirect('admin/login');
		}
		$data = array();
		
		$this->load->model('facility_model');
		$IsAllowMultiFacility = $this->facility_model->IsAllowMultiFacility();
		$data['IsAllowMultiFacility'] = $IsAllowMultiFacility;
		
		if($IsAllowMultiFacility){
			
			$data['facilities'] = $this->facility_model->getAllFacilities();
			
			$data['title'] = "Facility";
			
			$data['has_main'] = $this->facility_model->hasMainfacility();
			
			$this->load->view("admin/facilities", $data);
			
		}else{
			
			$data['id'] = '';
			$data['title'] = '';
			$data['content'] = '';
			$data['location_id'] = '';
			$data['is_main'] = '1';
			
			$data['meta_title'] = '';
			$data['meta_desc'] = '';
			
			$data['media'] = '';
			$data['count_media'] = 0;
				
			$facility = $this->facility_model->getMainFacility();
			
			if($facility){
			
				$data['id'] = $facility->id;
				$data['title'] = $facility->title;
				$data['content'] = $facility->content;
				$data['location_id'] = $facility->location_id;
				$data['meta_title'] = $facility->meta_title;		
				$data['meta_desc'] = $facility->meta_desc;				
				
				if($facility->id){
					$data['media'] = $this->db->query("Select * from `tblaboutfacilityphoto` where facility_id = ".$facility->id." order by pos ASC")->result();
					$data['count_media']= count($data['media']);				
				}
				
				$data['max_upload_media_limit']= 12-$data['count_media'];	
				
			}			
			
			$this->load->view("admin/facility", $data);
		}		
	}
	
	public function addfacility(){
		
		$data['id'] = '';
		$data['title'] = '';
		$data['content'] = '';
		$data['meta_title'] = '';
		$data['meta_desc'] = '';
		$data['is_main'] = '0';
		//$data['location_id'] = 0;
		
		$data['media'] = '';
		$data['count_media'] = 0;
		
		$this->load->model('facility_model');
		$this->load->helper('form');
		
		$IsAllowMultiFacility = $this->facility_model->IsAllowMultiFacility();
		$data['IsAllowMultiFacility'] = $IsAllowMultiFacility;		
		
		/*$blank_location = array('0' => 'Select Location');
		$locations = $this->facility_model->getLocations();
		
		$data['locations'] = $blank_location + $locations;		*/
			
		if($facility_id = $this->uri->segment(4)){
			
			$facility = $this->facility_model->getFacilityById($facility_id);
			
			$data['id'] = $facility->id;
			$data['title'] = $facility->title;
			$data['content'] = $facility->content;
			$data['meta_title'] = $facility->meta_title;
			$data['meta_desc'] = $facility->meta_desc;
			$data['is_main'] = $facility->main_facility;
			$data['location_id'] = $facility->location_id;
			
			if($facility_id){
				$data['media'] = $this->db->query("Select * from `tblaboutfacilityphoto` where facility_id = ".$facility->id." order by pos ASC")->result();
				$data['count_media']= count($data['media']);				
			}
			$data['max_upload_media_limit']= 12-$data['count_media'];		
		}
		
		$this->load->view("admin/facility", $data);
	}
	
	function addMainFacility(){
		
		$data['id'] = '';
		$data['title'] = '';
		$data['content'] = '';
		$data['meta_title'] = '';
		$data['meta_desc'] = '';
		$data['is_main'] = '1';
		$data['location_id'] = 0;
		
		$data['media'] = '';
		$data['count_media'] = 0;
		
		//$this->load->model('facility_model');
		//$this->load->helper('form');
		
		$this->load->view("admin/facility", $data);
	}
	
	public function updateFacility(){
		
		$this->load->model('facility_model');
		//echo '<pre>'; print_r($_POST); echo '</pre>';
		//exit;
		$result = $this->facility_model->updateFacility();
		
		redirect("admin/about/facility");
	}
	
	public function publishfacility(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tblfacilities", array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	public function aboutus(){		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$this->db->where("id", 2);
		$data['title'] = 'Pages';
		$data['pagedetails'] = $this->db->get("tblpages")->result();
		$this->load->view("admin/page_edit", $data);
		
		if(isset($_POST['update'])):
		
		$title = rtrim(ltrim($_POST['title']));
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
			
		$data = array("title" => $title, "content" => $content);
			$this->query_model->update("tblpages", 2, $data);
			redirect("admin/home/aboutus");
		endif;
		}else
		{
			redirect('admin/login');
		}
	}
	
		
	public function philosophy(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$this->db->where("id", 7);
		$data['title'] = 'Pages';
		$data['pagedetails'] = $this->db->get("tblpages")->result();
		$this->load->view("admin/page_edit", $data);
		
		if(isset($_POST['update'])):
		
		$title = rtrim(ltrim($_POST['title']));
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
				
		$data = array("title" => $title, "content" => $content);
			$this->query_model->update("tblpages", 7, $data);
			redirect("admin/about/philosophy");
		endif;
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function ourstaff(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$this->db->where("id", 6);
		$data['title'] = 'Pages';
		$data['link_type'] = 'Pages';
		$data['pagedetails'] = $this->db->get("tblpages")->result();
		$this->load->view("admin/staff", $data);
		
		if(isset($_POST['update'])):
		
		$title = rtrim(ltrim($_POST['title']));
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
				
		$data = array("title" => $title, "content" => $content);
			$this->query_model->update("tblpages", 6, $data);
			redirect("admin/about/ourstaff");
		endif;
		}else
		{
			redirect('admin/login');
		}
	}


	public function deletemedia(){
		if(array_key_exists('delete-item-id', $_POST) && $_POST['delete-item-id']!=''){
			$id = $_POST['delete-item-id'];
			$this->db->where("id", $id);
			$link = $this->db->get("tblaboutfacilityphoto");
			$row = $link->row_array(); 
			$temp = $row['photo'];
			$temp_thumb = $row['link_thumbnail'];
			$this->db->where("id", $id);
			if($this->db->delete("tblaboutfacilityphoto"))
			{	
				$umask=umask(0);
				if(file_exists(dirname($_SERVER['SCRIPT_FILENAME']).'/'.rawurldecode($temp))){
					unlink(dirname($_SERVER['SCRIPT_FILENAME']).'/'.rawurldecode($temp));
				}
				if(file_exists(dirname($_SERVER['SCRIPT_FILENAME']).'/'.rawurldecode($temp_thumb))){	
					unlink(dirname($_SERVER['SCRIPT_FILENAME']).'/'.rawurldecode($temp_thumb));
				}					
				umask($umask);				
				redirect("admin/about/facility");
			}
			else
			{
			echo "<script language='javascript'>alert('Unable to delete photo');</script>";
				redirect("admin/about/facility");
			}
		}	
		else{
			redirect("admin/about/facility");
		}
	}
	
	public function operateMedia(){
		
		if(array_key_exists('edit_id',$_POST) && $_POST['edit_id']!=''){
			$edit_id = $_POST['edit_id'];
			$media_desc = $_POST['media_desc'];
			$redirection = $_POST['redirection'];
			//echo $edit_id." ".$media_desc." ".$album." ".$album_cover." ".$cover_link;
			$success = 0;		
			$args = array( "desc" => $media_desc );
					
			if($this->query_model->update("tblaboutfacilityphoto", $edit_id, $args)):
				$success++;
			endif;
			
			if($success>0):
				redirect($redirection);
			endif;
		}else{
			redirect("admin/about/facility");
		}		
	}
	
	public function sortthis(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tblaboutfacilityphoto` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	
	
	public function about_header(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		
		$my_mainLocation = $this->query_model->getMainLocation();
		$my_mainLocation = $my_mainLocation[0]->id;
		$metaVaribles = $this->query_model->getbyTable("tblmetavariable");
		
		$this->db->where("published", 1);
		$this->db->where("id !=", $this->uri->segment(5));
		$this->db->select(array('id','name'));
		$this->db->order_by("pos","asc");
		$records['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$this->db->where('id',1);
		$records['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		$this->db->where('id',2);
		$records['multiAbout'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		
		if($this->uri->segment(5) == ''){
			$records['title'] = 'About Header';
			$this->db->where("location_id", $my_mainLocation);
			$records['pagedetails'] = $this->db->get("tblaboutheader")->result();
			$this->db->where("id", $my_mainLocation);
			$locationDetail = $this->db->get("tblcontact")->result();
			
			$records['site_setting'] = $this->query_model->getbyTable('tblsite');
			$records['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			
			//echo '<pre>records'; print_r($records); die;
			
					
			if(isset($_POST['update'])):
				unset($data['pagedetails']);
				$data['title'] = $this->input->post('title');
				$data['background_color'] = $this->input->post('background_color'); 
				$data['body_id'] = isset($_POST['body_id']) ? $_POST['body_id'] : '';
				
				$data['meta_title'] = !empty($_POST['meta_title']) ? $_POST['meta_title'] : 'About Us | '.$metaVaribles[0]->meta_main_martial_arts_style.' school in '.$locationDetail[0]->city.' | '.$metaVaribles[0]->meta_school_name. ' '.$locationDetail[0]->name;
				
				if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){
	
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/about_header/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('left_photo')){
					$image_data = $this->upload->data();
					$data['left_photo'] = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/about_header/'.$data['left_photo'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/about_header/thumb/'.$data['left_photo'];
				
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
				$this->query_model->tinyImageCampressAndResize('upload/about_header/'.$data['left_photo']);
				
				$this->query_model->tinyImageCampressAndResize('upload/about_header/thumb/'.$data['left_photo']);
										
			}
			
			/*
			if(isset($_FILES['right_photo']['name']) && !empty($_FILES['right_photo']['name'])){
	
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/about_header/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('right_photo')){
					$image_data = $this->upload->data();
					$data['right_photo'] = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/about_header/'.$data['right_photo'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/about_header/thumb/'.$data['right_photo'];
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
										
			}*/
			
			$this->query_model->updateData('tblaboutheader','location_id',$my_mainLocation, $data);
			//$this->query_model->update('tblaboutheader', $mainLocation, $data);
			
				redirect("admin/about/about_header");
			endif;
			
			
			$this->load->view("admin/about_header", $records);
			
			} 
			
			/***** Multiple Location *****/
			else{
			
				
			$records['title'] = 'About Header';
			$this->db->where("location_id", $this->uri->segment(5));
			$records['pagedetails'] = $this->db->get("tblaboutheader")->result();
			//$records['site_setting'] = $this->query_model->getbyTable('tblsite');
			$records['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			$records['location_id'] = $this->uri->segment(5);
			
			$this->db->where("id", $this->uri->segment(5));
			$locationDetail = $this->db->get("tblcontact")->result();
			//echo '<pre>'; print_r($data['pagedetails']); die;
			//echo '<pre>records2'; print_r($records); die;
			
					
			if(isset($_POST['update'])):
				// update query
				//echo '<pre>'; print_r($_POST); die;
				if(!empty($records['pagedetails'])){
				//echo '<pre>'; print_r($_FILES); die;
						unset($records['pagedetails']);
						//echo '<pre>'; print_r($_POST); die;
						$data['title'] = $this->input->post('title'); 
						$data['background_color'] = $this->input->post('background_color'); 
						$data['override_logo'] = $this->input->post('override_logo'); 
						$data['body_id'] = isset($_POST['body_id']) ? $_POST['body_id'] : ''; 
						
						$data['meta_title'] = !empty($_POST['meta_title']) ? $_POST['meta_title'] : 'About Us | '.$metaVaribles[0]->meta_main_martial_arts_style.' school in '.$locationDetail[0]->city.' | '.$metaVaribles[0]->meta_school_name. ' '.$locationDetail[0]->name;
						
						if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/about_header/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('left_photo')){
							$image_data = $this->upload->data();
							$data['left_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_header/'.$data['left_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_header/thumb/'.$data['left_photo'];
						
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
						$this->query_model->tinyImageCampressAndResize('upload/about_header/'.$data['left_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/about_header/thumb/'.$data['left_photo']);
							
										
					}
					
					
					/*if(isset($_FILES['right_photo']['name']) && !empty($_FILES['right_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/about_header/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('right_photo')){
							$image_data = $this->upload->data();
							$data['right_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_header/'.$data['right_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_header/thumb/'.$data['right_photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
											
					}*/
					
				//	echo '<pre>'; print_r($data); die;
					$this->query_model->updateData('tblaboutheader','location_id',$this->uri->segment(5), $data);
					redirect('admin/about/about_header/multilocation/'.$_POST['location_id']);
					
				} 
				
				// insert query
				else {
					//echo 'hello'; die;
					unset($records['pagedetails']);
						$data['title'] = $this->input->post('title'); 
						$data['background_color'] = $this->input->post('background_color'); 
						$data['location_id'] = $this->input->post('location_id');
						$data['override_logo'] = $this->input->post('override_logo'); 
						$data['body_id'] = isset($_POST['body_id']) ? $_POST['body_id'] : '';
						if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/about_header/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('left_photo')){
							$image_data = $this->upload->data();
							$data['left_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_header/'.$data['left_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_header/thumb/'.$data['left_photo'];
						
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
						$this->query_model->tinyImageCampressAndResize('upload/about_header/'.$data['left_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/about_header/thumb/'.$data['left_photo']);
							
																	
					}
					
					/*
					if(isset($_FILES['right_photo']['name']) && !empty($_FILES['right_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/about_header/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('right_photo')){
							$image_data = $this->upload->data();
							$data['right_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_header/'.$data['right_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_header/thumb/'.$data['right_photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
												
					}*/
					
					$this->query_model->insertData('tblaboutheader', $data);
					
						redirect("admin/about/about_header/multilocation/".$_POST['location_id']);
					
				}
				
				
				endif;
				
				$this->load->view("admin/about_header_multi", $records);
			
			}
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function about_the_ata(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		
		
		$my_mainLocation = $this->query_model->getMainLocation();
		$my_mainLocation = $my_mainLocation[0]->id;
		
		
			
				
			$records['title'] = 'About The ATA';
			$this->db->where("location_id", $this->uri->segment(5));
			$records['pagedetails'] = $this->db->get("tbl_about_the_ata")->result();
			//$records['site_setting'] = $this->query_model->getbyTable('tblsite');
			$records['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			$records['location_id'] = $this->uri->segment(5);
			//echo '<pre>'; print_r($records); die;
			
					
			if(isset($_POST['update'])):
				// update query
				//echo '<pre>'; print_r($_POST); die;
				if(!empty($records['pagedetails'])){
				//echo '<pre>'; print_r($_FILES); die;
						unset($records['pagedetails']);
						//echo '<pre>'; print_r($_POST); die;
						
						$data['background_color'] = $this->input->post('background_color'); 
						//$data['override_logo'] = $this->input->post('override_logo'); 
						$data['title'] = $this->input->post('title'); 
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
						 
						
						if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/about_the_ata/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('left_photo')){
							$image_data = $this->upload->data();
							$data['left_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_the_ata/'.$data['left_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_the_ata/thumb/'.$data['left_photo'];
						
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
						$this->query_model->tinyImageCampressAndResize('upload/about_the_ata/'.$data['left_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/about_the_ata/thumb/'.$data['left_photo']);
										
					}
					
					
				//	echo '<pre>'; print_r($data); die;
					$this->query_model->updateData('tbl_about_the_ata','location_id',$this->uri->segment(5), $data);
					redirect('admin/about/about_the_ata/multilocation/'.$_POST['location_id']);
					
				} 
				
				// insert query
				else {
					//echo 'hello'; die;
					unset($records['pagedetails']);
						$data['background_color'] = $this->input->post('background_color'); 
						$data['location_id'] = $this->input->post('location_id');
						//$data['override_logo'] = $this->input->post('override_logo'); 
						$data['title'] = $this->input->post('title'); 
						$data['box_1_text'] = $this->input->post('box_1_text'); 
						$data['box_2_text'] = $this->input->post('box_2_text'); 
						$data['box_3_text'] = $this->input->post('box_3_text'); 
						$data['full_box_title'] = isset($_POST['full_box_title']) ? $_POST['full_box_title'] : '';  
						$data['show_timeline'] = isset($_POST['show_timeline']) ? $_POST['show_timeline'] : 0;  
						
						$data['full_box_1_text'] = $this->input->post('full_box_1_text'); 
						$data['full_box_2_text'] = $this->input->post('full_box_2_text'); 
						$data['full_box_3_text'] = $this->input->post('full_box_3_text');
						$data['description'] = $this->input->post('description'); 
						
						if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/about_the_ata/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('left_photo')){
							$image_data = $this->upload->data();
							$data['left_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_the_ata/'.$data['left_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_the_ata/thumb/'.$data['left_photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
												
					}
					
				
					
					$this->query_model->insertData('tbl_about_the_ata', $data);
					
						redirect("admin/about/about_the_ata/multilocation/".$_POST['location_id']);
					
				}
				
				
				endif;
			
			$this->load->view("admin/about_the_ata_multi", $records);
		
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function about_us(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		
		$my_mainLocation = $this->query_model->getMainLocation();
		$my_mainLocation = $my_mainLocation[0]->id;
		
				
			$records['title'] = 'About Us';
			$records['link_type'] = 'about';
			$this->db->where("location_id", $this->uri->segment(5));
			$records['pagedetails'] = $this->db->get("tbl_about_us")->result();
			//$records['site_setting'] = $this->query_model->getbyTable('tblsite');
			//$records['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			$records['location_id'] = $this->uri->segment(5);
			
			$this->db->order_by("pos", 'asc');
			$this->db->select(array('id','location_id','title','photo_side','published'));
			$this->db->where("location_id", $this->uri->segment(5));
			$records['aboutUsRows'] = $this->query_model->getbyTable('tbl_aboutus_rows');
			//echo '<pre>records'; print_r($records); die;
			
					
			if(isset($_POST['update'])):
			//echo '<pre>_POST'; print_r($_POST); die;
				// update query
				if(!empty($records['pagedetails'])){
						unset($records['pagedetails']);
						
						$data['title'] = $this->input->post('title'); 
						$data['sub_title'] = $this->input->post('sub_title');						
						$data['description'] = $this->input->post('description'); 
						$data['location_id'] = $this->input->post('location_id'); 
						$data['img_top_spacing'] = isset($_POST['img_top_spacing']) ? $_POST['img_top_spacing'] : ''; 
						$data['photo_alt_text'] = isset($_POST['photo_alt_text']) ? $_POST['photo_alt_text'] : ''; 
						 
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/about_us/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_us/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_us/thumb/'.$data['photo'];
						
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
						$this->query_model->tinyImageCampressAndResize('upload/about_us/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/about_us/thumb/'.$data['photo']);				
					}
					
					
				//	echo '<pre>'; print_r($data); die;
					$this->query_model->updateData('tbl_about_us','location_id',$this->uri->segment(5), $data);
					redirect('admin/about/about_us/multilocation/'.$_POST['location_id']);
					
				} 
				
				// insert query
				else {
					//echo 'hello'; die;
					unset($records['pagedetails']);
						$data['title'] = $this->input->post('title'); 
						$data['sub_title'] = $this->input->post('sub_title');						
						$data['description'] = $this->input->post('description'); 
						$data['location_id'] = $this->input->post('location_id'); 
						$data['img_top_spacing'] = isset($_POST['img_top_spacing']) ? $_POST['img_top_spacing'] : ''; 
						$data['photo_alt_text'] = isset($_POST['photo_alt_text']) ? $_POST['photo_alt_text'] : ''; 
						 
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/about_us/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_us/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_us/thumb/'.$data['photo'];
						
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
						$this->query_model->tinyImageCampressAndResize('upload/about_us/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/about_us/thumb/'.$data['photo']);	
						
					}
					
				
					
					$this->query_model->insertData('tbl_about_us', $data);
					
						redirect("admin/about/about_us/multilocation/".$_POST['location_id']);
					
				}
				
				
				endif;
			
			$this->load->view("admin/about_us_multi", $records);
		
		
		}else
		{
			redirect('admin/login');
		}
		
	}
	
	
	public function delete_about_us_image(){
		
		
		if(count($_POST)>0){			
						
			$id = $_POST['id'];
			$query = $this->db->query("update tbl_about_us set photo='' where id=".$id."");
			echo 1;
		}else{
				echo 0;
		}
	
	}
	
	
	
	
	public function deleteAboutUsRowImage(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['id'];
			$query = $this->db->query("update tbl_aboutus_rows set photo='' where id=".$id."");
			echo 1;
		}else{
				echo 0;
		}
	
	}
	
	
	
	public function add_aboutus_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				
			$records['title'] = 'Add About Us Row';
			$records['link_type'] = 'about';
			
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
			
						$config['upload_path'] = 'upload/about_us/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_us/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_us/thumb/'.$data['photo'];
						
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
						$this->query_model->tinyImageCampressAndResize('upload/about_us/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/about_us/thumb/'.$data['photo']);
												
					}
					
				
					
					$this->query_model->insertData('tbl_aboutus_rows', $data);
					
						redirect("admin/about/about_us/multilocation/".$_POST['location_id']);
						
				//echo '<pre>'; print_r($_POST); die;
				//echo '<pre>'; print_r($_POST); die;
			}
		
			$this->load->view("admin/add_aboutus_row", $records);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
		
	public function edit_aboutus_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Add About Us Row';
			$records['link_type'] = 'about';
			
			
			$this->db->where("id", $this->uri->segment(4));
			$records['pagedetails'] = $this->query_model->getbyTable('tbl_aboutus_rows');
			
			
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
			
						$config['upload_path'] = 'upload/about_us/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/about_us/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/about_us/thumb/'.$data['photo'];
						
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
						$this->query_model->tinyImageCampressAndResize('upload/about_us/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/about_us/thumb/'.$data['photo']);						
					}
					
				
					$this->query_model->updateData('tbl_aboutus_rows','id',$this->uri->segment(4), $data);
					
					//$this->query_model->insertData('tbl_aboutus_rows', $data);
					
						redirect("admin/about/about_us/multilocation/".$_POST['location_id']);
						
				//echo '<pre>'; print_r($_POST); die;
			}
		
			
			$this->load->view("admin/edit_aboutus_row", $records);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function delete_aboutus_row(){
		
		$id = $_POST['delete-item-id'];
			$this->db->where("id", $id);
			if($this->db->delete("tbl_aboutus_rows"))
			{
				redirect("admin/about/about_us/multilocation/".$_POST['location-id']);
			}
			else
			{
				redirect("admin/about/about_us/multilocation/".$_POST['location-id']);
			}
	}
	
	
	
	public function sortAboutusRows(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_aboutus_rows` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'   AND `location_id`='" . $this->uri->segment(4) . "'  ") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	public function publishAboutusRows(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tbl_aboutus_rows", array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	
	public function duplicate_location_data(){
		$locationDataArr = array();
		
		if(isset($_POST['update'])){
			if(isset($_POST['duplicate_data_location_id']) && $_POST['location_id']){
				$duplicate_location_id = !empty($_POST['duplicate_data_location_id']) ? $_POST['duplicate_data_location_id'] : '';
				$location_id = !empty($_POST['location_id']) ? $_POST['location_id'] : '';
				
				if(!empty($duplicate_location_id) && !empty($location_id)){
					
					$social_feed_data = $this->query_model->getbyTable("tblconfigcalendar");
					$social_feed_data = $social_feed_data[9]->field_value;
					if($social_feed_data == 0){
						$social_feed_location_id = $this->query_model->getMainLocation("tblcontact");
						$social_feed_location_id = $social_feed_location_id[0]->id;
					}else{
						$social_feed_location_id = $duplicate_location_id;
					}
					
					$this->db->where("location_id", $duplicate_location_id);
					$locationDataArr['tblaboutheader'] = $this->query_model->getbyTable("tblaboutheader");
					
					$this->db->where("location_id", $duplicate_location_id);
					$locationDataArr['tbl_about_the_ata'] = $this->query_model->getbyTable("tbl_about_the_ata");
					
					$this->db->where("location_id", $duplicate_location_id);
					$locationDataArr['tbl_about_us'] = $this->query_model->getbyTable("tbl_about_us");
					
					$this->db->where("location_id", $duplicate_location_id);
					$locationDataArr['tbl_about_email_options'] = $this->query_model->getbyTable("tbl_about_email_options");
					
					$this->db->order_by("pos","asc");
					$this->db->where("location_id", $duplicate_location_id);
					$locationDataArr['tbl_aboutus_rows'] = $this->query_model->getbyTable("tbl_aboutus_rows");
					
					$multiConfigData = $this->query_model->getbyTable("tblconfigcalendar");
					$locationDataArr['tblstaff'] = array();
					if($multiConfigData[2]->field_value == 1){
						$this->db->order_by("pos","asc");
						$this->db->where("location_id", $duplicate_location_id);
						$locationDataArr['tblstaff'] = $this->query_model->getbyTable("tblstaff"); 
					}
					
					
					$this->db->where("location_id", $duplicate_location_id);
					$locationDataArr['tblaboutourschool'] = $this->query_model->getbyTable("tblaboutourschool");
					
					$this->db->where("location_id", $duplicate_location_id);
					$locationDataArr['tblseo'] = $this->db->get("tblseo")->row_array();
					
					$locationDataArr['tblapikey'] = $this->query_model->getbySpecific('tblapikey','location_id', $social_feed_location_id);
		
					//echo '<pre>locationDataArr'; print_r($locationDataArr); die;
					
					if(!empty($locationDataArr)){
						foreach($locationDataArr as $table_name => $location_data){
							$this->db->where("location_id", $location_id);
							$this->db->delete($table_name);
				
							if(!empty($location_data)){
								foreach($location_data as $data){
									
									$insertData = array();
									if(!empty($data)){
										foreach($data as $key => $val){
											if($key == "location_id"){
												$insertData[$key] = $location_id;
											}elseif($key == 'id'){
												unset($insertData[$key]);
											}else{
												$insertData[$key] = $val;
											}
										}
										
										if(!empty($insertData)){
											$this->query_model->insertData($table_name, $insertData);
										}
									}
								}
							}
						}
					}
					
					redirect('admin/about/about_header/multilocation/'.$location_id);
					
				}
				
			}
		}
		
		
		
	}
	
	
}
