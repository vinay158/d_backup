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
					
					$this->db->order_by('pos','ASC');
					$this->db->select(array('id','title','mail_flow_id','status','pos','created','template_id','template_type'));
					$data['sparkpost_templates'][$sparkpost_flow->id] = $this->query_model->getbySpecific('tbl_sparkpost_mail_templates', 'mail_flow_id',$sparkpost_flow->id);
					
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
			
			/*$requestData = array('search_url' =>'metrics/deliverability/template?from=2021-05-01T08:00&metrics=count_sent,count_unique_confirmed_opened,count_accepted,count_bounce,count_targeted,count_injected,count_rejected&limit=5&order_by=count_injected');
			$metrics_result = $this->sparkpost_mail_model->requestSparkPostApi('metrics_templates',$requestData);*/
			
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
				
				$data['template_types'] = array('day_1'=>'Day 1','day_2'=>'Day 2','day_3'=>'Day 3','day_4'=>'Day 4','day_5'=>'Day 5','day_6'=>'Day 6','paid_trial_purchased'=>'Paid Trial Purchased');
				
				
				
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
								
								$requestData = array('title'=>$flow_detail[0]->title.' ~ '. $postData['title'],
											'subject'=>$postData['subject'],
											'description'=>$postData['description'],
											'template_id' => $data['details']->template_id
										);
							
							
								$request_result = $this->sparkpost_mail_model->requestSparkPostApi('edit_template',$requestData);
								
							}else{
								$requestData = array('title'=>$flow_detail[0]->title.' ~ '. $postData['title'],
											'subject'=>$postData['subject'],
											'description'=>$postData['description']
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
				
				$requestData = array(
									'title'=>$flow_detail[0]->title.' ~ '. $template_detail[0]->title,
									'subject'=>$template_detail[0]->subject,
									'description'=>$template_detail[0]->description
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