<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_tags extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
			redirect('/admin/login');
        }
		$this->table_name = 'tbl_form_tags';
		$this->controller_name = 'form_tags';
	}
	
	public function index()
	{
		redirect('admin/'.$this->controller_name.'/view');
	}
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Tags';
			
			$data['link_type'] = $this->controller_name;	
			$data['user_level']=$this->session->userdata['user_level'];	
			
			$data['tagTypes'] = array(
									'active_campaign' => 'Active Campaign Tags',
									'rainmaker'=>'Rainmaker Tags',
									'webhook_outgoing_apis'=>"Webhook Outgoing API's Tags"
								);
			
			$this->db->order_by('id','DESC');
			$this->db->select(array('id','tag'));
			$data['tags']['active_campaign'] = $this->query_model->getbySpecific($this->table_name, 'tag_type','active_campaign');
			
			$this->db->order_by('id','DESC');
			$this->db->select(array('id','tag'));
			$data['tags']['rainmaker'] = $this->query_model->getbySpecific($this->table_name, 'tag_type','rainmaker');
			
			$this->db->order_by('id','DESC');
			$this->db->select(array('id','tag'));
			$data['tags']['webhook_outgoing_apis'] = $this->query_model->getbySpecific($this->table_name, 'tag_type','webhook_outgoing_apis');
			
		//	echo '<pre>data'; print_r($data); die;
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
				$data['title'] = "Edit Form Tag";
				
				$data['details'] = $this->query_model->getbySpecific($this->table_name,'id', $this->uri->segment(4));
				$data['details'] = $data['details'][0];
				//echo '<pre>data'; print_R($data['details']); die;
				$data['tag_types'] = array('active_campaign'=> 'Active Campaign', 'rainmaker' => 'Rainmaker','webhook_outgoing_apis'=> 'Webhook Outgoing Apis'); 
				
				$this->db->select(array('id','api_name'));
				$data['webhook_outgoing_apis'] = $this->query_model->getbySpecific('tbl_webhook_apis','published',1);
		
		
				
				
				if(isset($_POST['update'])):
				
						$postData['tag'] = isset($_POST['tag']) ? trim($_POST['tag']) : '';
						$postData['tag_type'] = isset($_POST['tag_type']) ? trim($_POST['tag_type']) : '';
						$postData['webhook_apis'] = (isset($_POST['webhook_apis']) && !empty($_POST['webhook_apis'])) ? serialize($_POST['webhook_apis']) : '';
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
		$data['title'] = "Add Tag";
		$data['tag_types'] = array('active_campaign'=> 'Active Campaign', 'rainmaker' => 'Rainmaker','webhook_outgoing_apis'=> 'Webhook Outgoing Apis');
		
		$this->db->select(array('id','api_name'));
		$data['webhook_outgoing_apis'] = $this->query_model->getbySpecific('tbl_webhook_apis','published',1);
		
			if(isset($_POST['update'])):
			
				$postData['tag'] = isset($_POST['tag']) ? trim($_POST['tag']) : '';
				$postData['tag_type'] = isset($_POST['tag_type']) ? trim($_POST['tag_type']) : '';
				$postData['webhook_apis'] = (isset($_POST['webhook_apis']) && !empty($_POST['webhook_apis'])) ? serialize($_POST['webhook_apis']) : '';
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
	
	
	
	
	public function ajax_tags_popup(){
		
		if(isset($_POST['action_type']) && !empty($_POST['action_type'])){
			$records = array();
			$records['detail'] = array();
			$records['action_type'] = $_POST['action_type'];
			$records['item_id'] = $_POST['item_id'];
			$records['table_name'] = $_POST['table_name'];
			$records['form_type'] = $_POST['form_type'];
			//$records['location_id'] = $_POST['location_id'];
			$records['tag_types'] = array('active_campaign'=> 'Active Campaign', 'rainmaker' => 'Rainmaker','webhook_outgoing_apis'=> 'Webhook Outgoing Apis'); 
			$this->db->select(array('id','api_name'));
			$records['webhook_outgoing_apis'] = $this->query_model->getbySpecific('tbl_webhook_apis','published',1);
			
			if($records['action_type'] == "edit" && !empty($records['item_id'])){
				
				$this->db->where("id", $records['item_id']);
				$detail = $this->query_model->getbyTable($records['table_name']);
				if(!empty($detail)){
					//echo '<pre>detail'; print_r($detail); die;
					$records['detail'] = $detail[0];
					
				}
			}
			
			
			$this->load->view("admin/ajax_form_tag_form", $records);
			
			
		}
	}
	
	
	public function ajax_save_tag(){
		
		parse_str($_POST['formData'], $searcharray);
		//echo '<pre>searcharray'; print_r($searcharray); die;
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['update'])){
				
				$item_id = isset($searcharray['item_id']) ? $searcharray['item_id'] : '';
				$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
				$form_type = isset($searcharray['form_type']) ? $searcharray['form_type'] : '';
					
					$postData['tag'] = isset($searcharray['tag']) ? trim($searcharray['tag']) : '';
					$postData['tag_type'] = isset($searcharray['tag_type']) ? trim($searcharray['tag_type']) : '';
					$postData['webhook_apis'] = (isset($searcharray['webhook_apis']) && !empty($searcharray['webhook_apis'])) ? serialize($searcharray['webhook_apis']) : '';
					
				if(!empty($item_id)){
					
					$this->query_model->updateData($table_name,'id',$item_id, $postData);
					$insert_id = $item_id;
					$result['form_action'] = 'edit';
				}else{
					$postData['created'] = date('Y-m-d h:i:s');
					$this->query_model->insertData($table_name, $postData);
					$insert_id = $this->db->insert_id();
					$result['form_action'] = 'add';
				}
				
					
					$result['res'] = 1;
					$result['id'] = $insert_id;
					$result['title'] = $postData['tag'];
					$result['form_type'] = $postData['tag_type'];
					$result['table_name'] = $table_name;
					
				
			}
		echo json_encode($result); 	
	}
	
	
	
	
}
