<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* changelog v2 - addcalendar function modified - 15 June 2013 */

class Blog_model extends CI_Model{
	
	var $table = 'tblblog';
	
	function getallblog(){
		return $this->query_model->getbyTable($this->table);
	}
	function getBlogbyCat($id){
		return $this->query_model->getbySpecific($this->table, "category", $id);
	}
	function addfaq(){
		$title = $_POST['title'];

		$content = $_POST['ques'];		
		$ques = htmlentities($content);
				
		$content = $_POST['ans'];		
		$ans = htmlentities($content);
				
		$pub = $_POST['published'];
		$data = array("title" => $title, "ques" => $ques, "ans" => $ans, "published" => $pub, "category" => $this->uri->segment(4));
		if($this->query_model->insertData("tblfaq",$data)):
			if($_POST['redirect']){
				redirect("admin/faq/".$_POST['redirect']);
			}else{
				redirect("admin/faq");
			}	
		endif;
	}
	function updatefaq(){
		$title = $_POST['title'];

		$content = $_POST['ques'];		
		$ques = htmlentities($content);
				
		$content = $_POST['ans'];		
		$ans = htmlentities($content);		
		
		$pub = $_POST['published'];
		$data = array("title" => $title, "ques" => $ques, "ans" => $ans, "published" => $pub);
		if($this->query_model->update("tblfaq",$this->uri->segment(4),$data)):
			if($_POST['redirect']){
				redirect("admin/faq/".$_POST['redirect']);
			}else{
				redirect("admin/faq");
			}	
		endif;
	}
	
	function addcalendar(){
		
		$title = $this->input->post('title');
		$category = $this->input->post('blog_category_id');				
		$content = $this->input->post('text');		
		$counter = $this->input->post('counter');		
		$redirect = $this->input->post('redirect');		
		$content = htmlentities($content);
		$location_id= isset($_POST['location_id']) ? $_POST['location_id'] : '0';
		
		for($i=1; $i<=$counter; $i++){
			
			$date = $this->input->post('date'.$i);
			if(isset($date) && !empty($date)){
				
				$repeat = $this->input->post('repeat'.$i);
				$allday = $this->input->post('allday'.$i);
				$start_hr = $this->input->post('start_hr'.$i);
				$start_min = $this->input->post('start_min'.$i);
				$start_ampm = $this->input->post('start_ampm'.$i);
				$end_hr = $this->input->post('end_hr'.$i);
				$end_min = $this->input->post('end_min'.$i);
				$end_ampm = $this->input->post('end_ampm'.$i);
				$start_time = '';
				$end_time = '';
				
				//if(empty($allday) && $category != 52){	// closed day does not require start/end date
				if(empty($allday)){	// allow closed day 
					$start_time = $start_hr.':'.$start_min.' '.$start_ampm;
					$end_time = $end_hr.':'.$end_min.' '.$end_ampm;
				}else
					$allday = 1;
					
				// allow closed day
				// if($category == 52) $repeat = 'never';	// closed day never repeat
				
				$data[] = array("category" => $category, "location_id" => $location_id,"title" => $title, "mydate" => $date,  "isWhole" => $allday, "start" => $start_time, 
								"end" => $end_time, "repeat" => $repeat, "content" => $content);
			}
		}
		//echo '<pre>'; print_r($data); echo '</pre>';
		foreach($data as $q){
			pre($q);exit;
			$this->query_model->insertData("tblcalendar", $q);
		}
		
		if($_POST['redirect']){
			redirect("admin/calendar/".$_POST['redirect']);
		}else{
			redirect("admin/calendar");
		}		
	}
	
