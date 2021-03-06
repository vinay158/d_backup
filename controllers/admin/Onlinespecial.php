<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onlinespecial extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("onlinespecial_model");
	}
	
	public function index()
	{
		redirect("admin/onlinespecial/view/1");
	}
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			$data['title'] = "Online Special"; //title on view page
			$data['link_type'] = "onlinespecial"; //cotroller name
			
			$this->db->select(array('id','name'));
			$data['category_detail'] = $this->query_model->getbySpecific('tbl_onlinespecial_categories',"id",$this->uri->segment(4));
			
			if(empty($data['category_detail'])){
				$this->db->select(array('id','name'));
				$this->db->limit(1);
				$this->db->order_by("pos", "ASC");
				$data['category_detail'] = $this->query_model->getbyTable('tbl_onlinespecial_categories');
				
			}
			
			$category_id = isset($data['category_detail'][0]->id) ? $data['category_detail'][0]->id : $this->uri->segment(4);
			
			
			$this->db->select(array('s_no','logo_name'));
			$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			
			$this->db->select(array('tiral_url_type','another_trial_url','trial_override_logo'));
			$data['site_setting'] = $this->query_model->getbyTable('tblsite');
			//echo '<pre>'; print_r($data['site_setting']); die;
			
			$this->db->order_by('pos asc, id desc');
			$this->db->where("cat_id",$category_id);
			$this->db->select(array('id','offer_title','trial','display_trial','cat_id','published','title'));
			$data['offer'] = $this->query_model->getbyTable("tblspecialoffer");
			
			$data['multi_location'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			$this->db->where("published", 1);
			$this->db->where("location_type", 'regular_link');
			$this->db->order_by("pos","asc");
			$this->db->select(array('id','name'));
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			
			$this->db->select(array('trial_header_title','trial_header_desc','additional_text_1','additional_text_2','additional_text_3','mini_form_offer_title','mini_form_offer_desc','button1_text','button2_text'));
			$data['mini_form_detail'] = $this->query_model->getbyId("tblsite", 1);
			
			
			$this->db->order_by("pos", 'asc');
			$this->db->select(array('id','name','slug','heading'));
			$data['categories'] = $this->db->get("tbl_onlinespecial_categories")->result();
		//	echo '<pre>'; print_r($data['categories']); die;
			
			$this->db->select(array('id','cat_id','title'));
			$allTrialOffers = $this->query_model->getByTable('tblspecialoffer');
			
			if(!empty($allTrialOffers)){
				foreach($allTrialOffers as $offer){
					$this->db->select(array('id'));
					$trialCat = $this->query_model->getBySpecific('tbl_onlinespecial_categories','id',$offer->cat_id);
					if(empty($trialCat)){
						$this->db->where("id", $offer->id);
						$this->db->delete("tblspecialoffer");
					}
				}
			}
			//echo '<pre>data'; print_r($data); die;
			$this->load->view("admin/onlinespecial_index", $data);
		}
		else{
			redirect("admin/login");
		}
	}
	
	public function add(){ 
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Online Special";
			$data['link_type'] = "onlinespecial";
			//$data['site_setting'] = $this->query_model->getbyTable('tblsite');
			
			$this->db->select(array('s_no','logo_name'));
			$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			
			$this->db->order_by("pos", 'asc');
			$this->db->select(array('id','name'));
			$data['categories'] = $this->db->get("tbl_onlinespecial_categories")->result();
			
			//echo '<pre>data'; print_r($data); die;
	
			if(isset($_POST['update'])):
				$this->onlinespecial_model->addOffer();
			endif;
			
			$this->load->view("admin/onlinespecial_add", $data);
		}
		else{
			redirect("admin/login");
		}
	}
	
	public function edit(){		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			if($this->uri->segment(4) != NULL){
			
			$data['title'] = "Online Special";
			$data['details'] = $this->query_model->getbyId("tblspecialoffer", $this->uri->segment(4));
			//$data['site_setting'] = $this->query_model->getbyTable('tblsite');
			
			$this->db->select(array('s_no','logo_name'));
			$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
			
			$this->db->order_by("pos", 'asc');
			$this->db->select(array('id','name'));
			$data['categories'] = $this->db->get("tbl_onlinespecial_categories")->result();
			
			$data['upsells'] = $this->query_model->getbySpecific("tbl_onlinespecial_upsales",'trial_offer_id',$this->uri->segment(4));
			//echo '<pre>data'; print_r($data); die;
				if(isset($_POST['update'])):
				
					$this->onlinespecial_model->updateOffer();
				endif;
			//	echo '<pre>'; print_r($data); die;
				$this->load->view("admin/onlinespecial_edit", $data);
			}else{
				redirect($this->index());
			}
		}else{
			redirect("admin/login");
		}
	}
	
	
	
	// Delete Upsell Individual
	public function delete_upsell(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['upsell_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("delete from tbl_onlinespecial_upsales where id=".$id.""))
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
	
	

	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tblspecialoffer` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//echo '<pre>'; print_r($_POST); die;
	$this->db->where("id", $id);
	if($this->db->update("tblspecialoffer", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	
	public function displaytrials(){
	$id = $_POST['pub_id'];
	$display_trial = $_POST['display_trial'];
	//echo '<pre>'; print_r($_POST); die;
	$this->db->where("id", $id);
	if($this->db->update("tblspecialoffer", array("display_trial" => $display_trial)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['del_item_id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblspecialoffer"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	redirect($this->index());
	}
	}
	
	
	
	
	function miniformvalues(){
		//echo '<pre>'; print_r($_POST); die;
		$additional_text_1 	= $this->input->post('additional_text_1');
		$additional_text_2 = $this->input->post('additional_text_2');
		$additional_text_3 = $this->input->post('additional_text_3');
		$trial_header_title = $this->input->post('trial_header_title');
		$trial_header_desc = $this->input->post('trial_header_desc');
		$override_logo 	= $this->input->post('trial_override_logo');
		
		$data = array('trial_header_title'=>$trial_header_title,'trial_header_desc'=>$trial_header_desc,'additional_text_1'=>$additional_text_1, 'additional_text_2'=> $additional_text_2, 'additional_text_3'=>$additional_text_3,'trial_override_logo'=>$override_logo);
		
		if(isset($_POST['update'])){
			$this->query_model->update("tblsite", 1, $data);
		
			redirect("admin/onlinespecial");
		}
		
		
	}
	
	
	
	function miniformvalues_2(){
		$mini_form_offer_title 	= $this->input->post('mini_form_offer_title');
		$mini_form_offer_desc = $this->input->post('mini_form_offer_desc');
		
		$button1_text = $this->input->post('button1_text');
		$button2_text = $this->input->post('button2_text');
		
		$data = array("mini_form_offer_title" => $mini_form_offer_title, "mini_form_offer_desc" => $mini_form_offer_desc,'button1_text'=>$button1_text,'button2_text'=>$button2_text);
		
		if(isset($_POST['update'])){
			$this->query_model->update("tblsite", 1, $data);
		
			redirect("admin/onlinespecial");
		}
		
		
	}
	
	
	public function selectFrontDisplayTrial(){
			$id = $_POST['offer_id'];
			$trial = $_POST['trial_value'];
			
			$this->db->where('display_trial',1);
			$records = $this->query_model->getbySpecific('tblspecialoffer','trial',$trial);
			
			if($trial == 0){
				if(count($records) >= 1){
					echo '0';
				}else{
					$data = array('display_trial' => 1);
					$this->query_model->update("tblspecialoffer", $id, $data);
					echo '1';
				}
			} else {
				if(count($records) >= 2){
					echo '0';
				}else{
					$data = array('display_trial' => 1);
					$this->query_model->update("tblspecialoffer", $id, $data);
					echo '1';
				}
			
			}
			
	}
	
	
	
	
	public function unSelectFrontDisplayTrial(){
			$id = $_POST['offer_id'];
			$trial = $_POST['trial_value'];
			
			$data = array('display_trial' => 0);
			$this->query_model->update("tblspecialoffer", $id, $data);
			
			echo '1';
			
	}
	
	
	public function saveAnotherMultiLocationTrialUrl(){
		
		if(isset($_POST['update'])){
			
			if(isset($_POST['data']) && !empty($_POST['data'])){
				
				$this->db->truncate('tbl_multi_trial_offers');
				
				foreach($_POST['data'] as $data){
					$insert_data = array();
					$insert_data['location_id'] = $data['location_id'];
					$insert_data['trial_offer_url'] = trim($data['trial_offer_url']);
					$insert_data['trial_offer_link_target'] = $data['trial_offer_link_target'];
					$this->db->insert('tbl_multi_trial_offers', $insert_data); 
					
				}
				redirect("admin/onlinespecial");
			}
			
		}
		
	}

	
	public function saveAnotherMultiLocationUniqueTrialUrl(){
		
		if(isset($_POST['update'])){
			
			if(isset($_POST['data']) && !empty($_POST['data'])){
				
				$this->db->truncate('tbl_multi_trial_offers');
				
				foreach($_POST['data'] as $data){
					$insert_data = array();
					$insert_data['location_id'] = $data['location_id'];
					$insert_data['trial_offer_url'] = trim($data['trial_offer_url']);
					$insert_data['trial_offer_link_target'] = $data['trial_offer_link_target'];
					$this->db->insert('tbl_multi_trial_offers', $insert_data); 
					
				}
				redirect("admin/unique_onlinespecial");
			}
			
		}
		
	}

	/*** created new function for new offer trials **/
	
	public function header(){
		
			$id = 1;
			
			$records['title'] = 'Trial Offer Header';
			$this->db->where("id", $id);
			$records['pagedetails'] = $this->db->get("tbl_onlinespecial_header")->result();
			
			//echo '<pre>pagedetails'; print_r($records); die;
			
					
			if(isset($_POST['update'])):
				//echo '<pre>'; print_r($_FILES); die;
						unset($records['pagedetails']);
						//echo '<pre>'; print_r($_POST); die;
						$data['description'] = $this->input->post('description'); 
						$data['background_color'] = $this->input->post('background_color'); 
						$data['body_id'] = isset($_POST['body_id']) ? $_POST['body_id'] : '';
						$data['meta_title'] = !empty($_POST['meta_title']) ? $_POST['meta_title'] : '';
						$data['meta_desc'] = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '';
						
						if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/onlinespecial/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('left_photo')){
							$image_data = $this->upload->data();
							$data['left_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/onlinespecial/'.$data['left_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/onlinespecial/thumb/'.$data['left_photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/'.$data['left_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/thumb/'.$data['left_photo']);
						
										
					}
					
					
				//	echo '<pre>'; print_r($data); die;
					$this->query_model->updateData('tbl_onlinespecial_header','id',$id, $data);
					redirect('admin/onlinespecial/header');
				
				endif;
			
		$this->load->view("admin/onlinespecial_header", $records);
		
	}
	
	
	public function text_sections(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		
			$id = 1;
			
			$records['title'] = 'About Us';
			$records['link_type'] = 'onlinespecial';
			$this->db->where("id", $id);
			$records['pagedetails'] = $this->db->get("tbl_onlinespecial_text_sections")->result();
			
			$this->db->order_by('pos asc, id desc');
			$this->db->select(array('id','title','photo_side','published'));
			$records['aboutUsRows'] = $this->query_model->getbyTable('tbl_onlinespecial_rows');
			//echo '<pre>records'; print_r($records); die;
			
			
			$this->db->order_by('id', 'desc');
			$this->db->where("published", 1);
			$this->db->select(array('id','title','name'));
			$records['testimonials'] = $this->query_model->getbyTable("tbltestimonials");
			
			//echo '<pre>records'; print_r($records); die;
					
			if(isset($_POST['update'])):
			//echo '<pre>_POST'; print_r($_POST); die;
				// update query
						unset($records['pagedetails']);
						
						$data['photo_alt_text'] = isset($_POST['photo_alt_text']) ? $_POST['photo_alt_text'] : ''; 
						$data['sub_title'] = isset($_POST['sub_title']) ? $_POST['sub_title'] : ''; 
						$data['description'] = $this->input->post('description'); 
						$data['testimonial_ids'] = (isset($_POST['testimonial_ids']) && !empty($_POST['testimonial_ids'])) ? serialize($_POST['testimonial_ids']) : '';  
						 
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/onlinespecial/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/onlinespecial/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/onlinespecial/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/thumb/'.$data['photo']);
						
										
					}
					
					
				//	echo '<pre>'; print_r($data); die;
					$this->query_model->updateData('tbl_onlinespecial_text_sections','id',$id, $data);
					redirect('admin/onlinespecial/text_sections');
					
				
				
				
				endif;
			
			$this->load->view("admin/onlinespecial_text_sections", $records);
		
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function email_options(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$id = 1;
			
			$records['title'] = 'Email Opt-in Only / Full Form';
			$records['link_type'] = 'about';
			
			$this->db->where("id", $id);
			$records['pagedetails'] = $this->db->get("tbl_onlinespecial_email_options")->result();
			
			
			
			if(isset($_POST['update'])){
				//echo '<pre>_POST'; print_r($_POST); die;
				$data['require_opt_in'] = $_POST['require_opt_in'];
				
				if(isset($_POST['require_opt_in']) && $_POST['require_opt_in'] == 0){
					$data['show_full_form'] = 0;	
				}else{
					$data['show_full_form'] = $_POST['show_full_form'];
				}
				
				$data['text'] = !empty($_POST['text']) ? $_POST['text'] : 'Opt-in to redeem current trial offers and view pricing & details:';
				$data['title'] = !empty($_POST['title']) ? $_POST['title'] : '';
				
				
				
				if(!empty($records['pagedetails'])){
					$this->query_model->updateData('tbl_onlinespecial_email_options','id',$id, $data);
				}else{
					$this->query_model->insertData('tbl_onlinespecial_email_options', $data);
				}
				
				redirect("admin/onlinespecial/email_options");
			}
			
			$this->load->view("admin/onlinespecial_email_options", $records);
			
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function deleteHeaderImage(){
		
		
		if(count($_POST)>0){			
						
			$id = 1;
			$this->db->where("id", $id);
			$query = $this->db->query("update tbl_onlinespecial_header set left_photo='' where id=".$id."");
			
			echo 1;
		}else{
			echo 0;
		}
	
	}
	
	
	
	public function delete_text_section_image(){
		
		
		if(count($_POST)>0){			
						
			$id = 1;
			$query = $this->db->query("update tbl_onlinespecial_text_sections set photo='' where id=".$id."");
			echo 1;
		}else{
				echo 0;
		}
	
	}
	
	
	
	
	public function add_onlinespecial_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				
			$records['title'] = 'Add Onlinespecial Row';
			$records['link_type'] = 'about';
			
			//$records['location_id'] = $this->uri->segment(4);
			
			
			if(isset($_POST['update'])){
				//echo '<pre>'; print_r($_POST); die;
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						//$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						//$data['button_text'] = $this->input->post('button_text');						
						//$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						//$data['location_id'] = $this->input->post('location_id'); 
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/onlinespecial/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/onlinespecial/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/onlinespecial/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/thumb/'.$data['photo']);
											
												
					}
					
				
					
					$this->query_model->insertData('tbl_onlinespecial_rows', $data);
					
						redirect("admin/onlinespecial/text_sections");
				
			}
		
			$this->load->view("admin/add_onlinespecial_row", $records);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
		
	public function edit_onlinespecial_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Edit Onlinespecial Row';
			$records['link_type'] = 'onlinespecial';
			
			
			$this->db->where("id", $this->uri->segment(4));
			$records['pagedetails'] = $this->query_model->getbyTable('tbl_onlinespecial_rows');
			
			
			if(isset($_POST['update'])){
				
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						//$data['button_text'] = $this->input->post('button_text');						
						//$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						//$data['location_id'] = $this->input->post('location_id'); 
						//echo '<pre>data'; print_r($data); die;
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/onlinespecial/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/onlinespecial/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/onlinespecial/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/thumb/'.$data['photo']);
												
					}
					
				
					$this->query_model->updateData('tbl_onlinespecial_rows','id',$this->uri->segment(4), $data);
					
					//$this->query_model->insertData('tbl_aboutus_rows', $data);
					
						redirect("admin/onlinespecial/text_sections");
						
				//echo '<pre>'; print_r($_POST); die;
			}
			
			
			$this->load->view("admin/edit_onlinespecial_row", $records);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
		
	public function deleteOnlinespecialRowImage(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['id'];
			$query = $this->db->query("update tbl_onlinespecial_rows set photo='' where id=".$id."");
			echo 1;
		}else{
				echo 0;
		}
	
	}
	
	
	public function delete_onlinespecial_row(){
		
		$id = $_POST['delete-item-id'];
			$this->db->where("id", $id);
			if($this->db->delete("tbl_onlinespecial_rows"))
			{
				redirect("admin/onlinespecial/text_sections");
			}
			else
			{
				redirect("admin/onlinespecial/text_sections");
			}
	}
	
	
	
	public function sortOnlinespecialRows(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_onlinespecial_rows` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	public function publishOnlinespecialRows(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tbl_onlinespecial_rows", array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	
	public function operateCategory(){
		if(isset($_POST['submit'])){
			
			$data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
			$data['heading'] = isset($_POST['heading']) ? $_POST['heading'] : '';
			
			$slug = (isset($_POST['slug']) && !empty($_POST['slug'])) ? $_POST['slug'] : $data['name'];
			$data['slug'] = slugify($slug);
			
				
			if($_POST['edit_id'] > 0){
				$this->query_model->updateData('tbl_onlinespecial_categories','id',$_POST['edit_id'], $data);
			}else{
				$this->query_model->insertData('tbl_onlinespecial_categories', $data);
			}
		}
		redirect("admin/onlinespecial");
	}
	
	
	public function deleteTrialCategory(){
		
		$id = $_POST['delete-item-id'];
		$this->db->where("id", $id);
		if($this->db->delete("tbl_onlinespecial_categories"))
		{
			
		redirect("admin/onlinespecial");
		}
		else
		{
			
		echo "<script language='javascript'>alert('Unable to delete category');</script>";
		redirect("admin/onlinespecial");
		}
	}
	
	
	public function category_sort(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tbl_onlinespecial_categories` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	
	public function add_category(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = 'Add: Trial Offer Category';
		$this->db->order_by("pos", "ASC");
		$this->db->where('published',1);
		$this->db->select(array('id','name'));
		$data['locations'] = $this->query_model->getbyTable('tblcontact');
		
		
		$this->db->where('id',12);
		$multi_school = $this->query_model->getbyTable("tblconfigcalendar");
		
		$data['multi_school'] = $multi_school[0]->field_value;
		
			
		if(isset($_POST['update'])){
			
			$insertData['name'] = isset($_POST['name']) ? $_POST['name'] : '';
			$insertData['heading'] = isset($_POST['heading']) ? $_POST['heading'] : '';
			$insertData['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
			$insertData['text_or_video'] = isset($_POST['text_or_video']) ? $_POST['text_or_video'] : '';
			$insertData['text'] = isset($_POST['text']) ? $_POST['text'] : '';
			$insertData['video_type'] = isset($_POST['video_type']) ? $_POST['video_type'] : '';
			$insertData['youtube_video'] = isset($_POST['youtube_video']) ? $_POST['youtube_video'] : '';
			$insertData['vimeo_video'] = isset($_POST['vimeo_video']) ? $_POST['vimeo_video'] : '';
			$slug = (isset($_POST['slug']) && !empty($_POST['slug'])) ? $_POST['slug'] : $insertData['name'];
			$insertData['slug'] = slugify($slug);
			
			$insertData['text_2'] = (isset($_POST['text_2']) && !empty($_POST['text_2'])) ? $_POST['text_2'] : $insertData['name'].' Trial Offers';
			
			$insertData['show_icon_rows'] = isset($_POST['show_icon_rows']) ? $_POST['show_icon_rows'] : 0;
			$insertData['icon_1_text'] = isset($_POST['icon_1_text']) ? $_POST['icon_1_text'] : '';
			$insertData['icon_2_text'] = isset($_POST['icon_2_text']) ? $_POST['icon_2_text'] : '';
			$insertData['icon_3_text'] = isset($_POST['icon_3_text']) ? $_POST['icon_3_text'] : '';
			$insertData['hide_from_trial_page'] = isset($_POST['hide_from_trial_page']) ? $_POST['hide_from_trial_page'] : 0;
			$insertData['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
			$insertData['body_id'] = isset($_POST['body_id']) ? $_POST['body_id'] : '';
			$insertData['body_class'] = isset($_POST['body_class']) ? $_POST['body_class'] : '';
			$insertData['location_id'] = isset($_POST['location_id']) ? $_POST['location_id'] : 0;
			
			$insertData['meta_title'] = !empty($_POST['meta_title']) ? $_POST['meta_title'] : '';
			$insertData['meta_desc'] = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '';
			
			if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/onlinespecial/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('left_photo')){
							$image_data = $this->upload->data();
							$insertData['left_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/onlinespecial/'.$insertData['left_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/onlinespecial/thumb/'.$insertData['left_photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/'.$insertData['left_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/thumb/'.$insertData['left_photo']);
										
					}
					
			
			//echo '<pre>insertData'; print_r($_POST); die;
			$this->query_model->insertData('tbl_onlinespecial_categories', $insertData);
			$id = $this->db->insert_id();
			
			if(!empty($id)){
				$this->db->where("cat_id", $id);
				$this->db->delete("tblspecialoffer");
			}
			
			redirect("admin/onlinespecial/view/".$id);
		}
		
		$this->load->view("admin/add_cat_onlinespecial", $data);
		
		
		
		}
	}
	
	
	public function edit_category(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Edit: Trial Offer Category';
			$records['link_type'] = 'onlinespecial';
			$this->db->order_by("pos", "ASC");
			$this->db->where('published',1);
			$this->db->select(array('id','name'));
			$records['locations'] = $this->query_model->getbyTable('tblcontact');
			
			$this->db->where('id',12);
			$multi_school = $this->query_model->getbyTable("tblconfigcalendar");
			$records['multi_school'] = $multi_school[0]->field_value;
		
			//echo '<pre>locations'; print_r($data['locations']); die;
			$this->db->where("id", $this->uri->segment(4));
			$records['pagedetails'] = $this->query_model->getbyTable('tbl_onlinespecial_categories');
			
		//echo '<pre>records'; print_r($records); die;	
		if(isset($_POST['update'])){
			
			$insertData['name'] = isset($_POST['name']) ? $_POST['name'] : '';
			$insertData['heading'] = isset($_POST['heading']) ? $_POST['heading'] : '';
			$insertData['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
			$insertData['text_or_video'] = isset($_POST['text_or_video']) ? $_POST['text_or_video'] : '';
			$insertData['text'] = isset($_POST['text']) ? $_POST['text'] : '';
			$insertData['video_type'] = isset($_POST['video_type']) ? $_POST['video_type'] : '';
			$insertData['youtube_video'] = isset($_POST['youtube_video']) ? $_POST['youtube_video'] : '';
			$insertData['vimeo_video'] = isset($_POST['vimeo_video']) ? $_POST['vimeo_video'] : '';
			$slug = (isset($_POST['slug']) && !empty($_POST['slug'])) ? $_POST['slug'] : $insertData['name'];
			$insertData['slug'] = slugify($slug);
			
			$insertData['text_2'] = (isset($_POST['text_2']) && !empty($_POST['text_2'])) ? $_POST['text_2'] : $insertData['name'].' Trial Offers';
			$insertData['show_icon_rows'] = isset($_POST['show_icon_rows']) ? $_POST['show_icon_rows'] : 0;
			$insertData['icon_1_text'] = isset($_POST['icon_1_text']) ? $_POST['icon_1_text'] : '';
			$insertData['icon_2_text'] = isset($_POST['icon_2_text']) ? $_POST['icon_2_text'] : '';
			$insertData['icon_3_text'] = isset($_POST['icon_3_text']) ? $_POST['icon_3_text'] : '';
			$insertData['hide_from_trial_page'] = isset($_POST['hide_from_trial_page']) ? $_POST['hide_from_trial_page'] : 0;
			$insertData['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
			$insertData['body_id'] = isset($_POST['body_id']) ? $_POST['body_id'] : '';
			$insertData['body_class'] = isset($_POST['body_class']) ? $_POST['body_class'] : '';
			$insertData['location_id'] = isset($_POST['location_id']) ? $_POST['location_id'] : 0;

			$insertData['meta_title'] = !empty($_POST['meta_title']) ? $_POST['meta_title'] : '';
			$insertData['meta_desc'] = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '';
			
			if(isset($_FILES['left_photo']['name']) && !empty($_FILES['left_photo']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/onlinespecial/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('left_photo')){
							$image_data = $this->upload->data();
							$insertData['left_photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/onlinespecial/'.$insertData['left_photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/onlinespecial/thumb/'.$insertData['left_photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/'.$insertData['left_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/onlinespecial/thumb/'.$insertData['left_photo']);
										
					}
			
			//echo '<pre>records'; print_r($insertData); die;	
			$this->query_model->updateData('tbl_onlinespecial_categories','id',$this->uri->segment(4), $insertData);
			
			redirect("admin/onlinespecial/view/".$this->uri->segment(4));
		}
		
		
		$this->load->view("admin/edit_cat_onlinespecial", $records);
		
		}
	}
	
		
	public function deleteCategoryImage(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['id'];
			$query = $this->db->query("update tbl_onlinespecial_categories set left_photo='' where id=".$id."");
			echo 1;
		}else{
				echo 0;
		}
	
	}
	
	
	
	
	public function promo_codes(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		
			$records['title'] = 'Trial Offer Promo Codes';
			$records['link_type'] = 'onlinespecial';
			
			$this->db->order_by("id", 'desc');
			$this->db->select(array('id','title','published','expiry_date'));
			$records['promo_codes'] = $this->query_model->getbyTable('tbl_onlinespecial_promo_codes');
			//echo '<pre>records'; print_r($records); die;
			$this->load->view("admin/onlinespecial_promo_codes", $records);
					
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function add_promocodes(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				
			$records['title'] = 'Add Onlinespecial Row';
			$records['link_type'] = 'about';
			
			$this->db->select(array('id','offer_title'));
			$records['trial_offers'] = $this->query_model->getbyTable('tblspecialoffer');
			
			
			
			if(isset($_POST['update'])){
				//echo '<pre>'; print_r($_POST); die;
						$data['title'] = $this->input->post('title'); 
						$data['discount_amount'] = $this->input->post('discount_amount');
						$data['connect_to_trials'] = isset($_POST['connect_to_trials']) ? $_POST['connect_to_trials'] : 'all_trials';
						$data['discount_type'] = isset($_POST['discount_type']) ? $_POST['discount_type'] : 'amount';
						$data['discount_percent'] = isset($_POST['discount_percent']) ? $_POST['discount_percent'] : '';
						$data['trial_offers'] = isset($_POST['trial_offers']) ? serialize($_POST['trial_offers']) : '';
						$data['expiry_date'] = isset($_POST['expiry_date']) ? $_POST['expiry_date'] : '';
						$data['created'] = date('Y-m-d h:i:s');
							
						
					$this->query_model->insertData('tbl_onlinespecial_promo_codes', $data);
					
						redirect("admin/onlinespecial/promo_codes");
				
			}
		
			$this->load->view("admin/add_promo_code_onlinespecial", $records);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
		
	public function edit_promocodes(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Edit Onlinespecial Row';
			$records['link_type'] = 'onlinespecial';
			
			
			$this->db->where("id", $this->uri->segment(4));
			$records['pagedetails'] = $this->query_model->getbyTable('tbl_onlinespecial_promo_codes');
			
			$this->db->select(array('id','offer_title'));
			$records['trial_offers'] = $this->query_model->getbyTable('tblspecialoffer');
			
			//echo '<prE>records'; print_r($records); die;
			
			
			if(isset($_POST['update'])){
				
					$data['title'] = $this->input->post('title'); 
						$data['discount_amount'] = $this->input->post('discount_amount');
						$data['connect_to_trials'] = isset($_POST['connect_to_trials']) ? $_POST['connect_to_trials'] : 'all_trials';
						$data['discount_type'] = isset($_POST['discount_type']) ? $_POST['discount_type'] : 'amount';
						$data['discount_percent'] = isset($_POST['discount_percent']) ? $_POST['discount_percent'] : '';
						$data['connect_to_trials'] = isset($_POST['connect_to_trials']) ? $_POST['connect_to_trials'] : 'all_trials';
						$data['trial_offers'] = isset($_POST['trial_offers']) ? serialize($_POST['trial_offers']) : '';
						$data['expiry_date'] = isset($_POST['expiry_date']) ? $_POST['expiry_date'] : '';
						
					//echo '<pre>'; print_r($data); die;	
					$this->query_model->updateData('tbl_onlinespecial_promo_codes','id',$this->uri->segment(4), $data);
					
						redirect("admin/onlinespecial/promo_codes");
						
				
			}
		
			$this->load->view("admin/edit_promo_code_onlinespecial", $records);
			
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
	public function publishOnlinespecialPromoCodes(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tbl_onlinespecial_promo_codes", array("published" => $pub)))
		{	
			echo 1;
		}
	}
		
	
	
	public function delete_onlinespecial_promo_code(){
		
		$id = $_POST['delete-item-id'];
			$this->db->where("id", $id);
			if($this->db->delete("tbl_onlinespecial_promo_codes"))
			{
				redirect("admin/onlinespecial/promo_codes");
			}
			else
			{
				redirect("admin/onlinespecial/promo_codes");
			}
	}
	
	
	
	public function duplicate_trial_offer(){
		
		parse_str($_POST['formData'], $searcharray);
		$_POST = $searcharray;
		
		
		$item_id =  (isset($_POST['item_id']) && !empty($_POST['item_id'])) ? $_POST['item_id'] : '';
		$action =  (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
		
		if(isset($action) && $action == "duplicate_record"){
			
			if(isset($item_id) && !empty($item_id) ){
				$details = $this->query_model->getbySpecific('tblspecialoffer','id', $item_id);
				
				if(!empty($details)){
					$programArr  = array();
					unset($details[0]->id);
					
					$offer_title = (isset($_POST['title']) && !empty($_POST['title'])) ? $_POST['title'] : '';
					$offer_title = !empty($offer_title) ? $offer_title : $details[0]->offer_title;
					$programArr['offer_title'] = trim($offer_title);
					$programArr['title'] = trim($offer_title);
					
					foreach($details[0] as $key => $detail){
						if($key == "offer_title"){
							if($detail == $offer_title){
								$programArr[$key] = $offer_title .' Duplicate';
							}
						}elseif($key == "title"){
							if($detail == $offer_title){
								$programArr[$key] = $offer_title .' Duplicate';
							}
						}elseif($key == "display_trial"){
							$programArr[$key] = 0;
						}else{
							$programArr[$key] = $detail;
						}
						
					}
					
					//echo '<pre>programArr'; print_r($programArr); die;
					
					$this->query_model->insertData('tblspecialoffer', $programArr);
					$duplicate_trialoffer_id = $this->db->insert_id();
					
					//$duplicate_program_id = 117;
					
					// saving  code other tables
					$tables = array('tbl_onlinespecial_upsales');
					foreach($tables as $table_name){
						
						$records = $this->query_model->getbySpecific($table_name,'trial_offer_id', $item_id);
						
						if(!empty($records)){
							foreach($records as $record){
								$dataArr = array();
									
								foreach($record as $key => $val){
									if($key == "id"){
										unset($key);
									}elseif($key == "trial_offer_id"){
										$dataArr[$key] = $duplicate_trialoffer_id;
									}else{
										$dataArr[$key] = $val;
									}
								}
								
								$this->query_model->insertData($table_name, $dataArr);
							}
							
						}
					}
					
					
				}
			}
			
			echo 1;
			
			//redirect("admin/onlinespecial/view/".$_POST['cat_id']);
		}
	}
	
	
	public function deleteSpecialOffers(){
		$result = 0;
		
		if(isset($_POST['ajaxType']) && $_POST['ajaxType'] == "deleteSpecialOffers"){
			
			if(isset($_POST['offer_id']) && !empty($_POST['offer_id'])){
				$id = $_POST['offer_id'];
				
				$this->db->where("id", $id);
				if($this->db->delete("tblspecialoffer"))
				{
					$result = 1;
				}
				
			}
		}
		
		echo $result;die;
		
	}
	
}