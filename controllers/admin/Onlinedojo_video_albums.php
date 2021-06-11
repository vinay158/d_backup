<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onlinedojo_video_albums extends CI_Controller {	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }		
		$this->load->model('onlinedojo_video_album_model');
		$this->load->library('UploadHandler');
	}

	public function index()
	{
		
		redirect('admin/onlinedojo_videos');
	}
	
	
	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tbl_onlinedojo_galleryname` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function sortgallery(){
		//echo "here";exit;
		//print_r($_POST);exit;
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
		$this->db->query("UPDATE `tbl_onlinedojo_media` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function add(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			$data['title'] = "Gallery";
			$data['cat'] = $this->query_model->getGalleryCategory("gallery");
			
			if(isset($_POST['update'])):
						$this->onlinedojo_video_album_model->addAlbum();
			endif;
			$this->load->view("admin/onlinedojo_video_album_add", $data);	
		}else{
			redirect('admin/login');
		}
	}
	
	public function edit(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{							
			if( $this->uri->segment(4) != NULL ){				
				if($this->uri->segment(5)!=NULL){
					 $data_set=$this->db->query("Select cat_name from `tblcategory` where cat_id='".$this->uri->segment(5)."'")->result();									 
					 $data=array();
					 $data['category']='';					 
					 if(is_array($data_set)){
					 	$data['category']=$data_set[0]->cat_name;
					 }
				}else{
					redirect("admin/onlinedojo_video_albums");
				}	 	
				
			$data['title'] = "Gallery";
			$data['link_type'] = "onlinedojo_video_albums";
			$this->db->where("category", $this->uri->segment(5));
			$data['albums'] = $this->query_model->getbyTable("tbl_onlinedojo_galleryname");
			$this->db->order_by('pos asc, id desc');
			$data['media'] = $this->query_model->getbySpecific("tbl_onlinedojo_media", "album", $this->uri->segment(4));
			$data['type']='';
			if(is_array($data['media']) && count($data['media'])>0) {
				$data['type']=$data['media'][0]->type;
			}
					
			$this->db->order_by("pos", "ASC");
			$this->db->select(array('cat_id','cat_name'));
			$data['cat'] = $this->query_model->getBySpecific('tblcategory','cat_type',"gallery");
			
			$data['details'] = $this->query_model->getbyID("tbl_onlinedojo_galleryname", $this->uri->segment(4));
			$data['album_id']=$this->uri->segment(4);			
			
			//echo '<pre>data'; print_r($data); die;
			if(isset($_POST['update'])):			
						//$this->onlinedojo_video_album_model->editAlbum();
			endif;			
				$this->load->view("admin/onlinedojo_video_album_edit",$data);			
			
			}else{
				redirect($this->index());
			}
		}else{
			redirect("admin/login");
		}
	}
	
	
	public function ajax_update_album_info(){
		
		parse_str($_POST['formData'], $searcharray);
	
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['action']) && $searcharray['action'] == "update_album_info"){
			
			$searcharray['text'] = isset($_POST['full_desc']) ? $_POST['full_desc'] : '';
			$searcharray['published'] = (isset($_POST['published']) && !empty($_POST['published'])) ? $_POST['published'] : 0;
			
			$this->onlinedojo_video_album_model->ajaxEditAlbum($searcharray);
			
			$result['res'] = 1;
		}
		
		echo json_encode($result); 	
	}
	
	
	
	/*public function view()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				$data['title'] = "Video Albums";
				$this->db->order_by("pos", "ASC");
				$data['cat'] = $this->query_model->getGalleryCategory("gallery");
				$data['link_type'] = "onlinedojo_video_albums";
				$this->db->order_by("pos", "ASC");
				$data['blogs'] = $this->query_model->getbySpecific("tbl_onlinedojo_galleryname", "category", $this->uri->segment(4));

				// Get Gallery/Video Page title from tbl_studentpagetitle
				$this->db->where('id', 8);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');			
				
				if($this->uri->segment(4) == 26){
					$this->load->view('admin/onlinedojo_video_album_index', $data);	
				} else {
					redirect('admin/dashboard');
				}
		}
		else
		{
			redirect('admin/login');
		}
	}*/
	
	public function deleteCategory(){
	$id = $_POST['delete-id'];
	$this->db->where("cat_id", $id);
	if($this->db->delete("tblcategory"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	redirect($this->index());
	}
	}
	
	public function publish(){ 
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tbl_onlinedojo_galleryname", array("published" => $pub)))
	{	
		echo 1;
		
	}
	} 
	
	public function publish_video(){ 
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tbl_onlinedojo_media", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function operateMedia(){
		
	$edit_id = $_POST['edit_id'];
	$media_desc = $_POST['media_desc'];
	$media_url = '';
	if(isset($_POST['media_url']) && !empty($_POST['media_url'])){		
		$upload_handler = new UploadHandler();			
		$cover_link=$upload_handler->getVimeoImage();
		if($cover_link){
			$_POST['cover_link']=$cover_link;
		}
		
		$media_url =$_POST['media_url'];
	}	
	
	

	
	
	
	$album = $_POST['edit-album'];
 	$album_cover = $_POST['album-cover-val'];
 	
 	$video_id= $_POST['video_id'];
	$video_type= $_POST['video_type'];	
 	
	$cover_link = $_POST['cover_link'];
	
	$redirection = $_POST['redirection'];	
	$success = 0;
	
	$this->db->where('is_cover_image', 1);
	$exit_album_cover_page = $this->query_model->getbySpecific('tbl_onlinedojo_media','album',$album);
	
	//echo $cover_link; die;
	
	
	if($video_type == "youtube"){
			$cover_link = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
			//$cover_img = array('cover'=> $cover_page_url);
		}elseif($video_type == "vimeo"){
			$cover_link=$this->query_model->getViemoVideoImage($video_id);
			//$cover_img = array('cover'=> $cover_page_url);
		}
	
	
	
	if($media_url){
		$args = array( "desc" => $media_desc,'link'=>htmlentities($media_url) ,'video_id'=>$video_id , 'video_type'=>$video_type);		
	}else{
		$args = array( "desc" => $media_desc );
	}		
	if( $album_cover == 1 ):
	$args2 = array( "cover" => $cover_link );
		if($this->query_model->update("tbl_onlinedojo_galleryname", $album, $args2)):
			if(empty($_POST['video_id'])){
				$this->db->query('update tbl_onlinedojo_media set is_cover_image="" where album ="'.$album.'"  && type="1"')or die(mysqli_error($this->db->conn_id));
			}else{
				$this->db->query('update tbl_onlinedojo_media set is_cover_image="" where album ="'.$album.'" && type="2"')or die(mysqli_error($this->db->conn_id));
			}	
			$args=array_merge ($args,array('is_cover_image'=>1));			
			$success++;
		endif;
	endif;
	if( $album_cover == 0 ):
			if(empty($exit_album_cover_page)){
				$args2 = array( "cover" => $cover_link);
			}else{
				$args2 = array( "pos" => 0);
			}
			
		if($this->query_model->update("tbl_onlinedojo_galleryname", $album, $args2)):
		
		if(empty($_POST['video_id'])){
			
				$this->db->query('update tbl_onlinedojo_media set is_cover_image="" where album ="'.$album.'"  && type="1"')or die(mysqli_error($this->db->conn_id));
		}else{
			  if(empty($exit_album_cover_page)){
			  
				$this->db->query('update tbl_onlinedojo_media set is_cover_image="1" where id ="'.$edit_id.'" && type="2"')or die(mysqli_error($this->db->conn_id));
			 } 
		}
			$success++;
		endif;
	endif;
	
	if($this->query_model->update("tbl_onlinedojo_media", $edit_id, $args)):
	$success++;
	endif;
	
	if($success>0):
	redirect($redirection);
	endif;
	
	}
	
	public function operateCategory(){
	$title = $_POST['name'];
	$meta_desc = $_POST['meta_desc'];
	$operation = $_POST['operation'];
	$id = $_POST['edit_id'];
	$shared = $_POST['shared'];
	$save = $_POST['submit'];
	//echo $title." ".$operation." ".$id." "." ".$shared." ".$save;
	if(isset($save))
	{
		if( $operation == 'add' )
		{
			$args = array("cat_name" => $title, "meta_desc" => $meta_desc,  "cat_type" => "gallery", "permission" => $shared);
			if($this->query_model->addCategory($args)){
			redirect($this->index());
			}
			else
			{	
				echo "<script language='javascript'>alert('Unable to add category');</script>";
				redirect($this->index());
			}
		}
		elseif( $operation == 'edit' )
		{
			$args = array("cat_name" => $title, "meta_desc" => $meta_desc,  "cat_type" => "gallery", "permission" => $shared);
			$this->db->where("cat_id",$id);
			if($this->query_model->editCategory($args)){
			redirect($this->index());
			}
			else
			{	
				echo "<script language='javascript'>alert('Unable to add category');</script>";
				redirect($this->index());
			}
		}
	}	
	}	
	
	public function deletemedia(){
		$id = $_POST['delete-item-id'];
		$redirect = $_POST['redirect'];	
		$this->db->where("id", $id);
		$link = $this->db->get("tbl_onlinedojo_media");
		$row = $link->row_array();		  
		$temp = $row['link'];
		$temp_thumb = $row['link_thumbnail'];
		$this->db->where("id", $id);	
		if( $this->db->delete("tbl_onlinedojo_media"))
		{
			if($row['type']!=2){
				$umask=umask(0);
				if(file_exists(dirname($_SERVER['SCRIPT_FILENAME']).'/'.rawurldecode($temp))){				
					unlink(dirname($_SERVER['SCRIPT_FILENAME']).'/'.rawurldecode($temp));
				}
				if(file_exists(dirname($_SERVER['SCRIPT_FILENAME']).'/'.rawurldecode($temp_thumb))){	
					unlink(dirname($_SERVER['SCRIPT_FILENAME']).'/'.rawurldecode($temp_thumb));
				}									
				umask($umask);
			}
		
			redirect("admin/onlinedojo_video_albums/edit/".$redirect);
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete media');</script>";
			redirect("admin/onlinedojo_video_albums/edit/".$redirect);
		}
	}

	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$cat = $_POST['category_loc'];
	
	$this->db->where("id", $id);
	if($this->db->delete("tbl_onlinedojo_galleryname"))
	{	if($cat){		
			redirect("admin/onlinedojo_video_albums/view/".$cat);
		}else{
			redirect("admin/onlinedojo_video_albums");
		}		
			
	}
	else
	{
		echo "<script language='javascript'>alert('Unable to delete album');</script>";
	
		if($cat){		
			redirect("admin/onlinedojo_video_albums/view/".$cat);
		}else{
			redirect("admin/onlinedojo_video_albums");
		}
	}
	}
	
	function uploadMedia(){				
								
	if(isset($_POST['submit'])):	
		if($_POST['upload-type'] == 1)
			$this->onlinedojo_video_album_model->uploadIt();
		else
			$this->onlinedojo_video_album_model->saveEmbed();
	endif;
	//redirect("admin/onlinedojo_video_albums/view/".$cat);
	redirect($_POST['referer']);
		
	}
	
	function makecover(){
	$id = $_POST['album'];
	$link = $_POST['cover_link'];
	$this->db->where("id", $id);
	if($this->db->update("tbl_onlinedojo_galleryname", array("cover" => $link)))
	{	
		echo 1;
		
	}
	}	
	
	
	 function GetImageFromUrl($link)

    {
	
	$link  = 'http://img.youtube.com/vi/D0E914X75K4/';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_POST, 0);

    curl_setopt($ch,CURLOPT_URL,$link);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result=curl_exec($ch);

    curl_close($ch);

    return $result; die;

    }

    
	
	
	public function sortcategory(){
		//print_r($_POST);EXIT;
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tblcategory` SET `pos`=" . $i . " WHERE `cat_id`='" . $menu[$i]. "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	function getCategory(){
		
		$cat_id = $_POST['cat_id'];
		
		$query = $this->db->get_where('tblcategory', array('cat_id' => $cat_id));
		$categories = $query->result();
		
		//echo '<pre>'; print_r($programs[0]); echo '</pre>';
		
		$data['cat_name'] = $categories[0]->cat_name;
		$data['meta_desc'] = $categories[0]->meta_desc;
		
		echo json_encode($data);
		
	}
	
	
	public function moveOnlineDojoVideos(){
		//echo '<pre>POST'; print_r($_POST); die;
		//if(isset($_POST['submit']) && !empty($_POST['submit'])){
			if(isset($_POST['move_video_type'])){
				
				$video_id = (isset($_POST['video_id']) && !empty($_POST['video_id'])) ? $_POST['video_id'] : '';
				$album_id = (isset($_POST['album_id']) && !empty($_POST['album_id'])) ? $_POST['album_id'] : '';
					
				if(!empty($video_id) && !empty($album_id) ){
					
					
					if($_POST['move_video_type'] == "video_to_album"){
					
						$videoDetail = $this->query_model->getBySpecific('tbl_onlinedojo_videos','id',$video_id);
						
						if(!empty($videoDetail)){
							
							
							
							$videoDetail = $videoDetail[0];
							$online_video_id = $videoDetail->video_id;
							//$online_video_type = $videoDetail->video_type;
						
							$link = '';
							if($videoDetail->video_type == "youtube_video"){
								$link = $videoDetail->youtube_video;
								$online_video_type = 'youtube';
								$video_img = "http://i.ytimg.com/vi/".$online_video_id."/0.jpg";
							}else if($videoDetail->video_type == "vimeo_video"){
								$link = $videoDetail->vimeo_video;
								$online_video_type = 'vimeo';
								$img_src=$this->query_model->getViemoVideoImage($online_video_id);
														
								$video_img = $this->query_model->changeVideoImgPathHttp($img_src);
								
								if (strpos($video_img, 'video_album_cover') !== false) {
									
								}else{
									$img_src_data = explode('_',$video_img);
										
									$img_1 = isset($img_src_data[0]) ? $img_src_data[0] : '';
									$extension = pathinfo($video_img, PATHINFO_EXTENSION);
									
									$video_img = $img_1.'_360x220.'.$extension;
								}
							}else if($videoDetail->video_type == "embed_video"){
								if(!empty($videoDetail->embed_video_text)){
									
									$video_img = base_url().'upload/slider_video/thumb/'.$videoDetail->video_img;
									
									preg_match('/src="([^"]+)"/', $videoDetail->embed_video_text, $match);
									$url = $match[1];
									$link = $url;
									
									if (strpos($link, 'youtube') > 0) {
										$online_video_type = 'youtube';
										
										preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $link, $matches);
		 
										  $online_video_id = isset($matches[1]) ? trim($matches[1]) : '';
										  
										 
										  
									} elseif (strpos($link, 'vimeo') > 0) {
										$online_video_type = 'vimeo';
										 preg_match("/(http?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $link, $matches);
		 
										$online_video_id = isset($matches[5]) ? trim($matches[5]) : '';
										
										
									}
								}
								
								
							}
							
							$updatedata = array('is_cover_image'=>0);
							$this->db->where('album', $album_id);
							$this->db->update("tbl_onlinedojo_media",$updatedata);
							
							$updateCover = array('cover'=>$video_img);
							$this->db->where('id', $album_id);
							$this->db->update("tbl_onlinedojo_galleryname",$updateCover);
							
							$updateData = array();
							$updateData['album'] = $album_id;
							$updateData['link'] = $link;
							$updateData['link_thumbnail'] = '';
							$updateData['link_thumbnail_2'] = '';
							$updateData['desc'] = $videoDetail->video_title.'. '.$videoDetail->slide_text;
							$updateData['video_id'] = $online_video_id;
							$updateData['video_type'] = $online_video_type;
							$updateData['is_cover_image'] = 1;
							$updateData['type'] = 2;
							$updateData['pos'] = 0;
							$updateData['category'] = 0;
							$updateData['published'] = $videoDetail->published;
							
							$this->query_model->insertData("tbl_onlinedojo_media", $updateData);
							
							$this->db->where("id", $video_id);
							$this->db->delete("tbl_onlinedojo_videos");
							
							redirect("admin/onlinedojo_video_albums");
							
						}
						
						
						
					}else if($_POST['move_video_type'] == "album_to_album"){
						
						if($album_id == "free_floting_video"){
							$videoDetail = $this->query_model->getBySpecific('tbl_onlinedojo_media','id',$video_id);
							
							if(!empty($videoDetail)){
								
								$videoDetail = $videoDetail[0];
								$online_video_id = $videoDetail->video_id;
								
								$updateData = array();
								$updateData['video_title'] = $videoDetail->desc;
								$updateData['slide_text'] = '';
								$updateData['video_type'] = $videoDetail->video_type.'_video';
								if($videoDetail->video_type == "youtube"){
									$updateData['youtube_video'] = $videoDetail->link;
									$video_img = "http://i.ytimg.com/vi/".$online_video_id."/0.jpg";
								}elseif($videoDetail->video_type == "vimeo"){
									$updateData['vimeo_video'] = $videoDetail->link;
									$img_src=$this->query_model->getViemoVideoImage($online_video_id);
														
									$video_img = $this->query_model->changeVideoImgPathHttp($img_src);
									
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
								
								
								
								
								
								$updateData['video_id'] = $videoDetail->video_id;
								$updateData['pos'] = 0;
								$updateData['published'] = $videoDetail->published;
								$updateData['videoimage'] = $videoimage;
								//echo '<pre>updateData'; print_r($updateData); die;
								$this->query_model->insertData("tbl_onlinedojo_videos", $updateData);
								
								$this->db->where("id", $video_id);
								$this->db->delete("tbl_onlinedojo_media");
								
								/** code for update cover **/
								$this->db->limit(1);
								$this->db->order_by('id','desc');
								$this->db->where('published',1);
								$lastMedia = $this->query_model->getBySpecific('tbl_onlinedojo_media','album',$videoDetail->album);
								
								$video_img = '';
								if(!empty($lastMedia)){
									$lastMedia = $lastMedia[0];
									if($lastMedia->video_type == "youtube"){
										$video_img = "http://i.ytimg.com/vi/".$lastMedia->video_id."/0.jpg";
									}else if($lastMedia->video_type == "vimeo"){
										
										$img_src=$this->query_model->getViemoVideoImage($lastMedia->video_id);
																
										$video_img = $this->query_model->changeVideoImgPathHttp($img_src);
										
										if (strpos($video_img, 'video_album_cover') !== false) {
											
										}else{
											$img_src_data = explode('_',$video_img);
												
											$img_1 = isset($img_src_data[0]) ? $img_src_data[0] : '';
											$extension = pathinfo($video_img, PATHINFO_EXTENSION);
											
											$video_img = $img_1.'_360x220.'.$extension;
										}
									}
								}
								
								$updateCover = array('cover'=>$video_img);
								$this->db->where('id', $videoDetail->album);
								$this->db->update("tbl_onlinedojo_galleryname",$updateCover);
								
								redirect("admin/onlinedojo_videos");
								
							}
						
						
						}else{
							$videoDetail = $this->query_model->getBySpecific('tbl_onlinedojo_media','id',$video_id);
							
							if(!empty($videoDetail)){
								$videoDetail = $videoDetail[0];
								
								$updatedata = array('is_cover_image'=>0);
								$this->db->where('album', $album_id);
								$this->db->update("tbl_onlinedojo_media",$updatedata);
								
								$online_video_id = $videoDetail->video_id;
								if($videoDetail->video_type == "youtube"){
									$video_img = "http://i.ytimg.com/vi/".$online_video_id."/0.jpg";
								}else if($videoDetail->video_type == "vimeo"){
									
									$img_src=$this->query_model->getViemoVideoImage($online_video_id);
															
									$video_img = $this->query_model->changeVideoImgPathHttp($img_src);
									
									if (strpos($video_img, 'video_album_cover') !== false) {
										
									}else{
										$img_src_data = explode('_',$video_img);
											
										$img_1 = isset($img_src_data[0]) ? $img_src_data[0] : '';
										$extension = pathinfo($video_img, PATHINFO_EXTENSION);
										
										$video_img = $img_1.'_360x220.'.$extension;
									}
								}
								
								
								$updateCover = array('cover'=>$video_img);
								$this->db->where('id', $album_id);
								$this->db->update("tbl_onlinedojo_galleryname",$updateCover);
								
								$updateData = array();
								$updateData['album'] = $album_id;
								$updateData['is_cover_image'] = 1;
								$updateData['pos'] = 0;
								
								$this->query_model->update("tbl_onlinedojo_media", $video_id , $updateData);
								
								redirect("admin/onlinedojo_video_albums/edit/".$album_id.'/26');
								
							}
							
							
						}
					}
					
				}
			}
		//}
		
	}
	
	
}