<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query_model extends CI_Model{
	
	
	public function getSiteUrl(){
		
		$base_url = $this->config->item('base_url');
		$base_url = str_replace(array('http://','https://'), '', $base_url);
		$base_url = rtrim($base_url,'/');
		
		return $base_url;
		//return 'dojoservers.com/~demov5';
	}
	
	function getbyUser($user,$password,$table){
		$this->db->where('user',$user);
		$this->db->where('password',sha1($password));
		$query = $this->db->get($table)->result();
		return $query;
	}
	
	function getbyTable($table){
		
		return $this->db->get($table)->result();
	}
	
	function getbyTableData($table){
		$this->db->where('user !=', ' ');
		return $this->db->get($table)->result();
	}
	
	function update($table,$id,$data){
		     $this->db->where('id',$id);
			$this->db->update($table,$data);
		return TRUE;
	}
	
	function insertData($table,$data){
		
		return $this->db->insert($table,$data);
	}
	
	
	function updateData($table,$field,$fieldValue,$data){
			$this->db->where($field,$fieldValue);
			$this->db->update($table,$data);
		return TRUE;
	}
	
	function insertDataFacility($table,$data){
		return $this->db->insert($table,$data);
	}
	
	function getbyId($table,$id){
		$this->db->where('id',$id);
		return $this->db->get($table)->result();	
	}
	
	
	
	function getbySpecific($table,$field,$data){
		$this->db->where($field,$data);
		return $this->db->get($table)->result();	
	}
	
	function getbySpecificRecord($table,$field,$data,$published){
		$this->db->where($field,$data);		
		$this->db->where('published', $published);
		return $this->db->get($table)->result();
		
	}
	
	function deletebyId($table,$id){
		$this->db->where('id',$id);
		if($this->db->delete($table)):
			$q = $this->db->count_all($table);
			if($q == 0) $this->db->query("TRUNCATE TABLE $table");
			return TRUE;
		endif;
	}
	
	
	function deletebySpecific($table,$field, $value){
		$this->db->where($field,$value);
		if($this->db->delete($table)):
			$q = $this->db->count_all($table);
			if($q == 0) $this->db->query("TRUNCATE TABLE $table");
			return TRUE;
		endif;
	}
	
	// Vinay 10/11
	function getMenuPages($id, $menu_id)
        {
			$result = $this->db->query("select * from tblmenupages where parent_id = '".$id."' AND `menu_id` = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
			return $result;
  
        }
		
		
		
		
		
	function getCategory($args){
            return $this->db->query("select * from tblcategory where cat_type = '".$args."' ORDER BY pos ASC")->result();
	}
        
        function getProgramCategory($args){
            return $this->db->query("select * from tblcategory where cat_type = '".$args."'  AND `published` = 1 ORDER BY pos ASC")->result();
	}
	
	function getGalleryCategory($args){
	return $this->db->query("select * from tblcategory where cat_type = '".$args."' ORDER BY pos ASC")->result();
	}
	function addCategory($args){
	return $this->db->insert('tblcategory', $args);
	}
	function editCategory($args){
	return $this->db->update('tblcategory', $args);
	}
	
	function getFacilityData(){
		return $this->db->query("select * from tblaboutfacilityphoto")->result();
	}
	function getAllPublishedLocation(){
		return $this->db->query("select * from tblcontact where published = 1 ORDER BY pos ASC")->result();
	}
	function getAllPublishedFeaturedLocation(){
		return $this->db->query("select * from tblcontact where published = 1 and featured = 1 ORDER BY pos ASC")->result();
	}
	
	
	// vinay 12/11
	
		
	function getMenuMainPages($id, $menu_id)
        {
			
			// vinay 16/11
			/*$this->db->select('tblmanagepages.slug,tblmenupages.*');
			$this->db->from('tblmanagepages');
			$this->db->join('tblmenupages','tblmenupages.page_id= tblmanagepages.id');
			$this->db->where(array('tblmenupages.parent_id' => $id, 'tblmenupages.menu_id' => $menu_id));
			$this->db->order_by("sort_order","ASC");
			$query=$this->db->get();
			$results = $query->result_array();*/
			
			
		   
		   // $results = $this->db->query("select * from tblmenupages where parent_id = '".$id."' ORDER BY title ASC")->result_array();
			
			
			 $results = $this->db->query("select * from tblmenupages where parent_id = '".$id."' AND menu_id = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
			
			return $results;

            
        }
	
	// vinay 19/11
	function getIsMultiMap(){
				$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_map'));
				$result = $query->result_array();
				//$IsMultiMap = $result[0]->field_value;
				return $result;
	}
	
	// vinay 19/11
	function getAllMultiLocation(){
	
				$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_location'));
				$result = $query->result_array();
				//$IsMultiMap = $result[0]->field_value;
				return $result;
				
	}
	
	// vinay 19/11
	function getTotalChild($parent_id){
		
		$countChild = $this->db->query("select count(*) as totalChild from tblmenupages where parent_id = '".$parent_id."'")->result_array();
		return $countChild[0]['totalChild'];
	}
	
	// vinay 19/11
	function getIsAllowMultiFacility(){
	
				$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_facility'));
				$result = $query->result_array();
				//$IsAllowMultiFacility = $result[0]->field_value;
				
				return $result;
				
				if($IsAllowMultiFacility){
					$this->db->select('tblfacilities.*, tblcontact.name');
					$this->db->from('tblfacilities');
					$this->db->join('tblcontact', 'tblcontact.id = tblfacilities.location_id', 'left');
					$this->db->where('tblfacilities.published', 1);
					$this->db->where('tblfacilities.main_facility', '0');
				
					$query = $this->db->get();
					
					//return $query;
					//echo $this->db->last_query();
					
					$total_facilities = $query->num_rows();
					$facilities = $query->result();	
				}
				
				
	}
	
	// vinay 19/11
	function getIsMultiCalender(){
				$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_calendar'));
				$result = $query->result_array();
				//$IsMultiMap = $result[0]->field_value;
				return $result;
	}
	
	
	function getIsMultiStaff(){
				$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_staff'));
				$result = $query->result_array();
				//$IsMultiMap = $result[0]->field_value;
				return $result;
	}
	
	// vinay 19/11
	function getOurProgramsChildPages($parent_id){
	
				$ourProgramsChildPages = $this->db->query("select * from tblmenupages where parent_id = '".$parent_id."' ORDER BY title ASC")->result_array();
			
				//echo '<pre>'; print_r($frontPagesListresults); die;
				return $ourProgramsChildPages ;
				
	}
	
	// vinay 19/11
	function getOurProgramsSubChild($parent_id){
				//$this->db->where('published', 1);
				$getOurProgramsSubChild = $this->db->query("select * from tblmenupages where parent_id = '".$parent_id."' ORDER BY title ASC")->result_array();
			
				//echo '<pre>'; print_r($getOurProgramsSubChild); die;
				return $getOurProgramsSubChild ;
				
	}
	// vinay 19/11
	function getMenuTabPages($slug, $menu_id)
        {
			
			if($slug == "admin/onlinespecial"){
				$resultMainPage = $this->db->query("select * from tblmenupages where slug = '".$slug."' AND `menu_id` = '".$menu_id."' AND `parent_id` = 0 ORDER BY sort_order ASC")->result_array();
			}else{
				$resultMainPage = $this->db->query("select * from tblmenupages where slug = '".$slug."' AND `menu_id` = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
			}
			
			if($resultMainPage){
				$result = $this->db->query("select * from tblmenupages where parent_id = '".$resultMainPage[0]['id']."' AND `menu_id` = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
				return $result;
			} else{
				return '';
			}
  
        }
		
	// vinay 19/11
	
	public function getUserPermission($user_id){
		if($user_id != 1){
			$this->db->where('user_id', $user_id);
			return $this->db->get('tbllinks')->result();
		} else{
			return '';
		}
	}
	
	
	public function getOtherPages($id, $menu_id){
		$mainPages = $this->getMenuMainPages($id,$menu_id);
		
		$otherPages = array();
		foreach($mainPages as $mainPage){
			$pages = $this->getMenuMainPages($mainPage['id'],$menu_id);
			if(empty($pages)){
				$otherPages[] = $mainPage;
			}
		}
		
		return $otherPages;
	}
	
	
	// vinay 20/11
	
	public function getMainLocation(){
			$this->db->where('main_location', 1);
			return $this->db->get('tblcontact')->result();
	}
	
	
	


public function getSubMenuPagesBeforeOnload($id, $menu_id){
	$getSubMenuPagesBeforeOnload = $this->db->query("select id, title, slug from tblmenupages where parent_id = '".$id."' AND `menu_id` = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
	return $getSubMenuPagesBeforeOnload;
}


public function getActivePage($slug){
			
			if(!empty($this->uri->segment(3))){
				$url_slug = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
			}else{
				$url_slug = $this->uri->segment(1).'/'.$this->uri->segment(2);
			}
			
			
			if($url_slug == $slug){
				return true;
			} else{
				return false;
			}
			
}



public function resize_and_crop($original_image_url, $thumb_image_url, $thumb_w, $thumb_h, $quality=75)
{
    // ACQUIRE THE ORIGINAL IMAGE: http://php.net/manual/en/function.imagecreatefromjpeg.php
    
	/*if($imageType == 'png'){
		$original = imagecreatefrompng($original_image_url);
	} else if($imageType == 'gif'){
		$original = imagecreatefromgif($original_image_url);
	} else{
		$original = imagecreatefromjpeg($original_image_url);
	}*/
	
	$original = imagecreatefromjpeg($original_image_url);
	
	
    if (!$original) return FALSE;

    // GET ORIGINAL IMAGE DIMENSIONS
    list($original_w, $original_h) = getimagesize($original_image_url);

    // RESIZE IMAGE AND PRESERVE PROPORTIONS
    $thumb_w_resize = $thumb_w;
    $thumb_h_resize = $thumb_h;
    if ($original_w > $original_h)
    {
        $thumb_h_ratio  = $thumb_h / $original_h;
        $thumb_w_resize = (int)round($original_w * $thumb_h_ratio);
    }
    else
    {
        $thumb_w_ratio  = $thumb_w / $original_w;
        $thumb_h_resize = (int)round($original_h * $thumb_w_ratio);
    }
    if ($thumb_w_resize < $thumb_w)
    {
        $thumb_h_ratio  = $thumb_w / $thumb_w_resize;
        $thumb_h_resize = (int)round($thumb_h * $thumb_h_ratio);
        $thumb_w_resize = $thumb_w;
    }

    // CREATE THE PROPORTIONAL IMAGE RESOURCE
    $thumb = imagecreatetruecolor($thumb_w_resize, $thumb_h_resize);
    if (!imagecopyresampled($thumb, $original, 0,0,0,0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h)) return FALSE;

    // ACTIVATE THIS TO STORE THE INTERMEDIATE IMAGE
    // imagejpeg($thumb, 'RAY_temp_' . $thumb_w_resize . 'x' . $thumb_h_resize . '.jpg', 100);

    // CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
    $final = imagecreatetruecolor($thumb_w, $thumb_h);

    $thumb_w_offset = 0;
    $thumb_h_offset = 0;
    if ($thumb_w < $thumb_w_resize)
    {
        $thumb_w_offset = (int)round(($thumb_w_resize - $thumb_w) / 2);
    }
    else
    {
        $thumb_h_offset = (int)round(($thumb_h_resize - $thumb_h) / 2);
    }

    if (!imagecopy($final, $thumb, 0,0, $thumb_w_offset, $thumb_h_offset, $thumb_w_resize, $thumb_h_resize)) return FALSE;

    // STORE THE FINAL IMAGE - WILL OVERWRITE $thumb_image_url
    if (!imagejpeg($final, $thumb_image_url, $quality)) return FALSE;
    return TRUE;
}



public function resize_and_crop_png($original_image_url, $thumb_image_url, $thumb_w, $thumb_h, $quality=75)
{
	
	$original = imagecreatefrompng($original_image_url);
	
	
    if (!$original) return FALSE;

    // GET ORIGINAL IMAGE DIMENSIONS
    list($original_w, $original_h) = getimagesize($original_image_url);

    // RESIZE IMAGE AND PRESERVE PROPORTIONS
    $thumb_w_resize = $thumb_w;
    $thumb_h_resize = $thumb_h;
    if ($original_w > $original_h)
    {
        $thumb_h_ratio  = $thumb_h / $original_h;
        $thumb_w_resize = (int)round($original_w * $thumb_h_ratio);
    }
    else
    {
        $thumb_w_ratio  = $thumb_w / $original_w;
        $thumb_h_resize = (int)round($original_h * $thumb_w_ratio);
    }
    if ($thumb_w_resize < $thumb_w)
    {
        $thumb_h_ratio  = $thumb_w / $thumb_w_resize;
        $thumb_h_resize = (int)round($thumb_h * $thumb_h_ratio);
        $thumb_w_resize = $thumb_w;
    }

    // CREATE THE PROPORTIONAL IMAGE RESOURCE
    $thumb = imagecreatetruecolor($thumb_w_resize, $thumb_h_resize);
    if (!imagecopyresampled($thumb, $original, 0,0,0,0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h)) return FALSE;

    // ACTIVATE THIS TO STORE THE INTERMEDIATE IMAGE
    // imagejpeg($thumb, 'RAY_temp_' . $thumb_w_resize . 'x' . $thumb_h_resize . '.jpg', 100);

    // CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
    $final = imagecreatetruecolor($thumb_w, $thumb_h);

    $thumb_w_offset = 0;
    $thumb_h_offset = 0;
    if ($thumb_w < $thumb_w_resize)
    {
        $thumb_w_offset = (int)round(($thumb_w_resize - $thumb_w) / 2);
    }
    else
    {
        $thumb_h_offset = (int)round(($thumb_h_resize - $thumb_h) / 2);
    }

    if (!imagecopy($final, $thumb, 0,0, $thumb_w_offset, $thumb_h_offset, $thumb_w_resize, $thumb_h_resize)) return FALSE;

    // STORE THE FINAL IMAGE - WILL OVERWRITE $thumb_image_url
    if (!imagejpeg($final, $thumb_image_url, $quality)) return FALSE;
    return TRUE;
}



public function resize_and_crop_gif($original_image_url, $thumb_image_url, $thumb_w, $thumb_h, $quality=75)
{
	
	$original = imagecreatefromgif($original_image_url);
	
	
    if (!$original) return FALSE;

    // GET ORIGINAL IMAGE DIMENSIONS
    list($original_w, $original_h) = getimagesize($original_image_url);

    // RESIZE IMAGE AND PRESERVE PROPORTIONS
    $thumb_w_resize = $thumb_w;
    $thumb_h_resize = $thumb_h;
    if ($original_w > $original_h)
    {
        $thumb_h_ratio  = $thumb_h / $original_h;
        $thumb_w_resize = (int)round($original_w * $thumb_h_ratio);
    }
    else
    {
        $thumb_w_ratio  = $thumb_w / $original_w;
        $thumb_h_resize = (int)round($original_h * $thumb_w_ratio);
    }
    if ($thumb_w_resize < $thumb_w)
    {
        $thumb_h_ratio  = $thumb_w / $thumb_w_resize;
        $thumb_h_resize = (int)round($thumb_h * $thumb_h_ratio);
        $thumb_w_resize = $thumb_w;
    }

    // CREATE THE PROPORTIONAL IMAGE RESOURCE
    $thumb = imagecreatetruecolor($thumb_w_resize, $thumb_h_resize);
    if (!imagecopyresampled($thumb, $original, 0,0,0,0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h)) return FALSE;

    // ACTIVATE THIS TO STORE THE INTERMEDIATE IMAGE
    // imagejpeg($thumb, 'RAY_temp_' . $thumb_w_resize . 'x' . $thumb_h_resize . '.jpg', 100);

    // CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
    $final = imagecreatetruecolor($thumb_w, $thumb_h);

    $thumb_w_offset = 0;
    $thumb_h_offset = 0;
    if ($thumb_w < $thumb_w_resize)
    {
        $thumb_w_offset = (int)round(($thumb_w_resize - $thumb_w) / 2);
    }
    else
    {
        $thumb_h_offset = (int)round(($thumb_h_resize - $thumb_h) / 2);
    }

    if (!imagecopy($final, $thumb, 0,0, $thumb_w_offset, $thumb_h_offset, $thumb_w_resize, $thumb_h_resize)) return FALSE;

    // STORE THE FINAL IMAGE - WILL OVERWRITE $thumb_image_url
    if (!imagejpeg($final, $thumb_image_url, $quality)) return FALSE;
    return TRUE;
}

// vinay 02/11
	/*public function getStrReplace($data){
			$metaVaribles = $this->getbyId('tblmetavariable',1);
			
			$this->db->where("published", 1);
			$allLocations = $this->getbyTable("tblcontact");
			$allLocations = count($allLocations);
			foreach($metaVaribles as $metaVarible){
				$school_name = $metaVarible->meta_school_name;
				$city = $metaVarible->meta_city;
				$state = $metaVarible->meta_state;
				$city_state = $metaVarible->meta_city_state;
				$nearby_location1 = $metaVarible->meta_nearbylocation1;
				$nearby_location2 = $metaVarible->meta_nearbylocation2;
				$county = $metaVarible->meta_county;
				$main_martial_arts_style = $metaVarible->meta_main_martial_arts_style;
				$martial_arts_style = $metaVarible->meta_martial_arts_style;
				$trial_offer1 = $metaVarible->trial_offer1;
				$trial_offer2 = $metaVarible->trial_offer2;
				$main_instructor = $metaVarible->main_instructor;
				$est_year = $metaVarible->est_year;
				//$current_location = $metaVarible->current_location;
			}
			
			
			$folder_name = $_SERVER['CONTEXT_PREFIX'];
  			$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
			$pageurl = '';
			if(isset($_SERVER['REQUEST_URI'])){
				$pageurl = explode('/',$_SERVER['REQUEST_URI']);
				if(isset($pageurl[1])){
					$controller_url = $pageurl[1];
				}
			}
			
			$about_slug = $this->query_model->getbySpecific('tblmeta', 'id', 21);
			$about_slug = $about_slug[0]->slug;
			
			$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
			$contact_slug = $contact_slug[0]->slug;
			
			$current_location = '';
			$current_city = '';
			if($controller_url == $about_slug || $controller_url == $contact_slug){
					$mutilocation = $this->query_model->getbyTable("tblconfigcalendar");
					
					if($mutilocation[0]->field_value == 1){
						if(!isset($pageurl[2])){
							$location_data = $this->query_model->getMainLocation("tblcontact");	
							$slug = $location_data[0]->slug;
							
						}else{
							$slug = $pageurl[2];
						}
						//$location_slug = str_replace('%27',"'",$this->uri->segment(2));
						$this->db->where("slug", $slug);
						$location_data = $this->query_model->getbyTable("tblcontact");
						$current_location = $location_data[0]->current_city;
						$current_city = $location_data[0]->current_location;
						
					}else{
						$location_data = $this->query_model->getMainLocation("tblcontact");
						$current_location = $location_data[0]->current_city;
						$current_city = $location_data[0]->current_location;
					}
					
			}
			
			
			$content = str_replace(array('{school_name}','{city}','{state}','{city_state}','{nearby_location1}','{nearby_location2}','{county}','{main_martial_arts_style}','{martial_arts_style}','{locations_number} ','{trial_offer1}','{trial_offer2}','{main_instructor}','{est_year}','{current_location}','{current_city}'), array($school_name,$city,$state,$city_state,$nearby_location1,$nearby_location2,$county,$main_martial_arts_style,$martial_arts_style,$allLocations, $trial_offer1, $trial_offer2, $main_instructor, $est_year,$current_location,$current_city), $data);
			
			$content = htmlspecialchars_decode($content);
			
			echo $content;
	}


public function getDescReplace($data){
			$metaVaribles = $this->getbyId('tblmetavariable',1);
			
			$this->db->where("published", 1);
			$allLocations = $this->getbyTable("tblcontact");
			$allLocations = count($allLocations);
			
			
			foreach($metaVaribles as $metaVarible){
				$school_name = $metaVarible->meta_school_name;
				
				$state = $metaVarible->meta_state;
				$city_state = $metaVarible->meta_city_state;
				$nearby_location1 = $metaVarible->meta_nearbylocation1;
				$nearby_location2 = $metaVarible->meta_nearbylocation2;
				$county = $metaVarible->meta_county;
				$main_martial_arts_style = $metaVarible->meta_main_martial_arts_style;
				$martial_arts_style = $metaVarible->meta_martial_arts_style;
				
				$trial_offer1 = $metaVarible->trial_offer1;
				$trial_offer2 = $metaVarible->trial_offer2;
				$main_instructor = $metaVarible->main_instructor;
				$est_year = $metaVarible->est_year;
				$city = $metaVarible->meta_city;
				//$current_location = $metaVarible->current_location;
				
				
			}
			
			$folder_name = $_SERVER['CONTEXT_PREFIX'];
  			$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
			$pageurl = '';
			if(isset($_SERVER['REQUEST_URI'])){
				$pageurl = explode('/',$_SERVER['REQUEST_URI']);
				if(isset($pageurl[1])){
					$controller_url = $pageurl[1];
				}
			}
			
			$about_slug = $this->query_model->getbySpecific('tblmeta', 'id', 21);
			$about_slug = $about_slug[0]->slug;
			
			$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
			$contact_slug = $contact_slug[0]->slug;
			
			$current_location = '';
			$current_city = '';
			if($controller_url == $about_slug || $controller_url == $contact_slug){
					$mutilocation = $this->query_model->getbyTable("tblconfigcalendar");
					
					if($mutilocation[0]->field_value == 1){
						if(!isset($pageurl[2])){
							$location_data = $this->query_model->getMainLocation("tblcontact");	
							$slug = $location_data[0]->slug;
							
						}else{
							$slug = $pageurl[2];
						}
						//$location_slug = str_replace('%27',"'",$this->uri->segment(2));
						$this->db->where("slug", $slug);
						$location_data = $this->query_model->getbyTable("tblcontact");
						$current_location = $location_data[0]->current_city;
						$current_city = $location_data[0]->current_location;
						
					}else{
						$location_data = $this->query_model->getMainLocation("tblcontact");
						$current_location = $location_data[0]->current_city;
						$current_city = $location_data[0]->current_location;
					}
					
			}
			
		
			
			$content = str_replace(array('{school_name}','{city}','{state}','{city_state}','{nearby_location1}','{nearby_location2}','{county}','{main_martial_arts_style}','{martial_arts_style}','{locations_number}','{trial_offer1}','{trial_offer2}','{main_instructor}','{est_year}','{current_location}','{current_city}'), array($school_name,$city,$state,$city_state,$nearby_location1,$nearby_location2,$county,$main_martial_arts_style,$martial_arts_style,$allLocations, $trial_offer1, $trial_offer2, $main_instructor, $est_year,$current_location,$current_city), $data);
			
			$content = htmlspecialchars_decode($content);
			
			echo $content;
	}
	



public function getShortDescReplace($data, $data_limit){
			$metaVaribles = $this->getbyId('tblmetavariable',1);
			
			$this->db->where("published", 1);
			$allLocations = $this->getbyTable("tblcontact");
			$allLocations = count($allLocations);
			foreach($metaVaribles as $metaVarible){
				$school_name = $metaVarible->meta_school_name;
				$city = $metaVarible->meta_city;
				$state = $metaVarible->meta_state;
				$city_state = $metaVarible->meta_city_state;
				$nearby_location1 = $metaVarible->meta_nearbylocation1;
				$nearby_location2 = $metaVarible->meta_nearbylocation2;
				$county = $metaVarible->meta_county;
				$main_martial_arts_style = $metaVarible->meta_main_martial_arts_style;
				$martial_arts_style = $metaVarible->meta_martial_arts_style;
				$trial_offer1 = $metaVarible->trial_offer1;
				$trial_offer2 = $metaVarible->trial_offer2;
				$main_instructor = $metaVarible->main_instructor;
				$est_year = $metaVarible->est_year;
				//$current_location = $metaVarible->current_location;
			}
			
			
			
			$folder_name = $_SERVER['CONTEXT_PREFIX'];
  			$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
			$pageurl = '';
			if(isset($_SERVER['REQUEST_URI'])){
				$pageurl = explode('/',$_SERVER['REQUEST_URI']);
				if(isset($pageurl[1])){
					$controller_url = $pageurl[1];
				}
			}
			
			$about_slug = $this->query_model->getbySpecific('tblmeta', 'id', 21);
			$about_slug = $about_slug[0]->slug;
			
			$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
			$contact_slug = $contact_slug[0]->slug;
			
			$current_location = '';
			$current_city = '';
			if($controller_url == $about_slug || $controller_url == $contact_slug){
					$mutilocation = $this->query_model->getbyTable("tblconfigcalendar");
					
					if($mutilocation[0]->field_value == 1){
						if(!isset($pageurl[2])){
							$location_data = $this->query_model->getMainLocation("tblcontact");	
							$slug = $location_data[0]->slug;
							
						}else{
							$slug = $pageurl[2];
						}
						//$location_slug = str_replace('%27',"'",$this->uri->segment(2));
						$this->db->where("slug", $slug);
						$location_data = $this->query_model->getbyTable("tblcontact");
						$current_location = $location_data[0]->current_city;
						$current_city = $location_data[0]->current_location;
						
					}else{
						$location_data = $this->query_model->getMainLocation("tblcontact");
						$current_location = $location_data[0]->current_city;
						$current_city = $location_data[0]->current_location;
					}
					
			}
			
		
			
			$content = str_replace(array('{school_name}','{city}','{state}','{city_state}','{nearby_location1}','{nearby_location2}','{county}','{main_martial_arts_style}','{martial_arts_style}','{locations_number} ','{trial_offer1}','{trial_offer2}','{main_instructor}','{est_year}','{current_location}','{current_city}'), array($school_name,$city,$state,$city_state,$nearby_location1,$nearby_location2,$county,$main_martial_arts_style,$martial_arts_style,$allLocations, $trial_offer1, $trial_offer2, $main_instructor, $est_year,$current_location,$current_city), $data);
			
			$content = htmlspecialchars_decode($content);
			
			if(strlen($content) > $data_limit){
				$content = substr($content, 0, $data_limit);
				$content = $content;
			}
			echo $content;
	}
*/
public function checkTestimonials(){
		$this->db->where("published", 1);
		$testimonials = $this->query_model->getbyTable("tbltestimonials");
		return $testimonials;
	}
	
public function checkFeaturedProgramms(){
		$this->db->select('f.*, p.program, c.cat_name');
		$this->db->from('tblfeaturedprogram f');
		$this->db->join('tblprogram p', 'p.id = f.program_id', 'left');
		$this->db->join('tblcategory c', 'c.cat_id = p.category', 'left');
		$this->db->order_by("f.pos", "ASC");		
		$this->db->where('f.published', 1);
		$query = $this->db->get();
		$featuredprograms = $query->result();
		
		return $featuredprograms;
}

public function checkStaffs($location_id){
			$this->db->where("location_id", $location_id);
			$this->db->where("published", 1);
			$ourStaffs = $this->query_model->getbyTable("tblstaff");
			
			return $ourStaffs;
}

public function getMainLocationToSlug($location_slug){
		$this->db->where("slug", $location_slug);
		$location_id = $this->query_model->getbyTable("tblcontact");
		
		return $location_id;
}

public function checkAboutContent($location_id){
		$this->db->where("location_id", $location_id);
		$aboutContent = $this->query_model->getbyTable("tblaboutourschool");
		
		return $aboutContent;
}




public function sbPagesList($mainPagesId, $pageSlug){
		$multiLocation = $this->getAllMultiLocation();
		if($pageSlug == 'about' || $pageSlug == 'contact-us'){
			if($multiLocation[0]['field_value'] == 1){
				$subPages = $this->db->query("select * from tblcontact where published = 1 ORDER BY pos ASC")->result_array();
			}else {
				$subPages = $this->query_model->getMenuMainPages($mainPagesId,3);
			}
		}elseif($pageSlug == 'ourprograms'){
				$subPages = array();
		} else{
			$subPages = $this->query_model->getMenuMainPages($mainPagesId,3);
		}
		
		return $subPages;
}


public function getMapPinAddress($contact_slug, $contact_name, $street_address, $suite, $city, $state, $zip, $currentpageurl){
			
			$viewLocationAddress = '';
			$html = '<div id="content-map">';
			$html .= '<h3  id="firstHeading" class="firstHeading">';
			
			if(!empty($contact_name)){ 
				
				$html .= addslashes($contact_name);	
			}
				$html .= "</h3>";
			if(!empty($street_address)){ 
				$viewLocationAddress = $street_address;
				$html .= $street_address; 
			}
				
			if(!empty($suite)){ 
				$html .= ', ';
				$html .= $suite; 
				//$viewLocationAddress .= ','.$suite;
			} 
				$html .= '<br>';
			
			if(!empty($city)){ 
				
				$html .= $city;	
				$viewLocationAddress .= ','.$city;
			}
			
			if(!empty($state)){
				$html .= ', ';
				$html .= $state;
				$html .= ' ';
				$viewLocationAddress .= ','.$state;
			}
			
			if(!empty($zip)){ 
				$html .= $zip;
				$viewLocationAddress .= ','.$zip;	
			}
			$html .= '</br>';
			
			$html .= '<a href="https://www.google.com/maps/place/'.urlencode($viewLocationAddress).'" target="_blank">'.$this->query_model->getStaticTextTranslation('view_large_map').'</a>'; 
			
			if(!empty($currentpageurl)){
			
				$html .= '<br><a href="'.$currentpageurl.'/'.addslashes($contact_slug).'" target="_blank">'.$this->query_model->getStaticTextTranslation('view_contact_page').'</a>';
			}
		
			$html .= '</div>';
			
			$html .= '</div>';
			
			return $html;
	}

	 public function userMedia($user_id, $token){
    	$url = 'https://api.instagram.com/v1/users/'.$user_id.'/media/recent/?access_token='.$token;
    	$content = file_get_contents($url);
		return $json = json_decode($content, true);
    }
	
	
	/*public function facebookUserMedia($user_id, $token, $limit){
    	$url = 'https://graph.facebook.com/'.$user_id.'/posts?fields=attachments,id,link,message,type,object_id,status_type,picture,source,from,story,created_time,name&access_token='.$token.'&limit='.$limit;
				$content = file_get_contents($url);
				 $json = json_decode($content, true);
				 return $json;
    }*/
	
	public function facebookUserMedia($user_id, $token, $limit, $page_id){
		$data = '';
		if(!empty($page_id)){
				$url = "https://graph.facebook.com/".$page_id."/feed?fields=attachments,id,link,message,type,object_id,status_type,picture,source,from,story,created_time,name&access_token=".$token;
				
				$request = curl_init($url); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				
				curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
				curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

				$response = (string)curl_exec($request); // execute curl post and store results in $response
				$error_msg = curl_error($request);
				curl_close($request); // close curl object
				
				if(!empty($response)){
					
					$data = json_decode($response, true);
					
				}
				//$data  = file_get_contents($url);
				//$data = json_decode($data, true);
				//echo '<pre>data'; print_r($data); die;
				 return $data;
			} else{
				$url = 'https://graph.facebook.com/'.$user_id.'/posts?fields=attachments,id,link,message,type,object_id,status_type,picture,source,from,story,created_time,name&access_token='.$token.'&limit='.$limit;
				$request = curl_init($url); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				
				curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
				curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

				$response = (string)curl_exec($request); // execute curl post and store results in $response
				$error_msg = curl_error($request);
				curl_close($request); // close curl object
				
				if(!empty($response)){
					
					$data = json_decode($response, true);
					
				}
				// $content = file_get_contents($url);
				// $json = json_decode($content, true);
				 return $json;
			}
    }
	
	public function get_youtube($url){

		 $youtube = "http://www.youtube.com/oembed?url=". $url ."&format=json";
		
		 $curl = curl_init($youtube);
		 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		 $return = curl_exec($curl);
		 curl_close($curl);
		 return json_decode($return, true);
	
	 }

	
	
	public function youtubeUserMedia($channel_id, $appKey){
			$content = file_get_contents('https://www.googleapis.com/youtube/v3/search?part=id&channelId='.$channel_id.'&maxResults=10&order=date&key='.$appKey);
			
			$content = json_decode($content, true);
			
			return $content;
	}
	
	public function googlePlusUserMedia($google_plus_id, $appKey){
			$streams = file_get_contents('https://www.googleapis.com/plus/v1/people/'.$google_plus_id.'/activities/public?key='.$appKey);
			$content = json_decode($streams, true);
			
			return $content;
	}
	

public function getMetaUrls($meta_id){
		$this->db->where('id',$meta_id);
		$meta_detail = $this->db->get('tblmeta')->result();
		$meta_detail = $meta_detail[0]->slug;
		return $meta_detail;
}

public function getFindUs($street_address, $suite, $city, $state, $zip){
			$viewLocationAddress = '';
			
			if(!empty($street_address)){ 
				$viewLocationAddress = $street_address;
			}
				
			/*if(!empty($suite)){ 
				$viewLocationAddress .= ' '.$suite;
			} **/
			
			if(!empty($city)){ 
				$viewLocationAddress .= ' '.$city;
			}
			
			if(!empty($state)){
				$viewLocationAddress .= ' '.$state;
			}
			if(!empty($zip)){ 
				$viewLocationAddress .= ' '.$zip;	
			}
			
			
			
			
			$findUsUrl = 'https://www.google.com/maps/place/'.urlencode($viewLocationAddress);
			return $findUsUrl;
	}
	
	
public function getFullAddress($street_address, $suite, $city, $state, $zip){
			$viewLocationAddress = '';
			
			if(!empty($street_address)){ 
				$viewLocationAddress = $street_address;
			}
				
			/**if(!empty($suite)){ 
				$viewLocationAddress .= ','.$suite;
			} **/
			
			if(!empty($city)){ 
				$viewLocationAddress .= ', '.$city;
			}
			
			if(!empty($state)){
				$viewLocationAddress .= ', '.$state;
			}

			if(!empty($zip)){ 
				$viewLocationAddress .= ' '.$zip;	
			}
			
			
			
			return $viewLocationAddress;
	}


public function getMetaPageName($slug){
		$this->db->where('slug',$slug);
		$meta_detail = $this->db->get('tblmeta')->result();
		$meta_page_name = !empty($meta_detail) ? $meta_detail[0]->page_label : '';
		return $meta_page_name;
}


public function getThisMonthNews($month){
		$this->db->where('published',1);
		$this->db->where('timestamp <=', date('Y-m-d'));
		$this->db->like('timestamp', $month);
		$this->db->order_by('timestamp','desc');
		$monthly_news = $this->db->get('tblnews')->result();
		return $monthly_news;
}

public function getThisMonthBlogs($month){
		$this->db->where('hide_from_public_blog', 0);
		$this->db->where('published',1);
		$this->db->where('timestamp <=', date('Y-m-d'));
		$this->db->like('timestamp', $month);
		$this->db->order_by('blog_timestamp','desc');
		$monthly_news = $this->db->get('tblblogs')->result();
		return $monthly_news;
}


public function resize_and_crop_staff($original_image_url, $thumb_image_url, $thumb_w, $thumb_h, $quality=75)
{
	
	$original = imagecreatefromjpeg($original_image_url);
	
	
    if (!$original) return FALSE;

    // GET ORIGINAL IMAGE DIMENSIONS
    list($original_w, $original_h) = getimagesize($original_image_url);
	
	
    // RESIZE IMAGE AND PRESERVE PROPORTIONS
    $thumb_w_resize = $thumb_w;
    $thumb_h_resize = $thumb_h;
	
	
	
    if ($original_w >= $original_h)
    {
		//echo 1;
        $thumb_h_ratio  = $thumb_h / $original_h;
        $thumb_w_resize = (int)round($original_w * $thumb_h_ratio);
	 // $thumb_w_resize = $thumb_w_resize;
    }
   else
    {
			//echo $thumb_h_resize.'==><br>';
     	  $thumb_w_ratio  = $thumb_w / $original_w;
     	  $thumb_h_resize = (int)round($original_h * $thumb_w_ratio);
		//echo $thumb_h_resize.'<br>';
		//$thumb_h_resize = $thumb_h_resize;
    }
    if ($thumb_w_resize < $thumb_w)
    {
		//echo 3;
        $thumb_h_ratio  = $thumb_w / $thumb_w_resize;
        $thumb_h_resize = (int)round($thumb_h * $thumb_h_ratio);
        $thumb_w_resize = $thumb_w;
    }


//	echo $thumb_w_resize.'===>'.$thumb_h_resize; die;

    // CREATE THE PROPORTIONAL IMAGE RESOURCE
    $thumb = imagecreatetruecolor($thumb_w_resize, $thumb_h_resize);
	
	$image_size = getimagesize($original_image_url);
	
	/*$top_margin = 0;
	if($thumb_h_resize > 254 ){
		$top_margin = 50;
	}*/
	
	//echo $thumb_h_resize; die;
    if (!imagecopyresampled($thumb, $original, 0,0,0,0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h)) return FALSE;

    // ACTIVATE THIS TO STORE THE INTERMEDIATE IMAGE
    // imagejpeg($thumb, 'RAY_temp_' . $thumb_w_resize . 'x' . $thumb_h_resize . '.jpg', 100);

    // CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
	
	
    $final = imagecreatetruecolor($thumb_w, $thumb_h);

    $thumb_w_offset = 0;
    $thumb_h_offset = 0;
    if ($thumb_w < $thumb_w_resize)
    {
        $thumb_w_offset = (int)round(($thumb_w_resize - $thumb_w) / 2);
    }
    else
    {
        $thumb_h_offset = (int)round(($thumb_h_resize - $thumb_h) / 2);
    }
	//echo $final.'==>'.$thumb.'===>'.$thumb_w_resize.'===>'.$thumb_h_resize; die;
    if (!imagecopy($final, $thumb, 0,0,$thumb_w_offset, 0, $thumb_w_resize, $thumb_h_resize)) return FALSE;

    // STORE THE FINAL IMAGE - WILL OVERWRITE $thumb_image_url
    if (!imagejpeg($final, $thumb_image_url, $quality)) return FALSE;
	


    return TRUE;
}




public function resize_and_crop_png_staff($original_image_url, $thumb_image_url, $thumb_w, $thumb_h, $quality=100)
{
	
	$original = imagecreatefrompng($original_image_url);
	imageAlphaBlending($original, true); // new line
	imageSaveAlpha($original, true); // new line
	
    if (!$original) return FALSE;

    // GET ORIGINAL IMAGE DIMENSIONS
    list($original_w, $original_h) = getimagesize($original_image_url);

    // RESIZE IMAGE AND PRESERVE PROPORTIONS
    $thumb_w_resize = $thumb_w;
    $thumb_h_resize = $thumb_h;
    if ($original_w >= $original_h)
    {
		//echo 1;
        $thumb_h_ratio  = $thumb_h / $original_h;
        $thumb_w_resize = (int)round($original_w * $thumb_h_ratio);
	 // $thumb_w_resize = $thumb_w_resize;
    }
   else
    {
			//echo $thumb_h_resize.'==><br>';
     	  $thumb_w_ratio  = $thumb_w / $original_w;
     	  $thumb_h_resize = (int)round($original_h * $thumb_w_ratio);
		//echo $thumb_h_resize.'<br>';
		//$thumb_h_resize = $thumb_h_resize;
    }
    if ($thumb_w_resize < $thumb_w)
    {
		//echo 3;
        $thumb_h_ratio  = $thumb_w / $thumb_w_resize;
        $thumb_h_resize = (int)round($thumb_h * $thumb_h_ratio);
        $thumb_w_resize = $thumb_w;
    } 
	// vinay new code
	/*else{
		 $thumb_w_ratio  = $thumb_h / $thumb_h_resize;
        $thumb_w_resize = (int)round($thumb_w * $thumb_w_ratio);
        $thumb_h_resize = $thumb_h;
	}*/

    // CREATE THE PROPORTIONAL IMAGE RESOURCE
    $thumb = imagecreatetruecolor($thumb_w_resize, $thumb_h_resize);
	
	/*$top_margin = 0;
	if($thumb_h_resize > 254 ){
		$top_margin = 50;
	}*/
	
	//new line
	$backgroundColor = imagecolorallocate($thumb, 250, 250, 250);
	imagefill($thumb, 0, 0, $backgroundColor);
	
    if (!imagecopyresampled($thumb, $original, 0,0,0,0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h)) return FALSE;

    // ACTIVATE THIS TO STORE THE INTERMEDIATE IMAGE
    // imagejpeg($thumb, 'RAY_temp_' . $thumb_w_resize . 'x' . $thumb_h_resize . '.jpg', 100);

    // CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
    $final = imagecreatetruecolor($thumb_w, $thumb_h);

    $thumb_w_offset = 0;
    $thumb_h_offset = 0;
    if ($thumb_w < $thumb_w_resize)
    {
        $thumb_w_offset = (int)round(($thumb_w_resize - $thumb_w) / 2);
    }
    else
    {
        $thumb_h_offset = (int)round(($thumb_h_resize - $thumb_h) / 2);
    }

    if (!imagecopy($final, $thumb, 0,0,$thumb_w_offset,0, $thumb_w_resize, $thumb_h_resize)) return FALSE;

    // STORE THE FINAL IMAGE - WILL OVERWRITE $thumb_image_url
    if (!imagejpeg($final, $thumb_image_url, $quality)) return FALSE;
    return TRUE;
}



public function resize_and_crop_gif_staff($original_image_url, $thumb_image_url, $thumb_w, $thumb_h, $quality=75)
{
	
	$original = imagecreatefromgif($original_image_url);
	
	
    if (!$original) return FALSE;

    // GET ORIGINAL IMAGE DIMENSIONS
    list($original_w, $original_h) = getimagesize($original_image_url);

    // RESIZE IMAGE AND PRESERVE PROPORTIONS
    $thumb_w_resize = $thumb_w;
    $thumb_h_resize = $thumb_h;
     if ($original_w >= $original_h)
    {
		//echo 1;
        $thumb_h_ratio  = $thumb_h / $original_h;
        $thumb_w_resize = (int)round($original_w * $thumb_h_ratio);
	 // $thumb_w_resize = $thumb_w_resize;
    }
   else
    {
			//echo $thumb_h_resize.'==><br>';
     	  $thumb_w_ratio  = $thumb_w / $original_w;
     	  $thumb_h_resize = (int)round($original_h * $thumb_w_ratio);
		//echo $thumb_h_resize.'<br>';
		//$thumb_h_resize = $thumb_h_resize;
    }
    if ($thumb_w_resize < $thumb_w)
    {
		//echo 3;
        $thumb_h_ratio  = $thumb_w / $thumb_w_resize;
        $thumb_h_resize = (int)round($thumb_h * $thumb_h_ratio);
        $thumb_w_resize = $thumb_w;
    }

    // CREATE THE PROPORTIONAL IMAGE RESOURCE
    $thumb = imagecreatetruecolor($thumb_w_resize, $thumb_h_resize);
    if (!imagecopyresampled($thumb, $original, 0,0,0,0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h)) return FALSE;

    // ACTIVATE THIS TO STORE THE INTERMEDIATE IMAGE
    // imagejpeg($thumb, 'RAY_temp_' . $thumb_w_resize . 'x' . $thumb_h_resize . '.jpg', 100);

    // CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
    $final = imagecreatetruecolor($thumb_w, $thumb_h);

    $thumb_w_offset = 0;
    $thumb_h_offset = 0;
    if ($thumb_w < $thumb_w_resize)
    {
        $thumb_w_offset = (int)round(($thumb_w_resize - $thumb_w) / 2);
    }
    else
    {
        $thumb_h_offset = (int)round(($thumb_h_resize - $thumb_h) / 2);
    }

    if (!imagecopy($final, $thumb, 0,0,$thumb_w_offset,0, $thumb_w_resize, $thumb_h_resize)) return FALSE;

    // STORE THE FINAL IMAGE - WILL OVERWRITE $thumb_image_url
    if (!imagejpeg($final, $thumb_image_url, $quality)) return FALSE;
    return TRUE;
}


public  function getAllPagesWithLinks(){
			
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		
		$allLocations = $this->query_model->getbyTable("tblcontact");
		
		$mainLocation = $this->query_model->getMainLocation("tblcontact");
		
		$about_slug = $this->query_model->getbySpecific('tblmeta', 'id', 21);
		$about_slug = $about_slug[0];
		
		$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
		$contact_slug = $contact_slug[0];
		
		$program_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);
		$program_slug = $program_slug[0];
		
		$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$start_trial_slug = $start_trial_slug[0];
		
		$school_slug = $this->query_model->getbySpecific('tblmeta', 'id', 51);
		$school_slug = $school_slug[0];
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$multiSchool = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
				
		$this->db->where("main_location", 0);
		$allSchoolContacts = $this->query_model->getbyTable("tblcontact");	

		$multi_about_us = $this->query_model->multi_about_us();
				
		$pages = array();
		$add_url = base_url();
		if($multiLocation[0]->field_value == 1 && $multiSchool == 0 && $multi_about_us == 1){
			
			foreach($allLocations as $allLocation){
				$about_url = $about_slug->slug.'/'.$allLocation->slug;
				$pages[$add_url.$about_url] = $about_slug->page_label.'- '.$allLocation->slug;
			}
		} else{
				$about_url = $about_slug->slug.'/'.strtolower(str_replace(' ','-',$mainLocation[0]->city));
				$pages[$add_url.$about_url] = $about_slug->page_label;
		}
		
		if($multiLocation[0]->field_value == 1 && $multiSchool == 1){
			foreach($allSchoolContacts as $allLocation){
				$school_url = $school_slug->slug.'/'.$allLocation->slug;
				$pages[$add_url.$school_url] = $school_slug->page_label.'- '.$allLocation->name;
			}
		}
		
		
		if($multiLocation[0]->field_value == 1 && $multiSchool == 0){
			foreach($allLocations as $allLocation){
				$contact_url = $contact_slug->slug.'/'.$allLocation->slug;
				$pages[$add_url.$contact_url] = $contact_slug->page_label.'- '.$allLocation->slug;
			}
		} else{
				$contact_url = $contact_slug->slug;
				$pages[$add_url.$contact_url] = $contact_slug->page_label;
		}
		
		$pages[$add_url.$start_trial_slug->slug] = $start_trial_slug->page_label;
		
		$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
		$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
		$this->db->order_by('pos', 'asc');
		$this->db->where("published", 1);
		$this->db->where("hide_from_trial_page", 0);
		if($isUniqueSpecialOffer == 1){
			$this->db->where("type", "trial_offer");
		}
		$trial_categories = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
		if(!empty($trial_categories)){
			foreach($trial_categories as $trial_category){
				$trial_category_url = $add_url.$start_trial_slug->slug.'/'.$trial_category->slug;
				$pages[$trial_category_url] = $start_trial_slug->page_label.' ~ '.$trial_category->name;
			}
		}
		
		
		$program_nav = $this->query_model->getCategory("programs");
			if(!empty($program_nav)){
				$col = 1;
					foreach($program_nav as $nav_item_prog){
					$this->db->where('published',1);
					$query_subcat=$this->db->query("select `id` from tblprogram where category=".$nav_item_prog->cat_id."");
									$query_subcat=$query_subcat->result();
									
									$cat_name=str_replace(" ",'-',trim($nav_item_prog->cat_name));
									
									
									$published = 1;
									$query_sub = $this->query_model->getbySpecificRecord("tblprogram", "category", $nav_item_prog->cat_id,$published);
									
									if(isset($query_sub) && !empty($query_sub)) {
									$category_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug;
									$pages[$add_url.$category_url] = '<b>'.$nav_item_prog->cat_name.' - <span class="form-module-span-text">Main Cateogry </span></b>';
									
									foreach($query_sub as $subnav_item_prog){						
											$subcat_name=str_replace(" ",'-',trim($subnav_item_prog->program)); 
													  
													$program_page_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug.'/'.$subnav_item_prog->program_slug;
													$pages[$add_url.$program_page_url] = $subnav_item_prog->buttonName;
											 }
											 
									}
							$col++; 
						}
		
					}
		/*$program_nav = $this->query_model->getCategory("programs");
			if(!empty($program_nav)){
				$col = 1;
					foreach($program_nav as $nav_item_prog){
					
					$query_subcat=$this->db->query("select `id` from tblprogram where category=".$nav_item_prog->cat_id."");
									$query_subcat=$query_subcat->result();
									
									$cat_name=str_replace(" ",'-',trim($nav_item_prog->cat_name));
									
									
									$published = 1;
									$query_sub = $this->query_model->getbySpecificRecord("tblprogram", "category", $nav_item_prog->cat_id,$published);
									
									if(isset($query_sub) && !empty($query_sub)) {
									$category_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug;
									$pages[base_url().$category_url] = '<b>'.$nav_item_prog->cat_name.'</b>';
									
									foreach($query_sub as $subnav_item_prog){						
											$subcat_name=str_replace(" ",'-',trim($subnav_item_prog->program)); 
											
											if($subnav_item_prog->landing_checkbox == 1){ 
													$program_url = '';
														if(!empty($subnav_item_prog->landing_program)){
															$program_url = $subnav_item_prog->landing_program;
														}else{
															$program_url = base_url().$subnav_item_prog->landing_page_url;
														}
														
															$program_page_url = $program_url;
															$pages[$program_page_url] = $subnav_item_prog->buttonName;
														
													 } elseif($subnav_item_prog->stand_alone_page == 1){ 
													 		$program_page_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug.'/'.$subnav_item_prog->program_slug;
															$pages[base_url().$program_page_url] = $subnav_item_prog->buttonName;
													  }
											 }
											 
									}
							$col++; 
						}
		
					} */
					
	//	echo '<pre>'; print_r($pages); die;
		return $pages;
		
}


function checkStudentPassword($table,$password,$location_id = null){
		$where = '(password="'.$password.'" or univeral_password = "'.$password.'")';
		
		//$where = '(password="'.$password.'" and id = "'.$location_id.'")';
		$this->db->where($where);
		return $this->db->get($table)->result();	
}

	
	
	
public  function getAllPagesForAddCode(){
		
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		
		$allLocations = $this->query_model->getbyTable("tblcontact");
		
		$mainLocation = $this->query_model->getMainLocation("tblcontact");
		
		$about_slug = $this->query_model->getbySpecific('tblmeta', 'id', 21);
		$about_slug = $about_slug[0];
		
		$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
		$contact_slug = $contact_slug[0];
		
		$program_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);
		$program_slug = $program_slug[0];
		
		$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$start_trial_slug = $start_trial_slug[0];
                
        $events_slug = $this->query_model->getbySpecific('tblmeta', 'id', 27);
		$events_slug = $events_slug[0];
                
        $student_section_slug = $this->query_model->getbySpecific('tblmeta', 'id', 47);
		$student_section_slug = $student_section_slug[0];
		
		$trial_offer_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$trial_offer_slug = $trial_offer_slug[0];
		
		$school_slug = $this->query_model->getbySpecific('tblmeta', 'id', 51);
		$school_slug = $school_slug[0];
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$multiSchool = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		$this->db->where("main_location", 0);
		$allSchoolContacts = $this->query_model->getbyTable("tblcontact");
		
		$multi_about_us = $this->query_model->multi_about_us();
		
		//echo '<pre>'; print_r($student_section_slug); die;
		$pages = array();
		
		$add_url = '/';
		$pages[$add_url] = 'Home';
                
                
                
		if($multiLocation[0]->field_value == 1 && $multiSchool == 0 && $multi_about_us == 1){
			foreach($allLocations as $allLocation){
				$about_url = $about_slug->slug.'/'.$allLocation->slug;
				$pages[$add_url.$about_url] = $about_slug->page_label.'- '.$allLocation->slug;
			}
		} else{
				$about_url = $about_slug->slug.'/'.strtolower(str_replace(' ','-',$mainLocation[0]->city));
				$pages[$add_url.$about_url] = $about_slug->page_label;
		}
		
		
		if($multiLocation[0]->field_value == 1 && $multiSchool == 1){
			foreach($allSchoolContacts as $allLocation){
				$school_url = $school_slug->slug.'/'.$allLocation->slug;
				$pages[$add_url.$school_url] = $school_slug->page_label.'- '.$allLocation->name;
			}
		}
		
		$pages[$add_url.$start_trial_slug->slug] = $start_trial_slug->page_label;
				
				$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
				$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
				$this->db->order_by('pos', 'asc');
				$this->db->where("published", 1);
				if($isUniqueSpecialOffer == 1){
					$this->db->where("type", "trial_offer");
				}
				$trial_categories = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
				if(!empty($trial_categories)){
					foreach($trial_categories as $trial_category){
						$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
						$this->db->order_by('pos', 'asc');
						$this->db->where("display_trial", 1);
						$trial_offers = $this->query_model->getBySpecific("$tblspecialoffer",'cat_id',$trial_category->id);
						
						$trial_cat_page_url = $start_trial_slug->slug.'/'.$trial_category->slug;
						$pages[$add_url.$trial_cat_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name;
						
						//echo '<pre>trial_offers'; print_r($trial_offers); die;
						if(!empty($trial_offers)){
							foreach($trial_offers as $trial_offer){
								if($trial_offer->trial == 1){
									$payment = $this->query_model->getByTable('tbl_payments');
									if(!empty($payment)){
										
										if($payment[0]->authorize_net_payment == 1 || $payment[0]->braintree_payment == 1 || $payment[0]->stripe_payment == 1 || $payment[0]->stripe_ideal_payment == 1 || $payment[0]->paypal_payment == 1){
											$authorized_payment_page_url = $start_trial_slug->slug.'/'.$trial_category->slug.'/Paid-'.$trial_offer->id.'/thank-you';
											
											$pages[$add_url.$authorized_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') PAID Thankyou Page';
										}
										
										
									}
								}else{
									
									$free_trial_page_url = $start_trial_slug->slug.'/'.$trial_category->slug.'/Free-'.$trial_offer->id.'/thank-you';
									$pages[$add_url.$free_trial_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') FREE Thankyou Page';
								}
							}
						}
						
						
						
						
					}
					
					
					foreach($trial_categories as $trial_category){
						$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
						$this->db->order_by('pos', 'asc');
						$this->db->where("display_trial", 1);
						$this->db->where("upsale", 1);
						$trialOffers = $this->query_model->getbySpecific("$tblspecialoffer", 'cat_id', $trial_category->id);
						
					if(!empty($trialOffers)){
						foreach($trialOffers as $trialOffer){
							
							$payment = $this->query_model->getByTable('tbl_payments');
							if(!empty($payment)){
								if($payment[0]->authorize_net_payment == 1 || $payment[0]->braintree_payment == 1 || $payment[0]->stripe_payment == 1 || $payment[0]->stripe_ideal_payment == 1 || $payment[0]->paypal_payment == 1){
									
									$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
									$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales",'trial_offer_id',$trialOffer->id);
								
									if(!empty($upsellDetail)){
										$upsell_payment_page_url = $start_trial_slug->slug.'/'.$trial_category->slug.'/Trial-'.$trialOffer->id.'/Upsell/thank-you';
											
										$pages[$add_url.$upsell_payment_page_url] = 'Trial Offer- '.$trial_category->name.' ~ '.$this->query_model->getMetaDescReplace($trialOffer->offer_title).'<br> Upsell: '.$this->query_model->getMetaDescReplace($upsellDetail[0]->up_title);
									}
									
								}
							}
								
							}
						}
					}
					
				}
		
		
		$program_nav = $this->query_model->getCategory("programs");
			if(!empty($program_nav)){
				$col = 1;
					foreach($program_nav as $nav_item_prog){
					$this->db->where('published',1);
					$query_subcat=$this->db->query("select `id` from tblprogram where category=".$nav_item_prog->cat_id."");
									$query_subcat=$query_subcat->result();
									
									$cat_name=str_replace(" ",'-',trim($nav_item_prog->cat_name));
									
									
									$published = 1;
									$this->db->select(array('program_slug','buttonName','program','button1_redirection_type','button2_redirection_type','program_type','redirection_type'));
									$query_sub = $this->query_model->getbySpecificRecord("tblprogram", "category", $nav_item_prog->cat_id,$published);
									
									if(isset($query_sub) && !empty($query_sub)) {
									$category_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug;
									$pages[$add_url.$category_url] = '<b>'.$nav_item_prog->cat_name.'</b>';
									if($nav_item_prog->redirection_type == "thankyou_page"){
										$category_thankyou_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug.'/thank-you';
										$pages[$add_url.$category_thankyou_url] = '<b>'.$nav_item_prog->cat_name.' - Thankyou Page</b>';	
									}
									
									foreach($query_sub as $subnav_item_prog){						
											$subcat_name=str_replace(" ",'-',trim($subnav_item_prog->program)); 
											
										//echo '<pre>subnav_item_prog'; print_R($subnav_item_prog); die;
													  $program_page_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug.'/'.$subnav_item_prog->program_slug;
													$pages[$add_url.$program_page_url] = $subnav_item_prog->buttonName;
												
											$program_thankyou_page_show = 0;
											if($subnav_item_prog->program_type == "program_page"){
												if($subnav_item_prog->redirection_type == "thankyou_page"){
													$program_thankyou_page_show = 1;
												}
											}else{
												if($subnav_item_prog->button1_redirection_type == "thankyou_page" || $subnav_item_prog->button2_redirection_type == "thankyou_page"){
													$program_thankyou_page_show = 1;
												}
											}
											
										if($program_thankyou_page_show == 1){
											$program_thankyou_page_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug.'/'.$subnav_item_prog->program_slug.'/thank-you';
											$pages[$add_url.$program_thankyou_page_url] = $subnav_item_prog->buttonName.' - Thankyou Page';
										}											
											
													
											 }
											 
									}
							$col++; 
						}
		
					}
		
		
		if($multiLocation[0]->field_value == 1  && $multiSchool == 0){
			foreach($allLocations as $allLocation){
				$contact_url = $contact_slug->slug.'/'.$allLocation->slug;
				$contact_thankyou_url = $contact_slug->slug.'/thank-you/'.$allLocation->slug;
				$pages[$add_url.$contact_url] = $contact_slug->page_label.'- '.$allLocation->name;
				$pages[$add_url.$contact_thankyou_url] = $contact_slug->page_label.' Thankyou Page - '.$allLocation->name;
			}
		} else{
				$contact_url = $contact_slug->slug;
				$pages[$add_url.$contact_url] = $contact_slug->page_label;
				foreach($allLocations as $allLocation){
					$contact_thankyou_url = $contact_slug->slug.'/thank-you/'.$allLocation->slug;
					$pages[$add_url.$contact_thankyou_url] = $contact_slug->page_label.' Thankyou Page - '.$allLocation->name;
				}
				
		}			
        
				     
				/*$contact_thanku_page_url = $contact_slug->page.'/send';
				$pages[$add_url.$contact_thanku_page_url] = 'Contact Thank you page';*/
				
				$student_section_thanku_page_url = $contact_slug->page.'/student_send_contact';
				$pages[$add_url.$student_section_thanku_page_url] = 'Student Section Thank you page';
				
				$free_tiral_thanku_page_url = 'starttrialsent?status=suc&mode=free';
				$pages[$add_url.$free_tiral_thanku_page_url] = 'Free Trial Thank you page';



				$paymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1); 
        
				$this->db->where("published", 1);
				$all_dojocart = $this->query_model->getbyTable("tbl_dojocarts");
					foreach ($all_dojocart as $dojocart_list){

						if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1  || $paymentDetail[0]->stripe_payment == 1  || $paymentDetail[0]->stripe_ideal_payment == 1    || $paymentDetail[0]->paypal_payment == 1  ){
				          if (!empty($dojocart_list->payment_type && $dojocart_list->payment_type == 'paid') ) {
				                if( !empty($paymentDetail[0]->authorize_net_payment) && $paymentDetail[0]->authorize_net_payment == 1 ){
				                  $action_value = 'dojocartpayment/authorized_payment_gateway/';
				                }

				                if( !empty($paymentDetail[0]->braintree_payment) && $paymentDetail[0]->braintree_payment == 1 ){
				                  $action_value = 'dojocartpayment/brainTreePaymentGateway/';
				                }
								
								if( !empty($paymentDetail[0]->stripe_payment) && $paymentDetail[0]->stripe_payment == 1 ){
				                  $action_value = 'dojocartpayment/stripe_payment_gateway/';
				                }
								
								if( !empty($paymentDetail[0]->stripe_ideal_payment) && $paymentDetail[0]->stripe_ideal_payment == 1 ){
				                  $action_value = 'dojocartpayment/stripe_ideal_payment_gateway/';
				                }
								
								if( !empty($paymentDetail[0]->paypal_payment) && $paymentDetail[0]->paypal_payment == 1 ){
				                  $action_value = 'dojocartpayment/paypal_payment_gateway/';
				                }
								
				            }else{
				                $action_value = 'dojocartpayment/buyspecial/';
				              }
				      }
				        else{
				          $action_value = 'dojocartpayment/buyspecial/';
				        }


						$dojocart_pages_url = 'promo/'.$dojocart_list->slug;
						$pages[$add_url.$dojocart_pages_url] = 'Dojocart- '.$dojocart_list->product_title;

						/*$dojocart_payment_thanku_page_url = $action_value.$dojocart_list->id;
						$pages[$add_url.$dojocart_payment_thanku_page_url] = 'Dojocart Thank You Page- '.$dojocart_list->product_title;*/
						
						$dojocart_payment_thanku_page_url = 'promo/thank-you/'.$dojocart_list->slug;
						$pages[$add_url.$dojocart_payment_thanku_page_url] = 'Dojocart Thankyou Page- '.$dojocart_list->product_title;
					}
					
				
				/*$authorized_payment_thanku_page_url = 'payment/authorized_payment_gateway';
				$pages[$add_url.$authorized_payment_thanku_page_url] = 'Authorized Payment Thank you page';
				
				$braintree_payment_thanku_page_url = 'payment/brainTreePaymentGateway';
				$pages[$add_url.$braintree_payment_thanku_page_url] = 'BrainTree Payment Thank you page';*/
				
				
                $student_section_news_url = $student_section_slug->slug.'/news';
                $student_section_videos_albums_url = $student_section_slug->slug.'/videos_albums';
                $student_section_videos_url = $student_section_slug->slug.'/videos';
                $student_section_downloads_url = $student_section_slug->slug.'/downloads';
                $student_section_contact_url = $student_section_slug->slug.'/contact';
                $student_section_contact_thankyou_url = $student_section_slug->slug.'/thankyou';
                $student_section_events_url = $events_slug->slug;
                $student_section_referral_rewards_url = $student_section_slug->slug.'/referral_rewards';
                  
                $pages['ALL_Student_Section'] = 'ALL Studentsection';
                $pages[$add_url.$student_section_slug->slug] = 'Studentsection Home';
                $pages[$add_url.$student_section_news_url] = 'Studentsection News';
                $pages[$add_url.$student_section_videos_albums_url] = 'Studentsection Video Album';
                $pages[$add_url.$student_section_videos_url] = 'Studentsection Videos';
                $pages[$add_url.$student_section_downloads_url] = 'Studentsection Download';
                $pages[$add_url.$student_section_events_url] = 'Studentsection Calender';
                $pages[$add_url.$student_section_referral_rewards_url] = 'Studentsection Referral Rewards';
                $pages[$add_url.$student_section_contact_url] = 'Studentsection Contact';
                $pages[$add_url.$student_section_contact_thankyou_url] = 'Studentsection Contact Thankyou Page';
				
				
                
		$blogs_slug = $this->query_model->getbySpecific('tblmeta', 'id', 48);
		$blogs_slug = $blogs_slug[0];
		
		
		$pages[$add_url.$blogs_slug->slug] = $blogs_slug->page_label;
		
		$this->db->order_by("timestamp", "desc"); 
		$blogsLists = $this->query_model->getbySpecific('tblblogs', 'published',1);
		
		foreach($blogsLists as $blogs_list){
			$blog_post_url = $blogs_slug->slug.'/'.$blogs_list->slug;
			$pages[$add_url.$blog_post_url] = $blogs_list->title;
		}			
		//echo '<pre>'; print_r($pages); die;
		return $pages;
}



public function saveWebLeadsOnRainMark($data, $active_rainmaker_tags = null){
		//echo '<pre>data'; print_r($data); die;
		$rainmaker_result = $this->query_model->getbyTable("tblrainmaker");
		
		if($rainmaker_result[0]->multi_rainmaker_check == 1){
				$location_detail = $this->query_model->getLocationIdForRainMarker($data);
			//	$rain_mark = $this->query_model->getbySpecific('tblcontact','id',$data['location_id']);
		}else{
				$location_detail = $rainmaker_result;
		}
		
		
		if(!empty($rainmaker_result)){
			if($rainmaker_result[0]->type == 1 && !empty($location_detail[0]->s_id) && !empty($location_detail[0]->api_key)){
				//echo 'hello===>'.$location_detail[0]->s_id; 
				$RM_SID = trim($location_detail[0]->s_id);
				$RM_APIKEY = trim($location_detail[0]->api_key);
				
				// set form all values in a format way
				$formData = $this->setFormDataValueInFormat($data);
						
				$RM_ACTION = "addWebLead";
				
				$full_name = (isset($formData['name']) && !empty($formData['name'])) ? trim($formData['name']) : '';
				
				$first_name = 'N/A';
				$last_name = 'N/A';
				if(!empty($full_name)){
					$user_full_name = explode(' ',$full_name);
					$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
					
					if(!empty($user_full_name)){
						unset($user_full_name[0]);
					}
					$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
				}
				
				$RM_FNAME = urlencode($first_name);
				$RM_LNAME = urlencode($last_name);
				
				/*if(isset($data['form_email_2'])){
					$RM_EMAIL = $data['form_email_2'];
				}else{
					$RM_EMAIL = $data['email'];
				} */
				$RM_EMAIL = $formData['email'];
				$RM_MOBILE = urlencode($formData['phone']);
				
				//echo $RM_SID.'====>'.$RM_APIKEY;
				
				
				
				
				$RM_INTERESTS = isset($formData['program']) ? $formData['program'] : '';
				/*if(isset($data['program']) && !empty($data['program'])){
					$program_detail = $this->query_model->getbyId("tblprogram", $data['program']);
					if(!empty($program_detail)){
						$RM_INTERESTS = urlencode($program_detail[0]->program);
						//$RM_INTERESTS = str_replace('%27',"'",$RM_INTERESTS);
					}
					
				}*/
				//$data['category_name']===>$data['program_name'];
				
				$RM_LOCATION = isset($formData['location']) ? $formData['location'] : '';
				/*if(isset($data['school_interest']) && !empty($data['school_interest'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','id',$data['school_interest']);
					$RM_LOCATION = urlencode($location_detail[0]->name);
				}
				
				if(isset($data['location_id']) && !empty($data['location_id'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','id',$data['location_id']);
					$RM_LOCATION = urlencode($location_detail[0]->name);
				}
				
				if(isset($data['school']) && !empty($data['school'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','name',$data['school']);
					$RM_LOCATION = urlencode($location_detail[0]->name);
				}*/
				
				$RM_COMMENTS = '';
				if(isset($formData['message']) && !empty($formData['message'])){
					$RM_COMMENTS = urlencode($formData['message']);
				}elseif(isset($formData['program']) && !empty($formData['program'])){
					//$postURL .= "&comments=" . $RM_INTERESTS;
					$RM_COMMENTS = urlencode('Program Of Interest - '.$RM_INTERESTS);
				}elseif(isset($formData['category_name']) && !empty($formData['category_name'])){
					//$postURL .= "&comments=" . $data['category_name'];
					$RM_COMMENTS = urlencode('Category Of Interest - '.$formData['category_name']);
				}elseif(isset($formData['program_name']) && !empty($formData['program_name'])){
					//$postURL .= "&comments=" . $data['program_name'];
					$RM_COMMENTS = urlencode('Program Of Interest - '.$formData['program_name']);
				}
				
				
				$tags = $this->query_model->formModuleTagsInSerializeForApis($active_rainmaker_tags);
				if(!empty($tags)){
					$tags = urlencode($tags);
				}
				
				
				$RM_URL = "https://addmembers.com/RainMaker/api/?";
					
				$postURL = $RM_URL . "action=" . $RM_ACTION . "&SID=" . $RM_SID . "&apikey=" . $RM_APIKEY . "&fname=" . $RM_FNAME;
					$postURL .= "&lname=" . $RM_LNAME . "&email=" . $RM_EMAIL . "&mobile=" . $RM_MOBILE;
					$postURL .= "&comments=" . $RM_COMMENTS;
					$postURL .= "&tags=" . $tags;
				
				//echo '<pre>POST'; print_R($formData);
				//echo $postURL; die;
				$result = $this->query_model->get_rainmark_data($postURL);
				//echo '<prE>result'; print_r($result); die;
				return $result;
				
			}
		}
}


public function saveWebLeadsOnKickSite($data){

		//echo '<pre>old data'; print_R($data); 
		// set form all values in a format way
		$formData = $this->setFormDataValueInFormat($data);
		
		//echo '<pre>new data'; print_R($data); die;
		$kicksite_result = $this->query_model->getbyTable("tbl_kicksite");

		if (!empty($kicksite_result)) {	
			if($kicksite_result[0]->multi_kicksite_check == 1){

					$location_detail = $this->query_model->getLocationIdForKickSite($data);
			}else{

					$location_detail = $kicksite_result;
			}
		}
		
		

		$PROGRAM_INTERESTS = isset($formData['program']) ? $formData['program'] : '';
		/*if(isset($data['program']) && !empty($data['program'])){
			$program_detail = $this->query_model->getbyId("tblprogram", $data['program']);
			if(!empty($program_detail)){
				$PROGRAM_INTERESTS = $program_detail[0]->program;
				
			}
			
		}*/
		//echo $PROGRAM_INTERESTS;
		//echo '<pre>formData'; print_r($formData); die;
		//echo '<pre>location_detail'; print_r($location_detail); die;
		if(!empty($kicksite_result)){

			if($kicksite_result[0]->type == 1 && !empty($location_detail[0]->ks_url) && !empty($location_detail[0]->ks_token)){

				$ks_url = trim($location_detail[0]->ks_url);
				$ks_token = trim($location_detail[0]->ks_token);
				//echo $ks_token; die;
				
				$full_name = (isset($formData['name']) && !empty($formData['name'])) ? trim($formData['name']) : '';
				
				$first_name = 'Website Dojo';
				$last_name = 'Leads';
				if(!empty($full_name)){
					$user_full_name = explode(' ',$full_name);
					$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
					
					if(!empty($user_full_name)){
						unset($user_full_name[0]);
					}
					$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
				}
				
				$ks_fname = $first_name;
				$ks_lname = $last_name;
				$ks_email = $formData['email'];
				
				

				$ks_mobile = (isset($formData['phone']) && !empty($formData['phone'])) ? str_replace(' ','',$formData['phone']) : '';

				$address1 = isset($data['address'])? $data['address'] : '';

				$address2 = isset($data['address_line2'])? $data['address_line2'] : '';

				$city = isset($data['city'])? $data['city'] : '';

				$state = isset($data['state'])? $data['state'] : '';

				$zip = isset($data['zip'])? $data['zip'] : '';

			
			if(!empty($ks_fname)){
				/*$data = array(
					"token" => $ks_token, 
					"first_name" => $ks_fname, 
					"last_name" => $ks_lname,
					 //"academy" => $PROGRAM_INTERESTS,
					 //"extra_info" => $PROGRAM_INTERESTS, 
					 "email" => $ks_email, 
					 "phone" => $ks_mobile,
					 "comments" => $PROGRAM_INTERESTS,
					 "address" => array(
						 	"street" => $address1, 
						 	"street2" => $address2,
						 	"city" => $city,
						 	"state" => $state,
						 	"zip" => $zip
					 	)
					 );*/
					 
					
			}else{
				/*$ks_fname = 'Null';
				$data = array(
					"token" => $ks_token, 
					"first_name" => $ks_fname, 
					 "email" => $ks_email,
					 "comments" => $PROGRAM_INTERESTS,
					 );*/
					 
				
			}
			
			$data = array(
					//'k_2f4a1fe8879efb771a214d55c2a7c49e4cb657a0_3389' => '',
					'token' => $ks_token,
					'bizbuilder_form_order' => array(
							'bizbuilder_form_order_items_attributes'=> array(
								'0' => array(
									'person_attributes' => array(
										'first_name'=>$ks_fname,
										'last_name'=>$ks_lname,
										'contact_info_attributes'=> array(
												'email_addresses_attributes' => array(
													'address' =>$ks_email
													),
												'phone_numbers_attributes' => array(
													'number' =>$ks_mobile
													)
												),
										)
									)
								)
							),
					'commit' => 'Submit'
					 );
				
			
				
				//$data_string = json_encode($data);
				
				$data_string = urldecode(http_build_query($data));
				
				$ch = curl_init($ks_url);                                                                     
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);                                                                      
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                                                                      
				/*curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
				    'Content-Type: application/json',                                                                                
				    'Content-Length: ' . strlen($data_string))                                                                       
				);  */
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));				
				                                                                                                                     
				$result = curl_exec($ch);
				$err = curl_error($ch);

				curl_close($ch);
				//echo '<pre>'; print_r($result); die;


				}
			}


}

public function Check_KickSiteOn(){
	$kicksite = $this->query_model->getbyTable("tbl_kicksite");
		if(!empty($kicksite)){
			$check_type = $kicksite[0]->type;
		}else{
			$check_type = 0;
		}
	
	return $check_type;

	}


public function get_rainmark_data($url){
		//echo $url; die;
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
}


public function getLocationIdForRainMarker($data){
			if(!empty($data)){
				$location_detail = '';
				if(isset($data['school_interest']) && !empty($data['school_interest'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','id',$data['school_interest']);
				}elseif(isset($data['location_id']) && !empty($data['location_id'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','id',$data['location_id']);
				}elseif(isset($data['school']) && !empty($data['school'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','name',$data['school']);
				}
				//echo '<pre>'; print_r($location_detail); die;
				return $location_detail;
			}
}

public function getLocationIdForKickSite($data){
	
			if(!empty($data)){
				$location_detail = '';
				if(isset($data['school_interest']) && !empty($data['school_interest'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','id',$data['school_interest']);
				}elseif(isset($data['location_id']) && !empty($data['location_id'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','id',$data['location_id']);
				}elseif(isset($data['school']) && !empty($data['school'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','name',$data['school']);
				}
				
				return $location_detail;
			}
}




public function getChangeUrl($url){
		
		
	if(!empty($url)){
		$trial_offer_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$trial_offer_slug = $trial_offer_slug[0];
		
		$setting = $this->query_model->getbyTable('tblsite');
		$setting = $setting[0];
		
		if (preg_match('/~/',$url)){
			$link = explode('/',$url);
			unset($link[0]);
			unset($link[1]);
			unset($link[2]);
			unset($link[3]);
			
			if($trial_offer_slug->slug == $link[4]){
				$offer_url = '';
				if($setting->tiral_url_type == 1){
					$main_link = $setting->another_trial_url;
				}else{
					$main_link  = base_url().implode('/',$link); 
				}
			}else{
				$main_link  = base_url().implode('/',$link); 
			}
		//	echo '<pre>';print_r( $link); echo '<br>'; 
			return $main_link;
		}else{
			$link = explode('/',$url);
			unset($link[0]);
			unset($link[1]);
			unset($link[2]);
			
			if($trial_offer_slug->slug == $link[3]){
				$offer_url = '';
				if($setting->tiral_url_type == 1){
					$main_link = $setting->another_trial_url;
				}else{
					$main_link  = base_url().implode('/',$link); 
				}
			}else{
				$main_link  = base_url().implode('/',$link); 
			}
			
				
			
			return $main_link;
		}
	} else{
		return '';
	}

}


public function getRefferalUrl(){
		if($this->session->userdata('refferal_url') != ''){
			return $this->session->userdata('refferal_url');
		} else{
			return base_ur();
		}
}


public function getSiteSetting(){
		//	$filePath = $this->session->userdata('refferal_url').'siteservices/getSettingData';
			//echo $filePath; die;
		//	 $setting = file_get_contents($filePath);
			// print_r($setting); die;
			$setting = $this->query_model->getbyTable("tblsite");
   			 return $setting;
}


public function getSchoolDetail(){
			
			 if(isset($_POST['location_id'])){

				$contact_detail = $this->query_model->getbySpecific('tblcontact', 'id', $_POST['location_id']);
		
			} else{
		
				$contact_detail = $this->query_model->getMainLocation();
			}
			
			return $contact_detail; 
}


public function getTrialOfferDetail(){
			
			if(!empty($_POST['trial_id'])){
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				
				$offer_detail = $this->query_model->getbySpecific("$tblspecialoffer", 'id', $_POST['trial_id']);
				return $offer_detail;
			}else{
				return '';
			}
}


public function getStrReplace($data){
			$metaVaribles = $this->getbyId('tblmetavariable',1);
			
			$this->db->where("published", 1);
			$allLocations = $this->getbyTable("tblcontact");
			$allLocations = count($allLocations);
			foreach($metaVaribles as $metaVarible){
				$school_name = $metaVarible->meta_school_name;
				$city = $metaVarible->meta_city;
				$state = $metaVarible->meta_state;
				$city_state = $metaVarible->meta_city_state;
				$nearby_location1 = $metaVarible->meta_nearbylocation1;
				$nearby_location2 = $metaVarible->meta_nearbylocation2;
				$county = $metaVarible->meta_county;
				$main_martial_arts_style = $metaVarible->meta_main_martial_arts_style;
				$martial_arts_style = $metaVarible->meta_martial_arts_style;
				$trial_offer1 = $metaVarible->trial_offer1;
				$trial_offer2 = $metaVarible->trial_offer2;
				$main_instructor = $metaVarible->main_instructor;
				$est_year = $metaVarible->est_year;
				$current_location = $metaVarible->current_location;
				$url = $metaVarible->url;
				$street = $metaVarible->street;
				$suite = $metaVarible->suite;
				$zip = $metaVarible->zip;
				$phone = $metaVarible->phone;
			}
			
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			
			$content = str_replace(array('{school_name}','{city}','{state}','{city_state}','{nearby_location1}','{nearby_location2}','{county}','{main_martial_arts_style}','{martial_arts_style}','{locations_number} ','{trial_offer1}','{trial_offer2}','{main_instructor}','{est_year}','{current_location}','{url}','{street}','{suite}','{zip}','{phone}','{currency}'), array($school_name,$city,$state,$city_state,$nearby_location1,$nearby_location2,$county,$main_martial_arts_style,$martial_arts_style,$allLocations, $trial_offer1, $trial_offer2, $main_instructor, $est_year,$current_location,$url,$street,$suite,$zip,$phone,$site_currency_type), $data);
			
			
			$content = htmlspecialchars_decode($content);
			
			echo $content;
	}


public function getDescReplace($data,$is_nested_location = 0,$location_id = 0){
	
			$metaVaribles = $this->getbyId('tblmetavariable',1);
			
			$this->db->where("published", 1);
			$allLocations = $this->getbyTable("tblcontact");
			$allLocations = count($allLocations);
			
			$location_detail = array();
			if($is_nested_location == 1 && $location_id > 0){
				$this->db->select(array('id','name','slug','address','suite','city','state','zip','phone','email'));
				$this->db->where('published',1);
				$this->db->where('school_location_type','nested');
				$location_detail = $this->query_model->getBySpecific('tblcontact','id',$location_id);
				if(!empty($location_detail)){
					$location_detail = $location_detail[0];
				}
			}
			
			
			foreach($metaVaribles as $metaVarible){
				
				$school_name = !empty($location_detail) ? $location_detail->name: $metaVarible->meta_school_name;
				
				$state = !empty($location_detail) ? $location_detail->state: $metaVarible->meta_state;
				$city_state = $metaVarible->meta_city_state;
				$nearby_location1 = $metaVarible->meta_nearbylocation1;
				$nearby_location2 = $metaVarible->meta_nearbylocation2;
				$county = $metaVarible->meta_county;
				$main_martial_arts_style = $metaVarible->meta_main_martial_arts_style;
				$martial_arts_style = $metaVarible->meta_martial_arts_style;
				
				$trial_offer1 = $metaVarible->trial_offer1;
				$trial_offer2 = $metaVarible->trial_offer2;
				$main_instructor = $metaVarible->main_instructor;
				$est_year = $metaVarible->est_year;
				$city = !empty($location_detail) ? $location_detail->city: $metaVarible->meta_city;
				$current_location = $metaVarible->current_location;
				$url = $metaVarible->url;
				$street = !empty($location_detail) ? $location_detail->address: $metaVarible->street;
				$suite = !empty($location_detail) ? $location_detail->suite: $metaVarible->suite;
				$zip = !empty($location_detail) ? $location_detail->zip: $metaVarible->zip;
				$phone =  !empty($location_detail) ? $location_detail->phone: $metaVarible->phone;
				
			}
			
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			
			$currentLocationDetail = $this->query_model->getCurrentLocationCityStateName();
			$current_city_state = isset($currentLocationDetail['current_city_state']) ? $currentLocationDetail['current_city_state'] : '';
			
			$content = str_replace(array('{school_name}','{city}','{state}','{city_state}','{nearby_location1}','{nearby_location2}','{county}','{main_martial_arts_style}','{martial_arts_style}','{locations_number}','{trial_offer1}','{trial_offer2}','{main_instructor}','{est_year}','{current_location}','{url}','{street}','{suite}','{zip}','{phone}','{CITY, ST}','{currency}'), array($school_name,$city,$state,$city_state,$nearby_location1,$nearby_location2,$county,$main_martial_arts_style,$martial_arts_style,$allLocations, $trial_offer1, $trial_offer2, $main_instructor, $est_year,$current_location,$url,$street,$suite,$zip,$phone,$current_city_state,$site_currency_type), $data);
			
			$content = htmlspecialchars_decode($content);
			
			echo $content;
	}
	



public function getShortDescReplace($data, $data_limit){
			$metaVaribles = $this->getbyId('tblmetavariable',1);
			
			$this->db->where("published", 1);
			$allLocations = $this->getbyTable("tblcontact");
			$allLocations = count($allLocations);
			foreach($metaVaribles as $metaVarible){
				$school_name = $metaVarible->meta_school_name;
				$city = $metaVarible->meta_city;
				$state = $metaVarible->meta_state;
				$city_state = $metaVarible->meta_city_state;
				$nearby_location1 = $metaVarible->meta_nearbylocation1;
				$nearby_location2 = $metaVarible->meta_nearbylocation2;
				$county = $metaVarible->meta_county;
				$main_martial_arts_style = $metaVarible->meta_main_martial_arts_style;
				$martial_arts_style = $metaVarible->meta_martial_arts_style;
				$trial_offer1 = $metaVarible->trial_offer1;
				$trial_offer2 = $metaVarible->trial_offer2;
				$main_instructor = $metaVarible->main_instructor;
				$est_year = $metaVarible->est_year;
				$current_location = $metaVarible->current_location;
				$url = $metaVarible->url;
				$street = $metaVarible->street;
				$suite = $metaVarible->suite;
				$zip = $metaVarible->zip;
				$phone = $metaVarible->phone;
			}
			
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			
			$content = str_replace(array('{school_name}','{city}','{state}','{city_state}','{nearby_location1}','{nearby_location2}','{county}','{main_martial_arts_style}','{martial_arts_style}','{locations_number} ','{trial_offer1}','{trial_offer2}','{main_instructor}','{est_year}','{current_location}','{url}','{street}','{suite}','{zip}','{phone}','{currency}'), array($school_name,$city,$state,$city_state,$nearby_location1,$nearby_location2,$county,$main_martial_arts_style,$martial_arts_style,$allLocations, $trial_offer1, $trial_offer2, $main_instructor, $est_year,$current_location,$url,$street,$suite,$zip,$phone,$site_currency_type), $data);
			
			$content = htmlspecialchars_decode($content);
			
			if(strlen($content) > $data_limit){
				$content = substr($content, 0, $data_limit);
				$content = $content;
			}
			echo $content;
	}

public  function getTrialOfferUrl($main_url){
	
		$newBaseUrl = $this->query_model->getBaseUrl();
		$setting = $this->query_model->getbyTable('tblsite');
		$setting = $setting[0];
		$offer_url = '';
			if($setting->tiral_url_type == 1){
				$offer_url = $setting->another_trial_url;
			}else{
				if($setting->link_third_party_url == 1){
					$offer_url = $main_url;
				}else{
					$offer_url = $newBaseUrl.$main_url;
				}
			}
			
			return $offer_url;
			
}


public function getSocialIcons(){
			$social_detail =$this->query_model->getbyTable("tblconfigcalendar");
			//echo '<pre>'; print_r($social_detail); die;
			$social_icon_data = '';
			if($social_detail[8]->field_value == 1){
				$social_icon_data = $this->query_model->getMainLocation();
			}else{
				$social_icon_data = $this->query_model->getbyTable("tblsite");
			}
			
			
			return $social_icon_data;
}

public function getSocialContactIcons($location_data){
			$social_detail =$this->query_model->getbyTable("tblconfigcalendar");
			//echo '<pre>'; print_r($social_detail); die;
			$social_icon_data = '';
			if($social_detail[8]->field_value == 1){
				$social_icon_data = $location_data;
			}else{
				$social_icon_data = $this->query_model->getbyTable("tblsite");
				$social_icon_data = $social_icon_data[0];
			}
			//echo '<pre>'; print_r($social_icon_data); die;
			
			return $social_icon_data;
}


public function getSliderImageWithVideo($id){
			if(!empty($id)){
				$sliderData = $this->query_model->getbySpecific('tblslider','id',$id);
				
				if(!empty($sliderData)){
						$slider_image = '';
					
						if($sliderData[0]->image_video == 'image'){
						
							$slider_image = $sliderData[0]->photo;
						
						}elseif($sliderData[0]->image_video == 'video'){
						
							
						
							if($sliderData[0]->video_img_type == 'upload_image'){
						
								$slider_image =$sliderData[0]->custom_video_thumbnail;
						
							}else if($sliderData[0]->video_img_type == 'automatically'){
							
								$slider_image = 'upload/slider_video/'.$sliderData[0]->videoimage;
							
							}
							
						}else{
							$slider_image = '';
						}
					
					return $slider_image;
							
				} else{
					return $slider_image;
				}
				
			}else{
				return $slider_image;
			}
}


public function getAllReguralLocations(){
				$this->db->where("published", 1);
				$this->db->where("location_type", 'regular_link');
				$this->db->order_by("pos","asc");
				$allLocations = $this->query_model->getbyTable("tblcontact");
				
				return $allLocations;
}



public function checkInternationalPhoneField(){
    
    $setting = $this->query_model->getbyTable("tblsite");
    
        $phone_validation_class = 'off';
        if($setting[0]->international_phone_fields == 1){
            $phone_validation_class = 'on';    
        }else{
            $phone_validation_class = 'off';
        }
    return $phone_validation_class;
}


public function getBaseUrl(){
	
	//$base_url = base_url();
	//$url = str_replace('https','https',$base_url);
	$url = base_url();
	
	return $url;
}


public function get_percent( $price, $sales_tax){
	$total = ($price*$sales_tax)/100;
	$total = $price+$total;
	return $total; 

}

public function getOrderEmailInfo($email, $name,$page_url = null,$order_id = null){
	/*
		$currentDate = date("Y-m-d h:i:s");
		$lastDate = date("Y-m-d h:i:s", strtotime("-5 minutes", strtotime($currentDate)));
		
		if(!empty($order_id)){
			$this->db->where( array( 'email'=> $email,'is_delete' => 0, 'offer_type' =>null, 'created >=' => $lastDate) );
		}else{
			$this->db->where( array( 'email'=> $email, 'name'=> $name, 'is_delete' => 0, 'offer_type' =>null, 'created >=' => $lastDate) );
		}
		
		$result = $this->db->get('tblorders')->result();
		
		if(!empty($result)){
			foreach($result as $res){
				
				$data = array('is_delete' => 1);
				
				if(!empty($order_id)){
					if($order_id != $res->id){
						if($page_url == $res->page_url){
							$this->db->where('id',$res->id);
							$this->db->update('tblorders', $data);
						}
						
					}
				}else{
					$this->db->where('id',$res->id);
					$this->db->update('tblorders', $data);
				}
				
			}
		}*/
	}
	
public function checkLocationUrl($location_slug){
	$response = 0;
	if(!empty($location_slug))
	{
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		$multiLocation = $multiLocation[0];
		
		
		if($multiLocation->field_value == 1)
		{
			$this->db->where("slug", $location_slug);
			$result = $this->query_model->getbyTable("tblcontact");
			
			$response = !empty($result) ? 1 : 0;
		}else{
			$result = $this->query_model->getMainLocation("tblcontact");
			$city_name = strtolower(str_replace('-',' ',$location_slug));
			$response = (strtolower($result[0]->city) == $city_name) ? 1 : 0;
			
		}
		
	}
	return $response;
}

	
	

public function getMetaDescReplace($data){
		$content = '';
			$metaVaribles = $this->getbyId('tblmetavariable',1);
			
			$this->db->where("published", 1);
			$allLocations = $this->getbyTable("tblcontact");
			$allLocations = count($allLocations);
			
			
			foreach($metaVaribles as $metaVarible){
				$school_name = $metaVarible->meta_school_name;
				
				$state = $metaVarible->meta_state;
				$city_state = $metaVarible->meta_city_state;
				$nearby_location1 = $metaVarible->meta_nearbylocation1;
				$nearby_location2 = $metaVarible->meta_nearbylocation2;
				$county = $metaVarible->meta_county;
				$main_martial_arts_style = $metaVarible->meta_main_martial_arts_style;
				$martial_arts_style = $metaVarible->meta_martial_arts_style;
				
				$trial_offer1 = $metaVarible->trial_offer1;
				$trial_offer2 = $metaVarible->trial_offer2;
				$main_instructor = $metaVarible->main_instructor;
				$est_year = $metaVarible->est_year;
				$city = $metaVarible->meta_city;
				$current_location = $metaVarible->current_location;
				$url = $metaVarible->url;
				$street = $metaVarible->street;
				$suite = $metaVarible->suite;
				$zip = $metaVarible->zip;
				$phone = $metaVarible->phone;
				
			}
			
			$site_currency_type = $this->query_model->getSiteCurrencyType();
			$site_base_url = base_url();
			
			$content = str_replace(array('{school_name}','{city}','{state}','{city_state}','{nearby_location1}','{nearby_location2}','{county}','{main_martial_arts_style}','{martial_arts_style}','{locations_number}','{trial_offer1}','{trial_offer2}','{main_instructor}','{est_year}','{current_location}','{url}','{street}','{suite}','{zip}','{phone}','{currency}','{base_url}'), array($school_name,$city,$state,$city_state,$nearby_location1,$nearby_location2,$county,$main_martial_arts_style,$martial_arts_style,$allLocations, $trial_offer1, $trial_offer2, $main_instructor, $est_year,$current_location,$url,$street,$suite,$zip,$phone,$site_currency_type,$site_base_url), $data);
			
			
			
			$content = htmlspecialchars_decode($content);
			
			return  $content;
	}
	
	
public function getMetaTitleForAboutUs($location_slug){
	$result = array();
	if(!empty($location_slug))
	{
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		$multiLocation = $multiLocation[0];
		
		
		if($multiLocation->field_value == 1)
		{
			$this->db->where("slug", $location_slug);
			$locationDetail = $this->query_model->getbyTable("tblcontact");
			
			if(!empty($locationDetail)){
				$this->db->where("location_id", $locationDetail[0]->id);
				$result = $this->query_model->getbyTable("tblaboutheader");
			}
		}
		
	}
	
	return $result;
}

	public function getOgImagePath($ogDefaultImgPath, $page_info)
	{
		
		$ogImgPath = '';
		if(isset($page_info['page']) && $page_info['page'] == 'blogs' && isset($this->uri->segments[2])){
			
			$blog_slug = isset($this->uri->segments[2]) && !empty($this->uri->segments[2]) ? urldecode($this->uri->segments[2]) : '';
			
			if(!empty($blog_slug)){
				$this->db->where('slug',$blog_slug);
				$blogDetail = $this->query_model->getbyTable('tblblogs');
				$ogImgPath = (!empty($blogDetail) && !empty($blogDetail[0]->image)) ? base_url().$blogDetail[0]->image : $ogDefaultImgPath;
			}else{
				$ogImgPath = $ogDefaultImgPath;
			}
		}else{
				$ogImgPath = $ogDefaultImgPath;
		}
		
		return $ogImgPath;
	}
	
	
	public function getOgTitle($ogDefaultTitle, $page_info)
	{
		
		$ogTitle = '';
		if(isset($page_info['page']) && $page_info['page'] == 'blogs' && isset($this->uri->segments[2])){
			
			$blog_slug = isset($this->uri->segments[2]) && !empty($this->uri->segments[2]) ? urldecode($this->uri->segments[2]) : '';
			
			if(!empty($blog_slug)){
				$this->db->where('slug',$blog_slug);
				$blogDetail = $this->query_model->getbyTable('tblblogs');
				$ogTitle = (!empty($blogDetail) && !empty($blogDetail[0]->title)) ? $blogDetail[0]->title : $ogDefaultTitle;
			}else{
				$ogTitle = $ogDefaultTitle;
			}
		}else{
				$ogTitle = $ogDefaultTitle;
		}
		
		return $ogTitle;
	}
	
	
	
	public function getOgDesc($ogDefaultDesc, $page_info)
	{
		
		$ogDesc = '';
		if(isset($page_info['page']) && $page_info['page'] == 'blogs' && isset($this->uri->segments[2])){
			
			$blog_slug = isset($this->uri->segments[2]) && !empty($this->uri->segments[2]) ? urldecode($this->uri->segments[2]) : '';
			
			if(!empty($blog_slug)){
				$this->db->where('slug',$blog_slug);
				$blogDetail = $this->query_model->getbyTable('tblblogs');
				$description = ($blogDetail) ? $this->query_model->getMetaDescReplace(  $blogDetail[0]->content) : ''; 
				$description = !empty($description) ? strip_tags($description) : $ogDefaultDesc;
				$ogDesc = $description;
			}else{
				$ogDesc = $ogDefaultDesc;
			}
		}else{
				$ogDesc = $ogDefaultDesc;
		}
		
		return $ogDesc;
	}
	
	public function getOgUrl($ogDefaultUrl, $page_info)
	{
		
		$ogUrl = '';
		if(isset($page_info['page']) && $page_info['page'] == 'blogs' && isset($this->uri->segments[2])){
			
			$blog_slug = isset($this->uri->segments[2]) && !empty($this->uri->segments[2]) ? urldecode($this->uri->segments[2]) : '';
			
			if(!empty($blog_slug)){
				$this->db->where('slug',$blog_slug);
				$blogDetail = $this->query_model->getbyTable('tblblogs');
				$ogUrl = (!empty($blogDetail) && !empty($blogDetail[0]->slug)) ? base_url().'blog/'.$blogDetail[0]->slug : $ogDefaultUrl;
			}else{
				$ogUrl = $ogDefaultUrl;
			}
		}else{
				$ogUrl = $ogDefaultUrl;
		}
		
		return $ogUrl;
	}
	
	public function changeVideoImgPathHttp($cover_image){
		$query = $this->db->get_where('tblsite', array( 'id' => 1));
		$site_settings = $query->row_array();
		$check_http = $site_settings['https'];
		
		$imagePath = $cover_image;
		if($check_http == 1){
			$imagePath = str_replace('http://','https://',$cover_image);
		}else{
			$imagePath = str_replace('https://','http://',$cover_image);
		}
		
		return $imagePath;

	}
	
	public function getContactMainLocationSlug(){
		$slug = '';
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		$mainLocation = $this->query_model->getMainLocation();
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$multiSchool = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		$multiAbout = $this->query_model->getbyTable("tblconfigcalendar");
		$multiAbout = isset($multiAbout[1]) ? $multiAbout[1]->field_value : 0;
		
		if(!empty($mainLocation)){
			if($multiLocation[0]->field_value == 1 && $multiSchool == 0 && $multiAbout == 1){
				$slug = $mainLocation[0]->slug;
			}else{
				$slug = str_replace(' ','-',strtolower($mainLocation[0]->city));
			}
		}
		
		
		return $slug;
	}

	
	public function saveWebLeadsOnActiveCampaign($data, $active_campaign_tags = null, $formModelDetail)
	{
		
			$activeCampaignResult = $this->query_model->getbyTable("tbl_active_campaign");
			
			if(!empty($activeCampaignResult) && $activeCampaignResult[0]->type == 1)
			{
				
				// set form all values in a format way
				$formData = $this->setFormDataValueInFormat($data);
				//echo "<pre>formData"; print_r($formData); die;
				// saving contact on active campaign
				$saveContact = $this->saveActiveCampaignContact($formData, $activeCampaignResult, $active_campaign_tags, $formModelDetail);
			}	
		
	}
	
	public function setFormDataValueInFormat($data){
		
		$result = array();
		
			$result['name'] = isset($data['name']) ? $data['name'] : '';
			$result['last_name'] = isset($data['last_name']) ? $data['last_name'] : '';
			if(isset($data['form_email_2'])){
				$result['email'] = $data['form_email_2'];
			}else{
				$result['email'] = $data['email'];
			} 
			$result['phone'] = isset($data['phone']) ? $data['phone'] : '';
			
			$result['program'] = '';
				if(isset($data['program']) && !empty($data['program'])){
					$program_detail = $this->query_model->getbyId("tblprogram", $data['program']);
					if(!empty($program_detail)){
						$result['program'] = $program_detail[0]->program;
						$result['program_id'] = $program_detail[0]->id;
						//$RM_INTERESTS = str_replace('%27',"'",$RM_INTERESTS);
					}
					
				}elseif(isset($data['program_id']) && !empty($data['program_id'])){
					$program_detail = $this->query_model->getbyId("tblprogram", $data['program_id']);
					
					if(!empty($program_detail)){
						$result['program'] = $program_detail[0]->program;
						$result['program_id'] = $program_detail[0]->id;
						//$RM_INTERESTS = str_replace('%27',"'",$RM_INTERESTS);
					}
					
				}elseif(isset($data['category_name']) && !empty($data['category_name'])){
					$result['program'] = $data['category_name'];
				}elseif(isset($data['program_name']) && !empty($data['program_name'])){
					$result['program'] = $data['program_name'];
					$program_detail = $this->query_model->getBySpecific("tblprogram",'program', $data['program_name']);
					
					if(!empty($program_detail)){
						$result['program_id'] = $program_detail[0]->id;
						
					}
				}
				
				$result['location'] = '';
				$result['selected_location_id'] = '';
				if(isset($data['school_interest']) && !empty($data['school_interest'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','id',$data['school_interest']);
					$result['location'] = !empty($location_detail) ? $location_detail[0]->name : '';
					$result['selected_location_id'] = !empty($location_detail) ? $location_detail[0]->id : '';
				}
				
				if(isset($data['location_id']) && !empty($data['location_id'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','id',$data['location_id']);
					$result['location'] = !empty($location_detail) ? $location_detail[0]->name : '';
					$result['selected_location_id'] = !empty($location_detail) ? $location_detail[0]->id : '';
				}
				
				if(isset($data['school']) && !empty($data['school'])){
					$location_detail = $this->query_model->getbySpecific('tblcontact','name',$data['school']);
					$result['location'] = !empty($location_detail) ? $location_detail[0]->name : '';
					$result['selected_location_id'] = !empty($location_detail) ? $location_detail[0]->id : '';
				}
				
				if(empty($result['location'])){
					$main_location =$this->query_model->getMainLocation("tblcontact");
					$result['location'] = !empty($main_location) ? $main_location[0]->name : '';
					$result['selected_location_id'] = !empty($main_location) ? $main_location[0]->id : '';
				}
				
				$result['trial_offer_id'] = (isset($data['trial_offer_id']) && !empty($data['trial_offer_id'])) ? $data['trial_offer_id'] : '';
				$result['send_trial_cat_tag_ac'] = (isset($data['send_trial_cat_tag_ac']) && !empty($data['send_trial_cat_tag_ac'])) ? 1 : 0;
				
				$result['active_campaign_location'] = '';
				$result['active_campaign_trial_type'] = '';
				$result['active_campaign_program'] = '';
				
				
				$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
				//$mainLocation = $this->query_model->getMainLocation("tblcontact");
				$multiSchoolOrLocation = $this->query_model->checkMultiSchoolOrLocationIsOn();
				
				if($multiLocation[0]->field_value == 1){
					$data['send_location'] = ($multiSchoolOrLocation == 1) ? 1 : 0;
					if(isset($data['send_location']) && $data['send_location'] == 0){
						$result['active_campaign_location'] = '';
					}else{
						$result['active_campaign_location'] = $result['location'];
					}
				}
				
				
				if(isset($data['send_trial_ac']) && $data['send_trial_ac'] == 1){
					if(isset($data['trial_id']) && !empty($data['trial_id'])){
						$trialOfferDetail = $this->query_model->getbySpecific($this->query_model->getTrialSpecialOffersTableName(),'id',$data['trial_id']);
						if(!empty($trialOfferDetail)){
							$result['active_campaign_trial_type'] = ($trialOfferDetail[0]->trial == 1) ? $this->query_model->getStaticTextTranslation('paid') : $this->query_model->getStaticTextTranslation('free');
						}
					}
				}
				
				if(isset($data['send_program_ac']) && $data['send_program_ac'] == 1){
					$result['active_campaign_program'] = $result['program'];
				}
				
				
				$result['call_or_schedule'] = '';
				$result['reserve_or_schedule'] = '';
				$result['program_type'] = '';
				if(isset($data['program_type']) && !empty($data['program_type'])){
					
					$result['program_type'] = $data['program_type'];
					
					if($data['program_type'] == "summer_camp"){
						if(isset($data['reserve_or_schedule']) && !empty($data['reserve_or_schedule'])){
							$result['reserve_or_schedule'] = $data['reserve_or_schedule'];
						}
					}elseif( $data['program_type'] == "birthday_page"){
						if(isset($data['call_or_schedule']) && !empty($data['call_or_schedule'])){
							$result['call_or_schedule'] = $data['call_or_schedule'];
						}
					}
				}
				
				if(isset($data['child_name']) ){
					$result['child_name'] = $data['child_name'];
				}
				
				if(isset($data['child_age']) ){
					$result['child_age'] = $data['child_age'];
				}
				
				if(isset($data['send_program_ac']) && $data['send_program_ac'] == 1){
					$result['active_campaign_program'] = $result['program'];
				}
				
				if(isset($data['amount']) ){
					$result['total_amount'] = $data['amount'];
				}
				
				if(isset($data['trial_id']) && !empty($data['trial_id']) ){
					$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
					$offer_detail = $this->query_model->getbySpecific("$tblspecialoffer", 'id' , $data['trial_id']);
					$result['trial_name'] = !empty($offer_detail) ? $offer_detail[0]->offer_title : '';
					$result['trial_type'] = (!empty($offer_detail) && $offer_detail[0]->trial == 1) ? 'Paid'  : 'Free';
				}
				
				
				$result['message'] = '';
				if(isset($data['message']) && !empty($data['message'])){
					$result['message'] = $data['message'];
				}elseif(isset($data['program']) && !empty($data['program'])){
					//$postURL .= "&comments=" . $RM_INTERESTS;
					$result['message'] = $result['program'];
				}elseif(isset($data['category_name']) && !empty($data['category_name'])){
					//$postURL .= "&comments=" . $data['category_name'];
					$result['message'] = $this->query_model->getStaticTextTranslation('category_interest').' - '.$data['category_name'];
				}elseif(isset($data['program_name']) && !empty($data['program_name'])){
					//$postURL .= "&comments=" . $data['program_name'];
					$result['message'] = $this->query_model->getStaticTextTranslation('program_interest').' - '.$data['program_name'];
				}
				
			$result['twilio_checkbox'] = isset($data['twilio_checkbox']) ? 1 : 0;
		
		return $result;
	}
	
	
	public function saveActiveCampaignContact($formData, $activeCampaign, $active_campaign_tags = null, $formModelDetail)
	{
	
	
		
		
		//$url = 'http://account.api-us1.com';
		$url = 'http://'.$activeCampaign[0]->account_name.'.api-us1.com';
		
		$customFields = $this->getActiveCampaignCustomFields($activeCampaign);
		
		$exitContact = $this->checkActiveCampaignContactExists($activeCampaign, $formData['email']);
		
		
		$extraTags = array();
		if(isset($formData['send_trial_cat_tag_ac']) && $formData['send_trial_cat_tag_ac'] == 1){
			if(isset($formData['trial_offer_id']) && !empty($formData['trial_offer_id'])){
				$extraTags = $this->getProgramCategoryTagsByTrialCatId($formData['trial_offer_id']);
			}
		}
		/*echo '<pre>extraTags'; print_r($extraTags); 
		echo '<pre>formData'; print_r($formData);
		echo '<pre>activeCampaign'; print_r($activeCampaign);
		echo '<pre>active_campaign_tags'; print_r($active_campaign_tags);
		echo '<pre>formModelDetail'; print_r($formModelDetail); die;   */
		
		if($exitContact['contactExit'] == 1){
			
			if(!empty($exitContact['tags'])){
				// remove old tags of this contact
				//$removeContactOldTags = $this->removeActiveCampaignContactOldTags($activeCampaign, $exitContact['contactId'],$exitContact['tags']);
			}
			
					$params = array(

						'api_key'      =>  $activeCampaign[0]->api_key,
						'api_action'   => 'contact_edit',
						'api_output'   => 'serialize',
						//'overwrite'    =>  0,
					);
					
					$tags = $this->query_model->formModuleTagsInSerializeForApis($active_campaign_tags);
					
					if(!empty($extraTags)){
						if(!empty($tags)){
							$alltags = $tags.','.$extraTags;
							$alltags = explode(',',$alltags);
							if(!empty($alltags)){
								foreach($alltags as $alltag){
									$tagList[$alltag] = $alltag;
								}
								$tags = implode(',',$tagList);
							}
						}else{
							$tags = $extraTags;
						}
					}
					
					/*$twilioApi = $this->query_model->getTwilioApiType();
					if(isset($formData['twilio_checkbox']) && $formData['twilio_checkbox'] == 1){
						if(!empty($twilioApi) && $twilioApi->type == 1){
							
							$this->query_model->sendMsgToTwilioApi($formData,$twilioApi);
							
							
							if(!empty($tags)){
								$tags = $tags.','.$twilioApi->ac_tag_name;
							}else{
								$tags = $twilioApi->ac_tag_name;
							}
						}
						
					}*/
					//echo "<pre>formData"; print_r($twilioApi); 
					//echo $tags; die;
					
					$full_name = (isset($formData['name']) && !empty($formData['name'])) ? trim($formData['name']) : '';
				
					$first_name = 'N/A';
					$last_name = 'N/A';
					if(!empty($full_name)){
						$user_full_name = explode(' ',$full_name);
						$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
						
						if(!empty($user_full_name)){
							unset($user_full_name[0]);
						}
						$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
					}
					
					// here we define the data we are posting in order to perform an update
					$post = array(
						
						'id'                       => $exitContact['contactId'], // example contact ID to modify
						'email'                    => $formData['email'],
						'first_name'               => $first_name,
						'last_name'                => $last_name,
						'phone'                    => $formData['phone'],
						'orgname'                  => $formData['active_campaign_location'],
						'tags'                     => $tags,
						//'ip4'                    => '127.0.0.1',

						// any custom fields
						//'field[345,0]'           => 'field value', // where 345 is the field ID
						//'field[%PERS_1%,0]'      => 'field value', // using the personalization tag instead (make sure to encode the key)
						//'field[%LOCATION%,0]'      => $formData['location'], // using the personalization tag instead (make sure to encode the key)

						// assign to lists:
						'p['.$activeCampaign[0]->list_id.']'     => $activeCampaign[0]->list_id, // example list ID (REPLACE '123' WITH ACTUAL LIST ID, IE: p[5] = 5)
						'status['.$activeCampaign[0]->list_id.']'              => 1, // 1: active, 2: unsubscribed (REPLACE '123' WITH ACTUAL LIST ID, IE: status[5] = 1)
						//'form'          => 1001, // Subscription Form ID, to inherit those redirection settings
						//'noresponders[123]'      => 1, // uncomment to set "do not send any future responders"
						//'sdate[123]'             => '2009-12-07 06:00:00', // Subscribe date for particular list - leave out to use current date/time
						// use the folowing only if status=1
						'instantresponders['.$activeCampaign[0]->list_id.']' => 1, // set to 0 to if you don't want to sent instant autoresponders
						//'lastmessage[123]'       => 1, // uncomment to set "send the last broadcast campaign"

						//'p[]'                    => 345, // some additional lists?
						//'status[345]'            => 1, // some additional lists?
					);
					
					if($customFields['location_field'] == 1){
						$post['field[%LOCATION%,0]'] = $formData['active_campaign_location'];
					}
					
					if($customFields['program_field'] == 1){
						$post['field[%PROGRAM%,0]'] = $formData['active_campaign_program'];
					}
					
					if($customFields['cost_of_trial_field'] == 1){
						$post['field[%COST_OF_TRIAL%,0]'] = $formData['active_campaign_trial_type'];
					}
					
					if(isset($formData['program_type']) && !empty($formData['program_type'])){
						if($formData['program_type'] == "birthday_page"){
							if($customFields['call_or_schedule'] == 1){
								$post['field[%BIRTHDAY_PAGE_OPTION%,0]'] = $formData['call_or_schedule'];
							}
						}elseif($formData['program_type'] == "summer_camp"){
							if($customFields['reserve_or_schedule'] == 1){
								$post['field[%SUMMER_CAMP_OPTION%,0]'] = $formData['reserve_or_schedule'];
							}
						}
					}
					
					
					
					//echo '<pre>post'.time(); print_r($post); die;
					
					// This section takes the input fields and converts them to the proper format
					$query = "";
					foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
					$query = rtrim($query, '& ');

					// This section takes the input data and converts it to the proper format
					$data = "";
					foreach( $post as $key => $value ) $data .= urlencode($key) . '=' . urlencode($value) . '&';
					$data = rtrim($data, '& ');

					// clean up the url
					$url = rtrim($url, '/ ');

					// This sample code uses the CURL library for php to establish a connection,
					// submit your request, and show (print out) the response.
					if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

					// If JSON is used, check if json_decode is present (PHP 5.2.0+)
					if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
						die('JSON not supported. (introduced in PHP 5.2.0)');
					}

					
					// define a final API request - GET
					$api = $url . '/admin/api.php?' . $query;

					$request = curl_init($api); // initiate curl object
					curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
					curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
					curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
					//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
					curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

					$response = (string)curl_exec($request); // execute curl post and store results in $response

					// additional options may be required depending upon your server configuration
					// you can find documentation on curl options at http://www.php.net/curl_setopt
					curl_close($request); // close curl object

					if ( !$response ) {
						//die('Nothing was returned. Do you have a connection to Email Marketing server?');
					}

					// This line takes the response and breaks it into an array using:
					// JSON decoder
					//$result = json_decode($response);
					// unserializer
					$result = unserialize($response);
					//echo '<pre>result'; print_r($result); die;
					// Result info that is always returned
					if(isset($result['result_code']) && $result['result_code'] == 1){
						//$this->saveActiveCampaignAutomationContact($formData['email'],$result,$activeCampaign, $formModelDetail);
					}

			
		}else{
			$params = array(

				// the API Key can be found on the "Your Settings" page under the "API" tab.
				// replace this with your API Key
				'api_key'      => $activeCampaign[0]->api_key,

				// this is the action that adds a contact
				'api_action'   => 'contact_add',

				// define the type of output you wish to get back
				// possible values:
				// - 'xml'  :      you have to write your own XML parser
				// - 'json' :      data is returned in JSON format and can be decoded with
				//                 json_decode() function (included in PHP since 5.2.0)
				// - 'serialize' : data is returned in a serialized format and can be decoded with
				//                 a native unserialize() function
				'api_output'   => 'serialize',
			);
			
			$tags = $this->query_model->formModuleTagsInSerializeForApis($active_campaign_tags);
			
			if(!empty($extraTags)){
				if(!empty($tags)){
					$alltags = $tags.','.$extraTags;
					$alltags = explode(',',$alltags);
					if(!empty($alltags)){
						foreach($alltags as $alltag){
							$tagList[$alltag] = $alltag;
						}
						$tags = implode(',',$tagList);
					}
				}else{
					$tags = $extraTags;
				}
			}
			
			
			/*$twilioApi = $this->query_model->getTwilioApiType();
			if(isset($formData['twilio_checkbox']) && $formData['twilio_checkbox'] == 1){
				if(!empty($twilioApi) && $twilioApi->type == 1){
					
					$this->query_model->sendMsgToTwilioApi($formData,$twilioApi);
					
					if(!empty($tags)){
						$tags = $tags.','.$twilioApi->ac_tag_name;
					}else{
						$tags = $twilioApi->ac_tag_name;
					}
				}
				
			}*/
			
			$full_name = (isset($formData['name']) && !empty($formData['name'])) ? trim($formData['name']) : '';
				
			$first_name = 'N/A';
			$last_name = 'N/A';
			if(!empty($full_name)){
				$user_full_name = explode(' ',$full_name);
				$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
				
				if(!empty($user_full_name)){
					unset($user_full_name[0]);
				}
				$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
			}
					
			
			// here we define the data we are posting in order to perform an update
			$post = array(
				'email'                    => $formData['email'],
				'first_name'               => $first_name,
				'last_name'                => $last_name,
				'phone'                    => $formData['phone'],
				'orgname'                  => $formData['active_campaign_location'],
				'tags'                     => $tags,
				//'ip4'                    => '127.0.0.1',

				// any custom fields
				//'field[345,0]'           => 'field value', // where 345 is the field ID
				//'field[%PERS_1%,0]'      => 'field value', // using the personalization tag instead (make sure to encode the key)
				//'field[%LOCATION%,0]'      => $formData['location'], // using the personalization tag instead (make sure to encode the key)

				// assign to lists:
				'p['.$activeCampaign[0]->list_id.']'     => $activeCampaign[0]->list_id, // example list ID (REPLACE '123' WITH ACTUAL LIST ID, IE: p[5] = 5)
				'status['.$activeCampaign[0]->list_id.']'              => 1, // 1: active, 2: unsubscribed (REPLACE '123' WITH ACTUAL LIST ID, IE: status[5] = 1)
				//'form'          => 1001, // Subscription Form ID, to inherit those redirection settings
				//'noresponders[123]'      => 1, // uncomment to set "do not send any future responders"
				//'sdate[123]'             => '2009-12-07 06:00:00', // Subscribe date for particular list - leave out to use current date/time
				// use the folowing only if status=1
				'instantresponders['.$activeCampaign[0]->list_id.']' => 1, // set to 0 to if you don't want to sent instant autoresponders
				//'lastmessage[123]'       => 1, // uncomment to set "send the last broadcast campaign"

				//'p[]'                    => 345, // some additional lists?
				//'status[345]'            => 1, // some additional lists?
			);
			
			
			
			if($customFields['location_field'] == 1){
				$post['field[%LOCATION%,0]'] = $formData['active_campaign_location'];
			}
			
			if($customFields['program_field'] == 1){
				$post['field[%PROGRAM%,0]'] = $formData['active_campaign_program'];
			}
			
			if($customFields['cost_of_trial_field'] == 1){
				$post['field[%COST_OF_TRIAL%,0]'] = $formData['active_campaign_trial_type'];
			}
			
			if(isset($formData['program_type']) && !empty($formData['program_type'])){
				if($formData['program_type'] == "birthday_page"){
					if($customFields['call_or_schedule'] == 1){
						$post['field[%BIRTHDAY_PAGE_OPTION%,0]'] = $formData['call_or_schedule'];
					}
				}elseif($formData['program_type'] == "summer_camp"){
					if($customFields['reserve_or_schedule'] == 1){
						$post['field[%SUMMER_CAMP_OPTION%,0]'] = $formData['reserve_or_schedule'];
					}
				}
			}
			
			//echo '<pre>post'.time(); print_r($post); die;
			
			// This section takes the input fields and converts them to the proper format
			$query = "";
			foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
			$query = rtrim($query, '& ');

			// This section takes the input data and converts it to the proper format
			$data = "";
			foreach( $post as $key => $value ) $data .= urlencode($key) . '=' . urlencode($value) . '&';
			$data = rtrim($data, '& ');

			// clean up the url
			$url = rtrim($url, '/ ');

			// This sample code uses the CURL library for php to establish a connection,
			// submit your request, and show (print out) the response.
			if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

			// If JSON is used, check if json_decode is present (PHP 5.2.0+)
			if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
				die('JSON not supported. (introduced in PHP 5.2.0)');
			}

			
			// define a final API request - GET
			$api = $url . '/admin/api.php?' . $query;

			$request = curl_init($api); // initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
			//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

			$response = (string)curl_exec($request); // execute curl post and store results in $response

			// additional options may be required depending upon your server configuration
			// you can find documentation on curl options at http://www.php.net/curl_setopt
			curl_close($request); // close curl object

			if ( !$response ) {
				//die('Nothing was returned. Do you have a connection to Email Marketing server?');
			}

			// This line takes the response and breaks it into an array using:
			// JSON decoder
			//$result = json_decode($response);
			// unserializer
			$result = unserialize($response);
			//echo '<pre>result'; print_r($result); die;
			// Result info that is always returned
			if(isset($result['result_code']) && $result['result_code'] == 1){
				//$this->saveActiveCampaignAutomationContact($formData['email'],$result,$activeCampaign, $formModelDetail);
			}
		}
		return $result;
	}
	
	
	public function saveActiveCampaignAutomationContact($email,$result,$activeCampaign, $formModelDetail){
		
		if($activeCampaign[0]->automation_id != 0){
				error_reporting(0);
				// Set up an object instance using our PHP API wrapper.
				define("ACTIVECAMPAIGN_URL", "https://".$activeCampaign[0]->account_name.".api-us1.com");
				define("ACTIVECAMPAIGN_API_KEY", $activeCampaign[0]->api_key);
				
				$this->load->library('activecampaign/includes/ActiveCampaign');
				$ac = new ActiveCampaign(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);

				$post_data = array(
					"contact_email" => $email, // include this or contact_id
					"automation" => $activeCampaign[0]->automation_id, // one or more
				);
				$response = $ac->api("automation/contact/add", $post_data);
				
				return $response;
		}
		
	}
	
	
	
		
// checking active campaign user already exit or not
public function checkActiveCampaignContactExists($activeCampaign, $email){
		// By default, this sample code is designed to get the result from your ActiveCampaign installation and print out the result
		
		$contactData['contactExit'] = 0;
		$contactData['contactId'] = 0;
		$contactData['tags'] = array();
		
		$url = 'http://'.$activeCampaign[0]->account_name.'.api-us1.com';


		$params = array(

			// the API Key can be found on the "Your Settings" page under the "API" tab.
			// replace this with your API Key
			'api_key'      => $activeCampaign[0]->api_key,

			// this is the action that fetches a contact info based on the ID you provide
			'api_action'   => 'contact_view_email',
			//'api_action' => 'contact_view', // this one also works

			// define the type of output you wish to get back
			// possible values:
			// - 'xml'  :      you have to write your own XML parser
			// - 'json' :      data is returned in JSON format and can be decoded with
			//                 json_decode() function (included in PHP since 5.2.0)
			// - 'serialize' : data is returned in a serialized format and can be decoded with
			//                 a native unserialize() function
			'api_output'   => 'serialize',

			'email'        => $email,
		);

		// This section takes the input fields and converts them to the proper format
		$query = "";
		foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
		$query = rtrim($query, '& ');

		// clean up the url
		$url = rtrim($url, '/ ');

		// This sample code uses the CURL library for php to establish a connection,
		// submit your request, and show (print out) the response.
		if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

		// If JSON is used, check if json_decode is present (PHP 5.2.0+)
		if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
			die('JSON not supported. (introduced in PHP 5.2.0)');
		}

		// define a final API request - GET
		$api = $url . '/admin/api.php?' . $query;

		$request = curl_init($api); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

		$response = (string)curl_exec($request); // execute curl fetch and store results in $response

		// additional options may be required depending upon your server configuration
		// you can find documentation on curl options at http://www.php.net/curl_setopt
		curl_close($request); // close curl object

		if ( !$response ) {
			//die('Nothing was returned. Do you have a connection to Email Marketing server?');
		}

		// This line takes the response and breaks it into an array using:
		// JSON decoder
		//$result = json_decode($response);
		// unserializer
		$result = unserialize($response);
		// XML parser...
		// ...
		
		if(isset($result['result_code']) && $result['result_code'] == 1){
			$contactData['contactExit'] = 1;
			$contactData['contactId'] = $result['id'];
			$contactData['tags'] = $result['tags'];
		}
		//echo "<pre>contactData"; print_r($contactData); die;
		return $contactData;
}	


	public function getProgramLists(){
		$programs = array();
		$programsArr = $this->query_model->getbySpecific('tblprogram', 'published', 1);
		if(!empty($programsArr)){
			foreach($programsArr as $pro){
				
				$programCategories =  $this->query_model->getbySpecific('tblcategory', 'cat_id', $pro->category);
				
				if(!empty($programCategories) && $programCategories[0]->published == 1){
					$programs[] = $pro;
				}
			}
		}
		
		return $programs;
	}
	
	
		
		public function checkHunneyPost($data){
			
			//$error_text = $this->query_model->getStaticTextTranslation('an_error_occurred');
			 $error_text = "";
			 $is_error = 0;
			 $is_country_error = 0;
			 $is_spamcheck_error = 0;
			 $is_captcha_error = 0;
			 
			
			$google_captcha_detail = $this->query_model->getByTable('tbl_google_captcha');
	
			if(!empty($google_captcha_detail) && $google_captcha_detail[0]->type == 1){
				$form_types =  !empty($google_captcha_detail[0]->form_types) ? unserialize($google_captcha_detail[0]->form_types) : ''; 
				
				$allFormTypes = array('opt_in_form','trial_form','contact_us_form','dojo_cart_form');
				
				if(!empty($form_types)){
					
					$submit_form_type = (isset($data['submit_form_type']) && !empty($data['submit_form_type'])) ? $data['submit_form_type'] : '';
					
					if(!empty($submit_form_type)){
						if(in_array($submit_form_type,$allFormTypes)){
							if(in_array($submit_form_type,$form_types)){
								   
								if (isset($data['g-recaptcha-response']) && !empty($data['g-recaptcha-response'])) {
									$captcha = $data['g-recaptcha-response'];
								} else {
									$captcha = false;
								}
								
								if (!$captcha) {
									//Do something with error
									$is_error = 1;
									$is_captcha_error = 1;
									$error_text = $error_text.' 41';
								} else {
									$secret   = $google_captcha_detail[0]->google_captcha_secret_key;//secret key
									/*$captcha_response = file_get_contents(
										"https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
									);*/
									
									$site_verify_url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR'];
				
									$request = curl_init($site_verify_url); // initiate curl object
									curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
									curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
									
									curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
									curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
									curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

									$captcha_response = (string)curl_exec($request); // execute curl post and store results in $response
									$error_msg = curl_error($request);
									curl_close($request); // close curl object
									
									// use json_decode to extract json response
									$captcha_response = json_decode($captcha_response);
								//	echo '<prE>$captcha_response'; print_r($captcha_response); die;
									
									if ($captcha_response->success === false) {
										//Do something with error
										$is_error = 1;
										$is_captcha_error = 1;
										$error_text = $error_text.' 42';
									}
									
									//... The Captcha is valid you can continue with the rest of your code
									//... Add code to filter access using $captcha_response . score
									if ($captcha_response->success==true && $captcha_response->score <= 0.5) {
										//Do something to denied access
										$is_error = 1;
										$is_captcha_error = 1;
										$error_text = $error_text.' 43';
									}
								}
								
							   
							}
						}else{
							$is_error = 1;
							$is_captcha_error = 1;
							$error_text = $error_text.' 44';
						}
					}else{
						$is_error = 1;
						$is_captcha_error = 1;
						$error_text = $error_text.' 45';
					}
				}
			}
		
			if($is_captcha_error == 1){
				
			   $ipAddress = $this->query_model->getCountryNameToIpAddress();
			   $formData = $this->setFormDataValueInFormat($_POST);
				
			   $insertDataArr['name'] = isset($formData['name']) ? $formData['name'] : '';
					$insertDataArr['email'] = isset($formData['email']) ? $formData['email'] : '';
					$insertDataArr['phone'] = isset($formData['phone']) ? $formData['phone'] : '';
					$insertDataArr['program'] = isset($formData['program']) ? $formData['program'] : '';
					$insertDataArr['school'] = isset($formData['location']) ? $formData['location'] : '';
					$error_msg_type = 'google_captcha';
					$insertDataArr['message'] = isset($formData['message']) ? $error_msg_type.' ~ '.$formData['message'] : $error_msg_type;
					$insertDataArr['trial_name'] = isset($formData['trial_name']) ? $formData['trial_name'] : '';
					$insertDataArr['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
					$insertDataArr['ip_address'] = isset($ipAddress['client_ip_address']) ? $ipAddress['client_ip_address'] : '';
					$insertDataArr['country_name'] = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
					$insertDataArr['created_at'] = date('Y-m-d H:i:s');
					
					$this->query_model->insertData("tbl_sp_leads", $insertDataArr);
		   }
		   
			
			$is_multi_item_dojocart = (isset($data['is_multi_item_dojocart']) && $data['is_multi_item_dojocart'] == 1) ? $data['is_multi_item_dojocart'] : 0;
			
	        
			
			if(isset($data['is_unique_dojocart']) && $data['is_unique_dojocart'] == 1){
				
			}else{
				
				if(isset($data['form_email_2'])){
					$data['email'] = $data['form_email_2'];
				}else{
					$data['email'] = $data['email'];
				} 
				
				if(isset($data['email']) && (empty($data['email']) || !preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/",$data['email']))) { 
					$error_text = $error_text.' 26'; 
					$is_error = 1;
				}
				
				if($is_multi_item_dojocart == 0){
					/*if(isset($data['last_name']) && !preg_match("/^[a-zA-Z ']+$/",$data['last_name'])) { die ($error_text." 2"); }
					if (isset($data['last_name']) && (empty($_POST['last_name']) || strpos($_POST['last_name'], 'www') !== false || strpos($_POST['last_name'], '.com') !== false)) {
						die($error_text." 5");
					}*/
					if(isset($data['last_name']) && !empty($data['last_name'])){
						$error_text = $error_text.' 1';
						$is_error = 1;
					}	
				}elseif($is_multi_item_dojocart == 1){
					if(isset($data['contact_last_name']) && !empty($data['contact_last_name'])){
						foreach($data['contact_last_name'] as $lastname){
							/*if(isset($lastname) && !preg_match("/^[a-zA-Z ']+$/",$lastname)) { die ($error_text." 10"); }
							if (isset($lastname) && (empty($lastname) || strpos($lastname, 'www') !== false || strpos($lastname, '.com') !== false)) {
								die($error_text." 11");
							}*/
							if(isset($lastname) && !empty($lastname)){
								$is_error = 1;
								$error_text = $error_text.' 2';
							}
						}
					}
				}
				
			
				$site_settings = $this->query_model->getbyTable("tblsite");
			
			//echo '<pre>site_settings'; print_r($site_settings);
			$check_phone_number = 0;
			if($site_settings[0]->international_phone_fields != 1){
				if($site_settings[0]->phone_required == 1){
					if(isset($data['phone']) && !empty($data['phone'])){
						
						preg_match_all('!\d+!', $data['phone'], $matches);
						
						if(isset($matches[0][0]) && !empty($matches[0][0])){
							if($matches[0][0] <= 200){
								$is_error = 1;
								$error_text = $error_text.' 3';
							}
						}
						
						$check_phone_number = 1;
						
						
						
					}else{
				    	//	$is_error = 1;
				    	//	die($error_text." 4");
					}
				}else{
					if(isset($data['phone']) && !empty($data['phone'])){
						
						preg_match_all('!\d+!', $data['phone'], $matches);
						
						if(isset($matches[0][0]) && !empty($matches[0][0])){
							if($matches[0][0] <= 200){
								$is_error = 1;
								$error_text = $error_text.' 4';
							}
						}
						
						$check_phone_number = 1;
					}
				}
				
				if($check_phone_number == 1){
					if(strlen($data['phone']) == 14){
						if($data['phone']{0} == "(" && $data['phone']{4} == ")" && $data['phone']{5} == " ")
						{
							
						}else{
							$is_error = 1;
							$error_text = $error_text.' 5';
						}
						 
					}else{
						$is_error = 1;
						$error_text = $error_text.' 6';
					}
				}
				
			}else{
				
				//international_phone_masking_format
				if(isset($data['phone'])){
					if($site_settings[0]->international_phone_masking == 1){
						if(!empty($site_settings[0]->international_phone_masking_format)){
							if(strlen($site_settings[0]->international_phone_masking_format) >= strlen($data['phone'])){
							//if(strlen($site_settings[0]->international_phone_masking_format) >= strlen($data['phone']) || strlen($site_settings[0]->international_phone_masking_format) == (strlen($data['phone'])+1)){
								$lastSpaceadmin = strrpos($site_settings[0]->international_phone_masking_format," ");
								$lastSpacefront = strrpos($data['phone']," ");
								
								$admin_phone_code = explode(' ',$site_settings[0]->international_phone_masking_format);
								$count_admin_phone_code = isset($admin_phone_code[0]) ? strlen($admin_phone_code[0]) : '';
								
								$form_phone_code = explode(' ',$site_settings[0]->international_phone_masking_format);
								$count_form_phone_code = isset($admin_phone_code[0]) ? strlen($admin_phone_code[0]) : '';
								
								
								$is_code_match = 0;
								if($count_admin_phone_code == $count_form_phone_code){
									$count_code = $count_admin_phone_code - 1;
									for($i = 0; $i <= $count_code; $i++){
										if($data['phone']{$i} == $site_settings[0]->international_phone_masking_format{$i}){
											$is_code_match = 1;
										}else{
											$is_code_match = 0;
										}
									}	
								}
								
								
								if($is_code_match == 1 && $lastSpaceadmin == $lastSpacefront){
									//die('sucs');
								}else{
									$is_error = 1;
									$error_text = $error_text.' 7';
								}
							}else{
								$is_error = 1;
								$error_text = $error_text.' 8';
							}
						}
					}
				}
				
			}
			}
	    //die('pass');  
		if($is_multi_item_dojocart == 0){
			if(isset($data['name']) && !preg_match("/^[a-zA-Z ']+$/",$data['name'])) { die ($error_text." 1"); }
			if (isset($data['name']) && (empty($_POST['name']) || strpos($_POST['name'], 'www') !== false || strpos($_POST['name'], '.com') !== false)) {
				
				$is_error = 1;
				$error_text = $error_text.' 9';
			} 
		}elseif($is_multi_item_dojocart == 1){
			
			if(isset($data['contact_name']) && !empty($data['contact_name'])){
				foreach($data['contact_name'] as $name){
					if(isset($name) && !preg_match("/^[a-zA-Z ']+$/",$name)) { die ($error_text." 12"); }
					if (isset($name) && (empty($name) || strpos($name, 'www') !== false || strpos($name, '.com') !== false)) {
						$is_error = 1;
						$error_text = $error_text.' 10';
					} 
				}
			}
		}
	      
			
			/*if(isset($_POST['website']) && $_POST['website'] != ''){
				
				die($error_text." 6");

			}else{
				
				if(!isset($_POST['website'])){
					die($error_text." 16");
				}
			}*/
			
		
		
		/*if(isset($_POST) && !empty($_POST)){
			$n = 0;
			foreach($_POST as $key => $val){
				
				if(strstr($key,'x2o3d_')){
					$n = 1;
					$customKeyData = explode('_',$key);
					
					if(isset($customKeyData[1]) && !empty($customKeyData[1])){
						$this->db->where_in('flag',array(1,0));
						$exitUniqueRecord = $this->query_model->getBySpecific( 'tbl_form_unique_ids', 'unique_id',$customKeyData[1]);
						
						
						if(empty($exitUniqueRecord)){
							$is_error = 1;
							$error_text = $error_text.' 11';
							
						}else{
							//$this->db->where("unique_id", $uniqueId);
							//$this->db->delete("tbl_form_unique_ids");
							$value=array('flag'=>1, 'updated_at'=> date('Y-m-d H:i:s'));
							$this->db->where('unique_id',$customKeyData[1]);
							$this->db->update('tbl_form_unique_ids',$value);
							
							
						}
						
					}else{
						$is_error = 1;
						$error_text = $error_text.' 12';
					}
				}
			}
			
			if($n == 0){
				$is_error = 1;
				$error_text = $error_text.' 13';
			}
		}
		
			
			
			if($this->session->userdata('website_unique_id')){
				$uniqueId = $this->session->userdata('website_unique_id');
				$this->db->limit(1);
				$exitUniqueId = $this->query_model->getBySpecific( 'tbl_form_unique_ids', 'unique_id',$uniqueId);
				
				if(empty($exitUniqueId)){
					
					$is_error = 1;
					$error_text = $error_text.' 15';
				}else{
					//$this->db->where("unique_id", $uniqueId);
					//$this->db->delete("tbl_form_unique_ids");
				}
				
			}else{
				$error_text = $error_text.' 16';
			}*/
			
			if(!isset($_POST['website'])){
				$is_error = 1;
				$error_text = $error_text.' 17';
			}else{
				if(!empty($_POST['website'])){
					$is_error = 1;
					$error_text = $error_text.' 18';
				}
			}
			
			
			/*if(!isset($_POST['firstname'])){
				die("Success! Thank you for your interest. A representative will contact you within 24 hours!..");
			}else{
				if(!empty($_POST['firstname'])){
					die("Success! Thank you for your interest. A representative will contact you within 24 hours!..");
				}
			}*/
			
			
			if(!isset($_POST['fax'])){
				$is_error = 1;
				$error_text = $error_text.' 19';
			}else{
				if(!empty($_POST['fax'])){
					$is_error = 1;
					$error_text = $error_text.' 20';
				}
			}
			
			
			
			if(!isset($_POST['comment'])){
				$is_error = 1;
				$error_text = $error_text.' 21';
			}else{
				if(!empty($_POST['comment'])){
					$is_error = 1;
					$error_text = $error_text.' 22';
				}
			}
			
			
			
			if(isset($_POST['contact_me_by_phone'])){
				$is_error = 1;
				$error_text = $error_text.' 23';
			}
			
			
			 
			 $formData = $this->setFormDataValueInFormat($_POST);
			
			// hunney pot code for check country by ip address
			
			$is_paid_form = (isset($_POST['amount']) && $_POST['amount'] > 0) ? 1 : 0;
			
		
			$this->db->select('stripe_ideal_payment');
			$paymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
			if($paymentDetail[0]->stripe_ideal_payment == 1 && $is_paid_form == 1){	
			
			}else{
				if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], base_url()) !== 0) {
					$is_error = 1;
					$error_text = $error_text.' 14';
				}
			}
			
			$is_paid_form = 0;
			if($is_paid_form == 0 && $is_error == 0){
				
				$this->db->select('allow_countries');
				$allow_countries = $this->query_model->getbyTable("tblsite");
				if($allow_countries[0]->allow_countries == 1){
					
					$ipAddress = $this->query_model->getCountryNameToIpAddress();
					$ipAddressCountry = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
					
					if(!empty($ipAddressCountry)){
						
						$this->db->where('status',1);
						$countries = $this->query_model->getbyTable("tbl_countries");
						$countryArr = array();
						if(!empty($countries)){
							foreach($countries as $country){
								$countryArr[$country->id] = $country->country_name;
							}
						}
						
						
						if(!empty($countryArr)){
							if(in_array($ipAddressCountry,$countryArr)){
								// write some code here
							}else{
								 $error_text = $error_text.' 27'; 
								 $is_error = 1;
								 $is_country_error = 1;
							}
						}
					}
					
					
					if($is_country_error == 1){
						
						$insertDataArr['name'] = isset($formData['name']) ? $formData['name'] : '';
						$insertDataArr['email'] = isset($formData['email']) ? $formData['email'] : '';
						$insertDataArr['phone'] = isset($formData['phone']) ? $formData['phone'] : '';
						$insertDataArr['program'] = isset($formData['program']) ? $formData['program'] : '';
						$insertDataArr['school'] = isset($formData['location']) ? $formData['location'] : '';
						$insertDataArr['message'] = isset($formData['message']) ? $formData['message'] : '';
						$insertDataArr['trial_name'] = isset($formData['trial_name']) ? $formData['trial_name'] : '';
						$insertDataArr['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
						$insertDataArr['ip_address'] = isset($ipAddress['client_ip_address']) ? $ipAddress['client_ip_address'] : '';
						$insertDataArr['country_name'] = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
						$insertDataArr['created_at'] = date('Y-m-d H:i:s');
						
						$this->query_model->insertData("tbl_sp_leads", $insertDataArr);
						
					}
					
				}
			}
		
		$spam_check_api = $this->query_model->getbyTable("tbl_spam_api");
		if(!empty($spam_check_api) && $spam_check_api[0]->type == 1 && $is_error == 0){
			
			if($is_paid_form == 0){
				
				if($is_country_error == 0){
						$ipAddress = $this->query_model->getCountryNameToIpAddress();
						$client_ip_address = isset($ipAddress['client_ip_address']) ? $ipAddress['client_ip_address'] : '';
						
						$email = isset($formData['email']) ? $formData['email'] : '';
						//$client_ip_address = '46.165.245.154';
						$network_type = '';
						$country = '';
						
						$url = "https://api.cleantalk.org/?method_name=spam_check&auth_key=".$spam_check_api[0]->api_key."&email=".$email."&ip=".$client_ip_address;
						//echo $url; die;	
						$request = curl_init($url); // initiate curl object
						curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
						curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
						
						curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
						curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
						curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

						$response = (string)curl_exec($request); // execute curl post and store results in $response
						$error_msg = curl_error($request);
						curl_close($request); // close curl object
						
						
						if(!empty($response)){
							
							$response_data = json_decode($response, true);
							//echo '<prE>response_data'; print_r($response_data); die;
							if(isset($response_data['data'][$client_ip_address]) && !empty($response_data['data'][$client_ip_address])){
								if(isset($response_data['data'][$client_ip_address]['appears'])){
									if($response_data['data'][$client_ip_address]['appears'] == 1){
										$country = isset($response_data['data'][$client_ip_address]['country']) ? $response_data['data'][$client_ip_address]['country'] : '';
										$network_type = isset($response_data['data'][$client_ip_address]['network_type']) ? $response_data['data'][$client_ip_address]['network_type'] : '';
										$error_text = $error_text.' 30'; 
										 $is_error = 1;
										 $is_spamcheck_error = 1;
										 
									}
								}else{
									$error_text = $error_text.' 31'; 
									 $is_error = 1;
									 $is_spamcheck_error = 1;
								}
							}else{
								$error_text = $error_text.' 32'; 
								 $is_error = 1;
								 $is_spamcheck_error = 1;
							}
						}else{
							$error_text = $error_text.' 33'; 
							 $is_error = 1;
							 $is_spamcheck_error = 1;
						}
						
						if($is_spamcheck_error == 1){
						
							$insertDataArr['name'] = isset($formData['name']) ? $formData['name'] : '';
							$insertDataArr['email'] = isset($formData['email']) ? $formData['email'] : '';
							$insertDataArr['phone'] = isset($formData['phone']) ? $formData['phone'] : '';
							$insertDataArr['program'] = isset($formData['program']) ? $formData['program'] : '';
							$insertDataArr['school'] = isset($formData['location']) ? $formData['location'] : '';
							$insertDataArr['message'] = isset($formData['message']) ? $formData['message'] : '';
							$insertDataArr['trial_name'] = isset($formData['trial_name']) ? $formData['trial_name'] : '';
							$insertDataArr['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
							$insertDataArr['ip_address'] = isset($ipAddress['client_ip_address']) ? $ipAddress['client_ip_address'] : '';
							$insertDataArr['country_name'] = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
							$insertDataArr['spam_api_country_name'] = $country;
							$insertDataArr['ip_network_type'] = $network_type;
							$insertDataArr['created_at'] = date('Y-m-d H:i:s');
							
							$this->query_model->insertData("tbl_sp_leads", $insertDataArr);
							
						}
						
				}

			}
		}
		
			
		
			
		 
		if($is_error == 1){
			
			$hunneypot_error_msg = array('hunneypot_error_msg' => $error_text);
			
			$this->session->set_userdata($hunneypot_error_msg);
			
			redirect(@base_url().'site/thank_you');
		}else{
			if(isset($_POST['trial_id']) && !empty($_POST['trial_id'])){
				if(isset($_POST['amount'])){
					$this->session->unset_userdata('sessionLeadsData');
				}
			}
		}
		
	}
	
	
	public function checkHunneyPostForBirthdayForm($data){
			
			 //$error_text = $this->query_model->getStaticTextTranslation('an_error_occurred');
			$error_text = "";
			$is_error = 0;
			$is_country_error = 0;
			$is_spamcheck_error = 0;
			$is_captcha_error = 0;
			 
			
			$google_captcha_detail = $this->query_model->getByTable('tbl_google_captcha');
	
			if(!empty($google_captcha_detail) && $google_captcha_detail[0]->type == 1){
				$form_types =  !empty($google_captcha_detail[0]->form_types) ? unserialize($google_captcha_detail[0]->form_types) : ''; 
				
				$allFormTypes = array('opt_in_form','trial_form','contact_us_form','dojo_cart_form');
				
				if(!empty($form_types)){
					
					$submit_form_type = (isset($data['submit_form_type']) && !empty($data['submit_form_type'])) ? $data['submit_form_type'] : '';
					
					if(!empty($submit_form_type)){
						if(in_array($submit_form_type,$allFormTypes)){
							if(in_array($submit_form_type,$form_types)){
								   
								if (isset($data['g-recaptcha-response']) && !empty($data['g-recaptcha-response'])) {
									$captcha = $data['g-recaptcha-response'];
								} else {
									$captcha = false;
								}
								
								if (!$captcha) {
									//Do something with error
									$is_error = 1;
									$is_captcha_error = 1;
									$error_text = $error_text.' 41';
								} else {
									$secret   = $google_captcha_detail[0]->google_captcha_secret_key;//secret key
									/*$captcha_response = file_get_contents(
										"https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
									);*/
									
									$site_verify_url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR'];
				
									$request = curl_init($site_verify_url); // initiate curl object
									curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
									curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
									
									curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
									curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
									curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

									$captcha_response = (string)curl_exec($request); // execute curl post and store results in $response
									$error_msg = curl_error($request);
									curl_close($request); // close curl object
									
									// use json_decode to extract json response
									$captcha_response = json_decode($captcha_response);
									
									if ($captcha_response->success === false) {
										//Do something with error
										$is_error = 1;
										$is_captcha_error = 1;
										$error_text = $error_text.' 42';
									}
									
									//... The Captcha is valid you can continue with the rest of your code
									//... Add code to filter access using $captcha_response . score
									if ($captcha_response->success==true && $captcha_response->score <= 0.5) {
										//Do something to denied access
										$is_error = 1;
										$is_captcha_error = 1;
										$error_text = $error_text.' 43';
									}
								}
								
							   
							}
						}else{
							$is_error = 1;
							$is_captcha_error = 1;
							$error_text = $error_text.' 44';
						}
					}else{
						$is_error = 1;
						$is_captcha_error = 1;
						$error_text = $error_text.' 45';
					}
				}
			}
		
			if($is_captcha_error == 1){
				
			   $ipAddress = $this->query_model->getCountryNameToIpAddress();
			   $formData = $this->setFormDataValueInFormat($_POST);
				
			   $insertDataArr['name'] = isset($formData['name']) ? $formData['name'] : '';
					$insertDataArr['email'] = isset($formData['email']) ? $formData['email'] : '';
					$insertDataArr['phone'] = isset($formData['phone']) ? $formData['phone'] : '';
					$insertDataArr['program'] = isset($formData['program']) ? $formData['program'] : '';
					$insertDataArr['school'] = isset($formData['location']) ? $formData['location'] : '';
					$error_msg_type = 'google_captcha';
					$insertDataArr['message'] = isset($formData['message']) ? $error_msg_type.' ~ '.$formData['message'] : $error_msg_type;
					$insertDataArr['trial_name'] = isset($formData['trial_name']) ? $formData['trial_name'] : '';
					$insertDataArr['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
					$insertDataArr['ip_address'] = isset($ipAddress['client_ip_address']) ? $ipAddress['client_ip_address'] : '';
					$insertDataArr['country_name'] = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
					$insertDataArr['created_at'] = date('Y-m-d H:i:s');
					
					$this->query_model->insertData("tbl_sp_leads", $insertDataArr);
		   }
			
		/*echo '<pre>captcha_response'; print_r($captcha_response); 
		echo '<pre>error_text'; print_r($error_text); 
		die;*/	
			 
			if(isset($data['bday_name']) && !preg_match("/^[a-zA-Z ']+$/",$data['bday_name'])) { 
				$error_text = $error_text.' 1';
				$is_error = 1;
			}
		//	if(isset($data['last_name']) && !preg_match("/^[a-zA-Z ']+$/",$data['last_name'])) { die ($error_text); }
			if(isset($data['bday_email']) && (empty($data['bday_email']) || !preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/",$data['bday_email']))) { 
					$error_text = $error_text.' 2';
						$is_error = 1; }
			
			if (strpos($_POST['bday_name'], 'www') !== false || strpos($_POST['bday_name'], '.com') !== false) {
					$error_text = $error_text.' 3';
					$is_error = 1;
			} 
			
			/*if (strpos($_POST['last_name'], 'www') !== false || strpos($_POST['last_name'], '.com') !== false) {
				die($error_text);
			} */
			
			
			/*if(isset($_POST['website']) && $_POST['website'] != ''){
				
				die($error_text." 6");

			}else{
				
				if(!isset($_POST['website'])){
					die($error_text." 16");
				}
			}*/
			
		/*if(isset($_POST) && !empty($_POST)){
			$n = 0;
			foreach($_POST as $key => $val){
				
				if(strstr($key,'x2o3d_')){
					$n = 1;
					$customKeyData = explode('_',$key);
					
					if(isset($customKeyData[1]) && !empty($customKeyData[1])){
						$this->db->where_in('flag',array(1,0));
						$exitUniqueRecord = $this->query_model->getBySpecific( 'tbl_form_unique_ids', 'unique_id',$customKeyData[1]);
						
						if(empty($exitUniqueRecord)){
							$error_text = $error_text.' 4';
							$is_error = 1;
						}else{
							//$this->db->where("unique_id", $uniqueId);
							//$this->db->delete("tbl_form_unique_ids");
							$value=array('flag'=>1);
							$this->db->where('unique_id',$customKeyData[1]);
							$this->db->update('tbl_form_unique_ids',$value);
							
							
						}
						
					}else{
						$error_text = $error_text.' 5';
						$is_error = 1;
					}
				}
			}
			
			if($n == 0){
				$error_text = $error_text.' 6';
						$is_error = 1;
			}
		}
		
			
			if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], base_url()) !== 0) {
				
				$error_text = $error_text.' 7';
				$is_error = 1;
				
			}
				
			
			if($this->session->userdata('website_unique_id')){
				$uniqueId = $this->session->userdata('website_unique_id');
				$this->db->limit(1);
				$exitUniqueId = $this->query_model->getBySpecific( 'tbl_form_unique_ids', 'unique_id',$uniqueId);
				
				if(empty($exitUniqueId)){
					$error_text = $error_text.' 8';
					$is_error = 1;
				}else{
					//$this->db->where("unique_id", $uniqueId);
					//$this->db->delete("tbl_form_unique_ids");
				}
				
			}else{
				$error_text = $error_text.' 9';
				$is_error = 1;
			}*/
			
			if(!isset($_POST['website'])){
				$error_text = $error_text.' 10';
				$is_error = 1;
			}else{
				if(!empty($_POST['website'])){
					$error_text = $error_text.' 11';
					$is_error = 1;
				}
			}
			
			
			/*if(!isset($_POST['firstname'])){
				die("Success! Thank you for your interest. A representative will contact you within 24 hours!..");
			}else{
				if(!empty($_POST['firstname'])){
					die("Success! Thank you for your interest. A representative will contact you within 24 hours!..");
				}
			}*/
			
			
			if(!isset($_POST['fax'])){
				$error_text = $error_text.' 12';
				$is_error = 1;
			}else{
				if(!empty($_POST['fax'])){
					$error_text = $error_text.' 13';
					$is_error = 1;
				}
			}
			
			
			
			if(!isset($_POST['comment'])){
				$error_text = $error_text.' 14';
				$is_error = 1;
			}else{
				if(!empty($_POST['comment'])){
					$error_text = $error_text.' 15';
					$is_error = 1;
				}
			}
			
			
			
			if(isset($_POST['contact_me_by_phone'])){
				$error_text = $error_text.' 16';
				$is_error = 1;
			}
			
		  
			
			
			
			
			if(isset($data['last_name']) && !empty($data['last_name'])){
				$error_text = $error_text.' 17';
				$is_error = 1;
			}	
			
			$site_settings = $this->query_model->getbyTable("tblsite");
			//echo '<pre>site_settings'; print_r($site_settings);
			$check_phone_number = 0;
			if($site_settings[0]->international_phone_fields != 1){
				if($site_settings[0]->phone_required == 1){
					if(isset($data['bday_phone']) && !empty($data['bday_phone'])){
						
						preg_match_all('!\d+!', $data['bday_phone'], $matches);
						
						if(isset($matches[0][0]) && !empty($matches[0][0])){
							if($matches[0][0] <= 200){
								$error_text = $error_text.' 18';
								$is_error = 1;
							}
						}
						
						$check_phone_number = 1;
						
					}else{
						$error_text = $error_text.' 19';
						$is_error = 1;
					}
				}else{
					if(isset($data['bday_phone']) && !empty($data['bday_phone'])){
						preg_match_all('!\d+!', $data['bday_phone'], $matches);
						
						if(isset($matches[0][0]) && !empty($matches[0][0])){
							if($matches[0][0] <= 200){
								$error_text = $error_text.' 20';
								$is_error = 1;
							}
						}
						
						$check_phone_number = 1;
					}
				}
				
				
				if($check_phone_number == 1){
					if(strlen($data['bday_phone']) == 14){
						if($data['bday_phone']{0} == "(" && $data['bday_phone']{4} == ")" && $data['bday_phone']{5} == " ")
						{
							
						}else{
							$error_text = $error_text.' 21';
							$is_error = 1;
						}
						 
					}else{
						$error_text = $error_text.' 22';
						$is_error = 1;
					}
				}
				
			}else{
				
				if(isset($data['bday_phone'])){
					if($site_settings[0]->international_phone_masking == 1){
						if(!empty($site_settings[0]->international_phone_masking_format)){
							if(strlen($site_settings[0]->international_phone_masking_format) >= strlen($data['bday_phone'])){
							//if(strlen($site_settings[0]->international_phone_masking_format) >= strlen($data['phone']) || strlen($site_settings[0]->international_phone_masking_format) == (strlen($data['phone'])+1)){
								$lastSpaceadmin = strrpos($site_settings[0]->international_phone_masking_format," ");
								$lastSpacefront = strrpos($data['bday_phone']," ");
								
								$admin_phone_code = explode(' ',$site_settings[0]->international_phone_masking_format);
								$count_admin_phone_code = isset($admin_phone_code[0]) ? strlen($admin_phone_code[0]) : '';
								
								$form_phone_code = explode(' ',$site_settings[0]->international_phone_masking_format);
								$count_form_phone_code = isset($admin_phone_code[0]) ? strlen($admin_phone_code[0]) : '';
								
								
								$is_code_match = 0;
								if($count_admin_phone_code == $count_form_phone_code){
									$count_code = $count_admin_phone_code - 1;
									for($i = 0; $i <= $count_code; $i++){
										if($data['bday_phone']{$i} == $site_settings[0]->international_phone_masking_format{$i}){
											$is_code_match = 1;
										}else{
											$is_code_match = 0;
										}
									}	
								}
								
								
								
								if($is_code_match == 1 && $lastSpaceadmin == $lastSpacefront){
									//die('sucs');
								}else{
									$error_text = $error_text.' 23';
									$is_error = 1;
								}
							}else{
								$error_text = $error_text.' 24';
								$is_error = 1;
							}
						}
					}
				}
			}
			
			
			
			
			 $formData = $this->setFormDataValueInFormat($_POST);
			
			// hunney pot code for check country by ip address
			
			$is_paid_form = (isset($_POST['amount']) && $_POST['amount'] > 0) ? 1 : 0;
			$is_paid_form = 0;
			if($is_paid_form == 0 && $is_error == 0){
				
				$this->db->select('allow_countries');
				$allow_countries = $this->query_model->getbyTable("tblsite");
				if($allow_countries[0]->allow_countries == 1){
					
					$ipAddress = $this->query_model->getCountryNameToIpAddress();
					$ipAddressCountry = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
					
					if(!empty($ipAddressCountry)){
						
						$this->db->where('status',1);
						$countries = $this->query_model->getbyTable("tbl_countries");
						$countryArr = array();
						if(!empty($countries)){
							foreach($countries as $country){
								$countryArr[$country->id] = $country->country_name;
							}
						}
						
						
						if(!empty($countryArr)){
							if(in_array($ipAddressCountry,$countryArr)){
								// write some code here
							}else{
								 $error_text = $error_text.' 27'; 
								 $is_error = 1;
								 $is_country_error = 1;
							}
						}
					}
					
					
					if($is_country_error == 1){
						
						
						//$formData = $this->setFormDataValueInFormat($_POST);
						
						$insertDataArr['name'] = isset($_POST['bday_name']) ? $_POST['bday_name'] : '';
						$insertDataArr['email'] = isset($_POST['bday_email']) ? $_POST['bday_email'] : '';
						$insertDataArr['phone'] = isset($_POST['bday_phone']) ? $_POST['bday_phone'] : '';
						$insertDataArr['program'] = isset($formData['program']) ? $formData['program'] : '';
						$insertDataArr['school'] = isset($formData['location']) ? $formData['location'] : '';
						$insertDataArr['message'] = isset($formData['message']) ? $formData['message'] : '';
						$insertDataArr['trial_name'] = isset($formData['trial_name']) ? $formData['trial_name'] : '';
						$insertDataArr['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
						$insertDataArr['ip_address'] = isset($ipAddress['client_ip_address']) ? $ipAddress['client_ip_address'] : '';
						$insertDataArr['country_name'] = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
						$insertDataArr['created_at'] = date('Y-m-d H:i:s');
						//echo '<prE>insertDataArr'; print_r($insertDataArr); die;
						$this->query_model->insertData("tbl_sp_leads", $insertDataArr);
						
					}
					
				}
			}
			
		
		$spam_check_api = $this->query_model->getbyTable("tbl_spam_api");
		if(!empty($spam_check_api) && $spam_check_api[0]->type == 1 && $is_error == 0){
			
			if($is_paid_form == 0){
				
				if($is_country_error == 0){
						$ipAddress = $this->query_model->getCountryNameToIpAddress();
						$client_ip_address = isset($ipAddress['client_ip_address']) ? $ipAddress['client_ip_address'] : '';
						
						$email = isset($_POST['bday_email']) ? $_POST['bday_email'] : '';
						//$client_ip_address = '46.165.245.154';
						$network_type = '';
						$country = '';
						
						$url = "https://api.cleantalk.org/?method_name=spam_check&auth_key=".$spam_check_api[0]->api_key."&email=".$email."&ip=".$client_ip_address;
						//echo $url; die;	
						$request = curl_init($url); // initiate curl object
						curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
						curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
						
						curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
						curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
						curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

						$response = (string)curl_exec($request); // execute curl post and store results in $response
						$error_msg = curl_error($request);
						curl_close($request); // close curl object
						
						
						if(!empty($response)){
							
							$response_data = json_decode($response, true);
							//echo '<prE>response_data'; print_r($response_data); die;
							if(isset($response_data['data'][$client_ip_address]) && !empty($response_data['data'][$client_ip_address])){
								if(isset($response_data['data'][$client_ip_address]['appears'])){
									if($response_data['data'][$client_ip_address]['appears'] == 1){
										$country = isset($response_data['data'][$client_ip_address]['country']) ? $response_data['data'][$client_ip_address]['country'] : '';
										$network_type = isset($response_data['data'][$client_ip_address]['network_type']) ? $response_data['data'][$client_ip_address]['network_type'] : '';
										$error_text = $error_text.' 30'; 
										 $is_error = 1;
										 $is_spamcheck_error = 1;
										 
									}
								}else{
									$error_text = $error_text.' 31'; 
									 $is_error = 1;
									 $is_spamcheck_error = 1;
								}
							}else{
								$error_text = $error_text.' 32'; 
								 $is_error = 1;
								 $is_spamcheck_error = 1;
							}
						}else{
							$error_text = $error_text.' 33'; 
							 $is_error = 1;
							 $is_spamcheck_error = 1;
						}
						
						if($is_spamcheck_error == 1){
						
							$insertDataArr['name'] = isset($_POST['bday_name']) ? $_POST['bday_name'] : '';
							$insertDataArr['email'] = isset($_POST['bday_email']) ? $_POST['bday_email'] : '';
							$insertDataArr['phone'] = isset($_POST['bday_phone']) ? $_POST['bday_phone'] : '';
							$insertDataArr['program'] = isset($formData['program']) ? $formData['program'] : '';
							$insertDataArr['school'] = isset($formData['location']) ? $formData['location'] : '';
							$insertDataArr['message'] = isset($formData['message']) ? $formData['message'] : '';
							$insertDataArr['trial_name'] = isset($formData['trial_name']) ? $formData['trial_name'] : '';
							$insertDataArr['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
							$insertDataArr['ip_address'] = isset($ipAddress['client_ip_address']) ? $ipAddress['client_ip_address'] : '';
							$insertDataArr['country_name'] = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
							$insertDataArr['spam_api_country_name'] = $country;
							$insertDataArr['ip_network_type'] = $network_type;
							$insertDataArr['created_at'] = date('Y-m-d H:i:s');
							//echo '<pre>insertDataArr'; print_r($insertDataArr); die;
							$this->query_model->insertData("tbl_sp_leads", $insertDataArr);
							
						}
						
				}

			}
		}
		
			
			
			//echo $error_text.'===>'.$is_error; die;
			
			
		if($is_error == 1){
			
			$hunneypot_error_msg = array('hunneypot_error_msg' => $error_text);
			
			$this->session->set_userdata($hunneypot_error_msg);
			
			redirect(@base_url().'site/thank_you');
		}
			
	}
	
	
	
	
	
	public function phoneNumberMaxLength(){
		$this->db->select(array('international_phone_fields'));
		$setting = $this->query_model->getbyTable('tblsite');
		
		$max_length = 14;
		if($setting[0]->international_phone_fields == 1){
			$max_length = 20;
		}
		
		return $max_length;
	}

	public function getPhoneNumberClass(){
		$phone_number_class = '';
		$this->db->select(array('international_phone_fields','international_phone_masking'));
		$setting = $this->query_model->getbyTable('tblsite');
		
		if($setting[0]->international_phone_fields != 1){
			$phone_number_class = 'phone_number';
		}elseif($setting[0]->international_phone_fields == 1 && $setting[0]->international_phone_masking == 1){
			$phone_number_class = 'international_phone_number';
		}
		
		return $phone_number_class;
	}
	
	public function getViemoVideoImage($v_id){
			$img_src = base_url().'images/video_album_cover.jpg';
			$url="https://vimeo.com/api/oembed.json?url=https%3A//vimeo.com/".$v_id;
			
			$request = curl_init($url); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				
				curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
				curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

				$response = (string)curl_exec($request); // execute curl post and store results in $response
				$error_msg = curl_error($request);
				curl_close($request); // close curl object
				
				if(!empty($response)){
					
					$vimeoData = json_decode($response);
					$img_src = isset($vimeoData->thumbnail_url) ? $vimeoData->thumbnail_url : $img_src;
				}
				
			//echo $img_src; die;
			return $img_src;	
			
			/*$vimeoData=file_get_contents($url);
			$vimeoData = json_decode($vimeoData);
			
			$img_src = isset($vimeoData->thumbnail_url) ? $vimeoData->thumbnail_url : '0';
			
			return $img_src;*/
	}
	
	
	// form module frontend
	
	public function checkFormModuleApplyAPI($postData){
			
			$page_url = isset($postData['page_url']) ? $postData['page_url'] : '';
			
			$page_url = $this->query_model->reconstruct_url($page_url);
			
			$page_url = $this->query_model->getFormPageUrl($page_url,$postData);
			
			
			// getting form instance by page url 
			if(isset($postData['trial_offer_cat_id']) && !empty($postData['trial_offer_cat_id'])){
				$this->db->where("action_id",$postData['trial_offer_cat_id']);
			}
			$formInstance = $this->query_model->getbySpecific('tbl_form_instances', 'page_url', $page_url);
			
			//echo '<pre>formInstance'; print_r($formInstance); die;
			
			$this->session->set_userdata('is_mat_api_apply',0);
			
			if(!empty($formInstance)){
				
				
				// geeting form model id if not empty form instance
				$form_model_id = isset($formInstance[0]) ? $formInstance[0]->form_module_id : '';
				
				// getting form model detail by form model id
				$formModelDetail = $this->query_model->getbySpecific('tbl_form_modules', 'id', $form_model_id);
				
				//echo '<pre>formModelDetail'; print_r($formModelDetail); die;
				if(!empty($formModelDetail)){
					
					$connectedTypesArr = !empty($formModelDetail[0]->connected_type) ? explode(', ',$formModelDetail[0]->connected_type) : '';
					
				  if(!empty($connectedTypesArr)){
					  
				   foreach($connectedTypesArr as $connectedType){
					
					// selected active campaign tags from form module
					$activeCampaignTagsArr = !empty($formModelDetail[0]->active_campaign_tags) ? unserialize($formModelDetail[0]->active_campaign_tags) : '';
					
					$active_campaign_tags = $this->query_model->getFormModuleTags($activeCampaignTagsArr);
					
					// selected rainmaker tags from form module
					$activeRainmakerTagsArr = !empty($formModelDetail[0]->active_rainmaker_tags) ? unserialize($formModelDetail[0]->active_rainmaker_tags) : '';
					
					$active_rainmaker_tags = $this->query_model->getFormModuleTags($activeRainmakerTagsArr);
					
					// getting webhook apis//
					$webhookApisArr = array();
					
					$this->db->where('published' ,1);
					$webhook_apis = $this->query_model->getByTable('tbl_webhook_apis');
					if(!empty($webhook_apis)){
						foreach($webhook_apis as $webhook_api){
							$webhookApisArr[$webhook_api->id] = $webhook_api->api_name;
						}
					}
					
				
				
				$this->db->select('gdpr_compliant');
				$gdpr_compliant = $this->query_model->getbyTable("tblsite");
				if($gdpr_compliant[0]->gdpr_compliant == 1){
					$gdpr_compliant_checkbox = (isset($_POST['gdpr_compliant_checkbox']) && $_POST['gdpr_compliant_checkbox'] == 1) ? 1 : 0;
				}else{
					$gdpr_compliant_checkbox = 1;
				}
				
				
				
				if($gdpr_compliant_checkbox == 1){
					
					//echo $connectedType; die;
					if($connectedType == 'Active Campaign'){
						
						$this->query_model->saveWebLeadsOnActiveCampaign($postData, $active_campaign_tags, $formModelDetail);	
						
					}elseif($connectedType == 'Kicksite'){
						
						$this->query_model->saveWebLeadsOnKickSite($postData);	
						
					}elseif($connectedType == 'Rainmaker'){
						
						$this->query_model->saveWebLeadsOnRainMark($postData, $active_rainmaker_tags);
						
					}elseif($connectedType == 'MailChimp'){
						
						$this->query_model->saveWebLeadsOnMailChimp($postData, $formModelDetail);
						
					}elseif($connectedType == 'Velocify'){
						
						$this->query_model->saveWebLeadsOnVelocify($postData, $formModelDetail);
						
					}elseif($connectedType == 'Perfectmind'){
						
						$this->query_model->saveWebLeadsOnPerfectmind($postData, $formModelDetail);
						
					}elseif($connectedType == 'MyStudio'){
						
						$this->query_model->saveWebLeadsOnMyStudio($postData);	
						
					}elseif($connectedType == 'MAT'){
						
						//$this->query_model->saveWebLeadsOnMAT($postData);
						$this->session->set_userdata('is_mat_api_apply',1);
						
					}else{
						/*if(!empty($webhookApisArr) && in_array($formModelDetail[0]->connected_type, $webhookApisArr)){
							$this->query_model->saveWebLeadsOnWebhookApis($postData, $formModelDetail);
						}else{
							return true;
						} */
						
						if(!empty($webhookApisArr)){
							foreach($webhookApisArr as $webhook_api){
								//echo $webhook_api.'=======>'.$connectedType; die;
								if($webhook_api  == $connectedType){
									$this->query_model->saveWebLeadsOnWebhookApis($postData, $formModelDetail,$webhook_api);
								}
							}
						}
					}
				}
					 }
					}
				}
			}
		
	}
	
	public function getFormModuleTags($tag_ids = null){
		$tag_lists = array();
		
		if(!empty($tag_ids)){
			
			// tag ids of specify form module;
			foreach($tag_ids as $id){
				
				// getting record by tag id
				$tagDetail = $this->query_model->getbySpecific('tbl_form_tags', 'id', $id);
				
				$tag_lists[] = !empty($tagDetail) ? $tagDetail[0]->tag : '';
			}
			
		}
		
		$tags = !empty($tag_lists) ? $tag_lists : '';
		
		return $tags;
		
	}
	
	
	public function formModuleTagsInSerializeForApis($tagsLists = null){
		$tags = '';
				if(!empty($tagsLists)){
					$total_tags = count($tagsLists);
					$n = 1;
					foreach($tagsLists as $val){
						if($n < $total_tags){
							$tags .= $val.',';
						}else{
							$tags .= $val;
						}
						
					$n++;
					}
				}
		$tags = !empty($tags) ? $tags : false;
		
		return $tags;
	}
	
	
	public function saveWebLeadsOnMailChimp($postData, $formModelDetail){
		
		$check_mailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		
		// set form all values in a format way
		$formData = $this->setFormDataValueInFormat($postData);
		
		
		if(!empty($check_mailchimp) && $check_mailchimp[0]->type == 1){

			$mailchimp_type = $check_mailchimp[0]->type;

			$mailchimp_template_id = $formModelDetail[0]->mailchimp_template_id;

			$mailchimp_api_key =  $check_mailchimp[0]->api_key;

			//$mailchimp_template_id = '0096b81a9d'; // dcook3-ApollosMA
		
			include_once 'MailChimp.php';

			if (!empty($formData['name']) || !empty($formData['email'])) {
				
				$program_name = !empty($formData['program']) ? $formData['program'] : 'N/A';
				
				$trial_id = isset($postData['trial_id']) ? $postData['trial_id'] : '';
				$planDetail = $this->query_model->getTrialOfferDetailById($trial_id);
				
				$mc = new \Drewm\MailChimp($mailchimp_api_key);
				
				$full_name = (isset($formData['name']) && !empty($formData['name'])) ? trim($formData['name']) : '';
				
				$first_name = 'N/A';
				$last_name = 'N/A';
				if(!empty($full_name)){
					$user_full_name = explode(' ',$full_name);
					$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
					
					if(!empty($user_full_name)){
						unset($user_full_name[0]);
					}
					$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
				}
				
				$mvars = array('optin_ip'=> $_SERVER['REMOTE_ADDR'], 'FNAME' => $first_name,'LNAME'=>$last_name,'TRIALOFFER' =>$planDetail['trial_type'],'AMOUNT' =>$planDetail['amount'],'PROGRAM' =>$program_name,'SCHOOL' =>$formData['location']);
				
				$result = $mc->call('lists/subscribe', array(

						'id'                => $mailchimp_template_id,

						'email'             => array('email'=>$formData['email']),

						'merge_vars'        => $mvars,

						'double_optin'      => false,

						'send_welcome'      => false

					)

				);
				
				//echo '<pre>result'; print_r($result); die;
			}
		}
	}
	
	
	
	public function saveWebLeadsOnVelocify($postData, $formModelDetail){
		
		$check_velocify = $this->query_model->getbySpecific('tbl_velocify', 'id', 1);
		
		if(!empty($check_velocify) && $check_velocify[0]->type == 1){
			if(!empty($check_velocify[0]->url)){
				
				$url = $check_velocify[0]->url;
				
				// set form all values in a format way
				$formData = $this->setFormDataValueInFormat($postData);
				
				$full_name = (isset($formData['name']) && !empty($formData['name'])) ? trim($formData['name']) : '';
				
				$first_name = 'N/A';
				$last_name = 'N/A';
				if(!empty($full_name)){
					$user_full_name = explode(' ',$full_name);
					$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
					
					if(!empty($user_full_name)){
						unset($user_full_name[0]);
					}
					$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
				}
				// here we define the data we are posting in order to perform an update
				$post = array(
					'name'  => urlencode($first_name),
					'last_name' => urlencode($last_name),
					'email'  => urlencode($formData['email']),
					'phone' => urlencode($formData['phone']),
					'location' => urlencode($formData['location']),
					'program' => urlencode($formData['program']),
					'message' => urlencode($formData['message']),
					
				); 
				//echo '<prE>post'; print_r($post); die;
				
				
				  $ch = curl_init();
				  $postvars = '';
				  foreach($post as $key=>$value) {
					$postvars .=  "&".$key . "=" . $value;
				  }
				  
				  $url = $url.$postvars;
				 
				
				$request = curl_init($url); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				curl_setopt($request, CURLOPT_POSTFIELDS, $post); // use HTTP POST to send form data
				curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
				
				$response = (string)curl_exec($request); // execute curl post and store results in $response

					
				//echo '<pre>curl_getinfo==>';print_r(curl_getinfo($request));
				//echo '<pre>curl_error==>';print_r(curl_error($request));
				// additional options may be required depending upon your server configuration
				// you can find documentation on curl options at http://www.php.net/curl_setopt
				curl_close($request); // close curl object
			
				//echo '<pre>response'; print_r($response); die;
				/*if ( !$response ) {
					die('Nothing was returned. Do you have a connection to Email Marketing server?');
				} */
				
			}
		}
		

	}
	
	
	
	public function checkFormModuleAutoResponder($postData, $extraContentArr = null){
			
			$result = array();
			$formData = $this->query_model->setFormDataValueInFormat($postData);
			
			$page_url = isset($postData['page_url']) ? $postData['page_url'] : '';
		    
		    $page_url = $this->query_model->reconstruct_url($page_url);
		    
			$page_url = $this->query_model->getFormPageUrl($page_url,$postData);
			
			//$page_url = '/promo/regional-tournament-registration-2';
			//echo $page_url; die;
			
			// getting form instance by page url 
			if(isset($postData['trial_offer_cat_id']) && !empty($postData['trial_offer_cat_id'])){
				$this->db->where("action_id",$postData['trial_offer_cat_id']);
			}
			$formInstance = $this->query_model->getbySpecific('tbl_form_instances', 'page_url', $page_url);
			//echo '<prE>formInstance'; print_R($formInstance); die;
			if(!empty($formInstance)){
				// geeting form model id if not empty form instance
				$form_model_id = isset($formInstance[0]) ? $formInstance[0]->form_module_id : '';
				
				// getting form model detail by form model id
				$formModelDetail = $this->query_model->getbySpecific('tbl_form_modules', 'id', $form_model_id);
				//echo '<pre>formModelDetail'; print_r($formModelDetail); die;
				if(!empty($formModelDetail)){
					$connectedTypesArr = !empty($formModelDetail[0]->connected_type) ? explode(', ',$formModelDetail[0]->connected_type) : '';
					$connected_type = (isset($connectedTypesArr[0]) && isset($connectedTypesArr[0])) ? $connectedTypesArr[0] : '';
					
					if(!empty($connected_type)){
						// Email Response according form module connect type
						$result['admin_email'] = $this->query_model->getAutoResponderResponseToApis($connected_type, 'admin',$formModelDetail[0]->user_email_option);
						$result['customer_email'] = $this->query_model->getAutoResponderResponseToApis($connected_type, 'customer',$formModelDetail[0]->user_email_option);
						
						
						// ADMIN AUTO RESPONDER
						$adminAutoRespoder =  $this->query_model->getbySpecific('tbl_form_autoresponders', 'id', $formModelDetail[0]->admin_auto_responder_id);
						//echo '<pre>formModelDetail'; print_r($adminAutoRespoder); die;
						$result['admin_auto_responder'] = $this->query_model->getReplaceAutoRenponderContent($adminAutoRespoder, $formData, $extraContentArr);
						$result['admin_email_subject'] = $this->query_model->getReplaceAutoRenponderEmailSubject($adminAutoRespoder, $formData, $extraContentArr);
						
						//CUSTOMER AUTO RESPONDER
						$customerAutoRespoder =  $this->query_model->getbySpecific('tbl_form_autoresponders', 'id', $formModelDetail[0]->customer_auto_responder_id);
						
						$result['customer_auto_responder'] = $this->query_model->getReplaceAutoRenponderContent($customerAutoRespoder, $formData, $extraContentArr);
						$result['customer_email_subject'] = $this->query_model->getReplaceAutoRenponderEmailSubject($customerAutoRespoder, $formData, $extraContentArr);
						
						//EMAIL SIGNATURE 
						$emailSignature =  $this->query_model->getbySpecific('tbl_form_emailsignatures', 'location_id', $formModelDetail[0]->email_signature_location_id);
						
						$result['email_signature'] = $this->query_model->getReplaceAutoRenponderContent($emailSignature, $formData, $extraContentArr);
					
					}
					
				}
			}
		//echo '<pre>result'; print_r($result); die;		
		
		return $result;
	}
	
	
	public function getReplaceAutoRenponderContent($detail = null, $formData, $extraContentArr= null){
		$result = '';
		
		if(!empty($detail)){
			$description = isset($detail[0]->description) ? $detail[0]->description : $detail[0]->signature_text;
			
			$content = $this->query_model->getMetaDescReplace($description);
			
			$result = $this->query_model->replaceAutoResponderVaribles($content, $formData, $extraContentArr);
			
		}
		
		return $result;
			
	}
	
	public function getReplaceAutoRenponderEmailSubject($detail = null, $formData, $extraContentArr= null){
		$result = '';
		
		if(!empty($detail)){
			$description = $detail[0]->subject;
			
			$content = $this->query_model->getMetaDescReplace($description);
			
			$result = $this->query_model->replaceAutoResponderVaribles($content, $formData, $extraContentArr);
			
			
		}
		
		return $result;
			
	}
	
	
	public function replaceAutoResponderVaribles($content, $formData, $extraContentArr){
		
		
		$multiLocation =  $this->query_model->getbyTable("tblconfigcalendar");
		if($multiLocation[0]->field_value == 1){
			$locationDetail = $this->query_model->getbySpecific("tblcontact", 'name', $formData['location']);
			if(empty($locationDetail)){
				$locationDetail = $this->query_model->getMainLocation("tblcontact");
			}
		}else{
			$locationDetail = $this->query_model->getMainLocation("tblcontact");
		}
		
		//echo '<pre>locationDetail'; print_r($locationDetail); die;
		$locationDetail = $locationDetail[0];
		
		$site_setting = $this->query_model->getbyTable("tblsite");
		
		//Some Extra content //
	
		$dojocart_title = '';
		$dojocart_quantity = '';
		$dojocart_amount = '';
		$dojocart_coupon_name = '';
		$dojocart_custom_fields = '';
		$dojocart_coupon_discount = '';
		$upsell_list = '';
		$dojocart_item_list = '';
		$birthday_title = '';
		$birthday_msg = '';
		$payment_result = '';
		$trial_offer_name = '';
		$trial_offer_amount = '';
		$trial_offer_type = '';
		$trial_upsell_name = '';
		$trial_upsell_amount = '';
		$trial_coupon_name = '';
		$trial_coupon_discount = '';
		$bdy_reserve_or_schedule = '';
		$pdfLink = '';
		$child_name = isset($formData['child_name']) ? $formData['child_name'] : '';
		$child_age = isset($formData['child_age']) ? $formData['child_age'] : '';
		
		
		if(!empty($extraContentArr) && isset($extraContentArr)){
			$dojocart_title = isset($extraContentArr['dojocart_title']) ? $this->query_model->getMetaDescReplace($extraContentArr['dojocart_title']) : '';
			$dojocart_quantity = isset($extraContentArr['dojocart_quantity']) ? $extraContentArr['dojocart_quantity'] : '';
			$dojocart_amount = isset($extraContentArr['dojocart_amount']) ? $extraContentArr['dojocart_amount'] : '';
			$dojocart_coupon_name = isset($extraContentArr['dojocart_coupon_name']) ? $extraContentArr['dojocart_coupon_name'] : '';
			$dojocart_coupon_discount = (isset($extraContentArr['dojocart_coupon_discount']) && !empty($extraContentArr['dojocart_coupon_discount'])) ? '$'.$extraContentArr['dojocart_coupon_discount'] : '';
			$upsell_list = isset($extraContentArr['upsell_list']) ? $extraContentArr['upsell_list'] : '';
			$dojocart_item_list = isset($extraContentArr['dojocart_item_list']) ? $extraContentArr['dojocart_item_list'] : '';
			$payment_result = isset($extraContentArr['paymentResult']) ? $extraContentArr['paymentResult'] : '';
			
			
			//trial offer keywords
			$trial_offer_name = isset($extraContentArr['trial_offer_name']) ? $this->query_model->getMetaDescReplace($extraContentArr['trial_offer_name']) : '';
			$trial_offer_amount = isset($extraContentArr['trial_offer_amount']) ? $extraContentArr['trial_offer_amount'] : '';
			$trial_offer_type = isset($extraContentArr['trial_offer_type']) ? $extraContentArr['trial_offer_type'] : '';
			$trial_upsell_name = isset($extraContentArr['trial_upsell_name']) ? $this->query_model->getMetaDescReplace($extraContentArr['trial_upsell_name']) : '';
			$trial_upsell_amount = isset($extraContentArr['trial_upsell_amount']) ? $extraContentArr['trial_upsell_amount'] : '';
			$trial_coupon_name = isset($extraContentArr['trial_coupon_name']) ? $extraContentArr['trial_coupon_name'] : '';
			$trial_coupon_discount = (isset($extraContentArr['trial_coupon_discount']) && !empty($extraContentArr['trial_coupon_discount'])) ? '$'.$extraContentArr['trial_coupon_discount'] : '';
			$bdy_reserve_or_schedule = isset($extraContentArr['bdy_reserve_or_schedule']) ? $extraContentArr['bdy_reserve_or_schedule'] : '';
			
			if(isset($extraContentArr['bdy_call_or_schedule'])){
				$birthday_title = ($extraContentArr['bdy_call_or_schedule']=='call') ? 'Call Me With More Information' : 'Schedule a Birthday Party';
				
				$bdy_party_date = isset($extraContentArr['bdy_party_date']) ? $extraContentArr['bdy_party_date'] : '';
				$bdy_guest = isset($extraContentArr['bdy_guest']) ? $extraContentArr['bdy_guest'] : '';
				
				$birthday_msg = ($extraContentArr['bdy_call_or_schedule']=='schecdule') ? 'We are interested in scheduling a birthday on '.$bdy_party_date.'.</p><p>Expected number of guests is '.$bdy_guest : '';
			}
			
			
			if(isset($extraContentArr['dojocart_custom_fields']) && !empty($extraContentArr['dojocart_custom_fields'])){
					foreach($extraContentArr['dojocart_custom_fields'] as $key => $val){

							$this->db->select(array('id','label_text','type'));
							$custom_field_detail = $this->query_model->getBySpecific('tbl_dojocart_custom_fields', 'id', $key);
							
							if(!empty($custom_field_detail)){
								if($custom_field_detail[0]->type == "checkbox"){
									$dojocart_custom_fields .= $custom_field_detail[0]->label_text.': ';
									if(!empty($val)){
										$i = 1;
										foreach($val as $k => $v){
											$dojocart_custom_fields .= ($i < count($val)) ? $v.', ' : $v;
										$i++;
										}
										$dojocart_custom_fields .= '<br/>';
									}
									
								}else{
									$dojocart_custom_fields .= $custom_field_detail[0]->label_text.': '.$val.'<br/>';
								}
								
							}
							
						}
				}
			
			if(isset($extraContentArr['pdfLink']) && !empty($extraContentArr['pdfLink'])){
				$pdf_url = $extraContentArr['pdfLink'];
				$pdfLink = '<a href="'.$pdf_url.'">Click here to view this in a printable form</a>';
			}
		}
		$dojocart_custom_fields = !empty($dojocart_custom_fields) ? trim($dojocart_custom_fields) : '';
		//echo $dojocart_custom_fields; die;
		
		$result = str_replace(
							array('#FIRSTNAME', '#LASTNAME', '#EMAIL', '#PHONE', '#LOCATION', '#PROGRAM', '#MESSAGE', '#SITE_TITLE','#CONTACT_NAME', '#CONTACT_ADDRESS', '#CONTACT_SUITE', '#CONTACT_CITY', '#CONTACT_STATE', '#CONTACT_ZIP', '#CONTACT_PHONE', '#DOJOCART_TITLE', '#DOJOCART_UPSELLS_LIST', '#DOJOCART_AMOUNT', '#DOJOCART_QUANTITY', '#BIRTHDAY_PARTY_TITLE', '#BIRTHDAY_CALL_OR_SCHEDULE','#PAYMENT_RESULT','#TRIAL_NAME','#TRIAL_TYPE','#TRIAL_AMOUNT','#TRIAL_UPSELL_NAME','#TRIAL_UPSELL_AMOUNT','#TRIAL_COUPON_NAME','#TRIAL_COUPON_DISCOUNT','#DOJOCART_COUPON_NAME','#DOJOCART_COUPON_DISCOUNT','#DOJOCART_CUSTOM_FIELDS','#SUMMER_CAMP_RESERVE_OR_SECHEDULE','#PRINT_PDF','#DOJOCART_MULTI_ITEMS_LIST','#CHILD_NAME','#CHILD_AGE'),
							array($formData['name'], $formData['last_name'], $formData['email'], $formData['phone'], $formData['location'], $formData['program'], $formData['message'], $site_setting[0]->title, $locationDetail->name, $locationDetail->address, $locationDetail->suite, $locationDetail->city, $locationDetail->state, $locationDetail->zip, $locationDetail->phone,$dojocart_title,$upsell_list,$dojocart_amount,$dojocart_quantity, $birthday_title, $birthday_msg,$payment_result,$trial_offer_name,$trial_offer_type,$trial_offer_amount,$trial_upsell_name,$trial_upsell_amount,$trial_coupon_name,$trial_coupon_discount,$dojocart_coupon_name,$dojocart_coupon_discount,$dojocart_custom_fields,$bdy_reserve_or_schedule,$pdfLink,$dojocart_item_list,$child_name,$child_age), 
							$content
							);
		
		
		return $result;
	}
	
	public function getAutoResponderResponseToApis($connect_type, $user_type,$user_email_option){
		$result = 0;
		
		if(!empty($connect_type)){
			
			/*if($connect_type == "Kicksite" || $connect_type == "Rainmaker"){
				$result = 1;
			}elseif($connect_type == "MailChimp"){
				$result = ($user_type == 'admin') ? 1 : 0;
			}elseif($connect_type == "Active Campaign"){
				$result = 0;
			}	*/
				
			if($connect_type == "Active Campaign" || $connect_type == "MailChimp" || $connect_type == "Kicksite" || $connect_type == "Rainmaker" || $connect_type == "Velocify" || $connect_type == "MyStudio" || $connect_type == "MAT"){
				$result = 1;
				if($user_type == "customer"){
					$result = ($user_email_option == 1) ? 1: 0;
				}
			}elseif($connect_type == "local"){
				$result = 1;
			}elseif($connect_type == "No AutoResponders"){
				$result = ($user_type == 'admin') ? 1 : 0;
			}else{
				// getting webhook apis//
				$webhookApisArr = array();
				
				$this->db->where('published' ,1);
				$webhook_apis = $this->query_model->getByTable('tbl_webhook_apis');
				if(!empty($webhook_apis)){
					foreach($webhook_apis as $webhook_api){
						$webhookApisArr[$webhook_api->id] = $webhook_api->api_name;
					}
				}
				
				if(!empty($webhookApisArr) && in_array($connect_type, $webhookApisArr)){
					$result = 1;
				}
				
			}
		}
		
		return $result;
	}
	
	
	public function getConatctPageSlug($location_id = null){
		
		$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
		
		$multiLocation =  $this->query_model->getbyTable("tblconfigcalendar");
		if($multiLocation[0]->field_value == 1){
			if(!empty($location_id)){
				$locationDetail = $this->query_model->getbySpecific('tblcontact', 'id', $location_id);
			}else{
				$locationDetail = $this->query_model->getMainLocation();
			}
			$url = !empty($locationDetail) ? '/'.$contact_slug[0]->slug.'/'.$locationDetail[0]->slug : '/';
		}else{
			$locationDetail = $this->query_model->getMainLocation("tblcontact");
			$url = !empty($locationDetail) ? '/'.$contact_slug[0]->slug : '/';
		}
		
		return $url;
	}
	
	public function getExtraContent($content = null){
		
		return $content;
	}
	
	// getting trial offer detail by trial id
	public function getTrialOfferDetailById($trial_id = null){
		$result  = array();
		$result['trial_type'] = 'N/A';
		$result['amount'] = '';
		if(!empty($trial_id)){
			$detail  =$this->query_model->getBySpecific($this->query_model->getTrialSpecialOffersTableName(), 'id', $trial_id);
			if(!empty($detail)){
				$result['trial_type'] = ($detail[0]->trial == 1) ? 'PAID' : 'FREE';
				$result['amount'] = ($detail[0]->trial == 1) ? $detail[0]->amount : '';
			}
		}
		
		return $result;
	}
	
	
	
	
	// 18 april 2017 form module function//
	public function getFormIntancesForTags($tag_id, $tag_type){
		$form_instances = array();
		
		
		if($tag_type == 'active_campaign'){
			$this->db->where('active_campaign_tags != ', '');
			$form_modules = $this->query_model->getByTable('tbl_form_modules');
		}elseif($tag_type == 'rainmaker'){
			$this->db->where('active_rainmaker_tags != ', '');
			$form_modules = $this->query_model->getByTable('tbl_form_modules');
		}elseif($tag_type == "webhook_outgoing_apis"){
			$this->db->where('email_webhook_api_tags != ', '');
			$this->db->or_where('crm_webhook_api_tags != ', ''); 
			$form_modules = $this->query_model->getByTable('tbl_form_modules');
		}
		
		if(!empty($form_modules)){
			foreach($form_modules as $form_module){
				$connectedTypesArr = !empty($form_module->connected_type) ? explode(', ',$form_module->connected_type) : '';
				
				if(!empty($connectedTypesArr)){
					if($tag_type == 'active_campaign' && in_array('Active Campaign',$connectedTypesArr)){
						$active_campaign_tags = !empty($form_module->active_campaign_tags) ? unserialize($form_module->active_campaign_tags) :'';
						if(!empty($active_campaign_tags) && in_array($tag_id, $active_campaign_tags)){
							$form_instances[] = $form_module;
						}
					}elseif($tag_type == 'rainmaker' && in_array('Rainmaker',$connectedTypesArr)){
						$rainmakerTags = !empty($form_module->active_rainmaker_tags) ? unserialize($form_module->active_rainmaker_tags) :'';
						
						if(!empty($rainmakerTags) && in_array($tag_id, $rainmakerTags)){
							$form_instances[] = $form_module;
						}
					}elseif($tag_type == "webhook_outgoing_apis"){
						$tagDetail = $this->query_model->getBySpecific('tbl_form_tags','id',$tag_id);
						if(!empty($tagDetail)){
							$connectedWebhooks = !empty($tagDetail[0]->webhook_apis) ? unserialize($tagDetail[0]->webhook_apis) : '';
							if(!empty($connectedWebhooks)){
								foreach($connectedWebhooks as $webhook_id){
									$webhookDetail = $this->query_model->getBySpecific('tbl_webhook_apis','id',$webhook_id);
									
									if(!empty($webhookDetail)){
										if(in_array($webhookDetail[0]->api_name,$connectedTypesArr)){
											if($webhookDetail[0]->api_type == "Email Auto-Responders"){
												$email_webhook_api_tags = !empty($form_module->email_webhook_api_tags) ? unserialize($form_module->email_webhook_api_tags) :'';
											
												if(!empty($email_webhook_api_tags) && in_array($tag_id, $email_webhook_api_tags)){
													$form_instances[] = $form_module;
												}
											}elseif($webhookDetail[0]->api_type == "CRM"){
												$crm_webhook_api_tags = !empty($form_module->crm_webhook_api_tags) ? unserialize($form_module->crm_webhook_api_tags) :'';
											
												if(!empty($crm_webhook_api_tags) && in_array($tag_id, $crm_webhook_api_tags)){
													$form_instances[] = $form_module;
												}
											}
											
										}
									}
									
									//echo '<pre>webhookDetail'; print_r($webhookDetail); die;
								}
							}
						}
					}
				}
				
			}
		}
		//echo '<pre>form_instances'; print_r($form_instances); die;
		return $form_instances;
	}
	
	
	
	
	
	public function saveWebLeadsOnWebhookApis($postData, $formModelDetail,$connected_type){
		
		
		
		// set form all values in a format way
		$formData = $this->setFormDataValueInFormat($postData);
		
		if(!empty($formModelDetail)){
			$formModelDetail =  $formModelDetail[0];
			
			$multiWebhook = $this->query_model->checkMultiWebhookIsOn();
			
			
			$webhookApiDetail = $this->query_model->getBySpecific('tbl_webhook_apis', 'api_name', $connected_type);
			
			if($multiWebhook == 1){
				$mainWebhookApiDetail = $this->query_model->getBySpecific('tbl_webhook_apis', 'api_name', $connected_type);
				
				if(!empty($mainWebhookApiDetail)){
					//echo $mainWebhookApiDetail[0]->id.'===>'.$postData['location_id']; die;
					if(isset($formData['selected_location_id']) && !empty($formData['selected_location_id'])){
						$this->db->where('location_id',$formData['selected_location_id']);
						$webhookApi = $this->query_model->getBySpecific('tbl_webhook_apis', 'parent_id', $mainWebhookApiDetail[0]->id);
						
						if(!empty($webhookApi)){
							$webhookApiDetail = $webhookApi;
						}
					}
					
				}
				
			}
			
			
			if(!empty($webhookApiDetail)){
				$webhookApiKeyValues = $this->query_model->getBySpecific('tbl_webhook_api_key_value', 'webook_api_id', $webhookApiDetail[0]->id);
				
				
				// saving data from curl on webhook apis
				
				$url = $webhookApiDetail[0]->api_url;
				
				$full_name = (isset($formData['name']) && !empty($formData['name'])) ? trim($formData['name']) : '';
				
				$first_name = 'N/A';
				$last_name = 'N/A';
				if(!empty($full_name)){
					$user_full_name = explode(' ',$full_name);
					$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
					
					if(!empty($user_full_name)){
						unset($user_full_name[0]);
					}
					$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
				}
				
				
				
				if(!empty($webhookApiDetail[0]->name_key)){
					if($webhookApiDetail[0]->name_key == "ma_fullname"  || $webhookApiDetail[0]->api_name == "WinnerMA CRM"){
						$post[$webhookApiDetail[0]->name_key] = !empty($full_name) ? $full_name : 'N/A';
					}else{
						$post[$webhookApiDetail[0]->name_key] = $first_name;
					}
				}
				
				if(!empty($webhookApiDetail[0]->last_name_key)){
					$post[$webhookApiDetail[0]->last_name_key] = $last_name;
				}
				
				if(!empty($webhookApiDetail[0]->email_key)){
					$post[$webhookApiDetail[0]->email_key] = isset($formData['email']) ? $formData['email'] : '';
				}
				
				if(!empty($webhookApiDetail[0]->phone_key)){
					$post[$webhookApiDetail[0]->phone_key] = isset($formData['phone']) ? $formData['phone'] : '';
				}
				
				if(!empty($webhookApiDetail[0]->location_key)){
					$post[$webhookApiDetail[0]->location_key] = isset($formData['location']) ? $formData['location'] : '';
				}
				if(!empty($webhookApiDetail[0]->message_key)){
					$post[$webhookApiDetail[0]->message_key] = isset($formData['message']) ? $formData['message'] : '';
				}
				
				if(!empty($webhookApiDetail[0]->program_key)){
					$post[$webhookApiDetail[0]->program_key] = isset($formData['program']) ? $formData['program'] : '';
				}
				
				if(!empty($webhookApiDetail[0]->trial_name_key)){
					$post[$webhookApiDetail[0]->trial_name_key] = isset($formData['trial_name']) ? $formData['trial_name'] : '';
				}
				
				if(!empty($webhookApiDetail[0]->trial_type_key)){
					$post[$webhookApiDetail[0]->trial_type_key] = isset($formData['trial_type']) ? $formData['trial_type'] : '';
				}
				
				if(!empty($webhookApiDetail[0]->total_amount_key)){
					$post[$webhookApiDetail[0]->total_amount_key] = isset($formData['total_amount']) ? $formData['total_amount'] : '';
				}
				
				if(!empty($webhookApiDetail[0]->page_url_key)){
					$post[$webhookApiDetail[0]->page_url_key] = isset($postData['page_url']) ? base_url() : '';
				}
				
				
				
				
				if(!empty($webhookApiDetail[0]->tag_key)){
					//$post[$webhookApiDetail[0]->tag_key] = (isset($webhookApiDetail[0]->tag_values) && !empty($webhookApiDetail[0]->tag_values)) ? $webhookApiDetail[0]->tag_values : ''; 
					
					if($webhookApiDetail[0]->api_type == "Email Auto-Responders"){
						$email_webhook_api_tags = (isset($formModelDetail->email_webhook_api_tags) && !empty($formModelDetail->email_webhook_api_tags)) ? unserialize($formModelDetail->email_webhook_api_tags) : ''; 
						
						$emailWebhookTagsArr = array();
						if(!empty($email_webhook_api_tags)){
							foreach($email_webhook_api_tags as $email_webhook_api_tag){
								$this->db->select('tag');
								$this->db->where('tag_type','webhook_outgoing_apis');
								$tagDetail = $this->query_model->getBySpecific('tbl_form_tags','id',$email_webhook_api_tag);
								if(!empty($tagDetail)){
									$emailWebhookTagsArr[] = !empty($tagDetail[0]->tag) ? $tagDetail[0]->tag  : '';
								}
								
							}
							
							$post[$webhookApiDetail[0]->tag_key] = !empty($emailWebhookTagsArr) ? implode(',',$emailWebhookTagsArr) : '';
						}
						
					}elseif($webhookApiDetail[0]->api_type == "CRM"){
						
						$crm_webhook_api_tags = (isset($formModelDetail->crm_webhook_api_tags) && !empty($formModelDetail->crm_webhook_api_tags)) ? unserialize($formModelDetail->crm_webhook_api_tags) : ''; 
						
						$crmWebhookTagsArr = array();
						if(!empty($crm_webhook_api_tags)){
							foreach($crm_webhook_api_tags as $crm_webhook_api_tag){
								$this->db->select('tag');
								$this->db->where('tag_type','webhook_outgoing_apis');
								$tagDetail = $this->query_model->getBySpecific('tbl_form_tags','id',$crm_webhook_api_tag);
								
								if(!empty($tagDetail)){
									$crmWebhookTagsArr[] = !empty($tagDetail[0]->tag) ? $tagDetail[0]->tag  : '';
								}
								
							}
							
							$post[$webhookApiDetail[0]->tag_key] = !empty($crmWebhookTagsArr) ? implode(',',$crmWebhookTagsArr) : '';
							
					}
					
				}
				
				
				if(isset($formData['program']) && !empty($formData['program'])){
					if($connected_type == "Spark"){
						$post[$webhookApiDetail[0]->tag_key] = (isset($post[$webhookApiDetail[0]->tag_key]) && !empty($post[$webhookApiDetail[0]->tag_key])) ? $post[$webhookApiDetail[0]->tag_key].', '.$formData['program'] : $formData['program'];
					}
					
				}
				
				}
				
				
				/*$post = array(
						$webhookApiDetail[0]->name_key => $formData['name'],
						$webhookApiDetail[0]->last_name_key => $formData['last_name'],
						$webhookApiDetail[0]->email_key => $formData['email'],
						$webhookApiDetail[0]->phone_key => $formData['phone'],
						$webhookApiDetail[0]->location_key => $formData['location'],
						$webhookApiDetail[0]->message_key => $formData['message'],
						$webhookApiDetail[0]->program_key => $formData['program'],
						); */
				//echo '<pre>post'; print_r($post); die;
				$params = array();
				if(!empty($webhookApiKeyValues)){
					foreach($webhookApiKeyValues as $api_key_value){
						$params[$api_key_value->keys] = $api_key_value->values;
						$post[$api_key_value->keys] = $api_key_value->values;
					}
				}
		
		$curlHeader = 0;
		if($webhookApiDetail[0]->api_name == "WinnerMA CRM"){
			
					$formDataArr = array();
					$requestDataArr = array();
					if(!empty($post)){
						$i = 1;
						foreach($post as $key => $value){
							if($key != "secret_key"){
								$formDataArr[$i]['key'] = $key;
								
								if($key == "phone"){
									if(!empty($value)){
										$formDataArr[$i]['value'] = preg_replace('/[^0-9]/', '', $value);
									}else{
										$formDataArr[$i]['value'] = 1234567890;
									}
									
								}elseif($key == "full_name" && $value == "N/A"){
									
									$formDataArr[$i]['value'] = "Website Dojo";
									$full_name = $formDataArr[$i]['value'];
								}else{
									$formDataArr[$i]['value'] = $value;
								}
								
								$formDataArr[$i]['type'] = "text";
							$i++;
							}
							
						}
					}
					
					$email = isset($formData['email']) ? $formData['email'] : '';
					$secret_key = isset($params['secret_key']) ? $params['secret_key'] : '';
					$formDataArr[$i]['key'] = "signature";
					$formDataArr[$i]['value'] = hash_hmac( 'sha256', sprintf('%s%s', $full_name, $email), $secret_key );
					$formDataArr[$i]['type'] = "text";
					
					$post = $formDataArr;
					$apiUrl = $url;
					$data = "";
					
					foreach( $post as $key => $value ) $data .= urlencode($value['key']) . '=' . urlencode($value['value']) . '&';
					$data = rtrim($data, '& ');
					
					
					$dataString = json_decode($data);
					$curlHeader =  array(
									'Expect:',
									"Accept: */*",
									"Content-Length: ".$dataString,
									"Content-Type: multipart/form-data;",
									"Host: adm.winnersmartialarts.com"
									);
					
				}else{	
					if($webhookApiDetail[0]->api_method == "GET"){
						$query = "";
						if(!empty($params)){
							foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
							$query = rtrim($query, '& ');
						}
						
						$data = "";
						foreach( $post as $key => $value ) $data .= urlencode($key) . '=' . urlencode($value) . '&';
						$query = rtrim($data, '& ');
						
						$apiUrl = $url .'?'. $query;
						
					}else{
						
				
						// This section takes the input data and converts it to the proper format
						$data = "";
						foreach( $post as $key => $value ) $data .= urlencode($key) . '=' . urlencode($value) . '&';
						$data = rtrim($data, '& ');
						
						$apiUrl = $url;
					}
				}
			//echo $apiUrl; die;	
				
				// define a final API request - GET
				//$apiUrl = $url . $query;
				//$apiUrl = $url;
				$request = curl_init($apiUrl); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, $curlHeader); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				if($webhookApiDetail[0]->api_method == "POST"){
					curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
				}
				curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
				curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

				$response = (string)curl_exec($request); // execute curl post and store results in $response

				curl_close($request); // close curl object
				
				//echo '<prE>formDataArr'; print_r($formDataArr);
				if(!empty($response)){
					//echo '<pre>response'; print_r($response); die;
				}else{
					
				}

			//die('pass');
				
			}
			
		}
		
	}
	
	
	

	public function getOtherPagePermissions($user_id, $page_link){
		$permission = 0;
		
		$this->db->where('user_id', $user_id);
		$user_permissions =  $this->query_model->getByTable('tbllinks');
			if($this->session->userdata("user_level") != 1){
			if(!empty($user_permissions) && !empty($user_permissions[0]->slug)){
				$userAllPermissions = explode('$',$user_permissions[0]->slug);
				
				if(!empty($userAllPermissions)){
					foreach($userAllPermissions as $userAllPermission){
						$u_permissions = explode(',',$userAllPermission);
						
						if(!empty($u_permissions)){
							foreach($u_permissions as $u_permission){
								$links = explode(':',$u_permission);
								if(isset($links[1]) && !empty($links[1])){
									if($page_link == $links[1]){
										$permission = 1;
									}
								}else{
									if($page_link == $links[0]){
										$permission = 1;
									}
								}
							}
						}
					}
					
				}
			}
		}else{
			$permission = 1;
		}
			return $permission;
		}
		
		
	public function getSecureHost(){
		$query = $this->db->get_where('tblsite', array( 'id' => 1));
		$site_settings = $query->row_array();
		$check_http = $site_settings['https'];
		$secureHost = ($check_http == 1) ? "https://" : 'http://';
		
		return $secureHost;
	}
	
	
	public function showCouponBoxForTrialOffers($trial_cat_id){
			$result = 0;
			if(!empty($trial_cat_id)){
				$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
				$this->db->where('display_trial',1);
				 $this->db->where('cat_id',$trial_cat_id);
				 $trialOffers = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 1);
				 
				 if(!empty($trialOffers)){
					 //$this->db->where('trial_offers !=','');
					 $promoCodes = $this->query_model->getbySpecific('tbl_onlinespecial_promo_codes', 'published', 1);
					 
					 if(!empty($promoCodes)){
						 foreach($promoCodes as $promo_code){
							if($promo_code->connect_to_trials == "all_trials"){
								$result = 1;
							}else{
								if(!empty($promo_code->trial_offers)){
									$offers = unserialize($promo_code->trial_offers);
									foreach($trialOffers as $trial_offer){
										if(in_array($trial_offer->id, $offers)){
											$result = 1;
										}
									}
								}
								
							}
							
						 }
					 }
					
				}
			}
		return $result;
	}
	
	
	public function getFormModuleThankYouPage($postData, $trial_type = null){
		
			$result = array();
			$result['postData'] = $postData;
			$page_url = isset($postData['page_url']) ? $postData['page_url'] : '';
			
			$page_url = $this->query_model->reconstruct_url($page_url);
			
			$page_url = $this->query_model->getFormPageUrl($page_url,$postData);
			
			//unset($result['postData']['page_url']);
			if(isset($result['postData']['page_url'])){
				unset($result['postData']['page_url']);
			}
			if(isset($result['postData']['refferal'])){
				unset($result['postData']['refferal']);
			}
			
			//echo $page_url; die;
			// getting form instance by page url 
			if(isset($postData['trial_offer_cat_id']) && !empty($postData['trial_offer_cat_id'])){
				$this->db->where("action_id",$postData['trial_offer_cat_id']);
			}
			$formInstance = $this->query_model->getbySpecific('tbl_form_instances', 'page_url', $page_url);
			//echo '<pre>POST'; print_r($postData); 
			//echo '<pre>formInstance'; print_r($formInstance); 
			if(!empty($formInstance)){
				// geeting form model id if not empty form instance
				$form_model_id = isset($formInstance[0]) ? $formInstance[0]->form_module_id : '';
				
				// getting form model detail by form model id
				$formModelDetail = $this->query_model->getbySpecific('tbl_form_modules', 'id', $form_model_id);
			//echo '<pre>formModelDetail'; print_r($formModelDetail); 	
				
				if($trial_type == 'free' || $trial_type == 'paid'){
					$result['trial_id'] = $postData['trial_id'];
					$result['order_id'] = $postData['order_id'];
					$result['trial_type'] = $trial_type;
					/*if($trial_type == 'paid'){
						$result['client_id'] = $postData['client_id'];
						$result['client_token'] = $postData['client_token'];
					}*/
				}
				
				if(!empty($formModelDetail)){
					if(!empty($formModelDetail[0]->thankyou_page_id)){
						
						$result['thankyou_page_id'] = $formModelDetail[0]->thankyou_page_id;
						
					}
				}
			}
		//echo '<pre>$postData=>'; print_r($postData); 
		//echo '<pre>$result=>'; print_r($result); die;
		$this->session->set_userdata('thankyouPageDetail',$result);
		//echo '<pre>result'; print_r($result); 
		//echo '<pre>session=>'; print_r($this->session->userdata('thankyouPageDetail')); die;
		//return $thankyouPageDetail;
	}
	
	
	public function authorizeNetApiRequests($post_data, $mode){
		
		if($mode == "liveMode"){
			$url = 'https://api2.authorize.net/xml/v1/request.api';
		}else{
			$url = 'https://apitest.authorize.net/xml/v1/request.api';
		}
		
		$resultArr = array();
		
			$curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL => $url,
				  CURLOPT_RETURNTRANSFER => true,
				  //CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => $post_data,
				  CURLOPT_SSL_VERIFYPEER => false,
				  CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"content-type: application/json; charset=UTF-8",
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);
				
				$encoding = mb_detect_encoding($response);

				if($encoding == 'UTF-8') {
				  $response = preg_replace('/[^(\x20-\x7F)]*/','', $response);    
				} 
				
				$response = array(json_decode($response));
				
				if(!empty($response)){
					$resultArr = $response;
					//echo '<pre>response'; print_r($response); die;
					/*if(isset($response[0]->messages->resultCode) && $response[0]->messages->resultCode == "Ok"){
							$resultArr = $response[0];
						} */
					
				}
				return $resultArr;
	}
	
	
	public function str_replace_trial_upsells($data, $upsell_id){
		$metaVaribles = $this->getbyId('tblmetavariable',1);
			
			$this->db->where("published", 1);
			$allLocations = $this->getbyTable("tblcontact");
			$allLocations = count($allLocations);
			$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
			$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales",'id',$upsell_id); 
			$upsell_price = !empty($upsellDetail) ? '$'.$upsellDetail[0]->up_price : '';
			foreach($metaVaribles as $metaVarible){
				$school_name = $metaVarible->meta_school_name;
				
				$state = $metaVarible->meta_state;
				$city_state = $metaVarible->meta_city_state;
				$nearby_location1 = $metaVarible->meta_nearbylocation1;
				$nearby_location2 = $metaVarible->meta_nearbylocation2;
				$county = $metaVarible->meta_county;
				$main_martial_arts_style = $metaVarible->meta_main_martial_arts_style;
				$martial_arts_style = $metaVarible->meta_martial_arts_style;
				
				$trial_offer1 = $metaVarible->trial_offer1;
				$trial_offer2 = $metaVarible->trial_offer2;
				$main_instructor = $metaVarible->main_instructor;
				$est_year = $metaVarible->est_year;
				$city = $metaVarible->meta_city;
				$current_location = $metaVarible->current_location;
				$url = $metaVarible->url;
				$street = $metaVarible->street;
				$suite = $metaVarible->suite;
				$zip = $metaVarible->zip;
				$phone = $metaVarible->phone;
				
			}
			
			$content = str_replace(array('{school_name}','{city}','{state}','{city_state}','{nearby_location1}','{nearby_location2}','{county}','{main_martial_arts_style}','{martial_arts_style}','{locations_number}','{trial_offer1}','{trial_offer2}','{main_instructor}','{est_year}','{current_location}','{url}','{street}','{suite}','{zip}','{phone}','{upsell_price}'), array($school_name,$city,$state,$city_state,$nearby_location1,$nearby_location2,$county,$main_martial_arts_style,$martial_arts_style,$allLocations, $trial_offer1, $trial_offer2, $main_instructor, $est_year,$current_location,$url,$street,$suite,$zip,$phone,$upsell_price), $data);
			
			$content = htmlspecialchars_decode($content);
			
			return $content;
	}
	
	
	
	public function getThankYouPageMessage($postData){
		//echo '<pre>postData'; print_r($postData);
			$result = array();
			$result['postData'] = $postData;
			$page_url = isset($postData['page_url']) ? $postData['page_url'] : '';
		    
		    $page_url = $this->query_model->reconstruct_url($page_url);
		    
			$page_url = $this->query_model->getFormPageUrl($page_url,$postData);
			
			//echo $page_url; die;
			if(isset($result['postData']['page_url'])){
				unset($result['postData']['page_url']);
			}
			if(isset($result['postData']['refferal'])){
				unset($result['postData']['refferal']);
			}
			// getting form instance by page url 
			if(isset($postData['trial_offer_cat_id']) && !empty($postData['trial_offer_cat_id'])){
				$this->db->where("action_id",$postData['trial_offer_cat_id']);
			}
			$formInstance = $this->query_model->getbySpecific('tbl_form_instances', 'page_url', $page_url);
			//echo '<pre>formInstance'; print_r($formInstance); die;
			if(!empty($formInstance)){
				// geeting form model id if not empty form instance
				$form_model_id = isset($formInstance[0]) ? $formInstance[0]->form_module_id : '';
				
				// getting form model detail by form model id
				$formModelDetail = $this->query_model->getbySpecific('tbl_form_modules', 'id', $form_model_id);
				
				if(!empty($formModelDetail)){
					if(!empty($formModelDetail[0]->thankyou_page_id)){
						
						$result['thankyou_page_id'] = $formModelDetail[0]->thankyou_page_id;
						
						/*$this->db->where('status',1);
						$thankyouPageDetail = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', $formModelDetail[0]->thankyou_page_id);
						
						if(!empty($thankyouPageDetail)){
							
							$result['message'] = $thankyouPageDetail[0]->description;
							
							
						} */
						
					}
				}
			}
		//echo '<pre>result'; print_R($result); die;
		//die('asfdsa');
		$this->session->set_userdata('thankyouMessage',$result);
		
		//return $thankyouPageDetail;
	}
	
	
	
	
	public function getOtherThankYouPageMessage($postData){
		
			$thankyouPageDetail = array();
			
			$page_url = isset($postData['page_url']) ? $postData['page_url'] : '';
			
			$page_url = $this->query_model->reconstruct_url($page_url);
			
			$page_url = $this->query_model->getFormPageUrl($page_url,$postData);
			// getting form instance by page url 
			if(isset($postData['trial_offer_cat_id']) && !empty($postData['trial_offer_cat_id'])){
				$this->db->where("action_id",$postData['trial_offer_cat_id']);
			}
			$formInstance = $this->query_model->getbySpecific('tbl_form_instances', 'page_url', $page_url);
			//echo '<pre>formInstance'; print_r($formInstance); die;
			if(!empty($formInstance)){
				// geeting form model id if not empty form instance
				$form_model_id = isset($formInstance[0]) ? $formInstance[0]->form_module_id : '';
				
				// getting form model detail by form model id
				$formModelDetail = $this->query_model->getbySpecific('tbl_form_modules', 'id', $form_model_id);
				
				if(!empty($formModelDetail)){
					if(!empty($formModelDetail[0]->thankyou_page_id)){
						
						$this->db->where('status',1);
						$thankyouPageDetail = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', $formModelDetail[0]->thankyou_page_id);
						
					}
				}
			}
		
		return $thankyouPageDetail;
	}
	
	
	public function changeVideoPathHttp($videoUrl){
		$query = $this->db->get_where('tblsite', array( 'id' => 1));
		$site_settings = $query->row_array();
		$check_http = $site_settings['https'];
		
		$newVideoUrl = $videoUrl;
		if($check_http == 1){
			$newVideoUrl = str_replace('http://','https://',$videoUrl);
		}else{
			$newVideoUrl = str_replace('https://','http://',$videoUrl);
		}
		
		return $newVideoUrl;

	}
	
	
	public function getAboutUsBodyId($queryString, $body_id){
		
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		
		if(isset($queryString[2]) && !empty($queryString[2])){
			if($multiLocation[0]->field_value == 1){
					$locationDetail = $this->query_model->getBySpecific("tblcontact","slug", $queryString[2]);
			}else{
				$locationDetail = $this->query_model->getBySpecific("tblcontact","main_location", 1);
			}
		}
		
		if(!empty($locationDetail)){
			$aboutHeader = $this->query_model->getBySpecific("tblaboutheader","location_id", $locationDetail[0]->id);
			$body_id = (!empty($aboutHeader) && !empty($aboutHeader[0]->body_id)) ? $aboutHeader[0]->body_id : $body_id;
		}
		
		return $body_id;
		
	}
	
	
	public function getTiralOfferBodyId($queryString, $body_id){
		
		if(isset($queryString[2]) && !empty($queryString[2])){
			$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
			$trialOffer = $this->query_model->getBySpecific("$tbl_onlinespecial_categories","slug", $queryString[2]);
			
			$body_id = (!empty($trialOffer) && !empty($trialOffer[0]->body_id)) ? $trialOffer[0]->body_id : $body_id;
		}else{
			$trialOffer = $this->query_model->getBySpecific("tbl_onlinespecial_header","id", 1);
			$body_id = (!empty($trialOffer) && !empty($trialOffer[0]->body_id)) ? $trialOffer[0]->body_id : $body_id;
		}
		
		return $body_id;
	}
	
	
	
	public function getTiralOfferBodyClass($queryString){
		$body_class = '';
		if(isset($queryString[2]) && !empty($queryString[2])){
			$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
			$trialOffer = $this->query_model->getBySpecific("$tbl_onlinespecial_categories","slug", $queryString[2]);
			
			$body_class = (!empty($trialOffer) && !empty($trialOffer[0]->body_class)) ? $trialOffer[0]->body_class : '';
		}
		return $body_class;
	}
	
	
	public function getContactUsBodyId($queryString, $body_id){
		
		if(isset($queryString[2]) && !empty($queryString[2])){
			$locationDetail = $this->query_model->getBySpecific("tblcontact","slug", $queryString[2]);
		}else{
			$locationDetail = $this->query_model->getBySpecific("tblcontact","main_location", 1);
		}
		
		if(!empty($locationDetail)){
			
			$body_id = (!empty($locationDetail) && !empty($locationDetail[0]->body_id)) ? $locationDetail[0]->body_id : $body_id;
		}
		
		return $body_id;
	}
	
	
	public function getDojocartBodyId($queryString, $body_id){
		
		if(isset($queryString[2]) && !empty($queryString[2])){
			$dojocartDetail = $this->query_model->getBySpecific("tbl_dojocarts","slug", $queryString[2]);
			
			if(!empty($dojocartDetail)){
				$body_id = (!empty($dojocartDetail) && !empty($dojocartDetail[0]->body_id)) ? $dojocartDetail[0]->body_id : $body_id;
			}
		}
		
		return $body_id;
	}
	
	
	public function getDojocartBodyClass($queryString){
		$body_class = '';
		if(isset($queryString[2]) && !empty($queryString[2])){
			
			$dojocartDetail = $this->query_model->getBySpecific("tbl_dojocarts","slug", $queryString[2]);
			
			$body_class = (!empty($dojocartDetail) && !empty($dojocartDetail[0]->body_class)) ? $dojocartDetail[0]->body_class : '';
		}
		return $body_class;
	}
	
	
	
	public function tinyImageCampressAndResize($image_full_path){
			include_once("./vendor/Tinify/Exception.php");
			include_once("./vendor/Tinify/ResultMeta.php");
			include_once("./vendor/Tinify/Result.php");
			include_once("./vendor/Tinify/Source.php");
			include_once("./vendor/Tinify/Client.php");
			include_once("./vendor/Tinify.php");
			
			$tinyjpg = $this->query_model->getbySpecific('tbl_chargify', 'id', 1);
			if(!empty($tinyjpg) && !empty($tinyjpg[0]->tinyjpg_key)){
				
				\Tinify\setKey($tinyjpg[0]->tinyjpg_key);
				// form image url 
				/* $source = \Tinify\fromUrl("https://tinypng.com/images/panda-happy.png");
				$source->toFile("upload/vnyoptimized.jpg"); */
				
				
				// from image local path
				if(!empty($image_full_path)){
					if(file_exists($image_full_path)){
						$source = \Tinify\fromFile($image_full_path);
						$source->toFile($image_full_path);
					}
				}
			}
			
			
	}
	
	
	
		
	
	public function getActiveCampaignCustomFields($activeCampaign){
		$responseArr = array();
		$responseArr['location_field'] = 0;
		$responseArr['program_field'] = 0;
		$responseArr['cost_of_trial_field'] = 0;
		$responseArr['call_or_schedule'] = 0;
		$responseArr['reserve_or_schedule'] = 0;
		// By default, this sample code is designed to get the result from your ActiveCampaign installation and print out the result
				$url = 'http://'.$activeCampaign[0]->account_name.'.api-us1.com';
				
				
				$params = array(

					// the API Key can be found on the "Your Settings" page under the "API" tab.
					// replace this with your API Key
					'api_key'      => $activeCampaign[0]->api_key,

					// this is the action that fetches a list info based on the ID you provide
					'api_action'   => 'list_field_view',

					// define the type of output you wish to get back
					// possible values:
					// - 'xml'  :      you have to write your own XML parser
					// - 'json' :      data is returned in JSON format and can be decoded with
					//                 json_decode() function (included in PHP since 5.2.0)
					// - 'serialize' : data is returned in a serialized format and can be decoded with
					//                 a native unserialize() function
					'api_output'   => 'serialize',

					// ID(s) of the contact custom field(s) you wish to fetch - comma-separate for more than one
					// You can also pass the personalization tag here, IE: %PERS_7%
					'ids'           => 'all',
				);


					// This section takes the input fields and converts them to the proper format
					$query = "";
					foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
					$query = rtrim($query, '& ');

					// clean up the url
					$url = rtrim($url, '/ ');

					// This sample code uses the CURL library for php to establish a connection,
					// submit your request, and show (print out) the response.
					if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

					// If JSON is used, check if json_decode is present (PHP 5.2.0+)
					if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
						die('JSON not supported. (introduced in PHP 5.2.0)');
					}

					// define a final API request - GET
					$api = $url . '/admin/api.php?' . $query;

					$request = curl_init($api); // initiate curl object
					curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
					curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
					//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
					curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

					$response = (string)curl_exec($request); // execute curl fetch and store results in $response

					// additional options may be required depending upon your server configuration
					// you can find documentation on curl options at http://www.php.net/curl_setopt
					curl_close($request); // close curl object

					if ( !$response ) {
						//die('Nothing was returned. Do you have a connection to Email Marketing server?');
					}

					// This line takes the response and breaks it into an array using:
					// JSON decoder
					//$result = json_decode($response);
					// unserializer
					$result = unserialize($response);
					// XML parser...
					// ...
					
					if(!empty($result)){
						foreach($result as $field){
							if(isset($field['tag']) && !empty($field['tag'])){
								if($field['tag'] == "%LOCATION%"){
									$responseArr['location_field'] = 1;
								}elseif($field['tag'] == "%PROGRAM%"){
									$responseArr['program_field'] = 1;
								}elseif($field['tag'] == "%COST_OF_TRIAL%"){
									$responseArr['cost_of_trial_field'] = 1;
								}elseif($field['tag'] == "%BIRTHDAY_PAGE_OPTION%"){
									$responseArr['call_or_schedule'] = 1;
								}elseif($field['tag'] == "%SUMMER_CAMP_OPTION%"){
									$responseArr['reserve_or_schedule'] = 1;
								}
							}
						}
					}
		//echo '<pre>responseArr'; print_r($result); die;			
		return $responseArr;
	}
	
	
	
	public function getStrReplaceAdmin($text = null){
		if(!empty($text)){
			$text = htmlentities($text);
		}
		
		return $text;
	}
	
	public function getProgramCategoryTagsByTrialCatId($trial_cat_id = null){
		$programCatTags = array();
		$alltags = array();
		
		if(!empty($trial_cat_id)){
			$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
			$trialOfferCat = $this->query_model->getBySpecific("$tbl_onlinespecial_categories",'id',$trial_cat_id);
			
			if(!empty($trialOfferCat)){
			
			$trial_cat_name = substr($trialOfferCat[0]->name, 0, 4);
			
			//echo $trial_cat_name; die;
			
			$this->db->select(array('cat_id','trial_offer_id','cat_slug','cat_name'));
			$this->db->like('cat_name',$trial_cat_name);
			$programCats = $this->query_model->getBySpecific('tblcategory','trial_offer_id',$trial_cat_id);
			
			if(!empty($programCats)){
				
				foreach($programCats as $program_cat){
					$program_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);
					$program_slug = $program_slug[0];
		
					$page_url = '/'.$program_slug->slug.'/'.$program_cat->cat_slug;
					$formInstances = $this->query_model->getBySpecific('tbl_form_instances','page_url',$page_url);
					
					if(!empty($formInstances)){
						
						$formModule = $this->query_model->getBySpecific('tbl_form_modules','id',$formInstances[0]->form_module_id);
						
						if(!empty($formModule)){
							if(!empty($formModule[0]->active_campaign_tags)){
								
								$activeCampaignTagsArr = unserialize($formModule[0]->active_campaign_tags);
								
								$active_campaign_tags = $this->query_model->getFormModuleTags($activeCampaignTagsArr);
								
								if(!empty($active_campaign_tags)){
									foreach($active_campaign_tags as $key => $active_campaign_tag){
										$programCatTags[] = $active_campaign_tag;
									}
									
								}
								//echo '<pre>active_campaign_tags'; print_r($active_campaign_tags); die;
							}
						}
					}
					
				}
				
				//echo '<prE>programCatTags'; print_r($programCatTags); die;
				if(!empty($programCatTags)){
					$alltags = $this->query_model->formModuleTagsInSerializeForApis($programCatTags);
				}
				
			}
		  }	
			
		}
		
		return $alltags;
	}
	
	
	function getIsMultiSocialFeeds(){
				$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_social_feeds'));
				$result = $query->result_array();
				//$IsMultiMap = $result[0]->field_value;
				return $result;
	}
	
	
	
	function getCurrentLocationSlug(){
		$location_slug = '';
		if($this->uri->segment(2) != ''){
				$location_slug = str_replace('%27',"'",$this->uri->segment(2));
		}
		
		return $location_slug;
	}
	
	
	public function getUniqueStatesList(){
		
		if($this->query_model->checkMultiSchoolIsOn() == 1){
			
			if($this->uri->segment(1) != '' && $this->uri->segment(1) == "admin"){
				$this->db->where("school_location_type", 'default');  //not nested child locations
			}else{
				$this->db->where("turn_on_nested_location", 0);  //not nested child locations
			}
			
		}
		$this->db->where("published", 1);
		$this->db->where("main_location", 0);
		$this->db->order_by("pos","asc");
		$this->db->group_by('state');
		$this->db->select(array('id','name','slug','city','state'));
		
		$results = $this->query_model->getbyTable("tblcontact");
		
		return $results;
	}
	
	
	public function getUniqueCitiesListByState($state = null){
		$results = array();
		if(!empty($state)){
			$this->db->select(array('id','name','slug','city','state'));
			$this->db->where("main_location", 0);
			$this->db->where("state", $state);
			$this->db->group_by('city');
			$this->db->where("published", 1);
			$results = $this->query_model->getbyTable("tblcontact");
		}
		
		return $results;
	}
	
	public function getLocationsListByCity($city = null){
		$results = array();
		if(!empty($city)){
			if($this->query_model->checkMultiSchoolIsOn() == 1){
				$this->db->where("turn_on_nested_location", 0);  //not nested child locations
			}
			$this->db->where("city", $city);
			$this->db->where("published", 1);
			$this->db->where("main_location", 0);
			$results = $this->query_model->getbyTable("tblcontact");
		}
		
		return $results;
	}
	
	
	
	public function getLocationsListByState($state = null){
		$results = array();
		if(!empty($state)){
			if($this->query_model->checkMultiSchoolIsOn() == 1){
				$this->db->where("school_location_type", 'default');  //not nested child locations
			}
			$this->db->where("state", $state);
			$this->db->where("published", 1);
			$this->db->where("main_location", 0);
			$results = $this->query_model->getbyTable("tblcontact");
		}
		
		return $results;
	}
	
	
	public function getSchoolMenu(){
		
		$uniqueStatesList = $this->query_model->getUniqueStatesList();
		
		$locationArr = array();
		if(!empty($uniqueStatesList)){
			$i = 0;
			foreach($uniqueStatesList as $state){
				foreach($state as $key => $val){
					$locationArr[$i][$key] = $val;
				}
				$locationArr[$i]['parent'] = 'Column 1';
				$locationArr[$i]['value'] = $state->state;
				
				$uniqueCitiesList = $this->query_model->getLocationsListByState($state->state);
				//echo '<pre>uniqueCitiesList'; print_r($uniqueCitiesList); die;
				if(!empty($uniqueCitiesList)){
					$n = 0;
					foreach($uniqueCitiesList as $city){
						foreach($city as $key => $val){
							$locationArr[$i]['children'][$n][$key] = $val;
						}
						$locationArr[$i]['children'][$n]['parent'] = $state->state;
						$locationArr[$i]['children'][$n]['value'] = $city->name;
					
						/*$city_locations = $this->query_model->getLocationsListByCity($city->city);
						
						if(!empty($city_locations)){
							$p = 0;
							foreach($city_locations as $city_location){
								//echo '<pre>value'; print_r($city_location); die;
								foreach($city_location as $key => $value){
									
									$locationArr[$i]['children'][$n]['children'][$p][$key] = $value;
								}
								$locationArr[$i]['children'][$n]['children'][$p]['parent'] = $city->city;
								$locationArr[$i]['children'][$n]['children'][$p]['value'] = $city_location->name;
							$p++;
							}
						
						} */
					$n++;
					}
					
				}
				
			$i++;
			}
		}
		//echo '<pre>locationArr'; print_r($locationArr); die;
		
		return $locationArr;
	}
	
	
	public function setSchoolMenu(){
		$schoolMenuArr = array();
		$schoolMenu = $this->query_model->getSchoolMenu();
		
		$boxes = array('Column 1','Column 2','Column 3','Column 4');
		
		foreach($boxes as $key=> $box){
			$schoolMenuArr[$key]['name'] = $box;
			$schoolMenuArr[$key]['value'] = $box;
			$schoolMenuArr[$key]['parent'] = 0;
				
			if($key == 0){
				$schoolMenuArr[$key]['children'] = $schoolMenu;
			}
		}
		
		return $schoolMenuArr;
		
	}
	
	function getSchoolMenuPagesCms($id, $menu_id)
        {
			$result = $this->db->query("select * from tbl_school_menupages where parent_id = '".$id."' AND `menu_id` = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
			return $result;
  
        }
	
	
	
	public function getBlogBodyId($queryString, $body_id = null){
		$blog_controller = $this->query_model->getbySpecific("tblmeta", "id", 48);
		//echo $queryString[1].'====>'.$blog_controller[0]->slug; die;
		if(isset($queryString[2]) && !empty($queryString[2])){
			$blogDetail = $this->query_model->getBySpecific("tblblogs","slug", $queryString[2]);
			
			$body_id = (!empty($blogDetail) && !empty($blogDetail[0]->body_id)) ? $blogDetail[0]->body_id : $body_id;
			
		}else{
			if(isset($queryString[1]) && ($queryString[1] == $blog_controller[0]->slug || $queryString[1] == $blog_controller[0]->page)){
				$body_id = "blog";
			}
		}
		
		return $body_id;
	}
	
	
	public function multi_school_minimum_locations(){
		//$result = $this->config->item('multi_school_minimum_locations');
		if(isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == "localhost"){
			$result = 2;
		}else{
			$result = 1;
		}
		
		
		return $result;
	}
	
	public function multi_about_us(){
		$multiAboutUs = $this->query_model->getBySpecific('tblconfigcalendar','id',2);
		
		$multiAboutUs = !empty($multiAboutUs) ? $multiAboutUs[0]->field_value : 0;
		
		return $multiAboutUs;
	}
	
	
	
	
	public function getThankYouPageProgramPageMessage($postData,$thankyou_page_id){
		
			$result = array();
			$result['postData'] = $postData;
			$result['thankyou_page_id'] = $thankyou_page_id;
			
		$this->session->set_userdata('thankyouMessage',$result);
		
		//return $thankyouPageDetail;
	}
	
	
	
	
	public function getSchoolBodyId($queryString, $body_id){
		
		if(isset($queryString[2]) && !empty($queryString[2])){
			$this->db->select('id');
			$locationDetail = $this->query_model->getBySpecific("tblcontact","slug", $queryString[2]);
			
			if(!empty($locationDetail)){
				$schoolDetail = $this->query_model->getBySpecific("tblaboutschoolheader","location_id", $locationDetail[0]->id);
			
				if(!empty($schoolDetail)){
					$body_id = (!empty($schoolDetail) && !empty($schoolDetail[0]->body_id)) ? $schoolDetail[0]->body_id : $body_id;
				}
			}
			
		}
		
		return $body_id;
	}
	
	public function checkMultiSchoolOrLocationIsOn(){
		$result = 0;
		$configCalendar = $this->query_model->getbyTable("tblconfigcalendar");
		if($configCalendar[0]->field_value == 1 || $configCalendar[11]->field_value == 1){
			$result = 1;
		}
		
		return $result;
	}
	
	
	//// 09 april 2018 kz
	public function checkFormModuleConncted(){
		$result = array();
		$pages_list = array();
		$form_modules = array();
		
		$form_types = $this->query_model->getByTable('tbl_form_types');
		if(!empty($form_types)){
				foreach($form_types as $form_type){
					
					$pages_list[$form_type->type] = $this->query_model->getAllPagesListAccordingFormTypes($form_type->id);
					
					$this->db->order_by('id','ASC');
					$form_modules[$form_type->type] = $this->query_model->getbySpecific('tbl_form_modules', 'form_type_id',$form_type->id);
					
				
				
				if(!empty($pages_list[$form_type->type])){
				$i = 0;
				foreach($pages_list[$form_type->type] as $url => $page_name){
					//$url = '/starttrial/buyspecial~4:/trial-offer/children';
					$mainUrl = $url;
					$pageViewUrl = $url;
					$mainUrlData = explode(':',$url);
					//echo '<pre>mainUrlData'; print_r($mainUrlData); die;
					$mainUrl = (isset($mainUrlData[0]) && !empty($mainUrlData[0])) ? $mainUrlData[0] : $url;
					$pageViewUrl = (isset($mainUrlData[1]) && !empty($mainUrlData[1])) ? $mainUrlData[1] : $url;
					
					
					$pageData = explode('~',$url);
					if(isset($pageData[1]) && !empty($pageData[1])){
						$actionData = explode(':',$pageData[1]);
						if(isset($actionData[0]) && !empty($actionData[0])){
							$action_id = $actionData[0];
						}
						
					}else{
						$action_id = 0;
					}
					
					
					$url = $pageData[0];
					
					if($action_id > 0){
						$this->db->where("action_id",$action_id);
					}
					$this->db->where("page_url",$url);
					$exitResult = $this->query_model->getbySpecific('tbl_form_instances', 'form_type_id',$form_type->id);
					$selected_form_module = !empty($exitResult) ? $exitResult[0]->form_module_id : 0;
					
					if($selected_form_module == 0){
						$result['form_instances'][$form_type->id] = 1;
					}
					$i++; 
				}
			}

				foreach($form_modules[$form_type->type] as $form_module){
					$form_result = $this->query_model->checkAllFormsConnectedAutoResponder($form_module);
					if($form_result == 0){
						$result['form_module'][$form_type->id] = 1;
					}
				}
		
				}
				
		}
		//echo "<pre>result"; print_r($result); die;
		return $result;
	}
	
	
	
	public function getAllPagesListAccordingFormTypes($form_type_id){
				
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		
		$allLocations = $this->query_model->getbyTable("tblcontact");
		
		$mainLocation = $this->query_model->getMainLocation("tblcontact");
		
		$about_slug = $this->query_model->getbySpecific('tblmeta', 'id', 21);
		$about_slug = $about_slug[0];
		
		$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
		$contact_slug = $contact_slug[0];
		
		$program_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);
		$program_slug = $program_slug[0];
		
		$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$start_trial_slug = $start_trial_slug[0];
                
        $events_slug = $this->query_model->getbySpecific('tblmeta', 'id', 27);
		$events_slug = $events_slug[0];
                
        $student_section_slug = $this->query_model->getbySpecific('tblmeta', 'id', 47);
		$student_section_slug = $student_section_slug[0];
		
		$trial_offer_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$trial_offer_slug = $trial_offer_slug[0];
		
		$school_slug = $this->query_model->getbySpecific('tblmeta', 'id', 51);
		$school_slug = $school_slug[0];
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$multiSchool = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		$this->db->where("main_location", 0);
		$allSchoolContacts = $this->query_model->getbyTable("tblcontact");
		
		$multi_about_us = $this->query_model->multi_about_us();
				
				
		//echo '<pre>'; print_r($trial_offer_slug); die;
		$pages = array();
		
		$add_url = '/';
		
		// trial form 
		if($form_type_id == 1){
				
				$pages[$add_url] = 'Home';
                
				if($multiLocation[0]->field_value == 1 && $multiSchool == 0 && $multi_about_us == 1){
					foreach($allLocations as $allLocation){
							$about_url = $about_slug->slug.'/'.$allLocation->slug;
							$pages[$add_url.$about_url] = $about_slug->page_label.'- '.$allLocation->name;
						}
				} else{
						$about_url = $about_slug->slug.'/'.strtolower(str_replace(' ','-',$mainLocation[0]->city));
						$pages[$add_url.$about_url] = $about_slug->page_label;
				}
				
				if($multiLocation[0]->field_value == 1){
					if($multiSchool == 1){
					
						foreach($allSchoolContacts as $allLocation){
							$school_url = $school_slug->slug.'/'.$allLocation->slug;
							$pages[$add_url.$school_url] = $school_slug->page_label.'- '.$allLocation->name;
						}
					}
				}
				
				$pages[$add_url.$start_trial_slug->slug] = $start_trial_slug->page_label;
				
				$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
				$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
				$this->db->order_by('pos', 'asc');
				$this->db->where("published", 1);
				if($isUniqueSpecialOffer == 1){
					$this->db->where("type", "trial_offer");
				}
				$trial_categories = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
				if(!empty($trial_categories)){
					foreach($trial_categories as $trial_category){
						$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
						$this->db->order_by('pos', 'asc');
						$this->db->where("display_trial", 1);
						$trial_offers = $this->query_model->getBySpecific("$tblspecialoffer",'cat_id',$trial_category->id);
						
						//echo '<pre>trial_offers'; print_r($trial_offers); die;
						if(!empty($trial_offers)){
							foreach($trial_offers as $trial_offer){
								if($trial_offer->trial == 1){
									$payment = $this->query_model->getByTable('tbl_payments');
									if(!empty($payment)){
										if($payment[0]->authorize_net_payment == 1){
											$authorized_payment_page_url = 'payment/buyoffer~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
											
											$pages[$add_url.$authorized_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') PAID';
											
										}elseif($payment[0]->braintree_payment == 1){
											$braintree_payment_page_url = 'payment/brainTreebuyoffer~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
											
											$pages[$add_url.$braintree_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') PAID';
											
										}elseif($payment[0]->stripe_payment == 1){
											$stripe_payment_page_url = 'payment/stripePaymentbuyoffer~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
											
											$pages[$add_url.$stripe_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') PAID';
										}elseif($payment[0]->stripe_ideal_payment == 1){
											$stripe_payment_page_url = 'payment/stripeIdealPaymentbuyoffer~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
											
											$pages[$add_url.$stripe_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') PAID';
										}elseif($payment[0]->paypal_payment == 1){
											$paypal_payment_page_url = 'payment/paypalPaymentbuyoffer~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
											
											$pages[$add_url.$paypal_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') PAID';
										}
									}
								}else{
									
									$free_trial_page_url = 'starttrial/buyspecial~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
									$pages[$add_url.$free_trial_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') FREE';
								}
							}
						}
						
						
						/*$trial_category_url = $trial_offer_slug->slug.'/'.$trial_category->slug;
						
						$pages[$add_url.$trial_category_url] = $trial_offer_slug->page_label.'- '.$trial_category->name; */
						
						/*$free_trial_page_url = 'starttrial/buyspecial~'.$trial_category->id;
						$pages[$add_url.$free_trial_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' (Free Trial)'; 
						
						
						$authorized_payment_page_url = 'payment/buyoffer~'.$trial_category->id;
						$pages[$add_url.$authorized_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' (Authorized payment checkout)';
						
						$braintree_payment_page_url = 'payment/brainTreebuyoffer~'.$trial_category->id;
						$pages[$add_url.$braintree_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' (Braintree payment checkout)';
						
						$stripe_payment_page_url = 'payment/stripePaymentbuyoffer~'.$trial_category->id;
						$pages[$add_url.$stripe_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' (Stripe payment checkout)';*/
						
					}
					
					
					foreach($trial_categories as $trial_category){
						$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
						$this->db->order_by('pos', 'asc');
						$this->db->where("display_trial", 1);
						$this->db->where("upsale", 1);
						$trialOffers = $this->query_model->getbySpecific("$tblspecialoffer", 'cat_id', $trial_category->id);
						
					if(!empty($trialOffers)){
						foreach($trialOffers as $trialOffer){
							
							$payment = $this->query_model->getByTable('tbl_payments');
							if(!empty($payment)){
								
								$tbl_onlinespecial_upsales = $this->query_model->getTrialOffersUpsellsTableName();
								$upsellDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_upsales",'trial_offer_id',$trialOffer->id);
								
								if(!empty($upsellDetail)){
									if($payment[0]->authorize_net_payment == 1){
									$authorized_payment_page_url = 'trial_upsells_payment/authorized_payment_gateway/'.$trialOffer->id;
									$pages[$add_url.$authorized_payment_page_url] = $trial_category->name.' ~ '.$this->query_model->getMetaDescReplace($trialOffer->offer_title).'<br>Upsell: '.$this->query_model->getMetaDescReplace($upsellDetail[0]->up_title);
									
								}elseif($payment[0]->braintree_payment == 1){
									$braintree_payment_page_url = 'trial_upsells_payment/brainTreePaymentGateway/'.$trialOffer->id;
									$pages[$add_url.$braintree_payment_page_url] = $trial_category->name.' ~ '.$this->query_model->getMetaDescReplace($trialOffer->offer_title).'<br>Upsell:  '.$this->query_model->getMetaDescReplace($upsellDetail[0]->up_title);
									
								}elseif($payment[0]->stripe_payment == 1){
									$stripe_payment_page_url = 'trial_upsells_payment/stripe_payment_gateway/'.$trialOffer->id;
								$pages[$add_url.$stripe_payment_page_url] = $trial_category->name.' ~ '.$this->query_model->getMetaDescReplace($trialOffer->offer_title).'<br>Upsell:  '.$this->query_model->getMetaDescReplace($upsellDetail[0]->up_title);
								}elseif($payment[0]->stripe_ideal_payment == 1){
									$stripe_payment_page_url = 'trial_upsells_payment/stripe_ideal_payment_gateway/'.$trialOffer->id;
								$pages[$add_url.$stripe_payment_page_url] = $trial_category->name.' ~ '.$this->query_model->getMetaDescReplace($trialOffer->offer_title).'<br>Upsell:  '.$this->query_model->getMetaDescReplace($upsellDetail[0]->up_title);
								}elseif($payment[0]->paypal_payment == 1){
									$paypal_payment_page_url = 'trial_upsells_payment/paypal_payment_gateway/'.$trialOffer->id;
								$pages[$add_url.$paypal_payment_page_url] = $trial_category->name.' ~ '.$this->query_model->getMetaDescReplace($trialOffer->offer_title).'<br>Upsell:  '.$this->query_model->getMetaDescReplace($upsellDetail[0]->up_title);
								}
								}
								
							}
								/*$authorized_payment_page_url = 'trial_upsells_payment/authorized_payment_gateway/'.$trialOffer->id;
								$pages[$add_url.$authorized_payment_page_url] = 'Upsell: '.$trialOffer->title.' (Authorized payment checkout)';
								
								$braintree_payment_page_url = 'trial_upsells_payment/brainTreePaymentGateway/'.$trialOffer->id;
								$pages[$add_url.$braintree_payment_page_url] = 'Upsell:  '.$trialOffer->title.' (Braintree payment checkout)';
								
								$stripe_payment_page_url = 'trial_upsells_payment/stripe_payment_gateway/'.$trialOffer->id;
								$pages[$add_url.$stripe_payment_page_url] = 'Upsell:  '.$trialOffer->title.' (Stripe payment checkout)';*/
							}
						}
					}
					
				}
				
				//echo '<pre>pages'; print_r($pages); die;
		}
		// program form
		elseif($form_type_id == 2){
			
			$program_nav = $this->query_model->getCategory("programs");
			if(!empty($program_nav)){
				$col = 1;
					foreach($program_nav as $nav_item_prog){
					$this->db->where('published',1);
					$query_subcat=$this->db->query("select `id` from tblprogram where category=".$nav_item_prog->cat_id."");
									$query_subcat=$query_subcat->result();
									
									$cat_name=str_replace(" ",'-',trim($nav_item_prog->cat_name));
									
									
									$published = 1;
									$query_sub = $this->query_model->getbySpecificRecord("tblprogram", "category", $nav_item_prog->cat_id,$published);
									
									if(isset($query_sub) && !empty($query_sub)) {
									$category_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug;
									$pages[$add_url.$category_url] = '<b>'.$nav_item_prog->cat_name.' - <span class="form-module-span-text">Main Cateogry </span></b>';
									
									foreach($query_sub as $subnav_item_prog){						
											$subcat_name=str_replace(" ",'-',trim($subnav_item_prog->program)); 
											
											/*if($subnav_item_prog->landing_checkbox == 1){ 
													$program_url = '';
														if(!empty($subnav_item_prog->landing_program)){
															$program_url = $subnav_item_prog->landing_program;
														}else{
															$program_url = $subnav_item_prog->landing_page_url;
														}
														
															$program_page_url = $program_url;
															$pages[$add_url.$program_page_url] = $subnav_item_prog->buttonName;
														
													 } 
													elseif($subnav_item_prog->stand_alone_page == 1){ 
													 		$program_page_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug.'/'.$subnav_item_prog->program_slug;
															$pages[$add_url.$program_page_url] = $subnav_item_prog->buttonName;
													  }*/
													  
													$program_page_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug.'/'.$subnav_item_prog->program_slug;
													$pages[$add_url.$program_page_url] = $subnav_item_prog->buttonName;
											 }
											 
									}
							$col++; 
						}
		
					}
					
					//echo '<pre>pages'; print_r($pages); die;
		
		}
		
		
		// contact us
		elseif($form_type_id == 3){
			
			if($multiLocation[0]->field_value == 1 && $multiSchool == 0){
				foreach($allLocations as $allLocation){
						$contact_url = $contact_slug->slug.'/'.$allLocation->slug;
						$pages[$add_url.$contact_url] = $contact_slug->page_label.'- '.$allLocation->name;
					}
			} else{
					$contact_url = $contact_slug->slug;
					$pages[$add_url.$contact_url] = $contact_slug->page_label;
			}
			
			$student_section_contact_url = $student_section_slug->slug.'/contact';
			$pages[$add_url.$student_section_contact_url] = 'Studentsection Contact';
		}
		//dojocart forms
		elseif($form_type_id == 4){
			
				$paymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1); 
        
				$this->db->where("published", 1);
				$all_dojocart = $this->query_model->getbyTable("tbl_dojocarts");
					foreach ($all_dojocart as $dojocart_list){

						if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1   || $paymentDetail[0]->stripe_payment == 1   || $paymentDetail[0]->stripe_ideal_payment == 1   || $paymentDetail[0]->paypal_payment == 1  ){
				          if (!empty($dojocart_list->payment_type && $dojocart_list->payment_type == 'paid') ) {
				                if( !empty($paymentDetail[0]->authorize_net_payment) && $paymentDetail[0]->authorize_net_payment == 1 ){
				                  $action_value = 'dojocartpayment/authorized_payment_gateway/';
				                }

				                if( !empty($paymentDetail[0]->braintree_payment) && $paymentDetail[0]->braintree_payment == 1 ){
				                  $action_value = 'dojocartpayment/brainTreePaymentGateway/';
				                }
								
								if( !empty($paymentDetail[0]->stripe_payment) && $paymentDetail[0]->stripe_payment == 1 ){
				                  $action_value = 'dojocartpayment/stripe_payment_gateway/';
				                }
								
								if( !empty($paymentDetail[0]->stripe_ideal_payment) && $paymentDetail[0]->stripe_ideal_payment == 1 ){
				                  $action_value = 'dojocartpayment/stripe_ideal_payment_gateway/';
				                }
								
								if( !empty($paymentDetail[0]->paypal_payment) && $paymentDetail[0]->paypal_payment == 1 ){
				                  $action_value = 'dojocartpayment/paypal_payment_gateway/';
				                }
								
				            }else{
				                $action_value = 'dojocartpayment/buyspecial/';
				              }
				      }
				        else{
				          $action_value = 'dojocartpayment/buyspecial/';
				        }


						$dojocart_pages_url = 'promo/'.$dojocart_list->slug;
						$pages[$add_url.$dojocart_pages_url] = 'Dojocart- '.$dojocart_list->product_title;
						
					}
						
		}
		return $pages;
		
	}
	
	
	public function checkMultiWebhookIsOn(){
		$result = 0;
		$configCalendar = $this->query_model->getbyTable("tblconfigcalendar");
		if($configCalendar[12]->field_value == 1){
			$result = 1;
		}
		
		return $result;
	}
	
	
	

public function saveWebLeadsOnPerfectmind($postData, $formModelDetail){
	

		$perfectmind_api_result = $this->query_model->getbyTable("tbl_perfectmind_api");
		
		if($perfectmind_api_result[0]->multi_perfectmind_check == 1){
				$perfectmindDetail = $this->query_model->getLocationIdForRainMarker($postData);
			
		}else{
				$perfectmindDetail = $perfectmind_api_result;
		}
		
		
		if(!empty($perfectmind_api_result)){
			
			if($perfectmind_api_result[0]->type == 1 && !empty($perfectmind_api_result[0]->subdomain)){
				
				if(!empty($perfectmindDetail)){
					
					if(!empty($perfectmindDetail[0]->perfectmind_access_key) && !empty($perfectmindDetail[0]->perfectmind_client_number)){
						
						$subdomain = $perfectmind_api_result[0]->subdomain;
						$url = "https://$subdomain.perfectmind.com/api/2.0/B2C/Records?tableName=Contact";
				
						// set form all values in a format way
						$formData = $this->setFormDataValueInFormat($postData);
						
						$full_name = (isset($formData['name']) && !empty($formData['name'])) ? trim($formData['name']) : '';
				
						$first_name = 'N/A';
						$last_name = 'N/A';
						if(!empty($full_name)){
							$user_full_name = explode(' ',$full_name);
							$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
							
							if(!empty($user_full_name)){
								unset($user_full_name[0]);
							}
							$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
						} 
						// here we define the data we are posting in order to perform an update
						$post = array(
							'FirstName'  => $first_name,
							'LastName' => $last_name,
							'Email'  => $formData['email'],
							//'Birthdate'  => '',
							//'Gender'  => '',
							'PrimaryNumber' => $formData['phone'],
							'Type' => 'Lead',
							'IsPrimaryContactForAccount' => true,
							"Location" => $formData['location'],
							"Program" => $formData['program'],
							'QuickNote' => $formData['message'],
							
						); 
						
						
						//echo "<pre>postData"; print_r($formData); die;
						$data_string = json_encode($post);
						$data_string = '['.$data_string.']';
		//echo $data_string; 
						$ch = curl_init($url);                                                                     
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);                                                                      
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                                                                      
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
							'X-Access-Key:'.$perfectmindDetail[0]->perfectmind_access_key,                                                                                
							'X-Client-Number:'.$perfectmindDetail[0]->perfectmind_client_number,                                                                                
							'Content-Type: application/json',                                                                                
							'Content-Length: ' . strlen($data_string))                                                                       
						);                                                                                                                   
																																			 
						$result = curl_exec($ch);
						$err = curl_error($ch);

						curl_close($ch);
						//echo $err;
						//echo '<pre>'; print_r($result); die;
						
						
						 
						
					}
				}
			}
			
		}
		
}	
	

	public function showCartOrderLeadTab(){
		$result = 0;
		
		$query = $this->db->query('SELECT `id` FROM `tbl_dojocart_orders` where is_delete = 0');
		$totalLeads = $query->num_rows();
		
		if(!empty($totalLeads) && $totalLeads > 0){
			$result = 1;
		}else{
			$query = $this->db->query('SELECT `id` FROM `tbl_dojocarts` where published = 1');
			$totalDojocart = $query->num_rows();
			
			if(!empty($totalDojocart) && $totalDojocart > 0){
				$result = 1;
			}
		}
		
		return $result;
	}
	
	
	public function showWebhookOrderLeadTab(){
		$result = 1;
		
		$query = $this->db->query('SELECT `id` FROM `tbl_webhook_leads` where is_delete = 0');
		$totalLeads = $query->num_rows();
		
		if(!empty($totalLeads) && $totalLeads > 0){
			$result = 1;
		}else{
			/*$query = $this->db->query('SELECT `id` FROM `tbl_webhook_apis` where published = 1');
			$totalDojocart = $query->num_rows();
			
			if(!empty($totalDojocart) && $totalDojocart > 0){
				$result = 1;
			}*/
		}
		
		return $result;
	}
	
	
	
	public function checkAllFormsConnectedAutoResponder($formModuleDetail){
		//echo "<prE>formModuleDetail"; print_r($formModuleDetail); die;
		$result = array();
		if(!empty($formModuleDetail)){
			if(!empty($formModuleDetail->admin_auto_responder_id)){
				$exitsAdminAutoResponer = $this->query_model->getBySpecific('tbl_form_autoresponders','id',$formModuleDetail->admin_auto_responder_id);
				if(empty($exitsAdminAutoResponer)){
					$result['admin_auto_responder_id'] = 0;
				}
			}else{
				$result['admin_auto_responder_id'] = 0;
			}
			
			if($formModuleDetail->user_email_option == 1){
				if(!empty($formModuleDetail->customer_auto_responder_id)){
					$exitsClientAutoResponer = $this->query_model->getBySpecific('tbl_form_autoresponders','id',$formModuleDetail->customer_auto_responder_id);
					if(empty($exitsClientAutoResponer)){
						$result['customer_auto_responder_id'] = 0;
					}
				}else{
					$result['customer_auto_responder_id'] = 0;
				}
			}
		}
		
		return !empty($result) ? 0 : 1;
	}
	
	public function getTwilioApiType(){
		
		$result = array();
		
		$twilioApi =  $this->query_model->getbySpecific('tbl_twilio', 'id', 1);
		
		if(!empty($twilioApi)){
			
			if($twilioApi[0]->type == 1 && $twilioApi[0]->send_user_msg == 1 && !empty($twilioApi[0]->checkbox_text)){
				$result = $twilioApi[0];
			}
			
		}
		return $result;
	}
	
	
	
	
	public function connectFormToTwillioAPi($data, $form_type, $extraContentArr = null){
		
		$result = array();
		$result['client_msg_template'] = '';
		$result['admin_msg_template'] = '';
		
		$twilioApi = $this->query_model->getbySpecific('tbl_twilio', 'id', 1);
		
		// set form all values in a format way
		$formData = $this->setFormDataValueInFormat($data);
		//echo "<pre>formData"; print_r($formData); die;
		if(!empty($twilioApi)){
			
			$twilioApi = $twilioApi[0];
				
				$msgTemplate =  $this->query_model->getbySpecific('tbl_twillio_msg_templates', 'form_type', $form_type);
				
				
				if(!empty($msgTemplate) && $twilioApi->type == 1){
					
					// ADMIN MSG TEMPLATE
					
					if($twilioApi->send_user_msg == 1){
						if(isset($formData['twilio_checkbox']) && $formData['twilio_checkbox'] == 1){
							$result['client_msg_template'] = $this->query_model->replaceAutoResponderVaribles($msgTemplate[0]->client_msg, $formData, $extraContentArr);
						}
					}
					
					
					if($twilioApi->send_admin_msg == 1){
						$result['admin_msg_template'] = $this->query_model->replaceAutoResponderVaribles($msgTemplate[0]->admin_msg, $formData, $extraContentArr);
					}
					
					
					if(!empty($result)){
						
						$this->sendMsgToTwilioApi($formData, $twilioApi,$result);
					}
					
					
				}
			
		}
	}
	
	public function sendMsgToTwilioApi($formData,$twilioApi, $msgTemplate){
		
		
		include_once './vendor/Twilio/autoload.php';
		include_once("./vendor/Twilio/Rest/Client.php");
		
		// Your Account Sid and Auth Token from twilio.com/console
		$sid    = $twilioApi->sid; # test sid
		$token  = $twilioApi->token;# test token
		
		$twilio = new Twilio\Rest\Client($sid, $token);
		
		
			// reciver test number +13472270477
			try{
				
				if(!empty($msgTemplate['client_msg_template'])){
					//// Send Twillio msg to client
					$clientPhoneNumber = (isset($formData['phone']) && !empty($formData['phone'])) ? $formData['phone'] : '';
		
					if(!empty($clientPhoneNumber)){
						
						$clientPhoneNumber = trim(str_replace(array("(",")"," ","-"),'',$clientPhoneNumber));
						$clientPhoneNumber = '+1'.$clientPhoneNumber;
						
						$client_message = $twilio->messages
									  ->create($clientPhoneNumber,
											   array(
												   "body" => $msgTemplate['client_msg_template'],
												   "from" => $twilioApi->from_phone_number,
												   "mediaUrl" => "https://dojoservers.com/~demov5/upload/ATA-logo11.png"
											   )
									  );
					}
				}
				
			
			}catch (Exception $e) {
				//echo 'Caught exception: ',  $e->getMessage(), "\n"; die;
			}
			
			
			
			try{
				
				if(!empty($msgTemplate['admin_msg_template'])){
					
					$this->db->select('phone');
					$mainLocation = $this->query_model->getMainLocation("tblcontact");
					$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
					
					$adminPhoneNumber = $twilioApi->twilio_cell_number;
					
					if($twilioApi->multi_twilio_check == 1 ){
						if($multiLocation[0]->field_value == 1){
									if(isset($formData['location']) && !empty($formData['location'])){
										$this->db->select('twilio_cell_number');
										$selectedLocation = $this->query_model->getBySpecific('tblcontact','name',$formData['location']);
										if(!empty($selectedLocation) && !empty($selectedLocation[0]->twilio_cell_number)){
											$adminPhoneNumber = $selectedLocation[0]->twilio_cell_number;
										}
										
									}
									
								}
					}
					
					if(!empty($adminPhoneNumber)){
						
						$adminPhoneNumber = trim(str_replace(array("(",")"," ","-"),'',$adminPhoneNumber));
						$adminPhoneNumber = '+1'.$adminPhoneNumber;
						
						$admin_message = $twilio->messages
									  ->create($adminPhoneNumber,
											   array(
												   "body" => $msgTemplate['admin_msg_template'],
												   "from" => $twilioApi->from_phone_number,
												   "mediaUrl" => "https://dojoservers.com/~demov5/upload/ATA-logo11.png"
											   )
									  ); 
					}
					
				}
				
			}catch (Exception $e) {
				//echo 'Caught exception: ',  $e->getMessage(), "\n"; die;
			}
			
			
		/*echo "<pre>client_message"; print_R($client_message);
		echo "<pre>admin_message"; print_R($admin_message);
		die;*/
		//print($message->sid); die;			
		
		
	}
	
	
	public function getActiveApisNames(){
		$result = array();
		
		//mailchimp api
		$tblmailchimp = $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		if(!empty($tblmailchimp) && $tblmailchimp[0]->type == 1){
			$result['mailchimp'] = "Mailchimp";
		}
		
		//rainmaker api
		$tblrainmaker = $this->query_model->getbySpecific('tblrainmaker', 'id', 1);
		if(!empty($tblrainmaker) && $tblrainmaker[0]->type == 1){
			$result['rainmaker'] = "Rainmaker";
		}
		
		//perfectmind api
		$perfectmind = $this->query_model->getbySpecific('tbl_perfectmind_api', 'id', 1);
		if(!empty($perfectmind) && $perfectmind[0]->type == 1){
			$result['perfectmind'] = "Perfectmind";
		}
		
		//kicksite api
		$kicksite = $this->query_model->getbySpecific('tbl_kicksite', 'id', 1);
		if(!empty($kicksite) && $kicksite[0]->type == 1){
			$result['kicksite'] = "Kicksite";
		}
		
		//mystudio api
		$mystudio = $this->query_model->getbySpecific('tbl_mystudio', 'id', 1);
		if(!empty($mystudio) && $mystudio[0]->type == 1){
			$result['mystudio'] = "MyStudio";
		}
		
		$mat_api = $this->query_model->getbySpecific('tbl_mat_api', 'id', 1);
		if(!empty($mat_api) && $mat_api[0]->type == 1){
			$result['mat_api'] = "MAT";
		}
		
		
		//activeCampaign api
		$active_campaign = $this->query_model->getbySpecific('tbl_active_campaign', 'id', 1);
		if(!empty($active_campaign) && $active_campaign[0]->type == 1){
			$result['active_campaign'] = "Active Campaign";
		}
		
		//chargify api
		/*$chargify = $this->query_model->getbySpecific('tbl_chargify', 'id', 1);
		if(!empty($chargify) && $chargify[0]->type == 1){
			$result['chargify'] = "Chargify";
		}
		
		//fb messenger api
		$fb_messenger =  $this->query_model->getbySpecific('tbl_fb_messenger', 'id', 1);
		if(!empty($fb_messenger) && $fb_messenger[0]->type == 1){
			$result['fb_messenger'] = "Facebook Messenger";
		}
		
		//chargify api
		$tinyjpg =  $this->query_model->getbySpecific('tbl_chargify', 'id', 1);
		if(!empty($tinyjpg) && $tinyjpg[0]->tinyjpg_key != ""){
			$result['tinyjpg'] = "Tinyjpg";
		}*/
		
		//velocify api
		$velocify =  $this->query_model->getbySpecific('tbl_velocify', 'id', 1);
		if(!empty($velocify) && $velocify[0]->type == 1){
			$result['velocify'] = "Velocify";
		}
		
		//twillio api
		$twilio =  $this->query_model->getbySpecific('tbl_twilio', 'id', 1);
		if(!empty($twilio) && $twilio[0]->type == 1){
			$result['twilio'] = "Twilio";
		}
		
		
		$payments =  $this->query_model->getbySpecific('tbl_payments', 'id', 1);
		//authorize payment api
		if(!empty($payments) && $payments[0]->authorize_net_payment == 1){
			$result['authorize_net_payment'] = "Authorize Net Payment";
		}
		
		//braintree payment api
		if(!empty($payments) && $payments[0]->braintree_payment == 1){
			$result['braintree_payment'] = "Braintree Payment";
		}
		
		////stripe payment api
		if(!empty($payments) && $payments[0]->stripe_payment == 1){
			$result['stripe_payment'] = "Stripe Payment";
		}
		
		if(!empty($payments) && $payments[0]->paypal_payment == 1){
			$result['paypal_payment'] = "Paypal Payment";
		}
		
		//email marketing api
		/*$this->db->select('email_marketing');
		$setting =  $this->query_model->getbyTable("tblsite");
		if(!empty($setting) && $setting[0]->email_marketing == 1){
			$result['email_marketing'] = "Email Marketing";
		}*/
		
		return $result;
		
		
	}
	
	
	public function get_gdpr_compliant(){
		
		$this->db->select('gdpr_compliant');
		$site_setting = $this->query_model->getbyTable("tblsite");
		
		$gdpr_compliant = ($site_setting[0]->gdpr_compliant == 1) ? 1 : 0;
		
		return $gdpr_compliant;
	}
	
	
	public function showProgramsListOnFroms(){
		
		$this->db->select('forms_programs_dropdown');
		$site_setting = $this->query_model->getbyTable("tblsite");
		
		$forms_programs_dropdown = ($site_setting[0]->forms_programs_dropdown == 1) ? 1 : 0;
		
		return $forms_programs_dropdown;
	}
	
	public function programsListOnFromDropdowns($cat_id = null){
		
		$programsArr = array();
		
		$this->db->select(array('cat_id','cat_name'));
		$this->db->where('published',1);
		if(!empty($cat_id) && $cat_id > 0){
			$this->db->where('cat_id',$cat_id);
		}
		$programCats = $this->query_model->getBySpecific('tblcategory','cat_type','programs');
		
			if(!empty($programCats)){
				foreach($programCats as $program_cat){
					$this->db->select(array('id','program'));
					$this->db->where('published',1);
					$programs = $this->query_model->getBySpecific('tblprogram','category',$program_cat->cat_id);
					
					if(!empty($programs)){
						foreach($programs as $program){
							$programsArr[$program->id] = $program;
						}
					}
				}
			}
		return $programsArr;
	}
	
	
	public function checkCronJobsForCoupons(){
		$resultArr = array();
		
		$cronJobs =	$this->query_model->getByTable('tbl_coupons_cronjobs');
		
		if(!empty($cronJobs)){
			
			$currentDate = date('Y-m-d'); 
			
			foreach($cronJobs as $cron_job){
				
				if($cron_job->execute_date == $currentDate){
					$resultArr[$cron_job->type] = 0;
				}else{
					$resultArr[$cron_job->type] = 1;
				}
				
			}
		}
		return $resultArr;
	}
	
	
	public function getGdprCompliantText(){
		
		$result['gdpr_compliant_txt1'] = $this->query_model->getStaticTextTranslation('gdpr_compliant_txt1');
		
		$result['gdpr_compliant_txt2'] = $this->query_model->getStaticTextTranslation('gdpr_compliant_txt2');
		
		$result['gdpr_compliant_submit_btn_text'] = ($this->query_model->get_gdpr_compliant() == 1) ? $this->query_model->getStaticTextTranslation('submit') : $this->query_model->getStaticTextTranslation('go');
 		
		return $result;
	}
	
	
	public function isTrialOfferUnique(){
		
		$multiConfig = $this->query_model->getByTable('tblconfigcalendar');
		
		$result = ($multiConfig[13]->field_value == 1) ? 'unique_' : '';
		
		return $result;
	}
	
	
	
	public function programsCatAndProgramLists(){
		
		$programsArr = array();
		
		$this->db->select(array('cat_id','cat_name'));
		$this->db->where('published',1);
		if(!empty($cat_id) && $cat_id > 0){
			$this->db->where('cat_id',$cat_id);
		}
		$programCats = $this->query_model->getBySpecific('tblcategory','cat_type','programs');
		
			if(!empty($programCats)){
				foreach($programCats as $program_cat){
					foreach($program_cat as $program_c){
						$programsArr['program_cat~'.$program_cat->cat_id]['cat_id'] = $program_cat->cat_id;
						$programsArr['program_cat~'.$program_cat->cat_id]['cat_name'] = $program_cat->cat_name.' - Main Category';
					}
					
					$this->db->select(array('id','program'));
					$this->db->where('published',1);
					$programs = $this->query_model->getBySpecific('tblprogram','category',$program_cat->cat_id);
					
					if(!empty($programs)){
						foreach($programs as $program){
							$programsArr['program~'.$program->id] = $program;
						}
					}
				}
			}
		
		return $programsArr;
	}
	
	
	public function getViewSpecialUrl($trialCat){
		$view_special_url = '';
		
		$program_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);
		$program_slug = $program_slug[0];
		
		if(!empty($trialCat->program_type) && !empty($trialCat->program_id)){
			if($trialCat->program_type == "program_cat"){
				$this->db->select(array('cat_id','cat_name','cat_slug'));
				$this->db->where('published',1);
				$programCats = $this->query_model->getBySpecific('tblcategory','cat_id',$trialCat->program_id);
				
				
				if(!empty($programCats)){
					$view_special_url =	base_url().$program_slug->slug.'/'.$programCats[0]->cat_slug;
				}
			}else{
				$this->db->select(array('id','program','program_slug','category'));
				$this->db->where('published',1);
				$programDetail = $this->query_model->getBySpecific('tblprogram','id',$trialCat->program_id);
				
				
				
				if(!empty($programDetail)){
					
					$this->db->select(array('cat_id','cat_name','cat_slug'));
					$this->db->where('published',1);
					$programCats = $this->query_model->getBySpecific('tblcategory','cat_id',$programDetail[0]->category);
					
					if(!empty($programCats)){
						$view_special_url =	base_url().$program_slug->slug.'/'.$programCats[0]->cat_slug.'/'.$programDetail[0]->program_slug;
					}
					
				}
			}
		}
		return $view_special_url;
	}
	
	
	
function checkMultiStudentPassword($table,$password,$location_id = null){
		$where = '(password="'.$password.'" and id = "'.$location_id.'")';
		$this->db->where($where);
		return $this->db->get($table)->result();
}


function getCurrentLocationCityStateName(){
	$school_slug = $this->query_model->getbySpecific('tblmeta', 'id', 51);
	$school_slug = $school_slug[0]->slug;
	
	$resultArr = array();
	$resultArr['current_city_state'] = '';
	if($this->uri->segment(1) != "" && $this->uri->segment(1) == $school_slug){
		
		if($this->uri->segment(2) != ""){
			
			$this->db->select(array('id','name','slug','address','city','state','zip'));
			$contactDetail = $this->query_model->getBySpecific('tblcontact','slug',$this->uri->segment(2));
			
			$resultArr['current_city_state'] = !empty($contactDetail) ? $contactDetail[0]->name : '';
			
		
		}
		
	}
	return $resultArr;
	
}


public function getFormPageUrl($page_url = null,$postData = null){
	
	if(!empty($page_url)){
		$multiSchool =  $this->query_model->getbySpecific("tblconfigcalendar",'id',12);
		
			if($multiSchool[0]->field_value == 1){
				if(isset($postData['message'])){
					$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
					$contact_slug = $contact_slug[0]->slug;
		
					$explodePageUrl = explode('/',$page_url);
					
					if(isset($explodePageUrl[1]) && !empty($explodePageUrl[1])){
						if($contact_slug == $explodePageUrl[1]){
							$page_url = '/'.$contact_slug;
						}
					}
				}
			}
	}
			
	
		return $page_url;
}
	
	
	
	public function programsCats(){
		
		$programCats = array();
		
		$this->db->select(array('cat_id','cat_name'));
		$this->db->where('published',1);
		
		$programCats = $this->query_model->getBySpecific('tblcategory','cat_type','programs');
		
		
		
		return $programCats;
	}
	
	
	public function programsListByCatId($cat_id = null){
		
		$programsArr = array();
		
		$this->db->select(array('cat_id','cat_name'));
		$this->db->where('published',1);
		if(!empty($cat_id) && $cat_id > 0){
			$this->db->where('cat_id',$cat_id);
		}
		$programCats = $this->query_model->getBySpecific('tblcategory','cat_type','programs');
		
			if(!empty($programCats)){
				foreach($programCats as $program_cat){
					$this->db->select(array('id','program'));
					$this->db->where('published',1);
					$this->db->where('show_learn_more',1);
					$programs = $this->query_model->getBySpecific('tblprogram','category',$program_cat->cat_id);
					
					if(!empty($programs)){
						foreach($programs as $program){
							$programsArr[$program->id] = $program;
						}
					}
				}
			}
		return $programsArr;
	}
	
	
	
	/********** code for download and video thread ************/
	public function getCategoryTreeForParentId($cat_type = null, $parent_id = 0) {
		
		 $categories = array();
		 
		 $this->db->from('tblcategory');
		 if(!empty($cat_type)){
			  $this->db->where('cat_type', $cat_type); 
		  }
		  $this->db->where('parent_id', $parent_id);
		  $result = $this->db->get()->result();
		  
		  foreach ($result as $mainCategory) {
			$category = array();
			$category['cat_id'] = $mainCategory->cat_id;
			$category['cat_name'] = $mainCategory->cat_name;
			$category['cat_slug'] = $mainCategory->cat_slug;
			$category['parent_id'] = $mainCategory->parent_id;
			$category['permission'] = $mainCategory->permission;
			$category['sub_categories'] = $this->getCategoryTreeForParentId($cat_type,$category['cat_id']);
			$categories[$mainCategory->cat_id] = $category;
		  }
		 
		  return $categories;
	}
	
	public function getCategoryTreeHTML($cat_type = null, $parent_id = 0,$level){
		
      $str = '';
      
	  $this->db->from('tblcategory');
		 if(!empty($cat_type)){
			  $this->db->where('cat_type', $cat_type); 
		  }
		  $this->db->where('parent_id', $parent_id);
		  $this->db->order_by('pos','ASC');
		  $result = $this->db->get()->result();
		 
		 $className = ($parent_id == 0) ? "mainCat" : 'subCat';
		  if(!empty($result)){
			 $level++;
			 foreach($result as $cat){
				 
				if($cat->cat_id == $this->uri->segment(4)){
					//$activeClass = 'active selected';
					$activeClass = 'active';
				}else{
					$activeClass = '';
				}
				
             $str .= '<li   id="menu_'.$cat->cat_id.'" class="az-contact-item little_row_'.$cat->cat_id.' '.$activeClass.'">';
			 
             $str .= '<div class="az-contact-body " id="catid_'.$cat->cat_id.'">';
			 
			 $dashes = '';
			 
			 for($i = 1; $i < $level; $i++){
				 $dashes .= '<img src="'.base_url().'img/icon_dash.jpg" class="dashesImg">';
			 }
			
			if($cat_type == 'downloads'){
				$linkType = 'downloads';
			}else{
				$linkType = 'albums';
			}
			
			if($cat->published == 1 && $cat_type != 'downloads'){
				$publishedClr = 'green';
			}else{
				$publishedClr = '';
			}
			
			
			
			
			 $str .= '<a href="admin/'.$linkType.'/view/'.$cat->cat_id.'" number="'.$cat->cat_id.'" id ="cat'.$cat->cat_id.'" class="show-entries download_thread_heading" style="color:'.$publishedClr.'"><h6 class="little_row_heading_'.$cat->cat_id.'">&nbsp; '.$dashes.' '.$cat->cat_name.'</h6></a><span></span>';
			 
			 $category['sub_categories'] = $this->getCategoryTreeForParentId($cat_type,$cat->cat_id);
				 if(!empty($category['sub_categories'])){
					$str .='<ul class="'.$className.'">';
					$str .= $this->getCategoryTreeHTML($cat_type,$cat->cat_id,$level);                  
					$str .="</ul>";
				 } 
				 
			  $str .= "</div><nav class='nav_box nav_".$cat->cat_id."'>";
			  
			  if(($cat->cat_id != 25) && ($cat->cat_id != 26)) {
					$str .= '<a  href="javascript:void(0)" class="badge-primary badge   full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="'.$cat->cat_id.'"  table_name="tblcategory" form_type="full_width_row">Edit</a>';
										
			 }
			 
			  if(($cat->cat_id != 25) && ($cat->cat_id != 26)) {
				  
				  $section_type = ($cat_type == 'downloads') ? 'full_width' : 'little_row';
				  $str .= '<a class="badge-primary badge  delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="'.$cat->cat_id.'"   table_name="tblcategory" item_title="'.$cat->cat_name.'" section_type="'.$section_type.'">Delete<input type="hidden" name="post-perm" class="post-perm" value="'.$cat->permission.'"/></a>';
			  }
										
			$str .= "</nav>";
			
			 
				 
			$str .= "</li>";  
			
				}
			  }
			  
     return $str;   
   }
   
   
	
   
	public function getCategoryDropdownOptions($cat_type = null,  $parent_id = 0,$level, $selected_id){
		
      $str = '';
      
	  $this->db->from('tblcategory');
		 if(!empty($cat_type)){
			  $this->db->where('cat_type', $cat_type); 
		  }
		  $this->db->where('parent_id', $parent_id);
		  $result = $this->db->get()->result();
		 
		  if(!empty($result)){
			 $level++;
			 foreach($result as $cat){
				 $dashes = '';
			 
				 for($i = 1; $i < $level; $i++){
					 $dashes .= '- ';
				 }
				
			
				$selected  = ($selected_id == $cat->cat_id) ? "selected = selected" : '';
						
             $str .= '<option value="'.$cat->cat_id.'" '.$selected.'>'.$dashes.$cat->cat_name.'</option>';
			 
             
			
			 $category['sub_categories'] = $this->getCategoryTreeForParentId($cat_type,$cat->cat_id);
				 if(!empty($category['sub_categories'])){
					$str .= $this->getCategoryDropdownOptions($cat_type,$cat->cat_id,$level, $selected_id);                  
					
				 } 
			
				}
			  }
			  
     return $str;  
   }
   
   public function getDownloadBrandcrumb($id = 0, $cat_type = null) {
		  $str = '';
		 
		  $this->db->from('tblcategory');
		  if(!empty($cat_type) && $cat_type == "videos"){
			 $this->db->where('cat_type', 'videos'); 
			  $linkType = 'videos_albums_new';
		  }else{
			  $this->db->where('cat_type', 'downloads');
			   $linkType = 'downloads';
		  }
		  
		  $this->db->where('cat_id', $id);
		  $cat = $this->db->get()->result();
			
		$student_section_slug = $this->query_model->getbySpecific('tblmeta', 'id', 47);
		$student_section_slug = $student_section_slug[0];
			  
			if(!empty($cat)){
				
				$str .= '<li class="brandcrumb_li">';
				if($cat[0]->parent_id != 0){
					$str .= '<a href="'.base_url().$student_section_slug->slug.'/'.$linkType.'/'.$cat[0]->cat_id.'">';
				}else{
					$str .= '<a href="'.base_url().$student_section_slug->slug.'/'.$linkType.'">';
				}
				$str .= $cat[0]->cat_name;
				$str .= '</a>';
				$str .= '</li>';
				$str .= $this->query_model->getDownloadBrandcrumb($cat[0]->parent_id); 
				 
			}
		
		return $str;
	}
	
	
   
	
   public function getSiteCurrencyType(){
	   $site_setting = $this->query_model->getByTable('tblsite');
	   $currencies = $this->query_model->getAllCurrencies();
	   
	   
	   $result = (isset($site_setting[0]->site_currency_type) && !empty($site_setting[0]->site_currency_type)) ? $currencies[$site_setting[0]->site_currency_type]['currency_symbol'] : '$';
	   
	   
	   return $result;
	  
   }
   
   
   public function getSiteCurrencyTypeForPaymentGateway(){
	   $site_setting = $this->query_model->getByTable('tblsite');
	   $currencies = $this->query_model->getAllCurrencies();
	  
	    $result = (isset($site_setting[0]->site_currency_type) && !empty($site_setting[0]->site_currency_type)) ? $currencies[$site_setting[0]->site_currency_type]['currency_code'] : 'USD';
	   
	   
	   return $result;
	  
   }
   
   public function getSiteCurrencyTypeForAdmin(){
	   $site_setting = $this->query_model->getByTable('tblsite');
	   $currencies = $this->query_model->getAllCurrencies();
	   
	   $result = (isset($site_setting[0]->site_currency_type) && !empty($site_setting[0]->site_currency_type)) ? $currencies[$site_setting[0]->site_currency_type]['currency_symbol'] : '$';
	   
	   return $result;
	  
   }
   
   public function getAllCurrencies(){
	   $result = array(
					'USD' => array('currency' => 'USD','currency_symbol' => '$','currency_code' => 'USD'),
					'CAD' => array('currency' => 'CAD','currency_symbol' => 'CAD','currency_code' => 'CAD'),
					'AUD' => array('currency' => 'Australian Dollar','currency_symbol' => '$','currency_code' => 'AUD'),
					'GBP' => array('currency' => 'Great Britain Pound','currency_symbol' => '£','currency_code' => 'GBP'),
					'EUR' => array('currency' => 'Euro','currency_symbol' => '€','currency_code' => 'EUR'),
						);
		
		return $result;
   }
   
   
   public function getStaticTextTranslation($original_key){
		
		$text = $original_key;
		
		$record = $this->query_model->getBySpecific('static_text_translations','original_key',$original_key);
		
		if(!empty($record)){
			$record = $record[0];
			if($record->type == "english"){
				$text = trim($record->english_text);
			}else{
				$text = !empty($record->translate) ? trim($record->translate) : trim($record->english_text);
			}
		}
	  return $this->query_model->getMetaDescReplace($text);
   }
   
   
   
   public function getCustomFieldNames($customFields){
	   $resultArr = array();
	   if(!empty($customFields)){
		   foreach($customFields as $key => $custom_field){
			   //echo '<pre>custom_field'; print_R($custom_field); die;
			   $this->db->select(array('id','label_text','type'));
				$custom_field_detail = $this->query_model->getBySpecific('tbl_dojocart_custom_fields', 'id', $key);
				
				if(!empty($custom_field_detail)){
					//$custom_field_detail = $custom_field_detail[0];
					$label_text = !empty($custom_field_detail[0]->label_text) ? strtolower($custom_field_detail[0]->label_text) : '';
					if($label_text == "name"){
						$resultArr['name'] = $custom_field;
					}elseif($label_text == "email"){
						$resultArr['email'] = $custom_field;
					}
				}
		   }
	   }
	  return $resultArr; 
   }
   
   
   public function getTrialSpecialOffersTableName(){
		
		$multiConfig = $this->query_model->getByTable('tblconfigcalendar');
		$result = ($multiConfig[13]->field_value == 1) ? 'tbl_unique_specialoffer' : 'tblspecialoffer';
		
		return $result;
	}
	
	 public function getTrialOffersUpsellsTableName(){
		
		$multiConfig = $this->query_model->getByTable('tblconfigcalendar');
		
		$result = ($multiConfig[13]->field_value == 1) ? 'tbl_unique_onlinespecial_upsales' : 'tbl_onlinespecial_upsales';
		
		return $result;
	}
	
	 public function getTrialOffersCategoryTableName(){
		
		$multiConfig = $this->query_model->getByTable('tblconfigcalendar');
		
		$result = ($multiConfig[13]->field_value == 1) ? 'tbl_unique_onlinespecial_categories' : 'tbl_onlinespecial_categories';
		
		return $result;
	}
	
	
	
public function saveWebLeadsOnMyStudio($data){

		
		// set form all values in a format way
		$formData = $this->setFormDataValueInFormat($data);
		
		$mystudio_result = $this->query_model->getbyTable("tbl_mystudio");

		if (!empty($mystudio_result)) {	
			if($mystudio_result[0]->multi_mystudio_check == 1){

					$location_detail = $this->query_model->getLocationIdForKickSite($data);
			}else{

					$location_detail = $mystudio_result;
			}
		}
		
		

		$PROGRAM_INTERESTS = isset($formData['program']) ? $formData['program'] : '';
		
		if(!empty($mystudio_result)){

			if($mystudio_result[0]->type == 1 && !empty($location_detail[0]->ms_url) ){

				$ms_url = trim($location_detail[0]->ms_url);
				
				
				//$data['Buyer_first_name'] = (isset($formData['name']) && !empty($formData['name'])) ? $formData['name'] : 'N/A';
				
				//$data['Buyer_last_name'] = (isset($formData['last_name']) && !empty($formData['last_name'])) ? $formData['last_name'] : 'N/A';
				
				// devide full name to first name and last name 
				$full_name = (isset($formData['name']) && !empty($formData['name'])) ? trim($formData['name']) : '';
				
				$first_name = 'N/A';
				$last_name = 'N/A';
				if(!empty($full_name)){
					$user_full_name = explode(' ',$full_name);
					$first_name = (isset($user_full_name[0]) && !empty($user_full_name[0])) ? $user_full_name[0] : $first_name;
					
					if(!empty($user_full_name)){
						unset($user_full_name[0]);
					}
					$last_name = !empty($user_full_name) ? implode(' ',$user_full_name) : $last_name;
				}
				
				$data['Buyer_first_name'] = $first_name;
				$data['Buyer_last_name'] = $last_name;
				/** end code for first name and last name **/
				
				
				
				$data['Email'] = $formData['email'];
				
				$data['Phone'] = isset($formData['phone']) ? $formData['phone'] : 'N/A';
				
				$data['Program_interest'] = isset($formData['program']) ? $formData['program'] : '';
				
				$data['Source'] = 'website dojo';

			
				
				//$data_string = json_encode($data);
				
				//$data_string = urldecode(http_build_query($data));
				
				$ch = curl_init($ms_url);                                                                     
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);                                                                      
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                                                                      
				
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));				
				                                                                                                                     
				$result = curl_exec($ch);
				$err = curl_error($ch);

				curl_close($ch);
				//echo '<pre>'; print_r($result); die;


				}
			}


}


public function isUniqueSpecialOffer(){
		
		$multiConfig = $this->query_model->getByTable('tblconfigcalendar');
		
		$result = ($multiConfig[13]->field_value == 1) ? 1 : 0;
		
		return $result;
	}
	
public function getDojocartThankyouUrl($slug = ''){
	$dojocart_slug = $this->query_model->getbySpecific('tblmeta', 'id', 49);
	$dojocart_slug = $dojocart_slug[0];
	$dojocart_thankyou_url = $dojocart_slug->slug.'/thank-you/'.$slug;
	return $dojocart_thankyou_url; 
}


public function getThankyouPageData($thankyouMessage){
	$data = array();
	
		if(!empty($thankyouMessage)){
			
			$data['thankyou_message'] = '';
			if(isset($thankyouMessage['thankyou_page_id'])){
				$this->db->where('status',1);
				$thankyouPageDetail = $this->query_model->getbySpecific('tbl_form_thankyou_pages', 'id', $thankyouMessage['thankyou_page_id']);
				
				if(!empty($thankyouPageDetail)){
					
					$data['thankyou_message'] = $thankyouPageDetail[0]->description;
					
					
				}
			}
			
			
			$data['postData'] = $thankyouMessage['postData'];
			$data['twilioApi'] = $this->query_model->getTwilioApiType();
			
			$data['contact_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 21);
			$data['contact_slug'] = $data['contact_slug'][0];
		
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			
			$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
			$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		
			$this->db->where("published", 1);
			if($data['multiSchool'] == 1){
				$this->db->where("main_location", 0);
			}
			$this->db->where("location_type", 'regular_link');
			$this->db->order_by("pos","asc");
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			
			
			
			$data['form_allLocations'] = $this->query_model->getFormAllLocations();
			
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		}
		
		$this->session->unset_userdata('thankyouMessage');		
			return $data;
}
	
	
public function getProgramThankyouUrl($postData){
		$program_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);
		$program_slug = $program_slug[0];
		
		if(isset($postData['page_url']) && !empty($postData['page_url'])){
		    
		    $postData['page_url'] = $this->query_model->reconstruct_url($postData['page_url']);
		    
			$pageUrl = explode('/',$postData['page_url']);
			
			if($_SERVER['SERVER_NAME'] == "localhost"){
				$is_program_cat_page = (count($pageUrl) == 4 && $pageUrl[2] == $program_slug->slug) ? 1 : 0;
			}else{
				$is_program_cat_page = (count($pageUrl) == 3 && $pageUrl[1] == $program_slug->slug) ? 1 : 0;
			}
		}
		
		if($is_program_cat_page == 1){
			if(isset($postData['program_cat_id']) && !empty($postData['program_cat_id'])){
				$programCatDetailSlug = $this->query_model->getBySpecific('tblcategory','cat_id',$postData['program_cat_id']);
				$program_cat_slug = !empty($programCatDetailSlug) ? $programCatDetailSlug[0]->cat_slug : '';
			
				$program_thankyou_url = $program_slug->slug.'/'.$program_cat_slug.'/thank-you';
			
			}
		}else{
			if(isset($postData['program_id']) && !empty($postData['program_id'])){
				$this->db->select('program_slug');
				$programDetailSlug = $this->query_model->getBySpecific('tblprogram','id',$postData['program_id']);
				$program_detail_slug = !empty($programDetailSlug) ? $programDetailSlug[0]->program_slug : '';
				
				$programCatDetailSlug = $this->query_model->getBySpecific('tblcategory','cat_id',$postData['program_cat_id']);
				$program_cat_slug = !empty($programCatDetailSlug) ? $programCatDetailSlug[0]->cat_slug : '';
				
				$program_thankyou_url = $program_slug->slug.'/'.$program_cat_slug.'/'.$program_detail_slug.'/thank-you';
			}
		}
		
		
		return $program_thankyou_url;
}


public function getTrialOfferThankyouUrl($postData){
	$trial_offer_thankyou_url = '';
	if(isset($_POST['trial_id']) && isset($_POST['trial_offer_cat_id'])){
		$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$start_trial_slug = $start_trial_slug[0];
		
		$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
		
		$trial_category = $this->query_model->getBySpecific("$tbl_onlinespecial_categories",'id',$_POST['trial_offer_cat_id']);
		
		/*if($trial_offer->trial == 1){
		$payment = $this->query_model->getByTable('tbl_payments');
		if(!empty($payment)){*/
			
		//echo '<pre>trial_category'; print_R($trial_category); die;
		if(!empty($trial_category)){
			
			$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
			$trial_record = $this->query_model->getbySpecific("$tblspecialoffer",'id',$_POST['trial_id']);
			
			$trial_type = "Free";
			if(!empty($trial_record)){
				if($trial_record[0]->trial == 1){
					$payment = $this->query_model->getByTable('tbl_payments');
					if(!empty($payment)){
						if($payment[0]->authorize_net_payment == 1 || $payment[0]->braintree_payment == 1 || $payment[0]->stripe_payment == 1 || $payment[0]->stripe_ideal_payment == 1 || $payment[0]->paypal_payment == 1){
							
							$trial_type = "Paid";
						}
					}
			
				}
			}
			$trial_offer_thankyou_url = $start_trial_slug->slug.'/'.$trial_category[0]->slug.'/'.$trial_type.'-'.$_POST['trial_id'].'/thank-you';
			
		}
		
	}
	
	return $trial_offer_thankyou_url;
}


public function getTrialUpsellThankyouUrl($postData){
	//echo '<pre>postData'; print_R($postData); die;
	
	$upsell_thankyou_url = '';
	
	$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
	$start_trial_slug = $start_trial_slug[0];
	
	if(isset($_POST['trial_id']) && !empty($_POST['trial_id'])){
		$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
		$trial_record = $this->query_model->getbySpecific("$tblspecialoffer",'id',$_POST['trial_id']);
		
		if(!empty($trial_record)){
			
			
			$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
			
			$trial_category = $this->query_model->getBySpecific("$tbl_onlinespecial_categories",'id',$trial_record[0]->cat_id);
			
			if(!empty($trial_category)){
				$upsell_thankyou_url = $start_trial_slug->slug.'/'.$trial_category[0]->slug.'/'.'Trial-'.$_POST['trial_id'].'/Upsell/thank-you';
			}
			//echo '<pre>trial_category'; print_r($upsell_thankyou_url); die;
		}
	}
	
	return $upsell_thankyou_url;
	
}


public function getDojocartItemSaleTax($dojocartDetail, $item_sales_tax, $item_price){
	$saleTaxArr = array();
	$saleTaxArr['result'] = 0;
	$saleTaxArr['sale_tax'] = '';
	if(!empty($dojocartDetail) && !empty($item_sales_tax)){
		if($dojocartDetail[0]->multi_item_sales_taxable == 1){
			$saleTaxArr['result'] = 2;
			$saleTaxArr['sale_tax'] = $item_sales_tax;
			$saleTaxArr['sale_tax_amount'] = $this->query_model->get_dojocart_sale_tax_amount($item_price, $item_sales_tax);
			$saleTaxArr['amount_with_tax'] = $this->query_model->get_percent($item_price, $item_sales_tax);
		}elseif($dojocartDetail[0]->sales_taxable == 1){
			$saleTaxArr['result'] = 1;
			$saleTaxArr['sale_tax'] = $dojocartDetail[0]->sales_tax_main;
		}
	}
	
	return $saleTaxArr;
}



public function get_dojocart_sale_tax_amount( $price, $sales_tax){
	$sale_tax = ($price*$sales_tax)/100;
	$sale_tax = $sale_tax;
	return $sale_tax; 

}


public function save_dojocart_order_items($dojocartItem = null,$order_id=0,$product_id=0){
	// kz multi_item
		$dojocartItemsText = '';
		if(isset($dojocartItem) && !empty($dojocartItem)){
			foreach($dojocartItem as $item_id => $dojocart_item){
				
				if(!empty($dojocart_item)){
					foreach($dojocart_item as $contact_number => $item){
						
						$insertItemArr = array();
						$insertItemArr['order_id'] = $order_id;
						$insertItemArr['dojocart_id'] = $product_id;
						$insertItemArr['item_id'] = $item_id;
						
						$insertItemArr['first_name'] = isset($item['first_name'])? trim($item['first_name']) : '';
						$insertItemArr['last_name'] = isset($item['last_name'])? trim($item['last_name']) : '';
						$contact_name = $insertItemArr['first_name'].' '.$insertItemArr['last_name'];
						$insertItemArr['contact_name'] = trim($contact_name);
						
						$insertItemArr['item_title'] = isset($item['item_title'])? $item['item_title'] : '';
						$insertItemArr['qty'] = isset($item['qty'])? $item['qty'] : 0;
						
						$insertItemArr['sale_tax_amount'] = isset($item['sale_tax_amount'])? $item['sale_tax_amount'] : 0;
						$insertItemArr['amount'] = isset($item['amount'])? $item['amount'] : 0;
						$insertItemArr['total_amount'] = isset($item['total_amount'])? $item['total_amount'] : 0;
						$insertItemArr['created_at'] = date('Y-m-d H:i:s');
						
						$this->query_model->insertData('tbl_dojocart_order_items', $insertItemArr);
					}	
				}
			}
		}
	
	
}


public function getLocationIdsByProgramId($program_id){
	$form_allLocations = array();
	if(!empty($program_id)){
		
		$this->db->select(array('show_location_type','locations'));
		$programDetail = $this->query_model->getBySpecific('tblprogram','id',$program_id);
		
		if(!empty($programDetail)){
			if($programDetail[0]->show_location_type == "show_all"){
				if($this->query_model->checkMultiSchoolIsOn() == 1){
					$this->db->where("turn_on_nested_location", 0);  //not nested child locations
				}
				$this->db->where("location_type !=", 'coming_soon_location');
				//$this->db->where("main_location", 0);
				$this->db->where("published", 1);
				$this->db->order_by("state","asc");
				$this->db->select(array('id','name'));
				$form_allLocations = $this->query_model->getbyTable("tblcontact");
				
			}elseif($programDetail[0]->show_location_type == "select_location"){
				$selectedLocationsArr = !empty($programDetail[0]->locations) ? unserialize($programDetail[0]->locations) : array();
				
				if(!empty($selectedLocationsArr)){
					$selectedLocations  =array();
					$finalLocations  = array();
					foreach($selectedLocationsArr as $selectedLoc){
						
						if($this->query_model->checkMultiSchoolIsOn() == 1){
							$this->db->where("turn_on_nested_location", 0);  //not nested child locations
						}
						$this->db->where("published", 1);
						$this->db->where("id", $selectedLoc);
						$this->db->select(array('id','name'));
						$locationResult = $this->query_model->getbyTable("tblcontact");
						if(!empty($locationResult )){
							foreach($locationResult as $locationRes){
								
								$selectedLocations[$locationRes->id] = $locationRes;
							}
						}
					}
					$form_allLocations = $selectedLocations;
				}
				
			}
		}
	}
	return $form_allLocations;
}


public function getProgramIdsByLocationId($location_id){
	$form_programs = array();
	if(!empty($location_id)){
		
		$this->db->select(array('id','program','show_location_type','locations'));
		$programs = $this->query_model->getBySpecific('tblprogram','published',1);
		
		if(!empty($programs)){
			foreach($programs as $program){
				if($program->show_location_type == "show_all"){
					$form_programs[$program->id]['id'] = $program->id;
					$form_programs[$program->id]['program'] = $program->program;
				}elseif($program->show_location_type == "select_location"){
					
					$selectedLocationsArr = !empty($program->locations) ? unserialize($program->locations) : array();
					
					if(!empty($selectedLocationsArr)){
						if(in_array($location_id,$selectedLocationsArr)){
							$form_programs[$program->id]['id'] = $program->id;
							$form_programs[$program->id]['program'] = $program->program;
						}
					}
					
				}
			}
		}
	}
	
	return $form_programs;
}




	
public function saveWebLeadsOnMAT($data){

		$result = 0;
		// set form all values in a format way
		$formData = $this->setFormDataValueInFormat($data);
		
		$mat_result = $this->query_model->getbyTable("tbl_mat_api");
		
		
		if(!empty($mat_result)){

			if($mat_result[0]->type == 1 ){
				
				
				$matDetail = $mat_result[0];
				
				$program_id =  (isset($formData['program_id']) && !empty($formData['program_id'])) ? $formData['program_id'] : '';
				
				$mat_category_id = (isset($matDetail->default_cat_id) && !empty(isset($matDetail->default_cat_id))) ? $matDetail->default_cat_id : 0;
				
				if(!empty($program_id)){
					
					$this->db->select(array('id','program','category'));
					$program_detail = $this->query_model->getBySpecific('tblprogram','id',$program_id);
					
					if(!empty($program_detail)){
						
						$selected_cats = (isset($matDetail->map_categories) && !empty($matDetail->map_categories)) ? unserialize($matDetail->map_categories) : '';
						
						$mat_category_id = (isset($selected_cats[$program_detail[0]->id]['mat_cat_id']) && !empty($selected_cats[$program_detail[0]->id]['mat_cat_id'])) ? $selected_cats[$program_detail[0]->id]['mat_cat_id'] : $mat_category_id;
						
					}
				}
				
				$first_name = (isset($formData['name']) && !empty($formData['name'])) ? urlencode($formData['name']) : '';
				$last_name = (isset($formData['last_name']) && !empty($formData['last_name'])) ? urlencode($formData['last_name']) : '';
				$email = (isset($formData['email']) && !empty($formData['email'])) ? $formData['email'] : '';
				$phone = (isset($formData['phone']) && !empty($formData['phone'])) ? str_replace(' ','',$formData['phone']) : '';
				
				$ms_url = base_url().'site/save_mat_api_lead_data/?mat_category_id='.$mat_category_id.'&first_name='.$first_name.'&last_name='.$last_name.'&email='.$email.'&phone='.$phone;
				
				
				$request = curl_init($ms_url); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 0); // Returns response data instead of TRUE(1)
				
				curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
				curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

				$response = (string)curl_exec($request); // execute curl post and store results in $response
				$error_msg = curl_error($request);
				curl_close($request); // close curl object
				
				$result = 1;
				
				/*echo '<pre>error_msg'; print_r($error_msg);
				echo '<pre>response'; print_r($response); die;*/
				
				}
			}
		//return $result;

}




public function getContactLeadEmailInfo($email, $name,$school = null,$contact_lead_id){
		$currentDate = date("Y-m-d h:i:s");
		$lastDate = date("Y-m-d h:i:s", strtotime("-5 minutes", strtotime($currentDate)));
		
		if(!empty($school)){
			$this->db->where( array( 'email'=> $email, 'name'=> $name,  'school'=> $school, 'is_delete' => 0,'date_added >=' => $lastDate) );
		}else{
			$this->db->where( array( 'email'=> $email, 'name'=> $name, 'is_delete' => 0,'date_added >=' => $lastDate) );
		}
		
		$result = $this->db->get('tblcontactusleads')->result();
		
		if(!empty($result)){
			foreach($result as $res){
				if($contact_lead_id != $res->id){
					$data = array('is_delete' => 1);
					$this->db->where('id',$res->id);
					$this->db->update('tblcontactusleads', $data);
				}
			
			}
		}
	}
	


	
public function saveFormDataOnMATApi($data){
	
	$is_mat_api_apply = $this->session->userdata('is_mat_api_apply');
	
	if(!empty($data) && $is_mat_api_apply == 1){
			// set form all values in a format way
			
		$data = isset($data['postData']) ? $data['postData'] : $data;
		$formData = $this->setFormDataValueInFormat($data);
		
		
		$mat_result = $this->query_model->getbyTable("tbl_mat_api");
		
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		$multiLocation = $multiLocation[0];
		
		if(!empty($mat_result)){

			if($mat_result[0]->type == 1 ){
				
				$matDetail = array();
				if($mat_result[0]->multi_mat_check == 1 && $multiLocation->field_value == 1){
					
					if(isset($formData['selected_location_id']) && !empty($formData['selected_location_id'])){
						
						$this->db->select(array('id','name','default_cat_id','map_categories'));
						$locationDetail = $this->query_model->getBySpecific('tblcontact','id',$formData['selected_location_id']);
						
						if(!empty($locationDetail)){
							$matDetail['default_cat_id'] = $locationDetail[0]->default_cat_id;
							$matDetail['map_categories'] = $locationDetail[0]->map_categories;
							$selectedClubIds = !empty($mat_result[0]->location_club_id) ? unserialize($mat_result[0]->location_club_id) : '';
							$matDetail['club_id'] = isset($selectedClubIds[$locationDetail[0]->id]) ? $selectedClubIds[$locationDetail[0]->id] : '';
							
						}
						
					}
					
				}else{
					$matDetail['default_cat_id'] = $mat_result[0]->default_cat_id;
					$matDetail['map_categories'] = $mat_result[0]->map_categories;
					$matDetail['club_id'] = $mat_result[0]->club_id;
				}
				
			
			if(!empty($matDetail)){
				//$matDetail = $mat_result[0];
				
				$program_id =  (isset($formData['program_id']) && !empty($formData['program_id'])) ? $formData['program_id'] : '';
				
				$mat_category_id = (isset($matDetail['default_cat_id']) && !empty($matDetail['default_cat_id'])) ? $matDetail['default_cat_id'] : 0;
				
				if(!empty($program_id)){
					
					$this->db->select(array('id','program','category'));
					$program_detail = $this->query_model->getBySpecific('tblprogram','id',$program_id);
					
					if(!empty($program_detail)){
						
						$selected_cats = (isset($matDetail['map_categories']) && !empty($matDetail['map_categories'])) ? unserialize($matDetail['map_categories']) : '';
						//$mat_category_id = (isset($selected_cats[$program_detail[0]->category]) && !empty($selected_cats[$program_detail[0]->category])) ? $selected_cats[$program_detail[0]->category]['mat_cat_id'] : $mat_category_id;
						$mat_category_id = (isset($selected_cats[$program_detail[0]->id]['mat_cat_id']) && !empty($selected_cats[$program_detail[0]->id]['mat_cat_id'])) ? $selected_cats[$program_detail[0]->id]['mat_cat_id'] : $mat_category_id;
						
					}
				}
				
				$first_name = (isset($formData['name']) && !empty($formData['name'])) ? urlencode($formData['name']) : '';
				$last_name = (isset($formData['last_name']) && !empty($formData['last_name'])) ? urlencode($formData['last_name']) : '';
				$email = (isset($formData['email']) && !empty($formData['email'])) ? $formData['email'] : '';
				$phone = (isset($formData['phone']) && !empty($formData['phone'])) ? str_replace(' ','',$formData['phone']) : '';
				$club_id = isset($matDetail['club_id']) ? $matDetail['club_id'] : 0;
				
				$ms_url = base_url().'site/save_mat_api_lead_data/?mat_category_id='.$mat_category_id.'&club_id='.$club_id.'&first_name='.$first_name.'&last_name='.$last_name.'&email='.$email.'&phone='.$phone;
				
				
				$request = curl_init($ms_url); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 0); // Returns response data instead of TRUE(1)
				
				curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
				curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

				$response = (string)curl_exec($request); // execute curl post and store results in $response
				$error_msg = curl_error($request);
				curl_close($request); // close curl object
				
				/*echo '<pre>error_msg'; print_r($error_msg);
				echo '<pre>response'; print_r($response); die;*/
				
					}
				}
			}
			
			$this->session->set_userdata('is_mat_api_apply',0);
		}
		


}



	public function matApiCheckFormModuleApplyAPI($postData){
			
			$page_url = isset($postData['page_url']) ? $postData['page_url'] : '';
			
			$page_url = $this->query_model->reconstruct_url($page_url);
			
			$page_url = $this->query_model->getFormPageUrl($page_url,$postData);
			
			//echo '<pre>page_url'; print_R($postData); die;
			// getting form instance by page url 
			if(isset($postData['trial_offer_cat_id']) && !empty($postData['trial_offer_cat_id'])){
				$this->db->where("action_id",$postData['trial_offer_cat_id']);
			}
			$formInstance = $this->query_model->getbySpecific('tbl_form_instances', 'page_url', $page_url);
			
			//echo '<pre>formInstance'; print_r($formInstance); die;
			
			$is_mat_api_apply = 0;
			
			if(!empty($formInstance)){
				
				
				// geeting form model id if not empty form instance
				$form_model_id = isset($formInstance[0]) ? $formInstance[0]->form_module_id : '';
				
				// getting form model detail by form model id
				$formModelDetail = $this->query_model->getbySpecific('tbl_form_modules', 'id', $form_model_id);
				
				
				if(!empty($formModelDetail)){
					
					$connectedTypesArr = !empty($formModelDetail[0]->connected_type) ? explode(', ',$formModelDetail[0]->connected_type) : '';
					
				  if(!empty($connectedTypesArr)){
					  
				   foreach($connectedTypesArr as $connectedType){
					
						if($connectedType == 'MAT'){
							
							$is_mat_api_apply = 1;
							
						}
					
					
					 }
					}
				}
			}
		return $is_mat_api_apply;
	}
	
	
	
	public function getAndUpdateMatApiIsAppiled($data){
		
		if(!empty($data)){
			$is_mat_api_apply = $this->query_model->matApiCheckFormModuleApplyAPI($data);
			
			if($is_mat_api_apply == 1){
				$this->session->set_userdata('is_mat_api_apply',1);
				$this->query_model->getThankYouPageMessage($data);
			}
		}
		
	}
	
	
	
	public function getAuthorizedPaymentCardError($error_msg = null){
		
		if(!empty($error_msg)){
			if (strpos($error_msg, 'AnetApiSchema.xsd:cardCode') !== false) {
				$error_msg = "The card verification value (cvv) is invalid";
			}elseif (strpos($error_msg, 'AnetApiSchema.xsd:cardNumber') !== false) {
				$error_msg = "The card number is invalid.";
			}
		}
		return $error_msg;
	}


	public function getAllNestedParentLocations($current_id = null){
		
		if(!empty($current_id)){
			$this->db->where("id !=", $current_id);
		}
		
		$this->db->where("location_type !=", 'coming_soon_location');
		$this->db->where("turn_on_nested_location", 1);
		$this->db->where("school_location_type", 'default');
		$this->db->order_by("state","asc");
		$this->db->select(array('id','name','parent_id','location_type'));
		$allLocations = $this->query_model->getbyTable("tblcontact");
		
		return $allLocations;
		
	}
	
	
	public function checkMultiSchoolIsOn(){
		$result = 0;
		$configCalendar = $this->query_model->getbyTable("tblconfigcalendar");
		if($configCalendar[11]->field_value == 1){
			$result = 1;
		}
		
		return $result;
	}
	
	
	public function getFormAllLocations($with_main_location = null){
		
		if($this->query_model->checkMultiSchoolIsOn() == 1){
			$this->db->where("turn_on_nested_location", 0);  //not nested child locations
			if(empty($with_main_location)){
				$this->db->where("main_location", 0);
			}
			
		}
		$this->db->where("published", 1);
		$this->db->order_by("pos","asc");
		$result = $this->query_model->getbyTable("tblcontact");
		
		return $result;
	}

	public function fullNameInputMaxLength(){
		return 50;
	}
	
	
	
	public function getNestedLocationsArr(){
		$nestedLocationsArr = array();
		$nestedLocationIds = array();
		
		$this->db->where("published", 1);
		$this->db->where("school_location_type", 'default');
		$this->db->where("turn_on_nested_location", 1);
		$this->db->order_by("pos","asc");
		$this->db->group_by('state');
		$this->db->select(array('id','name','slug','city','state'));
		$nested_results = $this->query_model->getbyTable("tblcontact");
		
		
		if(!empty($nested_results)){
			$i = 0;
			foreach($nested_results as $nested_result){
				
				$childNestedArr = array();
				
				$nestedLocationsArr['menu'][$i]['id'] = $nested_result->id;
				$nestedLocationsArr['menu'][$i]['name'] = $nested_result->name;
				$nestedLocationsArr['menu'][$i]['slug'] = $nested_result->slug;
				$nestedLocationsArr['menu'][$i]['city'] = $nested_result->city;
				$nestedLocationsArr['menu'][$i]['state'] = $nested_result->name;
				$nestedLocationsArr['menu'][$i]['parent'] = 'Column 1';
				$nestedLocationsArr['menu'][$i]['value'] = $nested_result->name;
				
				$nestedLocationIds[$nested_result->id] = $nested_result->id;
				
					
					$this->db->where("published", 1);
					$this->db->where("school_location_type", 'nested');
					$this->db->where("turn_on_nested_location", 0);
					$this->db->where("parent_id", $nested_result->id);
					$this->db->order_by("pos","asc");
					//$this->db->group_by('state');
					$this->db->select(array('id','name','slug','city','state'));
					$nested_child_results = $this->query_model->getbyTable("tblcontact");
					
					foreach($nested_child_results as $nested_child){
						$childNestedArr[$nested_child->id]['id'] = $nested_child->id;
						$childNestedArr[$nested_child->id]['name'] = $nested_child->name;
						$childNestedArr[$nested_child->id]['slug'] = $nested_child->slug;
						$childNestedArr[$nested_child->id]['city'] = $nested_child->city;
						$childNestedArr[$nested_child->id]['state'] = $nested_child->state;
						
						$childNestedArr[$nested_child->id]['parent'] = $nested_result->name;
						$childNestedArr[$nested_child->id]['value'] = $nested_child->name;
						
						$nestedLocationIds[$nested_child->id] = $nested_child->id;
					}
					
					
					$this->db->where("published", 1);
					$this->db->where("school_location_type", 'default');
					$this->db->where("turn_on_nested_location", 0);
					$this->db->where("state", $nested_result->state);
					$this->db->order_by("pos","asc");
					//$this->db->group_by('state');
					$this->db->select(array('id','name','slug','city','state'));
					$default_locations = $this->query_model->getbyTable("tblcontact");
					foreach($default_locations as $default_location){
						//$childNestedArr[$default_location->id] = $default_location;
						$childNestedArr[$default_location->id]['id'] = $default_location->id;
						$childNestedArr[$default_location->id]['name'] = $default_location->name;
						$childNestedArr[$default_location->id]['slug'] = $default_location->slug;
						$childNestedArr[$default_location->id]['city'] = $default_location->city;
						$childNestedArr[$default_location->id]['state'] = $default_location->state;
						
						$childNestedArr[$default_location->id]['parent'] = $nested_result->name;
						$childNestedArr[$default_location->id]['value'] = $default_location->name;
						
						$nestedLocationIds[$default_location->id] = $default_location->id;
					}
					
					$nestedLocationsArr['menu'][$i]['children'] = $childNestedArr;
				$i++;
			}
		}
		
		$nestedLocationsArr['location_ids'] = $nestedLocationIds;
		
		return $nestedLocationsArr;
	}
	
	public function getNormalLocationsArr($location_ids = ''){
		
		$normalLocationsArr = array();
		
		if(!empty($location_ids)){
			$this->db->where_not_in('id', $location_ids);
		}
		$this->db->where("school_location_type", "default");
		$this->db->where("turn_on_nested_location", 0);
		$this->db->where("published", 1);
		$this->db->where("main_location", 0);
		$this->db->order_by("pos","asc");
		$this->db->group_by('state');
		$this->db->select(array('id','name','slug','city','state'));
		
		$unique_states = $this->query_model->getbyTable("tblcontact");
		
		if(!empty($unique_states)){
			$i = 0;
			foreach($unique_states as $nested_result){
				
				$childNestedArr = array();
				
				$normalLocationsArr[$i]['id'] = $nested_result->id;
				$normalLocationsArr[$i]['name'] = $nested_result->name;
				$normalLocationsArr[$i]['slug'] = $nested_result->slug;
				$normalLocationsArr[$i]['city'] = $nested_result->city;
				$normalLocationsArr[$i]['state'] = $nested_result->state;
				
				$normalLocationsArr[$i]['parent'] = 'Column 1';
				$normalLocationsArr[$i]['value'] = $nested_result->state;
				
				
				if(!empty($location_ids)){
					$this->db->where_not_in('id', $location_ids);
				}
				$this->db->where("published", 1);
				$this->db->where("school_location_type", 'default');
				$this->db->where("turn_on_nested_location", 0);
				$this->db->where("state", $nested_result->state);
				$this->db->order_by("pos","asc");
				$this->db->select(array('id','name','slug','city','state'));
				$default_locations = $this->query_model->getbyTable("tblcontact");
				foreach($default_locations as $default_location){
					$childNestedArr[$default_location->id]['id'] = $default_location->id;
					$childNestedArr[$default_location->id]['name'] = $default_location->name;
					$childNestedArr[$default_location->id]['slug'] = $default_location->slug;
					$childNestedArr[$default_location->id]['city'] = $default_location->city;
					$childNestedArr[$default_location->id]['state'] = $default_location->state;
					
					$childNestedArr[$default_location->id]['parent'] = $nested_result->state;
					$childNestedArr[$default_location->id]['value'] = $default_location->name;
					
					
					
				}
				
				$normalLocationsArr[$i]['children'] = $childNestedArr;
				
			$i++;	
			}
		}
		
		return $normalLocationsArr;
	}
	
	
	public function getNestedSchoolMenu(){
		$locations = array();
		
		$nestedLocations = $this->query_model->getNestedLocationsArr();
		
		$normalLocations = $this->query_model->getNormalLocationsArr($nestedLocations['location_ids']);
		$nestedLocationList = (isset($nestedLocations['menu']) && !empty($nestedLocations['menu'])) ? $nestedLocations['menu'] : '';
		if(!empty($normalLocations) && !empty($nestedLocationList)){
			$locations = array_merge($nestedLocationList,$normalLocations);
		}else{
			if(!empty($nestedLocationList)){
				$locations = $nestedLocationList;
			}elseif(!empty($normalLocations)){
				$locations = $normalLocations;
			}
		}
		
		return $locations;
	}
	public function setNestedSchoolMenu(){
		$schoolMenuArr = array();
		$schoolMenu = $this->query_model->getNestedSchoolMenu();
		
		$boxes = array('Column 1','Column 2','Column 3','Column 4');
		
		foreach($boxes as $key=> $box){
			$schoolMenuArr[$key]['name'] = $box;
			$schoolMenuArr[$key]['value'] = $box;
			$schoolMenuArr[$key]['parent'] = 0;
				
			if($key == 0){
				$schoolMenuArr[$key]['children'] = $schoolMenu;
			}
		}
		
		return $schoolMenuArr;
	}
	
	
	public function getStripePaymentKeys($postData = null){
		
		$stripePayment = array();
		$this->db->select(array('stripe_payment','multi_stripe_check','stripe_sca_payment','stripe_secret_key','stripe_publishable_key'));
		$stripePaymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
		
		$stripe_payment = $stripePaymentDetail[0]->stripe_payment;
		$multi_stripe_check = $stripePaymentDetail[0]->multi_stripe_check;
		
		
		$multiLocationData = $this->query_model->getbySpecific("tblconfigcalendar",'id',1);
		$stripePayment['stripe_sca_payment'] = $stripePaymentDetail[0]->stripe_sca_payment;
		$stripePayment['stripe_payment'] = $stripe_payment;
		$stripePayment['multi_location'] = $multiLocationData[0]->field_value;
		$stripePayment['multi_stripe_check'] = $multi_stripe_check;
		
		if($multiLocationData[0]->field_value == 1 && $multi_stripe_check == 1){
			$location_id = (isset($postData['location_id']) && !empty($postData['location_id'])) ? $postData['location_id'] : 0;
			
			if(!empty($location_id) && $location_id > 0){
				$contact_detail = $this->query_model->getbySpecific('tblcontact','id',$location_id);
				if(!empty($contact_detail)){
					$stripePayment['stripe_secret_key'] = $contact_detail[0]->stripe_secret_key;
					$stripePayment['stripe_publishable_key'] = $contact_detail[0]->stripe_publishable_key;
				}
			}
		}else{
			$stripePayment['stripe_secret_key'] = $stripePaymentDetail[0]->stripe_secret_key;
			$stripePayment['stripe_publishable_key'] = $stripePaymentDetail[0]->stripe_publishable_key;
		}
		
		return $stripePayment;
	}
	
	
	public function retrive_payment_intent($postData, $stripe_secret_key, $description=''){
				
				$result = array();
				$result['status'] = '';
				
				$payment_intent_id = (isset($postData['payment_intent_id']) && !empty($postData['payment_intent_id'])) ? $postData['payment_intent_id'] : '';
				$name = (isset($postData['name']) && !empty($postData['name'])) ? $postData['name'] : '';
				$email = (isset($postData['form_email_2']) && !empty($postData['form_email_2'])) ? $postData['form_email_2'] : $postData['email'];
				$phone = (isset($postData['phone']) && !empty($postData['phone'])) ? $postData['phone'] : '';
				$stripeToken = (isset($postData['stripeToken']) && !empty($postData['stripeToken'])) ? $postData['stripeToken'] : '';
				
				
				$data  =array('stripe_action'=>'RetrivePaymentIntent','payment_intent_id'=>$payment_intent_id,'name'=>$name,'email'=>$email,'phone'=>$phone,'description'=>$description,'stripeToken'=>$stripeToken);
				
				
				$url = base_url().'vendor/stripe-latest/custom_stripe.php?stripe_secret_key='.$stripe_secret_key;
				
				$request = curl_init($url); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
				curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
				curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

				$response = (string)curl_exec($request); // execute curl post and store results in $response

				// additional options may be required depending upon your server configuration
				// you can find documentation on curl options at http://www.php.net/curl_setopt
				curl_close($request); // close curl object
				
				$response = json_decode($response);
				
				if(!empty($response) && isset($response->status) && $response->status == 1){
					if(isset($response->result->status) && !empty($response->result->status)){
						$result['status'] = $response->result->status;
						$result['balance_transaction'] = isset($response->result->charges->data[0]->balance_transaction) ? $response->result->charges->data[0]->balance_transaction : '';
						$result['response'] = $response;
					}
				}
				return $result;
	}
	
	
	
	
	
public function save_dojocart_order_upsells($dojocartUpsells = null,$order_id=0,$product_id=0){
	// kz multi_item
		$dojocartItemsText = '';
		if(isset($dojocartUpsells) && !empty($dojocartUpsells)){
			foreach($dojocartUpsells as $item_id => $dojocart_upsell){
					
						
						$insertItemArr = array();
						$insertItemArr['order_id'] = $order_id;
						$insertItemArr['dojocart_id'] = $product_id;
						$insertItemArr['upsell_id'] = (isset($dojocart_upsell['id']) && !empty($dojocart_upsell['id'])) ? $dojocart_upsell['id'] : 0;
						
						$insertItemArr['upsell_title'] = isset($dojocart_upsell['title'])? $dojocart_upsell['title'] : '';
						$insertItemArr['qty'] = isset($dojocart_upsell['qty'])? $dojocart_upsell['qty'] : 0;
						$beforetax_amount = isset($dojocart_upsell['beforetax_amount'])? $dojocart_upsell['beforetax_amount'] : 0;
						$insertItemArr['amount'] = isset($dojocart_upsell['amount'])? $dojocart_upsell['amount'] : 0;
						$insertItemArr['sale_tax_amount'] = $insertItemArr['amount'] - $beforetax_amount;
						
						$insertItemArr['total_amount'] = $insertItemArr['qty'] * $insertItemArr['amount'];
						$insertItemArr['created_at'] = date('Y-m-d H:i:s');
						
						$this->query_model->insertData('dojocart_order_upsells', $insertItemArr);
			}
		}
	
	
}


public function setUniqueNumberForForms(){
	$uniqueid = '';
	
	//$this->db->order_by('rand()');
	$this->db->limit(1);
	$record = $this->query_model->getByTable('tbl_form_unique_ids');
	
	if(!empty($record)){
		if(!empty($record[0]->unique_id)){
			$uniqueid = $record[0]->unique_id;
			
			$website_unique_id = array('website_unique_id' => $uniqueid);
			
			$this->session->set_userdata($website_unique_id);
			
		}
		
	}
	
	return $uniqueid;
}





public function setAndGetUniqueNumberForCustomField(){
	$uniqueid = '';
	
	$this->db->order_by('rand()');
	$this->db->limit(1);
	$record = $this->query_model->getByTable('tbl_form_unique_ids');
	//echo '<pre>record'; print_r($record); die;
	if(!empty($record)){
		if(!empty($record[0]->unique_id)){
			$uniqueid = $record[0]->unique_id;
		}
		
	}
	
	return $uniqueid;
}



public function generatingUniqueIds(){
	
	
	$this->db->select('*');
	$this->db->where('flag',0);
	$this->db->from('tbl_form_unique_ids');
	$count_all_results = $this->db->count_all_results();
	
	$total_results = 500;
	$all_records = 10000;
	if($count_all_results <= $total_results){
		
		$this->db->where('flag',1);
		$this->db->delete('tbl_form_unique_ids');
		
		$new_record_counts = $all_records - $count_all_results;
		
		for($i = 1; $i <= $new_record_counts; $i++){
			
			$uniqueId = md5(uniqid(rand(), true)).time().$i;
			
			$insertData = array();
			$insertData['unique_id'] = $uniqueId;
			$insertData['updated_at'] = date('Y-m-d H:i:s');
			$this->query_model->insertData('tbl_form_unique_ids', $insertData);
		}
		
		
	}
	
	$this->db->select('*');
	$usedUniqueIds = $this->query_model->getBySpecific('tbl_form_unique_ids','flag',1);
	if(!empty($usedUniqueIds)){
		foreach($usedUniqueIds as $value){
			//$current_time = date('Y-m-d H:i:s');
			
			$currentDate = date("Y-m-d H:i:s");
			$lastDate = date("Y-m-d H:i:s", strtotime("-10 minutes", strtotime($currentDate)));
			
			$updated_time = $value->updated_at;
			
			if($lastDate >= $updated_time){
				
				$updatedData=array('flag'=>2);
				$this->db->where('id',$value->id);
				$this->db->update('tbl_form_unique_ids',$updatedData);
			}
			
			
		}
	}
	
}

public function getCountryNameToIpAddress(){
	
	$client_ip_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	//$client_ip_address = '107.77.204.113'; //US
	//$client_ip_address = '78.129.156.190'; //fake IP UK country
	
	
	$result['client_ip_address'] = $client_ip_address;
	$result['client_country_name'] = '';
	if(!empty($client_ip_address)){
			
			$url = "http://www.geoplugin.net/json.gp?ip=".$client_ip_address;
				
			$request = curl_init($url); // initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			
			curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

			$response = (string)curl_exec($request); // execute curl post and store results in $response
			$error_msg = curl_error($request);
			curl_close($request); // close curl object
			
			if(!empty($response)){
				
				$data = json_decode($response, true);
			
				if(isset($data['geoplugin_countryName']) && !empty($data['geoplugin_countryName'])){
					$result['client_country_name'] = $data['geoplugin_countryName'];
				}
			}
			
		}
	return $result;
}


public function adminTextMessageTemplate($data, $form_type, $extraContentArr = null){
		
		$result = array();
		$result['admin_text_message_template'] = '';
		
		$this->db->select('send_admin_text_msg');
		$siteSetting = $this->query_model->getbySpecific('tblsite', 'id', 1);
		
		// set form all values in a format way
		$formData = $this->setFormDataValueInFormat($data);
		//echo "<pre>formData"; print_r($formData); die;
		if(!empty($siteSetting)){
			
			$siteSetting = $siteSetting[0];
				
				$msgTemplate =  $this->query_model->getbySpecific('tbl_text_msgs_templates', 'form_type', $form_type);
				
				
				if(!empty($msgTemplate) && $siteSetting->send_admin_text_msg == 1){
					
					// ADMIN MSG TEMPLATE
					
					$admin_text_message = $this->query_model->replaceAutoResponderVaribles($msgTemplate[0]->admin_msg, $formData, $extraContentArr);
					
					if(isset($admin_text_message) && !empty($admin_text_message)){
						$result['admin_text_message_template'] = $admin_text_message;
					}
					
					
					
				}
			
		}
		return $result;
}

public function hunneyPotOnlinedojoSignup($data){
	
	$error_text = "";
	 $is_error = 0;
	 $is_country_error = 0;
	 $is_spamcheck_error = 0;
	 
	 if(isset($data['form_email_2'])){
			$data['email'] = $data['form_email_2'];
		}else{
			$data['email'] = $data['email'];
		} 
		
		if(isset($data['email']) && (empty($data['email']) || !preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/",$data['email']))) { 
			$error_text = $error_text.' 1'; 
			$is_error = 1;
		}
		
		
		if(isset($data['firstname']) && !preg_match("/^[a-zA-Z ']+$/",$data['firstname'])) { 
			$is_error = 1;
				$error_text = $error_text.' 2';
		}
		if (isset($data['firstname']) && (empty($_POST['firstname']) || strpos($data['firstname'], 'www') !== false || strpos($data['firstname'], '.com') !== false)) {
			
			$is_error = 1;
			$error_text = $error_text.' 3';
		} 
		
		
		if(isset($data['lastname']) && !preg_match("/^[a-zA-Z ']+$/",$data['lastname'])) { 
			$is_error = 1;
				$error_text = $error_text.' 4';
		}
		if (isset($data['lastname']) && (empty($data['lastname']) || strpos($data['lastname'], 'www') !== false || strpos($data['lastname'], '.com') !== false)) {
			
			$is_error = 1;
			$error_text = $error_text.' 5';
		}
		
		if (!isset($data['password']) || (empty($data['password']))) {
			
			$is_error = 1;
			$error_text = $error_text.' 8';
		}
		
		

		 $formData = $this->setFormDataValueInFormat($_POST);
			
			// hunney pot code for check country by ip address
			
			$is_paid_form = 0;
			
			if($is_paid_form == 0 && $is_error == 0){
				
				$this->db->select('allow_countries');
				$allow_countries = $this->query_model->getbyTable("tblsite");
				if($allow_countries[0]->allow_countries == 1){
					
					$ipAddress = $this->query_model->getCountryNameToIpAddress();
					$ipAddressCountry = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
					
					if(!empty($ipAddressCountry)){
						
						$this->db->where('status',1);
						$countries = $this->query_model->getbyTable("tbl_countries");
						$countryArr = array();
						if(!empty($countries)){
							foreach($countries as $country){
								$countryArr[$country->id] = $country->country_name;
							}
						}
						
						
						if(!empty($countryArr)){
							if(in_array($ipAddressCountry,$countryArr)){
								// write some code here
							}else{
								 $error_text = $error_text.' 6'; 
								 $is_error = 1;
								 $is_country_error = 1;
							}
						}
					}
					
					
					if($is_country_error == 1){
						
						$insertDataArr['name'] = isset($_POST['firstname']) ? $_POST['firstname'].' '.$_POST['lastname'] : '';
						$insertDataArr['email'] = isset($formData['email']) ? $formData['email'] : '';
						$insertDataArr['phone'] = isset($formData['phone']) ? $formData['phone'] : '';
						$insertDataArr['program'] = isset($formData['program']) ? $formData['program'] : '';
						$insertDataArr['school'] = isset($formData['location']) ? $formData['location'] : '';
						$insertDataArr['trial_name'] = isset($formData['trial_name']) ? $formData['trial_name'] : '';
						$insertDataArr['page_url'] = isset($_POST['page_url']) ? $_POST['page_url'] : '';
						$insertDataArr['ip_address'] = isset($ipAddress['client_ip_address']) ? $ipAddress['client_ip_address'] : '';
						$insertDataArr['country_name'] = isset($ipAddress['client_country_name']) ? $ipAddress['client_country_name'] : '';
						$insertDataArr['created_at'] = date('Y-m-d H:i:s');
						
						$this->query_model->insertData("tbl_sp_leads", $insertDataArr);
						
					}
					
				}
			}
			
			
				
		 
		if($is_error == 1){
			
			$hunneypot_error_msg = array('hunneypot_error_msg' => $error_text);
			
			$this->session->set_userdata($hunneypot_error_msg);
			
			redirect(@base_url().'site/thank_you');
		}
		
		
}



public function getUniqueNumberForCustomField(){
	$uniqueid = '';
	
	$this->db->order_by('rand()');
	$this->db->limit(1);
	$this->db->where('signup_appiled',0);
	$record = $this->query_model->getByTable('tbl_form_unique_ids');
	
	if(!empty($record)){
		if(!empty($record[0]->unique_id)){
			$uniqueid = $record[0]->unique_id;
		}
		
	}
	
	return $uniqueid;
}

public function copyImageFromUrl($url = '', $img_path = ''){
	
	if(!empty($url) && !empty($img_path)){
		
		// Save image
		$ch = curl_init($url);
		$fp = fopen($img_path, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		
	}
	
}

public function reconstruct_url($url){
    
    $domain_name= 'http://'.$_SERVER['HTTP_HOST'];
    $newurl = $domain_name.$url;
    $url_parts = parse_url($newurl);
    
    if(isset($url_parts['query']) && !empty($url_parts['query'])){
       // $constructed_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'];
        $constructed_url = isset($url_parts['path']) ? $url_parts['path'] : '';
    }else{
        $constructed_url = $url;
    }
     
    return $constructed_url;
}

public function getProgramCategoryForNavigation($args){
            return $this->db->query("select * from tblcategory where cat_type = '".$args."'  AND `published` = 1 AND  `hide_from_navigation` = 0  ORDER BY pos ASC")->result();
	}
	
public function is_switch_to_crm_applied(){
	
	$result = 0;
	
	$this->db->select(array('switch_to_crm','dojo_crm_url'));
	$site_setting = $this->query_model->getByTable('tblsite');
	
	if($site_setting[0]->switch_to_crm == 1 && !empty($site_setting[0]->dojo_crm_url)){
		$result = 1;
	}
	
	return $result;
}


public function customCurlRequest($requestData){
	
	if(!empty($requestData)){
		
		$this->db->select('dojo_crm_url');
		$site_setting = $this->query_model->getByTable('tblsite');
		
		$action_url = isset($requestData['curl_url']) ? $requestData['curl_url'] : '';
		
		$url = $site_setting[0]->dojo_crm_url.'/'.$action_url;
	
		if(!empty($url)){
			if(isset($requestData['curl_url'])){
				unset($requestData['curl_url']);
			}
			
			$query = "";
			foreach( $requestData as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
			$query = rtrim($query, '& ');
			
			$api_url = $url.'?' . $query;
			//echo '<pre>api_url'; print_r($api_url); die;
			$ch = curl_init();
			$request = curl_init($api_url); // initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			//curl_setopt($request, CURLOPT_POSTFIELDS, $requestData); // use HTTP POST to send form data
			curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
			
			$response = (string)curl_exec($request); // execute curl post and store results in $response
			$error_msg = curl_error($request);
			curl_close($request); // close curl object
			
			//echo '<prE>error_msg=>'; print_r($error_msg); 
			//echo '<pre>response'; print_r($response); die;
			if(!empty($response)){
				
			}
		}
	}
	
	
	
}
	
	
	public function getCurrentDateTimeZone(){
		
		$this->db->select('timezone');
		$twilioChatApi = $this->query_model->getbySpecific('tbl_twilio_chat_api','id',1);
		
		$timezone = !empty($twilioChatApi[0]->timezone) ? $twilioChatApi[0]->timezone : 'America/New_York';
		
		return $timezone;
	}
	
	public function getTimeAgo($time, $day_format = ''){
		
		date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
		
		$result = 0;
			if(!empty($day_format)){
				
				$date = date('d/m/Y', strtotime($time));

				if($date == date('d/m/Y')) {
				  $date = 'Today';
				} 
				else if($date == date('d/m/Y',time() - (24 * 60 * 60))) {
				  $date = 'Yesterday';
				}else{
					$result = 1;
				}
				
				if($result == 0){
					return $date;
				}
			}else{
				$result = 1;
			}
			
			if($result == 1){
				
				$post_time = strtotime($time);
							$time = time() - $post_time; // to get the time since that moment
							$time = ($time<1)? 1 : $time;
							$tokens = array (
								31536000 => 'year',
								2592000 => 'month',
								604800 => 'week',
								86400 => 'day',
								3600 => 'hour',
								60 => 'minute',
								1 => 'second'
							);
						
				foreach ($tokens as $unit => $text) {
					if ($time < $unit) continue;
					$numberOfUnits = floor($time / $unit);
					return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
					break;
					 
				}
			}
				
	}
	
	
	public function sendMsgTwilioChatApi($msgData, $first_msg_type = ''){
		
		$twilio_message_id = "";
		
		$twilioChatApi = $this->query_model->getbySpecific('tbl_twilio_chat_api','id',1);
		
		if(!empty($twilioChatApi) && $twilioChatApi[0]->type == 1){
			
			if(!empty($twilioChatApi[0]->sid) && !empty($twilioChatApi[0]->token) ){
				
				if(!empty($msgData)){
					
					$phone = (isset($msgData['phone']) && !empty($msgData['phone'])) ? $msgData['phone'] : '';
					$msg_type = (isset($msgData['msg_type']) && !empty($msgData['msg_type'])) ? $msgData['msg_type'] : '';
					$message = (isset($msgData['message']) && !empty($msgData['message'])) ? $msgData['message'] : '';
					$twilio_user_id = (isset($msgData['twilio_user_id']) && !empty($msgData['twilio_user_id'])) ? $msgData['twilio_user_id'] : '';
					$twilio_sms_msg_id = (isset($msgData['twilio_sms_msg_id']) && !empty($msgData['twilio_sms_msg_id'])) ? $msgData['twilio_sms_msg_id'] : '';
					
					if(!empty($phone) && !empty($message) && !empty($twilio_user_id)){
						
						
						include_once './vendor/Twilio/autoload.php';
						include_once("./vendor/Twilio/Rest/Client.php");
						
						$sid    = $twilioChatApi[0]->sid; # test sid
						$token  = $twilioChatApi[0]->token;# test token
						
						$twilio = new Twilio\Rest\Client($sid, $token);
						
					
						
						$clientPhoneNumber = trim(str_replace(array("(",")"," ","-"),'',$phone));
						
						$clientPhoneNumber = $twilioChatApi[0]->country_phone_code.$clientPhoneNumber;
						
						try{
							
							$this->db->select(array('id','chat_conversation_sid'));
							$user_detail = $this->query_model->getBySpecific('twilio_sms_users','id',$twilio_user_id);
							
						  if(!empty($user_detail) && !empty($user_detail[0]->chat_conversation_sid) ){
							
							$message = $twilio->conversations->v1->conversations($user_detail[0]->chat_conversation_sid)
													 ->messages
													 ->create([
																  "author" => "Dojo Admin",
																  "body" => $message
															  ]
													 ); 
							$updateData = array();
							$updateData['chat_message_sid']  =  $message->sid;
							$this->query_model->update('twilio_sms_users', $twilio_user_id, $updateData);
							
							$smsUpdateData['chat_message_sid']  =  $message->sid;
							$this->query_model->update('twilio_sms_messenger', $twilio_sms_msg_id, $smsUpdateData);
							
							$twilio_message_id = 'msg_update=>'.$message->sid;
							//echo 'message old id=>'.$message->sid.'<br/>';
						  }else{
							 // echo '<pre>msgData'; print_r($msgData); die;
							 $service = $twilio->messaging->v1->services
															 ->create("dojo_name");

								if(isset($service->sid) && !empty($service->sid) ){
									
									//echo 'service id=>'.$service->sid.'<br/>'; die;
									
									$conversation = $twilio->conversations->v1->conversations
												  ->create([
															   "messagingServiceSid" => $service->sid,
															   "friendlyName" => "Dojo Conversation"
														   ]
												  );

									if(isset($conversation->sid) && !empty($conversation->sid)){
									
									//echo 'conversation id=>'.$conversation->sid.'<br/>';
											
											$participant = $twilio->conversations->v1->conversations($conversation->sid)
												 ->participants
												 ->create([
															  "messagingBindingAddress" => $clientPhoneNumber,
															  "messagingBindingProxyAddress" => $twilioChatApi[0]->from_phone_number
														  ]
												 );
												 
										//echo '<pre>participant'; print_r($participant);
										if(isset($participant->sid) && !empty($participant->sid)){
											
											
											//echo 'participant id=>'.$participant->sid.'<br/>';
											
											if($first_msg_type != "first_conversation"){
												
												$message = $twilio->conversations->v1->conversations($conversation->sid)
													 ->messages
													 ->create([
																  "author" => "Dojo Admin",
																  "body" => $message
															  ]
													 );
											}
											
											
											//echo '<pre>message new'; print_r($message);
											
											if(!empty($twilio_user_id)){
												
												$updateData = array();
												$updateData['chat_service_sid']  =  $service->sid;
												$updateData['chat_conversation_sid']  =  $conversation->sid;
												$updateData['chat_participant_sid']  =  $participant->sid;
												
												if($first_msg_type != "first_conversation"){
												$updateData['chat_message_sid']  =  $message->sid;
												}
												
												
												$this->query_model->update('twilio_sms_users', $twilio_user_id, $updateData);
												
												if($first_msg_type != "first_conversation"){
													$smsUpdateData['chat_message_sid']  =  $message->sid;
													$this->query_model->update('twilio_sms_messenger', $twilio_sms_msg_id, $smsUpdateData);
													
													$twilio_message_id = 'new msg=>'.$message->sid;
												}
												
											}
												
										}
									}
									
								}
						  }
							
						
						}catch (Exception $e) {
							//echo 'Caught exception: ',  $e->getMessage(), "\n"; die;
						}
					//die("==>");
					}
				}
				
			}
			
		}	
		
		return $twilio_message_id;
		
	}
	
	
	
	public function saveMsgFromTwilioChatApi($data, $leadData = array()){
		
		$formData = $this->setFormDataValueInFormat($data);
		
		if(!empty($formData)){
			
			date_default_timezone_set($this->query_model->getCurrentDateTimeZone());
			
			$twilioUserArr = array();
			$twilioUserArr['name'] = (isset($formData['name']) && !empty($formData['name'])) ? $formData['name'] : '';
			$twilioUserArr['phone'] =  (isset($formData['phone']) && !empty($formData['phone'])) ? $formData['phone'] : '';
			$twilioUserArr['lead_type'] = (isset($leadData['lead_type']) && !empty($leadData['lead_type'])) ? $leadData['lead_type'] : '';
			$twilioUserArr['lead_id'] = (isset($leadData['lead_id']) && !empty($leadData['lead_id'])) ? $leadData['lead_id'] : '';
			$twilioUserArr['last_updated_date'] = date('Y-m-d H:i:s');
			
			if(!empty($twilioUserArr['name']) && !empty($twilioUserArr['phone'])){
				
				$this->db->select(array('id','name','phone'));
				$twilio_user_detail = $this->query_model->getBySpecific('twilio_sms_users','phone',$twilioUserArr['phone']);
				
				if(empty($twilio_user_detail)){
					
					$this->query_model->insertData('twilio_sms_users',$twilioUserArr);
					$twilio_user_id = $this->db->insert_id();
					
					$user_type = "add";
					
					$this->db->select(array('id','name','phone'));
					$twilio_user_detail = $this->query_model->getBySpecific('twilio_sms_users','phone',$twilioUserArr['phone']);
				}else{
					$twilio_user_id = $twilio_user_detail[0]->id;
					$user_type = "edit"; 
				}
				
				if(!empty($twilio_user_id)){
					
					$twilio_sms_flows = $this->query_model->getBySpecific('tbl_twilio_sms_flows','msg_type',"template_1");
					
					if(!empty($twilio_sms_flows)){
						
						
						$template_start_time = $twilio_sms_flows[0]->start_time;
						$template_end_time = $twilio_sms_flows[0]->end_time;
						$current_time = date("H:i");
						$template_msg_status = "hold";
						if($current_time >= $template_start_time && $current_time <= $template_end_time){
							$template_msg_status = "sent";
						}
						
						$msg_template = $this->query_model->replaceAutoResponderVaribles($twilio_sms_flows[0]->msg_template, $formData, '');
						
						$insertSMSData = array();
						$insertSMSData['sender_by'] = 'admin';
						$insertSMSData['admin_id'] = 0;
						$insertSMSData['sms_users_id'] = $twilio_user_id;
						$insertSMSData['message'] = $twilio_sms_flows[0]->msg_template;
						$insertSMSData['template_msg_type'] = "template_1";
						$insertSMSData['template_msg_status'] = $template_msg_status;
						$insertSMSData['created'] = date('Y-m-d H:i:s');
						
						$this->query_model->insertData('twilio_sms_messenger',$insertSMSData);
						$twilio_sms_msg_id = $this->db->insert_id();
						
						$phone = (!empty($twilio_user_detail) && !empty($twilio_user_detail[0]->phone)) ? $twilio_user_detail[0]->phone : '';
						
						$msgData = array('twilio_user_id' => $twilio_user_id,'reciever_by'=>'student','phone'=>$phone,'msg_type'=>'admin_to_student','message'=>$msg_template,'twilio_sms_msg_id'=>$twilio_sms_msg_id);
							
						if($template_msg_status == "sent"){
							
							$this->query_model->sendMsgTwilioChatApi($msgData);
							//die('111');
						}else{
							//die('222');
							$this->query_model->sendMsgTwilioChatApi($msgData, 'first_conversation');
						}
						
					}
					
					
				}
			}
			
			
		}
	}
	
	
	
public function getAllTwilioUserConversations(){
	
		$twilioChatApi = $this->query_model->getbySpecific('tbl_twilio_chat_api','id',1);
	
		if(!empty($twilioChatApi) && $twilioChatApi[0]->type == 1){
			
			if(!empty($twilioChatApi[0]->sid) && !empty($twilioChatApi[0]->token) ){
				
						
						include_once './vendor/Twilio/autoload.php';
						include_once("./vendor/Twilio/Rest/Client.php");
						
						$sid    = $twilioChatApi[0]->sid; # test sid
						$token  = $twilioChatApi[0]->token;# test token
						
						$twilio = new Twilio\Rest\Client($sid, $token);
						
						$this->db->select(array('id','name','phone','chat_conversation_sid'));
						$twilio_users = $this->query_model->getBySpecific('twilio_sms_users','is_deleted',0);
						
						if(!empty($twilio_users)){
							$userMessages = array();
							foreach($twilio_users as $twilio_user){
								
								if(!empty($twilio_user->chat_conversation_sid)){
									
									$messages = $twilio->conversations->v1->conversations($twilio_user->chat_conversation_sid)
                                      ->messages
                                      ->read(20);
									
									if(!empty($messages)){
										
										foreach ($messages as $msg) {
											
											$this->db->select(array('id'));
											$msg_exit = $this->query_model->getBySpecific('twilio_sms_messenger','chat_message_sid',$msg->sid);
											
											if(empty($msg_exit)){
												
												$date_object = $msg->dateCreated;
												$date_created = $date_object->format('Y-m-d H:i:s');
												
												/*$userMessages[$twilio_user->chat_conversation_sid][$msg->sid]['msg'] = $msg->body;
												$userMessages[$twilio_user->chat_conversation_sid][$msg->sid]['created'] = $date_created;*/
												
												
											
												$insertSMSData = array();
												if($msg->author == "Dojo Admin"){
													$insertSMSData['sender_by'] = 'admin';
													$insertSMSData['admin_id'] = 0;
												}else{
													$insertSMSData['sender_by'] = 'student';
													$insertSMSData['admin_id'] = 0;
												}
												
												$insertSMSData['sms_users_id'] = $twilio_user->id;
												$insertSMSData['message'] = $msg->body;
												$insertSMSData['created'] = $date_created;
												$insertSMSData['chat_message_sid'] = $msg->sid;
												
												$this->query_model->insertData('twilio_sms_messenger',$insertSMSData);
												
												$updateData = array();
												if($msg->author != "Dojo Admin"){
													$updateData['is_msg_sent_by_phone'] = 1;
												}
												$updateData['chat_message_sid']  =  $msg->sid;
												$updateData['last_updated_date']  =  $date_created;
												$this->query_model->update('twilio_sms_users', $twilio_user->id, $updateData);
												
												
											}
											
											
											
										}
									}
								}
							}
						}
				
				}
			}
}
	
public function getSiteStatisticsNavMenu($report_type,$sort = ''){
	$navMenuArr = array('overview'=>'Overview','social_media'=>'Social media','top_reffers'=>'Top referrers','top_keywords'=>'Top keywords','top_pages'=>'Top pages','your_visitors'=>'Your visitors');
	
	$result = '';
	
	$sort = !empty($sort) ? '&sort='.$sort : '';
	foreach($navMenuArr as $key => $nav_menu){
		$active_report_type_cls = ($report_type == $key) ? 'active' : '';
		$result .= '<a class="nav-link '.$active_report_type_cls.' show" href="'.base_url().'admin/site_statistics/report?type='.$key.$sort.'">'.$nav_menu.'</a>';
	}
	
	//$result .= '<a class="nav-link" data-toggle="tab" href="#">More</a>';
	return $result;
}	


public function getCaptchaInputFields($current_form_type = ''){
	$html = '';
	$google_captcha_detail = $this->query_model->getByTable('tbl_google_captcha');
	
	if(!empty($google_captcha_detail) && $google_captcha_detail[0]->type == 1){
		$form_types =  !empty($google_captcha_detail[0]->form_types) ? unserialize($google_captcha_detail[0]->form_types) : ''; 
		
		if(!empty($current_form_type) && !empty($form_types) && in_array($current_form_type, $form_types)){
			$html .= '<input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">
				<input type="hidden" name="action" value="validate_captcha">';
		}
		
		$html .= '<input type="hidden" name="submit_form_type" value="'.$current_form_type.'">';
				
	}
				
	return $html;

}

public function getGoogleCaptchaScript($appliedForms){
	
	$script = '';
	$google_captcha_detail = $this->query_model->getByTable('tbl_google_captcha');
	
	if(!empty($google_captcha_detail) && $google_captcha_detail[0]->type == 1){
		$google_captcha_site_key = $google_captcha_detail[0]->google_captcha_site_key; 
		$form_types =  !empty($google_captcha_detail[0]->form_types) ? unserialize($google_captcha_detail[0]->form_types) : ''; 
		
		if(!empty($form_types)){
			
			$is_applied_captcha = 0;
			
			foreach($form_types as $key => $form_type){
				if(in_array($key,$appliedForms)){
					$is_applied_captcha = 1;
				}
			}
			
		if($is_applied_captcha == 1){
			//validate_captcha
				$script .= '<script src="https://www.google.com/recaptcha/api.js?render='.$google_captcha_site_key.'"></script>';
				$script .= "<script>
								var intervalID = window.setInterval(myCallback, 5000, 'Parameter 1', 'Parameter 2');
								function myCallback(a, b){
									console.log(a);
									console.log(b);
							 grecaptcha.ready(function() {
								
									grecaptcha.execute('".$google_captcha_site_key."', {action:'request_call_back'})
											  .then(function(token) {
										$('.g-recaptcha-response').val(token);
									});
								});
							}   
						</script>";
			}	
		}
	}
	
	return $script;
}


public function updateOrderForKabanLeads($order_id, $table_name, $form_tag, $post_data = array()){
	
	if(!empty($order_id) && !empty($table_name)){
		
		$leadTypes = array('tbl_dojocart_orders'=>'dojocart_lead','tblbirthdayparty'=>'birthday_party_lead','tblorders'=>'trial_offer_lead');
			
			$updateOrder = array();
			$updateOrder['kanban_status_id'] = 1;
			$this->db->where('id',$order_id);
			$this->db->update($table_name,$updateOrder);
			
			if(!empty($form_tag)){
				$insertData = array();
				$insertData['lead_type'] = isset($leadTypes[$table_name]) ? $leadTypes[$table_name] : '';
				$insertData['order_id'] = $order_id;
				$insertData['tag_type'] = 'form_tag';
				$insertData['tag'] = $form_tag;
				
				$this->db->insert('tbl_kanban_lead_tags',$insertData);
			}
			
			$program_name = $this->query_model->getProgramNameByFormPost($post_data);
			if(!empty($program_name)){
				
				$insertData = array();
				$insertData['lead_type'] = isset($leadTypes[$table_name]) ? $leadTypes[$table_name] : '';
				$insertData['order_id'] = $order_id;
				$insertData['tag_type'] = 'program_tag';
				$insertData['tag'] = $program_name;
				
				$this->db->insert('tbl_kanban_lead_tags',$insertData);
			}

		}
	}
	
public function getProgramNameByFormPost($data = array()){
		
		$program_name = '';
	
		if(isset($data['program']) && !empty($data['program'])){
			$program_detail = $this->query_model->getbyId("tblprogram", $data['program']);
			if(!empty($program_detail)){
				$program_name = $program_detail[0]->program;
				
			}
			
		}elseif(isset($data['program_id']) && !empty($data['program_id'])){
			$program_detail = $this->query_model->getbyId("tblprogram", $data['program_id']);
			
			if(!empty($program_detail)){
				$program_name = $program_detail[0]->program;
				
			}
			
		}elseif(isset($data['program_name']) && !empty($data['program_name'])){
			$program_name = $data['program_name'];
		}
		
		return $program_name;
}
	

public function getKanbanLeadTypeToOrderType($lead_type){
	$new_lead_type = '';
	if(!empty($lead_type)){
		
		if($lead_type == "email_opt_in" || $lead_type == "free_trial" || $lead_type == "paid_trial" || $lead_type == "upsell_trial"){
			$new_lead_type = 'trial_offer_lead';
			
		}elseif($lead_type == "birthday_parties" ){
			$new_lead_type = 'birthday_party_lead';
		}/*elseif($lead_type == "contact_us" ){
			$new_lead_type = 'contactus_lead';
		}*/elseif($lead_type == "dojocart" ){
			$new_lead_type = 'dojocart_lead';
		}
	}
	return $new_lead_type;
}

public function getOrderTagsByOrderId($lead_id,$lead_type,$tag_type = ''){
	
	$tagsArr = array();
	if(!empty($lead_id) && !empty($lead_type)){
		
		$this->db->select(array('id','tag'));
		if(!empty($tag_type)){
			$this->db->where('tag_type',$tag_type);
		}
		$this->db->where('order_id',$lead_id);
		$tags = $this->query_model->getBySpecific('tbl_kanban_lead_tags','lead_type',$lead_type);
		
		if(!empty($tags)){
			foreach($tags as $tag){
				$tagsArr[$tag->id] = $tag->tag;
			}
		}
	}
	
	return $tagsArr;
}

public function getKanbanLeadStatusById($kanban_status_id){
	
	if(!empty($kanban_status_id)){
		
		$kanban_status =  $this->query_model->getBySpecific('tbl_kanban_lead_status','id',$kanban_status_id);
		
		$kanban_status = !empty($kanban_status) ? $kanban_status[0] : array();
		return $kanban_status;
	}
}

public function getKanbanLeadComments($lead_id,$lead_type){
	
	if(!empty($lead_id) && !empty($lead_type)){
		
		$this->db->order_by('id','desc');
		$this->db->select(array('comment','id','created'));
		$this->db->where('lead_id',$lead_id);
		$comment_results =  $this->query_model->getBySpecific('tbl_kanban_lead_comments','lead_type',$lead_type);
		
		$comments = array();
		if(!empty($comment_results)){
			foreach($comment_results as $comment){
				$comments[$comment->id]['comment'] = $comment->comment;
				$comments[$comment->id]['created'] = $this->query_model->getTimeAgo($comment->created);
				$comments[$comment->id]['created_date'] = date('M d, Y  H:i:s', strtotime($comment->created));
			}
		}
		return $comments;
	}
}

public function getKanbanOrderSortNumber($kanban_status_id,$lead_type,$lead_id){
	
	$this->db->where('lead_type',$lead_type);
	$this->db->where('lead_id',$lead_id);
	$kanban_lead_sort_numbers = $this->query_model->getBySpecific('tbl_kanban_lead_sort_numbers','kanban_status_id',$kanban_status_id);
	
	$sort_number = !empty($kanban_lead_sort_numbers) ? $kanban_lead_sort_numbers[0]->sort_number : 0;
	
	return $sort_number;
}

public function createAndGetKanbanOrderSortNumber($kanban_status_id,$lead_type,$lead_id){
	
	if(!empty($kanban_status_id) && !empty($lead_type) && !empty($lead_id)){
		$this->db->select(array('sort_number'));
		$this->db->order_by('sort_number','asc');
		$this->db->limit(1);
		$last_sort_numbers = $this->query_model->getBySpecific('tbl_kanban_lead_sort_numbers','kanban_status_id',$kanban_status_id);
		
		
		$new_sort_number = !empty($last_sort_numbers) ? $last_sort_numbers[0]->sort_number - 1 : 999;
		$insertData = array();
		$insertData['kanban_status_id'] = $kanban_status_id;
		$insertData['lead_type'] = $lead_type;
		$insertData['lead_id'] = $lead_id;
		$insertData['sort_number'] = $new_sort_number;
		
		$this->db->insert('tbl_kanban_lead_sort_numbers',$insertData);
		
		return $new_sort_number;
	}
	
}

}
