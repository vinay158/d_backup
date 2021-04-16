<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Classschedule extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		//$this->load->model("customcss_model");
		
	}
	
	public function index(){
		
	$datas['user_level']=$this->session->userdata['user_level'];
	$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
		$datas['title'] = "Class Schedules";
		
		$datas['class_schedules'] = $this->query_model->getbyTable('tblclassschedule');
		
		$this->db->select(array('class_schedule_button'));
		$datas['site_setting'] = $this->query_model->getbyTable('tblsite');
		//echo '<pre>datas'; print_r($datas); die;
		
		if(isset($_POST['data'])){
		
			$this->query_model->deletebySpecific('tblclassschedule','class_schedule_id', 1);
			$i = 1;
			foreach($_POST['data'] as $standPage){
				$data['button_name'] = $standPage['button_name'];
				$data['class_schedule_id'] = 1;
				//$data['published'] = $_POST['published'];
				if(isset($standPage['last_stand_photo'])){
					$data['files'] = $standPage['last_stand_photo'];
				}
				$image_name = 'stand_page_photo'.$i;
				
				if(isset($_FILES[$image_name]['name']) && !empty($_FILES[$image_name]['name'])){
				$_FILES[$image_name]['name'] = time().$_FILES[$image_name]['name'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/class_schedule/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload($image_name)){
					$image_data = $this->upload->data();
					$data['files'] = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/class_schedule/'.$data['files'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/class_schedule/thumb/'.$data['files'];
				
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
		
			}
			
				$this->query_model->insertData('tblclassschedule', $data);
				$i++;
			}
			
			redirect('admin/classschedule');
			
		}
		
		$this->load->view("admin/class_schedule", $datas);
		
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function delete_classs_chedule(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['id'];
			$this->db->where("id", $id);
			
			if($this->db->query("delete from tblclassschedule where id=".$id.""))
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
	
	
	
	public function delete_class_schedule_img(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblclassschedule set files = 'Null' where id=".$id.""))
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
	
	public function save_class_schedule_button(){
			$publish = $_POST['publish'];
			$sql = "Update tblsite Set class_schedule_button = '".$publish."'";
			$this->db->query($sql);	
			echo '1'; die;
	}
	
}