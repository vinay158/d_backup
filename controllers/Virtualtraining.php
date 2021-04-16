<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Virtualtraining extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('url');	
		
		$this->load->database();
			
	}
	
	
	
	
	public function index(){
			
			$data['detail'] = $this->query_model->getbyTable("tbl_virtual_training");
			
			if($data['detail'][0]->without_login_virtual_training == 0){
					redirect(base_url());
			}
			$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
			$data['student_section_slug'] = $data['student_section_slug'][0];
			
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			
			
			$this->db->where('published',1);
			$this->db->order_by('pos','asc');
			$data['virtual_training_rows'] = $this->query_model->getbyTable("tbl_virtual_training_rows");
			
			$this->load->view('virtual_training', $data);
	}
	
	
	public function detailpage($slug = ""){
		
		$data['virtual_training'] = $this->query_model->getbyTable("tbl_virtual_training");
		if($data['virtual_training'][0]->without_login_virtual_training == 0){
					redirect(base_url());
			}
			
			$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
			$data['student_section_slug'] = $data['student_section_slug'][0];
			
			$data['virtual_training_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 54);
			$data['virtual_training_slug'] = $data['virtual_training_slug'][0];
			
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			if(!empty($slug)){
				$this->db->where('published',1);
				$this->db->where('slug',$slug);
				$this->db->order_by('pos','asc');
				$data['detail'] = $this->query_model->getbyTable("tbl_virtual_training_rows");
				
				
				if(empty($data['detail'])){
					redirect($data['virtual_training_slug']->slug);
				}else{
					
					$this->db->where("rows_id", $data['detail'][0]->id);
					$data['times'] = $this->query_model->getbyTable('tbl_virtual_training_rows_time');
		
					$this->load->view('virtual_training_row_detail', $data);
				}
			}else{
				redirect($data['virtual_training_slug']->slug);
			}
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */