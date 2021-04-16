<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller {

	public function index()
	{
		$data['page'] = $this->query_model->getbytable("tblgalleryname");
		$this->load->view('gallery-list', $data);
	}
	
	public function photo(){
		
		$data['album']=$this->db->query("select * from `tblgalleryname` where category='25' and published='1' order by pos asc")->result();		
		$data['link_type'] = "viewphoto";
		$data['title'] = "Photo Gallery";
		$this->load->view('gallery-list', $data);
	}
	
	public function video(){
		
		$data['album']=$this->db->query("select * from `tblgalleryname` where category='26' and published='1' order by pos asc")->result();
		$data['link_type'] = "viewvideo";
		$data['title'] = "Video Gallery";
		$this->load->view('gallery-list', $data);		
	}
	
	public function viewphoto(){
		$id = $this->uri->segment(3);
		$this->db->select("album");
		$data['album'] = $this->query_model->getbyId("tblgalleryname", $id);
		$data['media'] = $this->query_model->getbySpecific("tblmedia", "album", $id);
		$this->load->view("photo-gallery", $data);
	}

	public function viewvideo(){
		$id = $this->uri->segment(3);
		$this->db->select("album");
		$data['album'] = $this->query_model->getbyId("tblgalleryname", $id);
		$data['media'] = $this->query_model->getbySpecific("tblmedia", "album", $id);
		$this->load->view("video-gallery", $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */