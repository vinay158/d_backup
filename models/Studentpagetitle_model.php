<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Studentpagetitle_model extends CI_Model{
	
	var $table = 'tbl_studentpagetitle';
	
	function addStudentpagetitle(){
	
	$title = $_POST['title'];
	
	$data = array("title" => $title);
	
	if($this->query_model->insertData($this->table, $data)):
		redirect("admin/studentpagetitle");
	endif;
	
	}
	
	function editStudentpagetitle(){
	//echo '<pre>'; print_r($_POST); die;
	$title = $_POST['title'];

	$data = array("title" => $title);
	if($this->query_model->update($this->table, $this->uri->segment(4), $data)):
		redirect("admin/studentpagetitle");
	endif;
	
	}	
	

	

		
		
}