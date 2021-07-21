<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/sparkpost_autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class Cron extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		
		$this->load->model("sparkpost_mail_model");
		
	}
	

	public function index(){
		
		$apiResponse = array();
		$apiResponse['sparkpost_api'] = 0;
		$apiResponse['twilio_chat_api'] = 0;
		
		
	//	echo '<br/>***************** <b>Cron for Sparkpost Email Flow</b> ********************** <br/><br/>';
		
		$sparkPostDetail = $this->query_model->getbySpecific('tbl_sparkpost_mail', 'id', 1);
		
		if(!empty($sparkPostDetail)){
			
			if($sparkPostDetail[0]->type == 1 && !empty($sparkPostDetail[0]->api_key)){
				
				$apiResponse['sparkpost_api'] = 1;
				
				$this->cron_for_sparkpost_email_flow();
				
			}
		}
		
		
		//echo '<br/><br/><br/>***************** <b>Cron for Twilio SMS Flow </b> ********************** <br/><br/>';
		
		$twilioChatApi = $this->query_model->getbySpecific('tbl_twilio_chat_api', 'id', 1);
		
		if(!empty($twilioChatApi)){
			
			if($twilioChatApi[0]->type == 1 && !empty($twilioChatApi[0]->sid) && !empty($twilioChatApi[0]->token)){
				
				$apiResponse['twilio_chat_api'] = 1;
				
				$this->cron_for_twilio_sms_flow_msgs();
				
			}
		}
		
		if($apiResponse['sparkpost_api'] == 0){
			echo 'SparkPost Email Api is not active or configuration issue <br/>';
		}
		
		if($apiResponse['twilio_chat_api'] == 0){
			echo 'Twilio chat Api is not active or configuration issue';
		}
		
	}
	
	
	
public function cron_for_sparkpost_email_flow(){
	
	
	
	$this->db->order_by('id','asc');
	$sparkpost_users = $this->query_model->getBySpecific('tbl_sparkpost_mail_users','is_stop_mail',0);
//	echo '<pre>'; print_r($sparkpost_users); die;
	if(!empty($sparkpost_users)){
		
		foreach($sparkpost_users as $sparkpost_user){
			
			if($sparkpost_user->email_flows_status == "pending" && $sparkpost_user->mail_template_type != "paid_trial_purchased"){
				
				$last_mail_template_type = $sparkpost_user->mail_template_type;
				
				/*$current_mail_template_type = str_replace('day_','',$last_mail_template_type);
				$current_mail_template_type_number = $current_mail_template_type + 1;
				$current_mail_template_type = 'day_'.$current_mail_template_type_number;
				echo '<pre>current_mail_template_type'; print_r($current_mail_template_type); die;*/
				
				$this->db->where("mail_flow_id",$sparkpost_user->mail_flow_id);
				$this->db->where("template_type !=","paid_trial_purchased");
				$this->db->where("template_type >",$last_mail_template_type);
				$this->db->order_by('template_type','asc');
				$this->db->limit(1);
				$current_sparkpost_mail_template = $this->query_model->getByTable('tbl_sparkpost_mail_templates');
				
				if(!empty($current_sparkpost_mail_template)){
					
					$current_mail_template_type_number = str_replace('day_','',$current_sparkpost_mail_template[0]->template_type);
					$current_mail_template_type = $current_sparkpost_mail_template[0]->template_type;
					
					if($current_mail_template_type_number <= 6){
					
						/*$this->db->where("mail_flow_id",$sparkpost_user->mail_flow_id);
						$this->db->where("template_type",$current_mail_template_type);
						$this->db->where("template_type !=","paid_trial_purchased");
						$current_sparkpost_mail_template = $this->query_model->getByTable('tbl_sparkpost_mail_templates');*/
						//echo '<pre>sparkpost_mail_templates'; print_r($current_sparkpost_mail_template); die;
						
						$this->db->select(array('id','mail_flow_id','template_type'));
						$this->db->where("mail_flow_id",$sparkpost_user->mail_flow_id);
						$this->db->where("template_type !=","paid_trial_purchased");
						$this->db->order_by('template_type','desc');
						$this->db->limit(1);
						$last_email_flow = $this->query_model->getByTable('tbl_sparkpost_mail_templates');
						
						
						if(!empty($current_sparkpost_mail_template)){
							
							$next_day_number = $current_mail_template_type_number - 1;
							
							$next_msg_created_date = date('Y-m-d',strtotime($sparkpost_user->created. " + $next_day_number days"));
							$current_date = date('Y-m-d');
							
							//echo $next_msg_created_date.'==>'.$current_date; die;
							
							if($next_msg_created_date == $current_date){
								
								
								$formData = array('name'=>$sparkpost_user->name,'email'=> $sparkpost_user->email,'location'=>'','last_name'=>'','phone'=>'','program'=>'','message'=>'');
								
								
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
								if($current_sparkpost_mail_template[0]->template_type == $last_email_flow[0]->template_type){
									$updateData['email_flows_status']  = 'all_sent';
									$updateData['is_stop_mail']  = 1;
								}
								$updateData['mail_template_type']  = $current_mail_template_type;
								$this->query_model->update('tbl_sparkpost_mail_users', $sparkpost_user->id, $updateData);
								
								echo 'Successfully send email template for '.$current_sparkpost_mail_template[0]->title.' to user ID: '.$sparkpost_user->id.'<br/>';
								
							}
							//echo $next_msg_created_date.'===>'.$current_date; die;
						}
						//echo '<pre>sparkpost_mail_templates'; print_r($sparkpost_mail_templates); die;
						
					}
				}
				
				
				
				
			}
		}
		
		echo 'Successfully send email flows for users<br/>';
		
	}else{
		echo 'No any user record for send email flows. <br/>';
	}
	
} 
	
	
	
