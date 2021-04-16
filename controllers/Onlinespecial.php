<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Onlinespecial extends CI_Controller {



	function __construct(){

		parent::__construct();

		$this->load->model('trial_model');

	}

	

	public function index(){
		 $data['trials'] = $this->query_model->getbySpecific('tblspecialoffer', 'display_trial', 1);
		
		 $this->db->where('display_trial',1);
		 $data['free_trial'] = $this->query_model->getbySpecific('tblspecialoffer', 'trial', 0);
			 
		 $this->db->where('display_trial',1);
		 $data['paid_trial'] = $this->query_model->getbySpecific('tblspecialoffer', 'trial', 1);
		
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		$data['site_settings'] = $data['site_settings'][0];
		
		$data['trials_value'] = $this->checktrials($data['free_trial'], $data['paid_trial']);
		$this->load->view('onlinespecial', $data);
	}
	
	
	
	public function checktrials($free_trial, $paid_trial){
			$html = '';
			if(count($paid_trial) == 2){
				
				foreach($paid_trial as $paid){
					$features = unserialize($paid->features);
					$html .= '<div class="col-md-6 col-sm-6 col-xs-12"><div class="price-detail text-center"><div class="header b-bg">';
					$html .= ' <h3>'.$paid->offer_title.'</h3>';
					$html .= ' <p class="sky-txt" >'.$paid->offer_description.'</p>';
					$html .= ' </div>';
					$html .= ' <div class="price"><h2>$'.$paid->amount.'</h2></div>';
					$html .= ' <ul class="feature-list">';
					
					if(!empty($features)){
						foreach($features as $feature){
							$html .= ' <li>'.$feature.'</li>';
						}
					}
					
					$html .= ' </ul>';
					$html .= ' <div class="buttons-container">';
					$html .= ' <a class="btn-animate blue" href="javascript:void(0)">';
					$html .= ' <span class="btn-text"><input type="checkbox" name="" class="trial_offer_checkbox" number="'.$paid->id.'" /> <span class="selectedTrial'.$paid->id.'">Select</span></span> ';
					$html .= '  <span class="btn-slide-text">Fill out your info below to <br>redeem this Web Special Offer!</span>';
					$html .= ' </a>';
					$html .= ' </div>';
					$html .= ' </div>';
					$html .= ' </div>';
					
				
				}
				return $html;
			
			
			} elseif(count($paid_trial) == 1 &&  count($free_trial) == 1){
			
				foreach($free_trial as $free){
					$freefeatures = unserialize($free->features);
					$html .= '<div class="col-md-6 col-xs-12 col-sm-6"><div class="price-detail text-center"><div class="header r-bg">';
					$html .= ' <h3>'.$free->offer_title.'</h3>';
					$html .= ' <p>'.$free->offer_description.'</p>';
					$html .= ' </div>';
					$html .= ' <div class="price"><h2>FREE</h2></div>';
					$html .= ' <ul class="feature-list">';
					
					if(!empty($freefeatures)){
						foreach($freefeatures as $feature){
							$html .= ' <li>'.$feature.'</li>';
						}
					}
					
					$html .= ' </ul>';
					$html .= ' <div class="buttons-container">';
					$html .= ' <a class="btn-animate" href="javascript:void(0)">';
					$html .= ' <span class="btn-text"><input type="checkbox" name="" class="trial_offer_checkbox" /> <span class="selectedTrial">Select</span></span> ';
					$html .= '  <span class="btn-slide-text">Fill out your info below to <br>redeem this Web Special Offer!</span>';
					$html .= ' </a>';
					$html .= ' </div>';
					$html .= ' </div>';
					$html .= ' </div>';
					
				
				}
				
				foreach($paid_trial as $paid){
					$features = unserialize($paid->features);
					$html .= '<div class="col-md-6 col-sm-6 col-xs-12"><div class="price-detail text-center"><div class="header b-bg">';
					$html .= ' <h3>'.$paid->offer_title.'</h3>';
					$html .= ' <p class="sky-txt" >'.$paid->offer_description.'</p>';
					$html .= ' </div>';
					$html .= ' <div class="price"><h2>$'.$paid->amount.'</h2></div>';
					$html .= ' <ul class="feature-list">';
					
					if(!empty($features)){
						foreach($features as $feature){
							$html .= ' <li>'.$feature.'</li>';
						}
					}
					
					$html .= ' </ul>';
					$html .= ' <div class="buttons-container">';
					$html .= ' <a class="btn-animate blue" href="#">';
					$html .= ' <span class="btn-text"><i class="fa fa-check-square-o"></i> Select</span> ';
					$html .= '  <span class="btn-slide-text">Fill out your info below to <br>redeem this Web Special Offer!</span>';
					$html .= ' </a>';
					$html .= ' </div>';
					$html .= ' </div>';
					$html .= ' </div>';
					
				
				}
				
				
				return $html;
			
			} else {
				 if(count($free_trial) == 1){
					foreach($free_trial as $free){
					$freefeatures = unserialize($free->features);
					$html .= '<div class="col-md-6 col-xs-12 col-sm-6  col-lg-offset-3"><div class="price-detail text-center"><div class="header r-bg">';
					$html .= ' <h3>'.$free->offer_title.'</h3>';
					$html .= ' <p>'.$free->offer_description.'</p>';
					$html .= ' </div>';
					$html .= ' <div class="price"><h2>FREE</h2></div>';
					$html .= ' <ul class="feature-list">';
					
					if(!empty($freefeatures)){
						foreach($freefeatures as $feature){
							$html .= ' <li>'.$feature.'</li>';
						}
					}
					
					$html .= ' </ul>';
					$html .= ' <div class="buttons-container">';
					$html .= ' <a class="btn-animate" href="#">';
					$html .= ' <span class="btn-text"><i class="fa fa-check-square-o"></i> Select</span> ';
					$html .= '  <span class="btn-slide-text">Fill out your info below to <br>redeem this Web Special Offer!</span>';
					$html .= ' </a>';
					$html .= ' </div>';
					$html .= ' </div>';
					$html .= ' </div>';
					
					}
				}
				
				
				if(count($paid_trial) == 1){
					foreach($paid_trial as $paid){
						$features = unserialize($paid->features);
						$html .= '<div class="col-md-6 col-sm-6 col-xs-12  col-lg-offset-3"><div class="price-detail text-center"><div class="header b-bg">';
						$html .= ' <h3>'.$paid->offer_title.'</h3>';
						$html .= ' <p class="sky-txt" >'.$paid->offer_description.'</p>';
						$html .= ' </div>';
						$html .= ' <div class="price"><h2>$'.$paid->amount.'</h2></div>';
						$html .= ' <ul class="feature-list">';
						
						if(!empty($features)){
							foreach($features as $feature){
								$html .= ' <li>'.$feature.'</li>';
							}
						}
						
						$html .= ' </ul>';
						$html .= ' <div class="buttons-container">';
						$html .= ' <a class="btn-animate blue" href="#">';
						$html .= ' <span class="btn-text"><i class="fa fa-check-square-o"></i> Select</span> ';
						$html .= '  <span class="btn-slide-text">Fill out your info below to <br>redeem this Web Special Offer!</span>';
						$html .= ' </a>';
						$html .= ' </div>';
						$html .= ' </div>';
						$html .= ' </div>';
						
					
					}
				}
				
				return $html;
			}
				
			
	}

	
}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */
