<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class getTips extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('tips_model');
	}
	
	public function index()
	{	
		
		$this->load->helper('url');		
		$this->db->where("id", 1);
		$data['gettips'] = $this->db->get("tblgettips")->row_array();	
		
		$data['locations'] = $this->query_model->getAllPublishedLocation();
		
		$multi_location = $this->db->get('tblconfigcalendar');
		$multi_location_data = $multi_location->result();
		$multi_location_data = $multi_location_data[0];
		$data['multi_location_data'] = $multi_location_data->field_value;
					
		$this->load->view('gettips', $data);
	}
	
	public function send(){
		
		$this->load->library("email");
		$email = $this->input->post('form_email_2');
		//echo $email;
		//exit;
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){						
						
			if(isset($_POST['submit'])):	
			
				//echo '<pre>'; print_r($_POST); echo '</pre>';
				//exit;
			
				if($_POST['website'] != ''){

					die("You spammer!");
	
				}
			
									
				$this->tips_model->addTips();
			
			endif;

		}else{	
			echo "<script>alert('Invalid Email Address!')</script>";
		}
		
		redirect("gettips");
			
	}
	
	function sendsuccessfull(){
		$data = array();
		$this->load->view('gettipssuccess', $data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
