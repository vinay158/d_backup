<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onlinedojo_video_model extends CI_Model{	
	var $table = 'tblsite';	
	


function addVideo(){
	
	$video_title = $_POST['video_title'];
	$video_type = $_POST['video_type'];
	$youtube_video = $_POST['youtube_video'];
	$vimeo_video = $_POST['vimeo_video'];
	$remote_video = $_POST['remote_video'];
	$local_video_mp4 = isset($_POST['local_video_mp4']) ? $_POST['local_video_mp4'] : '';
	$local_video_webm = isset($_POST['local_video_webm']) ? $_POST['local_video_webm'] : '';
	$local_video_mov = isset($_POST['local_video_mov']) ? $_POST['local_video_mov'] : '';
	$local_video_mkv = isset($_POST['local_video_mkv']) ? $_POST['local_video_mkv'] : '';
	$video_format = isset($_POST['video_format']) ? $_POST['video_format'] : '';
	//$image = $_FILES['userfile']['name'];
	$slide_text = $_POST['slide_text'];
	$embed_video_text = isset($_POST['embed_video_text']) ? $_POST['embed_video_text'] : '';
	if(!empty($embed_video_text)){
		if (strpos($embed_video_text, 'iframe') !== false) {
			$embed_video_text = preg_replace('/(<iframe\b[^><]*)>/i', '$1 id="videoPlayer">', $embed_video_text);
		}
	}
	
	
	
	
	$video_id = '';
	$videoimg = '';
	if($video_type == 'youtube_video'){
		$video_url = $_POST['youtube_video'];
		if(!empty($video_url)){
		 preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
		 
		  $video_id = isset($matches[1]) ? trim($matches[1]) : '';
		  
		  $video_img = "http://i.ytimg.com/vi/".$video_id."/0.jpg";
		 // $video_img = $youtube_src;
		}
		 
	 }else if($video_type == 'vimeo_video'){
		$viemo_video_url = $_POST['vimeo_video'];
				 preg_match("/(http?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $viemo_video_url, $matches);
		 
		 		$video_id = isset($matches[5]) ? trim($matches[5]) : '';
		  		/*$url="http://vimeo.com/api/v2/video/".$video_id.".php";						
				$data=file_get_contents($url);						
				$data=unserialize($data);
				
				$video_img = $data[0]['thumbnail_large']; */
				
				$img_src=$this->query_model->getViemoVideoImage($video_id);
								//getThumbnailImage($feat_box->video_id);
								
				$video_img = $this->query_model->changeVideoImgPathHttp($img_src);
				//$video_img = $this->query_model->getViemoVideoImage($video_id);
				
				if (strpos($video_img, 'video_album_cover') !== false) {
					
				}else{
					$img_src_data = explode('_',$video_img);
						
					$img_1 = isset($img_src_data[0]) ? $img_src_data[0] : '';
					$extension = pathinfo($video_img, PATHINFO_EXTENSION);
					
					$video_img = $img_1.'_360x220.'.$extension;
				}
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
	
	
	$video_img = isset($_POST['last-video_img']) ? $_POST['last-video_img'] : '';
	
	if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
		$_FILES['userfile']['name'] = 'online_'.time().$_FILES['userfile']['name'];
				
				$this->load->model('upload_model');
			$path = "upload/slider_video/";
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
			
			if($width >= 360 && $height <= 220){
				$config['width'] = $width;
				$config['height'] =220;
			} elseif($height >= 220 && $width <= 360){
				$config['width'] = 360;
				$config['height'] = $height;
			}else{
				$config['height'] =220;
				$config['width'] = 360;
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
				$b=$path.$filename;
			}
			
			$original_image = $a;
			$img_name = str_replace('upload/slider_video/','',$a);
			$photo_thumb = 'upload/slider_video/thumb/'.$img_name;
			$main_image = 'upload/slider_video/'.$img_name;
			$main_image_name = $img_name;
			
			$imageType = str_replace('image/','',$imagedetails['mime']);
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/slider_video/thumb/'.$img_name, 360, 220);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/slider_video/thumb/'.$img_name, 360, 220);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/slider_video/thumb/'.$img_name, 360, 220);
			}
	
		
			}
		}
			
		
		
		
		
	$data = array("video_title" => $video_title, "slide_text" => $slide_text, 'video_type'=>$video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'remote_video'=>$remote_video,'video_id'=>$video_id,'videoimage'=>$videoimage,'video_img'=>$main_image_name,'local_video_mp4'=>$local_video_mp4,'local_video_webm'=>$local_video_webm,'embed_video_text'=>$embed_video_text,'local_video_mov'=>$local_video_mov,'local_video_mkv'=>$local_video_mkv,'video_format'=>$video_format);
	
	if($this->query_model->insertData("tbl_onlinedojo_videos" , $data)):
			redirect("admin/onlinedojo_videos");
		endif;
	}

function updateVideo(){
	
	$video_title = $_POST['video_title'];
	$video_type = $_POST['video_type'];
	$youtube_video = $_POST['youtube_video'];
	$vimeo_video = $_POST['vimeo_video'];
	$remote_video = $_POST['remote_video'];
	$local_video_mp4 = isset($_POST['local_video_mp4']) ? $_POST['local_video_mp4'] : '';
	$local_video_webm = isset($_POST['local_video_webm']) ? $_POST['local_video_webm'] : '';
	$local_video_mov = isset($_POST['local_video_mov']) ? $_POST['local_video_mov'] : '';
	$local_video_mkv = isset($_POST['local_video_mkv']) ? $_POST['local_video_mkv'] : '';
	$video_format = isset($_POST['video_format']) ? $_POST['video_format'] : '';
	
	//$image = $_FILES['userfile']['name'];
	$slide_text = $_POST['slide_text'];
	$embed_video_text = isset($_POST['embed_video_text']) ? $_POST['embed_video_text'] : '';
	if(!empty($embed_video_text)){
		if (strpos($embed_video_text, 'iframe') !== false) {
			$embed_video_text = preg_replace('/(<iframe\b[^><]*)>/i', '$1 id="videoPlayer">', $embed_video_text);
		}
	}
	
	//echo $embed_video_text; die;
	
	$video_id = '';
	$videoimg = '';
	if($video_type == 'youtube_video'){
		$video_url = $_POST['youtube_video'];
		//echo $video_url; die;
		if(!empty($video_url)){
		 preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches);
		 
		  $video_id = isset($matches[1]) ? trim($matches[1]) : '';
		  
		  $video_img = "http://i.ytimg.com/vi/".$video_id."/0.jpg";
		 // $video_img = $youtube_src;
		}
		 
	 }else if($video_type == 'vimeo_video'){
		$viemo_video_url = $_POST['vimeo_video'];
		
				 preg_match("/(http?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $viemo_video_url, $matches);
		 
		 		
				$video_id = isset($matches[5]) ? trim($matches[5]) : '';
		  		/*$url="http://vimeo.com/api/v2/video/".$video_id.".php";						
				$data=file_get_contents($url);						
				$data=unserialize($data);
				
				$video_img = $data[0]['thumbnail_large']; */
				
				$img_src=$this->query_model->getViemoVideoImage($video_id);
								//getThumbnailImage($feat_box->video_id);
								
								$video_img = $this->query_model->changeVideoImgPathHttp($img_src);
				//$video_img = $this->query_model->getViemoVideoImage($video_id);
				
				if (strpos($video_img, 'video_album_cover') !== false) {
					
				}else{
					$img_src_data = explode('_',$video_img);
						
					$img_1 = isset($img_src_data[0]) ? $img_src_data[0] : '';
					$extension = pathinfo($video_img, PATHINFO_EXTENSION);
					
					$video_img = $img_1.'_360x220.'.$extension;
				}
				
		 		
	 } 
	// echo $video_id; die;
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
	
	
	$main_image_name = isset($_POST['last-video_img']) ? $_POST['last-video_img'] : '';
	
	if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
		$_FILES['userfile']['name'] = 'online_'.time().$_FILES['userfile']['name'];
				
				$this->load->model('upload_model');
			$path = "upload/slider_video/";
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
			
			if($width >= 340 && $height <= 255){
				$config['width'] = $width;
				$config['height'] =255;
			} elseif($height >= 255 && $width <= 340){
				$config['width'] = 340;
				$config['height'] = $height;
			}else{
				$config['height'] =255;
				$config['width'] = 340;
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
				$b=$path.$filename;
			}
			
			$original_image = $a;
			$img_name = str_replace('upload/slider_video/','',$a);
			$photo_thumb = 'upload/slider_video/thumb/'.$img_name;
			$main_image = 'upload/slider_video/'.$img_name;
			$main_image_name = $img_name;
			
			$imageType = str_replace('image/','',$imagedetails['mime']);
			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/slider_video/thumb/'.$img_name, 360, 220);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/slider_video/thumb/'.$img_name, 360, 220);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/slider_video/thumb/'.$img_name, 360, 220);
			}
	
		
			}
		}
			
		
	$video_img_type =  (isset($_POST['video_img_type']) && !empty($_POST['video_img_type'])) ? $_POST['video_img_type'] : 'automatically';
	
	$custom_video_thumbnail = isset($_POST['old_custom_thumbnail_img']) ? $_POST['old_custom_thumbnail_img'] : '';
		if(isset($_FILES['custom_video_thumbnail']['name']) && !empty($_FILES['custom_video_thumbnail']['name'])){
			$_FILES['custom_video_thumbnail']['name'] = time().$_FILES['custom_video_thumbnail']['name'];
			$this->load->library('image_lib');

			$config['upload_path'] = 'upload/class_schedule/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('custom_video_thumbnail')){
				$image_data = $this->upload->data();
				$custom_video_thumbnail = $image_data['file_name'];
			}

			$resize_config['source_image'] = 'upload/class_schedule/'.$custom_video_thumbnail;
			$get_size = getimagesize($resize_config['source_image']);

			$image_info = array(
				'width' => $get_size[0],
				'height' => $get_size[1]
			);

			$resize_config['create_thumb'] = FALSE;

			$resize_config['new_image'] = 'upload/class_schedule/thumb/'.$custom_video_thumbnail;
			
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
			$this->query_model->tinyImageCampressAndResize('upload/class_schedule/'.$custom_video_thumbnail);
			
			$this->query_model->tinyImageCampressAndResize('upload/class_schedule/thumb/'.$custom_video_thumbnail);
									
		}
		
		
	$data = array("video_title" => $video_title, "slide_text" => $slide_text, 'video_type'=>$video_type,'youtube_video'=>$youtube_video,'vimeo_video'=>$vimeo_video,'remote_video'=>$remote_video,'video_id'=>$video_id,'videoimage'=>$videoimage,'video_img'=>$main_image_name,'local_video_mp4'=>$local_video_mp4,'local_video_webm'=>$local_video_webm,'embed_video_text'=>$embed_video_text,'local_video_mov'=>$local_video_mov,'local_video_mkv'=>$local_video_mkv,'video_format'=>$video_format,'video_img_type'=>$video_img_type,'custom_video_thumbnail'=>$custom_video_thumbnail,);
	
	if($this->query_model->update("tbl_onlinedojo_videos", $this->uri->segment(4) , $data)):
			redirect("admin/onlinedojo_videos");
		endif;
	}
	
	
	
}