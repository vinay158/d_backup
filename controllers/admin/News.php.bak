<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }		
		$this->load->model("news_model");
	}
	
	public function index()
	{
		redirect("admin/news/view");
	}
	
	public function view($page = 1){
	ob_start();
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "News";
			$data['link_type'] = "news";
			/*$this->db->order_by("timestamp 	", "DESC");
			$data['staff'] = $this->query_model->getbyTable("tblnews");
			$this->load->view("admin/news_index", $data);*/

			// Get News Page title from tbl_studentpagetitle
				$this->db->where('id', 2);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
					
			
			
			//** Pagination ** //
		
		$config = array();
	
		$config['per_page']= 15;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/news/view/'; 
		
		$config['total_rows'] = $this->pagination_model->record_count('tblnews');
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		$this->db->order_by('pos', 'ASC');
		$this->db->select(array('id','title','image','published'));
		$data['staff'] = $this->pagination_model->fetch_data('tblnews',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		
		//echo '<pre>data'; print_r($data); die;
		//echo '<pre>';print_r($config['total_rows']);
		$this->load->view('admin/news_index',$data);			
			// ** </code> ** //
			
		}
		else{
		redirect("admin/login");
		}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "News";
			$data['link_type'] = "news";
			
			if(isset($_POST['update'])):
				$this->news_model->addNews();
			endif;
			
			$this->load->view("admin/news_add", $data);
		}
		else{
			redirect("admin/login");
		}
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
	if(!empty($is_logged_in) && $is_logged_in == true){
		if($this->uri->segment(4) != NULL){
		$data['title'] = "News";
		$data['news_id']=$this->uri->segment(4);
		$data['details'] = $this->news_model->getNewsById($this->uri->segment(4));
			
			if(isset($_POST['update'])):
				$this->news_model->updateNews();
			endif;
		$this->load->view("admin/news_edit", $data);
		}else{
			redirect($this->index());
		}
	}else{
	redirect("admin/login");}
	}

	
	public function publish(){
	$id = $_POST['pub_id'];
	$pub = $_POST['publish_type'];
	//$id = 1;
	//$pub = 1;
	$this->db->where("id", $id);
	if($this->db->update("tblnews", array("published" => $pub)))
	{	
		echo 1;
		
	}
	}
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblnews"))
	{
	redirect($this->index());
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
	redirect($this->index());
	}
	}
	
	
	public function delete(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['news_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblnews set image='' where id=".$id.""))
			{	
				$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);					
				echo 1;
			}
			else
			{
				echo 0;
			}
		}else{
				echo 0;
		}
	}

	public function sortthis(){		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
			echo "UPDATE `tblnews` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'";
			 
			$this->db->query("UPDATE `tblnews` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
}