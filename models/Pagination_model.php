<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pagination_Model extends CI_Model {
function __construct() {
parent::__construct();
}
// Count all record of table "contact_info" in database.
public function record_count($table) {
return $this->db->count_all($table);
}

public function fetch_data($table,$limit,$offset, $num) {	
	$this->db->limit($limit,$offset);
	//$this->db->where('id', $id);
	$query = $this->db->get($table);
	//echo $this->db->last_query(); 
	if ($query->num_rows() > 0) {
	foreach ($query->result() as $row) {
	$data[] = $row;
	}
	return $data;
	}
	return false;
}




public function record_calender_count($table, $category) {
	$this->db->where('category',$category);
	$events = $this->db->get('tblcalendar')->result_array();
	return count($events);
}

public function fetch_calender_data($table,$limit,$offset, $num, $category) {
//echo $table.'==>'.$limit.'===>'.$page.'===>'. $num.'===>'. $category;
$this->db->where('category',$category);
$this->db->order_by("mydate DESC");
$this->db->limit($limit,$offset);
$query = $this->db->get($table);
//echo $this->db->last_query(); 
if ($query->num_rows() > 0) {
foreach ($query->result_array() as $row) {
$data[] = $row;
}
return $data;
}
return false;
}
}
?>