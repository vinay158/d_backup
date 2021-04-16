<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {
	
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
		redirect('admin/faq/view/21');
	}
	
	
	public function sortthis(){
	
	$menu = $_POST['menu'];
	for ($i = 0; $i < count($menu); $i++) {

	$this->db->query("UPDATE `tblfaq` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
	}
	return;
	}
	
	
	public function sortcategory(){
	
	$menu = $_POST['menu'];
	for ($a = 0; $a < count($menu); $a++) {

	$this->db->query("UPDATE `tblcategory` SET `pos`=" . $a . " WHERE `cat_id`='" . $menu[$a] . "'") or die(mysqli_error($this->db->conn_id));
	}
	
	return;
	}
	
	public function edit(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			if($this->uri->segment(4) != NULL):
				$data['title'] = "faq";
				$data['blogdetails'] = $this->query_model->getbyId('tblfaq',$this->uri->segment(4));
				$data['cat'] = $this->query_model->getCategory("faq");
				if(!empty($data['blogdetails'])):
					
					$this->load->view('admin/faq_edit',$data);
		
					if(isset($_POST['update'])):					 
						$this->blog_model->updatefaq();
					endif;
				else:
					redirect('admin/faq');
				endif;
			else:
				redirect('admin/faq');
			endif;

		}else{
			redirect('admin/login');
		}
	}
	
	public function add(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "faq";
			$data['cat'] = $this->query_model->getCategory("faq");
			
			if(isset($_POST['update'])):			
				$this->blog_model->addfaq();
			endif;
			$this->load->view("admin/faq_add", $data);	
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function view()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "faq";			
			//$this->db->order_by("pos", "ASC"); // vinay 16/11
			$this->db->order_by("id", "DESC"); // vinay 16/11
			$data['cat'] = $this->query_model->getCategory("faq");			
			$data['link_type'] = "faq";
			//$this->db->order_by("pos", "ASC"); // vinay 16/11
			$this->db->order_by("id", "DESC"); // vinay 16/11
			$data['blogs'] = $this->db->query("select * from tblfaq where category = '".$this->uri->segment(4)."' ORDER BY pos ASC")->result();
			$this->load->view('admin/faq_index', $data);	
		}
		else
		{
			redirect('admin/login');
		}
	}
	
	public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tblfaq", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblfaq"))
	{
		if($_POST['category_loc']){
			redirect("admin/faq/view/".$_POST['category_loc']);
		}else{
			redirect("admin/faq");
		}
	
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	
		if($_POST['category_loc']){
			redirect("admin/faq/view/".$_POST['category_loc']);
		}else{
			redirect("admin/faq");
		}
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
	public function operateCategory(){
		
		$title = $_POST['name'];
		// $meta_desc = $_POST['meta_desc'];
		$operation = $_POST['operation'];
		$id = $_POST['edit_id'];
		$shared = $_POST['shared'];
		$save = $_POST['submit'];
		//echo $title." ".$operation." ".$id." "." ".$shared." ".$save;
		if(isset($save))
		{
			if( $operation == 'add' )
			{
				//$args = array("cat_name" => $title, "meta_desc" => $meta_desc,  "cat_type" => "faq", "permission" => $shared);
				$args = array("cat_name" => $title, "cat_type" => "faq", "permission" => $shared);
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
				//$args = array("cat_name" => $title, "meta_desc" => $meta_desc,  "cat_type" => "faq", "permission" => $shared);
				$args = array("cat_name" => $title,  "cat_type" => "faq", "permission" => $shared);
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
	
	function getCategory(){
		
		$cat_id = $_POST['cat_id'];
		
		$query = $this->db->get_where('tblcategory', array('cat_id' => $cat_id));
		$categories = $query->result();
		
		//echo '<pre>'; print_r($programs[0]); echo '</pre>';
		
		$data['cat_name'] = $categories[0]->cat_name;
		$data['meta_desc'] = $categories[0]->meta_desc;
		
		echo json_encode($data);
		
	}
}