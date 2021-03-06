<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model{	
	var $table = 'tblsite';	
	function updateSetting(){
	
		
		$this->load->helper(array('url'));
		
		if(isset($_POST['data'])){
			//$this->db->empty_table('tbloverride_logos');
			$i = 2;
			foreach($_POST['data'] as $standPage){
				
				$data['logo_name'] = $standPage['logo_name'];
				$data['logo_alt'] = $standPage['logo_alt'];
				$data['s_no'] = $standPage['s_no'];
				$s_no = $standPage['s_no'];
				if(isset($standPage['last_stand_photo'])){
					$data['logos'] = $standPage['last_stand_photo'];
				}
				$image_name = 'logos'.$i;
				if(isset($_FILES[$image_name]['name']) && !empty($_FILES[$image_name]['name'])){
				$_FILES[$image_name]['name'] = time().$_FILES[$image_name]['name'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/override_logos/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload($image_name)){
					$image_data = $this->upload->data();
					$data['logos'] = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/override_logos/'.$data['logos'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/override_logos/thumb/'.$data['logos'];
				
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
			}
			 
			 $records = $this->query_model->getbySpecific('tbloverride_logos', 's_no', $s_no);
			 if(empty($records)){
				$this->query_model->insertData('tbloverride_logos', $data);
			 } else{
			 	$this->query_model->updateData('tbloverride_logos', 's_no', $s_no , $data);
			 }
				$i++;
			}
			
		}

		/*$this->db->select(array('login_check_fields'));
		$site_setting_detail = $this->query_model->getByTable('tblsite');
		$site_setting_detail = $site_setting_detail[0];*/

		$title = str_replace(array("???"),array("'"),$_POST['title']);
		$phone = isset($_POST['phone'])?$_POST['phone']:'';
		$address = isset($_POST['address'])?$_POST['address']:'';
		$city = isset($_POST['city'])?$_POST['city']:'';
		$zip = isset($_POST['zip'])?$_POST['zip']:'';
		$state = isset($_POST['state'])?$_POST['state']:'';
		$fb = isset($_POST['fb'])?$_POST['fb']:'';
		$google_reviews = (isset($_POST['google_reviews']) && !empty($_POST['google_reviews']))? $_POST['google_reviews']:'';
		$facebook_reviews = (isset($_POST['facebook_reviews']) && !empty($_POST['facebook_reviews']))?$_POST['facebook_reviews'] :'';
		$twitter = $_POST['twitter'];
		$gplus = $_POST['gplus'];
		$youtube = $_POST['youtube'];	
		$email = strtolower($_POST['email']);	
		$image = isset($_FILES['userfile']['name'])?$_FILES['userfile']['name']:'';
		$old_logo = isset($_POST['old-logo'])?$_POST['old-logo']:'';
		$logo_alt = $this->input->post('logo_alt');

		$ss_login_text = $this->input->post('ss_login_text');
		$ss_login_popup_text = $this->input->post('ss_login_popup_text');
	
		/*** vinay 18/11 ***/
		$h1_tag = $_POST['h1_tag'];
		$phone_number_text = isset($_POST['phone_number_text']) ? $_POST['phone_number_text'] : '';
		$top_bar_text = $_POST['top_bar_text'];
		$call_to_action = $_POST['call_to_action'];
		$url_call_to_action = $_POST['url_call_to_action'];
		$window = $_POST['window'];
		$hide_window = isset($_POST['hide_window'])?$_POST['hide_window']:'';
		$instagram = $_POST['instagram'];
		$yelp = $_POST['yelp'];
		$linkedIn = $_POST['linkedIn'];
		$vimeo = $_POST['vimeo'];
		$override_footer_logo = $_POST['override_footer_logo'];
		$override_nav_bar_logo = $_POST['override_nav_bar_logo'];
		$text_address = $_POST['text_address'];
		$home_program_map_zoom = isset($_POST['home_program_map_zoom'])?$_POST['home_program_map_zoom']:'';
		$unique_logo_mob_alt_text = isset($_POST['unique_logo_mob_alt_text'])?$_POST['unique_logo_mob_alt_text']:'';
		$override_logo = 0;
		$map_api_key = isset($_POST['map_api_key'])?$_POST['map_api_key']:'';;
		if(isset($_POST['override_logo'])){
			$override_logo = $_POST['override_logo'];
		}
		
		
		$st_sec_external_link = 0;
		if(isset($_POST['st_sec_external_link']) && $_POST['st_sec_external_link'] == 1){
			$st_sec_external_link = $_POST['st_sec_external_link'];
			$login_check_fields = 0;
		}else{
			$login_check_fields = 1;
		}
		$st_sec_button_text = isset($_POST['st_sec_button_text'])?$_POST['st_sec_button_text']:'';
		$st_sec_button_url = isset($_POST['st_sec_button_url'])?$_POST['st_sec_button_url']:'';
		$tilt_bg_class = isset($_POST['tilt_bg_class'])?$_POST['tilt_bg_class']:'';
		$ss_login_popup_class = isset($_POST['ss_login_popup_class'])?$_POST['ss_login_popup_class']:'';
		$ss_login_btn_position = isset($_POST['ss_login_btn_position'])?$_POST['ss_login_btn_position']:'';
		$ss_login_button_class = isset($_POST['ss_login_button_class'])?$_POST['ss_login_button_class']:'';
		$gdpr_compliant = isset($_POST['gdpr_compliant'])?$_POST['gdpr_compliant']:0;
		$forms_programs_dropdown = isset($_POST['forms_programs_dropdown'])?$_POST['forms_programs_dropdown']:0;
		$download_thread = isset($_POST['download_thread'])?$_POST['download_thread']:0;
		$video_thread = isset($_POST['video_thread'])?$_POST['video_thread']:0;
		$bdy_form_location_dropdown = isset($_POST['bdy_form_location_dropdown'])?$_POST['bdy_form_location_dropdown']:0;
		$site_currency_type = isset($_POST['site_currency_type'])?$_POST['site_currency_type']:'USD';
		$allow_countries = isset($_POST['allow_countries'])?$_POST['allow_countries']:1;
		
		$dojo_crm_url = isset($_POST['dojo_crm_url'])?$_POST['dojo_crm_url']: '';
		$crm_expire_access_token = (isset($_POST['crm_expire_access_token']) && !empty($_POST['crm_expire_access_token']) )?$_POST['crm_expire_access_token']: 48;
		$switch_to_crm = (isset($_POST['switch_to_crm']) && !empty($_POST['switch_to_crm']) )?$_POST['switch_to_crm']: 0;
		
		
		
		if(isset($_POST['ata_database'])){
			
			$ata_database = $_POST['ata_database'];
		} else{
			$ata_database = 0;
		}
               
        $international_phone_fields = 0;
		if(isset($_POST['international_phone_fields'])){
			$international_phone_fields = $_POST['international_phone_fields'];
		}

		$international_phone_masking = (isset($_POST['international_phone_masking']) && !empty($_POST['international_phone_masking']) && $international_phone_fields == 1)?$_POST['international_phone_masking']:0;
		$international_phone_masking_format = isset($_POST['international_phone_masking_format'])?$_POST['international_phone_masking_format']:'';
		
		
		$messenger_icon = isset($_POST['messenger_icon']) ? $_POST['messenger_icon'] : 0;
		//$email_marketing = isset($_POST['email_marketing']) ? $_POST['email_marketing'] : 0;
		$small_large_logo = isset($_POST['small_large_logo']) ? $_POST['small_large_logo'] : '';
		$large_logo_margin_left = isset($_POST['large_logo_margin_left']) ? $_POST['large_logo_margin_left'] : '';
		$horizontal_vertical_menu = isset($_POST['horizontal_vertical_menu']) ? $_POST['horizontal_vertical_menu'] : 'horizontal';
		$link_third_party_url = isset($_POST['link_third_party_url']) ? $_POST['link_third_party_url'] : 0;

		
		//Unique Logo For Mobile Header

			/**if(isset($_FILES['userfile2']['name']) && !empty($_FILES['userfile2']['name'])){
				$path = $_FILES['userfile2']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$_FILES['userfile2']['name'] = time().'_img.'.$ext;
				$image_name = $_FILES['userfile2']['name'];

				//$image_name = $_FILES['userfile2']['name'] = time().$_FILES['userfile2']['name'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/unique_logo/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
				echo $image_name; die;
				if ( $this->upload->do_upload($image_name)){
					$image_data = $this->upload->data();
					$data['unique_logo_mob'] = $image_data['file_name'];
				}
				echo '<pre>data'; print_r($data); die;
				$resize_config['source_image'] = 'upload/unique_logo/'.$data['unique_logo_mob'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/unique_logo/thumb/'.$data['unique_logo_mob'];
				
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				echo '<pre>data'; print_r($data); die;
				 $this->query_model->updateData('tblsite', 'id', 1 , $data);
			} **/
			$this->load->model('upload_model');
			 $_FILES['userfile2']['name'] = time().$_FILES['userfile2']['name'];
			if(!empty($_FILES['userfile2']['name'] ) && strlen($_FILES['userfile2']['name'] )> 10){
				$path = $_FILES['userfile2']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$_FILES['userfile2']['name'] = time().'_img.'.$ext;
				
				$path = "upload/unique_logo/";

				if($a = $this->upload_model->upload_image($path, 'userfile2')){
					
					$b='';
					//image resize process start			
					$filename=basename($a);	
					$umask=umask(0);
					$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
					$dirpath.='/'.$path;			
					chmod($dirpath.$filename ,0777);
					umask($umask);        				
					$this->load->library('image_lib');
					$config=array();			
					$config['image_library'] = 'gd2';
					$config['source_image'] = $dirpath.$filename;						
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['allowed_types'] = 'jpg|gif|png';
					$image_config['new_image'] = $dirpath.$filename;
					$image_config['quality'] = "100%";
					
					
						$imagedetails = getimagesize($_FILES['userfile2']['tmp_name']);

						$width = $imagedetails[0];
						$height = $imagedetails[1];
						

						$ratio = $width/$height;
						
						if($width >= 250){
						 	 $width = 250;
						}
						
						$config['width'] = $width;
						$config['height'] = $height;
						
						$this->load->library('image_lib', $config);			 			
				        $this->image_lib->initialize($config);        
				        
						if (!$this->image_lib->resize())
						{
						    echo  $this->image_lib->display_errors();
						    exit;		    
						}else{			
							$this->image_lib->clear();
							$filename=str_replace('.','_thumb.',$filename);
							//die($filename);
							$b=$path.$filename;
						}
						
					//	echo '<pre>aa==>'; print_r($a); die;
						
						$uniqueLogoImgArr = array('unique_logo_mob'=>$filename);
						
						$this->query_model->updateData('tblsite', 'id', 1 , $uniqueLogoImgArr);
			
			
				
				}
		}
			


			$this->load->model('upload_model');
			 $_FILES['userfile3']['name'] = time().$_FILES['userfile3']['name'];
			if(!empty($_FILES['userfile3']['name'] ) && strlen($_FILES['userfile3']['name'] )> 10){
				$path = $_FILES['userfile3']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$_FILES['userfile2']['name'] = time().'_img.'.$ext;
				
				$path = "upload/unique_logo/";

				if($a = $this->upload_model->upload_image($path, 'userfile3')){
					
					$b='';
					//image resize process start			
					$filename=basename($a);	
					$umask=umask(0);
					$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
					$dirpath.='/'.$path;			
					chmod($dirpath.$filename ,0777);
					umask($umask);        				
					$this->load->library('image_lib');
					$config=array();			
					$config['image_library'] = 'gd2';
					$config['source_image'] = $dirpath.$filename;						
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['allowed_types'] = 'jpg|gif|png';
					$image_config['new_image'] = $dirpath.$filename;
					$image_config['quality'] = "100%";
					
					
						$imagedetails = getimagesize($_FILES['userfile3']['tmp_name']);

						$width = $imagedetails[0];
						$height = $imagedetails[1];
						

						$ratio = $width/$height;
						
						if($width >= 250){
						 	 $width = 250;
						}
						
						$config['width'] = $width;
						$config['height'] = $height;
						
						$this->load->library('image_lib', $config);			 			
				        $this->image_lib->initialize($config);        
				        
						if (!$this->image_lib->resize())
						{
						    echo  $this->image_lib->display_errors();
						    exit;		    
						}else{			
							$this->image_lib->clear();
							$filename=str_replace('.','_thumb.',$filename);
							//die($filename);
							$b=$path.$filename;
						}
						
					//	echo '<pre>aa==>'; print_r($a); die;
						
						$og_imageArr = array('og_image'=>$filename);
						
						$this->query_model->updateData('tblsite', 'id', 1 , $og_imageArr);
			
			
				
				}
		}
			
		$this->load->model('upload_model');
			 $_FILES['favicon_icon_img']['name'] = time().$_FILES['favicon_icon_img']['name'];
			if(!empty($_FILES['favicon_icon_img']['name'] ) && strlen($_FILES['favicon_icon_img']['name'] )> 10){
				$path = $_FILES['favicon_icon_img']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$_FILES['favicon_icon_img']['name'] = time().'_img.'.$ext;
				
				$path = "upload/unique_logo/";
				
				if($a = $this->upload_model->upload_image($path, 'favicon_icon_img')){
					$b='';
					//image resize process start			
					$filename=basename($a);	
					$umask=umask(0);
					$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
					$dirpath.='/'.$path;			
					chmod($dirpath.$filename ,0777);
					umask($umask);        				
					$this->load->library('image_lib');
					$config=array();			
					$config['image_library'] = 'gd2';
					$config['source_image'] = $dirpath.$filename;						
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['allowed_types'] = 'jpg|gif|png|ico';
					$image_config['new_image'] = $dirpath.$filename;
					$image_config['quality'] = "100%";
					
					
						$imagedetails = getimagesize($_FILES['favicon_icon_img']['tmp_name']);

						$width = $imagedetails[0];
						$height = $imagedetails[1];
						

						$ratio = $width/$height;
						
						if($width >= 250){
						 	 $width = 250;
						}
						
						$config['width'] = $width;
						$config['height'] = $height;
						
						$this->load->library('image_lib', $config);			 			
				        $this->image_lib->initialize($config);        
				        
						if (!$this->image_lib->resize())
						{
						    echo  $this->image_lib->display_errors();
						    exit;		    
						}else{			
							$this->image_lib->clear();
							$filename=str_replace('.','_thumb.',$filename);
							//die($filename);
							$b=$path.$filename;
						}
						
					//	echo '<pre>aa==>'; print_r($a); die;
						
						$favicon_icon_imageArr = array('favicon_icon_img'=>$filename);
						$this->query_model->updateData('tblsite', 'id', 1 , $favicon_icon_imageArr);
			
			
				
				}
		}
			

		
		//echo"Check:". $login_check_fields; die;
		
		//echo '--->'.$ata_database; die;
		/*** End Code **/
		
		if(isset($_POST['country_data']) && !empty($_POST['country_data'])){
			$this->db->select(array('id'));
			$countries = $this->query_model->getbyTable("tbl_countries");
			if(!empty($countries)){
				foreach($countries as $country){
					if(in_array($country->id,$_POST['country_data'])){
						$update_country = array('status'=>1);
						$this->query_model->updateData('tbl_countries', 'id', $country->id , $update_country);
					}else{
						$update_country = array('status'=>0);
						$this->query_model->updateData('tbl_countries', 'id', $country->id , $update_country);
					}
				}
			}
		}else{
			$this->db->select(array('id'));
			$countries = $this->query_model->getbyTable("tbl_countries");
			if(!empty($countries)){
				foreach($countries as $country){
					$update_country = array('status'=>0);
					$this->query_model->updateData('tbl_countries', 'id', $country->id , $update_country);
				}
			}
		}
		
		$this->db->select(array('switch_to_crm'));
		$old_switch_to_crm =  $this->query_model->getByTable('tblsite');
		
		
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/";
			if($a = $this->upload_model->upload_image($path)){
			$data = array('title' => $title, 'phone' => $phone, 'address' => $address, 'city' => $city, 'state' => $state, 'zip' => $zip, 'fb' => $fb, 'twitter' => $twitter, 'gplus' => $gplus, 'youtube' => $youtube, 'email' => $email, 'sitelogo' => $a, 'logo_alt' => $logo_alt, 'h1_tag' => $h1_tag, 'phone_number_text' => $phone_number_text, 'top_bar_text' => $top_bar_text, 'call_to_action' => $call_to_action, 'url_call_to_action' => $url_call_to_action, 'window' => $window, 'hide_window' => $hide_window, 'instagram' => $instagram, 'yelp' => $yelp, 'linkedIn' => $linkedIn, 'vimeo' => $vimeo,'override_logo'=>$override_logo,'override_footer_logo'=> $override_footer_logo,'override_nav_bar_logo'=> $override_nav_bar_logo,'ata_database'=>$ata_database,'text_address'=>$text_address,'home_program_map_zoom'=>$home_program_map_zoom,'international_phone_fields'=>$international_phone_fields,'st_sec_external_link'=>$st_sec_external_link,'st_sec_button_text'=>$st_sec_button_text,'st_sec_button_url'=>$st_sec_button_url,'map_api_key'=>$map_api_key,'login_check_fields'=>$login_check_fields,'ss_login_text'=>$ss_login_text, 'ss_login_popup_text'=>$ss_login_popup_text,'google_reviews' =>$google_reviews,'facebook_reviews' => $facebook_reviews,'messenger_icon'=>$messenger_icon,'unique_logo_mob_alt_text'=>$unique_logo_mob_alt_text,'small_large_logo'=>$small_large_logo,'large_logo_margin_left'=>$large_logo_margin_left,'horizontal_vertical_menu'=>$horizontal_vertical_menu,'link_third_party_url' =>$link_third_party_url,'tilt_bg_class'=>$tilt_bg_class,'ss_login_popup_class' => $ss_login_popup_class,'ss_login_btn_position' => $ss_login_btn_position,'ss_login_button_class'=>$ss_login_button_class,'gdpr_compliant' =>$gdpr_compliant,'forms_programs_dropdown'=>$forms_programs_dropdown,'download_thread'=>$download_thread,'video_thread'=>$video_thread,'bdy_form_location_dropdown'=>$bdy_form_location_dropdown,'site_currency_type' => $site_currency_type,'international_phone_masking'=>$international_phone_masking,'international_phone_masking_format'=>$international_phone_masking_format,'allow_countries'=>$allow_countries,'dojo_crm_url'=>$dojo_crm_url,'crm_expire_access_token'=>$crm_expire_access_token,'switch_to_crm'=>$switch_to_crm);
				
			
			/*if(isset($_POST['status']) && $_POST['status']!=''){
				$data = array_merge($data, array('status'=>$_POST['status']));
						
			}*/
			
			if($this->query_model->update("tblsite", 1, $data)):
					
					
				// Code for new database	
				$res_db = mysqli_query($this->db->conn_id,'select * from `tblsite`');
				$result_db = mysqli_fetch_array($res_db);
				
				if($result_db['ata_database'] == 1){
					$this->session->set_userdata('database','db2');
				}elseif($result_db['ata_database'] == 2){
					$this->session->set_userdata('database','db3');
				} else{
					//$this->load->database('default', TRUE);
					$this->session->set_userdata('database','default');
				}
				
				if($old_switch_to_crm[0]->switch_to_crm != $switch_to_crm){
					
					$requestData  = array('switch_to_crm'=>$switch_to_crm, 'curl_action'=> 'update_switch_to_dojo_admin_field','curl_url'=>'web-services/update-switch-to-crm');
					$this->query_model->customCurlRequest($requestData);
				}
				
			
					redirect("admin/setting");
				endif;
			}
			else{
				/*echo '<script>alert("Unable to upload Logo");</script>';*/
				$error = strip_tags($this->upload->display_errors());
				echo '<script>alert("'.$error.'");</script>';
			}
		}else{
			$data = array('title' => $title, 'phone' => $phone, 'address' => $address, 'city' => $city, 'state' => $state, 'zip' => $zip, 'fb' => $fb, 'twitter' => $twitter, 'gplus' => $gplus, 'youtube' => $youtube, 'email' => $email, 'logo_alt' => $logo_alt, 'h1_tag' => $h1_tag, 'phone_number_text' => $phone_number_text, 'top_bar_text' => $top_bar_text, 'call_to_action' => $call_to_action, 'url_call_to_action' => $url_call_to_action, 'window' => $window, 'hide_window' => $hide_window, 'instagram' => $instagram, 'yelp' => $yelp, 'linkedIn' => $linkedIn, 'vimeo' => $vimeo,'override_logo'=>$override_logo,'override_footer_logo'=> $override_footer_logo,'override_nav_bar_logo'=> $override_nav_bar_logo,'ata_database'=>$ata_database,'text_address'=>$text_address,'home_program_map_zoom'=>$home_program_map_zoom,'international_phone_fields'=>$international_phone_fields,'st_sec_external_link'=>$st_sec_external_link,'st_sec_button_text'=>$st_sec_button_text,'st_sec_button_url'=>$st_sec_button_url,'map_api_key'=>$map_api_key,'login_check_fields'=>$login_check_fields,'ss_login_text'=>$ss_login_text, 'ss_login_popup_text'=>$ss_login_popup_text,'google_reviews' =>$google_reviews,'facebook_reviews' => $facebook_reviews,'messenger_icon'=>$messenger_icon,'unique_logo_mob_alt_text'=>$unique_logo_mob_alt_text,'small_large_logo'=>$small_large_logo,'large_logo_margin_left'=>$large_logo_margin_left,'horizontal_vertical_menu'=>$horizontal_vertical_menu,'link_third_party_url' =>$link_third_party_url,'tilt_bg_class'=>$tilt_bg_class,'ss_login_popup_class' => $ss_login_popup_class,'ss_login_btn_position' => $ss_login_btn_position,'ss_login_button_class'=>$ss_login_button_class,'gdpr_compliant' =>$gdpr_compliant,'forms_programs_dropdown'=>$forms_programs_dropdown,'download_thread'=>$download_thread,'video_thread'=>$video_thread,'bdy_form_location_dropdown'=>$bdy_form_location_dropdown,'site_currency_type' => $site_currency_type,'international_phone_masking'=>$international_phone_masking,'international_phone_masking_format'=>$international_phone_masking_format,'allow_countries'=>$allow_countries,'dojo_crm_url'=>$dojo_crm_url,'crm_expire_access_token'=>$crm_expire_access_token,'switch_to_crm'=>$switch_to_crm);
			
	
			/*if(isset($_POST['status']) && $_POST['status']!=''){
				$data = array_merge($data, array('status'=>$_POST['status']));			
			}*/
			
			if($this->query_model->update("tblsite", 1, $data)):
				
				
				// Code for new database
				$res_db = mysqli_query($this->db->conn_id,'select * from `tblsite`');
				$result_db = mysqli_fetch_array($res_db);
				//echo '<pre>'; print_r($result_db); die;
				if($result_db['ata_database'] == 1){
					$this->session->set_userdata('database','db2');
				}elseif($result_db['ata_database'] == 2){
					$this->session->set_userdata('database','db3');
				} else{
					//$this->load->database('default', TRUE);
					$this->session->set_userdata('database','default');
				}
				
			if($old_switch_to_crm[0]->switch_to_crm != $switch_to_crm){
				
				$requestData  = array('switch_to_crm'=>$switch_to_crm, 'curl_action'=> 'update_switch_to_dojo_admin_field','curl_url'=>'web-services/update-switch-to-crm');
				$this->query_model->customCurlRequest($requestData);
			}
				
				redirect("admin/setting");
			endif;
		}
}


function addSlider(){
	
	$slide_template = $_POST['slide_template'];
	if($_POST['show_logo'] != ''){
		$show_logo = $_POST['show_logo'];
	} else{
		$show_logo = 1;
	}
	
	$button1_text = $_POST['button1_text'];
	$button1_link = $_POST['button1_link'];
	$button1_link_target = $_POST['button1_link_target'];
	$button2_text = $_POST['button2_text'];
	$button2_link = $_POST['button2_link'];
	$button2_link_target = $_POST['button2_link_target'];
	$background_color = $_POST['background_color'];
	$image = $_FILES['userfile']['name'];
	$slide_text = $_POST['slide_text'];
	$override_logo = $_POST['override_logo'];
	
	$link_button1 = $_POST['link_button1'];
	$button1_page_link = $_POST['button1_page_link'];
	$link_button2 = $_POST['link_button2'];
	$button2_page_link = $_POST['button2_page_link'];
	
	$buttons = $_POST['buttons'];
	$button1_button_class = $_POST['button1_button_class'];
	$button2_button_class = $_POST['button2_button_class'];
	
	$image_video = $_POST['image_video'];
	$video_type = $_POST['video_type'];
	$youtube_video = $_POST['youtube_video'];
	$vimeo_video = $_POST['vimeo_video'];
	$remote_video = $_POST['remote_video'];
	$video_img_type = $_POST['video_img_type'];
	$background_overlay = isset($_POST['background_overlay']) ? $_POST['background_overlay'] : '';
	$background_overlay_color = isset($_POST['background_overlay_color']) ? $_POST['background_overlay_color'] : '';
	$video_overlay_color = isset($_POST['video_overlay_color']) ? $_POST['video_overlay_color'] : '';
	$local_video_mp4 = isset($_POST['local_video_mp4']) ? $_POST['local_video_mp4'] : '';
	$local_video_webm = isset($_POST['local_video_webm']) ? $_POST['local_video_webm'] : '';
	$video_img_alt_text = isset($_POST['video_img_alt_text']) ? $_POST['video_img_alt_text'] : '';
	$custom_video_thumbnail_alt_text = isset($_POST['custom_video_thumbnail_alt_text']) ? $_POST['custom_video_thumbnail_alt_text'] : '';
	$photo_background_color = isset($_POST['photo_background_color']) ? $_POST['photo_background_color'] : '';
	
	
	$video_id = '';
	$videoimg = '';
	if($video_type == 'youtube_video'){
		$video_url = $_POST['youtube_video'];
		if(!empty($video_url)){
		 preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
		 
		  $video_id = $matches[1];
		  $video_img = "http://i.ytimg.com/vi/".$video_id."/0.jpg";
		}
	 }
	 
	else if($video_type == 'vimeo_video'){
		$viemo_video_url = $_POST['vimeo_video'];
		 preg_match("/(http?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $viemo_video_url, $matches);
		 
		  $video_id = $matches[5];
		  /*$url="http://vimeo.com/api/v2/video/".$video_id.".php";						
				$data=file_get_contents($url);						
				$data=unserialize($data);
				
				$video_img = $data[0]['thumbnail_large']; */
				
				
				
				$img_src=$this->query_model->getViemoVideoImage($video_id);
								
				$video_img = $this->query_model->changeVideoImgPathHttp($img_src);
				
			//$video_img = $this->query_model->getViemoVideoImage($video_id);
		 		
	 }
	 
	 
	 $videoimage = '';
	 if(!empty($video_img)){
	 	
			$videoimg_name = time().'.jpg';
			//copy($video_img, 'upload/slider_video/'.$videoimg_name);
			
			$img = 'upload/slider_video/'.$videoimg_name;
			
			$this->query_model->copyImageFromUrl($video_img,$img);
			
			$videoimage = $videoimg_name;
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/slider_video/'.$videoimg_name);
			
	}
	
	$custom_video_thumbnail_name = '';
	
	$custom_video_thumbnail = time().$_FILES['custom_video_thumbnail']['name'];
	if(!empty($custom_video_thumbnail) && strlen($custom_video_thumbnail) > 10){
				//echo $custom_video_thumbnail.'===>hello2';
				$uploads_dir = 'upload/slider_video/';
		
				$tmp_name = $_FILES['custom_video_thumbnail']["tmp_name"];
				$name = $custom_video_thumbnail;
				move_uploaded_file($tmp_name, "$uploads_dir/$name");
				
				$custom_video_thumbnail_name = 'upload/slider_video/'.$custom_video_thumbnail;
				
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/slider_video/'.$custom_video_thumbnail);
	
	} 
	
	 $video_img = isset($_POST['last-video_img']) ? $_POST['last-video_img'] : '';
	if(isset($_FILES['video_img']['name']) && !empty($_FILES['video_img']['name'])){
				//$video_img = $_POST['video_img'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/slider_video/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('video_img')){
					$image_data = $this->upload->data();
					$video_img = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/slider_video/'.$video_img;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/slider_video/thumb/'.$video_img;
				
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
				$this->query_model->tinyImageCampressAndResize('upload/slider_video/'.
				$video_img);
				
				$this->query_model->tinyImageCampressAndResize('upload/slider_video/thumb/'.$video_img);
	
		
		
			}
			
		
	
	 
	//echo $image; die;
	if(!empty($image)){
		//echo '<pre>FILES'; print_r($_FILES); die;
		
		$this->load->model('upload_model');
		$path = "upload/";
		if($a = $this->upload_model->upload_image($path)){
		
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize($a);
				
		$data = array("slide_template" => $slide_template, "photo" => $a , "show_logo" => $show_logo, "button1_text" => $button1_text, "button1_link" => $button1_link , "button1_link_target" => $button1_link_target , "button2_text" => $button2_text , "button2_link" => $button2_link , "button2_link_target" => $button2_link_target , "background_color" => $background_color, "slide_text" => $slide_text , 'buttons'=> $buttons, 'button1_button_class'=> $button1_button_class, 'button2_button_class'=> $button2_button_class,'override_logo' => $override_logo,'link_button1' => $link_button1,'button1_page_link'=>$button1_page_link,'link_button2'=>$link_button2,'button2_page_link'=>$button2_page_link,'image_video'=>$image_video,'video_type'=>$video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'remote_video'=>$remote_video,'video_id'=>$video_id,'videoimage'=>$videoimage,'video_img_type'=>$video_img_type,'custom_video_thumbnail'=>$custom_video_thumbnail_name,'background_overlay'=>$background_overlay,'background_overlay_color' => $background_overlay_color,'video_overlay_color'=>$video_overlay_color,'video_img'=>$video_img,'local_video_mp4'=>$local_video_mp4,'local_video_webm'=>$local_video_webm,'video_img_alt_text'=>$video_img_alt_text,'custom_video_thumbnail_alt_text'=>$custom_video_thumbnail_alt_text,'photo_background_color'=>$photo_background_color);
		if($this->query_model->insertData("tblslider", $data)):
			redirect("admin/slider");
		endif;
		}else{
	 		$error = strip_tags( $this->upload->display_errors() );
			echo '<script>alert("'.$error.'");</script>';
	  }
	}else{
			$data = array("slide_template" => $slide_template,"show_logo" => $show_logo, "button1_text" => $button1_text, "button1_link" => $button1_link , "button1_link_target" => $button1_link_target , "button2_text" => $button2_text , "button2_link" => $button2_link , "button2_link_target" => $button2_link_target , "background_color" => $background_color, "slide_text" => $slide_text , 'buttons'=> $buttons, 'button1_button_class'=> $button1_button_class, 'button2_button_class'=> $button2_button_class,'override_logo' => $override_logo,'link_button1' => $link_button1,'button1_page_link'=>$button1_page_link,'link_button2'=>$link_button2,'button2_page_link'=>$button2_page_link,'image_video'=>$image_video,'video_type'=>$video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'remote_video'=>$remote_video,'video_id'=>$video_id,'videoimage'=>$videoimage,'video_img_type'=>$video_img_type,'custom_video_thumbnail'=>$custom_video_thumbnail_name,'background_overlay'=>$background_overlay,'background_overlay_color' => $background_overlay_color,'video_overlay_color'=>$video_overlay_color,'video_img'=>$video_img,'local_video_mp4'=>$local_video_mp4,'local_video_webm'=>$local_video_webm,'video_img_alt_text'=>$video_img_alt_text,'custom_video_thumbnail_alt_text'=>$custom_video_thumbnail_alt_text,'photo_background_color'=>$photo_background_color);
		if($this->query_model->insertData("tblslider", $data)):
			redirect("admin/slider");
		endif;
	}
	}

function updateSlider(){
	//echo '<pre>'; print_r($_FILES); die;
	$slide_template = $_POST['slide_template'];
	$show_logo = $_POST['show_logo'];
	$button1_text = $_POST['button1_text'];
	$button1_link = $_POST['button1_link'];
	$button1_link_target = $_POST['button1_link_target'];
	$button2_text = $_POST['button2_text'];
	$button2_link = $_POST['button2_link'];
	$button2_link_target = $_POST['button2_link_target'];
	$background_color = $_POST['background_color'];
	$image = $_FILES['userfile']['name'];
	$slide_text = $_POST['slide_text'];
	$override_logo = $_POST['override_logo'];
	
	$buttons = $_POST['buttons'];
	$button1_button_class = $_POST['button1_button_class'];
	$button2_button_class = $_POST['button2_button_class'];
	
	
	$link_button1 = $_POST['link_button1'];
	$button1_page_link = $_POST['button1_page_link'];
	$link_button2 = $_POST['link_button2'];
	$button2_page_link = $_POST['button2_page_link'];
	
	$image_video = $_POST['image_video'];
	$video_type = $_POST['video_type'];
	$youtube_video = $_POST['youtube_video'];
	$vimeo_video = $_POST['vimeo_video'];
	$remote_video = $_POST['remote_video'];
	
	$video_img_type = $_POST['video_img_type'];
	$background_overlay = isset($_POST['background_overlay']) ? $_POST['background_overlay'] : '';
	$background_overlay_color = isset($_POST['background_overlay_color']) ? $_POST['background_overlay_color'] : '';
	$video_overlay_color = isset($_POST['video_overlay_color']) ? $_POST['video_overlay_color'] : '';
	$local_video_mp4 = isset($_POST['local_video_mp4']) ? $_POST['local_video_mp4'] : '';
	$local_video_webm = isset($_POST['local_video_webm']) ? $_POST['local_video_webm'] : '';
	$video_img_alt_text = isset($_POST['video_img_alt_text']) ? $_POST['video_img_alt_text'] : '';
	$custom_video_thumbnail_alt_text = isset($_POST['custom_video_thumbnail_alt_text']) ? $_POST['custom_video_thumbnail_alt_text'] : '';
	$photo_background_color = isset($_POST['photo_background_color']) ? $_POST['photo_background_color'] : '';
	
	//$_FILES['custom_video_thumbnail']['name'] = time().$_FILES['custom_video_thumbnail']['name'];
	//echo $_FILES['custom_video_thumbnail']['name']; die;
	
	
	
	$video_id = '';
	$videoimg = '';
	if($video_type == 'youtube_video'){
		$video_url = $_POST['youtube_video'];
		if(!empty($video_url)){
		 preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
		 
		  $video_id = $matches[1];
		  
		  $video_img = "http://i.ytimg.com/vi/".$video_id."/0.jpg";
		 // $video_img = $youtube_src;
		}
		 
	 }else if($video_type == 'vimeo_video'){
		$viemo_video_url = $_POST['vimeo_video'];
				 preg_match("/(http?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $viemo_video_url, $matches);
		 
		 		$video_id = $matches[5];
		  		/*$url="http://vimeo.com/api/v2/video/".$video_id.".php";						
				$data=file_get_contents($url);						
				$data=unserialize($data);
				
				$video_img = $data[0]['thumbnail_large']; */
				
				$img_src=$this->query_model->getViemoVideoImage($video_id);
								//getThumbnailImage($feat_box->video_id);
								
								$video_img = $this->query_model->changeVideoImgPathHttp($img_src);
				//$video_img = $this->query_model->getViemoVideoImage($video_id);
		 		
	 } 
	// echo $video_img; die;
	 $videoimage = '';
	 if(!empty($video_img)){
	 	
			$videoimg_name = time().'.jpg';
			//copy($video_img, 'upload/slider_video/'.$videoimg_name);
			
			$img = 'upload/slider_video/'.$videoimg_name;
			$this->query_model->copyImageFromUrl($video_img,$img);
			
			$videoimage = $videoimg_name;
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/slider_video/'.$videoimg_name);
	
			
	}
	
	$custom_video_thumbnail_name = $_POST['old_custom_thumbnail_img'];
	$custom_video_thumbnail = time().$_FILES['custom_video_thumbnail']['name'];
	if(!empty($custom_video_thumbnail) && strlen($custom_video_thumbnail) > 10){
				$uploads_dir = 'upload/slider_video/';
		
				$tmp_name = $_FILES['custom_video_thumbnail']["tmp_name"];
				$name = $custom_video_thumbnail;
				move_uploaded_file($tmp_name, "$uploads_dir/$name");
				
				$custom_video_thumbnail_name = 'upload/slider_video/'.$custom_video_thumbnail;
				
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/slider_video/'.$custom_video_thumbnail);
	
	
	} 
	
	
	$video_img = isset($_POST['last-video_img']) ? $_POST['last-video_img'] : '';
	if(isset($_FILES['video_img']['name']) && !empty($_FILES['video_img']['name'])){
				//$video_img = $_POST['video_img'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/slider_video/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('video_img')){
					$image_data = $this->upload->data();
					$video_img = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/slider_video/'.$video_img;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/slider_video/thumb/'.$video_img;
				
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
				$this->query_model->tinyImageCampressAndResize('upload/slider_video/'.
				$video_img);
				
				$this->query_model->tinyImageCampressAndResize('upload/slider_video/thumb/'.$video_img);
	
		
			}
			
		
	
		
	if(!empty($image)){
		$this->load->model('upload_model');
		$path = "upload/";
		if($a = $this->upload_model->upload_image($path)){
			
			// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize($a);
				
		$data = array("slide_template" => $slide_template, "photo" => $a , "show_logo" => $show_logo, "button1_text" => $button1_text, "button1_link" => $button1_link , "button1_link_target" => $button1_link_target , "button2_text" => $button2_text , "button2_link" => $button2_link , "button2_link_target" => $button2_link_target , "background_color" => $background_color, "slide_text" => $slide_text, 'buttons'=> $buttons, 'button1_button_class'=> $button1_button_class, 'button2_button_class'=> $button2_button_class,'override_logo' => $override_logo,'link_button1' => $link_button1,'button1_page_link'=>$button1_page_link,'link_button2'=>$link_button2,'button2_page_link'=>$button2_page_link,'image_video'=>$image_video,'video_type'=>$video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'remote_video'=>$remote_video,'video_id'=>$video_id,'videoimage'=>$videoimage,'video_img_type'=>$video_img_type,'custom_video_thumbnail'=>$custom_video_thumbnail_name,'background_overlay'=>$background_overlay,'background_overlay_color' => $background_overlay_color,'video_overlay_color'=>$video_overlay_color,'video_img'=>$video_img,'local_video_mp4'=>$local_video_mp4,'local_video_webm'=>$local_video_webm,'video_img_alt_text'=>$video_img_alt_text,'custom_video_thumbnail_alt_text'=>$custom_video_thumbnail_alt_text,'photo_background_color'=>$photo_background_color);
		
		if($this->query_model->update("tblslider", $this->uri->segment(4) , $data)):
			redirect("admin/slider");
		endif;
		}else{
			$error = strip_tags($this->upload->display_errors());
			echo '<script>alert("'.$error.'");</script>';
		}
	}else{
			
	///////////////////////////////////////////////////////
			
			
	/////////////////////////////////////////////////////
			
		$data = array("slide_template" => $slide_template, "show_logo" => $show_logo, "button1_text" => $button1_text, "button1_link" => $button1_link , "button1_link_target" => $button1_link_target , "button2_text" => $button2_text , "button2_link" => $button2_link , "button2_link_target" => $button2_link_target , "background_color" => $background_color, "slide_text" => $slide_text , 'buttons'=> $buttons, 'button1_button_class'=> $button1_button_class, 'button2_button_class'=> $button2_button_class,'override_logo' => $override_logo,'link_button1' => $link_button1,'button1_page_link'=>$button1_page_link,'link_button2'=>$link_button2,'button2_page_link'=>$button2_page_link,'image_video'=>$image_video,'video_type'=>$video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'remote_video'=>$remote_video,'video_id'=>$video_id,'videoimage'=>$videoimage,'video_img_type'=>$video_img_type,'custom_video_thumbnail'=>$custom_video_thumbnail_name,'background_overlay'=>$background_overlay,'background_overlay_color' => $background_overlay_color,'video_overlay_color'=>$video_overlay_color,'video_img'=>$video_img,'local_video_mp4'=>$local_video_mp4,'local_video_webm'=>$local_video_webm,'video_img_alt_text'=>$video_img_alt_text,'custom_video_thumbnail_alt_text'=>$custom_video_thumbnail_alt_text,'photo_background_color'=>$photo_background_color);
		//echo '<pre>'; print_r($data); die;
	//	echo $this->uri->segment(4); die;
		if($this->query_model->update("tblslider", $this->uri->segment(4) , $data)):
				redirect("admin/slider");
			endif;
		}
	}
	
	
	
	function addHeader(){
	$link = $_POST['page'];
	$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
	$image = $_FILES['userfile']['name'];
	if(!empty($image)){
		$this->load->model('upload_model');
		$path = "upload/";
		if($a = $this->upload_model->upload_image($path)){
			$data = array("url" => $link, "photo" => $a);
			if($this->query_model->insertData("tblheader", $data)):
				redirect("admin/header");
			endif;
		}else{
		 	$error = strip_tags($this->upload->display_errors());
			echo '<script>alert("'.$error.'");</script>';
		}
	}
	
	}
	
	function updateHeader(){
	$link = $_POST['page'];
	$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
	$image = $_FILES['userfile']['name'];
	$last = $_POST['last-photo'];
	
	if(!empty($image)){
		$this->load->model('upload_model');
		$path = "upload/";
		if($a = $this->upload_model->upload_image($path)){
			$data = array("url" => $link, "photo" => $a);
			unlink($last);
			if($this->query_model->update("tblheader", $this->uri->segment(4), $data)):
				redirect("admin/header");
			endif;
		}else{
		 	$error = strip_tags($this->upload->display_errors());
			echo '<script>alert("'.$error.'");</script>';
		}
	}else{
	$data = array("url" => $link);
	if($this->query_model->update("tblheader", $this->uri->segment(4), $data)):
				redirect("admin/header");
			endif;
	}
	
	}
	
	function addAds(){
	
	$title = $_POST['title'];
	$url = $_POST['url'];
	$pub = $_POST['published'];
	$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
	$image = $_FILES['userfile']['name'];
	$target = $_POST['target'];
	$image_alt = $_POST['image_alt'];	
	$summary = $_POST['summary'];
	
	$image_video = $_POST['image_video'];
	$video_type = $_POST['video_type'];
	$youtube_video = $_POST['youtube_video'];
	$vimeo_video = $_POST['vimeo_video'];
	
	$video_id = '';
	if($video_type == 'youtube_video'){
		$video_url = $_POST['youtube_video'];
		 preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
		 
		  $video_id = $matches[1];
	 }
	 
	else if($video_type == 'vimeo_video'){
		$viemo_video_url = $_POST['vimeo_video'];
		 preg_match("/(http?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $viemo_video_url, $matches);
		 
		  $video_id = $matches[5];
	 }
	//echo $image_video; die;
	if($image_video == 'image'){
	if(!empty($image) && strlen($image)> 10){
		//$image = time().$_FILES['userfile']['name'];
		$this->load->model('upload_model');
		$path = "upload/featured/";
		if($a = $this->upload_model->upload_image($path)){
			$b='';
			//image resize process start			
			$filename=basename($a);	
			$umask=umask(0);
			$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
			$dirpath.='/'.$path;			
           	chmod($dirpath.$filename ,0777);
            umask($umask);        				
			$this->load->library('image_lib');
			$config=array();			
			$config['image_library'] = 'gd2';
			$config['source_image'] = $dirpath.$filename;						
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$image_config['new_image'] = $dirpath.$filename;
			$image_config['quality'] = "100%";
			
			// vinay 30/11
			$imagedetails = getimagesize($_FILES['userfile']['tmp_name']);
			$width = $imagedetails[0];
			$height = $imagedetails[1];
			
			if($width >= 800 && $height <= 581){
				$config['width'] = $width;
				$config['height'] =581;
			} elseif($height >= 581 && $width <= 800){
				$config['width'] = 800;
				$config['height'] = $height;
			} else{
				$config['height'] =581;
				$config['width'] = 800;
			}
			
			$dim = (intval($width) / intval($height)) - ($config['width'] / $config['height']);
			$image_config['master_dim'] = ($dim > 0)? "height" : "width";
			
			
			
			$config['master_dim'] = 'width';			
			$this->load->library('image_lib', $config);			 			
	        $this->image_lib->initialize($config);        
	        
			if (!$this->image_lib->resize())
			{
			    echo  $this->image_lib->display_errors();
			    exit;		    
			}else{			
				$this->image_lib->clear();
				$filename=str_replace('.','_thumb.',$filename);
				$b=$path.$filename;
			}
			//image resize process end	
			
			//image resize process end	
			//$original_image = base_url().'upload/featured/'.$image;
			$imageType = str_replace('image/','',$imagedetails['mime']);
			
			
			$original_image = $a;
			$img_name = str_replace('upload/featured/','',$a);
			//echo $img_name; die;
			//$photo_thumb = 'upload/featured/thumb/'.$img_name;
			//echo $photo_thumb; die;
			$main_image = 'upload/featured/'.$img_name;
			
			//echo $imageType; die;
			
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/featured/thumb/'.$img_name, 800, 581);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/featured/thumb/'.$img_name, 800, 581);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/featured/thumb/'.$img_name, 800, 581);
			}
			$photo_thumb = 'upload/featured/thumb/'.$img_name;	
			
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/featured/'.$img_name);
			
			$this->query_model->tinyImageCampressAndResize('upload/featured/thumb/'.$img_name);
			
			
		}
	}
			
			$data = array("title" => $title, "url" => $url, "photo" => $a, "photo_thumb" => $photo_thumb, "published" => $pub, "target" => $target, "image_alt" => $image_alt, 'summary' => $summary,'image_video' => $image_video, 'video_type'=> $video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'video_id'=>$video_id);	
		} else{
			$data = array("title" => $title, "url" => $url, "published" => $pub, "target" => $target, "image_alt" => $image_alt, 'summary' => $summary,'image_video' => $image_video, 'video_type'=> $video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'video_id'=>$video_id);	
		}		
			if($this->query_model->insertData("tblads", $data)):
				redirect("admin/ads");
			endif;
	
	}	
	
	function updateAds(){
	//echo '<pre>'; print_r($_POST); die;
	$title = $_POST['title'];
	$url = $_POST['url'];
	$pub = $_POST['published'];
	
	$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
	$image =$_FILES['userfile']['name'];
	$target = $_POST['target'];
	$image_alt = $_POST['image_alt'];
	
	$summary = $_POST['summary'];
	
	
	$image_video = $_POST['image_video'];
	$video_type = $_POST['video_type'];
	$youtube_video = $_POST['youtube_video'];
	$vimeo_video = $_POST['vimeo_video'];
	
	$video_id = '';
	if($video_type == 'youtube_video'){
		$video_url = $_POST['youtube_video'];
		 preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
		 
		  $video_id = $matches[1];
	 }
	 
	else if($video_type == 'vimeo_video'){
		$viemo_video_url = $_POST['vimeo_video'];
		 preg_match("/(http?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $viemo_video_url, $matches);
		 
		  $video_id = $matches[5];
	 }
	 
	

	if(!empty($image) && strlen($image)> 10){
		$this->load->model('upload_model');
		$path = "upload/featured/";
		if($a = $this->upload_model->upload_image($path)){
			$b='';
			//image resize process start			
			$filename=basename($a);	
			$umask=umask(0);
			$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
			$dirpath.='/'.$path;			
           	chmod($dirpath.$filename ,0777);
            umask($umask);        				
			$this->load->library('image_lib');
			$config=array();			
			$config['image_library'] = 'gd2';
			$config['source_image'] = $dirpath.$filename;						
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$image_config['new_image'] = $dirpath.$filename;
			$image_config['quality'] = "100%";
			$config['allowed_types'] = 'jpg|gif|png';
			// vinay 30/11
			$imagedetails = getimagesize($_FILES['userfile']['tmp_name']);
			$width = $imagedetails[0];
			$height = $imagedetails[1];
			
			if($width >= 800 && $height <= 581){
				$config['width'] = $width;
				$config['height'] =581;
			} elseif($height >= 581 && $width <= 800){
				$config['width'] = 800;
				$config['height'] = $height;
			} else{
				$config['height'] =581;
				$config['width'] = 800;
			}
			
			$dim = (intval($width) / intval($height)) - ($config['width'] / $config['height']);
			$image_config['master_dim'] = ($dim > 0)? "height" : "width";
			
			
			
			$config['master_dim'] = 'width';	
//echo '<pre>config'; print_r($config); die;			
			$this->load->library('image_lib', $config);			 			
	        $this->image_lib->initialize($config);        
	       
			if (!$this->image_lib->resize())
			{
			   echo $this->image_lib->display_errors();
			    exit;		    
			}else{			
				$this->image_lib->clear();
				$filename=str_replace('.','_thumb.',$filename);
				$b=$path.$filename;
			}
			//image resize process end	
			//$original_image = base_url().'upload/featured/'.$image;
			$imageType = str_replace('image/','',$imagedetails['mime']);
			
			
			$original_image = $a;
			$img_name = str_replace('upload/featured/','',$a);
			//echo $img_name; die;
			//$photo_thumb = 'upload/featured/thumb/'.$img_name;
			//echo $photo_thumb; die;
			$main_image = 'upload/featured/'.$img_name;
			
			//echo $imageType; die;
			
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/featured/thumb/'.$img_name, 800, 581);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/featured/thumb/'.$img_name, 800, 581);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/featured/thumb/'.$img_name, 800, 581);
			}
			$photo_thumb = 'upload/featured/thumb/'.$img_name;	
			
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/featured/'.$img_name);
			
			$this->query_model->tinyImageCampressAndResize('upload/featured/thumb/'.$img_name);
			
			
			
			$data = array("title" => $title, "url" => $url, "photo" => $a,"photo_thumb" => $photo_thumb, "published" => $pub, "target" => $target, "image_alt" => $image_alt, 'summary' => $summary,'image_video' => $image_video, 'video_type'=> $video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'video_id'=>$video_id);
			if($this->query_model->update("tblads", $this->uri->segment(4), $data)):
				redirect("admin/ads");
			endif;
		}else{
		 	$data = array("title" => $title, "url" => $url, "published" => $pub, "target" => $target, "image_alt" => $image_alt, 'summary' => $summary,'image_video' => $image_video, 'video_type'=> $video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'video_id'=>$video_id);
			if($this->query_model->update("tblads", $this->uri->segment(4), $data)):
				redirect("admin/ads");
			endif;
		}
	}else{
			$data = array("title" => $title, "url" => $url, "published" => $pub, "target" => $target, "image_alt" => $image_alt, 'summary' => $summary,'image_video' => $image_video, 'video_type'=> $video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'video_id'=>$video_id);
			if($this->query_model->update("tblads", $this->uri->segment(4), $data)):
				redirect("admin/ads");
			endif;
	}
	
	}
	
function addTheme(){	
	
	$theme_name = $_POST['theme_name'];
	$theme_path = $_POST['theme_path'];
	
	if(!empty($theme_name)){
		
		$data = array("name" => $theme_name,"published"=> 1 ,"path"=>$theme_path );
		if($this->query_model->insertData("tbltheme", $data)):
			redirect("admin/theme");		
		else:
			echo '<script>alert("Unable to upload Logo");</script>';		
		endif;	
	}
}



	
}