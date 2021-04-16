<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header extends CI_Controller {
	
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
			$data['title'] = "Header Image";
			$data['link_type'] = "header";
			$data['slides'] = $this->query_model->getbyTable("tblheader");
			$this->load->view('admin/header_index', $data);	
		}else{
			redirect("admin/login");
		}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = 'Slider';
		$this->load->view('admin/header_add', $data);
		
		if(isset($_POST['update'])):
		if(!empty($_FILES['userfile']['name'])):
			$this->setting_model->addHeader();
		else:
		echo '<script>alert("You need to upload an image.");</script>';
		endif; 
		endif;
		
		
		}else{
			redirect("admin/login");
		}
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		if( $this->uri->segment(4) != NULL ){
		$data['title'] = 'Slider';
		$data['con'] = $this->query_model->getbyId("tblheader", $this->uri->segment(4) );
		$this->load->view('admin/header_edit', $data);
		
		if(isset($_POST['update'])):
			$this->setting_model->updateHeader();
		endif;
		}else{
		redirect("admin/header");
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
	if($this->db->update("tblheader", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblheader"))
	{
	redirect("admin/header");
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	redirect($this->index());
	}
	}
	
}