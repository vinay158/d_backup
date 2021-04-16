<?php 
//require 'vendor/autoload.php';
//require 'vendor/Mailchimp.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kicksite extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		//$this->load->model("customcss_model");
		
	}
	
	public function index(){
		
	//	redirect('admin/dashboard');
		
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');
	
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Kicksite";
			$data['multi_location'] =  $this->query_model->getbyTable('tblconfigcalendar');
			//echo '<pre>'; print_r($data['multi_location']); die;
			$data['detail'] =  $this->query_model->getbySpecific('tbl_kicksite', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		


	$this->load->view("admin/kicksite_index", $data);
		
		if(isset($_POST['update'])){
			
			if(!empty($data['detail'])){
				$updateData['type']  = isset($_POST['type'])?$_POST['type']:'';
				$updateData['ks_url']  = isset($_POST['ks_url'])?$_POST['ks_url']:'';
				$updateData['ks_token']  = isset($_POST['ks_token'])?$_POST['ks_token']:'';
				$updateData['multi_kicksite_check']  = isset($_POST['multi_kicksite_check'])?$_POST['multi_kicksite_check']:'0';
				$updateData['created'] = time();
				
				$this->query_model->update('tbl_kicksite', 1, $updateData);
			} else{
				$insertData['type']  = isset($_POST['type'])?$_POST['type']:'';
				$insertData['ks_url']  = isset($_POST['ks_url'])?$_POST['ks_url']:'';
				$insertData['ks_token']  = isset($_POST['ks_token'])?$_POST['ks_token']:'';
				$insertData['multi_kicksite_check']  = isset($_POST['multi_kicksite_check'])?$_POST['multi_kicksite_check']:'0';
				$insertData['created'] = time();
				$this->query_model->insertData('tbl_kicksite',$insertData);
			}
		redirect('admin/kicksite');
		}
		
			
			
			
		}else{
			redirect('admin/login');
		}
	}
	



	
}