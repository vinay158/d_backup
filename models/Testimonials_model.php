<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonials_model extends CI_Model{
	
	var $table = 'tbltestimonials';
	
	function updateTestimonials(){
		
		$image = $_FILES['userfile']['name'];
		$name = trim($_POST['name']);
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
				
		$title = $_POST['title'];
		$publish = $_POST['publish'];		
		
		$a = $error = '';
				
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/";
			if($a = $this->upload_model->upload_image($path))
			{
				$data = array(
					'name' => $name,
					'content' => $content,		
					'photo' => $a,
					'title' => $title,
					'published' => $publish
				);
				if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
					redirect("admin/testimonials");
				endif;
			}else{
				$error = strip_tags($this->upload->display_errors());
				echo '<script>alert("'.$error.'");</script>';
			}
		}
		else {
			$data = array(
				'name' => $name,
				'content' => $content,
				'title' => $title,
				'published' => $publish
			);
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
					redirect("admin/testimonials");
			endif;			
		}

	}
	
	function addTestimonials(){
		
		$image = $_FILES['userfile']['name'];
		$name = trim($_POST['name']);
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
				
		$title = $_POST['title'];
		
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/";
			if($a = $this->upload_model->upload_image($path)){
				$data = array(
					'name' => $name,
					'content' => $content,
					'photo' => $a,
					'title' => $title,
					'published' => 1
				);
				if($this->query_model->insertData($this->table,$data)):
					redirect("admin/testimonials");
				endif;
			}
			else{
	 			$error = strip_tags($this->upload->display_errors());
				echo '<script>alert("'.$error.'");</script>';
	  		}
		}else{
			$data = array(
				'name' => $name,
				'content' => $content,
				'title' => $title,
				'photo' => '',
				'published' => 1
			);
			if($this->query_model->insertData($this->table,$data)):
				redirect("admin/testimonials");
			endif;
		}
	}
	function getTestimonialsbyId($id){
		return $this->query_model->getbyId($this->table, $id);
	}
	
	function IsAllowMultiStaff(){
		$this->load->database();
		
		$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_staff'));
		$result = $query->result();
		return $result[0]->field_value;
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
	
	function getAllTestimonials(){
		
		$this->db->select('*');
		$this->db->from('tbltestimonials');
		$this->db->order_by('pos asc, id desc');

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}
	
	function getFacilityByLocationSlug($location_slug){
		
		$this->db->select('tblstaff.*, tblcontact.name as location, , tblcontact.slug');
		$this->db->from('tblstaff');
		$this->db->join('tblcontact', 'tblcontact.id = tblstaff.location_id', 'left');
		$this->db->where('tblstaff.published', 1);
		$this->db->where('tblcontact.slug', $location_slug);
		
		$query = $this->db->get();
		
		//echo $this->db->last_query();

		if($query->num_rows() > 0){
			$result = $query->result();
			//echo '<pre>'; print_r($result); echo '</pre>';
		 	return $result;
		}else{
			return false;	
		}
	}
	
}