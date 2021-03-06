<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/sparkpost_autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class Sparkpost_mail extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("sparkpost_mail_model");
		
		$sparkpost_api_is_active = $this->query_model->checkSparkpostApiIsActive();
		if($sparkpost_api_is_active == 0){
			redirect('/admin');
		}
		
	}
	
	public function index(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = 'Email Flows';
			$data['link_type'] = 'sparkpost_mail';
			
			$data['template_types'] = array('day_1'=>'Day 1','day_2'=>'Day 2','day_3'=>'Day 3','day_4'=>'Day 4','day_5'=>'Day 5','day_6'=>'Day 6','paid_trial_purchased'=>'Paid Trial Purchased');
			
			$data['sparkpost_mail_flows'] = $this->query_model->getByTable('tbl_sparkpost_mail_flows');

			
			if(!empty($data['sparkpost_mail_flows'])){
				foreach($data['sparkpost_mail_flows'] as $sparkpost_flow){
					
					$this->db->order_by('template_type','ASC');
					$this->db->select(array('id','title','mail_flow_id','status','pos','created','template_id','template_type'));
					$this->db->where('template_type !=','paid_trial_purchased');
					$data['sparkpost_templates']['days_template'][$sparkpost_flow->id] = $this->query_model->getbySpecific('tbl_sparkpost_mail_templates', 'mail_flow_id',$sparkpost_flow->id);
					
					$this->db->order_by('pos','ASC');
					$this->db->select(array('id','title','mail_flow_id','status','pos','created','template_id','template_type'));
					$this->db->where('template_type','paid_trial_purchased');
					$data['sparkpost_templates']['paid_template'][$sparkpost_flow->id] = $this->query_model->getbySpecific('tbl_sparkpost_mail_templates', 'mail_flow_id',$sparkpost_flow->id);
					
				}
			}
			
			
			
			$this->db->select('id');
			$this->db->where('template_id','');
			$sparkpost_blank_templates = $this->query_model->getbyTable('tbl_sparkpost_mail_templates');
			
			if(!empty($sparkpost_blank_templates)){
				foreach($sparkpost_blank_templates as $sparkpost_blank_template){
					
					$this->addTemplateToSparkPostApi($sparkpost_blank_template->id);
					
				}
			}
			
			$requestData = array('search_url' =>'metrics/deliverability/template?from=2021-01-01T08:00&metrics=count_sent,count_unique_confirmed_opened,count_accepted,count_bounce,count_targeted,count_injected,count_rejected&limit=100&order_by=count_injected');
			$metrics_result = $this->sparkpost_mail_model->requestSparkPostApi('metrics_templates',$requestData);
			
			$data['metrics_records'] = array();
			if(isset($metrics_result['response']) && $metrics_result['response'] == 1){
				if(isset($metrics_result['records']) && !empty($metrics_result['records'])){
					foreach($metrics_result['records'] as $metrics){
						$data['metrics_records'][$metrics['template_id']] = $metrics;
					}
				}
			}
			
			//echo '<pre>metrics_result'; print_r($data['metrics_records']); die;
		
			$this->load->view("admin/sparkpost_mail_index", $data);
		}
	}
	
	
	
	
	public function edit_template(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if( $this->uri->segment(4) != NULL ){
				
				$data['title'] = "Edit: Email Template";
				
				$data['details'] = $this->query_model->getbySpecific('tbl_sparkpost_mail_templates','id', $this->uri->segment(4));
				$data['details'] = $data['details'][0];
				
			//	$data['template_types'] = array('day_1'=>'Day 1','day_2'=>'Day 2','day_3'=>'Day 3','day_4'=>'Day 4','day_5'=>'Day 5','day_6'=>'Day 6','paid_trial_purchased'=>'Paid Trial Purchased');
				if($data['details']->template_type == "paid_trial_purchased"){
					$data['template_types'] = array('paid_trial_purchased'=>'Paid Trial Purchased');
				}else{
					$data['template_types'] = array('day_1'=>'Day 1','day_2'=>'Day 2','day_3'=>'Day 3','day_4'=>'Day 4','day_5'=>'Day 5','day_6'=>'Day 6');
				}
				
				
				
				if(isset($_POST['update'])):
				
						$postData['title'] = isset($_POST['title']) ? trim($_POST['title']) : '';
						$postData['subject'] = isset($_POST['subject']) ? trim($_POST['subject']) : '';
						$postData['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
						$postData['created'] = date('Y-m-d h:i:s');
						$postData['mail_flow_id'] = (isset($_POST['mail_flow_id']) && !empty($_POST['mail_flow_id'])) ? $_POST['mail_flow_id'] : 0;
						$postData['template_type'] = (isset($_POST['template_type']) && !empty($_POST['template_type'])) ? $_POST['template_type'] : '';
						$this->query_model->updateData('tbl_sparkpost_mail_templates','id',$this->uri->segment(4), $postData);


						
						$flow_detail = $this->query_model->getBySpecific('tbl_sparkpost_mail_flows','id',$postData['mail_flow_id']);
						
						if(!empty($flow_detail) && !empty($this->uri->segment(4))){
							
							if(!empty($data['details']->template_id)){
								
								$mail_subject = $this->query_model->replaceSparkpostEmailVaribles($postData['subject']);
								$mail_template = $this->query_model->replaceSparkpostEmailVaribles($postData['description']);
								
								$requestData = array('title'=>$flow_detail[0]->title.' ~ '. $postData['title'],
											'subject'=>$mail_subject,
											'description'=>$mail_template,
											'template_id' => $data['details']->template_id
										);
							
									
								$request_result = $this->sparkpost_mail_model->requestSparkPostApi('edit_template',$requestData);
								
								
								
							}else{
								
								$mail_subject = $this->query_model->replaceSparkpostEmailVaribles($postData['subject']);
								$mail_template = $this->query_model->replaceSparkpostEmailVaribles($postData['description']);
								
								$requestData = array('title'=>$flow_detail[0]->title.' ~ '. $postData['title'],
											'subject'=>$mail_subject,
											'description'=>$mail_template
										);
							
								
								$request_result = $this->sparkpost_mail_model->requestSparkPostApi('add_template',$requestData);
								
								if(isset($request_result['response']) && $request_result['response'] == 1){
									
									if(isset($request_result['template_id']) && !empty($request_result['template_id'])){
										$updateData = array();
										$updateData['template_id'] = $request_result['template_id'];
										
										$this->query_model->updateData('tbl_sparkpost_mail_templates','id',$this->uri->segment(4), $updateData);
									}
								}
							}
							
							
						}
						
						redirect("admin/sparkpost_mail#email_flow_".$postData['mail_flow_id']);
				endif;		
				
				$this->load->view("admin/sparkpost_mail_edit_template", $data);
				
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
		$data['title'] = "Add: Email Template";
		$data['template_types'] = array();
		$template_types_arr = array('day_1'=>'Day 1','day_2'=>'Day 2','day_3'=>'Day 3','day_4'=>'Day 4','day_5'=>'Day 5','day_6'=>'Day 6','paid_trial_purchased'=>'Paid Trial Purchased');
		
		$sparkpost_flow_id = $this->uri->segment(4);
		
		$this->db->where('template_type !=','');
		$this->db->select(array('template_type'));
		$template_type_groups = $this->query_model->getBySpecific('tbl_sparkpost_mail_templates','mail_flow_id',$sparkpost_flow_id);
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
				$postData['subject'] = isset($_POST['subject']) ? trim($_POST['subject']) : '';
				$postData['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
				$postData['mail_flow_id'] = (isset($_POST['mail_flow_id']) && !empty($_POST['mail_flow_id'])) ? $_POST['mail_flow_id'] : 0;
				$postData['template_type'] = (isset($_POST['template_type']) && !empty($_POST['template_type'])) ? $_POST['template_type'] : '';
				$postData['created'] = date('Y-m-d h:i:s');
				$postData['status'] = 1;
				
				$this->query_model->insertData('tbl_sparkpost_mail_templates', $postData);
				$insert_template_id = $this->db->insert_id();
				
				$this->addTemplateToSparkPostApi($insert_template_id);
				
				
				
				redirect("admin/sparkpost_mail#email_flow_".$postData['mail_flow_id']);
			endif;
			$this->load->view("admin/sparkpost_mail_add_template", $data);
		
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
			$this->query_model->updateData('tbl_sparkpost_mail_flows','id',$flow_id, $updateData);
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
					
					if($table_name == "tbl_sparkpost_mail_flows"){
						
						
						// saving  code other tables
						$tables = array('tbl_sparkpost_mail_templates');
						foreach($tables as $table_name){
							
							$records = $this->query_model->getbySpecific($table_name,'mail_flow_id', $item_id);
							
							if(!empty($records)){
								foreach($records as $record){
									$dataArr = array();
										
									foreach($record as $key => $val){
										if($key == "id"){
											unset($key);
										}elseif($key == "mail_flow_id"){
											$dataArr[$key] = $duplicate_id;
										}else{
											$dataArr[$key] = $val;
										}
									}
									
									$this->query_model->insertData($table_name, $dataArr);
									$template_duplicate_id = $this->db->insert_id();
									
									$this->addTemplateToSparkPostApi($template_duplicate_id);
									
								}
								
							}
						}
						
					}elseif($table_name == "tbl_sparkpost_mail_templates"){
						
						$this->addTemplateToSparkPostApi($item_id);
						
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
	
	
public function cron_for_sparkpost_email_flow(){
	
	$this->db->order_by('id','desc');
	$sparkpost_users = $this->query_model->getBySpecific('tbl_sparkpost_mail_users','is_stop_mail',0);
	
	if(!empty($sparkpost_users)){
		
		foreach($sparkpost_users as $sparkpost_user){
			
			if($sparkpost_user->email_flows_status == "pending" && $sparkpost_user->mail_template_type != "paid_trial_purchased"){
				
				$last_mail_template_type = $sparkpost_user->mail_template_type;
				
				$current_mail_template_type = str_replace('day_','',$last_mail_template_type);
				$current_mail_template_type_number = $current_mail_template_type + 1;
				$current_mail_template_type = 'day_'.$current_mail_template_type_number;
				
				if($current_mail_template_type_number <= 6){
					
					//$this->db->select(array('id','template_type'));
					$this->db->where("mail_flow_id",$sparkpost_user->mail_flow_id);
					$this->db->where("template_type",$current_mail_template_type);
					//$this->db->where("template_type",'day_2');
					$this->db->where("template_type !=","paid_trial_purchased");
					$current_sparkpost_mail_template = $this->query_model->getByTable('tbl_sparkpost_mail_templates');
					//echo '<pre>sparkpost_mail_templates'; print_r($current_sparkpost_mail_template); die;
					
					if(!empty($current_sparkpost_mail_template)){
						$next_msg_created_date = date('Y-m-d',strtotime($sparkpost_user->created. " + $current_mail_template_type_number days"));
						$current_date = date('Y-m-d');
						//echo $next_msg_created_date.'==>'.$current_date; die;
						if($next_msg_created_date == $current_date){
							
							
							
							$formData = array('name'=>$sparkpost_user->name,'email'=> $sparkpost_user->email,'location'=>'','last_name'=>'','phone'=>'','program'=>'','message'=>'');
							
							//$mail_subject = $this->query_model->replaceAutoResponderVaribles($current_sparkpost_mail_template[0]->subject, $formData, '');
							//$mail_template = $this->query_model->replaceAutoResponderVaribles($current_sparkpost_mail_template[0]->description, $formData, '');
							
							$mail_subject = $this->query_model->replaceSparkpostEmailVaribles($current_sparkpost_mail_template[0]->subject);
							$mail_template = $this->query_model->replaceSparkpostEmailVaribles($current_sparkpost_mail_template[0]->description);
							
							$requestData = array(
												'recipient_name' => $sparkpost_user->name,
												'recipient_email' => $sparkpost_user->email,
												'subject' => $mail_subject,
												'mail_template' => $mail_template,
												'mail_template_id' => $current_sparkpost_mail_template[0]->template_id,
												);
												
							//echo '<pre>requestData'; print_r($requestData); die;
							
							$request_result = $this->sparkpost_mail_model->requestSparkPostApi('send_email_by_template',$requestData);
							
							//echo '<pre>request_result'; print_r($request_result); die;
							if(isset($request_result['response']) && $request_result['response'] == 1){
								
								if(isset($request_result['email_id']) && !empty($request_result['email_id'])){
									$insertData = array();
									$insertData['user_id'] = $sparkpost_user->id;
									$insertData['sent_email_id'] = $request_result['email_id'];
									$insertData['is_rejected_email'] = $request_result['is_rejected_email'];
									$insertData['is_accepted_email'] = $request_result['is_accepted_email'];
									$insertData['mail_flow_id'] = $sparkpost_user->mail_flow_id;
									$insertData['mail_template_type'] = $current_mail_template_type;
									$insertData['created'] = date('Y-m-d H:i:s');
									
									$this->query_model->insertData('tbl_sparkpost_sent_mails', $insertData);
								}
							}
							
							
							$updateData = array();
							if($current_mail_template_type_number == 6){
								$updateData['email_flows_status']  = 'all_sent';
								$updateData['is_stop_mail']  = 1;
							}
							$updateData['mail_template_type']  = $current_mail_template_type;
							$this->query_model->update('tbl_sparkpost_mail_users', $sparkpost_user->id, $updateData);
							
							
						}
						//echo $next_msg_created_date.'===>'.$current_date; die;
					}
					//echo '<pre>sparkpost_mail_templates'; print_r($sparkpost_mail_templates); die;
					
				}
				
				
			}
		}
	}
	
} 
	
	public function custom_functions(){
		
		
		$sparkPostDetail = $this->query_model->getbySpecific('tbl_sparkpost_mail', 'id', 1);
		
		if(!empty($sparkPostDetail)){
			if($sparkPostDetail[0]->type == 1 && !empty($sparkPostDetail[0]->api_key)){
				
				
				$httpClient = new GuzzleAdapter(new Client());
				$sparky = new SparkPost($httpClient, ['key'=>$sparkPostDetail[0]->api_key]);
				$sparky->setOptions(['async' => false]);
				
				
				/**** get teamplates ***/
				/*$template_promise = $sparky->request('GET', 'templates');
				
				try {
					$templates_response_code = $template_promise->getStatusCode();
					$templates = $template_promise->getBody();
					
					echo '<prE>templates_response_code'; print_r($templates_response_code); 
					echo '<prE>templates'; print_r($templates);
				} catch (\Exception $e) {
					echo $e->getCode()."\n";
					echo $e->getMessage()."\n";
				}*/
				
				
				
				/******** create template *********/
				/*$create_template_promise = $sparky->request('POST', 'templates', [
				  'name' => 'Demo template',
				  'published' => true,
				  'content' => [
					'from' => $sparkPostDetail[0]->from_email,
					'subject' => 'Test Email',
					'html' => '<b>Write your message here.</b>',
				  ],
				]);

				try {
					$create_template_response_code = $create_template_promise->getStatusCode();
					$create_template = $create_template_promise->getBody();
					
					echo '<prE>create_template_response_code'; print_r($create_template_response_code); 
					echo '<prE>create_template'; print_r($create_template); die;
				} catch (\Exception $e) {
					echo $e->getCode()."\n";
					echo $e->getMessage()."\n";
				}*/
				
				/****** update template ******/
				
				/*$update_template_promise = $sparky->request('PUT', 'templates/6956991775567766329', [
					'published' => true,
					'content' => [
						'from' => $sparkPostDetail[0]->from_email,
						'subject' => 'Test Email new',
						'html' => '<b>Write your message here. test</b>',
					  ],
					'options' => [
						'open_tracking' => true,
					],
				]);
				
				try {
					$update_template_response_code = $update_template_promise->getStatusCode();
					$update_template = $update_template_promise->getBody();
					
					echo '<prE>update_template_response_code'; print_r($update_template_response_code); 
					echo '<prE>update_template'; print_r($update_template); die;
				} catch (\Exception $e) {
					echo $e->getCode()."\n";
					echo $e->getMessage()."\n";
				}*/
				
				/****** get Metrics by Template ******/
				
				$metrics_template_promise = $sparky->request('GET', 'metrics/deliverability/template?from=2021-05-01T08:00&metrics=count_sent,count_unique_confirmed_opened,count_accepted,count_bounce,count_targeted,count_injected,count_rejected&limit=5&order_by=count_injected');
				
				try {
					$metrics_template_response_code = $metrics_template_promise->getStatusCode();
					$metrics_template = $metrics_template_promise->getBody();
					
					echo '<prE>metrics_template_response_code'; print_r($metrics_template_response_code); 
					echo '<prE>metrics_template'; print_r($metrics_template); die;
				} catch (\Exception $e) {
					echo $e->getCode()."\n";
					echo $e->getMessage()."\n";
				}
				
			}
		}
		
		
	}
	
}