<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ourschool extends CI_Controller {

	public function index()
	{
		$data['page'] = $this->query_model->getbyId("tblpages", 4);
		$this->load->view('our-school', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */