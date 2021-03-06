<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album_model extends CI_Model{
	

	var $table = 'tblgalleryname';
	
		
	
	function uploadIt(){
	$desc = $_POST['description'];
	$album =  $_POST['upload_album'];
	$image = $_FILES['userfile']['name'];	
			
		if(!empty($image)){
				$this->load->model('upload_model');
				$path = "upload/";
				if($a = $this->upload_model->upload_image($path)){			
				$data = array(
					'album' => $album,
					'link' => $a,
					'desc' => $desc,
					'type' => 1
				);
				if($this->query_model->insertData("tblmedia",$data)):
					//redirect("admin/gallery/edit/".$album);
					return true;
					
				endif;
				}
				else echo "UNABLE TO UPLOAD";
		}
		
	}
	
	function saveEmbed(){
		
		
		//echo '<pre>'; print_r($_POST); die;
		$desc = $_POST['description'];
		$album =  isset($_POST['upload_album']) ? $_POST['upload_album'] : 0;
		$category =  isset($_POST['category']) ? $_POST['category'] : 0;
		$published =  isset($_POST['published']) ? $_POST['published'] : 0;
		$video_id= $_POST['video_id'];
		$video_type= $_POST['video_type'];
		$embed =  htmlentities($_POST['embed']);
		
		$cover_image_blank_update = array('is_cover_image' => 0);
		
		$this->query_model->updateData('tblmedia','category',$category,$cover_image_blank_update);
		
		//$cover_page_url = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
		$cover_page_url='';
		if($video_type=='youtube'){
			$cover_page_url="http://img.youtube.com/vi/".$video_id."/0.jpg";	
		}
		if($video_type=='vimeo'){
			$cover_page_url = $this->query_model->getViemoVideoImage($video_id);
		}
		
		$cover_img = array('cover'=> $cover_page_url);
		$this->query_model->updateData('tblcategory','cat_id',$category,$cover_img);
		
		$data = array(
		'category' => $category,
		'album' => $album,
		'link' => $embed,
		'desc' => $desc,
		'video_id'=>$video_id,
		'video_type'=>$video_type,	
		'published'=>$published,	
		'type' => 2,
		'is_cover_image' => 1
		);
		//echo '<pre>'; print_r($data); die;
		if($this->query_model->insertData("tblmedia",$data)):
			redirect("admin/albums/view/".$category);
			return true;
		endif;
		}
		
		
		
	function updateEmbed(){
		
		
		//echo '<pre>updateEmbed'; print_r($_POST); die;
		$desc = $_POST['description'];
		$album =  isset($_POST['upload_album']) ? $_POST['upload_album'] : 0;
		$category =  isset($_POST['category']) ? $_POST['category'] : 0;
		$published =  isset($_POST['published']) ? $_POST['published'] : 0;
		$video_id= $_POST['video_id'];
		$video_type= $_POST['video_type'];
		$embed =  htmlentities($_POST['embed']);
		$id =  htmlentities($_POST['id']);
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
		
		$data = array(
		'category' => $category,
		'album' => $album,
		'link' => $embed,
		'desc' => $desc,
		'video_id'=>$video_id,
		'video_type'=>$video_type,	
		'published'=>$published,	
		'type' => 2,
		'is_cover_image' => 1,
		'video_img_type'=>$video_img_type,	
		'custom_video_thumbnail'=>$custom_video_thumbnail,	
		);
		//echo '<pre>'; print_r($data); die;
		if($this->query_model->update("tblmedia", $id, $data)):
			redirect("admin/albums/view/".$category);
			return true;
		endif;
		}
		
	
		
	}