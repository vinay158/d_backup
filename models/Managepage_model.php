<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* changelog v2 - addcalendar function modified - 15 June 2013 */

class ManagePage_model extends CI_Model{
	
	var $table = 'tblmanagepages';
	
	function getallpage(){
		return $this->query_model->getbyTable($this->table);
	}
	
	
	function getPagebyCat($id){
		return $this->query_model->getbySpecific($this->table, "parent", $id);
	}
	
	function addpage(){
		
		$title = trim($_POST['title']);
		$slug = str_replace(' ', '-', $_POST['slug']);
		$content = htmlentities($_POST['content']);
		$meta_title = $_POST['meta_title'];
		$meta_description = $_POST['meta_description'];
		$published = $_POST['published'];
		$sort_order = $_POST['sort_order'];
		$type = $_POST['type'];
		
		
		$slug = strtolower($slug);
		
		if($slug == ''){
			$slug = str_replace(' ', '-', $_POST['title']);
			$slug = strtolower($slug);	
			}
		
		
		$resAll = mysqli_query($this->db->conn_id,"select * from tblmanagepages where `sort_order` = '$sort_order'");
		$rowAll = mysqli_fetch_array($resAll);
		
		$resMax = mysqli_query($this->db->conn_id,"SELECT MAX(sort_order) FROM tblmanagepages");
		$rowMax = mysqli_fetch_array($resMax);
		$maxValue = $rowMax['MAX(sort_order)'];
		
		
		
			if($rowAll['sort_order'] != $sort_order){
				$sort_order = $_POST['sort_order'];
				//echo $sort_order;
				}
			else
			{
				$sort_order = ($maxValue+1);
				//echo $sort_order;
				}
				
				
				
	
		
		$data = array(
			'title' => $title,
			'slug' => $slug,
			'content' => $content,
			'meta_title' => $meta_title,
			'meta_description' => $meta_description,
			'published' => $published,
			'sort_order' => $sort_order,
			'type' => $type
			
		);
		
		if($this->query_model->insertData($this->table,$data)):
			//redirect("admin/page");
			return true;		
		endif;
		
	
		
	}
	
	
	function updatepage(){
		$title = trim($_POST['title']);
		$slug = str_replace(' ', '-', $_POST['slug']);
		$content = htmlentities($_POST['content']);
		$meta_title = $_POST['meta_title'];
		$meta_description = $_POST['meta_description'];
		$published = $_POST['published'];
		$sort_order = $_POST['sort_order'];
		$type = $_POST['type'];
		
		$slug = strtolower($slug);
		
		if($slug == ''){
			$slug = str_replace(' ', '-', $_POST['title']);
			$slug = strtolower($slug);	
			}
		//echo $slug; die;
		
		$id = $this->uri->segment(4);
		$res = mysqli_query($this->db->conn_id,"select * from tblmanagepages where `sort_order` = '$sort_order' and `id` = '$id'");
		$row = mysqli_fetch_array($res);
		
		
		$resAll = mysqli_query($this->db->conn_id,"select * from tblmanagepages where `sort_order` = '$sort_order'");
		$rowAll = mysqli_fetch_array($resAll);
			
		
		$resMax = mysqli_query($this->db->conn_id,"SELECT MAX(sort_order) FROM tblmanagepages");
		$rowMax = mysqli_fetch_array($resMax);
		$maxValue = $rowMax['MAX(sort_order)'];
		
		
		if($row['sort_order'] == $sort_order && $row['id'] == $id){
			$sort_order = $_POST['sort_order'];
			}
			elseif($rowAll['sort_order'] != $sort_order){
				$sort_order = $_POST['sort_order'];
				}
			else
			{
				$sort_order = ($maxValue+1);
				}
		
		
		
		
			$data = array(
			'title' => $title,
			'slug' => $slug,
			'content' => $content,
			'meta_title' => $meta_title,
			'meta_description' => $meta_description,
			'published' => $published,
			'sort_order' => $sort_order,
			'type' => $type
		);
		
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
				//redirect("admin/page");
			endif;	
	}
	
	
	
	function checkduplicate($title){
		$this->db->where("title",$title);
		return count($this->db->get($this->table)->result());	
	}
	
	
	function updatefaq(){
		$title = $_POST['title'];

		$content = $_POST['ques'];		
		$ques = htmlentities($content);
				
		$content = $_POST['ans'];		
		$ans = htmlentities($content);		
		
		$pub = $_POST['published'];
		$data = array("title" => $title, "ques" => $ques, "ans" => $ans, "published" => $pub);
		if($this->query_model->update("tblfaq",$this->uri->segment(4),$data)):
			if($_POST['redirect']){
				redirect("admin/faq/".$_POST['redirect']);
			}else{
				redirect("admin/faq");
			}	
		endif;
	}
	
	
	
	
}
	
	
