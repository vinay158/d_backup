<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {
	
	public function index( $location = NULL, $year = NULL, $month = NULL)
	{
		
		if($this->session->userdata('student_session_login') == 1){	
		
			$selected_location_slug = $location;
			
				$multi_calendar = $this->default_db->row('tblconfigcalendar',array('field_name'=>'multi_calendar'));
				$multi_location = $this->default_db->row('tblconfigcalendar',array('field_name'=>'multi_location'));
				
				$data['multi_calendar_val'] = $multi_calendar['field_value'];
				$data['multi_location_val'] = $multi_location['field_value'];
				
				if(!empty($location)){
					$publish = $this->default_db->row('tblcontact',array('slug'=>$location));
					if($publish['published'] == 0){
						redirect(base_url());
					}
				}
			
				//echo "<br>Year :".$year;
				if($year == NULL):
					$year=date("Y");
				endif;
				
				if($month == NULL):
					$month=date("m");
				endif;
				
				$this->load->model("event_model");

				// Get Calendar/Event Page title from tbl_studentpagetitle
				$this->db->where('id', 3);
				$data['title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
				$data['title'] = !empty($data['title'])? $data['title'][0]->title:'';
				
				//$data['title'] = "Events / Schedulesdd";
				$contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));
				$_locations=$contact_data->result();
				$data['location_count'] = count($_locations);
				$first_rec = $_locations[0];
				$_multi_location_data = $this->db->query("select * from tblconfigcalendar ") or die(mysqli_error($this->db->conn_id));
				$_multi_location=$_multi_location_data->result();
				$data['multi_location'] = $_multi_location[0];
				$data['multi_location'] = $data['multi_location']->field_value;
				
				
				$location = isset($this->uri->segments[2]) && !empty($this->uri->segments[2]) ? $this->uri->segments[2] : '';
				
				
				if(isset($location) && !empty($location)){
					$res="";
					$_contact_data=$this->db->query("select * from `tblcontact`  where  published='1'  and slug = '".$location."' order by pos ASC") or die(mysqli_error($this->db->conn_id));
					$res=$_contact_data->result();
					
					
					if(count($res) > 0){
						$data['location'] = $location;
					}else{
						$location = $first_rec->name;
						$data['location'] = $location;
						redirect("events");
					}
					$_data = $this->query_model->getbySpecific("tblcontact", "slug", $location);
					$_data = $_data[0];
					$location_id = $_data->id;
				}else{	
					/*unset($data['location']);
					$location = $first_rec->slug;
					$data['location'] = $location;*/
					$location_id = '';
				}
				
				$data['location_id'] = $location_id;
				
				
				/*$_data = $this->query_model->getbySpecific("tblcontact", "slug", $location);
				$_data = $_data[0];
				$location_id = $_data->id;*/
				//echo '<br>year: '.$year;
				
				// vinay new 
				$location_id = $this->query_model->getMainLocation("tblcontact");
				$location_id = $location_id[0]->id;
				
				$selected_location_id = '';
				if($multi_calendar['field_value'] == 1 && $multi_location['field_value'] == 1){
					if(!empty($selected_location_slug)){
						$this->db->select(array('id','name'));
						$this->db->where('published',1);
						$selected_location = $this->default_db->row('tblcontact',array('slug'=>$selected_location_slug));
						$selected_location_id = $selected_location['id'];
					}
				}
				$data['selected_location_id'] = $selected_location_id;
				
				$this->db->select(array('id','name','slug'));
				$this->db->where("published", 1);
				$this->db->where("location_type", 'regular_link');
				$this->db->order_by('pos', 'asc');
				$data['eventAllLocations'] = $this->query_model->getbyTable("tblcontact");
				
				//echo $selected_location_id; die;
				
				$data['calendar'] = $this->event_model->generateCalendar($year,$month,$selected_location_id);
				//echo '<pre>data'; print_r($data['calendar']); die;
				$this->db->order_by("pos", "DESC");		
				//echo $year.'===>'.$month.'===>'.$location_id; die;
				$events = $this->event_model->count_num_appointment_for_extracting_all_categories_used($year,$month,$location_id);
				
				
				$unique_cats = array();
				# pre($events);exit; 
				if(count($events) >0){
					
					foreach($events as $i=>$item1){
					
						if(count($item1)>0){
						
							foreach($item1 as $item2){
								
								//$unique_cats[] = $item3['category'];
								// updated code by kz 09 april 2019
								if(!empty($item2)){
									foreach($item2 as $item3){
										$unique_cats[] = $item3['category'];
									}
								}
							
							}
							
						}
					
					}
					
					if(count($unique_cats)>0){
						$unique_cats = array_values(array_unique($unique_cats));
					}
				}
				
				if(!empty($unique_cats)){
				$this->db->order_by('pos','DESC');
					$this->db->where_in('cat_id',$unique_cats);
					$categories = $this->db->get('tblcategory')->result();

				}
				
				
				
				$data['categories'] = !empty($categories) ? $categories : '';
				
				$data['month'] = $month;
				$data['year'] = $year;
				
				$this->load->view('events-schedule', $data);
		
		} else{
			redirect(base_url());
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function requested($year = NULL, $month = NULL,$location_id = '')
	{   
	
		$selected_location_id = $location_id;
		
		if($year == NULL):
			$year=date("Y");
		endif;
		if($month == NULL):
			$month=date("m");
		endif;
		
		
		
		
		/*if($year == NULL || $year == "location" ):
			$year=date("Y");
		endif;
		
		if($month != NULL || $month == NULL):
			$month=date("m");
		endif;*/
	if($location_id != ''){
		$_data = $this->query_model->getbySpecific("tblcontact", "id", $location_id);
		if(!empty($_data)){
			$_data = $_data[0];
			$data['location'] = $_data->name;	
			$location_id = $_data->id;
		}
	}else{
		$data['location'] = '';
		$location_id = '';
	}
	
	// Get Calendar/Event Page title from tbl_studentpagetitle
		$this->db->where('id', 3);
		$data['title'] = $this->query_model->getbyTable('tbl_studentpagetitle');
		$data['title'] = !empty($data['title'])? $data['title'][0]->title:'';
		
	$data['location_id'] = $location_id;
	
	$contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));
	$_locations=$contact_data->result();
	$data['location_count'] = count($_locations);
	
	$_multi_location_data = $this->db->query("select * from tblconfigcalendar") or die(mysqli_error($this->db->conn_id));
	$_multi_location=$_multi_location_data->result();
	$data['multi_location'] = $_multi_location[0];
	$data['multi_location'] = $data['multi_location']->field_value;
		/*if(count($_data) == 0){
			if($data['multi_location'] == 0){
				redirect("events");
			}	
		}*/
		
	$this->load->model("event_model");
	$this->db->order_by("pos", "DESC");
	
	// vinay new 
	$location_id = $this->query_model->getMainLocation("tblcontact");
	$location_id = $location_id[0]->id;
	
	// custom code for events according location
	$multi_calendar = $this->default_db->row('tblconfigcalendar',array('field_name'=>'multi_calendar'));
	$multi_location = $this->default_db->row('tblconfigcalendar',array('field_name'=>'multi_location'));
	$data['multi_calendar_val'] = $multi_calendar['field_value'];
	$data['multi_location_val'] = $multi_location['field_value'];
	
	if($multi_calendar['field_value'] == 1 && $multi_location['field_value'] == 1){
		if(!empty($selected_location_id)){
			$this->db->select(array('id','name'));
			$this->db->where('published',1);
			$selected_location = $this->default_db->row('tblcontact',array('id'=>$selected_location_id));
			$selected_location_id = !empty($selected_location) ?  $selected_location['id'] : '';
		}
	}
	$data['selected_location_id'] = $selected_location_id;
	
	$this->db->select(array('id','name','slug'));
	$this->db->where("published", 1);
	$this->db->where("location_type", 'regular_link');
	$this->db->order_by('pos', 'asc');
	$data['eventAllLocations'] = $this->query_model->getbyTable("tblcontact");
				
	//echo $selected_location_id; die;
	$data['calendar'] = $this->event_model->generateCalendar($year,$month,$selected_location_id);
	
	$data['month'] = $month;
		$data['year'] = $year;
		//echo $year.'===>'.$month.'===>'.$location_id; die;
		$events = $this->event_model->count_num_appointment_for_extracting_all_categories_used($year,$month,$location_id);
	
		$unique_cats = array();
		
		if(count($events) >0){
			
			foreach($events as $i=>$item1){
			
				if(count($item1)>0){
				 
					foreach($item1 as $key => $item2){
						
						if(!empty($item2)){
							foreach($item2 as $item3){
								$unique_cats[] = $item3['category'];
							}
						}
						
					
					}
				}
			}
			
			if(count($unique_cats)>0){
				$unique_cats = array_values(array_unique($unique_cats));
			}
		}
		//echo '<pre>data'; print_r($unique_cats); die;
		if(!empty($unique_cats)){
		$this->db->order_by('pos','DESC');
			$this->db->where_in('cat_id',$unique_cats);
			$categories = $this->db->get('tblcategory')->result();
			
			$data['categories'] = $categories;
		}
		
		//echo '<pre>data'; print_r($data); die;
		
		$this->load->view('events-schedule',$data);		

	}
	
	
	public function getCheckBoxValue(){
		if(count($_POST)> 0){
			$data = array(
						$_POST['id'] => array(
										'checkboxValue' => $_POST['checkboxValue'],
										'category_id' => $_POST['id']
									)
								);
			$this->session->set_userdata($data);
			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
