<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Downloads extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('download_model');
	}
	
	public function index()
	{
		redirect('admin/downloads/view/60');
	}
	
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
	
			$this->db->query("UPDATE `tbldownloads` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
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
		
		/*$spl_data=$this->db->query("select `id` from `tblspecialoffer` where featured_on_off ='on'") or die(mysqli_error($this->db->conn_id));
		$spl_data=$spl_data->result();
		
		if(is_array($spl_data) && count($spl_data)>0){
			if($spl_data[0]->id){
				$data['special_prog_hide']=0;
			}
		}*/
	if( $this->uri->segment(4) != NULL ){							 
		$data['title'] = "Our Programs";
		$data['cat'] = $this->query_model->getCategory("downloads");		
		$data['details'] = $this->query_model->getbyId("tbldownloads", $this->uri->segment(4));
		
		$this->db->select('download_thread');
			$data['is_download_thread'] = $this->query_model->getByTable('tblsite');
			$data['is_download_thread'] = 	$data['is_download_thread'][0]->download_thread;
		
		if(isset($_POST['update'])):			
			$this->download_model->updateDownload();			
		endif;		
		$this->load->view("admin/download_edit", $data);
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
		$data['title'] = "Our Downloads";
		 $data['cat'] = $this->query_model->getCategory("downloads");
		 
		 $this->db->select('download_thread');
			$data['is_download_thread'] = $this->query_model->getByTable('tblsite');
			$data['is_download_thread'] = 	$data['is_download_thread'][0]->download_thread;
		  
			if(isset($_POST['update'])):
				$this->download_model->addDownload();
			endif;
		$this->load->view("admin/download_add", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Our Downloads';
			$data['link_type'] = 'downloads';
			
			
			$this->db->select(array('cat_id','cat_name'));
			$this->db->where("cat_type", "downloads");
			$data['category_detail'] = $this->query_model->getbySpecific('tblcategory',"cat_id",$this->uri->segment(4));
			
			if(empty($data['category_detail'])){
				$this->db->select(array('cat_id','cat_name'));
				$this->db->limit(1);
				$this->db->order_by("pos", "ASC");
				$this->db->where("cat_type", "downloads");
				$data['category_detail'] = $this->query_model->getbyTable('tblcategory');
				
			}
			
			$this->db->select(array('cat_id','cat_name','cat_slug','published','parent_id','permission'));
			$this->db->order_by("pos", "ASC");
			$data['cat'] = $this->query_model->getBySpecific('tblcategory','cat_type', "downloads");
			//$data['cat'] = $this->query_model->getCategory("downloads");
			$this->db->order_by('pos asc, id desc');
			$data['downloads'] = $this->query_model->getbySpecific("tbldownloads", "category", $data['category_detail'][0]->cat_id);

			$this->db->select('download_thread');
			$data['is_download_thread'] = $this->query_model->getByTable('tblsite');
			$data['is_download_thread'] = 	$data['is_download_thread'][0]->download_thread;
			
			// Get Downloads Page title from tbl_studentpagetitle
			$this->db->where('id', 4);
			$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
			//echo '<pre>data'; print_r($data); die;
			$this->load->view("admin/download_index", $data);
		
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
			$this->db->query("delete from tbldownloads where category='".$id."'") or die(mysqli_error($this->db->conn_id));	
			redirect($this->index());
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete category');</script>";
			redirect($this->index());
		}
	}
	
	public function operateCategory(){
		
		//echo '<pre>'; print_r($_POST); die;
		$title = $_POST['name'];
		
		$operation = $_POST['operation'];
		$id = $_POST['edit_id'];
		$parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
		if(isset($_POST['shared']) && !empty($_POST['shared'])){
				$shared = $_POST['shared'];
		}else{
			$shared = 0;
		}
		
		$save = $_POST['submit'];
		
		//echo $title." ".$operation." ".$id." "." ".$shared." ".$save;
		if(isset($save))
		{
			if( $operation == 'add' )
			{
				
				$args = array("cat_name" => $title, "cat_type" => "downloads", "permission" => $shared,'parent_id'=>$parent_id);
				$data = $this->query_model->getCategory("downloads");
				if($this->query_model->addCategory($args)){
				redirect($this->index());
				}
				else
				{	
					echo "<script language='javascript'>alert('Unable to add category');</script>";
					redirect($this->index());
				}
				/*if(count($data)<4){
					if($this->query_model->addCategory($args)){
					redirect($this->index());
					}
					else
					{	
						echo "<script language='javascript'>alert('Unable to add category');</script>";
						redirect($this->index());
					}
				}else{
					
					echo "<script language='javascript'>alert('Sorry! Only a 4 program categories may be added');</script>";
					echo "<script language='javascript'>window.location = 'view/27';</script>";
					//redirect("admin/programs/view/27");
				} */
			}
			elseif( $operation == 'edit' )
			{
				$args = array("cat_name" => $title, "cat_type" => "downloads", "permission" => $shared,'parent_id'=>$parent_id );
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
	//echo $id; die;
	$this->db->where("id", $id);
	if($this->db->delete("tbldownloads"))
	{
		if($_POST['category_loc']){
			redirect("admin/downloads/view/".$_POST['category_loc']);
		}else{
			redirect("admin/downloads");
		}		
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
		if($_POST['category_loc']){
				redirect("admin/downloads/view/".$_POST['category_loc']);
			}else{
				redirect("admin/downloads");
			}
		}
	}
	
	
	public function download_delete(){
		$id = $_POST['delete-item-id'];
		//echo '<pre>'; print_r($_POST); die;
		$category_id = $_POST['category_loc'];
		$this->db->where("id", $id);
		if($this->db->delete("tbldownloads"))
		{
			if($_POST['category_loc']){
				redirect("admin/downloads/view/".$_POST['category_loc']);
			}else{
				redirect("admin/downloads");
			}
		}
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
			
			if($this->db->query("update tbldownloads set files='' where id=".$id.""))
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
		

	
	function getCategory(){
		
		$cat_id = $_POST['cat_id'];
		
		$query = $this->db->get_where('tblcategory', array('cat_id' => $cat_id));
		$categories = $query->result();
		
		//echo '<pre>'; print_r($categories[0]); echo '</pre>'; die;
		
		$data['cat_name'] = $categories[0]->cat_name;
		
		
		echo json_encode($data);
		
	}
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tbldownloads", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	

	
	
	public function download_cat_add(){
			$is_logged_in = $this->session->userdata('is_logged_in');
		
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
				$data['title'] = 'Our Download Category';
				$data['link_type'] = 'downloads';		
				
				$this->load->view("admin/download_cat_add", $data);
				
				
			if(isset($_POST['update'])){	
				$cat_data['cat_name'] = $_POST['name'];
				$cat_data['meta_title'] = $_POST['meta_title'];
				$cat_data['meta_desc'] = $_POST['meta_desc'];
				$cat_data['cat_type'] = 'downloads';
				
								
				if($this->query_model->addCategory($cat_data)){
				redirect($this->index());
				}
				else
				{	
					echo "<script language='javascript'>alert('Unable to add category');</script>";
					redirect($this->index());
				}
			
			}
			
			}else
			{
				redirect('admin/login');
			}
	}
	
	
	public function download_cat_edit(){
		$cat_id = $this->uri->segment(4);
		$query = $this->db->get_where('tblcategory', array('cat_id' => $cat_id));
		$data['categories'] = $query->result();
		
		if(isset($_POST['update'])){
				$cat_data['cat_name'] = $_POST['name'];
				$cat_data['meta_title'] = $_POST['meta_title'];
				$cat_data['meta_desc'] = $_POST['meta_desc'];
				$cat_data['published'] = $_POST['published'];
				$cat_data['cat_type'] = 'downloads';
				
				$this->db->where("cat_id",$cat_id);
				if($this->query_model->editCategory($cat_data)){
				redirect($this->index());
				}
				else
				{	
					echo "<script language='javascript'>alert('Unable to add category');</script>";
					redirect($this->index());
				}
			
		}
		$this->load->view("admin/download_cat_edit", $data);
		
	}
	
	
	public function download_cat_delete($id = null){
		
		$id = $this->uri->segment(4);
		$this->db->where("cat_id", $id);	
		if($this->db->delete("tblcategory"))
		{		
			$this->db->query("delete from tbldownloads where category='".$id."'") or die(mysqli_error($this->db->conn_id));	
			redirect('admin/downloads');
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete category');</script>";
			redirect('admin/downloads');
		}
	}
	
	
	
	
		public function ajax_delete_popup_record(){
		
				parse_str($_POST['formData'], $searcharray);
				//echo '<pre>searcharray'; print_r($searcharray); die;
				$id = isset($searcharray['delete-item-id']) ? $searcharray['delete-item-id'] : 0;
				$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
				
				if(!empty($id) && !empty($table_name)){
					
					if($table_name == "tblcategory"){
						$this->db->where("cat_id", $id);
					}else{
						$this->db->where("id", $id);
					}
					
					if($this->db->delete($table_name))
					{
						if($table_name == "tblcategory"){
							$this->query_model->deletebySpecific('tbldownloads','category',$id);
						}
						
						echo 1;
					}
					else
					{
						echo 0;
					}
				}else{
					echo 1;
				}
				
				exit();	
	}
	
	public function ajaxPublishWebhookApi(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		$table_name = $_POST['table_name'];
		$this->db->where("id", $id);
		if($this->db->update($table_name, array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	public function ajax_full_alternate_popup(){
		
		if(isset($_POST['action_type']) && !empty($_POST['action_type'])){
			$records = array();
			$records['detail'] = array();
			$records['action_type'] = $_POST['action_type'];
			$records['item_id'] = $_POST['item_id'];
			$records['table_name'] = $_POST['table_name'];
			$records['form_type'] = $_POST['form_type'];
			$records['link_type'] = 'downloads';
			
			if($records['action_type'] == "edit" && !empty($records['item_id'])){
				
				$this->db->where("cat_id", $records['item_id']);
				$this->db->select(array('cat_id','cat_name','cat_type','color','published','permission','parent_id'));
				$detail = $this->query_model->getbyTable($records['table_name']);
				if(!empty($detail)){
					
					$records['detail'] = $detail[0];
					
				}
			}
			
			//echo '<pre>records'; print_r($records); die;
			$this->load->view("admin/ajax_downloads_category_form", $records);
			
			
		}
	}
	
	
	public function ajax_save_full_alternate_row(){
		
		parse_str($_POST['formData'], $searcharray);
		//echo '<pre>searcharray'; print_r($_POST); die;
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['update'])){
				
				$item_id = isset($searcharray['item_id']) ? $searcharray['item_id'] : '';
				$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
				$form_type = isset($searcharray['form_type']) ? $searcharray['form_type'] : '';
					
					$postData['cat_name'] = isset($searcharray['name']) ? trim($searcharray['name']) : '';
					$postData['cat_type'] = isset($searcharray['cat_type']) ? trim($searcharray['cat_type']) : '';
					$postData['color'] = isset($searcharray['color']) ? trim($searcharray['color']) : '';
					$postData['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
					$postData['permission'] = 1;
					$postData['parent_id'] = isset($searcharray['parent_id']) ? $searcharray['parent_id'] : 0;
					
					
					
				if(!empty($item_id)){
					
					$this->query_model->updateData($table_name,'cat_id',$item_id, $postData);
					$insert_id = $item_id;
					$result['form_action'] = 'edit';
				}else{
					$this->query_model->insertData($table_name, $postData);
					$insert_id = $this->db->insert_id();
					$result['form_action'] = 'add';
				}
				
					
					$result['res'] = 1;
					$result['id'] = $insert_id;
					$result['title'] = $postData['cat_name'];
					$result['form_type'] = $form_type;
					$result['table_name'] = $table_name;
					$result['photo_side'] = '';
					
				
			}
		echo json_encode($result); 	
	}
	
	
	
}