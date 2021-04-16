<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		$this->load->model('user_model');
		$this->load->model('contact_model');
		
	}
	
	public function index()
	{
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
            $data['title'] = "Dashboard";
			
			
			// new code for update site setting email in main location when we are turning off multi location	
			$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
			$mainLocation = $this->query_model->getMainLocation("tblcontact");
			$site_setting =  $this->query_model->getbyTable("tblsite");
			//echo "<pre>site_setting"; print_r($site_setting); die;
			if($multiLocation[0]->field_value == 0){
				$site_setting_email = $site_setting[0]->email;
				$main_location_email = $mainLocation[0]->email;
				
				$site_setting_text_address = $site_setting[0]->text_address;
				$main_location_text_address = $mainLocation[0]->text_address;
				
				//echo $site_setting_email.'====>'.$main_location_email; 
				//echo $site_setting_text_address.'====>'.$main_location_text_address; die;
				if($site_setting_email != $main_location_email){
					$location_id = $mainLocation[0]->id;
					
					$sql = "UPDATE `tblcontact` SET `email` = '$site_setting_email' WHERE `id` = $location_id";
					$this->db->query($sql);	
				}
				
				if($site_setting_text_address != $main_location_text_address){
					
					$location_id = $mainLocation[0]->id;
					
					$sql = "UPDATE `tblcontact` SET `text_address` = '$site_setting_text_address' WHERE `id` = $location_id";
					$this->db->query($sql);	
				}
				
			} 
			
			/* --- Get Wordpress Blog Data --- */
			
			// vinay 05/2015
			
			 $filePath = base_url().'wp-blog.php';
			  $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_URL => $filePath,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_SSL_VERIFYHOST => 0,
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Postman-Token: 766cb339-f979-4a7d-88cc-9b6dabf41402",
					"cache-control: no-cache"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				 // echo "cURL Error #:" . $err;
				} else {
				  $wp_blogs =  $response;
				}
			 //$wp_blogs = file_get_contents($filePath);
   			 $data['wp_categories'] = json_decode($wp_blogs);
			//echo '<pre>'; print_r($data['wp_categories']); die;
			/* ------- </code> ------------- */
			 
			 
			 
			$data['users'] = $this->db->get("tbladmin")->result();
			$data['gallery_count'] = $this->db->count_all_results("tblgalleryname");
			$this->db->where("type", 1);
			$this->db->from("tblmedia");
			$data['image_count'] = $this->db->count_all_results();
			$this->db->where("type", 2);
			$this->db->from("tblmedia");
			$data['video_count'] = $this->db->count_all_results();
			$data['staff_count'] = $this->db->count_all_results("tblstaff");
			$data['event_count'] = $this->db->count_all_results("tblcalendar");
			$this->db->order_by("id", "DESC"); 
			//$data['recent'] = $this->query_model->getbyTable("tblgalleryname");
			$this->db->order_by("pos", "ASC");
			$data['contact'] = $this->contact_model->getAll();
			$data['setting']=$this->db->query("select title from tblsite")->result();
			
			
			$this->load->view('admin/dashboard',$data);
		}else{
			redirect('admin/login');
		}
	}
	

	// vinay 05/11
	public function getPostsByCategory(){
			if(count($_POST)> 0){
				
				 $category_id = $_POST['category_id'];
				 $filePath = base_url().'wp-blog.php?category_id='.$category_id;
				  $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_URL => $filePath,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_SSL_VERIFYHOST => 0,
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Postman-Token: 766cb339-f979-4a7d-88cc-9b6dabf41402",
					"cache-control: no-cache"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				 // echo "cURL Error #:" . $err;
				} else {
				  $wp_blogs =  $response;
				}
				 //$wp_blogs = file_get_contents($filePath);
				 $data['wp_cat_blogs'] = json_decode($wp_blogs);
				 if(count( $data['wp_cat_blogs']) < 1){
				 	$data['wp_cat_blogs'] = array();
				 }
				
				 $this->load->view('admin/wp_cat_blogs',$data);
			}
	}
	
	
	// vinay 05/11
	public function getPostsDetail(){
			if(count($_POST)> 0){
				
				 $blog_id = $_POST['blog_id'];
				 $category_id = $_POST['category'];
				 $filePath = base_url().'wp-blog.php?blog_id='.$blog_id.'&&category='.$category_id;
				 //$wp_blogs = file_get_contents($filePath);
				  $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_URL => $filePath,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_SSL_VERIFYHOST => 0,
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Postman-Token: 766cb339-f979-4a7d-88cc-9b6dabf41402",
					"cache-control: no-cache"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				 // echo "cURL Error #:" . $err;
				} else {
				  $wp_blogs =  $response;
				}
				 $data['wp_blog_detail'] = json_decode($wp_blogs);
				//echo '<pre>'; print_r($data['wp_blog_detail']); die;
				 $this->load->view('admin/wp_blog_detail',$data);
			}
	}
	
	
	public function ajax_publish_records(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		$table_name = $_POST['table_name'];
		
		$published_field = 'published';
		if($table_name == "tbl_static_pages"){
			$published_field = 'is_display';
		}
		
		$this->db->where("id", $id);
		if($this->db->update($table_name, array($published_field => $pub)))
		{	
			echo 1;
		}
	}
	
	public function ajax_delete_record(){
		
		parse_str($_POST['formData'], $searcharray);
		
		$id = isset($searcharray['delete-item-id']) ? $searcharray['delete-item-id'] : 0;
		$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
		
		if(!empty($id) && !empty($table_name)){
			$this->db->where("id", $id);
			if($this->db->delete($table_name))
			{
				if($table_name == "tblcontact"){
					// check if multi location enabled
					$this->load->model('facility_model');
					$IsAllowMultiFacility = $this->facility_model->IsAllowMultiFacility();
					if($IsAllowMultiFacility){
						$this->db->where("location_id", $id);
						$this->db->delete("tblfacilities");
					}
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
	
	
	public function ajax_record_sort(){
		parse_str($_POST['serial'], $searcharray);
		
		$menu = isset($searcharray['menu']) ? $searcharray['menu'] : '';
		$table_name = isset($_POST['table_name']) ? $_POST['table_name'] : '';
		
		$extra_field = (isset($_POST['extra_field']) && !empty($_POST['extra_field'])) ? $_POST['extra_field'] : '';
		$extra_value = (isset($_POST['extra_value']) && !empty($_POST['extra_value'])) ? $_POST['extra_value'] : '';
		
		if(!empty($table_name) && !empty($menu) ){
			for ($i = 0; $i < count($menu); $i++) {	
			
				if(!empty($extra_field) &&  !empty($extra_value)){
					
					$this->db->query("UPDATE $table_name SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'   AND $extra_field ='" . $extra_value . "'  ") or die(mysqli_error($this->db->conn_id));
				
				}else{
					
					$this->db->query("UPDATE $table_name SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "' ") or die(mysqli_error($this->db->conn_id));
				}
				
			}
		}
		
	}
	
}