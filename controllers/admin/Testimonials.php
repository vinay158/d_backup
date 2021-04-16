<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonials extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('testimonials_model');
	}
	
	public function index()
	{
		redirect('admin/testimonials/view');
	}
	
	
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
	
			$this->db->query("UPDATE `tbltestimonials` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{ 
			$data['title'] = 'Testimonials';
			$data['link_type'] = 'testimonials';
			//$this->db->order_by("pos", "ASC");
			
			//$data['staff'] = $this->db->get("tblstaff")->result();
			
			$data['testimonials'] = $this->testimonials_model->getAllTestimonials();
			$data['site_setting'] = $this->query_model->getbyTable('tblsite');
			
			$this->load->view("admin/testimonials", $data);
		
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
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$this->load->helper('form');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if($this->uri->segment(4) != NULL){
				
				$data['title'] = 'Testimonials';
				$data['details'] = $this->testimonials_model->getTestimonialsbyId($this->uri->segment(4));
		
				
			
				if(isset($_POST['update'])):
					$this->testimonials_model->updateTestimonials();
				endif;
				
				$this->load->view("admin/testimonials_edit", $data);
			}else{ 
				redirect("admin/testimonials");
			}
		}else{ 
			redirect("admin/login");
		}
	}
	
	public function add(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$this->load->helper('form');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			$data['title'] = "Testimonials";			
				
			if(isset($_POST['update'])):
				$this->testimonials_model->addTestimonials();
			endif;
			
			$this->load->view("admin/testimonials_add", $data);	
		}else{
			redirect('admin/login');
		}
	
	}
	
	public function deleteitem(){
		$id = $_POST['delete-item-id'];
		$this->db->where("id", $id);
		if($this->db->delete("tbltestimonials"))
		{
			redirect($this->index());
		}
		else
		{
		echo "<script language='javascript'>alert('Unable to delete testimonials');</script>";
			redirect($this->index());
		}
	}
	
	public function delete(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['testimonials_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tbltestimonials set photo='' where id=".$id.""))
			{	
				$dir=pathinfo(BASEPATH);
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
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tbltestimonials", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
}