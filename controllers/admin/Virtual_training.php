<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Virtual_training extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		//$this->load->model("customcss_model");
		
	}
	
	public function index(){
		
	$data['user_level']=$this->session->userdata['user_level'];
	$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
		$data['title'] = "Virtual Training";
		$data['link_type'] = "virtual_training";
		
		
		$data['detail'] = $this->query_model->getbyTable("tbl_virtual_training");
		
		$this->db->order_by('pos','asc');
		$data['rows'] = $this->query_model->getbyTable("tbl_virtual_training_rows");
		//echo '<pre>data'; print_r($data); die;
			if(isset($_POST['update'])){
				
				$updateData['title'] = (isset($_POST['title']) && !empty($_POST['title'])) ? $_POST['title'] : 'Virtual Training';
				$updateData['sub_title'] = (isset($_POST['sub_title']) && !empty($_POST['sub_title'])) ? $_POST['sub_title'] : '';
				$updateData['show_zoom_logo'] = (isset($_POST['show_zoom_logo']) && !empty($_POST['show_zoom_logo'])) ? $_POST['show_zoom_logo'] : 0;
				$updateData['video_type'] = (isset($_POST['video_type']) && !empty($_POST['video_type'])) ? $_POST['video_type'] : '';
				$updateData['youtube_video'] = (isset($_POST['youtube_video']) && !empty($_POST['youtube_video'])) ? $_POST['youtube_video'] : '';
				$updateData['vimeo_video'] = (isset($_POST['vimeo_video']) && !empty($_POST['vimeo_video'])) ? $_POST['vimeo_video'] : '';
				$updateData['embed_video_text'] = (isset($_POST['embed_video_text']) && !empty($_POST['embed_video_text'])) ? $_POST['embed_video_text'] : '';
				$updateData['desc_title'] = (isset($_POST['desc_title']) && !empty($_POST['desc_title'])) ? $_POST['desc_title'] : 'Taking Virtual Classes with {school_name} is super easy!';
				$updateData['desc_short'] = (isset($_POST['desc_short']) && !empty($_POST['desc_short'])) ? $_POST['desc_short'] : " I'll have Melanie write you some text for this";
				$updateData['image_video'] = (isset($_POST['image_video']) && !empty($_POST['image_video'])) ? $_POST['image_video'] : "";
				$updateData['virtual_classes_button_url'] = (isset($_POST['virtual_classes_button_url']) && !empty($_POST['virtual_classes_button_url'])) ? $_POST['virtual_classes_button_url'] : "";
				$updateData['hide_virtual_classes_button'] = (isset($_POST['hide_virtual_classes_button']) && !empty($_POST['hide_virtual_classes_button'])) ? $_POST['hide_virtual_classes_button'] : 0;
				$updateData['without_login_virtual_training'] = (isset($_POST['without_login_virtual_training']) && !empty($_POST['without_login_virtual_training'])) ? $_POST['without_login_virtual_training'] : 0;
				
				//echo '<pre>updateData'; print_r($updateData); die;
				$video_img = isset($_POST['last-photo']) ? $_POST['last-photo'] : '';
				if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
					$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/slider_video/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('userfile')){
					$image_data = $this->upload->data();
					$video_img = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/slider_video/'.$video_img;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/slider_video/thumb/'.$video_img;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 700){				
					$new_width = 700;
					$new_height = round((700/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/slider_video/'.
				$video_img);
				
				$this->query_model->tinyImageCampressAndResize('upload/slider_video/thumb/'.$video_img);
	
		
			}
			
		$updateData['photo'] = $video_img;
	
	
				
				
				if(empty($data['detail'])){
					$this->query_model->insertData('tbl_virtual_training', $updateData);
				}else{
					$this->query_model->updateData('tbl_virtual_training', 'id',1, $updateData);
				}
				
					redirect('admin/virtual_training');
			}
		
		
			$this->load->view("admin/virtual_training_index", $data);
		}else{
			redirect('admin/login');
		}
	}
	
	
	
	public function add_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Add Row';
			$records['link_type'] = 'virtual_training';
			
			
			if(isset($_POST['update'])){
				
						
					$updateData['class_name'] = (isset($_POST['class_name']) && !empty($_POST['class_name'])) ? $_POST['class_name'] : '';
					$updateData['slug'] = slugify($updateData['class_name']);
					$updateData['ages'] = (isset($_POST['ages']) && !empty($_POST['ages'])) ? $_POST['ages'] : '';
					$updateData['video_type'] = (isset($_POST['video_type']) && !empty($_POST['video_type'])) ? $_POST['video_type'] : '';
					$updateData['youtube_video'] = (isset($_POST['youtube_video']) && !empty($_POST['youtube_video'])) ? $_POST['youtube_video'] : '';
					$updateData['vimeo_video'] = (isset($_POST['vimeo_video']) && !empty($_POST['vimeo_video'])) ? $_POST['vimeo_video'] : '';
					$updateData['embed_video_text'] = (isset($_POST['embed_video_text']) && !empty($_POST['embed_video_text'])) ? $_POST['embed_video_text'] : '';
					$updateData['instructions_title'] = (isset($_POST['instructions_title']) && !empty($_POST['instructions_title'])) ? $_POST['instructions_title'] : '';
					$updateData['instructions_description'] = (isset($_POST['instructions_description']) && !empty($_POST['instructions_description'])) ? $_POST['instructions_description'] : '';
					$updateData['live_class_embed'] = (isset($_POST['live_class_embed']) && !empty($_POST['live_class_embed'])) ? $_POST['live_class_embed'] : '';
					$updateData['zoom_metting_id'] = (isset($_POST['zoom_metting_id']) && !empty($_POST['zoom_metting_id'])) ? $_POST['zoom_metting_id'] : '';
					$updateData['created']  = date('Y-m-d H:i:s');
					$updateData['modified'] = date('Y-m-d H:i:s');
				
				
					
					$this->query_model->insertData('tbl_virtual_training_rows', $updateData);
					
					$rows_id = $this->db->insert_id();
					
					if(isset($_POST['weekDays'])){
						foreach($_POST['weekDays'] as $key => $day){
						
						$time_data['weekday'] = $key;
						$time_data['time'] = isset($day['time']) ? $day['time'] : '';
						$time_data['no_classes'] = (isset($day['no_classes']) && !empty($day['no_classes'])) ? 1 : 0;
						$time_data['rows_id'] = $rows_id;
						
						$this->query_model->insertData('tbl_virtual_training_rows_time', $time_data);
						}
					}
					
						redirect("admin/virtual_training");
						
			
			}
		
			
			$this->load->view("admin/add_virtual_training_row", $records);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
		
	public function edit_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			$records['title'] = 'Edit Row';
			$records['link_type'] = 'virtual_training';
			
			$this->db->where("id", $this->uri->segment(4));
			$pagedetails = $this->query_model->getbyTable('tbl_virtual_training_rows');
			$records['pagedetails'] = !empty($pagedetails) ? $pagedetails[0] : array();
			
			if(!empty($pagedetails)){ 
				$this->db->where("rows_id", $pagedetails[0]->id);
				$row_times = $this->query_model->getbyTable('tbl_virtual_training_rows_time');
				
				$records['row_times'] = array();
				if(!empty($row_times)){
					foreach($row_times as $key => $val){
						$records['row_times'][$val->weekday] = $val;
					}
				}
			}
			
			
			
			
			if(isset($_POST['update'])){
				
				$rows_id = $this->uri->segment(4);
				
				$updateData['class_name'] = (isset($_POST['class_name']) && !empty($_POST['class_name'])) ? $_POST['class_name'] : '';
				$updateData['slug'] = slugify($updateData['class_name']);
			
			
					$updateData['ages'] = (isset($_POST['ages']) && !empty($_POST['ages'])) ? $_POST['ages'] : '';
					$updateData['video_type'] = (isset($_POST['video_type']) && !empty($_POST['video_type'])) ? $_POST['video_type'] : '';
					$updateData['youtube_video'] = (isset($_POST['youtube_video']) && !empty($_POST['youtube_video'])) ? $_POST['youtube_video'] : '';
					$updateData['vimeo_video'] = (isset($_POST['vimeo_video']) && !empty($_POST['vimeo_video'])) ? $_POST['vimeo_video'] : '';
					$updateData['embed_video_text'] = (isset($_POST['embed_video_text']) && !empty($_POST['embed_video_text'])) ? $_POST['embed_video_text'] : '';
					$updateData['instructions_title'] = (isset($_POST['instructions_title']) && !empty($_POST['instructions_title'])) ? $_POST['instructions_title'] : '';
					$updateData['instructions_description'] = (isset($_POST['instructions_description']) && !empty($_POST['instructions_description'])) ? $_POST['instructions_description'] : '';
					$updateData['live_class_embed'] = (isset($_POST['live_class_embed']) && !empty($_POST['live_class_embed'])) ? $_POST['live_class_embed'] : '';
					$updateData['zoom_metting_id'] = (isset($_POST['zoom_metting_id']) && !empty($_POST['zoom_metting_id'])) ? $_POST['zoom_metting_id'] : '';
					//$updateData['created']  = date('Y-m-d H:i:s');
					$updateData['modified'] = date('Y-m-d H:i:s');
				
					
					
					$this->query_model->updateData('tbl_virtual_training_rows','id',$rows_id, $updateData);
					
					
					
					if(isset($_POST['weekDays'])){
				
						$this->query_model->deletebySpecific('tbl_virtual_training_rows_time','rows_id',$rows_id);
				
						foreach($_POST['weekDays'] as $key => $day){
						
						$time_data['weekday'] = $key;
						$time_data['time'] = isset($day['time']) ? $day['time'] : '';
						$time_data['no_classes'] = (isset($day['no_classes']) && !empty($day['no_classes'])) ? 1 : 0;
						$time_data['rows_id'] = $rows_id;
						
						$this->query_model->insertData('tbl_virtual_training_rows_time', $time_data);
						}
					}
					
						redirect("admin/virtual_training");
						
			}
			
			$this->load->view("admin/edit_virtual_training_row", $records);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function deleteitem(){
		
		$id = $_POST['delete-item-id'];
			$this->db->where("id", $id);
			if($this->db->delete("tbl_virtual_training_rows"))
			{
				redirect("admin/virtual_training");
			}
			else
			{
				redirect("admin/virtual_training");
			}
	}
	
	
	
	public function sortRows(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_virtual_training_rows` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'  ") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	public function publishRows(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tbl_virtual_training_rows", array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	
	public function delete_img(){
		
		if(count($_POST)>0){	
											
			$id = $_POST['record_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tbl_virtual_training set photo='' where id=".$id.""))
			{	
				$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/upload/slider_video/'.$_POST['image_name'];				
				unlink($img);	
				
				
				$imgthumb=$dir['dirname'].'/upload/slider_video/thumb/'.$_POST['image_name'];				
				unlink($imgthumb);	
				
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
	
	
	
}