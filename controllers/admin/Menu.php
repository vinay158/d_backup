<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model('menu_model');
	}
	
	public function index()
	{
		redirect('admin/menu/view/1');
	}
	
	
	public function add()
	{
		
		
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "menus";
			
			
			
			if(isset($_POST['save'])):
						$this->menu_model->addmenu();
						redirect('admin/menu/view');
			endif;
			$this->load->view("admin/menu_add", $data);	
		}else{
			redirect('admin/login');
		}
	
		
	}
	
	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		$this->db->where("id",$this->uri->segment(4));
		$data['title'] = 'Pages';
		$data['pagedetails'] = $this->db->get("tblmenus")->result();
		
		//$query = $this->db->query("select * from tblmenus where `parent` = 0");
		//$data['parentPage'] = $query->result();
		if(!empty($data['pagedetails'])){
					
				
		
					if(isset($_POST['update'])){
						$this->menu_model->updatemenu();
						
						redirect('admin/menu/view');
					}
					
						$this->load->view('admin/menu_edit',$data);
		}
		
		//$this->load->view("admin/page_edit", $data);
		
		}else
		{
			redirect('admin/login');
		}
		
		
	}
	
	
	public function editMenuPage(){
		$is_logged_in = $this->session->userdata('is_logged_in');
			//print_r($this->input->post()); die;
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
			$this->db->where("id",$this->input->post('id'));
			$data['title'] = 'Pages';
			$data['editMenuPage'] = $this->db->get("tblmenupages")->result();
			
			
						
						
			
						if(isset($_POST['update'])){
						
							$this->menu_model->updatemenuPageTitle();
							
							redirect($_SERVER['HTTP_REFERER']);
							
						
			}
		
		
		}else
		{
			redirect('admin/login');
		}
		
		
	}
	
	
	public function getCmsSubPages(){
	
			$is_logged_in = $this->session->userdata('is_logged_in');
			//print_r($this->input->post()); die;
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
			$id = $this->input->post('id');
			//$mainMenuUrl = $this->input->post('mainMenuUrl');
			$menu_id = $this->input->post('menu_id');
			$getAllMultiLocation = $this->query_model->getAllMultiLocation();
			$getCmsSubPages = $this->db->query("select id, title, slug from tblmenupages where parent_id = '".$id."' AND `menu_id` = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
			$this->db->where("id",$this->input->post('id'));
			$result = $this->db->get("tblmenupages")->result_array();
		//	echo '<div style="" id="more-nav-holder" style="display:none" class="'.$id.'">';
			
			echo '<input type="hidden" value="1" id="temp_nav_holder" name="temp_nav_holder">';
			echo '<div class=" sub-nav">';
			// vinay 19/11
			$usrePermissions = $this->query_model->getUserPermission($this->session->userdata('userid'));
			echo '<ul class="sub-inner">';
			if(count($getCmsSubPages) > 0){
			
				// vinay 04/12
				//echo '<li class="mainTabName">'.$result[0]['title'].' : '.'</li>';
				
				$this->session->set_userdata('pageId', $id); // vinay 16/11
				//$this->session->set_userdata('mainMenuUrl', $mainMenuUrl);
			}
			
			/** vinay 04/12 **/
			$chargifyApiDisplay = 0;
			$chargifyApi = $this->query_model->getbySpecific('tbl_chargify', 'id', 1);
			if(!empty($chargifyApi) && $chargifyApi[0]->type == 1){
				$chargifyApiDisplay = 1;
			}
			
			$email_marketing_setting = $this->query_model->getByTable('tblsite');
			$email_marketingDisplay = (!empty($email_marketing_setting) && $email_marketing_setting[0]->email_marketing == 1) ? 1 : 0;
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
							
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/email_marketing"){
								if($email_marketingDisplay == 1){
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/leads/cartorders"){
								$show_cartorder_lead = $this->query_model->showCartOrderLeadTab();
								if($show_cartorder_lead == 1){
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/leads/webhook_leads"){
								$show_webhook_lead = $this->query_model->showWebhookOrderLeadTab();
								if($show_webhook_lead == 1){
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/leads/orders_email_only_leads"){
								/*echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>'; */
							}elseif($subPages['slug'] == "admin/gallery"){
								if($is_video_thread == 0){
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/albums/view"){
								if($is_video_thread == 1){
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}elseif($subPages['slug'] == "admin/onlinedojo_users"){
								if($password_setting[0]->password_protection_type == "multiple"){
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
							}else{
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';

							}
						}
					}else{
						if($subPages['slug'] == "admin/chargify_api"){
							if($chargifyApiDisplay == 1){
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/email_marketing"){
							if($email_marketingDisplay == 1){
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/leads/cartorders"){
							$show_cartorder_lead = $this->query_model->showCartOrderLeadTab();
							if($show_cartorder_lead == 1){
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/leads/webhook_leads"){
							$show_webhook_lead = $this->query_model->showWebhookOrderLeadTab();
							if($show_webhook_lead == 1){
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/leads/orders_email_only_leads"){
								/*echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>'; */
						}elseif($subPages['slug'] == "admin/gallery"){
							if($is_video_thread == 0){
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}elseif($subPages['slug'] == "admin/albums/view"){
							if($is_video_thread == 1){
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}else{
							echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
							echo $subPages['title'];
							echo '</a></li>';
						}
						
					}
				}
			} else{
				
				$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
			
				$multiSchool = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
				
				$multi_about_us = $this->query_model->multi_about_us();
				
					if($getAllMultiLocation[0]['field_value'] == 1 && $multiSchool == 0 && $multi_about_us == 1){
								$locations = $this->query_model->getAllReguralLocations();
								foreach($locations as $location){
									$activeTabPageCls = '';
									if($location->id == $this->session->userdata("aboutLocation_id")){
										$activeTabPageCls = 'activeTabPageCls';
									}
									echo ' <li><a  href="javascript:void(0)" slug="'.'admin/about/'.$location->id.'" class="AboutMultiLocation '.$activeTabPageCls.'" location_id="'.$location->id.'">'.$location->name.'</a></li>';
									//echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages '.$activeTabPageCls.'">';
									
						}
					} else {
							$my_mainLocation = $this->query_model->getMainLocation();
							$my_mainLocation = $my_mainLocation[0]->id;
						foreach($getCmsSubPages as $subPages){
							$activeTabPageCls = '';
							$aboutPageUrl = $subPages['slug'].'/multilocation/'.$my_mainLocation;
							if($this->session->userdata("subPageUrlSlug") == $aboutPageUrl){ $activeTabPageCls = 'activeTabPageCls'; }
							if($this->session->userdata('user_level') != 1){
								if(strstr($usrePermissions[0]->slug, $subPages['slug'])){
									if($subPages['slug'] == 'admin/about/about_header' || $subPages['slug'] == 'admin/video' || $subPages['slug'] == 'admin/about/ourschool' || $subPages['slug'] == 'admin/staff' || $subPages['slug'] == 'admin/seotext' || $subPages['slug'] == 'admin/setting/apikeys' || $subPages['slug'] == 'admin/setting/instagramapikeys' || $subPages['slug'] == 'admin/about/about_the_ata' || $subPages['slug'] == 'admin/about/about_us' || $subPages['slug'] == 'admin/email_options/about_email_option1' || $subPages['slug'] == 'admin/email_options/about_email_option2'){
										
										echo '<li><a href="javascript:void(0)"  slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'"  class="subPages '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									} else {
										echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages 2 '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
								}
							}else{
									$my_mainLocation = $this->query_model->getMainLocation();
									$my_mainLocation = $my_mainLocation[0]->id;
									$aboutPageUrl = $subPages['slug'].'/multilocation/'.$my_mainLocation;
									if($this->session->userdata("subPageUrlSlug") == $aboutPageUrl.'/multilocation/'.$my_mainLocation){
										$activeTabPageCls = 'activeTabPageCls';
									}
									if($subPages['slug'] == 'admin/about/about_header' || $subPages['slug'] == 'admin/video' || $subPages['slug'] == 'admin/about/ourschool' || $subPages['slug'] == 'admin/staff' || $subPages['slug'] == 'admin/seotext' || $subPages['slug'] == 'admin/setting/apikeys' || $subPages['slug'] == 'admin/setting/instagramapikeys' || $subPages['slug'] == 'admin/about/about_the_ata' || $subPages['slug'] == 'admin/about/about_us' || $subPages['slug'] == 'admin/email_options/about_email_option1' || $subPages['slug'] == 'admin/email_options/about_email_option2'){
										
										echo '<li><a href="javascript:void(0)"  slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'"  class="subPages '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									} else {
										echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="subPages 2 '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
							}
						}
					}
			}
			echo '<ul>';
			echo '</div>'; 
			
		}else{ 
			redirect('admin/login');
		}	
	
	}

public function setAboutMultiLocationChildPages(){
	
	
			$is_logged_in = $this->session->userdata('is_logged_in');
			//print_r($this->input->post()); die;
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
			$id = $this->input->post('pageId');
			$menu_id = $this->input->post('menu_id');
			$location_id = $this->input->post('location_id');
			$location_detail = $this->query_model->getbyId('tblcontact', $location_id);
			
			$getIsMultiStaff = $this->query_model->getIsMultiStaff();
			$getIsMultiSocialFeeds = $this->query_model->getIsMultiSocialFeeds();
			
			$getAllMultiLocation = $this->query_model->getAllMultiLocation();
			$getCmsSubPages = $this->db->query("select id, title, slug from tblmenupages where parent_id = '".$id."' AND `menu_id` = '".$menu_id."' ORDER BY sort_order ASC")->result_array();
			$this->db->where("id",$this->input->post('id'));
			$result = $this->db->get("tblmenupages")->result_array();
		//	echo '<div style="" id="more-nav-holder" style="display:none" class="'.$id.'">';
			echo '<input type="hidden" value="1" id="temp_nav_holder" name="temp_nav_holder">';
			echo '<div class=" sub-nav sub_nav_about">';
			// vinay 19/11
			$usrePermissions = $this->query_model->getUserPermission($this->session->userdata('userid'));
			echo '<ul class="sub-inner">';
			if(count($getCmsSubPages) > 0){
			
				// vinay 04/12
				echo '<li class="mainTabName">'.$location_detail[0]->name.' : '.'</li>';
				
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
									$my_mainLocation = $this->query_model->getMainLocation();
									$my_mainLocation = $my_mainLocation[0]->id;
									if($getIsMultiSocialFeeds[0]['field_value'] == 1){
										echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="childAboutPages '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}else{
										echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'" class="childAboutPages '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
									
								}else{
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="childAboutPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
								/*	echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="childAboutPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>'; */
							} else{
								if($getIsMultiStaff[0]['field_value'] == 1){
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="childAboutPages '.$activeTabPageCls.'">';
									echo $subPages['title'];	
									echo '</a></li>';
									echo '<li class="GlobalClass">Global: </li>';
									
									}else{
										echo '<li class="GlobalClass">Global: </li>';
										echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="childAboutPages '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
								}
								
						}
					}else{
						if($subPages['slug'] != 'admin/staff'){
								
							if($subPages['slug'] == 'admin/about/about_header' || $subPages['slug'] == 'admin/video' || $subPages['slug'] == 'admin/about/ourschool' || $subPages['slug'] == 'admin/staff' || $subPages['slug'] == 'admin/seotext' || $subPages['slug'] == 'admin/setting/apikeys' || $subPages['slug'] == 'admin/setting/instagramapikeys' || $subPages['slug'] == 'admin/about/about_the_ata' || $subPages['slug'] == 'admin/about/about_us' || $subPages['slug'] == 'admin/email_options/about_email_option1' || $subPages['slug'] == 'admin/email_options/about_email_option1'){
								
								if($subPages['slug'] == 'admin/setting/apikeys' || $subPages['slug'] == 'admin/setting/instagramapikeys'){
									$my_mainLocation = $this->query_model->getMainLocation();
									$my_mainLocation = $my_mainLocation[0]->id;
									if($getIsMultiSocialFeeds[0]['field_value'] == 1){
										echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="childAboutPages '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}else{
										echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'" class="childAboutPages '.$activeTabPageCls.'">';
										echo $subPages['title'];
										echo '</a></li>';
									}
									
								}else{
									echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="childAboutPages '.$activeTabPageCls.'">';
									echo $subPages['title'];
									echo '</a></li>';
								}
								
							} else {
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'" class="childAboutPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						} else{
							$my_mainLocation = $this->query_model->getMainLocation();
							$my_mainLocation = $my_mainLocation[0]->id;
							if($getIsMultiStaff[0]['field_value'] == 1){
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$location_id.'" class="childAboutPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
								echo '<li class="GlobalClass">Global: </li>';
								
							}else{
								echo '<li class="GlobalClass">Global: </li>';
								echo '<li><a href="javascript:void(0)" slug="'.$subPages['slug'].'/multilocation/'.$my_mainLocation.'" class="childAboutPages '.$activeTabPageCls.'">';
								echo $subPages['title'];
								echo '</a></li>';
							}
						}
					}
				}
			
			echo '<ul>';
			echo '</div>';
		}else
		{
			redirect('admin/login');
		}	
	
	
}

// vinay 08/12
public function setSubPageUrl(){
	$this->session->unset_userdata('subPageUrlSlug');
	//echo $_POST['slug']; die;
	if($_POST['slug'] != ''){
		$this->session->set_userdata('subPageUrlSlug', $_POST['slug']);
	}
}

public function setAboutSubPageUrl(){
	$this->session->unset_userdata('aboutLocation_id');
	$this->session->unset_userdata('subPageUrlSlug');
	
	if($_POST['slug'] != ''){
		$this->session->set_userdata('subPageUrlSlug', $_POST['slug']);
		$this->session->set_userdata('aboutLocation_id', $_POST['aboutLocation_id']);
	}
	
	
}

public function subchildAboutPages(){
	$this->session->unset_userdata('aboutLocation_id');
	$this->session->unset_userdata('subPageUrlSlug');
	
	if($_POST['slug'] != ''){
		$this->session->set_userdata('subPageUrlSlug', $_POST['slug']);
		$this->session->set_userdata('aboutLocation_id', $_POST['aboutLocation_id']);
	}
	
	
}

	
//  vinay 17/11

public function setPageUrl(){
		$this->session->unset_userdata('pageId');
		$this->session->unset_userdata('aboutLocation_id');
		$this->session->unset_userdata('subPageUrlSlug');
		echo '1'; die;
}	




	public function delete(){
		$id = $this->uri->segment(4);
		$this->db->where("id", $id);
		//echo $id; die;
		//echo ''; die;
			if($this->db->delete("tblmenus"))
			{
				redirect($this->index());
			}
			else
			{
				echo "<script language='javascript'>alert('Unable to delete Pages');</script>";
				redirect($this->index());
		}
	}
	
	public function setMenuManager(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$childParentData = json_decode($this->input->post('data'),true);
			
			$i = 0;
			foreach($childParentData as $data){
				$i++;
				$dataArr = array('parent_id' => 0, 'sort_order' => $i);
					
				$this->db->where('id', $data['id']);
					
				$this->db->update('tblmenupages', $dataArr); 
					
				$childDataArr =  array();
				if(isset($data['children'])){
					
					$this->saveParentChildrenData($data['id'],$data['children']);	
				
				}
				
				
			}

		}
	}
	
	
	
	
	private function saveParentChildrenData($parent_id,$childArr){
			
			$i = 0;
			foreach($childArr as $children){
				$i++;
				
					$data = array('parent_id' => $parent_id, 'sort_order' => $i);
					
					$this->db->where('id', $children['id']);
					
					
					
					$this->db->update('tblmenupages', $data); 
					
					if(isset($children['children'])){
					
						$this->saveParentChildrenData($children['id'],$children['children']);	
				
					}
				
			}
		
		
	}
	
	public function manage($id = null){
		
		$this->load->helper('menu');
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			if($this->input->post()){
				
				$query = $this->db->select('id,title,slug')->from('tblmanagepages')->where_in('id', $this->input->post('page_id'))->get();
				$result = $query->result_array();
				
				//echo '<pre>'; print_r($result); die;
				
				
				$i = 0;
				foreach($result as $test){
				$i++;
					$query = $this->db->query("SELECT id FROM tblmenupages WHERE page_id =".$test['id']." AND menu_id =".$this->input->post('menu_id'));
					if ($query->num_rows() <= 0){
						
						$status = (isset($_POST['status']) && !empty($_POST['status'])) ? $_POST['status'] : 0;
						$data = array(
								'page_id' => $test['id'],
								'menu_id' => $this->input->post('menu_id'),
								'title' => $test['title'],
								'sort_order' => $i,
								'slug' => $test['slug'],
								'status' => $status
								);
								
					
					
								
						$this->query_model->insertData('tblmenupages',$data);
									

					} 
								
								
				} 
				redirect('admin/menu/manage/'.$id,'refersh');
				
			}
			
			$data['title'] = "manage";
			
			$this->db->select(array('id','title'));
			$query = $this->db->get_where('tblmanagepages', array('published' => 1));
			$data['pagesList'] = $query->result();
			//echo '<pre>'; print_r($data['pagesList']); die;
			
			
			//$queryPages = $this->db->get_where('tblmenupages', array('menu_id' => $id));
			//$data['menu'] = $queryPages->result();
			
			
			$this->db->select(array('id','title'));
			$queryMenus = $this->db->get_where('tblmenus');
			$data['menus'] = $queryMenus->result_array();
			
			
			
			$queryMenuList = $this->db->select('page_id')->from('tblmenupages')->where('menu_id', $id)->get();
			$data['checkedMenu'] = $queryMenuList->result_array();
			
			$queryMenus = $this->db->get_where('tblmenus', array('id' => $id));
			$data['menuDetail'] = $queryMenus->result_array();
			
			//echo '<pre>data'; print_r($data); die;
			$this->load->view('admin/menu_manage', $data);	
		}
		else
		{
			redirect('admin/login');
		}
		
		}
	
	public function deleteMenuPage(){
	
			
			
			$id = $this->input->post('id');
			
				$this->db->where("id", $id);
				
				$this->db->or_where('parent_id', $id);
				
					
					if($this->db->delete("tblmenupages"))
					{
						
						$page = $_SERVER['PHP_SELF'];
						$sec = "5";

						echo "1";
						
						//header("Refresh: $sec; url=$page");
						
						//$data['result'] = 'success';
					}
					else{
						echo "0";

					}
					exit;
					
					
	}
	
	
	public function deleteSchoolMenuPage(){
	
			
			
			$id = $this->input->post('id');
			
				$this->db->where("id", $id);
				
				$this->db->or_where('parent_id', $id);
				
					
					if($this->db->delete("tbl_school_menupages"))
					{
						
						$page = $_SERVER['PHP_SELF'];
						$sec = "5";

						echo "1";
						
						//header("Refresh: $sec; url=$page");
						
						//$data['result'] = 'success';
					}
					else{
						echo "0";

					}
					exit;
					
					
	}
	public function publish(){
		$id = $this->uri->segment(4);
		$status = $this->uri->segment(5);
		//echo $status; die;
			
			if($status == 'publish'){
				$pub = 0;
				}else {
				$pub = 1;	
					}
					
				//	echo $pub; die;
			$this->db->where("id", $id);
			if($this->db->update("tblmenus", array("published" => $pub)))
			{	
				redirect($this->index());
				
			}
		}
		
		
	public function view()
	{
	
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "menus";
			$data['link_type'] = 'menu';
			//echo 'hello'; die;
			$this->db->order_by("id", "desc"); 
			$query = $this->db->get('tblmenus');
			$data['menus'] = $query->result();
			
			
			$this->load->view('admin/menu_index', $data);	
		}
		else
		{
			redirect('admin/login');
		}
	
	}
	
	
	
	
	
	public function deleteCategory(){
	$id = $_POST['delete-id'];
	$this->db->where("cat_id", $id);
	if($this->db->delete("tblcategory"))
	{
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
	$operation = $_POST['operation'];
	$id = $_POST['edit_id'];
	$shared = $_POST['shared'];
	$save = $_POST['submit'];
	//echo $title." ".$operation." ".$id." "." ".$shared." ".$save;
	if(isset($save))
	{
		if( $operation == 'add' )
		{
			$args = array("cat_name" => $title, "cat_type" => "page", "permission" => $shared);
			if($this->query_model->addCategory($args)){
			redirect($this->index());
			}
			else
			{	
				echo "<script language='javascript'>alert('Unable to add category');</script>";
				redirect($this->index());
			}
		}
		elseif( $operation == 'edit' )
		{
			$args = array("cat_name" => $title, "cat_type" => "page", "permission" => $shared);
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
	
	/*public function uploadPhoto(){
		if(isset($_POST['submit'])):
			$data_count = $this->query_model->getFacilityData();
			if(count($data_count)<8){
				$image = $_FILES['userfile']['name'];
				$table = 'tblaboutfacilityphoto';
				if(!empty($image)){
						$this->load->model('upload_model');
						$path = "upload/facility/";
					if($a = $this->upload_model->upload_image($path)){
						$data = array(
						'photo' => $a,
						);
					if($this->query_model->insertDataFacility($table,$data)): 
						redirect("admin/about/facility");
					endif;
				  }
				}
			}else{
				echo "<script language='javascript'>alert('Oops! You already have uploaded the maximum amount of 8 photos.');</script>";
				echo "<script language='javascript'>window.location = '../about/facility';</script>";
				//redirect("admin/about/facility");				
			}
		endif;
	}*/
	
	
	/*** school menu ***/
	public function manage_school_menu($id = null)
	{
	
		
		$this->load->helper('menu');
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			
			if($this->input->post()){
				
				$query = $this->db->select('id,title,slug')->from('tbl_school_menupages')->where_in('id', $this->input->post('page_id'))->get();
				$result = $query->result_array();
				
				//echo '<pre>'; print_r($result); die;
				
				
				$i = 0;
				foreach($result as $test){
				$i++;
					$query = $this->db->query("SELECT id FROM tbl_school_menupages WHERE page_id =".$test['id']." AND menu_id =".$this->input->post('menu_id'));
					if ($query->num_rows() <= 0){
						
						$data = array(
								'page_id' => $test['id'],
								'menu_id' => $this->input->post('menu_id'),
								'title' => $test['title'],
								'sort_order' => $i,
								'slug' => $test['slug'],
								'status' => $this->input->post('status')
								);
								
					
					
								
						$this->query_model->insertData('tbl_school_menupages',$data);
									

					} 
								
								
				} 
				redirect('admin/menu/manage_school_menu/'.$id,'refersh');
				
			}
			
			$data['title'] = "School Menu";
			
			
			
			
			$queryPages = $this->db->get_where('tbl_school_menupages', array('menu_id' => $id));
			$data['menu'] = $queryPages->result();
			
			
			
			
			$this->load->view('admin/manage_school_menu', $data);	
		}
		else
		{
			redirect('admin/login');
		}
		
	
	}
	
	
	public function default_rearrange_school_menu($menu_id = null, $type = 'new'){
		if(!empty($menu_id)){
			
			if($type == "update"){
				$this->db->truncate('tbl_school_menupages');
			}
			//$schoolMenus = $this->query_model->setSchoolMenu();
			$schoolMenus = $this->query_model->setNestedSchoolMenu();
			//echo '<pre>schoolMenus'; print_r($schoolMenus); die;
			
			if(!empty($schoolMenus)){
				$a = 1;
				foreach($schoolMenus as $coloumn){
					$coloumnArr = array();
					$coloumnArr['title'] = $coloumn['value'];
					$coloumnArr['slug'] = $this->school_menu_slug_from_title($coloumn['value'],'coloumn');
					$coloumnArr['parent_id'] = $coloumn['parent'];
					$coloumnArr['menu_id'] = $menu_id;
					$coloumnArr['sort_order'] = $a;
					
					$this->query_model->insertData('tbl_school_menupages', $coloumnArr);
					$coloumn_parent_id = $this->db->insert_id();
					
					if(isset($coloumn['children']) && !empty($coloumn['children'])){
						$b = 1;
						foreach($coloumn['children'] as $state){
							$stateArr = array();
							$stateArr['title'] = $state['value'];
							$stateArr['slug'] = $this->school_menu_slug_from_title($state['value'],'state');
							$stateArr['parent_id'] = $coloumn_parent_id;
							$stateArr['location_id'] = $state['id'];
							$stateArr['menu_id'] = $menu_id;
							$stateArr['sort_order'] = $b;
							//echo '<pre>'; print_r($stateArr); die;
							$this->query_model->insertData('tbl_school_menupages', $stateArr);
							$state_parent_id = $this->db->insert_id();
							
							// city save
							if(isset($state['children']) && !empty($state['children'])){
										$d = 1;
											foreach($state['children'] as $location){
												$locationArr = array();
												$locationArr['title'] = $location['value'];
												$locationArr['slug'] = $this->school_menu_slug_from_title($location['value'],'location');
												$locationArr['parent_id'] = $state_parent_id;
												$locationArr['menu_id'] = $menu_id;
												$locationArr['location_id'] = $location['id'];
												$locationArr['city'] = $location['city'];
												$locationArr['state'] = $location['state'];
												$locationArr['sort_order'] = $d;
												
												$this->query_model->insertData('tbl_school_menupages', $locationArr);
											
											 $d++;
												//$parent_id = $this->db->insert_id();
											}
									
								}
						$b++;
						}
						
					}
				$a++;	
				}
			}
			
		}
		
		redirect('admin/menu/manage_school_menu/'.$menu_id,'refersh');
	}
	
	
	
	public function setSchoolMenuManager(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			//$_POST['data'] = '[{"id":1,"children":[{"id":2,"children":[{"id":3,"children":[{"id":5},{"id":4}]}]}]},{"id":8,"children":[{"id":6,"children":[{"id":7}]}]},{"id":9},{"id":10}]';
			
			//$childParentData = json_decode($_POST['data'],true);
			$childParentData = json_decode($this->input->post('data'),true);
			
			//echo '<prE>childParentData'; print_r($childParentData); die;
			
			
			$i = 0;
			foreach($childParentData as $data){
				//, 'is_new_row' => 0
				$i++;
				$dataArr = array('parent_id' => 0, 'sort_order' => $i);
					
				$this->db->where('id', $data['id']);
					
				$this->db->update('tbl_school_menupages', $dataArr); 
					
				$childDataArr =  array();
				if(isset($data['children'])){
					
					$this->saveSchoolParentChildrenData($data['id'],$data['children']);	
				
				}
				
				
			}

		}
	}
	
	
	
	
	private function saveSchoolParentChildrenData($parent_id,$childArr){
			
			$i = 0;
			foreach($childArr as $children){
				$i++;
				//, 'is_new_row' => 0
					$data = array('parent_id' => $parent_id, 'sort_order' => $i);
					
					$this->db->where('id', $children['id']);
					
					
					
					$this->db->update('tbl_school_menupages', $data); 
					
					if(isset($children['children'])){
					
						$this->saveSchoolParentChildrenData($children['id'],$children['children']);	
				
					}
				
			}
		
		
	}
	
	
	
	
	public function editSchoolMenuPage(){
		$is_logged_in = $this->session->userdata('is_logged_in');
			//print_r($this->input->post()); die;
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
			
			$data['title'] = 'Pages';
			
			$this->db->where("id",$this->input->post('id'));
			$data['editMenuPage'] = $this->db->get("tbl_school_menupages")->result();
			
			
						
						
			
						if(isset($_POST['update'])){
						
							$title = trim($_POST['title']);
							$new_tab = isset( $_POST['new_tab'] ) ? $_POST['new_tab']:0;
							
							$postData = array('title' => $title, 'new_tab' => $new_tab);
			
							$this->query_model->update('tbl_school_menupages',$this->input->post('id'),$postData);
							
							redirect($_SERVER['HTTP_REFERER']);
							
						
			}
		
		
		}else
		{
			redirect('admin/login');
		}
		
		
	}
	
	
	public function update_school_menu($menu_id = null){
		if(!empty($menu_id)){
			$this->db->where('location_id  !=',0);
			$locationMenus = $this->query_model->getBySpecific('tbl_school_menupages','menu_id',$menu_id);
			if(!empty($locationMenus)){
				foreach($locationMenus as $location_menu){
					
					$location_id = $location_menu->location_id;
					
					// getting contant detail
					if($this->query_model->checkMultiSchoolIsOn() == 1){
						$this->db->where("school_location_type", 'default');  //not nested child locations
					}
					$this->db->where('published',1);
					//$this->db->where('city',$location_menu->city);
					$this->db->where('state',$location_menu->state);
					$this->db->where("main_location", 0);
					$existsRecord = $this->query_model->getBySpecific('tblcontact','id',$location_id);
					
					if(empty($existsRecord)){
						$parent_id = $location_menu->parent_id; // contact menu parent_id
						
						
						$multipleLocationsInSameCity = $this->query_model->getBySpecific('tbl_school_menupages','parent_id',$parent_id);
						
						// delete location menu
						$this->query_model->deletebySpecific('tbl_school_menupages','id',$location_menu->id);
						
						if(!empty($multipleLocationsInSameCity) && count($multipleLocationsInSameCity) == 1){
							
							$cityMenuRecord = $this->query_model->getBySpecific('tbl_school_menupages','id',$parent_id);
							
							$multipleCitiesInSameState = $this->query_model->getBySpecific('tbl_school_menupages','parent_id',$cityMenuRecord[0]->parent_id);
							// delete location menu
							$this->query_model->deletebySpecific('tbl_school_menupages','id',$parent_id);
							
							/*if(!empty($multipleCitiesInSameState) && count($multipleCitiesInSameState) == 1){
								// delete location menu
								$this->query_model->deletebySpecific('tbl_school_menupages','id',$multipleCitiesInSameState[0]->parent_id);
							} */
						}
						
						
					}
				}
			}
			
			$schoolMenus = $this->query_model->setSchoolMenu();
			//echo '<pre>schoolMenus'; print_r($schoolMenus); die;
			if(!empty($schoolMenus)){
				$a = 1;
				foreach($schoolMenus as $coloumn){
					$coloumnSlug = $this->school_menu_slug_from_title($coloumn['value'],'coloumn');
					
					$existsColoumn= $this->query_model->getBySpecific('tbl_school_menupages','slug',$coloumnSlug);
					
					if(!empty($existsColoumn)){
						$coloumn_parent_id = $existsColoumn[0]->id;
					
							if(isset($coloumn['children']) && !empty($coloumn['children'])){
								$b = 1;
								foreach($coloumn['children'] as $state){
									$stateSlug = $this->school_menu_slug_from_title($state['value'],'state');
					
									$existsState= $this->query_model->getBySpecific('tbl_school_menupages','slug',$stateSlug);
									
									if(!empty($existsState)){
										$state_parent_id = $existsState[0]->id;
									}else{
										$stateArr = array();
										$stateArr['title'] = $state['value'];
										$stateArr['slug'] = $this->school_menu_slug_from_title($state['value'],'state');
										$stateArr['parent_id'] = $coloumn_parent_id;
										$stateArr['menu_id'] = $menu_id;
										$stateArr['sort_order'] = $b;
										$stateArr['is_new_row'] = 1;
										//echo '<pre>stateArr'; print_r($stateArr); die;
										$this->query_model->insertData('tbl_school_menupages', $stateArr);
										$state_parent_id = $this->db->insert_id();
									}
									
									
										// location save
											if(isset($state['children']) && !empty($state['children'])){
												$d = 1;
													foreach($state['children'] as $location){
														
														$locationSlug = $this->school_menu_slug_from_title($location['value'],'location');
														
							
														$existsLocation= $this->query_model->getBySpecific('tbl_school_menupages','slug',$locationSlug);
															if(empty($existsLocation)){
																$locationArr = array();
																$locationArr['title'] = $location['value'];
																$locationArr['slug'] =  $this->school_menu_slug_from_title($location['value'],'location');
																$locationArr['parent_id'] = $state_parent_id;
																$locationArr['menu_id'] = $menu_id;
																$locationArr['location_id'] = $location['id'];
																$locationArr['city'] = $location['city'];
																$locationArr['state'] = $location['state'];
																$locationArr['sort_order'] = $d;
																$locationArr['is_new_row'] = 1;
																
																$this->query_model->insertData('tbl_school_menupages', $locationArr);
															}
														
													
													 $d++;
														//$parent_id = $this->db->insert_id();
													}
												}
								$b++;
								}
								
							}
					}
					
				$a++;	
				}
			}
			
			
			
			redirect('admin/menu/manage_school_menu/'.$menu_id,'refersh');
			
		}
	}
	
	
	public function school_menu_slug_from_title($title,$type){
		$title = $title.'-'.$type;
		$slug = preg_replace( '/[«»“”!?,. ]+/', '-', strtolower($title) );
		
		return $slug;
	}
	
	
	public function updateIsNewRow(){
		
		if(isset($_POST['list_id']) && !empty($_POST['list_id'])){
				
				$existsSchoolMenu = $this->query_model->getBySpecific('tbl_school_menupages','id',$_POST['list_id']);
				
				if(!empty($existsSchoolMenu)){
					
					$data = array('is_new_row' => 0);
					
					$this->db->where('id', $_POST['list_id']);
					$this->db->update('tbl_school_menupages', $data); 
				}
				
		}
		
		if(isset($_POST['parent_id']) && $_POST['parent_id'] > 0){
				
				$existsSchoolMenu = $this->query_model->getBySpecific('tbl_school_menupages','parent_id',$_POST['list_id']);
				
				if(!empty($existsSchoolMenu)){
					foreach($existsSchoolMenu as $menu){
						$data = array('is_new_row' => 0);
					
						$this->db->where('id', $menu->id);
						$this->db->update('tbl_school_menupages', $data); 
					}
					
				}
				
		}
		exit();
	}
	
	
  	
}