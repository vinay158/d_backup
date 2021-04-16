<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Livestream extends CI_Controller {

	public function index()
	{	
		//user auth start	
		$data['action'] = "livestream";					
		$data['albumId']='0';
		$data['loginRequired']=false;	
		/*
		$auth_data=$this->config->item('_credentials');
		if(array_key_exists($data['albumId'],$auth_data[$data['action']])){
			$data['loginRequired']=true;						
		}
		//check user is logged in or not
		 
		$this->load->library('session');		
		$sessionData=$this->session->userdata;							
		$key='access_'.$data['albumId'];
		if(isset($sessionData[$key]) && $sessionData[$key]==$data['albumId']){
			$data['loginRequired']=false;
		}
		//user auth end	
		 * 
		 */
					
		$this->load->view("livestream",$data); //View file name
		
	}
		
}
