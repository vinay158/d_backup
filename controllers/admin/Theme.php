<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Theme extends CI_Controller {
	
	function __construct(){		
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("setting_model");
	}
	
	public function index()
	{
	
	redirect('/admin/dashboard');
	
	$is_logged_in = $this->session->userdata('is_logged_in');
	
		if(!empty($is_logged_in) && $is_logged_in == true)
		{	$theme_url=$this->config->item('theme_url');
			//echo '<pre>'; print_r($theme_url); die;
			$data['title'] = "Theme";
			$data['link_type'] = "theme";
			$this->db->order_by("id", "ASC");
			
			$site_setting = $this->query_model->getbyTable("tblsite");
			if($this->uri->segment(1) != NULL)
			$this->db->where("page", $this->uri->segment(1));
			else
			$this->db->where("page", "home");
			
			if(!empty($site_setting)):
				foreach($site_setting as $setting):
					$site_id = $setting->id;
					$site_theme = $setting->theme;
					$status = $setting->theme_published;
				endforeach; 
			endif;
			$data['site_theme']=$site_theme;
			$data['site_id']=$site_id;
						
			//available themes

			$them_data= file_get_contents($this->config->item('theme_url'));

			$data['themes']=unserialize($them_data);			
			//$dir= FCPATH.'themes/';
			//exit;			
			//$data['themes_path']=$dir;
			//$data['themes_dir']=$this->read_dir($dir);
			//$data['themes']=$this->read_dir($dir);			
			usort($data['themes'] ,'strnatcasecmp');			
			 //echo '<pre>'; print_r($data['themes']); die;	
			$this->load->view('admin/theme_index', $data);	
		}else{
			redirect("admin/login");
		}
	}
	
	public function publish(){
	
	$id = $_POST['site_id'];
	$pub = $_POST['publish_type'];
	$theme = $_POST['theme_name'];
		
	$this->db->where("id", $id);
		if($this->db->update("tblsite", array("theme_published" => $pub , "theme"=>$theme)))
		{	
			echo 1;
			exit;
			
		}
	}
		
	function read_dir($dir, $array = array()){
        $dh = opendir($dir);
        $files = array();
        while (($file = readdir($dh)) !== false) {
            $flag = false;
            if($file !== 'global' && $file !== '.' && $file !== '..' && !in_array($file, $array)) {
                $files[] = $file;
            }
        }
        return $files;
    }
	
}
