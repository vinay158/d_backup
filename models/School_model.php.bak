<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends CI_Model{
	
	var $table = 'tblcontact';
	
	function getAll(){
		$this->db->where('published',1);
		return $this->query_model->getbyTable($this->table);
	}

	// School Staff Section for Instructor Start


		function getStaffbyId($id){
		return $this->query_model->getbyId('tblschool_staff', $id);
	}

		function IsAllowMultiStaff(){
		$this->load->database();
		
		$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_staff'));
		$result = $query->result();
		return $result[0]->field_value;
	}

		function getSpecificLocationStaffMeta($location_id){
		$this->db->where('id',$location_id);
		$query = $this->db->get('tblcontact');
		$result = $query->result();
		$data = array();
		
		foreach($result as $r){
			$data[$r->id][] = $r->name;
			$data[$r->id][] = $r->meta_desc_staff;
			$data[$r->id][] = $r->meta_title_staff;
		}
		
		return $data;
		
		
	}

		function getLocations(){
		$query = $this->db->get('tblcontact');
		$result = $query->result();
		$data = array();
		foreach($result as $r){
			$data[$r->id] = $r->name;
		}
		
		return $data;
		
	}


		function addStaff(){
		
		$this->load->helper(array('url'));
		
		$data['name'] = $this->input->post('name'); 
		$data['content'] = htmlentities($this->input->post('text')); 
		$data['belt'] = $this->input->post('belt'); 
		$data['experience'] =  isset($_POST['experience']) ? $_POST['experience'] : 0;
		$data['image_alt'] = isset($_POST['image_alt']) ? $_POST['image_alt'] : ''; 
		$data['position'] = isset($_POST['position']) ? $_POST['position'] : ''; 
		$data['not_linked'] = isset($_POST['not_linked']) ? $_POST['not_linked'] : 0; 
		 
		$data['lightbox_or_url'] = $this->input->post('lightbox_or_url'); 
		$data['photo_alt_text'] = isset($_POST['photo_alt_text']) ? $_POST['photo_alt_text'] : ''; 
		$data['lightbox_photo_alt_text'] = isset($_POST['lightbox_photo_alt_text']) ? $_POST['lightbox_photo_alt_text'] : ''; 
		if($data['lightbox_or_url'] == 'url'){
			$data['url'] = $this->input->post('url'); 
			$data['target'] = $this->input->post('target'); 
		}
		
		$data['published'] = 1;
		
		if($_POST['location_id'] != ''){
			$data['location_id'] = $_POST['location_id'];
		}else{
			$data['location_id'] = NULL;
		}

		//echo '<pre>'; print_r($data); die('yes');
		
		/*$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
		$image = $_FILES['userfile']['name'];	*/	
		//echo '<pre>'; print_r($_FILES); die('yes');
		
		$base_url = base_url();
		
		$this->db->select_max('pos');
		$query = $this->db->get('tblschool_staff');
		$row = $query->row();
		$data['pos'] = $row->pos + 1;
		
		if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
			$image = $_FILES['userfile']['name'];
			$this->load->model('upload_model');
		$path = "upload/school_staff/";
		$data['photo'] = $image; 
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
			
			if($width >= 210 && $height <= 250){
				$config['width'] = $width;
				$config['height'] =250;
			} elseif($height >= 250 && $width <= 210){
				$config['width'] = 210;
				$config['height'] = $height;
			}else{
				$config['height'] =250;
				$config['width'] = 210;
			}
			
			//$dim = (intval($width) / intval($height)) - ($config['width'] / $config['height']);
			//$image_config['master_dim'] = ($dim > 0)? "height" : "width";
			
			
			
			//$config['master_dim'] = 'width';			
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
			
			$original_image = $a;
			$data['photo'] = str_replace('upload/school_staff/','',$a);
			//$this->query_model->resize_and_crop($original_image, 'upload/staff/thumb/'.$image, 210, 250);
			$imageType = str_replace('image/','',$imagedetails['mime']);
			
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png_staff($original_image, 'upload/school_staff/thumb/'.$data['photo'], 210, 250);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif_staff($original_image, 'upload/school_staff/thumb/'.$data['photo'], 210, 250);
			} else {
				$this->query_model->resize_and_crop_staff($original_image, 'upload/school_staff/thumb/'.$data['photo'], 210, 250);
			}
			
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/school_staff/'.$data['photo']);
			
			$this->query_model->tinyImageCampressAndResize('upload/school_staff/thumb/'.$data['photo']);
			
			}
		
		
		}
		
		
		
		//////// Lightbox image///
		
		
		if(isset($_FILES['lightbox_photo']['name']) && !empty($_FILES['lightbox_photo']['name'])){
				$this->load->model('upload_model');
				$_FILES['userfile'] = $_FILES['lightbox_photo'];
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
				$image = $_FILES['userfile']['name'];
				
				$path = "upload/school_staff/";
				$data['lightbox_photo'] = $image;
				
				if($a = $this->upload_model->upload_image($path)){
					//echo $p; die;
					$r='';
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
					
					if($width >= 419 && $height <= 640){
						$config['width'] = $width;
						$config['height'] =640;
					} elseif($height >= 640 && $width <= 419){
						$config['width'] = 419;
						$config['height'] = $height;
					}else{
						$config['height'] =640;
						$config['width'] = 419;
					}
					
					
					$this->load->library('image_lib', $config);			 			
					$this->image_lib->initialize($config);        
					
					if (!$this->image_lib->resize())
					{
						echo  $this->image_lib->display_errors();
						exit;		    
					}else{			
						$this->image_lib->clear();
						$filename=str_replace('.','_thumb.',$filename);
						$r=$path.$filename;
					}
					
					$original_image = $a;
					$data['lightbox_photo'] = str_replace('upload/school_staff/','',$a);
					$imageType = str_replace('image/','',$imagedetails['mime']);
					
					if($imageType == 'png'){
						$this->query_model->resize_and_crop_png_staff($original_image, 'upload/school_staff/thumb/'.$data['lightbox_photo'], 419, 640);
					}elseif($imageType == 'gif'){
						$this->query_model->resize_and_crop_gif_staff($original_image, 'upload/school_staff/thumb/'.$data['lightbox_photo'], 419, 640);
					} else {
						$this->query_model->resize_and_crop_staff($original_image, 'upload/school_staff/thumb/'.$data['lightbox_photo'], 419, 640);
					}
					
			
					// Tiny Image Campress and resize
					$this->query_model->tinyImageCampressAndResize('upload/school_staff/'.$data['lightbox_photo']);
					
					$this->query_model->tinyImageCampressAndResize('upload/school_staff/thumb/'.$data['lightbox_photo']);	
			
			
					}
			}
		
		
		$this->query_model->insertData('tblschool_staff', $data);	
		//redirect("admin/staff");
		if($this->input->post('location_id') != ''){
				redirect("admin/school/school_staff_index/".$data['location_id']);
		} else{
				redirect("admin/school");
		}
	}


		function updateStaff(){
		//echo '<pre>'; print_r($_POST); die;
		$this->load->helper(array('url'));
		
		$data['name'] = $this->input->post('name'); 
		$data['content'] = htmlentities($this->input->post('text')); 
		$data['belt'] = $this->input->post('belt'); 
		$data['experience'] = isset($_POST['experience']) ? $_POST['experience'] : 0;
		$data['image_alt'] = isset($_POST['image_alt']) ? $_POST['image_alt'] : ''; 
		$data['position'] = isset($_POST['position']) ? $_POST['position'] : ''; 
		$data['not_linked'] = isset($_POST['not_linked']) ? $_POST['not_linked'] : 0; 
		$data['lightbox_or_url'] = $this->input->post('lightbox_or_url'); 
		$data['photo_alt_text'] = isset($_POST['photo_alt_text']) ? $_POST['photo_alt_text'] : ''; 
		$data['lightbox_photo_alt_text'] = isset($_POST['lightbox_photo_alt_text']) ? $_POST['lightbox_photo_alt_text'] : ''; 
		if($data['lightbox_or_url'] == 'url'){
			$data['url'] = $this->input->post('url'); 
			$data['target'] = $this->input->post('target'); 
		}
		$data['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
		
		if($_POST['location_id'] != ''){
			$data['location_id'] = $_POST['location_id'];
		}else{
			$data['location_id'] = NULL;
		}
		
			
		
		$base_url = base_url();
		
		$staff_id = $this->uri->segment(4);
		
		if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			$this->load->model('upload_model');
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
		$image = $_FILES['userfile']['name'];
		$path = "upload/school_staff/";
		$data['photo'] = $image; 
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
			
			if($width >= 210 && $height <= 250){
				$config['width'] = $width;
				$config['height'] =250;
			} elseif($height >= 250 && $width <= 210){
				$config['width'] = 210;
				$config['height'] = $width;
			}else{
				$config['height'] =250;
				$config['width'] = 210;
			}
			
			//$dim = (intval($width) / intval($height)) - ($config['width'] / $config['height']);
			//$image_config['master_dim'] = ($dim > 0)? "height" : "width";
			
			
			
			//$config['master_dim'] = 'width';			
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
			
			$original_image = $a;
			$data['photo'] = str_replace('upload/school_staff/','',$a);
			$imageType = str_replace('image/','',$imagedetails['mime']);
			
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png_staff($original_image, 'upload/school_staff/thumb/'.$data['photo'], 210, 250);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif_staff($original_image, 'upload/school_staff/thumb/'.$data['photo'], 210, 250);
			} else {
				$this->query_model->resize_and_crop_staff($original_image, 'upload/school_staff/thumb/'.$data['photo'], 210, 250);
			}
			
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/school_staff/'.$data['photo']);
			
			$this->query_model->tinyImageCampressAndResize('upload/school_staff/thumb/'.$data['photo']);	
			
			}
		}
		
		
		
		
		//////// Lightbox image///
		
		
		if(isset($_FILES['lightbox_photo']['name']) && !empty($_FILES['lightbox_photo']['name'])){
				$this->load->model('upload_model');
				$_FILES['userfile'] = $_FILES['lightbox_photo'];
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
				$image = $_FILES['userfile']['name'];
				
				$path = "upload/school_staff/";
				$data['lightbox_photo'] = $image;
				
				if($a = $this->upload_model->upload_image($path)){
					//echo $p; die;
					$r='';
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
					
					if($width >= 419 && $height <= 640){
						$config['width'] = $width;
						$config['height'] =640;
					} elseif($height >= 640 && $width <= 419){
						$config['width'] = 419;
						$config['height'] = $height;
					}else{
						$config['height'] =640;
						$config['width'] = 419;
					}
					
					
					$this->load->library('image_lib', $config);			 			
					$this->image_lib->initialize($config);        
					
					if (!$this->image_lib->resize())
					{
						echo  $this->image_lib->display_errors();
						exit;		    
					}else{			
						$this->image_lib->clear();
						$filename=str_replace('.','_thumb.',$filename);
						$r=$path.$filename;
					}
					
					$original_image = $a;
					$data['lightbox_photo'] = str_replace('upload/school_staff/','',$a);
					$imageType = str_replace('image/','',$imagedetails['mime']);
					
					if($imageType == 'png'){
						$this->query_model->resize_and_crop_png_staff($original_image, 'upload/school_staff/thumb/'.$data['lightbox_photo'], 419, 640);
					}elseif($imageType == 'gif'){
						$this->query_model->resize_and_crop_gif_staff($original_image, 'upload/school_staff/thumb/'.$data['lightbox_photo'], 419, 640);
					} else {
						$this->query_model->resize_and_crop_staff($original_image, 'upload/school_staff/school_staff/'.$data['lightbox_photo'], 419, 640);
					}
					
					// Tiny Image Campress and resize
					$this->query_model->tinyImageCampressAndResize('upload/school_staff/'.$data['lightbox_photo']);
					
					$this->query_model->tinyImageCampressAndResize('upload/school_staff/thumb/'.$data['lightbox_photo']);
					
					}
			}
			
		
		
		$this->query_model->update('tblschool_staff', $staff_id, $data);
		if($this->input->post('location_id') != ''){
				redirect("admin/school/school_staff_index/".$data['location_id']);
		} else{
				redirect("admin/school");
		}
		
	}


