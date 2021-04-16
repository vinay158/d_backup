<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->helper('url');	
		$this->load->database();
			
	}
	
	function index($slug=''){
		
		//$slug = $this->uri->segment(1);
		//echo 'slug: '.$slug;
		
		if(empty($slug)){
			$sql = "Select * From tblnews where published = 1 and publish_date <= now() order by timestamp desc";
			$query = $this->db->query($sql);
			$data['current'] = $query->row_object();			
		}else{
			$query = $this->db->get_where('tblnews', array('slug' => $slug, 'published' => 1));
			$data['current'] = $query->row_object();
		}
		
		//echo '<pre>'; print_r($data['current']); echo '</pre>';
		
		$this->db->select("id, title, timestamp, slug");
		$this->db->from('tblnews');
		$this->db->where("published", 1);
		$this->db->where("publish_date <= now()");
		$this->db->order_by("timestamp", "desc");
		$query = $this->db->get();				
		$data['sideitems'] = $query->result();
		//echo $this->db->last_query();
		// $data['sideitems'] = $this->query_model->getbySpecific("tblnews", "published", 1);
		
		$this->load->view('news', $data);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */