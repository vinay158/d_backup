<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* changelog v2 - addcalendar function modified - 15 June 2013 */

class Menu_model extends CI_Model{
	
	var $table = 'tblmenus';
	
	function getallpage(){
		return $this->query_model->getbyTable($this->table);
	}
	
	
	function getPagebyCat($id){
		return $this->query_model->getbySpecific($this->table, "parent", $id);
	}
	
	function addmenu(){
		
		$title = trim($_POST['title']);
		$content = htmlentities($_POST['content']);
		$published = $_POST['published'];
		
		
		
				
				
				
	
		if($title == NULL):
			$title = "menu ".$this->countpage();
		endif;
		
		$x = $this->checkduplicate($title);
		if($x > 0):		
			$title = $title." ".($x+1);
		endif;
		
		$data = array(
			'title' => $title,
			'content' => $content,
			'published' => $published
			
		);
		
		if($this->query_model->insertData($this->table,$data)):
			//redirect("admin/page");
			return true;		
		endif;
		
	
		
	}
	
	
	function updatemenu(){
		$title = trim($_POST['title']);
		$content = htmlentities($_POST['content']);
		$published = $_POST['published'];
		
		
		
		
		
		
		
		
			$data = array(
			'title' => $title,
			'content' => $content,
			'published' => $published
		);
		
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
				//redirect("admin/page");
			endif;	
	}
	
	
	function updatemenuPageTitle(){
		
		$title = trim($_POST['title']);
		
		if(isset($_POST['status'])){
			$status = $_POST['status'];
		} else {
			$status = 0;
		}

		$new_tab = isset( $_POST['new_tab'] ) ? $_POST['new_tab']:0;
		
		//print_r($_POST['status']); die;
		
		
		
		
		
		
		$slug = str_replace(' ', '-', $_POST['slug']);
		
		//$slug = strtolower($slug);
		
		if($slug == ''){
			$slug = str_replace(' ', '-', $_POST['title']);
			$slug = strtolower($slug);	
			}
		
		
			$data = array('title' => $title, 'slug' => $slug, 'status' => $status, 'new_tab' => $new_tab);
			
			//print_r($data); die;
		
			if($this->query_model->update('tblmenupages',$this->input->post('id'),$data)):
				//redirect("admin/page");
			endif;	
	}
	
	
	
	function checkduplicate($title){
		$this->db->where("title",$title);
		return count($this->db->get($this->table)->result());	
	}
	
	
	function insertMenuPage(){
		
		//echo '<pre>'; print_r($_POST); die;
			$page_id = $_POST['page_id'];
			$menu_id = $_POST['menu_id'];
			
			$count = 2;
			$data=array(
                'page_id'=>$_POST['page_id'],
                'menu_id'=>$_POST['menu_id']
            );
			
			 
			
			foreach($_POST['page_id'] as $pages){
					$this->db->insert('tblmenupages', $data);
				}
			
			
		}
	
	function updatefaq(){
		$title = $_POST['title'];

		$content = $_POST['ques'];		
		$ques = htmlentities($content);
				
		$content = $_POST['ans'];		
		$ans = htmlentities($content);		
		
		$pub = $_POST['published'];
		$data = array("title" => $title, "ques" => $ques, "ans" => $ans, "published" => $pub);
		if($this->query_model->update("tblfaq",$this->uri->segment(4),$data)):
			if($_POST['redirect']){
				redirect("admin/faq/".$_POST['redirect']);
			}else{
				redirect("admin/faq");
			}	
		endif;
	}
	
	
	
	public function getCmsSubPages($id, $menu_id){
	
			$is_logged_in = $this->session->userdata('is_logged_in');
			//print_r($this->input->post()); die;
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
			//$id = $this->input->post('id');
			//$mainMenuUrl = $this->input->post('mainMenuUrl');
			//$menu_id = $this->input->post('menu_id');
			$child_sub_cls = 'nav-sub-item ';
			$child_sub_link_cls = ' nav-sub-link ';
			$getAllMultiLocation = $this->query_model->getAllMultiLocation();
			
			$getCmsSubPages = $this->db->query("select id, title, slug from tblmenupages where parent_id = '".$id."' AND `menu_id` = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
			
			$this->db->where("id",$this->input->post('id'));
			$result = $this->db->get("tblmenupages")->result_array();
			
		//	echo '<div style="" id="more-nav-holder" style="display:none" class="'.$id.'">';
			
			//echo '<input type="hidden" value="1" id="temp_nav_holder" name="temp_nav_holder">';
			//echo '<div class=" sub-nav">';
			// vinay 19/11
			$usrePermissions = $this->query_model->getUserPermission($this->session->userdata('userid'));
			
			echo '<ul class="nav-sub">';
			if(count($getCmsSubPages) > 0){
			
				// vinay 04/12
				//echo '<li class="mainTabName">'.$result[0]['title'].' : '.'</li>';
				
				$this->session->set_userdata('pageId', $id); // vinay 16/11
				//$this->session->set_userdata('mainMenuUrl', $mainMenuUrl);
			}
			
			/** vinay 04/12 **/
			$chargifyApiDisplay = 0;
			$this->db->select('type');
			$chargifyApi = $this->query_model->getbySpecific('tbl_chargify', 'id', 1);
			if(!empty($chargifyApi) && $chargifyApi[0]->type == 1){
				$chargifyApiDisplay = 1;
			}
			
			$this->db->select('email_marketing');
			$email_marketing_setting = $this->query_model->getByTable('tblsite');
			
			$email_marketingDisplay = (!empty($email_marketing_setting) && $email_marketing_setting[0]->email_marketing == 1) ? 1 : 0;
			
			$this->db->select('password_protection_type');
			$password_setting = $this->query_model->getbyTable("tbl_password_pro");
			
			
			$this->db->select('video_thread');
			$is_video_thread = $this->query_model->getByTable('tblsite');
			$is_video_thread = 	$is_video_thread[0]->video_thread;
			
			if($id != 183){
				foreach($getCmsSubPages as $subPages){
					$activeTabPageCls = '';
					if($this->session->userdata("subPageUrlSlug") == $subPages['slug']){ $activeTabPageCls = 'activeTabPageCls'; }
					if($this->session->userdata('user_level') != 1){
						if(strstr($usrePermissions[0]->slug, $subPages['slug'])){
							if($subPages['slug'] == "admin/chargify_api"){
								if($chargifyApiDisplay == 1){
							
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/email_marketing"){
								if($email_marketingDisplay == 1){
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/leads/cartorders"){
								$show_cartorder_lead = $this->query_model->showCartOrderLeadTab();
								
								if($show_cartorder_lead == 1){
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/leads/webhook_leads"){
								$show_webhook_lead = $this->query_model->showWebhookOrderLeadTab();
								
								if($show_webhook_lead == 1){
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/leads/orders_email_only_leads"){
								/*echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>'; */
							}elseif($subPages['slug'] == "admin/gallery"){
								if($is_video_thread == 0){
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/albums/view"){
								if($is_video_thread == 1){
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/onlinedojo_users"){
								if($password_setting[0]->password_protection_type == "multiple"){
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/sparkpost_mail"){
								$sparkpost_api_is_active = $this->query_model->checkSparkpostApiIsActive();
								
								if($sparkpost_api_is_active == 1){
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}else{
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';

							}
						}
					}else{
						if($subPages['slug'] == "admin/chargify_api"){
							if($chargifyApiDisplay == 1){
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/email_marketing"){
							if($email_marketingDisplay == 1){
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/leads/cartorders"){
							$show_cartorder_lead = $this->query_model->showCartOrderLeadTab();
							if($show_cartorder_lead == 1){
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/leads/webhook_leads"){
							$show_webhook_lead = $this->query_model->showWebhookOrderLeadTab();
							
							if($show_webhook_lead == 1){
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/leads/orders_email_only_leads"){
								/*echo '<li class="'.$child_sub_cls.'"><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>'; */
						}elseif($subPages['slug'] == "admin/gallery"){
							if($is_video_thread == 0){
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/albums/view"){
							if($is_video_thread == 1){
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/sparkpost_mail"){
							$sparkpost_api_is_active = $this->query_model->checkSparkpostApiIsActive();
							
							if($sparkpost_api_is_active == 1){
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}else{
							echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
							echo $subPages['title'];
							echo '</a></li>';
						}
						
					}
				}
			} else{
				
				$this->db->where('id',12);
				$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
			
				$multiSchool = isset($multiSchool[0]) ? $multiSchool[0]->field_value : 0;
				
				$multi_about_us = $this->query_model->multi_about_us();
				
					if($getAllMultiLocation[0]['field_value'] == 1 && $multiSchool == 0 && $multi_about_us == 1){
					
								$this->db->where("published", 1);
								$this->db->where("location_type", 'regular_link');
								$this->db->order_by("pos","asc");
								$this->db->select(array("id","name"));
								$locations = $this->query_model->getbyTable("tblcontact");
								
								foreach($locations as $location){
									$activeTabPageCls = '';
									if($location->id == $this->session->userdata("aboutLocation_id")){
										$activeTabPageCls = 'activeTabPageCls';
									}
									echo ' <li class="'.$child_sub_cls.'"><a  href="'.'admin/about/'.$location->id.'" slug="'.'admin/about/'.$location->id.'" class="cms_menu_url AboutMultiLocation '.$child_sub_link_cls.' '.$activeTabPageCls.'" location_id="'.$location->id.'">'.$location->name.'</a></li>';
									//echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									
						}
					} else {
							$this->db->select(array("id","name"));
							$this->db->where('main_location', 1);
							$my_mainLocation = $this->db->get('tblcontact')->result();
							
							$my_mainLocation = $my_mainLocation[0]->id;
						foreach($getCmsSubPages as $subPages){
							$activeTabPageCls = '';
							$aboutPageUrl = $subPages['slug'].'/multilocation/'.$my_mainLocation;
							if($this->session->userdata("subPageUrlSlug") == $aboutPageUrl){ $activeTabPageCls = 'activeTabPageCls'; }
							if($this->session->userdata('user_level') != 1){
								if(strstr($usrePermissions[0]->slug, $subPages['slug'])){
									if($subPages['slug'] == 'admin/about/about_header' || $subPages['slug'] == 'admin/video' || $subPages['slug'] == 'admin/about/ourschool' || $subPages['slug'] == 'admin/staff' || $subPages['slug'] == 'admin/seotext' || $subPages['slug'] == 'admin/setting/apikeys' || $subPages['slug'] == 'admin/setting/instagramapikeys' || $subPages['slug'] == 'admin/about/about_the_ata' || $subPages['slug'] == 'admin/about/about_us' || $subPages['slug'] == 'admin/email_options/about_email_option1' || $subPages['slug'] == 'admin/email_options/about_email_option2'){
										
										echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'"  slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'"  class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									} else {
										echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages 2 '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
								}
							}else{
									$this->db->select(array("id","name"));
									$this->db->where('main_location', 1);
									$my_mainLocation = $this->db->get('tblcontact')->result();
									
									$my_mainLocation = $my_mainLocation[0]->id;
									$aboutPageUrl = $subPages['slug'].'/multilocation/'.$my_mainLocation;
									if($this->session->userdata("subPageUrlSlug") == $aboutPageUrl.'/multilocation/'.$my_mainLocation){
										$activeTabPageCls = 'activeTabPageCls';
									}
									if($subPages['slug'] == 'admin/about/about_header' || $subPages['slug'] == 'admin/video' || $subPages['slug'] == 'admin/about/ourschool' || $subPages['slug'] == 'admin/staff' || $subPages['slug'] == 'admin/seotext' || $subPages['slug'] == 'admin/setting/apikeys' || $subPages['slug'] == 'admin/setting/instagramapikeys' || $subPages['slug'] == 'admin/about/about_the_ata' || $subPages['slug'] == 'admin/about/about_us' || $subPages['slug'] == 'admin/email_options/about_email_option1' || $subPages['slug'] == 'admin/email_options/about_email_option2'){
										
										echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'"  slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'"  class="cms_menu_url subPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									} else {
										echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url subPages 2 '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
							}
						}
					}
			}
			echo '</ul>';
			//echo '</div>'; 
			
		}else{ 
			redirect('admin/login');
		}	
	
	}

public function setAboutMultiLocationChildPages($id,$menu_id,$location_id){
	
	
			$is_logged_in = $this->session->userdata('is_logged_in');
			//print_r($this->input->post()); die;
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
			//$id = $this->input->post('pageId');
			//$menu_id = $this->input->post('menu_id');
			//$location_id = $this->input->post('location_id');
			
			$child_sub_cls = 'nav-sub-item ';
			$child_sub_link_cls = ' nav-sub-link ';
			
			$this->db->select(array("id","name"));
			$location_detail = $this->query_model->getbyId('tblcontact', $location_id);
			
			$getIsMultiStaff = $this->query_model->getIsMultiStaff();
			
			$getIsMultiSocialFeeds = $this->query_model->getIsMultiSocialFeeds();
			
			$getAllMultiLocation = $this->query_model->getAllMultiLocation();
			
			
			$getCmsSubPages = $this->db->query("select id, title, slug from tblmenupages where parent_id = '".$id."' AND `menu_id` = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
			
			$this->db->where("id",$this->input->post('id'));
			$result = $this->db->get("tblmenupages")->result_array();
		//	echo '<div style="" id="more-nav-holder" style="display:none" class="'.$id.'">';
			//echo '<input type="hidden" value="1" id="temp_nav_holder" name="temp_nav_holder">';
			//echo '<div class=" sub-nav sub_nav_about">';
			// vinay 19/11
			$usrePermissions = $this->query_model->getUserPermission($this->session->userdata('userid'));
			echo '<ul class="nav-sub">';
			if(count($getCmsSubPages) > 0){
			
				// vinay 04/12
				//echo '<li class="mainTabName">'.$location_detail[0]->name.' : '.$location_id.'</li>';
				
				//$this->session->set_userdata('aboutLocation_id', $location_id); // vinay 16/11
			}
			
			/** vinay 04/12 **/
				
				foreach($getCmsSubPages as $subPages){
					$activeTabPageCls = '';
					if($this->session->userdata("subPageUrlSlug") == $subPages['slug']){ $activeTabPageCls = 'activeTabPageCls'; }
					if($this->session->userdata('user_level') != 1){
						if(strstr($usrePermissions[0]->slug, $subPages['slug'])){
							if($subPages['slug'] != 'admin/staff'){
									if($subPages['slug'] == 'admin/setting/apikeys' || $subPages['slug'] == 'admin/setting/instagramapikeys'){
									//$my_mainLocation = $this->query_model->getMainLocation();
									$this->db->select(array("id","name"));
									$this->db->where('main_location', 1);
									$my_mainLocation = $this->db->get('tblcontact')->result();
									
									$my_mainLocation = $my_mainLocation[0]->id;
									if($getIsMultiSocialFeeds[0]['field_value'] == 1){
										echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$location_id.'" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}else{
										echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'" slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
									
								}else{
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$location_id.'" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
								/*	echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="childAboutPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>'; */
							} else{
								if($getIsMultiStaff[0]['field_value'] == 1){
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$location_id.'" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];	
									echo '</a></li>';
									echo '<li class="GlobalClass">Global: </li>';
									
									}else{
										echo '<li class="GlobalClass">Global: </li>';
										echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$location_id.'" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
								}
								
						}
					}else{
						if($subPages['slug'] != 'admin/staff'){
								
							if($subPages['slug'] == 'admin/about/about_header' || $subPages['slug'] == 'admin/video' || $subPages['slug'] == 'admin/about/ourschool' || $subPages['slug'] == 'admin/staff' || $subPages['slug'] == 'admin/seotext' || $subPages['slug'] == 'admin/setting/apikeys' || $subPages['slug'] == 'admin/setting/instagramapikeys' || $subPages['slug'] == 'admin/about/about_the_ata' || $subPages['slug'] == 'admin/about/about_us' || $subPages['slug'] == 'admin/email_options/about_email_option1' || $subPages['slug'] == 'admin/email_options/about_email_option1'){
								
								if($subPages['slug'] == 'admin/setting/apikeys' || $subPages['slug'] == 'admin/setting/instagramapikeys'){
									//$my_mainLocation = $this->query_model->getMainLocation();
									
									$this->db->select(array("id","name"));
									$this->db->where('main_location', 1);
									$my_mainLocation = $this->db->get('tblcontact')->result();
									$my_mainLocation = $my_mainLocation[0]->id;
									if($getIsMultiSocialFeeds[0]['field_value'] == 1){
										echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$location_id.'" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}else{
										echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'" slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
									
								}else{
									echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$location_id.'" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
								
							} else {
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'" slug="'.$subPages['slug'].'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						} else{
							//$my_mainLocation = $this->query_model->getMainLocation();
							$this->db->select(array("id","name"));
							$this->db->where('main_location', 1);
							$my_mainLocation = $this->db->get('tblcontact')->result();
							$my_mainLocation = $my_mainLocation[0]->id;
							if($getIsMultiStaff[0]['field_value'] == 1){
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$location_id.'" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
								echo '<li class="GlobalClass">Global: </li>';
								
							}else{
								echo '<li class="GlobalClass">Global: </li>';
								echo '<li class="'.$child_sub_cls.'"><a href="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'" slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'" class="cms_menu_url childAboutPages '.$child_sub_link_cls.' '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}
					}
				}
			
			echo '</ul>';
			//echo '</div>';
		}else
		{
			redirect('admin/login');
		}	
	
	
}
	
	
	
	
}
	
	
