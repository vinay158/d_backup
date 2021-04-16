<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model{
	
	var $table = 'tblnews';
	
	function updateNews(){
		
		$image = $_FILES['userfile']['name'];
		$news_id = $this->input->post('news_id');
		$title = trim ($this->input->post('title'));
		$date = !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d");
		$published = $this->input->post('published');
		$content = $this->input->post('text');
		$image_alt = '';//$this->input->post('image_alt');
		$meta_desc = '';//$this->input->post('meta_desc');
		$meta_desc = '';//substr($meta_desc, 0, 150);
		$content = $this->input->post('content');
		$short_desc = strip_tags($content, '<h1></h1><p></p>');
		
		//$slug = $this->input->post('title');		
		$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$title);
		$slug = str_replace(' ', '-',strtolower($replce_slug));
		$slug = str_replace('--', '-',strtolower($slug));
		//echo $slug; die;
		
		$publish_date = $this->input->post('publish_date');	

		if(empty($publish_date)){
			$publish_date = date('Y-m-d');
		}		
		
		$slug = slugify($slug);
		
		if(empty($slug)){
			$slug = slugify($title);
		}
		
		$news = $this->getNewsById($news_id);
		
		if($slug != $news[0]->slug){
			$slug = $this->get_unique_slug($slug, $news_id);
		}
		//echo $slug; die;
		$content = htmlentities($content);
		
		
		$publish_type = !empty($_POST['publish_type']) ? $_POST['publish_type'] : 'publish_now';
		if($publish_type == "publish_now"){
			$publish_date = date("Y-m-d");
			$date = date("Y-m-d");
		}
		
		
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/";
			if($a = $this->upload_model->upload_image($path)){
				$data = array(
					'title' => $title,
					'timestamp' => $date,
					'image' => $a,
					'content' => $content,
					'published' => $published,
					'publish_date' => $publish_date,
					'slug' => $slug,
					'content' => $content,
					'image_alt' => $image_alt,
					'meta_desc' => $meta_desc,
					'short_desc'=>$short_desc,
					'publish_type' => $publish_type
				);
				if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
					redirect("admin/news");
				endif;
			}else{
				$error = strip_tags($this->upload->display_errors());
				echo '<script>alert("'.$error.'");</script>';
			}
		}
		else {
			$data = array(
				'title' => $title,
				'timestamp' => $date,
				'content' => $content,
				'published' => $published,
				'publish_date' => $publish_date,
				'slug' => $slug,
				'content' => $content,
				'image_alt' => $image_alt,
				'meta_desc' => $meta_desc,
				'short_desc'=>$short_desc,
				'publish_type' => $publish_type
			);
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
				redirect("admin/news");
			endif;
		}

	}
	
	function addNews(){
		
		$image = $_FILES['userfile']['name'];
		
		$title = trim ($this->input->post('title'));
		$date = !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d");
		$published = $this->input->post('published');
		$content = $this->input->post('text');
		$publish_date = $this->input->post('publish_date');
		$image_alt = '';//$this->input->post('image_alt');
		$content = $this->input->post('content');
		$meta_desc = '';//$this->input->post('meta_desc');
		$meta_desc = '';//substr($meta_desc, 0, 150);
		$short_desc = strip_tags($content, '<h1></h1><p></p>');
		//$slug = slugify($title);
		$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$title);
		$slug = str_replace(' ', '-',strtolower($replce_slug));
		$slug = str_replace('--', '-',strtolower($slug));
		//echo $slug; die;
		
		if(empty($publish_date)){
			$publish_date = date('Y-m-d');
		}
		
		$slug = $this->get_unique_slug($slug);
		
		$pos = 0;

		$content = htmlentities($content);
		
		$publish_type = !empty($_POST['publish_type']) ? $_POST['publish_type'] : 'publish_now';
		if($publish_type == "publish_now"){
			$publish_date = date("Y-m-d");
			$date = date("Y-m-d");
		}
		
		//echo '<pre>publish_date'; print_r($publish_date); die;
		
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/";
			if($a = $this->upload_model->upload_image($path)){
				$data = array(
					'title' => $title,
					'timestamp' => $date,
					'image' => $a,
					'content' => $content,
					'published' => $published,
					'pos' => $pos,
					'publish_date' => $publish_date,
					'slug' => $slug,
					'content' => $content,
					'image_alt' => $image_alt,
					'meta_desc' => $meta_desc,
					'short_desc'=>$short_desc,
					'publish_type' => $publish_type
				);
				if($this->query_model->insertData($this->table,$data)):
					redirect("admin/news");
				endif;
			}else{
				$error = strip_tags($this->upload->display_errors());
				echo '<script>alert("'.$error.'");</script>';		
			}
		}else{
			$data = array(
					'title' => $title,
					'timestamp' => $date,
					'content' => $content,
					'published' => $published,
					'pos' => $pos,
					'publish_date' => $publish_date,
					'slug' => $slug,
					'content' => $content,
					'image_alt' => $image_alt,
					'meta_desc' => $meta_desc,
					'short_desc'=>$short_desc,
					'publish_type' => $publish_type
			);
			if($this->query_model->insertData($this->table,$data)):
				redirect("admin/news");
			endif;
		}	
		
	}
	
	
	function getNewsById($id){
		return $this->query_model->getbyId($this->table, $id);
	}
	
	function get_unique_slug($slug, $id=''){
		
		$this->load->helper('string');
		
		$query = $this->db->get_where('tblnews', array('slug' => $slug));
		
		if($query->num_rows() > 0){			
			$row = $query->row_object();
			if($id)
				$slug = $slug.'-'.$id;
			else{
				$rand = random_string('numeric', 3);
				$slug = $slug.'-'.$rand;					
			}
			return $slug;
		}else{
			return $slug;
		}		
	}	
}