<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ourstaff extends CI_Controller {

	public function index()
	{			
		$this->load->model("staff_model");
		$IsAllowMultiStaff = $this->staff_model->IsAllowMultiStaff();
		
		
		if(isset($this->uri->segments[2]) && $this->uri->segments[2] != ''){
			$location_slug = $this->uri->segments[2];				
			$data['staff'] = $this->staff_model->getFacilityByLocationSlug($location_slug);
		}else{
			$data['staff'] = $this->staff_model->getAllStaff();
		}
		
		/*if($IsAllowMultiStaff){
			//$facility_slug = $this->uri->segments[2];
			if(isset($this->uri->segments[2]) && $this->uri->segments[2] != ''){
				$location_slug = $this->uri->segments[2];				
				$data['staff'] = $this->staff_model->getFacilityByLocationSlug($location_slug);
			}else{
				$data['staff'] = $this->staff_model->getAllStaff();
			}
			
		}else{
			$data['staff'] = $this->staff_model->getAllStaff();
		}*/
		
		$this->load->view('our-staff', $data);
		
		/*$this->db->order_by("pos", "ASC");
		$data['staff']= $this->query_model->getbyTable("tblstaff");
		$this->load->view('our-staff', $data);*/
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */