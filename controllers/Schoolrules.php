<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schoolrules extends CI_Controller {

	public function index()
	{	$this->db->order_by("pos", "ASC");
		$data['rules']= $this->query_model->getbyTable("tblrules");
		$this->load->view('school-rules', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */