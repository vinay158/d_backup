<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		$this->load->model("blog_model");		
	}
	
	public function index()
	{
		redirect("admin/calendar/view/22");
	}
	
	public function view($category = NULL, $page = 1){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Calendar";
		
			$this->db->select(array('cat_id','cat_name'));
			$data['category_detail'] = $this->query_model->getbySpecific('tblcategory',"cat_id",$this->uri->segment(4));
			
			if(empty($data['category_detail'])){
				$this->db->select(array('cat_id','cat_name'));
				$this->db->limit(1);
				$this->db->order_by("pos", "ASC");
				$data['category_detail'] = $this->query_model->getbySpecific('tblcategory',"cat_type","calendar");
				
			}
			//echo '<pre>category_detail'; print_r($data['category_detail']); die;
			//$data['location_data'] = $this->query_model->getAllPublishedLocation();
			/*if(!empty($data['location']) && count($data['location']) == 1){
				$this->query_model->update("tblconfigcalendar","1",array("field_value"=>"0"));
			}else{
				$this->query_model->update("tblconfigcalendar","1",array("field_value"=>"1"));
			}*/
			$data['multi_calendar'] = $this->db->query("SELECT * FROM tblconfigcalendar where `id` = 1");
			$data['multi_calendar'] = $data['multi_calendar']->result();
			$data['multi_calendar'] = $data['multi_calendar'][0];

			$this->db->select(array('calender_layout','embed_calendar_code'));
			$data['site_setting'] = $this->query_model->getByTable("tblsite");
			
			$data['link_type'] = "calendar";
			
			$this->db->order_by("pos", "ASC");
			$this->db->select(array('cat_id','cat_name','cat_slug','published','color','permission'));
			$data['cat'] = $this->query_model->getBySpecific('tblcategory','cat_type', "calendar");
			//$this->db->order_by("isWhole DESC");
			$this->db->order_by("mydate DESC");
			
			$g = $_GET;
			
			if(!$category ) {
				$cartegory = $this->uri->segment(4);
			}
			
			if(array_key_exists('location',$g) AND $g['location'] != ''){
				$this->db->where('location_id',$g['location']);
			}
			
			//$this->db->where('category',$category);
			//$blogs = $this->db->get('tblcalendar')->result_array();
			
			//echo count($blogs); die;
			//**** Pagination ***/
			
			$config = array();
	
			$config['per_page']= 15;
			$config['page']= $page;
			$config['uri_segment'] = 5;
			$config['use_page_numbers'] = TRUE;
	
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Prev';
			$config['base_url']= base_url().'admin/calendar/view/'.$this->uri->segment(4); 
			
			$config['total_rows'] = $this->pagination_model->record_calender_count('tblcalendar',$category);
			$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
			$this->db->order_by('pos asc, id desc');
			$blogs = $this->pagination_model->fetch_calender_data('tblcalendar',$config["per_page"], $offset, $config['total_rows'],$category);
			$this->pagination->initialize($config);
		//echo '<pre>'; print_r($blogs);
			$data['paginglinks'] = $this->pagination->create_links();
			$data['config'] = $config;		
		
			// *** </code> **/
			
			//removed all events with events UNPUBLISHED OR DELETED
			  /*** a slightly more complex array ***/
    
		if($blogs){
			foreach($blogs as $i => $item){
			
			
				$where2['published'] = 1;
				$where2['id'] = $item['location_id'];
				
				$this->db->where($where2);
				$location = $this->db->get('tblcontact')->row_array();
					
				if(!empty($location) && count($location)==0){
				
					unset($blogs[$i]);
				}	
													
															
			}
			
		}	
			//cleanups on all zero locations 
			
			//get first location
			
			$this->db->order_by('id','ASC');
			$first_location = $this->db->get('tblcontact')->row_array();
			
			$this->db->where('location_id',0);
			$this->db->update('tblcalendar',array('location_id'=>$first_location['id']));

			// Get Calendar Page title from tbl_studentpagetitle
				$this->db->where('id', 3);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
			
			
			$data['blogs'] = $blogs;
			
			//echo '<pre>'; print_r($data); die;
			
		}
		else{
		redirect("admin/login");
		}
		
		
		$this->load->view("admin/calendar_index", $data);
	}
	
	public function sortthis(){
		//print_r($_POST);EXIT;
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
	
		$this->db->query("UPDATE `tblcalendar` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function sortcategory(){
		//print_r($_POST);EXIT;
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tblcategory` SET `pos`=" . $i . " WHERE `cat_id`='" . $menu[$i]. "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	public function add(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Calendar";
			$data['cat'] = $this->query_model->getCategory("calendar");			
			$data['location'] = $this->query_model->getAllPublishedLocation();
			
			
			
			// check if multi calendar allowed
			$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_calendar'));
			$result = $query->result();
			$data['multi_calendar']= $result[0]->field_value;
			// var_dump($_POST);exit;
			
			
			$post = $this->input->post();
		
			
			if(isset($_POST['update'])):
			
				
				// echo $this->input->post('title');			
			
				// $this->blog_model->addcalendar();
				//$this->blog_model->addcalendar_v2();
				//echo '<pre>post'; print_r($_POST); die;
				$this->blog_model->addcalendar_new_multiple();
				
				
			endif;
			$this->load->view("admin/calendar_add", $data);	
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function edit(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			if($this->uri->segment(4) != NULL){
				//echo '<pre>POST'; print_r($_POST); die;
				$data['title'] = "Calendar";
				$data['cat'] = $this->query_model->getCategory("calendar");
				$data['location'] = $this->query_model->getAllPublishedLocation();
				
								
				// check if multi calendar allowed
				$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_calendar'));
				$result = $query->result();
				$data['multi_calendar']= $result[0]->field_value;
				
				$this->db->where('id',$this->uri->segment(4));
				$event_record = $this->db->get('tblcalendar')->row_array();
				
				$post = $_POST;
			#	 pre($post);
			//
				if($post and array_key_exists('update',$post)){
					//echo '<pre>post'; print_r($_POST); die;
					if(array_key_exists('is_multiple',$post)){
						$this->blog_model->editcalendar_multiple();
						
					}else{
					
						$this->blog_model->editcalendar();
					
					}
					
					redirect("admin/calendar/view/".$event_record['category']);
					
				}
				
				
				if($event_record['is_multiple'] == 1){
							
			
					$data['details'] = $event_record;
									$this->db->order_by('date');
									$this->db->where('event_id',$event_record['id']);
					$multiple_dates = $this->db->get('tbl_calendar_dates')->result_array();
					
					$data['multiple_dates'] = $multiple_dates;
					// pre($data);exit;
					$this->load->view("admin/calendar_edit_multiple", $data);	
					
				}else{
					
					
					// $details  = $this->query_model->getbyID("tblcalendar", $this->uri->segment(4));
					$data['details'] = $this->default_db->row("tblcalendar", array('id'=>$this->uri->segment(4)));
					
					// pre($data['details']);exit;
					$data['multiple_dates'][0]['id']		= '';
					$data['multiple_dates'][0]['date']		= $data['details']['mydate'];
					$data['multiple_dates'][0]['start']		= $data['details']['start'];
					$data['multiple_dates'][0]['end']		= $data['details']['end'];
					$data['multiple_dates'][0]['repeat']	= $data['details']['repeat'];
					$data['multiple_dates'][0]['isWhole']	= $data['details']['isWhole'];
					$data['multiple_dates'][0]['event_id']	= $data['details']['id'];
					$data['multiple_dates'][0]['created']	= date('Y-m-d H:i:s');
					
					// pre($data);exit;
					$this->load->view("admin/calendar_edit_multiple", $data);
					// $this->load->view("admin/calendar_edit", $data);	
				}
				
				
				
				
				
		
				
			}else
			{
				redirect($this->index());
			}
		}else{
			redirect('admin/login');
		}
	}
	
	/* changelog v2 exception day */
	public function exception(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			if($this->uri->segment(4) != NULL){
				
				$data['title'] = "Calendar";
				$data['cat'] = $this->query_model->getCategory("calendar");
				$data['details'] = $this->query_model->getbyID("tblcalendar", $this->uri->segment(4));
				
				$data['exceptions'] = $this->query_model->getbySpecific("tblexception", 'cal_id', $this->uri->segment(4));
				
				if(isset($_POST['update'])):
					$this->blog_model->edit_exception();
				endif; 
				
				$this->load->view("admin/calendar_exception", $data);
			}else
			{
				redirect($this->index());
			}
		}else{
			redirect('admin/login');
		}
	}
	
	public function delete_exception(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			if($this->uri->segment(4) != NULL){
				
				$this->query_model->deletebyId("tblexception", $this->uri->segment(4));
				
				$cal_id = $this->uri->segment(6);
				
				if($cal_id){
					redirect('admin/calendar/exception/'.$cal_id);
				}else
					redirect($this->index());
				
			}else
			{
				redirect($this->index());
			}
		}else{
			redirect('admin/login');
		}
	}
	
	/* changelog v2 end exception day */
	
	public function deleteCategory(){
	$id = $_POST['delete-id'];
	$this->db->where("cat_id", $id);
	if($this->db->delete("tblcategory"))
	{
		$this->db->query("delete from tblcalendar where category='".$id."'") or die(mysqli_error($this->db->conn_id));
		redirect($this->index());
	}
	else
	{
		echo "<script language='javascript'>alert('Unable to delete category');</script>";
		redirect($this->index());
	}
	}
	
	public function operateCategory(){
	$title = $_POST['name'];
	$operation = $_POST['operation'];
	$id = $_POST['edit_id'];
	$color = $_POST['color'];
	$shared = $_POST['shared'];
	$save = $_POST['submit'];
	//echo $title." ".$operation." ".$id." "." ".$shared." ".$save;
	if(isset($save))
	{
		if( $operation == 'add' )
		{
			$args = array("cat_name" => $title, "cat_type" => "calendar", "permission" => $shared, "color" => $color);
			if($this->query_model->addCategory($args)){
			redirect($this->index());
			}
			else
			{	
				echo "<script language='javascript'>alert('Unable to add category');</script>";
				redirect($this->index());
			}
		}
		elseif( $operation == 'edit' )
		{
			$args = array("cat_name" => $title, "cat_type" => "calendar", "permission" => $shared , "color" => $color);
			$this->db->where("cat_id",$id);
			if($this->query_model->editCategory($args)){
			redirect($this->index());
			}
			else
			{	
				echo "<script language='javascript'>alert('Unable to add category');</script>";
				redirect($this->index());
			}
		}
	}	
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblcalendar"))
	{
		if($_POST['category_loc']){
			redirect("admin/calendar/view/".$_POST['category_loc']);
		}else{
			redirect("admin/calendar");
		}	
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
		if($_POST['category_loc']){
			redirect("admin/calendar/view/".$_POST['category_loc']);
		}else{
			redirect("admin/calendar");
		}
	}
	}
	
	public function update_multicalendar(){
		$val = isset($_POST["multi_calendar"]) ? $_POST["multi_calendar"] : '' ;
		if($this->query_model->update("tblconfigcalendar","1",array("field_value"=>$val))){
			if($val == 0)
				echo "Multi calendar option OFF";
			else
				echo "Multi calendar option ON";	
		}else{
			echo "Error";
		}
	}
	
	
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tblcalendar", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	
	
		public function ajax_delete_popup_record(){
		
				parse_str($_POST['formData'], $searcharray);
				//echo '<pre>searcharray'; print_r($searcharray); die;
				$id = isset($searcharray['delete-item-id']) ? $searcharray['delete-item-id'] : 0;
				$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
				
				if(!empty($id) && !empty($table_name)){
					if($table_name == "tblcategory"){
						$this->db->where("cat_id", $id);
					}else{
						$this->db->where("id", $id);
					}
					if($this->db->delete($table_name))
					{
						if($table_name == "tblcategory"){
							$this->query_model->deletebySpecific('tblcalendar','category',$id);
						}
						
						echo 1;
					}
					else
					{
						echo 0;
					}
				}else{
					echo 1;
				}
				
				exit();	
	}
	
	public function ajaxPublishWebhookApi(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		$table_name = $_POST['table_name'];
		$this->db->where("id", $id);
		if($this->db->update($table_name, array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	public function ajax_full_alternate_popup(){
		
		if(isset($_POST['action_type']) && !empty($_POST['action_type'])){
			$records = array();
			$records['detail'] = array();
			$records['action_type'] = $_POST['action_type'];
			$records['item_id'] = $_POST['item_id'];
			$records['table_name'] = $_POST['table_name'];
			$records['form_type'] = $_POST['form_type'];
			
			if($records['action_type'] == "edit" && !empty($records['item_id'])){
				
				$this->db->where("cat_id", $records['item_id']);
				$this->db->select(array('cat_id','cat_name','cat_type','color','published','permission'));
				$detail = $this->query_model->getbyTable($records['table_name']);
				if(!empty($detail)){
					
					$records['detail'] = $detail[0];
					
				}
			}
			
			//echo '<pre>records'; print_r($records); die;
			$this->load->view("admin/ajax_calendar_category_form", $records);
			
			
		}
	}
	
	
	public function ajax_save_full_alternate_row(){
		
		parse_str($_POST['formData'], $searcharray);
		//echo '<pre>searcharray'; print_r($_POST); die;
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['update'])){
				
				$item_id = isset($searcharray['item_id']) ? $searcharray['item_id'] : '';
				$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
				$form_type = isset($searcharray['form_type']) ? $searcharray['form_type'] : '';
					
					$postData['cat_name'] = isset($searcharray['name']) ? trim($searcharray['name']) : '';
					$postData['cat_type'] = isset($searcharray['cat_type']) ? trim($searcharray['cat_type']) : '';
					$postData['color'] = isset($searcharray['color']) ? trim($searcharray['color']) : '';
					$postData['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
					$postData['permission'] = 1;
					
					
				if(!empty($item_id)){
					
					$this->query_model->updateData($table_name,'cat_id',$item_id, $postData);
					$insert_id = $item_id;
					$result['form_action'] = 'edit';
				}else{
					$this->query_model->insertData($table_name, $postData);
					$insert_id = $this->db->insert_id();
					$result['form_action'] = 'add';
				}
				
					
					$result['res'] = 1;
					$result['id'] = $insert_id;
					$result['title'] = $postData['cat_name'];
					$result['form_type'] = $form_type;
					$result['table_name'] = $table_name;
					$result['photo_side'] = '';
					
				
			}
		echo json_encode($result); 	
	}
	
	
	
}
