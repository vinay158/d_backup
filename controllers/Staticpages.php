<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Staticpages extends CI_Controller {
	function __construct(){
		
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('url');	
		
		$this->load->database();
			
	}


	public function index($slug = "")

	{
		
		$slug = $this->uri->segment(1);
		//echo $slug; die;
		if(!empty($slug)){
			$this->db->where('is_display',1);
			$data['pageDetail'] = $this->query_model->getbySpecific('tbl_static_pages','slug',$slug);
				if(!empty($data['pageDetail'])){
					$this->load->view('static_page_detail', $data);
				}else{
					redirect('/','location',301);
				}
		}else{
			redirect('/','location',301);
		}
	
	}

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */