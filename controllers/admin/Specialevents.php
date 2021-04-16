<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class specialEvents extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('specialevent_model');
	}
	
	public function index()
	{
		redirect('admin/specialevents/view/27');
	}
	
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
	
			$this->db->query("UPDATE `tblspecialevents` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function sortcategory(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tblcategory` SET `pos`=" . $i . " WHERE `cat_id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function edit(){
	
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		$data['special_prog_hide']=1;
		
		if(!empty($is_logged_in) && $is_logged_in == true){
		
			$spl_data = $this->db->query("select `special_name` from `tblspecialoffer` where featured_on_off ='on'") or die(mysqli_error($this->db->conn_id));
			$spl_data = $spl_data->result();
		
			if(is_array($spl_data) && count($spl_data)>0){
				if($spl_data[0]->special_name){
					$data['special_prog_hide']=0;
				}
			}
			
			if( $this->uri->segment(4) != NULL ){							 
				$data['title'] = "Our Special Events";
				$data['cat'] = $this->query_model->getSpecialEventCategory("specialevent");		
				$data['details'] = $this->query_model->getbyId("tblspecialevents", $this->uri->segment(4));
				
				if(isset($_POST['update'])):			
					$this->specialevent_model->updateSpecialEvent();
				endif;		
				$this->load->view("admin/specialevent_edit", $data);
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
			$data['title'] = "Our Special Events";
		 	$data['cat'] = $this->query_model->getSpecialEventCategory("specialevent");		
		  
			if(isset($_POST['update'])):
				$this->specialevent_model->addSpecialEvent();
			endif;
			$this->load->view("admin/specialevent_add", $data);
		
		}else{
			redirect("admin/login");
		}
	}
	
	
	public function view(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Our Special Events';
			$data['link_type'] = 'specialevents';		
			$data['cat'] = $this->query_model->getSpecialEventCategory("specialevent");		
			$this->db->order_by("pos", "ASC");
			$data['blogs'] = $this->query_model->getbySpecific("tblspecialevents", "category", $this->uri->segment(4));
			$this->load->view("admin/specialevent_index", $data);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	public function deleteCategory(){
		$id = $_POST['delete-id'];
		$this->db->where("cat_id", $id);	
		if($this->db->delete("tblcategory"))
		{		
			$this->db->query("delete from tblspecialevents where category='".$id."'") or die(mysqli_error($this->db->conn_id));	
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
				$args = array("cat_name" => $title, "meta_desc" => $meta_desc, "cat_type" => "specialevent", "permission" => $shared);
				$data = $this->query_model->getSpecialEventCategory("specialevent");
				if(count($data)<4){
					if($this->query_model->addCategory($args)){
						redirect($this->index());
					}
					else
					{	
						echo "<script language='javascript'>alert('Unable to add category');</script>";
						redirect($this->index());
					}
				}else{
					
					/*echo "<script language='javascript'>alert('Unable to add category');</script>";*/
					echo "<script language='javascript'>alert('Sorry! Only a 4 Sepecial Event categories can be added');</script>";
					echo "<script language='javascript'>window.location = 'view/27';</script>";
					//redirect("admin/programs/view/27");
				}
			}
			elseif( $operation == 'edit' )
			{
				$args = array("cat_name" => $title, "meta_desc" => $meta_desc, "cat_type" => "specialevent", "permission" => $shared );
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
	
	public function deleteitem(){
		$id = $_POST['delete-item-id'];
		$this->db->where("id", $id);
		if($this->db->delete("tblspecialevents"))
		{
			if($_POST['category_loc']){
				redirect("admin/specialevents/view/".$_POST['category_loc']);
			}else{
				redirect("admin/specialevents");
			}		
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete category');</script>";
			if($_POST['category_loc']){
					redirect("admin/specialevents/view/".$_POST['category_loc']);
				}else{
					redirect("admin/specialevents");
				}
			}
	}
	
	public function delete(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['specialevent_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblspecialevents set photo='', homepageImage='' where id=".$id.""))
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