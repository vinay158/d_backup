<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videogallery extends CI_Controller {

	/*public function index()
	{		redirect("videogallery/video/");		exit;
		$data['page'] = $this->query_model->getbytable("tblgalleryname");
		$this->load->view('gallery-list', $data);
	}*/

	public function index(){
		
		$data['album']=$this->db->query("select * from `tblgalleryname` where category='26' and published='1' order by pos asc")->result();		
		$data['link_type'] = "viewvideo";
		$data['title'] = "Video Gallery";
		$this->load->view('gallery-list', $data);		
	}
		public function viewvideo(){					
		//user auth start	
		$data['action'] = "viewvideo";					
		$data['albumId']=$this->uri->segment(3);
		$data['loginRequired']=false;	
		/*
		$auth_data=$this->config->item('_credentials');
		
		if(array_key_exists($data['albumId'],$auth_data[$data['action']])){			
			$data['loginRequired']=true;						
		}
		//check user is logged in or not
		$this->load->library('session');
		$sessionData=$this->session->userdata;
		$key='access_'.$data['albumId'];
		if(isset($sessionData[$key]) && $sessionData[$key]==$data['albumId']){
			$data['loginRequired']=false;
		}
		*/		
		//user auth end
		//if(!$data['loginRequired']){
			$id = $this->uri->segment(3);
			$this->db->select("album");
			$data['album'] = $this->query_model->getbyId("tblgalleryname", $id);		
			$this->db->order_by("pos", "ASC");		
			$data['media'] = $this->query_model->getbySpecific("tblmedia", "album", $id);
			$this->load->view("video-gallery", $data);	
		/*}else{
			$this->load->view("video-gallery", $data);
		}*/	
				
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */