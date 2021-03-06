<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Featuredprogram_model extends CI_Model{
	
	var $table = 'tblprogram';
	
function updateProgram(){
	//	echo '<pre>'; print_r($_POST); die;
		$program_id = isset($_POST['program_id'])?$_POST['program_id']:'';
		$program_title = $_POST['program_title'];
		$program_description = $_POST['program_description'];
		
		$program_url = $_POST['program_url'];
		$program_category_url = $_POST['program_category_url'];
		$program_cat_id = isset($_POST['program_cat_id'])?$_POST['program_cat_id']:'';
		$custom_url_checkbox = (isset($_POST['custom_url_checkbox']) && !empty($_POST['custom_url_checkbox']))?$_POST['custom_url_checkbox']: 0;
		$custom_url = isset($_POST['custom_url'])?$_POST['custom_url']: '';
				
		$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
		$image = $_FILES['userfile']['name'];
		$summary = $_POST['summary'];
		$image_alt = $_POST['image_alt'];
		$program_url = $_POST['program_url'];
		
		$url = '';
		$target = '';
		
		if(isset($_POST['url'])){
			$url = $_POST['url'];
		}
		
		if(isset($_POST['target'])){
			$target = $_POST['target'];
		}
	

		if(!empty($image) && strlen($image)> 10){
			$this->load->model('upload_model');
			$path = "upload/featuredprograms/";
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
			
			if($width >= 370 && $height <= 543){
				$config['width'] = $width;
				$config['height'] =543;
			} elseif($height >= 543 && $width <= 370){
				$config['width'] = 370;
				$config['height'] = $height;
			}else{
				$config['height'] =543;
				$config['width'] = 370;
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
			
			//$original_image = base_url().$a;
			$original_image = $a;
			$img_name = str_replace('upload/featuredprograms/','',$a);
			$photo_thumb = 'upload/featuredprograms/thumb/'.$img_name;
			$main_image = 'upload/featuredprograms/'.$img_name;
			
			$imageType = str_replace('image/','',$imagedetails['mime']);
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/featuredprograms/thumb/'.$img_name, 370, 543);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/featuredprograms/thumb/'.$img_name, 370, 543);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/featuredprograms/thumb/'.$img_name, 370, 543);
			}
			
			
			$data = array("program_title" => $program_title, "program_description" => $program_description, "summary" => $summary, "photo_thumb" => $photo_thumb,"photo" => $main_image,  "image_alt" => $image_alt,'url' => $url, 'target'=>$target,'program_id'=>$program_id, 'program_url'=> $program_url,'program_cat_id'=> $program_cat_id,'program_category_url' => $program_category_url,'custom_url_checkbox'=>$custom_url_checkbox,'custom_url'=>$custom_url);
			if($this->query_model->update("tblfeaturedprogram", $this->uri->segment(4), $data)):
				redirect("admin/featuredprograms");
			endif;
		}
	}else{
		
			$data = array("program_title" => $program_title, "program_description" => $program_description, "summary" => $summary,  "image_alt" => $image_alt,'url' => $url, 'target'=>$target,'program_id'=>$program_id, 'program_url'=> $program_url,'program_cat_id'=> $program_cat_id,'program_category_url' => $program_category_url,'custom_url_checkbox'=>$custom_url_checkbox,'custom_url'=>$custom_url);
			if($this->query_model->update("tblfeaturedprogram", $this->uri->segment(4), $data)):
				redirect("admin/featuredprograms");
			endif;
	}
	
	}

	function addProgram(){
			//echo '<pre>'; print_r($_POST); die;
			$program_id = isset($_POST['program_id'])?$_POST['program_id']:'';
			//$program_name = $_POST['program_name'];
			$program_title = $_POST['program_title'];
			$program_description = $_POST['program_description'];
			$custom_url_checkbox = (isset($_POST['custom_url_checkbox']) && !empty($_POST['custom_url_checkbox']))?$_POST['custom_url_checkbox']: 0;
			$custom_url = isset($_POST['custom_url'])?$_POST['custom_url']: '';
			
			
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
			$image = $_FILES['userfile']['name'];
			$summary = $_POST['summary'];
			$p_type = 'program';
			$image_alt = $_POST['image_alt'];	
			$this->db->select_max('pos');
			$query = $this->db->get('tblfeaturedprogram');
			$row = $query->row();
			$pos = $row->pos + 1;
			$program_url = $_POST['program_url'];
			
			$program_category_url = $_POST['program_category_url'];
			$program_cat_id = isset($_POST['program_cat_id'])?$_POST['program_cat_id']:'';
			
			//echo $program_cat_url; die;
		
			if(!empty($image) && strlen($image)> 10){
				$this->load->model('upload_model');
				$path = "upload/featuredprograms/";
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
					$config['allowed_types'] = 'jpg|gif|png';
					$image_config['new_image'] = $dirpath.$filename;
					$image_config['quality'] = "100%";
					
					
					$imagedetails = getimagesize($_FILES['userfile']['tmp_name']);
			$width = $imagedetails[0];
			$height = $imagedetails[1];
			
			if($width >= 370 && $height <= 543){
				$config['width'] = $width;
				$config['height'] =543;
			} elseif($height >= 543 && $width <= 370){
				$config['width'] = 370;
				$config['height'] = $height;
			}else{
				$config['height'] =543;
				$config['width'] = 370;
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
			
			//$original_image = base_url().$a;
			$original_image = $a;
			$img_name = str_replace('upload/featuredprograms/','',$a);
			$photo_thumb = 'upload/featuredprograms/thumb/'.$img_name;
			$main_image = 'upload/featuredprograms/'.$img_name;
			
			$imageType = str_replace('image/','',$imagedetails['mime']);
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/featuredprograms/thumb/'.$img_name, 370, 543);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/featuredprograms/thumb/'.$img_name, 370, 543);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/featuredprograms/thumb/'.$img_name, 370, 543);
			}
			
				
				}
				
					$main_image = 'upload/featuredprograms/'.$image;
					$data = array("program_id" => $program_id, "program_title" => $program_title, "photo" => $main_image, "program_description" => $program_description,"summary" => $summary, "photo_thumb" => $photo_thumb, "pos" => $pos, "p_type" => $p_type, "image_alt" => $image_alt, 'program_url'=> $program_url,'program_cat_id'=> $program_cat_id,'program_category_url' => $program_category_url,'custom_url_checkbox'=>$custom_url_checkbox,'custom_url'=>$custom_url);
					if($this->query_model->insertData("tblfeaturedprogram", $data)):
						redirect("admin/featuredprograms");
					endif;
			} else {
					$program_image = $_POST['old_program_img'];
					$program_image_thumb = $_POST['old_program_img'];
					$data = array("program_id" => $program_id, "program_title" => $program_title, "photo" => $program_image, "program_description" => $program_description,"summary" => $summary, "photo_thumb" => $program_image_thumb, "pos" => $pos, "p_type" => $p_type, "image_alt" => $image_alt, 'program_url'=> $program_url,'program_cat_id'=> $program_cat_id,'program_category_url' => $program_category_url,'custom_url_checkbox'=>$custom_url_checkbox,'custom_url'=>$custom_url);
					if($this->query_model->insertData("tblfeaturedprogram", $data)):
						redirect("admin/featuredprograms");
					endif;
			}
			
			
			}	
	
	function addAdvert(){
		
		$this->load->helper(array('url'));
		
		$data['program_title'] = 0;
		$data['program_title'] = $_POST['title'];
		$data['url'] = $_POST['url'];
		$data['summary'] = $_POST['summary']; // vinay	11/12
		$data['program_description'] = $_POST['description'];  // vinay	11/12
		$data['p_type'] = 'advert';
		$data['target'] = $_POST['target']; 
		$data['photo'] = $_FILES['userfile']['name']; 
		$data['image_alt'] = $this->input->post('image_alt');
		$image = $_FILES['userfile']['name'];		
		
		$base_url = base_url();
		//echo '<pre>'; print_r($_FILES); die;
		$this->db->select_max('pos');
		$query = $this->db->get('tblfeaturedprogram');
		$row = $query->row(); 		
		$data['pos'] = $row->pos + 1;
		
		if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
			$this->load->library('image_lib');

			$config['upload_path'] = 'upload/featuredprograms/';
			$config['allowed_types'] = 'gif|jpg|png';

			//$this->photo_model->resizeImageToDimensions();

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('userfile')){
				$image_data = $this->upload->data();
				$data['photo'] = $image_data['file_name'];
			}

			$resize_config['source_image'] = 'upload/featuredprograms/'.$data['photo'];
			$get_size = getimagesize($resize_config['source_image']);

			$image_info = array(
				'width' => $get_size[0],
				'height' => $get_size[1]
			);

			$resize_config['create_thumb'] = FALSE;

			$resize_config['new_image'] = 'upload/featuredprograms/thumb/'.$data['photo'];

			if($image_info['width']  >= $image_info['height']){
				$new_height = 110;
				$new_width = round((110/$image_info['height'])*$image_info['width']);
			}else{
				$new_width = 215;
				$new_height = round((215/$image_info['width'])*$image_info['height']);
			}
			
			$resize_config['width'] = $new_width;
			$resize_config['height'] = $new_height;
			$this->image_lib->initialize($resize_config);
			$this->image_lib->resize();				
			
			$resize_config['source_image'] = $base_url.'upload/featuredprograms/thumb/'.$data['photo'];
			$resize_config['new_image'] = 'upload/featuredprograms/thumb/'.$data['photo'];
			
			//echo '<pre>'; print_r($resize_config); echo '</pre>';

			$this->load->library('image', $resize_config);
			
			$imgsize = getimagesize($resize_config['source_image']);
    		$width = $imgsize[0];
    		$height = $imgsize[1];
			
			//echo '<br>width: '.$width;
			//echo '<br>height: '.$height;
	
			$centreX = round($width / 2);
			$centreY = round($height / 2);
			
			//echo '<br>centreX: '.$centreX;
			//echo '<br>centreY: '.$centreY;
			
			$cropWidth  = 215;
			$cropHeight = 110;
			$cropWidthHalf  = round($cropWidth / 2); // could hard-code this but I'm keeping it flexible
			$cropHeightHalf = round($cropHeight / 2);
			
			$x1 = $centreX - $cropWidthHalf;
			$y1 = $centreY - $cropHeightHalf;
			
			$x2 = $centreX + $cropWidthHalf;
			$y2 = $centreY + $cropHeightHalf;
			
			
			//echo '<br>'.$x1.' - '.$y1;
			//echo '<br>'.$x2.' - '.$y2;
			//exit;
			
			$resize_image = $this->image->crop($x1, $y1, $x2, $y2);
			$this->image->save($resize_config['new_image']);

		}
		$data['photo'] = 'upload/featuredprograms/'.$data['photo'];
		$data['photo_thumb'] = 'upload/featuredprograms/'.$_FILES['userfile']['name']; 
		//echo '<pre>'; print_r($_FILES); die;
		$this->query_model->insertData('tblfeaturedprogram', $data);		
	}	
	
	function updateAdvert(){
		
		$this->load->helper(array('url'));
		
		$advert_id = $_POST['advert_id'];
		$data['program_title'] = $_POST['title'];
		$data['url'] = $_POST['url'];
		$data['summary'] = $_POST['description'];
				
		$image = $_FILES['userfile']['name'];		
		
		$base_url = base_url();		
		
		if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){

			$this->load->library('image_lib');

			$config['upload_path'] = 'upload/featuredprograms/';
			$config['allowed_types'] = 'gif|jpg|png';

			//$this->photo_model->resizeImageToDimensions();

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('userfile')){
				$image_data = $this->upload->data();
				$data['photo'] = $image_data['file_name'];
			}

			$resize_config['source_image'] = 'upload/featuredprograms/'.$data['photo'];
			$get_size = getimagesize($resize_config['source_image']);

			$image_info = array(
				'width' => $get_size[0],
				'height' => $get_size[1]
			);

			$resize_config['create_thumb'] = FALSE;

			$resize_config['new_image'] = 'upload/featuredprograms/thumb/'.$data['photo'];

			if($image_info['width']  >= $image_info['height']){
				$new_height = 110;
				$new_width = round((110/$image_info['height'])*$image_info['width']);
			}else{
				$new_width = 215;
				$new_height = round((215/$image_info['width'])*$image_info['height']);
			}
			
			$resize_config['width'] = $new_width;
			$resize_config['height'] = $new_height;
			$this->image_lib->initialize($resize_config);
			$this->image_lib->resize();				
			
			$resize_config['source_image'] = $base_url.'upload/featuredprograms/thumb/'.$data['photo'];
			$resize_config['new_image'] = 'upload/featuredprograms/thumb/'.$data['photo'];
			
			//echo '<pre>'; print_r($resize_config); echo '</pre>';

			$this->load->library('image', $resize_config);
			
			$imgsize = getimagesize($resize_config['source_image']);
    		$width = $imgsize[0];
    		$height = $imgsize[1];
			
			//echo '<br>width: '.$width;
			//echo '<br>height: '.$height;
	
			$centreX = round($width / 2);
			$centreY = round($height / 2);
			
			//echo '<br>centreX: '.$centreX;
			//echo '<br>centreY: '.$centreY;
			
			$cropWidth  = 215;
			$cropHeight = 110;
			$cropWidthHalf  = round($cropWidth / 2); // could hard-code this but I'm keeping it flexible
			$cropHeightHalf = round($cropHeight / 2);
			
			$x1 = $centreX - $cropWidthHalf;
			$y1 = $centreY - $cropHeightHalf;
			
			$x2 = $centreX + $cropWidthHalf;
			$y2 = $centreY + $cropHeightHalf;
			
			
			//echo '<br>'.$x1.' - '.$y1;
			//echo '<br>'.$x2.' - '.$y2;
			//exit;
			
			$resize_image = $this->image->crop($x1, $y1, $x2, $y2);
			$this->image->save($resize_config['new_image']);

		}
		
		$this->query_model->update('tblfeaturedprogram', $advert_id, $data);
	}
}