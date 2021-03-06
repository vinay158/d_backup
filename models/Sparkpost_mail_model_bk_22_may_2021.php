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
		
		$create_template_promise = $sparky->request('POST', 'templates', [
				  'name' => $name,
				  'published' => true,
				  'content' => [
					'from' => $sparkPostDetail[0]->from_email,
					'subject' => $subject,
					'html' => $html,
				  ],
				]);

				try {
					$create_template_response_code = $create_template_promise->getStatusCode();
					$create_template = $create_template_promise->getBody();
					
					if($create_template_response_code == 200){
						if(isset($create_template['results']['id']) && !empty($create_template['results']['id'])){
							
							$result['response'] = 1;
							$result['template_id'] = $create_template['results']['id'];
						}
					}
					
				} catch (\Exception $e) {
					echo $e->getCode()."\n";
					echo $e->getMessage()."\n";
				}
		
		return $result;
		
	}
	
	
	public function editTemplateToSparkpostApi($sparkPostDetail,$requestData){
		
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
		
		$update_template_promise = $sparky->request('PUT', 'templates/'.$template_id, [
					'name' => $name,
					'published' => true,
					'content' => [
						'from' => $sparkPostDetail[0]->from_email,
						'subject' => $subject,
						'html' => $html,
					  ],
					'options' => [
						'open_tracking' => true,
					],
				]);

				try {
					$response_code = $update_template_promise->getStatusCode();
					$response = $update_template_promise->getBody();
					if($response_code == 200){
						$result['response'] = 1;
					}
					
				} catch (\Exception $e) {
					echo $e->getCode()."\n";
					echo $e->getMessage()."\n";
				}
		
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
		
		$promise = $sparky->request('DELETE', 'templates/'.$template_id);

			try {
				$response_code = $promise->getStatusCode();
				$response = $promise->getBody();
				
				
				if($response_code == 200){
					$result['response'] = 1;
					//$result['template_id'] = $response['results']['id'];
				}
				
			} catch (\Exception $e) {
				echo $e->getCode()."\n";
				echo $e->getMessage()."\n";
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
		
		$site_setting = $this->query_model->getbyTable('tblsite');
		$site_title = $site_setting[0]->title;
		
		
		$promise = $sparky->transmissions->post([
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
							/*'template_id' => 'custom-template',
							 "use_draft_template"=>false*/
						  ],
						  'recipients' => [
							//['address' => ['email'=>'dojodeveloper158@gmail.com']]
							['address' => ['name' => $recipient_name,'email'=>$recipient_email]]
						  ]
						]);

			try {
				$response_code = $promise->getStatusCode();
				$response = $promise->getBody();
				
				/*echo '<pre>requestData'; print_r($requestData);
				echo '<pre>response_code'; print_r($response_code); 
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
				echo $e->getCode()."\n";
				echo $e->getMessage()."\n";
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
				
				//echo '<pre>response'; print_r($response); die;
				
				if($response_code == 200){
					$result['response'] = 1;
					//$result['template_id'] = $response['results']['id'];
				}
				
			} catch (\Exception $e) {
				echo $e->getCode()."\n";
				echo $e->getMessage()."\n";
			}
		
		return $result;
		
	}
	
	
}