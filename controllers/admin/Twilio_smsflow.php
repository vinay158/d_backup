<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/sparkpost_autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class Twilio_smsflow extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("sparkpost_mail_model");
		
	}
	
	public function index(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = 'SMS Flows';
			$data['link_type'] = 'twilio_smsflow';
			
			
			$data['template_types'] = array();
			for($i = 1; $i <= 14; $i++){
				$data['template_types']['day_'.$i] = 'Day '.$i;
			}
			$data['template_types']['paid_trial_template'] = 'Paid Trial Template';
			$data['template_types']['admin_sms_template'] = 'Admin SMS Template';
			
			
			$data['twilio_sms_flows'] = $this->query_model->getByTable('twilio_sms_flows');

			
			if(!empty($data['twilio_sms_flows'])){
				foreach($data['twilio_sms_flows'] as $twilio_sms_flow){
					
					$this->db->order_by('template_type','ASC');
					$this->db->select(array('id','title','sms_flow_id','status','pos','created','template_type','send_sms_time'));
					$this->db->where('template_type !=','paid_trial_template');
					$this->db->where('template_type !=','admin_sms_template');
					$data['twilio_sms_templates']['days_template'][$twilio_sms_flow->id] = $this->query_model->getbySpecific('tbl_twilio_sms_templates', 'sms_flow_id',$twilio_sms_flow->id);
					
					if($twilio_sms_flow->id == 1){
						$this->db->order_by('pos','ASC');
						$this->db->select(array('id','title','sms_flow_id','status','pos','created','template_type'));
						$this->db->where('template_type','paid_trial_template');
						$this->db->or_where('template_type','admin_sms_template');
						$data['twilio_sms_templates']['other_templates'][$twilio_sms_flow->id] = $this->query_model->getbySpecific('tbl_twilio_sms_templates', 'sms_flow_id',$twilio_sms_flow->id);
					}
					
					
				}
			}
			
			$this->db->where_in('type', ['trial_forms','program_forms']);
			$data['form_types'] = $this->query_model->getByTable('tbl_form_types');
			$data['form_types_list'] = array();
			if(!empty($data['form_types'])){
				foreach($data['form_types'] as $form_type){
					
					$data['pages_list'][$form_type->type] = $this->query_model->getAllPagesListForSmsFlows($form_type->id);
					$data['form_types_list'][$form_type->type] = $form_type->name;
					/*
					$this->db->order_by('id','ASC');
					$this->db->select(array('id','name'));
					$data['form_modules'][$form_type->type] = $this->query_model->getbySpecific('tbl_form_modules', 'form_type_id',$form_type->id);*/
				}
			}
			//echo '<prE>data'; print_r($data); die;
		
			$this->load->view("admin/twilio_sms_flows", $data);
		}
	}
	
	
	
	
	public function edit_template(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if( $this->uri->segment(4) != NULL ){
				
				$data['title'] = "Edit: Sms Template";
				
				$data['times'] = $this->get_hours_range();
				$data['details'] = $this->query_model->getbySpecific('tbl_twilio_sms_templates','id', $this->uri->segment(4));
				$data['details'] = $data['details'][0];
				
				if($data['details']->template_type != "paid_trial_template" && $data['details']->template_type != "admin_sms_template"){
					$data['template_types'] = array();
					for($i = 1; $i <= 14; $i++){
						$data['template_types']['day_'.$i] = 'Day '.$i;
					}
				}else{
					if($data['details']->template_type == "paid_trial_template"){
						$data['template_types']['paid_trial_template'] = 'Paid Trial Template';
					}elseif($data['details']->template_type == "admin_sms_template"){
						$data['template_types']['admin_sms_template'] = 'Admin SMS Template';
					}
				}
				
				//echo '<prE>data'; print_r($data); die;
				
				
				if(isset($_POST['update'])):
					
						$postData['title'] = isset($_POST['title']) ? trim($_POST['title']) : '';
						$postData['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
						$postData['created'] = date('Y-m-d h:i:s');
						$postData['sms_flow_id'] = (isset($_POST['sms_flow_id']) && !empty($_POST['sms_flow_id'])) ? $_POST['sms_flow_id'] : 0;
						$postData['send_sms_time'] = (isset($_POST['send_sms_time']) && !empty($_POST['send_sms_time'])) ? $_POST['send_sms_time'] : 0;
						$postData['template_type'] = (isset($_POST['template_type']) && !empty($_POST['template_type'])) ? $_POST['template_type'] : '';
						$this->query_model->updateData('tbl_twilio_sms_templates','id',$this->uri->segment(4), $postData);

						redirect("admin/twilio_smsflow#sms_flow_".$postData['sms_flow_id']);
				endif;		
				
				$this->load->view("admin/twilio_sms_edit_template", $data);
				
			}else{
				redirect($this->index());
			}
		}else{
		redirect("admin/login");
		}
	}
	
