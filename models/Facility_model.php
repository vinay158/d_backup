<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facility_model extends CI_Model{
	
	var $table = 'tblfacilities';
	
	function getAllFacilities(){
		
		$this->db->select('tblfacilities.*, tblcontact.name');
		$this->db->from('tblfacilities');
		$this->db->join('tblcontact', 'tblcontact.id = tblfacilities.location_id', 'left');

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}
	
	
	function IsAllowMultiFacility(){
		$this->load->database();
		
		$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_facility'));
		$result = $query->result();
		return $result[0]->field_value;
	}
	
	function hasMainfacility(){
		$this->load->database();
		
		$query = $this->db->get_where('tblfacilities', array('main_facility' => '1'));

		return $query->num_rows();
	}
	
	function getSingleFacility(){
		
		$this->db->select('tblfacilities.*, tblcontact.name');
		$this->db->from('tblfacilities');
		$this->db->join('tblcontact', 'tblcontact.id = tblfacilities.location_id', 'left');
		$this->db->limit(1);
		
		$query = $this->db->get();		

		if($query->num_rows() > 0){
			$result = $query->result();
			//echo '<pre>'; print_r($result[0]); echo '</pre>';
		 	return $result[0];
		}else{
			return false;	
		}
	}
	
	function getMainFacility(){
		
		$this->db->select('tblfacilities.*');
		$this->db->from('tblfacilities');
		$this->db->where('main_facility', 1);

		$query = $this->db->get();		

		if($query->num_rows() > 0){
			$result = $query->result();
			//echo '<pre>'; print_r($result[0]); echo '</pre>';
		 	return $result[0];
		}else{
			return false;	
		}
	}
	
	function getFacilityById($id){
		
		$this->db->select('tblfacilities.*, tblcontact.name');
		$this->db->from('tblfacilities');
		$this->db->join('tblcontact', 'tblcontact.id = tblfacilities.location_id', 'left');
		$this->db->where('tblfacilities.id', $id); 
		
		$query = $this->db->get();

		if($query->num_rows() > 0){
			$result = $query->result();
			//echo '<pre>'; print_r($result[0]); echo '</pre>';
		 	return $result[0];
		}else{
			return false;	
		}
	}
	
	function getFacilityBySlug($facility_slug){
		
		$this->db->select('tblfacilities.*, tblcontact.name');
		$this->db->from('tblfacilities');
		$this->db->join('tblcontact', 'tblcontact.id = tblfacilities.location_id', 'left');
		$this->db->where('tblfacilities.slug', $facility_slug); 

		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$result = $query->result();
			//echo '<pre>'; print_r($result[0]); echo '</pre>';
		 	return $result[0];
		}else{
			return false;	
		}
	}
	
	function getLocations(){
		$query = $this->db->get('tblcontact');
		$result = $query->result();
		$data = array();
		foreach($result as $r){
			$data[$r->id] = $r->name;
		}
		
		return $data;
		
	}
	
	function updateFacility(){
		
		$facility_id = $this->input->post('facility_id');
		$title = $this->input->post('title');
		//$location_id = $this->input->post('location_id');
		$content = htmlentities($this->input->post('text'));
		$meta_title = $this->input->post('meta_title');
		$meta_desc = $this->input->post('meta_desc');
		$is_main = $this->input->post('is_main');
		
		if(preg_match('/\s/',$title)){
			$slug = str_replace(" ","-",strtolower($title));
		}else{
			$slug = strtolower($title);
		}
		
		$data = array(
					   'title' => $title,
					   //'location_id' => $location_id,
					   'content' => $content,
					   'slug' => $slug,
					   'meta_title' => $meta_title,
					   'meta_desc' => $meta_desc,
					   'main_facility' => $is_main
					);		
			
		if($facility_id){
			$this->db->where('id', $facility_id);
			$result = $this->db->update('tblfacilities', $data); 	
			return $result;
		}else{			
			$result = $this->db->insert('tblfacilities', $data); 
			return $result;
		}
		
	}
}
