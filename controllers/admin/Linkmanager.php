<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Linkmanager extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
	}
	
	public function index()
	{
		redirect('admin/linkmanager/view');
	}
	
	public function view(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = 'Top Link';
		$data['link_type'] = 'linkmanager';
		$this->db->order_by("pos", "ASC");
		$data['staff'] = $this->db->get("tblnavigation")->result();
		$this->load->view("admin/toplink", $data);
		}else
		{
			redirect('admin/login');
		}
	}
	
	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tblnavigation` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
	if(!empty($is_logged_in) && $is_logged_in == true){
	if($this->uri->segment(4) != NULL){
	$data['title'] = 'Top Link';
	$data['details'] = $this->query_model->getbyId("tblnavigation", $this->uri->segment(4));
	$this->load->view("admin/link_edit", $data);
		if(isset($_POST['update'])):
		$name = $_POST['name'];
		$url = $_POST['url'];
		$target = $_POST['target']; 
		if($this->query_model->update("tblnavigation", $this->uri->segment(4) , array("name" => $name, "url" => $url, "target" => $target)))
			redirect("admin/linkmanager");
		endif;
		
	}
	else{ redirect("admin/staff");}
	}else{ redirect("admin/login");}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Top Link";
			if(isset($_POST['update'])):
				$name = $_POST['name'];
				$url = $_POST['url'];
				$target = $_POST['target']; 
				if($this->query_model->insertData("tblnavigation", array("name" => $name, "url" => $url, "target" => $target)))
					redirect("admin/linkmanager");
			endif;
			$this->load->view("admin/link_add", $data);	
		}else{
			redirect('admin/login');
		}
	
	}
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	//echo $id;exit;
	$this->db->where("id", $id);
	if($this->db->delete("tblnavigation"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete staff');</script>";
	redirect($this->index());
	}
	}
	
	public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tblstaff", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
}