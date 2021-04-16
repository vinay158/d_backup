<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Themes_model extends CI_Model{
	
	var $table = 'tbldownloads';
	
	function addTheme(){
				
					$data['theme_name'] = $this->input->post('theme_name'); 
					
				if(isset($_FILES['files']['name']) && !empty($_FILES['files']['name'])){
				$_FILES['files']['name'] = $_FILES['files']['name'];

				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/themes/';
				$config['allowed_types'] = 'css';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('files')){
					$image_data = $this->upload->data();
					$data['files'] = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/themes/'.$data['files'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/themes/thumb/'.$data['files'];
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
										
			}
					
					$this->query_model->insertData('tblthemes', $data);
					
				redirect("admin/themes");
					
				
	
	}
	
	function updateTheme(){
			
			$data['theme_name'] = $this->input->post('theme_name'); 
			
			if(isset($_FILES['files']['name']) && !empty($_FILES['files']['name'])){
				$_FILES['files']['name'] = $_FILES['files']['name'];

				$old_files = $this->input->post('last_files');
				//$new_files = $_FILES['files']['name'];

				if ( !empty($old_files) ){
					unlink('upload/themes/'.$old_files);
				}

				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/themes/';
				$config['allowed_types'] = 'css';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('files')){
					$image_data = $this->upload->data();
					$data['files'] = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/themes/'.$data['files'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/themes/thumb/'.$data['files'];
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
										
			}
			$this->query_model->update('tblthemes', $this->input->post('id'), $data);
			
				redirect("admin/themes");
		
	}
	
}