	function addcalendar_v2(){
		$post = $this->input->post();
		$post['allday'] = !empty($post['allday']) ? $post['allday'] : '';
		// pre($post);
		// exit;
		
		$count_if_2_consec_empty = 0;
		foreach($post['date1'] as $k => $v){
			if(!empty($v)){
				
				$start_time = '';
				$end_time = '';
				if(empty($allday)){	// allow closed day 
					$start_time = $post['start_hr1'][$k].':'.$post['start_min1'][$k].' '.$post['start_ampm1'][$k];
					$end_time = $post['end_hr1'][$k].':'.$post['end_min1'][$k].' '.$post['end_ampm1'][$k];
				}else{
					$allday = 1;
				}
				
				$params["category"]		= $post['blog_category_id'];
				$params["location_id"]	= (array_key_exists('location_id',$post))?$post['location_id']:0;
				$params["title"]		= $post['title'];
				$params["mydate"]		= date('Y/m/d', strtotime($post['date1'][$k]));
				$params["isWhole"]		= $post['allday'];
				$params["start"]		= $start_time;
				$params["end"]			= $end_time;
				$params["repeat"]		= $post['repeat1'][$k];
				$params["content"]		= $post['text'];
				$this->db->insert('tblcalendar', $params);
				
			}else{
				$count_if_2_consec_empty++;
				if($count_if_2_consec_empty >= 2){ break; }
			}
		}
		
		
		
		if($_POST['redirect']){
			redirect("admin/calendar/".$_POST['redirect']);
		}else{
			redirect("admin/calendar");
		}		
	}
	
	function addcalendar_new_multiple(){
		
		$post = $this->input->post();
		$allday = !empty($post['allday']) ? $post['allday'] : '';

		
		$show_even_on_closed_days = isset($_POST['show_even_on_closed_days']) ? 1 : 0;
		$posted_dates = array_values(($post['date1']));
		
		$count_dates = count($posted_dates);
		
		if($count_dates == 2){ // meaniing it is just a single event 
		
			$k = 1; // set key as zero acting like it is the first one 
			
			$first_date = $posted_dates[$k];
			
			
			$start_time = '';
			$end_time = '';
			
			if(empty($allday)){	// allow closed day
			if( $post['blog_category_id'] == 52  ){
				$start_time = "";
				$end_time =   "";
				//$post['repeat1'][$k] = "";
			} else{
				$start_time = $post['start_hr1'][$k].':'.$post['start_min1'][$k].' '.$post['start_ampm1'][$k];
				$end_time = $post['end_hr1'][$k].':'.$post['end_min1'][$k].' '.$post['end_ampm1'][$k];
				}
			}else{
				$allday = 1;
			}
			
			if($allday == 1){
				$start_time = "";
				$end_time =   "";
			}
			// var_dump($allday);
			// pre($post);
			// exit;
			$params["category"]		= $post['blog_category_id'];
			$params["location_id"]	= (array_key_exists('location_id',$post))?$post['location_id']:0;
			$params["title"]		= $post['title'];
			$params["mydate"]		= date('Y/m/d', strtotime($first_date));
			$params["isWhole"]		= $post['allday1'][1];
			$params["start"]		= $start_time;
			$params["end"]			= $end_time;
			$params["repeat"]		= $post['repeat1'][$k];
			$params["content"]		= $post['text'];
			$params['is_multiple'] = 0;
			//$params['is_multiple'] = 1;
			$params['pos'] = 0;
			$params['show_even_on_closed_days'] = $show_even_on_closed_days;
			$ins['end_date'] = $_POST['end_date1'][$i];
			//echo '<pre>params'; print_r($params); die;
			$this->db->insert('tblcalendar', $params);
			
		}else{
		
		
		  	// HERE we are going to handle the multiple events one.
				
			// Initially We would like to insert ONE First.
				
			$k = 1; // set key as zero acting like it is the first one 
			
			// pre($post);exit;
			
			$params["category"]		= $post['blog_category_id'];
			$params["location_id"]	= (array_key_exists('location_id',$post))?$post['location_id']:0;
			$params["title"]		= $post['title'];
			$params["mydate"]		= date('Y/m/d', strtotime($post['date1'][$k]));
			$params["isWhole"]		= '';
			$params["start"]		= '';
			$params["end"]			= '';
			$params["repeat"]		= '';
			$params["content"]		= $post['text'];
			$params['is_multiple'] = 1;
			$params['show_even_on_closed_days'] = $show_even_on_closed_days;
			
			$this->db->insert('tblcalendar', $params);
			$event_id = $this->db->insert_id();
			
			$start_hr1 = ($post['start_hr1']);
			$start_min1 = ($post['start_min1']);
			$start_ampm1 = ($post['start_ampm1']);
			
			$end_hr1 = ($post['end_hr1']);
			$end_min1 = ($post['end_min1']);
			$end_ampm1 = ($post['end_ampm1']);
			
			$repeat1 = ($post['repeat1']);
			
			$allday1 = array();
			
			if(array_key_exists('allday1',$post)){
				$allday1 = ($post['allday1']);
			}
			
			$isWhole = '';
			
			foreach($posted_dates as $i => $item){
				
				if($i>0){
					if(array_key_exists($i,$allday1) AND $allday1[$i] != '' AND $allday1 == '1'){
						
						$isWhole = 1;
						
					}				
					$start_time = '';
					$end_time = '';
				
					if(empty($allday)){
						if( $_POST['blog_category_id'] == 52  ){
							$start_time = "";
							$end_time =   "";
						} else{
							$start_time = $start_hr1[$i].':'.$start_min1[$i].' '.$start_ampm1[$i];
							$end_time = $end_hr1[$i].':'.$end_min1[$i].' '.$end_ampm1[$i];
						}
					}else{
						$allday = 1;
					}
					
					if($post['allday1'][$i] == 1){
						$start_time = "";
						$end_time =   "";
					}
					
					$ins['created'] = date('Y-m-d H:i:s');
					$ins['date'] = date('Y/m/d', strtotime($item));
					$ins['start'] =  $start_time;
					$ins['end'] = $end_time;
					$ins['repeat'] = $repeat1[$i];
					$ins['event_id'] = $event_id;
					$ins['isWhole'] = $post['allday1'][$i];
					$ins['pos'] = 0;
					$ins['end_date'] = $_POST['end_date1'][$i];
					
					$this->db->insert('tbl_calendar_dates',$ins);
				}
			}
		
		}
		
		
		if($_POST['redirect']){
			redirect("admin/calendar/".$_POST['redirect']);
		}else{
			redirect("admin/calendar");
		}		
	}
	
	
	function editcalendar_multiple(){
		
		$post = $this->input->post();
		$show_even_on_closed_days = isset($_POST['show_even_on_closed_days']) ? 1 : 0;
		$allday = !empty($post['allday']) ? $post['allday'] : '';
	
		$posted_dates = ($post['date1']);
		
		$count_dates = count($posted_dates);
		
		$event_id = $this->uri->segment(4);
		
		// HERE we are going to handle the multiple events one.
		
		
		// get a location_id
		$location_id = array_key_exists('location_id',$post)?$post['location_id']:'';
		if(empty($post['location_id'])){
			$check = $this->default_db->row('tblcalendar', array('id'=>$event_id));
			$location_id = $check['location_id'];
			if(empty($check['location_id'])){
				$this->db->order_by('id');
				$get_location = $this->default_db->row('tblcontact');
				$location_id = $get_location['id'];
			}
		}	
			
		$k = 1; // set key as zero acting like it is the first one 
		
		
		$params["category"]		= $post['blog_category_id'];
		$params["location_id"]	= $location_id;
		$params["title"]		= $post['title'];
		$params["mydate"]		= $post['date1'][1];
		$params["isWhole"]		= '';
		$params["start"]		= '';
		$params["end"]			= '';
		$params["repeat"]		= '';
		$params["content"]		= $post['text'];
		$params['is_multiple'] = 1; //if count == 1 then just make it as a single event one.
		$params["show_even_on_closed_days"]	= $show_even_on_closed_days;
		$this->db->where('id',$event_id);
		$this->db->update('tblcalendar', $params);
		
		
		$start_hr1 = ($post['start_hr1']);
		$start_min1 = ($post['start_min1']);
		$start_ampm1 = ($post['start_ampm1']);
		
		$end_hr1 = ($post['end_hr1']);
		$end_min1 = ($post['end_min1']);
		$end_ampm1 = ($post['end_ampm1']);
		
		$repeat1 = ($post['repeat1']);
		
		$allday1 = array();
		
		if(array_key_exists('allday1',$post)){
			$allday1 = ($post['allday1']);
		}
		
		$isWhole = '';
		
		//delete and re-insert
		
		$this->db->where('event_id',$event_id);
		$this->db->delete('tbl_calendar_dates');
		
		
		//echo '<pre>posted_dates'; print_r($posted_dates); die;
		
		foreach($posted_dates as $i => $item){
			
			if($i>0){
			
				if(array_key_exists($i,$allday1) AND $allday1[$i] != '' AND $allday1 == '1'){
					
					$isWhole = 1;
					
				}				
				$start_time = '';
				$end_time = '';
				
				
				if(empty($allday)){
					if( $_POST['blog_category_id'] == 52  ){
						$start_time = "";
						$end_time =   "";
						$ins['repeat'] = '';
					} else{
						$start_time = $start_hr1[$i].':'.$start_min1[$i].' '.$start_ampm1[$i];
						$end_time = $end_hr1[$i].':'.$end_min1[$i].' '.$end_ampm1[$i];
					}
					
				}else{
					$allday = 1;
				}
				
				if($post['allday1'][$i] == 1){
					$start_time = "";
					$end_time =   "";
				}
				
				$ins['created'] = date('Y-m-d H:i:s');
				$ins['date'] = date('Y/m/d', strtotime($item));
				$ins['start'] =  $start_time;
				$ins['end'] = $end_time;
				$ins['repeat'] = $repeat1[$i];
				$ins['event_id'] = $event_id;
				$ins['isWhole'] = $post['allday1'][$i];
				$ins['end_date'] = $_POST['end_date1'][$i];
				//echo '<prE>ins'; print_r($ins); die;
				$this->db->insert('tbl_calendar_dates',$ins);
			}
			
		}
		
		
			
	}
	
	function editcalendar(){
	
		$title = $_POST['title'];
		$category = $_POST['blog_category_id'];
		$date = array_key_exists('date',$_POST)?$_POST['date']:'0000-00-00';
		$repeat = $_POST['repeat'];
		$location_id= isset($_POST['location_id']) ? $_POST['location_id'] : '0';
		
		if($location_id == 0){
			$check_current = $this->default_db->row('tblcalendar', array('id'=>$this->uri->segment(4)));
			if(!empty($check_current['location_id'])){
				$location_id = $check_current['location_id'];
			}else{
				$this->db->order_by('id');
				$this->db->limit(1);
				$check_current = $this->default_db->row('tblcontact');
				$location_id = $check_current['id'];
				
			}
		}
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
		
		if(!array_key_exists('allday',$_POST) AND !isset($_POST['allday'])){
			if( $_POST['blog_category_id'] == 52  ){
					$start_time = "";
					$end_time =   "";

			} else{
				$start = $_POST['start_hr'].':'.$_POST['start_min'].' '.$_POST['start_ampm'];
				$end = $_POST['end_hr'].':'.$_POST['end_min'].' '.$_POST['end_ampm'];
			}
			$allday = 0;
		}
		else{
			$allday = 1;
			$start = '';
			$end = '';
		}
		
		
		$post = $_POST;
		pre($post);
		
				
		$data = array(
		  "category" => $category,
		  "location_id" => $location_id, 
		  "title" => $title,
		  "mydate" => $date,  
		  "isWhole" => $post['allday1'][1],
		  "start" => $start, 
		  "end" => $end, 
		  "repeat" => $repeat, 
		  "content" => $content);
	  
	  
		$this->query_model->update("tblcalendar",$this->uri->segment(4), $data);
	
		
		

	}
	
	/* changelog v2 edit_exception */
	function edit_exception(){		
		
		$counter = $this->input->post('counter');	
		$content = $_POST['text'];		
		$content = htmlentities($content);
		
		$cal_id = $this->uri->segment(4);
		
		$data = array( "exception_text" => $content);
		
		if($this->query_model->update("tblcalendar",$this->uri->segment(4), $data))
		
		$data = array();
		
		//echo '<pre>'; print_r($_POST); echo '</pre>';
		for($i=1; $i<=$counter; $i++){
			
			$date = $this->input->post('date'.$i);
			if(isset($date) && !empty($date)){
				
				$data[] = array("cal_id" => $cal_id, "exception_date" => $date);
			}
		}
		//echo '<pre>'; print_r($data); echo '</pre>';
		
		foreach($data as $q){
			$this->query_model->insertData("tblexception", $q);
		}
		
		if($_POST['redirect']){
			redirect("admin/calendar/".$_POST['redirect']);
		}else{
			redirect("admin/calendar");
		}

	}
	
	function updaterules(){
		$title = $_POST['title'];
		
		$content = $_POST['text'];		
		$ans = htmlentities($content);				
		
		$pub = $_POST['published'];
		$data = array("title" => $title, "content" => $ans, "published" => $pub);
		if($this->query_model->update("tblrules",$this->uri->segment(4),$data)):
			redirect("admin/schoolrules");	
		endif;
	}
	
	function addRules(){
		$title = $_POST['title'];
		
		$content = $_POST['text'];		
		$ans = htmlentities($content);
		
		$pub = $_POST['published'];
		$data = array("title" => $title, "content" => $ans, "published" => $pub);
		if($this->query_model->insertData("tblrules",$data)):
			if($_POST['redirect']){
					redirect("admin/schoolrules/".$_POST['redirect']);
				}else{
					redirect("admin/schoolrules");
			}
		endif;
	}
	
	function addblog(){
		$title = trim($_POST['title']);
		$content = htmlentities($_POST['text']);
		$category = $_POST['blog_category_id'];
		$comment = $_POST['allow_comments'];
		$shared = $_POST['shared'];
		$published = $_POST['published'];
		$desc = $_POST['short_description'];
		
	
		if($title == NULL):
			$title = "blog ".$this->countblog();
		endif;
		
		$x = $this->checkduplicate($title);
		if($x > 0):		
			$title = $title." ".($x+1);
		endif;
		
		$data = array(
			'title' => $title,
			'content' => $content,
			'author' => $this->session->userdata('user'),
			'published' => $published,
			'sharing' => $shared,
			'commenting' => $comment,
			'category' => $category,
			'short_desc' => $desc
		);
		
		if($this->query_model->insertData($this->table,$data)):
			redirect("admin/blog");			
		endif;
		
	}
	
	function checkduplicate($title){
		$this->db->where("title",$title);
		return count($this->db->get($this->table)->result());	
	}
		
	function countblog(){		
		return count($this->getallblog())+1;
	}
	
	function updateblog(){
		$title = trim($_POST['title']);
		
		$content = $_POST['text'];		
		$content = htmlentities($content);
		
		$category = $_POST['blog_category_id'];
		$comment = $_POST['allow_comments'];
		$shared = $_POST['shared'];
		$published = $_POST['published'];
		$desc = $_POST['short_description'];
		
			$data = array(
			'title' => $title,
			'content' => $content,
			'author' => $this->session->userdata('user'),
			'published' => $published,
			'sharing' => $shared,
			'commenting' => $comment,
			'category' => $category,
			'short_desc' => $desc
		);
		
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
				redirect("admin/blog");
			endif;	
	}
	
	function editTab( $id, $type ){
		//echo $id.'====>'; 
		//$title = trim($_POST['title']);
		$headline = $_POST['headline'];
		
		$content = $_POST['text'];
		
		$image_video = $_POST['image_video'];
		$youtube_video = $_POST['youtube_video'];
		$vimeo_video = $_POST['vimeo_video'];
		$video_type = $_POST['video_type'];
		$read_more_button = $_POST['read_more_button'];
		$background_color = isset($_POST['background_color']) ? $_POST['background_color'] : '';
		$img_top_spacing = isset($_POST['img_top_spacing']) ? $_POST['img_top_spacing'] : '';
		//echo '<pre>';print_r($_POST); die;
		$image_alt = '';
		if(isset($_POST['image_alt'])){ $image_alt = $_POST['image_alt'];	}
		$content = htmlentities($content);
		
		//$bulhead = $_POST['bulhead'];
		//$bulcont = $_POST['bulcont'];
		
		//$data = array("title" => $title, "headline" => $headline, "content" => $content, "bulhead" => $bulhead, "bulcont" => $bulcont); 
		$data = array("headline" => $headline, "content" => $content,'image_alt' => $image_alt, 'image_video'=> $image_video, 'youtube_video' => $youtube_video,'vimeo_video'=> $vimeo_video,'video_type' => $video_type,'read_more_button'=>$read_more_button,'background_color' => $background_color,'img_top_spacing'=>$img_top_spacing); 
		
		/*** vinay 18/11 ***/
		
		if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){

			$this->load->library('image_lib');

			$config['upload_path'] = 'upload/welcome_text/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('userfile')){
				$image_data = $this->upload->data();
				$data['photo'] = $image_data['file_name'];
			}

