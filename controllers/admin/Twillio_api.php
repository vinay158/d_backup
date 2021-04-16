<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twillio_api extends CI_Controller {
	
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
		
			$data['pagedetails'] =  $this->query_model->getbySpecific('tbl_twilio', 'id', 1);
			
			$data['twillioTemplates'] =  $this->query_model->getbyTable('tbl_twillio_msg_templates');
			
			$data['twillioMsgTemplates'] = array();
			
			if(!empty($data['twillioTemplates'])){
				foreach($data['twillioTemplates'] as $msg_template){
					$data['twillioMsgTemplates'][$msg_template->form_type] = $msg_template;
				}
			}
			
			
			
			if(isset($_POST['update_twillio_api']) && $_POST['update_twillio_api'] == "Save"){
				
					if(!empty($data['pagedetails'])){
						$updateData['send_user_msg']  = isset($_POST['send_user_msg'])?$_POST['send_user_msg']:0;
						$updateData['send_admin_msg']  = isset($_POST['send_admin_msg'])?$_POST['send_admin_msg']:0;
						
						$this->query_model->update('tbl_twilio',1, $updateData);
					} else{
						$insertData['send_user_msg']  = isset($_POST['send_user_msg'])?$_POST['send_user_msg']:0;
						$insertData['send_admin_msg']  = isset($_POST['send_admin_msg'])?$_POST['send_admin_msg']:0;
						
						
						$this->query_model->insertData('tbl_twilio',$insertData);
					} 
					
				redirect('admin/twillio_api');
				
			}elseif(isset($_POST['update_twillio_msg_templates']) && !empty($_POST['update_twillio_msg_templates'])){
				
				$this->saveTwillioMsgTemplates($_POST['twillio_msg_template']);
				
				redirect('admin/twillio_api');
			} 
			
			
			$this->load->view("admin/twillio_msg_templates", $data);
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function saveTwillioMsgTemplates($postData){
		
		if(isset($postData) && !empty($postData)){
			
			foreach($postData as $key => $msg_template){
				
				$exitRecord = $this->query_model->getbySpecific('tbl_twillio_msg_templates','form_type',$key);
				
				if(!empty($exitRecord)){
						$updateData['client_msg']  = isset($msg_template['client_msg'])?$msg_template['client_msg']:'';
						$updateData['admin_msg']  = isset($msg_template['admin_msg'])?$msg_template['admin_msg']:'';
						$updateData['form_type']  = $key;
						
						$this->query_model->update('tbl_twillio_msg_templates',$exitRecord[0]->id, $updateData);
					} else{
						$insertData['client_msg']  = isset($msg_template['client_msg']) ? $msg_template['client_msg']:'';
						$insertData['admin_msg']  = isset($msg_template['admin_msg']) ? $msg_template['admin_msg']:'';
						$insertData['form_type']  = $key;
						
						$this->query_model->insertData('tbl_twillio_msg_templates',$insertData);
					} 
				
			}
		}
	}

		
}
