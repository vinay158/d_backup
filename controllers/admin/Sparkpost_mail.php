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