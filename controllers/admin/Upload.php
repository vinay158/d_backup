<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

public function __construct()
	{
		parent::__construct();		
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->helper(array('form', 'url'));
		$this->load->model('gallery_model');
		$this->load->library('UploadHandler');
	}

public function index()
	{
		//$this->load->view('admin/upload', array('error' => ''));		
		
		 
		$this->load->view("admin/include/upload-modal2",array('error' => '')); 
		
	}
	
	public function do_upload()
	{	
		error_reporting(0);
		ini_set('display_errors',0);
		$error=false;
		
	if(IS_AJAX){		
		
		if(isset($_FILES['files']['name'])){			
			//echo @base_url(); 
			$img_data=$_options=array();
		    
		    if($this->uri->segment(5)=='facility'){ //check facility page ?
		    	$_options=array('user_dirs'=>'facility','image_versions_2_allowed'=>false);		    	
		    }else{
		    	$_options=array('image_versions_2_allowed'=>true);
		    }						
												
			$upload_handler = new UploadHandler($_options,false);			
			$upload_handler->initialize();
			
			$main_data=$upload_handler->opt;
			$data=json_decode($main_data);
						
			if($data->files[0]->name){	
				$data->files[0]->thumbnail_url;
				$data->files[0]->url;
						
				$_thumb_url=str_replace(@base_url(),'',$data->files[0]->thumbnail_url);
				$_thumb_url_2="";
				if(isset($data->files[0]->thumbnail_2_url)){
					$_thumb_url_2=str_replace(@base_url(),'',$data->files[0]->thumbnail_2_url);
				}	
				$_url=str_replace(@base_url(),'',$data->files[0]->url);				
					
				$img_data['img_path']=$_url;				
				$img_data['img_path_thumbnail']=$_thumb_url;
				if($_thumb_url_2){
					$img_data['img_path_thumbnail_2']=$_thumb_url_2;
				}
				
				// This will be fixed Image type =1, Video type =2 ,
					
				if($this->uri->segment(4)=='page'){
					if($this->uri->segment(5)=='facility'){ //check facility page ?						
						if($this->insertFacilityImage($img_data)){
								echo $main_data;
								exit;																
							}else{
								echo "No data saved while uploading.";
								exit;
							}										 
						
					}else{
							echo "Wrong file path.";
							exit;
					}			
						
				}
				else{							
						$img_data['album']=$this->uri->segment(5);
						$img_data['type']='1';						
						
						if($this->gallery_model->insertGalleryImage($img_data)){
							echo $main_data;
							exit;
						}else{
							echo "No data saved while uploading.";
							exit;
						}
				}
			}	
			
		}else{
			echo '0'; exit;
		}
			
	}else{
		echo 'No ajax request.';
		exit;
	}
	
	}	
	
	public function facility_upload()
	{	
		error_reporting(0);
		ini_set('display_errors',0);
		$error = false;
		
		$facility_id = $this->uri->segment(5);		
		
		if(IS_AJAX){		
		
			if(isset($_FILES['files']['name'])){			

				$img_data = $_options = array();
		    
				$_options=array('user_dirs'=>'facility','image_versions_2_allowed'=>false);					
												
				$upload_handler = new UploadHandler($_options,false);			
				$upload_handler->initialize();
			
				$main_data = $upload_handler->opt;
				$data = json_decode($main_data);
				//echo '<pre>'; print_r($data); echo '</pre>';
						
				if($data->files[0]->name){	
				
					$data->files[0]->thumbnail_url;
					$data->files[0]->url;
						
					$_thumb_url = str_replace(@base_url(),'',$data->files[0]->thumbnail_url);
					$_thumb_url_2 = "";
					
					if(isset($data->files[0]->thumbnail_2_url)){
						$_thumb_url_2=str_replace(@base_url(),'',$data->files[0]->thumbnail_2_url);
					}	
					
					$_url = str_replace(@base_url(),'',$data->files[0]->url);				
					
					$img_data['img_path'] = $_url;				
					$img_data['img_path_thumbnail'] = $_thumb_url;
					if($_thumb_url_2){
						$img_data['img_path_thumbnail_2'] = $_thumb_url_2;
					}
					
					$img_data['facility_id'] = $facility_id;
				
					// This will be fixed Image type =1, Video type =2 ,
					
					if($this->insertFacilityImage($img_data)){
						echo $main_data;
						exit;																
					}else{
						echo "No data saved while uploading.";
						exit;
					}
				}	
			
			}else{
				echo '0'; exit;
			}
			
		}else{
			echo 'No ajax request.';
			exit;
		}
	
	}
	
	public function insertFacilityImage($img_data){			
	
		$data_count = $this->query_model->getFacilityData();
			
		$table = 'tblaboutfacilityphoto';
		
		if(is_array($img_data) && count($img_data)>0){
		
			$a = $img_data['img_path'];
			$b = $img_data['img_path_thumbnail'];
		
			if(isset($img_data['img_path_thumbnail_2']) && $img_data['img_path_thumbnail_2']){
				$c = $img_data['img_path_thumbnail_2'];					
			}
		
			$data = array(
				'photo' => $a,
				'link_thumbnail'=>$b,		
				'facility_id'=> $img_data['facility_id']						
			);
		
			if($c){
				$data = array_merge($data,array('link_thumbnail_2'=>$c));					
			}		
		
			if($this->query_model->insertDataFacility($table,$data)){
				return true;
			}else{
				return 0;
			}											
		}
				
	}
	
	public function ckupload(){
	 
	$url = 'upload/ckeditor/'.time()."_".$_FILES['upload']['name'];
 	//extensive suitability check before doing anything with the file...
    if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
    {
       $message = "No file uploaded.";
    }
    else if ($_FILES['upload']["size"] == 0)
    {
       $message = "The file is of zero length.";
    }
    else if (($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
    {
       $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
    }
    else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
    {
       $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
    }
    else {
      $message = "";
      $move = @ move_uploaded_file($_FILES['upload']['tmp_name'], $url);
      if(!$move)
      {
         $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
      }
      $url = base_url(). $url;      
    }
 
		$funcNum = $_GET['CKEditorFuncNum'] ;
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
		
		
	}
	
	public function getVimeoImage(){
			$url=trim($_POST['src']);	
			$data=file_get_contents($url);						
			$data=unserialize($data);						
			$src=$data[0]['user_portrait_medium'];
			return  trim($src);
			
	}
}
?>