public function cron_for_twilio_sms_flow_msgs(){
	
	
	$this->db->order_by('id','desc');
	$this->db->select(array('id','name','phone','sms_flows_status','chat_conversation_sid','sms_flow_id','msg_template_type','lead_created'));
	$this->db->where('sms_flows_status','pending');
	$this->db->where('conversation_type','user');
	$this->db->where('sms_flow_id !=',0);
	$twilio_users = $this->query_model->getBySpecific('twilio_sms_users','is_msg_sent_by_phone',0);
	
	//echo '<pre>twilio_users'; print_r($twilio_users); die;
	
	
	if(!empty($twilio_users)){
		
		date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
		
		foreach($twilio_users as $twilio_user){
			
			if($twilio_user->sms_flows_status == "pending" && !empty($twilio_user->msg_template_type)){
				
				$last_msg_template_type = $twilio_user->msg_template_type;
				
				$this->db->where("sms_flow_id",$twilio_user->sms_flow_id);
				$this->db->where("template_type !=","paid_trial_template");
				$this->db->where("template_type !=","admin_sms_template");
				$this->db->where("template_type >",$last_msg_template_type);
				$this->db->order_by('convert (SUBSTRING(template_type, POSITION("_" IN template_type ) + 1 , LENGTH(template_type)), signed) ASC');
				$this->db->limit(1);
				$current_twilio_msg_template = $this->query_model->getByTable('tbl_twilio_sms_templates');
				//echo '<pre>current_twilio_msg_template'; print_r($current_twilio_msg_template); die;
			if(!empty($current_twilio_msg_template)){
				
				/*$current_msg_template_type = str_replace('day_','',$last_msg_template_type);
				$current_msg_template_type_number = $current_msg_template_type + 1;
				$current_msg_template_type = 'day_'.$current_msg_template_type_number;*/
				
				$current_msg_template_type_number = str_replace('day_','',$current_twilio_msg_template[0]->template_type);
				$current_msg_template_type = $current_twilio_msg_template[0]->template_type;
				//echo '<pre>current_twilio_msg_template'; print_r($current_twilio_msg_template);
				if($current_msg_template_type_number <= 14){
					
					/*$this->db->where("sms_flow_id",$twilio_user->sms_flow_id);
					$this->db->where("template_type",$current_msg_template_type);
					$this->db->where("template_type !=","paid_trial_template");
					$this->db->where("template_type !=","admin_sms_template");
					$current_twilio_msg_template = $this->query_model->getByTable('tbl_twilio_sms_templates');*/
					
					
					$this->db->where("sms_flow_id",$twilio_user->sms_flow_id);
					$this->db->where("template_type !=","paid_trial_template");
					$this->db->where("template_type !=","admin_sms_template");
					$this->db->order_by('convert (SUBSTRING(template_type, POSITION("_" IN template_type ) + 1 , LENGTH(template_type)), signed) DESC');
					$this->db->limit(1);
					$last_sms_flow = $this->query_model->getByTable('tbl_twilio_sms_templates');
					//echo '<pre>last_sms_flow'; print_r($last_sms_flow); die;
					
					if(!empty($current_twilio_msg_template)){
						
						$next_day_number = $current_msg_template_type_number - 1;
						
						$next_msg_created_date = date('Y-m-d',strtotime($twilio_user->lead_created . " + $next_day_number days"));
						$current_date = date('Y-m-d');
						
						$start_sms_time = $current_twilio_msg_template[0]->send_sms_time;
						$end_sms_time = date('H:i', strtotime($current_twilio_msg_template[0]->send_sms_time . "+ 1 hour"));
						$current_time = date("H:i");
								
						//echo $next_msg_created_date.'=>'.$current_date.'=>'.$start_sms_time.'=>'.$current_time; die;
						if($next_msg_created_date == $current_date && $start_sms_time <= $current_time &&  $end_sms_time >= $current_time ){
							//die('new1 success');		
							$phone = (!empty($twilio_user->phone)) ? $twilio_user->phone : '';
							
							$formData = array('name'=>$twilio_user->name,'phone'=> $phone,'location'=>'','last_name'=>'','email'=>'','program'=>'','message'=>'');
							$msg_template = $this->query_model->replaceAutoResponderVaribles($current_twilio_msg_template[0]->msg_template, $formData, '');
							
							
							$insertSMSData = array();
							$insertSMSData['sender_by'] = 'admin';
							$insertSMSData['admin_id'] = 0;
							$insertSMSData['sms_users_id'] = $twilio_user->id;
							$insertSMSData['message'] = $msg_template;
							$insertSMSData['template_msg_type'] = $current_twilio_msg_template[0]->template_type;
							$insertSMSData['template_msg_status'] = "sent";
							$insertSMSData['created'] = date('Y-m-d H:i:s');
							
				
							$this->query_model->insertData('twilio_sms_messenger',$insertSMSData);
							$twilio_sms_msg_id = $this->db->insert_id();
							
							$updateTwilioUserData = array();
							$updateTwilioUserData['msg_template_type'] = $current_twilio_msg_template[0]->template_type;
							$this->query_model->update('twilio_sms_users', $twilio_user->id, $updateTwilioUserData);
							
							$author_name = 'Dojo Admin';
							$newMsgData = array('twilio_user_id' => $twilio_user->id,'reciever_by'=>'student','phone'=>$phone,'msg_type'=>'admin_to_student','message'=>$msg_template,'twilio_sms_msg_id'=>$twilio_sms_msg_id,'author_name'=>$author_name,'twilio_user_name'=>$twilio_user->name);
							
							
							$twilio_message_id = $this->query_model->sendMsgTwilioChatApi($newMsgData);
							
							
							if(!empty($last_sms_flow) && $last_sms_flow[0]->template_type == $current_twilio_msg_template[0]->template_type){
								
								$updateUserData = array('sms_flows_status'=>'all_sent');
								$this->query_model->update('twilio_sms_users', $twilio_user->id, $updateUserData);
								
							}
							
							//echo 'Twilio Message: '.$twilio_message_id.'<br/>'; die;
							
							echo 'Successfully send twilio sms flow to user ID: '.$twilio_user->id.' and twilio message ID is '.$twilio_message_id.'<br/>'; 
									
						}
					}
					
					
					//die('pass');
					
					}
				}
				
			}else{
				echo 'Error: msg_template_type is blank in twilio user ID:'.$twilio_user->id.'<br/>';
			}
		}
	}else{
		echo 'No any user record for send sms flows. <br/>';
	}
	
}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
