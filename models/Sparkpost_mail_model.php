<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/sparkpost_autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class Sparkpost_mail_model extends CI_Model{	
	
	public function requestSparkPostApi($action, $requestData){
		
		
		$sparkPostDetail = $this->query_model->getbySpecific('tbl_sparkpost_mail', 'id', 1);
		
		$request_result = array();
		
		if(!empty($sparkPostDetail)){
			
			if($sparkPostDetail[0]->type == 1 && !empty($sparkPostDetail[0]->api_key)){
				
				if(!empty($requestData)){
					
					if($action == "add_template"){
						$request_result = $this->addTemplateToSparkpostApi($sparkPostDetail, $requestData);
					}elseif($action == "edit_template"){
						$request_result = $this->editTemplateToSparkpostApi($sparkPostDetail, $requestData);
					}elseif($action == "delete_template"){
						$request_result = $this->deleteTemplateToSparkpostApi($sparkPostDetail, $requestData);
					}elseif($action == "send_email_by_template"){
						$request_result = $this->sendEmailByTemplateToSparkpostApi($sparkPostDetail, $requestData);
					}elseif($action == "update_template_setting"){
						$request_result = $this->updateTemplateSettingToSparkpostApi($sparkPostDetail, $requestData);
					}elseif($action == "metrics_templates"){
						$request_result = $this->metricsTemplateToSparkpostApi($sparkPostDetail, $requestData);
					}
					
				}
				
			}
		}
		
		return $request_result;		
		
	}
	
	public function addTemplateToSparkpostApi($sparkPostDetail,$requestData){
		
		$httpClient = new GuzzleAdapter(new Client());
		$sparky = new SparkPost($httpClient, ['key'=>$sparkPostDetail[0]->api_key]);
		$sparky->setOptions(['async' => false]);
		
		$sparkpost_template_id = '';
		$result = array();
		$result['response'] = 0;
		
		$name = (isset($requestData['title']) && !empty($requestData['title'])) ? $requestData['title'] : '';
		$subject = (isset($requestData['subject']) && !empty($requestData['subject'])) ? $requestData['subject'] : '';
		$html = (isset($requestData['description']) && !empty($requestData['description'])) ? $requestData['description'] : '';
		
		//$reply_to = 'noreply@dojoonlinemarketing.com';
		
		$this->db->select(array('title'));
		$site_setting = $this->query_model->getbyTable('tblsite');
		$site_title = $site_setting[0]->title;
		
		try {
			$create_template_promise = $sparky->request('POST', 'templates', [
				  'name' => $name,
				  'published' => true,
				  'content' => [
					'from' => ['name' => $site_title,'email'=>$sparkPostDetail[0]->from_email],
					'reply_to' => $sparkPostDetail[0]->reply_to_email,
					'subject' => $subject,
					'html' => $html,
				  ],
				]);

				
					$create_template_response_code = $create_template_promise->getStatusCode();
					$create_template = $create_template_promise->getBody();
					
					if($create_template_response_code == 200){
						if(isset($create_template['results']['id']) && !empty($create_template['results']['id'])){
							
							$result['response'] = 1;
							$result['template_id'] = $create_template['results']['id'];
						}
					}
					
				} catch (\Exception $e) {
					//echo $e->getCode()."\n";
					//echo $e->getMessage()."\n";
				}
		
		return $result;
		
	}
	
	
	public function editTemplateToSparkpostApi($sparkPostDetail,$requestData){
		//echo '<pre>requestData'; print_r($requestData); die;
		$httpClient = new GuzzleAdapter(new Client());
		$sparky = new SparkPost($httpClient, ['key'=>$sparkPostDetail[0]->api_key]);
		$sparky->setOptions(['async' => false]);
		
		$sparkpost_template_id = '';
		$result = array();
		$result['response'] = 0;
		
		$template_id = (isset($requestData['template_id']) && !empty($requestData['template_id'])) ? $requestData['template_id'] : '';
		$name = (isset($requestData['title']) && !empty($requestData['title'])) ? $requestData['title'] : '';
		$subject = (isset($requestData['subject']) && !empty($requestData['subject'])) ? $requestData['subject'] : '';
		$html = (isset($requestData['description']) && !empty($requestData['description'])) ? $requestData['description'] : '';
		
		//$reply_to = 'noreply@dojoonlinemarketing.com';
		
		$this->db->select(array('title'));
		$site_setting = $this->query_model->getbyTable('tblsite');
		$site_title = $site_setting[0]->title;
		
		try {
			$update_template_promise = $sparky->request('PUT', 'templates/'.$template_id, [
					'name' => $name,
					'published' => true,
					'content' => [
						//'from' => ['name' => $site_title,'email'=>$sparkPostDetail[0]->from_email],
						'from' => ['name' => $site_title,'email'=>$sparkPostDetail[0]->from_email],
						'reply_to' => $sparkPostDetail[0]->reply_to_email,
						'subject' => $subject,
						'html' => $html,
					  ],
					'options' => [
						'open_tracking' => true,
					],
				]);

				
					$response_code = $update_template_promise->getStatusCode();
					$response = $update_template_promise->getBody();
					
					if($response_code == 200){
						$result['response'] = 1;
					}
					
				} catch (\Exception $e) {
					//echo $e->getCode()."\n";
					//echo $e->getMessage()."\n";
				}
		
		return $result;
		
	}
	
	
	public function updateTemplateSettingToSparkpostApi($sparkPostDetail,$requestData){
		
		$httpClient = new GuzzleAdapter(new Client());
		$sparky = new SparkPost($httpClient, ['key'=>$sparkPostDetail[0]->api_key]);
		$sparky->setOptions(['async' => false]);
		
		$sparkpost_template_id = '';
		$result = array();
		$result['response'] = 0;
		
		$template_id = (isset($requestData['template_id']) && !empty($requestData['template_id'])) ? $requestData['template_id'] : '';
		$subject = (isset($requestData['subject']) && !empty($requestData['subject'])) ? $requestData['subject'] : '';
		$html = (isset($requestData['description']) && !empty($requestData['description'])) ? $requestData['description'] : '';
		$name = (isset($requestData['title']) && !empty($requestData['title'])) ? $requestData['title'] : '';
		
		//echo '<pre>template_id'; print_r($template_id); die;
		
		$this->db->select(array('title'));
		$site_setting = $this->query_model->getbyTable('tblsite');
		$site_title = $site_setting[0]->title;
		
		try {
		$update_template_promise = $sparky->request('PUT', 'templates/'.$template_id, [
					'name' => $name,
					'published' => true,
					'content' => [
						'from' => ['name' => $site_title,'email'=>$sparkPostDetail[0]->from_email],
						'reply_to' => $sparkPostDetail[0]->reply_to_email,
						'subject' => $subject,
						'html' => $html,
					  ],
					'options' => [
						'open_tracking' => true,
					],
				]);

				
					$response_code = $update_template_promise->getStatusCode();
					$response = $update_template_promise->getBody();
					
					if($response_code == 200){
						$result['response'] = 1;
					}
					
				} catch (\Exception $e) {
					//echo $e->getCode()."\n";
					//echo $e->getMessage()."\n";
				}
		
		/*echo '<pre>template_id'; print_r($template_id); 
		echo '<pre>result'; print_r($result); die;*/
		
		return $result;
		
	}
	
	
	
	public function deleteTemplateToSparkpostApi($sparkPostDetail,$requestData){
		
		$httpClient = new GuzzleAdapter(new Client());
		$sparky = new SparkPost($httpClient, ['key'=>$sparkPostDetail[0]->api_key]);
		$sparky->setOptions(['async' => false]);
		
		$sparkpost_template_id = '';
		$result = array();
		$result['response'] = 0;
		
		$template_id = (isset($requestData['template_id']) && !empty($requestData['template_id'])) ? $requestData['template_id'] : '';
		
			try {
				
				$promise = $sparky->request('DELETE', 'templates/'.$template_id);

		
				$response_code = $promise->getStatusCode();
				$response = $promise->getBody();
				
				
				if($response_code == 200){
					$result['response'] = 1;
					//$result['template_id'] = $response['results']['id'];
				}
				
			} catch (\Exception $e) {
				//echo $e->getCode()."\n";
				//echo $e->getMessage()."\n";
			}
		
		return $result;
		
	}
	
	
public function sendEmailByTemplateToSparkpostApi($sparkPostDetail,$requestData){
		
		$httpClient = new GuzzleAdapter(new Client());
		$sparky = new SparkPost($httpClient, ['key'=>$sparkPostDetail[0]->api_key]);
		$sparky->setOptions(['async' => false]);
		
		$sparkpost_template_id = '';
		$result = array();
		$result['response'] = 0;
		//echo '<pre>requestData'; print_r($requestData); die;
		$subject = (isset($requestData['subject']) && !empty($requestData['subject'])) ? $requestData['subject'] : '';
		$html = (isset($requestData['mail_template']) && !empty($requestData['mail_template'])) ? $requestData['mail_template'] : '';
		$recipient_name = (isset($requestData['recipient_name']) && !empty($requestData['recipient_name'])) ? $requestData['recipient_name'] : '';
		$recipient_email = (isset($requestData['recipient_email']) && !empty($requestData['recipient_email'])) ? $requestData['recipient_email'] : '';
		$mail_template_id = (isset($requestData['mail_template_id']) && !empty($requestData['mail_template_id'])) ? $requestData['mail_template_id'] : '';
		
		$this->db->select(array('title'));
		$site_setting = $this->query_model->getbyTable('tblsite');
		$site_title = $site_setting[0]->title;
		
		$reply_to = $sparkPostDetail[0]->reply_to_email;
		
		// Note: sandbox is true then mail from address is : info@sparkpostbox.com    // template id : 6962077433458241801 or 6961497415304991863  sandbox true ke case me to mail send ho rhi h 
		// sandbos is false then mail from address is : info@dojoonlinemarketing.com  //template id :  6961495113202512439
		// if we are sending mail by template id then only sandbox true is working. and mail from address will be info@sparkpostbox.com
		//info@spbounce.dojoonlinemarketing.com
		
	try {
		$promise = $sparky->transmissions->post([
						// 'campaign_id'=> 'postman_metadata_example',
						  'options' => [
							'sandbox' => false,
							"open_tracking" => true,
							"click_tracking" => true
						  ],
						  'content' => [
							//'template_id' => 'bounce-template-2'
							'template_id' => $mail_template_id,
							//'reply_to' => $reply_to,
						  ],
						  'recipients' => [
							['address' => ['name' => $recipient_name,'email'=>$recipient_email]]
						  ],
						]);
			

			// code for send mail with inline html without template ID
			
			/*$promise = $sparky->transmissions->post([
						  'options' => [
							'sandbox' => false,
							"open_tracking" => true,
							"click_tracking" => true
						  ],
						  'content' => [
							'from' => [
								'name' => $site_title,
								'email' => $sparkPostDetail[0]->from_email,
							],
							'subject' => $subject,
							'html' => $html,
						  ],
						  'recipients' => [
							['address' => ['name' => $recipient_name,'email'=>$recipient_email]]
						  ]
						]);*/
						
			
				$response_code = $promise->getStatusCode();
				$response = $promise->getBody();
				
				//echo '<pre>requestData'; print_r($requestData);
			/*	echo '<pre>response_code'; print_r($response_code); 
				echo '<pre>response'; print_r($response); die;*/
				
				if($response_code == 200){
					
					if(isset($response['results']['id']) && !empty($response['results']['id'])){
						
						$result['response'] = 1;
						$result['email_id'] = $response['results']['id'];
						$result['is_rejected_email'] = $response['results']['total_rejected_recipients'];
						$result['is_accepted_email'] = $response['results']['total_accepted_recipients'];
						
					}
					
				}
				
			} catch (\Exception $e) { 
				//echo $e->getCode()."\n";
				//echo $e->getMessage()."\n";
			}
		
		
		return $result;
		
	}
	
	
	
public function metricsTemplateToSparkpostApi($sparkPostDetail,$requestData){
		
		$httpClient = new GuzzleAdapter(new Client());
		$sparky = new SparkPost($httpClient, ['key'=>$sparkPostDetail[0]->api_key]);
		$sparky->setOptions(['async' => false]);
		
		$sparkpost_template_id = '';
		$result = array();
		$result['response'] = 0;
		
		$search_url = (isset($requestData['search_url']) && !empty($requestData['search_url'])) ? $requestData['search_url'] : '';
		
		$promise = $sparky->request('GET', $search_url);

			try {
				$response_code = $promise->getStatusCode();
				$response = $promise->getBody();
				
				
				if($response_code == 200){
					$result['response'] = 1;
					$result['records'] = $response['results'];
				}
				
			} catch (\Exception $e) {
				echo $e->getCode()."\n";
				echo $e->getMessage()."\n";
			}
		
		return $result;
		
	}
	
	
}