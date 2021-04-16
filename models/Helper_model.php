<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_model extends CI_Model{
	
	public function checkTestimonials(){
		$this->db->where("published", 1);
		$testimonials = $this->query_model->getbyTable("tbltestimonials");
		return $testimonials;
	}

}
