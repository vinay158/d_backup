<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('url');	
		$this->load->model("onlinedojo_user_model"); 
		
		$this->load->database();
			
	}
	
	
	
	
	public function index(){
		
		
		$password_setting = $this->query_model->getbyTable("tbl_password_pro");
						
						
		if($this->session->userdata('student_session_login') == 1 || $password_setting[0]->password_protection_type == "single"){
			redirect(base_url());
		}else{	
			
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			$data['page_title'] = 'Sign Up';
		
			$data['signup_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 55);
			$data['signup_slug'] = $data['signup_slug'][0];
			
			$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
			$data['student_section_slug'] = $data['student_section_slug'][0];
			
			//$data['url_query_string'] = (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) ? '?'.$_SERVER['QUERY_STRING'] : '';
			$this->load->view('online_user_signup', $data);
		}
	}
	
	
	public function save_new_user(){
		
		$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
		$data['student_section_slug'] = $data['student_section_slug'][0];
		$data['signup_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 55);
		$data['signup_slug'] = $data['signup_slug'][0];
		
		$password_setting = $this->query_model->getbyTable("tbl_password_pro");


		$request_status = 0;
		$requestReffer = (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		//echo '<pre>queryString'; print_r($_SERVER); die;
		
		if(!empty($requestReffer)){
			parse_str( $requestReffer, $queryString );
			
			if(isset($queryString['ps']) && !empty($queryString['ps'])){
				if($password_setting[0]->signup_unique_id == $queryString['ps']){
					$request_status = 1;
				}
			}
			
			
			if(isset($queryString['viewPage']) && !empty($queryString['viewPage']) && $request_status == 1){
				if($queryString['viewPage'] == $data['signup_slug']->slug){
					$request_status = 1;
				}else{
					$request_status = 0;
				}
			}
		}
		
		
		
		
		
		if($this->session->userdata('student_session_login') == 1 || $password_setting[0]->password_protection_type == "single"){
			redirect(base_url());
		}else{		
			
			if(isset($_POST['submit']) && !empty($_POST['submit']) && $request_status == 1){
			
				$user_unique_id = $this->uri->segment(3);
				
				if(!empty($user_unique_id)){
					
					
					$this->db->where('signup_appiled',0);
					$uniqueIdExists = $this->query_model->getBySpecific('tbl_form_unique_ids','unique_id',$user_unique_id);
					//echo '<pre>uniqueIdExists'; print_r($uniqueIdExists); die;
					if(!empty($uniqueIdExists)){
						
						
						$this->query_model->hunneyPotOnlinedojoSignup($_POST);
						
						$password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : '';
						
						$firstname = (isset($_POST['firstname']) && !empty($_POST['firstname'])) ? $_POST['firstname'] : '';
						$lastname = (isset($_POST['lastname']) && !empty($_POST['lastname'])) ? $_POST['lastname'] : '';
						$email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : '';
						$phone = (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : '';
						$location_id = (isset($_POST['location']) && !empty($_POST['location'])) ? $_POST['location'] : '';
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
						
						
						$data = array("firstname" => $firstname, "lastname" => $lastname,  "email" => $email, "phone" => $phone,   "location_id" => $location_id,"location" => $location,  "password" => sha1($password),  "published" => 1,"signup_type" => 'front', 'created'=>date('Y-m-d H:i:s'), 'modfied' => date('Y-m-d H:i:s'));
						
							
							
							if($this->query_model->insertData('tbl_onlinedojo_users',$data)):
								
								$updateUniqueIdData=array('signup_appiled'=>1);
								$this->db->where('unique_id',$user_unique_id);
								$this->db->update('tbl_form_unique_ids',$updateUniqueIdData);
								
								$emailTemplateDetail = $this->query_model->getBySpecific('tbl_users_email_templates','id',6);
								$data['password'] = $password;
								$data['useremail'] = $email;
								$this->onlinedojo_user_model->sendUserEmail($emailTemplateDetail,$data);
								
								$success_msg = 'Your have successfully created your account.<br>Please login below with your login detail.';
								$this->session->set_userdata('onlineuser_forgot_password_success', $success_msg);
								
								redirect($data['student_section_slug']->slug."/onlinedojo");
							endif;	
						
					}else{
						redirect(base_url());
					}
					
				}else{
					redirect(base_url());
				}
				
			}else{
				redirect(base_url());
			}
		}
		
	}
	
	
	public function generate_password($page_ac = "",$user_unique_id = ""){
		$user_unique_id =  $this->uri->segment(3); 
		$password_setting = $this->query_model->getbyTable("tbl_password_pro");
		
		if($this->session->userdata('student_session_login') == 1 || empty($user_unique_id) || $password_setting[0]->password_protection_type == "single"){
			redirect(base_url());
		}else{
			
			$userDetail = $this->query_model->getBySpecific('tbl_onlinedojo_users','user_unique_id',$user_unique_id);
			//echo '<pre>userDetail'; print_r($userDetail); die;
			if(!empty($userDetail)){
				
				$data['page_title'] = 'Generate Password';
		
				$data['signup_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 55);
				$data['signup_slug'] = $data['signup_slug'][0];
				
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];
				
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$error = '';
			if(isset($_POST['generate_password']) && !empty($_POST['generate_password'])){
				
				$new_password = (isset($_POST['new_password']) && !empty($_POST['new_password']) ) ? $_POST['new_password'] : '';
				$confirm_password = (isset($_POST['confirm_password']) && !empty($_POST['confirm_password']) ) ? $_POST['confirm_password'] : '';
				
				if(!empty($new_password) && !empty($new_password) && ($new_password == $confirm_password)){
					
					
					$userExists = $this->query_model->getbySpecific("tbl_onlinedojo_users",'user_unique_id',$user_unique_id);
					
					if(!empty($userExists)){
						
						$data = array("password" => sha1($new_password), 'modfied' => date('Y-m-d H:i:s'),'user_unique_id'=>'');
						
						if($this->query_model->update('tbl_onlinedojo_users',$userExists[0]->id,$data)){
							
							$formData = array(
											'firstname' => $userExists[0]->firstname,
											'lastname' => $userExists[0]->lastname,
											'useremail' => $userExists[0]->email,
											'phone' => $userExists[0]->phone,
											'location' => $userExists[0]->location,
											'password' => $new_password,
											);
							$emailTemplateDetail = $this->query_model->getBySpecific('tbl_users_email_templates','id',5);
							
							$this->onlinedojo_user_model->sendUserEmail($emailTemplateDetail,$formData);
							
							$success_msg = 'Your password was successfully generated.<br>Please login below with your new password.';
							$this->session->set_userdata('onlineuser_forgot_password_success', $success_msg);
							
							redirect($data['student_section_slug']->slug."/onlinedojo");
							
						}
						
						
					}else{
						$error .= 'Something went wrong. please try again';
					}
				}else{
					$error .= 'Your password and confirmation password do not match..';
				}
				
				if(!empty($error)){
					$this->session->set_userdata('onlineuser_forgot_password_error', $error);
					
					redirect($data['signup_slug']->slug.$page_ac.'/'.$user_unique_id);
				}
				
			}
			
				$this->load->view('user_generate_password', $data);
			}else{
				redirect(base_url());
			}
			
		}
		
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */