<?php 
//require 'vendor/autoload.php';
//require 'vendor/Mailchimp.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailchimp extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		//$this->load->model("customcss_model");
		
	}
	
	public function index(){
		
	$data['user_level']=$this->session->userdata['user_level'];
	$is_logged_in = $this->session->userdata('is_logged_in');

	if(!empty($is_logged_in) && $is_logged_in == true){
		$data['title'] = "Mailchimp Css";
		
		
		
		
		$data['detail'] =  $this->query_model->getbySpecific('tblmailchimp', 'id', 1);
		
			if(!empty($data['detail'])){
				$data['detail'] = $data['detail'][0];
			} else{
				$data['detail'] = array();
			}
		
		$this->load->library('mailchimp_library');	
		$mailchimp  = new Mailchimp_library($data['detail']->api_key);
		$tamplete_lists_data = $this->getMailChampData('https://us9.api.mailchimp.com/3.0/lists?offset=0&count=100',$data['detail']->api_key,$data['detail']->email,$data['detail']->first_name);
		$listsArray = array();
			$i = 1;
			if(isset($tamplete_lists_data->lists)){
				foreach($tamplete_lists_data->lists as $template_list){
					$listsArray[$i]['id'] = $template_list->id;
					$listsArray[$i]['name'] = $template_list->name;
					
					$i++;
				}
			}
			
		$data['template_lists'] = $listsArray;
		$this->load->view("admin/mailchimp_index", $data);
		
		if(isset($_POST['update'])){
			
			if(!empty($data['detail'])){
				$updateData['type']  = $_POST['type'];
				$updateData['template_id']  = $_POST['template_id'];
				$updateData['api_key']  = $_POST['api_key'];
				$updateData['email']  = $_POST['email'];
				$updateData['first_name']  = $_POST['first_name'];
				$this->query_model->update('tblmailchimp', 1, $updateData);
			} else{
				$insertData['type']  = $_POST['type'];
				$insertData['template_id']  = $_POST['template_id'];
				$insertData['api_key']  = $_POST['api_key'];
				$insertData['email']  = $_POST['email'];
				$insertData['first_name']  = $_POST['first_name'];
				$this->query_model->insertData('tblmailchimp',$insertData);
			}
		redirect('admin/mailchimp');
		}
		
			
			
			
		}else{
			redirect('admin/login');
		}
	}
	
	
	
		
 function getMailChampData($url, $apikey, $email, $fname){
	
			
		//$apikey = '38416ee8dfba9d6ccf0f8359705cbb5c-us9';
		//$email = 'info@websitedojo.com';
        $auth = base64_encode( 'user:'.$apikey );

        $data = array(
            'apikey'        => $apikey,
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => array(
                'FNAME' => $fname
            )
        );
        $json_data = json_encode($data);
		//https://us9.api.mailchimp.com/3.0/campaigns?offset=0&count=10
		 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://us9.api.mailchimp.com/3.0/lists?offset=0&count=1000');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$auth));
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                                                                                  

        $result = curl_exec($ch);
	
		return json_decode($result);
	}
	
}