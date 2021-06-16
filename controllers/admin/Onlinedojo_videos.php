<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Onlinedojo_videos extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("onlinedojo_video_model");
	}
	
	public function index()
	{
		
	if($this->session->userdata['user_level'] != 1){ 
			$usrePermissions = $this->query_model->getUserPermission($this->session->userdata('userid'));// vinay 19/11
			//echo '<pre>userpermission==>'; print_r($usrePermissions[0]->slug); die;
			if(strstr($usrePermissions[0]->slug, 'admin/onlinedojo_videos')){
				
			}else{
				redirect("admin/dashboard");
			}
			
		} 
		
		
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{ 
			$data['title'] = "Video Training Library";
			$data['link_type'] = "onlinedojo_videos";
			
			//$this->db->order_by("pos", "ASC");
			$this->db->order_by('pos asc, id desc');
			$this->db->select(array('id','video_title','video_type','published','pos'));
			$data['slides'] = $this->query_model->getbyTable("tbl_onlinedojo_videos");
			
			
			$data['album_link_type'] = "onlinedojo_video_albums";
			$this->db->order_by('pos asc, id desc');
			$this->db->select(array('id','published','album','category','cover','pos'));
			$data['blogs'] = $this->query_model->getbySpecific("tbl_onlinedojo_galleryname", "category", 26);
			//echo '<pre>data'; print_r($data); die;
			
			$this->load->view('admin/onlinedojo_videos_index', $data);	
		}else{
			redirect("admin/login");
		}
	}
	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tbl_onlinedojo_videos` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = 'Video Training Library';
		
		
		
		
		if(isset($_POST['update'])):
		
			$this->onlinedojo_video_model->addVideo();
		endif;
		
		$this->load->view('admin/onlinedojo_videos_add', $data);
		
		}else{
			redirect("admin/login");
		}
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{ //echo '<pre>POST'; print_r($_POST); die;
		if($this->uri->segment(4) !== NULL){
		$data['title'] = 'Video Training Library';
		
		$data['slides'] = $this->query_model->getbyId("tbl_onlinedojo_videos", $this->uri->segment(4)); 
		
		
		
		if(isset($_POST['update'])):
			$this->onlinedojo_video_model->updateVideo();
		endif;
		
		
		$this->load->view('admin/onlinedojo_videos_edit', $data);
		
		}else{
		redirect("admin/onlinedojo_videos");
		}
		
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
	if($this->db->update("tbl_onlinedojo_videos", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tbl_onlinedojo_videos"))
	{
	  redirect("admin/onlinedojo_videos");	 
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
			
			if($this->db->query("update tbl_onlinedojo_videos set video_img='' where id=".$id.""))
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
				//$filename = 'online'.time().$_FILES['file']['name'];
				$targetPath = "upload/local_videos/".$_FILES['file']['name'];
				if(move_uploaded_file($sourcePath,$targetPath)) {
					$result =  1;
					
					$old_video_name = (isset($_POST['old_video_name']) && !empty($_POST['old_video_name'])) ? $_POST['old_video_name'] : '';
					
					if(!empty($old_video_name)){
						$dir=pathinfo(BASEPATH);
						$img=$dir['dirname'].'/upload/local_videos/'.$old_video_name;				
						unlink($img);
						//echo $img; die;
					}
					
				}
			}
		}
		echo $result; exit();
	}
	
	public function delete_local_video(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['slider_id'];
			$field_name = $_POST['field_name'];
			if($this->db->query("update tbl_onlinedojo_videos set $field_name='' where id=".$id.""))
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
	
	
		
public function deleteVideoCustomImage(){
		
		if(count($_POST)>0){			
						
			//$photo = $_POST['photo'];
			$id = $_POST['number'];
			
			$query = $this->db->query("update tbl_onlinedojo_videos set custom_video_thumbnail='' where id=".$id."");
			
			if($query)
			{	
				/*$dir=pathinfo(BASEPATH);
				
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
	
}