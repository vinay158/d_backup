<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('session');
	}
	
	public function index()
	{
	   
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
				redirect('admin');
		}else{
			$this->load->view('admin/login');
		}
	}
	
	public function validate_credential(){
		
		if($this->user_model->validate() == 1){
			
			$reffer_url = (isset($_POST['reffer_url']) && !empty($_POST['reffer_url'])) ? $_POST['reffer_url'] : 'admin/dashboard';
			
			$this->session->unset_userdata('admin_after_login_redirct_url');
			
			redirect($reffer_url);
		}else{
			
			$admin_login_error = array('admin_login_error' => 1);
			$this->session->set_userdata($admin_login_error);
					
			redirect('admin/login');
		}
	}
}