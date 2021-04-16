<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	public function index()
	{	
		$this->db->select("status");
		$site_setting = $this->query_model->getbyTable("tblsite");
		if(!empty($site_setting)):
		foreach($site_setting as $setting):
		if($setting->status == 1){
			redirect("");
		}	
		else{	
			$DomainName =str_ireplace('www.', '', parse_url(base_url(), PHP_URL_HOST));				
			echo "$DomainName is undergoing server maintenance but will be back online shortly. Sorry for the inconvenience.";
		}	
		endforeach;
		endif; 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */