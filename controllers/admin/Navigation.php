<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigation extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
	}
	
	public function index()
	{	
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(empty($is_logged_in) && $is_logged_in != true){
			redirect("admin/login");
		}
		
		$data = array();
		
		$data['tblmeta'] = $this->default_db->getall('tblmeta');
		
		$name = 'default'; //set by default because not yet dynamic
		
		$nav_list = $this->default_db->row('navigation_listing', array('listing_name'=>$name));
		$data['nav_list'] = json_decode($nav_list['nav_list']);
		
		
		$this->load->view("admin/navigation", $data);
	}
	
	public function active_page(){
		$post = $this->input->post();
		
		// pre($post);
		
		$check = $this->default_db->getall('tblmeta',array('id'=>$post['id']));
		
		if(empty($check)){
			echo json_encode('Invalid link!');exit;
		}
		
		$update['display_status'] = ($post['status'] == 'false') ? 'H' : 'D';
		$this->db->where('id', $post['id']);
		$this->db->update('tblmeta', $update);
		
		echo json_encode('Successfully updated');
	}
	public function change_link_name(){
		$post = $this->input->post();
		$check_id = $this->default_db->row('tblmeta', array('id'=>$post['id']));
		
		if(empty($check_id)){
				echo json_encode('Unknown link line');exit;
		}
		
		if(empty($post['val'])){
			echo json_encode('Link name is required');exit;
		}
		
		$update['page_label'] = $post['val'];

		$this->db->where('id', $post['id']);
		$this->db->update('tblmeta', $update);
		echo json_encode('Successfully updated');
	
	}
	
	
	public function add(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(empty($is_logged_in) && $is_logged_in != true){
			redirect("admin/login");
		}
		
		$data = array();
		$data['message'] = "";
		
		$post = $this->input->post();
		
		if(!empty($_POST)){
			// pre($_POST);exit;
			$error = false;
			foreach($post as $v){
				if(empty($v)){
					$error = true;
				}
			}
			
			if(!$error){
				$this->db->insert('tblmeta',$post);
				redirect(base_url().'admin/navigation');
			}
			$data['message'] = " All Fields are required";
		}
		
		
		$this->load->view("admin/navigation_add", $data);
	}
	
	public function add_proccess(){
		
	}
	
	
	
	public function save_arrangement(){
		$post = $this->input->post();
		
		if(empty($post)){
			echo json_encode(array('bol'=>false));
		}
		
		$name = !empty($post['name']) ? $post['name'] : 'default';
		
		$check = $this->default_db->row('navigation_listing', array('listing_name'=>$name));
		
		$data = array();
		
		$data['nav_list']	= json_encode($post['data']);
		$data['date_saved']	= date('Y-m-d H:i:s');
		
		if(!empty($check)){
			
			$this->db->where('listing_name', $name);
			$this->db->update('navigation_listing', $data);
			
		}else{
			
			$data['listing_name'] = $name;
			$this->db->insert('navigation_listing', $data);
			
		}
		
		
		echo json_encode(array('bol'=>true, 'message'=> 'List Saved'));
		
		
	}
	
}