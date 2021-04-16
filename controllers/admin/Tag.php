<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
	}
	
	public function index()
	{
		redirect("admin/dashboard");
	}
	public function add(){
	$newtag = $_POST['tag'];
	echo $newtag;
	}
}