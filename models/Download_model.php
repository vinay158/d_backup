<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download_model extends CI_Model{
	
	var $table = 'tbldownloads';
	
	function addDownload(){
	//echo '<pre>POST'; print_r($_FILES); die;
						$data['name'] = $this->input->post('name'); 
						$data['desc'] = $this->input->post('desc');
						$data['category'] = $this->input->post('category');
						if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
							$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/downloads/';
						$config['allowed_types'] = 'gif|jpg|png';
			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('userfile')){
							$image_data = $this->upload->data();
							$data['photo'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/downloads/'.$data['photo'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/downloads/thumb/'.$data['photo'];
						
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
					
					
					/*if(isset($_FILES['files']['name']) && !empty($_FILES['files']['name'])){
						$_FILES['files']['name'] = time().$_FILES['files']['name'];
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/downloads/';
$config['allowed_types'] = 'exe|psd|pdf|xls|ppt|php|php4|php3|js|swf|Xhtml|zip|mid|midi|mp2|mp3|wav|bmp|gif|jpg|jpeg|png|html|htm|txt|rtf|mpeg|mpg|avi|doc|docx|xlsx';			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('files')){
							$image_data = $this->upload->data();
							$data['files'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/downloads/'.$data['files'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/downloads/thumb/'.$data['files'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
												
					} */
					
					if(isset($_FILES['files']['name']) && !empty($_FILES['files']['name'])){
						$_FILES['files']['name'] = time().$_FILES['files']['name'];
						$ext = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);
						$allowedExt = array('pdf','xls','ppt','swf','zip','mid','midi','mp2','mp3','wav','bmp','gif','jpg','jpeg','png','txt','rtf','mpeg','mpg','avi','doc','docx','xlsx','pptx','csv');
						if(in_array($ext, $allowedExt)){
							if(is_uploaded_file($_FILES['files']['tmp_name'])) {
								$sourcePath = $_FILES['files']['tmp_name'];
								$targetPath = "upload/downloads/".$_FILES['files']['name'];
								
								if(move_uploaded_file($sourcePath,$targetPath)) {
									$data['files'] = $_FILES['files']['name'];
								}
							}
						}
						
					}
					
					$this->query_model->insertData('tbldownloads', $data);
					
				redirect("admin/downloads/".$_POST['redirect']);
					
				
	
	}
	
	function updateDownload(){
			
			
			$data['name'] = $this->input->post('name'); 
			$data['desc'] = $this->input->post('desc');
			$data['category'] = $this->input->post('category');
		//	echo '<pre>'; print_r($_POST); die;
				if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){
					$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/downloads/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('userfile')){
					$image_data = $this->upload->data();
					$data['photo'] = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/downloads/'.$data['photo'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/downloads/thumb/'.$data['photo'];
				
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
			
			
			
					/*if(isset($_FILES['files']['name']) && !empty($_FILES['files']['name'])){
						$_FILES['files']['name'] = time().$_FILES['files']['name'];
						$this->load->library('image_lib');
			
						$config['upload_path'] = 'upload/downloads/';
$config['allowed_types'] = 'exe|psd|pdf|xls|ppt|php|php4|php3|js|swf|Xhtml|zip|mid|midi|mp2|mp3|wav|bmp|gif|jpg|jpeg|png|html|htm|txt|rtf|mpeg|mpg|avi|doc|docx|xlsx';			
						$this->load->library('upload', $config);
			
						if ( $this->upload->do_upload('files')){
							$image_data = $this->upload->data();
							$data['files'] = $image_data['file_name'];
						}
			
						$resize_config['source_image'] = 'upload/downloads/'.$data['files'];
						$get_size = getimagesize($resize_config['source_image']);
			
						$image_info = array(
							'width' => $get_size[0],
							'height' => $get_size[1]
						);
			
						$resize_config['create_thumb'] = FALSE;
			
						$resize_config['new_image'] = 'upload/downloads/thumb/'.$data['files'];
						
						//echo '<pre>'; print_r($image_info); echo '</pre>';
					
			
						if($image_info['width']  >= 250){				
							$new_width = 250;
							$new_height = round((250/$image_info['width'])*$image_info['height']);				
							
							$resize_config['width'] = $new_width;
							$resize_config['height'] = $new_height;
							$this->image_lib->initialize($resize_config);
							$this->image_lib->resize();	
						}
												
					} */
					
					if(isset($_FILES['files']['name']) && !empty($_FILES['files']['name'])){
						$_FILES['files']['name'] = time().$_FILES['files']['name'];
						$ext = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);
						$allowedExt = array('pdf','xls','ppt','swf','zip','mid','midi','mp2','mp3','wav','bmp','gif','jpg','jpeg','png','txt','rtf','mpeg','mpg','avi','doc','docx','xlsx','pptx','csv');
						if(in_array($ext, $allowedExt)){
							if(is_uploaded_file($_FILES['files']['tmp_name'])) {
								$sourcePath = $_FILES['files']['tmp_name'];
								$targetPath = "upload/downloads/".$_FILES['files']['name'];
								
								if(move_uploaded_file($sourcePath,$targetPath)) {
									$data['files'] = $_FILES['files']['name'];
								}
							}
						}
						
					}
					
					
			$this->query_model->update('tbldownloads', $this->input->post('id'), $data);
			
				redirect("admin/downloads/".$this->input->post('redirect'));
		
	}
	
}