<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homework extends CI_Controller {
	
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
		redirect('admin/homework/view/21');
	}
	
	
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tblhomework` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
		
		return true;
	}
	
	
	public function sortcategory(){	
		$menu = $_POST['menu'];
		for ($a = 0; $a < count($menu); $a++) {
			$this->db->query("UPDATE `tblcategory` SET `pos`=" . $a . " WHERE `cat_id`='" . $menu[$a] . "'") or die(mysqli_error($this->db->conn_id));
		}
	
		return true;
	}
	
	public function edit(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			if($this->uri->segment(4) != NULL):
				$data['title'] = "homework";
				$data['blogdetails'] = $this->query_model->getbyId('tblhomework',$this->uri->segment(4));
				$data['cat'] = $this->query_model->getCategory("faq");
				if(!empty($data['blogdetails'])):
					
					$this->load->view('admin/homework_edit',$data);
		
					if(isset($_POST['update'])):					 
						$this->blog_model->updateHomework();
					endif;
				else:
					redirect('admin/homework');
				endif;
			else:
				redirect('admin/homework');
			endif;

		}else{
			redirect('admin/login');
		}
	}
	
	public function add(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "homework";
			$data['cat'] = $this->query_model->getCategory("faq");
			
			if(isset($_POST['update'])):			
				$this->blog_model->addHomework();
			endif;
			$this->load->view("admin/homework_add", $data);	
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function view()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "homework";			
			/*$this->db->order_by("pos", "ASC");
			$data['cat'] = $this->query_model->getCategory("faq");*/			
			$data['link_type'] = "homework";
			$this->db->order_by("pos", "ASC");
			//$data['blogs'] = $this->db->query("select * from tblhomework where category = '".$this->uri->segment(4)."' ORDER BY pos ASC")->result();
			$data['blogs'] = $this->db->query("select * from tblhomework  ORDER BY pos ASC")->result();
			$this->load->view('admin/homework_index', $data);	
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
		if($this->db->update("tblhomework", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	public function deleteitem(){
		$id = $_POST['delete-item-id'];
		$this->db->where("id", $id);
		
		if($this->db->delete("tblhomework"))
		{
			if($_POST['category_loc']){
				redirect("admin/homework/view/".$_POST['category_loc']);
			}else{
				redirect("admin/homework");
			}
		
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete category');</script>";		
			if($_POST['category_loc']){
				redirect("admin/homework/view/".$_POST['category_loc']);
			}else{
				redirect("admin/homework");
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
				$args = array("cat_name" => $title, "meta_desc" => $meta_desc,  "cat_type" => "faq", "permission" => $shared);
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
				$args = array("cat_name" => $title, "meta_desc" => $meta_desc,  "cat_type" => "faq", "permission" => $shared);
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