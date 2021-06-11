<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Featuredprograms extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('blog_model');
		$this->load->model('featuredprogram_model');
		$this->load->helper(array('url'));
		$base_url = base_url();
	}
	
	public function index()
	{ 
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Featured Programs";
			$data['link_type'] = "featuredprograms";
			
			$this->db->order_by('pos asc, id desc');
			$this->db->select(array('id','photo_thumb','program_title','p_type','published'));
			$query = $this->db->get('tblfeaturedprogram');
			$data['programs'] = $query->result();
			
			$query = $this->db->get('tbladvert');
			$data['adverts'] = $query->result();
			$this->load->view("admin/featured_index", $data);
			
		}
		else{
			redirect("admin/login");
		}
	}
	
	
	public function edit($id){
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true){		
			if( $id != NULL ){
				$data['program_id'] = $id;
				$data['title'] = "Our Featured Programs";
				//$data['details'] = $this->query_model->getbyId("tblfeaturedprogram", $this->uri->segment(4));		
				
				$query = $this->db->get_where('tblfeaturedprogram', array('id' => $id));
				$data['detail'] = $query->row_array();
				
			//$this->db->where("stand_alone_page", 1);
			$this->db->where("published", 1);
			$data['leanding_programs'] = $this->query_model->getbyTable('tblprogram');
			$program_lists = array();
			foreach($data['leanding_programs'] as $leanding_programs){
				$programs = $this->query_model->getbySpecific('tblprogram', 'id', $leanding_programs->id);
				if(!empty($programs)){
					$program_lists[] = $programs;
				}
			} 
			$data['stand_programs'] = $program_lists;
			
			
			$this->db->where('published', 1);
			$data['program_categories'] = $this->query_model->getbySpecific('tblcategory','cat_type','programs');
			
			
			
			$data['program_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 30);
			$data['program_slug'] = $data['program_slug'][0]->slug;
			
			
				if(count($_POST)>0 && isset($_POST['update'])):
				
					$this->featuredprogram_model->updateProgram();
					
					redirect($base_url.'admin/featuredprograms');
				endif;
				$this->load->view("admin/featured_edit", $data);
			}else{
				redirect("admin/featured_index");
			}
		}else{
			redirect("admin/login");
		}
	}
	
	function add(){
		
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Featured Programs";
			$data['link_type'] = "featuredprograms";
			$data['programs'] = $this->query_model->getbyTable("tblprogram");
			
			//$this->db->where("stand_alone_page", 1);
			$this->db->where("published", 1);
			$data['leanding_programs'] = $this->query_model->getbyTable('tblprogram');
			$program_lists = array();
			foreach($data['leanding_programs'] as $leanding_programs){
				$programs = $this->query_model->getbySpecific('tblprogram', 'id', $leanding_programs->id);
				if(!empty($programs)){
					$program_lists[] = $programs;
				}
			} 
			$data['stand_programs'] = $program_lists;
			
			
			$this->db->where('published', 1);
			$data['program_categories'] = $this->query_model->getbySpecific('tblcategory','cat_type','programs');
			
			
			//echo '<pre>'; print_r($data['stand_programs']); die;
			$data['program_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 30);
			$data['program_slug'] = $data['program_slug'][0]->slug;
			
			if(isset($_POST['update'])):
				$this->featuredprogram_model->addProgram();
				redirect($base_url.'admin/featuredprograms');
			endif;
			
			$this->load->view("admin/featured_add", $data);
		}
		else{
			redirect("admin/login");
		}
	}
	
	function addAdvert(){
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		$this->featuredprogram_model->addAdvert();
		redirect($base_url.'admin/featuredprograms');
	}
	
	public function editAdvert($id){
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true){		
			if( $id != NULL ){
				$data['advert_id'] = $id;
				$data['title'] = "Advertisement";
				//$data['details'] = $this->query_model->getbyId("tblfeaturedprogram", $this->uri->segment(4));		
				
				$query = $this->db->get_where('tblfeaturedprogram', array('id' => $id));
				$data['detail'] = $query->row_array();
		
				if(count($_POST)>0 && isset($_POST['update'])):
				
					$this->featuredprogram_model->updateAdvert();
					
					redirect($base_url.'admin/featuredprograms');
				endif;
				$this->load->view("admin/advert_edit", $data);
			}else{
				redirect("admin/featured_index");
			}
		}else{
			redirect("admin/login");
		}
	}
	
	function getProgram(){
		
		$program_id = $_POST['program_id'];
		
		$query = $this->db->get_where('tblprogram', array('id' => $program_id));
		$programs = $query->result();
		
		//echo '<pre>'; print_r($programs[0]); echo '</pre>';
		
		$data['name'] = $programs[0]->program;
		$data['ages'] = $programs[0]->ages;
		$data['photo'] = $programs[0]->photo;
		
		echo json_encode($data);
		
	}
	
	
	function getProgramCategory(){
		
		$cat_id = $_POST['program_cat_id'];
		$query = $this->db->get_where('tblcategory', array('cat_id' => $cat_id));
		$programs_category = $query->result();
		
		//echo '<pre>'; print_r($programs_category[0]->cat_name); echo '</pre>'; die;
		
		$datas['name'] = $programs[0]->cat_name;
		
		
		echo json_encode($datas);
		
	}
	
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
	
			$this->db->query("UPDATE `tblfeaturedprogram` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function deleteitem(){
		
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		$id = $_POST['delete-item-id'];
		
		$query = $this->db->get_where('tblfeaturedprogram', array('id' => $id));
		$programs = $query->row();
		
		@unlink('upload/featuredprograms/'.$programs->photo);
		@unlink('upload/featuredprograms/thumb/'.$programs->photo);

		$this->db->where("id", $id);
		if($this->db->delete("tblfeaturedprogram"))
		{
			redirect($base_url.'admin/featuredprograms');
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete item');</script>";
			redirect($this->index());
		}
	}
	
	public function deleteadvert(){
		
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		$id = $_POST['delete-advert-id'];
		
		$query = $this->db->get_where('tbladvert', array('id' => $id));
		$programs = $query->row();
		
		@unlink('upload/advert/'.$programs->photo);
		@unlink('upload/advert/thumb/'.$programs->photo);

		$this->db->where("id", $id);
		if($this->db->delete("tbladvert"))
		{
			redirect($base_url.'admin/featuredprograms');
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete item');</script>";
			redirect($this->index());
		}
	}
	
	public function sortadvert(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
	
			$this->db->query("UPDATE `tbladvert` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tblfeaturedprogram", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
}