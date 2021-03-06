<?php
class Event_model extends CI_Model {
 
	var $config;
	var $cache_temp; 
	function __construct(){
		parent::__construct();
		
		$events_controller = $this->query_model->getbySpecific("tblmeta", "id", 27);
		
		
		$this->config = array(
			'start_day' => "sunday",
			'show_next_prev' => true,
                        'day_type' => "short",
			'next_prev_url' => base_url().$events_controller[0]->slug."/requested"
		);
	}
	
	
	
	function generateCalendar($year,$month,$location_id){
	
		$location_id_url = !empty($location_id) ? '/'.$location_id : '';
	$this->config['template'] = '
	
   {heading_row_start}<div class="calendar_month">{/heading_row_start}

   {heading_previous_cell}<a href="{previous_url}'.$location_id_url.'"><div  class="prev_month">&lt;&lt;</div></a>{/heading_previous_cell}
   {heading_next_cell}<a href="{next_url}'.$location_id_url.'"><div class="next_month">&gt;&gt;</div></a>{/heading_next_cell}
   {heading_title_cell}<div class="month"><span>{heading}</span></div>{/heading_title_cell}
   
   <hr class="calendar_month_bar" />
   {heading_row_end}</div>{/heading_row_end}
   
   {table_open}<table class="calendar" border="0" cellpadding="0" cellspacing="0">{/table_open}


   {week_row_start}<tr class="calendar_dow">{/week_row_start}
   {week_day_cell}<th>{week_day}</th>{/week_day_cell}
   {week_row_end}</tr>{/week_row_end}

   {cal_row_start}<tr class="calendar_days">{/cal_row_start}
   {cal_cell_start}<td  class="day">{/cal_cell_start}

   {cal_cell_content}<div class="num">{day}</div>{content}{/cal_cell_content}
   {cal_cell_content_today}<div class="num  highlight">{day}</div>{content}{/cal_cell_content_today}

   {cal_cell_no_content}<div class="num">{day}</div>{/cal_cell_no_content}
   {cal_cell_no_content_today}<div class="num highlight">{day}</div>{/cal_cell_no_content_today}

   {cal_cell_blank}&nbsp;{/cal_cell_blank}

   {cal_cell_end}</td>{/cal_cell_end}
   {cal_row_end}</tr>{/cal_row_end}

   {table_close}</table>{/table_close}';
  
		$data = $this->count_num_appointment($year,$month,$location_id);
		//echo '<pre>data'; print_r($data); die;
		 $this->load->library('calendar',$this->config);
		//return $this->calendar->generate($year,$month,$location_id);
		return $this->calendar->generate($year,$month,$data,$location_id);
	}
	
	
	
	
	
	function count_num_appointment($year,$month,$location_id){
		
		$this->db->order_by('id','ASC');
		$first_location = $this->db->get('tblcontact')->row_array();
		$first_location_id = $first_location['id'];
		
		
		$date_data = array();
		//get category sorting details;
		$cat_index=array();	
		if ($year == '')
			$year  = date("Y");

		if ($month == '')
			$month = date("m");
		
		$this->db->where("cat_type", "calendar");
		$this->db->order_by("pos", "ASC");
		$query = $this->db->get("tblcategory");
			foreach($query->result() as $row):
				$cat_index[]= $row->cat_id;								
			endforeach;	
			
					
		
		$monthday = '';
		$weekday = '';
		$yearday = '';
		for($day = 1; $day<=31; $day++){
			
			if($day < 10):
				$this_date = "$year-$month-0$day";
			else:
				$this_date = "$year-$month-$day";
			endif;
			
		/*------------------- iteration for no repeat and repeat daily -----------------*/
			$where = " where mydate = '".$this_date."'";
			
			//$this->db->where("mydate", $this_date);
			
			
			
			
			/*if($location_id != 0){
				//$this->db->where("location_id", $location_id);
				
				$where .= " and location_id = '".$location_id."'";
			}else{
			
				$where .= " AND (location_id = 0 OR location_id = {$first_location_id})";
			
			}*/
			
			if($location_id != 0){
				$where .= " and location_id = '".$location_id."'";
			}
			//$this->db->where("repeat", "Never");
			//$this->db->or_where("repeat", "Every day");
			
			if($location_id != 0){
				$where .= " and location_id = '".$location_id."'";
			}
			
			$where .= " and `repeat` = 'never' OR `repeat` = 'Every day'"; 
			
			$where .= " and `category` <> 52";
			
			$where .= " and `published` = 1";
			
			$order_by = " order by STR_TO_DATE(start, '%l:%i %p')";
			
			//$this->db->order_by("STR_TO_DATE(start, '%l:%i %p')", "ASC");
			//$query = $this->db->get("tblcalendar");
			
			$sql = "select * from tblcalendar ".$where.$order_by;
			
			$query = $this->db->query($sql);
			
			//echo $this->db->last_query();
			
			$temp_c = '';
			$temp_c2 = '';
			$temp_c3 = '';
			$temp_c4 = '';			
			
			
			$arr_temp_c1 = array();
			$arr_temp_c2 = array();
			$arr_temp_c3 = array();
			$arr_temp_c4 = array();	
			
			/**
			 * @param WHERE repeat == NERVER or repeat == 'EVERY DAY'
			 *
			 * @throws \
			 *
			 * @return \ 'RETURNS DAILY'
			 */
			//echo '<pre>'; print_r($query->result()); die;
			foreach($query->result() as $row):
				//echo '<pre>row'; print_r($row); 
				if(!empty($row->category)){
					$this->db->where('cat_id',$row->category);
					$parent_category = $this->db->get('tblcategory')->row_array();
					
				} 
				
				if(strtotime($this_date . ' 00:00:00') <= strtotime($row->mydate)) {
					
					// changelog v2 - get exception
					$sql = "Select * From tblexception where cal_id = ".$row->id." AND exception_date >= '".$this_date."'";
					$result = $this->db->query($sql);
					$num_rows = $result->num_rows();
					$excp_found = false;
					if($num_rows){
						foreach($result->result() as $excp){
							if($excp->exception_date == $this_date){
								$excp_found = true;
							}
						}
					}
					
				
					
					//if($row->exception_date && $row->exception_date != '0000-00-00' && $row->exception_date == $this_date){
					if($excp_found){
					
						
					}else{
						$component['location_id'] = $row->location_id;
						$component['frequency'] = 'daily';
						$component['start'] = $row->start;
						$component['end'] = $row->end;
						$component['title'] = $row->title;
						$component['category'] = $row->category;
						$component['isWhole'] = $row->isWhole;
						$component['mydate'] = date_format(date_create($row->mydate), 'm/d/Y');
						$component['content'] = $row->content;
						$component['id'] = $row->id;
						$component['published'] = $row->published;
						//$component['event_id'] = isset($row->event_id) ? $row->event_id : 0;
						$component['show_even_on_closed_days'] = isset($row->show_even_on_closed_days) ? $row->show_even_on_closed_days : '';
						$component['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row->start)).':00');
						
						$arr_temp_c1[] = $component;
						
						
						$temp = "<span class='time'>".$row->start."</span>";
						##$temp = "<span class='time'>".$row->start."  - NEVERS REPEAT OR EVERYDAY</span>";
						$temp2 ='<ul class="more_info">
									<li class="header_'.$row->category.'">'.$row->title.'</li>
									<li class="date">'.date_format(date_create($row->mydate), 'm/d/Y').'</li>';
									
						$temp2 .=($row->start && $row->end )?'<li class="time">'.$row->start.'&nbsp;-&nbsp;'.$row->end.'</li>':'';					
						$temp2 .='<li class="blurb">'.html_entity_decode($row->content).'</li>
									<li class="close"><a href="#">x</a>
								</ul>';
						$temp_c .= "<div  class='category cat_".$row->category."'>".$row->title.$temp.$temp2."</div>";
					}
					
				}
			endforeach;
			
			
			/*------------------- end iteration for no repeat and repeat daily -----------------*/
		
			/*------------------- iteration for repeat weekly -----------------*/
			
			#$this->db->where("repeat", "Every week");
			
			#$where = " where mydate = '".$this_date."'"; //added by luigi
			
			$where = " where `repeat` = 'Every week'";
			
			/*if($location_id != 0){
				//$this->db->where("location_id", $location_id);
				$where .= " and location_id = '".$location_id."'";
			}else{
			
				$where .= " AND (location_id = 0 OR location_id = {$first_location_id})";
				
			}*/
			
			if($location_id != 0){
				$where .= " and location_id = '".$location_id."'";
			}
			
			$where .= " and `category` <> 52";
			
			$where .= " and `published` = 1";
			//$this->db->order_by("start", "ASC");
			
			$order_by = " order by STR_TO_DATE(start, '%l:%i %p')";
			//$order_by = " order by STR_TO_DATE(start, '%l:%i %p')";
			
			//$query2 = $this->db->get("tblcalendar");
			
			$sql = "select * from tblcalendar ".$where.$order_by;
			
			$query2 = $this->db->query($sql);
			
			
			
			/**
			 * @param WHERE repeat == Every week
			 *
			 * @throws \
			 *
			 * @return \ 'RETURNS WEEKLY'
			 */
			
			
			foreach($query2->result() as $row2):
				
				if(
				date('w', strtotime($row2->mydate)) == date('w', strtotime($this_date . ' 00:00:00')) 
				&& 
				strtotime($this_date . ' 00:00:00') >= strtotime($row2->mydate)) {
				
					
					
					if(!empty($row2->category)){
						$this->db->where('cat_id',$row2->category);
						$parent_category = $this->db->get('tblcategory')->row_array();
					}
					
					
					// changelog v2 - get exception
					$sql = "Select * From tblexception where cal_id = ".$row2->id." AND exception_date >= '".$this_date."'";
					$result = $this->db->query($sql);
					$num_rows = $result->num_rows();
					$excp_found = false;
					if($num_rows){
						foreach($result->result() as $excp){
							if($excp->exception_date == $this_date){
								$excp_found = true;
							}
						}
					}
				
					// if($row2->exception_date && $row2->exception_date != '0000-00-00' && $row2->exception_date == $this_date){
					if($excp_found){	
						
						
					}else{
						$component['location_id'] = $row2->location_id;
						$component['frequency'] = 'weekly';
						$component['start'] = $row2->start;
						$component['end'] = $row2->end;
						$component['title'] = $row2->title;
						$component['category'] = $row2->category;
						$component['isWhole'] = $row2->isWhole;
						$component['mydate'] = date_format(date_create($row2->mydate), 'm/d/Y');
						$component['content'] = $row2->content;
						$component['id'] = $row2->id;
						$component['published'] = $row2->published;
						//$component['event_id'] = isset($row2->event_id) ? $row->event_id : 0;
						$component['show_even_on_closed_days'] = isset($row2->show_even_on_closed_days) ? $row2->show_even_on_closed_days : '';
						$component['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row2->start)).':00');
						
						$arr_temp_c2[] = $component;
						
						
						
						$temp = "<span class='time'>".$row2->start."</span>";
						
						##$temp = "<span class='time'>".$row2->start." - WEEKLYS </span>";
						
						$temp2 ='<ul class="more_info">
								<li class="header_'.$row2->category.'">'.$row2->title.'</li>
								
								<li class="date">'.date_format(date_create($this_date), 'm/d/Y').'</li>';
						$temp2 .=($row2->start && $row2->end)?'<li class="time">'.$row2->start.'&nbsp;-&nbsp;'.$row2->end.'</li>':'';
						$temp2 .='<li class="blurb">'.html_entity_decode($row2->content).'</li>
								<li class="close"><a href="#">x</a>
							</ul>';
						$weekday = date_format(date_create($row2->mydate), 'D');
						
						$temp_c2 .= "<div  class='category cat_".$row2->category."'>".$row2->title.$temp.$temp2."</div>";	
					}
	
				}
			
			endforeach;
			
			
			
			
			/*------------------- end iteration for no repeat and repeat weekly -----------------*/
		
			/*------------------- iteration for repeat monthly -----------------*/
			/*if($day < 10):
				$this->db->where("mydate REGEXP ", "^[[:digit:]]{4}-[[:digit:]]{2}-0$day$");				
			else:
				$this->db->where("mydate REGEXP ", "^[[:digit:]]{4}-[[:digit:]]{2}-$day$");
			endif;*/
			
			$where = ' where mydate REGEXP "^[[:digit:]]{4}-[[:digit:]]{2}-'.str_pad($day, 2, 0, STR_PAD_LEFT).'$"';
			
			//$this->db->where("repeat", "Every month");
			
			$where .= " and `repeat` = 'Every month'";
			
			/*if($location_id != 0){
				//$this->db->where("location_id", $location_id);
				
				$where .= " and location_id = '".$location_id."'";
			}else{
			
				$where .= " AND (location_id = 0 OR location_id = {$first_location_id})";
			
			}*/
			
			if($location_id != 0){
				$where .= " and location_id = '".$location_id."'";
			}
			
			$where .= " and `category` <> 52";
			
			$where .= " and `published` = 1";
			//$this->db->order_by("start", "ASC");
			
			$order_by = " order by STR_TO_DATE(start, '%l:%i %p')";
			
			$sql = "select * from tblcalendar ".$where.$order_by;
			
			$query3 = $this->db->query($sql);
			
			
			//$query3 = $this->db->get("tblcalendar");
			
			
			/**
			 * @param WHERE repeat == MONTHLY
			 *
			 * @throws \
			 *
			 * @return \ 'RETURNS NOTHING'
			 */
			
			foreach($query3->result() as $row3):
			
				if(date('d', strtotime($row3->mydate . ' 00:00:00')) == date('d', strtotime($this_date . ' 00:00:00')) && 
				$this_date >= $row3->mydate) {
					
					if(!empty($row3->category)){
						$this->db->where('cat_id',$row3->category);
						$parent_category = $this->db->get('tblcategory')->row_array();
					}
					
					
					// changelog v2 - get exception
					$sql = "Select * From tblexception where cal_id = ".$row3->id." AND exception_date >= '".$this_date."'";
					$result = $this->db->query($sql);
					$num_rows = $result->num_rows();
					$excp_found = false;
					if($num_rows){
						foreach($result->result() as $excp){
							if($excp->exception_date == $this_date){
								$excp_found = true;
							}
						}
					}
					
					//if($row3->exception_date && $row3->exception_date != '0000-00-00' && $row3->exception_date == $this_date){
					if($excp_found){
					

					}else{
						$component['location_id'] = $row3->location_id;
						$component['frequency'] = 'monthly';
						$component['start'] = $row3->start;
						$component['end'] = $row3->end;
						$component['title'] = $row3->title;
						$component['category'] = $row3->category;
						$component['isWhole'] = $row3->isWhole;
						$component['mydate'] = date_format(date_create($row3->mydate), 'm/d/Y');
						$component['content'] = $row3->content;
						$component['id'] = $row3->id;
						$component['published'] = $row3->published;
						//$component['event_id'] = isset($row3->event_id) ? $row3->event_id : 0;
						$component['show_even_on_closed_days'] = isset($row3->show_even_on_closed_days) ? $row3->show_even_on_closed_days : '';
						$component['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row3->start)).':00');
						
						$arr_temp_c3[] = $component;
						
						
						$temp = "<span class='time'>".$row3->start."</span>";
						$temp2 ='<ul class="more_info">
								<li class="header_'.$row3->category.'">'.$row3->title.'</li>
								
								<li class="date">'.date_format(date_create($this_date), 'm/d/Y').'</li>';
						$temp2 .=($row3->start && $row3->end)?'<li class="time">'.$row3->start.'&nbsp;-&nbsp;'.$row3->end.'</li>':'';					
						$temp2 .='<li class="blurb">'.html_entity_decode($row3->content).'</li>
								<li class="close"><a href="#">x</a>
							</ul>';
						$monthday = date_format(date_create($row3->mydate), 'j');
						$temp_c3 .= "<div  class='category cat_".$row3->category."'>".$row3->title.$temp.$temp2."</div>";
					}
				}
						
			endforeach;
			/*------------------- end iteration for no repeat and repeat monthly -----------------*/		
		
			/*------------------- iteration for repeat yearly -----------------*/
			
			
			
			if($day < 10):
				
				$date_where = "MONTH(mydate) = '{$month}' AND DAY(mydate) = '0{$day}' ";
				
				$this->db->where($date_where);
				//$this->db->where("mydate REGEXP ", "^[[:digit:]]{4}-$month-0$day$");
			else:
				//$this->db->where("mydate REGEXP ", "^[[:digit:]]{4}-$month-$day$");
			
				$date_where = "MONTH(mydate) = '{$month}' AND DAY(mydate) = '0{$day}' ";
				
				$this->db->where($date_where);
				
			
			endif;
						
			$this->db->where("repeat", "Every year");
			/*if($location_id != 0){
				$this->db->where("location_id", $location_id);
			}else{
				$this->db->where("(location_id = 0 OR location_id = {$first_location_id})");
			}*/
			
			if($location_id != 0){
				$this->db->where("location_id", $location_id);
			}
			
			$this->db->where('category <> 52');
			$this->db->where('published', 1);
			
			$this->db->order_by("start", "ASC");
			$query4 = $this->db->get("tblcalendar");
			
			#echo $this->db->last_query();
			//pre($query4->result_array());
			
			/**
			 * @param WHERE repeat == YEARLY
			 *
			 * @throws \
			 *
			 * @return \ 'RETURNS YEARLY'
			 */
			
			foreach($query4->result() as $row4):
				
				if(date('m-d', strtotime($row4->mydate)) == date('m-d', strtotime($this_date . ' 00:00:00')) && 
					strtotime($this_date . ' 00:00:00') >= strtotime($row4->mydate)) {
					
					if(!empty($row4->category)){
						$this->db->where('cat_id',$row4->category);
						$parent_category = $this->db->get('tblcategory')->row_array();
					}
					
						// changelog v2 - get exception
						$sql = "Select * From tblexception where cal_id = ".$row4->id." AND exception_date >= '".$this_date."'";
						$result = $this->db->query($sql);
						$num_rows = $result->num_rows();
						$excp_found = false;
						if($num_rows){
							foreach($result->result() as $excp){
								if($excp->exception_date == $this_date){
									$excp_found = true;
								}
							}
						}
					
						// if($row4->exception_date && $row4->exception_date != '0000-00-00' && $row4->exception_date == $this_date){
						if($excp_found){
							// hide exceptions	
							/* $temp = "<span class='time'>".$row4->start."</span>";
							$temp2 ='<ul class="more_info">
									<li class="header_'.$row4->category.'">'.$row4->title.'</li>
									<li class="date">'.date_format(date_create($this_date), 'F d, Y').'</li>';
							
							$temp2 .='<li class="blurb">'.html_entity_decode($row4->exception_text).'</li>
									<li class="close"><a href="#">x</a>
								</ul>';
							$yearday = date_format(date_create($row4->mydate), 'm-j');
							$temp_c4 .= "<div  class='category cat_52'>".$row4->title.$temp.$temp2."</div>"; */
							
						}else{
							$component['location_id'] = $row4->location_id;
							$component['frequency'] = 'yearly';
							$component['start'] = $row4->start;
							$component['end'] = $row4->end;
							$component['title'] = $row4->title;
							$component['category'] = $row4->category;
							$component['isWhole'] = $row4->isWhole;
							$component['mydate'] = date_format(date_create($row4->mydate), 'm/d/Y');
							$component['content'] = $row4->content;
							$component['id'] = $row4->id;
							$component['published'] = $row4->published;
							//$component['event_id'] = isset($row4->event_id) ? $row4->event_id : 0;
							$component['show_even_on_closed_days'] = isset($row4->show_even_on_closed_days) ? $row4->show_even_on_closed_days : '';
							$component['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row4->start)).':00');
						
							$arr_temp_c4[] = $component;
						
							$temp = "<span class='time'>".$row4->start."</span>";
							$temp2 ='<ul class="more_info">
									<li class="header_'.$row4->category.'">'.$row4->title.'</li>
									<li class="date">'.date_format(date_create($this_date), 'm/d/Y').'</li>';
							$temp2 .=($row4->start && $row4->end)?'<li class="time">'.$row4->start.'&nbsp;-&nbsp;'.$row4->end.'</li>':'';						
							$temp2 .='<li class="blurb">'.html_entity_decode($row4->content).'</li>
									<li class="close"><a href="#">x</a>
								</ul>';
							$yearday = date_format(date_create($row4->mydate), 'm-j');
							$temp_c4 .= "<div  class='category cat_".$row4->category."'>".$row4->title.$temp.$temp2."</div>";
						}
				}		
			endforeach;
			
			/*------------------- end iteration for no repeat and repeat yearly -----------------*/	
		
		
			
			$where = '';
			$where .= "WHERE `category` <> 52 ";
			/*if($location_id != 0){
				$where = "WHERE location_id = '".$location_id."'";
				$where .= " and `category` <> 52";
			}
			else{
				
				$where .= "WHERE `category` <> 52 AND (location_id = 0 OR location_id = {$first_location_id})";
				
			}*/
			if($location_id != 0){
				$where = "WHERE location_id = '".$location_id."'";
				$where .= " and `category` <> 52";
			}
			
			$where .= " AND `is_multiple` = 1"; 
			
			$where .= " and `published` = 1";
			$order_by = " order by STR_TO_DATE(start, '%l:%i %p')";
			
			$sql = "select * from tblcalendar ".$where.$order_by;
			
			
			
			$query5 = $this->db->query($sql);
			
			#echo $this->db->last_query();
						
			$arr_temp_c5 = array();	
			
			/**
			 * @param MULTIPLE DATES
			 *
			 * @throws \
			 *
			 * @return \ 'MULTIPLE DATES'
			 */
			//echo '<pre>'; print_r($query5->result_array()); die; 
			
			foreach($query5->result_array() as $row5):
				
				if(!empty($row5['category'])){
					$this->db->where('cat_id',$row5['category']);
					$parent_category = $this->db->get('tblcategory')->row_array();
				}
				
							   $this->db->where('event_id',$row5['id']);
				$multi_dates = $this->db->get('tbl_calendar_dates')->result_array();
				
				foreach($multi_dates as $i=>$item){
					
					switch($item['repeat']){
					
						case 'never':

							if(strtotime($this_date . ' 00:00:00') == strtotime($item['date'])) {
								
								$component['location_id'] = $row5['location_id'];
								$component['frequency'] = $item['repeat'];
								$component['start'] = $item['start'];
								$component['end'] = $item['end'];
								$component['title'] = $row5['title'];
								$component['category'] = $row5['category'];
								$component['isWhole'] = $item['isWhole'];
								$component['id'] = $item['id'];
								$component['published'] = $row5['published'];
								//$component['event_id'] = isset($item['event_id']) ? $item['event_id'] : 0;
								$component['show_even_on_closed_days'] = isset($row5['show_even_on_closed_days']) ? $row5['show_even_on_closed_days'] : '';
								$component['mydate'] = date_format(date_create($item['date']), 'm/d/Y');
								$component['content'] = $row5['content'];
								$component['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($item['start'])).':00');
						
								$arr_temp_c5[] = $component;
							
							}
						
						break;
						
						
						case 'Every week':
							
							
							if(
							date('w', strtotime($item['date'])) == date('w', strtotime($this_date . ' 00:00:00')) 
							&& 
							strtotime($this_date . ' 00:00:00') >= strtotime($item['date'])) {
								
								$is_repeat_weekly = 1;
								if(!empty($item['end_date'])){
									$last_week_date = date('Y-m-d', strtotime($item['end_date']));
									$last_week_date = strtotime($last_week_date);
									
									$current_calendar_date = strtotime($this_date);
									
									if($current_calendar_date > $last_week_date){
										$is_repeat_weekly = 0;
									}
								}
								
								if($is_repeat_weekly == 1){
								
									$component['location_id'] =  $row5['location_id'];
									$component['frequency'] = $item['repeat'];
									$component['start'] = $item['start'];
									$component['end'] = $item['end'];
									$component['title'] = $row5['title'];
									$component['category'] = $row5['category'];
									$component['isWhole'] = $item['isWhole'];
									$component['id'] = $item['id'];
									$component['published'] = $row5['published'];
									$component['show_even_on_closed_days'] = isset($row5['show_even_on_closed_days']) ? $row5['show_even_on_closed_days'] : '';
									$component['mydate'] = date_format(date_create($item['date']), 'm/d/Y');
									$component['content'] = $row5['content'];
									$component['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($item['start'])).':00');
							
									$arr_temp_c5[] = $component;
								
								}
									
							}
												
						break;
						
						
						case 'Every year';
							
							if(date('m-d', strtotime($item['date'])) == date('m-d', strtotime($this_date . ' 00:00:00')) && 
							strtotime($this_date . ' 00:00:00') >= strtotime($item['date'])) {
						
								$component['location_id'] =  $row5['location_id'];
								$component['frequency'] = $item['repeat'];
								$component['start'] = $item['start'];
								$component['end'] = $item['end'];
								$component['title'] = $row5['title'];
								$component['category'] = $row5['category'];
								$component['isWhole'] = $item['isWhole'];
								$component['id'] = $item['id'];
								$component['published'] = $row5['published'];
								$component['show_even_on_closed_days'] = isset($row5['show_even_on_closed_days']) ? $row5['show_even_on_closed_days'] : '';
								$component['mydate'] = date_format(date_create($item['date']), 'm/d/Y');
								$component['content'] = $row5['content'];
								$component['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($item['start'])).':00');
						
								$arr_temp_c5[] = $component;
									
							}
						
						break;
					
					} 
				
				} //endforeach multidates
				
				
			endforeach;
			
			
			/*
			echo '<h1>arr_temp_c1</h1>';
			pre($arr_temp_c1);
			
			echo '<h1>arr_temp_c2</h1>';
			pre($arr_temp_c2);
			
			echo '<h1>arr_temp_c3</h1>';
			pre($arr_temp_c3);
			
			echo '<h1>arr_temp_c4</h1>';
			pre($arr_temp_c4);
			echo '<h1>arr_temp_c5</h1>';
			pre($arr_temp_c5);
			*/
			
			
			$merging1 = array_merge($arr_temp_c1,$arr_temp_c2);
			
			$merging2 = array_merge($arr_temp_c3,$arr_temp_c4);
			
			$merging3 = array_merge($merging1,$merging2);
			
			$merging4 = array_merge($merging3,$arr_temp_c5);
			
			#echo '<h1>merging3 UNSORTED</h1>';
			#pre($merging3);
			
			$sorted = $this->sortArray($merging4,'timestamp');
			
			//echo '<pre>sorted'; print_r($sorted); die;
			//echo '<h1>arr_temp_c5</h1>';
			//pre($arr_temp_c5);
			
			//echo '<h1>merging3 SORTED</h1>';
			#pre($sorted);
		#	
			
			
			
            $html = '';
			foreach($sorted as $i=>$item){
				
				if($item['published'] == 1){
					$category_detail = $this->query_model->getbySpecific('tblcategory', 'cat_id', $item['category']);
					$cat_color = isset($category_detail[0]->color) ? $category_detail[0]->color : '';
					$html .= '
						<div data-location="'.$item['location_id'].'" class="category cat_'.$item['category']. ' '.$cat_color.'">'.$item['title'].'
							<span class="time">'.($item['isWhole'] == 1 ? '' : $item['start']).'</span>
							<ul class="more_info">
								<li class="header_'.$item['category'].' '.$cat_color.'_more_info'.'">'.$item['title'].'</li>
								<li class="date">'.date_format(date_create($this_date), 'm/d/Y').'</li>
								<li class="time">'.($item['isWhole'] == 1 ? '' : $item['start'].' - '.$item['end']).'</li>';
								
								$event_location_name = $this->getMultiCalendarLocationName($item['location_id']);
							if(!empty($event_location_name)){
								$html .= '<li class="location_name">Location: '.$event_location_name.'</li>';
							}
							
							$html .= '<li class="blurb">'.html_entity_decode($item['content']).'</li>
								<li class="close"><a href="#">x</a></li>
							</ul>
						</div>
					';
				}
				
			}
			
			
			//closed days SINGLE
			$this->db->where("repeat", "never");
			$this->db->where("mydate", $this_date);			
			$this->db->where("category", 52);
			/*if($location_id != 0){
				$this->db->where("location_id", $location_id);
			}else{
				$this->db->where("(location_id = 0 OR location_id = {$first_location_id})");
			}*/
			
			if($location_id != 0){
				$this->db->where("location_id", $location_id);
			}
			$this->db->where("published", 1);
			$closed_days = $this->db->get("tblcalendar");
			
			$closed_day_count = $closed_days->num_rows();
			
			$sorted_date_data = $matches = array();
			
			//THIS IS FOR CLOSED DAY AND IT IS MULTIPLE 
			
			$extra_where = '';
			/*if($location_id != 0){
				$extra_where = " AND cal.location_id = {$location_id}";
			}else{
				$extra_where = " AND (cal.location_id = 0 OR cal.location_id = {$first_location_id})";
			}*/
			
			if($location_id != 0){
				$extra_where = " AND cal.location_id = {$location_id}";
			}
			
			$query = "SELECT cal.category, cal.location_id,cal.content, cal.title, cal.published, cal.is_multiple, dates.* FROM tblcalendar as cal
INNER JOIN tbl_calendar_dates as dates 

ON dates.event_id = cal.id
WHERE dates.date = '{$this_date}' AND cal.is_multiple = 1 and cal.published = 1 and cal.category = 52 {$extra_where};";
			
			$closed_days_multiple = $this->db->query($query);
 			
			$closed_day_count_multiple = $closed_days_multiple->num_rows();
			
			// vinay new 
			$closed_day_detail = $this->query_model->getbySpecific('tblcategory', 'cat_id', 52);
			
			if($closed_day_count){
				$closed_day_block = '';
				//echo '<pre>'; print_r($closed_days->result()); die;
				foreach($closed_days->result() as $row):
					
					if(strtotime($this_date . ' 00:00:00') >= strtotime($row->mydate)) {
						if($row->published == 1){
							
							$temp = "<span class='time'>".($row->isWhole == 1 ? '' : $row->start)."</span>";
							$temp2 ='<ul class="more_info">
										<li class="header_'.$row->category.' '.$closed_day_detail[0]->color.'_more_info'.'">'.$row->title.'</li>
										<li class="date">'.date_format(date_create($row->mydate), 'm/d/Y').'</li>';
										
							$temp2 .=($row->start && $row->end )?'<li class="time">'.($row->isWhole == 1 ? '' : $row->start.'&nbsp;-&nbsp;'.$row->end).'</li>':'';	
							
							$event_location_name = $this->getMultiCalendarLocationName($row->location_id);
							if(!empty($event_location_name)){
								$temp2 .= '<li class="location_name">Location: '.$event_location_name.'</li>';
							}
							
							$temp2 .='<li class="blurb">'.html_entity_decode($row->content).'</li>
										<li class="close"><a href="#">x</a>
									</ul>';
							$closed_day_block .= "<div  class='category cat_".$row->category.' '.$closed_day_detail[0]->color."'>".$row->title.$temp.$temp2."</div>";
							
						}
						
					}
				endforeach;
				
				
				foreach($sorted as $i=>$item){
					
						//$calendarDetail = $this->query_model->getbySpecific('tblcalendar', 'id', $item['event_id']);
						//if(!empty($calendarDetail)){
							if($item['show_even_on_closed_days'] == 1){
								$category_detail = $this->query_model->getbySpecific('tblcategory', 'cat_id', $item['category']);
								$closed_day_block .= '
									<div data-location="'.$item['location_id'].'" class="category cat_'.$item['category']. ' '.$category_detail[0]->color.'">'.$item['title'].'
										<span class="time">'.($item['isWhole'] == 1 ? '' : $item['start']).'</span>
										<ul class="more_info">
											<li class="header_'.$item['category'].' '.$category_detail[0]->color.'_more_info'.'">'.$item['title'].'</li>
											<li class="date">'.date_format(date_create($this_date), 'm/d/Y').'</li>
											<li class="time">'.($item['isWhole'] == 1 ? '' : $item['start'].' - '.$item['end']).'</li>
											';
										$event_location_name = $this->getMultiCalendarLocationName($item['location_id']);
										if(!empty($event_location_name)){
											$closed_day_block .= '<li class="location_name">Location: '.$event_location_name.'</li>';
										}
							
											$closed_day_block .= '<li class="blurb">'.html_entity_decode($item['content']).'</li>
											<li class="close"><a href="#">x</a></li>
										</ul>
									</div>
								';
							}
							
						//}
			}
				
				$date_data[$day] = $closed_day_block;
				
				
			}
			elseif($closed_day_count_multiple >0){
				$closed_day_block = '';
				
				foreach($closed_days_multiple->result() as $row):
				
					if($row->published == 1){
						if(strtotime($this_date . ' 00:00:00') >= strtotime($row->date)) {
						$temp = "<span class='time'>".($row->isWhole == 1 ? '' : $row->start)."</span>";
						$temp2 ='<ul class="more_info">
									<li class="header_'.$row->category.' '.$closed_day_detail[0]->color.'_more_info'.'">'.$row->title.'</li>
									<li class="date">'.date_format(date_create($row->date), 'm/d/Y').'</li>';
									
						$temp2 .=($row->start && $row->end )?'<li class="time">'.($row->isWhole == 1 ? '' : $row->start.'&nbsp;-&nbsp;'.$row->end).'</li>':'';	
						$event_location_name = $this->getMultiCalendarLocationName($row->location_id);
							if(!empty($event_location_name)){
								$temp2 .= '<li class="location_name">Location: '.$event_location_name.'</li>';
							}						
						$temp2 .='<li class="blurb">'.html_entity_decode($row->content).'</li>
									<li class="close"><a href="#">x</a>
								</ul>';
						$closed_day_block .= "<div  class='category cat_".$row->category."'>".$row->title.$temp.$temp2."</div>";
						
					}
					}
					
				endforeach;
				
				foreach($sorted as $i=>$item){ 
				//echo '<pre>item'; print_r($item); die;
						//echo '<pre>item4==>'; print_r($item);
						//$calendarDetail = $this->query_model->getbySpecific('tblcalendar', 'id', $item['event_id']);
						//if(!empty($calendarDetail)){
							if($item['show_even_on_closed_days'] == 1){
								$category_detail = $this->query_model->getbySpecific('tblcategory', 'cat_id', $item['category']);
								$cat_color = isset($category_detail[0]->color) ? $category_detail[0]->color : '';
								$closed_day_block .= '
									<div data-location="'.$item['location_id'].'" class="category cat_'.$item['category']. ' '.$cat_color.'">'.$item['title'].'
										<span class="time">'.($item['isWhole'] == 1 ? '' : $item['start']).'</span>
										<ul class="more_info">
											<li class="header_'.$item['category'].' '.$cat_color.'_more_info'.'">'.$item['title'].'</li>
											<li class="date">'.date_format(date_create($this_date), 'm/d/Y').'</li>
											<li class="time">'.($item['isWhole'] == 1 ? '' : $item['start'].' - '.$item['end']).'</li>
											';
											
											$event_location_name = $this->getMultiCalendarLocationName($item['location_id']);
										if(!empty($event_location_name)){
											$closed_day_block .= '<li class="location_name">Location: '.$event_location_name.'</li>';
										}
										
										$closed_day_block .= '<li class="blurb">'.html_entity_decode($item['content']).'</li>
											<li class="close"><a href="#">x</a></li>
										</ul>
									</div>
								';
							}
							
						//}
			}
				
				$date_data[$day] = $closed_day_block;
				
			}
			
			
			else{
				
				$date_data[$day] = $html;	
			}
			
			
			
			
			/* changelog v2 - get closed day and overrite all event for this day end  */
							
							
			//data sort by category details
			if (preg_match_all('/<div(.*?)>(.*?)<\/div>/is', $date_data[$day], $matches)) {			  
				foreach($cat_index as $cat_id){									
					foreach($matches[1] as $index =>$data){						
						if(preg_match("/$cat_id/i",$data)){
			 				$sorted_date_data[]=$matches[0][$index];
						}
					}		
				}
			}
			
			#$date_data[$day]=implode("",$sorted_date_data);
		}	
		
		return $date_data;
	}

/******************************************************************************************************************************************************/	
	
	function sortArray( $data, $field ) {
		$field = (array) $field;
		uasort( $data, function($a, $b) use($field) {
			$retval = 0;
			foreach( $field as $fieldname ) {
				 
				//if( $retval == 0 ) $retval = strnatcmp( $a[$fieldname], $b[$fieldname] );
			}
			return $retval;
		} );
		$test[] = $data;
		
		return $data;
	}
	
	
	function count_num_appointment_for_extracting_all_categories_used($year,$month,$location_id){
		$this->db->order_by('id','ASC');
		$first_location = $this->db->get('tblcontact')->row_array();
		$first_location_id = $first_location['id'];
		
		$date_data = array();
		//get category sorting details;
		$cat_index=array();	
		if ($year == '')
			$year  = date("Y");

		if ($month == '')
			$month = date("m");
		
		$this->db->where("cat_type", "calendar");
		$this->db->order_by("pos", "ASC");
		$query = $this->db->get("tblcategory");
		
			foreach($query->result() as $row):
				$cat_index[]= $row->cat_id;								
			endforeach;			
		
		$monthday = '';
		$weekday = '';
		$yearday = '';
		for($day = 1; $day<=31; $day++){
			
			if($day < 10):
				$this_date = "$year-$month-0$day";
			else:
				$this_date = "$year-$month-$day";
			endif;
			
		/*------------------- iteration for no repeat and repeat daily -----------------*/
			$where = " where mydate = '".$this_date."'";
			
			//$this->db->where("mydate", $this_date);
			
			/*if($location_id != 0){
				//$this->db->where("location_id", $location_id);
				
				$where .= " and location_id = '".$location_id."'";
			}else{
			
				$where .= " AND (location_id = 0 OR location_id = {$first_location_id})";
			
			}*/
			//$this->db->where("repeat", "Never");
			//$this->db->or_where("repeat", "Every day");
			
			$where .= " and `repeat` = 'never' OR `repeat` = 'Every day'"; 
			
			$where .= " and `category` <> 52";
			
			$where .= " and `published` = 1";
			
			$order_by = " order by STR_TO_DATE(start, '%l:%i %p')";
			
			//$this->db->order_by("STR_TO_DATE(start, '%l:%i %p')", "ASC");
			//$query = $this->db->get("tblcalendar");
			
			$sql = "select * from tblcalendar ".$where.$order_by;
			
			$query = $this->db->query($sql);
			
			//echo $this->db->last_query();
			
			$temp_c = '';
			$temp_c2 = '';
			$temp_c3 = '';
			$temp_c4 = '';			
			
			
			$arr_temp_c1 = array();
			$arr_temp_c2 = array();
			$arr_temp_c3 = array();
			$arr_temp_c4 = array();	
			
			/**
			 * @param WHERE repeat == NERVER or repeat == 'EVERY DAY'
			 *
			 * @throws \
			 *
			 * @return \ 'RETURNS DAILY'
			 */
			
			foreach($query->result() as $row):
				
				
						$this->db->where('cat_id',$row->category);
					$parent_category = $this->db->get('tblcategory')->row_array();
					
				
				
				if(strtotime($this_date . ' 00:00:00') <= strtotime($row->mydate)) {
					
					// changelog v2 - get exception
					$sql = "Select * From tblexception where cal_id = ".$row->id." AND exception_date >= '".$this_date."'";
					$result = $this->db->query($sql);
					
					$num_rows = $result->num_rows();
					$excp_found = false;
					if($num_rows){
						foreach($result->result() as $excp){
							if($excp->exception_date == $this_date){
								$excp_found = true;
							}
						}
					}
					
				
					
					//if($row->exception_date && $row->exception_date != '0000-00-00' && $row->exception_date == $this_date){
					if($excp_found){
						
						
					}else{
						$component[$row->category]['category'] = $row->category;
						$component[$row->category]['frequency'] = 'daily';
						$component[$row->category]['start'] = $row->start;
						$component[$row->category]['end'] = $row->end;
						$component[$row->category]['title'] = $row->title;
						$component[$row->category]['category'] = $row->category;
						$component[$row->category]['isWhole'] = $row->isWhole;
						$component[$row->category]['mydate'] = date_format(date_create($row->mydate), 'm/d/Y');
						$component[$row->category]['content'] = $row->content;
						$component[$row->category]['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row->start)).':00');
						
						$arr_temp_c1[] = $component;
						
						//echo '<pre>';print_r($row); die;
					
						$temp = "<span class='time'>".$row->start."</span>";
						##$temp = "<span class='time'>".$row->start."  - NEVERS REPEAT OR EVERYDAY</span>";
						$temp2 ='<ul class="more_info">
									<li class="header_'.$row->category.'">'.$row->title.'</li>
									<li class="date">'.date_format(date_create($row->mydate), 'm/d/Y').'</li>';
									
						$temp2 .=($row->start && $row->end )?'<li class="time">'.($row->isWhole == 1 ? 'All Day' : $row->start.'&nbsp;-&nbsp;'.$row->end).'</li>':'';					
						$temp2 .='<li class="blurb">'.html_entity_decode($row->content).'</li>
									<li class="close"><a href="#">x</a>
								</ul>';
						$temp_c .= "<div  class='category cat_".$row->category."'>".$row->title.$temp.$temp2."</div>";
					}
					
				}
			endforeach;
			
			
			/*------------------- end iteration for no repeat and repeat daily -----------------*/
		
			/*------------------- iteration for repeat weekly -----------------*/
			
			#$this->db->where("repeat", "Every week");
			
			#$where = " where mydate = '".$this_date."'"; //added by luigi
			
			$where = " where `repeat` = 'Every week'";
			
			/*if($location_id != 0){
				//$this->db->where("location_id", $location_id);
				$where .= " and location_id = '".$location_id."'";
			}else{
			
				$where .= " AND (location_id = 0 OR location_id = {$first_location_id})";
			
			}*/
			
			$where .= " and `category` <> 52";
			
			//$this->db->order_by("start", "ASC");
			$where .= " and `published` = 1";
			$order_by = " order by STR_TO_DATE(start, '%l:%i %p')";
			
			//$query2 = $this->db->get("tblcalendar");
			
			$sql = "select * from tblcalendar ".$where.$order_by;
			
			$query2 = $this->db->query($sql);
			
		
			
			/**
			 * @param WHERE repeat == Every week
			 *
			 * @throws \
			 *
			 * @return \ 'RETURNS WEEKLY'
			 */
			
			
			foreach($query2->result() as $row2):

				if(
				date('w', strtotime($row2->mydate)) == date('w', strtotime($this_date . ' 00:00:00')) 
				&& 
				strtotime($this_date . ' 00:00:00') >= strtotime($row2->mydate)) {
				
					
					
					
										$this->db->where('cat_id',$row2->category);
					$parent_category = $this->db->get('tblcategory')->row_array();
					
					
					// changelog v2 - get exception
					$sql = "Select * From tblexception where cal_id = ".$row2->id." AND exception_date >= '".$this_date."'";
					$result = $this->db->query($sql);
					$num_rows = $result->num_rows();
					$excp_found = false;
					if($num_rows){
						foreach($result->result() as $excp){
							if($excp->exception_date == $this_date){
								$excp_found = true;
							}
						}
					}
				
					// if($row2->exception_date && $row2->exception_date != '0000-00-00' && $row2->exception_date == $this_date){
					if($excp_found){	
						
						
					}else{
						
						$component[$row2->category]['category'] = $row2->category;
						$component[$row2->category]['frequency'] = 'weekly';
						$component[$row2->category]['start'] = $row2->start;
						$component[$row2->category]['end'] = $row2->end;
						$component[$row2->category]['title'] = $row2->title;
						$component[$row2->category]['category'] = $row2->category;
						$component[$row2->category]['isWhole'] = $row2->isWhole;
						$component[$row2->category]['mydate'] = date_format(date_create($row2->mydate), 'm/d/Y');
						$component[$row2->category]['content'] = $row2->content;
						$component[$row2->category]['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row2->start)).':00');
						
						$arr_temp_c2[] = $component;
						
						
						
						$temp = "<span class='time'>".$row2->start."</span>";
						
						##$temp = "<span class='time'>".$row2->start." - WEEKLYS </span>";
						
						$temp2 ='<ul class="more_info">
								<li class="header_'.$row2->category.'">'.$row2->title.'</li>
								
								<li class="date">'.date_format(date_create($this_date), 'm/d/Y').'</li>';
						$temp2 .=($row2->start && $row2->end)?'<li class="time">'.($row2->isWhole == 1 ? 'All Day' : $row2->start.'&nbsp;-&nbsp;'.$row2->end).'</li>':'';
						$temp2 .='<li class="blurb">'.html_entity_decode($row2->content).'</li>
								<li class="close"><a href="#">x</a>
							</ul>';
						$weekday = date_format(date_create($row2->mydate), 'D');
						
						$temp_c2 .= "<div  class='category cat_".$row2->category."'>".$row2->title.$temp.$temp2."</div>";	
					}
	
				}
			
			endforeach;
			
			
			
			
			/*------------------- end iteration for no repeat and repeat weekly -----------------*/
		
			/*------------------- iteration for repeat monthly -----------------*/
			/*if($day < 10):
				$this->db->where("mydate REGEXP ", "^[[:digit:]]{4}-[[:digit:]]{2}-0$day$");				
			else:
				$this->db->where("mydate REGEXP ", "^[[:digit:]]{4}-[[:digit:]]{2}-$day$");
			endif;*/
			
			$where = ' where mydate REGEXP "^[[:digit:]]{4}-[[:digit:]]{2}-'.str_pad($day, 2, 0, STR_PAD_LEFT).'$"';
			
			//$this->db->where("repeat", "Every month");
			
			$where .= " and `repeat` = 'Every month'";
			
			/*if($location_id != 0){
				//$this->db->where("location_id", $location_id);
				
				$where .= " and location_id = '".$location_id."'";
			}
			else{
			
				$where .= " AND (location_id = 0 OR location_id = {$first_location_id})";
			
			}*/
			$where .= " and `category` <> 52";
			$where .= " and `published` = 1";
			//$this->db->order_by("start", "ASC");
			
			$order_by = " order by STR_TO_DATE(start, '%l:%i %p')";
			
			$sql = "select * from tblcalendar ".$where.$order_by;
			
			$query3 = $this->db->query($sql);
			
			
			//$query3 = $this->db->get("tblcalendar");
			
			
			/**
			 * @param WHERE repeat == MONTHLY
			 *
			 * @throws \
			 *
			 * @return \ 'RETURNS NOTHING'
			 */
			
			foreach($query3->result() as $row3):
			
				if(date('d', strtotime($row3->mydate . ' 00:00:00')) == date('d', strtotime($this_date . ' 00:00:00')) && 
				$this_date >= $row3->mydate) {
					
						$this->db->where('cat_id',$row3->category);
					$parent_category = $this->db->get('tblcategory')->row_array();
					
					
					// changelog v2 - get exception
					$sql = "Select * From tblexception where cal_id = ".$row3->id." AND exception_date >= '".$this_date."'";
					$result = $this->db->query($sql);
					$num_rows = $result->num_rows();
					$excp_found = false;
					if($num_rows){
						foreach($result->result() as $excp){
							if($excp->exception_date == $this_date){
								$excp_found = true;
							}
						}
					}
					
					//if($row3->exception_date && $row3->exception_date != '0000-00-00' && $row3->exception_date == $this_date){
					if($excp_found){
					

					}else{
						$component[$row3->category]['category'] = $row3->category;
						$component[$row3->category]['frequency'] = 'monthly';
						$component[$row3->category]['start'] = $row3->start;
						$component[$row3->category]['end'] = $row3->end;
						$component[$row3->category]['title'] = $row3->title;
						$component[$row3->category]['category'] = $row3->category;
						$component[$row3->category]['isWhole'] = $row3->isWhole;
						$component[$row3->category]['mydate'] = date_format(date_create($row3->mydate), 'm/d/Y');
						$component[$row3->category]['content'] = $row3->content;
						$component[$row3->category]['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row3->start)).':00');
						
						$arr_temp_c3[] = $component;
						
						
						$temp = "<span class='time'>".$row3->start."</span>";
						$temp2 ='<ul class="more_info">
								<li class="header_'.$row3->category.'">'.$row3->title.'</li>
								
								<li class="date">'.date_format(date_create($this_date), 'm/d/Y').'</li>';
						$temp2 .=($row3->start && $row3->end)?'<li class="time">'.($row3->isWhole == 1 ? 'All Day' : $row3->start.'&nbsp;-&nbsp;'.$row3->end).'</li>':'';					
						$temp2 .='<li class="blurb">'.html_entity_decode($row3->content).'</li>
								<li class="close"><a href="#">x</a>
							</ul>';
						$monthday = date_format(date_create($row3->mydate), 'j');
						$temp_c3 .= "<div  class='category cat_".$row3->category."'>".$row3->title.$temp.$temp2."</div>";
					}
				}
						
			endforeach;
			/*------------------- end iteration for no repeat and repeat monthly -----------------*/		
		
			/*------------------- iteration for repeat yearly -----------------*/
			
			
			
			if($day < 10):
				
				$date_where = "MONTH(mydate) = '{$month}' AND DAY(mydate) = '0{$day}' ";
				
				$this->db->where($date_where);
				//$this->db->where("mydate REGEXP ", "^[[:digit:]]{4}-$month-0$day$");
			else:
				//$this->db->where("mydate REGEXP ", "^[[:digit:]]{4}-$month-$day$");
			
				$date_where = "MONTH(mydate) = '{$month}' AND DAY(mydate) = '0{$day}' ";
				
				$this->db->where($date_where);
				
			
			endif;
						
			$this->db->where("repeat", "Every year");
			/*if($location_id != 0){
				$this->db->where("location_id", $location_id);
			}else{
				$this->db->where("(location_id = 0 OR location_id = {$first_location_id})");
			
			}*/
			
			$this->db->where('category <> 52');
			$this->db->where('published', 1);
			
			$this->db->order_by("start", "ASC");
			$query4 = $this->db->get("tblcalendar");
			
			//echo $this->db->last_query();
			//pre($query4->result_array());
			
			/**
			 * @param WHERE repeat == YEARLY
			 *
			 * @throws \
			 *
			 * @return \ 'RETURNS YEARLY'
			 */
			 
			foreach($query4->result() as $row4):
				
				if(date('m-d', strtotime($row4->mydate)) == date('m-d', strtotime($this_date . ' 00:00:00')) && 
					strtotime($this_date . ' 00:00:00') >= strtotime($row4->mydate)) {
					
						
						$this->db->where('cat_id',$row4->category);
					$parent_category = $this->db->get('tblcategory')->row_array();
					
						// changelog v2 - get exception
						$sql = "Select * From tblexception where cal_id = ".$row4->id." AND exception_date >= '".$this_date."'";
						$result = $this->db->query($sql);
						$num_rows = $result->num_rows();
						$excp_found = false;
						if($num_rows){
							foreach($result->result() as $excp){
								if($excp->exception_date == $this_date){
									$excp_found = true;
								}
							}
						}
					
						// if($row4->exception_date && $row4->exception_date != '0000-00-00' && $row4->exception_date == $this_date){
						if($excp_found){
							// hide exceptions	
							/* $temp = "<span class='time'>".$row4->start."</span>";
							$temp2 ='<ul class="more_info">
									<li class="header_'.$row4->category.'">'.$row4->title.'</li>
									<li class="date">'.date_format(date_create($this_date), 'F d, Y').'</li>';
							
							$temp2 .='<li class="blurb">'.html_entity_decode($row4->exception_text).'</li>
									<li class="close"><a href="#">x</a>
								</ul>';
							$yearday = date_format(date_create($row4->mydate), 'm-j');
							$temp_c4 .= "<div  class='category cat_52'>".$row4->title.$temp.$temp2."</div>"; */
							
						}else{
							
							$component[$row4->category]['category'] = $row4->category;
							$component[$row4->category]['frequency'] = 'yearly';
							$component[$row4->category]['start'] = $row4->start;
							$component[$row4->category]['end'] = $row4->end;
							$component[$row4->category]['title'] = $row4->title;
							$component[$row4->category]['category'] = $row4->category;
							$component[$row4->category]['isWhole'] = $row4->isWhole;
							$component[$row4->category]['mydate'] = date_format(date_create($row4->mydate), 'm/d/Y');
							$component[$row4->category]['content'] = $row4->content;
							$component[$row4->category]['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row4->start)).':00');
						
							$arr_temp_c4[] = $component;
						
							$temp = "<span class='time'>".$row4->start."</span>";
							$temp2 ='<ul class="more_info">
									<li class="header_'.$row4->category.'">'.$row4->title.'</li>
									<li class="date">'.date_format(date_create($this_date), 'm/d/Y').'</li>';
							$temp2 .=($row4->start && $row4->end)?'<li class="time">'.($row4->isWhole == 1 ? 'All Day' : $row4->start.'&nbsp;-&nbsp;'.$row4->end).'</li>':'';						
							$temp2 .='<li class="blurb">'.html_entity_decode($row4->content).'</li>
									<li class="close"><a href="#">x</a>
								</ul>';
							$yearday = date_format(date_create($row4->mydate), 'm-j');
							$temp_c4 .= "<div  class='category cat_".$row4->category."'>".$row4->title.$temp.$temp2."</div>";
						}
				}		
			endforeach;
			
			/*------------------- end iteration for no repeat and repeat yearly -----------------*/	
		
		
			
			
			
		
			
			$where = "WHERE `category` <> 52 ";
			/*if($location_id != 0){
				$where = "WHERE location_id = '".$location_id."'";
				$where .= " and `category` <> 52";
			}
			else{
				
				$where = "WHERE `category` <> 52 AND (location_id = 0 OR location_id = {$first_location_id})";
				
			}*/
			
			$where .= " AND `is_multiple` = 1"; 
			
			$where .= " and `published` = 1";

			$order_by = " order by STR_TO_DATE(start, '%l:%i %p')";
			
			$sql = "select * from tblcalendar ".$where.$order_by;
			
			
			$query5 = $this->db->query($sql);
			
			#echo $this->db->last_query();
						
			$arr_temp_c5 = array();	
			
			/**
			 * @param MULTIPLE DATES
			 *
			 * @throws \
			 *
			 * @return \ 'MULTIPLE DATES'
			 */
			 
			 
			foreach($query5->result_array() as $row5):
				
				$this->db->where('cat_id',$row5['category']);
				$parent_category = $this->db->get('tblcategory')->row_array();
				
							   $this->db->where('event_id',$row5['id']);
				$multi_dates = $this->db->get('tbl_calendar_dates')->result_array();
				
				foreach($multi_dates as $i=>$item){
					
					switch($item['repeat']){
					
						case 'never':

							if(strtotime($this_date . ' 00:00:00') == strtotime($item['date'])) {
								
								$component[$row5['category']]['category'] = $row5['category'];
								$component[$row5['category']]['frequency'] = $item['repeat'];
								$component[$row5['category']]['start'] = $item['start'];
								$component[$row5['category']]['end'] = $item['end'];
								$component[$row5['category']]['title'] = $row5['title'];
								$component[$row5['category']]['category'] = $row5['category'];
								$component[$row5['category']]['isWhole'] = $row5['isWhole'];
								$component[$row5['category']]['mydate'] = date_format(date_create($item['date']), 'm/d/Y');
								$component[$row5['category']]['content'] = $row5['content'];
								$component[$row5['category']]['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($item['start'])).':00');
						
								$arr_temp_c5[] = $component;
							
							}
						
						break;
						
						
						case 'Every week':
							
							
							if(
							date('w', strtotime($item['date'])) == date('w', strtotime($this_date . ' 00:00:00')) 
							&& 
							strtotime($this_date . ' 00:00:00') >= strtotime($item['date'])) {
								
								$component[$row5['category']]['category'] = $row5['category'];
								$component[$row5['category']]['frequency'] = $item['repeat'];
								$component[$row5['category']]['start'] = $item['start'];
								$component[$row5['category']]['end'] = $item['end'];
								$component[$row5['category']]['title'] = $row5['title'];
								$component[$row5['category']]['category'] = $row5['category'];
								$component[$row5['category']]['isWhole'] = $row5['isWhole'];
								$component[$row5['category']]['mydate'] = date_format(date_create($item['date']), 'm/d/Y');
								$component[$row5['category']]['content'] = $row5['content'];
								$component[$row5['category']]['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($item['start'])).':00');
						
								$arr_temp_c5[] = $component;
									
							}
												
						break;
						
						
						case 'Every year';
							
							if(date('m-d', strtotime($item['date'])) == date('m-d', strtotime($this_date . ' 00:00:00')) && 
							strtotime($this_date . ' 00:00:00') >= strtotime($item['date'])) {
						
								$component[$row5['category']]['category'] = $row5['category'];
								$component[$row5['category']]['frequency'] = $item['repeat'];
								$component[$row5['category']]['start'] = $item['start'];
								$component[$row5['category']]['end'] = $item['end'];
								$component[$row5['category']]['title'] = $row5['title'];
								$component[$row5['category']]['category'] = $row5['category'];
								$component[$row5['category']]['isWhole'] = $row5['isWhole'];
								$component[$row5['category']]['mydate'] = date_format(date_create($item['date']), 'm/d/Y');
								$component[$row5['category']]['content'] = $row5['content'];
								$component[$row5['category']]['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($item['start'])).':00');
						
								$arr_temp_c5[] = $component;
									
							}
						
						break;
					
					}
				
				} //endforeach multidates
				
				
			endforeach;
			
		
			
			
			$merging1 = array_merge($arr_temp_c1,$arr_temp_c2);
			$merging2 = array_merge($arr_temp_c3,$arr_temp_c4);
			
			$merging3 = array_merge($merging1,$merging2);
			
			$merging4 = array_merge($merging3,$arr_temp_c5);
			
			#echo '<h1>merging3 UNSORTED</h1>';
			#pre($merging3);
			$sorted = $this->sortArray($merging4,'timestamp');
			
			
		
			
			//closed days SINGLE
			$this->db->where("repeat", "never");
			$this->db->where("mydate", $this_date);			
			$this->db->where("category", 52);
			/*if($location_id != 0){
				$this->db->where("location_id", $location_id);
			}else{
				$this->db->where("(location_id = 0 OR location_id = {$first_location_id})");
			
			}*/
			$this->db->where("published", 1);
			$closed_days = $this->db->get("tblcalendar");
			
			$closed_day_count = $closed_days->num_rows();
			
			$sorted_date_data = $matches = array();
			
			//THIS IS FOR CLOSED DAY AND IT IS MULTIPLE 
			$extra_where = '';
			/*if($location_id != 0){
				$extra_where = " AND cal.location_id = {$location_id}";
			}else{
				$extra_where = " AND (cal.location_id = 0 OR cal.location_id = {$first_location_id})";
			}*/
			
			
			
			$query = "SELECT cal.category, cal.location_id,cal.content, cal.title, cal.published , cal.is_multiple, dates.* FROM tblcalendar as cal
INNER JOIN tbl_calendar_dates as dates 

ON dates.event_id = cal.id
WHERE dates.date = '{$this_date}' AND cal.is_multiple = 1  and cal.published = 1  and cal.category = 52 {$extra_where};";



			$closed_days_multiple = $this->db->query($query);
 
			$closed_day_count_multiple = $closed_days_multiple->num_rows();
			
			if($closed_day_count){
				
				$closed_day_block = '';
				
				foreach($closed_days->result_array() as $row):
					if(strtotime($this_date . ' 00:00:00') >= strtotime($row['mydate'])) {
						
						$sorted = array();
						
						$component[$row['category']]['category'] = $row['category'];
						$component[$row['category']]['frequency'] = $row['repeat'];
						$component[$row['category']]['start'] = $row['start'];
						$component[$row['category']]['end'] = $row['end'];
						$component[$row['category']]['title'] = $row['title'];
						$component[$row['category']]['category'] = $row['category'];
						$component[$row['category']]['isWhole'] = $row['isWhole'];
					#	$component['mydate'] = date_format(date_create($item['mydate']), 'm/d/Y');
						$component[$row['category']]['content'] = $row['content'];
						$component[$row['category']]['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row['start'])).':00');
				
						$sorted[] = $component;
						
						
					}
				endforeach;
				
				
				$date_data[$day] = $sorted;
			}
			elseif($closed_day_count_multiple >0){
				
				$closed_day_block = '';
				
				foreach($closed_days_multiple->result_array() as $row):
					if(strtotime($this_date . ' 00:00:00') >= strtotime($row['date'])) {
						$sorted = array();
						
						$component[$row['category']]['category'] = $row['category'];
						$component[$row['category']]['frequency'] = $row['repeat'];
						$component[$row['category']]['start'] = $row['start'];
						$component[$row['category']]['end'] = $row['end'];
						$component[$row['category']]['title'] = $row['title'];
						$component[$row['category']]['category'] = $row['category'];
						$component[$row['category']]['isWhole'] = $row['isWhole'];
						#$component['mydate'] = date_format(date_create($item['date']), 'm/d/Y');
						$component[$row['category']]['content'] = $row['content'];
						$component[$row['category']]['timestamp'] = strtotime(date('Y-m-d').' '.date("H:i", strtotime($row['start'])).':00');
				
						$sorted[] = $component;
						
					}
				endforeach;
				
				$date_data[$day] = $sorted;
				
			}
			
			
			else{
				$date_data[$day] = $sorted;
			}
			
			
			
			
		}	
		//echo '<pre>'; print_r($date_data); die;
		return $date_data;
		
		
		
	}
	
public function getMultiCalendarLocationName($location_id = ''){
	$location_name = '';
	if(!empty($location_id)){
		$multi_calendar = $this->default_db->row('tblconfigcalendar',array('field_name'=>'multi_calendar'));
		$multi_location = $this->default_db->row('tblconfigcalendar',array('field_name'=>'multi_location'));
		
		if($multi_calendar['field_value'] == 1 && $multi_location['field_value'] == 1){
			
			$this->db->select(array('id','name'));
			$this->db->where('published',1);
			$location = $this->default_db->row('tblcontact',array('id'=>$location_id));
			
			$location_name = !empty($location) ? $location['name'] : '';
		}
	}
	
	return $location_name;
	
}


}
