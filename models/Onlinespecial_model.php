<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onlinespecial_model extends CI_Model{
	
	var $table = 'tblspecialoffer';
	
	function addOffer(){
		//echo '<pre>'; print_r($_POST); die;
		$data['title'] = $_POST['offer_title'];
		$data['description'] = $_POST['description'];
		$data['trial'] = $_POST['trial'];
		$data['offer_title'] = $_POST['offer_title'];
		$data['offer_description'] = $_POST['offer_description'];
		$data['large_offer_text'] = $_POST['large_offer_text'];
		$data['additional_text_1'] = isset($_POST['additional_text_1']) ? $_POST['additional_text_1'] : '';
		$data['additional_text_2'] = isset($_POST['additional_text_2']) ? $_POST['additional_text_2'] : '';
		$data['additional_text_3'] = isset($_POST['additional_text_3']) ? $_POST['additional_text_3'] : '';
		$data['amount'] = isset($_POST['amount']) ? number_format($_POST['amount'], 2, '.', '') : '';
		$data['features'] = serialize($_POST['features']);
		$data['override_logo'] = $_POST['override_logo'];
		$data['cat_id'] = isset($_POST['cat_id'])? $_POST['cat_id'] : 0;
		$data['pos'] = isset($_POST['pos'])? $_POST['pos'] : 0;
		$data['is_child_name'] = (isset($_POST['is_child_name']) && !empty($_POST['is_child_name']))? $_POST['is_child_name'] : 0;
		
		$data['third_party_tiral_url_type'] = isset($_POST['third_party_tiral_url_type']) ? $_POST['third_party_tiral_url_type'] : 0;
		$data['third_party_trial_url'] = $_POST['third_party_trial_url'];
		
		$data['upsale'] = isset($_POST['upsale']) ? $_POST['upsale'] : 0;
		$data['show_term_condition'] = isset($_POST['show_term_condition']) ? $_POST['show_term_condition'] : 0;
		$data['term_condition'] = isset($_POST['term_condition']) ? $_POST['term_condition'] : '';
		
		
		if($this->query_model->insertData($this->table,$data)):
		
			$insert_id = $this->db->insert_id();
			if($data['upsale'] == 1){
					foreach($_POST['data'] as $upsalePage){
						$updata['up_title'] = $upsalePage['up_title'];
						$updata['up_price'] = $upsalePage['up_price'];
						$updata['yes'] = $upsalePage['yes'];
						$updata['no'] = !empty($upsalePage['no']) ? $upsalePage['no'] : "No Thank You. I'll Pay Full Price Another Time.";
						$updata['description'] = $upsalePage['description'];
						$updata['text_1'] = $upsalePage['text_1'];
						$updata['trial_offer_id'] = $insert_id;
						$updata['upsell_top_text'] = $upsalePage['upsell_top_text'];
						
						$updata['video_type'] = !empty($upsalePage['video_type']) ? $upsalePage['video_type'] : 'youtube_video';
						$updata['youtube_video'] = !empty($upsalePage['youtube_video']) ? $upsalePage['youtube_video'] : '';
						$updata['vimeo_video'] = !empty($upsalePage['vimeo_video']) ? $upsalePage['vimeo_video'] : '';
					$this->query_model->insertData('tbl_onlinespecial_upsales',$updata);
				}
			}
		
			redirect("admin/onlinespecial/view/".$data['cat_id']);
		endif;
	}
	
	function updateOffer(){
		
		$data['title'] = $_POST['offer_title'];
		$data['description'] = $_POST['description'];
		$payment_result = $this->query_model->getbyTable('tbl_payments');
		$data['trial'] = $_POST['trial'];
		if($payment_result[0]->authorize_net_payment == 0 && $payment_result[0]->braintree_payment == 0 && $payment_result[0]->stripe_payment == 0 && $payment_result[0]->stripe_ideal_payment == 0 && $payment_result[0]->paypal_payment == 0){
			$data['trial'] = 0;
		}
							
		
		$data['offer_title'] = $_POST['offer_title'];
		$data['offer_description'] = $_POST['offer_description'];
		$data['large_offer_text'] = $_POST['large_offer_text'];
		$data['additional_text_1'] = isset($_POST['additional_text_1']) ? $_POST['additional_text_1'] : '';
		$data['additional_text_2'] = isset($_POST['additional_text_2']) ? $_POST['additional_text_2'] : '';
		$data['additional_text_3'] = isset($_POST['additional_text_3']) ? $_POST['additional_text_3'] : '';
		$data['amount'] = isset($_POST['amount']) ? number_format($_POST['amount'], 2, '.', '') : '';
		$data['features'] = serialize($_POST['features']);
		$data['override_logo'] = $_POST['override_logo'];
		$data['cat_id'] = isset($_POST['cat_id'])? $_POST['cat_id'] : 0;
		$data['is_child_name'] = (isset($_POST['is_child_name']) && !empty($_POST['is_child_name']))? $_POST['is_child_name'] : 0;
		
		
		$data['third_party_tiral_url_type'] = isset($_POST['third_party_tiral_url_type']) ? $_POST['third_party_tiral_url_type'] : 0;
		$data['third_party_trial_url'] = $_POST['third_party_trial_url'];
		
		$data['upsale'] = isset($_POST['upsale']) ? $_POST['upsale'] : 0;
		
		$data['show_term_condition'] = isset($_POST['show_term_condition']) ? $_POST['show_term_condition'] : 0;
		$data['term_condition'] = isset($_POST['term_condition']) ? $_POST['term_condition'] : '';
		
		
		//echo '<pre>data'; print_R($data); die;
		$this->query_model->update($this->table,$this->uri->segment(4),$data);
		
		if($data['upsale'] == 1){
			if(!empty($_POST['data'])){
			$this->query_model->deletebySpecific('tbl_onlinespecial_upsales','trial_offer_id',$this->uri->segment(4));
				foreach($_POST['data'] as $upsalePage){
					if(!empty($upsalePage['up_price'])){
						$updata['up_title'] = !empty($upsalePage['up_title']) ? $upsalePage['up_title'] : '';
						$updata['up_price'] = !empty($upsalePage['up_price']) ? $upsalePage['up_price'] : '';
						$updata['yes'] = !empty($upsalePage['yes']) ? $upsalePage['yes'] : '' ;
						$updata['no'] = !empty($upsalePage['no']) ? $upsalePage['no'] : "No Thank You. I'll Pay Full Price Another Time.";
						$updata['description'] = !empty($upsalePage['description']) ? $upsalePage['description'] : '';
						$updata['text_1'] = !empty($upsalePage['text_1']) ? $upsalePage['text_1'] : '';
						$updata['upsell_top_text'] = !empty($upsalePage['upsell_top_text']) ? $upsalePage['upsell_top_text'] : '';
						
						$updata['video_type'] = !empty($upsalePage['video_type']) ? $upsalePage['video_type'] : 'youtube_video';
						$updata['youtube_video'] = !empty($upsalePage['youtube_video']) ? $upsalePage['youtube_video'] : '';
						$updata['vimeo_video'] = !empty($upsalePage['vimeo_video']) ? $upsalePage['vimeo_video'] : '';
						$updata['trial_offer_id'] = $this->uri->segment(4);
						$this->query_model->insertData('tbl_onlinespecial_upsales',$updata);
					}
				}
			}
		}
		
		redirect("admin/onlinespecial/view/".$data['cat_id']);		
	}
	
	/*function updateOffer(){
		
		$error_arr = array();
		$email_to_validate = $_POST['email'];
		$amount = $_POST['amount'];
		
		if(!is_numeric($amount)){
			array_push($error_arr, "Amount");
			
		}
		if (!filter_var($email_to_validate, FILTER_VALIDATE_EMAIL)) {
			array_push($error_arr, "Email");
			
		}
		if(!empty($error_arr)){
			$str = implode(' and ',$error_arr);
			$err_str = "Invalid ".$str."!";
			echo "<script>alert('".$err_str."')</script>";
		}else{
			$name = $_POST['name'];
			$offer = $_POST['offer'];
			$desc ='';
			
			if(isset($_POST['desc']) && $_POST['desc']!=''){				
		 		$desc = $_POST['desc'];		 	
		 		
				if ( ( is_string($desc) && is_numeric($desc) ) || is_string($desc) ){
						if ( get_magic_quotes_gpc() )
							$desc = htmlspecialchars( stripslashes((string)$desc) );
						else
							$desc = htmlspecialchars((string)$desc);
				}			
			}			
			
			$amount = $_POST['amount'];
			$email = $_POST['email'];
			
			if(!isset($_POST['feature'])) {
				$featured = 'off';
			} else {
				$featured = $_POST['feature'];
			}
			$amount=number_format($amount, 2, '.', ',');
			
			$trial=$_POST['trial'];
			if($trial=="Paid")
			{
				$flag=1;
			}
			else{
				$flag=0;
			}
			
			$data = array("special_name" => $name, "special_offer" => $offer,  "details" => $desc,  "trial_amount" => $amount,  "paypal_email" => $email, "featured_on_off"=>$featured,"flag"=>$flag);
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
				redirect("admin/onlinespecial");
			endif;				
		}
		
		}*/
}