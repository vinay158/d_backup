<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pwa_settings extends CI_Controller {
	
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
			$data['title'] = 'PWA Setting';
			$data['link_type'] = 'pwa_settings';
			
			$this->db->select(array('title'));
			$data['site_setting'] = $this->query_model->getbyTable('tblsite');
			
			$data['detail'] =  $this->query_model->getbySpecific('tbl_pwa_settings', 'id', 1);
			
				if(!empty($data['detail'])){
					$data['detail'] = $data['detail'][0];
				} else{
					$data['detail'] = array();
				}
			
			
			
			if(isset($_POST['update'])){
				
				if(!empty($data['detail'])){
					$updateData['type']  = isset($_POST['type'])?$_POST['type']:0;
					$updateData['name']  = isset($_POST['name'])?$_POST['name']:'';
					$updateData['short_name']  = isset($_POST['short_name'])?$_POST['short_name']:'';
					$updateData['background_color']  = isset($_POST['background_color'])?$_POST['background_color']:'';
					$updateData['theme_color']  = isset($_POST['theme_color'])?$_POST['theme_color']:'';
					//$updateData['created'] = time();
					
					if($updateData['type'] == 1){
						
						
						$iconsSizes = array('96x96','144x144','192x192','256x256','384x384','512x512');
						$icon_image_name = (isset($_POST['last-photo']) && !empty($_POST['last-photo'])) ? $_POST['last-photo'] : '';
						
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
							
								$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
								$image = $_FILES['userfile']['name'];	
								$this->load->model('upload_model');
								$path = "upload/pwa_icons/";
								$cat_data['icon_image'] = $image; 
								if($a = $this->upload_model->upload_image($path)){
									$b='';
									//image resize process start			
									$filename=basename($a);	
									
									$umask=umask(0);
									$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
									$dirpath.='/'.$path;			
									chmod($dirpath.$filename ,0777);
									umask($umask);        				
									$this->load->library('image_lib');
									$config=array();			
									$config['image_library'] = 'gd2';
									$config['source_image'] = $dirpath.$filename;						
									$config['create_thumb'] = TRUE;
									$config['maintain_ratio'] = TRUE;
									$image_config['new_image'] = $dirpath.$filename;
									$image_config['quality'] = "100%";
									
									// vinay 30/11
									
									$config['height'] =512;
									$config['width'] = 512;
									
									$this->load->library('image_lib', $config);			 			
									$this->image_lib->initialize($config);        
									
									if (!$this->image_lib->resize())
									{
										echo  $this->image_lib->display_errors();
										exit;		    
									}else{			
										$this->image_lib->clear();
										$filename=str_replace('.','_thumb.',$filename);
										$b=$path.$filename;
									}
									
									$original_image = $a;
									$img_name = str_replace('upload/pwa_icons/','',$a);
									$updateData['icon_image'] = $img_name;
									//echo $data['header_photo']; die;
									//$this->query_model->resize_and_crop($original_image, 'upload/pwa_icons/thumb/'.$img_name, 288, 254);
									
									$icon_image_name = 	$updateData['icon_image'];
									foreach($iconsSizes as $size){
										$img_size = explode('x',$size);
										
										//$this->query_model->resize_and_crop_png($original_image, 'upload/pwa_icons/'.$size.'/'.$img_name, $img_size[0], $img_size[1]);
										//$this->query_model->tinyImageCampressAndResize('upload/pwa_icons/'.$size.'/'.$updateData['icon_image']);
										
										$this->query_model->resize_and_crop_png($original_image, 'upload/pwa_icons/'.$size.'-'.$img_name, $img_size[0], $img_size[1]);
										$this->query_model->tinyImageCampressAndResize('upload/pwa_icons/'.$size.'-'.$updateData['icon_image']);
										
									}
									
									}
								}
						
						$icons = array();
						$i = 0;
						foreach($iconsSizes as $icon_size){
							$icons[$i]['src'] = '/upload/pwa_icons/'.$icon_size.'-'.$icon_image_name;
							$icons[$i]['sizes'] = $icon_size;
							$icons[$i]['type'] = 'image/png';
							$i++;
						}
						
						$json_object = file_get_contents('manifest.json');
						$json_data = json_decode($json_object, true);
						//echo '<pre>json_object'; print_r($json_data); die;
						$updated_json_data = array(
													'name'=>$updateData['name'],
													'short_name'=>$updateData['short_name'],
													'background_color'=>$updateData['background_color'],
													'theme_color'=>$updateData['theme_color'],
													'start_url' =>'/admin',
													'display'=>'standalone',
													'icons' => $icons
												);
												
										
						$json_object = json_encode($updated_json_data);
						file_put_contents('manifest.json', $json_object);
					}
					$this->query_model->update('tbl_pwa_settings', 1, $updateData);
				} else{
					$insertData['type']  = isset($_POST['type'])?$_POST['type']:0;
					$insertData['name']  = isset($_POST['name'])?$_POST['name']:'';
					$insertData['short_name']  = isset($_POST['short_name'])?$_POST['short_name']:'';
					$insertData['background_color']  = isset($_POST['background_color'])?$_POST['background_color']:'';
					$insertData['theme_color']  = isset($_POST['theme_color'])?$_POST['theme_color']:'';
					//$insertData['created'] = time();
					$this->query_model->insertData('tbl_pwa_settings',$insertData);
				}
				
				redirect('admin/pwa_settings');
			}
			
			
			$this->load->view("admin/pwa_setting", $data);
			
		}else{
			redirect('admin/login');
		}
	}
	
	
}
