<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_model extends CI_Model {
	var $image_path;
	var $imgdata_path;

	function __construct(){
		parent::__construct();

		//$this->load->library('jq_uploader');
	}
	
	function uploadFile(){
		$uploadpath = "sitefiles/";
		$config = array(
                'allowed_types' => 'doc|docx|pdf|rtf|txt|DOC|DOCX|PDF|RTF|TXT|jpg|jpeg|gif|png|JPG|JPEG|GIF|PNG|ico',
				'upload_path' => $uploadpath 
			);
		$this->load->library('upload',$config);
		if($this->upload->do_upload()): return TRUE;
        else: return FALSE;
		endif;
	}

	function upload_image($path, $filename = 'userfile'){
		$this->image_path = $path;
		
		if($path=="img/"){
			$config = array(
				'allowed_types' => 'jpg|jpeg|gif|png|JPG|GIF|PNG|ico|JPEG',
				'upload_path' => $this->image_path,
				'file_name' => 'sitelogo',
				'overwrite' => TRUE
			);
		}else{  
			$config = array(
				//'allowed_types' => '*',
				'allowed_types' => 'jpg|jpeg|gif|png|JPG|GIF|PNG|ico|JPEG',
				'upload_path' => $this->image_path,
			);
		}	
		$this->load->library('upload',$config);		
		
		if($this->upload->do_upload($filename)){	
		

			$imgdata= array('upload_data' => $this->upload->data());

		 	$imgdata_path = $this->image_path.$imgdata['upload_data']['file_name'];
		 	
		 	return $imgdata_path;
		}
		else {			
			return NULL;} 

	}
}
