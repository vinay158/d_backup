<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {
	
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
		redirect('admin/blog/view/1');
	}
	
	public function edit(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			if($this->uri->segment(4) != NULL):
				$data['title'] = "Blog";
				$data['blogdetails'] = $this->query_model->getbyId('tblblog',$this->uri->segment(4));
				$data['cat'] = $this->query_model->getCategory("blog");
				if(!empty($data['blogdetails'])):
					
					$this->load->view('admin/blog_edit',$data);
		
					if(isset($_POST['update'])):
						$this->blog_model->updateblog();
					endif;
				else:
					redirect('admin/blog');
				endif;
			else:
				redirect('admin/blog');
			endif;

		}else{
			redirect('admin/login');
		}
	}
	
	public function add(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "blogs";
			$data['cat'] = $this->query_model->getCategory("blog");
			
			if(isset($_POST['update'])):
						$this->blog_model->addblog();
			endif;
			$this->load->view("admin/blog_add", $data);	
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function view()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "Blog";
			$data['cat'] = $this->query_model->getCategory("blog");
			$data['link_type'] = "blog";
			$data['blogs'] = $this->blog_model->getBlogbyCat($this->uri->segment(4));
			$this->load->view('admin/blog_index', $data);	
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
	if($this->db->update("tblblog", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblblog"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	redirect($this->index());
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
	$operation = $_POST['operation'];
	$id = $_POST['edit_id'];
	$shared = $_POST['shared'];
	$save = $_POST['submit'];
	//echo $title." ".$operation." ".$id." "." ".$shared." ".$save;
	if(isset($save))
	{
		if( $operation == 'add' )
		{
			$args = array("cat_name" => $title, "cat_type" => "blog", "permission" => $shared);
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
			$args = array("cat_name" => $title, "cat_type" => "blog", "permission" => $shared);
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
}