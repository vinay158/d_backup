<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("setting_model");
		
	}
	
	public function index(){
		
	$data['user_level']=$this->session->userdata['user_level'];
	$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
		$data['title'] = "Site Settings";
		$data['setting'] = $this->query_model->getbyTable("tblsite");	
		
		/*** vinay 18/11 ***/
		$data['multi_location'] = $this->db->query("SELECT * FROM tblconfigcalendar");
		$data['multi_location'] = $data['multi_location']->result();
		//echo '<pre>'; print_r($data['multi_location'][0]); die;
		//$data['multi_location'] = $data['multi_location'][0];
		
		
		$data['student_section'] = $this->db->query("SELECT * FROM tblconfigcalendar where `id` = 8");
		$data['student_section'] = $data['student_section']->result();
		
		$data['override_logos'] = $this->query_model->getbyTable("tbloverride_logos");
		
		
		$this->db->limit(1);
		$this->db->order_by("s_no","DESC");
		$data['override_logos_s_no'] = $this->query_model->getbyTable("tbloverride_logos");
		
		
		$this->db->order_by("country_name","ASC");
		$data['countries'] = $this->query_model->getbyTable("tbl_countries");
		
		/** End **/
		
		if(isset($_POST['update'])) :
		//echo '<pre>'; print_r($_POST); die;
			$_POST['email'] = trim($_POST['email']);
			$this->setting_model->updateSetting();
		endif;
			$this->load->view("admin/setting_index", $data);
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function apikeys(){
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
			
			
			if($this->uri->segment(5) != ''){
				//echo '<pre>vinay'; echo $this->uri->segment(5); die;
				$data['title'] = "Authentication";
				$data['location_id'] = $this->uri->segment(5);
				$data['apiKey'] = $this->query_model->getbySpecific('tblapikey','location_id', $data['location_id']);
				if(!empty($data['apiKey'])){
					$data['apiKey'] = $data['apiKey'][0];
				}else{
					$data['apiKey'] = '';
				}
				//echo '<pre>'; print_r($data['apiKey']); die;
				
				
				if(isset($_POST['update'])){
					if(!empty($data['apiKey'])){
							$post_data['youtube_channel_id'] = $_POST['youtube_channel_id'];
							$post_data['youtube_api_key'] = $_POST['youtube_api_key'];
							$post_data['google_plus_id'] = $_POST['google_plus_id'];
							$post_data['google_plus_api_key'] = $_POST['google_plus_api_key'];
							$post_data['facebook_user_id'] = $_POST['facebook_user_id'];
							$post_data['facebook_access_token'] = $_POST['facebook_access_token'];
							$post_data['twitter_user_name'] = $_POST['twitter_user_name'];
							$post_data['twitter_consumer_key'] = $_POST['twitter_consumer_key'];
							$post_data['twitter_consumer_secret'] = $_POST['twitter_consumer_secret'];
							$post_data['twitter_access_token'] = $_POST['twitter_access_token'];
							$post_data['twitter_access_token_secret'] = $_POST['twitter_access_token_secret'];
							$post_data['facebook_page_id'] = $_POST['facebook_page_id'];
					
							if($this->query_model->updateData('tblapikey', 'location_id',$_POST['location_id'], $post_data)){
							 redirect('admin/setting/apikeys/multilocation/'.$_POST['location_id']);
							}
						}else{
							$post_data['youtube_channel_id'] = $_POST['youtube_channel_id'];
							$post_data['youtube_api_key'] = $_POST['youtube_api_key'];
							$post_data['google_plus_id'] = $_POST['google_plus_id'];
							$post_data['google_plus_api_key'] = $_POST['google_plus_api_key'];
							$post_data['facebook_user_id'] = $_POST['facebook_user_id'];
							$post_data['facebook_access_token'] = $_POST['facebook_access_token'];
							$post_data['twitter_user_name'] = $_POST['twitter_user_name'];
							$post_data['twitter_consumer_key'] = $_POST['twitter_consumer_key'];
							$post_data['twitter_consumer_secret'] = $_POST['twitter_consumer_secret'];
							$post_data['twitter_access_token'] = $_POST['twitter_access_token'];
							$post_data['twitter_access_token_secret'] = $_POST['twitter_access_token_secret'];
							$post_data['facebook_page_id'] = $_POST['facebook_page_id'];
							$post_data['location_id'] = $_POST['location_id'];
							//echo '<pre>'; print_r($post_data); die;
							if($this->query_model->insertData('tblapikey', $post_data)){
							 redirect('admin/setting/apikeys/multilocation/'.$_POST['location_id']);
							}
						}
					
				}
				
				$this->load->view("admin/apikeys", $data);
				
			}
		
	
	}else{
			redirect('admin/login');
		}
	}
	
	
	
	public function instagramapikeys(){
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
			if($this->uri->segment(5) != ''){
				//echo '<pre>vinay'; echo $this->uri->segment(5); die;
				$data['title'] = "Authentication";
				$data['location_id'] = $this->uri->segment(5);
				$data['apiKey'] = $this->query_model->getbySpecific('tblapikey','location_id', $data['location_id']);
				if(!empty($data['apiKey'])){
					$data['apiKey'] = $data['apiKey'][0];
				}else{
					$data['apiKey'] = '';
				}
				//echo '<pre>'; print_r($data['apiKey']); die;
				
				
				if(isset($_POST['update'])){
					if(!empty($data['apiKey'])){
							$post_data['instragram_user_id'] = $_POST['instragram_user_id'];
							$post_data['instragram_access_token'] = $_POST['instragram_access_token'];
					
							if($this->query_model->updateData('tblapikey', 'location_id',$_POST['location_id'], $post_data)){
							 redirect('admin/setting/instagramapikeys/multilocation/'.$_POST['location_id']);
							}
						}else{
							$post_data['instragram_user_id'] = $_POST['instragram_user_id'];
							$post_data['instragram_access_token'] = $_POST['instragram_access_token'];
							$post_data['location_id'] = $_POST['location_id'];
							//echo '<pre>'; print_r($post_data); die;
							if($this->query_model->insertData('tblapikey', $post_data)){
							 redirect('admin/setting/instagramapikeys/multilocation/'.$_POST['location_id']);
							}
						}
					
				}
				
				$this->load->view("admin/instagramapikeys", $data);
				
			}
		}else{
			redirect('admin/login');
		}
	}
	
	
	public  function full_ckeditor(){
			$data['title'] = "Full Wysiwyg ";
			$this->load->view("admin/full_ckeditor", $data);
	}
	
	public  function mini_ckeditor(){
			$data['title'] = "Minimal Wysiwyg";
			$this->load->view("admin/mini_ckeditor", $data);
	}
	
	
	
	
	public function delete_override_logo(){
		
		if(count($_POST)>0){		
									
			$id = $_POST['id'];
			
			if($this->db->query("delete from tbloverride_logos where id=".$id.""))
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
	

	public function delete_unique_logo_mob(){
		
		if(count($_POST)>0){		
									
			$post_data = array('unique_logo_mob' => '');
			
			if($this->query_model->updateData('tblsite', 'id',1, $post_data))
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
	
	
	
	
	
	public function delete_og_image(){
		
		if(count($_POST)>0){		
									
			$post_data = array('og_image' => '');
			
			if($this->query_model->updateData('tblsite', 'id',1, $post_data))
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
	
	
	public function saveFacebookLoginkey(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
			
			if(isset($_POST['update'])){
				$post_data['facebook_api_id'] = $_POST['facebook_api_id'];
				$post_data['facebook_secret_id'] = $_POST['facebook_secret_id'];
				
				if($this->query_model->update('tblapikey', 1, $post_data)){
				 redirect('admin/adduser/view');
				}
				else
				{	
					echo "<script language='javascript'>alert('Unable to add category');</script>";
					redirect($this->index());
				}
			}
		}else{
			redirect('admin/login');
		}
	
	}
	
	
	public function payments(){
			
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Payments";
			$data['detail'] = $this->query_model->getbySpecific('tbl_payments','id', 1);
			$data['detail'] = $data['detail'][0];
			
			$this->load->view("admin/payment_index", $data);
			
			if(isset($_POST['update'])){
				//echo '<pre>'; print_r($_POST); die;
				if(!empty($data['detail'])){
					$updateData['authorize_net_payment']  = $_POST['authorize_net_payment'];
					$updateData['authorize_loginkey']  = $_POST['authorize_loginkey'];
					$updateData['authorize_transkey']  = $_POST['authorize_transkey'];
					$updateData['braintree_payment']  = $_POST['braintree_payment'];
					$updateData['braintree_merchant_id']  = $_POST['braintree_merchant_id'];
					$updateData['braintree_public_key']  = $_POST['braintree_public_key'];
					$updateData['braintree_private_key']  = $_POST['braintree_private_key'];
					$this->query_model->update('tbl_payments', 1, $updateData);
					
					if($_POST['authorize_net_payment'] == 0 && $_POST['braintree_payment'] == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific('tblspecialoffer','trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData('tblspecialoffer','id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
				}else{
					$insertData['authorize_net_payment']  = $_POST['authorize_net_payment'];
					$insertData['authorize_loginkey']  = $_POST['authorize_loginkey'];
					$insertData['authorize_transkey']  = $_POST['authorize_transkey'];
					$insertData['braintree_payment']  = $_POST['braintree_payment'];
					$insertData['braintree_merchant_id']  = $_POST['braintree_merchant_id'];
					$insertData['braintree_public_key']  = $_POST['braintree_public_key'];
					$insertData['braintree_private_key']  = $_POST['braintree_private_key'];
					//echo 'hello2'; die;
					$this->query_model->insertData('tbl_payments',$insertData);
					
					if($_POST['authorize_net_payment'] == 0 && $_POST['braintree_payment'] == 0){
						//$this->db->where('trial',1);
						$paid_trials =	$this->query_model->getbySpecific('tblspecialoffer','trial', 1);
						//echo '<pre>'; print_r($paid_trials); die;
						if(!empty($paid_trials)){
							
							foreach($paid_trials as $paid_trial){
								$updateTrialData['trial'] = 0;
								$updateTrialData['display_trial'] = 0;
								$this->query_model->updateData('tblspecialoffer','id', $paid_trial->id, $updateTrialData);
							}
						}
						
					} 
					
					
				}
				
				redirect('admin/setting/payments');
			}
		}else{
			redirect('admin/login');
		}
	
	}
	
	
public function savePhoneNumberRequired(){
		
		if(isset($_POST) && isset($_POST['phone_required'])){
			$data['phone_required'] = $_POST['phone_required'];
			if($this->query_model->update('tblsite', 1, $data)){
				return '1';
			}else{
				return '';
			}
		}else{
			return '';
		}
}


public function saveTrialUrlType(){
		
		if(isset($_POST) && isset($_POST['tiral_url_type'])){
			
			$data['tiral_url_type'] = $_POST['tiral_url_type'];
			//$data['third_party_tiral_url_type'] = $_POST['third_party_tiral_url_type'];
			
			if($this->query_model->update('tblsite', 1, $data)){
				return '1';
			}else{
				return '';
			}
		}else{
			return '';
		}
}


	public function saveAnotherTrialUrl(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
			
			if(isset($_POST['update'])){
				$post_data['another_trial_url'] = $_POST['another_trial_url'];
				
				if($this->query_model->update('tblsite', 1, $post_data)){
				 redirect('admin/onlinespecial/view');
				}
				else
				{	
					echo "<script language='javascript'>alert('Unable to add category');</script>";
					redirect($this->index());
				}
			}
		}else{
			redirect('admin/login');
		}
	
	}
	
	
	public function saveAnotherUniqueTrialUrl(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
			
			if(isset($_POST['update'])){
				$post_data['another_trial_url'] = $_POST['another_trial_url'];
				
				if($this->query_model->update('tblsite', 1, $post_data)){
				 redirect('admin/unique_onlinespecial/view');
				}
				else
				{	
					echo "<script language='javascript'>alert('Unable to add category');</script>";
					redirect($this->index());
				}
			}
		}else{
			redirect('admin/login');
		}
	
	}
	
	
	
	public function saveAnotherTrialUrlMulti(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
			
			if(isset($_POST['update'])){
				
				$post_data['tiral_url_type'] = $_POST['tiral_url_type'];
				$post_data['another_trial_url'] = $_POST['another_trial_url'];
				$post_data['third_party_tiral_url_type'] = $_POST['third_party_tiral_url_type'];
				$post_data['third_party_trial_url'] = $_POST['third_party_trial_url'];
				
				if($this->query_model->update('tblsite', 1, $post_data)){
				 redirect('admin/onlinespecial/view');
				}
				else
				{	
					echo "<script language='javascript'>alert('Unable to add category');</script>";
					redirect($this->index());
				}
			}
		}else{
			redirect('admin/login');
		}
	
	}
	
	
	public function save_multi_social_icons(){
		
		if(isset($_POST) && isset($_POST['multi_social_icons'])){
			$data['multi_social_icons'] = $_POST['multi_social_icons'];
			if($this->query_model->update('tblsite', 1, $data)){
				return '1';
			}else{
				return '';
			}
		}else{
			return '';
		}
}

// Develoer1 Code Start	
public function saveHttps(){
		
		if(isset($_POST) && isset($_POST['https'])){
			$data['https'] = $_POST['https'];
			if($this->query_model->update('tblsite', 1, $data)){
				return '1';
			}else{
				return '';
			}
		}else{
			return '';
		}
}

// Develoer1 Code End


public function save_testimonial_background(){
	if(isset($_POST['update'])){
		$image = isset($_FILES['userfile']['name']) ? $_FILES['userfile']['name'] : '';
		
			$a = $error = '';
				
			if(!empty($image)){
				$this->load->model('upload_model');
				$path = "upload/";
				
				if($a = $this->upload_model->upload_image($path))
				{
					
					$data = array(
						'testimonial_background' => $a
					);
					
					if($this->query_model->update('tblsite',1,$data)):
						
					endif;
				}
			}

			}
		redirect("admin/testimonials");
		}
		
		
	
	public function delete_testimonial_background(){
		
		if(count($_POST)>0){		
									
			$post_data = array('testimonial_background' => '');
			
			if($this->query_model->updateData('tblsite', 'id',1, $post_data))
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
	
	
	
	public function static_texts_and_traslations(){
		$data['user_level']=$this->session->userdata['user_level'];
	$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
		$data['title'] = "Static Texts / Translations";
		
		$static_text_translations = $this->query_model->getByTable('static_text_translations');
		$recordArr = array();
		if(!empty($static_text_translations)){
			foreach($static_text_translations as $translation){
				$recordArr[$translation->original_key]['type'] = $translation->type;
				$recordArr[$translation->original_key]['english_text'] = $translation->english_text;
				$recordArr[$translation->original_key]['translate'] = $translation->translate;
				$recordArr[$translation->original_key]['id'] = $translation->id;
				$recordArr[$translation->original_key]['original_key'] = $translation->original_key;
			}
		}
		
		$this->db->limit(1);
		$data['singleRecord'] = $this->query_model->getByTable('static_text_translations');
		
		$data['records'] = $recordArr;
		
		//echo '<pre>data'; print_r($data); die;
		if(isset($_POST['update'])) :
			
			if(isset($_POST['translation']) && !empty($_POST['translation'])){
				$language = (isset($_POST['language']) && !empty($_POST['language'])) ? $_POST['language'] : 'english';
				$other_language_name = (isset($_POST['other_language_name']) && !empty($_POST['other_language_name'])) ? $_POST['other_language_name'] : 'Other Language';
				
				foreach($_POST['translation'] as $key => $translation){
					$postData = array();
					$postData['original_key'] = $key;
					$postData['other_language_name'] = $other_language_name;
					$postData['scroll_top'] = isset($_POST['scroll_top']) ? $_POST['scroll_top'] : 200;
					$postData['type'] = $language;
					$postData['english_text'] = isset($translation['english']) ? $translation['english'] : '';
					$postData['translate'] =  isset($translation['translate']) ? $translation['translate'] : '';
					
					$existsRecord = $this->query_model->getBySpecific('static_text_translations','original_key',$key);
					
					if(!empty($existsRecord)){
						$this->query_model->update('static_text_translations',$existsRecord[0]->id, $postData);
					}else{
						$this->query_model->insertData('static_text_translations',$postData);
					}
					
				}
				
				
			}
			
			redirect('admin/setting/static_texts_and_traslations');
			
		endif;
			$this->load->view("admin/static_texts_and_traslations", $data);
		}else{
			redirect('admin/login');
		}
	}
	
	
	

	public function delete_favicon_icon_img(){
		
		if(count($_POST)>0){		
									
			$post_data = array('favicon_icon_img' => '');
			
			if($this->query_model->updateData('tblsite', 'id',1, $post_data))
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
	
	
	
	
	
}