<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_emailsignatures extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
			redirect('/admin/login');
        }
		$this->table_name = 'tbl_form_emailsignatures';
		$this->controller_name = 'form_emailsignatures';
	}
	
	public function index()
	{
		redirect('admin/'.$this->controller_name.'/add');
	}
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Email Signatures';
			
			$data['link_type'] = $this->controller_name;	
			$data['user_level']=$this->session->userdata['user_level'];	
			
			$this->db->order_by('id','DESC');
			$data['details'] = $this->query_model->getByTable($this->table_name);
			
			$this->load->view("admin/".$this->controller_name."_index", $data);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function edit(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if( $this->uri->segment(4) != NULL ){							 
				$data['title'] = "Edit Email Signature";
				
					$multi_locations = $this->query_model->getbyTable("tblconfigcalendar");
		
					if($multi_locations[0]->field_value == 1){
						$data['locations'] = $this->query_model->getbyTable("tblcontact");
					}else{
						$data['locations'] = $this->query_model->getMainLocation();
					}
					
					
				
				$this->load->view("admin/".$this->controller_name."_edit", $data);
				if(isset($_POST['update'])):
				
						$postData['tag'] = isset($_POST['tag']) ? $_POST['tag'] : '';
						$postData['tag_type'] = isset($_POST['tag_type']) ? $_POST['tag_type'] : '';
						$postData['created'] = date('Y-m-d h:i:s');
						$this->query_model->updateData($this->table_name,'id',$this->uri->segment(4), $postData);	
						redirect("admin/".$this->controller_name);
				endif;		
				
			}else{
				redirect($this->index());
			}
		}else{
		redirect("admin/login");
		}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = "Add Email Signature";
		$multi_locations = $this->query_model->getbyTable("tblconfigcalendar");
		
		
			
		if($multi_locations[0]->field_value == 1){
			$this->db->select(array('id','name'));
			$data['locations'] = $this->query_model->getbyTable("tblcontact");
		}else{
			$this->db->select(array('id','name'));
			$this->db->where('main_location', 1);
			$data['locations'] = $this->query_model->getbyTable("tblcontact");
		}
		
		
		$results = $this->query_model->getByTable($this->table_name);
		
		if(!empty($results)){
			foreach($results as $result){
				$data['detail'][$result->location_id] =  $result;
			}
		} 
		//echo '<pre>data'; print_r($data); die;
		if(isset($_POST['update'])):
				if(isset($_POST['data'])){
					
					$this->db->query("TRUNCATE TABLE ".$this->table_name);
					//die('a');
					foreach($_POST['data'] as $val){
						
						$postData['signature_text'] = isset($val['signature_text']) ? trim($val['signature_text']) : '';
						$postData['location_id'] = isset($val['location_id']) ? $val['location_id'] : 0;
						//$postData['location_name'] = isset($val['location_name']) ? $val['location_name'] : '';
						//	$postData['u_id'] = $u_id;
						$postData['created'] = date('Y-m-d h:i:s');
						
						$this->query_model->insertData($this->table_name, $postData);
					}
				}
				
				
				
				redirect("admin/".$this->controller_name."/add");
			endif;
			$this->load->view("admin/".$this->controller_name."_add", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	
	
	public function deleteitem(){
		$id = $_POST['delete-item-id'];
	
	$this->db->where("id", $id);
	if($this->db->delete($this->table_name))
	{
		redirect("admin/".$this->controller_name);	
	}
	}
	
	
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update($this->table_name, array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	
}
