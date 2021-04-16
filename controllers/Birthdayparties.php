<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Birthdayparties extends CI_Controller {

	public function index()
	{
		$data['page'] = $this->query_model->getbyId("tblpages", 8);
		$this->load->view('birthday-parties', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */