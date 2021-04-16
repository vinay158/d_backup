<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ads extends CI_Controller {
	
	function __construct(){
		parent::__construct();
				
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
        $this->load->model("setting_model");

	}
	
	public function index()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		$data['user_level']=$this->session->userdata['user_level'];
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
				$data['title'] = "Advertisements";
				$data['link_type'] = "ads";
				
				$this->db->order_by("pos", "ASC");
				$this->db->select(array('id','image_video','video_id','video_type','photo','title','published'));
				$data['slides'] = $this->query_model->getbyTable("tblads");
				//echo '<pre>data'; print_r($data); die;
				$this->load->view('admin/ads_index', $data);	
			}else{
				redirect("admin/login");
			}
	}
	
	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tblads` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = 'Advertisement Manager';
		
		if(isset($_POST['update'])):
			$this->setting_model->addAds();
		endif;
		
		$this->load->view('admin/ads_add', $data);
		
		
		}else{
			redirect("admin/login");
		}
	}

public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		if( $this->uri->segment(4) != '') :
		$data['title'] = 'Advertisement Manager';
		$data['ads'] = $this->query_model->getbyId("tblads", $this->uri->segment(4)); 
		
		
		
		if(isset($_POST['update'])):
		
			$this->setting_model->updateAds();
		endif;		
		else: 
			redirect("admin/ads");
		endif;
		}else{
			redirect("admin/login");
		}
		
		$this->load->view('admin/ads_edit', $data);
	}


	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblads"))
	{
		redirect("admin/ads");
	}
	else
	{
		echo "<script language='javascript'>alert('Unable to delete');</script>";
		redirect("admin/ads");
	}
	}

public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tblads", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function publish_mailling(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];	
		$this->db->where("id", $id);
		if($this->db->update("tblsite", array("is_mailing_required" => $pub)))
		{	
			echo 1;
			exit;
			
		}
	}
}