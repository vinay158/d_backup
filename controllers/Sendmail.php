<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendmail extends CI_Controller {

	public function index()
	{
	}
	
	public function send(){
		
		date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
		
		//echo '<pre>POST'; print_r($_POST); die;
		/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		$this->query_model->checkHunneyPostForBirthdayForm($_POST);
			
		
		$data = array();
		$insert_data = array();
		
		if(isset($_POST['email']) && empty($_POST['email'])){	
			$this->load->library("email");		
			$query = $this->query_model->getbyTable('tblsite');
			foreach($query as $row):
				$site_email = $row->email;
				$school_name = $row->title;
				$text_address = $row->text_address;
				$bdy_form_location_dropdown = $row->bdy_form_location_dropdown;
			endforeach;
			
			$mainLocation = $this->query_model->getMainLocation("tblcontact");
			
			
			
			$insert_data['name'] = $sender = $_POST['bday_name'];
			$insert_data['last_name'] = $last_name = $_POST['last_name'];
			$program_type = isset($_POST['program_type']) ? $_POST['program_type'] : '';
			
			$reserve_or_schedule = '';
			$call_or_schedule = '';
			$body_call_or_schedule = '';
			if($program_type == "summer_camp"){
				$reserve_or_schedule = isset($_POST['reserve_or_schedule']) ? $_POST['reserve_or_schedule'] : '';
				$insert_data['reserve_or_schedule'] = $reserve_or_schedule;
				$extraContentArr = array('bdy_reserve_or_schedule' => $reserve_or_schedule);
			
				$form_type = "summer_camp_program_form";
			}else{
				$call_or_schedule = ($_POST['call_or_schedule']=='call') ? 'Call Me' : 'Schedule a Party';
			
				$body_call_or_schedule = ($_POST['call_or_schedule']=='call') ? 'Call Me With More Information' : 'Schedule a Birthday Party';
				
				$party_date = $_POST['party_date'];
			
				$insert_data['party_date'] = $party_date;
				
				$insert_data['guests'] = $guest =$_POST['party_guests'];
				
				$bdy_party_date = isset($_POST['party_date']) ? $_POST['party_date'] : '';
				$bdy_guest = isset($_POST['party_guests']) ? $_POST['party_guests'] : '';
				$extraContentArr = array('bdy_call_or_schedule' => $_POST['call_or_schedule'], 'bdy_party_date'=>$bdy_party_date, 'bdy_guest' => $bdy_guest);
				
				$form_type = "birthday_program_form";
			}
			
			
			$type = 'Birthday Parties | '.$school_name.' | '.$sender.' '.$last_name;//$sender . " - Birthday Form | " . $call_or_schedule;
			$insert_data['email'] = $sender_email = $_POST['bday_email'];
			$insert_data['phone'] = $phone = $_POST['bday_phone'];
			
			//$insert_data['ip_address'] = isset($_POST['ip_address']) ? $_POST['ip_address'] : '';
			$insert_data['gdpr_compliant_checkbox'] = isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : 0;
			
			$insert_data['location_id'] = isset($_POST['school_interest']) ? $_POST['school_interest'] : $mainLocation[0]->id;
			$insert_data['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0;
			$ipAddress = $this->query_model->getCountryNameToIpAddress();
			$insert_data['ip_address'] = $ipAddress['client_ip_address'];
			$insert_data['client_country_name'] = $ipAddress['client_country_name'];
			$insert_data['request_detail'] = isset($_SERVER) ? serialize($_SERVER) : '';
			$insert_data['date_added'] =  date('Y-m-d H:i:s');
			//$month = $_POST['party_date_month'];
			//$day = $_POST['party_date_day'];
			
			
			
			$this->query_model->insertData('tblbirthdayparty', $insert_data);
			
			$order_id = $this->db->insert_id();
			if(!empty($order_id)){
				
				$leadTypeArr = array('lead_type'=>'opt_in_form','lead_id'=>$order_id);
				$this->query_model->saveMsgFromTwilioChatApi($_POST, $leadTypeArr);
				
				$this->query_model->sendEmailFromSparkpostApi($_POST, $leadTypeArr);
				
				$this->query_model->updateOrderForKabanLeads($order_id,'tblbirthdayparty','Birthday Party Opt-in',$_POST);
				
					
			}
			
			
			$location_detail = $this->query_model->getMainLocation();
			//echo '<pre>'; print_r($location_detail); die;
			
			
			
			
			/*********RainMark Code ******/
			
			$_POST['party_date'] = isset($_POST['party_date']) ? $_POST['party_date'] : '';
			$_POST['party_guests'] = isset($_POST['party_guests']) ? $_POST['party_guests'] : '';
			$_POST['program_type'] = isset($_POST['program_type']) ? $_POST['program_type'] : '';
			$_POST['ip_address'] = isset($_POST['ip_address']) ? $_POST['ip_address'] : '';
			$_POST['gdpr_compliant_checkbox'] = isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : 0;
			$_POST['location_id'] = isset($_POST['school_interest']) ? $_POST['school_interest'] : $mainLocation[0]->id;
			$_POST['program_id'] = isset($_POST['program_id']) ? $_POST['program_id'] : 0;
			
			$call_or_schedule = (isset($_POST['call_or_schedule']) && $_POST['call_or_schedule'] == "call") ? "Call Me With More Information" : 'Schedule a Birthday Party';
			$reserve_or_schedule = isset($_POST['reserve_or_schedule']) ? $_POST['reserve_or_schedule'] : '';
			$twilio_checkbox = isset($_POST['twilio_checkbox']) ? $_POST['twilio_checkbox'] : 0;
			
			
			$post_data = array('name' => $_POST['bday_name'], 'last_name' => $_POST['last_name'],'form_email_2' => $_POST['bday_email'],'phone' => $_POST['bday_phone'], 'page_url' =>  $_POST['page_url'],'party_date'=>$_POST['party_date'],'party_guests'=>$_POST['party_guests'],'program_type'=>$_POST['program_type'],'call_or_schedule'=>$call_or_schedule,'reserve_or_schedule'=>$reserve_or_schedule,'twilio_checkbox'=>$twilio_checkbox,'ip_address'=>$_POST['ip_address'],'gdpr_compliant_checkbox'=>$_POST['gdpr_compliant_checkbox'],'location_id' => $_POST['location_id'],'program_id' => $_POST['program_id']);
			//echo '<pre>post_data'; print_r($post_data); die;
		
		$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
		if($multiLocationData[0]->field_value == 1 && $bdy_form_location_dropdown == 1){
			//$mainLocationData = $this->query_model->getMainLocation();
			$mainLocationData = $this->query_model->getBySpecific('tblcontact','id',$_POST['location_id']);
			//echo '<pre>mainLocationData'; print_R($mainLocationData); die;
			$text_address = !empty($mainLocationData) ? $mainLocationData[0]->text_address : '';
			$noreply_email_address = !empty($mainLocationData) ? $mainLocationData[0]->email : '';
		}else{
			$siteSettingData = $this->query_model->getbyTable('tblsite');
			$text_address = $siteSettingData[0]->text_address;
			$noreply_email_address = $siteSettingData[0]->email;
		}
			
		/** checkFormModuleApplyAPI 						
		* this function for using apis according form model 						
		*/								
		$this->query_model->checkFormModuleApplyAPI($post_data);
		
		$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($post_data, $extraContentArr);
		
		
		// sending msg by twillio api
		
		$this->query_model->connectFormToTwillioAPi($post_data,$form_type,$extraContentArr);
		
		
		
			/******</End Code >*****/
		$extraContent1 = $extraContent2 = '';
		$extraContent1 = $body_call_or_schedule;
		if($_POST['program_type'] == "birthday_page"){
			if(isset($_POST['call_or_schedule']) && !empty($_POST['call_or_schedule'])) {
				if($_POST['call_or_schedule'] !='call'){
					$extraContent2 = 'We are interested in scheduling a birthday on '.$party_date.'.</p><p>Expected number of guests is '.$guest;
				}
				
			}
		}
		
		
		
		
		$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($post_data,$form_type,$extraContentArr);
		$type = '';
		$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


		if(!empty($text_address) && !empty($mes)){
			
			//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			$config['charset'] = 'UTF-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype']="html";
			$this->email->initialize($config);
			//$this->email->from($sender_email);
			
			if(!empty($fromEmailId)){
				$this->email->from($fromEmailId);
			}
			if(!empty($replyEmailId)){
				$this->email->reply_to($replyEmailId);
			}
			if(!empty($cc_email)){
				$this->email->bcc($cc_email);
			}
			$this->email->to($text_address);
			$this->email->subject($type);
			
				//$mes  = $this->query_model->getExtraContent($extraContent1);	
				//$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
				//$mes  .= $this->query_model->getExtraContent($extraContent2);		
				//$mes .= "<br/>";					
				//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';	
			$this->email->message($mes);
			
			$this->email->send();
		}	
			/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
			
			$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
			$config['charset'] = 'UTF-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype']="html";
			$this->email->initialize($config);
			//$this->email->from($sender_email);
			
			if(!empty($fromEmailId)){
				$this->email->from($fromEmailId);
			}
			if(!empty($replyEmailId)){
				$this->email->reply_to($replyEmailId);
			}
			if(!empty($cc_email)){
				$this->email->bcc($cc_email);
			}
			
			$this->email->to($noreply_email_address);
			$this->email->subject($type);
			
				//$mes  = $this->query_model->getExtraContent($extraContent1);	
				$mes  = isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';
				//$mes  .= $this->query_model->getExtraContent($extraContent2);					
				$mes .= "<br/>";				
				//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
			$this->email->message($mes);
			
			if($this->email->send()):
			
			
				// send email to websitedojo.com
				/*$this->email->initialize($config);
				$this->email->from($site_email);
				$this->email->to('leads@websitedojo.com');
				$this->email->subject($type);
				$this->email->message($mes);					
				$this->email->send(); */
				
				// thank you Email to user			
				$qry = $this->db->query("select * from `tblsite` limit 1") or die(mysqli_error($this->db->conn_id));
				$site_settings = $qry->row_array();
				
				$site_email = $site_settings['email'];
				$site_title = $site_settings['title'];				
			if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){	
			$subject = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
				$config['charset'] = 'UTF-8';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = "html";	
				
				$msg_body  = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';					
				//$msg_body .= "<br/>";					
				$msg_body .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
				
				$this->email->initialize($config);
				$this->email->from($noreply_email_address);
				$this->email->reply_to($noreply_email_address, $site_title);
				$this->email->to($sender_email);	
				$this->email->subject($subject);
				$this->email->message($msg_body);
				
				//echo '<br>subject: '.$subject;
				//echo '<br>msg_body: '.nl2br($msg_body);
				//exit;
				
				$this->email->send();
			}
	
				$data['msg'] = 1;
				//$this->load->view("birthday-parties",$data);
				
				
			$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
			$start_trial_slug = $start_trial_slug[0];
			
			$dojocart_slug = $this->query_model->getbySpecific('tblmeta', 'id', 49);
			$dojocart_slug = $dojocart_slug[0];
			
			
			$redirect_url = $start_trial_slug->slug;
			
			
			
			
			if(isset($_POST['is_unique_trial']) && ($_POST['is_unique_trial'] == 1)){
				//echo '<pre>POST'; print_r($_POST); die;
				$program_id = isset($_POST['program_id']) ? $_POST['program_id'] : '';
				$program_cat_id = isset($_POST['program_cat_id']) ? $_POST['program_cat_id'] : '';
				$location = isset($_POST['location_id']) ? $_POST['location_id'] : '';
				
				
				$this->db->select(array('id','name','slug'));
				$locationDetail = $this->query_model->getBySpecific('tblcontact','id',$location);
				
				
				
				$this->db->where('program_cat_id',$program_cat_id);
				$this->db->where('unique_program_id',$program_id);
				$this->db->where('location_id',$location);
				$uniqueTrialCat = $this->query_model->getBySpecific('tbl_unique_onlinespecial_categories','type','trial_offer');
				
				if(!empty($uniqueTrialCat)){
					$redirect_url = $start_trial_slug->slug.'/'.$uniqueTrialCat[0]->slug.'/'.$locationDetail[0]->slug;
				}else{
					$this->db->where('program_cat_id',$program_cat_id);
					$this->db->where('location_id',$location);
					if(!empty($program_id)){
							$this->db->where('unique_program_id',$program_id);
						}
					//$this->db->where('location_id','all');
					$uniqueTrialCat = $this->query_model->getBySpecific('tbl_unique_onlinespecial_categories','type','trial_offer');
					
					if(!empty($uniqueTrialCat)){
						$redirect_url = $start_trial_slug->slug.'/'.$uniqueTrialCat[0]->slug;
					}else{
						$this->db->where('program_cat_id',$program_cat_id);
						$this->db->where('location_id','all');
						
						$uniqueTrialCat = $this->query_model->getBySpecific('tbl_unique_onlinespecial_categories','type','trial_offer');
						if(!empty($uniqueTrialCat)){
							$redirect_url = $start_trial_slug->slug.'/'.$uniqueTrialCat[0]->slug;
						}
					}
				}
				
				
				
				$redirect_url = base_url().$redirect_url;
				
				redirect($redirect_url);
			}
			
			
			if(isset($_POST['redirection_type']) && !empty($_POST['redirection_type'])){
				if($_POST['redirection_type'] == "trial_offer" && isset($_POST['trial_offer_id']) && !empty($_POST['trial_offer_id'])){
					
					$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
					$trialOfferDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_categories", 'id', $_POST['trial_offer_id']);
					if(!empty($trialOfferDetail)){
						$redirect_url = '/'.$start_trial_slug->slug.'/'.$trialOfferDetail[0]->slug;
					}
				}elseif($_POST['redirection_type'] == "dojocart" && isset($_POST['dojocart_id']) && !empty($_POST['dojocart_id'])){
					$dojocartDetail = $this->query_model->getbySpecific('tbl_dojocarts', 'id', $_POST['dojocart_id']);
					if(!empty($dojocartDetail)){
						$redirect_url = '/'.$dojocart_slug->slug.'/'.$dojocartDetail[0]->slug;
					}
				}elseif($_POST['redirection_type'] == "thankyou_page" && isset($_POST['thankyou_page_id']) && !empty($_POST['thankyou_page_id'])){
					
					$this->query_model->getThankYouPageProgramPageMessage($_POST,$_POST['thankyou_page_id']);
					$this->query_model->getThankYouPageProgramPageMessage($_POST,$_POST['thankyou_page_id']);
					$program_thankyou_url = $this->query_model->getProgramThankyouUrl($_POST);
					
					redirect(@base_url().$program_thankyou_url);
					//redirect(@base_url().'site/thankyou');
				}elseif($_POST['redirection_type'] == "third_party_url" && isset($_POST['third_party_url']) && !empty($_POST['third_party_url'])){
					$redirect_url = $_POST['third_party_url'];
				}
			}
			//echo $redirect_url; die;
			
			
			
			redirect($redirect_url);
				
				
				
			else:
				$data['msg'] = 0;
				$this->load->view("birthday-parties",$data);
			endif;
			
			
			
		}else{			
			$this->load->view("birthday-parties",$data);
		}	
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */