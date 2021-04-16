<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homework extends CI_Controller {

	public function index()
	{	$data=array();
		$data['error_arr']=array();
		//$data['cat'] = $this->query_model->getCategory("faq");		
		//$data['cat_t'] = $data['cat'];
		$this->db->order_by("pos", "ASC");
		$data['faq'] = $this->query_model->getbySpecific("tblhomework", "published", 1);		
		$this->load->view('homework', $data);
		
	}
	
	public function send(){
			$data['error_arr']=array();
			$is_post=false;
			echo '<pre>';
			print_r($_POST);
			echo '</pre>';
			$is_logged_in = $this->session->userdata('is_logged_in');
			if(!empty($is_logged_in) && $is_logged_in == true)
			{	
				if ( isset($_POST['form_email_2']) && !filter_var($_POST['form_email_2'], FILTER_VALIDATE_EMAIL)){
						$is_post=false;
						$data['error_arr'][]='emailNotValid';
				}
				
				foreach ($_POST['ques'] as $index => $ques):
					if(!$ques){
						$is_post=false;
						$data['error_arr'][]='ansNotEmpty';
					}
				endforeach;

				if(count($data['error_arr'])==0 && isset($_POST['submit'])){
					echo 'submit form';
						//$data['offers'] = $this->query_model->getbyTable("tblspecialoffer");
						//$this->trial_model->addTrial($data);
				}							
					
				}
				
				$this->db->order_by("pos", "ASC");
				$data['faq'] = $this->query_model->getbySpecific("tblhomework", "published", 1);		
				$this->load->view('homework', $data);
		//}	
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */