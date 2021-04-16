<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('url');	
		$this->load->model("onlinedojo_user_model"); 
		
		$this->load->database();
			
	}
	
	
	public function checkstudentlogin(){
		
			if(isset($_POST['password'])){
				$password  =md5($_POST['password']);
				$location_id  =isset($_POST['location_id']) ? $_POST['location_id'] : '';
				//$checkpassword = $this->query_model->checkStudentPassword('tblcontact', $password, $location_id);
				$checkpassword = $this->query_model->checkStudentPassword('tbl_password_pro', $password);
				if(!empty($checkpassword)){
					$student_session_login = array('student_session_login' => 1);
					$this->session->set_userdata($student_session_login);
					echo '1';
				} else{
					
					echo '0';
				}
				
			}
	}
	
	
	public function checkstudentloginToEnterKey(){
			$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
			$data['student_section_slug'] = $data['student_section_slug'][0];
			
			
			if(isset($_POST['password'])){
				$password  =md5($_POST['password']);
				$location_id  =isset($_POST['location_id']) ? $_POST['location_id'] : '';
				
				$multi_student_password = $this->query_model->getbySpecific("tblconfigcalendar",'id',15);
				$multi_student_password = !empty($multi_student_password) ? $multi_student_password[0]->field_value : 0;
				
				if($multi_student_password == 1){
					$checkpassword = $this->query_model->checkMultiStudentPassword('tblcontact', $password, $location_id);
				}else{
					$checkpassword = $this->query_model->checkStudentPassword('tbl_password_pro', $password);
				}
				
				if(!empty($checkpassword)){
					$student_session_login = array('student_session_login' => 1);
					$this->session->set_userdata($student_session_login);
					$this->session->unset_userdata('onlineuser_error_message');
					
					$password_setting = $this->query_model->getbyTable("tbl_password_pro");
					if($password_setting[0]->virtual_training == 1){
						redirect($data['student_section_slug']->slug.'/virtualtraining');
					}else{
						redirect($data['student_section_slug']->slug);
					}
					
				} else{
					//$error_message =  'Password is wrong. please try again';
					
					$this->session->set_userdata('onlineuser_error_message', 1);
					
					redirect($data['student_section_slug']->slug.'/onlinedojo');
				}
				
			}
	}
	
	
	
	
	function logout(){
				
				$student_session_login = array('student_session_login' => 0);
				$this->session->set_userdata($student_session_login);
				//$this->session->unset_userdata('student_session_login');
				
				if($this->session->userdata('onlinedojo_user_detail')){
					$this->session->unset_userdata('onlinedojo_user_detail');
				}
				
				$this->db->select(array('login_check_fields'));
				$login_check_fields = $this->query_model->getbyTable("tblsite");
				if($login_check_fields[0]->login_check_fields == 0){
					redirect(base_url());
				}else{
					redirect(base_url().'students/onlinedojo');
				}
				
	}
	
	
	
	function index($page = 1){
				
			
			if($this->session->userdata('student_session_login') == 1){

				$password_setting = $this->query_model->getbyTable('tbl_password_pro');
				if($password_setting[0]->virtual_training == 1){
					redirect(base_url().'students/virtualtraining','location',301);
				}
			
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];
				
				$data['events_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 27);
				$data['events_slug'] = $data['events_slug'][0];
				
				$data['blogs_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 48);
				$data['blogs_slug'] = $data['blogs_slug'][0];
				
				$data['site_setting'] = $this->query_model->getbyTable('tblsite');
				
				
				
				$cu_date= date('Y-m-d',time());		
		
				$st = "c.mydate >='$cu_date'";
		
				$this->db->select('c.*, l.name, l.city');
		
				$this->db->from('tblcalendar c');
		
				$this->db->join('tblcontact l', 'l.id = c.location_id', 'left');
		
				$this->db->where($st, NULL, FALSE);  
				
				if($data['site_setting'][0]->event_category_type == "custom_categories"){
					$selected_catgories = unserialize($data['site_setting'][0]->event_show_categories);
					if(!empty($selected_catgories)){
						
						$this->db->where_in('category',$selected_catgories);
					
					}
					
				}
				
				$this->db->order_by("c.mydate", "ASC");
				$this->db->limit(5);		
				$query = $this->db->get();		
				$events = $query->result();
				$data['special_events'] = $query->result();

				$pending_events = 5 - count($events);

				if($pending_events >= 1){

				$this->db->where('date >=', date('Y-m-d'));
				//$this->db->order_by('timestamp', 'desc');
				$this->db->order_by('date', 'ASC');
				$this->db->limit($pending_events);
				$q = $this->db->get('tbl_calendar_dates');
				$special_event_tcd = $q->result_array();

				$special_event_c = array();
				foreach ($special_event_tcd as $value) {
					$result_data = $this->query_model->getbySpecific('tblcalendar', 'id', $value['event_id']);
					if(!empty($result_data)){
						$special_event_c[] = $result_data[0];
					}
					
				}

				$data['special_events'] = array_merge($data['special_events'], $special_event_c);
				
			}
			//echo '<pre>'; print_r($data['special_events']); die;
				
				// Get Home Page title from tbl_studentpagetitle
				$this->db->where('id', 1);
				$data['page_titles'] = $this->query_model->getbyTable('tbl_studentpagetitle');
				$data['page_titles'] = !empty($data['page_titles'])? $data['page_titles'][0]->title:'';
				
				
				
				$this->db->where('published', 1);
				$this->db->order_by("id", "DESC");
				$this->db->limit(5);
				$data['latest_downloads'] = $this->query_model->getbyTable('tbldownloads');
				
				$this->db->where('published', 1);
				$this->db->where('timestamp <=', date('Y-m-d'));
				//$this->db->order_by('timestamp', 'desc');
				$this->db->order_by('id', 'desc');
				$this->db->limit(5);
				$data['recents_news'] = $this->query_model->getbyTable('tblnews');
				$data['page_title'] = 'Student News';
				
				$config['base_url']= base_url().$data['student_section_slug']->slug.'/index'; 	
				$config['total_rows'] = $this->pagination_model->record_count('tblnews');
				$config['use_page_numbers'] = TRUE;
				$config['per_page'] = '5';
				$config['uri_segment'] = 3;
				
				$config['next_link'] = '<i class="fa fa-angle-double-left"></i>Older Post';
				$config['prev_link'] = 'Newer Post<i class="fa fa-angle-double-right"></i>';
				
				$config['num_links']=4;
				$config['num_tag_open'] = '<div class="hidden">';
				$config['num_tag_close'] = '</div>';
				$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
				
				$this->db->where('timestamp <=', date('Y-m-d'));
				$this->db->where('published', 1);
				$this->db->order_by('timestamp', 'desc');
				$data['student_news'] = $this->pagination_model->fetch_data('tblnews',$config["per_page"], $offset, $config['total_rows']);
				$config['total_rows']=$this->pagination_model->record_count('tblnews');;
				$this->pagination->initialize($config);
				$data['paginglinks'] = $this->pagination->create_links();
				
				
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->load->view('studentsection', $data);
				
				} else{
					redirect(base_url());
				}
	}
	
	
	
	function news($page = 1){
			if($this->session->userdata('student_session_login') == 1){	
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];
				
				
				// Get News Page title from tbl_studentpagetitle
				$this->db->where('id', 2);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
				$data['page_title'] = !empty($data['page_title'])? $data['page_title'][0]->title:'';	
				
				$config = array();
				
				$config['base_url']= base_url().$data['student_section_slug']->slug.'/news'; 	
				$config['total_rows'] = $this->pagination_model->record_count('tblnews');
				$config['use_page_numbers'] = TRUE;
				$config['per_page'] = '2';
				$config['uri_segment'] = 3;
				
				$config['next_link'] = '<i class="fa fa-angle-double-left"></i>Older Post';
				$config['prev_link'] = 'Newer Post<i class="fa fa-angle-double-right"></i>';
				
				$config['num_links']=4;
				$config['num_tag_open'] = '<div class="hidden">';
				$config['num_tag_close'] = '</div>';
				$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
				
				$this->db->where('timestamp <=', date('Y-m-d'));
				$this->db->where('published', 1);
				$this->db->order_by('timestamp', 'desc');
				$data['student_news'] = $this->pagination_model->fetch_data('tblnews',$config["per_page"], $offset, $config['total_rows']);
				$config['total_rows']=$this->pagination_model->record_count('tblnews');;
				$this->pagination->initialize($config);
				$data['paginglinks'] = $this->pagination->create_links();
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
					
					
				$this->load->view('student_news', $data);
				
				} else{
					redirect(base_url().'students/onlinedojo');
				}
	}
	
	
	
	function news_detail($id = ''){
			if($this->session->userdata('student_session_login') == 1){	
					$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
					$data['student_section_slug'] = $data['student_section_slug'][0];
					
					$data['blogs_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 48);
					$data['blogs_slug'] = $data['blogs_slug'][0];
					
					
						$data['news_detail'] = $this->query_model->getbySpecific('tblnews','slug', $this->uri->segment(3));
						
						$this->db->where('id <', $data['news_detail'][0]->id);
						$this->db->order_by("id","desc");
						$this->db->limit(1);
						$data['previos_news'] = $this->query_model->getbyTable("tblnews");
						
						$this->db->where('id >', $data['news_detail'][0]->id);
						$this->db->order_by("id","asc");
						$this->db->limit(1);
						$data['next_news'] = $this->query_model->getbyTable("tblnews");
						
						$this->db->where('published', 1);
						$this->db->where('timestamp <=', date('Y-m-d'));
						$this->db->order_by('id', 'desc');
						$this->db->limit(5);
						$data['recents_blogs'] = $this->query_model->getbyTable('tblblog');
						
						$this->db->where('published', 1);
						$this->db->order_by('timestamp', 'desc');
						$this->db->limit(5);
						$data['recents_news'] = $this->query_model->getbyTable('tblnews');
						
						
						$this->db->where("published", 1);
						$this->db->order_by("pos","asc");
						$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
						$data['site_settings'] = $this->query_model->getbyTable("tblsite");
						$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
						$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
						$this->load->view('student_news_detail', $data);
			
				} else{
					redirect(base_url().'students/onlinedojo');
				}
			
	}
	
	
	function videos_albums(){
		if($this->session->userdata('student_session_login') == 1){
			// Get Videos page title from tbl_studentpagetitle
				$this->db->where('id', 7);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
				$data['page_title'] = !empty($data['page_title'])? $data['page_title'][0]->title:'';

				//$data['page_title'] = 'Video Gallery';
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];
				
				
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->db->select('video_thread');
				$data['is_video_thread'] = $this->query_model->getByTable('tblsite');
				$data['is_video_thread'] = 	$data['is_video_thread'][0]->video_thread;
			
				if($data['is_video_thread'] == 1){
					$id = $this->uri->segment(3);
						if(!empty($id)){
							$data['type'] = 'inner_page';
							
							// category detail
							$catDetail = $this->query_model->getbySpecific('tblcategory', 'cat_id', $id);
							
							if(!empty($catDetail)){
								$data['album']['categoryDetail'] = $catDetail;
								
								// getting sub categories
								$this->db->where("published", 1);
								$this->db->order_by('pos', 'asc');
								$data['album']['sub_categories'] = $this->query_model->getbySpecific('tblcategory', 'parent_id', $catDetail[0]->cat_id);
								
								// gettind category download files
								
								$this->db->where('published',1);
								$data['album']['videos'] = $this->query_model->getbySpecific('tblmedia', 'category', $catDetail[0]->cat_id);
								
								// gettind category download files
								$data['brandcrumb'] = $this->query_model->getDownloadBrandcrumb($catDetail[0]->cat_id, 'videos');
								
								
								
							}else{
								redirect(base_url());
							}
						}else{
							$data['type'] = 'main_page';
							$this->db->where("published", 1);
							$this->db->where("parent_id", 0);
							$this->db->order_by('pos', 'asc');
							$categories =  $this->query_model->getbySpecific("tblcategory", "cat_type", 'videos');
							
							if(!empty($categories)){
								foreach($categories as $key => $cat){
									$data['albums'][$key]['categories'] = $cat;
									$data['albums'][$key]['sub_categories'] = $this->query_model->getbySpecific('tblcategory', 'parent_id', $cat->cat_id);
									
										
									// gettind category download files
									$data['albums'][$key]['videos'] = $this->query_model->getbySpecific('tblmedia', 'category', $cat->cat_id);
									
								}
								
								//echo '<pre>data'; print_r($data); die;
							}
							
						}
						//echo '<pre>data'; print_r($data); die;
						$this->load->view('student_video_albums_thread', $data);
				}else{
					$this->db->where('published', 1);
					$this->db->order_by('pos', 'asc');
					$data['video_albums'] = $this->query_model->getbySpecific("tblgalleryname", "category", 26);
					
					$this->load->view('student_video_albums', $data);
				}
				
				
				
				
	
		} else{
			redirect(base_url().'students/onlinedojo');
		}
	}
	
	function videos($id = ''){
			if($this->session->userdata('student_session_login') == 1){	
				
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];
				
				$this->db->where('published',1);
				$data['album_detail'] = $this->query_model->getbySpecific("tblgalleryname", "id", $this->uri->segment(3));
				
				if(empty($data['album_detail'])){
					redirect('students/videos_albums');
				}
				
				
				$this->db->order_by('pos', 'asc');
				$this->db->where('published',1);
				$data['videos'] = $this->query_model->getbySpecific("tblmedia", "album", $this->uri->segment(3));
				
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->load->view('student_videos', $data);
			
			} else{
				redirect(base_url().'students/onlinedojo');
			}
			
	}
	
	
	function contact(){
			if($this->session->userdata('student_session_login') == 1){

				// Get Contact page title from tbl_studentpagetitle
				$this->db->where('id', 5);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
				$data['page_title'] = !empty($data['page_title'])? $data['page_title'][0]->title:'';

				//$data['page_title'] = 'Contact Us';

				$this->db->where("published", 1);
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
				$this->load->view('student_contact', $data);
			
			} else{
				redirect(base_url().'students/onlinedojo');
			}
	
	}
	
	function downloads(){
			if($this->session->userdata('student_session_login') == 1){
				
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];

				// Get Downloads title from tbl_studentpagetitle
				$this->db->where('id', 4);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
				$data['page_title'] = !empty($data['page_title'])? $data['page_title'][0]->title:'';

				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->db->select('download_thread');
				$data['is_download_thread'] = $this->query_model->getByTable('tblsite');
				$data['is_download_thread'] = 	$data['is_download_thread'][0]->download_thread;
				
				if($data['is_download_thread'] == 1){
					$id = $this->uri->segment(3);
						if(!empty($id)){
							$data['type'] = 'inner_page';
							
							// category detail
							$catDetail = $this->query_model->getbySpecific('tblcategory', 'cat_id', $id);
							
							if(!empty($catDetail)){
								$data['downloads']['categoryDetail'] = $catDetail;
								
								// getting sub categories
								$this->db->where("published", 1);
								$this->db->order_by('pos', 'asc');
								$data['downloads']['sub_categories'] = $this->query_model->getbySpecific('tblcategory', 'parent_id', $catDetail[0]->cat_id);
								
								// gettind category download files
								$data['downloads']['downloadFiles'] = $this->query_model->getbySpecific('tbldownloads', 'category', $catDetail[0]->cat_id);
								
								// gettind category download files
								$data['brandcrumb'] = $this->query_model->getDownloadBrandcrumb($catDetail[0]->cat_id);
								
								
							}else{
								redirect(base_url());
							}
						}else{
							$data['type'] = 'main_page';
							$this->db->where("published", 1);
							$this->db->where("parent_id", 0);
							$this->db->order_by('pos', 'asc');
							$categories =  $this->query_model->getbySpecific("tblcategory", "cat_type", 'downloads');
							if(!empty($categories)){
								foreach($categories as $key => $cat){
									$data['downloads'][$key]['categories'] = $cat;
									$data['downloads'][$key]['sub_categories'] = $this->query_model->getbySpecific('tblcategory', 'parent_id', $cat->cat_id);
								}
							}
							
						}
						
						$this->load->view('student_downloads_thread', $data);
				}else{
					
					//$data['page_title'] = 'Downloadsdd';
					
					$this->db->where("published", 1);
					$this->db->order_by('pos', 'asc');
					$data['download_category'] =  $this->query_model->getbySpecific("tblcategory", "cat_type", 'downloads');
					
					
					$this->load->view('student_downloads', $data);
				}
				
				
			
			} else{
				redirect(base_url().'students/onlinedojo');
			}
	}
	
	function referral_rewards(){
			if($this->session->userdata('student_session_login') == 1){	
			
				// Get Referral Rewards title from tbl_studentpagetitle
				$this->db->where('id', 6);
				$data['page_title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
				$data['page_title'] = !empty($data['page_title'])? $data['page_title'][0]->title:'';

				//$data['page_title'] = 'Referral Rewards';
				$this->db->order_by('pos', 'asc');
				$data['referral_rewards'] = $this->query_model->getbyTable("tbloffers");
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->load->view('student_referral_rewards', $data);
				
			} else{
				redirect(base_url().'students/onlinedojo');
			}
	}
	
	
	function download_file($file_name){

		
		$image_name = $file_name;
		$image_path = $this->config->item('base_url') . "upload/downloads/$image_name";
		header('Content-Type: application/octet-stream');
		header("Content-Disposition: attachment; filename=$image_name");
		ob_clean();
		flush();
		readfile($image_path);


	}


function download_class_schedule_file($file_name){

		
			$image_name = $file_name;
			$image_path = $this->config->item('base_url') . "upload/class_schedule/$image_name";
			header('Content-Type: application/octet-stream');
			header("Content-Disposition: attachment; filename=$image_name");
			ob_clean();
			flush();
			readfile($image_path);
	}
	
	
public function thankyou(){
	$thankyouMessage = $this->session->userdata('thankyouMessage');
	
		if(!empty($thankyouMessage)){
			
			$data = $this->query_model->getThankyouPageData($thankyouMessage);
			
			$this->load->view('student_send_contact', $data);
		}else{
			redirect(base_url());
		}
}




	
	
	public function onlineDojoUserLogin(){
			$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
			$data['student_section_slug'] = $data['student_section_slug'][0];
			
			if(isset($_POST['login']) && !empty($_POST['login'])){
				$password  = isset($_POST['password']) ? sha1(trim($_POST['password'])) : '';
				$username =  isset($_POST['username']) ? trim($_POST['username']) : '';
				
				$this->db->where('email',$username);
				$this->db->where('password',$password);
				$userExists = $this->query_model->getbySpecific("tbl_onlinedojo_users", "published", 1);
				//echo '<pre>userExists'; print_r($userExists); die;
				if(!empty($userExists)){
					$student_session_login = array('student_session_login' => 1);
					$this->session->set_userdata($student_session_login);
					
					$userExists = $userExists[0];
					$onlinedojo_user_detail = array('onlinedojo_user_detail' => $userExists);
					$this->session->set_userdata($onlinedojo_user_detail);
					
					$this->session->unset_userdata('onlineuser_error_message');
					
					$password_setting = $this->query_model->getbyTable("tbl_password_pro");
					if($password_setting[0]->virtual_training == 1){
						redirect($data['student_section_slug']->slug.'/virtualtraining');
					}else{
						redirect($data['student_section_slug']->slug);
					}
					
				} else{					
					$this->session->set_userdata('onlineuser_error_message', 1);
					redirect($data['student_section_slug']->slug.'/onlinedojo');
				}
				
			}
	}
	
	
	function onlinedojo_logout(){
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];
			
				$student_session_login = array('student_session_login' => 0);
				$this->session->set_userdata($student_session_login);
				//$this->session->unset_userdata('student_session_login');
				$this->session->unset_userdata('onlinedojo_user_detail');
				
				//$this->session->sess_destroy();
				redirect($data['student_section_slug']->slug.'/virtualtraining');
	}
	
	
	function onlinedojo(){
		
			$data['page_title'] = 'Video Training Library';
			$data['page_slug'] = 'onlinedojo';
			
			$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
			$data['student_section_slug'] = $data['student_section_slug'][0];
			
			$this->db->order_by('pos', 'asc');
			$data['videos'] = $this->query_model->getbySpecific("tbl_onlinedojo_videos", "published", 1);
			
			
			$this->db->where('published', 1);
			$this->db->order_by('pos', 'asc');
			$data['video_albums'] = $this->query_model->getbySpecific("tbl_onlinedojo_galleryname", "category", 26);
			
			
			$this->db->where("published", 1);
			$this->db->order_by("pos","asc");
			
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			$data['password_setting'] = $this->query_model->getbyTable("tbl_password_pro");
			
			$data['is_mobile'] = 0;
			$useragent=$_SERVER['HTTP_USER_AGENT'];
			if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
				$data['is_mobile'] = 1;
			}
			
			$this->load->view('onlinedojo_videos', $data);
			
	}
	
	public function virtualtraining($slug = ""){
		
		if($this->session->userdata('student_session_login') == 1){	
			
			$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
			$data['student_section_slug'] = $data['student_section_slug'][0];
			
			
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			if(empty($slug)){
				
				$data['detail'] = $this->query_model->getbyTable("tbl_virtual_training");
		
				$this->db->where('published',1);
				$this->db->order_by('pos','asc');
				$data['virtual_training_rows'] = $this->query_model->getbyTable("tbl_virtual_training_rows");
				
				$this->load->view('virtual_training', $data);
			}else{
				
				$this->db->where('published',1);
				$this->db->where('slug',$slug);
				$this->db->order_by('pos','asc');
				$data['detail'] = $this->query_model->getbyTable("tbl_virtual_training_rows");
				
				$data['virtual_training'] = $this->query_model->getbyTable("tbl_virtual_training");
				if(empty($data['detail'])){
					redirect($data['student_section_slug']->slug.'/virtual_training');
				}else{
					
					$this->db->where("rows_id", $data['detail'][0]->id);
					$data['times'] = $this->query_model->getbyTable('tbl_virtual_training_rows_time');
		
					$this->load->view('virtual_training_row_detail', $data);
				}
			}
			
		
		}else{
			redirect(base_url().'students/onlinedojo');
		}
	}
	
	public function forgot_password(){
		
		if($this->session->userdata('student_session_login') == 1){	
		
			redirect(base_url());
		}else{
			$data['page_title'] = 'Forgot Password';
		
			$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
			$data['student_section_slug'] = $data['student_section_slug'][0];
			
			
			$this->db->where("published", 1);
			$this->db->order_by("pos","asc");
			
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			$data['site_settings'] = $this->query_model->getbyTable("tblsite");
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			
			$error = '';
			if(isset($_POST['forgot_password']) && !empty($_POST['forgot_password'])){
				
				$username = (isset($_POST['username']) && !empty($_POST['username']) ) ? $_POST['username'] : '';
				$new_password = (isset($_POST['new_password']) && !empty($_POST['new_password']) ) ? $_POST['new_password'] : '';
				$confirm_password = (isset($_POST['confirm_password']) && !empty($_POST['confirm_password']) ) ? $_POST['confirm_password'] : '';
				
				if(!empty($username) && !empty($new_password)){
					//$password = sha1(trim($new_password));
					$this->db->where('email',$username);
					$userExists = $this->query_model->getbySpecific("tbl_onlinedojo_users", "published", 1);
					
					if(!empty($userExists)){
						
						$data = array("password" => sha1($new_password), 'modfied' => date('Y-m-d H:i:s'));
						
						if($this->query_model->update('tbl_onlinedojo_users',$userExists[0]->id,$data)){
							
							$formData = array(
											'firstname' => $userExists[0]->firstname,
											'lastname' => $userExists[0]->lastname,
											'useremail' => $userExists[0]->email,
											'password' => $new_password,
											);
							$emailTemplateDetail = $this->query_model->getBySpecific('tbl_users_email_templates','id',3);
							
							$this->onlinedojo_user_model->sendUserEmail($emailTemplateDetail,$formData);
							
							$success_msg = 'Your password was successfully updated.<br>Please login below with your new password.';
							$this->session->set_userdata('onlineuser_forgot_password_success', $success_msg);
							
							redirect($data['student_section_slug']->slug."/onlinedojo");
							
						}
						
						
					}else{
						$error .= 'Email address not exists';
					}
				}else{
					$error .= 'Please fill required fields';
				}
				
			}
			
			if(!empty($error)){
				$this->session->set_userdata('onlineuser_forgot_password_error', $error);
				
				redirect($data['student_section_slug']->slug.'/forgot_password');
			}
			
			
			$this->load->view('online_user_forgot_password', $data);
		}
		
	}
	
	
	function academy_videos(){
		if($this->session->userdata('student_session_login') == 1){
			
			$this->db->select(array('academy_videos'));
			$academy_videos = $this->query_model->getbyTable('tblsite');
			
			$this->db->limit(1);
			$this->db->select('id');
			$this->db->where('published',1);
			$academy_video_ablums = $this->query_model->getbyTable('tbl_academy_galleryname');
			
				if($academy_videos[0]->academy_videos == 0 || empty($academy_video_ablums)){
					redirect(base_url());
				}
			// Get Videos page title from tbl_studentpagetitle
				$this->db->where('id', 8);
				$data['page_detail'] = $this->query_model->getbyTable('tbl_studentpagetitle');
				$data['page_title'] = !empty($data['page_detail'])? $data['page_detail'][0]->title:'';
				$data['page_desc'] = !empty($data['page_detail'])? $data['page_detail'][0]->description:'';

				//$data['page_title'] = 'Video Gallery';
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];
				
				
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->db->select('video_thread');
				$data['is_video_thread'] = $this->query_model->getByTable('tblsite');
				$data['is_video_thread'] = 	$data['is_video_thread'][0]->video_thread;
				
				
				$this->db->where("published", 1);
				$this->db->order_by("pos", "ASC");
				$data['week_academy_pages'] = $this->query_model->getbyTable('tbl_8_week_academy');
			
				/*$this->db->where('published', 1);
				$this->db->order_by('pos', 'asc');
				$data['video_albums'] = $this->query_model->getbySpecific("tbl_academy_galleryname", "category", 26);*/
				
				$this->load->view('student_academy_video_albums', $data);
				
				
				
				
	
		} else{
			redirect(base_url().'students/onlinedojo');
		}
	}
	
	
	function video($id = ''){
		
			if($this->session->userdata('student_session_login') == 1){	
				
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];
				$data['back_link'] = 'academy_videos';
				
				$this->db->where('published',1);
				$data['album_detail'] = $this->query_model->getbySpecific("tbl_academy_galleryname", "id", $this->uri->segment(3));
				
				if(empty($data['album_detail'])){
					redirect('students/academy_videos');
				}
				
				
				$this->db->order_by('pos', 'asc');
				$this->db->where('published',1);
				$data['videos'] = $this->query_model->getbySpecific("tbl_academy_media", "album", $this->uri->segment(3));
				
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->load->view('student_videos', $data);
			
			} else{
				redirect(base_url().'students/onlinedojo');
			}
			
	}
	
	
	function onlinedojo_video_album($id = ''){
		
			if($this->session->userdata('student_session_login') == 1){	
				
				$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
				$data['student_section_slug'] = $data['student_section_slug'][0];
				$data['back_link'] = 'onlinedojo';
				
				$this->db->where('published',1);
				$data['album_detail'] = $this->query_model->getbySpecific("tbl_onlinedojo_galleryname", "id", $this->uri->segment(3));
				
				if(empty($data['album_detail'])){
					redirect('students/onlinedojo');
				}
				
				
				$this->db->order_by('pos', 'asc');
				$this->db->where('published',1);
				$data['videos'] = $this->query_model->getbySpecific("tbl_onlinedojo_media", "album", $this->uri->segment(3));
				
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				$this->load->view('student_videos', $data);
			
			} else{
				redirect(base_url().'students/onlinedojo');
			}
			
	}
	
	
	public function studentZoomAttendance(){
		
		if($this->session->userdata('student_session_login') == 1){
			
			$password_setting = $this->query_model->getbyTable("tbl_password_pro");
		
			if($password_setting[0]->password_protection_type == "multiple"){
				if(isset($_POST['action']) && $_POST['action'] == "zoom_record"){
					
					$zoom_metting_id = (isset($_POST['zoom_metting_id']) && !empty($_POST['zoom_metting_id'])) ? $_POST['zoom_metting_id'] : '';
					$user_id = (isset($_POST['user_id']) && !empty($_POST['user_id'])) ? $_POST['user_id'] : '';
					$user_name = (isset($_POST['user_name']) && !empty($_POST['user_name'])) ? $_POST['user_name'] : '';
					$class_id = (isset($_POST['class_id']) && !empty($_POST['class_id'])) ? $_POST['class_id'] : '';
					$class_name = (isset($_POST['class_name']) && !empty($_POST['class_name'])) ? $_POST['class_name'] : '';
					$today_weekday = (isset($_POST['today_weekday']) && !empty($_POST['today_weekday'])) ? $_POST['today_weekday'] : '';
					$location_id = (isset($_POST['location_id']) && !empty($_POST['location_id'])) ? $_POST['location_id'] : '';
					$location = (isset($_POST['location']) && !empty($_POST['location'])) ? $_POST['location'] : '';
					$attendance_date = date('Y-m-d');
					
					if(!empty($zoom_metting_id) && !empty($user_id) && !empty($today_weekday)){
						
						$this->db->where('attendance_date',$attendance_date);
						$this->db->where('today_weekday',$today_weekday);
						$this->db->where('zoom_metting_id',$zoom_metting_id);
						$existsAttendance = $this->query_model->getBySpecific('tbl_student_attendance','user_id',$user_id);
						
						if(empty($existsAttendance)){
							$requestData = array(
												'user_id' => $user_id,
												'user_name' => $user_name,
												'zoom_metting_id' => $zoom_metting_id,
												'class_id' => $class_id,
												'class_name' => $class_name,
												'today_weekday' => $today_weekday,
												'attendance_date' => $attendance_date,
												'location_id' => $location_id,
												'location' => $location,
												'attendance_time' => date('H:i:s'),
												'created' => date('Y-m-d H:i:s')
												);
							//echo '<prE>requestData'; print_r($requestData);
							$this->query_model->insertData('tbl_student_attendance',$requestData);
							echo 'successfull added this attendance!';
						}else{
							echo 'already exists this record!';
						}
						
					}
					
				}
			}
		}
		
	}
	
	public function edit_profile(){
		$error = 0;
		if($this->session->userdata('student_session_login') == 1){
			
			$this->db->select('password_protection_type');
			$isMultiUser = $this->query_model->getByTable('tbl_password_pro');
			
			if($isMultiUser[0]->password_protection_type == "multiple"){
				$userDetail = $this->session->userdata('onlinedojo_user_detail');
				
				if(!empty($userDetail)){
					
					$user_id = $userDetail->id;
					$data['user'] = $this->query_model->getbySpecific('tbl_onlinedojo_users', 'id', $user_id);
					$data['user'] = $data['user'][0];
					
					$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
					$data['site_settings'] = $this->query_model->getbyTable("tblsite");
					$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
					$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
					
					$data['page_title'] = 'Edit Profile';
				
					$data['signup_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 55);
					$data['signup_slug'] = $data['signup_slug'][0];
					
					$data['student_section_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 47);
					$data['student_section_slug'] = $data['student_section_slug'][0];
					
					
					if(isset($_POST['submit']) && !empty($_POST['submit'])){
						
						$phone = (isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : '';
						$firstname = (isset($_POST['firstname']) && !empty($_POST['firstname'])) ? $_POST['firstname'] : '';
						$lastname = (isset($_POST['lastname']) && !empty($_POST['lastname'])) ? $_POST['lastname'] : '';
						$location_id = (isset($_POST['location']) && !empty($_POST['location'])) ? $_POST['location'] : '';
						$password = (isset($_POST['password']) && !empty($_POST['password']) ) ? $_POST['password'] : '';
						$confirm_password = (isset($_POST['confirm_password']) && !empty($_POST['confirm_password']) ) ? $_POST['confirm_password'] : '';
						
						/*$location = '';
						if(!empty($location_id)){
							if($location_id == "virtual_student_only" ){
								$location = 'Virtual student only';
							}else{
								$location_detail = $this->query_model->getbySpecific('tblcontact','id',$location_id); 
								 if(isset($location_detail[0]) && !empty($location_detail[0])){
									   $location = $location_detail[0]->name;
								 }
							}
							
						}*/
				
					//echo $password.'==>'. $confirm_password;die;
						if(!empty($password) && !empty($confirm_password)){
							
							if($password == $confirm_password){
								$data = array("firstname" => $firstname, "lastname" => $lastname,"password" => sha1($password),  "phone" => $phone, 'modfied' => date('Y-m-d H:i:s'));
								
								$this->session->set_userdata('edit_profile_success_message', "successfully updated your profile with new password.");
							}else{
								$this->session->set_userdata('edit_profile_error_message', "Your password and confirmation password do not match..");
								redirect(base_url().'students/edit_profile');
							}
						}else{
							$data = array("firstname" => $firstname, "lastname" => $lastname,  "phone" => $phone, 'modfied' => date('Y-m-d H:i:s'));
							
							$this->session->set_userdata('edit_profile_success_message', "successfully updated your profile.");
						}
						
						
							if($this->query_model->update('tbl_onlinedojo_users',$user_id,$data)):
								
								
								redirect(base_url().'students/edit_profile');
							endif;
					}
					
					$this->load->view('online_user_edit_profile', $data);
				}else{
					$error = 1;
				}
			}else{
				$error = 1;
			}
		}else{
			$error = 1;
		}
		
		if($error == 1){
			redirect(base_url());
		}
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */