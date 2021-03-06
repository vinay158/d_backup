<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Promo extends CI_Controller {

		public function index($slug = ""){
		
		$folder_name = $_SERVER['CONTEXT_PREFIX'];
  		$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
   
	   if(isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])){
			$slug = $slug;
		}else{
			$slug = explode('/',$_SERVER['REQUEST_URI']);
			
		   if (isset($slug)) {
			   if($_SERVER['SERVER_NAME'] == "localhost"){
				 $slug = $slug[3];  
			   }else{
				   $slug = $slug[2];
			   }
			
		   }
		}
	   
	   
	   /**
	   * Get slug value from server
	   * $slug = $slug[2] for live,
	   * $slug = $slug[3] for local
	   **/

		$this->db->where("slug", $slug);
		$this->db->where("published", 1);
		$data['single_record'] = $this->query_model->getbyTable("tbl_dojocarts");
		
		$data['twilioApi'] = $this->query_model->getTwilioApiType();
		
		if(isset($data['single_record']) && !empty($data['single_record'])){
			
			if($data['single_record'][0]->show_location_type == "show_all"){
			
			if($this->query_model->checkMultiSchoolIsOn() == 1){
				$this->db->where("turn_on_nested_location", 0);  //not nested child locations
			}
			$this->db->where("location_type !=", 'coming_soon_location');
			//$this->db->where("main_location", 0);
			$this->db->where("published", 1);
			$this->db->order_by("state","asc");
			$data['form_allLocations'] = $this->query_model->getbyTable("tblcontact");
			
		}elseif($data['single_record'][0]->show_location_type == "select_location"){
			$selectedLocationsArr = !empty($data['single_record'][0]->locations) ? unserialize($data['single_record'][0]->locations) : array();
			
			if(!empty($selectedLocationsArr)){
				$selectedLocations  =array();
				$finalLocations  = array();
				foreach($selectedLocationsArr as $selectedLoc){
					
					/*$cityState = explode('~',$selectedLoc);
					$city = $cityState[0];
					$state = $cityState[1];*/
					if($this->query_model->checkMultiSchoolIsOn() == 1){
						$this->db->where("turn_on_nested_location", 0);  //not nested child locations
					}
					$this->db->where("published", 1);
					$this->db->where("id", $selectedLoc);
					//$this->db->where("city", $city);
					//$this->db->where("state", $state);
					$locationResult = $this->query_model->getbyTable("tblcontact");
					if(!empty($locationResult )){
						foreach($locationResult as $locationRes){
							
							$selectedLocations[$locationRes->id] = $locationRes;
						}
					}
				}
				$data['form_allLocations'] = $selectedLocations;
			}
			
		}
		
		
			$data['single_record'] = $data['single_record'][0];
			
			$dojocart_id = $data['single_record']->id;
			$data['upsells'] = $this->query_model->getbySpecific("tbl_dojocart_upsales",'dojocart_id',$dojocart_id);
			
			$this->db->where("published", 1);
			$this->db->order_by("pos","asc");
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			
			$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
			
			$data['custom_fields'] = $this->query_model->getbySpecific("tbl_dojocart_custom_fields",'dojocart_id',$dojocart_id);
			
			$data['dojocart_items'] = $this->query_model->getbySpecific("tbl_dojocart_items",'dojocart_id',$dojocart_id);
			
			
			$clientToken = '';
					$brainTreeDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
					
					if(!empty($brainTreeDetail)){
						if($brainTreeDetail[0]->braintree_payment == 1 && $data['single_record']->payment_type == "paid"){
							
							$braintree_merchant_id = $brainTreeDetail[0]->braintree_merchant_id;
							$braintree_public_key = $brainTreeDetail[0]->braintree_public_key;
							$braintree_private_key = $brainTreeDetail[0]->braintree_private_key;
							
							include("./vendor/lib/Braintree.php");
							//$this->load->library('Braintree');
							
							/*$gateway = new Braintree_Gateway([
											'environment' => $brainTreeDetail[0]->braintree_payment_mode,
											'merchantId' => $braintree_merchant_id,
											'publicKey' => $braintree_public_key,
											'privateKey' => $braintree_private_key
										]);
							
							// or like this:
							$config = new Braintree_Configuration([
								'environment' => $brainTreeDetail[0]->braintree_payment_mode,
								'merchantId' => $braintree_merchant_id,
								'publicKey' => $braintree_public_key,
								'privateKey' => $braintree_private_key
							]);*/
							
							try {
								$gateway = new Braintree\Gateway([
													'environment' => $brainTreeDetail[0]->braintree_payment_mode,
													'merchantId' => $braintree_merchant_id,
													'publicKey' => $braintree_public_key,
													'privateKey' => $braintree_private_key
												]);
								
								$clientToken = $gateway->clientToken()->generate();
							
							} catch (Braintree\Exception\Authentication $e) {
								echo 'Authentication Error ! '. $e->getMessage(); die;
							}
							

							
							/*if($brainTreeDetail[0]->braintree_payment_mode == "production"){
								Braintree_Configuration::environment('production');
							}else{
								Braintree_Configuration::environment('sandbox');
							}

							Braintree_Configuration::merchantId($braintree_merchant_id);
							Braintree_Configuration::publicKey($braintree_public_key);
							Braintree_Configuration::privateKey($braintree_private_key);
				
							$clientToken = Braintree_ClientToken::generate();	*/						
						}
						
					}
					
			$data['clientToken'] = $clientToken;
			
					
			// Stripe SCA
			$data['stripePayment'] = $this->query_model->getStripePaymentKeys();
			
			if($data['single_record']->template == 'tournaments'){
				$this->load->view('dojocart_tournaments_template', $data);
			}elseif($data['single_record']->template == 'events'){
				$this->load->view('dojocart_events_template', $data);
			}elseif($data['single_record']->template == "ata_cr_xma" || $data['single_record']->template == "tiger_blank" || $data['single_record']->template == "novice_blank" || $data['single_record']->template == "traditional_blank"){
				$this->load->view('dojocart_ata_cr_xma_template', $data);
			}elseif($data['single_record']->template == 'multi_item_dojocart'){
				$this->load->view('dojocart_multi_item_template', $data);
			}else{
				$this->load->view('dojocart_default', $data);
			}
			
		}
		else{
			redirect('/','location',301);
		}
		


	}

public function thankyoupage(){
	
		$thankyouMessage = $this->session->userdata('thankyouMessage');
		
		$this->query_model->saveFormDataOnMATApi($thankyouMessage);
		if(!empty($thankyouMessage)){
			
			$data = $this->query_model->getThankyouPageData($thankyouMessage);
			//echo '<pre>data'; print_R($data); die;
			$this->load->view('thankyou-page-message', $data);
		}else{
			redirect(base_url());
		}
	}


		

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */