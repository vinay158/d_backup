<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ourfacility extends CI_Controller {

	public function index()
	{	
		
		$this->load->model("facility_model");
		$IsAllowMultiFacility = $this->facility_model->IsAllowMultiFacility();
		
		$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_map'));
		$result = $query->result();
		$IsMultiMap = $result[0]->field_value;
		
		
		if(isset($this->uri->segments[2]) && $this->uri->segments[2] != ''){
			$facility_slug = $this->uri->segments[2];
			$data['facility'] = $this->facility_model->getFacilityBySlug($facility_slug);
		}else{
			$data['facility'] = $this->facility_model->getMainFacility();
		}
			
		/*if($IsAllowMultiFacility){
			//$facility_slug = $this->uri->segments[2];
			if(isset($this->uri->segments[2]) && $this->uri->segments[2] != ''){
				$facility_slug = $this->uri->segments[2];
				$data['facility'] = $this->facility_model->getFacilityBySlug($facility_slug);
			}else{
				$data['facility'] = $this->facility_model->getMainFacility();
			}
			
			//echo '<pre>'; print_r($data['facility']); echo '</pre>';
			
		}else{
			$data['facility'] = $this->facility_model->getMainFacility();
		}*/

		$this->load->view('our-facility', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */