<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blogs_model extends CI_Model{
	
	var $table = 'tblblogs';
	
	function updateNews(){
		
		$metavariable = $this->query_model->getbyTable('tblmetavariable');
		//echo '<pre>'; print_r($metavariable); die;
		$image = $_FILES['userfile']['name'];
		$news_id = $this->input->post('news_id');
		$title = trim ($this->input->post('title'));
		$date =  !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d");;
		$published = $this->input->post('published');
		$content = $this->input->post('text');
		$image_alt = $this->input->post('image_alt');
		$meta_desc = $this->input->post('meta_desc');
		if(!empty($meta_desc)){
			$meta_desc = substr($meta_desc, 0, 150);
		}
		$content = $this->input->post('content');
		$meta_title = $this->input->post('meta_title');
		$short_desc = strip_tags($content, '<h1></h1><p></p>');
		
		//echo strip_tags($content); die;
		if(isset($_POST['meta_title']) && !empty($_POST['meta_title'])){
			$meta_title = $this->input->post('meta_title');
			//$replce_slug = preg_replace("/[^A-Za-z0-9\- ]/", "", $this->input->post('meta_title'));
			//$meta_title = str_replace(' ', '-',strtolower($replce_slug));
		} else{
			$meta_title = $title.' | '.$metavariable[0]->meta_school_name.' | '.$metavariable[0]->meta_city.', '.$metavariable[0]->meta_state;
		}
		
			$meta_title = str_replace("′","'",$meta_title);
		//echo '<pre>'; print_r($_POST); die;
		$meta_keyword = $this->input->post('meta_keyword');
		
		$slug = $this->input->post('slug');		
		//echo $slug; die;
		$publish_date = isset($_POST['publish_date']) ? $_POST['publish_date'] : '';	
		
		if(empty($publish_date)){
			$publish_date = date('Y-m-d');
		}
		
		//echo $_POST['publish_date'].' ==>'.$_POST['date']; die;
		/**if($_POST['publish_date'] >= $_POST['date']){
			$date = $this->input->post('publish_date');
		} **/
		
		//echo $date; die;
		$slug = slugify($slug);
		
		
		if(empty($slug)){
			//$slug = slugify($title);
			$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "", $title);
			$slug = str_replace(' ', '-',strtolower($replce_slug));
			$slug = str_replace('--', '-',strtolower($slug));
		}
		
		
		$news = $this->getNewsById($news_id);
		
		if($slug != $news[0]->slug){
			$slug = $this->get_unique_slug($slug, $news_id);
		}
		
		$content = htmlentities($content);	
		$publish_type = !empty($_POST['publish_type']) ? $_POST['publish_type'] : 'publish_now';
		if($publish_type == "publish_now"){	
		$publish_date = date("Y-m-d");		
		$date = date("Y-m-d");	
		}
		
		$blog_timestamp = $date.' '.date('H:i:s');
		
		
		$hide_from_public_blog = isset($_POST['hide_from_public_blog']) ? $_POST['hide_from_public_blog'] : 0;
		$body_id = isset($_POST['body_id']) ? $_POST['body_id'] : '';
		
		
		
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/blogs/";
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
					'meta_title' => $meta_title,
					'meta_keyword' => $meta_keyword,
					'short_desc' => $short_desc,					
					'publish_type' => $publish_type,
					'blog_timestamp' => $blog_timestamp,
					'hide_from_public_blog'=>$hide_from_public_blog,
					'body_id' =>$body_id,
				);
				if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
					redirect("admin/blogs");
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
					'meta_title' => $meta_title,
					'meta_keyword' => $meta_keyword,
					'short_desc' => $short_desc,		
					'publish_type' => $publish_type,
					'blog_timestamp' => $blog_timestamp,
					'hide_from_public_blog'=>$hide_from_public_blog,
					'body_id' =>$body_id,
			);
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
				redirect("admin/blogs");
			endif;
		}

	}
	
	function addNews(){
		//echo '<pre>'; print_r($_POST); die;
		$metavariable = $this->query_model->getbyTable('tblmetavariable');
		
		$image = $_FILES['userfile']['name'];
		
		$title = trim ($this->input->post('title'));
		$date = !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d");
		$published = $this->input->post('published');
		$content = $this->input->post('text');
		$publish_date = isset($_POST['publish_date']) ? $_POST['publish_date'] : '';
		if(empty($publish_date)){
			$publish_date = date('Y-m-d');
		}
		
		
		
		$image_alt = $this->input->post('image_alt');
		$content = $this->input->post('content');
		$meta_desc = $this->input->post('meta_desc');
		if(!empty($meta_desc)){
			$meta_desc = substr($meta_desc, 0, 150);
		}
		$meta_title = $this->input->post('meta_title');
		$short_desc = strip_tags($content, '<h1></h1><p></p>');
		
		if(isset($_POST['meta_title']) && !empty($_POST['meta_title'])){
			$meta_title = $_POST['meta_title'];
		} else{
			$meta_title = $title.' | '.$metavariable[0]->meta_school_name.' | '.$metavariable[0]->meta_city.', '.$metavariable[0]->meta_state;
		}
			$meta_title = str_replace("′","'",$meta_title);
		//echo '<pre>'; print_r($meta_title); die;
		/**if($_POST['publish_date'] >= $_POST['date']){
			$date = $this->input->post('publish_date');
		} **/
		
		$meta_keyword = $this->input->post('meta_keyword');
		
		$slug = !empty($_POST['slug']) ? $_POST['slug'] : $title;
		$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "", $slug);
		$slug = str_replace(' ', '-',strtolower($replce_slug));
		$slug = str_replace('--', '-',strtolower($slug));
		//$slug = slugify($title);
		
		$slug = $this->get_unique_slug($slug);
		//echo $slug; die;
		$pos = 0;

		$content = htmlentities($content);
				$publish_type = !empty($_POST['publish_type']) ? $_POST['publish_type'] : 'publish_now';		if($publish_type == "publish_now"){			$publish_date = date("Y-m-d");			$date = date("Y-m-d");		}
				
				
		$blog_timestamp = $date.' '.date('H:i:s');
		
		$hide_from_public_blog = isset($_POST['hide_from_public_blog']) ? $_POST['hide_from_public_blog'] : 0;
		$body_id = isset($_POST['body_id']) ? $_POST['body_id'] : '';
		
		
		if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/blogs/";
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
					'meta_title' => $meta_title,
					'meta_keyword' => $meta_keyword,
					'short_desc'=>$short_desc,				
					'publish_type' => $publish_type,
					'blog_timestamp' => $blog_timestamp,
					'hide_from_public_blog'=>$hide_from_public_blog,
					'body_id' =>$body_id,
				);
				
				if($this->query_model->insertData($this->table,$data)):
					redirect("admin/blogs");
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
					'meta_title' => $meta_title,
					'meta_keyword' => $meta_keyword,
					'short_desc'=>$short_desc,		
					'publish_type' => $publish_type,
					'blog_timestamp' => $blog_timestamp,
					'hide_from_public_blog'=>$hide_from_public_blog,
					'body_id' =>$body_id,
			);
			if($this->query_model->insertData($this->table,$data)):
				redirect("admin/blogs");
			endif;
		}	
		
	}
	
	
	function getNewsById($id){
		return $this->query_model->getbyId($this->table, $id);
	}
	
	function get_unique_slug($slug, $id=''){
		
		$this->load->helper('string');
		
		$query = $this->db->get_where('tblblogs', array('slug' => $slug));
		
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