<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slider extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("setting_model");
	}
	
	public function index()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "Sliders";
			$data['link_type'] = "slider";
			
			$this->db->order_by('pos asc, id desc');
			$this->db->select(array('id','image_video','published'));
			$data['slides'] = $this->query_model->getbyTable("tblslider");
			//echo '<pre>data'; print_r($data); die;
			$this->load->view('admin/slider_index', $data);	
		}else{
			redirect("admin/login");
		}
	}
	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tblslider` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = 'Slider';
		$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
		
		
		/**** Page Links ***/
		$data['pages'] = $this->query_model->getAllPagesWithLinks();
		
		/*** </code> ***/
		
		
		
		if(isset($_POST['update'])):
		
			$this->setting_model->addSlider();
		endif;
		$this->load->view('admin/slider_add', $data);
		
		}else{
			redirect("admin/login");
		}
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		if($this->uri->segment(4) !== NULL){
		$data['title'] = 'Slider';
		$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
		$data['slides'] = $this->query_model->getbyId("tblslider", $this->uri->segment(4)); 
		
		$data['pages'] = $this->query_model->getAllPagesWithLinks();
		
	
		
		if(isset($_POST['update'])):
			$this->setting_model->updateSlider();
		endif;
		
			//echo '<pre>data'; print_r($data); die;
		$this->load->view('admin/slider_edit', $data);
		
		}else{
		redirect("admin/slider");}
		
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
	if($this->db->update("tblslider", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblslider"))
	{
	  redirect("admin/slider");	 
	//redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	redirect($this->index());
	}
	}
	
	
	public function delete_video_img(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['slider_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblslider set video_img='' where id=".$id.""))
			{	
				/**$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);**/			
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
	
	
	public function saveLocalVideos(){
		$result =  0;
		if(isset($_FILES['file']) && !empty($_FILES['file'])){
			
			
			if(is_uploaded_file($_FILES['file']['tmp_name'])) {
				$sourcePath = $_FILES['file']['tmp_name'];
				$targetPath = "upload/local_videos/".$_FILES['file']['name'];
				if(move_uploaded_file($sourcePath,$targetPath)) {
					$result =  1;
				}
			}
		}
		echo $result; exit();
	}
	
	public function delete_local_video(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['slider_id'];
			$field_name = $_POST['field_name'];
			if($this->db->query("update tblslider set $field_name='' where id=".$id.""))
			{	
				$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['video_path'];				
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
	
	
}