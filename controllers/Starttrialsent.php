<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Starttrialsent extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('trial_model');
	}
	
	public function index()
	{
		$this->load->library("email");		
		//$this->trial_model->_test_email();
		$this->trial_model->handlePaypalResponse();
		$this->load->view("start-trial-sent");
	}
		
}