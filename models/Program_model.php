<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program_model extends CI_Model{
	
	var $table = 'tblprogram';
	
	function addProgram(){
		//echo '<pre>'; print_r($_POST); die;
	$metaVaribles = $this->query_model->getbyTable("tblmetavariable");
	if(isset($_POST['data'])){
			$p = 1;
			foreach($_POST['data'] as $standPage){
				$this->db->order_by("id","desc");
				$current_program_id = $this->query_model->getbyTable('tblprogram');
				$current_program_id = $current_program_id[0]->id + 1;
				$data['title'] = $standPage['title'];
				$data['desc'] = $standPage['desc'];
				$data['background_color'] = $standPage['background_color'];
				$data['program_id'] = $current_program_id;
				
				$image_name = 'stand_page_photo'.$p;
				
				
				$myImage = isset($_FILES['stand_page_photo'.$p]) ? $_FILES['stand_page_photo'.$p] : '';
				
			//	if( isset($_FILES[$image_name]['name']) && !empty($_FILES[$image_name]['name'])){
				if(isset($myImage['name']) && !empty($myImage['name']) && $myImage['name'] != ''){
				//echo $_FILES[$image_name]['name'].'<br>';
				$_FILES[$image_name]['name'] = time().$_FILES[$image_name]['name'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload($image_name)){
					$image_data = $this->upload->data();
					$data['stand_page_photo'] = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$data['stand_page_photo'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$data['stand_page_photo'];
				
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
		
			}else{
					$data['stand_page_photo'] = '';
				}
				$this->query_model->insertData('tblstandpage', $data);
				$p++;
			} //die;
			
		}
		
	$sectionArr = array('question_headline_section~0'=>'Question Headline Section','white_stripe_section~1'=>'White Stripe Under Header Section','benefits_1_section~2'=>'Benefits with 3 images Section','video_row_section~3'=>'Video Row Section','call_to_action_section~5'=>'Call to Action with 3 Images Section','headling_section~6'=>'Heading with 3 boxes Section','statistics_section~7'=>'Statistics with 3 images Section','benefits_2_section~8'=>'Benefits Row2 with 3 Images Section','white_stripe_2_section~9'=>'White Stripe Row 2 Section','benefits_3_section~13'=>'Benefits Row3 with 3 Images Section','full_width_row_section~4'=>'Alternating Full Width Rows','little_row_section~10'=>'Alternating Little Rows','faq_section~12'=>'Faqs','testimonial_section~11'=>'Testimonials','html_editor_section~2'=>'HTML Editor');
	
	if(!empty($sectionArr)){
		foreach($sectionArr as $key => $section){
			
			$this->db->order_by('id','desc');
			$this->db->limit(1);
			$lastProgramData = $this->query_model->getbyTable('tblprogram');
			$sectionValue = explode('~',$key);
			
			$section_name = $sectionValue[0];
			$section_pos = $sectionValue[1];
			$sectionData['section'] = $section_name;
			$sectionData['published'] = 1;
			$sectionData['pos'] = $section_pos;
			$sectionData['program_id'] = !empty($lastProgramData) ? $lastProgramData[0]->id + 1 : 1;
			$sectionData['cat_id'] = isset($_POST['category']) ? $_POST['category'] : 0;
			
			$this->query_model->insertData('tbl_program_sections',$sectionData);
		}
	}
	
	$p = '';	
	$name = trim ($_POST['name']);
	$buttonName = trim ($_POST['btnname']);
	
		$ages = $_POST['ages'];
		$features = serialize($_POST['features']);
		$stand_alone_page = $_POST['stand_alone_page'];
		$video_type = $_POST['video_type'];
		$youtube_video = $_POST['youtube_video'];
		$vimeo_video = $_POST['vimeo_video'];
		$content = $_POST['text'];		
		$desc = htmlentities($content);
		$body_id = $_POST['body_id'];
		$header_title = $_POST['header_title'];
		$header_desc = $_POST['header_desc'];
		$override_logo = $_POST['override_logo'];
		$landing_checkbox = $_POST['landing_checkbox'];
		$landing_program = $_POST['landing_program'];
		$landing_page_url = $_POST['landing_page_url'];
		$landing_program_id = !empty($_POST['landing_program_id'])?$_POST['landing_program_id']:'';
		
		$stand_program_name = $_POST['stand_program_name'];
		$stand_program_ages = $_POST['stand_program_ages'];
		
		$mini_form_offer_title = $_POST['mini_form_offer_title'];
		$mini_form_offer_desc = $_POST['mini_form_offer_desc'];
		$mini_form_button1_text = $_POST['mini_form_button1_text'];
		$mini_form_button2_text = $_POST['mini_form_button2_text'];
		$trial_title = $_POST['trial_title'];
		$trial_desc = $_POST['trial_desc'];
		$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : $metaVaribles[0]->meta_school_name.' | '.$name.' in '.$metaVaribles[0]->meta_city.', '.$metaVaribles[0]->meta_state;
		$meta_desc = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '';
		
		          
                $receive_class_button = 0;
                if(isset($_POST['receive_class_button'])){
                    $receive_class_button = $_POST['receive_class_button'];
                }
                $receive_button_text = isset($_POST['receive_button_text'])?$_POST['receive_button_text']:'';
                $receive_button_link = isset($_POST['receive_button_link'])?$_POST['receive_button_link']:'';
		
		/*if(!empty($_POST['slug'])){
				$program_slug = strtolower(str_replace(' ','-',$_POST['slug']));
		}else{
				$program_slug = strtolower(str_replace(' ','-',$_POST['name']));
		}*/
		
		if(!empty($_POST['slug'])){
				//$program_slug = strtolower(str_replace(' ','-',$_POST['slug']));
				$replce_slug = preg_replace("/[^A-Za-z0-9\- ]/", "",$_POST['slug']);
				$slug = str_replace(' ', '-',strtolower($replce_slug));
				$program_slug = str_replace('--', '-',strtolower($slug));
		}else{
				//$program_slug = strtolower(str_replace(' ','-',$_POST['name']));
					$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$name);
					$slug = str_replace(' ', '-',strtolower($replce_slug));
					$program_slug = str_replace('--', '-',strtolower($slug));
		}
		
		
		$image_video = isset($_POST['image_video']) ? $_POST['image_video'] : '';
		$image_alt = isset($_POST['image_alt']) ? $_POST['image_alt'] : '';
		$image_2 = '';
		
		$image = isset($_FILES['userfile']['name'])?$_FILES['userfile']['name']:'';
		$header_image = $_FILES['header_image']['name'];
		$trials = 0;
		if(isset($_POST['trials'])){
			$trials = $_POST['trials'];
		}
		
		
		$background_color = isset($_POST['background_color']) ? $_POST['background_color'] : '';
		$background_image = isset($_POST['last-background_image']) ? $_POST['last-background_image'] : '';
		$body_title = isset($_POST['body_title']) ? $_POST['body_title'] : '';
		$body_desc = isset($_POST['body_desc']) ? $_POST['body_desc'] : '';
		$body_img_position = isset($_POST['body_img_position']) ? $_POST['body_img_position'] : '';
		$body_image = isset($_POST['last-body_image']) ? $_POST['last-body_image'] : '';
		$action_title = isset($_POST['action_title']) ? $_POST['action_title'] : '';
		$action_desc = isset($_POST['action_desc']) ? $_POST['action_desc'] : '';
		$action_background_image = isset($_POST['last-action_background_image']) ? $_POST['last-action_background_image'] : '';
		$action_background_color = isset($_POST['action_background_color']) ? $_POST['action_background_color'] : '';
		$action_headline_1 = isset($_POST['action_headline_1']) ? $_POST['action_headline_1'] : '';
		$action_image_1 = isset($_POST['last-action_image_1']) ? $_POST['last-action_image_1'] : '';
		$action_headline_2 = isset($_POST['action_headline_2']) ? $_POST['action_headline_2'] : '';
		$action_image_2 = isset($_POST['last-action_image_2']) ? $_POST['last-action_image_2'] : '';
		$action_headline_3 = isset($_POST['action_headline_3']) ? $_POST['action_headline_3'] : '';
		$action_image_3 = isset($_POST['last-action_image_3']) ? $_POST['last-action_image_3'] : '';
		$action_desc_1 = isset($_POST['action_desc_1']) ? $_POST['action_desc_1'] : '';
		$action_desc_2 = isset($_POST['action_desc_2']) ? $_POST['action_desc_2'] : '';
		$action_desc_3 = isset($_POST['action_desc_3']) ? $_POST['action_desc_3'] : '';
		
		$video_background_image = isset($_POST['last-video_background_image']) ? $_POST['last-video_background_image'] : '';
		$video_background_color = isset($_POST['video_background_color']) ? $_POST['video_background_color'] : '';
		
		$benefits_title = isset($_POST['benefits_title']) ? $_POST['benefits_title'] : '';
		$benefits_desc = isset($_POST['benefits_desc']) ? $_POST['benefits_desc'] : '';
		$benefits_background_image = isset($_POST['last-benefits_background_image']) ? $_POST['last-benefits_background_image'] : '';
		$benefits_background_color = isset($_POST['benefits_background_color']) ? $_POST['benefits_background_color'] : '';
		
		$benefits_headline_1 = isset($_POST['benefits_headline_1']) ? $_POST['benefits_headline_1'] : '';
		$benefits_image_1 = isset($_POST['last-benefits_image_1']) ? $_POST['last-benefits_image_1'] : '';
		$benefits_headline_2 = isset($_POST['benefits_headline_2']) ? $_POST['benefits_headline_2'] : '';
		$benefits_image_2 = isset($_POST['last-benefits_image_2']) ? $_POST['last-benefits_image_2'] : '';
		$benefits_headline_3 = isset($_POST['benefits_headline_3']) ? $_POST['benefits_headline_3'] : '';
		$benefits_image_3 = isset($_POST['last-benefits_image_3']) ? $_POST['last-benefits_image_3'] : '';
		
		$headling_title = isset($_POST['headling_title']) ? $_POST['headling_title'] : '';
		$headling_desc = isset($_POST['headling_desc']) ? $_POST['headling_desc'] : '';
		$headling_background_image = isset($_POST['last-headling_background_image']) ? $_POST['last-headling_background_image'] : '';
		$headling_background_color = isset($_POST['headling_background_color']) ? $_POST['headling_background_color'] : '';
		
		$headling_headline_1 = isset($_POST['headling_headline_1']) ? $_POST['headling_headline_1'] : '';
		$headling_headline_2 = isset($_POST['headling_headline_2']) ? $_POST['headling_headline_2'] : '';
		$headling_headline_3 = isset($_POST['headling_headline_3']) ? $_POST['headling_headline_3'] : '';
		
		$statistics_title = isset($_POST['statistics_title']) ? $_POST['statistics_title'] : '';
		$statistics_desc = isset($_POST['statistics_desc']) ? $_POST['statistics_desc'] : '';
		$statistics_background_image = isset($_POST['last-statistics_background_image']) ? $_POST['last-statistics_background_image'] : '';
		$statistics_background_color = isset($_POST['statistics_background_color']) ? $_POST['statistics_background_color'] : '';
		$statistics_headline_1 = isset($_POST['statistics_headline_1']) ? $_POST['statistics_headline_1'] : '';
		$statistics_image_1 = isset($_POST['last-statistics_image_1']) ? $_POST['last-statistics_image_1'] : '';
		$statistics_headline_2 = isset($_POST['statistics_headline_2']) ? $_POST['statistics_headline_2'] : '';
		$statistics_image_2 = isset($_POST['last-statistics_image_2']) ? $_POST['last-statistics_image_2'] : '';
		$statistics_headline_3 = isset($_POST['statistics_headline_3']) ? $_POST['statistics_headline_3'] : '';
		$statistics_image_3 = isset($_POST['last-statistics_image_3']) ? $_POST['last-statistics_image_3'] : '';
		$statistics_desc_1 = isset($_POST['statistics_desc_1']) ? $_POST['statistics_desc_1'] : '';
		$statistics_desc_2 = isset($_POST['statistics_desc_2']) ? $_POST['statistics_desc_2'] : '';
		$statistics_desc_3 = isset($_POST['statistics_desc_3']) ? $_POST['statistics_desc_3'] : '';
		
		$benefits_2_title = isset($_POST['benefits_2_title']) ? $_POST['benefits_2_title'] : '';
		$benefits_2_desc = isset($_POST['benefits_2_desc']) ? $_POST['benefits_2_desc'] : '';
		$benefits_2_background_image = isset($_POST['last-benefits_2_background_image']) ? $_POST['last-benefits_2_background_image'] : '';
		$benefits_2_background_color = isset($_POST['benefits_2_background_color']) ? $_POST['benefits_2_background_color'] : '';
		$benefits_2_headline_1 = isset($_POST['benefits_2_headline_1']) ? $_POST['benefits_2_headline_1'] : '';
		$benefits_2_image_1 = isset($_POST['last-benefits_2_image_1']) ? $_POST['last-benefits_2_image_1'] : '';
		$benefits_2_headline_2 = isset($_POST['benefits_2_headline_2']) ? $_POST['benefits_2_headline_2'] : '';
		$benefits_2_image_2 = isset($_POST['last-benefits_2_image_2']) ? $_POST['last-benefits_2_image_2'] : '';
		$benefits_2_headline_3 = isset($_POST['benefits_2_headline_3']) ? $_POST['benefits_2_headline_3'] : '';
		$benefits_2_image_3 = isset($_POST['last-benefits_2_image_3']) ? $_POST['last-benefits_2_image_3'] : '';
		$benefits_2_desc_1 = isset($_POST['benefits_2_desc_1']) ? $_POST['benefits_2_desc_1'] : '';
		$benefits_2_desc_2 = isset($_POST['benefits_2_desc_2']) ? $_POST['benefits_2_desc_2'] : '';
		$benefits_2_desc_3 = isset($_POST['benefits_2_desc_3']) ? $_POST['benefits_2_desc_3'] : '';
		
		$show_full_form_1 = isset($_POST['show_full_form_1']) ? $_POST['show_full_form_1'] : 0;
		$show_full_form_2 = isset($_POST['show_full_form_2']) ? $_POST['show_full_form_2'] : 0;
		$opt1_text = isset($_POST['opt1_text']) ? $_POST['opt1_text'] : '';
		$opt_2_title = isset($_POST['opt_2_title']) ? $_POST['opt_2_title'] : '';
		$opt_2_text = isset($_POST['opt_2_text']) ? $_POST['opt_2_text'] : '';
		
		$benefits_3_title = isset($_POST['benefits_3_title']) ? $_POST['benefits_3_title'] : '';
		$benefits_3_desc = isset($_POST['benefits_3_desc']) ? $_POST['benefits_3_desc'] : '';
		$benefits_3_background_image = isset($_POST['benefits_3_background_image']) ? $_POST['benefits_3_background_image'] : '';
		$benefits_3_background_color = isset($_POST['benefits_3_background_color']) ? $_POST['benefits_3_background_color'] : '';
		$benefits_3_headline_1 = isset($_POST['benefits_3_headline_1']) ? $_POST['benefits_3_headline_1'] : '';
		$benefits_3_image_1 = isset($_POST['benefits_3_image_1']) ? $_POST['benefits_3_image_1'] : '';
		$benefits_3_headline_2 = isset($_POST['benefits_3_headline_2']) ? $_POST['benefits_3_headline_2'] : '';
		$benefits_3_image_2 = isset($_POST['benefits_3_image_2']) ? $_POST['benefits_3_image_2'] : '';
		$benefits_3_headline_3 = isset($_POST['benefits_3_headline_3']) ? $_POST['benefits_3_headline_3'] : '';
		$benefits_3_image_3 = isset($_POST['benefits_3_image_3']) ? $_POST['benefits_3_image_3'] : '';
		$white_stripe2_title = isset($_POST['white_stripe2_title']) ? $_POST['white_stripe2_title'] : '';
		$white_stripe2_desc = isset($_POST['white_stripe2_desc']) ? $_POST['white_stripe2_desc'] : '';
		$white_stripe2_override_logo = isset($_POST['white_stripe2_override_logo']) ? $_POST['white_stripe2_override_logo'] : 0;
		
		$white_stripe2_image = isset($_POST['last-white_stripe2_image']) ? $_POST['last-white_stripe2_image'] : '';
		$show_learn_more = isset($_POST['show_learn_more']) ? $_POST['show_learn_more'] : 0;
		$white_stripe_background_color = isset($_POST['white_stripe_background_color']) ? $_POST['white_stripe_background_color'] : '';
		$program_cat_summary = isset($_POST['program_cat_summary']) ? $_POST['program_cat_summary'] : '';
		$program_cat_img_top_spacing = isset($_POST['program_cat_img_top_spacing']) ? $_POST['program_cat_img_top_spacing'] : '';
		$program_cat_image = isset($_POST['last-program_cat_image']) ? $_POST['last-program_cat_image'] : '';
		$testimonials_h2_text = isset($_POST['testimonials_h2_text']) ? $_POST['testimonials_h2_text'] : '';
		$testimonial_ids = isset($_POST['testimonial_ids']) ? serialize($_POST['testimonial_ids']) : '';
		$html_editor = isset($_POST['html_editor']) ? $_POST['html_editor'] : '';
		$video_title = isset($_POST['video_title']) ? $_POST['video_title'] : '';
		$video_desc = isset($_POST['video_desc']) ? $_POST['video_desc'] : '';
		
		$scroll_top = isset($_POST['scroll_top']) ? $_POST['scroll_top'] : 200;
		$opt1_title = isset($_POST['opt1_title']) ? $_POST['opt1_title'] : '';
		
		$program_cat_image_alt_text = isset($_POST['program_cat_image_alt_text']) ? $_POST['program_cat_image_alt_text'] : '';
		$header_image_alt_text = isset($_POST['header_image_alt_text']) ? $_POST['header_image_alt_text'] : '';
		$body_image_alt_text = isset($_POST['body_image_alt_text']) ? $_POST['body_image_alt_text'] : '';
		$benefits_image_1_alt_text = isset($_POST['benefits_image_1_alt_text']) ? $_POST['benefits_image_1_alt_text'] : '';
		$benefits_image_2_alt_text = isset($_POST['benefits_image_2_alt_text']) ? $_POST['benefits_image_2_alt_text'] : '';
		$benefits_image_3_alt_text = isset($_POST['benefits_image_3_alt_text']) ? $_POST['benefits_image_3_alt_text'] : '';
		$action_image_1_alt_text = isset($_POST['action_image_1_alt_text']) ? $_POST['action_image_1_alt_text'] : '';
		$action_image_2_alt_text = isset($_POST['action_image_2_alt_text']) ? $_POST['action_image_2_alt_text'] : '';
		$action_image_3_alt_text = isset($_POST['action_image_3_alt_text']) ? $_POST['action_image_3_alt_text'] : '';
		$statistics_image_1_alt_text = isset($_POST['statistics_image_1_alt_text']) ? $_POST['statistics_image_1_alt_text'] : '';
		$statistics_image_2_alt_text = isset($_POST['statistics_image_2_alt_text']) ? $_POST['statistics_image_2_alt_text'] : '';
		$statistics_image_3_alt_text = isset($_POST['statistics_image_3_alt_text']) ? $_POST['statistics_image_3_alt_text'] : '';
		$benefits_2_image_1_alt_text = isset($_POST['benefits_2_image_1_alt_text']) ? $_POST['benefits_2_image_1_alt_text'] : '';
		$benefits_2_image_2_alt_text = isset($_POST['benefits_2_image_2_alt_text']) ? $_POST['benefits_2_image_2_alt_text'] : '';
		$benefits_2_image_3_alt_text = isset($_POST['benefits_2_image_3_alt_text']) ? $_POST['benefits_2_image_3_alt_text'] : '';
		$white_stripe2_image_alt_text = isset($_POST['white_stripe2_image_alt_text']) ? $_POST['white_stripe2_image_alt_text'] : '';
		$benefits_3_image_1_alt_text = isset($_POST['benefits_3_image_1_alt_text']) ? $_POST['benefits_3_image_1_alt_text'] : '';
		$benefits_3_image_2_alt_text = isset($_POST['benefits_3_image_2_alt_text']) ? $_POST['benefits_3_image_2_alt_text'] : '';
		$benefits_3_image_3_alt_text = isset($_POST['benefits_3_image_3_alt_text']) ? $_POST['benefits_3_image_3_alt_text'] : '';
		$featured_program_img = isset($_POST['featured_program_img']) ? $_POST['featured_program_img'] : '';
		$featured_program_img_alt_text = isset($_POST['featured_program_img_alt_text']) ? $_POST['featured_program_img_alt_text'] : '';
		
		$faqs_h2_text = (isset($_POST['faqs_h2_text']) && !empty($_POST['faqs_h2_text'])) ? $_POST['faqs_h2_text'] : 'Frequently Asked Questions';
		$faq_ids = isset($_POST['faq_ids']) ? serialize($_POST['faq_ids']) : '';
		$program_type = isset($_POST['program_type']) ? $_POST['program_type'] : 'program_page';
		$header_title_background_color = isset($_POST['header_title_background_color']) ? $_POST['header_title_background_color'] : '';
		$show_override_logo = isset($_POST['show_override_logo']) ? $_POST['show_override_logo'] : 0;
		$question_headline = isset($_POST['question_headline']) ? $_POST['question_headline'] : '';
		
		$opt1_submit_btn_text = isset($_POST['opt1_submit_btn_text']) ? $_POST['opt1_submit_btn_text'] : '';
		$trial_offer_id = (isset($_POST['trial_offer_id']) && !empty($_POST['trial_offer_id'])) ? $_POST['trial_offer_id'] : 0;
		$redirection_type = isset($_POST['redirection_type']) ? $_POST['redirection_type'] : 'trial_offer';
		$dojocart_id = isset($_POST['dojocart_id']) ? $_POST['dojocart_id'] : 0;
		$third_party_url = isset($_POST['third_party_url']) ? $_POST['third_party_url'] : '';
		
		$button1_redirection_type = isset($_POST['button1_redirection_type']) ? $_POST['button1_redirection_type'] : 'trial_offer';
		$button1_trial_offer_id = (isset($_POST['button1_trial_offer_id']) && !empty($_POST['button1_trial_offer_id'])) ? $_POST['button1_trial_offer_id'] : 0;
		$button1_dojocart_id = isset($_POST['button1_dojocart_id']) ? $_POST['button1_dojocart_id'] : 0;
		$button1_third_party_url = isset($_POST['button1_third_party_url']) ? $_POST['button1_third_party_url'] : '';
		
		$button2_redirection_type = isset($_POST['button2_redirection_type']) ? $_POST['button2_redirection_type'] : 'trial_offer';
		$button2_trial_offer_id = (isset($_POST['button2_trial_offer_id']) && !empty($_POST['button2_trial_offer_id'])) ? $_POST['button2_trial_offer_id'] : 0;
		$button2_dojocart_id = isset($_POST['button2_dojocart_id']) ? $_POST['button2_dojocart_id'] : 0;
		$button2_third_party_url = isset($_POST['button2_third_party_url']) ? $_POST['button2_third_party_url'] : '';
		
		$thankyou_page_id = isset($_POST['thankyou_page_id']) ? $_POST['thankyou_page_id'] : 0;
		$button1_thankyou_page_id = isset($_POST['button1_thankyou_page_id']) ? $_POST['button1_thankyou_page_id'] : 0;
		$button2_thankyou_page_id = isset($_POST['button2_thankyou_page_id']) ? $_POST['button2_thankyou_page_id'] : 0;
		$connect_trial_offer_id = (isset($_POST['connect_trial_offer_id']) && !empty($_POST['connect_trial_offer_id'])) ? $_POST['connect_trial_offer_id'] : 0;
		$guests_values = (isset($_POST['guests_values']) && !empty($_POST['guests_values'])) ? serialize($_POST['guests_values']) : '';
		
		$show_location_type = (isset($_POST['show_location_type']) && !empty($_POST['show_location_type'])) ? $_POST['show_location_type'] : 'show_all';
		$locations = (isset($_POST['locations']) && !empty($_POST['locations'])) ? serialize($_POST['locations']) : '';
		$cat_photo_side = (isset($_POST['cat_photo_side']) && !empty($_POST['cat_photo_side'])) ? $_POST['cat_photo_side'] : 'left';
		
		$header_image_video = (isset($_POST['header_image_video']) && !empty($_POST['header_image_video'])) ? $_POST['header_image_video'] : 'image';
		$header_video_type = (isset($_POST['header_video_type']) && !empty($_POST['header_video_type'])) ? $_POST['header_video_type'] : '';
		$header_youtube_video = (isset($_POST['header_youtube_video']) && !empty($_POST['header_youtube_video'])) ? $_POST['header_youtube_video'] : '';
		$header_vimeo_video = (isset($_POST['header_vimeo_video']) && !empty($_POST['header_vimeo_video'])) ? $_POST['header_vimeo_video'] : '';
		
		$action_link_url_1 = (isset($_POST['action_link_url_1']) && !empty($_POST['action_link_url_1'])) ? $_POST['action_link_url_1'] : '';
		$action_link_url_2 = (isset($_POST['action_link_url_2']) && !empty($_POST['action_link_url_2'])) ? $_POST['action_link_url_2'] : '';
		$action_link_url_3 = (isset($_POST['action_link_url_3']) && !empty($_POST['action_link_url_3'])) ? $_POST['action_link_url_3'] : '';
      
		
				
		
		if(isset($_FILES['program_cat_image']['name']) && !empty($_FILES['program_cat_image']['name'])){
			$_FILES['program_cat_image']['name'] = time().$_FILES['program_cat_image']['name'];
				$program_cat_image = $_POST['program_cat_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('program_cat_image')){
					$image_data = $this->upload->data();
					$program_cat_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$program_cat_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$program_cat_image;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
					
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$program_cat_image);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$program_cat_image);
		
			}
			
			
		
		if(isset($_FILES['white_stripe2_image']['name']) && !empty($_FILES['white_stripe2_image']['name'])){
			$_FILES['white_stripe2_image']['name'] = time().$_FILES['white_stripe2_image']['name'];
				$white_stripe2_image = $_POST['white_stripe2_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('white_stripe2_image')){
					$image_data = $this->upload->data();
					$white_stripe2_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$white_stripe2_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$white_stripe2_image;
				
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
			
		
		if(isset($_FILES['benefits_3_background_image']['name']) && !empty($_FILES['benefits_3_background_image']['name'])){
			$_FILES['benefits_3_background_image']['name'] = time().$_FILES['benefits_3_background_image']['name'];
				$benefits_3_background_image = $_POST['benefits_3_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_3_background_image')){
					$image_data = $this->upload->data();
					$benefits_3_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_3_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_3_background_image;
				
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
			
			if(isset($_FILES['benefits_3_image_1']['name']) && !empty($_FILES['benefits_3_image_1']['name'])){
				$_FILES['benefits_3_image_1']['name'] = time().$_FILES['benefits_3_image_1']['name'];
				$benefits_3_image_1 = $_POST['benefits_3_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_3_image_1')){
					$image_data = $this->upload->data();
					$benefits_3_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_3_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_3_image_1;
				
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
			
			if(isset($_FILES['benefits_3_image_2']['name']) && !empty($_FILES['benefits_3_image_2']['name'])){
				$_FILES['benefits_3_image_2']['name'] = time().$_FILES['benefits_3_image_2']['name'];
				$benefits_3_image_2 = $_POST['benefits_3_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_3_image_2')){
					$image_data = $this->upload->data();
					$benefits_3_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_3_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_3_image_2;
				
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
			
			if(isset($_FILES['benefits_3_image_3']['name']) && !empty($_FILES['benefits_3_image_3']['name'])){
				$_FILES['benefits_3_image_3']['name'] = time().$_FILES['benefits_3_image_3']['name'];
				
				$benefits_3_image_3 = $_POST['benefits_3_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_3_image_3')){
					$image_data = $this->upload->data();
					$benefits_3_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_3_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_3_image_3;
				
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
			
		
		
		if(isset($_FILES['benefits_2_background_image']['name']) && !empty($_FILES['benefits_2_background_image']['name'])){
			$_FILES['benefits_2_background_image']['name'] = time().$_FILES['benefits_2_background_image']['name'];
				
				$benefits_2_background_image = $_POST['benefits_2_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_2_background_image')){
					$image_data = $this->upload->data();
					$benefits_2_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_2_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_2_background_image;
				
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
			
			if(isset($_FILES['benefits_2_image_1']['name']) && !empty($_FILES['benefits_2_image_1']['name'])){
				$_FILES['benefits_2_image_1']['name'] = time().$_FILES['benefits_2_image_1']['name'];
				$benefits_2_image_1 = $_POST['benefits_2_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_2_image_1')){
					$image_data = $this->upload->data();
					$benefits_2_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_2_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_2_image_1;
				
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
			
			if(isset($_FILES['benefits_2_image_2']['name']) && !empty($_FILES['benefits_2_image_2']['name'])){
				
				$_FILES['benefits_2_image_2']['name'] = time().$_FILES['benefits_2_image_2']['name'];
				
				$benefits_2_image_2 = $_POST['benefits_2_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_2_image_2')){
					$image_data = $this->upload->data();
					$benefits_2_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_2_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_2_image_2;
				
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
			
			if(isset($_FILES['benefits_2_image_3']['name']) && !empty($_FILES['benefits_2_image_3']['name'])){
				$_FILES['benefits_2_image_3']['name'] = time().$_FILES['benefits_2_image_3']['name'];
				$benefits_2_image_3 = $_POST['benefits_2_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_2_image_3')){
					$image_data = $this->upload->data();
					$benefits_2_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_2_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_2_image_3;
				
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
			
		
		
		if(isset($_FILES['statistics_background_image']['name']) && !empty($_FILES['statistics_background_image']['name'])){
			$_FILES['statistics_background_image']['name'] = time().$_FILES['statistics_background_image']['name'];
				$statistics_background_image = $_POST['statistics_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('statistics_background_image')){
					$image_data = $this->upload->data();
					$statistics_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$statistics_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$statistics_background_image;
				
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
			
			if(isset($_FILES['statistics_image_1']['name']) && !empty($_FILES['statistics_image_1']['name'])){
				$_FILES['statistics_image_1']['name'] = time().$_FILES['statistics_image_1']['name'];
				$statistics_image_1 = $_POST['statistics_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('statistics_image_1')){
					$image_data = $this->upload->data();
					$statistics_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$statistics_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$statistics_image_1;
				
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
			
			if(isset($_FILES['statistics_image_2']['name']) && !empty($_FILES['statistics_image_2']['name'])){
				$_FILES['statistics_image_2']['name'] = time().$_FILES['statistics_image_2']['name'];
				
				$statistics_image_2 = $_POST['statistics_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('statistics_image_2')){
					$image_data = $this->upload->data();
					$statistics_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$statistics_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$statistics_image_2;
				
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
			
			if(isset($_FILES['statistics_image_3']['name']) && !empty($_FILES['statistics_image_3']['name'])){
				$_FILES['statistics_image_3']['name'] = time().$_FILES['statistics_image_3']['name'];
				
				$statistics_image_3 = $_POST['statistics_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('statistics_image_3')){
					$image_data = $this->upload->data();
					$statistics_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$statistics_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$statistics_image_3;
				
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
			
		
		if(isset($_FILES['headling_background_image']['name']) && !empty($_FILES['headling_background_image']['name'])){
			$_FILES['headling_background_image']['name'] = time().$_FILES['headling_background_image']['name'];
				
				$headling_background_image = $_POST['headling_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('headling_background_image')){
					$image_data = $this->upload->data();
					$headling_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$headling_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$headling_background_image;
				
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
		if(isset($_FILES['benefits_background_image']['name']) && !empty($_FILES['benefits_background_image']['name'])){
			$_FILES['benefits_background_image']['name'] = time().$_FILES['benefits_background_image']['name'];
			
				$benefits_background_image = $_POST['benefits_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_background_image')){
					$image_data = $this->upload->data();
					$benefits_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_background_image;
				
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
			
			if(isset($_FILES['benefits_image_1']['name']) && !empty($_FILES['benefits_image_1']['name'])){
				$_FILES['benefits_image_1']['name'] = time().$_FILES['benefits_image_1']['name'];
			
				$benefits_image_1 = $_POST['benefits_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_image_1')){
					$image_data = $this->upload->data();
					$benefits_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_image_1;
				
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
			
			if(isset($_FILES['benefits_image_2']['name']) && !empty($_FILES['benefits_image_2']['name'])){
				$_FILES['benefits_image_2']['name'] = time().$_FILES['benefits_image_2']['name'];
			
				$benefits_image_2 = $_POST['benefits_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_image_2')){
					$image_data = $this->upload->data();
					$benefits_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_image_2;
				
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
			
			if(isset($_FILES['benefits_image_3']['name']) && !empty($_FILES['benefits_image_3']['name'])){
				$_FILES['benefits_image_3']['name'] = time().$_FILES['benefits_image_3']['name'];
			
				$benefits_image_3 = $_POST['benefits_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_image_3')){
					$image_data = $this->upload->data();
					$benefits_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_image_3;
				
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
		
		if(isset($_FILES['video_background_image']['name']) && !empty($_FILES['video_background_image']['name'])){
			$_FILES['video_background_image']['name'] = time().$_FILES['video_background_image']['name'];
			
				$video_background_image = $_POST['video_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('video_background_image')){
					$image_data = $this->upload->data();
					$video_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$video_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$video_background_image;
				
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
			
		if(isset($_FILES['action_background_image']['name']) && !empty($_FILES['action_background_image']['name'])){
			$_FILES['action_background_image']['name'] = time().$_FILES['action_background_image']['name'];
			
				$action_background_image = $_POST['action_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('action_background_image')){
					$image_data = $this->upload->data();
					$action_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$action_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$action_background_image;
				
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
			
			if(isset($_FILES['action_image_1']['name']) && !empty($_FILES['action_image_1']['name'])){
				$_FILES['action_image_1']['name'] = time().$_FILES['action_image_1']['name'];
				$action_image_1 = $_POST['action_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('action_image_1')){
					$image_data = $this->upload->data();
					$action_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$action_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$action_image_1;
				
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
			
			if(isset($_FILES['action_image_2']['name']) && !empty($_FILES['action_image_2']['name'])){
				$_FILES['action_image_2']['name'] = time().$_FILES['action_image_2']['name'];
				
				$action_image_2 = $_POST['action_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('action_image_2')){
					$image_data = $this->upload->data();
					$action_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$action_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$action_image_2;
				
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
			
			if(isset($_FILES['action_image_3']['name']) && !empty($_FILES['action_image_3']['name'])){
				$_FILES['action_image_3']['name'] = time().$_FILES['action_image_3']['name'];
				
				$action_image_3 = $_POST['action_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('action_image_3')){
					$image_data = $this->upload->data();
					$action_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$action_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$action_image_3;
				
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
			
		if(isset($_FILES['body_image']['name']) && !empty($_FILES['body_image']['name'])){
			$_FILES['body_image']['name'] = time().$_FILES['body_image']['name'];
				
				$body_image = $_POST['body_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('body_image')){
					$image_data = $this->upload->data();
					$body_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$body_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$body_image;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
		
			
					
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$body_image);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$body_image);
		
		
			}
		
		if(isset($_FILES['background_image']['name']) && !empty($_FILES['background_image']['name'])){
			$_FILES['background_image']['name'] = time().$_FILES['background_image']['name'];
			
				$background_image = $_POST['background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('background_image')){
					$image_data = $this->upload->data();
					$background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$background_image;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
					
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$background_image);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$background_image);
		
		
			}
			
		/**** header image ***/
			if(isset($_FILES['header_image']['name']) && !empty($_FILES['header_image']['name'])){
				$_FILES['header_image']['name'] = time().$_FILES['header_image']['name'];
			
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
				if ( $this->upload->do_upload('header_image')){
					$image_data = $this->upload->data();
					//echo '<pre>'; print_r($image_data); die;
					$header_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$header_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$header_image;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
					
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$header_image);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$header_image);
		
		
			}
			
			
			
			
			
			if(isset($_FILES['userfile_2']['name']) && !empty($_FILES['userfile_2']['name'])){
				$_FILES['userfile_2']['name'] = time().$_FILES['userfile_2']['name'];
			
				$image_2 = $_POST['userfile_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('userfile_2')){
					$image_data = $this->upload->data();
					$image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$image_2;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
					
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$image_2);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$image_2);
		
		
			}
		/** </code ****/
		
		$cat = $_POST['category'];	
	 
	if(!empty($image)){
			$this->load->model('upload_model');
			$path = "upload/programs/";
		if($a = $this->upload_model->upload_image($path)){					
			$data = array(
			'program' => $name,
			'buttonName' => $buttonName,
			'desc' => $desc,
			'photo' => $a,			
			'category' => $cat,
			'ages' => $ages,
			'features' => $features,
			'stand_alone_page' => $stand_alone_page,
			'video_type' => $video_type,
			'youtube_video' => $youtube_video,
			'vimeo_video' => $vimeo_video,
			'header_image' => $header_image,
			'body_id' => $body_id,
			'header_title' => $header_title,
			'header_desc' => $header_desc,
			'override_logo' => $override_logo,
			'landing_checkbox' => $landing_checkbox,
			'landing_program' => $landing_program,
			'landing_page_url' => $landing_page_url,
			'landing_program_id' => $landing_program_id,
			'stand_program_name' => $stand_program_name,
			'stand_program_ages' => $stand_program_ages,
			'image_video'=>$image_video,
			'image_alt' => $image_alt,
			'image' => $image_2,
			'program_slug' => $program_slug,
			'receive_class_button' => $receive_class_button,
			'receive_button_text' => $receive_button_text,
			'receive_button_link' => $receive_button_link,
			'mini_form_offer_title' => $mini_form_offer_title,
			'mini_form_offer_desc' => $mini_form_offer_desc,
			'mini_form_button1_text' => $mini_form_button1_text,
			'mini_form_button2_text' => $mini_form_button2_text,
			'trial_title' => $trial_title,
			'trial_desc' => $trial_desc,
			'meta_title' =>$meta_title,
					'background_color' =>$background_color,
					'background_image' =>$background_image,
					'body_title' =>$body_title,
					'body_desc' =>$body_desc,
					'body_img_position' =>$body_img_position,
					'body_image' =>$body_image,
					'action_title' =>$action_title,
					'action_desc' =>$action_desc,
					'action_background_image' =>$action_background_image,
					'action_background_color' =>$action_background_color,
					'action_headline_1' =>$action_headline_1,
					'action_image_1' =>$action_image_1,
					'action_headline_2' =>$action_headline_2,
					'action_image_2' =>$action_image_2,
					'action_headline_3' =>$action_headline_3,
					'action_image_3' =>$action_image_3,
					'action_desc_1' =>$action_desc_1,
					'action_desc_2' =>$action_desc_2,
					'action_desc_3' =>$action_desc_3,
					'video_background_image' =>$video_background_image,
					'video_background_color' =>$video_background_color,
					'benefits_title' =>$benefits_title,
					'benefits_desc' =>$benefits_desc,
					'benefits_background_image' =>$benefits_background_image,
					'benefits_background_color' =>$benefits_background_color,
					'benefits_headline_1' =>$benefits_headline_1,
					'benefits_image_1' =>$benefits_image_1,
					'benefits_headline_2' =>$benefits_headline_2,
					'benefits_image_2' =>$benefits_image_2,
					'benefits_headline_3' =>$benefits_headline_3,
					'benefits_image_3' =>$benefits_image_3,
					'headling_title' =>$headling_title,
					'headling_desc' =>$headling_desc,
					'headling_background_image' =>$headling_background_image,
					'headling_background_color' =>$headling_background_color,
					'headling_headline_1' =>$headling_headline_1,
					'headling_headline_2' =>$headling_headline_2,
					'headling_headline_3' =>$headling_headline_3,
					'statistics_title' =>$statistics_title,
					'statistics_desc' =>$statistics_desc,
					'statistics_background_image' =>$statistics_background_image,
					'statistics_background_color' =>$statistics_background_color,
					'statistics_headline_1' =>$statistics_headline_1,
					'statistics_image_1' =>$statistics_image_1,
					'statistics_headline_2' =>$statistics_headline_2,
					'statistics_image_2' =>$statistics_image_2,
					'statistics_headline_3' =>$statistics_headline_3,
					'statistics_image_3' =>$statistics_image_3,
					'statistics_desc_1' =>$statistics_desc_1,
					'statistics_desc_2' =>$statistics_desc_2,
					'statistics_desc_3' =>$statistics_desc_3,
					'benefits_2_title' =>$benefits_2_title,
					'benefits_2_desc' =>$benefits_2_desc,
					'benefits_2_background_image' =>$benefits_2_background_image,
					'benefits_2_background_color' =>$benefits_2_background_color,
					'benefits_2_headline_1' =>$benefits_2_headline_1,
					'benefits_2_image_1' =>$benefits_2_image_1,
					'benefits_2_headline_2' =>$benefits_2_headline_2,
					'benefits_2_image_2' =>$benefits_2_image_2,
					'benefits_2_headline_3' =>$benefits_2_headline_3,
					'benefits_2_image_3' =>$benefits_2_image_3,
					'benefits_2_desc_1' =>$benefits_2_desc_1,
					'benefits_2_desc_2' =>$benefits_2_desc_2,
					'benefits_2_desc_3' =>$benefits_2_desc_3,
					'show_full_form_1' =>$show_full_form_1,
					'show_full_form_2' =>$show_full_form_2,
					'opt1_text' =>$opt1_text,
					'opt_2_title' =>$opt_2_title,
					'opt_2_text' =>$opt_2_text,
					'benefits_3_title' =>$benefits_3_title,
					'benefits_3_desc' =>$benefits_3_desc,
					'benefits_3_background_image' =>$benefits_3_background_image,
					'benefits_3_background_color' =>$benefits_3_background_color,
					'benefits_3_headline_1' =>$benefits_3_headline_1,
					'benefits_3_image_1' =>$benefits_3_image_1,
					'benefits_3_headline_2' =>$benefits_3_headline_2,
					'benefits_3_image_2' =>$benefits_3_image_2,
					'benefits_3_headline_3' =>$benefits_3_headline_3,
					'benefits_3_image_3' =>$benefits_3_image_3,
					'white_stripe2_title' =>$white_stripe2_title,
					'white_stripe2_desc' =>$white_stripe2_desc,
					'white_stripe2_override_logo' =>$white_stripe2_override_logo,
					'white_stripe2_image' =>$white_stripe2_image,
					'show_learn_more' =>$show_learn_more,
					'white_stripe_background_color' =>$white_stripe_background_color,
					'program_cat_summary' =>$program_cat_summary,
					'program_cat_img_top_spacing' =>$program_cat_img_top_spacing,
					'program_cat_image' =>$program_cat_image,
					'scroll_top' =>$scroll_top,
					'testimonials_h2_text' =>$testimonials_h2_text,
					'testimonial_ids' =>$testimonial_ids,
					'html_editor' =>$html_editor,
					'video_title' =>$video_title,
					'video_desc' =>$video_desc,
					'opt1_title' => $opt1_title,
					'program_cat_image_alt_text' => $program_cat_image_alt_text,
					'header_image_alt_text' => $header_image_alt_text,
					'body_image_alt_text' => $body_image_alt_text,
					'benefits_image_1_alt_text' => $benefits_image_1_alt_text,
					'benefits_image_2_alt_text' => $benefits_image_2_alt_text,
					'benefits_image_3_alt_text' => $benefits_image_3_alt_text,
					'action_image_1_alt_text' => $action_image_1_alt_text,
					'action_image_2_alt_text' => $action_image_2_alt_text,
					'action_image_3_alt_text' => $action_image_3_alt_text,
					'statistics_image_1_alt_text' => $statistics_image_1_alt_text,
					'statistics_image_2_alt_text' => $statistics_image_2_alt_text,
					'statistics_image_3_alt_text' => $statistics_image_3_alt_text,
					'benefits_2_image_1_alt_text' => $benefits_2_image_1_alt_text,
					'benefits_2_image_2_alt_text' => $benefits_2_image_2_alt_text,
					'benefits_2_image_3_alt_text' => $benefits_2_image_3_alt_text,
					'white_stripe2_image_alt_text' => $white_stripe2_image_alt_text,
					'benefits_3_image_1_alt_text' => $benefits_3_image_1_alt_text,
					'benefits_3_image_2_alt_text' => $benefits_3_image_2_alt_text,
					'benefits_3_image_3_alt_text' => $benefits_3_image_3_alt_text,
					'faqs_h2_text' => $faqs_h2_text,
					'faq_ids' => $faq_ids,
					'program_type' => $program_type,
					'header_title_background_color' => $header_title_background_color,
					'show_override_logo' => $show_override_logo,
					'question_headline' => $question_headline,
					'featured_program_img' => $featured_program_img,
					'featured_program_img_alt_text' => $featured_program_img_alt_text,
					'opt1_submit_btn_text' => $opt1_submit_btn_text,
					'trial_offer_id' => $trial_offer_id,
					'redirection_type' => $redirection_type,
					'dojocart_id' => $dojocart_id,
					'third_party_url' => $third_party_url,
					'button1_redirection_type' => $button1_redirection_type,
					'button1_trial_offer_id' => $button1_trial_offer_id,
					'button1_dojocart_id' => $button1_dojocart_id,
					'button1_third_party_url' => $button1_third_party_url,
					'button2_redirection_type' => $button2_redirection_type,
					'button2_trial_offer_id' => $button2_trial_offer_id,
					'button2_dojocart_id' => $button2_dojocart_id,
					'button2_third_party_url' => $button2_third_party_url,
					'thankyou_page_id' => $thankyou_page_id,
					'button1_thankyou_page_id' => $button1_thankyou_page_id,
					'button2_thankyou_page_id' => $button2_thankyou_page_id,
					'connect_trial_offer_id' => $connect_trial_offer_id,
					'guests_values' => $guests_values,
					'show_location_type' => $show_location_type,
					'locations' => $locations,
					'cat_photo_side' => $cat_photo_side,
					'header_image_video' => $header_image_video,
					'header_video_type' => $header_video_type,
					'header_youtube_video' => $header_youtube_video,
					'header_vimeo_video' => $header_vimeo_video,
					'action_link_url_1' => $action_link_url_1,
					'action_link_url_2' => $action_link_url_2,
					'action_link_url_3' => $action_link_url_3,
					'meta_desc' => $meta_desc,
			);
			
			if($trials){						
				$data=array_merge($data, array('trial' => $trials));
			}
		if($this->query_model->insertData($this->table,$data)):
			$program_id = $this->db->insert_id();
			if(isset($_POST['action_type']) && $_POST['action_type'] == "save_and_continue"){
				redirect("admin/programs/edit/".$program_id.'/view/'.$cat);
			}else{
				redirect("admin/programs/".$_POST['redirect']);
			}
		endif;
		}
		else{
		 		$error = strip_tags($this->upload->display_errors());
				echo '<script>alert("'.$error.'");</script>';
		  }
	}else{
		
		$data = array(
			'program' => $name,
			'buttonName' => $buttonName,
			'desc' => $desc,
			'trial' => $trials,
			'category' => $cat,
			'ages' => $ages,
			'features' => $features,
			'stand_alone_page' => $stand_alone_page,
			'video_type' => $video_type,
			'youtube_video' => $youtube_video,
			'vimeo_video' => $vimeo_video,
			'header_image' => $header_image,
			'body_id' => $body_id,
			'header_title' => $header_title,
			'header_desc' => $header_desc,
			'override_logo' => $override_logo,
			'landing_checkbox' => $landing_checkbox,
			'landing_program' => $landing_program,
			'landing_page_url' => $landing_page_url,
			'landing_program_id' => $landing_program_id,
			'stand_program_name' => $stand_program_name,
			'stand_program_ages' => $stand_program_ages,
			'image_video'=>$image_video,
			'image_alt' => $image_alt,
			'image' => $image_2,
			'program_slug' => $program_slug,
			'receive_class_button' => $receive_class_button,
			'receive_button_text' => $receive_button_text,
			'receive_button_link' => $receive_button_link,
			'mini_form_offer_title' => $mini_form_offer_title,
			'mini_form_offer_desc' => $mini_form_offer_desc,
			'mini_form_button1_text' => $mini_form_button1_text,
			'mini_form_button2_text' => $mini_form_button2_text,
			'trial_title' => $trial_title,
			'trial_desc' => $trial_desc,
			'meta_title' =>$meta_title,
					'background_color' =>$background_color,
					'background_image' =>$background_image,
					'body_title' =>$body_title,
					'body_desc' =>$body_desc,
					'body_img_position' =>$body_img_position,
					'body_image' =>$body_image,
					'action_title' =>$action_title,
					'action_desc' =>$action_desc,
					'action_background_image' =>$action_background_image,
					'action_background_color' =>$action_background_color,
					'action_headline_1' =>$action_headline_1,
					'action_image_1' =>$action_image_1,
					'action_headline_2' =>$action_headline_2,
					'action_image_2' =>$action_image_2,
					'action_headline_3' =>$action_headline_3,
					'action_image_3' =>$action_image_3,
					'action_desc_1' =>$action_desc_1,
					'action_desc_2' =>$action_desc_2,
					'action_desc_3' =>$action_desc_3,
					'video_background_image' =>$video_background_image,
					'video_background_color' =>$video_background_color,
					'benefits_title' =>$benefits_title,
					'benefits_desc' =>$benefits_desc,
					'benefits_background_image' =>$benefits_background_image,
					'benefits_background_color' =>$benefits_background_color,
					'benefits_headline_1' =>$benefits_headline_1,
					'benefits_image_1' =>$benefits_image_1,
					'benefits_headline_2' =>$benefits_headline_2,
					'benefits_image_2' =>$benefits_image_2,
					'benefits_headline_3' =>$benefits_headline_3,
					'benefits_image_3' =>$benefits_image_3,
					'headling_title' =>$headling_title,
					'headling_desc' =>$headling_desc,
					'headling_background_image' =>$headling_background_image,
					'headling_background_color' =>$headling_background_color,
					'headling_headline_1' =>$headling_headline_1,
					'headling_headline_2' =>$headling_headline_2,
					'headling_headline_3' =>$headling_headline_3,
					'statistics_title' =>$statistics_title,
					'statistics_desc' =>$statistics_desc,
					'statistics_background_image' =>$statistics_background_image,
					'statistics_background_color' =>$statistics_background_color,
					'statistics_headline_1' =>$statistics_headline_1,
					'statistics_image_1' =>$statistics_image_1,
					'statistics_headline_2' =>$statistics_headline_2,
					'statistics_image_2' =>$statistics_image_2,
					'statistics_headline_3' =>$statistics_headline_3,
					'statistics_image_3' =>$statistics_image_3,
					'statistics_desc_1' =>$statistics_desc_1,
					'statistics_desc_2' =>$statistics_desc_2,
					'statistics_desc_3' =>$statistics_desc_3,
					'benefits_2_title' =>$benefits_2_title,
					'benefits_2_desc' =>$benefits_2_desc,
					'benefits_2_background_image' =>$benefits_2_background_image,
					'benefits_2_background_color' =>$benefits_2_background_color,
					'benefits_2_headline_1' =>$benefits_2_headline_1,
					'benefits_2_image_1' =>$benefits_2_image_1,
					'benefits_2_headline_2' =>$benefits_2_headline_2,
					'benefits_2_image_2' =>$benefits_2_image_2,
					'benefits_2_headline_3' =>$benefits_2_headline_3,
					'benefits_2_image_3' =>$benefits_2_image_3,
					'benefits_2_desc_1' =>$benefits_2_desc_1,
					'benefits_2_desc_2' =>$benefits_2_desc_2,
					'benefits_2_desc_3' =>$benefits_2_desc_3,
					'show_full_form_1' =>$show_full_form_1,
					'show_full_form_2' =>$show_full_form_2,
					'opt1_text' =>$opt1_text,
					'opt_2_title' =>$opt_2_title,
					'opt_2_text' =>$opt_2_text,
					'benefits_3_title' =>$benefits_3_title,
					'benefits_3_desc' =>$benefits_3_desc,
					'benefits_3_background_image' =>$benefits_3_background_image,
					'benefits_3_background_color' =>$benefits_3_background_color,
					'benefits_3_headline_1' =>$benefits_3_headline_1,
					'benefits_3_image_1' =>$benefits_3_image_1,
					'benefits_3_headline_2' =>$benefits_3_headline_2,
					'benefits_3_image_2' =>$benefits_3_image_2,
					'benefits_3_headline_3' =>$benefits_3_headline_3,
					'benefits_3_image_3' =>$benefits_3_image_3,
					'white_stripe2_title' =>$white_stripe2_title,
					'white_stripe2_desc' =>$white_stripe2_desc,
					'white_stripe2_override_logo' =>$white_stripe2_override_logo,
					'white_stripe2_image' =>$white_stripe2_image,
					'show_learn_more' =>$show_learn_more,
					'white_stripe_background_color' =>$white_stripe_background_color,
					'program_cat_summary' =>$program_cat_summary,
					'program_cat_img_top_spacing' =>$program_cat_img_top_spacing,
					'program_cat_image' =>$program_cat_image,
					'scroll_top' =>$scroll_top,
					'testimonials_h2_text' =>$testimonials_h2_text,
					'testimonial_ids' =>$testimonial_ids,
					'html_editor' =>$html_editor,
					'video_title' =>$video_title,
					'video_desc' =>$video_desc,
					'opt1_title' => $opt1_title,
					'program_cat_image_alt_text' => $program_cat_image_alt_text,
					'header_image_alt_text' => $header_image_alt_text,
					'body_image_alt_text' => $body_image_alt_text,
					'benefits_image_1_alt_text' => $benefits_image_1_alt_text,
					'benefits_image_2_alt_text' => $benefits_image_2_alt_text,
					'benefits_image_3_alt_text' => $benefits_image_3_alt_text,
					'action_image_1_alt_text' => $action_image_1_alt_text,
					'action_image_2_alt_text' => $action_image_2_alt_text,
					'action_image_3_alt_text' => $action_image_3_alt_text,
					'statistics_image_1_alt_text' => $statistics_image_1_alt_text,
					'statistics_image_2_alt_text' => $statistics_image_2_alt_text,
					'statistics_image_3_alt_text' => $statistics_image_3_alt_text,
					'benefits_2_image_1_alt_text' => $benefits_2_image_1_alt_text,
					'benefits_2_image_2_alt_text' => $benefits_2_image_2_alt_text,
					'benefits_2_image_3_alt_text' => $benefits_2_image_3_alt_text,
					'white_stripe2_image_alt_text' => $white_stripe2_image_alt_text,
					'benefits_3_image_1_alt_text' => $benefits_3_image_1_alt_text,
					'benefits_3_image_2_alt_text' => $benefits_3_image_2_alt_text,
					'benefits_3_image_3_alt_text' => $benefits_3_image_3_alt_text,
					'faqs_h2_text' => $faqs_h2_text,
					'faq_ids' => $faq_ids,
					'program_type' => $program_type,
					'header_title_background_color' => $header_title_background_color,
					'show_override_logo' => $show_override_logo,
					'question_headline' => $question_headline,
					'featured_program_img' => $featured_program_img,
					'featured_program_img_alt_text' => $featured_program_img_alt_text,
					'opt1_submit_btn_text' => $opt1_submit_btn_text,
					'trial_offer_id' => $trial_offer_id,
					'redirection_type' => $redirection_type,
					'dojocart_id' => $dojocart_id,
					'third_party_url' => $third_party_url,
					'button1_redirection_type' => $button1_redirection_type,
					'button1_trial_offer_id' => $button1_trial_offer_id,
					'button1_dojocart_id' => $button1_dojocart_id,
					'button1_third_party_url' => $button1_third_party_url,
					'button2_redirection_type' => $button2_redirection_type,
					'button2_trial_offer_id' => $button2_trial_offer_id,
					'button2_dojocart_id' => $button2_dojocart_id,
					'button2_third_party_url' => $button2_third_party_url,
					'thankyou_page_id' => $thankyou_page_id,
					'button1_thankyou_page_id' => $button1_thankyou_page_id,
					'button2_thankyou_page_id' => $button2_thankyou_page_id,
					'connect_trial_offer_id' => $connect_trial_offer_id,
					'guests_values' => $guests_values,
					'show_location_type' => $show_location_type,
					'locations' => $locations,
					'cat_photo_side' => $cat_photo_side,
					'header_image_video' => $header_image_video,
					'header_video_type' => $header_video_type,
					'header_youtube_video' => $header_youtube_video,
					'header_vimeo_video' => $header_vimeo_video,
					'action_link_url_1' => $action_link_url_1,
					'action_link_url_2' => $action_link_url_2,
					'action_link_url_3' => $action_link_url_3,
					'meta_desc' => $meta_desc,
			);
		if($this->query_model->insertData($this->table,$data)):
			$program_id = $this->db->insert_id();
			if(isset($_POST['action_type']) && $_POST['action_type'] == "save_and_continue"){
				redirect("admin/programs/edit/".$program_id.'/view/'.$cat);
			}else{
				redirect("admin/programs/".$_POST['redirect']);
			}
		endif;
	}
	
	}
	
	function updateProgram(){
		//echo '<pre>'; print_r($_FILES);
		//echo '<pre>POST'; print_r($_POST); die;
		$this->load->helper(array('url'));
		
		$metaVaribles = $this->query_model->getbyTable("tblmetavariable");
		
		
		if(isset($_POST['data'])){
			$this->query_model->deletebySpecific('tblstandpage','program_id',$_POST['program_id']);
			$i = 1;
			foreach($_POST['data'] as $standPage){
				$data['title'] = $standPage['title'];
				$data['desc'] = $standPage['desc'];
				$data['background_color'] = $standPage['background_color'];
				$data['program_id'] = $_POST['program_id'];
				if(isset($standPage['last_stand_photo'])){
					$data['stand_page_photo'] = $standPage['last_stand_photo'];
				}
				$image_name = 'stand_page_photo'.$i;
				$myImage = isset($_FILES['stand_page_photo'.$i]) ? $_FILES['stand_page_photo'.$i] : '';
				
			//	if( isset($_FILES[$image_name]['name']) && !empty($_FILES[$image_name]['name'])){
				if(isset($myImage['name']) && !empty($myImage['name']) && $myImage['name'] != ''){
				$_FILES[$image_name]['name'] = time().$_FILES[$image_name]['name'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload($image_name)){
					$image_data = $this->upload->data();
					$data['stand_page_photo'] = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$data['stand_page_photo'];
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$data['stand_page_photo'];
				
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
		
			} else{
					if(!empty($standPage['last_stand_photo'])){
						$data['stand_page_photo'] = $standPage['last_stand_photo'];
					} else{
						$data['stand_page_photo'] = '';
					}
				}
				$this->query_model->insertData('tblstandpage', $data);
				$i++;
			} //die;
			
		}
	
		$name = trim ($_POST['name']);
		$buttonName = trim ($_POST['btnname']);
		$ages = $_POST['ages'];
		$features = serialize($_POST['features']);
		$stand_alone_page = $_POST['stand_alone_page'];
		$video_type = $_POST['video_type'];
		$youtube_video = $_POST['youtube_video'];
		$vimeo_video = $_POST['vimeo_video'];
		$content = $_POST['text'];		
		$desc = htmlentities($content);
		$body_id = $_POST['body_id'];
		$header_title = $_POST['header_title'];
		$header_desc = $_POST['header_desc'];
		$override_logo = $_POST['override_logo'];
		$landing_checkbox = $_POST['landing_checkbox'];
		$landing_program = $_POST['landing_program'];
		$landing_page_url = $_POST['landing_page_url'];
		$landing_program_id = !empty($_POST['landing_program_id'])?$_POST['landing_program_id']:'';
		$stand_program_name = $_POST['stand_program_name'];
		$stand_program_ages = $_POST['stand_program_ages'];
		$progam_id = $_POST['program_id'];
		
		$mini_form_offer_title = $_POST['mini_form_offer_title'];
		$mini_form_offer_desc = $_POST['mini_form_offer_desc'];
		$mini_form_button1_text = $_POST['mini_form_button1_text'];
		$mini_form_button2_text = $_POST['mini_form_button2_text'];
        $trial_title = $_POST['trial_title'];
		$trial_desc = $_POST['trial_desc'];
		
		
	
		$meta_title = !empty($_POST['meta_title']) ? $_POST['meta_title'] : $metaVaribles[0]->meta_school_name.' | '.$name.' in '.$metaVaribles[0]->meta_city.', '.$metaVaribles[0]->meta_state;
		
		
		$meta_desc = !empty($_POST['meta_desc']) ? $_POST['meta_desc'] : '';
		//echo '<pre>metaVaribles'; print_r($metaVaribles);
		//echo $meta_title; die;
                $receive_class_button = 0;
                if(isset($_POST['receive_class_button'])){
                    $receive_class_button = $_POST['receive_class_button'];
                }
                $receive_button_text = isset($_POST['receive_button_text'])?$_POST['receive_button_text']:'';
                $receive_button_link = isset($_POST['receive_button_link'])?$_POST['receive_button_link']:'';
                
                
		
		if(!empty($_POST['slug'])){
				//$program_slug = strtolower(str_replace(' ','-',$_POST['slug']));
				$replce_slug = preg_replace("/[^A-Za-z0-9\- ]/", "",$_POST['slug']);
				$slug = str_replace(' ', '-',strtolower($replce_slug));
				$program_slug = str_replace('--', '-',strtolower($slug));
		}else{
				//$program_slug = strtolower(str_replace(' ','-',$_POST['name']));
				$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "",$name);
				$slug = str_replace(' ', '-',strtolower($replce_slug));
				$program_slug = str_replace('--', '-',strtolower($slug));
		}
		
		
		//$checkSlug = $this->query_model->getbySpecific('')
		//echo $program_slug; die;
		$image_video = isset($_POST['image_video']) ? $_POST['image_video'] : '';
		$image_alt = isset($_POST['image_alt']) ? $_POST['image_alt'] : '';
		
		// code for update featured program
		$prog_slug = $this->query_model->getbySpecific('tblmeta', 'id', 30);// get program slug
		$prog_slug = $prog_slug[0];
		
		$feat_program_url = '';
		if($_POST['landing_checkbox'] == 1){ // landing checkbox status
			if(!empty($_POST['landing_program'])){
				$feat_program_url = $_POST['landing_program'];
			}elseif(!empty($_POST['landing_page_url'])){
				$feat_program_url = $_POST['landing_page_url'];
			}
		}else{
			$cateogry_detail = $this->query_model->getbySpecific('tblcategory','cat_id', $_POST['category']);
			//$feat_program_url = base_url().$prog_slug->slug.'/program/'.$progam_id.'/'.str_replace(' ','-',$name);
			$feat_program_url = base_url().$prog_slug->slug.'/'.$cateogry_detail[0]->cat_slug.'/'.$program_slug;
		}
		
		$featured_program_data = array('program_url' => $feat_program_url);
		$this->query_model->updateData('tblfeaturedprogram','program_id', $progam_id, $featured_program_data);
		
		
		
		//$_FILES['userfile']['name'] = time().$_FILES['userfile']['name'];
		$image = isset($_FILES['userfile']['name'])?$_FILES['userfile']['name']:'';
		
		$image_2 = isset($_POST['last-photo-2']) ? $_POST['last-photo-2'] : '';
		//$_FILES['header_image']['name'] = time().$_FILES['header_image']['name'];
		$header_image = $_POST['last_header_image'];
		$trials = $error = 0;
		if(isset($_POST['trials'])){
			$trials = $_POST['trials'];
		}
		
		$background_color = isset($_POST['background_color']) ? $_POST['background_color'] : '';
		$background_image = isset($_POST['last-background_image']) ? $_POST['last-background_image'] : '';
		$body_title = isset($_POST['body_title']) ? $_POST['body_title'] : '';
		$body_desc = isset($_POST['body_desc']) ? $_POST['body_desc'] : '';
		$body_img_position = isset($_POST['body_img_position']) ? $_POST['body_img_position'] : '';
		$body_image = isset($_POST['last-body_image']) ? $_POST['last-body_image'] : '';
		$action_title = isset($_POST['action_title']) ? $_POST['action_title'] : '';
		$action_desc = isset($_POST['action_desc']) ? $_POST['action_desc'] : '';
		$action_background_image = isset($_POST['last-action_background_image']) ? $_POST['last-action_background_image'] : '';
		$action_background_color = isset($_POST['action_background_color']) ? $_POST['action_background_color'] : '';
		$action_headline_1 = isset($_POST['action_headline_1']) ? $_POST['action_headline_1'] : '';
		$action_image_1 = isset($_POST['last-action_image_1']) ? $_POST['last-action_image_1'] : '';
		$action_headline_2 = isset($_POST['action_headline_2']) ? $_POST['action_headline_2'] : '';
		$action_image_2 = isset($_POST['last-action_image_2']) ? $_POST['last-action_image_2'] : '';
		$action_headline_3 = isset($_POST['action_headline_3']) ? $_POST['action_headline_3'] : '';
		$action_image_3 = isset($_POST['last-action_image_3']) ? $_POST['last-action_image_3'] : '';
		$action_desc_1 = isset($_POST['action_desc_1']) ? $_POST['action_desc_1'] : '';
		$action_desc_2 = isset($_POST['action_desc_2']) ? $_POST['action_desc_2'] : '';
		$action_desc_3 = isset($_POST['action_desc_3']) ? $_POST['action_desc_3'] : '';
		
		$video_background_image = isset($_POST['last-video_background_image']) ? $_POST['last-video_background_image'] : '';
		$video_background_color = isset($_POST['video_background_color']) ? $_POST['video_background_color'] : '';
		
		$benefits_title = isset($_POST['benefits_title']) ? $_POST['benefits_title'] : '';
		$benefits_desc = isset($_POST['benefits_desc']) ? $_POST['benefits_desc'] : '';
		$benefits_background_image = isset($_POST['last-benefits_background_image']) ? $_POST['last-benefits_background_image'] : '';
		$benefits_background_color = isset($_POST['benefits_background_color']) ? $_POST['benefits_background_color'] : '';
		
		$benefits_headline_1 = isset($_POST['benefits_headline_1']) ? $_POST['benefits_headline_1'] : '';
		$benefits_image_1 = isset($_POST['last-benefits_image_1']) ? $_POST['last-benefits_image_1'] : '';
		$benefits_headline_2 = isset($_POST['benefits_headline_2']) ? $_POST['benefits_headline_2'] : '';
		$benefits_image_2 = isset($_POST['last-benefits_image_2']) ? $_POST['last-benefits_image_2'] : '';
		$benefits_headline_3 = isset($_POST['benefits_headline_3']) ? $_POST['benefits_headline_3'] : '';
		$benefits_image_3 = isset($_POST['last-benefits_image_3']) ? $_POST['last-benefits_image_3'] : '';
		
		$headling_title = isset($_POST['headling_title']) ? $_POST['headling_title'] : '';
		$headling_desc = isset($_POST['headling_desc']) ? $_POST['headling_desc'] : '';
		$headling_background_image = isset($_POST['last-headling_background_image']) ? $_POST['last-headling_background_image'] : '';
		$headling_background_color = isset($_POST['headling_background_color']) ? $_POST['headling_background_color'] : '';
		
		$headling_headline_1 = isset($_POST['headling_headline_1']) ? $_POST['headling_headline_1'] : '';
		$headling_headline_2 = isset($_POST['headling_headline_2']) ? $_POST['headling_headline_2'] : '';
		$headling_headline_3 = isset($_POST['headling_headline_3']) ? $_POST['headling_headline_3'] : '';
		
		$statistics_title = isset($_POST['statistics_title']) ? $_POST['statistics_title'] : '';
		$statistics_desc = isset($_POST['statistics_desc']) ? $_POST['statistics_desc'] : '';
		$statistics_background_image = isset($_POST['last-statistics_background_image']) ? $_POST['last-statistics_background_image'] : '';
		$statistics_background_color = isset($_POST['statistics_background_color']) ? $_POST['statistics_background_color'] : '';
		$statistics_headline_1 = isset($_POST['statistics_headline_1']) ? $_POST['statistics_headline_1'] : '';
		$statistics_image_1 = isset($_POST['last-statistics_image_1']) ? $_POST['last-statistics_image_1'] : '';
		$statistics_headline_2 = isset($_POST['statistics_headline_2']) ? $_POST['statistics_headline_2'] : '';
		$statistics_image_2 = isset($_POST['last-statistics_image_2']) ? $_POST['last-statistics_image_2'] : '';
		$statistics_headline_3 = isset($_POST['statistics_headline_3']) ? $_POST['statistics_headline_3'] : '';
		$statistics_image_3 = isset($_POST['last-statistics_image_3']) ? $_POST['last-statistics_image_3'] : '';
		$statistics_desc_1 = isset($_POST['statistics_desc_1']) ? $_POST['statistics_desc_1'] : '';
		$statistics_desc_2 = isset($_POST['statistics_desc_2']) ? $_POST['statistics_desc_2'] : '';
		$statistics_desc_3 = isset($_POST['statistics_desc_3']) ? $_POST['statistics_desc_3'] : '';
		
		$benefits_2_title = isset($_POST['benefits_2_title']) ? $_POST['benefits_2_title'] : '';
		$benefits_2_desc = isset($_POST['benefits_2_desc']) ? $_POST['benefits_2_desc'] : '';
		$benefits_2_background_image = isset($_POST['last-benefits_2_background_image']) ? $_POST['last-benefits_2_background_image'] : '';
		$benefits_2_background_color = isset($_POST['benefits_2_background_color']) ? $_POST['benefits_2_background_color'] : '';
		$benefits_2_headline_1 = isset($_POST['benefits_2_headline_1']) ? $_POST['benefits_2_headline_1'] : '';
		$benefits_2_image_1 = isset($_POST['last-benefits_2_image_1']) ? $_POST['last-benefits_2_image_1'] : '';
		$benefits_2_headline_2 = isset($_POST['benefits_2_headline_2']) ? $_POST['benefits_2_headline_2'] : '';
		$benefits_2_image_2 = isset($_POST['last-benefits_2_image_2']) ? $_POST['last-benefits_2_image_2'] : '';
		$benefits_2_headline_3 = isset($_POST['benefits_2_headline_3']) ? $_POST['benefits_2_headline_3'] : '';
		$benefits_2_image_3 = isset($_POST['last-benefits_2_image_3']) ? $_POST['last-benefits_2_image_3'] : '';
		$benefits_2_desc_1 = isset($_POST['benefits_2_desc_1']) ? $_POST['benefits_2_desc_1'] : '';
		$benefits_2_desc_2 = isset($_POST['benefits_2_desc_2']) ? $_POST['benefits_2_desc_2'] : '';
		$benefits_2_desc_3 = isset($_POST['benefits_2_desc_3']) ? $_POST['benefits_2_desc_3'] : '';
		
		$show_full_form_1 = isset($_POST['show_full_form_1']) ? $_POST['show_full_form_1'] : 0;
		$show_full_form_2 = isset($_POST['show_full_form_2']) ? $_POST['show_full_form_2'] : 0;
		$opt1_text = isset($_POST['opt1_text']) ? $_POST['opt1_text'] : '';
		$opt_2_title = isset($_POST['opt_2_title']) ? $_POST['opt_2_title'] : '';
		$opt_2_text = isset($_POST['opt_2_text']) ? $_POST['opt_2_text'] : '';
		$benefits_3_title = isset($_POST['benefits_3_title']) ? $_POST['benefits_3_title'] : '';
		$benefits_3_desc = isset($_POST['benefits_3_desc']) ? $_POST['benefits_3_desc'] : '';
		$benefits_3_background_image = isset($_POST['benefits_3_background_image']) ? $_POST['benefits_3_background_image'] : '';
		$benefits_3_background_color = isset($_POST['benefits_3_background_color']) ? $_POST['benefits_3_background_color'] : '';
		$benefits_3_headline_1 = isset($_POST['benefits_3_headline_1']) ? $_POST['benefits_3_headline_1'] : '';
		$benefits_3_image_1 = isset($_POST['benefits_3_image_1']) ? $_POST['benefits_3_image_1'] : '';
		$benefits_3_headline_2 = isset($_POST['benefits_3_headline_2']) ? $_POST['benefits_3_headline_2'] : '';
		$benefits_3_image_2 = isset($_POST['benefits_3_image_2']) ? $_POST['benefits_3_image_2'] : '';
		$benefits_3_headline_3 = isset($_POST['benefits_3_headline_3']) ? $_POST['benefits_3_headline_3'] : '';
		$benefits_3_image_3 = isset($_POST['benefits_3_image_3']) ? $_POST['benefits_3_image_3'] : '';
		$white_stripe2_title = isset($_POST['white_stripe2_title']) ? $_POST['white_stripe2_title'] : '';
		$white_stripe2_desc = isset($_POST['white_stripe2_desc']) ? $_POST['white_stripe2_desc'] : '';
		$white_stripe2_override_logo = isset($_POST['white_stripe2_override_logo']) ? $_POST['white_stripe2_override_logo'] : 0;
		$white_stripe2_image = isset($_POST['last-white_stripe2_image']) ? $_POST['last-white_stripe2_image'] : '';
		$show_learn_more = isset($_POST['show_learn_more']) ? $_POST['show_learn_more'] : 0;
		$white_stripe_background_color = isset($_POST['white_stripe_background_color']) ? $_POST['white_stripe_background_color'] : '';
		$program_cat_summary = isset($_POST['program_cat_summary']) ? $_POST['program_cat_summary'] : '';
		$program_cat_img_top_spacing = isset($_POST['program_cat_img_top_spacing']) ? $_POST['program_cat_img_top_spacing'] : '';
		$program_cat_image = isset($_POST['last-program_cat_image']) ? $_POST['last-program_cat_image'] : '';
		$scroll_top = isset($_POST['scroll_top']) ? $_POST['scroll_top'] : 200;
		
		$testimonials_h2_text = isset($_POST['testimonials_h2_text']) ? $_POST['testimonials_h2_text'] : '';
		$testimonial_ids = isset($_POST['testimonial_ids']) ? serialize($_POST['testimonial_ids']) : '';
		
		$html_editor = isset($_POST['html_editor']) ? $_POST['html_editor'] : '';
		$video_title = isset($_POST['video_title']) ? $_POST['video_title'] : '';
		$video_desc = isset($_POST['video_desc']) ? $_POST['video_desc'] : '';
		
		$opt1_title = isset($_POST['opt1_title']) ? $_POST['opt1_title'] : '';
		
		
		$program_cat_image_alt_text = isset($_POST['program_cat_image_alt_text']) ? $_POST['program_cat_image_alt_text'] : '';
		$header_image_alt_text = isset($_POST['header_image_alt_text']) ? $_POST['header_image_alt_text'] : '';
		$body_image_alt_text = isset($_POST['body_image_alt_text']) ? $_POST['body_image_alt_text'] : '';
		$benefits_image_1_alt_text = isset($_POST['benefits_image_1_alt_text']) ? $_POST['benefits_image_1_alt_text'] : '';
		$benefits_image_2_alt_text = isset($_POST['benefits_image_2_alt_text']) ? $_POST['benefits_image_2_alt_text'] : '';
		$benefits_image_3_alt_text = isset($_POST['benefits_image_3_alt_text']) ? $_POST['benefits_image_3_alt_text'] : '';
		$action_image_1_alt_text = isset($_POST['action_image_1_alt_text']) ? $_POST['action_image_1_alt_text'] : '';
		$action_image_2_alt_text = isset($_POST['action_image_2_alt_text']) ? $_POST['action_image_2_alt_text'] : '';
		$action_image_3_alt_text = isset($_POST['action_image_3_alt_text']) ? $_POST['action_image_3_alt_text'] : '';
		$statistics_image_1_alt_text = isset($_POST['statistics_image_1_alt_text']) ? $_POST['statistics_image_1_alt_text'] : '';
		$statistics_image_2_alt_text = isset($_POST['statistics_image_2_alt_text']) ? $_POST['statistics_image_2_alt_text'] : '';
		$statistics_image_3_alt_text = isset($_POST['statistics_image_3_alt_text']) ? $_POST['statistics_image_3_alt_text'] : '';
		$benefits_2_image_1_alt_text = isset($_POST['benefits_2_image_1_alt_text']) ? $_POST['benefits_2_image_1_alt_text'] : '';
		$benefits_2_image_2_alt_text = isset($_POST['benefits_2_image_2_alt_text']) ? $_POST['benefits_2_image_2_alt_text'] : '';
		$benefits_2_image_3_alt_text = isset($_POST['benefits_2_image_3_alt_text']) ? $_POST['benefits_2_image_3_alt_text'] : '';
		$white_stripe2_image_alt_text = isset($_POST['white_stripe2_image_alt_text']) ? $_POST['white_stripe2_image_alt_text'] : '';
		$benefits_3_image_1_alt_text = isset($_POST['benefits_3_image_1_alt_text']) ? $_POST['benefits_3_image_1_alt_text'] : '';
		$benefits_3_image_2_alt_text = isset($_POST['benefits_3_image_2_alt_text']) ? $_POST['benefits_3_image_2_alt_text'] : '';
		$benefits_3_image_3_alt_text = isset($_POST['benefits_3_image_3_alt_text']) ? $_POST['benefits_3_image_3_alt_text'] : '';
		
		$faqs_h2_text = (isset($_POST['faqs_h2_text']) && !empty($_POST['faqs_h2_text'])) ? $_POST['faqs_h2_text'] : 'Frequently Asked Questions';
		$faq_ids = isset($_POST['faq_ids']) ? serialize($_POST['faq_ids']) : '';
		$program_type = isset($_POST['program_type']) ? $_POST['program_type'] : 'program_page';
		$header_title_background_color = isset($_POST['header_title_background_color']) ? $_POST['header_title_background_color'] : '';
		$show_override_logo = isset($_POST['show_override_logo']) ? $_POST['show_override_logo'] : 0;
		$question_headline = isset($_POST['question_headline']) ? $_POST['question_headline'] : '';
		$featured_program_img = isset($_POST['featured_program_img']) ? $_POST['featured_program_img'] : '';
		$featured_program_img_alt_text = isset($_POST['featured_program_img_alt_text']) ? $_POST['featured_program_img_alt_text'] : '';
		$opt1_submit_btn_text = isset($_POST['opt1_submit_btn_text']) ? $_POST['opt1_submit_btn_text'] : '';
		$trial_offer_id = (isset($_POST['trial_offer_id']) && !empty($_POST['trial_offer_id'])) ? $_POST['trial_offer_id'] : 0;
		
		$redirection_type = isset($_POST['redirection_type']) ? $_POST['redirection_type'] : 'trial_offer';
		$dojocart_id = isset($_POST['dojocart_id']) ? $_POST['dojocart_id'] : 0;
		$third_party_url = isset($_POST['third_party_url']) ? $_POST['third_party_url'] : '';
		
		
		$button1_redirection_type = isset($_POST['button1_redirection_type']) ? $_POST['button1_redirection_type'] : 'trial_offer';
		$button1_trial_offer_id = (isset($_POST['button1_trial_offer_id']) && !empty($_POST['button1_trial_offer_id'])) ? $_POST['button1_trial_offer_id'] : 0;
		$button1_dojocart_id = isset($_POST['button1_dojocart_id']) ? $_POST['button1_dojocart_id'] : 0;
		$button1_third_party_url = isset($_POST['button1_third_party_url']) ? $_POST['button1_third_party_url'] : '';
		
		$button2_redirection_type = isset($_POST['button2_redirection_type']) ? $_POST['button2_redirection_type'] : 'trial_offer';
		$button2_trial_offer_id = (isset($_POST['button2_trial_offer_id']) && !empty($_POST['button2_trial_offer_id'])) ? $_POST['button2_trial_offer_id'] : 0;
		$button2_dojocart_id = isset($_POST['button2_dojocart_id']) ? $_POST['button2_dojocart_id'] : 0;
		$button2_third_party_url = isset($_POST['button2_third_party_url']) ? $_POST['button2_third_party_url'] : '';
		$thankyou_page_id = isset($_POST['thankyou_page_id']) ? $_POST['thankyou_page_id'] : 0;
		$button1_thankyou_page_id = isset($_POST['button1_thankyou_page_id']) ? $_POST['button1_thankyou_page_id'] : 0;
		$button2_thankyou_page_id = isset($_POST['button2_thankyou_page_id']) ? $_POST['button2_thankyou_page_id'] : 0;
		$connect_trial_offer_id = (isset($_POST['connect_trial_offer_id']) && !empty($_POST['connect_trial_offer_id'])) ? $_POST['connect_trial_offer_id'] : 0;
		$guests_values = (isset($_POST['guests_values']) && !empty($_POST['guests_values'])) ? serialize($_POST['guests_values']) : '';
		$show_location_type = (isset($_POST['show_location_type']) && !empty($_POST['show_location_type'])) ? $_POST['show_location_type'] : 'show_all';
		$locations = (isset($_POST['locations']) && !empty($_POST['locations'])) ? serialize($_POST['locations']) : '';
		$cat_photo_side = (isset($_POST['cat_photo_side']) && !empty($_POST['cat_photo_side'])) ? $_POST['cat_photo_side'] : 'left';
		
		$header_image_video = (isset($_POST['header_image_video']) && !empty($_POST['header_image_video'])) ? $_POST['header_image_video'] : 'image';
		$header_video_type = (isset($_POST['header_video_type']) && !empty($_POST['header_video_type'])) ? $_POST['header_video_type'] : '';
		$header_youtube_video = (isset($_POST['header_youtube_video']) && !empty($_POST['header_youtube_video'])) ? $_POST['header_youtube_video'] : '';
		$header_vimeo_video = (isset($_POST['header_vimeo_video']) && !empty($_POST['header_vimeo_video'])) ? $_POST['header_vimeo_video'] : '';
		
		$action_link_url_1 = (isset($_POST['action_link_url_1']) && !empty($_POST['action_link_url_1'])) ? $_POST['action_link_url_1'] : '';
		$action_link_url_2 = (isset($_POST['action_link_url_2']) && !empty($_POST['action_link_url_2'])) ? $_POST['action_link_url_2'] : '';
		$action_link_url_3 = (isset($_POST['action_link_url_3']) && !empty($_POST['action_link_url_3'])) ? $_POST['action_link_url_3'] : '';
		
		
		
		
		if(isset($_FILES['program_cat_image']['name']) && !empty($_FILES['program_cat_image']['name'])){
			$_FILES['program_cat_image']['name'] = time().$_FILES['program_cat_image']['name'];
			
				$program_cat_image = $_POST['program_cat_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('program_cat_image')){
					$image_data = $this->upload->data();
					$program_cat_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$program_cat_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$program_cat_image;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
					
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$program_cat_image);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$program_cat_image);
		
			}
			
			
		
		if(isset($_FILES['white_stripe2_image']['name']) && !empty($_FILES['white_stripe2_image']['name'])){
			$_FILES['white_stripe2_image']['name'] = time().$_FILES['white_stripe2_image']['name'];
			
				$white_stripe2_image = $_POST['white_stripe2_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('white_stripe2_image')){
					$image_data = $this->upload->data();
					$white_stripe2_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$white_stripe2_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$white_stripe2_image;
				
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
			
		
		
		if(isset($_FILES['benefits_3_background_image']['name']) && !empty($_FILES['benefits_3_background_image']['name'])){
			$_FILES['benefits_3_background_image']['name'] = time().$_FILES['benefits_3_background_image']['name'];
			
				$benefits_3_background_image = $_POST['benefits_3_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_3_background_image')){
					$image_data = $this->upload->data();
					$benefits_3_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_3_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_3_background_image;
				
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
			
			if(isset($_FILES['benefits_3_image_1']['name']) && !empty($_FILES['benefits_3_image_1']['name'])){
				$_FILES['benefits_3_image_1']['name'] = time().$_FILES['benefits_3_image_1']['name'];
			
				$benefits_3_image_1 = $_POST['benefits_3_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_3_image_1')){
					$image_data = $this->upload->data();
					$benefits_3_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_3_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_3_image_1;
				
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
			
			if(isset($_FILES['benefits_3_image_2']['name']) && !empty($_FILES['benefits_3_image_2']['name'])){
				$_FILES['benefits_3_image_2']['name'] = time().$_FILES['benefits_3_image_2']['name'];
			
				$benefits_3_image_2 = $_POST['benefits_3_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_3_image_2')){
					$image_data = $this->upload->data();
					$benefits_3_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_3_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_3_image_2;
				
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
			
			if(isset($_FILES['benefits_3_image_3']['name']) && !empty($_FILES['benefits_3_image_3']['name'])){
				$_FILES['benefits_3_image_3']['name'] = time().$_FILES['benefits_3_image_3']['name'];
			
				$benefits_3_image_3 = $_POST['benefits_3_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_3_image_3')){
					$image_data = $this->upload->data();
					$benefits_3_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_3_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_3_image_3;
				
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
			
		
		
		if(isset($_FILES['benefits_2_background_image']['name']) && !empty($_FILES['benefits_2_background_image']['name'])){
			$_FILES['benefits_2_background_image']['name'] = time().$_FILES['benefits_2_background_image']['name'];
			
				$benefits_2_background_image = $_POST['benefits_2_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_2_background_image')){
					$image_data = $this->upload->data();
					$benefits_2_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_2_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_2_background_image;
				
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
			
			if(isset($_FILES['benefits_2_image_1']['name']) && !empty($_FILES['benefits_2_image_1']['name'])){
				$_FILES['benefits_2_image_1']['name'] = time().$_FILES['benefits_2_image_1']['name'];
			
				$benefits_2_image_1 = $_POST['benefits_2_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_2_image_1')){
					$image_data = $this->upload->data();
					$benefits_2_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_2_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_2_image_1;
				
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
			
			if(isset($_FILES['benefits_2_image_2']['name']) && !empty($_FILES['benefits_2_image_2']['name'])){
				$_FILES['benefits_2_image_2']['name'] = time().$_FILES['benefits_2_image_2']['name'];
			
				$benefits_2_image_2 = $_POST['benefits_2_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_2_image_2')){
					$image_data = $this->upload->data();
					$benefits_2_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_2_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_2_image_2;
				
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
			
			if(isset($_FILES['benefits_2_image_3']['name']) && !empty($_FILES['benefits_2_image_3']['name'])){
				$_FILES['benefits_2_image_3']['name'] = time().$_FILES['benefits_2_image_3']['name'];
			
				$benefits_2_image_3 = $_POST['benefits_2_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_2_image_3')){
					$image_data = $this->upload->data();
					$benefits_2_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_2_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_2_image_3;
				
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
			
		
		
		if(isset($_FILES['statistics_background_image']['name']) && !empty($_FILES['statistics_background_image']['name'])){
			$_FILES['statistics_background_image']['name'] = time().$_FILES['statistics_background_image']['name'];
			
				$statistics_background_image = $_POST['statistics_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('statistics_background_image')){
					$image_data = $this->upload->data();
					$statistics_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$statistics_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$statistics_background_image;
				
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
			
			if(isset($_FILES['statistics_image_1']['name']) && !empty($_FILES['statistics_image_1']['name'])){
				$_FILES['statistics_image_1']['name'] = time().$_FILES['statistics_image_1']['name'];
				$statistics_image_1 = $_POST['statistics_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('statistics_image_1')){
					$image_data = $this->upload->data();
					$statistics_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$statistics_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$statistics_image_1;
				
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
			
			if(isset($_FILES['statistics_image_2']['name']) && !empty($_FILES['statistics_image_2']['name'])){
				$_FILES['statistics_image_2']['name'] = time().$_FILES['statistics_image_2']['name'];
				
				$statistics_image_2 = $_POST['statistics_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('statistics_image_2')){
					$image_data = $this->upload->data();
					$statistics_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$statistics_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$statistics_image_2;
				
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
			
			if(isset($_FILES['statistics_image_3']['name']) && !empty($_FILES['statistics_image_3']['name'])){
				$_FILES['statistics_image_3']['name'] = time().$_FILES['statistics_image_3']['name'];
				
				$statistics_image_3 = $_POST['statistics_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('statistics_image_3')){
					$image_data = $this->upload->data();
					$statistics_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$statistics_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$statistics_image_3;
				
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
			
		
		if(isset($_FILES['headling_background_image']['name']) && !empty($_FILES['headling_background_image']['name'])){
			$_FILES['headling_background_image']['name'] = time().$_FILES['headling_background_image']['name'];
				
				$headling_background_image = $_POST['headling_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('headling_background_image')){
					$image_data = $this->upload->data();
					$headling_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$headling_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$headling_background_image;
				
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
			
			
		if(isset($_FILES['benefits_background_image']['name']) && !empty($_FILES['benefits_background_image']['name'])){
			$_FILES['benefits_background_image']['name'] = time().$_FILES['benefits_background_image']['name'];
				
				$benefits_background_image = $_POST['benefits_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_background_image')){
					$image_data = $this->upload->data();
					$benefits_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_background_image;
				
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
			
			if(isset($_FILES['benefits_image_1']['name']) && !empty($_FILES['benefits_image_1']['name'])){
				$_FILES['benefits_image_1']['name'] = time().$_FILES['benefits_image_1']['name'];
				
				$benefits_image_1 = $_POST['benefits_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_image_1')){
					$image_data = $this->upload->data();
					$benefits_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_image_1;
				
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
			
			if(isset($_FILES['benefits_image_2']['name']) && !empty($_FILES['benefits_image_2']['name'])){
				$_FILES['benefits_image_2']['name'] = time().$_FILES['benefits_image_2']['name'];
				
				$benefits_image_2 = $_POST['benefits_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_image_2')){
					$image_data = $this->upload->data();
					$benefits_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_image_2;
				
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
			
			if(isset($_FILES['benefits_image_3']['name']) && !empty($_FILES['benefits_image_3']['name'])){
				$_FILES['benefits_image_3']['name'] = time().$_FILES['benefits_image_3']['name'];
				
				$benefits_image_3 = $_POST['benefits_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('benefits_image_3')){
					$image_data = $this->upload->data();
					$benefits_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$benefits_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$benefits_image_3;
				
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
		
		if(isset($_FILES['video_background_image']['name']) && !empty($_FILES['video_background_image']['name'])){
			
			$_FILES['benefits_image_3']['name'] = time().$_FILES['benefits_image_3']['name'];
				
				$video_background_image = $_POST['video_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('video_background_image')){
					$image_data = $this->upload->data();
					$video_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$video_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$video_background_image;
				
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
			
		if(isset($_FILES['action_background_image']['name']) && !empty($_FILES['action_background_image']['name'])){
			$_FILES['action_background_image']['name'] = time().$_FILES['action_background_image']['name'];
			
				$action_background_image = $_POST['action_background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('action_background_image')){
					$image_data = $this->upload->data();
					$action_background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$action_background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$action_background_image;
				
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
			
			if(isset($_FILES['action_image_1']['name']) && !empty($_FILES['action_image_1']['name'])){
				$_FILES['action_image_1']['name'] = time().$_FILES['action_image_1']['name'];
				$action_image_1 = $_POST['action_image_1'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('action_image_1')){
					$image_data = $this->upload->data();
					$action_image_1 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$action_image_1;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$action_image_1;
				
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
			
			if(isset($_FILES['action_image_2']['name']) && !empty($_FILES['action_image_2']['name'])){
				$_FILES['action_image_2']['name'] = time().$_FILES['action_image_2']['name'];
				
				
				$action_image_2 = $_POST['action_image_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('action_image_2')){
					$image_data = $this->upload->data();
					$action_image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$action_image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$action_image_2;
				
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
			
			if(isset($_FILES['action_image_3']['name']) && !empty($_FILES['action_image_3']['name'])){
				$_FILES['action_image_3']['name'] = time().$_FILES['action_image_3']['name'];
				
				$action_image_3 = $_POST['action_image_3'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('action_image_3')){
					$image_data = $this->upload->data();
					$action_image_3 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$action_image_3;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$action_image_3;
				
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
			
		if(isset($_FILES['body_image']['name']) && !empty($_FILES['body_image']['name'])){
			$_FILES['body_image']['name'] = time().$_FILES['body_image']['name'];
				
				$body_image = $_POST['body_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('body_image')){
					$image_data = $this->upload->data();
					$body_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$body_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$body_image;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
				
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$body_image);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$body_image);
		
		
			}
		
		if(isset($_FILES['background_image']['name']) && !empty($_FILES['background_image']['name'])){
			$_FILES['background_image']['name'] = time().$_FILES['background_image']['name'];
			
				$background_image = $_POST['background_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('background_image')){
					$image_data = $this->upload->data();
					$background_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$background_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$background_image;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
				
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$background_image);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$background_image);
		
		
			}
			
		/**** header image ***/
			if(isset($_FILES['header_image']['name']) && !empty($_FILES['header_image']['name'])){
				$_FILES['header_image']['name'] = time().$_FILES['header_image']['name'];
			
				$header_image = $_POST['header_image'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('header_image')){
					$image_data = $this->upload->data();
					$header_image = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$header_image;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$header_image;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
				
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$header_image);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$header_image);
		
		
			}
			
			
			
			
			if(isset($_FILES['userfile_2']['name']) && !empty($_FILES['userfile_2']['name'])){
				$_FILES['userfile_2']['name'] = time().$_FILES['userfile_2']['name'];
			
				$image_2 = $_POST['userfile_2'];
				$this->load->library('image_lib');
	
				$config['upload_path'] = 'upload/programs/';
				$config['allowed_types'] = 'gif|jpg|png';
	
				$this->load->library('upload', $config);
	
				if ( $this->upload->do_upload('userfile_2')){
					$image_data = $this->upload->data();
					$image_2 = $image_data['file_name'];
				}
	
				$resize_config['source_image'] = 'upload/programs/'.$image_2;
				$get_size = getimagesize($resize_config['source_image']);
	
				$image_info = array(
					'width' => $get_size[0],
					'height' => $get_size[1]
				);
	
				$resize_config['create_thumb'] = FALSE;
	
				$resize_config['new_image'] = 'upload/programs/thumb/'.$image_2;
				
				//echo '<pre>'; print_r($image_info); echo '</pre>';
			
	
				if($image_info['width']  >= 250){				
					$new_width = 250;
					$new_height = round((250/$image_info['width'])*$image_info['height']);				
					
					$resize_config['width'] = $new_width;
					$resize_config['height'] = $new_height;
					$this->image_lib->initialize($resize_config);
					$this->image_lib->resize();	
				}
				
				
				
				// Tiny Image Campress and resize
				$this->query_model->tinyImageCampressAndResize('upload/programs/'.$image_2);
				
				$this->query_model->tinyImageCampressAndResize('upload/programs/thumb/'.$image_2);
		
		
		
			}
		/** </code ****/
		
		$cat = $_POST['category']; 
			if(!empty($image))
			{
				$this->load->model('upload_model');
				$path = "upload/programs/";			
				if($a = $this->upload_model->upload_image($path)){
					$data = array(
					'program' => $name,
					'buttonName' => $buttonName,
					'desc' => $desc,
					'photo' => $a,				
					'category' => $cat,
					'ages' => $ages,
					'features' => $features,
					'stand_alone_page' => $stand_alone_page,
					'video_type' => $video_type,
					'youtube_video' => $youtube_video,
					'vimeo_video' => $vimeo_video,
					'header_image' => $header_image,
					'body_id' => $body_id,
					'header_title' => $header_title,
					'header_desc' => $header_desc,
					'override_logo' => $override_logo,
					'landing_checkbox' => $landing_checkbox,
					'landing_program' => $landing_program,
					'landing_page_url' => $landing_page_url,
					'landing_program_id'=>$landing_program_id,
					'stand_program_name' => $stand_program_name,
					'stand_program_ages' => $stand_program_ages,
					'image_video'=>$image_video,
					'image_alt' => $image_alt,
					'image' => $image_2,
					'program_slug' => $program_slug,
					'receive_class_button' => $receive_class_button,
					'receive_button_text' => $receive_button_text,
					'receive_button_link' => $receive_button_link,
					'mini_form_offer_title' => $mini_form_offer_title,
					'mini_form_offer_desc' => $mini_form_offer_desc,
					'mini_form_button1_text' => $mini_form_button1_text,
					'mini_form_button2_text' => $mini_form_button2_text,
					'trial_title' => $trial_title,
					'trial_desc' => $trial_desc,
					'meta_title' =>$meta_title,
					'background_color' =>$background_color,
					'background_image' =>$background_image,
					'body_title' =>$body_title,
					'body_desc' =>$body_desc,
					'body_img_position' =>$body_img_position,
					'body_image' =>$body_image,
					'action_title' =>$action_title,
					'action_desc' =>$action_desc,
					'action_background_image' =>$action_background_image,
					'action_background_color' =>$action_background_color,
					'action_headline_1' =>$action_headline_1,
					'action_image_1' =>$action_image_1,
					'action_headline_2' =>$action_headline_2,
					'action_image_2' =>$action_image_2,
					'action_headline_3' =>$action_headline_3,
					'action_image_3' =>$action_image_3,
					'action_desc_1' =>$action_desc_1,
					'action_desc_2' =>$action_desc_2,
					'action_desc_3' =>$action_desc_3,
					'video_background_image' =>$video_background_image,
					'video_background_color' =>$video_background_color,
					'benefits_title' =>$benefits_title,
					'benefits_desc' =>$benefits_desc,
					'benefits_background_image' =>$benefits_background_image,
					'benefits_background_color' =>$benefits_background_color,
					'benefits_headline_1' =>$benefits_headline_1,
					'benefits_image_1' =>$benefits_image_1,
					'benefits_headline_2' =>$benefits_headline_2,
					'benefits_image_2' =>$benefits_image_2,
					'benefits_headline_3' =>$benefits_headline_3,
					'benefits_image_3' =>$benefits_image_3,
					'headling_title' =>$headling_title,
					'headling_desc' =>$headling_desc,
					'headling_background_image' =>$headling_background_image,
					'headling_background_color' =>$headling_background_color,
					'headling_headline_1' =>$headling_headline_1,
					'headling_headline_2' =>$headling_headline_2,
					'headling_headline_3' =>$headling_headline_3,
					'statistics_title' =>$statistics_title,
					'statistics_desc' =>$statistics_desc,
					'statistics_background_image' =>$statistics_background_image,
					'statistics_background_color' =>$statistics_background_color,
					'statistics_headline_1' =>$statistics_headline_1,
					'statistics_image_1' =>$statistics_image_1,
					'statistics_headline_2' =>$statistics_headline_2,
					'statistics_image_2' =>$statistics_image_2,
					'statistics_headline_3' =>$statistics_headline_3,
					'statistics_image_3' =>$statistics_image_3,
					'statistics_desc_1' =>$statistics_desc_1,
					'statistics_desc_2' =>$statistics_desc_2,
					'statistics_desc_3' =>$statistics_desc_3,
					'benefits_2_title' =>$benefits_2_title,
					'benefits_2_desc' =>$benefits_2_desc,
					'benefits_2_background_image' =>$benefits_2_background_image,
					'benefits_2_background_color' =>$benefits_2_background_color,
					'benefits_2_headline_1' =>$benefits_2_headline_1,
					'benefits_2_image_1' =>$benefits_2_image_1,
					'benefits_2_headline_2' =>$benefits_2_headline_2,
					'benefits_2_image_2' =>$benefits_2_image_2,
					'benefits_2_headline_3' =>$benefits_2_headline_3,
					'benefits_2_image_3' =>$benefits_2_image_3,
					'benefits_2_desc_1' =>$benefits_2_desc_1,
					'benefits_2_desc_2' =>$benefits_2_desc_2,
					'benefits_2_desc_3' =>$benefits_2_desc_3,
					'show_full_form_1' =>$show_full_form_1,
					'show_full_form_2' =>$show_full_form_2,
					'opt1_text' =>$opt1_text,
					'opt_2_title' =>$opt_2_title,
					'opt_2_text' =>$opt_2_text,
					'benefits_3_title' =>$benefits_3_title,
					'benefits_3_desc' =>$benefits_3_desc,
					'benefits_3_background_image' =>$benefits_3_background_image,
					'benefits_3_background_color' =>$benefits_3_background_color,
					'benefits_3_headline_1' =>$benefits_3_headline_1,
					'benefits_3_image_1' =>$benefits_3_image_1,
					'benefits_3_headline_2' =>$benefits_3_headline_2,
					'benefits_3_image_2' =>$benefits_3_image_2,
					'benefits_3_headline_3' =>$benefits_3_headline_3,
					'benefits_3_image_3' =>$benefits_3_image_3,
					'white_stripe2_title' =>$white_stripe2_title,
					'white_stripe2_desc' =>$white_stripe2_desc,
					'white_stripe2_override_logo' =>$white_stripe2_override_logo,
					'white_stripe2_image' =>$white_stripe2_image,
					'show_learn_more' =>$show_learn_more,
					'white_stripe_background_color' =>$white_stripe_background_color,
					'program_cat_summary' =>$program_cat_summary,
					'program_cat_img_top_spacing' =>$program_cat_img_top_spacing,
					'program_cat_image' =>$program_cat_image,
					'scroll_top' =>$scroll_top,
					'testimonials_h2_text' =>$testimonials_h2_text,
					'testimonial_ids' =>$testimonial_ids,
					'html_editor' =>$html_editor,
					'video_title' =>$video_title,
					'video_desc' =>$video_desc,
					'opt1_title' => $opt1_title,
					'program_cat_image_alt_text' => $program_cat_image_alt_text,
					'header_image_alt_text' => $header_image_alt_text,
					'body_image_alt_text' => $body_image_alt_text,
					'benefits_image_1_alt_text' => $benefits_image_1_alt_text,
					'benefits_image_2_alt_text' => $benefits_image_2_alt_text,
					'benefits_image_3_alt_text' => $benefits_image_3_alt_text,
					'action_image_1_alt_text' => $action_image_1_alt_text,
					'action_image_2_alt_text' => $action_image_2_alt_text,
					'action_image_3_alt_text' => $action_image_3_alt_text,
					'statistics_image_1_alt_text' => $statistics_image_1_alt_text,
					'statistics_image_2_alt_text' => $statistics_image_2_alt_text,
					'statistics_image_3_alt_text' => $statistics_image_3_alt_text,
					'benefits_2_image_1_alt_text' => $benefits_2_image_1_alt_text,
					'benefits_2_image_2_alt_text' => $benefits_2_image_2_alt_text,
					'benefits_2_image_3_alt_text' => $benefits_2_image_3_alt_text,
					'white_stripe2_image_alt_text' => $white_stripe2_image_alt_text,
					'benefits_3_image_1_alt_text' => $benefits_3_image_1_alt_text,
					'benefits_3_image_2_alt_text' => $benefits_3_image_2_alt_text,
					'benefits_3_image_3_alt_text' => $benefits_3_image_3_alt_text,
					'faqs_h2_text' => $faqs_h2_text,
					'faq_ids' => $faq_ids,
					'program_type' => $program_type,
					'header_title_background_color' => $header_title_background_color,
					'show_override_logo' => $show_override_logo,
					'question_headline' => $question_headline,
					'featured_program_img' => $featured_program_img,
					'featured_program_img_alt_text' => $featured_program_img_alt_text,
					'opt1_submit_btn_text' => $opt1_submit_btn_text,
					'trial_offer_id' => $trial_offer_id,
					'redirection_type' => $redirection_type,
					'dojocart_id' => $dojocart_id,
					'third_party_url' => $third_party_url,
					'button1_redirection_type' => $button1_redirection_type,
					'button1_trial_offer_id' => $button1_trial_offer_id,
					'button1_dojocart_id' => $button1_dojocart_id,
					'button1_third_party_url' => $button1_third_party_url,
					'button2_redirection_type' => $button2_redirection_type,
					'button2_trial_offer_id' => $button2_trial_offer_id,
					'button2_dojocart_id' => $button2_dojocart_id,
					'button2_third_party_url' => $button2_third_party_url,
					'thankyou_page_id' => $thankyou_page_id,
					'button1_thankyou_page_id' => $button1_thankyou_page_id,
					'button2_thankyou_page_id' => $button2_thankyou_page_id,
					'connect_trial_offer_id' => $connect_trial_offer_id,
					'guests_values' => $guests_values,
					'show_location_type' => $show_location_type,
					'locations' => $locations,
					'cat_photo_side' => $cat_photo_side,
					'header_image_video' => $header_image_video,
					'header_video_type' => $header_video_type,
					'header_youtube_video' => $header_youtube_video,
					'header_vimeo_video' => $header_vimeo_video,
					'action_link_url_1' => $action_link_url_1,
					'action_link_url_2' => $action_link_url_2,
					'action_link_url_3' => $action_link_url_3,
					'meta_desc' => $meta_desc,
					);
					
						if($trials){						
							$data=array_merge($data, array('trial' => $trials));			
						}
						else{
							$data=array_merge($data, array('trial' => '0'));
						}			
						if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
							if(isset($_POST['action_type']) && $_POST['action_type'] == "save_and_continue"){
								redirect("admin/programs/edit/".$this->uri->segment(4).'/view/'.$cat);
							}else{
								redirect("admin/programs/".$_POST['redirect']);
							}
						endif;
				}else{
					$error = strip_tags($this->upload->display_errors());
				}
			
		}
		if(isset($_POST['last-photo']) && empty($image)){		
			
			$data = array(
				'program' => $name,
				'buttonName' => $buttonName,
				'desc' => $desc,			
				'category' => $cat,
				'ages' => $ages,
				'features' => $features,
				'stand_alone_page' => $stand_alone_page,
				'video_type' => $video_type,
				'youtube_video' => $youtube_video,
				'vimeo_video' => $vimeo_video,
				'header_image' => $header_image,
				'body_id' => $body_id,
				'header_title' => $header_title,
				'header_desc' => $header_desc,
				'override_logo' => $override_logo,
				'landing_checkbox' => $landing_checkbox,
				'landing_program' => $landing_program,
				'landing_page_url' => $landing_page_url,
				'landing_program_id' => $landing_program_id,
				'stand_program_name' => $stand_program_name,
				'stand_program_ages' => $stand_program_ages,
				'image_video'=>$image_video,
				'image_alt' => $image_alt,
				'image' => $image_2,
				'program_slug' => $program_slug,
				'receive_class_button' => $receive_class_button,
				'receive_button_text' => $receive_button_text,
				'receive_button_link' => $receive_button_link,
				'mini_form_offer_title' => $mini_form_offer_title,
				'mini_form_offer_desc' => $mini_form_offer_desc,
				'mini_form_button1_text' => $mini_form_button1_text,
				'mini_form_button2_text' => $mini_form_button2_text,
				'trial_title' => $trial_title,
				'trial_desc' => $trial_desc,
				'meta_title' =>$meta_title,
					'background_color' =>$background_color,
					'background_image' =>$background_image,
					'body_title' =>$body_title,
					'body_desc' =>$body_desc,
					'body_img_position' =>$body_img_position,
					'body_image' =>$body_image,
					'action_title' =>$action_title,
					'action_desc' =>$action_desc,
					'action_background_image' =>$action_background_image,
					'action_background_color' =>$action_background_color,
					'action_headline_1' =>$action_headline_1,
					'action_image_1' =>$action_image_1,
					'action_headline_2' =>$action_headline_2,
					'action_image_2' =>$action_image_2,
					'action_headline_3' =>$action_headline_3,
					'action_image_3' =>$action_image_3,
					'action_desc_1' =>$action_desc_1,
					'action_desc_2' =>$action_desc_2,
					'action_desc_3' =>$action_desc_3,
					'video_background_image' =>$video_background_image,
					'video_background_color' =>$video_background_color,
					'benefits_title' =>$benefits_title,
					'benefits_desc' =>$benefits_desc,
					'benefits_background_image' =>$benefits_background_image,
					'benefits_background_color' =>$benefits_background_color,
					'benefits_headline_1' =>$benefits_headline_1,
					'benefits_image_1' =>$benefits_image_1,
					'benefits_headline_2' =>$benefits_headline_2,
					'benefits_image_2' =>$benefits_image_2,
					'benefits_headline_3' =>$benefits_headline_3,
					'benefits_image_3' =>$benefits_image_3,
					'headling_title' =>$headling_title,
					'headling_desc' =>$headling_desc,
					'headling_background_image' =>$headling_background_image,
					'headling_background_color' =>$headling_background_color,
					'headling_headline_1' =>$headling_headline_1,
					'headling_headline_2' =>$headling_headline_2,
					'headling_headline_3' =>$headling_headline_3,
					'statistics_title' =>$statistics_title,
					'statistics_desc' =>$statistics_desc,
					'statistics_background_image' =>$statistics_background_image,
					'statistics_background_color' =>$statistics_background_color,
					'statistics_headline_1' =>$statistics_headline_1,
					'statistics_image_1' =>$statistics_image_1,
					'statistics_headline_2' =>$statistics_headline_2,
					'statistics_image_2' =>$statistics_image_2,
					'statistics_headline_3' =>$statistics_headline_3,
					'statistics_image_3' =>$statistics_image_3,
					'statistics_desc_1' =>$statistics_desc_1,
					'statistics_desc_2' =>$statistics_desc_2,
					'statistics_desc_3' =>$statistics_desc_3,
					'benefits_2_title' =>$benefits_2_title,
					'benefits_2_desc' =>$benefits_2_desc,
					'benefits_2_background_image' =>$benefits_2_background_image,
					'benefits_2_background_color' =>$benefits_2_background_color,
					'benefits_2_headline_1' =>$benefits_2_headline_1,
					'benefits_2_image_1' =>$benefits_2_image_1,
					'benefits_2_headline_2' =>$benefits_2_headline_2,
					'benefits_2_image_2' =>$benefits_2_image_2,
					'benefits_2_headline_3' =>$benefits_2_headline_3,
					'benefits_2_image_3' =>$benefits_2_image_3,
					'benefits_2_desc_1' =>$benefits_2_desc_1,
					'benefits_2_desc_2' =>$benefits_2_desc_2,
					'benefits_2_desc_3' =>$benefits_2_desc_3,
					'show_full_form_1' =>$show_full_form_1,
					'show_full_form_2' =>$show_full_form_2,
					'opt1_text' =>$opt1_text,
					'opt_2_title' =>$opt_2_title,
					'opt_2_text' =>$opt_2_text,
					'benefits_3_title' =>$benefits_3_title,
					'benefits_3_desc' =>$benefits_3_desc,
					'benefits_3_background_image' =>$benefits_3_background_image,
					'benefits_3_background_color' =>$benefits_3_background_color,
					'benefits_3_headline_1' =>$benefits_3_headline_1,
					'benefits_3_image_1' =>$benefits_3_image_1,
					'benefits_3_headline_2' =>$benefits_3_headline_2,
					'benefits_3_image_2' =>$benefits_3_image_2,
					'benefits_3_headline_3' =>$benefits_3_headline_3,
					'benefits_3_image_3' =>$benefits_3_image_3,
					'white_stripe2_title' =>$white_stripe2_title,
					'white_stripe2_desc' =>$white_stripe2_desc,
					'white_stripe2_override_logo' =>$white_stripe2_override_logo,
					'white_stripe2_image' =>$white_stripe2_image,
					'show_learn_more' =>$show_learn_more,
					'white_stripe_background_color' =>$white_stripe_background_color,
					'program_cat_summary' =>$program_cat_summary,
					'program_cat_img_top_spacing' =>$program_cat_img_top_spacing,
					'program_cat_image' =>$program_cat_image,
					'scroll_top' =>$scroll_top,
					'testimonials_h2_text' =>$testimonials_h2_text,
					'testimonial_ids' =>$testimonial_ids,
					'html_editor' =>$html_editor,
					'video_title' =>$video_title,
					'video_desc' =>$video_desc,
					'opt1_title' => $opt1_title,
					'program_cat_image_alt_text' => $program_cat_image_alt_text,
					'header_image_alt_text' => $header_image_alt_text,
					'body_image_alt_text' => $body_image_alt_text,
					'benefits_image_1_alt_text' => $benefits_image_1_alt_text,
					'benefits_image_2_alt_text' => $benefits_image_2_alt_text,
					'benefits_image_3_alt_text' => $benefits_image_3_alt_text,
					'action_image_1_alt_text' => $action_image_1_alt_text,
					'action_image_2_alt_text' => $action_image_2_alt_text,
					'action_image_3_alt_text' => $action_image_3_alt_text,
					'statistics_image_1_alt_text' => $statistics_image_1_alt_text,
					'statistics_image_2_alt_text' => $statistics_image_2_alt_text,
					'statistics_image_3_alt_text' => $statistics_image_3_alt_text,
					'benefits_2_image_1_alt_text' => $benefits_2_image_1_alt_text,
					'benefits_2_image_2_alt_text' => $benefits_2_image_2_alt_text,
					'benefits_2_image_3_alt_text' => $benefits_2_image_3_alt_text,
					'white_stripe2_image_alt_text' => $white_stripe2_image_alt_text,
					'benefits_3_image_1_alt_text' => $benefits_3_image_1_alt_text,
					'benefits_3_image_2_alt_text' => $benefits_3_image_2_alt_text,
					'benefits_3_image_3_alt_text' => $benefits_3_image_3_alt_text,
					'faqs_h2_text' => $faqs_h2_text,
					'faq_ids' => $faq_ids,
					'program_type' => $program_type,
					'header_title_background_color' => $header_title_background_color,
					'show_override_logo' => $show_override_logo,
					'question_headline' => $question_headline,
					'featured_program_img' => $featured_program_img,
					'featured_program_img_alt_text' => $featured_program_img_alt_text,
					'opt1_submit_btn_text' => $opt1_submit_btn_text,
					'trial_offer_id' => $trial_offer_id,
					'redirection_type' => $redirection_type,
					'dojocart_id' => $dojocart_id,
					'third_party_url' => $third_party_url,
					'button1_redirection_type' => $button1_redirection_type,
					'button1_trial_offer_id' => $button1_trial_offer_id,
					'button1_dojocart_id' => $button1_dojocart_id,
					'button1_third_party_url' => $button1_third_party_url,
					'button2_redirection_type' => $button2_redirection_type,
					'button2_trial_offer_id' => $button2_trial_offer_id,
					'button2_dojocart_id' => $button2_dojocart_id,
					'button2_third_party_url' => $button2_third_party_url,
					'thankyou_page_id' => $thankyou_page_id,
					'button1_thankyou_page_id' => $button1_thankyou_page_id,
					'button2_thankyou_page_id' => $button2_thankyou_page_id,
					'connect_trial_offer_id' => $connect_trial_offer_id,
					'guests_values' => $guests_values,
					'show_location_type' => $show_location_type,
					'locations' => $locations,
					'cat_photo_side' => $cat_photo_side,
					'header_image_video' => $header_image_video,
					'header_video_type' => $header_video_type,
					'header_youtube_video' => $header_youtube_video,
					'header_vimeo_video' => $header_vimeo_video,
					'action_link_url_1' => $action_link_url_1,
					'action_link_url_2' => $action_link_url_2,
					'action_link_url_3' => $action_link_url_3,
					'meta_desc' => $meta_desc,
				);
			if($trials){						
				$data=array_merge($data, array('trial' => $trials));			
			}
			else{
				$data=array_merge($data, array('trial' => '0'));
			}			
			if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
				if(isset($_POST['action_type']) && $_POST['action_type'] == "save_and_continue"){
					redirect("admin/programs/edit/".$this->uri->segment(4).'/view/'.$cat);
				}else{
					redirect("admin/programs/".$_POST['redirect']);
				}
			endif;
		}
		else{
			if($error == ''){
					$data = array(
						'program' => $name,
						'buttonName' => $buttonName,
						'desc' => $desc,
						'trial' => $trials,
						'category' => $cat,
						'ages' => $ages,
						'features' => $features,
						'stand_alone_page' => $stand_alone_page,
						'video_type' => $video_type,
						'youtube_video' => $youtube_video,
						'vimeo_video' => $vimeo_video,
						'header_image' => $header_image,
						'body_id' => $body_id,
						'header_title' => $header_title,
						'header_desc' => $header_desc,
						'override_logo' => $override_logo,
						'landing_checkbox' => $landing_checkbox,
						'landing_program' => $landing_program,
						'landing_page_url' => $landing_page_url,
						'landing_program_id' => $landing_program_id,
						'stand_program_name' => $stand_program_name,
						'stand_program_ages' => $stand_program_ages,
						'image_video'=>$image_video,
						'image_alt' => $image_alt,
						'image' => $image_2,
						'program_slug' => $program_slug,
						'receive_class_button' => $receive_class_button,
						'receive_button_text' => $receive_button_text,
						'receive_button_link' => $receive_button_link,
						'mini_form_offer_title' => $mini_form_offer_title,
						'mini_form_offer_desc' => $mini_form_offer_desc,
						'mini_form_button1_text' => $mini_form_button1_text,
						'mini_form_button2_text' => $mini_form_button2_text,
						'trial_title' => $trial_title,
						'trial_desc' => $trial_desc,
						'meta_title' =>$meta_title,
					'background_color' =>$background_color,
					'background_image' =>$background_image,
					'body_title' =>$body_title,
					'body_desc' =>$body_desc,
					'body_img_position' =>$body_img_position,
					'body_image' =>$body_image,
					'action_title' =>$action_title,
					'action_desc' =>$action_desc,
					'action_background_image' =>$action_background_image,
					'action_background_color' =>$action_background_color,
					'action_headline_1' =>$action_headline_1,
					'action_image_1' =>$action_image_1,
					'action_headline_2' =>$action_headline_2,
					'action_image_2' =>$action_image_2,
					'action_headline_3' =>$action_headline_3,
					'action_image_3' =>$action_image_3,
					'action_desc_1' =>$action_desc_1,
					'action_desc_2' =>$action_desc_2,
					'action_desc_3' =>$action_desc_3,
					'video_background_image' =>$video_background_image,
					'video_background_color' =>$video_background_color,
					'benefits_title' =>$benefits_title,
					'benefits_desc' =>$benefits_desc,
					'benefits_background_image' =>$benefits_background_image,
					'benefits_background_color' =>$benefits_background_color,
					'benefits_headline_1' =>$benefits_headline_1,
					'benefits_image_1' =>$benefits_image_1,
					'benefits_headline_2' =>$benefits_headline_2,
					'benefits_image_2' =>$benefits_image_2,
					'benefits_headline_3' =>$benefits_headline_3,
					'benefits_image_3' =>$benefits_image_3,
					'headling_title' =>$headling_title,
					'headling_desc' =>$headling_desc,
					'headling_background_image' =>$headling_background_image,
					'headling_background_color' =>$headling_background_color,
					'headling_headline_1' =>$headling_headline_1,
					'headling_headline_2' =>$headling_headline_2,
					'headling_headline_3' =>$headling_headline_3,
					'statistics_title' =>$statistics_title,
					'statistics_desc' =>$statistics_desc,
					'statistics_background_image' =>$statistics_background_image,
					'statistics_background_color' =>$statistics_background_color,
					'statistics_headline_1' =>$statistics_headline_1,
					'statistics_image_1' =>$statistics_image_1,
					'statistics_headline_2' =>$statistics_headline_2,
					'statistics_image_2' =>$statistics_image_2,
					'statistics_headline_3' =>$statistics_headline_3,
					'statistics_image_3' =>$statistics_image_3,
					'statistics_desc_1' =>$statistics_desc_1,
					'statistics_desc_2' =>$statistics_desc_2,
					'statistics_desc_3' =>$statistics_desc_3,
					'benefits_2_title' =>$benefits_2_title,
					'benefits_2_desc' =>$benefits_2_desc,
					'benefits_2_background_image' =>$benefits_2_background_image,
					'benefits_2_background_color' =>$benefits_2_background_color,
					'benefits_2_headline_1' =>$benefits_2_headline_1,
					'benefits_2_image_1' =>$benefits_2_image_1,
					'benefits_2_headline_2' =>$benefits_2_headline_2,
					'benefits_2_image_2' =>$benefits_2_image_2,
					'benefits_2_headline_3' =>$benefits_2_headline_3,
					'benefits_2_image_3' =>$benefits_2_image_3,
					'benefits_2_desc_1' =>$benefits_2_desc_1,
					'benefits_2_desc_2' =>$benefits_2_desc_2,
					'benefits_2_desc_3' =>$benefits_2_desc_3,
					'show_full_form_1' =>$show_full_form_1,
					'show_full_form_2' =>$show_full_form_2,
					'opt1_text' =>$opt1_text,
					'opt_2_title' =>$opt_2_title,
					'opt_2_text' =>$opt_2_text,
					'benefits_3_title' =>$benefits_3_title,
					'benefits_3_desc' =>$benefits_3_desc,
					'benefits_3_background_image' =>$benefits_3_background_image,
					'benefits_3_background_color' =>$benefits_3_background_color,
					'benefits_3_headline_1' =>$benefits_3_headline_1,
					'benefits_3_image_1' =>$benefits_3_image_1,
					'benefits_3_headline_2' =>$benefits_3_headline_2,
					'benefits_3_image_2' =>$benefits_3_image_2,
					'benefits_3_headline_3' =>$benefits_3_headline_3,
					'benefits_3_image_3' =>$benefits_3_image_3,
					'white_stripe2_title' =>$white_stripe2_title,
					'white_stripe2_desc' =>$white_stripe2_desc,
					'white_stripe2_override_logo' =>$white_stripe2_override_logo,
					'white_stripe2_image' =>$white_stripe2_image,
					'show_learn_more' =>$show_learn_more,
					'white_stripe_background_color' =>$white_stripe_background_color,
					'program_cat_summary' =>$program_cat_summary,
					'program_cat_img_top_spacing' =>$program_cat_img_top_spacing,
					'program_cat_image' =>$program_cat_image,
					'scroll_top' =>$scroll_top,
					'testimonials_h2_text' =>$testimonials_h2_text,
					'testimonial_ids' =>$testimonial_ids,
					'html_editor' =>$html_editor,
					'video_title' =>$video_title,
					'video_desc' =>$video_desc,
					'opt1_title' => $opt1_title,
					'program_cat_image_alt_text' => $program_cat_image_alt_text,
					'header_image_alt_text' => $header_image_alt_text,
					'body_image_alt_text' => $body_image_alt_text,
					'benefits_image_1_alt_text' => $benefits_image_1_alt_text,
					'benefits_image_2_alt_text' => $benefits_image_2_alt_text,
					'benefits_image_3_alt_text' => $benefits_image_3_alt_text,
					'action_image_1_alt_text' => $action_image_1_alt_text,
					'action_image_2_alt_text' => $action_image_2_alt_text,
					'action_image_3_alt_text' => $action_image_3_alt_text,
					'statistics_image_1_alt_text' => $statistics_image_1_alt_text,
					'statistics_image_2_alt_text' => $statistics_image_2_alt_text,
					'statistics_image_3_alt_text' => $statistics_image_3_alt_text,
					'benefits_2_image_1_alt_text' => $benefits_2_image_1_alt_text,
					'benefits_2_image_2_alt_text' => $benefits_2_image_2_alt_text,
					'benefits_2_image_3_alt_text' => $benefits_2_image_3_alt_text,
					'white_stripe2_image_alt_text' => $white_stripe2_image_alt_text,
					'benefits_3_image_1_alt_text' => $benefits_3_image_1_alt_text,
					'benefits_3_image_2_alt_text' => $benefits_3_image_2_alt_text,
					'benefits_3_image_3_alt_text' => $benefits_3_image_3_alt_text,
					'faqs_h2_text' => $faqs_h2_text,
					'faq_ids' => $faq_ids,
					'program_type' => $program_type,
					'header_title_background_color' => $header_title_background_color,
					'show_override_logo' => $show_override_logo,
					'question_headline' => $question_headline,
					'featured_program_img' => $featured_program_img,
					'featured_program_img_alt_text' => $featured_program_img_alt_text,
					'opt1_submit_btn_text' => $opt1_submit_btn_text,
					'trial_offer_id' => $trial_offer_id,
					'redirection_type' => $redirection_type,
					'dojocart_id' => $dojocart_id,
					'third_party_url' => $third_party_url,
					'button1_redirection_type' => $button1_redirection_type,
					'button1_trial_offer_id' => $button1_trial_offer_id,
					'button1_dojocart_id' => $button1_dojocart_id,
					'button1_third_party_url' => $button1_third_party_url,
					'button2_redirection_type' => $button2_redirection_type,
					'button2_trial_offer_id' => $button2_trial_offer_id,
					'button2_dojocart_id' => $button2_dojocart_id,
					'button2_third_party_url' => $button2_third_party_url,
					'thankyou_page_id' => $thankyou_page_id,
					'button1_thankyou_page_id' => $button1_thankyou_page_id,
					'button2_thankyou_page_id' => $button2_thankyou_page_id,
					'connect_trial_offer_id' => $connect_trial_offer_id,
					'guests_values' => $guests_values,
					'show_location_type' => $show_location_type,
					'locations' => $locations,
					'cat_photo_side' => $cat_photo_side,
					'header_image_video' => $header_image_video,
					'header_video_type' => $header_video_type,
					'header_youtube_video' => $header_youtube_video,
					'header_vimeo_video' => $header_vimeo_video,
					'action_link_url_1' => $action_link_url_1,
					'action_link_url_2' => $action_link_url_2,
					'action_link_url_3' => $action_link_url_3,
					'meta_desc' => $meta_desc,
					);
					
				if($this->query_model->update($this->table,$this->uri->segment(4),$data)):
					if(isset($_POST['action_type']) && $_POST['action_type'] == "save_and_continue"){
						redirect("admin/programs/edit/".$this->uri->segment(4).'/view/'.$cat);
					}else{
						redirect("admin/programs/".$_POST['redirect']);
					}
				endif;
			}else{
				echo '<script>alert("'.$error.'");</script>';
			}
			
		}
		
		
	}
	
}