<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendances extends CI_Controller {

	
	function __construct(){
		parent::__construct();
		
		 $this->load->model("onlinedojo_user_model"); 	
	}
	
	public function weekly()
	{
		
		$this->db->select(array('attendance_email_cron'));
		$attendance_cron = $this->query_model->getbySpecific("tbl_password_pro",'id',1);
		
		
		if($attendance_cron[0]->attendance_email_cron == "weekly"){	
		
			$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$sunday = strtotime(date("d-m-Y",$monday)." +6 days");
			$start_date = date("Y-m-d",$monday);
			$end_date = date("Y-m-d",$sunday);
			
			$this->getAttendanceAndSetReport($start_date,$end_date,'weekly');
			
			die('successfully we send weekly report of admin');
		}else{
			die('something went wrong. please check is this weekly or daily in cms');
		}
		
	}
	
	public function daily()
	{
		
		$this->db->select(array('attendance_email_cron'));
		$attendance_cron = $this->query_model->getbySpecific("tbl_password_pro",'id',1);
		
		
		
		if($attendance_cron[0]->attendance_email_cron == "daily"){	
		
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d');
			
			$this->getAttendanceAndSetReport($start_date,$end_date,'daily');
			
			die('successfully we send daily report of admin');
		}else{
			die('something went wrong. please check is this weekly or daily in cms');
		}
		
	}
	
	
	public function getAttendanceAndSetReport($start_date, $end_date,$cron_type){
		
		if(!empty($start_date) && !empty($end_date)){
			
			$this->db->select('location_id');
			$this->db->group_by('location_id');
			$this->db->where('attendance_date >=', $start_date);
			$this->db->where('attendance_date <=', $end_date);
			$students = $this->query_model->getByTable('tbl_student_attendance');
			
				if(!empty($students)){
					foreach($students as $student){
						
						
						//$this->db->select(array('id','firstname','lastname','email'));
						//$userDetail = $this->query_model->getBySpecific('tbl_onlinedojo_users','id',$student->user_id);
						
						
						$this->db->order_by('attendance_date','desc');
						$this->db->where('attendance_date >=', $start_date);
						$this->db->where('attendance_date <=', $end_date);
						$attendances = $this->query_model->getBySpecific('tbl_student_attendance','location_id',$student->location_id);
						
						
						if(!empty($attendances)){
							
							
							$this->db->where('id',1);
							$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
							if($multiLocation[0]->field_value == 1){
								
								if($student->location_id == "virtual_student_only"){
									$this->db->select('email');
									$main_location_detail = $this->query_model->getBySpecific('tblcontact','main_location',1);
									$admin_email = isset($main_location_detail[0]->email) ? $main_location_detail[0]->email : '';
								}else{
									$this->db->select('email');
									$location_detail = $this->query_model->getbySpecific('tblcontact','id',$student->location_id);
									$admin_email = isset($location_detail[0]->email) ? $location_detail[0]->email : '';
								}
								
								
							}else{
								$this->db->select('email');
								$site_setting = $this->query_model->getbyTable('tblsite');
								$admin_email = $site_setting[0]->email;
								
							}
							
							if(empty($admin_email)){
								$admin_email = $site_setting[0]->email;
							}
							
							if($cron_type == "daily"){
								$report_date = date('d M, Y', strtotime($start_date));
								$filename = "upload/importCsv/".$cron_type."-attendance-".$start_date.'-'.$student->location_id.".csv";
							}else{
								$report_date = date('d M, Y', strtotime($start_date)).' to '.date('d M, Y', strtotime($end_date));
								$filename = "upload/importCsv/".$cron_type."-attendance-".$start_date.'-to-'.$end_date.'-'.$student->location_id.".csv";
							}
							
							$file = fopen($filename, 'w');                              
							fputcsv($file, array('Student name', 'School name', 'Class Name', 'Day', 'Attendance Date'));
							
							foreach($attendances as $attendance){
								$this->db->select(array('firstname','lastname'));
								$userDetail = $this->query_model->getBySpecific('tbl_onlinedojo_users','id',$attendance->user_id);
							
								$username = !empty($userDetail) ? $userDetail[0]->firstname.' '.$userDetail[0]->lastname : $student->user_name;
								
								$record = array($username,$attendance->location, $attendance->class_name, $attendance->today_weekday, $attendance->attendance_date);
								fputcsv($file, $record);

								
							}
							fclose($file);
							$emailRequestData = array('email_type'=> 'attendance_cron','csv_file_link'=> $filename,'useremail'=>$admin_email,'cron_type'=>ucfirst($cron_type),'report_date'=>$report_date);
							
							//echo '<prE>emailRequestData'; print_r($emailRequestData); die;
							$emailTemplateDetail = $this->query_model->getBySpecific('tbl_users_email_templates','id',7);
				
							$this->onlinedojo_user_model->sendUserEmail($emailTemplateDetail,$emailRequestData);
						}	
					}
					
					
				}
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */