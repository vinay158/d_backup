<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meta extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }		
	}
	public function index()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
		
		
			$data['meta']=$this->db->query("select * from `tblmeta` order by pos ASC" )->result();
			//$data['meta'] = $this->query_model->getbyTable("tblmeta");	
			$data['title'] = "Meta Tags/URL Rewriting";
			$data['link_type'] = "meta";
			$this->db->where("published", 1);
			$this->db->select(array('id'));
			$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
			//echo '<pre>data'; print_r($data); die;
			$query = $this->db->get_where('tblmetavariable', array('id' => 1));
			if($query->num_rows() > 0){
				$result = $query->result();
				$data['meta_data'] = $result[0];
			
			}else{
				$data['meta_data'] = array();
			}			
			
			$this->load->view("admin/meta_index", $data);
		}else{
			redirect("admin/login");
		}
	}

	public function add(){
	$is_logged_in = $this->session->userdata('is_logged_in');
	if(!empty($is_logged_in) && $is_logged_in == true)
	{
	$data['title'] = "Meta Tags/URL Rewriting";
	$data['link_type'] = "meta";
	if(isset($_POST['update'])):
		$title = rtrim(ltrim($_POST['title']));
		$desc = $_POST['desc'];
		//$keywords = $_POST['keywords'];
		$url = $_POST['url'];
		$page = $_POST['page'];
		
		$slug='';		
		if(!empty($url)){
			$slug =$url;		
			//$slug=substr($url,strlen($this->config->item('base_url'))+1);
		}
		$data = array("title" => $title, "desc" => $desc, "url" => $url, "page" => $page , "slug" => $slug, "display_status"=> !empty($display) ? $display : 'H'  );
		$this->query_model->insertData("tblmeta", $data);
		redirect("admin/meta");
		endif;
	$this->load->view("admin/meta_add", $data);
	
	}else{
	redirect("admin/login");
	}
	}

	public function edit(){
	$is_logged_in = $this->session->userdata('is_logged_in');
	if(!empty($is_logged_in) && $is_logged_in == true)
	{
	if($this->uri->segment(4) != NULL) :
		$data['title'] = "Meta Tags/URL Rewriting";
		$data['link_type'] = "meta";
		$data['meta'] = $this->query_model->getbyId("tblmeta", $this->uri->segment(4));

		if(isset($_POST['update'])):
		
				$title = rtrim(ltrim($_POST['title']));
				$desc = $_POST['desc'];
				//$keywords = $_POST['keywords'];
				//$url = $_POST['url'];				
				//$page = $_POST['page'];
				//$slug='';
				
				// Vinay
				/*if(!isset($_POST['display'])){
					$_POST['display'] = 'H';
				}
		
				//$display = $_POST['display'];
				$display = 'D';
				
				if(!empty($url)){
					$slug =$url;		
					//$slug=substr($url,strlen($this->config->item('base_url'))+1);
				}*/
				
				//$data = array("title" => $title, "desc" => $desc, "url" => $url, "page" => $page, "slug" => $slug, "display_status"=> !empty($display) ? $display : 'H' );
				$data = array("title" => $title, "desc" => $desc);
					$this->query_model->update("tblmeta", $this->uri->segment(4), $data);
					redirect("admin/meta");
				endif;		
		
		$this->load->view("admin/meta_edit", $data );	
	else:
	redirect("admin/meta");
	endif;
	}else{
	redirect("admin/login");
	}
	}

	public function deleteitem(){
	$id = $_POST['delete-item-id'];
	$this->db->where("id", $id);
	if($this->db->delete("tblmeta"))
	{
	redirect("admin/meta");
	}
	else
	{
	echo "<script language='javascript'>alert('Unable to delete');</script>";
	redirect($this->index());
	}
	}
	public function sortthis(){
	
		$menu = $_POST['menu'];
		for ($i = 0; $i < count($menu); $i++) {
		$this->db->query("UPDATE `tblmeta` SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'") or die(mysqli_error($this->db->conn_id));
		}
	}
	
	function updateMetaVariable(){
		
		$school_name 	= $this->input->post('meta_school_name');
		$city 			= $this->input->post('meta_city');
		$state 			= $this->input->post('meta_state');
		$city_state 			= $this->input->post('meta_city_state');
		$nearbylocation1 = $this->input->post('meta_nearbylocation1');
		$nearbylocation2 = $this->input->post('meta_nearbylocation2');
		$county 		= $this->input->post('meta_county');
		$main_martial_arts_style = $this->input->post('meta_main_martial_arts_style');
		$martial_arts_style = $this->input->post('meta_martial_arts_style');
		$trial_offer1 = $this->input->post('trial_offer1');
		$trial_offer2 = $this->input->post('trial_offer2');
		$display = $this->input->post('display');
		$main_instructor = $this->input->post('main_instructor');
		$est_year = $this->input->post('est_year');
		$current_location = $this->input->post('current_location');
		
		$url = $this->input->post('url');
		$street = $this->input->post('street');
		$suite = $this->input->post('suite');
		$zip = $this->input->post('zip');
		$phone = $this->input->post('phone');
		$school_owner_name = $this->input->post('meta_school_owner_name');
		
		
		
		
		$data = array("meta_school_name" => $school_name, "meta_city" => $city, "meta_state" => $state, "meta_city_state" => $city_state, "meta_nearbylocation1" => $nearbylocation1, "meta_nearbylocation2" => $nearbylocation2 , "meta_county" => $county, "meta_main_martial_arts_style" => $main_martial_arts_style, "meta_martial_arts_style" => $martial_arts_style, "display_status"=> !empty($display) ? $display : 'H', "trial_offer1" => $trial_offer1, "trial_offer2" => $trial_offer2,'main_instructor' => $main_instructor,'est_year'=> $est_year,'current_location'=> $current_location,'url' => $url,'street' => $street,'suite' => $suite,'zip' => $zip,'phone' => $phone,'meta_school_owner_name' => $school_owner_name);
							
							
		$meta_data = $this->query_model->getbyId("tblmetavariable", 1);
		//echo '<pre>'; print_r($meta_data); echo '</pre>';
							
		if(empty($meta_data)){
			//echo 'add';		
			$this->query_model->insertData("tblmetavariable", $data);			
		
		}else{
			//echo 'update';
			$this->query_model->update("tblmetavariable", 1, $data);
		}
		redirect("admin/meta");		
		exit;
		
	}
}