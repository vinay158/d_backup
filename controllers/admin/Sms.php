<?php 
class Sms extends CI_Controller{
	

	function index(){
		
	}
	
	
	function chat(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
	
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			$data['title'] = "SMS messenger";
			$data['link_type'] = "twilio_sms_messenger";
			
			$data['lead_users'] = $this->db->query("SELECT `id`,`name`,`phone`,`last_updated_date`, (select count(*) from twilio_sms_messenger where sms_users_id = twilio_sms_users.id and is_read_msg = 0  and sender_by = 'student' ) as total_msgs FROM `twilio_sms_users` WHERE is_deleted = 0 and  conversation_type != 'admin' order by last_updated_date DESC")->result();
			
			
			$this->load->view('admin/twilio_sms_messenger',$data);
		
		}else{
			redirect("admin/login");
		}

	}
	
	

}
