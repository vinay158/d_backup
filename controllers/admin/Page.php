<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('blog_model');
	}
	
	public function index()
	{
		redirect("admin/page/view");
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Page";
			$data['link_type'] = "page";
			
			if(isset($_POST['update'])) {
				
				$title = !empty($_POST['title']) ? trim($_POST['title']) : '';
				$slug = !empty($_POST['slug']) ? trim($_POST['slug']) : trim($_POST['title']);
				$description = !empty($_POST['description']) ? $_POST['description'] : '';
				$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : '{school_name} | '.$title;
				$meta_desc = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '{school_name} | '.$title;
				$page_layout = !empty($_POST['page_layout']) ? $_POST['page_layout'] : 'default';
				$body_class = !empty($_POST['body_class']) ? $_POST['body_class'] : '';
				$is_display = 0;
				
				
				$slug = slugify($slug);
					
				$data = array(
							'title' => $title,
							'slug' => $slug,
							'description' => $description,
							'meta_title' => $meta_title,
							'meta_desc' => $meta_desc,
							'is_display' => $is_display,
							'page_layout' => $page_layout,
							'body_class' => $body_class,
							);
				
				
				if($this->query_model->insertData("tbl_static_pages", $data)):
					redirect("admin/page/view");
				endif;
			}
			
			$this->load->view("admin/page_add", $data);
		}
		else{
			redirect("admin/login");
		}
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$this->db->where("id",$this->uri->segment(4));
		$data['title'] = 'Page';
		$data['detail'] = $this->db->get("tbl_static_pages")->result();
		
		
		
			if(isset($_POST['update'])) {
				
				$title = !empty($_POST['title']) ? trim($_POST['title']) : '';
				$slug = !empty($_POST['slug']) ? trim($_POST['slug']) : trim($_POST['title']);
				$description = !empty($_POST['description']) ? $_POST['description'] : '';
				$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : '{school_name} | '.$title;
				$meta_desc = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '{school_name} | '.$title;
				$page_layout = !empty($_POST['page_layout']) ? $_POST['page_layout'] : 'default';
				//$is_display = 0;
				$body_class = !empty($_POST['body_class']) ? $_POST['body_class'] : '';
				
				
				$slug = slugify($slug);
					
				$data = array(
							'title' => $title,
							'slug' => $slug,
							'description' => $description,
							'meta_title' => $meta_title,
							'meta_desc' => $meta_desc,
							'page_layout' => $page_layout,
							'body_class' => $body_class,
							);
				
				
				if($this->query_model->update("tbl_static_pages",$this->uri->segment(4),$data)):
					redirect("admin/page/view");
				endif;
			}
			
			
		$this->load->view("admin/page_edit", $data);
		
		
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	public function view($page = 1){
		
	ob_start();
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Pages";
			$data['link_type'] = "page";
			
			//** Pagination ** //
		
		$config = array();
	
		$config['per_page']= 15;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/page/view/'; 
		
		$this->db->where_not_in('id', array(1,2,3));
		$config['total_rows'] = $this->pagination_model->record_count('tbl_static_pages');
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		$this->db->order_by('id', 'desc');
		$this->db->where_not_in('id', array(1,2,3));
		$this->db->select(array('id','title','slug','page_layout','is_display'));
		$data['staff'] = $this->pagination_model->fetch_data('tbl_static_pages',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		//echo '<pre>';print_r($data); die;
		$this->load->view('admin/page_index',$data);			
			// ** </code> ** //
			
		}
		else{
		redirect("admin/login");
		}
	}
	
	public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tbl_static_pages", array("is_display" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tbl_static_pages"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete page');</script>";
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
			$args = array("cat_name" => $title, "cat_type" => "page", "permission" => $shared);
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
			$args = array("cat_name" => $title, "cat_type" => "page", "permission" => $shared);
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
	
	/*public function uploadPhoto(){
		if(isset($_POST['submit'])):
			$data_count = $this->query_model->getFacilityData();
			if(count($data_count)<8){
				$image = $_FILES['userfile']['name'];
				$table = 'tblaboutfacilityphoto';
				if(!empty($image)){
						$this->load->model('upload_model');
						$path = "upload/facility/";
					if($a = $this->upload_model->upload_image($path)){
						$data = array(
						'photo' => $a,
						);
					if($this->query_model->insertDataFacility($table,$data)): 
						redirect("admin/about/facility");
					endif;
				  }
				}
			}else{
				echo "<script language='javascript'>alert('Oops! You already have uploaded the maximum amount of 8 photos.');</script>";
				echo "<script language='javascript'>window.location = '../about/facility';</script>";
				//redirect("admin/about/facility");				
			}
		endif;
	}*/
	
	
	public function privacy_policy(){
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = 'Privacy Policy';
			
			$data['detail'] = $this->query_model->getBySpecific('tbl_static_pages','id',1);
			
			if(isset($_POST['update'])) {
				
				$title = !empty($_POST['title']) ? trim($_POST['title']) : '';
				$slug = !empty($_POST['slug']) ? trim($_POST['slug']) : trim($_POST['title']);
				$description = !empty($_POST['description']) ? $_POST['description'] : '';
				$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : '';
				$meta_desc = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '';
				
				
				$slug = slugify($slug);
					
				$data = array(
							'title' => $title,
							'slug' => $slug,
							'description' => $description,
							'meta_title' => $meta_title,
							'meta_desc' => $meta_desc,
							);
				
				
				if($this->query_model->update("tbl_static_pages", 1, $data)):
					redirect("admin/page/privacy_policy");
				endif;
			}else{
				$this->load->view("admin/privacy_policy", $data);
			}
					
		}else{
			redirect('admin/login');
		}
	}
	
	
	
	public function terms_conditions(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = 'Terms and Conditions';
			
			$data['detail'] = $this->query_model->getBySpecific('tbl_static_pages','id',2);
			
			if(isset($_POST['update'])) {
				$title = !empty($_POST['title']) ? trim($_POST['title']) : '';
				$slug = !empty($_POST['slug']) ? trim($_POST['slug']) : trim($_POST['title']);
				$description = !empty($_POST['description']) ? $_POST['description'] : '';
				$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : '';
				$meta_desc = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '';
				
				
				$slug = slugify($slug);
					
				$data = array(
							'title' => $title,
							'slug' => $slug,
							'description' => $description,
							'meta_title' => $meta_title,
							'meta_desc' => $meta_desc,);
				
				
				if($this->query_model->update("tbl_static_pages", 2, $data)):
					redirect("admin/page/terms_conditions");
				endif;
			}else{
				$this->load->view("admin/terms_conditions", $data);
			}
					
		}else{
			redirect('admin/login');
		}
	}
	
	
	function get_unique_slug($slug, $id=''){
		
		$this->load->helper('string');
		
		$query = $this->db->get_where('tbl_static_pages', array('slug' => $slug));
		
		if($query->num_rows() > 0){			
			$row = $query->row_object();
			if($id)
				$slug = $slug.'-'.$id;
			else{
				$rand = random_string('numeric', 3);
				$slug = $slug.'-'.$rand;					
			}
			return $slug;
		}else{
			return $slug;
		}		
	}
  	
	
	public function faqs(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = 'FAQs';
			$data['link_type'] = 'programs';
			
			$this->db->order_by('pos asc, id desc');
			$this->db->select(array('id','title','published','pos'));
			$data['programFaqs'] = $this->query_model->getbyTable('tbl_program_faqs');
			//echo '<pre>data'; print_r($data); die;
			$this->load->view("admin/faqs_index", $data);
					
		}else{
			redirect('admin/login');
		}
		
		
		
	}
	
	
	
	
	
	
	public function career_opportunities(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = 'Career Opportunities';
			
			$data['detail'] = $this->query_model->getBySpecific('tbl_static_pages','id',3);
			
			$menuPageCareerId = '';
			if(!empty($data['detail'])){
				
				$this->db->where('menu_id',3);
				$data['menuPageCareer'] =  $this->query_model->getBySpecific('tblmenupages','slug',$data['detail'][0]->slug);
				
				$menuPageCareerId = !empty($data['menuPageCareer']) ? $data['menuPageCareer'][0]->id : '';
			}
			
			
			if(isset($_POST['update'])) {
				$is_display = (isset($_POST['is_display']) && !empty($_POST['is_display'])) ? $_POST['is_display'] : 0;
				$title = !empty($_POST['title']) ? trim($_POST['title']) : '';
				$slug = !empty($_POST['slug']) ? trim($_POST['slug']) : trim($_POST['title']);
				$description = !empty($_POST['description']) ? $_POST['description'] : '';
				$terms_conditions = !empty($_POST['terms_conditions']) ? $_POST['terms_conditions'] : '';
				$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : '';
				$meta_desc = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '';
				
				
				$slug = slugify($slug);
					
				$data = array(
							'title' => $title,
							'is_display' => $is_display,
							'slug' => $slug,
							'description' => $description,
							'terms_conditions' => $terms_conditions,
							'meta_title' => $meta_title,
							'meta_desc' => $meta_desc,
							);
				
				
				if($this->query_model->update("tbl_static_pages", 3, $data)):
				
					$updateMeta = array(
										'slug' => $slug,
										'url' => $slug,
										'page_label' => $title,
										'keywords' => $title,
										);
					$this->query_model->update("tblmeta", 53, $updateMeta);
					
					if(!empty($menuPageCareerId)){
						$updateMenuPage = array(
										'slug' => $slug,
										);
						$this->query_model->update("tblmenupages", $menuPageCareerId, $updateMenuPage);
					}
					redirect("admin/page/career_opportunities");
				endif;
			}else{
				$this->load->view("admin/career_opportunities", $data);
			}
					
		}else{
			redirect('admin/login');
		}
	}
	
	
	
}