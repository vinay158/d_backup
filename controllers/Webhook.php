<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webhook extends CI_Controller {

	public function save_lead(){
		
		/*$_POST = array(
					'first_name' => 'vinay',
					'last_name' => 'sameer',
					'email' => 'vinayverma158@gmail.com',
					'phone' => '8233232572',
					'program' => 'adult martial arts',
					'location' => 'demo location1',
					'message' => 'hello sir i want to get some information about dojo',
					); */
		
		$resultArr['result'] = 0;
		$resultArr['message'] = 'An error occurred, please try again';
		if(isset($_POST['email']) && !empty($_POST['email'])){
			
			
			//$_POST['name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
			
			//$checkHunneyPost = $this->webhookCheckHunneyPost($_POST);
			$checkHunneyPost = 0;
			if($checkHunneyPost == 0){
				
				$formData = $this->webhookSetFormDataValueInFormat($_POST);
				
				$saveResult  = $this->webhookSaveDataInContactLeads($formData);
				
				if($saveResult['result'] == 1){
					$resultArr['result'] = 1;
					$resultArr['response'] = $saveResult['response'];
					$resultArr['message'] = 'successfully saved';
				}else{
					$resultArr['result'] = 0;
					$resultArr['message'] = "data couldn't be saved please try again";
				}
				
			}
			
			echo json_encode($resultArr); exit();
			
		}
		
	}
	
	
	
	
	public function webhookSetFormDataValueInFormat($data){
		$result = array();
		
			$result['name'] = isset($data['name']) ? $data['name'] : '';
			$result['last_name'] = isset($data['last_name']) ? $data['last_name'] : '';
			$result['email'] = isset($data['email']) ? $data['email'] : '';
			$result['phone'] = isset($data['phone']) ? $data['phone'] : '';
			$result['program'] = isset($data['program']) ? $data['program'] : '';
			$result['location'] = isset($data['location']) ? $data['location'] : '';
			$result['message'] = isset($data['message']) ? $data['message'] : '';
		
		return $result;
	}
	
	
	
	
	
	public function webhookCheckHunneyPost($data){
		$error = 0;
			if(isset($data['name']) && !preg_match("/^[a-zA-Z ']+$/",$data['name'])) { 
				$error = 1;
			}
			if(isset($data['last_name']) && !preg_match("/^[a-zA-Z ']+$/",$data['last_name'])) { $error = 1; }
			
			if (strpos($_POST['name'], 'www') !== false || strpos($_POST['name'], '.com') !== false) {
				$error = 1;
			} 
			
			if (strpos($_POST['last_name'], 'www') !== false || strpos($_POST['last_name'], '.com') !== false) {
				$error = 1;
			} 
			
			if(isset($_POST['website']) && $_POST['website'] != ''){
				
				$error = 1;

			}
			
		return $error;
	}
	
	
	
	public function webhookSaveDataInContactLeads($formData){
				$data = array(
					'name' => $formData['name'],
					'last_name' => $formData['last_name'],
					'phone' => $formData['phone'],
					'email' => $formData['email'],
					'school' => $formData['location'],
					'message' => $formData['message'],
					'date_added' => date('Y-m-d h:i:s'),
				);
						
		$result = $this->insertDataWebhook('tblcontactusleads', $data);
		
		return $result;
	}
	
	
	public function insertDataWebhook($table_name, $data){
		$responseArr = array();
		
		$result = $this->db->insert($table_name,$data);
		$lastInsertedId  = $this->db->insert_id();
		$responseArr['result'] = $result;
		
		if($responseArr['result'] == 1 && $lastInsertedId > 0){
			$detail = $this->query_model->getbyId($table_name, $lastInsertedId);
			$responseArr['response'] = !empty($detail) ? $detail[0] : '';
		}
		
		return $responseArr;
	}
	
	/************ saving webhook unbounce data in dojo ***************/
	
	public function saveWhook(){
		
		
		
		$webhookApis = $this->query_model->getbySpecific('tbl_webhook_apis_incoming','published', 1);
		
		if(!empty($webhookApis)){
			
			foreach($webhookApis as $webhook_api){
				
				if($webhook_api->type == 'unbounce'){
					
					// getting data from unbounce api
					$formDataArr = $this->getDataFromUnbounceApi($_POST,$webhook_api);
					
						if(!empty($formDataArr)){
							if(!empty($formDataArr['name']) && !empty($formDataArr['email'])){
								$this->db->insert('tbl_webhook_leads',$formDataArr);
						}
					}

				}elseif($webhook_api->type == 'zenplanner'){
					
					$formDataArr = $this->getDataFromZenplannerApi($_POST,$webhook_api);

					
					if(!empty($formDataArr)){
						if(!empty($formDataArr['name']) && !empty($formDataArr['email'])){
							$this->db->insert('tbl_webhook_leads',$formDataArr);
						}
					}
					
				}
				
				
			}
			
		}
		
		
		/* if(isset($form_data) && !empty($form_data)){
			foreach($form_data as $key => $value){
				if(!empty($value)){
					foreach($value as $k => $v){
						$formDataArr[$key] = $v;
					}
				}
			}
		} */
		
		
		// Grab the remaining page data...                                                
		/*$formDataArr['page_id'] = isset($_POST['page_id']) ? $_POST['page_id'] : '';
		$formDataArr['page_name'] = isset($_POST['page_name']) ? $_POST['page_name'] : '';
		$formDataArr['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
		$formDataArr['variant'] = isset($_POST['variant']) ? $_POST['variant'] : ''; */
		// Assemble the body of the email...   
		
		
		/*$result_data = !empty($formDataArr) ? serialize($formDataArr) : '';
		$message_body = $result_data;
		mail('vinayverma158@gmail.com',
			 'New Unbounce Form Submission!',
			 $message_body);*/
			 
		
	}
	
	function stripslashes_deep($value) {
	  $value = is_array($value) ?
		array_map('stripslashes_deep', $value) :
		stripslashes($value);
	  return $value;
	}
	
	
	public function getDataFromUnbounceApi($postData,$webhook_api){
		
		// First, grab the form data.  Some things to note:                               
		// 1.  PHP replaces the '.' in 'data.json' with an underscore.                    
		// 2.  Your fields names will appear in the JSON data in all lower-case,          
		//     with underscores for spaces.                                               
		// 3.  We need to handle the case where PHP's 'magic_quotes_gpc' option           
		//     is enabled and automatically escapes quotation marks.                      
		if (get_magic_quotes_gpc()) {
		  $unescaped_post_data = stripslashes_deep($postData);
		} else {
		  $unescaped_post_data = $postData;
		}
		$form_data = json_decode($unescaped_post_data['data_json']);
		// If your form data has an 'Email Address' field, here's how you extract it:     
	
		//echo '<pre>form_data1'; print_R($form_data); die;
		$formDataArr = array();
		
		$formDataArr['name'] = isset($form_data->name[0]) ? $form_data->name[0] : '';
		$formDataArr['last_name'] = isset($form_data->last_name[0]) ? $form_data->last_name[0] : '';
		$formDataArr['email'] = isset($form_data->email[0]) ? $form_data->email[0] : '';
		$formDataArr['phone_number'] = isset($form_data->phone_number[0]) ? $form_data->phone_number[0] : '';
		$formDataArr['current_website_url'] = isset($form_data->current_website_url[0]) ? $form_data->current_website_url[0] : '';
		$formDataArr['additional_comments'] = isset($form_data->preferred_time_to_be_contacted__additional_comments[0]) ? $form_data->preferred_time_to_be_contacted__additional_comments[0] : '';
		$formDataArr['ip_address'] = isset($form_data->ip_address[0]) ? $form_data->ip_address[0] : '';
		$formDataArr['page_name'] = isset($form_data->page_name[0]) ? $form_data->page_name[0] : '';
		$formDataArr['page_id'] = isset($form_data->page_uuid[0]) ? $form_data->page_uuid[0] : '';
		$formDataArr['page_url'] = isset($form_data->page_url[0]) ? $form_data->page_url[0] : '';
		$formDataArr['variant'] = isset($form_data->variant[0]) ? $form_data->variant[0] : '';
		$formDataArr['is_delete'] = 0;
		$formDataArr['webhook_incoming_api_id'] = $webhook_api->id;
		$formDataArr['created'] = date('Y-m-d H:i:s');
			 
		return $formDataArr;
	}
	
	public function getDataFromZenplannerApi($postData,$webhook_api){
		
		$formDataArr = array();
		
		$formDataArr['name'] = isset($postData[$webhook_api->name_key]) ? $postData[$webhook_api->name_key] : '';
		$formDataArr['last_name'] = isset($postData[$webhook_api->last_name_key]) ? $postData[$webhook_api->last_name_key] : '';
		$formDataArr['email'] = isset($postData[$webhook_api->email_key]) ? $postData[$webhook_api->email_key] : '';
		$formDataArr['phone_number'] = isset($postData[$webhook_api->phone_key]) ? $postData[$webhook_api->phone_key] : '';
		if(empty($formDataArr['phone_number'])){
			$formDataArr['phone_number'] = isset($postData['phone']) ? $postData['phone'] : '';
		}
		$formDataArr['current_website_url'] = isset($postData[$webhook_api->school_url_key]) ? $postData[$webhook_api->school_url_key] : '';
		$formDataArr['school_name'] = isset($postData[$webhook_api->school_name_key]) ? $postData[$webhook_api->school_name_key] : '';
		
		$formDataArr['inquiry_date'] = '';
		if(isset($postData[$webhook_api->inquiry_date_key]) && !empty($postData[$webhook_api->inquiry_date_key])){
			$inquiry_date = str_replace(array("{ts '","'}"),'',$postData[$webhook_api->inquiry_date_key]);
			$formDataArr['inquiry_date'] = date('Y-m-d H:i:s', strtotime($inquiry_date));
		}
		
		$formDataArr['last_updated'] = '';
		if(isset($postData[$webhook_api->last_updated_key]) && !empty($postData[$webhook_api->last_updated_key])){
			$last_updated = str_replace(array("{ts '","'}"),'',$postData[$webhook_api->last_updated_key]);
			$formDataArr['last_updated'] = date('Y-m-d H:i:s', strtotime($last_updated));
		}
		
		/*$formDataArr['inquiry_date'] = (isset($postData[$webhook_api->inquiry_date_key]) && !empty($postData[$webhook_api->inquiry_date_key])) ?  : date('Y-m-d H:i:s');
		$formDataArr['last_updated'] = (isset($postData[$webhook_api->last_updated_key]) && !empty($postData[$webhook_api->last_updated_key])) ? $postData[$webhook_api->last_updated_key] : date('Y-m-d H:i:s'); */
		
		
		$formDataArr['location'] = isset($postData[$webhook_api->location_key]) ? $postData[$webhook_api->location_key] : '';
		$formDataArr['program'] = isset($postData[$webhook_api->program_key]) ? $postData[$webhook_api->program_key] : '';
		
		$formDataArr['is_delete'] = 0;
		$formDataArr['webhook_incoming_api_id'] = $webhook_api->id;
		$formDataArr['created'] = date('Y-m-d H:i:s');
		
		return $formDataArr;
	}
	

}
