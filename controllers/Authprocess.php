<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authprocess extends CI_Controller {

	public function index()
	{	
		$album_id=isset($_POST['album_id'])?$_POST['album_id']:'';
		$pass=isset($_POST['login_pass'])?$_POST['login_pass']:'';
		$login=isset($_POST['login_name'])?$_POST['login_name']:'';
		$action=isset($_POST['action'])?$_POST['action']:'';		
		$auth_data=$this->config->item('_credentials');		
		
		if($auth_data[$action][$album_id]['pass']==$pass && $auth_data[$action][$album_id]['user']==$login){			
				
			$session_key = "access_" . $album_id;
			$pp_pages[$session_key] = $album_id;
			
			$pp_session = $this->session->userdata($pp_pages[$session_key]);
			
			$grant_access = (!empty($pp_session) && $pp_session == $album_id) ? TRUE : FALSE; 
			if(!$grant_access) {
				$this->session->set_userdata($pp_pages);
			}			
			echo 1;
		}else{
			echo 0;			
		}
		exit;	
	}
}
?>