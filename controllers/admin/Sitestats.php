<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class siteStats extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }		
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
			$this->load->view("admin/sitestats", $data);
		}else{
			redirect('admin/login');
		}
	}
	
}