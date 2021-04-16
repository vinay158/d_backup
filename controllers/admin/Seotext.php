<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seotext extends CI_Controller {
	
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
		$data['title'] = "SEO text";
		$data['content'] = $this->query_model->getbyId("tblseo",1);
		//echo '<pre>'; print_r($data['content']); die;
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);
			
			if(isset($_POST['update'])){
				//print_r($_POST); die;
				$seo_text = $_POST['seo_text'];
				$datas = array("seo_text" => $seo_text);	// vinay 01/12
				$this->query_model->update('tblseo',1, $datas);
				redirect('admin/seotext');
			}
			$this->load->view("admin/seotext_index", $data);
		}else{
			redirect('admin/login');
		}
	}
	
	public function multilocation(){
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = "SEO text";
			
			$data['content'] = $this->query_model->getbySpecific("tblseo", 'location_id',$this->uri->segment(4));
			
			$data['location_id'] = $this->uri->segment(4);
			ini_set('display_errors', 'On');
			error_reporting(E_ALL);
				
			if($this->uri->segment(4) != ''){
				if(isset($_POST['update'])){
					if(!empty($data['content'])){
						$seo_text = $_POST['seo_text'];
						$location_id = $_POST['location_id'];
						$datas = array("seo_text" => $seo_text, 'location_id' => $_POST['location_id']);	// vinay 01/12
						$this->query_model->updateData('tblseo','location_id',$this->uri->segment(4), $datas);
						redirect('admin/seotext/multilocation/'.$_POST['location_id']);
					} else{
						$seo_text = $_POST['seo_text'];
						$location_id = $_POST['location_id'];
						$datas = array("seo_text" => $seo_text, 'location_id' => $_POST['location_id']);
						$this->query_model->insertData('tblseo', $datas);
						redirect('admin/seotext/multilocation/'.$_POST['location_id']);
					}
				}
				$this->load->view("admin/seotext_multi_index", $data);
			}
			}else{
				redirect('admin/login');
			}
	}
	
}