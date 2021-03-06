<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_instances extends CI_Controller {
	
	function __construct(){
		
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
			redirect('/admin/login');
        }
		$this->table_name = 'tbl_form_instances';
		$this->controller_name = 'form_instances';
	}
	
	public function index()
	{
		redirect('admin/'.$this->controller_name.'/view');
	}
	
	public function view(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = 'Form Instances ';
			
			$data['link_type'] = $this->controller_name;	
			$data['user_level']=$this->session->userdata['user_level'];	
			
			$data['form_types'] = $this->query_model->getByTable('tbl_form_types');
			
			
			
			if(!empty($data['form_types'])){
				foreach($data['form_types'] as $form_type){
					
					$data['pages_list'][$form_type->type] = $this->query_model->getAllPagesListAccordingFormTypes($form_type->id);
					
					
					$this->db->order_by('id','ASC');
					$this->db->select(array('id','name'));
					$data['form_modules'][$form_type->type] = $this->query_model->getbySpecific('tbl_form_modules', 'form_type_id',$form_type->id);
				}
			}
			//echo '<pre>data'; print_r($data); die;
			
			if(isset($_POST['submit'])){
				$this->saveFormInstanceFormData($_POST);
				
				redirect('admin/form_instances/view');
			}
			
			$this->load->view("admin/".$this->controller_name."_index", $data);
		
		}else
		{
			redirect('admin/login');
		}
	}
	
	
	public function saveFormInstanceFormData($postData){
		
		if(isset($postData['data']) && !empty($postData['data'])){
			$this->db->query("TRUNCATE TABLE ".$this->table_name);
			//echo '<pre>'; print_r($postData['data']); die;
			foreach($postData['data'] as $data_value){
				
				if(!empty($data_value)){
					
					foreach($data_value as $val){
						//$val['page_url'] = '/trial_upsells_payment/stripe_payment_gateway~6';
						$pageData = explode('~',$val['page_url']);
						if(isset($pageData[1]) && !empty($pageData[1])){
							$val['action_id'] = $pageData[1];
						}else{
							$val['action_id'] = 0;
						}
						
						$val['page_url'] = $pageData[0];
						
						//echo '<pre>'; print_r($val); die;
						if($val['action_id'] > 0){
							$this->db->where("action_id",$val['action_id']);
						}
						$exitResult = $this->query_model->getbySpecific($this->table_name, 'page_url',$val['page_url']);
						
						$insertData['page_name'] = $val['page_name'];
						$insertData['page_url'] = $val['page_url'];
						$insertData['form_type_id'] = $val['form_type_id'];
						$insertData['form_module_id'] = (isset($val['form_module_id']) && !empty($val['form_module_id'])) ? $val['form_module_id'] : 0;
						$insertData['action_id'] = isset($val['action_id']) ? $val['action_id'] : 0;
						$this->query_model->insertData($this->table_name, $insertData);
						
						/*if(empty($exitResult)){
							$insertData['page_name'] = $val['page_name'];
							$insertData['page_url'] = $val['page_url'];
							$insertData['form_type_id'] = $val['form_type_id'];
							$insertData['form_module_id'] = isset($val['form_module_id']) ? $val['form_module_id'] : 0;
							$insertData['action_id'] = isset($val['action_id']) ? $val['action_id'] : 0;
							$this->query_model->insertData($this->table_name, $insertData);
						}else{
							//echo $exitResult[0]->id.'<br/>'; 
							$updateData['form_module_id'] = isset($val['form_module_id']) ? $val['form_module_id'] : 0;
							//echo '<pre>updateData'; print_r($updateData); die;
							$this->query_model->updateData($this->table_name,'id',$exitResult[0]->id, $updateData);	
						} */
					}
				}
			}
		}
	}
	
	
	/*public function getAllPagesListAccordingFormTypes($form_type_id){
				
		$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
		
		$allLocations = $this->query_model->getbyTable("tblcontact");
		
		$mainLocation = $this->query_model->getMainLocation("tblcontact");
		
		$about_slug = $this->query_model->getbySpecific('tblmeta', 'id', 21);
		$about_slug = $about_slug[0];
		
		$contact_slug = $this->query_model->getbySpecific('tblmeta', 'id', 38);
		$contact_slug = $contact_slug[0];
		
		$program_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);
		$program_slug = $program_slug[0];
		
		$start_trial_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$start_trial_slug = $start_trial_slug[0];
                
        $events_slug = $this->query_model->getbySpecific('tblmeta', 'id', 27);
		$events_slug = $events_slug[0];
                
        $student_section_slug = $this->query_model->getbySpecific('tblmeta', 'id', 47);
		$student_section_slug = $student_section_slug[0];
		
		$trial_offer_slug = $this->query_model->getbySpecific('tblmeta', 'id', 40);
		$trial_offer_slug = $trial_offer_slug[0];
		
		$school_slug = $this->query_model->getbySpecific('tblmeta', 'id', 51);
		$school_slug = $school_slug[0];
		
		$multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
		$multiSchool = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
		$this->db->where("main_location", 0);
		$allSchoolContacts = $this->query_model->getbyTable("tblcontact");
		
		$multi_about_us = $this->query_model->multi_about_us();
				
				
		//echo '<pre>'; print_r($trial_offer_slug); die;
		$pages = array();
		
		$add_url = '/';
		
		// trial form 
		if($form_type_id == 1){
				
				$pages[$add_url] = 'Home';
                
				if($multiLocation[0]->field_value == 1 && $multiSchool == 0 && $multi_about_us == 1){
					foreach($allLocations as $allLocation){
							$about_url = $about_slug->slug.'/'.$allLocation->slug;
							$pages[$add_url.$about_url] = $about_slug->page_label.'- '.$allLocation->name;
						}
				} else{
						$about_url = $about_slug->slug.'/'.strtolower(str_replace(' ','-',$mainLocation[0]->city));
						$pages[$add_url.$about_url] = $about_slug->page_label;
				}
				
				if($multiLocation[0]->field_value == 1){
					if($multiSchool == 1){
					
						foreach($allSchoolContacts as $allLocation){
							$school_url = $school_slug->slug.'/'.$allLocation->slug;
							$pages[$add_url.$school_url] = $school_slug->page_label.'- '.$allLocation->name;
						}
					}
				}
				
				$pages[$add_url.$start_trial_slug->slug] = $start_trial_slug->page_label;
				
				$this->db->order_by('pos', 'asc');
				$this->db->where("published", 1);
				$trial_categories = $this->query_model->getbyTable('tbl_onlinespecial_categories');
				if(!empty($trial_categories)){
					foreach($trial_categories as $trial_category){
						
						$this->db->order_by('pos', 'asc');
						$this->db->where("display_trial", 1);
						$trial_offers = $this->query_model->getBySpecific('tblspecialoffer','cat_id',$trial_category->id);
						
						//echo '<pre>trial_offers'; print_r($trial_offers); die;
						if(!empty($trial_offers)){
							foreach($trial_offers as $trial_offer){
								if($trial_offer->trial == 1){
									$payment = $this->query_model->getByTable('tbl_payments');
									if(!empty($payment)){
										if($payment[0]->authorize_net_payment == 1){
											$authorized_payment_page_url = 'payment/buyoffer~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
											
											$pages[$add_url.$authorized_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') PAID';
											
										}elseif($payment[0]->braintree_payment == 1){
											$braintree_payment_page_url = 'payment/brainTreebuyoffer~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
											
											$pages[$add_url.$braintree_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') PAID';
											
										}elseif($payment[0]->stripe_payment == 1){
											$stripe_payment_page_url = 'payment/stripePaymentbuyoffer~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
											
											$pages[$add_url.$stripe_payment_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') PAID';
										}
									}
								}else{
									
									$free_trial_page_url = 'starttrial/buyspecial~'.$trial_category->id.':/'.$start_trial_slug->slug.'/'.$trial_category->slug;
									$pages[$add_url.$free_trial_page_url] = $trial_offer_slug->page_label.'- '.$trial_category->name.' ('.$this->query_model->getMetaDescReplace($trial_offer->offer_title).') FREE';
								}
							}
						}
						
						
						
						
					}
					
					
					foreach($trial_categories as $trial_category){
						
						$this->db->order_by('pos', 'asc');
						$this->db->where("display_trial", 1);
						$this->db->where("upsale", 1);
						$trialOffers = $this->query_model->getbySpecific('tblspecialoffer', 'cat_id', $trial_category->id);
						
					if(!empty($trialOffers)){
						foreach($trialOffers as $trialOffer){
							
							$payment = $this->query_model->getByTable('tbl_payments');
							if(!empty($payment)){
								if($payment[0]->authorize_net_payment == 1){
									$authorized_payment_page_url = 'trial_upsells_payment/authorized_payment_gateway/'.$trialOffer->id;
									$pages[$add_url.$authorized_payment_page_url] = $trial_category->name.' ~ '.$this->query_model->getMetaDescReplace($trialOffer->offer_title).'<br>Upsell: '.$this->query_model->getMetaDescReplace($trialOffer->title);
									
								}elseif($payment[0]->braintree_payment == 1){
									$braintree_payment_page_url = 'trial_upsells_payment/brainTreePaymentGateway/'.$trialOffer->id;
									$pages[$add_url.$braintree_payment_page_url] = $trial_category->name.' ~ '.$this->query_model->getMetaDescReplace($trialOffer->offer_title).'<br>Upsell:  '.$this->query_model->getMetaDescReplace($trialOffer->title);
									
								}elseif($payment[0]->stripe_payment == 1){
									$stripe_payment_page_url = 'trial_upsells_payment/stripe_payment_gateway/'.$trialOffer->id;
								$pages[$add_url.$stripe_payment_page_url] = $trial_category->name.' ~ '.$this->query_model->getMetaDescReplace($trialOffer->offer_title).'<br>Upsell:  '.$this->query_model->getMetaDescReplace($trialOffer->title);
								}
							}
								
							}
						}
					}
					
				}
				
				//echo '<pre>pages'; print_r($pages); die;
		}
		// program form
		elseif($form_type_id == 2){
			
			$program_nav = $this->query_model->getCategory("programs");
			if(!empty($program_nav)){
				$col = 1;
					foreach($program_nav as $nav_item_prog){
					$this->db->where('published',1);
					$query_subcat=$this->db->query("select `id` from tblprogram where category=".$nav_item_prog->cat_id."");
									$query_subcat=$query_subcat->result();
									
									$cat_name=str_replace(" ",'-',trim($nav_item_prog->cat_name));
									
									
									$published = 1;
									$query_sub = $this->query_model->getbySpecificRecord("tblprogram", "category", $nav_item_prog->cat_id,$published);
									
									if(isset($query_sub) && !empty($query_sub)) {
									$category_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug;
									$pages[$add_url.$category_url] = '<b>'.$nav_item_prog->cat_name.' - <span class="form-module-span-text">Main Cateogry </span></b>';
									
									foreach($query_sub as $subnav_item_prog){						
											$subcat_name=str_replace(" ",'-',trim($subnav_item_prog->program)); 
											
										
													  
													$program_page_url = $program_slug->slug.'/'.$nav_item_prog->cat_slug.'/'.$subnav_item_prog->program_slug;
													$pages[$add_url.$program_page_url] = $subnav_item_prog->buttonName;
											 }
											 
									}
							$col++; 
						}
		
					}
					
					//echo '<pre>pages'; print_r($pages); die;
		
		}
		
		
		// contact us
		elseif($form_type_id == 3){
			
			if($multiLocation[0]->field_value == 1 && $multiSchool == 0){
				foreach($allLocations as $allLocation){
						$contact_url = $contact_slug->slug.'/'.$allLocation->slug;
						$pages[$add_url.$contact_url] = $contact_slug->page_label.'- '.$allLocation->name;
					}
			} else{
					$contact_url = $contact_slug->slug;
					$pages[$add_url.$contact_url] = $contact_slug->page_label;
			}
			
			$student_section_contact_url = $student_section_slug->slug.'/contact';
			$pages[$add_url.$student_section_contact_url] = 'Studentsection Contact';
		}
		//dojocart forms
		elseif($form_type_id == 4){
			
				$paymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1); 
        
				$this->db->where("published", 1);
				$all_dojocart = $this->query_model->getbyTable("tbl_dojocarts");
					foreach ($all_dojocart as $dojocart_list){

						if($paymentDetail[0]->authorize_net_payment == 1 || $paymentDetail[0]->braintree_payment == 1  ){
				          if (!empty($dojocart_list->payment_type && $dojocart_list->payment_type == 'paid') ) {
				                if( !empty($paymentDetail[0]->authorize_net_payment) && $paymentDetail[0]->authorize_net_payment == 1 ){
				                  $action_value = 'dojocartpayment/authorized_payment_gateway/';
				                }

				                if( !empty($paymentDetail[0]->braintree_payment) && $paymentDetail[0]->braintree_payment == 1 ){
				                  $action_value = 'dojocartpayment/brainTreePaymentGateway/';
				                }
								
								if( !empty($paymentDetail[0]->stripe_payment) && $paymentDetail[0]->stripe_payment == 1 ){
				                  $action_value = 'dojocartpayment/stripe_payment_gateway/';
				                }
				            }else{
				                $action_value = 'dojocartpayment/buyspecial/';
				              }
				      }
				        else{
				          $action_value = 'dojocartpayment/buyspecial/';
				        }


						$dojocart_pages_url = 'promo/'.$dojocart_list->slug;
						$pages[$add_url.$dojocart_pages_url] = 'Dojocart- '.$dojocart_list->product_title;
						
					}
						
		}
		return $pages;
		
	}*/
	
	
}
