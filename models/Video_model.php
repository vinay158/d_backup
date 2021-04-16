<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_model extends CI_Model{
	
	var $table = 'tblvideo';
	
	function updateVideo(){
		
		$this->load->helper(array('url'));
		
		$data['name'] = $this->input->post('name'); 
		$data['youtube_video'] = htmlentities($this->input->post('youtube_video')); 
		$data['vimeo_video'] = $this->input->post('vimeo_video');
		$data['video_type'] = $this->input->post('video_type');
		$data['published'] = $this->input->post('publish');
		if($this->input->post('location_id') != ''){
			$data['location_id'] = $this->input->post('location_id');
		} else {
			$my_mainLocation = $this->query_model->getMainLocation();
			$my_mainLocation = $my_mainLocation[0]->id;
			$data['location_id'] = $my_mainLocation;
		}
		
		$videoDetail = $this->query_model->getbySpecific("tblvideo", 'location_id',$data['location_id']);
		$video_id = $videoDetail[0]->id;
		
		$this->query_model->update('tblvideo', $video_id, $data);
		//echo $data['location_id']; die;
		if($this->input->post('location_id') != ''){
				redirect("admin/video/multilocation/".$data['location_id']);
		} else{
				redirect("admin/video");
		}
		
	}
	
	function addVideo(){
		$this->load->helper(array('url'));
		$data['name'] = $this->input->post('name'); 
		$data['youtube_video'] = htmlentities($this->input->post('youtube_video')); 
		$data['vimeo_video'] = $this->input->post('vimeo_video'); 
		$data['video_type'] = $this->input->post('video_type');
		if($this->input->post('location_id') != ''){
			$data['location_id'] = $this->input->post('location_id');
		}else {
			$my_mainLocation = $this->query_model->getMainLocation();
			$my_mainLocation = $my_mainLocation[0]->id;
			$data['location_id'] = $my_mainLocation;
		}
		$this->query_model->insertData('tblvideo', $data);
		
		if($this->input->post('location_id') != ''){	
			redirect("admin/video/multilocation/".$data['location_id']);
		} else {
			redirect("admin/video");
		}
		
	}
	
	
	
	
	
}