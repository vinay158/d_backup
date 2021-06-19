<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onlinedojo_users extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		if (!$this->session->userdata('is_logged_in'))
	        { 
	            redirect('/admin/login');
	        }
	       $this->load->model("onlinedojo_user_model"); 
		   
		}
	
	public function index()
	{
		
			redirect("admin/onlinedojo_users/view");
		
	}
	
	public function view($page = 1){
		
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if($this->session->userdata['user_level'] != 1){ 
		$usrePermissions = $this->query_model->getUserPermission($this->session->userdata('userid'));// vinay 19/11
		//echo '<pre>userpermission==>'; print_r($usrePermissions[0]->slug); die;
		if(strstr($usrePermissions[0]->slug, 'admin/onlinedojo_users')){
			
		}else{
			redirect("admin/dashboard");
		}
		
	} 
	
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Online Dojo User"; //title on view page
			$data['link_type'] = "onlinedojo_users"; //cotroller name
			//$this->db->order_by('id','desc');
			//$data['user'] = $this->query_model->getbyTable("tbl_onlinedojo_users");
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}

		$this->db->limit(1);
		$this->db->select("id");
		$this->db->order_by("id", "desc");
		$data['users_list'] = $this->query_model->getByTable('tbl_onlinedojo_users');
		
		/*$totalUsers = $this->query_model->getByTable('tbl_onlinedojo_users');
		$totalUsers = count($totalUsers);
		
		$config = array();
	
		$config['per_page']=20;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/onlinedojo_users/view'; 
		
		$config['total_rows'] = $totalUsers;
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		
		
		$this->db->order_by("id", "desc");
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$data['users_list'] = $this->pagination_model->fetch_data('tbl_onlinedojo_users',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		
		$number = ($page * $config['per_page']) - $config['per_page'];
		$data['number'] = $number + 1;*/
		
		$this->db->where("id", 1);
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		//echo '<pre>'; print_r($data); die;
		
		
		
		
		
		
			
			$this->db->order_by('id','asc');
			$this->db->select(array('id','title'));
			$data['email_templates'] = $this->query_model->getbyTable("tbl_users_email_templates");
			
			$data['userDetail'] = array();
			/*if($this->uri->segment(4) != ''){
				$data['userDetail'] = $this->query_model->getbySpecific('tbl_onlinedojo_users','id', $this->uri->segment(4));
				$data['userDetail'] = !empty($data['userDetail']) ? $data['userDetail'][0] : array();
			}*/
			$recordError = '';
			if(isset($_POST['update']) && !empty($_POST['update'])){
				
				$email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : '';
				
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$recordError .= 'Invalid Email Address!';
				}else{
					if($_POST['request_action'] == "add"){
					
						$exitRecord = $this->query_model->getbySpecific('tbl_onlinedojo_users','email', $email);
						if(empty($exitRecord)){
							$this->addUserSave($_POST);
						}else{
							$recordError .= 'Email Address already exists!';
						}
						
					}else{
						$request_id = (isset($_POST['request_id']) && !empty($_POST['request_id'])) ? $_POST['request_id'] : '';
						$this->db->where('id','!=',$request_id);
						$exitRecord = $this->query_model->getbySpecific('tbl_onlinedojo_users','email', $email);
						
						if(empty($exitRecord)){
							$this->updateUserSave($_POST,$request_id);
						}else{
							$recordError .= 'Email Address already exists!';
						}
					}
				}
				
			}
			
			$data['recordError'] = $recordError;
			//echo '<pre>recordError'; print_r($data); die;
			
			$this->load->view("admin/onlinedojo_users_index", $data);
			
			//echo '<pre>POST'; print_r($_POST); die;
		}
		else{
		redirect("admin/login");
		}
	}
	
	
	
	
	public function addUserSave($postData){
		
		if(!empty($postData)){
			$password = $this->randomPassword();
			$firstname = (isset($_POST['firstname']) && !empty($_POST['firstname'])) ? $_POST['firstname'] : '';
			$lastname = (isset($_POST['lastname']) && !empty($_POST['lastname'])) ? $_POST['lastname'] : '';
			$email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : '';
			
			$this->db->select(array('id','name'));
			$mainLocation = $this->query_model->getMainLocation("tblcontact");
			
			
			
			$data = array("firstname" => $firstname, "lastname" => $lastname,  "email" => $email,'location_id'=> $mainLocation[0]->id,'location'=> $mainLocation[0]->name,  "password" => sha1($password),  "published" => 1, 'created'=>date('Y-m-d H:i:s'), 'modfied' => date('Y-m-d H:i:s'));
				if($this->query_model->insertData('tbl_onlinedojo_users',$data)):
				
				$_POST['password'] = $password;
					$this->sendEmailForUser($_POST,1);
					
					redirect("admin/onlinedojo_users");
				endif;	
				
		}
	}
	
	public function updateUserSave($postData,$id){
		
		if(!empty($postData) && !empty($id)){
			$password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : '';
			$firstname = (isset($_POST['firstname']) && !empty($_POST['firstname'])) ? $_POST['firstname'] : '';
			$lastname = (isset($_POST['lastname']) && !empty($_POST['lastname'])) ? $_POST['lastname'] : '';
			$email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : '';
			
			if(!empty($password)){
				$data = array("firstname" => $firstname, "lastname" => $lastname,  "email" => $email,  "password" => sha1($password),  "published" => 1, 'created'=>date('Y-m-d H:i:s'), 'modfied' => date('Y-m-d H:i:s'));
			}else{
				$data = array("firstname" => $firstname, "lastname" => $lastname, 'modfied' => date('Y-m-d H:i:s'));
			}
			
				if($this->query_model->update('tbl_onlinedojo_users',$id,$data)):
				
					if(!empty($password)){
						$this->sendEmailForUser($_POST,2);
					}
					
					redirect("admin/onlinedojo_users");
				endif;	
				
		}
	}
	
	
	function sendEmailForUser($postData, $email_template_id){
		
		if(!empty($postData)){
			
			
			
			$formData['password'] = (isset($postData['password']) && !empty($postData['password'])) ? $postData['password'] : '';
			$formData['firstname'] = (isset($postData['firstname']) && !empty($postData['firstname'])) ? $postData['firstname'] : '';
			$formData['lastname'] = (isset($postData['lastname']) && !empty($postData['lastname'])) ? $postData['lastname'] : '';
			$formData['useremail'] = (isset($postData['email']) && !empty($postData['email'])) ? $postData['email'] : '';
			$formData['phone'] = (isset($postData['phone']) && !empty($postData['phone'])) ? $postData['phone'] : '';
			$formData['location'] = (isset($postData['location']) && !empty($postData['location'])) ? $postData['location'] : '';
			$formData['generate_password_link'] = (isset($postData['generate_password_link']) && !empty($postData['generate_password_link'])) ? $postData['generate_password_link'] : '';
			
			$emailTemplateDetail = $this->query_model->getBySpecific('tbl_users_email_templates','id',$email_template_id);
			
			$this->onlinedojo_user_model->sendUserEmail($emailTemplateDetail,$formData);
			
			
		}
		
	}
	
	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	
	

	public function deleteitem(){
		
		if($this->session->userdata['user_level'] != 1){ 
			$usrePermissions = $this->query_model->getUserPermission($this->session->userdata('userid'));// vinay 19/11
			//echo '<pre>userpermission==>'; print_r($usrePermissions[0]->slug); die;
			if(strstr($usrePermissions[0]->slug, 'admin/onlinedojo_users')){
				
			}else{
				redirect("admin/dashboard");
			}
			
		} 
		
		$id = $_POST['delete-item-id']; 
		$this->db->where("id", $id);
		if($this->db->delete("tbl_onlinedojo_users"))
		{
			
			$this->db->where('user_id',$id);
			$this->db->delete("tbl_student_attendance");
					
			redirect($this->index());
		}
		else
		{
			echo "<script language='javascript'>alert('Unable to delete user');</script>";
			redirect($this->index());
		}
	}
	
	public function publish(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		
		$this->db->where("id", $id);
		if($this->db->update("tbl_onlinedojo_users", array("published" => $pub)))
		{	
			echo 1;
			
		}
	}
	
	
	public function edit_onlineusers_email_template(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if( $this->uri->segment(4) != NULL ){							 
				$data['title'] = "Edit Email Template";
				
				$data['details'] = $this->query_model->getbySpecific('tbl_users_email_templates','id', $this->uri->segment(4));
				$data['details'] = $data['details'][0];
				
				if(isset($_POST['update'])):
				
						$postData['title'] = isset($_POST['title']) ? trim($_POST['title']) : '';
						$postData['subject'] = isset($_POST['subject']) ? trim($_POST['subject']) : '';
						$postData['description'] = isset($_POST['description']) ? trim($_POST['description']) : '';
						$postData['created'] = date('Y-m-d h:i:s');
						$this->query_model->updateData('tbl_users_email_templates','id',$this->uri->segment(4), $postData);	
						redirect("admin/onlinedojo_users/view");
				endif;	

				
				$this->load->view("admin/edit_onlineusers_email_template", $data);
				
			}else{
				redirect($this->index());
			}
		}else{
		redirect("admin/login");
		}
	}
	
	
	public function importUsers(){
		
		if(isset($_FILES['importCsv']['name']) && !empty($_FILES['importCsv']['name'])){
				$_FILES['importCsv']['name'] = time().$_FILES['importCsv']['name'];
				
				$ext = pathinfo($_FILES['importCsv']['name'], PATHINFO_EXTENSION);
				
				$allowedExt = array('csv');
				if(in_array($ext, $allowedExt)){
					
					if(is_uploaded_file($_FILES['importCsv']['tmp_name'])) {
						$sourcePath = $_FILES['importCsv']['tmp_name'];
						
						$targetPath = "upload/importCsv/".$_FILES['importCsv']['name'];
						
						if(move_uploaded_file($sourcePath,$targetPath)) {
							$csv_file = base_url()."upload/importCsv/".$_FILES['importCsv']['name'];
							$n = 1;
							if (($handle = fopen($csv_file, "r")) !== FALSE) {
								while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
									
									if(isset($row[3])  && !empty($row[3]) && $row[3] != "phone"){
										
										$importDataArr = array();
										$importDataArr['firstname'] = (isset($row[0]) && !empty($row[0])) ? $row[0] : '';
										$importDataArr['lastname'] = (isset($row[1]) && !empty($row[1])) ? $row[1] : '';
										$importDataArr['email'] = (isset($row[2]) && !empty($row[2])) ? $row[2] : '';
										$importDataArr['phone'] = (isset($row[3]) && !empty($row[3])) ? $row[3] : '';
										$importDataArr['location'] = (isset($row[4]) && !empty($row[4])) ? $row[4] : '';
										$importDataArr['signup_type'] = 'csv';
										$importDataArr['published'] = 1;
										$importDataArr['created'] = date('Y-m-d H:i:s');
										$importDataArr['modfied'] = date('Y-m-d H:i:s');
										
										
										$school = (isset($row[4]) && !empty($row[4])) ? trim($row[4]) : '';
										
										$mainLocation = $this->query_model->getMainLocation("tblcontact");
										if(!empty($mainLocation)){
										$importDataArr['location_id'] = $mainLocation[0]->id;
										}
										
										if(!empty($school)){
											if($school == "Virtual student only" ){
												$importDataArr['location_id'] = 'virtual_student_only';
											}else{
												$location_detail = $this->query_model->getbySpecific('tblcontact','name',$school); 
												 if(isset($location_detail[0]) && !empty($location_detail[0])){
													   $importDataArr['location_id'] = $location_detail[0]->id;
												 }
											}
											
										}
										
										
										$get_unique_id = $this->query_model->setAndGetUniqueNumberForCustomField();
										$user_unique_id = $get_unique_id.uniqid();
										$importDataArr['user_unique_id'] = $user_unique_id;
									
										$existRecord = $this->query_model->getbySpecific('tbl_onlinedojo_users','email',$importDataArr['email']);
										if(empty($existRecord)){
											
											$this->query_model->insertData('tbl_onlinedojo_users', $importDataArr);
											
											
											$importDataArr['generate_password_link'] = '<a href="'.base_url().'sign-up/generate-password/'.$user_unique_id.'">Generate Password</a>';
											$this->sendEmailForUser($importDataArr,4);
											
										}else{
											$updateUser=array('is_duplicate'=>1);
											$this->db->where('id',$existRecord[0]->id);
											$this->db->update('tbl_onlinedojo_users',$updateUser);
										}
										
										
									}
								}
							}
						}
					}
				}
				
			}
		redirect($base_url.'admin/onlinedojo_users');
	}
	
	
	
	public function deleteAllUsers(){
		
		if($this->session->userdata['user_level'] != 1){ 
			$usrePermissions = $this->query_model->getUserPermission($this->session->userdata('userid'));// vinay 19/11
			
			if(strstr($usrePermissions[0]->slug, 'admin/onlinedojo_users')){
				
			}else{
				redirect("admin/dashboard");
			}
			
		}
		
		if(isset($_POST['user_ids']) && !empty($_POST['user_ids'])){
			if(isset($_POST['table_name']) && !empty($_POST['table_name'])){
				foreach($_POST['user_ids'] as $user_id){
					
					
					$this->db->where('id',$user_id);
					if($this->db->delete($_POST['table_name'])){
						$this->db->where('user_id',$user_id);
						$this->db->delete("tbl_student_attendance");
					}
					
				}
			}
		}
		$redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url']  : 'admin/dashboard';
		redirect($redirect_url);
		
	}


	public function ajax_onlinedojo_user_edit(){
		$data = array();
		if(isset($_POST['action']) && $_POST['action'] == "edit_user"){
			
			
			$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
			
			if(!empty($user_id)){
				
				$data['user'] = $this->query_model->getBySpecific('tbl_onlinedojo_users','id',$user_id);
				
				$this->db->where('id',1);
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->db->where("published", 1);
				$this->db->where("location_type", 'regular_link');
				$this->db->select(array('id','name'));
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				
			}
			
		}
		
		$this->load->view('admin/ajax_onlinedojo_user_edit',$data);
	}


	public function updateOnlinedojoUser(){
		
		if(isset($_POST['update']) && !empty($_POST['update'])){
			
			$id = (isset($_POST['user_id']) && !empty($_POST['user_id'])) ? $_POST['user_id'] : '';
			$phone = (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : '';
			$firstname = (isset($_POST['firstname']) && !empty($_POST['firstname'])) ? $_POST['firstname'] : '';
			$lastname = (isset($_POST['lastname']) && !empty($_POST['lastname'])) ? $_POST['lastname'] : '';
			$location_id = (isset($_POST['location_id']) && !empty($_POST['location_id'])) ? $_POST['location_id'] : '';
			
			$location = '';
			if(!empty($location_id)){
				if($location_id == "virtual_student_only" ){
					$location = 'Virtual student only';
				}else{
					$location_detail = $this->query_model->getbySpecific('tblcontact','id',$location_id); 
					 if(isset($location_detail[0]) && !empty($location_detail[0])){
						   $location = $location_detail[0]->name;
					 }
				}
				
			}
			
			$data = array("firstname" => $firstname, "lastname" => $lastname,  "phone" => $phone,'location_id'=>$location_id,'location'=>$location, 'modfied' => date('Y-m-d H:i:s'));
			
			
				if($this->query_model->update('tbl_onlinedojo_users',$id,$data)):
					
					$this->onlinedojo_user_model->updateUserAttendaceRecords($id);
					
					redirect("admin/onlinedojo_users");
				endif;
		}
		
				
				
	}
	
	public function ajax_online_user_list(){
		
		if(isset($_POST['action']) && $_POST['action'] == "get_user"){
			
			$user_name = (isset($_POST['user_name']) && !empty($_POST['user_name'])) ? $_POST['user_name'] : '';
			$user_email = (isset($_POST['user_email']) && !empty($_POST['user_email'])) ? $_POST['user_email'] : '';
			$location = (isset($_POST['location_sort']) && !empty($_POST['location_sort'])) ? $_POST['location_sort'] : '';
			$per_page = (isset($_POST['sort_numbers']) && !empty($_POST['sort_numbers'])) ? $_POST['sort_numbers'] : '';
			
			
			/******** Getting resuls ***********/
			if(empty($location) && empty($user_name) && empty($user_email)){
				$default_per_page = 10;
				if(!empty($per_page)){
					if($default_per_page != $per_page){
						$this->db->limit($per_page);
					}else{
						$this->db->limit($default_per_page);
					}
					
				}
				
			}else{
				if(!empty($per_page)){
					
					/***** count total records ********/
					if(!empty($location)){
						$this->db->where('location_id', $location);
					}
					if(!empty($user_name)){
						$this->db->like('firstname', $user_name, 'after');
						$this->db->or_like('lastname', $user_name, 'after');
					}
					if(!empty($user_email)){
						$this->db->like('email', $user_email, 'after');
					}
					
					$data['total_records'] = $this->db->from("tbl_onlinedojo_users")->count_all_results();
					
					if($data['total_records'] <= $per_page){
						$this->db->limit($per_page);
					}
				}
			}
			
			
			if(!empty($location)){
				$this->db->where('location_id', $location);
			}
			if(!empty($user_name)){
				$this->db->like('firstname', $user_name, 'after');
				$this->db->or_like('lastname', $user_name, 'after');
			}
			if(!empty($user_email)){
				$this->db->like('email', $user_email, 'after');
			}
			$data['users_list'] = $this->query_model->getByTable('tbl_onlinedojo_users');
			//echo '<pre>data'; print_r($data); die;
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			$onlineuser_search_data = array('user_name' => $user_name,'location' => $location,'user_email' => $user_email,'per_page' => $per_page);
			
			$this->session->set_userdata('onlineuser_search_data',$onlineuser_search_data);
			
			$this->load->view('admin/ajax_online_user_list',$data);
			
		}
	}
	
}