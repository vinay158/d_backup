<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schoolrules extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('blog_model');
	}
	
	public function index()
	{
	redirect("admin/schoolrules/view");
	}
	
	public function view(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = 'School Rules';
		$data['link_type'] = 'schoolrules';
		$this->db->order_by("pos", "ASC");
		$data['staff'] = $this->db->get("tblrules")->result();
		$this->load->view("admin/school_rules_index", $data);
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tblrules` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "School Rules";
			if(isset($_POST['update'])):
						$this->blog_model->addRules();
			endif;
			$this->load->view("admin/rules_add", $data);	
		}else{
			redirect('admin/login');
		}
	
	}
	
	public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tblrules", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblrules"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	redirect($this->index());
	}
	}
	
	public function edit(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			if($this->uri->segment(4) != NULL):
				$data['title'] = "School Rules";
				$data['blogdetails'] = $this->query_model->getbyId('tblrules',$this->uri->segment(4));
				if(!empty($data['blogdetails'])):
					$this->load->view('admin/rules_edit',$data);
					if(isset($_POST['update'])):
						$this->blog_model->updaterules();
					endif;
				else:
					redirect('admin/schoolrules');
				endif;
			else:
				redirect('admin/schoolrules');
			endif;

		}else{
			redirect('admin/login');
		}
	}
	
	
	
}