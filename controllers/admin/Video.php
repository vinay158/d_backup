<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('video_model');
	}
	
	public function index()
	{
		
		redirect('admin/video/view');
	}
	
	
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {

			$this->db->query("UPDATE `tblvideo` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Videos';
			$data['link_type'] = 'video';
			$my_mainLocation = $this->query_model->getMainLocation();
			$my_mainLocation = $my_mainLocation[0]->id;
			$data['video'] = $this->query_model->getbySpecific("tblvideo", 'location_id',$my_mainLocation);
			$this->load->view("admin/video", $data);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	public function edit(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$this->load->helper('form');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if($this->uri->segment(4) != NULL){
				
				$data['title'] = 'Video';
				$data['details'] = $this->query_model->getbyId('tblvideo',$this->uri->segment(4));
				
				$this->load->view("admin/video_edit", $data);
				
				if(isset($_POST['update'])):
					$this->video_model->updateVideo();
				endif;
			}else{ 
				redirect("admin/video");
			}
		}else{ 
			redirect("admin/login");
		}
	}
	
	public function add(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$this->load->helper('form');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			$data['title'] = "Video";
			
			$data['location_id'] = $this->uri->segment(5);
			
				
			if(isset($_POST['update'])):
						$this->video_model->addVideo();
			endif;
			
			$this->load->view("admin/video_add", $data);	
		}else{
			redirect('admin/login');
		}
	
	}
	public function deleteitem(){
	
	
	$id = $this->uri->segment(4);
	$location_id = $this->uri->segment(6);
	//echo $location_id; die;
	$this->db->where("id", $id);
	if($this->db->delete("tblvideo"))
	{
		if($location_id != ''){
			redirect('admin/video/multilocation/'.$location_id);
		} else {
			redirect($this->index());
		}
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete video');</script>";
			if($location_id != ''){
				redirect('admin/video/multilocation/'.$location_id);
			} else {
				redirect($this->index());
			}
	
		}
	}
	
	
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		$location_id = $_POST['location_id'];
		if($location_id != ''){
			$this->db->where('location_id',$location_id);
			$publisedVideo = $this->query_model->getbySpecific('tblvideo', 'published',1);
			//echo '<pre>'; print_r($publisedVideo); die;
		} else{
			$this->db->where('location_id',NULL);
			$publisedVideo = $this->query_model->getbySpecific('tblvideo', 'published',1);
			//echo '<pre>'; print_r($publisedVideo); die;
		}
		
		if(count($publisedVideo) == 0 || $pub == 0){
			$this->db->where("id", $id);
			if($this->db->update("tblvideo", array("published" => $pub)))
			{	
				echo 1;
				
			}
		} else{
			echo 0;
		}
		exit;
		}
	
	
	// *** multi location ***/
	
	public function multilocation(){
			$is_logged_in = $this->session->userdata('is_logged_in');
		
				if(!empty($is_logged_in) && $is_logged_in == true)
				{
					$data['title'] = 'Videos';
					$data['link_type'] = 'video';
					$data['details'] = $this->query_model->getbySpecific("tblvideo", 'location_id',$this->uri->segment(4));
					//echo '<pre>'; print_r($data['video']); die;
						$this->load->view("admin/video", $data);
						
						if(isset($_POST['update'])):
							if(empty($data['details'])){
								$this->video_model->addVideo();
							} else {
								$this->video_model->updateVideo();
							} 
						endif;
					
				}else
				{
					redirect('admin/login');
				}
	}
	
	
}