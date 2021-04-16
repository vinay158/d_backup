<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ManagePage extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('managepage_model');
	}
	
	public function index()
	{
		redirect('admin/managepage/view/1');
	}
	
	
	public function add()
	{
		//$x = $this->input->post();
		//print_r($x); die;
		/*$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['name'] = $this->input->post('name');
			$data['description'] = $this->input->post('description');
			$data['meta_title'] = $this->input->post('meta_title');
			$data['meta_description'] = $this->input->post('meta_description');
			$data['trials'] = $this->input->post('trials');
			//print_r($data['name']);
			//$data['cat'] = $this->query_model->getCategory("blog");
			
			if(isset($_POST['Save'])):
						
			endif;
			$this->load->view("admin/page_add", $data);	
		}else{
			redirect('admin/login');
		}*/
		//$this->load->view("admin/page_add");
		
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "managepage";
			//$query = $this->db->query("select * from tblpages where `parent` = 0");
			
			//$query = $this->db->query("select * from tblpages where `parent` = 0");
			//$data['parentPage'] = $query->result();
			
			
			if(isset($_POST['save'])):
						$this->managepage_model->addpage();
						redirect('admin/managepage/view');
			endif;
			$this->load->view("admin/managepage_add", $data);	
		}else{
			redirect('admin/login');
		}
	
		
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$this->db->where("id",$this->uri->segment(4));
		$data['title'] = 'managepage';
		$data['pagedetails'] = $this->db->get("tblmanagepages")->result();
		
		//$query = $this->db->query("select * from tblpages where `parent` = 0");
		//$data['parentPage'] = $query->result();
		if(!empty($data['pagedetails'])){
					
					$this->load->view('admin/managepage_edit',$data);
		
					if(isset($_POST['update'])){
						$this->managepage_model->updatepage();
						
						redirect('admin/managepage/view');
					}
		}
		//$this->load->view("admin/page_edit", $data);
		
		}else
		{
			redirect('admin/login');
		}
		
		
	}
	
	public function delete(){
		$id = $this->uri->segment(4);
		$this->db->where("id", $id);
		//echo $id; die;
		//echo ''; die;
			if($this->db->delete("tblmanagepages"))
			{
				redirect($this->index());
			}
			else
			{
				echo "<script language='javascript'>alert('Unable to delete Pages');</script>";
				redirect($this->index());
		}
	}
	
	
	public function publish(){
		$id = $this->uri->segment(4);
		$status = $this->uri->segment(5);
		//echo $status; die;
			
			if($status == 'publish'){
				$pub = 0;
				}else {
				$pub = 1;	
					}
					
				//	echo $pub; die;
			$this->db->where("id", $id);
			if($this->db->update("tblmanagepages", array("published" => $pub)))
			{	
				redirect($this->index());
				
			}
		}
		
		
	public function view()
	{/*
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "Page";
			$data['cat'] = $this->query_model->getCategory("page");
			$data['link_type'] = "page";
			$data['blogs'] = $this->blog_model->getPagebyCat($this->uri->segment(4));
			$this->load->view('admin/page_index', $data);
				
		}
		else
		{
			redirect('admin/login');
		}
	*/
	
	
	
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "managepage";
			$this->db->order_by("id", "desc"); 
			$query = $this->db->get('tblmanagepages');
			$data['pages'] = $query->result();
			//echo '<pre>'; print_r($data); die;
			$this->load->view('admin/managepage_index', $data);	
		}
		else
		{
			redirect('admin/login');
		}
	
	}
	
	
	
	public function deleteCategory(){
	$id = $_POST['delete-id'];
	$this->db->where("cat_id", $id);
	if($this->db->delete("tblcategory"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	redirect($this->index());
	}
	}
	public function operateCategory(){
	$title = $_POST['name'];
	$operation = $_POST['operation'];
	$id = $_POST['edit_id'];
	$shared = $_POST['shared'];
	$save = $_POST['submit'];
	//echo $title." ".$operation." ".$id." "." ".$shared." ".$save;
	if(isset($save))
	{
		if( $operation == 'add' )
		{
			$args = array("cat_name" => $title, "cat_type" => "page", "permission" => $shared);
			if($this->query_model->addCategory($args)){
			redirect($this->index());
			}
			else
			{	
				echo "<script language='javascript'>alert('Unable to add category');</script>";
				redirect($this->index());
			}
		}
		elseif( $operation == 'edit' )
		{
			$args = array("cat_name" => $title, "cat_type" => "page", "permission" => $shared);
			$this->db->where("cat_id",$id);
			if($this->query_model->editCategory($args)){
			redirect($this->index());
			}
			else
			{	
				echo "<script language='javascript'>alert('Unable to add category');</script>";
				redirect($this->index());
			}
		}
	}	
	}
	
	/*public function uploadPhoto(){
		if(isset($_POST['submit'])):
			$data_count = $this->query_model->getFacilityData();
			if(count($data_count)<8){
				$image = $_FILES['userfile']['name'];
				$table = 'tblaboutfacilityphoto';
				if(!empty($image)){
						$this->load->model('upload_model');
						$path = "upload/facility/";
					if($a = $this->upload_model->upload_image($path)){
						$data = array(
						'photo' => $a,
						);
					if($this->query_model->insertDataFacility($table,$data)): 
						redirect("admin/about/facility");
					endif;
				  }
				}
			}else{
				echo "<script language='javascript'>alert('Oops! You already have uploaded the maximum amount of 8 photos.');</script>";
				echo "<script language='javascript'>window.location = '../about/facility';</script>";
				//redirect("admin/about/facility");				
			}
		endif;
	}*/
		
  	
}