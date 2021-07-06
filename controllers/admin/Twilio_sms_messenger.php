<?php 
class Twilio_sms_messenger extends CI_Controller{
	

	function index(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
	
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "SMS messenger";
			$data['link_type'] = "twilio_sms_messenger";
			
			$data['lead_users'] = $this->db->query("SELECT `id`,`name`,`phone`,`last_updated_date`, (select count(*) from twilio_sms_messenger where sms_users_id = twilio_sms_users.id and is_read_msg = 0  and sender_by = 'student' ) as total_msgs FROM `twilio_sms_users` WHERE is_deleted = 0 and  conversation_type != 'admin' order by last_updated_date DESC")->result();
			
			/*date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
			if (date_default_timezone_get()) {
				echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
			}*/
			
			$this->load->view('admin/twilio_sms_messenger',$data);
		
		}else{
			redirect("admin/login");
		}

	}
	
	public function get_twilio_user_msgs(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
	
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if(isset($_POST['action']) && $_POST['action'] == "get_user_msgs" ){
				
				$user_id = (isset($_POST['user_id']) && !empty($_POST['user_id'])) ? $_POST['user_id'] : '';
				
				if(!empty($user_id)){
					
					$this->db->set('is_read_msg',1);
					$this->db->where('sms_users_id',$user_id);
					$this->db->update('twilio_sms_messenger');
					
					$this->db->select(array('id','name','phone','last_updated_date','chat_conversation_sid'));
					$this->db->order_by('last_updated_date','desc');
					$this->db->where('id',$user_id);
					$data['sms_user_detail'] = $this->query_model->getbySpecific('twilio_sms_users','is_deleted',0);
					
					
					$this->db->select(array('id','sender_by','message','created','chat_message_sid','template_msg_status'));
					$this->db->order_by('created','asc');
					$this->db->where('sms_users_id',$user_id);
					$data['messages'] = $this->query_model->getbySpecific('twilio_sms_messenger','is_deleted',0);
					//echo '<pre>data'; print_r($data); die;
					$this->load->view('admin/ajax_twilio_user_msgs', $data);
					
				}
			}
		}
	}
	
	
	public function save_text_message(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		$admin_user_id = $this->session->userdata('userid');
	
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
			
			if(isset($_POST['action']) && $_POST['action'] == "send_msg"){
				
				$user_id = (isset($_POST['user_id']) && !empty($_POST['user_id'])) ? $_POST['user_id'] : '';
				$message = (isset($_POST['message']) && !empty($_POST['message'])) ? $_POST['message'] : '';
				
				if(!empty($user_id) && !empty($message)){
					
					$insertData = array();
					$insertData['sender_by'] = 'admin';
					$insertData['admin_id'] = $admin_user_id;
					$insertData['sms_users_id'] = $user_id;
					$insertData['message'] = $message;
					$insertData['created'] = date('Y-m-d H:i:s');
					
					$this->query_model->insertData('twilio_sms_messenger',$insertData);
					$twilio_sms_msg_id = $this->db->insert_id();
					
					
					$updateData = array();
					$updateData['last_updated_date']  =  date('Y-m-d H:i:s');
					$this->query_model->update('twilio_sms_users', $user_id, $updateData);
					//echo '<pre>insertData'; print_r($insertData); die;
					
					
					/**** code for send twilio msg ****/
					$this->db->select(array('id','phone','name'));
					$user_detail = $this->query_model->getBySpecific('twilio_sms_users','id',$user_id);
					$phone = (!empty($user_detail) && !empty($user_detail[0]->phone)) ? $user_detail[0]->phone : '';
					$author_name = 'Dojo Admin';
					
					$msgData = array('twilio_user_id' => $user_id,'reciever_by'=>'student','phone'=>$phone,'msg_type'=>'admin_to_student','message'=>$message,'twilio_sms_msg_id'=>$twilio_sms_msg_id,'author_name'=>$author_name,'twilio_user_name'=>$user_detail[0]->name);
					
					//echo '<pre>msgData'; print_r($msgData); die;
					$this->query_model->sendMsgTwilioChatApi($msgData);
					
					
					$responseData = array('message' => $message,'new_created'=> date('h:i a'));
					echo json_encode($responseData); die;
				}
				
			}
		}
	}
	