public function add_template(){
		
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = "Add: Sms Template";
		$data['template_types'] = array();
		
		$data['times'] = $this->get_hours_range();
		
		$template_types_arr = array();
		for($i = 1; $i <= 14; $i++){
			$template_types_arr['day_'.$i] = 'Day '.$i;
		}
		//$template_types_arr['paid_trial_template'] = 'Paid Trial Template';
		//$template_types_arr['admin_sms_template'] = 'Admin SMS Template';
		
		$sparkpost_flow_id = $this->uri->segment(4);
		
		$this->db->where('template_type !=','');
		$this->db->select(array('template_type'));
		$template_type_groups = $this->query_model->getBySpecific('tbl_twilio_sms_templates','sms_flow_id',$sparkpost_flow_id);
		$selectedTemplateTypes = array();
		if(!empty($template_type_groups)){
			foreach($template_type_groups as $template_type_group){
				$selectedTemplateTypes[$template_type_group->template_type] = $template_type_group->template_type;
			}
		}
		
		
		foreach($template_types_arr as $key => $template_type){
			if(!empty($selectedTemplateTypes)){
				if(!in_array($key,$selectedTemplateTypes)){
					$data['template_types'][$key] = $template_type;
				}
			}else{
				$data['template_types'] = $template_types_arr;
			}
		}
		
		//echo '<pre>template_types'; print_r($data['template_types']); die;
		
		if(isset($_POST['update'])):
			
				
				$postData['title'] = isset($_POST['title']) ? trim($_POST['title']) : '';
				$postData['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
				$postData['sms_flow_id'] = (isset($_POST['sms_flow_id']) && !empty($_POST['sms_flow_id'])) ? $_POST['sms_flow_id'] : 0;
				$postData['template_type'] = (isset($_POST['template_type']) && !empty($_POST['template_type'])) ? $_POST['template_type'] : '';
				$postData['created'] = date('Y-m-d h:i:s');
				$postData['status'] = 1;
				
				$this->query_model->insertData('tbl_twilio_sms_templates', $postData);
				$insert_template_id = $this->db->insert_id();
				
				$this->addTemplateToSparkPostApi($insert_template_id);
				
				
				
				redirect("admin/twilio_smsflow#sms_flow_".$postData['sms_flow_id']);
			endif;
			$this->load->view("admin/twilio_sms_add_template", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	public function ajax_update_flow_title(){
		
		$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
		$flow_id = (isset($_POST['flow_id']) && !empty($_POST['flow_id'])) ? $_POST['flow_id'] : '';
		$title = (isset($_POST['title']) && !empty($_POST['title'])) ? $_POST['title'] : '';
		
		if(!empty($action) && !empty($flow_id) && !empty($title)){
			$updateData = array();
			$updateData['title'] = $title;
			$this->query_model->updateData('twilio_sms_flows','id',$flow_id, $updateData);
		}
		
		echo 1;
	}
	
	
	public function ajax_update_flow_page_url(){
		
		$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
		$flow_id = (isset($_POST['flow_id']) && !empty($_POST['flow_id'])) ? $_POST['flow_id'] : '';
		$page_url = (isset($_POST['page_url']) && !empty($_POST['page_url'])) ? $_POST['page_url'] : '';
		
		if(!empty($action) && !empty($flow_id) && !empty($page_url)){
			$updateData = array();
			$updateData['page_url'] = $page_url;
			$this->query_model->updateData('twilio_sms_flows','id',$flow_id, $updateData);
		}
		
		echo 1;
	}
	
	public function duplicate_form(){
		
		parse_str($_POST['formData'], $searcharray);
		
		$_POST = $searcharray;
		
		$item_id =  (isset($_POST['item_id']) && !empty($_POST['item_id'])) ? $_POST['item_id'] : '';
		$table_name =  (isset($_POST['table_name']) && !empty($_POST['table_name'])) ? $_POST['table_name'] : '';
		$action =  (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
		if(isset($action) && $action == "duplicate_record"){
			
			if(isset($item_id) && !empty($item_id) ){
				
				$details = $this->query_model->getbySpecific($table_name,'id', $item_id);
				if(!empty($details)){
					
					$postData  = array();
					unset($details[0]->id);
					
					$title = (isset($_POST['title']) && !empty($_POST['title'])) ? $_POST['title'] : '';
					$title = !empty($title) ? $title : $details[0]->title;
					$postData['title'] = trim($title);
					
					foreach($details[0] as $key => $detail){
						if($key == "title"){
							if($detail == $title){
								$postData[$key] = $title .' Duplicate';
							}
						}else{
							$postData[$key] = $detail;
						}
						
					}
					
					$this->query_model->insertData($table_name, $postData);
					$duplicate_id = $this->db->insert_id();
					
					if($table_name == "twilio_sms_flows"){
						
						
						// saving  code other tables
						$tables = array('tbl_twilio_sms_templates');
						foreach($tables as $table_name){
							$this->db->where('template_type !=','paid_trial_template');
							$this->db->where('template_type !=','admin_sms_template');
							$records = $this->query_model->getbySpecific($table_name,'sms_flow_id', $item_id);
							
							if(!empty($records)){
								foreach($records as $record){
									$dataArr = array();
										
									foreach($record as $key => $val){
										if($key == "id"){
											unset($key);
										}elseif($key == "sms_flow_id"){
											$dataArr[$key] = $duplicate_id;
										}else{
											$dataArr[$key] = $val;
										}
									}
									
									$this->query_model->insertData($table_name, $dataArr);
									$template_duplicate_id = $this->db->insert_id();
									
								}
								
							}
						}
						
					}
					
				}
				
			}
		}
		
		echo 1;
		//redirect("admin/".$this->controller_name);
		
	}
	
	
	public function addTemplateToSparkPostApi($template_duplicate_id){
		
									
		$template_detail = $this->query_model->getBySpecific('tbl_sparkpost_mail_templates','id',$template_duplicate_id);
		
		if(!empty($template_detail)){
			$flow_detail = $this->query_model->getBySpecific('tbl_sparkpost_mail_flows','id',$template_detail[0]->mail_flow_id);
			
			if(!empty($flow_detail)){
				
				$mail_subject = $this->query_model->replaceSparkpostEmailVaribles($template_detail[0]->subject);
				$mail_template = $this->query_model->replaceSparkpostEmailVaribles($template_detail[0]->description);
								
				$requestData = array(
									'title'=>$flow_detail[0]->title.' ~ '. $template_detail[0]->title,
									'subject'=>$mail_subject,
									'description'=>$mail_template
								);
			
				
				$request_result = $this->sparkpost_mail_model->requestSparkPostApi('add_template',$requestData);
				
				if(isset($request_result['response']) && $request_result['response'] == 1){
					
					if(isset($request_result['template_id']) && !empty($request_result['template_id'])){
						$updateData = array();
						$updateData['template_id'] = $request_result['template_id'];
						
						$this->query_model->updateData('tbl_sparkpost_mail_templates','id',$template_duplicate_id, $updateData);
					}
				}
				
				
			}
		}
	}
	
	
	
	 
function get_hours_range( $start = 0, $end = 86400, $step = 3600, $format = 'g:i a' ) {
        $times = array();
        foreach ( range( $start, $end, $step ) as $timestamp ) {
                $hour_mins = gmdate( 'H:i', $timestamp );
                if ( ! empty( $format ) )
                        $times[$hour_mins] = gmdate( $format, $timestamp );
                else $times[$hour_mins] = $hour_mins;
        }
        return $times;
}
	
}