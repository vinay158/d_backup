<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siteservices extends CI_Controller {

	public function index()
	{
	
	}
	
	
public function getSettingData(){
			$settingData = $this->query_model->getbyTable("tblsite");
			
			print_r(json_encode($settingData));
}


public function getSchoolDetail($location_id = null){
			
			if(!empty($location_id)){

				$contact_detail = $this->query_model->getbySpecific('tblcontact', 'id', $location_id);
		
			} else{
		
				$contact_detail = $this->query_model->getMainLocation();
			}
			
			print_r(json_encode($contact_detail));
}


public function getTrialOfferDetail($trial_id = null){
			if(!empty($trial_id)){
				$offer_detail = $this->query_model->getbySpecific('tblspecialoffer', 'id', $trial_id);
				print_r(json_encode($offer_detail));
			}else{
				return '';
			}
}


public function getFooterLinks(){
 //front_menu(0, 4, '', '');
 		
			$id = 0;
			$menu_id = 4;
           
			$query = $this->query_model->getMenuMainPages($id, $menu_id);
			
			$querygetIsMultiMap = $this->query_model->getIsMultiMap();
			
			$getAllMultiLocation = $this->query_model->getAllMultiLocation();
			
			
			
			/*****************************************/
			$pageurl = '';
			$activePage = '';
			$activeConatctPage = '';
			$activeaboutPage = '';
			$activeProgramPage = '';
			if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/'){
				$folder_name = $_SERVER['CONTEXT_PREFIX'];
				$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
				
				$pageurl = explode('/',$_SERVER['REQUEST_URI']);
				
				$pageurl = $pageurl[1];
				
			}
			
			
						 foreach($query as $row){ 
										echo '<div class="col-md-3 col-sm-4">';
										echo '<div class="footer-widget">';
										echo '<div class="widget-title">';
										echo '<h6>';
										echo $row['title'];
										echo '</h6>';
										echo '</div>';
										echo '<div class="widget-about">';
											if($row['id'] == 56){
												$locations = $this->query_model->getAllPublishedLocation();
												$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
												$mainLocation = $this->query_model->getMainLocation();
												$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
												$contact_slug = $contact_slug[0];
												//echo '<pre>'; print_r($multiLocation); die;
												echo '<ul>';
												
												if($multiLocation[0]->field_value == 1){
													foreach($locations as $location)
													{
														
														echo '<li class="dropdown">';
														echo '<a href="'.$contact_slug->slug.'/'.$location->slug.'">';
														echo $location->name;
														echo '</a>';
														echo '</li>';
														
													}
												} else{
														echo '<li class="dropdown">';
														echo '<a href="contact-us/">';
														echo 'Contact Us';
														echo '</a>';
														echo '</li>';
												}
												
												echo '</ul>';
											}elseif($row['id'] == 62){
												$locations = $this->query_model->getAllPublishedLocation();
												$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
												$mainLocation = $this->query_model->getMainLocation();
												$about_slug = $this->query_model->getbySpecific('tblmeta', 'id', 21);
												$about_slug = $about_slug[0];
												echo '<ul>';
												
												if($multiLocation[0]->field_value == 1){
													foreach($locations as $location)
													{
														
														echo '<li class="dropdown">';
														echo '<a href="'.$about_slug->slug.'/'.$location->slug.'">';
														echo 'About '.$location->name;
														echo '</a>';
														echo '</li>';
														
													}
														//print_front_menu($row['id'], $row['menu_id']);
												} else{
														echo '<li class="dropdown">';
														echo '<a href="'.$about_slug->slug.'/'.strtolower(str_replace(' ','-',$mainLocation[0]->city)).'">';
														echo 'About';
														echo '</a>';
														echo '</li>';
														
														//print_front_menu($row['id'], $row['menu_id']);
												}
												
												echo '</ul>';
											}
											elseif($row['id'] == 44){
												
												$program_nav = $this->query_model->getCategory("programs");
												$prog_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);
												//echo '<pre>'; print_r($prog_slug);
												$prog_slug = $prog_slug[0];
												
										echo '<ul>';	
										foreach($program_nav as $pro_category){ 
										
												$query_subcat=$this->db->query("select `id` from tblprogram where category=".$pro_category->cat_id."");
												$query_subcat=$query_subcat->result();
												$cat_name=str_replace(" ",'-',trim($pro_category->cat_name));
												$published = 1;
												//$query_sub = $this->query_model->getbySpecific("tblprogram", "category", $nav_item_prog->cat_id);
												$query_sub = $this->query_model->getbySpecificRecord("tblprogram", "category", $pro_category->cat_id,$published);
														//$query_sub[0]->id
														
														if(isset($query_sub) && !empty($query_sub)) {
											
													
														echo '<li class="dropdown">';
														
														echo '<a href="'.$prog_slug->slug.'/'.$pro_category->cat_slug.'">';
														echo $pro_category->cat_name;
														echo '</a>';
														echo '</li>';
												}
														
											}
											echo '</ul>';
														//print_front_menu($row['id'], $row['menu_id']);
											
											}
											else{
												//print_front_menu($row['id'], $row['menu_id']);
											}
										echo '</div> </div></div>';
								
										
						}
					
        
}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
