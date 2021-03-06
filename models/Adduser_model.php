<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adduser_model extends CI_Model{
	
	var $table = 'tbladmin';
	
	function addUser(){
		
		$flag = false;
		$error_arr = array();
		$email_to_validate = $_POST['email'];
		$facebook_email = $_POST['facebook_email']; // vinay 04/11
		$user_type = $_POST['user_type']; // vinay 04/11
		
		$username = $_POST['firstname'];
		$password = 'LeOBpz#980';
		if($user_type != "FaceBookUser"){
			$username = $_POST['username'];
			$password = $_POST['password'];
		}
		
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		
		if(!empty($_POST['home'])):
			$str = "Home:".implode(',',$_POST['home'])."$";
		endif;
		if(!empty($_POST['about'])):
			$str = $str."About:".implode(',',$_POST['about'])."$";
		endif;
		if(!empty($_POST['contact'])):
			$str = $str."Contact:".implode(',',$_POST['contact'])."$";	
		endif;
		if(!empty($_POST['setting'])):
			$str = $str."Setting:".implode(',',$_POST['setting'])."$";	
		endif;
		if(!empty($_POST['other'])):
			$str = $str."Other:".implode(',',$_POST['other']);	
		endif;
		
		if(!empty($_POST['school_info'])):
			$str = $str."School Info:".implode(',',$_POST['school_info']);	
		endif;
		
		if(!empty($_POST['trial_offer'])):
			$str = $str."Trial Offer:".implode(',',$_POST['trial_offer']);	
		endif;
		
		if(!empty($_POST['forms'])):
			$str = $str."Forms:".implode(',',$_POST['forms']);	
		endif;
		
		if(!empty($_POST['leads'])):
			$str = $str."Leads:".implode(',',$_POST['leads']);	
		endif;
		
		if(!empty($_POST['school'])):
			$str = $str."School:".implode(',',$_POST['school']);	
		endif;
		
		if(!empty($_POST['twilio_sms_messenger'])):
			$str = $str."SMS:".implode(',',$_POST['twilio_sms_messenger']);	
		endif;
		
		if(!empty($_POST['unique_trial_offer'])):
			$str = $str."Unique Trial Offer:".implode(',',$_POST['unique_trial_offer']);	
		endif;
		
		/*if(empty($username)){
			array_push($error_arr, "Username");
		}
		if(empty($password)){
			array_push($error_arr, "password");
		}*/
		if(empty($firstname)){
			array_push($error_arr, "First name");
		}
		if(empty($lastname)){
			array_push($error_arr, "Last name");
		}
		
		$flag = false;
		if(!empty($error_arr)){
			$str = implode(', ',$error_arr);
			$flag = true;
			$err_str = "Required Fields ".$str." !";
			echo "<script>alert('".$err_str."')</script>";
		}else{
			if (!filter_var($email_to_validate, FILTER_VALIDATE_EMAIL)){
				$flag = true;
				echo "<script> alert('Invalid Email Address!');</script> ";
			}
		
		
			$data = $this->query_model->getbyTableData("tbladmin");
			foreach ($data as $user){
				if($user_type != "FaceBookUser"){
					if($user->user == $_POST['username']){
						$flag = true;
						echo "<script>alert('Username already exists!');</script>";
					}
				}else{
					if($user->facebook_email == $_POST['facebook_email']){
						$flag = true;
						echo "<script>alert('Username already exists!');</script>";
					}
				}
			}
		
			if($flag==false):
				if($username == ''){
						$username = $firstname.'.'.$lastname;
				}
				$data = array("user" => $username, "password" => sha1($password),  "fname" => $firstname,  "lname" => $lastname,  "email" => $email, 'user_level'=>2, 'facebook_email' => $facebook_email,'user_type' => $user_type);
				if($this->query_model->insertData($this->table,$data)):
				
					$link_data = array("user_id" => mysqli_insert_id($this->db->conn_id), "slug" => $str);
					
					$this->query_model->insertData('tbllinks',$link_data);
					redirect("admin/adduser");
				endif;			
			endif;
		}
	}
	
	function updateUser(){
		//echo '<pre>'; print_r($_POST); die;
		$flag = false;
		$error_arr = array();
		$email_to_validate = $_POST['email'];
		$facebook_email = $_POST['facebook_email']; // vinay 04/11
		$user_type = $_POST['user_type']; // vinay 04/11
		$username = '';
		$password = 'LeOBpz#980';
		if($user_type != "FaceBookUser"){
			$username = $_POST['username'];
			$password = $_POST['password'];
		}
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];		 
		$str='';
		if(!empty($_POST['home'])):
			$str = "Home:".implode(',',$_POST['home'])."$";
		endif;
		if(!empty($_POST['about'])):
			$str = $str."About:".implode(',',$_POST['about'])."$";
		endif;
		if(!empty($_POST['contact'])):
			$str = $str."Contact:".implode(',',$_POST['contact'])."$";	
		endif;
		if(!empty($_POST['setting'])):
			$str = $str."Setting:".implode(',',$_POST['setting'])."$";	
		endif;
		if(!empty($_POST['other'])):
			$str = $str."Other:".implode(',',$_POST['other']);	
		endif;		
		
		
		if(!empty($_POST['school_info'])):
			$str = $str."School Info:".implode(',',$_POST['school_info']);	
		endif;
		
		if(!empty($_POST['trial_offer'])):
			$str = $str."Trial Offer:".implode(',',$_POST['trial_offer']);	
		endif;
		
		if(!empty($_POST['forms'])):
			$str = $str."Forms:".implode(',',$_POST['forms']);	
		endif;
		
		if(!empty($_POST['leads'])):
			$str = $str."Leads:".implode(',',$_POST['leads']);	
		endif;
		
		if(!empty($_POST['school'])):
			$str = $str."School:".implode(',',$_POST['school']);	
		endif;
		
		if(!empty($_POST['twilio_sms_messenger'])):
			$str = $str."SMS:".implode(',',$_POST['twilio_sms_messenger']);	
		endif;
		
		if(!empty($_POST['unique_trial_offer'])):
			$str = $str."Unique Trial Offer:".implode(',',$_POST['unique_trial_offer']);	
		endif;
		
		/*if(empty($username)){
			array_push($error_arr, "Username");
		}*/
		if(empty($firstname)){
			array_push($error_arr, "First name");
		}
		if(empty($lastname)){
			array_push($error_arr, "Last name");
		}
		
		if($username == ''){
				$username = $firstname.'.'.$lastname;
		}
		
		if($user_type != "FaceBookUser"){
			$this->db->where('id != ', $this->uri->segment(4));
			$exitUser = $this->query_model->getbySpecific('tbladmin', 'user', $username);
		}else{
			$this->db->where('id != ', $this->uri->segment(4));
			$exitUser = $this->query_model->getbySpecific('tbladmin', 'facebook_email', $facebook_email);
		}	
			if(!empty($exitUser)){
				$flag = true;
				echo "<script>alert('Username already exists!');</script>";
			}
		
		
		if(!empty($error_arr)){
			$str = implode(', ',$error_arr);
			$err_str = "Required Fields ".$str." !";
			echo "<script>alert('".$err_str."')</script>";
		}else{
			if (!filter_var($email_to_validate, FILTER_VALIDATE_EMAIL)){
				echo "<script>alert('Invalid Email Address!')</script>";
			}else{
				if(empty($exitUser)){
				if(empty($password)){
					$data = array("user" => $username, "fname" => $firstname,  "lname" => $lastname,  "email" => $email, 'user_level'=>2, 'facebook_email' => $facebook_email,'user_type' => $user_type);
					if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
					
						// Delete existing permissions if any
						$this->db->where("user_id", $this->uri->segment(4));
						$this->db->delete("tbllinks");
						
						// Insert new permissions
						$link_data = array("user_id" => $this->uri->segment(4), "slug" => $str);
						$this->query_model->insertData('tbllinks',$link_data);
						
						redirect("admin/adduser");
					endif;
				}else{
					$data = array("user" => $username, "password" => sha1($password),  "fname" => $firstname,  "lname" => $lastname,  "email" => $email, 'user_level'=>2, 'facebook_email' => $facebook_email,'user_type' => $user_type);
					if($this->query_model->update($this->table,$this->uri->segment(4),$data)):

						// Delete existing permissions if any
						$this->db->where("user_id", $this->uri->segment(4));
						$this->db->delete("tbllinks");
						 
						// Insert new permissions
						$link_data = array("user_id" => $this->uri->segment(4), "slug" => $str);
						$this->query_model->insertData('tbllinks',$link_data);
						redirect("admin/adduser");
					endif;
				}
				}
			}
		}
	}
}