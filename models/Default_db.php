<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Default_db extends CI_Model
{
	
	public function row($table = NULL,$where = NULL,$select = NULL,$return = NULL)
	{
		if($select)
		{
			$this->db->select($select);
		}
													
		if($where){
			$this->db->where($where);
		}
		if($return)
		{
			$row = $this->db->get($table)->row_array();
			if(array_key_exists($return,$row))
			{
				return $row[$return];
			}
			else
			{
				return "";
			}
		}
		else
		{
			return  $this->db->get($table)->row_array();
		}
		
	}
	
	public function all($table = NULL,$where = NULL,$select = NULL)
	{
				if($select)
				{
					$this->db->select($select);
				}
				if($where)
				{
					$this->db->where($where);
				}
		return  $this->db->get($table)->result_array();
	}
	
	public function getall($table = NULL,$where = NULL,$select = NULL,$order=NULL,$limit = NULL, $offset = NULL)
	{
		if($select)
		{
			$this->db->select($select);
		}
		if($order){
			$this->db->order_by($order);
		}
		if($where)
		{
			$this->db->where($where);
		}
		if($limit)
		{
			$this->db->limit($limit, $offset);
		}
		return  $this->db->get($table)->result_array();
	}

	public function getall_count($table = NULL,$where = NULL)
	{
		$this->db->from($table);

		if($where)
			$this->db->where($where);

		return  $this->db->count_all_results();
	}
	
	public function empty_fields($database){
		
		$array = $this->db->list_fields($database);
		$fields = array();
		foreach($array as $i){
			$fields[$i] = NULL;
		}
		
		return $fields;
	}
	
	function __extract_message($return = NULL)
	{
			$class = "";
			$message = "";
			if(validation_errors()) 
			{
				$message = validation_errors();
				$class = 'alert-danger';
			}
			else if ($this->session->flashdata('message'))
			{
				$message = $this->session->flashdata('message');
				$class = 'alert-danger';
			}
			else if($this->session->flashdata('good_message'))
			{
				$message = $this->session->flashdata('good_message');
				$class = 'alert-success';
			}
		
		if($return == 'class') return $class;
		elseif($return == 'message') return $message;
		
	} 
	
	function update($table = NULL,$update = NULL,$where = NULL){
		$this->db->where($where);
		$this->db->update($table,$update);
	}
	
	function insert($table = NULL,$insert = NULL){
		
		$this->db->insert($table,$insert);
	return $this->db->insert_id();
	}
	
	function num_rows($table = NULL,$where = NULL){
		
		$this->db->where($where,$where);
	return	$this->db->get($table)->num_rows();
	}
	
	function check_session(){
		
		$s = $this->session->userdata;
		if(array_key_exists('logged',$s) AND $s['logged'] == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	
	
	function check_admin_session(){
		
		$s = $this->session->userdata;
		if(array_key_exists('admin_logged',$s) AND $s['admin_logged'] == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function find($table, $id){

		$this->db->where('id', $id);
		$this->db->limit(1);
		$result = $this->db->get($table)->row_array();

		$item = count($result) > 0 ? $result : NULL;

		return $item;
	}

	function find_where($table, $where){

		$this->db->where($where);
		$this->db->limit(1);
		$result = $this->db->get($table)->row_array();

		$item = count($result) > 0 ? $result : NULL;

		return $item;
	}

	function save($table, $data, $id = NULL){

		$data['modified'] = date('Y-m-d H:i:s');

		if ($id) {
			
			$this->db->where('id', $id);
			$this->db->update($table, $data);

		} else{
			$data['created'] = date('Y-m-d H:i:s');

			$this->db->insert($table, $data);

			$id = $this->db->insert_id();
		}

		return $id;
	}

	function delete($table, $id){
		$this->db->where('id', $id);
		$this->db->delete($table);
	}
	function delete_where($table, $where){
		$this->db->where($where);
		$this->db->delete($table);
	}
	
	
	function get_int_values_from_table($table,$id,$return){
			
			
			$this->db->where('id',$id);
			$row = $this->db->get($table)->row_array();
			
			if(array_key_exists($return,$row)){
				
				return $row[$return];
				
			}
			else{
				return '';
			}
			
		}
	
	function get_int_values_from_table_id_special($what_id = NULL,$table,$id,$return){
			
			
			$this->db->where($what_id,$id);
			$row = $this->db->get($table)->row_array();
			
			if(array_key_exists($return,$row)){
				
				return $row[$return];
				
			}
			else{
				return '';
			}
			
		}
	
	function table_init($table){

		$fields = array();
		$names = $this->db->list_fields($table);

		foreach ($names as $key => $value)
			$fields[$value] = NULL;

		return $fields;
	}
	
}
