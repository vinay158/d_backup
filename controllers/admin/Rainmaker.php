<?php 
//require 'vendor/autoload.php';
//require 'vendor/Mailchimp.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rainmaker extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		//$this->load->model("customcss_model");
		
	}
	
	public function index(){
		
	//	redirect('admin/dashboard');
		
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');
	
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "Rainmaker";
			$data['multi_location'] =  $this->query_model->getbyTable('tblconfigcalendar');
			//echo '<pre>'; print_r($data['multi_location']); die;
			$data['detail'] =  $this->query_model->getbySpecific('tblrainmaker', 'id', 1);
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
		

		//// RAINMAKER API GET DATA
		
/*
RainMaker Software Process Web Lead PHP Sample Script
Created By Ron Sell
Version 1.1
3/19/2014
*/

/* Assign the variables below with the fields from web form */
/*$RM_SID = "1291";
$RM_APIKEY = "Pu-ca7dd31cbfd646608d037b74cfa82d94";
$RM_ACTION = "addWebLead";
$RM_FNAME = "Shirley";
$RM_LNAME = "Smith";
$RM_EMAIL = "Shirley@mailservice.com";
$RM_PHONE = "9999999999";
$RM_MOBILE = "9999999999";

$RM_URL = "https://addmembers.com/RainMaker/api/?";
$postURL = $RM_URL . "action=" . $RM_ACTION . "&SID=" . $RM_SID . "&apikey=" . $RM_APIKEY . "&fname=" . $RM_FNAME;
$postURL .= "&lname=" . $RM_LNAME . "&email=" . $RM_EMAIL . "&phone=" . $RM_PHONE . "&mobile=" . $RM_MOBILE;
//echo $postURL; die;
$returned_content = $this->get_rainmark_data($postURL);*/
//echo '<pre>'; print_r($returned_content); die;

	$this->load->view("admin/rainmaker_index", $data);
		
		if(isset($_POST['update'])){
			
			if(!empty($data['detail'])){
				$updateData['type']  = isset($_POST['type'])?$_POST['type']:'';
				$updateData['s_id']  = isset($_POST['s_id'])?$_POST['s_id']:'';
				$updateData['api_key']  = isset($_POST['api_key'])?$_POST['api_key']:'';
				$updateData['multi_rainmaker_check']  = isset($_POST['multi_rainmaker_check'])?$_POST['multi_rainmaker_check']:'';
				$updateData['created'] = time();
				
				$this->query_model->update('tblrainmaker', 1, $updateData);
			} else{
				$insertData['type']  = isset($_POST['type'])?$_POST['type']:'';
				$insertData['s_id']  = isset($_POST['s_id'])?$_POST['s_id']:'';
				$insertData['api_key']  = isset($_POST['api_key'])?$_POST['api_key']:'';
				$insertData['multi_rainmaker_check']  = isset($_POST['multi_rainmaker_check'])?$_POST['multi_rainmaker_check']:'';
				$insertData['created'] = time();
				$this->query_model->insertData('tblrainmaker',$insertData);
			}
		redirect('admin/rainmaker');
		}
		
			
			
			
		}else{
			redirect('admin/login');
		}
	}
	

public function get_rainmark_data($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
}

	
}