// ----- School Staff Section for Instructor Ends


// Team Members Section Starts



		function getMemberbyId($id){
		return $this->query_model->getbyId('tbl_team_members', $id);
	}

		function addTeam(){
		
		$this->load->helper(array('url'));
		
		$data['name'] = $this->input->post('name'); 
		$data['designation'] = $this->input->post('designation'); 
		$data['created'] = date('Y-m-d h:i:s'); 
		
		if($_POST['location_id'] != ''){
			$data['location_id'] = $_POST['location_id'];
		}else{
			$data['location_id'] = NULL;
		}

		//echo '<pre>'; print_r($data); die('yes');
		
		$base_url = base_url();
				
		
		$this->query_model->insertData('tbl_team_members', $data);	
		//redirect("admin/staff");
		if($this->input->post('location_id') != ''){
				redirect("admin/school/team_member_index/".$data['location_id']);
		} else{
				redirect("admin/school");
		}
	}


		function update_team(){

		//echo '<pre>'; print_r($_POST); die;

		$this->load->helper(array('url'));
		
		$data['name'] = $this->input->post('name'); 
		$data['designation'] = $this->input->post('designation');
		$data['published'] = $this->input->post('publish'); 
		
		if($_POST['location_id'] != ''){
			$data['location_id'] = $_POST['location_id'];
		}else{
			$data['location_id'] = NULL;
		}
		
			
		
		$base_url = base_url();
		
		$team_mem_id = $this->uri->segment(4);
		

		
		$this->query_model->update('tbl_team_members', $team_mem_id, $data);
		if($this->input->post('location_id') != ''){
				redirect("admin/school/team_member_index/".$data['location_id']);
		} else{
				redirect("admin/school");
		}
		
	}


	// Team Members Section Ends



	
	function addContact(){
		
		$image = $_FILES['userfile']['name'];
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
		
		$meta_title = $_POST['meta_title'];
		$meta_desc = $_POST['meta_desc'];
		//$featured = $_POST['featured'];
		$map_zoom_level = $_POST['map_zoom_level'];
		
		$type = isset($_POST['type'])?$_POST['type']:'';
		$s_id = isset($_POST['s_id'])?$_POST['s_id']:'';
		$api_key = isset($_POST['api_key'])?$_POST['api_key']:'';
		
		$fb = $_POST['fb'];
		$twitter = $_POST['twitter'];
		$instagram = $_POST['instagram'];
		$gplus = $_POST['gplus'];
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
		$text_address = $_POST['text_address'];
		
		/*$current_city = $_POST['current_city'];
		$current_location = $_POST['current_location'];*/
		
		$AddressForLatitude = $address.' '.$suite.' '.$city.' ' .$state.' '.$zip; // Google HQ
		$latitude = '';
		$longitude ='';
      	$url =file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($AddressForLatitude).",+US");
		$output= json_decode($url);
		if(!empty($output) && isset($output->results[0])){
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;
		}
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/contacts/";
			$a = $this->upload_model->upload_image($path);
		
		$data = array("name" => $name,"slug" => $slug, "address" => $address,"suite"=>$suite, "city" => $city, "state" => $state, "zip" => $zip, "phone" => $phone, "email" => $email,"content" => $content, "published" => $pub, "meta_desc" => $meta_desc, "meta_title" => $meta_title,'latitude' => $latitude,'longitude'=>$longitude,'map_zoom_level'=>$map_zoom_level,'single_map_zoom_level'=>$single_map_zoom_level,'seo_text'=>$seo_text,'text_address'=>$text_address,'type'=>$type,'s_id'=>$s_id,'api_key'=>$api_key,'fb'=>$fb,'twitter'=>$twitter,'instagram'=>$instagram,'gplus'=>$gplus,'youtube'=>$youtube,'vimeo'=>$vimeo,'yelp'=>$yelp,'linkedIn'=>$linkedIn,'external_url'=>$external_url,'location_type'=>$location_type,'photo' => $a);
			
		}else{
		
		$data = array("name" => $name,"slug" => $slug, "address" => $address,"suite"=>$suite, "city" => $city, "state" => $state, "zip" => $zip, "phone" => $phone, "email" => $email,"content" => $content, "published" => $pub, "meta_desc" => $meta_desc, "meta_title" => $meta_title,'latitude' => $latitude,'longitude'=>$longitude,'map_zoom_level'=>$map_zoom_level,'single_map_zoom_level'=>$single_map_zoom_level,'seo_text'=>$seo_text,'text_address'=>$text_address,'type'=>$type,'s_id'=>$s_id,'api_key'=>$api_key,'fb'=>$fb,'twitter'=>$twitter,'instagram'=>$instagram,'gplus'=>$gplus,'youtube'=>$youtube,'vimeo'=>$vimeo,'yelp'=>$yelp,'linkedIn'=>$linkedIn,'external_url'=>$external_url,'location_type'=>$location_type);
		}
		
		$this->query_model->insertData($this->table, $data);
		$contact_id = $this->db->insert_id();
		
		
			if(isset($_POST['ContactTime'])){
				foreach($_POST['ContactTime'] as $contactTime){
				$this->db->order_by("id","desc");
				$time_data['week_day'] = $contactTime[0];
				$time_data['start_hour'] = $contactTime[1];
				$time_data['start_min'] = $contactTime[2];
				$time_data['start_am_pm'] = $contactTime[3];
				$time_data['end_hour'] = $contactTime[4];
				$time_data['end_min'] = $contactTime[5];
				$time_data['end_am_pm'] = $contactTime[6];
				$time_data['location_id'] = $contact_id;
				$time_data['closed'] = $contactTime[7];
				
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
			 $x = explode('/',$data['photo']);
		 
		$image = $_FILES['userfile']['name'];
		 if(isset($_POST['update'])){
					
					if($_FILES['userfile']['name'] !== ""){
					
				$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
				
					}
					
			    }
				
		
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
		$meta_title = $_POST['meta_title'];
		$meta_desc = $_POST['meta_desc'];
		//$featured = $_POST['featured'];
		$map_zoom_level = $_POST['map_zoom_level'];
		$text_address = $_POST['text_address'];
		
		$type = isset($_POST['type'])?$_POST['type']:'';
		$s_id = isset($_POST['s_id'])?$_POST['s_id']:'';
		$api_key = isset($_POST['api_key'])?$_POST['api_key']:'';
		
		$fb = $_POST['fb'];
		$twitter = $_POST['twitter'];
		$instagram = $_POST['instagram'];
		$gplus = $_POST['gplus'];
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
		
		/*$mon_to_fri = $_POST['mon_to_fri'];
		$saturday = $_POST['saturday'];
		$sunday = $_POST['sunday'];*/
		
		$contactDetail = $this->query_model->getById('tblcontact',$this->uri->segment(4));
		if($contactDetail[0]->address == $address && $contactDetail[0]->suite == $suite && $contactDetail[0]->city == $city && $contactDetail[0]->state == $state && $contactDetail[0]->zip == $zip){
			$latitude = $contactDetail[0]->latitude;
			$longitude =$contactDetail[0]->longitude;
		}else {
			$latitude = '';
			$longitude ='';
			$AddressForLatitude = $address.' '.$suite.' '.$city.' ' .$state.' '.$zip; // Google HQ
			$url =file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($AddressForLatitude).",+US");
			$output= json_decode($url);
			if(!empty($output) && isset($output->results[0])){
				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;
			}
		
		}
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/contacts/";
			$a = $this->upload_model->upload_image($path);
			
			$data = array("name" => $name,"slug" => $slug, "address" => $address,"suite"=>$suite, "city" => $city, "state" => $state, "zip" => $zip, "phone" => $phone, "email" => $email,"content" => $content, "published" => $pub, "meta_desc" => $meta_desc, "meta_title" => $meta_title,'latitude' => $latitude,'longitude'=>$longitude,'map_zoom_level'=>$map_zoom_level,'single_map_zoom_level'=>$single_map_zoom_level,'seo_text'=>$seo_text,'text_address'=>$text_address,'type'=>$type,'s_id'=>$s_id,'api_key'=>$api_key,'fb'=>$fb,'twitter'=>$twitter,'instagram'=>$instagram,'gplus'=>$gplus,'youtube'=>$youtube,'vimeo'=>$vimeo,'yelp'=>$yelp,'linkedIn'=>$linkedIn,'external_url'=>$external_url,'location_type'=>$location_type,'photo' => $a);
			
		}else{
		
		$data = array("name" => $name,"slug" => $slug, "address" => $address,"suite"=>$suite, "city" => $city, "state" => $state, "zip" => $zip, "phone" => $phone, "email" => $email,"content" => $content, "published" => $pub, "meta_desc" => $meta_desc, "meta_title" => $meta_title,'latitude' => $latitude,'longitude'=>$longitude,'map_zoom_level'=>$map_zoom_level,'single_map_zoom_level'=>$single_map_zoom_level,'seo_text'=>$seo_text,'text_address'=>$text_address,'type'=>$type,'s_id'=>$s_id,'api_key'=>$api_key,'fb'=>$fb,'twitter'=>$twitter,'instagram'=>$instagram,'gplus'=>$gplus,'youtube'=>$youtube,'vimeo'=>$vimeo,'yelp'=>$yelp,'linkedIn'=>$linkedIn,'external_url'=>$external_url,'location_type'=>$location_type);
		}
	
		

		if($this->query_model->update($this->table,$this->uri->segment(4), $data)):
			
			if(isset($_POST['ContactTime'])){
				$this->query_model->deletebySpecific('tblcontact_time','location_id',$this->uri->segment(4));
				//echo '<pre>'; print_r($_POST['ContactTime']); die;
				foreach($_POST['ContactTime'] as $contactTime){
				
					
					$this->db->order_by("id","desc");
					$time_data['week_day'] = $contactTime[0];
					$time_data['start_hour'] = $contactTime[1];
					$time_data['start_min'] = $contactTime[2];
					$time_data['start_am_pm'] = $contactTime[3];
					$time_data['end_hour'] = $contactTime[4];
					$time_data['end_min'] = $contactTime[5];
					$time_data['end_am_pm'] = $contactTime[6];
					$time_data['closed'] = $contactTime[7];
					
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
					
					
					$this->query_model->insertData('tblcontact_time', $time_data);
					
				}
			
			}
			redirect("admin/contact");
		endif;
	
	}	
	

}
