<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller {	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }		
		$this->load->model('gallery_model');
		$this->load->library('UploadHandler');
	}

	public function index()
	{
		
		redirect('admin/gallery/view/26');
	}
	
	
	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tblgalleryname` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function sortgallery(){
		//echo "here";exit;
		//print_r($_POST);exit;
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
		$this->db->query("UPDATE `tblmedia` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function add(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Gallery";
			
			$this->db->order_by("pos", "ASC");
			$this->db->select(array('cat_id','cat_name'));
			$data['cat'] = $this->query_model->getBySpecific('tblcategory','cat_type',"gallery");
			//$data['cat'] = $this->query_model->getGalleryCategory("gallery");
			//echo '<pre>data'; print_r($data); die;
			if(isset($_POST['update'])):
						$this->gallery_model->addAlbum();
			endif;
			$this->load->view("admin/gallery_add", $data);	
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
					redirect("admin/gallery");
				}	 	
				
			$data['title'] = "Gallery";
			$data['link_type'] = "gallery";
			
			$this->db->where("category", $this->uri->segment(5));
			$data['albums'] = $this->query_model->getbyTable("tblgalleryname");
			
			$this->db->order_by("pos", "ASC");	
			$data['media'] = $this->query_model->getbySpecific("tblmedia", "album", $this->uri->segment(4));
			$data['type']='';
			if(is_array($data['media']) && count($data['media'])>0) {
				$data['type']=$data['media'][0]->type;
			}
			

			$this->db->select(array('cat_id','cat_name'));
			$data['cat'] = $this->query_model->getBySpecific('tblcategory','cat_type',"gallery");
			
			//$data['cat'] = $this->query_model->getGalleryCategory("gallery");
			$data['details'] = $this->query_model->getbyID("tblgalleryname", $this->uri->segment(4));
			$data['album_id']=$this->uri->segment(4);			
			
			//echo '<pre>data'; print_r($data); die;
			if(isset($_POST['update'])):			
					//$this->gallery_model->editAlbum();
			endif;			
				$this->load->view("admin/gallery_edit",$data);			
			
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
			
			$this->gallery_model->ajaxEditAlbum($searcharray);
			
			$result['res'] = 1;
		}
		
		echo json_encode($result); 	
	}
	
	public function view()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				$data['title'] = "Video Albums";
				$this->db->order_by("pos", "ASC");
				//$data['cat'] = $this->query_model->getGalleryCategory("gallery");
				$data['link_type'] = "gallery";
				
				$this->db->order_by("pos", "ASC");
				$this->db->select(array('id','published','album','category','cover','pos'));
				$data['blogs'] = $this->query_model->getbySpecific("tblgalleryname", "category", $this->uri->segment(4));

				// Get Gallery/Video Page title from tbl_studentpagetitle
				$this->db->where('id', 7);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');			
				//echo '<pre>data'; print_r($data); die;
				if($this->uri->segment(4) == 26){
					$this->load->view('admin/gallery_index', $data);	
				} else {
					redirect('admin/dashboard');
				}
		}
		else
		{
			redirect('admin/login');
		}
	}
	
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
	if($this->db->update("tblgalleryname", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	public function operateMedia(){
		
	$edit_id = $_POST['edit_id'];
	$album = $_POST['edit-album'];
	
	$videoDetail = $this->query_model->getBySpecific('tblmedia','id',$edit_id);
	
	
	
	
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
	
	

	
	
	
	
 	$album_cover = $_POST['album-cover-val'];
 	
 	$video_id= $_POST['video_id'];
	$video_type= $_POST['video_type'];	
 	
	$cover_link = $_POST['cover_link'];
	
	$redirection = $_POST['redirection'];	
	$success = 0;
	
	$this->db->where('is_cover_image', 1);
	$exit_album_cover_page = $this->query_model->getbySpecific('tblmedia','album',$album);
	
	//echo $cover_link; die;
	
	
	if($video_type == "youtube"){
			$cover_link = 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
			//$cover_img = array('cover'=> $cover_page_url);
		}elseif($video_type == "vimeo"){
			$cover_link=$this->query_model->getViemoVideoImage($video_id);
			//$cover_img = array('cover'=> $cover_page_url);
		}
	
	
	
	if($media_url){
		$args = array( "desc" => $media_desc,'link'=>htmlentities($media_url) ,'video_id'=>$video_id , 'video_type'=>$video_type,"album" => $album );		
	}else{
		$args = array( "desc" => $media_desc ,"album" => $album );
	}		
	if( $album_cover == 1 ):
	$args2 = array( "cover" => $cover_link );
		if($this->query_model->update("tblgalleryname", $album, $args2)):
			if(empty($_POST['video_id'])){
				$this->db->query('update tblmedia set is_cover_image="" where album ="'.$album.'"  && type="1"')or die(mysqli_error($this->db->conn_id));
			}else{
				$this->db->query('update tblmedia set is_cover_image="" where album ="'.$album.'" && type="2"')or die(mysqli_error($this->db->conn_id));
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
			
		if($this->query_model->update("tblgalleryname", $album, $args2)):
		
		if(empty($_POST['video_id'])){
			
				$this->db->query('update tblmedia set is_cover_image="" where album ="'.$album.'"  && type="1"')or die(mysqli_error($this->db->conn_id));
		}else{
			  if(empty($exit_album_cover_page)){
			  
				$this->db->query('update tblmedia set is_cover_image="1" where id ="'.$edit_id.'" && type="2"')or die(mysqli_error($this->db->conn_id));
			 } 
		}
			$success++;
		endif;
	endif;
	
	if($this->query_model->update("tblmedia", $edit_id, $args)):
	$success++;
	endif;
	
	if($success>0):
	
	/***/
	
	$this->db->limit(1);
	$this->db->order_by('id','desc');
	$this->db->where('published',1);
	$this->db->where('id !=',$edit_id);
	$lastMedia = $this->query_model->getBySpecific('tblmedia','album',$videoDetail[0]->album);
	
	$video_img = '';
	$new_album_id = $album;
	$old_album_id = $album;
	if(!empty($lastMedia)){
		$lastMedia = $lastMedia[0];
		$old_album_id = $lastMedia->album;
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
		
		//echo $new_album_id.'===>'.$old_album_id.'==>'.$video_img;  die;
		if($new_album_id != $old_album_id){
			$updateCover = array('cover'=>$video_img);
			$this->db->where('id', $old_album_id);
			$this->db->update("tblgalleryname",$updateCover);
		}
	}
	
	
	
	
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
		$link = $this->db->get("tblmedia");
		$row = $link->row_array();		  
		$temp = $row['link'];
		$temp_thumb = $row['link_thumbnail'];
		$this->db->where("id", $id);	
		if( $this->db->delete("tblmedia"))
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
		
			redirect("admin/gallery/edit/".$redirect);
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete media');</script>";
			redirect("admin/gallery/edit/".$redirect);
		}
	}

	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$cat = $_POST['category_loc'];
	
	$this->db->where("id", $id);
	if($this->db->delete("tblgalleryname"))
	{	if($cat){		
			redirect("admin/gallery/view/".$cat);
		}else{
			redirect("admin/gallery");
		}		
			
	}
	else
	{
		echo "<script language='javascript'>alert('Unable to delete album');</script>";
	
		if($cat){		
			redirect("admin/gallery/view/".$cat);
		}else{
			redirect("admin/gallery");
		}
	}
	}
	
	function uploadMedia(){				
								
	if(isset($_POST['submit'])):	
		if($_POST['upload-type'] == 1)
			$this->gallery_model->uploadIt();
		else
			$this->gallery_model->saveEmbed();
	endif;
	//redirect("admin/gallery/view/".$cat);
	redirect($_POST['referer']);
		
	}
	
	function makecover(){
	$id = $_POST['album'];
	$link = $_POST['cover_link'];
	$this->db->where("id", $id);
	if($this->db->update("tblgalleryname", array("cover" => $link)))
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
	
	public function publish_video(){ 
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tblmedia", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
}