public function get_twilio_user_info(){
	
		$is_logged_in = $this->session->userdata('is_logged_in');
		$admin_user_id = $this->session->userdata('userid');
		
		$resultArr = array();
		$resultArr['response'] = 0;
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if(isset($_POST['action']) && $_POST['action'] == "get_user_info"){
				
				$user_id = (isset($_POST['user_id']) && !empty($_POST['user_id'])) ? $_POST['user_id'] : '';
				
				if(!empty($user_id)){
					
					$this->db->select(array('id','name','phone','last_updated_date'));
					$user_detail = $this->query_model->getBySpecific('twilio_sms_users','id',$user_id);
					
					if(!empty($user_detail)){
						$resultArr['response'] = 1;
						$resultArr['twilio_user_detail'] = $user_detail[0];
						$resultArr['last_updated_date']= $this->query_model->getTimeAgo($user_detail[0]->last_updated_date);
					}
				}
			}
		}
	
	//echo '<pre>resultArr'; print_r($resultArr); die;
	echo json_encode($resultArr); die;
}


public function get_twilio_user_conversations(){
	
	$this->query_model->getAllTwilioUserConversations();
	
	$lead_users = $this->db->query("SELECT `id`,`last_updated_date`,(select count(*) from twilio_sms_messenger where sms_users_id = twilio_sms_users.id and is_read_msg = 0  and sender_by = 'student' ) as total_msgs FROM `twilio_sms_users` WHERE is_deleted = 0 and  conversation_type != 'admin' order by last_updated_date DESC")->result();
	
	$result = array();
	$result['response'] = 0;
	if(!empty($lead_users)){
		
		foreach($lead_users as $lead_user){
			
			if($lead_user->total_msgs > 0){
				$result['record'][$lead_user->id]['id'] = $lead_user->id;
				$result['record'][$lead_user->id]['total_msgs'] = $lead_user->total_msgs;
				$result['record'][$lead_user->id]['last_updated_date'] = $this->query_model->getTimeAgo($lead_user->last_updated_date);
				
			}
		}
	}
	
	if(isset($result['record']) && !empty($result['record'])){
		$result['response'] = 1;
	
	}
	
	echo json_encode($result); die;
	//echo json_encode($lead_users); die;
	
}


public function ajax_delete_twilio_msg(){
	
	$is_logged_in = $this->session->userdata('is_logged_in');
	$result = 0;
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if(isset($_POST['action']) && $_POST['action'] == "delete_msg"){
				
				$chat_conversation_sid = (isset($_POST['chat_conversation_sid']) && !empty($_POST['chat_conversation_sid'])) ? $_POST['chat_conversation_sid'] : '';
				$chat_message_sid = (isset($_POST['chat_message_sid']) && !empty($_POST['chat_message_sid'])) ? $_POST['chat_message_sid'] : '';
				$twilio_user_id = (isset($_POST['twilio_user_id']) && !empty($_POST['twilio_user_id'])) ? $_POST['twilio_user_id'] : '';
				
				
				if(!empty($chat_conversation_sid) && !empty($chat_message_sid) && !empty($twilio_user_id)){
					
					$twilioChatApi = $this->query_model->getbySpecific('tbl_twilio_chat_api','id',1);
	
					if(!empty($twilioChatApi) && $twilioChatApi[0]->type == 1){
						
						if(!empty($twilioChatApi[0]->sid) && !empty($twilioChatApi[0]->token) ){
							
									
								require_once './vendor/Twilio/autoload.php';
								include("./vendor/Twilio/Rest/Client.php");
								
								$sid    = $twilioChatApi[0]->sid; # test sid
								$token  = $twilioChatApi[0]->token;# test token
								
								$twilio = new Twilio\Rest\Client($sid, $token);
								
								$delete_msg = $twilio->conversations->v1->conversations($chat_conversation_sid)
																	  ->messages($chat_message_sid)
																		  ->delete();
								
								
								
								$this->db->where('sms_users_id', $twilio_user_id);
								$this->db->where('chat_message_sid', $chat_message_sid);
								$this->db->delete('twilio_sms_messenger');
				
								$result = 1;	
									
						}
					}
									
									
					
					
				}
			}
		}
		
		echo $result; die;
}


