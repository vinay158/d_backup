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
	
	
}