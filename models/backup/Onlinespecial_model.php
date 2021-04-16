<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onlinespecial_model extends CI_Model{
	
	var $table = 'tblspecialoffer';
	
	function addOffer(){
		$name = $_POST['name'];
		$offer = $_POST['offer'];
		$desc = $_POST['desc'];		
		$amount = $_POST['amount'];
		$amount=number_format($amount, 2, '.', ',');
		$email = $_POST['email'];
		
		$data = array("special_name" => $name, "special_offer" => $offer,  "details" => $desc,  "trial_amount" => $amount,  "paypal_email" => $email);
		if($this->query_model->insertData($this->table,$data)):
			redirect("admin/onlinespecial");
		endif;
	}
	
	function updateOffer(){
		$error_arr = array();
		$email_to_validate = $_POST['email'];
		$amount = $_POST['amount'];
		if(!is_numeric($amount)){
			array_push($error_arr, "Amount");
			//echo "<script>alert('Invalid amount!')</script>";
		}
		if (!filter_var($email_to_validate, FILTER_VALIDATE_EMAIL)) {
			array_push($error_arr, "Email");
			//echo "<script>alert('Invalid Email!')</script>";
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
			$data = array("special_name" => $name, "special_offer" => $offer,  "details" => $desc,  "trial_amount" => $amount,  "paypal_email" => $email, "featured_on_off"=>$featured);
			
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
				redirect("admin/onlinespecial");
			endif;				
		}
		
		}
}