public function cron_for_twilio_sms_flow_msgs(){
	
	$this->db->order_by('id','desc');
	$this->db->select(array('id','name','phone','sms_flows_status','chat_conversation_sid'));
	$this->db->where('conversation_type','user');
	$twilio_users = $this->query_model->getBySpecific('twilio_sms_users','is_msg_sent_by_phone',0);
	
	if(!empty($twilio_users)){
		
		date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
		
		$this->db->select(array('id','days','start_time','msg_type','msg_template'));
		$this->db->where("msg_type","second_sms_template");
		$twilio_sms_flows = $this->query_model->getByTable('tbl_twilio_sms_flows');
		
		foreach($twilio_users as $twilio_user){
			
			if($twilio_user->sms_flows_status == "pending"){
				
				
				/*$this->db->select(array('id','start_time','msg_type'));
				$this->db->where("msg_type","opt_in_form_template");
				$this->db->or_where("msg_type","trial_offer_template");
				$pending_twilio_sms_flows = $this->query_model->getByTable('tbl_twilio_sms_flows');
				
				if(!empty($pending_twilio_sms_flows)){
					foreach($pending_twilio_sms_flows as $pending_sms_flow){
						//echo '<pre>pending_sms_flow'; print_r($pending_sms_flow); die;
						$first_flow_start_time = $pending_sms_flow->start_time;
						$first_current_time = date("H:i"); 
						
						
						if($first_flow_start_time <= $first_current_time){
							
							$this->db->where('template_msg_type',$pending_sms_flow->msg_type);
							$this->db->where('template_msg_status','hold');
							$this->db->where('created <',date('Y-m-d'));
							$hold_template_1_msgs =  $this->query_model->getBySpecific('twilio_sms_messenger','sms_users_id',$twilio_user->id);
							
							if(!empty($hold_template_1_msgs)){
								
								foreach($hold_template_1_msgs as $hold_template_1_msg){
									
									$phone = (!empty($twilio_user->phone)) ? $twilio_user->phone : '';
									
									$msgData = array('twilio_user_id' => $twilio_user->id,'reciever_by'=>'student','phone'=>$phone,'msg_type'=>'admin_to_student','message'=>$hold_template_1_msg->message,'twilio_sms_msg_id'=>$hold_template_1_msg->id);
									
									$this->query_model->sendMsgTwilioChatApi($msgData);
									
									$smsUpdateData['template_msg_status']  =  'sent';
									$this->query_model->update('twilio_sms_messenger', $hold_template_1_msg->id, $smsUpdateData);
							
								}
								//die('pass');
							}
						}else{
							//die('0');
						}
					}
				}*/
				
				
				//die('complete step 1');
				/******* sending other sms accoding  flow *********/
				
				if(!empty($twilio_sms_flows)){
					$i = 1;
					foreach($twilio_sms_flows as $twilio_sms_flow){
						
						
						//$twilio_user->id = 15;
						$this->db->limit(1);
						$this->db->select(array('id'));
						$this->db->where('template_msg_type',$twilio_sms_flow->msg_type);
						$pending_sms_flows =  $this->query_model->getBySpecific('twilio_sms_messenger','sms_users_id',$twilio_user->id);
						
						//echo '<pre>pending_sms_flows'; print_r($pending_sms_flows); die;
						
						/*$this->db->limit(1);
						$this->db->select(array('id'));
						$this->db->where('template_msg_type',"opt_in_form_template");
						$send_first_template =  $this->query_model->getBySpecific('twilio_sms_messenger','sms_users_id',$twilio_user->id);*/
						
						
						
						if(empty($pending_sms_flows)){
							
							/*$last_template_type = str_replace('template_','',$twilio_sms_flow->msg_type);
							$last_template_type = $last_template_type - 1;
							$last_template_type = 'template_'.$last_template_type;*/
						
							
							$this->db->limit(1);
							$this->db->order_by("id","DESC");
							//$this->db->where('template_msg_type',$last_template_type);
							$this->db->where("template_msg_type","opt_in_form_template");
							$this->db->or_where("template_msg_type","trial_offer_template");
							$this->db->select(array('id','template_msg_type','created'));
							$user_last_template_msg = $this->query_model->getBySpecific('twilio_sms_messenger','sms_users_id',$twilio_user->id);
							
							if(!empty($user_last_template_msg)){
								
								/*$next_days = $twilio_sms_flow->days;
								$next_msg_created_date = date('Y-m-d',strtotime($user_last_template_msg[0]->created. " + $next_days days"));
								$current_date = date('Y-m-d');
								
								$flow_start_time = $twilio_sms_flow->start_time;
								$current_time = date("H:i");
								
								
								if($next_msg_created_date == $current_date && $flow_start_time <= $current_time){*/
									
									$phone = (!empty($twilio_user->phone)) ? $twilio_user->phone : '';
									
									$formData = array('name'=>$twilio_user->name,'phone'=> $phone,'location'=>'','last_name'=>'','email'=>'','program'=>'','message'=>'');
									$msg_template = $this->query_model->replaceAutoResponderVaribles($twilio_sms_flow->msg_template, $formData, '');
									
									
						
									$insertSMSData = array();
									$insertSMSData['sender_by'] = 'admin';
									$insertSMSData['admin_id'] = 0;
									$insertSMSData['sms_users_id'] = $twilio_user->id;
									$insertSMSData['message'] = $twilio_sms_flow->msg_template;
									$insertSMSData['template_msg_type'] = $twilio_sms_flow->msg_type;
									$insertSMSData['template_msg_status'] = "sent";
									$insertSMSData['created'] = date('Y-m-d H:i:s');
									
									$this->query_model->insertData('twilio_sms_messenger',$insertSMSData);
									$twilio_sms_msg_id = $this->db->insert_id();
									
						
									$newMsgData = array('twilio_user_id' => $twilio_user->id,'reciever_by'=>'student','phone'=>$phone,'msg_type'=>'admin_to_student','message'=>$msg_template,'twilio_sms_msg_id'=>$twilio_sms_msg_id);
									
									$twilio_message_id = $this->query_model->sendMsgTwilioChatApi($newMsgData);
									
									
									if(count($twilio_sms_flows) == $i){
										
										$updateUserData = array('sms_flows_status'=>'all_sent');
										$this->query_model->update('twilio_sms_users', $twilio_user->id, $updateUserData);
										
									}
									
									echo 'Twilio Message: '.$twilio_message_id.'<br/>';
									
								//}
								
								
							}
							
						}
						
						$i++;
					}
				}
				
			}else{
				echo "Cron runned:  no any pending sms flows for User ID ".$twilio_user->id.".<br/>";
			}
		}
	}
	
}

public function ajax_delete_twilio_conversaction(){
	
		$is_logged_in = $this->session->userdata('is_logged_in');
	
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$result = 0;
			parse_str($_POST['formData'], $searcharray);
		
			$twilio_user_id = isset($searcharray['delete-item-id']) ? $searcharray['delete-item-id'] : 0;
			
			if(!empty($twilio_user_id)){
				
				$this->db->where('conversation_type','user');
				$user_detail = $this->query_model->getBySpecific('twilio_sms_users','id',$twilio_user_id);
				if(!empty($user_detail)){
					if(!empty($user_detail[0]->chat_conversation_sid) && !empty($user_detail[0]->chat_participant_sid)){
						
						$twilioChatApi = $this->query_model->getbySpecific('tbl_twilio_chat_api','id',1);
	
						if(!empty($twilioChatApi) && $twilioChatApi[0]->type == 1){
							
							if(!empty($twilioChatApi[0]->sid) && !empty($twilioChatApi[0]->token) ){
								
										
									require_once './vendor/Twilio/autoload.php';
									include("./vendor/Twilio/Rest/Client.php");
									
									$sid    = $twilioChatApi[0]->sid; # test sid
									$token  = $twilioChatApi[0]->token;# test token
									
									$twilio = new Twilio\Rest\Client($sid, $token);
									
									try{
										$delete_participant = $twilio->conversations->v1
																		->conversations($user_detail[0]->chat_conversation_sid)
																		->participants($user_detail[0]->chat_participant_sid)
																		->delete();
									}catch (Exception $e) {
										//echo 'delete_participant Caught exception: ',  $e->getMessage(), "\n"; die;
									}
									
									try{
										$delete_conversation = $twilio->conversations->v1
																		->conversations($user_detail[0]->chat_conversation_sid)
																		->delete();
									}catch (Exception $e) {
										//echo 'delete_conversation Caught exception: ',  $e->getMessage(), "\n"; die;
									}
									
									
										
							}
						}
					}
					
					$this->db->where('sms_users_id', $twilio_user_id);
					$this->db->delete('twilio_sms_messenger');
					
					$this->db->where('id', $twilio_user_id);
					$this->db->delete('twilio_sms_users');
	
					$result = 1;
					
				}
			}
			
			echo $result; die;
			
		}else{
			redirect("admin/login");
		}
		
		
}

public function ajax_send_twilio_new_sms_popup_form(){
	
		if(isset($_POST['action_type']) && !empty($_POST['action_type'])){
			//echo '<pre>POST'; print_r($_POST); die;
			$records = array();
			$records['detail'] = array();
			$records['action_type'] = $_POST['action_type'];
			$records['lead_type'] = $_POST['lead_type'];
			$records['lead_id'] = $_POST['lead_id'];
			$records['email'] = $_POST['email'];
			$records['phone'] = $_POST['phone'];
			$records['name'] = $_POST['name'];
			$records['form_type'] = $_POST['form_type'];
			$records['table_name'] = 'twilio_sms_users'; 
			//$records['link_type'] = 'albums';
			//echo '<pre>records'; print_r($records); 
			
			$this->load->view("admin/ajax_send_twilio_new_sms_popup_form", $records);
			
			
		}
}


public function ajax_send_twilio_new_sms(){
	
	parse_str($_POST['formData'], $searcharray);
		//echo '<pre>searcharray'; print_r($searcharray); die;
		//echo '<pre>searcharray'; print_r($_POST); die;
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['update'])){
					
				$name = isset($searcharray['name']) ? trim($searcharray['name']) : '';
				$phone = isset($searcharray['lead_phone']) ? trim($searcharray['lead_phone']) : '';
				$message = isset($searcharray['message']) ? trim($searcharray['message']) : '';
				$lead_type = isset($searcharray['lead_type']) ? $searcharray['lead_type'] : '';
				$lead_id = isset($searcharray['lead_id']) ? trim($searcharray['lead_id']) : '';
				
				if(!empty($phone) && !empty($message)){
					
					$twilio_user_detail = $this->query_model->getBySpecific('twilio_sms_users','phone',$phone);
				
					if(empty($twilio_user_detail)){
						
						$leadTypes = array('dojocart_lead'=>'tbl_dojocart_orders','birthday_party_lead'=>'tblbirthdayparty','trial_offer_lead'=>'tblorders');
						$new_lead_type = $this->query_model->getKanbanLeadTypeToOrderType($lead_type);
						$lead_table_name = isset($leadTypes[$new_lead_type]) ? $leadTypes[$new_lead_type] : '';
						
						$twilio_user_lead_type = 'custom_lead';
						$twilio_sms_template = 'custom_message';
						
						$orderDetail = $this->query_model->getBySpecific($lead_table_name,'id',$lead_id);
						if(!empty($orderDetail)){
							if($lead_table_name == "tblorders"){
								if($orderDetail[0]->offer_type == "Free" || $orderDetail[0]->offer_type == "Paid"){
									$twilio_user_lead_type = 'trial_forms';
									$twilio_sms_template = 'trial_offer_template';
								}else{
									$twilio_user_lead_type = 'opt_in_form';
									$twilio_sms_template = 'opt_in_form_template';
								}
							}elseif($lead_table_name == "tblbirthdayparty"){
								$twilio_user_lead_type = 'opt_in_form';
								$twilio_sms_template = 'opt_in_form_template';
							}
						}
						
						//echo $twilio_user_lead_type.'==>'.$twilio_sms_template; die;
						$twilioUserArr = array();
						$twilioUserArr['name'] = $name;
						$twilioUserArr['phone'] = $phone;
						$twilioUserArr['conversation_type'] = 'user';
						$twilioUserArr['lead_type'] = $twilio_user_lead_type;
						$twilioUserArr['lead_id'] = $lead_id;
						$twilioUserArr['last_updated_date'] = date('Y-m-d H:i:s');
						
						//echo '<pre>twilioUserArr'; print_r($twilioUserArr); die;
						$this->query_model->insertData('twilio_sms_users',$twilioUserArr);
						$twilio_user_id = $this->db->insert_id();
						
						$this->db->select(array('id','name','phone'));
						$twilio_user_detail = $this->query_model->getBySpecific('twilio_sms_users','phone',$phone);
							
						if(!empty($twilio_user_detail)){
						
							$template_msg_status = "sent";
								
							//$msg_template = $this->query_model->replaceAutoResponderVaribles($message, $formData, '');
							$formData = array('name'=>$twilio_user_detail[0]->name,'phone'=> $twilio_user_detail[0]->phone,'location'=>'','last_name'=>'','email'=>'','program'=>'','message'=>'');
							$msg_template = $this->query_model->replaceAutoResponderVaribles($message, $formData, '');
							
							$insertSMSData = array();
							$insertSMSData['sender_by'] = 'admin';
							$insertSMSData['admin_id'] = 0;
							$insertSMSData['sms_users_id'] = $twilio_user_id;
							$insertSMSData['message'] = $message;
							$insertSMSData['template_msg_type'] = $twilio_sms_template;
							$insertSMSData['template_msg_status'] = $template_msg_status;
							$insertSMSData['created'] = date('Y-m-d H:i:s');
							
							$this->query_model->insertData('twilio_sms_messenger',$insertSMSData);
							$twilio_sms_msg_id = $this->db->insert_id();
							
							$phone = $twilio_user_detail[0]->phone;
							$author_name = 'Dojo Admin';
							//$msg_template = 'hello us1';
							$msgData = array('twilio_user_id' => $twilio_user_id,'reciever_by'=>'student','phone'=>$phone,'msg_type'=>'admin_to_student','message'=>$msg_template,'twilio_sms_msg_id'=>$twilio_sms_msg_id,'author_name'=>$author_name,'twilio_user_name'=>$twilio_user_detail[0]->name);
							
							//echo '<prE>msgData'; print_r($msgData); die;
							$this->query_model->sendMsgTwilioChatApi($msgData);
							
							$result['res'] = 1;
							
						}
					}else{
						$result['res'] = 2;
					}
					
					
					$result['lead_type'] = $lead_type;
					$result['lead_id'] = $lead_id;
					$result['phone'] = $phone;
					
				}
				
				
					
				
			}
		echo json_encode($result); 
		
}

public function twilio_msgs(){
		
		$twilioChatApi = $this->query_model->getbySpecific('tbl_twilio_chat_api','id',1);
	
		if(!empty($twilioChatApi) && $twilioChatApi[0]->type == 1){
			
			if(!empty($twilioChatApi[0]->sid) && !empty($twilioChatApi[0]->token) ){
				
						
						include_once './vendor/Twilio/autoload.php';
						include_once("./vendor/Twilio/Rest/Client.php");
						
						$sid    = $twilioChatApi[0]->sid; # test sid
						$token  = $twilioChatApi[0]->token;# test token
						
						$twilio = new Twilio\Rest\Client($sid, $token);
						
						$messages = $twilio->conversations->v1->conversations('CHa004302ab6664830892f677dd0bca921')
                                      ->messages
                                      ->read(2000);
									  
						echo '<pre>client_messages'; print_r($messages);
						
						$admin_messages = $twilio->conversations->v1->conversations('CH4473e8caa9bc401db749882ea2b97684')
                                      ->messages
                                      ->read(2000);
									  
						echo '<pre>admin_messages'; print_r($admin_messages); die;
						
						
			}
		}
}

}
