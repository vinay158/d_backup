<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_model extends CI_Model{
	
	var $table = 'tbloffers';
	
	function addOffer(){
	$name = $_POST['name'];
	$offer = '';
	$desc = $_POST['desc'];
	$start = $_POST['start'];
	$end = $_POST['expire'];
	$image = $_FILES['userfile']['name'];
	$position = $this->db->count_all_results($this->table);
	$pos = $position + 1;
	
	if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/offers/";
		if($a = $this->upload_model->upload_image($path)){
			$data = array("name" => $name, "offers" => $offer,  "desc" => $desc,  "start" => $start,  "expire" => $end,  "photo" => $a, "pos" => $pos );
		
			if($this->query_model->insertData($this->table,$data)):
				redirect("admin/offers");
			endif;
		}
		else{
				
		 		$error = strip_tags($this->upload->display_errors());
				echo '<script>alert("'.$error.'");</script>';
		  }
		}else{
			$data = array("name" => $name, "offers" => $offer,  "desc" => $desc,  "start" => $start,  "expire" => $end, "pos" => $pos);
		if($this->query_model->insertData($this->table,$data)):
			redirect("admin/offers");
		endif;
		}
	}
	
	function updateOffer(){
	$name = $_POST['name'];
	$offer = '';
	$desc = $_POST['desc'];
	$start = $_POST['start'];
	$end = $_POST['expire'];
	$image = $_FILES['userfile']['name'];
	$error="";
	if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/offers/";
			if($a = $this->upload_model->upload_image($path)){
			$data = array("name" => $name, "offers" => $offer,  "desc" => $desc,  "start" => $start,  "expire" => $end,  "photo" => $a);
				if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
					redirect("admin/offers");
				endif;
			}	
			else{
		 		$error = strip_tags($this->upload->display_errors());
			
		  }
	}
	if(isset($_POST['last-photo']) && empty($image)){
			$data = array("name" => $name, "offers" => $offer,  "desc" => $desc,  "start" => $start,  "expire" => $end);
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
					redirect("admin/offers");
			endif;
	}else{
			if(!$error){
				$data = array("name" => $name, "offers" => $offer,  "desc" => $desc,  "start" => $start,  "expire" => $end);
				if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
						redirect("admin/offers");
				endif;
			}else{
					echo '<script>alert("'.$error.'");</script>';	
			}	
		}
	}
}