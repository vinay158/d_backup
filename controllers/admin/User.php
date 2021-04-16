<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }		

	}
	
	public function switch_login(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$this->db->select('dojo_crm_url');
			$site_setting = $this->query_model->getByTable('tblsite');
			
			$crm_login_url = $site_setting[0]->dojo_crm_url.'/web-services/switch-dojo-user';
			
		//	$crm_login_url = 'https://localhost/dojo_crm_v1/public/web-services/switch-dojo-user';
			
			
			$userDetail = $this->query_model->getBySpecific('tbladmin','id',$this->session->userdata("userid"));
			$userDetail = !empty($userDetail) ? $userDetail[0] : '';
			
			if(!empty($userDetail) && !empty($userDetail->secret_key) && !empty($userDetail->access_token)){
				
				$redirect_url = $crm_login_url.'?uEmail='.$userDetail->email.'&uName='.$userDetail->user.'&uAction=dojo-switch-user&uSecret_key='.$userDetail->secret_key.'&uUserId=&uAccessToken='.$userDetail->access_token.'&uPassword=';
				
				redirect($redirect_url);
				
			}
		}
	}
	
	public function index()
	{ 
		$is_logged_in = $this->session->userdata('is_logged_in');
			if(!empty($is_logged_in) && $is_logged_in == true)
			{
				$data['title'] = "User Account";
				$id = $this->session->userdata("userid");
				$data['user'] = $this->query_model->getbyId("tbladmin", $id);
				if(isset($_POST['update'])) :
					$uid = $_POST['id'];
					$user = $_POST['user'];
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$change =  $_POST['change'];
					$email =  $_POST['email'];
					$pass = $_POST['newpass'];
					
				if($change == 1)
					$data = array("user" => $user, "password" => sha1($pass) , "fname" => $fname , "lname" => $lname, "email" => $email);
				else
					$data = array("user" => $user, "fname" => $fname , "lname" => $lname, "email" => $email);
					
					if($this->query_model->update("tbladmin", $uid, $data)):
						
						redirect("admin/user");
					endif;
				endif;
				$this->load->view('admin/user_edit', $data);	
			}else{
				redirect("admin/login");
			}
	}

}