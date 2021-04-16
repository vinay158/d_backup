<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_thankyou_pages extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
			redirect('/admin/login');
        }
		$this->table_name = 'tbl_form_thankyou_pages';
		$this->controller_name = 'form_thankyou_pages';
	}
	
	public function index()
	{
		redirect('admin/'.$this->controller_name.'/view');
	}
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Thank You Pages';
			
			$data['link_type'] = $this->controller_name;	
			$data['user_level']=$this->session->userdata['user_level'];	
			
			$this->db->order_by('id','DESC');
			$this->db->select(array('id','title','status'));
			$data['details'] = $this->query_model->getByTable($this->table_name);
			//echo '<pre>data'; print_r($data); die;
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
				$data['title'] = "Edit: Thank You Page";
				
				$data['details'] = $this->query_model->getbySpecific($this->table_name,'id', $this->uri->segment(4));
				$data['details'] = $data['details'][0];
				
				$this->db->select(array('name'));
				$data['form_instances'] = $this->query_model->getbySpecific('tbl_form_modules','thankyou_page_id', $data['details']->id);
				
				
				if(isset($_POST['update'])):
				
						$postData['title'] = isset($_POST['title']) ? trim($_POST['title']) : '';
						$postData['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
						$postData['created'] = date('Y-m-d h:i:s');
						$this->query_model->updateData($this->table_name,'id',$this->uri->segment(4), $postData);	
						redirect("admin/".$this->controller_name);
				endif;	
				
				$this->load->view("admin/".$this->controller_name."_edit", $data);
				
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
		$data['title'] = "Add: Thank You Page";
		
		if(isset($_POST['update'])):
		
				$postData['title'] = isset($_POST['title']) ? trim($_POST['title']) : '';
				$postData['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
				$postData['created'] = date('Y-m-d h:i:s');
				$this->query_model->insertData($this->table_name, $postData);
				redirect("admin/".$this->controller_name);
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
