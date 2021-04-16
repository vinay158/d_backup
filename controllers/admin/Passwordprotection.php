<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passwordprotection extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		//$this->load->model("customcss_model");
		
	}
	
	public function index(){
		
	$data['user_level']=$this->session->userdata['user_level'];
	$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
		$data['title'] = "Password Settings";
		$setting = $this->query_model->getbyTable("tblsite");
		$data['setting'] = $setting[0];
		
		$data['detail'] = $this->query_model->getbyTable("tbl_password_pro");
		
			if(isset($_POST['update'])){
			//echo '<pre>POST'; print_r($_POST); die;
					$insertdata['password'] = md5($_POST['password']);
					$insertdata['p_number'] = $_POST['password'];	
					$insertdata['password_protection_type'] = (isset($_POST['password_protection_type']) && !empty($_POST['password_protection_type'])) ? $_POST['password_protection_type'] : 'single';	
					$insertdata['virtual_training'] = (isset($_POST['virtual_training']) && !empty($_POST['virtual_training'])) ? $_POST['virtual_training'] : 0;	
					
					$this->query_model->updateData('tbl_password_pro', 'id',1, $insertdata);
					
					
					$settingdata['login_check_fields'] = (isset($_POST['login_check_fields']) && !empty($_POST['login_check_fields'])) ? $_POST['login_check_fields'] : 0;
					if($settingdata['login_check_fields'] == 1){
						$settingdata['st_sec_external_link'] = 0;
					}
					
					$this->query_model->updateData('tblsite', 'id',1, $settingdata);
					redirect('admin/passwordprotection');
			}
		
		
			$this->load->view("admin/passwordprotection", $data);
		}else{
			redirect('admin/login');
		}
	}
	
}