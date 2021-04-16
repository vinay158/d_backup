<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Contactus extends CI_Controller {



	public function index()

	{
		
		$folder_name = $_SERVER['CONTEXT_PREFIX'];
  		$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
   
	   $meta_slug = explode('/',$_SERVER['REQUEST_URI']);
	   //echo '<pre>'; print_r($meta_slug); die;
	   $meta_slug = $meta_slug[1];
		
		if(!empty($meta_slug)){
			$data['page_name'] = $this->query_model->getMetaPageName($meta_slug);
		}
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		$data['site_settings'] = $data['site_settings'][0];
		
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		
		
		$this->db->where("published", 1);
		if($data['multiSchool'] == 1){
			$this->db->where("main_location", 0);
		}
		$this->db->order_by("pos","asc");
		$this->db->where("location_type", 'regular_link');
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$data['twilioApi'] = $this->query_model->getTwilioApiType();
		
		$data['uniqueStatesList'] = $this->query_model->getUniqueStatesList();
		
		if($data['multiLocation'][0]->field_value == 1){
			if($this->uri->segment(2) != ''){
				$location_slug = str_replace('%27',"'",$this->uri->segment(2));
				

				$location_slugs = addslashes($location_slug);
				//echo $location_slug; die;
				$data['contactDetail'] = $this->db->query('select * from `tblcontact`  where  slug= "'.$location_slugs.'" and `published` = 1') or die(mysqli_error($this->db->conn_id));
				$data['contactDetail']=$data['contactDetail']->result();

			} else{
				
				$data['contactDetail'] = $this->query_model->getMainLocation("tblcontact");
				
			}
		} else{
			
			$data['contactDetail'] = $this->query_model->getMainLocation("tblcontact");
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			if(!empty($this->uri->segment(2))){
				redirect(base_url(),'location',301);
			}
		
		}
		//echo '<pre>'; print_R($data['contactDetail']); die;
		if(empty($data['contactDetail'])){
			redirect(base_url(),'location',301);
		}
		
		$data['contactDetail'] = $data['contactDetail'][0];
		
		$data['contactTime'] = $this->query_model->getbySpecific('tblcontact_time', 'location_id', $data['contactDetail']->id);
		
		$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 38);
		$data['contact_slug'] = $data['contact_slug'][0];
		
		$this->db->where("location_id",  $data['contactDetail']->id);
		$data['seoContent'] = $this->db->get("tblseo")->row_array();
		
		$this->load->view('contact-us', $data);

	}

	

	public function send(){
		
		//echo '<pre>POST'; print_r($_POST); die;
		/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		// checking hunney Post
		$this->query_model->checkHunneyPost($_POST);
		

		$data = array();

		$insert_data = array();

		$insert_data['school'] = '';


		if(isset($_POST['email']) && empty($_POST['email'])){

			$data['location'] = isset($_POST['hid_location']) ? $_POST['hid_location'] : '';	

			if(!empty($_POST['form_email_2'])){

				$this->load->library("email");

				$sel_school='';

				if(isset($_POST['school'])){

					$insert_data['school'] = $sel_school=$_POST['school'];							

					$school_data=$this->db->query("select email from `tblcontact` where name='".mysqli_real_escape_string($this->db->conn_id,$_POST['school'])."';") or die(mysqli_error($this->db->conn_id));

					$school_data=$school_data->result();
					
					$location_detail=$this->db->query("select * from `tblcontact` where name='".mysqli_real_escape_string($this->db->conn_id,$_POST['school'])."';") or die(mysqli_error($this->db->conn_id));

					$location_detail=$location_detail->result();
					
					$noreply_email_address = $location_detail[0]->email;				

					if(is_array($school_data) && count($school_data)>0){

						$school_email=($school_data[0]->email);	

					}else{

						$school_email=''; 

					}				

				} else{
					$location_detail = $this->query_model->getMainLocation();
					
					$site_setting = $this->query_model->getbyTable('tblsite');	
					$noreply_email_address = $site_setting[0]->email;
				}
			
		
		//echo '<pre>'; print_r($_POST); die;

				$query = $this->query_model->getbyTable('tblsite');			

				foreach($query as $row):

					$site_email = trim($row->email);

					$school_name = $row->title;

				endforeach;
				
				$multi_calendar_qry = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_location'");
				$multi_calendar_result = $multi_calendar_qry->result();
				$multi_calendar = $multi_calendar_result[0];				 

				if(isset($school_email) && $multi_calendar->field_value = 1){

					$site_email = $school_email;

				}

			

				$insert_data['name'] = $sender = $_POST['name'];

				$insert_data['email'] = $sender_email = trim($_POST['form_email_2']);

				$insert_data['message'] = $cont = $_POST['message'];				

				$type = "Contact Form | ".$school_name." | ".$_POST['name']." ".$_POST['last_name'];				

				$insert_data['phone'] = $phone = $_POST['phone'];
				
				$insert_data['last_name'] = $last_name = $_POST['last_name'];
				
				//$insert_data['ip_address'] = isset($_POST['ip_address']) ? $_POST['ip_address'] : '';
				$insert_data['gdpr_compliant_checkbox'] = isset($_POST['gdpr_compliant_checkbox']) ? $_POST['gdpr_compliant_checkbox'] : 0;
				$ipAddress = $this->query_model->getCountryNameToIpAddress();
				$insert_data['ip_address'] = $ipAddress['client_ip_address'];
				$insert_data['client_country_name'] = $ipAddress['client_country_name'];
				$insert_data['request_detail'] = isset($_SERVER) ? serialize($_SERVER) : '';

				$this->query_model->insertData('tblcontactusleads', $insert_data);
				
				$contact_lead_id = $this->db->insert_id();
				
				if(!empty($contact_lead_id)){
					$school = isset($_POST['school']) ? $_POST['school'] : '';
					$current_email_info = $this->query_model->getContactLeadEmailInfo($insert_data['email'], $insert_data['name'],$school,$contact_lead_id );
					
				}

				/*
				* checkFormModuleApplyAPI 				
				* this function for using apis according form model 				
				*/				

				$this->query_model->checkFormModuleApplyAPI($_POST);
				
				$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST);
				
				// sending msg by twillio api
				$this->query_model->connectFormToTwillioAPi($_POST,'contact_us');	
				

				$config['charset'] = 'UTF-8';

				$config['wordwrap'] = TRUE;

				$config['mailtype']="html";
				
		/*********Start CODE FOR ADMIN PHONE MESSAGES ******/
		if(isset($emailAutoResponder['admin_email'])){
				$multiple_loc = $this->query_model->getbyTable("tblconfigcalendar");
				if($multiple_loc[0]->field_value == 1){
					$loc_detail = $this->query_model->getbySpecific('tblcontact', 'id',$location_detail[0]->id);
					$text_address = $loc_detail[0]->text_address;
				}else{
					$loc_detail = $this->query_model->getMainLocation("tblcontact");
					$text_address = $loc_detail[0]->text_address;
				}
			//	echo $text_address; die;
			$adminTextMsgTemplate = $this->query_model->adminTextMessageTemplate($_POST,'contact_us');
			$type = '';
			$mes  = isset($adminTextMsgTemplate['admin_text_message_template']) ? $adminTextMsgTemplate['admin_text_message_template'] : '';


			if(!empty($text_address) && !empty($mes)){
				
				//$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				
				$this->email->initialize($config);
				
				
				$this->email->to($text_address);

				if(!empty($fromEmailId)){
					$this->email->from($fromEmailId);
				}
				if(!empty($sender_email)){
					$this->email->reply_to($sender_email);
				}
				if(!empty($cc_email)){
					$this->email->bcc($cc_email);
				}

				$this->email->subject($type);
				
				//$mes =isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';;
				//$mes .= '<br/>';
				//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';		

					$this->email->message($mes);
					$this->email->send();
					
				}	
				
				
				/********* Ends CODE FOR ADMIN PHONE MESSAGES ******/
					
					
				// Mail to admin
				$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				$this->email->initialize($config);

				
				$this->email->to($site_email);
				
				if(!empty($fromEmailId)){
					$this->email->from($fromEmailId);
				}
				if(!empty($sender_email)){
					$this->email->reply_to($sender_email);
				}
				if(!empty($cc_email)){
					$this->email->bcc($cc_email);
				}

				$this->email->subject($type);

				
					$mes =isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';;
					$mes .= '<br/>';
					//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';		
	
					

					$this->email->message($mes);
					$this->email->send();
			}	
					//if($this->email->send()):


						// thank you Email to user
	
						$qry = $this->db->query("select * from `tblsite` limit 1") or die(mysqli_error($this->db->conn_id));

						$site_settings = $qry->row_array();

						$site_email = $site_settings['email'];

						$site_title = $site_settings['title'];				

						
				if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){
					
						$config['charset'] = 'UTF-8';

						$config['wordwrap'] = TRUE;

						$config['mailtype'] = "html";	


						$subject = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
						$msg_body = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';	

						//$msg_body .= "<br/>";
						$msg_body .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
						


						$this->email->initialize($config);

						$this->email->from($noreply_email_address);

						$this->email->reply_to($noreply_email_address, $site_title);

						$this->email->to($sender_email);	

						$this->email->subject($subject);

						$this->email->message($msg_body);					

						$this->email->send();
				}	

						$data['msg'] = 1;

						//redirect("contactus");

						$data['content'] = $this->query_model->getbyId("tblpages", 9);

						$data['school_name']=$school_name;

						$data['sel_school']=$sel_school;

						//$this->db->order_by("pos", "ASC");				

						//$data['contact'] = $this->query_model->getbyTable("tblcontact");

		

						$contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));

						$data['contact']=$contact_data->result();

						$query = $this->query_model->getbyTable('tblsite');		

						if(is_array($query) && count($query)>0):		

							$data['site_title']=$query[0]->title;

						else:

							$data['site_title']='';

						endif;

						
						$this->query_model->getThankYouPageMessage($_POST);
						//echo @base_url().'site/thankyou'; die;
						
						$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
						$contact_slug = $contact_slug[0];
						$contact_thankyou_url = $contact_slug->slug.'/thank-you/'.$location_detail[0]->slug;
						
						
						redirect(@base_url().$contact_thankyou_url);
						//$this->load->view("contact-us-sent",$data);

					
					

					}else{

						redirect("contact-us");

					}

			}	

			else{

				

				redirect("contact-us");

			}

	}		

	

public function student_send_contact(){
		
		
		

		// checking hunney Post
		$this->query_model->checkHunneyPost($_POST);

			/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		

		$data = array();
		
						$this->db->where("published", 1);
						$this->db->order_by("pos","asc");
						$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
						$data['site_settings'] = $this->query_model->getbyTable("tblsite");
						$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
						$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
						
						
		$insert_data = array();

		$insert_data['school'] = '';

		
		//echo '<pre>'; print_r($_POST); die;
		if(isset($_POST['email']) && empty($_POST['email'])){
			$data['location'] = isset($_POST['hid_location']) ? $_POST['hid_location'] : '';	

			if(!empty($_POST['form_email_2'])){

				$this->load->library("email");

				$sel_school='';

				if(isset($_POST['school'])){

					$insert_data['school'] = $sel_school=$_POST['school'];	
					
					$location_detail=$this->db->query("select * from `tblcontact` where name='".mysqli_real_escape_string($this->db->conn_id,$_POST['school'])."';") or die(mysqli_error($this->db->conn_id));

					$location_detail=$location_detail->result();
					
					//echo 'hello1';
					
					 $noreply_email_address = $location_detail[0]->email;	
										
					//$noreply_email_address = 
				}else{
					$location_detail = $this->query_model->getMainLocation();
				//echo 'hello2';
					$site_setting = $this->query_model->getbyTable('tblsite');	
					$noreply_email_address = $site_setting[0]->email;
					
				}

			

				$query = $this->query_model->getbyTable('tblsite');			

				foreach($query as $row):

					$site_email = trim($row->email);

					$school_name = $row->title;

				endforeach;
				
				$multi_calendar_qry = $this->db->query("SELECT * FROM tblconfigcalendar where field_name = 'multi_location'");
				$multi_calendar_result = $multi_calendar_qry->result();
				$multi_calendar = $multi_calendar_result[0];				 

				if(isset($school_email)){

					$site_email = $school_email;

				}
				
			

				$insert_data['name'] = $sender = $_POST['name'];

				$insert_data['email'] = $sender_email = trim($_POST['form_email_2']);

				$insert_data['message'] = $cont = $_POST['message'];				

				$type = "Student Section | ".$school_name.' | '.$_POST['name'].' '.$_POST['last_name'];				

				$insert_data['phone'] = $phone = $_POST['phone'];
				
				$insert_data['last_name'] = $last_name = $_POST['last_name'];
				

			//	$this->query_model->insertData('tblcontactusleads', $insert_data);

				/*
				* checkFormModuleApplyAPI 				
				* this function for using apis according form model 				
				*/				

				$this->query_model->checkFormModuleApplyAPI($_POST);
				
				$emailAutoResponder = $this->query_model->checkFormModuleAutoResponder($_POST);
				
				/// end code 
				if(isset($emailAutoResponder['admin_email'])){
				$type = isset($emailAutoResponder['admin_email_subject']) ? $emailAutoResponder['admin_email_subject'] : '';
				$config['charset'] = 'UTF-8';

				$config['wordwrap'] = TRUE;

				$config['mailtype']="html";

				$this->email->initialize($config);

				//$this->email->from($sender_email);

				$this->email->to($site_email);
				
				if(!empty($fromEmailId)){
					$this->email->from($fromEmailId);
				}
				if(!empty($sender_email)){
					$this->email->reply_to($sender_email);
				}
				if(!empty($cc_email)){
					$this->email->bcc($cc_email);
				}
				

				$this->email->subject($type);

				$mes =isset($emailAutoResponder['admin_auto_responder']) ? $emailAutoResponder['admin_auto_responder'] : '';;
				$mes .= '<br/>';
				//$mes .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';		


					
					$this->email->message($mes);

					$this->email->send();
				}
					//if($this->email->send()):

					

						// thank you Email to user

						$qry = $this->db->query("select * from `tblsite` limit 1") or die(mysqli_error($this->db->conn_id));

						$site_settings = $qry->row_array();

						

						$site_email = $site_settings['email'];

						$site_title = $site_settings['title'];				

						
					if(isset($emailAutoResponder['customer_email']) && $emailAutoResponder['customer_email'] == 1){
						
						$config['charset'] = 'UTF-8';

						$config['wordwrap'] = TRUE;

						$config['mailtype'] = "html";	

						
						$subject = isset($emailAutoResponder['customer_email_subject']) ? $emailAutoResponder['customer_email_subject'] : '';
						$msg_body = isset($emailAutoResponder['customer_auto_responder']) ? $emailAutoResponder['customer_auto_responder'] : '';	

						//$msg_body .= "<br/>";
						$msg_body .= isset($emailAutoResponder['email_signature']) ? $emailAutoResponder['email_signature'] : '';
						

						$this->email->initialize($config);

						$this->email->from('noreply@websitedojo.com');

						$this->email->reply_to($noreply_email_address, $site_title);

						$this->email->to($sender_email);	

						$this->email->subject($subject);

						$this->email->message($msg_body);

						$this->email->send();
					}

						$data['msg'] = 1;

						//redirect("contactus");

						$data['content'] = $this->query_model->getbyId("tblpages", 9);

						$data['school_name']=$school_name;

						$data['sel_school']=$sel_school;

		

						$contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));

						$data['contact']=$contact_data->result();

						$query = $this->query_model->getbyTable('tblsite');		

						if(is_array($query) && count($query)>0):		

							$data['site_title']=$query[0]->title;

						else:

							$data['site_title']='';

						endif;
						
						$this->query_model->getThankYouPageMessage($_POST);
						//echo @base_url().'site/thankyou'; die;
						
						$studentsection_slug = $this->query_model->getbySpecific('tblmeta', 'id', 47);
						$studentsection_slug = $studentsection_slug[0];
						$contact_thankyou_url = $studentsection_slug->slug.'/thankyou/';
						
						
						redirect(@base_url().$contact_thankyou_url);
						//$this->load->view("student_send_contact",$data);

					/*else:

						$data['msg'] = 0;

						//redirect("contactus");

						$data['content'] = $this->query_model->getbyId("tblpages", 9);

						//$this->db->order_by("pos", "ASC");

						

						$contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));

						$data['contact']=$contact_data->result();

						$query = $this->query_model->getbyTable('tblsite');		

						if(is_array($query) && count($query)>0):		

							$data['site_title']=$query[0]->title;

						else:

							$data['site_title']='';

						endif;				

						

						//$data['contact'] = $this->query_model->getbyTable("tblcontact");
						
						$this->load->view("student_send_contact",$data);

					endif;*/

					

					}else{

						redirect("studentsection/contact");

					}

			}	

			else{

				

				redirect("studentsection/contact");

			}

	
}		

	



public function quicksend(){

	$data = array();	

	$this->load->library("email");

	

	$query = $this->query_model->getbyTable('tblsite');

	foreach($query as $row):

		$site_email = $row->email;

		$school_name = $row->title;

	endforeach;

	

	$sender = $_POST['name'];

    $sender_email = $_POST['email'];

	$cont = $_POST['message'];

	 

	$type = "Email Inquiry";

	

  	$config['charset'] = 'UTF-8';

	$config['wordwrap'] = TRUE;

	$config['mailtype']="html";

	$this->email->initialize($config);

	$this->email->from($sender_email);

	$this->email->to($site_email);

	$this->email->subject($type);

	

		$mes ="<html><head>";

		$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

		$mes.="<style>

		*{ margin: 0; padding: 0; font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

		body{ margin: 5px;text-align: left;  }

		h1{ font-weight:900; color: #006699; font-size: 16px; text-transform:capitalize; font-family: 'Raleway', sans-serif; line-height:20px; margin-bottom:15px;margin-top:0px;}
					
		h6{ font-size: 14px; color: #006699}

		strong{ color:#006699; font-weight:900; }

		.content{ margin-top: 5px;}

		.content .row{ margin: 5px 0;}

		.row .message{ width: 700px; padding-top: 10px; }

		.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px; text-indent: 20px;}

		label{ font-weight:400; }

		

		</style>";

		$mes .= "</head><body>";

		//$mes .= "<h1>".$school_name."</h1>";

		$mes .= "<h1>Email Contact Form</h1>";

		

		$mes .= '<div class="content">';

		$mes .=	'<div class="row"><strong>Name: &nbsp;</strong><label>'.$sender.'</label></div>';

		$mes .=	'<div class="row"><strong>Email: &nbsp;</strong><label>'.$sender_email.'</label></div>';

		

		$mes .= '<div class="row">';

		$mes .= '<div class="message"><p>'.$cont.'</p></div>';

		$mes .= '</div></div>';

		$mes .= '</body></html>';

	

	$this->email->message($mes);

	

	if($this->email->send()):

		echo "<script language='javascript'>window.location.reload();</script>";

		//$this->load->view("contact-us",$data);

	else:

		echo "<script language='javascript'>window.location.reload();</script>";

		//$this->load->view("contact-us",$data);

	endif;

	}





public function thankyoupage(){
	
		$thankyouMessage = $this->session->userdata('thankyouMessage');
		
		$this->query_model->saveFormDataOnMATApi($thankyouMessage);
		
		if(!empty($thankyouMessage)){
			
			$data = $this->query_model->getThankyouPageData($thankyouMessage);
			
			$this->load->view('thankyou-page-message', $data);
		}else{
			redirect(base_url());
		}
		
	}


	
	

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */