<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_options extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
			redirect('/admin/login');
        }
		
	}
	
	public function index()
	{
		redirect('admin/email_options/view');
	}
	
	public function about_email_option1(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$records['title'] = 'Email Opt-in Only / Full Form';
			$records['link_type'] = 'about';
			$records['location_id'] = $this->uri->segment(5);
			
			$this->db->where("location_id", $this->uri->segment(5));
			$records['pagedetails'] = $this->db->get("tbl_about_email_options")->result();
			
			
			
			if(isset($_POST['update'])){
				//echo '<pre>_POST'; print_r($_POST); die;
				$data['show_full_form_1'] = $_POST['show_full_form_1'];
				$data['show_full_form_2'] = $_POST['show_full_form_2'];
				$data['show_email_opt_form'] = isset($_POST['show_email_opt_form']) ? $_POST['show_email_opt_form'] : 1;
				$data['location_id'] = $_POST['location_id'];
				$data['opt1_text'] = !empty($_POST['opt1_text']) ? $_POST['opt1_text'] : 'Enter your Email to View Current Web-Specials & Pricing';
				$data['opt_2_title'] = !empty($_POST['opt_2_title']) ? $_POST['opt_2_title'] : 'Limited Trial Offers Available';
				$data['opt_2_text'] = !empty($_POST['opt_2_text']) ? $_POST['opt_2_text'] : 'If you want to avoid paying regular pricing or missing out, <br>this is your chance to try our martial arts program for a ridiculously low price<br><strong>TAKE ACTION NOW!</strong>';
				$data['page'] = 'about';
				
				
				if(!empty($records['pagedetails'])){
					$this->query_model->updateData('tbl_about_email_options','location_id',$this->uri->segment(5), $data);
				}else{
					$this->query_model->insertData('tbl_about_email_options', $data);
				}
				
				redirect("admin/email_options/about_email_option1/multilocation/".$_POST['location_id']);
			}
			
			$this->load->view("admin/about_email_option1", $records);
			
		}else{
			redirect('admin/login');
		}
	}
	
	
	
	public function home_page_email_option(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$records['title'] = 'Email Opt-in Only / Full Form';
			$records['link_type'] = 'about';
			$records['location_id'] = $this->uri->segment(5);
			
			$records['pagedetails'] = $this->db->get("tbl_homepage_email_options")->result();
			
			
			
			if(isset($_POST['update'])){
				//echo '<pre>_POST'; print_r($_POST); die;
				$data['show_full_form'] = $_POST['show_full_form'];
				$data['text'] = !empty($_POST['text']) ? $_POST['text'] : '';
				$data['title'] = !empty($_POST['title']) ? $_POST['title'] : '';
				
				
				if(!empty($records['pagedetails'])){
					$this->query_model->updateData('tbl_homepage_email_options','id',1, $data);
				}else{
					$this->query_model->insertData('tbl_homepage_email_options', $data);
				}
				
				redirect("admin/email_options/home_page_email_option");
			}
			
			$this->load->view("admin/home_page_email_option", $records);
			
		}else{
			redirect('admin/login');
		}
	}
	
	
	
}
