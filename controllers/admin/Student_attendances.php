<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_attendances extends CI_Controller {

	
	function __construct(){
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }		
	}
	
	public function index($page = 1)
	{
		
		$start_date = (isset($_GET['start_date']) && !empty($_GET['start_date'])) ? $_GET['start_date'] : date('Y-m-01');
		$end_date = (isset($_GET['end_date']) && !empty($_GET['end_date'])) ? $_GET['end_date'] : date('Y-m-d');
		
		
		//$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
		
		$this->db->select('user_id');
		$this->db->group_by('user_id');
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$this->db->where('attendance_date >=', $start_date);
		$this->db->where('attendance_date <=', $end_date);
		$totalStudents = $this->query_model->getByTable('tbl_student_attendance');
		//echo '<pre>totalStudents'; print_r($totalStudents); die;
		$totalStudents = count($totalStudents);
		
		$data['title'] = "Attendance";
		$data['link_type'] = "student_attendances"; 
		$config = array();
	
		$config['per_page']=20;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/student_attendances/index'; 
		
		$config['total_rows'] = $totalStudents;
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		
		
		$this->db->group_by('user_id');
		//$this->db->where("DATE_FORMAT(attendance_date,'%Y-%m')", $date);
		$this->db->where('attendance_date >=', $start_date);
		$this->db->where('attendance_date <=', $end_date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$this->db->order_by("id", "desc");
		$data['student_attendances'] = $this->pagination_model->fetch_data('tbl_student_attendance',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		
		
		$number = ($page * $config['per_page']) - $config['per_page'];
		$data['number'] = $number + 1;
		
		$this->db->where('id',1);
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		//	echo '<pre>';print_r($data['student_attendances']); die;	
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		/*if($data['multiLocation'][11]->field_value == 1){
			$this->db->where("main_location", 0);
		}*/
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$this->db->select(array('attendance_email_cron'));
		$data['attendance_cron'] = $this->query_model->getbySpecific("tbl_password_pro",'id',1);
		
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		//echo '<pre>data'; print_r($data); die;
		$this->load->view('admin/student_attendances',$data);
		
	}
	
	
	public function exportAttendance(){
		
		//$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
		$start_date = (isset($_GET['start_date']) && !empty($_GET['start_date'])) ? $_GET['start_date'] : date('Y-m-01');
		$end_date = (isset($_GET['end_date']) && !empty($_GET['end_date'])) ? $_GET['end_date'] : date('Y-m-d');
		
		$this->db->order_by('id','asc');
		$this->db->group_by('user_id');
		$this->db->select('user_id');
		$this->db->where('attendance_date >=', $start_date);
		$this->db->where('attendance_date <=', $end_date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$students = $this->query_model->getByTable('tbl_student_attendance');	
		
		
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=students-attendance-report.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$file = fopen('php://output', 'w');                              
      	fputcsv($file, array('Student name', 'School name', 'Class Name', 'Day', 'Attendance Date'));
		
		
		foreach($students as $student){
			
			$this->db->order_by('attendance_date','desc');
			//$this->db->where("DATE_FORMAT(attendance_date,'%Y-%m')", $date);
			$this->db->where('attendance_date >=', $start_date);
			$this->db->where('attendance_date <=', $end_date);
			if(isset($_GET['location']) && !empty($_GET['location'])){
				$this->db->where('location_id',$_GET['location']);
			}
			$attendances = $this->query_model->getBySpecific('tbl_student_attendance','user_id',$student->user_id);
			
			$this->db->select(array('firstname','lastname'));
			$userDetail = $this->query_model->getBySpecific('tbl_onlinedojo_users','id',$student->user_id);
		
			$username = !empty($userDetail) ? $userDetail[0]->firstname.' '.$userDetail[0]->lastname : $student->user_name;
			
			if(!empty($attendances)){
				foreach($attendances as $attendance){
										
					 $record = array($username,$attendance->location, $attendance->class_name, $attendance->today_weekday, $attendance->attendance_date);
					fputcsv($file, $record);
				}
			}
			 
						
		}
		fclose($file);
		exit();	


	}
	
	
	public function ajax_student_attendance_info(){
		$data = array();
		if(isset($_POST['action']) && $_POST['action'] == "get_record"){
			
			//$date = isset($_POST['date']) ? $_POST['date'] : date('Y-m');
			$start_date = (isset($_POST['start_date']) && !empty($_POST['start_date'])) ? $_POST['start_date'] : date('Y-m-01');
			$end_date = (isset($_POST['end_date']) && !empty($_POST['end_date'])) ? $_POST['end_date'] : date('Y-m-d');
		
			$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
			$location = isset($_POST['location']) ? $_POST['location'] : '';
			
			if(!empty($user_id)){
				$this->db->order_by('attendance_date','desc');
				//$this->db->where("DATE_FORMAT(attendance_date,'%Y-%m')", $date);
				$this->db->where('attendance_date >=', $start_date);
				$this->db->where('attendance_date <=', $end_date);
				if(isset($location) && !empty($location)){
					$this->db->where('location_id',$location);
				}
				$data['attendances'] = $this->query_model->getBySpecific('tbl_student_attendance','user_id',$user_id);
				
				
				$this->db->order_by('id','desc');
				$this->db->limit(1);
				$this->db->select(array('attendance_date'));
				$data['last_attendance'] = $this->query_model->getBySpecific('tbl_student_attendance','user_id',$user_id);
				
			}
			
		}
		
		$this->load->view('admin/ajax_student_attendance_info',$data);
		
	}
	
	public function ajax_set_attendance_email_cron(){
		
		if(isset($_POST['action']) && $_POST['action'] == "attendance_email_cron"){
			
			$attendance_email_cron = (isset($_POST['attendance_email_cron']) && !empty($_POST['attendance_email_cron'])) ? $_POST['attendance_email_cron'] : 'weekly';
			
			
			$updateData['attendance_email_cron']  = $attendance_email_cron;
			$this->query_model->update('tbl_password_pro', 1, $updateData);
			
		}
		
		echo '1'; exit();
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */