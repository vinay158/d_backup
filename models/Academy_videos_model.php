<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Academy_videos_model extends CI_Model{
	
	var $table = 'tbl_academy_galleryname';
	
	function addAlbum(){
	
	$album = $_POST['title'];
	$category = $_POST['category'];
	
	$content = $_POST['text'];	
	$desc = htmlentities($content);
	$desc = substr($desc, 0, 140);
		
	$published = $_POST['published'];
	
	$week_academy_id = (isset($_POST['week_academy_id']) && !empty($_POST['week_academy_id'])) ? $_POST['week_academy_id'] : $this->uri->segment(5);
	
	$data = array("album" => $album, "category" => $category, "desc" => $desc, "published" => $published, "week_academy_id" => $week_academy_id);
	
	if($this->query_model->insertData($this->table, $data)):
		redirect("admin/academy_videos/view/".$category);
	endif;
	
	}
	
	function editAlbum(){
	//echo '<pre>'; print_r($_POST); die;
	$album = $_POST['title'];
	$category = $_POST['category'];
	
	$content = $_POST['text'];	
	$desc = htmlentities($content);
	$desc = substr($desc, 0, 140);
	//echo '<pre>'; print_r($_POST); die;
	$week_academy_id = (isset($_POST['week_academy_id']) && !empty($_POST['week_academy_id'])) ? $_POST['week_academy_id'] : $this->uri->segment(5);
	$published = $_POST['published'];
	$data = array("album" => $album, "category" => $category, "desc" => $desc, "published" => $published,'week_academy_id'=>$week_academy_id);
	if($this->query_model->update($this->table, $this->uri->segment(4), $data)):
	
	$updateIdArr = array('week_academy_id'=>$week_academy_id);
	$this->db->where('album', $this->uri->segment(4));
    $this->db->update('tbl_academy_media', $updateIdArr);
	
		redirect("admin/academy_videos/edit/".$this->uri->segment(4));
	endif;
	
	}	
	
	
	function ajaxEditAlbum($searcharray){
		$_POST = $searcharray;
	
		$album = $_POST['title'];
		$category = $_POST['category'];
		
		$content = $_POST['text'];	
		$desc = htmlentities($content);
		$desc = substr($desc, 0, 140);
		//echo '<pre>'; print_r($_POST); die;
		$week_academy_id = (isset($_POST['week_academy_id']) && !empty($_POST['week_academy_id'])) ? $_POST['week_academy_id'] : '';
		$album_id = (isset($_POST['id_of_album']) && !empty($_POST['id_of_album'])) ? $_POST['id_of_album'] : '';
		//$published = $_POST['published'];
		$data = array("album" => $album, "category" => $category, "desc" => $desc,'week_academy_id'=>$week_academy_id);
		
		if($this->query_model->update($this->table, $album_id, $data)):
		
			$updateIdArr = array('week_academy_id'=>$week_academy_id);
			$this->db->where('album', $album_id);
			$this->db->update('tbl_academy_media', $updateIdArr);
		
			//redirect("admin/academy_videos/edit/".$this->uri->segment(4));
		endif;
	
	}
	
	
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
				if($this->query_model->insertData("tbl_academy_media",$data)):
					//redirect("admin/academy_videos/edit/".$album);
					return true;
					
				endif;
				}
				else echo "UNABLE TO UPLOAD";
		}
		
	}
	
	function saveEmbed(){
		
		
		
		$desc = $_POST['description'];
		$album =  $_POST['upload_album'];
		$video_id= $_POST['video_id'];
		$video_type= $_POST['video_type'];
		$embed =  htmlentities($_POST['embed']);
		
		
		
		$cover_image_blank_update = array('is_cover_image' => 0);
		$this->query_model->updateData('tbl_academy_media','album',$album,$cover_image_blank_update);
		
		if($video_type == "youtube"){
			$cover_page_url = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
			$cover_img = array('cover'=> $cover_page_url);
		}elseif($video_type == "vimeo"){
			$cover_page_url=$this->query_model->getViemoVideoImage($video_id);
			$cover_img = array('cover'=> $cover_page_url);
		}
		//echo '<pre>cover_img'; print_r($cover_page_url); die;
		
		$this->query_model->updateData('tbl_academy_galleryname','id',$album,$cover_img);
		
		$this->db->select("week_academy_id");
		$albumDetail = $this->query_model->getbySpecific("tbl_academy_galleryname", "id", $album);
		$week_academy_id = !empty($albumDetail) ? $albumDetail[0]->week_academy_id : 0;
		
		$data = array(
		'album' => $album,
		'link' => $embed,
		'desc' => $desc,
		'video_id'=>$video_id,
		'video_type'=>$video_type,	
		'type' => 2,
		'is_cover_image' => 1,
		'week_academy_id' => $week_academy_id
		);
		
		
		if($this->query_model->insertData("tbl_academy_media",$data)): 
		
			//redirect("admin/academy_videos/edit/".$album);
			return true;
		endif;
		}
		
		
	function insertGalleryImage($img_data=array()){		
		$album=$a=$b=$type='';		
		$a=$img_data['img_path'];
		$b=$img_data['img_path_thumbnail'];
		$c=$img_data['img_path_thumbnail_2'];
		$album=$img_data['album'];
		$type=$img_data['type'];
		
		if(!empty($a)){							
				$data = array(
					'album' => $album,
					'link' => $a,
					'link_thumbnail' => $b,
					'link_thumbnail_2' => $c,									
					'type' => $type
				);
				
				if($this->query_model->insertData("tbl_academy_media",$data)):					
					return true;					
				endif;
				}
				else echo 0;
		}
		
	}