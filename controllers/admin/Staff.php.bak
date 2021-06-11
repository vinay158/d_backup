<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('staff_model');
	}
	
	public function index()
	{
		redirect('admin/staff/view');
	}
	
	
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {

			$this->db->query("UPDATE `tblstaff` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Our Instructors';
			$data['link_type'] = 'staff';
			//$this->db->order_by("pos", "ASC");
			
			//$data['staff'] = $this->db->get("tblstaff")->result();
			
			$data['staff'] = $this->query_model->getbySpecific("tblstaff", 'location_id',NULL);
			
			$IsAllowMultiStaff = $this->staff_model->IsAllowMultiStaff();
			$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;			
			
			$locations = $this->staff_model->getLocationStaffMeta();
			
			$data['locations'] = $locations;		
			
			
			
		
			if(isset($_POST['update'])):
				
				$title = trim($_POST['title']);
		
				$content = $_POST['text'];		
				$content = htmlentities($content);
		
				$data = array("title" => $title, "content" => $content);
				$this->query_model->update("tblpages", 6, $data);
				redirect("admin/staff");
			endif;
			
			$this->load->view("admin/staff", $data);
			
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
				
				$data['title'] = 'Our Instructors';
				$data['details'] = $this->staff_model->getStaffbyId($this->uri->segment(4));
				
				$IsAllowMultiStaff = $this->staff_model->IsAllowMultiStaff();
				$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;
				
				$blank_location = array('0' => 'Select Location');
				$locations = $this->staff_model->getLocations();
				
				$data['locations'] = $blank_location + $locations;		
		
			
				if(isset($_POST['update'])):
					$this->staff_model->updateStaff();
				endif;
				
				
				$this->load->view("admin/staff_edit", $data);
				
			}else{ 
				redirect("admin/staff");
			}
		}else{ 
			redirect("admin/login");
		}
	}
	
	public function add(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$this->load->helper('form');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			$data['title'] = "Our Instructors";
			
			$IsAllowMultiStaff = $this->staff_model->IsAllowMultiStaff();
			$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;
			
			$blank_location = array('0' => 'Select Location');
			$locations = $this->staff_model->getLocations();
			
			$data['locations'] = $blank_location + $locations;	
			$data['location_id'] = $this->uri->segment(5);
			if(isset($_POST['update'])):
						$this->staff_model->addStaff();
			endif;
			
			$this->load->view("admin/staff_add", $data);	
		}else{
			redirect('admin/login');
		}
	
	}
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$location_id = $_POST['category_loc'];
	
	$this->db->where("id", $id);
	if($this->db->delete("tblstaff"))
	{
	redirect('admin/staff/multilocation/'.$location_id);
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete staff');</script>";
	redirect('admin/staff/multilocation/'.$location_id);
	}
	}
	
	
	
	
	public function deleteitemLocationWise(){
	
	
			$id = $this->uri->segment(4);
			$location_id = $this->uri->segment(6);
			//echo $location_id; die;
			$this->db->where("id", $id);
			if($this->db->delete("tblstaff"))
			{
				if($location_id != ''){
					redirect('admin/staff/multilocation/'.$location_id);
				} else {
					redirect($this->index());
				}
			}
			else
			{
			echo "<script language='javascript'>alert('Unable to delete video');</script>";
					if($location_id != ''){
						redirect('admin/staff/multilocation/'.$location_id);
					} else {
						redirect($this->index());
					}
			
				}
	}
	
	
	public function delete(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['staff_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblstaff set photo='' where id=".$id.""))
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
	
	
	
	public function delete_lightbox_photo(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['staff_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblstaff set lightbox_photo='' where id=".$id.""))
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
	
	
	public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tblstaff", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	function updatemeta(){
		$location_id = $this->uri->segment(4);
		$meta_desc = $this->input->post('meta_desc');
		$meta_title = $this->input->post('meta_title');
		if(isset($meta_desc) && is_array($meta_desc) && !empty($meta_desc)){
			foreach($meta_desc as $k => $v){
				$this->db->where("id", $k);
				$this->db->update("tblcontact", array("meta_desc_staff" => $v));
			}
			
			foreach($meta_title as $k => $v){
				$this->db->where("id", $k);
				$this->db->update("tblcontact", array("meta_title_staff" => $v));
			}
		}
		//exit;
		if($location_id != ''){
			redirect('admin/staff/multilocation/'.$location_id);
		} else {
			redirect($this->index());
		}
		
	}
	
	
	/*** multi location ***/
	
	
	public function multilocation(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		
				if(!empty($is_logged_in) && $is_logged_in == true)
				{
					$data['title'] = 'Our Instructors';
						$data['link_type'] = 'staff';
						//echo $this->uri->segment(4); die;
						
						$this->db->order_by("pos","asc");
						$this->db->select(array('id','photo','name','published'));
						$data['staff'] = $this->query_model->getbySpecific("tblstaff", 'location_id',$this->uri->segment(4));
						
						$IsAllowMultiStaff = $this->staff_model->IsAllowMultiStaff();
						$data['IsAllowMultiStaff'] = $IsAllowMultiStaff;			
						
						$locations = $this->staff_model->getSpecificLocationStaffMeta($this->uri->segment(4));
						
						$data['locations'] = $locations;
						
						$data['location_id'] = $this->uri->segment(4);		
						
						//echo '<pre>'; print_r($data); die;
					
						if(isset($_POST['update'])):
						
							$title = trim($_POST['title']);
					
							$content = $_POST['text'];		
							$content = htmlentities($content);
					
							$data = array("title" => $title, "content" => $content);
							$this->query_model->update("tblpages", 6, $data);
							redirect("admin/staff");
						endif;
						
						$this->load->view("admin/staff", $data);
					
				}else
				{
					redirect('admin/login');
				}
	}
	
	
}