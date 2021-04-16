<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function index()
	{	
		$data['cat'] = $this->query_model->getCategory("faq");		
		$data['cat_t'] = $data['cat'];
		$this->load->view('faq', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */