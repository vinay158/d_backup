<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onlinedojo_user_model extends CI_Model{	
	var $table = 'tblsite';
	
	

	public function sendUserEmail($emailTemplateDetail,$postData){
		
		
		
		/** geting from, replyto and cc email address **/
		$emailIdManager = $this->query_model->getbyTable('tblsite');
		$fromEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->from_email)) ? $emailIdManager[0]->from_email : '';
		$replyEmailId = (!empty($emailIdManager) && !empty($emailIdManager[0]->replyto_email)) ? $emailIdManager[0]->replyto_email : '';
		$cc_email = (!empty($emailIdManager) && !empty($emailIdManager[0]->cc_email)) ? $emailIdManager[0]->cc_email : '';
		/*** end  code **/
		
		$subject = !empty($emailTemplateDetail[0]->subject) ?  $this->replaceAutoResponderVaribles($emailTemplateDetail[0]->subject,$postData) : '';
		$content = !empty($emailTemplateDetail[0]->description) ?  $this->replaceAutoResponderVaribles($emailTemplateDetail[0]->description,$postData) : '';
		$user_email = isset($postData['useremail']) ? $postData['useremail'] : '';
		
		$email_type = isset($postData['email_type']) ? $postData['email_type'] : '';
		$csv_file_link = isset($postData['csv_file_link']) ? $postData['csv_file_link'] : '';
		
		
		
			$this->load->library('email');
			
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype']="html";
			
			$this->email->initialize($config);
			
			if(!empty($fromEmailId)){
				$this->email->from($fromEmailId);
			}
			if(!empty($replyEmailId)){
				$this->email->reply_to($replyEmailId);
			}
			if(!empty($cc_email)){
				$this->email->bcc($cc_email);
			}
			
			$this->email->to($user_email);
			$this->email->subject($subject);
			$this->email->message($content);
			
			if($email_type == "attendance_cron" && !empty($csv_file_link)){
				$dir=pathinfo(BASEPATH);
				$this->email->attach($dir['dirname'].'/'.$csv_file_link);
			}
			$this->email->send();
			
			if($email_type == "attendance_cron"){
				$this->email->clear(TRUE);
			}
	}
	
	
	
	public function replaceAutoResponderVaribles($content, $formData){
		
		
		$locationDetail = $this->query_model->getMainLocation("tblcontact");
		
		$locationDetail = $locationDetail[0];
		
		$site_setting = $this->query_model->getbyTable("tblsite");
		
		$firstname = isset($formData['firstname']) ? $formData['firstname'] : '';
		$lastname = isset($formData['lastname']) ? $formData['lastname'] : '';
		$username = isset($formData['useremail']) ? $formData['useremail'] : '';
		$password = isset($formData['password']) ? $formData['password'] : '';
		$phone = isset($formData['phone']) ? $formData['phone'] : '';
		$location = isset($formData['location']) ? $formData['location'] : '';
		$generate_password_link = isset($formData['generate_password_link']) ? $formData['generate_password_link'] : '';
		$cron_type = isset($formData['cron_type']) ? $formData['cron_type'] : '';
		$report_date = isset($formData['report_date']) ? $formData['report_date'] : '';
		
		$result = str_replace(
							array('#FIRSTNAME', '#LASTNAME', '#EMAIL', '#PASSWORD', '#PHONE', '#LOCATION', '#GENERATE_PASSWORD_LINK','#ATTENDANCE_REPORT_TYPE','#ATTENDANCE_REPORT_DATE','#SITE_TITLE','#CONTACT_NAME', '#CONTACT_ADDRESS', '#CONTACT_SUITE', '#CONTACT_CITY', '#CONTACT_STATE', '#CONTACT_ZIP', '#CONTACT_PHONE'),
							array($firstname, $lastname, $username, $password, $phone, $location, $generate_password_link,$cron_type,$report_date, $site_setting[0]->title, $locationDetail->name, $locationDetail->address, $locationDetail->suite, $locationDetail->city, $locationDetail->state, $locationDetail->zip, $locationDetail->phone), 
							$content
							);
		
		
		return $result;
		
	}
	
	
	public function updateUserAttendaceRecords($user_id = ''){
		
		if(!empty($user_id)){
			
			$userDetail = $this->query_model->getBySpecific('tbl_onlinedojo_users','id',$user_id);
			
			if(!empty($userDetail)){
				//echo '<pre>userDetail'; print_r($userDetail); die;
				$userDetail = $userDetail[0];
				
				$updateData = array();
				//$updateData['user_name'] = $userDetail->firstname.' '.$userDetail->lastname;
				$updateData['location'] = $userDetail->location;
				$updateData['location_id'] = $userDetail->location_id;
				
				$this->db->where('location_id !=',$userDetail->location_id);
				$this->db->where('user_id',$user_id);
				$this->db->update('tbl_student_attendance',$updateData);
			}
			
		}
		
	}
	
}