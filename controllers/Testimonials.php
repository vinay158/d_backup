<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonials extends CI_Controller {

	public function index()
	{			
		$this->load->model("testimonials_model");
		
		$data['testimonials'] = $this->testimonials_model->getAllTestimonials();
		
		$this->load->view('testimonials', $data);
		
		/*$this->db->order_by("pos", "ASC");
		$data['staff']= $this->query_model->getbyTable("tblstaff");
		$this->load->view('our-staff', $data);*/
	}		
}
