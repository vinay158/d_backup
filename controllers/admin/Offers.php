<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offers extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("offer_model");
	}
	
	public function index()
	{
	redirect("admin/offers/view");
	}
	
	public function view(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Referral Rewards ";
			$data['link_type'] = "offers";
			//$this->db->order_by("expire", "DESC"); 
			$this->db->order_by('pos asc, id desc');
			$this->db->select(array('id','name','expire','photo'));
			$data['staff'] = $this->query_model->getbyTable("tbloffers");
			//$data['mini_form_detail'] = $this->query_model->getbyId("tblsite", 1);
			//$this->db->order_by("pos", "ASC"); // 
			$this->db->order_by("id", "DESC"); // 

			// Get Referral Rewards Page title from tbl_studentpagetitle
				$this->db->where('id', 6);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
			//echo '<pre>data'; print_r($data); die;
			$this->load->view("admin/offers_index", $data);
		}
		else{
		redirect("admin/login");
		}
	}
	
	
	public function studentsection_homepage(){
			$data['title'] = "Homepage";
			$data['mini_form_detail'] = $this->query_model->getbyId("tblsite", 1);
			
			$this->db->where('published', 1);
			$data['categories'] = $this->query_model->getbySpecific("tblcategory","cat_type",'calendar');

			// Get Home Page title from tbl_studentpagetitle
				$this->db->where('id', 1);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
			
			$this->load->view("admin/studentsection_homepage", $data);
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Special Offers";
			$data['link_type'] = "offers";
				
			
			if(isset($_POST['update'])):
				$this->offer_model->addOffer();
			endif;
			
			$this->load->view("admin/offers_add", $data);
		}
		else{
			redirect("admin/login");
		}
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
	if(!empty($is_logged_in) && $is_logged_in == true){
		if($this->uri->segment(4) != NULL){
		$data['title'] = "Special Offers";
		$data['details'] = $this->query_model->getbyId("tbloffers", $this->uri->segment(4));
		
		if(isset($_POST['update'])):
				$this->offer_model->updateOffer();
			endif;
		$this->load->view("admin/offer_edit", $data);
		}else{
			redirect($this->index());
		}
	}else{
	redirect("admin/login");}
	}

	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tbloffers` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tblnews", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tbloffers"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	redirect($this->index());
	}
	}
	
	public function delete_offer_image(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['offer_id'];
			
			if($this->db->query("update tbloffers set photo = '' where id=".$id.""))
			{					
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
	
	public function delete(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['offer_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tbloffers set photo='' where id=".$id.""))
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
	
	function miniformvalues(){
		
		$homepage_referral_title 	= $this->input->post('homepage_referral_title');
		$homepage_referral_desc = $this->input->post('homepage_referral_desc');
		$homepage_referral_box = $this->input->post('homepage_referral_box');

		$show_home_recent_upload = $this->input->post('show_home_recent_upload');
		$show_home_recent_post = $this->input->post('show_home_recent_post');
		$show_home_recent_event = $this->input->post('show_home_recent_event');
		
		$event_category_type = !empty($_POST['event_category_type']) ? $_POST['event_category_type'] : 'all_categories';
		
		$event_show_categories = '';
		
		if($event_category_type == "custom_categories"){
			$event_show_categories  = !empty($_POST['event_show_categories']) ? serialize($_POST['event_show_categories']) : '';
		}

		$title 	= $this->input->post('title');
		$id 	= $this->input->post('id');
		
		$data = array(

					"homepage_referral_title"   => $homepage_referral_title,
					"homepage_referral_desc"    => $homepage_referral_desc,
					"homepage_referral_box"     => $homepage_referral_box,
					"show_home_recent_upload"	=> $show_home_recent_upload,
					"show_home_recent_post"		=> $show_home_recent_post,
					"show_home_recent_event"    => $show_home_recent_event,
					"event_category_type" 		=> $event_category_type,
					"event_show_categories" 	=> $event_show_categories,
				);

		$stu_page_data = array(
							'title'	=> $title
							);
		
		if(isset($_POST['update'])){
			$this->query_model->update("tblsite", 1, $data);

			$this->query_model->update("tbl_studentpagetitle", $id, $stu_page_data);
			
			redirect("admin/offers/studentsection_homepage");
		}
		
		
	}


	public function editStudentPageTitle(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
		
			$title 	= $this->input->post('title');
			$id 	= $this->input->post('id');
			$redirect 	= $this->input->post('redirect');
			$calender_layout = (isset($_POST['calender_layout']) && !empty($_POST['calender_layout'])) ? $_POST['calender_layout'] : 'default_calender';
			$embed_calendar_code = (isset($_POST['embed_calendar_code']) && !empty($_POST['embed_calendar_code'])) ? $_POST['embed_calendar_code'] : '';

			$data =  array(
				'title'	=> $title
				);
				
			$site_data =  array(
				'calender_layout'	=> $calender_layout,
				'embed_calendar_code'	=> $embed_calendar_code
				);
			
			if(isset($_POST['update'])){
					$this->query_model->update("tbl_studentpagetitle", $id, $data);
					$this->query_model->update("tblsite", 1, $site_data);
		
			redirect($redirect);
				}
		}else{
		redirect("admin/login");}
	}


	public function editStudentAcademyPageTitle(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
		
			$title 	= $this->input->post('title');
			$id 	= $this->input->post('id');
			$redirect 	= $this->input->post('redirect');
			
			$academy_videos = (isset($_POST['academy_videos']) && !empty($_POST['academy_videos'])) ? $_POST['academy_videos'] : 0;
			$academy_videos_desc = (isset($_POST['academy_videos_desc']) && !empty($_POST['academy_videos_desc'])) ? $_POST['academy_videos_desc'] : '';
			$is_update_academy_videos = (isset($_POST['is_update_academy_videos']) && !empty($_POST['is_update_academy_videos'])) ? $_POST['is_update_academy_videos'] : 0;
			$week_academy_id = (isset($_POST['week_academy_id']) && !empty($_POST['week_academy_id'])) ? $_POST['week_academy_id'] : 0;
			$week_academy_id = (isset($_POST['week_academy_id']) && !empty($_POST['week_academy_id'])) ? $_POST['week_academy_id'] : 0;
			$published = (isset($_POST['published']) && !empty($_POST['published'])) ? $_POST['published'] : 0;
			$pos = (isset($_POST['pos']) && !empty($_POST['pos'])) ? $_POST['pos'] : $week_academy_id;
			
			$data =  array(
				'title'	=> $title,
				'description' => $academy_videos_desc,
				'pos' => $pos,
				'published' => $published,
				);
			
			
			
			
			if(isset($_POST['update'])){
					$this->query_model->update("tbl_8_week_academy", $week_academy_id, $data);
					
					if($is_update_academy_videos == 1){
				
						$site_data =  array('academy_videos' => $academy_videos);
						
						$this->query_model->update("tblsite", 1, $site_data);
					}
					
		
			redirect($redirect);
				}
		}else{
		redirect("admin/login");}
	}



}