<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ourprograms extends CI_Controller {

	public function index()
	{
		
		redirect(base_url());
		
		
		$spl_data=$this->db->query("select featured_on_off from `tblspecialoffer`") or die(mysqli_error($this->db->conn_id));
		$spl_data=$spl_data->result();
		
		$data['special_prog_hide']=0;
		if(is_array($spl_data) && count($spl_data)>0){
			if($spl_data[0]->featured_on_off=='on'){
			  $data['special_prog_hide']=1;
			}
		}
		
		$this->db->where("published", 1); // vinay 11/2
		$this->db->order_by("pos", "ASC");
		$data['page'] = $this->query_model->getbyTable("tblprogram");
		$this->load->view('our-programs', $data);
		
	}
	public function view()
	{
		
		if($this->uri->segment(2) != NULL){
			
		$folder_name = $_SERVER['CONTEXT_PREFIX'];
  		$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
   
	   $meta_slug = explode('/',$_SERVER['REQUEST_URI']);
	   //echo '<pre>'; print_r($meta_slug); die;
	   $meta_slug = $meta_slug[1];
		
			if(!empty($meta_slug)){
				$data['page_name'] = $this->query_model->getMetaPageName($meta_slug);
			}
			
			/*$spl_data=$this->db->query("select featured_on_off from `tblspecialoffer`") or die(mysqli_error($this->db->conn_id));
			$spl_data=$spl_data->result();
			$data['special_prog_hide']=0;
			if(is_array($spl_data) && count($spl_data)>0){
				if($spl_data[0]->featured_on_off=='on'){
				  $data['special_prog_hide']=1;
				}
			 }*/
			 
			 
			/* $cat_data=$this->db->query("select category from `tblprogram`  where  id=".$this->uri->rsegment(3)."") or die(mysqli_error($this->db->conn_id));
			 $cat_data=$cat_data->result();
			
			 $data['category']=$cat_name='';
			 		 
			 if(is_array($cat_data) && count($cat_data)>0):		
				$data['category']=$cat_data[0]->category;
			 endif;*/
			// echo $this->uri->segment(2); die;
			$this->db->where('published',1);
			 $data['category'] = $this->query_model->getbySpecific('tblcategory', 'cat_slug', $this->uri->segment(2));
			 
			$data['trialCatSlug'] = '';
			if(!empty($data['category'][0]->trial_offer_id)){
				$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
				$trialCatDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_categories", 'id', $data['category'][0]->trial_offer_id);
				$data['trialCatSlug'] =  !empty($trialCatDetail) ? $trialCatDetail[0]->slug : '';
			}
			
			
			 $data['category'] = $data['category'][0]->cat_id;
			
			 $multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
			$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
			
			
			if(empty($data['category'])){
				redirect(base_url(),'location',301);
			}
			
			 if($data['category']){			 
				$program_list = $this->db->query("select * from `tblprogram`  where  published = 1 and  category=".$data['category']." order by pos asc" ) or die(mysqli_error($this->db->conn_id));
				$data['programs']=$program_list=$program_list->result();
			 	$cat_name=$this->db->query("select * from `tblcategory` where cat_id=".$data['category']." order by pos asc") or die(mysqli_error($this->db->conn_id));
			 	$cat_name=$cat_name->result();
			 }	 
			 
			 $data['uniqueStatesList'] = $this->query_model->getUniqueStatesList();
			 
			 $data['site_settings'] = $this->query_model->getbyTable("tblsite");
			 
			 $data['twilioApi'] = $this->query_model->getTwilioApiType();
			 
			 $data['category_detail'] = $cat_name[0];
			 
			 $data['all_programs'] = $this->query_model->getbySpecific('tblprogram', 'published', 1);
			 
			 $tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
			 $this->db->where('display_trial',1);
			 $data['free_trial'] = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 0);
			 
			 $this->db->where('display_trial',1);
			 $data['paid_trial'] = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 1);
			 
			$this->db->where("published", 1);
			$this->db->where("location_type", 'regular_link');
			if($data['multiSchool'] == 1){
				$this->db->where("main_location", 0);
			}
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			
			$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
			$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
				
			
				
				
				$data['form_allLocations'] = $this->query_model->getFormAllLocations();
				
			
			$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
			
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		    //echo '<pre>'; print_r($data['category_detail']); die;
			 $data['trials_value'] = $this->checktrialsoffer($data['free_trial'], $data['paid_trial']);
			 
			 $data['program_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 30);
			$data['program_slug'] = $data['program_slug'][0]->slug;
			
			$this->db->order_by("pos","asc");
			$this->db->where("cat_id", $data['category_detail']->cat_id);
			$this->db->where("published", 1);
			$data['programCatRows'] = $this->query_model->getbyTable("tbl_program_cat_rows");
			
			$this->db->where("cat_id", $data['category_detail']->cat_id);
			$this->db->order_by("pos","asc");
			$data['allProgramSections'] = $this->query_model->getbyTable("tbl_program_cat_sections");
			
			
			 if($data['category_detail']->page_template == "condensed"){
				$template_name = "our-programs-condensed";
			}else{
				$template_name = "our-programs";
			}
			 $this->load->view($template_name, $data);
			 
			 
		}else{
			redirect("index");
		}
	}
	
	public function program(){
		
		if($this->uri->segment(3) != NULL){
			$folder_name = $_SERVER['CONTEXT_PREFIX'];
  		$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
   
	   $meta_slug = explode('/',$_SERVER['REQUEST_URI']);
	   //echo '<pre>'; print_r($meta_slug); die;
	   $meta_slug = $meta_slug[1];
		
			if(!empty($meta_slug)){
				$data['page_name'] = $this->query_model->getMetaPageName($meta_slug);
			}
			
			$this->db->select('cat_id');
			$this->db->where('published',1);
			$this->db->where('cat_type','programs');
			$proagm_category_detail = $this->query_model->getbySpecific('tblcategory', 'cat_slug', $this->uri->segment(2));
			
			
			$this->db->where('published',1);
			$data['program'] = $this->query_model->getbySpecific('tblprogram', 'program_slug', $this->uri->segment(3));
			
			if(empty($data['program']) || $data['program'][0]->show_learn_more == 0 || empty($proagm_category_detail)){
				redirect(base_url(),'location',301);
			}
			
			$data['trial_offer_id'] = $data['program'][0]->trial_offer_id;
			$data['program'] = $data['program'][0]->id;
			
			if(empty($data['program'])){
				redirect(base_url(),'location',301);
			}
					$program_id = $data['program'];
					
					$data['uniqueStatesList'] = $this->query_model->getUniqueStatesList();
					$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
					$data['multiSchool'] = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
					
					$data['twilioApi'] = $this->query_model->getTwilioApiType();
					
					$data['program_detail'] = $this->query_model->getbySpecific('tblprogram', 'id', $program_id);
					$data['program_detail'] = $data['program_detail'][0];
					
					$data['category_detail'] = $this->query_model->getbySpecific('tblcategory', 'cat_id', $data['program_detail']->category);
					
					$data['trialCatSlug'] = '';
					if(!empty($data['trial_offer_id'])){
						$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
						$trialCatDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_categories", 'id', $data['trial_offer_id']);
					
						$data['trialCatSlug'] =  !empty($trialCatDetail) ? $trialCatDetail[0]->slug : '';
						$data['trial_offer_id'] =  !empty($trialCatDetail) ? $trialCatDetail[0]->id : '';
					}else{
						if(!empty($data['category_detail']) && !empty($data['category_detail'][0]->trial_offer_id)){
							
							$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
							
							$trialCatDetail = $this->query_model->getbySpecific("$tbl_onlinespecial_categories", 'id', $data['category_detail'][0]->trial_offer_id);
							$data['trialCatSlug'] =  !empty($trialCatDetail) ? $trialCatDetail[0]->slug : '';
							$data['trial_offer_id'] =  !empty($trialCatDetail) ? $trialCatDetail[0]->id : '';
						}
					}
					
					
					
					$data['stand_page'] = $this->query_model->getbySpecific('tblstandpage', 'program_id', $program_id);
					$data['site_settings'] = $this->query_model->getbyTable("tblsite");
					
					$this->db->where("published", 1);
					if($data['multiSchool'] == 1){
						$this->db->where("main_location", 0);
					}
					$this->db->where("location_type", 'regular_link');
					$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
					
					
					/*$this->db->where("published", 1);
					if($data['multiSchool'] == 1){
						$this->db->where("main_location", 0);
					}
					$this->db->order_by("pos","asc");
					$data['form_allLocations'] = $this->query_model->getbyTable("tblcontact");*/
					$data['form_allLocations'] = $this->query_model->getLocationIdsByProgramId($program_id);
					
					$data['form_allLocations_contact'] = $this->query_model->getFormAllLocations();
					
					
					
		
					
					$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
					
					$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
					
					$data['all_programs'] = $this->query_model->getbySpecific('tblprogram', 'published', 1);
					
					$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
					 $this->db->where('display_trial',1);
					 $data['free_trial'] = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 0);
					 
					 $this->db->where('display_trial',1);
					 $data['paid_trial'] = $this->query_model->getbySpecific("$tblspecialoffer", 'trial', 1);
					 
					 $data['trials_value'] = $this->checktrialsoffer($data['free_trial'], $data['paid_trial']);
					 
					 
					$selectedTesti = !empty($data['program_detail']->testimonial_ids) ?  unserialize($data['program_detail']->testimonial_ids) : '';
					if(!empty($selectedTesti)){
						if(count($selectedTesti) > 2){
							$this->db->limit(2);
						}
						$this->db->order_by("pos","asc");
						$this->db->where("published", 1);
						$this->db->where_in('id', $selectedTesti);
					}else{
						$this->db->limit(2);
						$this->db->where("published", 1);
					}
					$data['myTestimonials'] = $this->query_model->getbyTable("tbltestimonials");
					
					$data['trial_offer_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 40);
					$data['trial_offer_slug'] = $data['trial_offer_slug'][0];
			
					$this->db->where("published", 1);
					$this->db->where("program_id", $data['program_detail']->id);
					$this->db->order_by("pos","asc");
					$data['allProgramRows'] = $this->query_model->getbyTable("tbl_program_rows");
					
					$this->db->where("published", 1);
					$this->db->where("program_id", $data['program_detail']->id);
					$this->db->order_by("pos","asc");
					$data['allLittleProgramRows'] = $this->query_model->getbyTable("tbl_program_little_rows");
					
					/*$this->db->where("published", 1);
					$this->db->where("program_id", $data['program_detail']->id);
					$this->db->order_by("pos","asc");
					$data['allProgramFaqs'] = $this->query_model->getbyTable("tbl_program_faqs"); */
					
					$data['allProgramFaqs'] = array();
					$selectedFaqs = !empty($data['program_detail']->faq_ids) ?  unserialize($data['program_detail']->faq_ids) : '';
					if(!empty($selectedFaqs)){
						$this->db->order_by("pos","asc");
						$this->db->where_in('id', $selectedFaqs);
						$data['allProgramFaqs'] = $this->query_model->getbyTable("tbl_program_faqs");
					}
					//echo '<pre>'; print_r($data['allProgramFaqs']); die;
					
					
					
					//$this->db->where("published", 1);
					$this->db->where("program_id", $data['program_detail']->id);
					$this->db->order_by("pos","asc");
					$data['allProgramSections'] = $this->query_model->getbyTable("tbl_program_sections");
					
					
					$this->load->view('program', $data);
					
			
			 
		} else {
			redirect("index");
		}
	}
	
	
	
	public function checktrialsoffer($free_trial, $paid_trial){
			$online_trail = $this->query_model->getbySpecific('tblmeta', 'id', 40);
			$html = '';
			if(count($paid_trial) == 2){
				$i = 1;
				foreach($paid_trial as $paid){
					$html .= '<a href="'.$online_trail[0]->slug.'" class="btn btn-blue">'.$paid->title. ' $'.$paid->amount.'</a>';
					if($i == 1){ 
						$html .= '<span> OR </span>'; 
					 } 
				
				$i++; }
				return $html;
			
			
			} elseif(count($paid_trial) == 1 &&  count($free_trial) == 1){
			
				foreach($free_trial as $free){
					$html .=  '<a href="'.$online_trail[0]->slug.'" class="btn btn-white">'.$free->title.'</a>';
				}
					$html .= '<span> OR </span>';
				foreach($paid_trial as $paid){
					$html .=  '<a href="'.$online_trail[0]->slug.'" class="btn btn-blue">'.$paid->title. ' $'.$paid->amount.'</a>';
				}
			return $html;
			
			
			} else {
				 if(count($free_trial) == 1){
					foreach($free_trial as $free){
					$html .= '<a href="'.$online_trail[0]->slug.'" class="btn btn-white">'.$free->title.'</a>';
					}
				}
				
				
				if(count($paid_trial) == 1){
					foreach($paid_trial as $paid){
						$html .= '<a href="'.$online_trail[0]->slug.'" class="btn btn-blue">'.$paid->title. ' $'.$paid->amount.'</a>';
					}
				}
				
				return $html;
			}
				
			
	}
	
	
	/************ NEW FUNCTION ONLY FOR DEMO ************/
	
	public function children_programs(){
		
		$data = array();
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		  
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		
		$this->db->where("published", 1);
		$this->db->order_by("pos","asc");
		$data['form_allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		 $this->db->where("published", 1);
		 $this->db->order_by("pos","asc");
		 $data['myTestimonials'] = $this->query_model->getbyTable("tbltestimonials");

		//echo '<pre>'; print_R($data); die;   
			
		if($this->uri->segment(3) == NULL){
			$this->load->view('programs/children_programs', $data);
		}else{
			$this->load->view('programs/'.$this->uri->segment(3), $data);
		}
	}
	
	public function adult_programs(){
		
		$data = array();
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		  
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		
		$this->db->where("published", 1);
		$this->db->order_by("pos","asc");
		$data['form_allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		 $this->db->where("published", 1);
		 $this->db->order_by("pos","asc");
		 $data['myTestimonials'] = $this->query_model->getbyTable("tbltestimonials");

		//echo '<pre>'; print_R($data); die;   
		   
		if($this->uri->segment(3) == NULL){
			$this->load->view('programs/adult_programs', $data);
		}else{
			$this->load->view('programs/'.$this->uri->segment(3), $data);
		}
	}
	
	
	
public function thankyoupage(){
	
		$thankyouMessage = $this->session->userdata('thankyouMessage');
		$this->query_model->saveFormDataOnMATApi($thankyouMessage);
		if(!empty($thankyouMessage)){
			
			$data = $this->query_model->getThankyouPageData($thankyouMessage);
			
			$this->load->view('thankyou-page-message', $data);
		}else{
			redirect(base_url());
		}
		
	}


	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */