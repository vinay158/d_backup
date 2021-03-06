<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adduser extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
	        { 
	            redirect('/admin/login');
	        }
	       $this->load->model("adduser_model"); 
		}
	
	public function index()
	{
		
			redirect("admin/adduser/view");
		
	}
	
	public function view(){
	$is_logged_in = $this->session->userdata('is_logged_in');
	if($this->session->userdata['user_level'] != 1){
		redirect("admin/dashboard");
	} 
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Users"; //title on view page
			$data['link_type'] = "adduser"; //cotroller name
			
			$this->db->select(array('facebook_api_id','facebook_secret_id'));
			$data['apiKey'] = $this->query_model->getbySpecific('tblapikey','id', 1);
			$data['apiKey'] = $data['apiKey'][0];
			//echo '<pre>'; print_r($data['apiKey']); die;
			
			$this->db->select(array('id','fname','lname','user_level'));
			$data['user'] = $this->query_model->getbyTable("tbladmin");
			//echo '<pre>data'; print_r($data); die;
			$this->load->view("admin/adduser_index", $data);
		}
		else{
		redirect("admin/login");
		}
	}
	
	public function add(){
	if($this->session->userdata['user_level'] != 1){
		redirect("admin/dashboard");
	} 
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Add User";
			$data['link_type'] = "adduser";
		
		$data['multi_trial_offer'] = $this->query_model->getBySpecific('tblconfigcalendar','id',14);
		//echo '<prE>multi_trial_offer'; print_r($data['multi_trial_offer'][0]->field_value); die;
			// vinay 19/11
		$data['home_tab'] = $this->query_model->getMenuTabPages('admin/home', 7);
		$data['aboutus_tab'] = $this->query_model->getMenuTabPages('admin/aboutus', 7);
		//$data['contactus_tab'] = $this->query_model->getMenuTabPages('admin/contactus', 7);
		$data['settings_tab'] = $this->query_model->getMenuTabPages('admin/settings', 7);
		$data['student_section_tab'] = $this->query_model->getMenuTabPages('admin/studentsection', 7);
		$data['leads_tab'] = $this->query_model->getMenuTabPages('admin/leads', 7);
		//echo '<pre>'; print_r($data['student_section_tab']); die;
		$data['others'] =  $this->query_model->getOtherPages(0,7);
		$data['school_info_tab'] = $this->query_model->getMenuTabPages('admin/school_info', 7);
		$data['trial_offer_tab'] = $this->query_model->getMenuTabPages('admin/onlinespecial', 7);
		
		$data['unique_trial_offer_tab'] = $this->query_model->getMenuTabPages('admin/unique_onlinespecial', 7);
		//echo '<pre>'; print_r($data['unique_trial_offer_tab']); die;
		$data['forms_tab'] = $this->query_model->getMenuTabPages('admin/form_builder', 7);
		
		//echo '<pre>data'; print_r($data); die;
		$data['school_tab'] = array('admin/school/about_school_header'=>'School Header','admin/school/about_ourschool'=>'About Us','admin/school/text_sections'=>'Text Section','admin/school/video_section'=>'Video Section','admin/school/testimonial_sections'=>'Testimonial / Trial Offer','admin/school/team_member_index'=>'Team Member', 'admin/school/school_staff_index'=>'Our Instructor','admin/school/school_apikeys'=>'Social Api Key');
		
		$data['twilio_sms_messenger'] = $this->query_model->getMenuTabPages('admin/sms', 7);
		//echo '<pre>data'; print_r($data); die;
			
			if(isset($_POST['update'])):
				$this->adduser_model->addUser();
			endif;
			
			$this->load->view("admin/adduser_add", $data);
		}
		else{
			redirect("admin/login");
		}
	}
	
	public function edit(){
		if($this->session->userdata['user_level'] != 1){
			redirect("admin/dashboard");
		} 
	$is_logged_in = $this->session->userdata('is_logged_in');
	if(!empty($is_logged_in) && $is_logged_in == true){
		if($this->uri->segment(4) != NULL){
		$data['title'] = "Edit User";
		$data['details'] = $this->query_model->getbyId("tbladmin", $this->uri->segment(4));
		$data['links'] = $this->db->query("select * from tbllinks where user_id=".$this->uri->segment(4))->result();
		$data['multi_trial_offer'] = $this->query_model->getBySpecific('tblconfigcalendar','id',14);
		
		// vinay 19/11
		$data['home_tab'] = $this->query_model->getMenuTabPages('admin/home', 7);
		$data['aboutus_tab'] = $this->query_model->getMenuTabPages('admin/aboutus', 7);
		$data['contactus_tab'] = $this->query_model->getMenuTabPages('admin/contactus', 7);
		$data['settings_tab'] = $this->query_model->getMenuTabPages('admin/settings', 7);
		$data['student_section_tab'] = $this->query_model->getMenuTabPages('admin/studentsection', 7);
		$data['leads_tab'] = $this->query_model->getMenuTabPages('admin/leads', 7);
		$data['others'] =  $this->query_model->getOtherPages(0,7);
		$data['school_info_tab'] = $this->query_model->getMenuTabPages('admin/school_info', 7);
		$data['trial_offer_tab'] = $this->query_model->getMenuTabPages('admin/onlinespecial', 7);
		$data['unique_trial_offer_tab'] = $this->query_model->getMenuTabPages('admin/unique_onlinespecial', 7);
		
		$data['forms_tab'] = $this->query_model->getMenuTabPages('admin/form_builder', 7);
		
		$data['school_tab'] = array('admin/school/about_school_header'=>'School Header','admin/school/about_ourschool'=>'About Us','admin/school/text_sections'=>'Text Section','admin/school/video_section'=>'Video Section','admin/school/testimonial_sections'=>'Testimonial / Trial Offer','admin/school/team_member_index'=>'Team Member', 'admin/school/school_staff_index'=>'Our Instructor','admin/school/school_apikeys'=>'Social Api Key');
		$data['twilio_sms_messenger'] = $this->query_model->getMenuTabPages('admin/sms', 7);
		
		
		
			if(isset($_POST['update'])):
			
				$this->adduser_model->updateUser();
			endif;
		$this->load->view("admin/adduser_edit", $data);
		}else{
			redirect($this->index());
		}
	}else{
	redirect("admin/login");}
	}

	public function deleteitem(){
		if($this->session->userdata['user_level'] != 1){
		redirect("admin/dashboard");
	} 
		$id = $_POST['delete-item-id'];
		$this->db->where("id", $id);
		if($this->db->delete("tbladmin"))
		{
			redirect($this->index());
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete category');</script>";
			redirect($this->index());
		}
	}
}