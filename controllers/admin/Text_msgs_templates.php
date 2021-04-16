<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Text_msgs_templates extends CI_Controller {
	
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
		
			$this->db->select('send_admin_text_msg');
			$data['pagedetails'] =  $this->query_model->getbySpecific('tblsite', 'id', 1);
			
			$data['twillioTemplates'] =  $this->query_model->getbyTable('tbl_text_msgs_templates');
			
			$data['twillioMsgTemplates'] = array();
			
			if(!empty($data['twillioTemplates'])){
				foreach($data['twillioTemplates'] as $msg_template){
					$data['twillioMsgTemplates'][$msg_template->form_type] = $msg_template;
				}
			}
			
			//echo '<pre>data'; print_r($data); die;
			
			if(isset($_POST['update_twillio_api']) && $_POST['update_twillio_api'] == "Save"){
				
					if(!empty($data['pagedetails'])){
						$updateData['send_admin_text_msg']  = isset($_POST['send_admin_text_msg'])?$_POST['send_admin_text_msg']:0;
						
						$this->query_model->update('tblsite',1, $updateData);
					} 
					
				redirect('admin/text_msgs_templates');
				
			}elseif(isset($_POST['update_twillio_msg_templates']) && !empty($_POST['update_twillio_msg_templates'])){
				//echo '<prE>POST'; print_r($_POST); die;
				$this->saveTwillioMsgTemplates($_POST['twillio_msg_template']);
				
				redirect('admin/text_msgs_templates');
			} 
			
			
			$this->load->view("admin/text_msgs_templates", $data);
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function saveTwillioMsgTemplates($postData){
		
		if(isset($postData) && !empty($postData)){
			
			foreach($postData as $key => $msg_template){
				
				$exitRecord = $this->query_model->getbySpecific('tbl_text_msgs_templates','form_type',$key);
				
				if(!empty($exitRecord)){
						$updateData['client_msg']  = isset($msg_template['client_msg'])?$msg_template['client_msg']:'';
						$updateData['admin_msg']  = isset($msg_template['admin_msg'])?$msg_template['admin_msg']:'';
						$updateData['form_type']  = $key;
						
						$this->query_model->update('tbl_text_msgs_templates',$exitRecord[0]->id, $updateData);
					} else{
						$insertData['client_msg']  = isset($msg_template['client_msg']) ? $msg_template['client_msg']:'';
						$insertData['admin_msg']  = isset($msg_template['admin_msg']) ? $msg_template['admin_msg']:'';
						$insertData['form_type']  = $key;
						
						$this->query_model->insertData('tbl_text_msgs_templates',$insertData);
					} 
				
			}
		}
	}

		
}
