<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customcss extends CI_Controller {
	
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
		$data['title'] = "Custom Css";
		$data['setting'] = $this->query_model->getbyTable("tblsite");
		
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);
		
		
		$filename = base_url().'custom.css';
		
		
		//$data['content'] = file_get_contents($filename);
		 
		
		if(isset($_POST['update'])){
			
			 $file = fopen('custom.css',"w");
			 fwrite($file,trim($_POST['content']));
			fclose($file);
			
			redirect('admin/customcss');
		}
		
		
			$this->load->view("admin/customcss_index", $data);
		}else{
			redirect('admin/login');
		}
	}
	
}