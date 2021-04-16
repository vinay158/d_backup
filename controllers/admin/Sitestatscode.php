<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sitestatscode extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("setting_model");
		
	}
	
	public function index(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = 'Site Statistics';
			$data['statslink'] = ''; 
			
			$result = $this->db->get("tblsitestatcode")->result();
			if($result){
				$data['statslink'] = $result[0]->statslink;
			}
	
			if(isset($_POST['update'])) :
				$statslink = trim($_POST['statslink']);
				
				if($this->query_model->update("tblsitestatcode", 1, array("statslink" => $statslink))):
					redirect("admin/sitestatscode");
				endif;
			endif;
				$this->load->view("admin/sitestatscode", $data);
		}else{
			redirect('admin/login');
		}
	}
	
}