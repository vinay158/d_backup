<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Programs extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('program_model');
	}
	
	public function index()
	{
		
		redirect('admin/programs/view/27');
	}
	
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
	
			$this->db->query("UPDATE `tblprogram` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
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
	
		$data['user_level']=$this->session->userdata['user_level'];
		
		/*$spl_data=$this->db->query("select `id` from `tblspecialoffer` where featured_on_off ='on'") or die(mysqli_error($this->db->conn_id));
		$spl_data=$spl_data->result();
		
		if(is_array($spl_data) && count($spl_data)>0){
			if($spl_data[0]->id){
				$data['special_prog_hide']=0;
			}
		}*/
	if( $this->uri->segment(4) != NULL ){							 
		$data['title'] = "Our Programs";
		$data['link_type'] = "programs";
		
		$this->db->order_by("pos", 'asc');
		$this->db->select(array('cat_id','cat_name','pos'));
		$data['cat'] = $this->query_model->getbySpecific("tblcategory",'cat_type','programs');
		
		$data['details'] = $this->query_model->getbyId("tblprogram", $this->uri->segment(4));
		
		$data['stand_pages'] = $this->query_model->getbySpecific("tblstandpage",'program_id',$this->uri->segment(4));
		//$data['site_setting'] = $this->query_model->getbyTable('tblsite');
		
		$this->db->select(array('s_no','logo_name'));
		$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
		
		$this->db->order_by("pos", 'asc');
		$this->db->where('program_id',$this->uri->segment(4));
		$this->db->select(array('id','program_id','title','cat_id','photo_side','published','pos'));
		$data['programRows'] = $this->query_model->getbyTable('tbl_program_rows');
		
		$this->db->order_by("pos", 'asc');
		$this->db->where('program_id',$this->uri->segment(4));
		$this->db->select(array('id','program_id','title','cat_id','photo_side','published','pos'));
		$data['programLittleRows'] = $this->query_model->getbyTable('tbl_program_little_rows');
		
		$this->db->order_by("pos", 'asc');
		$this->db->where("published", 1);
		//$this->db->where('program_id',$this->uri->segment(4));
		$this->db->select(array('id','title','title_2','published','pos'));
		$data['programFaqs'] = $this->query_model->getbyTable('tbl_program_faqs');
		
		
		
		$this->db->order_by("pos", 'asc');
		$this->db->where('program_id',$this->uri->segment(4));
		$this->db->select(array('id','section','published','program_id','pos'));
		$data['programSections'] = $this->query_model->getbyTable('tbl_program_sections');
		
		$this->db->order_by('id', 'desc');
		$this->db->where("published", 1);
		$this->db->select(array('id','title','name','published'));
		$data['testimonials'] = $this->query_model->getbyTable("tbltestimonials");
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
		$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
		$this->db->order_by("pos", 'asc');
		$this->db->where('status',1);
		if($isUniqueSpecialOffer == 1){
			$this->db->where("type", "trial_offer");
			$this->db->select(array('id','name','pos','status','type'));
		}else{
			$this->db->select(array('id','name','pos','status'));
		}
		
		$data['trialCategories'] = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
		
		$this->db->where('published',1);
		$this->db->select(array('id','product_title'));
		$data['dojocarts'] = $this->query_model->getbyTable('tbl_dojocarts');
		
		$this->db->where('status',1);
		$this->db->select(array('id','title'));
		$data['thankyou_pages'] = $this->query_model->getbyTable('tbl_form_thankyou_pages');
		
		
		
		/* Leanding page**/
		/*$this->db->group_by('program_id');
		$data['leanding_programs'] = $this->query_model->getbyTable('tblstandpage');
		$program_lists = array();
		foreach($data['leanding_programs'] as $leanding_programs){
			$programs = $this->query_model->getbySpecific('tblprogram', 'id', $leanding_programs->program_id);
			if(!empty($programs)){
				$program_lists[] = $programs;
			}
		}
		$data['stand_programs'] = $program_lists;
		*/

		$this->db->where("published", 1);
		$this->db->select(array('category','id','landing_checkbox','landing_program','landing_page_url','program_slug','program','published'));
		$data['leanding_programs'] = $this->query_model->getbyTable('tblprogram');		
	
	
		
		$data['program_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 30);
		$data['program_slug'] = $data['program_slug'][0]->slug;
		
		
		$this->db->where("location_type !=", 'coming_soon_location');
			$this->db->where("published", 1);
			//$this->db->where("main_location", 0);
			//$this->db->group_by("city");
			$this->db->order_by("state","asc");
			$this->db->select(array('id','name','location_type','published','state'));
			$data['dojo_cart_allLocations'] = $this->query_model->getbyTable("tblcontact");	
		
		if(isset($_POST) && !empty($_POST)):	
				
			$this->program_model->updateProgram();			
		endif;		
		$this->load->view("admin/program_edit", $data);
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
		 $data['user_level']=$this->session->userdata['user_level'];
		 $data['title'] = "Our Programs";
		 
		 $this->db->order_by("pos", 'asc');
		 $this->db->select(array('cat_id','cat_name','pos'));
		 $data['cat'] = $this->query_model->getbySpecific("tblcategory",'cat_type','programs');
		
		// $data['site_setting'] = $this->query_model->getbyTable('tblsite');
		 
		 $this->db->select(array('s_no','logo_name'));
		 $data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
		
		$this->db->order_by('id', 'desc');
		$this->db->where("published", 1);
		$this->db->select(array('id','title','name','published'));
		$data['testimonials'] = $this->query_model->getbyTable("tbltestimonials");
		
		
		$this->db->select(array('redirection_type','trial_offer_id','dojocart_id','thankyou_page_id','third_party_url'));
		$data['cat_detail'] = $this->query_model->getBySpecific('tblcategory','cat_id',$this->uri->segment(4));
		//echo '<pre>'; print_r($data['cat_detail']); die;
		
		/* Leanding page**/
		/*$this->db->group_by('program_id');
		$data['leanding_programs'] = $this->query_model->getbyTable('tblstandpage');
		$program_lists = array();
		foreach($data['leanding_programs'] as $leanding_programs){
			$programs = $this->query_model->getbySpecific('tblprogram', 'id', $leanding_programs->program_id);
			if(!empty($programs)){
				$program_lists[] = $programs;
			}
		} 
		$data['stand_programs'] = $program_lists; */
		
		$this->db->where("published", 1);
		$this->db->select(array('category','id','landing_checkbox','landing_program','landing_page_url','program_slug','program','published'));
		$data['leanding_programs'] = $this->query_model->getbyTable('tblprogram');	
		//echo '<pre>'; print_r($data['leanding_programs']); die;
		
		$data['program_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 30);
		$data['program_slug'] = $data['program_slug'][0]->slug;
		
		$this->db->order_by("pos", 'asc');
		$this->db->where("published", 1);
		//$this->db->where('program_id',$this->uri->segment(4));
		$this->db->select(array('id','title','title_2','published','pos'));
		$data['programFaqs'] = $this->query_model->getbyTable('tbl_program_faqs');
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
		$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
		$this->db->order_by("pos", 'asc');
		$this->db->where('status',1);
		if($isUniqueSpecialOffer == 1){
			$this->db->where("type", "trial_offer");
			$this->db->select(array('id','name','pos','status','type'));
		}else{
			$this->db->select(array('id','name','pos','status'));
		}
		$data['trialCategories'] = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
		
		$this->db->where('published',1);
		$this->db->select(array('id','product_title'));
		$data['dojocarts'] = $this->query_model->getbyTable('tbl_dojocarts');
		
		$this->db->where('status',1);
		$this->db->select(array('id','title'));
		$data['thankyou_pages'] = $this->query_model->getbyTable('tbl_form_thankyou_pages');
		
		
			$this->db->where("location_type !=", 'coming_soon_location');
			$this->db->where("published", 1);
			//$this->db->where("main_location", 0);
			//$this->db->group_by("city");
			$this->db->order_by("state","asc");
			$this->db->select(array('id','name','location_type','published','state'));
			$data['dojo_cart_allLocations'] = $this->query_model->getbyTable("tblcontact");	
		//echo '<pre>'; print_r($data); die;
			if(isset($_POST) && !empty($_POST)):
				//echo '<pre>'; print_r($_POST); die;
				$this->program_model->addProgram();
			endif;
		$this->load->view("admin/program_add", $data);
		
		}else{
		redirect("admin/login");
		}
	}
	
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Our Programs';
			$data['link_type'] = 'programs';
			
			
			
			$this->db->select(array('cat_id','cat_name'));
			$data['category_detail'] = $this->query_model->getbySpecific('tblcategory',"cat_id",$this->uri->segment(4));
			
			if(empty($data['category_detail'])){
				$this->db->select(array('cat_id','cat_name'));
				$this->db->limit(1);
				$this->db->order_by("pos", "ASC");
				$data['category_detail'] = $this->query_model->getbySpecific('tblcategory',"cat_type","programs");
				
			}
			
			
			
			$this->db->select(array('cat_id','cat_name','cat_slug','cat_type','published'));
			$this->db->order_by("pos", "ASC");
			$data['cat'] = $this->query_model->getbySpecific('tblcategory',"cat_type","programs");
			
			
			
			$this->db->order_by("pos", "ASC");
			$this->db->select(array('id','program','program_slug','published','category'));
			$data['blogs'] = $this->query_model->getbySpecific("tblprogram", "category", $data['category_detail'][0]->cat_id);
			//echo '<pre>data'; print_r($data); die;
			$this->load->view("admin/program_index", $data);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
	public function operateCategory(){
		
		$title = $_POST['name'];
		$meta_title = $_POST['meta_title'];
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
				$args = array("cat_name" => $title, "meta_title" => $meta_title, "meta_desc" => $meta_desc, "cat_type" => "programs", "permission" => $shared);
				$data = $this->query_model->getCategory("programs");
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
					echo "<script language='javascript'>alert('Sorry! Only a 4 program categories may be added');</script>";
					echo "<script language='javascript'>window.location = 'view/27';</script>";
					//redirect("admin/programs/view/27");
				}
			}
			elseif( $operation == 'edit' )
			{
				$args = array("cat_name" => $title, "meta_title" => $meta_title, "meta_desc" => $meta_desc, "cat_type" => "programs", "permission" => $shared );
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
	
	public function delete_program_and_pro_cat(){
		
		parse_str($_POST['formData'], $searcharray);
		
		$id = isset($searcharray['delete-item-id']) ? $searcharray['delete-item-id'] : 0;
		$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
		$category_id = isset($searcharray['category_id']) ? $searcharray['category_id'] : '';
		
		$field_name = ($table_name == "tblcategory") ? 'cat_id' : 'id';
		
		if(!empty($id) && !empty($table_name)){
			$this->db->where($field_name, $id);
			if($this->db->delete($table_name))
			{
				
				if($table_name == "tblprogram"){
					
					$tables = array('tbl_program_faqs','tbl_program_rows','tbl_program_little_rows','tbl_program_sections');
					foreach($tables as $table){
						//$this->db->where('cat_id',$category_id);
						$this->query_model->deletebySpecific($table,'program_id', $id);
					}
				}elseif($table_name == "tblcategory"){
					
					$this->query_model->deletebySpecific('tblprogram','category', $id);
					
				}
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
		exit();
	}

	public function program_delete(){
		$id = $_POST['delete-item-id'];
		//echo '<pre>'; print_r($_POST); die;
		$category_id = $_POST['category_loc'];
		
		
			
		$this->db->where("id", $id);
		if($this->db->delete("tblprogram"))
		{
			$tables = array('tbl_program_faqs','tbl_program_rows','tbl_program_little_rows','tbl_program_sections');
			foreach($tables as $table_name){
				$this->db->where('cat_id',$category_id);
				$this->query_model->deletebySpecific($table_name,'program_id', $id);
			}
			
			if($_POST['category_loc']){
				redirect("admin/programs/view/".$_POST['category_loc']);
			}else{
				redirect("admin/programs");
			}
		}
	}
	
	
	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblprogram"))
	{
		if($_POST['category_loc']){
			redirect("admin/programs/view/".$_POST['category_loc']);
		}else{
			redirect("admin/programs");
		}		
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete category');</script>";
		if($_POST['category_loc']){
				redirect("admin/programs/view/".$_POST['category_loc']);
			}else{
				redirect("admin/programs");
			}
		}
	}
	
	public function delete(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['program_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblprogram set photo='', homepageImage='' where id=".$id.""))
			{	
				/**$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img); **/					
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
	
	
		
	public function delete_header_image(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['program_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblprogram set header_image='' where id=".$id.""))
			{	
				/**$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);**/			
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
	
		
		
	public function delete_userfile_2(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['program_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblprogram set image='' where id=".$id.""))
			{	
				/*$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);	*/				
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
	
	
	public function deleteImg(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['cat_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblcategory set header_photo='' where cat_id=".$id.""))
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
	
	
	
	public function deleteCatBackgroundImg(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['cat_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblcategory set background_image='' where cat_id=".$id.""))
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
	
	
	
	public function deleteCatActionBackgroundImg(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['cat_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblcategory set action_background_image='' where cat_id=".$id.""))
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
	
	
	
	
	public function deleteCatActionImages(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['cat_id'];
			$type = $_POST['type'];
			$this->db->where("id", $id);
			
			if($type == 1){
				$this->db->query("update tblcategory set action_image_1='' where cat_id=".$id."");
			}elseif($type == 2){
				$this->db->query("update tblcategory set action_image_2='' where cat_id=".$id."");
			}elseif($type == 3){
				$this->db->query("update tblcategory set action_image_3='' where cat_id=".$id."");
			}
			
			echo 1;
		}else{
				echo 0;
		}
	}
	
	
	
	public function deleteCatImgTextImage(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['cat_id'];
			$type = $_POST['type'];
			$this->db->where("id", $id);
			
			if($type == 1){
				$this->db->query("update tblcategory set img_text_image_1='' where cat_id=".$id."");
			}elseif($type == 2){
				$this->db->query("update tblcategory set img_text_image_2='' where cat_id=".$id."");
			}elseif($type == 3){
				$this->db->query("update tblcategory set img_text_image_3='' where cat_id=".$id."");
			}
			
			echo 1;
		}else{
				echo 0;
		}
	}
	
	
	
	public function delete_stand_page_img(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['stand_page_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblstandpage set stand_page_photo = 'Null' where id=".$id.""))
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
	
	
	
	public function delete_stand_page(){
		
		if(count($_POST)>0){		
										
			$id = $_POST['stand_page_id'];
			$this->db->where("id", $id);
			
			if($this->db->query("delete from tblstandpage where id=".$id.""))
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
		
		//echo '<pre>'; print_r($programs[0]); echo '</pre>';
		
		$data['cat_name'] = $categories[0]->cat_name;
		$data['meta_title'] = $categories[0]->meta_title;
		$data['meta_desc'] = $categories[0]->meta_desc;
		
		echo json_encode($data);
		
	}
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		//$id = 1;
		//$pub = 1;
		$this->db->where("id", $id);
		if($this->db->update("tblprogram", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	
	public function program_cat_add(){
			$is_logged_in = $this->session->userdata('is_logged_in');
			$metaVaribles = $this->query_model->getbyTable("tblmetavariable");
			
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
				$data['user_level']=$this->session->userdata['user_level'];
				$data['title'] = 'Our Programs Category';
				$data['link_type'] = 'programs';		
				//$data['site_setting'] = $this->query_model->getbyTable('tblsite');
				
				$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
				
				
				$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
				$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
				
				$this->db->order_by("pos", 'asc');
				$this->db->where('status',1);
				if($isUniqueSpecialOffer == 1){
					$this->db->where("type", "trial_offer");
				}
				$this->db->select(array('id','name'));
				$data['trialCategories'] = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
				
				$this->db->where('published',1);
				$this->db->select(array('id','product_title'));
				$data['dojocarts'] = $this->query_model->getbyTable('tbl_dojocarts');
				
				$this->db->where('status',1);
				$this->db->select(array('id','title'));
				$data['thankyou_pages'] = $this->query_model->getbyTable('tbl_form_thankyou_pages');
				
				
				
				
			if(isset($_POST['update'])){	
				$cat_data['cat_name'] = trim ($_POST['name']);
				//$cat_data['meta_title'] = $_POST['meta_title'];
				$cat_data['meta_title'] = !empty($_POST['meta_title']) ? $_POST['meta_title'] : $metaVaribles[0]->meta_school_name.' | '.$cat_data['cat_name'].' in '.$metaVaribles[0]->meta_city.', '.$metaVaribles[0]->meta_state;
				$cat_data['meta_desc'] = $_POST['meta_desc'];
				$cat_data['cat_type'] = 'programs';
				
				$cat_data['header_title'] = $_POST['header_title'];
				$cat_data['header_desc'] = $_POST['header_desc'];
				$cat_data['body_title'] = $_POST['body_title'];
				$cat_data['body_desc'] = $_POST['body_desc'];
				$cat_data['video_type'] = $_POST['video_type'];
				$cat_data['youtube_video'] = $_POST['youtube_video'];
				$cat_data['vimeo_video'] = $_POST['vimeo_video'];
				$cat_data['action_title'] = $_POST['action_title'];
				$cat_data['action_desc'] = $_POST['action_desc'];
				$cat_data['trial_title'] = $_POST['trial_title'];
				$cat_data['trial_desc'] = $_POST['trial_desc'];
				$cat_data['body_id'] = $_POST['body_id'];
				$cat_data['override_logo'] = $_POST['override_logo'];
				
				$cat_data['mini_form_offer_title'] = $_POST['mini_form_offer_title'];
				$cat_data['mini_form_offer_desc'] = $_POST['mini_form_offer_desc'];
				$cat_data['mini_form_button1_text'] = $_POST['mini_form_button1_text'];
				$cat_data['mini_form_button2_text'] = $_POST['mini_form_button2_text'];
				$cat_data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
				$cat_data['action_background_color'] = isset($_POST['action_background_color']) ? $_POST['action_background_color'] : '';
				$cat_data['trial_offer_id'] = isset($_POST['trial_offer_id']) ? $_POST['trial_offer_id'] : 0;
				$cat_data['show_full_form_1'] = $_POST['show_full_form_1'];
				$cat_data['show_full_form_2'] = $_POST['show_full_form_2'];
				$cat_data['opt1_text'] = !empty($_POST['opt1_text']) ? $_POST['opt1_text'] : '';
				$cat_data['opt_2_title'] = !empty($_POST['opt_2_title']) ? $_POST['opt_2_title'] : '';
				$cat_data['opt_2_text'] = !empty($_POST['opt_2_text']) ? $_POST['opt_2_text'] : '';
				$cat_data['action_headline_1'] = !empty($_POST['action_headline_1']) ? $_POST['action_headline_1'] : '';
				$cat_data['action_headline_2'] = !empty($_POST['action_headline_2']) ? $_POST['action_headline_2'] : '';
				$cat_data['action_headline_3'] = !empty($_POST['action_headline_3']) ? $_POST['action_headline_3'] : '';
				
				$cat_data['img_text_headline'] = !empty($_POST['img_text_headline']) ? $_POST['img_text_headline'] : '';
				$cat_data['img_text_title_1'] = !empty($_POST['img_text_title_1']) ? $_POST['img_text_title_1'] : '';
				$cat_data['img_text_desc_1'] = !empty($_POST['img_text_desc_1']) ? $_POST['img_text_desc_1'] : '';
				$cat_data['img_text_title_2'] = !empty($_POST['img_text_title_2']) ? $_POST['img_text_title_2'] : '';
				$cat_data['img_text_desc_2'] = !empty($_POST['img_text_desc_2']) ? $_POST['img_text_desc_2'] : '';
				$cat_data['img_text_title_3'] = !empty($_POST['img_text_title_3']) ? $_POST['img_text_title_3'] : '';
				$cat_data['img_text_desc_3'] = !empty($_POST['img_text_desc_3']) ? $_POST['img_text_desc_3'] : '';
				$cat_data['ages'] = !empty($_POST['ages']) ? $_POST['ages'] : '';
				
				$cat_data['opt1_title'] = isset($_POST['opt1_title']) ? $_POST['opt1_title'] : '';
				
				
				$cat_data['header_photo_alt_text'] = isset($_POST['header_photo_alt_text']) ? $_POST['header_photo_alt_text'] : '';
				$cat_data['action_image_1_alt_text'] = isset($_POST['action_image_1_alt_text']) ? $_POST['action_image_1_alt_text'] : '';
				$cat_data['action_image_2_alt_text'] = isset($_POST['action_image_2_alt_text']) ? $_POST['action_image_2_alt_text'] : '';
				$cat_data['action_image_3_alt_text'] = isset($_POST['action_image_3_alt_text']) ? $_POST['action_image_3_alt_text'] : '';
				$cat_data['img_text_image_1_alt_text'] = isset($_POST['img_text_image_1_alt_text']) ? $_POST['img_text_image_1_alt_text'] : '';
				$cat_data['img_text_image_2_alt_text'] = isset($_POST['img_text_image_2_alt_text']) ? $_POST['img_text_image_2_alt_text'] : '';
				$cat_data['img_text_image_3_alt_text'] = isset($_POST['img_text_image_3_alt_text']) ? $_POST['img_text_image_3_alt_text'] : '';
				$cat_data['show_override_logo'] = isset($_POST['show_override_logo']) ? $_POST['show_override_logo'] : 0;
				//$cat_data['header_photo_top_spacing'] = isset($_POST['header_photo_top_spacing']) ? $_POST['header_photo_top_spacing'] : '';
				$cat_data['redirection_type'] = isset($_POST['redirection_type']) ? $_POST['redirection_type'] : 'trial_offer';
				$cat_data['dojocart_id'] = isset($_POST['dojocart_id']) ? $_POST['dojocart_id'] : 0;
				$cat_data['third_party_url'] = isset($_POST['third_party_url']) ? $_POST['third_party_url'] : '';
				$cat_data['thankyou_page_id'] = isset($_POST['thankyou_page_id']) ? $_POST['thankyou_page_id'] : 0;
				$cat_data['opt1_submit_btn_text'] = isset($_POST['opt1_submit_btn_text']) ? $_POST['opt1_submit_btn_text'] : '';
				$cat_data['page_template'] = isset($_POST['page_template']) ? $_POST['page_template'] : 'default';
				$cat_data['icon_row_1'] = isset($_POST['icon_row_1']) ? $_POST['icon_row_1'] : '';
				$cat_data['icon_row_2'] = isset($_POST['icon_row_2']) ? $_POST['icon_row_2'] : '';
				$cat_data['icon_row_3'] = isset($_POST['icon_row_3']) ? $_POST['icon_row_3'] : '';
				$cat_data['published'] = isset($_POST['published']) ? $_POST['published'] : 0;
				$cat_data['hide_from_navigation'] = isset($_POST['hide_from_navigation']) ? $_POST['hide_from_navigation'] : 0;
				
				
				
				if(!empty($_POST['slug'])){
						//$cat_data['cat_slug'] = strtolower(str_replace(' ','-',$_POST['slug']));
						$replce_slug = preg_replace("/[^A-Za-z0-9\- ]/", "",$_POST['slug']);
						$slug = str_replace(' ', '-',strtolower($replce_slug));
						$cat_data['cat_slug'] = str_replace('--', '-',strtolower($slug));
				}else{
					//$cat_data['cat_slug'] = strtolower(str_replace(' ','-',$_POST['name']));
						$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$cat_data['cat_name']);
						$slug = str_replace(' ', '-',strtolower($replce_slug));
						$cat_data['cat_slug'] = str_replace('--', '-',strtolower($slug));
				}
				//echo $cat_data['cat_slug']; die;
				
				if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
						$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
						$image = $_FILES['userfile']['name'];	
						$this->load->model('upload_model');
						$path = "upload/program_category/";
						$cat_data['header_photo'] = $image; 
						if($a = $this->upload_model->upload_image($path)){
							$b='';
							//image resize process start			
							$filename=basename($a);	
							$umask=umask(0);
							$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
							$dirpath.='/'.$path;			
							chmod($dirpath.$filename ,0777);
							umask($umask);        				
							$this->load->library('image_lib');
							$config=array();			
							$config['image_library'] = 'gd2';
							$config['source_image'] = $dirpath.$filename;						
							$config['create_thumb'] = TRUE;
							$config['maintain_ratio'] = TRUE;
							$image_config['new_image'] = $dirpath.$filename;
							$image_config['quality'] = "100%";
							
							// vinay 30/11
							$imagedetails = getimagesize($_FILES['userfile']['tmp_name']);
							$width = $imagedetails[0];
							$height = $imagedetails[1];
							
							if($width >= 288 && $height <= 254){
								$config['width'] = $width;
								$config['height'] =254;
							} elseif($height >= 254 && $width <= 288){
								$config['width'] = 288;
								$config['height'] = $height;
							}else{
								$config['height'] =254;
								$config['width'] = 288;
							}
							
							$this->load->library('image_lib', $config);			 			
							$this->image_lib->initialize($config);        
							
							if (!$this->image_lib->resize())
							{
								echo  $this->image_lib->display_errors();
								exit;		    
							}else{			
								$this->image_lib->clear();
								$filename=str_replace('.','_thumb.',$filename);
								$b=$path.$filename;
							}
							//echo '<pre>'; print_r($cat_data); die;
							//$original_image = base_url().'upload/program_category/'.$image;
							
							
							$original_image = $a;
							$img_name = str_replace('upload/program_category/','',$a);
							$cat_data['header_photo'] = $img_name;
							$this->query_model->resize_and_crop($original_image, 'upload/program_category/thumb/'.$img_name, 288, 254);
							
							$imageType = str_replace('image/','',$imagedetails['mime']);
			
							if($imageType == 'png'){
								$this->query_model->resize_and_crop_png($original_image, 'upload/program_category/thumb/'.$img_name, 525, 307);
							}elseif($imageType == 'gif'){
								$this->query_model->resize_and_crop_gif($original_image, 'upload/program_category/thumb/'.$img_name, 525, 307);
							} else {
								$this->query_model->resize_and_crop($original_image, 'upload/program_category/thumb/'.$img_name, 525, 307);
							}
			
				
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/program_category/'.$cat_data['header_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/program_category/thumb/'.$cat_data['header_photo']);
						
							
							}
						}
						
						
					
				if(isset($_FILES['background_image']['name']) && !empty($_FILES['background_image']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('background_image')){
							$image_data = $this->upload->data();
							$cat_data['background_image'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['background_image'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['background_image'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/program_category/'.$cat_data['background_image']);
						
						$this->query_model->tinyImageCampressAndResize('upload/program_category/thumb/'.$cat_data['background_image']);
						
						
									
					}
				
				
					
				if(isset($_FILES['action_background_image']['name']) && !empty($_FILES['action_background_image']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('action_background_image')){
							$image_data = $this->upload->data();
							$cat_data['action_background_image'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['action_background_image'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['action_background_image'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/program_category/'.$cat_data['action_background_image']);
						
						$this->query_model->tinyImageCampressAndResize('upload/program_category/thumb/'.$cat_data['action_background_image']);
										
					}
					
				
					if(isset($_FILES['action_image_1']['name']) && !empty($_FILES['action_image_1']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('action_image_1')){
							$image_data = $this->upload->data();
							$cat_data['action_image_1'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['action_image_1'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['action_image_1'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						
										
					}
					
					
					
					
					if(isset($_FILES['action_image_2']['name']) && !empty($_FILES['action_image_2']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('action_image_2')){
							$image_data = $this->upload->data();
							$cat_data['action_image_2'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['action_image_2'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['action_image_2'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
									
					}
					
					
					
					
					if(isset($_FILES['action_image_3']['name']) && !empty($_FILES['action_image_3']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('action_image_3')){
							$image_data = $this->upload->data();
							$cat_data['action_image_3'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['action_image_3'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['action_image_3'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						

					}
					
					
					
					
					if(isset($_FILES['img_text_image_1']['name']) && !empty($_FILES['img_text_image_1']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('img_text_image_1')){
							$image_data = $this->upload->data();
							$cat_data['img_text_image_1'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['img_text_image_1'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['img_text_image_1'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
										
					}
					
					
					
					
					if(isset($_FILES['img_text_image_2']['name']) && !empty($_FILES['img_text_image_2']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('img_text_image_2')){
							$image_data = $this->upload->data();
							$cat_data['img_text_image_2'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['img_text_image_2'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['img_text_image_2'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
										
					}
					
					
					
					
					if(isset($_FILES['img_text_image_3']['name']) && !empty($_FILES['img_text_image_3']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('img_text_image_3')){
							$image_data = $this->upload->data();
							$cat_data['img_text_image_3'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['img_text_image_3'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['img_text_image_3'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
										
					}
					
					
					
					
						
								
				if($this->query_model->addCategory($cat_data)){
					$cat_id = $this->db->insert_id();
					$sectionArr = array('white_stripe_section~1'=>'White Stripe Under Header Section','full_width_row_section~2'=>'Full Width Rows Section','call_to_action_section~5'=>'Call to Action with 3 Images Section','images_text_section~3'=>'3 images + Text Section','program_listing_section~4'=>'Porgrams Listing');
	
					if(!empty($sectionArr)){
						foreach($sectionArr as $key => $section){
							
							$sectionValue = explode('~',$key);
							
							$section_name = $sectionValue[0];
							$section_pos = $sectionValue[1];
							$sectionData['section'] = $section_name;
							$sectionData['published'] = 1;
							$sectionData['pos'] = $section_pos;
							$sectionData['cat_id'] = $cat_id;
							
							$this->query_model->insertData('tbl_program_cat_sections',$sectionData);
						}
					}
					
				redirect($this->index());
				}
				else
				{	
					echo "<script language='javascript'>alert('Unable to add category');</script>";
					redirect($this->index());
				}
			
			}
			
			
			$this->load->view("admin/program_cat_add", $data);
				
			}else
			{
				redirect('admin/login');
			}
	}
	
	
	public function program_cat_edit(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$data['link_type'] = 'programs';
		$cat_id = $this->uri->segment(4);
		$query = $this->db->get_where('tblcategory', array('cat_id' => $cat_id));
		$data['categories'] = $query->result();
		//$data['site_setting'] = $this->query_model->getbyTable('tblsite');
		$data['override_logos'] = $this->query_model->getbyTable('tbloverride_logos');
		
		$this->db->order_by("pos", 'asc');
		$this->db->where('cat_id',$cat_id);
		$this->db->select(array('id','title','cat_id','photo_side','pos','published'));
		$data['programCatRows'] = $this->query_model->getbyTable('tbl_program_cat_rows');
		
		$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
		$isUniqueSpecialOffer = $this->query_model->isUniqueSpecialOffer();
		$this->db->order_by("pos", 'asc');
		$this->db->where('status',1);
		if($isUniqueSpecialOffer == 1){
			$this->db->where("type", "trial_offer");
		}
		$this->db->select(array('id','name'));
		$data['trialCategories'] = $this->query_model->getbyTable("$tbl_onlinespecial_categories");
		
		
		$this->db->where('published',1);
		$this->db->select(array('id','product_title'));
		$data['dojocarts'] = $this->query_model->getbyTable('tbl_dojocarts');
		
		$this->db->where('status',1);
		$this->db->select(array('id','title'));
		$data['thankyou_pages'] = $this->query_model->getbyTable('tbl_form_thankyou_pages');
		
		
		$this->db->order_by("pos", 'asc');
		$this->db->where('cat_id',$cat_id);
		$data['programSections'] = $this->query_model->getbyTable('tbl_program_cat_sections');
		
		
		
		$metaVaribles = $this->query_model->getbyTable("tblmetavariable");
		if(isset($_POST['update'])){
			//echo '<pre>'; print_r($_POST); die;
				$cat_data['cat_name'] = trim ($_POST['name']);
				//$cat_data['meta_title'] = $_POST['meta_title'];
				$cat_data['meta_title'] = !empty($_POST['meta_title']) ? $_POST['meta_title'] : $metaVaribles[0]->meta_school_name.' | '.$cat_data['cat_name'].' in '.$metaVaribles[0]->meta_city.', '.$metaVaribles[0]->meta_state;
				
				$cat_data['meta_desc'] = $_POST['meta_desc'];
				$cat_data['cat_type'] = 'programs';
				
				$cat_data['header_title'] = $_POST['header_title'];
				$cat_data['header_desc'] = $_POST['header_desc'];
				$cat_data['body_title'] = $_POST['body_title'];
				$cat_data['body_desc'] = $_POST['body_desc'];
				$cat_data['video_type'] = $_POST['video_type'];
				$cat_data['youtube_video'] = $_POST['youtube_video'];
				$cat_data['vimeo_video'] = $_POST['vimeo_video'];
				$cat_data['action_title'] = $_POST['action_title'];
				$cat_data['action_desc'] = $_POST['action_desc'];
				$cat_data['trial_title'] = $_POST['trial_title'];
				$cat_data['trial_desc'] = $_POST['trial_desc'];
				$cat_data['published'] = $_POST['published'];
				$cat_data['body_id'] = $_POST['body_id'];
				$cat_data['override_logo'] = $_POST['override_logo'];
				
				$cat_data['mini_form_offer_title'] = $_POST['mini_form_offer_title'];
				$cat_data['mini_form_offer_desc'] = $_POST['mini_form_offer_desc'];
				$cat_data['mini_form_button1_text'] = $_POST['mini_form_button1_text'];
				$cat_data['mini_form_button2_text'] = $_POST['mini_form_button2_text'];
				$cat_data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
				$cat_data['trial_offer_id'] = isset($_POST['trial_offer_id']) ? $_POST['trial_offer_id'] : 0;
				$cat_data['action_background_color'] = isset($_POST['action_background_color']) ? $_POST['action_background_color'] : '';
				
				$cat_data['show_full_form_1'] = $_POST['show_full_form_1'];
				$cat_data['show_full_form_2'] = $_POST['show_full_form_2'];
				$cat_data['opt1_text'] = !empty($_POST['opt1_text']) ? $_POST['opt1_text'] : '';
				$cat_data['opt_2_title'] = !empty($_POST['opt_2_title']) ? $_POST['opt_2_title'] : '';
				$cat_data['opt_2_text'] = !empty($_POST['opt_2_text']) ? $_POST['opt_2_text'] : '';
				$cat_data['action_headline_1'] = !empty($_POST['action_headline_1']) ? $_POST['action_headline_1'] : '';
				$cat_data['action_headline_2'] = !empty($_POST['action_headline_2']) ? $_POST['action_headline_2'] : '';
				$cat_data['action_headline_3'] = !empty($_POST['action_headline_3']) ? $_POST['action_headline_3'] : '';
				
				$cat_data['img_text_headline'] = !empty($_POST['img_text_headline']) ? $_POST['img_text_headline'] : '';
				$cat_data['img_text_title_1'] = !empty($_POST['img_text_title_1']) ? $_POST['img_text_title_1'] : '';
				$cat_data['img_text_desc_1'] = !empty($_POST['img_text_desc_1']) ? $_POST['img_text_desc_1'] : '';
				$cat_data['img_text_title_2'] = !empty($_POST['img_text_title_2']) ? $_POST['img_text_title_2'] : '';
				$cat_data['img_text_desc_2'] = !empty($_POST['img_text_desc_2']) ? $_POST['img_text_desc_2'] : '';
				$cat_data['img_text_title_3'] = !empty($_POST['img_text_title_3']) ? $_POST['img_text_title_3'] : '';
				$cat_data['img_text_desc_3'] = !empty($_POST['img_text_desc_3']) ? $_POST['img_text_desc_3'] : '';
				$cat_data['ages'] = !empty($_POST['ages']) ? $_POST['ages'] : '';
				$cat_data['opt1_title'] = isset($_POST['opt1_title']) ? $_POST['opt1_title'] : '';
				
				$cat_data['header_photo_alt_text'] = isset($_POST['header_photo_alt_text']) ? $_POST['header_photo_alt_text'] : '';
				$cat_data['action_image_1_alt_text'] = isset($_POST['action_image_1_alt_text']) ? $_POST['action_image_1_alt_text'] : '';
				$cat_data['action_image_2_alt_text'] = isset($_POST['action_image_2_alt_text']) ? $_POST['action_image_2_alt_text'] : '';
				$cat_data['action_image_3_alt_text'] = isset($_POST['action_image_3_alt_text']) ? $_POST['action_image_3_alt_text'] : '';
				$cat_data['img_text_image_1_alt_text'] = isset($_POST['img_text_image_1_alt_text']) ? $_POST['img_text_image_1_alt_text'] : '';
				$cat_data['img_text_image_2_alt_text'] = isset($_POST['img_text_image_2_alt_text']) ? $_POST['img_text_image_2_alt_text'] : '';
				$cat_data['img_text_image_3_alt_text'] = isset($_POST['img_text_image_3_alt_text']) ? $_POST['img_text_image_3_alt_text'] : '';
				$cat_data['show_override_logo'] = isset($_POST['show_override_logo']) ? $_POST['show_override_logo'] : 0;
				//$cat_data['header_photo_top_spacing'] = isset($_POST['header_photo_top_spacing']) ? $_POST['header_photo_top_spacing'] : '';
				
				$cat_data['redirection_type'] = isset($_POST['redirection_type']) ? $_POST['redirection_type'] : 'trial_offer';
				$cat_data['dojocart_id'] = isset($_POST['dojocart_id']) ? $_POST['dojocart_id'] : 0;
				$cat_data['third_party_url'] = isset($_POST['third_party_url']) ? $_POST['third_party_url'] : '';
				$cat_data['thankyou_page_id'] = isset($_POST['thankyou_page_id']) ? $_POST['thankyou_page_id'] : 0;
				$cat_data['opt1_submit_btn_text'] = isset($_POST['opt1_submit_btn_text']) ? $_POST['opt1_submit_btn_text'] : '';
				$cat_data['page_template'] = isset($_POST['page_template']) ? $_POST['page_template'] : 'default';
				$cat_data['icon_row_1'] = isset($_POST['icon_row_1']) ? $_POST['icon_row_1'] : '';
				$cat_data['icon_row_2'] = isset($_POST['icon_row_2']) ? $_POST['icon_row_2'] : '';
				$cat_data['icon_row_3'] = isset($_POST['icon_row_3']) ? $_POST['icon_row_3'] : '';
				$cat_data['hide_from_navigation'] = isset($_POST['hide_from_navigation']) ? $_POST['hide_from_navigation'] : 0;
				
				
				
				
				//echo '<pre>'; print_r($cat_data); die;
				if(!empty($_POST['slug'])){
						//$cat_data['cat_slug'] = slugify($_POST['slug']);
						$replce_slug = preg_replace("/[^A-Za-z0-9\- ]/", "",$_POST['slug']);
						$slug = str_replace(' ', '-',strtolower($replce_slug));
						$cat_data['cat_slug'] = str_replace('--', '-',strtolower($slug));
						
				}else{
					//$cat_data['cat_slug'] = strtolower(str_replace(' ','-',$_POST['name']));
						$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$cat_data['cat_name']);
						$slug = str_replace(' ', '-',strtolower($replce_slug));
						$cat_data['cat_slug'] = str_replace('--', '-',strtolower($slug));
				}
				
				//echo $cat_data['cat_slug']; die;
				
					
				if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
						$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
						$image = $_FILES['userfile']['name'];	
						$this->load->model('upload_model');
						$path = "upload/program_category/";
						$cat_data['header_photo'] = $image; 
						if($a = $this->upload_model->upload_image($path)){
							$b='';
							//image resize process start			
							$filename=basename($a);	
							$umask=umask(0);
							$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
							$dirpath.='/'.$path;			
							chmod($dirpath.$filename ,0777);
							umask($umask);        				
							$this->load->library('image_lib');
							$config=array();			
							$config['image_library'] = 'gd2';
							$config['source_image'] = $dirpath.$filename;						
							$config['create_thumb'] = TRUE;
							$config['maintain_ratio'] = TRUE;
							$image_config['new_image'] = $dirpath.$filename;
							$image_config['quality'] = "100%";
							
							// vinay 30/11
							$imagedetails = getimagesize($_FILES['userfile']['name']);
							$width = $imagedetails[0];
							$height = $imagedetails[1];
							
							if($width >= 288 && $height <= 254){
								$config['width'] = $width;
								$config['height'] =254;
							} elseif($height >= 254 && $width <= 288){
								$config['width'] = 288;
								$config['height'] = $height;
							}else{
								$config['height'] =254;
								$config['width'] = 288;
							}
							
							$this->load->library('image_lib', $config);			 			
							$this->image_lib->initialize($config);        
							
							if (!$this->image_lib->resize())
							{
								echo  $this->image_lib->display_errors();
								exit;		    
							}else{			
								$this->image_lib->clear();
								$filename=str_replace('.','_thumb.',$filename);
								$b=$path.$filename;
							}
							
							$original_image = $a;
							$img_name = str_replace('upload/program_category/','',$a);
							$cat_data['header_photo'] = $img_name;
							//echo $data['header_photo']; die;
							$this->query_model->resize_and_crop($original_image, 'upload/program_category/thumb/'.$img_name, 288, 254);
							
							$imageType = str_replace('image/','',$imagedetails['mime']);
			
							if($imageType == 'png'){
								$this->query_model->resize_and_crop_png($original_image, 'upload/program_category/thumb/'.$img_name, 525, 307);
							}elseif($imageType == 'gif'){
								$this->query_model->resize_and_crop_gif($original_image, 'upload/program_category/thumb/'.$img_name, 525, 307);
							} else {
								$this->query_model->resize_and_crop($original_image, 'upload/program_category/thumb/'.$img_name, 525, 307);
							}
							
							
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/program_category/'.$cat_data['header_photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/program_category/thumb/'.$cat_data['header_photo']);
						
			
							
							}
						}
				
				if(isset($_FILES['background_image']['name']) && !empty($_FILES['background_image']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('background_image')){
							$image_data = $this->upload->data();
							$cat_data['background_image'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['background_image'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['background_image'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
							
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/program_category/'.$cat_data['background_image']);
						
						$this->query_model->tinyImageCampressAndResize('upload/program_category/thumb/'.$cat_data['background_image']);
										
					}
					
					
				if(isset($_FILES['action_background_image']['name']) && !empty($_FILES['action_background_image']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('action_background_image')){
							$image_data = $this->upload->data();
							$cat_data['action_background_image'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['action_background_image'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['action_background_image'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
							
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/program_category/'.$cat_data['action_background_image']);
						
						$this->query_model->tinyImageCampressAndResize('upload/program_category/thumb/'.$cat_data['action_background_image']);
										
					}
					
					
					if(isset($_FILES['action_image_1']['name']) && !empty($_FILES['action_image_1']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('action_image_1')){
							$image_data = $this->upload->data();
							$cat_data['action_image_1'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['action_image_1'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['action_image_1'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
										
					}
					
					
					
					
					if(isset($_FILES['action_image_2']['name']) && !empty($_FILES['action_image_2']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('action_image_2')){
							$image_data = $this->upload->data();
							$cat_data['action_image_2'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['action_image_2'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['action_image_2'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
									
										
					}
					
					
					
					
					if(isset($_FILES['action_image_3']['name']) && !empty($_FILES['action_image_3']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('action_image_3')){
							$image_data = $this->upload->data();
							$cat_data['action_image_3'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['action_image_3'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['action_image_3'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
								
					}
					
					
					
					
					if(isset($_FILES['img_text_image_1']['name']) && !empty($_FILES['img_text_image_1']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('img_text_image_1')){
							$image_data = $this->upload->data();
							$cat_data['img_text_image_1'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['img_text_image_1'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['img_text_image_1'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
														
										
					}
					
					
					
					
					if(isset($_FILES['img_text_image_2']['name']) && !empty($_FILES['img_text_image_2']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('img_text_image_2')){
							$image_data = $this->upload->data();
							$cat_data['img_text_image_2'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['img_text_image_2'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['img_text_image_2'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						
					}
					
					
					
					
					if(isset($_FILES['img_text_image_3']['name']) && !empty($_FILES['img_text_image_3']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('img_text_image_3')){
							$image_data = $this->upload->data();
							$cat_data['img_text_image_3'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$cat_data['img_text_image_3'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$cat_data['img_text_image_3'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						
						
					}
					
					
					
				//echo '<pre>cat_data';print_r($_FILES); die;				
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
		$this->load->view("admin/program_cat_edit", $data);
		
	}
	
	
	public function check_slug(){
		
		if(count($_POST)>0){
			$type = $_POST['type'];
			
			$name = $_POST['name'];
			
			$slug = $_POST['slug'];
			if(empty($slug)){
				$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$name);
				$program_slug = str_replace(' ', '-',strtolower($replce_slug));
				$slug = str_replace('--', '-',strtolower($program_slug));
			}
			
			
			if($type == 'edit'){
				$program_id = $_POST['program_id'];
				$this->db->where("id !=", $program_id);
			}
			$checkSlug = $this->query_model->getbySpecific('tblprogram','program_slug',$slug);
			
			if(!empty($checkSlug)){
				echo 1;
			}else{
				echo 0;
			}
			
		}
		
	}
	
	public function program_cat_delete(){
		$id = $this->uri->segment(4);
		$this->db->where("cat_id", $id);	
		if($this->db->delete("tblcategory"))
		{		
			$this->db->query("delete from tblprogram where category='".$id."'") or die(mysqli_error($this->db->conn_id));	
			redirect($this->index());
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete category');</script>";
			redirect($this->index());
		}
	}
	
	
	
	
	public function add_program_cat_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				
			$records['title'] = 'Add Program Category Row';
			$records['link_type'] = 'programs';
			
			$records['cat_id'] = $this->uri->segment(4);
			
			$this->load->view("admin/add_program_cat_row", $records);
			
			if(isset($_POST['update'])){
				//echo '<pre>'; print_r($_POST); die;
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						$data['cat_id'] = $this->uri->segment(4);						
						//$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						//$data['button_text'] = $this->input->post('button_text');						
						//$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						//$data['location_id'] = $this->input->post('location_id'); 
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
							
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/program_category/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/program_category/thumb/'.$data['photo']);
												
					}
					
				
					
					$this->query_model->insertData('tbl_program_cat_rows', $data);
					
						redirect("admin/programs/program_cat_edit/".$this->uri->segment(4));
				
			}
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
		
	public function edit_program_cat_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Edit Program Category Row';
			$records['link_type'] = 'programs';
			
			
			$this->db->where("id", $this->uri->segment(4));
			$records['pagedetails'] = $this->query_model->getbyTable('tbl_program_cat_rows');
			
			$this->load->view("admin/edit_program_cat_row", $records);
			
			if(isset($_POST['update'])){
				
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						//$data['button_text'] = $this->input->post('button_text');						
						//$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						//$data['location_id'] = $this->input->post('location_id'); 
						//echo '<pre>data'; print_r($data); die;
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/program_category/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/program_category/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/program_category/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
							
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/program_category/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/program_category/thumb/'.$data['photo']);
												
					}
					
				
					$this->query_model->updateData('tbl_program_cat_rows','id',$this->uri->segment(4), $data);
					
					//$this->query_model->insertData('tbl_aboutus_rows', $data);
					
					redirect("admin/programs/program_cat_edit/".$records['pagedetails'][0]->cat_id);
						
				//echo '<pre>'; print_r($_POST); die;
			}
		
		}else
		{
			redirect('admin/login');
		}
	}
	
		
	public function deleteProgramCatRowImage(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['id'];
			$query = $this->db->query("update tbl_program_cat_rows set photo='' where id=".$id."");
			echo 1;
		}else{
				echo 0;
		}
	
	}
	
	
	public function delete_program_cat_row(){
		
		$id = $_POST['delete-item-id'];
		$cat_id = $_POST['delete-cat-id'];
			$this->db->where("id", $id);
			if($this->db->delete("tbl_program_cat_rows"))
			{
				redirect("admin/programs/program_cat_edit/".$cat_id);
			}
			else
			{
				redirect("admin/programs/program_cat_edit/".$cat_id);
			}
	}
	
	
	
	public function sortProgramCatRows(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_program_cat_rows` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'  AND `cat_id`='" . $this->uri->segment(4) . "' ") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	public function sortProgramCatSections(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_program_cat_sections` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "' AND `cat_id`='" . $this->uri->segment(4) . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	
	public function publishProgramCatRows(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tbl_program_cat_rows", array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	
	public function publishProgramSection(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
	
		$this->db->where("id", $id);
		if($this->db->update("tbl_program_cat_sections", array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	
	
	
	
	
	public function add_program_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				
			$records['title'] = 'Add Program Full Width Row';
			$records['link_type'] = 'programs';
			
			$records['cat_id'] = $this->uri->segment(4);
			$this->load->view("admin/add_program_row", $records);
			
			if(isset($_POST['update'])){
				//echo '<pre>'; print_r($_POST); die;
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						$data['program_id'] = $this->uri->segment(4);						
						$data['cat_id'] = $this->uri->segment(6);						
						$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						//$data['button_text'] = $this->input->post('button_text');						
						//$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						//$data['location_id'] = $this->input->post('location_id'); 
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/programs/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/programs/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/programs/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/programs/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$data['photo']);
												
					}
					
				
					
					$this->query_model->insertData('tbl_program_rows', $data);
					
					redirect("admin/programs/edit/".$this->uri->segment(4).'/view/'.$this->uri->segment(6));
				
			}
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
		
	public function edit_program_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Edit Program Full Width Row';
			$records['link_type'] = 'programs';
			
			
			$this->db->where("id", $this->uri->segment(4));
			$records['pagedetails'] = $this->query_model->getbyTable('tbl_program_rows');
			
			$this->load->view("admin/edit_program_row", $records);
			
			if(isset($_POST['update'])){
				
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						//$data['button_text'] = $this->input->post('button_text');						
						//$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						//$data['location_id'] = $this->input->post('location_id'); 
						//echo '<pre>data'; print_r($data); die;
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/programs/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/programs/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/programs/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
							
	
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/programs/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$data['photo']);							
					}
					
				
					$this->query_model->updateData('tbl_program_rows','id',$this->uri->segment(4), $data);
					
					
					redirect("admin/programs/edit/".$records['pagedetails'][0]->program_id.'/view/'.$records['pagedetails'][0]->cat_id);
						
				//echo '<pre>'; print_r($_POST); die;
			}
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	public function deleteProgramRowImage(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['id'];
			
			$query = $this->db->query("update tbl_program_rows set photo='' where id=".$id."");
			echo 1;
		}else{
				echo 0;
		}
	
	}
	
	
	
	
	
	
	public function add_program_little_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				
			$records['title'] = 'Add Program Little Row';
			$records['link_type'] = 'programs';
			
			$records['cat_id'] = $this->uri->segment(4);
			$this->load->view("admin/add_program_little_row", $records);
			
			if(isset($_POST['update'])){
				//echo '<pre>'; print_r($_POST); die;
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						$data['program_id'] = $this->uri->segment(4);						
						$data['cat_id'] = $this->uri->segment(6);						
						$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						$data['img_top_spacing'] = isset($_POST['img_top_spacing']) ? $_POST['img_top_spacing'] : '';
						$data['photo_alt_text'] = isset($_POST['photo_alt_text']) ? $_POST['photo_alt_text'] : '';
						//$data['button_text'] = $this->input->post('button_text');						
						//$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						//$data['location_id'] = $this->input->post('location_id'); 
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/programs/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/programs/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/programs/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
							
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/programs/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$data['photo']);
												
					}
					
				
					
					$this->query_model->insertData('tbl_program_little_rows', $data);
					
					redirect("admin/programs/edit/".$this->uri->segment(4).'/view/'.$this->uri->segment(6));
				
			}
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	
		
	public function edit_program_little_row(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Edit Program Little Row';
			$records['link_type'] = 'programs';
			
			
			$this->db->where("id", $this->uri->segment(4));
			$records['pagedetails'] = $this->query_model->getbyTable('tbl_program_little_rows');
			
			$this->load->view("admin/edit_program_little_row", $records);
			
			if(isset($_POST['update'])){
				
						$data['title'] = $this->input->post('title'); 
						$data['photo_side'] = $this->input->post('photo_side');						
						$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						$data['img_top_spacing'] = isset($_POST['img_top_spacing']) ? $_POST['img_top_spacing'] : '';
						$data['photo_alt_text'] = isset($_POST['photo_alt_text']) ? $_POST['photo_alt_text'] : '';
						//$data['button_text'] = $this->input->post('button_text');						
						//$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description'); 
						//$data['location_id'] = $this->input->post('location_id'); 
						//echo '<pre>data'; print_r($data); die;
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
			
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/programs/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/programs/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/programs/thumb/'.$data['photo'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 400){				
							$new_width = 400;
							$new_height = round((400/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
						
							
						// Tiny Image Campress and resize
						$this->query_model->tinyImageCampressAndResize('upload/programs/'.$data['photo']);
						
						$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$data['photo']);
												
					}
					
				
					$this->query_model->updateData('tbl_program_little_rows','id',$this->uri->segment(4), $data);
					
					
					redirect("admin/programs/edit/".$records['pagedetails'][0]->program_id.'/view/'.$records['pagedetails'][0]->cat_id);
						
				//echo '<pre>'; print_r($_POST); die;
			}
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	public function deleteProgramLittleRowImage(){
		
		if(count($_POST)>0){			
						
			$id = $_POST['id'];
			
			$query = $this->db->query("update tbl_program_little_rows set photo='' where id=".$id."");
			echo 1;
		}else{
				echo 0;
		}
	
	}
	
	
	public function publishProgramRows(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		$table_name = $_POST['table_name'];
		$this->db->where("id", $id);
		if($this->db->update($table_name, array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	
	public function publishFaqs(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		$table_name = 'tbl_program_faqs';
		$this->db->where("id", $id);
		if($this->db->update($table_name, array("published" => $pub)))
		{	
			echo 1;
		}
	}
	
	public function delete_program_row(){
		
		
		parse_str($_POST['formData'], $searcharray);
		
		$id = isset($searcharray['delete-item-id']) ? $searcharray['delete-item-id'] : 0;
		$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
		
		if(!empty($id) && !empty($table_name)){
			$this->db->where("id", $id);
			if($this->db->delete($table_name))
			{
				
				echo 1;
				//redirect("admin/programs/edit/".$program_id.'/view/'.$cat_id);
			}
			else
			{
				echo 0;
				//redirect("admin/programs/edit/".$program_id.'/view/'.$cat_id);
			}
		}
		exit();	
	}
		
	//
	public function delete_program_faqs(){
		
		$id = $_POST['delete-item-id'];
		$table_name = 'tbl_program_faqs';
		//echo '<pre>'; print_r($_POST); die;
		
			$this->db->where("id", $id);
			if($this->db->delete($table_name))
			{
				redirect("admin/page/faqs");
			}
			else
			{
				redirect("admin/page/faqs");
			}
	}
	
	
	public function add_program_faq(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
				
			$records['title'] = 'Program Faq';
			$records['link_type'] = 'programs';
			
			$records['cat_id'] = $this->uri->segment(4);
			
			
			if(isset($_POST['update'])){
				//echo '<pre>'; print_r($_POST); die;
						$data['title'] = $this->input->post('title'); 						
						$data['program_id'] = 0;						
						$data['cat_id'] = 0;						
						//$data['background_color'] = isset($_POST['background_color']) ? $_POST['background_color'] : '';
						//$data['button_text'] = $this->input->post('button_text');						
						//$data['button_url'] = $this->input->post('button_url');						
						$data['description'] = $this->input->post('description');
						$data['title_2'] = $this->input->post('title_2'); 							
						$data['description_2'] = $this->input->post('description_2'); 							
						//$data['location_id'] = $this->input->post('location_id'); 
						
				
					
					$this->query_model->insertData('tbl_program_faqs', $data);
					
					redirect("admin/page/faqs");
				
			}
			
			$this->load->view("admin/add_program_faq", $records);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
		
	public function edit_program_faq(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			
			$records['title'] = 'Program Faq';
			$records['link_type'] = 'programs';
			
			
			$this->db->where("id", $this->uri->segment(4));
			$records['pagedetails'] = $this->query_model->getbyTable('tbl_program_faqs');
			
			
			
			if(isset($_POST['update'])){
				
						$data['title'] = $this->input->post('title'); 
						//$data['photo_side'] = $this->input->post('photo_side');						
						$data['description'] = $this->input->post('description'); 
						
						$data['title_2'] = $this->input->post('title_2'); 							
						$data['description_2'] = $this->input->post('description_2');
				
					$this->query_model->updateData('tbl_program_faqs','id',$this->uri->segment(4), $data);
					
					
					//redirect("admin/programs/edit/".$records['pagedetails'][0]->program_id.'/view/'.$records['pagedetails'][0]->cat_id);
					redirect("admin/page/faqs");
						
				//echo '<pre>'; print_r($_POST); die;
			}
			
			$this->load->view("admin/edit_program_faq", $records);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
		
	public function deleteOtherImages(){
		
		if(count($_POST)>0){		
									
			$id = $_POST['program_id'];
			$field_name = $_POST['field_name'];
			$this->db->where("id", $id);
			
			if($this->db->query("update tblprogram set ".$field_name."='' where id=".$id.""))
			{	
				/**$dir=pathinfo(BASEPATH);
				$img=$dir['dirname'].'/'.$_POST['image_path'];				
				unlink($img);**/			
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
	
		
	
	
	
	
	public function default_program_cat_sections(){
		
		if($this->uri->segment(4) != ''){
			$cat_id = $this->uri->segment(4);
			
			$exitRecord = $this->query_model->getbySpecific('tbl_program_cat_sections', 'cat_id',$cat_id);
			if(!empty($exitRecord)){
				$this->db->where("cat_id", $cat_id);
				$this->db->delete("tbl_program_cat_sections");
			}
			
			$sectionArr = array('white_stripe_section~1'=>'White Stripe Under Header Section','full_width_row_section~2'=>'Full Width Rows Section','call_to_action_section~5'=>'Call to Action with 3 Images Section','images_text_section~3'=>'3 images + Text Section','program_listing_section~4'=>'Porgrams Listing');
	
					if(!empty($sectionArr)){
						foreach($sectionArr as $key => $section){
							
							$sectionValue = explode('~',$key);
							
							$section_name = $sectionValue[0];
							$section_pos = $sectionValue[1];
							$sectionData['section'] = $section_name;
							$sectionData['published'] = 1;
							$sectionData['pos'] = $section_pos;
							$sectionData['cat_id'] = $cat_id;
							
							$this->query_model->insertData('tbl_program_cat_sections',$sectionData);
						}
					}
					
		}
		redirect('admin/programs/program_cat_edit/'.$cat_id);
	}
	
	
	public function default_program_sections(){
		
		if($this->uri->segment(4) != ''){
			
			$program_id = $this->uri->segment(4);
			$cat_id = $this->uri->segment(6);
			
			$exitRecord = $this->query_model->getbySpecific('tbl_program_sections', 'program_id',$program_id);
			
			if(!empty($exitRecord)){
				$this->db->where("program_id", $program_id);
				$this->db->delete("tbl_program_sections");
			}
			
			$sectionArr = array('question_headline_section~0'=>'Question Headline Section','white_stripe_section~1'=>'White Stripe Under Header Section','benefits_1_section~2'=>'Benefits with 3 images Section','video_row_section~3'=>'Video Row Section','call_to_action_section~5'=>'Call to Action with 3 Images Section','headling_section~6'=>'Heading with 3 boxes Section','statistics_section~7'=>'Statistics with 3 images Section','benefits_2_section~8'=>'Benefits Row2 with 3 Images Section','white_stripe_2_section~9'=>'White Stripe Row 2 Section','benefits_3_section~13'=>'Benefits Row3 with 3 Images Section','full_width_row_section~4'=>'Alternating Full Width Rows','little_row_section~10'=>'Alternating Little Rows','faq_section~12'=>'Faqs','testimonial_section~11'=>'Testimonials','html_editor_section~2'=>'HTML Editor');
	
					if(!empty($sectionArr)){
						foreach($sectionArr as $key => $section){
							
							$sectionValue = explode('~',$key);
							
							$section_name = $sectionValue[0];
							$section_pos = $sectionValue[1];
							$sectionData['section'] = $section_name;
							$sectionData['published'] = 1;
							$sectionData['pos'] = $section_pos;
							$sectionData['cat_id'] = $cat_id;
							$sectionData['program_id'] = $program_id;
							
							$this->query_model->insertData('tbl_program_sections',$sectionData);
						}
					}
					
		}
		redirect('admin/programs/edit/'.$program_id.'/view/'.$cat_id);
	}
	
	
	public function sortProgramFullWidthRows(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_program_rows` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "' AND `program_id`='" . $this->uri->segment(4) . "' ") or die(mysqli_error($this->db->conn_id));
		}
	} 
	
	public function sortProgramLittleRows(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_program_little_rows` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "' AND `program_id`='" . $this->uri->segment(4) . "' ") or die(mysqli_error($this->db->conn_id));
		}
	} 
	
	
	public function sortProgramFaqs(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_program_faqs` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "' ") or die(mysqli_error($this->db->conn_id));
		}
	} 
	
	public function sortProgramSections(){	
		
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {	
			$this->db->query("UPDATE `tbl_program_sections` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'  AND `program_id`='" . $this->uri->segment(4) . "'  ") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	public function duplicate_program(){
		parse_str($_POST['formData'], $searcharray);
		$_POST = $searcharray;
		//echo '<pre>POST'; print_r($_POST); die;
		if(isset($_POST['action']) && $_POST['action'] == "duplicate_record"){
			$item_id = (isset($_POST['item_id']) && !empty($_POST['item_id'])) ? $_POST['item_id'] : '';
			if(!empty($item_id)){
				$details = $this->query_model->getbySpecific('tblprogram','id', $item_id);
				
				if(!empty($details)){
					$programArr  = array();
					unset($details[0]->id);
					
					$program_name = (isset($_POST['program_title']) && !empty($_POST['program_title'])) ? $_POST['program_title'] : '';
					$program_name = !empty($program_name) ? $program_name : $details[0]->program;
					$programArr['program'] = trim($program_name);
					
					foreach($details[0] as $key => $detail){
						if($key == "program"){
							if($detail == $program_name){
								$programArr[$key] = $program_name .' Duplicate';
							}
						}elseif($key == "buttonName"){
								$programArr[$key] = $programArr['program'];
							
						}elseif($key == "program_slug"){
							$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$programArr['program']);
							$slug = str_replace(' ', '-',strtolower($replce_slug));
							$programArr[$key] = str_replace('--', '-',strtolower($slug));
						}else{
							$programArr[$key] = $detail;
						}
						
					}
					
					//echo '<pre>programArr'; print_r($programArr); die;
					
					$this->query_model->insertData('tblprogram', $programArr);
					$duplicate_program_id = $this->db->insert_id();
					
					//$duplicate_program_id = 117;
					
					// saving  code other tables
					$tables = array('tbl_program_rows','tbl_program_little_rows','tbl_program_sections');
					foreach($tables as $table_name){
						$this->db->where('cat_id',$_POST['category_id']);
						$records = $this->query_model->getbySpecific($table_name,'program_id', $item_id);
						
						if(!empty($records)){
							foreach($records as $record){
								$dataArr = array();
									
								foreach($record as $key => $val){
									if($key == "id"){
										unset($key);
									}elseif($key == "program_id"){
										$dataArr[$key] = $duplicate_program_id;
									}else{
										$dataArr[$key] = $val;
									}
								}
								
								$this->query_model->insertData($table_name, $dataArr);
							}
							
						}
					}
					
					
				}
			}
			echo 1;
			//redirect("admin/programs/view/".$_POST['category_id']);
		}
	}
	
	
	public function ajaxSaveProgramImage(){
		$file = '';
		if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
			//$_FILES['file']['name'] = time().$_FILES['file']['name'];
				//$file = $_FILES['file'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('file')){
					$image_data = $this->upload->data();
					$file = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$file;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$file;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
					
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$file);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$file);
		
			}
		echo  $file;	
	}
	
	
	public function duplicate_category(){
		
		parse_str($_POST['formData'], $searcharray);
		$_POST = $searcharray;
		
		$categoryArr = array();
		$cat_id =  (isset($_POST['item_id']) && !empty($_POST['item_id'])) ? $_POST['item_id'] : '';
		if(!empty($cat_id)){
			$details = $this->query_model->getbySpecific('tblcategory','cat_id', $cat_id);
			
			if(!empty($details)){
				$cat_id = $details[0]->cat_id;
				$category_name = (isset($_POST['program_title']) && !empty($_POST['program_title'])) ? $_POST['program_title'] : '';
				$category_name = !empty($category_name) ? $category_name : $details[0]->cat_name;
				
				foreach($details[0] as $key => $detail){
					if($key == "cat_name"){
						//$cat_name = $detail.' Duplicate';
						if($detail == $category_name){
							$category_name = $category_name.' Duplicate '.uniqid();
						}
						$categoryArr[$key] = $category_name;
					}elseif($key == "cat_slug"){
						$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$categoryArr['cat_name']);
						$slug = str_replace(' ', '-',strtolower($replce_slug));
						$categoryArr[$key] = str_replace('--', '-',strtolower($slug));
					}else{
						$categoryArr[$key] = $detail;
					}
					
				}
				
				unset($categoryArr['cat_id']);
			}
			//echo '<pre>categoryArr'; print_r($categoryArr); die;
			if(!empty($categoryArr)){
				$this->query_model->insertData('tblcategory', $categoryArr);
				$duplicate_cat_id = $this->db->insert_id();
				
				$tables = array('tbl_program_cat_rows','tbl_program_cat_sections');
					foreach($tables as $table_name){
						
						$records = $this->query_model->getbySpecific($table_name,'cat_id', $this->uri->segment(4));
						
						if(!empty($records)){
							foreach($records as $record){
								$dataArr = array();
									
								foreach($record as $key => $val){
									if($key == "id"){
										unset($key);
									}elseif($key == "cat_id"){
										$dataArr[$key] = $duplicate_cat_id;
									}else{
										$dataArr[$key] = $val;
									}
								}
								
								$this->query_model->insertData($table_name, $dataArr);
							}
							
						}
					}
			}
			
			//echo '<pre>categoryArr'; print_r($categoryArr); die;
		}
		
		echo 1;
		//redirect("admin/programs/view/".$duplicate_cat_id);
	}
	
	
	public function ajax_full_alternate_popup(){
		
		if(isset($_POST['action_type']) && !empty($_POST['action_type'])){
			$records = array();
			$records['detail'] = array();
			$records['action_type'] = $_POST['action_type'];
			$records['item_id'] = $_POST['item_id'];
			$records['table_name'] = $_POST['table_name'];
			$records['form_type'] = $_POST['form_type'];
			
			if($records['action_type'] == "edit" && !empty($records['item_id'])){
				
				$this->db->where("id", $records['item_id']);
				$detail = $this->query_model->getbyTable($records['table_name']);
				if(!empty($detail)){
					$records['detail'] = $detail[0];
				}
			}
			
			$this->load->view("admin/ajax_full_alternate_popup", $records);
		}
	}
	
	
	
	
	public function ajaxSaveFullRowImage(){
		$file = '';
		if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
			//$_FILES['file']['name'] = time().$_FILES['file']['name'];
				//$file = $_FILES['file'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('file')){
					$image_data = $this->upload->data();
					$file = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$file;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$file;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
					
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$file);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$file);
		
			}
		echo  $file;	
	}
	
	public function ajax_save_full_alternate_row(){
		
		parse_str($_POST['formData'], $searcharray);
		
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['update'])){
				
				$item_id = isset($searcharray['item_id']) ? $searcharray['item_id'] : '';
				
						$data['title'] = isset($searcharray['title']) ? $searcharray['title'] : '';
						$data['photo_side'] = isset($searcharray['photo_side']) ? $searcharray['photo_side'] : '';					
						$data['program_id'] = isset($searcharray['program_id']) ? $searcharray['program_id'] : 0;						
						$data['cat_id'] = isset($searcharray['cat_id']) ? $searcharray['cat_id'] : 0;					
						$data['background_color'] = isset($searcharray['background_color']) ? $searcharray['background_color'] : '';					
						$data['description'] = isset($_POST['full_desc']) ? trim($_POST['full_desc']) : '';
						$data['photo'] = isset($searcharray['photo']) ? trim($searcharray['photo']) : '';
						
						$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
						$form_type = isset($searcharray['form_type']) ? $searcharray['form_type'] : '';
						
						if($form_type == "little_row"){
							
							$data['title'] = isset($_POST['littlerow_title']) ? trim($_POST['littlerow_title']) : '';
							$data['photo_alt_text'] = isset($searcharray['photo_alt_text']) ? $searcharray['photo_alt_text'] : '';
							$data['img_top_spacing'] = isset($searcharray['img_top_spacing']) ? trim($searcharray['img_top_spacing']) : '';
						}
				
				if(!empty($item_id)){
					
					$this->query_model->updateData($table_name,'id',$item_id, $data);
					$insert_id = $item_id;
					$result['form_action'] = 'edit';
				}else{
					$this->query_model->insertData($table_name, $data);
					$insert_id = $this->db->insert_id();
					$result['form_action'] = 'add';
				}
					
					$result['res'] = 1;
					$result['id'] = $insert_id;
					$result['title'] = $data['title'];
					$result['form_type'] = $form_type;
					$result['table_name'] = $table_name;
					$result['photo_side'] = $data['photo_side'];
					
				
			}
		echo json_encode($result); 	
	}
	
	
	public function ajax_program_cat_rows_popup(){
		
		if(isset($_POST['action_type']) && !empty($_POST['action_type'])){
			$records = array();
			$records['detail'] = array();
			$records['action_type'] = $_POST['action_type'];
			$records['item_id'] = $_POST['item_id'];
			$records['table_name'] = $_POST['table_name'];
			$records['form_type'] = $_POST['form_type'];
			
			if($records['action_type'] == "edit" && !empty($records['item_id'])){
				
				$this->db->where("id", $records['item_id']);
				$detail = $this->query_model->getbyTable($records['table_name']);
				if(!empty($detail)){
					$records['detail'] = $detail[0];
				}
			}
			
			$this->load->view("admin/ajax_program_cat_rows_popup", $records);
		}
	}
	
	
	
	
	public function ajaxSaveCategoryFullRowImage(){
		$file = '';
		if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
			//$_FILES['file']['name'] = time().$_FILES['file']['name'];
				//$file = $_FILES['file'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/program_category/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('file')){
					$image_data = $this->upload->data();
					$file = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/program_category/'.$file;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/program_category/thumb/'.$file;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
					
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/program_category/'.$file);
				
				$this->query_model->tinyImageCampressAndResize('upload/program_category/thumb/'.$file);
		
			}
		echo  $file;	
	}
	
	public function ajax_save_category_full_alternate_row(){
		
		parse_str($_POST['formData'], $searcharray);
		
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['update'])){
				
				$item_id = isset($searcharray['item_id']) ? $searcharray['item_id'] : '';
				
						$data['title'] = isset($searcharray['title']) ? $searcharray['title'] : '';
						$data['photo_side'] = isset($searcharray['photo_side']) ? $searcharray['photo_side'] : '';					
						//$data['program_id'] = isset($searcharray['program_id']) ? $searcharray['program_id'] : 0;						
						$data['cat_id'] = isset($searcharray['cat_id']) ? $searcharray['cat_id'] : 0;					
						//$data['background_color'] = isset($searcharray['background_color']) ? $searcharray['background_color'] : '';					
						$data['description'] = isset($_POST['full_desc']) ? trim($_POST['full_desc']) : '';
						$data['photo'] = isset($searcharray['photo']) ? trim($searcharray['photo']) : '';
						
						$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
						$form_type = isset($searcharray['form_type']) ? $searcharray['form_type'] : '';
						
						
				
				if(!empty($item_id)){
					
					$this->query_model->updateData($table_name,'id',$item_id, $data);
					$insert_id = $item_id;
					$result['form_action'] = 'edit';
				}else{
					$this->query_model->insertData($table_name, $data);
					$insert_id = $this->db->insert_id();
					$result['form_action'] = 'add';
				}
					
					$result['res'] = 1;
					$result['id'] = $insert_id;
					$result['title'] = $data['title'];
					$result['form_type'] = $form_type;
					$result['table_name'] = $table_name;
					$result['photo_side'] = $data['photo_side'];
					
				
			}
		echo json_encode($result); 	
	}
	
	
}