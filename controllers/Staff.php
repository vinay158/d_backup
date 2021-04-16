<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('staff_model');
	}
	
	public function index()
	{
		redirect('admin/staff/view');
	}
	
	public function view(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = 'Our Instructors';
		$data['link_type'] = 'staff';
		$data['staff'] = $this->db->get("tblstaff")->result();
		$this->load->view("admin/staff", $data);
		
		if(isset($_POST['update'])):
		
		$title = trim($_POST['title']);
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
		
		$data = array("title" => $title, "content" => $content);
			$this->query_model->update("tblpages", 6, $data);
			redirect("admin/staff");
		endif;
		}else
		{
			redirect('admin/login');
		}
	}
	
	public function edit(){
	
	if($this->uri->segment(4) != NULL){
	$data['title'] = 'Our Instructors';
	$data['details'] = $this->staff_model->getStaffbyId($this->uri->segment(4));
	$this->load->view("admin/staff_edit", $data);
		
		if(isset($_POST['update'])):
		
			//redirect("admin/staff");
		endif;
	}
	else{ redirect("admin/staff");}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Our Instructors";
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
	$this->db->where("id", $id);
	if($this->db->delete("tblstaff"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete staff');</script>";
	redirect($this->index());
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
}