<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
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
		redirect('admin/home/featuredprograms');
	}
	
	public function featuredprograms(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$this->db->where("id", 1);
		$data['title'] = 'Pages';
		$data['pagedetails'] = $this->db->get("tblpages")->result();
		$this->load->view("admin/page_edit", $data);
		
		if(isset($_POST['update'])):
		
		$title = trim($_POST['title']);
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
				
		$data = array("title" => $title, "content" => $content);
			$this->query_model->update("tblpages", 1, $data);
			redirect("admin/home");
		endif;
		}else
		{
			redirect('admin/login');
		}
	}
	
		
	public function facility(){		
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$this->db->where("id", 2);
		$data['title'] = 'Home Tabs';
		$data['pagedetails'] = $this->db->get("tbltab")->result();
		$this->load->view("admin/tab_edit", $data);
		
		if(isset($_POST['update'])):
			$this->blog_model->editTab(2, "facility");
		endif;
		}else
		{
			redirect('admin/login');
		}
	}
	
	public function social(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = "Social Plugin"; 
		$data['social'] = $this->query_model->getbyTable("tblcode");
		$this->load->view("admin/social", $data);
		if(isset($_POST['update'])):
			
			if($this->query_model->update("tblcode", 1, array("embed" => $_POST['embed']))):
				redirect("admin/home/social");
			endif;
		endif;
		}else{
		redirect("admin/login");
		}
	}

	public function aboutus(){

		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$this->db->where("id", 1);
			$data['title'] = 'Home Tabs';
			$data['link_type'] = 'home';
			$data['pagedetails'] = $this->db->get("tbltab")->result();
			
			$this->db->order_by("pos", 'asc');
			$this->db->where('page_id',1);
			$data['homeSections'] = $this->query_model->getbyTable('tbl_homepage_sections');
			
		
			if(isset($_POST['update'])):
				$this->blog_model->editTab(1, "aboutus");
			endif;
			
			
			$this->load->view("admin/tab_edit", $data);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
	
	public function default_homepage_sections(){
		
		if($this->uri->segment(4) != ''){
			$page_id = $this->uri->segment(4);
			
			$exitRecord = $this->query_model->getbySpecific('tbl_homepage_sections', 'page_id',$page_id);
			if(!empty($exitRecord)){
				$this->db->where("page_id", $page_id);
				$this->db->delete("tbl_homepage_sections");
			}
			
			$sectionArr = array('featured_programs~1'=>'Featured Programs','welcome_text~2'=>'Welcome Text','getting_started~3'=>'Getting Started','large_video~4'=>'Large Video','advertisements~5'=>'Advertisements','testimonial_section~6'=>'Testimonials','our_locations~7'=>'Locations');
	
					if(!empty($sectionArr)){
						foreach($sectionArr as $key => $section){
							
							$sectionValue = explode('~',$key);
							
							$section_name = $sectionValue[0];
							$section_pos = $sectionValue[1];
							$sectionData['section'] = $section_name;
							$sectionData['published'] = 1;
							$sectionData['pos'] = $section_pos;
							$sectionData['page_id'] = $page_id;
							//echo '<pre>sectionData'; print_r($sectionData); die;
							$this->query_model->insertData('tbl_homepage_sections',$sectionData);
						}
					}
					
		}
		redirect('admin/home/home_page_section_sorting');
	}
	
	public function publishHomepageSection(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tbl_homepage_sections", array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	
	
	public function sortHomepageSections(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_homepage_sections` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "' AND `page_id`='1'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	

		public function video(){
		
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$this->db->where("id", 1);
			$data['title'] = 'Home Tabs';
			$data['pagedetails'] = $this->db->get("tbl_large_video")->result();
			
		
			if(isset($_POST['update'])):
				$this->blog_model->editvideo(1, "video");
			endif;
			
			$this->load->view("admin/largevideo_add", $data);
			
		}else
		{
			redirect('admin/login');
		}
	}

	public function deletebgImg(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['v_id'];
			
			if($this->db->query("update tbl_large_video set background_image='' where id=".$id.""))
			{	
				$dir=pathinfo(BASEPATH);
				echo $dir; die;
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
	
	public function gettips(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$this->db->where("id", 1);
			$data['title'] = 'Get Tips';
			$pagedetails = $this->db->get("tblgettips")->result();
			
			//echo '<pre>'; print_r($pagedetails); echo '</pre>';

			
			$data['details'] = $pagedetails[0];
			$this->load->view("admin/tips_edit", $data);
		
			if(isset($_POST['update'])):
				$this->blog_model->editTips();
				redirect('admin/home/gettips');
			endif;
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	/** vinay 18/11 **/
	public function deleteAboutImg(){
		
		//echo '<pre>'; print_r($_POST); die;
		if(count($_POST)>0){			
						
			$location_id = $_POST['location_id'];
			$this->db->where("location_id", $location_id);
			
			if($this->db->query("update tblaboutourschool set photo='' where location_id=".$location_id.""))
			{	
				$dir=pathinfo(BASEPATH);
				echo $dir; die;
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
	
	
	
	public function deleteAboutBackgroundImg(){
		
		//echo '<pre>'; print_r($_POST); die;
		if(count($_POST)>0){			
						
			
			if($this->db->query("update tbltab set background_image='' where id=1"))
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
	
	
	public function getting_started(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$records['title'] = 'Email Opt-in Only / Full Form';
			$records['link_type'] = 'about';
			$records['location_id'] = $this->uri->segment(5);
			
			$records['pagedetails'] = $this->db->get("tbl_homepage_getting_started")->result();
			$records['pagedetails'] = !empty($records['pagedetails']) ? $records['pagedetails'][0] : '';
			
			
			if(isset($_POST['update'])){
				//echo '<pre>_POST'; print_r($_POST); die;
				$postData['headline'] = !empty($_POST['headline']) ? $_POST['headline'] : '';
				$postData['title_1'] = !empty($_POST['title_1']) ? $_POST['title_1'] : '';
				$postData['desc_1'] = !empty($_POST['desc_1']) ? $_POST['desc_1'] : '';
				$postData['title_2'] = !empty($_POST['title_2']) ? $_POST['title_2'] : '';
				$postData['desc_2'] = !empty($_POST['desc_2']) ? $_POST['desc_2'] : '';
				$postData['title_3'] = !empty($_POST['title_3']) ? $_POST['title_3'] : '';
				$postData['desc_3'] = !empty($_POST['desc_3']) ? $_POST['desc_3'] : '';
				$postData['image_1_alt_text'] = !empty($_POST['image_1_alt_text']) ? $_POST['image_1_alt_text'] : '';
				$postData['image_2_alt_text'] = !empty($_POST['image_2_alt_text']) ? $_POST['image_2_alt_text'] : '';
				$postData['image_3_alt_text'] = !empty($_POST['image_3_alt_text']) ? $_POST['image_3_alt_text'] : '';
				
				
					
					
					if(isset($_FILES['image_1']['name']) && !empty($_FILES['image_1']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/welcome_text/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('image_1')){
							$image_data = $this->upload->data();
							$postData['image_1'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/welcome_text/'.$postData['image_1'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/welcome_text/thumb/'.$postData['image_1'];
						
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
						$this->query_model->tinyImageCampressAndResize('upload/welcome_text/'.$postData['image_1']);
						
						$this->query_model->tinyImageCampressAndResize('upload/welcome_text/thumb/'.$postData['image_1']);
			
					}
					
					
					
					
					if(isset($_FILES['image_2']['name']) && !empty($_FILES['image_2']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/welcome_text/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('image_2')){
							$image_data = $this->upload->data();
							$postData['image_2'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/welcome_text/'.$postData['image_2'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/welcome_text/thumb/'.$postData['image_2'];
						
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
					
					
					
					
					if(isset($_FILES['image_3']['name']) && !empty($_FILES['image_3']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/welcome_text/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('image_3')){
							$image_data = $this->upload->data();
							$postData['image_3'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/welcome_text/'.$postData['image_3'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/welcome_text/thumb/'.$postData['image_3'];
						
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
					
					
					
					
				
				if(!empty($records['pagedetails'])){
					$this->query_model->updateData('tbl_homepage_getting_started','id',1, $postData);
				}else{
					$this->query_model->insertData('tbl_homepage_getting_started', $postData);
				}
				
				redirect("admin/home/getting_started");
			}
			
			$this->load->view("admin/home_page_getting_started", $records);
			
		}else{
			redirect('admin/login');
		}
	}
	
	
	
	
	public function deleteImgTextImage(){
		
		if(count($_POST)>0){		
										
			//$id = $_POST['cat_id'];
			$type = $_POST['type'];
			$this->db->where("id", $id);
			
			if($type == 1){
				$this->db->query("update tbl_homepage_getting_started set image_1='' where id=1");
			}elseif($type == 2){
				$this->db->query("update tbl_homepage_getting_started set image_2='' where id=1");
			}elseif($type == 3){
				$this->db->query("update tbl_homepage_getting_started set image_3='' where id=1");
			}
			
			echo 1;
		}else{
				echo 0;
		}
	}
	
	public function home_page_section_sorting(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Home Tabs';
			$data['link_type'] = 'home';
			
			$this->db->order_by("pos", 'asc');
			$this->db->where('page_id',1);
			$data['homeSections'] = $this->query_model->getbyTable('tbl_homepage_sections');
			
			
			$this->load->view("admin/home_page_section_sorting", $data);
		
			
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
}