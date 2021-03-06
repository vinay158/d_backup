<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model{
	
	var $table = 'tblcontact';
	
	function getAll(){
		return $this->query_model->getbyTable($this->table);
	}
	
	function addContact(){
		//echo '<pre>POST'; print_r($_POST); die;
		$name = $_POST['name'];
		
		if(preg_match('/\s/',$name)){
			$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "", $_POST['name']);
			$slug = str_replace(' ', '-',strtolower($replce_slug));
			$slug = str_replace('--', '-',strtolower($slug));
		}else{
			$slug = strtolower($_POST['name']);
		}	
		
		$address = $_POST['address'];
		$suite=$_POST['suite'];	
		//echo $suite_new;exit;
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$seo_text = $_POST['seo_text'];
		//$fax = $_POST['fax'];
		
		// Vinay
		if(!isset($_POST['email'])){
			$mainContact = $this->query_model->getbyId('tblsite',1);
			$_POST['email'] = $mainContact[0]->email;
		}
		
		
		$email = $_POST['email'];
		$pub = $_POST['published'];
		$content = $_POST['content'];
		
		$metaVaribles = $this->query_model->getbyTable("tblmetavariable");
		$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : 'Contact '.$metaVaribles[0]->meta_school_name.' | '.$_POST['city'].', '.$_POST['state'].' | '.$name;
		
		//$meta_title = $_POST['meta_title'];
		$meta_desc = $_POST['meta_desc'];
		//$featured = $_POST['featured'];
		$map_zoom_level = $_POST['map_zoom_level'];
		
		$type = isset($_POST['type'])?$_POST['type']:'';
		$s_id = isset($_POST['s_id'])?$_POST['s_id']:'';
		$api_key = isset($_POST['api_key'])?$_POST['api_key']:'';
		
		$perfectmind_access_key = isset($_POST['perfectmind_access_key'])?$_POST['perfectmind_access_key']:'';
		$perfectmind_client_number = isset($_POST['perfectmind_client_number'])?$_POST['perfectmind_client_number']:'';

		$ks_url = isset($_POST['ks_url'])?$_POST['ks_url']:'';
		$ks_token = isset($_POST['ks_token'])?$_POST['ks_token']:'';
		
		$fb = $_POST['fb'];
		$twitter = $_POST['twitter'];
		$instagram = $_POST['instagram'];
		$gplus =  (isset($_POST['gplus']) && !empty($_POST['gplus']))? $_POST['gplus']:'';
		$youtube = $_POST['youtube'];
		$vimeo = $_POST['vimeo'];
		$yelp = $_POST['yelp'];
		$linkedIn = $_POST['linkedIn'];
		
		
		$location_type = isset($_POST['location_type'])?$_POST['location_type']:'';;
		if($location_type == 'external_link'){
			$name = $_POST['external_name'];
			$email = $_POST['external_email'];
		}
		$external_url = isset($_POST['external_url'])?$_POST['external_url']:'';
		
		
		
		
		
		/*$mon_to_fri = $_POST['mon_to_fri'];
		$saturday = $_POST['saturday'];
		$sunday = $_POST['sunday'];*/
		$single_map_zoom_level = $_POST['single_map_zoom_level']; 
		$text_address = isset($_POST['text_address']) ? $_POST['text_address'] : '';
		
		/*$current_city = $_POST['current_city'];
		$current_location = $_POST['current_location'];*/
		$google_reviews = (isset($_POST['google_reviews']) && !empty($_POST['google_reviews']))? $_POST['google_reviews']:'';
		$facebook_reviews = (isset($_POST['facebook_reviews']) && !empty($_POST['facebook_reviews']))?$_POST['facebook_reviews'] :'';
		$body_id = isset($_POST['body_id']) ? $_POST['body_id'] :'';
		
		$contact_location_type = isset($_POST['contact_location_type']) ? $_POST['contact_location_type'] : 'US';
		if($contact_location_type == "International"){
			$state = (isset($_POST['state_text']) && isset($_POST['state_text'])) ? $_POST['state_text'] : $city;
		}
		
		
		$AddressForLatitude = $address.' '.$city.' ' .$state.' '.$zip; // Google HQ
		$latitude = '';
		$longitude ='';
		
      	/*$url =file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($AddressForLatitude).'&key=AIzaSyAvsN6lxKatuxrNPlOguoReJkwgFX6DjKA');
		$output= json_decode($url);*/
		
		$output = $this->getLatLongByAddress($AddressForLatitude);
		if(!empty($output) && isset($output->results[0])){
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;
		}
		//echo $latitude.'===>'.$longitude; die;
		$large_map_url = isset($_POST['large_map_url'])?$_POST['large_map_url']:'';
		$password = isset($_POST['password'])? md5($_POST['password']):'';
		$p_number = isset($_POST['password'])? $_POST['password']:'';
		$stripe_secret_key = isset($_POST['stripe_secret_key'])? $_POST['stripe_secret_key'] : '';
		$stripe_publishable_key = isset($_POST['stripe_publishable_key'])? $_POST['stripe_publishable_key'] : '';
		$ms_url = isset($_POST['ms_url'])? $_POST['ms_url'] : '';
		$twilio_cell_number = isset($_POST['twilio_cell_number'])? $_POST['twilio_cell_number'] : '';
		$school_location_type = (isset($_POST['school_location_type']) && !empty($_POST['school_location_type']))?$_POST['school_location_type']:'default';
		$turn_on_nested_location = (isset($_POST['turn_on_nested_location']) && !empty($_POST['turn_on_nested_location']))?$_POST['turn_on_nested_location']: 0;
		$parent_id = (isset($_POST['parent_id']) && !empty($_POST['parent_id']))?$_POST['parent_id']: 0;
	
		$photo = '';
		$image = isset($_FILES['userfile']['name']) ? $_FILES['userfile']['name'] : '';
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/contacts/";
			$photo = $this->upload_model->upload_image($path);
		}
		
		$data = array("name" => $name, "slug" => $slug, "address" => $address,"suite"=>$suite, "city" => $city, "state" => $state, "zip" => $zip, "phone" => $phone, "email" => $email,"content" => $content,"published" => $pub, "meta_desc" => $meta_desc, "meta_title" => $meta_title,'latitude' => $latitude,'longitude'=>$longitude,'map_zoom_level'=>$map_zoom_level, 'single_map_zoom_level'=>$single_map_zoom_level,'seo_text'=>$seo_text,'text_address'=>$text_address,'type'=>$type,'s_id'=>$s_id,'api_key'=>$api_key,'ks_url'=>$ks_url,'ks_token'=>$ks_token,'fb'=>$fb,'twitter'=>$twitter,'instagram'=>$instagram,'gplus'=>$gplus,'youtube'=>$youtube,'vimeo'=>$vimeo,'yelp'=>$yelp,'linkedIn'=>$linkedIn,'external_url'=>$external_url,'location_type'=>$location_type,'google_reviews' =>$google_reviews,'facebook_reviews' => $facebook_reviews,'body_id' => $body_id,'photo' => $photo, 'large_map_url' => $large_map_url,'password'=>$password, 'p_number'=>$p_number,'contact_location_type'=>$contact_location_type,'perfectmind_access_key'=>$perfectmind_access_key,'perfectmind_client_number'=>$perfectmind_client_number,'stripe_secret_key'=>$stripe_secret_key,'stripe_publishable_key'=>$stripe_publishable_key,'ms_url'=>$ms_url,'twilio_cell_number'=>$twilio_cell_number,'school_location_type'=>$school_location_type,'turn_on_nested_location'=>$turn_on_nested_location,'parent_id'=>$parent_id);
		
		$this->query_model->insertData($this->table, $data);
		$contact_id = $this->db->insert_id();
		
		
			if(isset($_POST['ContactTime'])){
				foreach($_POST['ContactTime'] as $key => $contactTime){
				
				$this->db->order_by("id","desc");
				
				/*$time_data['week_day'] = (isset($contactTime[0]) && !empty($contactTime[0])) ? $contactTime[0] : ucfirst($key);
				$time_data['start_hour'] = isset($contactTime[1]) ? $contactTime[1] : '';
				$time_data['start_min'] =isset($contactTime[2]) ? $contactTime[2] : '';
				$time_data['start_am_pm'] = isset($contactTime[3]) ? $contactTime[3] : '';
				$time_data['end_hour'] = isset($contactTime[4]) ? $contactTime[4] : '';
				$time_data['end_min'] = isset($contactTime[5]) ? $contactTime[5] : '';
				$time_data['end_am_pm'] = isset($contactTime[6]) ? $contactTime[6] : '';
				$time_data['closed'] = isset($contactTime[7]) ? $contactTime[7] : '';*/
				
				$time_data['week_day'] = ucfirst($key);
				$time_data['start_hour'] = isset($contactTime['start_hour']) ? $contactTime['start_hour'] : '';
				$time_data['start_min'] =isset($contactTime['start_min']) ? $contactTime['start_min'] : '';
				$time_data['start_am_pm'] = isset($contactTime['start_am_pm']) ? $contactTime['start_am_pm'] : '';
				$time_data['end_hour'] = isset($contactTime['end_hour']) ? $contactTime['end_hour'] : '';
				$time_data['end_min'] = isset($contactTime['end_min']) ? $contactTime['end_min'] : '';
				$time_data['end_am_pm'] = isset($contactTime['end_am_pm']) ? $contactTime['end_am_pm'] : '';
				$time_data['closed'] = isset($contactTime['closed']) ? $contactTime['closed'] : 0;
				
				$time_data['location_id'] = $contact_id;
				
				if(isset($contactTime['custom_text_checkbox']) && !empty($contactTime['custom_text_checkbox'])){
						//echo '111<br>';
						$time_data['custom_text_checkbox'] = $contactTime['custom_text_checkbox'];
					}else{
						//echo '222<br>';
						$time_data['custom_text_checkbox'] = 0;
					}
					
					if(isset($contactTime['custom_text'])){
						$time_data['custom_text'] = $contactTime['custom_text'];
					} else{
						$time_data['custom_text'] = '';
					}
					
					
					
				$this->query_model->insertData('tblcontact_time', $time_data);
				}
			}
			
		return $contact_id;
	
	}	
	
	
	function editContact(){
		//echo '<pre>'; print_r($_POST); die;
		$name = $_POST['name'];
		if(preg_match('/\s/',$name)){
			$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "", $_POST['name']);
			$slug = str_replace(' ', '-',strtolower($replce_slug));
			$slug = str_replace('--', '-',strtolower($slug));
		}else{
			$slug = strtolower($_POST['name']);
		}	
		
		
		$address = $_POST['address'];
		$suite=$_POST['suite'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$seo_text = $_POST['seo_text'];
		//$fax = $_POST['fax'];
		if(!isset($_POST['email'])){
			$mainContact = $this->query_model->getbyId('tblsite',1);
			$_POST['email'] = $mainContact[0]->email;
		}
		$email = $_POST['email'];
		$pub = $_POST['published'];
		$content = $_POST['content'];
		
		$metaVaribles = $this->query_model->getbyTable("tblmetavariable");
		$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : 'Contact '.$metaVaribles[0]->meta_school_name.' | '.$_POST['city'].', '.$_POST['state'].' | '.$name;
		//$meta_title = $_POST['meta_title'];
		$meta_desc = $_POST['meta_desc'];
		//$featured = $_POST['featured'];
		$map_zoom_level = $_POST['map_zoom_level'];
		$text_address = isset($_POST['text_address']) ? $_POST['text_address'] : '';
		
		$type = isset($_POST['type'])?$_POST['type']:'';
		$s_id = isset($_POST['s_id'])?$_POST['s_id']:'';
		$api_key = isset($_POST['api_key'])?$_POST['api_key']:'';
		
		$perfectmind_access_key = isset($_POST['perfectmind_access_key'])?$_POST['perfectmind_access_key']:'';
		$perfectmind_client_number = isset($_POST['perfectmind_client_number'])?$_POST['perfectmind_client_number']:'';

		$ks_url = isset($_POST['ks_url'])?$_POST['ks_url']:'';
		$ks_token = isset($_POST['ks_token'])?$_POST['ks_token']:'';
		$twilio_cell_number = isset($_POST['twilio_cell_number'])?$_POST['twilio_cell_number']:'';
		$school_location_type = (isset($_POST['school_location_type']) && !empty($_POST['school_location_type']))?$_POST['school_location_type']:'default';
		$turn_on_nested_location = (isset($_POST['turn_on_nested_location']) && !empty($_POST['turn_on_nested_location']))?$_POST['turn_on_nested_location']: 0;
		
		$map_categories  = isset($_POST['mat_cats'])?serialize($_POST['mat_cats']):'';
		$default_cat_id  = (isset($_POST['default_cat_id']) && !empty($_POST['default_cat_id']))?$_POST['default_cat_id']:0;
		
		$parent_id = (isset($_POST['parent_id']) && !empty($_POST['parent_id']))?$_POST['parent_id']: 0;
		
		$fb = $_POST['fb'];
		$twitter = $_POST['twitter'];
		$instagram = $_POST['instagram'];
		$gplus =  (isset($_POST['gplus']) && !empty($_POST['gplus']))? $_POST['gplus']:'';
		$youtube = $_POST['youtube'];
		$vimeo = $_POST['vimeo'];
		$yelp = $_POST['yelp'];
		$linkedIn = $_POST['linkedIn'];
		
		$location_type = isset($_POST['location_type'])?$_POST['location_type']:'';;
		if($location_type == 'external_link'){
			$name = $_POST['external_name'];
			$email = $_POST['external_email'];
		}
		$external_url = isset($_POST['external_url'])?$_POST['external_url']:'';
		
		/*$current_city = $_POST['current_city'];
		$current_location = $_POST['current_location'];*/
		//echo $text_address; die;
		$single_map_zoom_level = '';
		if(isset($_POST['single_map_zoom_level'])){ 
			$single_map_zoom_level = $_POST['single_map_zoom_level']; 
		}
		
		$google_reviews = (isset($_POST['google_reviews']) && !empty($_POST['google_reviews']))? $_POST['google_reviews']:'';
		$facebook_reviews = (isset($_POST['facebook_reviews']) && !empty($_POST['facebook_reviews']))?$_POST['facebook_reviews'] :'';
		$body_id = isset($_POST['body_id']) ? $_POST['body_id'] :'';
		
		
		$contact_location_type = isset($_POST['contact_location_type']) ? $_POST['contact_location_type'] : 'US';
		if($contact_location_type == "International"){
			$state = (isset($_POST['state_text']) && isset($_POST['state_text'])) ? $_POST['state_text'] : $city;
		}
		
		/*$mon_to_fri = $_POST['mon_to_fri'];
		$saturday = $_POST['saturday'];
		$sunday = $_POST['sunday'];*/
		
		$contactDetail = $this->query_model->getById('tblcontact',$this->uri->segment(4));
		if($contactDetail[0]->address == $address && $contactDetail[0]->city == $city && $contactDetail[0]->state == $state && $contactDetail[0]->zip == $zip){
			if(!empty($contactDetail[0]->latitude) && !empty($contactDetail[0]->longitude)){
				$latitude = $contactDetail[0]->latitude;
				$longitude =$contactDetail[0]->longitude;
			}else{
				$latitude = '';
				$longitude ='';
				$AddressForLatitude = $address.' '.$city.' ' .$state.' '.$zip; // Google HQ
				/*$url =file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($AddressForLatitude).'&key=AIzaSyAvsN6lxKatuxrNPlOguoReJkwgFX6DjKA');
				$output= json_decode($url);*/
				
				$output = $this->getLatLongByAddress($AddressForLatitude);
				if(!empty($output) && isset($output->results[0])){
					$latitude = $output->results[0]->geometry->location->lat;
					$longitude = $output->results[0]->geometry->location->lng;
				}
			}
		}else {
			$latitude = '';
			$longitude ='';
			$AddressForLatitude = $address.' '.$city.' ' .$state.' '.$zip; // Google HQ
			
			/*$url =file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($AddressForLatitude).'&key=AIzaSyAvsN6lxKatuxrNPlOguoReJkwgFX6DjKA');
			$output= json_decode($url);*/
			
			$output = $this->getLatLongByAddress($AddressForLatitude);
			if(!empty($output) && isset($output->results[0])){
				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;
			}
		
		}
		
		//echo 'latitude23=>'.$latitude.'<br/>';
		//echo 'longitude=>'.$longitude.'<br/>'; die;
		
		$large_map_url = isset($_POST['large_map_url'])?$_POST['large_map_url']:'';
		$password = isset($_POST['password'])? md5($_POST['password']):'';
		$p_number = isset($_POST['password'])?$_POST['password']:'';
		$stripe_secret_key = isset($_POST['stripe_secret_key'])? $_POST['stripe_secret_key'] : '';
		$stripe_publishable_key = isset($_POST['stripe_publishable_key'])? $_POST['stripe_publishable_key'] : '';
		$ms_url = isset($_POST['ms_url'])? $_POST['ms_url'] : '';
	
		$photo = isset($_POST['last-photo']) ? $_POST['last-photo'] : '';
		$image = isset($_FILES['userfile']['name']) ? $_FILES['userfile']['name'] : '';
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/contacts/";
			$photo = $this->upload_model->upload_image($path);
		}
		
		
		//echo '<pre>'; print_r($_POST); die;
		
		$data = array("name" => $name,"slug" => $slug, "address" => $address,"suite"=>$suite, "city" => $city, "state" => $state, "zip" => $zip, "phone" => $phone, "email" => $email,"content" => $content, "published" => $pub, "meta_desc" => $meta_desc, "meta_title" => $meta_title,'latitude' => $latitude,'longitude'=>$longitude,'map_zoom_level'=>$map_zoom_level,'single_map_zoom_level'=>$single_map_zoom_level,'seo_text'=>$seo_text,'text_address'=>$text_address,'type'=>$type,'s_id'=>$s_id,'api_key'=>$api_key,'ks_url'=>$ks_url,'ks_token'=>$ks_token,'fb'=>$fb,'twitter'=>$twitter,'instagram'=>$instagram,'gplus'=>$gplus,'youtube'=>$youtube,'vimeo'=>$vimeo,'yelp'=>$yelp,'linkedIn'=>$linkedIn,'external_url'=>$external_url,'location_type'=>$location_type,'google_reviews' =>$google_reviews,'facebook_reviews' => $facebook_reviews,'body_id' => $body_id,'photo' => $photo, 'large_map_url' => $large_map_url,'password'=>$password, 'p_number'=>$p_number,'contact_location_type'=>$contact_location_type,'perfectmind_access_key'=>$perfectmind_access_key,'perfectmind_client_number'=>$perfectmind_client_number,'stripe_secret_key'=>$stripe_secret_key,'stripe_publishable_key'=>$stripe_publishable_key,'ms_url'=>$ms_url,'twilio_cell_number'=>$twilio_cell_number,'school_location_type'=>$school_location_type,'turn_on_nested_location'=>$turn_on_nested_location,'parent_id'=>$parent_id,'map_categories'=>$map_categories,'default_cat_id'=>$default_cat_id);
		
		if($this->query_model->update($this->table,$this->uri->segment(4), $data)):
			
			if($turn_on_nested_location == 0){
				
					$this->db->select(array('id'));
					$this->db->order_by("pos", "ASC");
					$this->db->where("school_location_type", 'nested');
					$this->db->where("parent_id", $this->uri->segment(4));
					$childLocations = $this->contact_model->getAll();
					if(!empty($childLocations)){
						
						foreach($childLocations as $child_location){
							
							$updateField['school_location_type'] = 'default'; 
							$updateField['turn_on_nested_location'] = 0; 
							$updateField['parent_id'] = 0; 
							
							$this->query_model->update($this->table,$child_location->id, $updateField);
						}
						
					}
			}
				
			
			if(isset($_POST['ContactTime'])){
				$this->query_model->deletebySpecific('tblcontact_time','location_id',$this->uri->segment(4));
				
				 
				foreach($_POST['ContactTime'] as $key => $contactTime){
				
					
					$this->db->order_by("id","desc");
					/*$time_data['week_day'] = (isset($contactTime[0]) && !empty($contactTime[0])) ? $contactTime[0] : ucfirst($key);
					$time_data['start_hour'] = isset($contactTime[1]) ? $contactTime[1] : '';
					$time_data['start_min'] =isset($contactTime[2]) ? $contactTime[2] : '';
					$time_data['start_am_pm'] = isset($contactTime[3]) ? $contactTime[3] : '';
					$time_data['end_hour'] = isset($contactTime[4]) ? $contactTime[4] : '';
					$time_data['end_min'] = isset($contactTime[5]) ? $contactTime[5] : '';
					$time_data['end_am_pm'] = isset($contactTime[6]) ? $contactTime[6] : '';
					$time_data['closed'] = isset($contactTime[7]) ? $contactTime[7] : '';*/
					
					$time_data['week_day'] = ucfirst($key);
					$time_data['start_hour'] = isset($contactTime['start_hour']) ? $contactTime['start_hour'] : '';
					$time_data['start_min'] =isset($contactTime['start_min']) ? $contactTime['start_min'] : '';
					$time_data['start_am_pm'] = isset($contactTime['start_am_pm']) ? $contactTime['start_am_pm'] : '';
					$time_data['end_hour'] = isset($contactTime['end_hour']) ? $contactTime['end_hour'] : '';
					$time_data['end_min'] = isset($contactTime['end_min']) ? $contactTime['end_min'] : '';
					$time_data['end_am_pm'] = isset($contactTime['end_am_pm']) ? $contactTime['end_am_pm'] : '';
					$time_data['closed'] = isset($contactTime['closed']) ? $contactTime['closed'] : 0;
					
					$time_data['location_id'] = $this->uri->segment(4);
					
					
					
					if(isset($contactTime['custom_text_checkbox']) && !empty($contactTime['custom_text_checkbox'])){
						//echo '111<br>';
						$time_data['custom_text_checkbox'] = $contactTime['custom_text_checkbox'];
					}else{
						//echo '222<br>';
						$time_data['custom_text_checkbox'] = 0;
					}
					
					if(isset($contactTime['custom_text'])){
						$time_data['custom_text'] = $contactTime['custom_text'];
					} else{
						$time_data['custom_text'] = '';
					}
					
					//echo '<pre>time_data'; print_r($time_data); die;
					$this->query_model->insertData('tblcontact_time', $time_data);
					
				}
			
			}
			redirect("admin/contact");
		endif;
	
	}


	public function getLatLongByAddress($AddressForLatitude = null){
		$response = array();
		
		if(!empty($AddressForLatitude)){
			
			$curl = curl_init();
			$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($AddressForLatitude)."&key=AIzaSyAvsN6lxKatuxrNPlOguoReJkwgFX6DjKA";
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_POSTFIELDS => "",
			  CURLOPT_SSL_VERIFYHOST => 0,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/x-www-form-urlencoded",
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
				$response = json_decode($response);
				
			}
			
			return $response;
		}
		
	}
	

}