			$resize_config['source_image'] = 'upload/welcome_text/'.$data['photo'];
			$get_size = getimagesize($resize_config['source_image']);

			$image_info = array(
				'width' => $get_size[0],
				'height' => $get_size[1]
			);

			$resize_config['create_thumb'] = FALSE;

			$resize_config['new_image'] = 'upload/welcome_text/thumb/'.$data['photo'];
			
			//echo '<pre>'; print_r($image_info); echo '</pre>';
		

			if($image_info['width']  >= 130){				
				$new_width = 130;
				$new_height = round((130/$image_info['width'])*$image_info['height']);				
				
				$resize_config['width'] = $new_width;
				$resize_config['height'] = $new_height;
				$this->image_lib->initialize($resize_config);
				$this->image_lib->resize();	
			}
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/welcome_text/'.$data['photo']);
			
			$this->query_model->tinyImageCampressAndResize('upload/welcome_text/thumb/'.$data['photo']);
									
		}
		
		if(isset($_FILES['background_image']['name']) && !empty($_FILES['background_image']['name'])){

			$this->load->library('image_lib');

			$config['upload_path'] = 'upload/welcome_text/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);

			if ( $this->upload->do_upload('background_image')){
				$image_data = $this->upload->data();
				$data['background_image'] = $image_data['file_name'];
			}

			$resize_config['source_image'] = 'upload/welcome_text/'.$data['background_image'];
			$get_size = getimagesize($resize_config['source_image']);

			$image_info = array(
				'width' => $get_size[0],
				'height' => $get_size[1]
			);

			$resize_config['create_thumb'] = FALSE;

			$resize_config['new_image'] = 'upload/welcome_text/thumb/'.$data['background_image'];
			
			//echo '<pre>'; print_r($image_info); echo '</pre>';
		

			if($image_info['width']  >= 130){				
				$new_width = 130;
				$new_height = round((130/$image_info['width'])*$image_info['height']);				
				
				$resize_config['width'] = $new_width;
				$resize_config['height'] = $new_height;
				$this->image_lib->initialize($resize_config);
				$this->image_lib->resize();	
			}
			
			// Tiny Image Campress and resize
			$this->query_model->tinyImageCampressAndResize('upload/welcome_text/'.$data['background_image']);
			
			$this->query_model->tinyImageCampressAndResize('upload/welcome_text/thumb/'.$data['background_image']);
									
		}
		/*** end Code ***/
		
		
		if($this->query_model->update("tbltab", $id ,$data)):
			redirect("admin/home/".$type);
		endif;			
	}
	
	function editTips(){
		
		$heading1 = htmlentities($this->input->post('heading1'));
		$heading2 = htmlentities($this->input->post('heading2'));
		$description = htmlentities($this->input->post('description'));
		$feature = $this->input->post('feature');
		
		$email_subject = htmlentities($this->input->post('email_subject'));
		$email_body = $this->input->post('email_body');
		
		if($feature!=''){
			$published = 'off';
		}else
			$published = 'on';
		
		$data = array('heading1' => $heading1, 'heading2' => $heading2, 'description' => $description, 'published' => $feature, 'email_subject' => $email_subject, 
				'email_body' => $email_body);
				
		//echo '<pre>'; print_r($data); echo '</pre>';
		//exit;
		$this->query_model->update("tblgettips", 1 ,$data);
	}
	
	function addHomework(){
		$title = $_POST['title'];

		$content = $_POST['ques'];		
		$ques = htmlentities($content);
				
		$content = $_POST['ans'];		
		$ans = htmlentities($content);
				
		$pub = $_POST['published'];
		$data = array("title" => $title, "ques" => $ques, "ans" => $ans, "published" => $pub, "category" => $this->uri->segment(4));
		if($this->query_model->insertData("tblhomework",$data)):
			if($_POST['redirect']){
				redirect("admin/homework/".$_POST['redirect']);
			}else{
				redirect("admin/homework");
			}	
		endif;
	}
	
	function updateHomework(){
		$title = $_POST['title'];

		$content = $_POST['ques'];		
		$ques = htmlentities($content);
				
		$content = $_POST['ans'];		
		$ans = htmlentities($content);		
		
		$pub = $_POST['published'];
		$data = array("title" => $title, "ques" => $ques, "ans" => $ans, "published" => $pub);
		if($this->query_model->update("tblhomework",$this->uri->segment(4),$data)):
			if($_POST['redirect']){
				redirect("admin/homework/".$_POST['redirect']);
			}else{
				redirect("admin/homework");
			}	
		endif;
	}


