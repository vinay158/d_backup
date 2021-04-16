<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Pages extends CI_Controller {
	function __construct(){
		
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('url');	
		
		$this->load->database();
			
	}


	public function index($page = 1)

	{
		
		
	
	}

	
public function viewblog(){
	
	
		//echo 'hello'; die;
			$data['blogs_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 48);
			$data['blogs_slug'] = $data['blogs_slug'][0];

			if( $this->uri->segment(2) == 'index' && empty($this->uri->segment(3)) ){
				redirect('/','location',301);
			}
			if($this->uri->segment(2) == 'index' && !is_numeric($this->uri->segment(3)) ){
				redirect('/','location',301);
			}
			
			
		$data['pages_slug'] = $this->query_model->getbySpecific('tblmeta', 'id', 52);
		$data['pages_slug'] = $data['pages_slug'][0];	
				
				if($this->uri->segment(2) == 'index'){
					
					$data['page_title'] = 'Blog';
					
					$this->db->where('published', 1);
					$this->db->where('timestamp <=', date('Y-m-d'));
					$this->db->order_by('blog_timestamp', 'desc');
					$totalResults = $this->query_model->getbyTable('tblblogs');
					$totalResults = count($totalResults);
		
		$config = array();
		
		$config['base_url']= base_url().$data['blogs_slug']->slug.'/index'; 
		
		//$config['total_rows'] = $this->pagination_model->record_count('tblblogs');
		$config['total_rows']=$totalResults;
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = 2;
		$config['uri_segment'] = 3;
		
		$config['next_link'] = '<i class="fa fa-angle-double-left"></i>Older Post';
		$config['prev_link'] = 'Newer Post<i class="fa fa-angle-double-right"></i>';
		
		
		$config['num_links']=4;
		$config['num_tag_open'] = '<div class="hidden">';
		$config['num_tag_close'] = '</div>';
		$page = $this->uri->segment(3);
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		//echo $offset; die;
		$this->db->where('published', 1);
		$this->db->where('timestamp <=', date('Y-m-d'));
		$this->db->order_by('blog_timestamp', 'desc');
		$data['blogs'] = $this->pagination_model->fetch_data('tblblogs',$config["per_page"], $offset, $config['total_rows']);
		//$config['total_rows']=$this->pagination_model->record_count('tblblogs');
		$config['total_rows']=$totalResults;
		$this->pagination->initialize($config);
		$data['paginglinks'] = $this->pagination->create_links();
			
		//echo '<pre>'; print_r($this->pagination->create_links()); die;	
		
		$this->db->where('hide_from_public_blog', 0);
		$this->db->where('timestamp <=', date('Y-m-d'));
		$this->db->where('published', 1);
		$this->db->order_by('blog_timestamp', 'desc');
		$this->db->limit(5);
		$data['recents_blogs'] = $this->query_model->getbyTable('tblblogs');
		
		
		$this->db->where("published", 1);
		$this->db->order_by("pos","asc");
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		$data['site_settings'] = $this->query_model->getbyTable("tblsite");
		$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
		
		
		$this->load->view('blogs', $data);
				}else{
					
				$data['blog_detail'] = $this->query_model->getbySpecific('tblblogs','slug', $this->uri->segment(2));
				//echo '<pre>'; print_r($data['blog_detail']); die;
				if(empty($data['blog_detail'])){
					redirect('/','location',301);
				}
				
				$this->db->where('hide_from_public_blog', 0);
				$this->db->where('timestamp <=', date('Y-m-d'));
				//$this->db->where('id <', $data['blog_detail'][0]->id);
				//$this->db->order_by("id","desc");
				$this->db->order_by("blog_timestamp","asc");
				$this->db->limit(1);
				$data['previos_blog'] = $this->query_model->getbyTable("tblblogs");
				
				
				$this->db->where('timestamp <=', date('Y-m-d'));
				$this->db->where('hide_from_public_blog', 0);
				//$this->db->where('id >', $data['blog_detail'][0]->id);
				//$this->db->order_by("id","asc");
				$this->db->order_by("blog_timestamp","desc");
				$this->db->limit(1);
				$data['next_blog'] = $this->query_model->getbyTable("tblblogs");
				//echo '<pre>old'; print_r($data['previos_blog']); 
				//echo '<pre>new'; print_r($data['next_blog']); die;
				
				$this->db->where('hide_from_public_blog', 0);
				$this->db->where('timestamp <=', date('Y-m-d'));
				$this->db->where('published', 1);
				$this->db->order_by('blog_timestamp', 'desc');
				$this->db->limit(5);
				$data['recents_blogs'] = $this->query_model->getbyTable('tblblogs');
				
				
				
				$this->db->where("published", 1);
				$this->db->order_by("pos","asc");
				$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
				$data['site_settings'] = $this->query_model->getbyTable("tblsite");
				
				$data['mainLocation'] = $this->query_model->getMainLocation("tblcontact");
				
				$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
				
				$this->load->view('blog_detail', $data);
				}
				
				
			
}
	

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */