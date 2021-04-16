<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dojocart extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }		
		$this->load->model("dojocarts_model");
	}
	
	public function index()
	{
		redirect("admin/dojocart/view");
	}
	
	public function view($page = 1){
	ob_start();
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "DojoCart";
			$data['link_type'] = "dojocart";
			/*$this->db->order_by("timestamp 	", "DESC");
			$data['staff'] = $this->query_model->getbyTable("tblnews");
			$this->load->view("admin/news_index", $data);*/
			
			
			//** Pagination ** //
		
		$config = array();
	
		$config['per_page']= 15;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/dojocart/view/'; 
		
		$config['total_rows'] = $this->pagination_model->record_count('tbl_dojocarts');
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		
		$this->db->order_by('id', 'desc');
		$this->db->select(array('id','product_image','product_title','template','published','slug'));
		$data['dojocartDetails'] = $this->pagination_model->fetch_data('tbl_dojocarts',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		//echo '<pre>';print_r($data); die;
		$this->load->view('admin/dojocarts_index',$data);			
			// ** </code> ** //
			
		}
		else{
		redirect("admin/login");
		}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "DojoCart";
			$data['link_type'] = "dojocart";
			
			$this->db->select(array('s_no','logo_name'));
			$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			//$data['cart_detail'] = $this->query_model->getbyTable("tbl_dojocarts");
			
			$this->db->where("location_type !=", 'coming_soon_location');
			$this->db->where("published", 1);
			//$this->db->where("main_location", 0);
			//$this->db->group_by("city");
			$this->db->order_by("state","asc");
			$this->db->select(array('id','name'));
			$data['dojo_cart_allLocations'] = $this->query_model->getbyTable("tblcontact");	
			
			//echo '<pre>data'; print_r($data); die;
			
			if(isset($_POST['update'])){
				//echo '<pre>$_POST'; print_R($_POST); die;
				$this->dojocarts_model->addCart();
			}
			
			
			if($this->session->userdata('dojo_cart_template') == "events"){
				$this->load->view("admin/dojocart_add_events_template", $data);
			}elseif($this->session->userdata('dojo_cart_template') == "tournaments"){
				$this->load->view("admin/dojocart_add_tournaments_template", $data);
			}elseif($this->session->userdata('dojo_cart_template') == "ata_cr_xma" || $this->session->userdata('dojo_cart_template') == "tiger_blank" || $this->session->userdata('dojo_cart_template') == "novice_blank" || $this->session->userdata('dojo_cart_template') == "traditional_blank"){
				$this->load->view("admin/dojocart_add_ata_cr_xma_template", $data);
			}elseif($this->session->userdata('dojo_cart_template') == "multi_item_dojocart"){
				$this->load->view("admin/dojocart_add_multi_item_template", $data);
			}else{
				$this->load->view("admin/dojocarts_add_default", $data);
			}
		}
		else{
			redirect("admin/login");
		}
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
	if(!empty($is_logged_in) && $is_logged_in == true){
		if($this->uri->segment(4) != NULL){
		$data['title'] = "DojoCart";
		$data['dojo_cart_id']=$this->uri->segment(4);
		$data['details'] = $this->dojocarts_model->getDetailById($this->uri->segment(4));
		$data['upsells'] = $this->query_model->getbySpecific("tbl_dojocart_upsales",'dojocart_id',$this->uri->segment(4));
		$data['items'] = $this->query_model->getbySpecific("tbl_dojocart_items",'dojocart_id',$this->uri->segment(4));
		
		$this->db->select(array('s_no','logo_name'));
		$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
		
		$data['coupons'] = $this->query_model->getbySpecific("tbl_dojocart_coupons",'dojocart_id',$this->uri->segment(4));
		$data['custom_fields'] = $this->query_model->getbySpecific("tbl_dojocart_custom_fields",'dojocart_id',$this->uri->segment(4));
		
		$this->db->where("location_type !=", 'coming_soon_location');
		$this->db->where("published", 1);
		//$this->db->where("main_location", 0);
		//$this->db->group_by("city");
		$this->db->order_by("state","asc");
		$this->db->select(array('id','name'));
		$data['dojo_cart_allLocations'] = $this->query_model->getbyTable("tblcontact");	


		
			if(isset($_POST['update'])):
				$this->dojocarts_model->updateDojoCart();
			endif;
		
			if($data['details'][0]->template == "events"){
				$this->load->view("admin/dojocart_edit_events_template", $data);
			}elseif($data['details'][0]->template == "tournaments"){
				$this->load->view("admin/dojocart_edit_tournaments_template", $data);
			}elseif($data['details'][0]->template == "ata_cr_xma" || $data['details'][0]->template == "tiger_blank" || $data['details'][0]->template == "novice_blank" || $data['details'][0]->template == "traditional_blank"){
				$this->load->view("admin/dojocart_edit_ata_cr_xma_template", $data);
			}elseif($data['details'][0]->template == "multi_item_dojocart"){
				$this->load->view("admin/dojocart_edit_multi_item_template", $data);
			}else{
				$this->load->view("admin/dojocarts_edit_default", $data);
			}
			
		//$this->load->view("admin/dojocarts_edit", $data);
		}else{
			redirect($this->index());
		}
	}else{
	redirect("admin/login");}
	}

	
	public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];

	$this->db->where("id", $id);
	if($this->db->update("tbl_dojocarts", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tbl_dojocarts"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete product');</script>";
	redirect($this->index());
	}
	}
	
	
	public function delete(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['dojo_cart_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tbl_dojocarts set product_image='' where id=".$id.""))
			{	
				$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);					
				echo 1;
			}
			else
			{
				echo 0;
			}
		}else{
				echo 0;
		}
	}

		public function deleteOfferImg(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['dojo_cart_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tbl_dojocarts set offer_image='' where id=".$id.""))
			{	
				$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);					
				echo 1;
			}
			else
			{
				echo 0;
			}
		}else{
				echo 0;
		}
	}



	public function sortthis(){		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
			echo "UPDATE `tblblogs` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'";
			 
			$this->db->query("UPDATE `tblblogs` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}

	public function showPrice(){
		
		if(isset($_POST) && isset($_POST['show_price'])){
			$data['show_price'] = $_POST['show_price'];
			if($this->query_model->update('tbl_dojocarts', 1, $data)){
				return '1';
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	// Delete Upsell Individual
	public function delete_upsell(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['upsell_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("delete from tbl_dojocart_upsales where id=".$id.""))
			{					
				echo 1;
			}
			else
			{
				echo 0;
			}
		}else{
				echo 0;
		}
	}
	
	// Delete Upsell Individual
	public function delete_item(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['item_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("delete from tbl_dojocart_items where id=".$id.""))
			{					
				echo 1;
			}
			else
			{
				echo 0;
			}
		}else{
				echo 0;
		}
	}
	
	
	// Delete Upsell Individual
	public function delete_coupon(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['coupon_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("delete from tbl_dojocart_coupons where id=".$id.""))
			{					
				echo 1;
			}
			else
			{
				echo 0;
			}
		}else{
				echo 0;
		}
	}


	public function deleteFeature(){

		if($_POST){
			$feature_value = $_POST['value'];
			$id = $_POST['dojo_cart_id'];
			
			$detail = $this->query_model->getbyId('tbl_dojocarts',$id);
			
			$features = !empty($detail) ? $detail[0]->features : '';


			$ary = unserialize($features);

			$key = array_search($feature_value, $ary);
			unset ($ary[$key]);

			$feautre_value_data = serialize($ary);
			$data['features'] = $feautre_value_data;
			$this->query_model->update('tbl_dojocarts', $id, $data);

			echo 1;

		}else{
			echo 0;
		}

	}
	
	
	public function saveDojoCartTemplate(){
		//echo '<pre>POST'; print_r($_POST); die;
		if(isset($_POST['submit'])){
			
			$template = $_POST['dojo_cart_template'];
			
			$this->session->set_userdata(array('dojo_cart_template' => $template));
			
			redirect("admin/dojocart/add");
			//echo 'test'; echo $this->session->userdata('dojo_cart_template'); die;
		}
		
	}
	
	
	public function duplicateDojocart(){
		
		parse_str($_POST['formData'], $searcharray);
		$_POST = $searcharray;
		
		$item_id =  (isset($_POST['item_id']) && !empty($_POST['item_id'])) ? $_POST['item_id'] : '';
		$action =  (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
		
		if(isset($action) && $action == "duplicate_record"){
			
			if(isset($item_id) && !empty($item_id) ){
				
				$details = $this->query_model->getbySpecific('tbl_dojocarts','id', $item_id);
				
				if(!empty($details) && ($_POST['title'] != $details[0]->product_title)){
					
					foreach($details[0] as $key => $detail){
						$postData[$key] = $detail;
					}
					
					$postData['product_title']  = $_POST['title'];
					
					$slug = str_replace(' ','-',$postData['product_title']);
					$slug = preg_replace("/[^A-Za-z0-9\-]/", "", $slug);
					
					$postData['slug']  = $slug;
					
					unset($postData['id']);
					
					
					// saving dojocart data
					$this->query_model->insertData('tbl_dojocarts', $postData);
						$duplicate_dojocart_id = $this->db->insert_id();
					
					//$duplicate_program_id = 117;
					
					// saving  code other tables
					$tables = array('tbl_dojocart_upsales','tbl_dojocart_coupons','tbl_dojocart_custom_fields');
					foreach($tables as $table_name){
						
						$records = $this->query_model->getbySpecific($table_name,'dojocart_id', $item_id);
						
						if(!empty($records)){
							foreach($records as $record){
								$dataArr = array();
									
								foreach($record as $key => $val){
									if($key == "id"){
										unset($key);
									}elseif($key == "dojocart_id"){
										$dataArr[$key] = $duplicate_dojocart_id;
									}else{
										$dataArr[$key] = $val;
									}
								}
								
								$this->query_model->insertData($table_name, $dataArr);
							}
							
						}
					}
					
					
					
					$old_cart_slug = '/promo/'.$details[0]->slug;
					$form_instancesDetail = $this->query_model->getbySpecific('tbl_form_instances','page_url', $old_cart_slug);
					if(!empty($form_instancesDetail)){
						
						$formInstanceData = array();
						$formInstanceData['form_type_id'] = $form_instancesDetail[0]->form_type_id;
						$formInstanceData['form_module_id'] = $form_instancesDetail[0]->form_module_id;
						$formInstanceData['page_url'] = '/promo/'.$postData['slug'];
						$formInstanceData['page_name'] = 'Dojocart- '.$postData['product_title'];
						
						$this->query_model->insertData('tbl_form_instances', $formInstanceData);
					}
					
						
				}
			}
		}
		
		echo 1;
		//redirect("admin/dojocart/view");
	
	}
	
	
	public function deleteCustomField(){
		if(isset($_POST['custom_field_id']) && !empty($_POST['custom_field_id'])){
			$this->query_model->deletebySpecific('tbl_dojocart_custom_fields','id',$_POST['custom_field_id']);
			
			echo '1';
		}else{
			echo '0';
		}
		exit();
	}

}