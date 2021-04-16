<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff_model extends CI_Model{
	
	var $table = 'tblstaff';
	
	function updateStaff(){
		//echo '<pre>'; print_r($_FILES); die;
		$this->load->helper(array('url'));
		
		$data['name'] = $this->input->post('name'); 
		$data['content'] = htmlentities($this->input->post('text')); 
		$data['belt'] = $this->input->post('belt'); 
		$data['experience'] =  isset($_POST['experience']) ? $_POST['experience'] : 0;
		$data['image_alt'] = isset($_POST['image_alt']) ? $_POST['image_alt'] : ''; 
		$data['position'] = isset($_POST['position']) ? $_POST['position'] : ''; 
		$data['photo_alt_text'] = isset($_POST['photo_alt_text']) ? $_POST['photo_alt_text'] : ''; 
		$data['lightbox_photo_alt_text'] = isset($_POST['lightbox_photo_alt_text']) ? $_POST['lightbox_photo_alt_text'] : ''; 
		
		$data['not_linked'] = isset($_POST['not_linked']) ? $_POST['not_linked'] : 0;  
		$data['lightbox_or_url'] = $this->input->post('lightbox_or_url'); 
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
		
			
		
		$base_url = base_url();
		
		$staff_id = $this->uri->segment(4);
		
		
			
		if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			$this->load->model('upload_model');
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
		$image = $_FILES['userfile']['name'];
		$path = "upload/staff/";
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
			$data['photo'] = str_replace('upload/staff/','',$a);
			$imageType = str_replace('image/','',$imagedetails['mime']);
			
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png_staff($original_image, 'upload/staff/thumb/'.$data['photo'], 210, 250);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif_staff($original_image, 'upload/staff/thumb/'.$data['photo'], 210, 250);
			} else {
				$this->query_model->resize_and_crop_staff($original_image, 'upload/staff/thumb/'.$data['photo'], 210, 250);
			}
			
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/staff/'.$data['photo']);
			
			$this->query_model->tinyImageCampressAndResize('upload/staff/thumb/'.$data['photo']);	
			
			}
		}
		
		
		//////// Lightbox image///
		
		
		if(isset($_FILES['lightbox_photo']['name']) && !empty($_FILES['lightbox_photo']['name'])){
				$this->load->model('upload_model');
				$_FILES['userfile'] = $_FILES['lightbox_photo'];
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
				$image = $_FILES['userfile']['name'];
				
				$path = "upload/staff/";
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
					$data['lightbox_photo'] = str_replace('upload/staff/','',$a);
					$imageType = str_replace('image/','',$imagedetails['mime']);
					
					if($imageType == 'png'){
						$this->query_model->resize_and_crop_png_staff($original_image, 'upload/staff/thumb/'.$data['lightbox_photo'], 419, 640);
					}elseif($imageType == 'gif'){
						$this->query_model->resize_and_crop_gif_staff($original_image, 'upload/staff/thumb/'.$data['lightbox_photo'], 419, 640);
					} else {
						$this->query_model->resize_and_crop_staff($original_image, 'upload/staff/thumb/'.$data['lightbox_photo'], 419, 640);
					}
					
					// Tiny Image Campress and resize
					$this->query_model->tinyImageCampressAndResize('upload/staff/'.$data['lightbox_photo']);
					
					$this->query_model->tinyImageCampressAndResize('upload/staff/thumb/'.$data['lightbox_photo']);
					
					}
			}
			
			
		//echo '<pre>data'; print_r($data); die;
		$this->query_model->update('tblstaff', $staff_id, $data);
		if($this->input->post('location_id') != ''){
				redirect("admin/staff/multilocation/".$data['location_id']);
		} else{
				redirect("admin/staff");
		}
		
	}
	
	function addStaff(){
		
		$this->load->helper(array('url'));
		
		$data['name'] = $this->input->post('name'); 
		$data['content'] = htmlentities($this->input->post('text')); 
		$data['belt'] = $this->input->post('belt'); 
		$data['experience'] =   isset($_POST['experience']) ? $_POST['experience'] : 0;
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
		
		/*$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
		$image = $_FILES['userfile']['name'];	*/	
		
		$base_url = base_url();
		
		$this->db->select_max('pos');
		$query = $this->db->get('tblstaff');
		$row = $query->row();
		$data['pos'] = $row->pos + 1;
		
		if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
			$image = $_FILES['userfile']['name'];
			$this->load->model('upload_model');
		$path = "upload/staff/";
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
			$data['photo'] = str_replace('upload/staff/','',$a);
			//$this->query_model->resize_and_crop($original_image, 'upload/staff/thumb/'.$image, 210, 250);
			$imageType = str_replace('image/','',$imagedetails['mime']);
			
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png_staff($original_image, 'upload/staff/thumb/'.$data['photo'], 210, 250);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif_staff($original_image, 'upload/staff/thumb/'.$data['photo'], 210, 250);
			} else {
				$this->query_model->resize_and_crop_staff($original_image, 'upload/staff/thumb/'.$data['photo'], 210, 250);
			}
			
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/staff/'.$data['photo']);
			
			$this->query_model->tinyImageCampressAndResize('upload/staff/thumb/'.$data['photo']);	
			
			
			
			}
		
		
		
		}
		
		
		//////// Lightbox image///
		
		
		if(isset($_FILES['lightbox_photo']['name']) && !empty($_FILES['lightbox_photo']['name'])){
				$this->load->model('upload_model');
				$_FILES['userfile'] = $_FILES['lightbox_photo'];
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
				$image = $_FILES['userfile']['name'];
				
				$path = "upload/staff/";
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
					$data['lightbox_photo'] = str_replace('upload/staff/','',$a);
					$imageType = str_replace('image/','',$imagedetails['mime']);
					
					if($imageType == 'png'){
						$this->query_model->resize_and_crop_png_staff($original_image, 'upload/staff/thumb/'.$data['lightbox_photo'], 419, 640);
					}elseif($imageType == 'gif'){
						$this->query_model->resize_and_crop_gif_staff($original_image, 'upload/staff/thumb/'.$data['lightbox_photo'], 419, 640);
					} else {
						$this->query_model->resize_and_crop_staff($original_image, 'upload/staff/thumb/'.$data['lightbox_photo'], 419, 640);
					}
					
			
					// Tiny Image Campress and resize
					$this->query_model->tinyImageCampressAndResize('upload/staff/'.$data['lightbox_photo']);
					
					$this->query_model->tinyImageCampressAndResize('upload/staff/thumb/'.$data['lightbox_photo']);	
			
			
					}
			}
		
		$this->query_model->insertData('tblstaff', $data);	
		//redirect("admin/staff");
		if($this->input->post('location_id') != ''){
				redirect("admin/staff/multilocation/".$data['location_id']);
		} else{
				redirect("admin/staff");
		}
	}
	
	
	function getStaffbyId($id){
		return $this->query_model->getbyId($this->table, $id);
	}
	
	function IsAllowMultiStaff(){
		$this->load->database();
		
		$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_staff'));
		$result = $query->result();
		return $result[0]->field_value;
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
	
	function getLocationStaffMeta(){
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
	
	function getAllStaff(){
		
		$this->db->select('tblstaff.*, tblcontact.name as location');
		$this->db->from('tblstaff');
		$this->db->join('tblcontact', 'tblcontact.id = tblstaff.location_id', 'left');
		$this->db->order_by("pos", "ASC");

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}
	
	function getFacilityByLocationSlug($location_slug){
		
		$this->db->select('tblstaff.*, tblcontact.name as location, tblcontact.slug, tblcontact.name as meta_desc_staff');
		$this->db->from('tblstaff');
		$this->db->join('tblcontact', 'tblcontact.id = tblstaff.location_id', 'left');
		$this->db->where('tblstaff.published', 1);
		$this->db->where('tblcontact.slug', $location_slug);
		
		$query = $this->db->get();
		
		//echo $this->db->last_query();

		if($query->num_rows() > 0){
			$result = $query->result();
			//echo '<pre>'; print_r($result); echo '</pre>';
		 	return $result;
		}else{
			return false;	
		}
	}
	
}