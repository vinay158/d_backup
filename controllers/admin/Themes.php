<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Themes extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('themes_model');
	}
	
	public function index()
	{
		redirect('admin/themes/view');
	}
	
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
	
			$this->db->query("UPDATE `tblthemes` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function sortcategory(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tblthemes` SET `pos`=" . $i . " WHERE `cat_id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	
	public function edit(){
	
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!empty($is_logged_in) && $is_logged_in == true){
		
	if( $this->uri->segment(4) != NULL ){							 
		$data['title'] = "Edit Themes";
		
		$data['details'] = $this->query_model->getbyId("tblthemes", $this->uri->segment(4));
		$data['details'] = $data['details'][0];
		
		if(isset($_POST['update'])):
						
			$this->themes_model->updateTheme();			
		endif;		
		$this->load->view("admin/theme_edit", $data);
	}else{
		redirect($this->index());
	}
	}else{
	redirect("admin/login");
	}
	}
	
	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$data['title'] = "Add Themes";
		  
			if(isset($_POST['update'])):
				$this->themes_model->addTheme();
			endif;
			
			$this->load->view("admin/theme_add", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Themes';
			
			$data['link_type'] = 'themes';	
			$data['user_level']=$this->session->userdata['user_level'];	
			
			$data['themes'] = $this->query_model->getbyTable("tblthemes");
			
			$this->load->view("admin/theme_index", $data);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
	public function deleteitem(){
		$id = $_POST['delete-item-id'];
	
	$this->db->where("id", $id);
	if($this->db->delete("tblthemes"))
	{
		redirect("admin/themes");	
	}
	}
	
	
	public function selectMainTheme(){
		$id = $_POST['theme_id'];
		
		$data['themes'] = $this->query_model->getbyTable('tblthemes');
		//echo '<pre>'; print_r($data['themes']); die;
		
		foreach($data['themes'] as $themes){
			
			if($themes->id == $id){
				$this->db->where("id", $themes->id);
				$this->db->update("tblthemes", array("main_theme" => 1));
			}else{
				$this->db->where("id", $themes->id);
				$this->db->update("tblthemes", array("main_theme" => 0));
			}	
		} 
		/*$message = 'Successfully change main location.';
		echo $message;*/  die;
		
	}
	
	
	public function delete(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tbldownloads set photo='' where id=".$id.""))
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
		
		
	public function delete_files(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblthemes set files='' where id=".$id.""))
			{	
							
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
		

	
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tblthemes", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	
	
	
}