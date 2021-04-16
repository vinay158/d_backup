<?php 
if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Specialoffers extends CI_Controller {
	
	public function index()
	{
		//$this->db->order_by("pos", "ASC");
		$cr_date=date('Y-m-d',time());					
		$offers_data=$this->db->query("select * from `tbloffers` where expire >= '$cr_date' order by pos ASC") or die(mysqli_error($this->db->conn_id));  
		$data['offers']=$offers_data->result();		
		//$data['offers'] = $this->query_model->getbyTable("tbloffers");
		$this->load->view('special-offers', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
