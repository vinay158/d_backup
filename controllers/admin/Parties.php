<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parties extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('blog_model');
	}
	
	public function index()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
		$this->db->where("id", 8);
		$data['title'] = 'Pages';
		$data['pagedetails'] = $this->db->get("tblpages")->result();
		if(isset($_POST['update'])):		
		
		$title = strtolower(rtrim(ltrim($_POST['title'])));
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
				
		$data = array("title" => $title, "content" => $content);
			$this->query_model->update("tblpages", 8, $data);
			redirect("admin/parties");
		endif;
		$this->load->view("admin/page_edit", $data);
	}else{
	redirect("admin/login");
	}
	}
}