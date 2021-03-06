<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_modules extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
			redirect('/admin/login');
        }
		$this->table_name = 'tbl_form_modules';
		$this->controller_name = 'form_modules';
	}
	
	public function index()
	{
		redirect('admin/'.$this->controller_name.'/view');
	}
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Forms ';
			
			$data['link_type'] = $this->controller_name;	
			$data['user_level']=$this->session->userdata['user_level'];	
			
			$data['form_types'] = $this->query_model->getByTable('tbl_form_types');
			
			if(!empty($data['form_types'])){
				foreach($data['form_types'] as $form_type){
					
					$this->db->order_by('pos','ASC');
					$this->db->select(array('id','name','form_type_id','connected_type','user_email_option','admin_auto_responder_id','customer_auto_responder_id'));
					$data['form_modules'][$form_type->type] = $this->query_model->getbySpecific($this->table_name, 'form_type_id',$form_type->id);
				}
			}
			//echo '<prE>data'; print_r($data); die;
			
			$this->load->view("admin/".$this->controller_name."_index", $data);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function edit(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if( $this->uri->segment(4) != NULL ){							 
				$data['title'] = "Edit Form";
				
				$data['details'] = $this->query_model->getbySpecific($this->table_name,'id', $this->uri->segment(4));
				$data['details'] = $data['details'][0];
				
				$this->db->select(array('id','page_name'));
				$data['page_instances'] = $this->query_model->getbySpecific('tbl_form_instances','form_module_id', $data['details']->id);
				
				$this->db->select(array('id','type','title'));
				$this->db->where('type','admin');
				$data['admin_auto_responders'] = $this->query_model->getByTable('tbl_form_autoresponders');
				
				$this->db->select(array('id','type','title'));
				$this->db->where('type','customer');
				$data['customer_auto_responders'] = $this->query_model->getByTable('tbl_form_autoresponders');
				
				$this->db->order_by('id','DESC');
				$this->db->select(array('id','tag'));
				$data['active_campaign_tags'] = $this->query_model->getbySpecific('tbl_form_tags', 'tag_type','active_campaign');
				
				$this->db->order_by('id','DESC');
				$this->db->select(array('id','tag'));
				$data['active_rainmaker_tags'] = $this->query_model->getbySpecific('tbl_form_tags', 'tag_type','rainmaker');
				
				$this->db->select(array('id','title','status'));
				$this->db->order_by('id','DESC');
				$data['thankyou_pages'] = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'status',1);
				
				
				$data['mailchimp_templates'] = array();
				$mailchimp_api = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
				if(!empty($mailchimp_api) && $mailchimp_api[0]->type == 1){
					$data['mailchimp_templates'] = $this->getMailChimpTemplateLists();
				}
				
				
				$this->db->where('id',13);
				$data['multi_location'] =  $this->query_model->getbyTable('tblconfigcalendar');
			
				$data['active_campagin_lists_list'] = array();
				$data['active_campagin_automation_list'] = array();
				$data['active_campaign_detail'] =  $this->query_model->getbySpecific('tbl_active_campaign', 'id', 1);
				
				$this->db->where('api_type_id',1);
				$this->db->select(array('display_name','value'));
				$data['email_auto_responder_apis'] = $this->query_model->getByTable('tbl_api_type_values');
				
				$this->db->where('api_type_id',4);
				$this->db->select(array('display_name','value'));
				$data['crm_apis'] = $this->query_model->getByTable('tbl_api_type_values');
				
				$data['multi_webhook'] = $data['multi_location'][0]->field_value;
				
				//echo '<pre>'; print_R($data['multi_webhook']); die;
				if(!empty($data['active_campaign_detail'])){
						$data['active_campaign_detail'] = $data['active_campaign_detail'][0];
						
					if($data['active_campaign_detail']->type == 1){
						$data['active_campagin_lists_list'] = $this->getActiveCampignLists($data['active_campaign_detail']->account_name,$data['active_campaign_detail']->api_key);
					}	
						
						//$data['active_campagin_automation_list'] = $this->getActiveCampignAutomationLists($data['active_campaign_detail']->account_name,$data['active_campaign_detail']->api_key);
						
				} 
				
				//echo '<pre>'; print_r($data['mailchimp_templates']); die;
				
				$this->db->where('id',1);
				$multi_locations = $this->query_model->getbyTable("tblconfigcalendar");
		
				if($multi_locations[0]->field_value == 1){
					$this->db->select(array('id','name'));
					$data['email_sign_locations'] = $this->query_model->getbyTable("tblcontact");
				}else{
					
					$this->db->select(array('id','name'));
					$this->db->where('main_location',1);
					$data['email_sign_locations'] = $this->query_model->getMainLocation();
				}
				
				
				$this->db->select(array('id','type'));
				$data['mailchimpResult'] = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
				
				$this->db->select(array('id','type'));
				$data['rainmakerResult'] = $this->query_model->getbySpecific('tblrainmaker', 'id', 1);
				
				$this->db->select(array('id','type'));
				$data['activecampaignResult'] = $this->query_model->getbySpecific('tbl_active_campaign', 'id', 1);
				
				$this->db->select(array('id','type'));
				$data['kicksiteResult'] = $this->query_model->getbySpecific('tbl_kicksite', 'id', 1);
				
				$this->db->where('parent_id',0);
				$this->db->select(array('id','parent_id','api_type','api_name','published'));
				$data['webhookApisResult'] = $this->query_model->getbySpecific('tbl_webhook_apis', 'published', 1);
				
				$this->db->order_by('id','DESC');
				$data['webhook_apis_tags'] = $this->query_model->getbySpecific('tbl_form_tags', 'tag_type','webhook_outgoing_apis');
				
				//echo '<pre>'; print_r($data); die;
				
				
				if(isset($_POST['update'])):
						//echo '<pre>data=>'; print_r($_POST); die;
						$postData['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
						$postData['connected_type'] = isset($_POST['connected_type']) ? trim($_POST['connected_type']) : '';
						$connected_type_crm = isset($_POST['connected_type_crm']) ? trim($_POST['connected_type_crm']) : '';
						$postData['connected_type'] = !empty($connected_type_crm) ? $postData['connected_type'].', '.$connected_type_crm : $postData['connected_type'];
						
						$postData['active_campaign_tags'] = isset($_POST['active_campaign_tags']) ? serialize($_POST['active_campaign_tags']) : '';
						$postData['active_rainmaker_tags'] = isset($_POST['active_rainmaker_tags']) ? serialize($_POST['active_rainmaker_tags']) : '';
						$postData['email_webhook_api_tags'] = (isset($_POST['email_webhook_api_tags']) && !empty($_POST['email_webhook_api_tags'])) ? serialize($_POST['email_webhook_api_tags']) : '';
						$postData['crm_webhook_api_tags'] = (isset($_POST['crm_webhook_api_tags']) && !empty($_POST['crm_webhook_api_tags'])) ? serialize($_POST['crm_webhook_api_tags']) : '';
						
						$postData['active_campaign_automation_id'] = isset($_POST['active_campaign_automation_id']) ? $_POST['active_campaign_automation_id'] : 0;
						$postData['active_campaign_list_id'] = isset($_POST['active_campaign_list_id']) ? $_POST['active_campaign_list_id'] : 0;
						
						
						if($postData['connected_type'] == "Active Campaign"){
							$activeCampaign = $this->query_model->getbySpecific('tbl_active_campaign', 'id', 1);
							
							$postData['active_campaign_list_id'] = !empty($activeCampaign) ? $activeCampaign[0]->list_id : 0;
							//echo '<pre>activeCampaign'; print_r($activeCampaign); die;
						}
						
						
						$postData['mailchimp_template_id'] = isset($_POST['mailchimp_template_id']) ? $_POST['mailchimp_template_id'] : 0;
						$postData['customer_auto_responder_id'] = (isset($_POST['customer_auto_responder_id']) && !empty($_POST['customer_auto_responder_id'])) ? $_POST['customer_auto_responder_id'] : 0;
						$postData['admin_auto_responder_id'] = (isset($_POST['admin_auto_responder_id']) && !empty($_POST['admin_auto_responder_id'])) ? trim($_POST['admin_auto_responder_id']) : 0;
						$postData['email_signature_location_id'] = isset($_POST['email_signature_location_id']) ? trim($_POST['email_signature_location_id']) : 0;
						$postData['thankyou_page_id'] = isset($_POST['thankyou_page_id']) ? trim($_POST['thankyou_page_id']) : 0;
						
						
						$postData['status'] = 1;
						
						$postData['user_email_option'] = (isset($_POST['user_email_option']) && !empty($_POST['user_email_option'])) ? $_POST['user_email_option'] : 0;
						//echo '<pre>postData'; print_r($postData); die;
						
						$this->query_model->updateData($this->table_name,'id',$this->uri->segment(4), $postData);	
						redirect("admin/".$this->controller_name); 
				endif;		
				
				$this->load->view("admin/".$this->controller_name."_edit", $data);
				
			}else{
				redirect($this->index());
			}
		}else{
		redirect("admin/login");
		}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = "Add Tag";
		$data['tag_types'] = array('active_campaign'=> 'Active Campaign', 'rainmaker' => 'Rainmaker'); 
			if(isset($_POST['update'])):
				$postData['tag'] = isset($_POST['tag']) ? trim($_POST['tag']) : '';
				$postData['tag_type'] = isset($_POST['tag_type']) ? trim($_POST['tag_type']) : '';
				$postData['created'] = date('Y-m-d h:i:s');
				$this->query_model->insertData($this->table_name, $postData);
				redirect("admin/".$this->controller_name);
			endif;
			$this->load->view("admin/".$this->controller_name."_add", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	
	
	public function deleteitem(){
		$id = $_POST['delete-item-id'];
	
	$this->db->where("id", $id);
	if($this->db->delete($this->table_name))
	{
		redirect("admin/".$this->controller_name);	
	}
	}
	
	
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update($this->table_name, array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	
	public function duplicate_form(){
		
		parse_str($_POST['formData'], $searcharray);
		$_POST = $searcharray;
		
		$form_id =  (isset($_POST['item_id']) && !empty($_POST['item_id'])) ? $_POST['item_id'] : '';
		$action =  (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
		if(isset($action) && $action == "duplicate_record"){
			
			if(isset($form_id) && !empty($form_id) ){
				$details = $this->query_model->getbySpecific($this->table_name,'id', $form_id);
				if(!empty($details)){
				
					$title = !empty($_POST['title']) ? $_POST['title'] : $details[0]->name;
					$postData['form_type_id'] = $details[0]->form_type_id;
					$postData['name'] = $title;
					$postData['status'] = 1;
					$postData['connected_type'] = $details[0]->connected_type;
					$postData['active_campaign_tags'] = $details[0]->active_campaign_tags;
					$postData['active_rainmaker_tags'] = $details[0]->active_rainmaker_tags;
					$postData['active_campaign_automation_id'] = $details[0]->active_campaign_automation_id;
					$postData['active_campaign_list_id'] = $details[0]->active_campaign_list_id;
					$postData['mailchimp_template_id'] = $details[0]->mailchimp_template_id;
					$postData['admin_auto_responder_id'] = $details[0]->admin_auto_responder_id;
					$postData['customer_auto_responder_id'] = $details[0]->customer_auto_responder_id;
					$postData['email_signature_location_id'] = $details[0]->email_signature_location_id;
					$postData['thankyou_page_id'] = $details[0]->thankyou_page_id;
					$postData['user_email_option'] = $details[0]->user_email_option;
					
					$this->query_model->insertData($this->table_name, $postData);
					
				}
				
			}
		}
		
		echo 1;
		//redirect("admin/".$this->controller_name);
		
	}
	
	
	public function getMailChimpTemplateLists(){
			
			$data['detail'] =  $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
			
			if(!empty($data['detail'])){
				$data['detail'] = $data['detail'][0];
			} else{
				$data['detail'] = array();
			}
			
			$this->load->library('mailchimp_library');	
			$mailchimp  = new Mailchimp_library($data['detail']->api_key);
			
			$datacenter = explode('-',$data['detail']->api_key);
			$datacenter = isset($datacenter[1]) ? $datacenter[1] : 'us9';
		
			$tamplete_lists_data = $this->getMailChampData('https://'.$datacenter.'.api.mailchimp.com/3.0/lists?offset=0&count=100',$data['detail']->api_key,$data['detail']->email,$data['detail']->first_name);
			
			$listsArray = array();
				$i = 1;
				if(isset($tamplete_lists_data->lists)){
					foreach($tamplete_lists_data->lists as $template_list){
						$listsArray[$i]['id'] = $template_list->id;
						$listsArray[$i]['name'] = $template_list->name;
						
						$i++;
					}
				}
				
			return  $listsArray;
	}
	
	
		// other relative function to apis		
		
 public function getMailChampData($url, $apikey, $email, $fname){
	
			
		//$apikey = '38416ee8dfba9d6ccf0f8359705cbb5c-us9';
		//$email = 'info@websitedojo.com';
        $auth = base64_encode( 'user:'.$apikey );
		$datacenter = explode('-',$apikey);
		$datacenter = isset($datacenter[1]) ? $datacenter[1] : 'us9';
		

        $data = array(
            'apikey'        => $apikey,
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => array(
                'FNAME' => $fname
            )
        );
        $json_data = json_encode($data);
		//https://us9.api.mailchimp.com/3.0/campaigns?offset=0&count=10
		 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://'.$datacenter.'.api.mailchimp.com/3.0/lists?offset=0&count=1000');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$auth));
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 4000);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                                                                                  

         $result = curl_exec($ch);
		$err = curl_error($ch);
		
		curl_close($ch);
		
		if($err){
			  echo "cURL Error #:" . $err;
		}else{
			//echo 'result=>'.$result; die;
			return json_decode($result);
		}
	}
	
	
	
	
	public function getActiveCampignAutomationLists($account_name, $api_key){
		//echo 'hello'; die;
					$listsArray = array();
					error_reporting(0);
					define("ACTIVECAMPAIGN_URL", "https://".$account_name.".api-us1.com");
					define("ACTIVECAMPAIGN_API_KEY", $api_key);
					$this->load->library('activecampaign/includes/ActiveCampaign');
					//require_once("../activecampaign-api-php/includes/ActiveCampaign.class.php");
					$ac = new ActiveCampaign(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);
					
					$automations = $ac->api("automation/list?offset=0&limit=500");
					
					if(!empty($automations)){
						$listsArray = array();
						$i = 1;
						foreach($automations as $automation_list){
							if(isset($automation_list->id) && isset($automation_list->name) ){
								$listsArray[$i]['id'] = $automation_list->id;
								$listsArray[$i]['name'] = $automation_list->name;
							}
							$i++;
						}
					}
					
			return $listsArray;
	} 
	
	public function getActiveCampignLists($account_name, $api_key){
		
		$listsArray = array();
					error_reporting(0);
					
				// By default, this sample code is designed to get the result from your ActiveCampaign installation and print out the result
				$url = 'http://'.$account_name.'.api-us1.com';
				
				$params = array(

					// the API Key can be found on the "Your Settings" page under the "API" tab.
					// replace this with your API Key
					'api_key'      => $api_key,

					// this is the action that fetches a list info based on the ID you provide
					'api_action'   => 'list_list',

					// define the type of output you wish to get back
					// possible values:
					// - 'xml'  :      you have to write your own XML parser
					// - 'json' :      data is returned in JSON format and can be decoded with
					//                 json_decode() function (included in PHP since 5.2.0)
					// - 'serialize' : data is returned in a serialized format and can be decoded with
					//                 a native unserialize() function
					'api_output'   => 'serialize',

					// a comma-separated list of IDs of lists you wish to fetch
					'ids'          => 'all',

					// filters: supply filters that will narrow down the results
					//'filters[name]'      => 'General',  // perform a pattern match (LIKE) for List Name

					// include global custom fields? by default, it does not
					//'global_fields'      => true,

					// whether or not to return ALL data, or an abbreviated portion (set to 0 for abbreviated)
					'full'         => 0,
				);

				// This section takes the input fields and converts them to the proper format
				$query = "";
				foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
				$query = rtrim($query, '& ');

				// clean up the url
				$url = rtrim($url, '/ ');

				// This sample code uses the CURL library for php to establish a connection,
				// submit your request, and show (print out) the response.
				if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

				// If JSON is used, check if json_decode is present (PHP 5.2.0+)
				if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
					die('JSON not supported. (introduced in PHP 5.2.0)');
				}

				// define a final API request - GET
				$api = $url . '/admin/api.php?' . $query;
				
				$request = curl_init($api); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

				$response = (string)curl_exec($request); // execute curl fetch and store results in $response
				
				// additional options may be required depending upon your server configuration
				// you can find documentation on curl options at http://www.php.net/curl_setopt
				curl_close($request); // close curl object
				
				if ( !$response ) {
					//die('Nothing was returned. Do you have a connection to Email Marketing server?');
				}

				// This line takes the response and breaks it into an array using:
				// JSON decoder
				//$result = json_decode($response);
				// unserializer
				$result = unserialize($response);
				// XML parser...
				// ...

				// Result info that is always returned
				if(!empty($result) && isset($result['result_code']) && $result['result_code'] == 1){
					$i = 1;
						foreach($result as $list){
							if(isset($list['id']) && isset($list['name']) ){
								$listsArray[$i]['id'] = $list['id'];
								$listsArray[$i]['name'] = $list['name'];
							}
							$i++;
						}
				}
			
			return $listsArray;
	}
	
	
	public function sortFormModuleFromsPosition(){
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_form_modules` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'  AND `form_type_id`='" . $this->uri->segment(4) . "'  ") or die(mysqli_error($this->db->conn_id));
		}
	}
	
}