// Large Video Section On Home Page

		function editvideo($id,$type){
		
		//echo '<pre>'; print_r($_POST); die;
		$image = $_FILES['userfile']['name'];
		$youtube_video = $_POST['youtube_video'];
		$vimeo_video = $_POST['vimeo_video'];
		$video_type = $_POST['video_type'];
		$background_color = $_POST['background_color'];
		$headline = $_POST['headline'];
		$show_button = isset($_POST['show_button']) ? $_POST['show_button'] : 0;
		$button_text = isset($_POST['button_text']) ? $_POST['button_text'] : '';
		$button_link = isset($_POST['button_link']) ? $_POST['button_link'] : '';
		$button_link_target = isset($_POST['button_link_target']) ? $_POST['button_link_target'] : '';
		
		$image_alt = '';
		if(isset($_POST['image_alt'])){ $image_alt = $_POST['image_alt'];	}
		
		
		if(isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])){

			$this->load->library('image_lib');

			$config['upload_path'] = 'upload/largevideo/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);
              
			if ( $this->upload->do_upload('userfile')){
				$image_data = $this->upload->data();
				$data['background_image'] = $image_data['file_name'];
			}

			$resize_config['source_image'] = 'upload/largevideo/'.$data['background_image'];
			$get_size = getimagesize($resize_config['source_image']);

			$image_info = array(
				'width' => $get_size[0],
				'height' => $get_size[1]
			);

			$resize_config['create_thumb'] = FALSE;

			$resize_config['new_image'] = 'upload/largevideo/thumb/'.$data['background_image'];
			
			//echo '<pre>'; print_r($image_info); echo '</pre>';
		

			if($image_info['width']  >= 130){				
				$new_width = 130;
				$new_height = round((130/$image_info['width'])*$image_info['height']);				
				
				$resize_config['width'] = $new_width;
				$resize_config['height'] = $new_height;
				$this->image_lib->initialize($resize_config);
				$this->image_lib->resize();	
			}
									
		}
		/*** end Code ***/
		$data = array('vimeo_video' =>$vimeo_video,'youtube_video' => $youtube_video,'video_type' => $video_type,'background_image'=>$image,'background_color'=>$background_color,'headline' => $headline,'show_button' => $show_button,'button_text' => $button_text,'button_link' => $button_link,'button_link_target' => $button_link_target,); 
     if(empty($this->query_model->getbyTable("tbl_large_video")))
				  {
					  
						 if($this->query_model->insertData("tbl_large_video",$data)):
						 redirect("admin/home/".$type);
						 endif; 
					 
				  }else
				  {
		
						if($this->query_model->update("tbl_large_video", $id ,$data)):
							redirect("admin/home/".$type);
						endif;	
				  }

		
	}



}
