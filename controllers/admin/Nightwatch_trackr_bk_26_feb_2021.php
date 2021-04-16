<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nightwatch_trackr extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("nightwatch_trackr_model");
		
	}
	
	public function index(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			
			$group_type = (isset($_GET['url_type']) && !empty($_GET['url_type'])) ? $_GET['url_type'] :  'google';
			
			$searchData['url_type'] = $group_type;
			//$searchData['start_date'] = (isset($_GET['start_date']) && !empty($_GET['start_date'])) ? $_GET['start_date'] :  '';
			//$searchData['end_date'] = (isset($_GET['end_date']) && !empty($_GET['end_date'])) ? $_GET['end_date'] :  '';
			$searchData['keyword_id'] = (isset($_GET['keyword_id']) && !empty($_GET['keyword_id'])) ? $_GET['keyword_id'] :  '';
			$searchData['report_type'] = (isset($_GET['report_type']) && !empty($_GET['report_type'])) ? $_GET['report_type'] :  '';
			
			$data['searchData'] = $searchData;
			
			$data['date_sort'] = (isset($_GET['date_sort']) && !empty($_GET['date_sort'])) ? $_GET['date_sort'] : 'last_1_days';
			$data['dateRanges'] = $this->getStartAndEndDate($data['date_sort']);
			
			if(strtotime($data['dateRanges']['start_date']) != strtotime($data['dateRanges']['end_date'])){
				$searchData['start_date'] = $data['dateRanges']['start_date'];
				$searchData['end_date'] = $data['dateRanges']['end_date'];
			}else{
				$searchData['start_date'] = '';
				$searchData['end_date'] = '';
			}
			
		
			
			
			$rankTrackerDetail = $this->query_model->getbySpecific('tbl_rank_trackr', 'id', 1);
			
			if(!empty($rankTrackerDetail)){
				
				$rankTrackerDetail = $rankTrackerDetail[0];
				
				$data['respose'] = 0;
					
				if($rankTrackerDetail->type == 1 && !empty($rankTrackerDetail->email) && !empty($rankTrackerDetail->password)){
					
					
					
					/// request for access token
					$accessTokenRequestdata = array(
						'email'=> trim($rankTrackerDetail->email),
						'password'=> trim($rankTrackerDetail->password)
						);
						
					$tokenRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/token','POST',$accessTokenRequestdata);
					
					if(isset($tokenRequest->access_token) && !empty($tokenRequest->access_token)){
						$data['respose'] = 1;
						
						$access_token = $tokenRequest->access_token;
						
						
						// request for search urls
						$search_url = 'http://'.$_SERVER['HTTP_HOST'];
						$search_url = '';
						$search_url_request_data = array(
													'access_token'=> $access_token,
													'search'=> 'http://karatememphis.com',
													);
						$searchUrlRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls','GET',$search_url_request_data);
						
						if(!empty($searchUrlRequest)){
							foreach($searchUrlRequest as $key => $val){
								// set group types in array
								$data['api_reponse_data']['url_types'][$val->url_type] = $val->url_type;
								
								if($val->url_type == $group_type){ 
									$type = $val->url_type;
									$data['api_reponse_data'][$val->url_type] = $val;
									
									// request for url detail
									/*$show_url_request_data = array(
																'access_token'=> $access_token
																);
									$urlDetailRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls/'.$val->id,'GET',$show_url_request_data);
									
									if(!empty($urlDetailRequest)){
										$data['api_reponse_data']['url_detail'] = $urlDetailRequest;
									}*/
									
									
									// request for competitors
									$competitors_request_data = array(
																'access_token'=> $access_token
																);
									$competitorsRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls/'.$val->id.'/competitors','GET',$competitors_request_data);
									
									if(!empty($competitorsRequest)){
										$data['api_reponse_data']['competitors_list'] = $competitorsRequest;
									}
									
									
									
									// request for competitors
									$keywords_list_request_data = array(
																'access_token'=> $access_token,
																'sort' => 'position',
																'direction' => 'asc',
																//'date_from'=>'2019-12-30',
																//'date_to'=>'2021-01-01',
																);
									if(!empty($searchData['start_date'])){
										$keywords_list_request_data['date_from'] = $searchData['start_date'];
									}
									
									if(!empty($searchData['end_date'])){
										$keywords_list_request_data['date_to'] = $searchData['end_date'];
									}
									
									/*if(!empty($searchData['keyword_id'])){
										$keywords_list_request_data['filter_groups'] = '[{"dynamic_view_id":null,"filters":[{"field":"query","condition":"equals","value":"karate classes","filter_group_id":null}]}]';
									}*/
									
									$keywordsListRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls/'.$val->id.'/keywords','GET',$keywords_list_request_data);
									
									
									
									if(!empty($keywordsListRequest)){
										$data['api_reponse_data']['keywords_list'] = $keywordsListRequest;
									}
									
									
									// request for generate report
									$report_request_data = array(
																'access_token'=> $access_token,
																'url_id' => $val->id,
																//'time_start'=>'2020-10-01',
																//'time_end'=>' 2020-10-29',
																//'keyword_ids' =>'5475822',
																//'report_type' =>'simple'
																);
									if(!empty($searchData['start_date'])){
										$report_request_data['time_start'] = $searchData['start_date'];
									}
									
									if(!empty($searchData['end_date'])){
										$report_request_data['time_end'] = $searchData['end_date'];
									}
									
									if(!empty($searchData['keyword_id'])){
										$report_request_data['keyword_ids'] = $searchData['keyword_id'];
									}
									
									if(!empty($searchData['report_type'])){
										$report_request_data['report_type'] = $searchData['report_type'];
									}
									
									$generateReportRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/reports/generate','POST',$report_request_data);
									
									if(isset($generateReportRequest->report_link) && !empty($generateReportRequest->report_link)){
										$data['api_reponse_data']['report_link'] = $generateReportRequest->report_link;
									}
									
									
									
									/******************* Url Main Graphs***********************/
									$dataseries_request_data = array(
																'access_token'=> $access_token,
																'url_id' => $val->id,
																'with_competitors'=> false
																);
									if(!empty($searchData['start_date'])){
										$dataseries_request_data['date_from'] = $searchData['start_date'];
									}
									
									if(!empty($searchData['end_date'])){
										$dataseries_request_data['date_to'] = $searchData['end_date'];
									}
									
									$dataSeriesRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/series','GET',$dataseries_request_data);
									
								/*$graphDataArr = array();
								if(isset($dataSeriesRequest[0]->url_series) && !empty($dataSeriesRequest[0]->url_series)){
									
									$url_series = $dataSeriesRequest[0]->url_series;
									
									$graphDataArr['average_position'] = $this->getFilteredGraphData('average_position',1,$url_series[0]); //Average position
									
									$graphDataArr['search_visibility_index'] = $this->getFilteredGraphData('search_visibility_index',2,$url_series[1]); //Search Visibility %
									
									$graphDataArr['click_potential'] = $this->getFilteredGraphData('click_potential',1,$url_series[2]); //Click Potential
									
									$graphDataArr['up_down'] = $this->getFilteredGraphData('up_down',1,$url_series[4]); // Keywords Up / Down 
									
									$graphDataArr['keyword_distribution'] = $this->getFilteredGraphData('keyword_distribution',1,$url_series[5]); // Keyword Distribution 
									
									
								}*/	
									
								//echo '<pre> graphDataArr'; print_r($graphDataArr); die;
									
									/******************* Keyword Graphs***********************/
									/*$dataseries_request_data = array(
																'access_token'=> $access_token,
																'keyword_ids' => array('5475819'),
																);
									if(!empty($searchData['start_date'])){
										$dataseries_request_data['date_from'] = $searchData['start_date'];
									}
									
									if(!empty($searchData['end_date'])){
										$dataseries_request_data['date_to'] = $searchData['end_date'];
									}
																
									$dataSeriesRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/series','GET',$dataseries_request_data);
									
									*/
									
									/******************* Keyword Stats***********************/
									/*$dataseries_request_data = array(
																'access_token'=> $access_token,
																'url_id' => $val->id,
																);
									if(!empty($searchData['start_date'])){
										$dataseries_request_data['start_date'] = $searchData['start_date'];
									}
									
									if(!empty($searchData['end_date'])){
										$dataseries_request_data['end_date'] = $searchData['end_date'];
									}
																
									$dataSeriesRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/keyword_stats','GET',$dataseries_request_data);
									
									echo '<pre>Keyword Stats'; print_r($dataSeriesRequest); die;*/
									
									
									
									
									
								}
							}
						}
						
					}
					
				}
				
			}
			
			$data['selected_group_type'] = $group_type;
			
			$this->load->view("admin/nightwatch_trackr", $data);
		}else{
			redirect('admin/login');
		}
	}
	
	
	public function ajaxGetRankTrackrKeywords(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		$keywordsListArr = array();
		$result['response'] = 0;
		if(!empty($is_logged_in) && $is_logged_in == true){
			
			if(isset($_POST['action']) && $_POST['action'] == "getKeywords" ){
				
				$group_type = (isset($_POST['url_type']) && !empty($_POST['url_type'])) ? $_POST['url_type'] :  'google';
				
				$searchData['url_type'] = $group_type;
				$searchData['start_date'] = (isset($_POST['start_date']) && !empty($_POST['start_date'])) ? $_POST['start_date'] :  '';
				$searchData['end_date'] = (isset($_POST['end_date']) && !empty($_POST['end_date'])) ? $_POST['end_date'] :  '';
				$searchData['keyword_id'] = (isset($_POST['keyword_id']) && !empty($_POST['keyword_id'])) ? $_POST['keyword_id'] :  '';
				$searchData['report_type'] = (isset($_POST['report_type']) && !empty($_POST['report_type'])) ? $_POST['report_type'] :  '';
				
				$rankTrackerDetail = $this->query_model->getbySpecific('tbl_rank_trackr', 'id', 1);
			
			if(!empty($rankTrackerDetail)){
				
				$rankTrackerDetail = $rankTrackerDetail[0];
				
				$data['respose'] = 0;
					
				if($rankTrackerDetail->type == 1 && !empty($rankTrackerDetail->email) && !empty($rankTrackerDetail->password)){
					
					
					
					/// request for access token
					$accessTokenRequestdata = array(
						'email'=> trim($rankTrackerDetail->email),
						'password'=> trim($rankTrackerDetail->password)
						);
						
					$tokenRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/token','POST',$accessTokenRequestdata);
					
					if(isset($tokenRequest->access_token) && !empty($tokenRequest->access_token)){
						$data['respose'] = 1;
						
						$access_token = $tokenRequest->access_token;
						
						
						// request for search urls
						$search_url = 'http://'.$_SERVER['HTTP_HOST'];
						$search_url = '';
						$search_url_request_data = array(
													'access_token'=> $access_token,
													'search'=> 'http://karatememphis.com',
													);
						$searchUrlRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls','GET',$search_url_request_data);
						
						if(!empty($searchUrlRequest)){
							foreach($searchUrlRequest as $key => $val){
								// set group types in array
								$data['api_reponse_data']['url_types'][$val->url_type] = $val->url_type;
								
								if($val->url_type == $group_type){
									
									// request for competitors
									$keywords_list_request_data = array(
																'access_token'=> $access_token,
																'sort' => 'position',
																'direction' => 'asc',
																//'date_from'=>'2019-12-30',
																//'date_to'=>'2021-01-01',
																);
									if(!empty($searchData['start_date'])){
										$keywords_list_request_data['date_from'] = $searchData['start_date'];
									}
									
									if(!empty($searchData['end_date'])){
										$keywords_list_request_data['date_to'] = $searchData['end_date'];
									}
									
									$keywordsListRequest  = $this->nightwatch_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls/'.$val->id.'/keywords','GET',$keywords_list_request_data);
									
									
									if(!empty($keywordsListRequest)){
										$result['response'] = 1;
										foreach($keywordsListRequest as $key => $value){
											$keywordsListArr[$value->id] = $value->query;
										}
									}
									
									
									
								}
							}
						}
						
					}
					
				}
				
			}
			
				
			}
		}
		
		$result['result'] = $keywordsListArr;
		echo json_encode($result); die;
	}
	
	
	
public function getStartAndEndDate($sort){
	
	$result  =array();
	
	
	
	$currentlyArr = array(
						//'currently'=>'---Currently---',
						//'current_week'=>'This Week',
						'current_month'=>'This Month',
						'current_year'=>'This Year',
						//'fixed'=>'---Fixed---',
						//'last_week'=>'Last week',
						//'last_2_weeks'=>'Last 2 weeks',
						'last_month'=>'Last month');
						
	$fixedDateArr = array(
						//'last_2_months'=>'Last 2 months',
						'last_3_months'=>'Last 3 months',
						'last_6_months'=>'Last 6 months',
						'last_year'=>'Last year'
						);
						
	$slidingDateArr = array(
						//'sliding'=>'---Sliding---',
						'last_1_days' => 'Last day',
						'last_2_days' => 'Last 2 days',
						'last_7_days' => 'Last 7 Days',
						'last_14_days' => 'Last 14 Days',
						'last_30_days' => 'Last 30 Days',
						//'last_60_days' => 'Last 60 Days',
						//'last_90_days' => 'Last 90 Days',
						//'last_180_days' => 'Last 180 Days',
						//'last_365_days' => 'Last 365 Days'
						);
						
						
	$listArr = array_merge($slidingDateArr,$currentlyArr,$fixedDateArr);
	
	$start_date = '';
	$end_date = '';
	foreach($currentlyArr as $key => $val){
		
		if($key == "current_week" && $key == $sort){
			
			$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$sunday = strtotime(date("d-m-Y",$monday)." +6 days");
			$start_date = date("Y-m-d",$monday);
			$end_date = date("Y-m-d",$sunday);
			//echo "current_week from $start_date to $end_date <br/><br/>"; 
		
		}elseif($key == "current_month" && $key == $sort){
			$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$start_date = date("Y-m-01",$monday);
			$end_date = date('Y-m-d',strtotime("-1 days"));
			//echo "current_month from $start_date to $end_date <br/><br/>"; 
			
		}elseif($key == "current_year" && $key == $sort){
			$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$start_date = date("Y-01-01",$monday);
			$end_date = date('Y-m-d',strtotime("-1 days"));
			//echo "current_year from $start_date to $end_date <br/><br/>"; 
			
		}elseif($key == "last_week" && $key == $sort){
			$monday = strtotime("last monday");
			$monday = date('W', $monday)==date('W') ? $monday-7*86400 : $monday;
			 
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			$start_date = date("Y-m-d",$monday);
			$end_date = date("Y-m-d",$sunday);
			//echo "last_week from $start_date to $end_date <br/><br/>"; 
			
		}elseif($key == "last_2_weeks" && $key == $sort){
			$monday = strtotime("last monday");
			$start_date = date("Y-m-d", strtotime("-2 weeks",$monday));
			$monday = date('W', $monday)==date('W') ? $monday-7*86400 : $monday;
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			$end_date = date("Y-m-d",$sunday);
			//echo "last_2_weeks from $start_date to $end_date <br/><br/>"; 
			 
		}elseif($key == "last_month" && $key == $sort){
			
			$start_date = date('Y-m-d', strtotime('first day of last month'));
			$end_date = date('Y-m-d', strtotime('last day of last month'));
			//echo "last_month from $start_date to $end_date <br/><br/>"; 
			
		}
		
	}
	
	
	foreach($fixedDateArr as $key => $val){
		if($key == $sort){
			
			if($key == "last_year" && $key == $sort){
				$start_date = date("Y",strtotime("-1 year")).'-01-01';
				$end_date = date("Y",strtotime("-1 year")).'-12-31';
				//echo "last_year from $start_date to $end_date <br/><br/>";
			}else{
				$number = explode('_',$key);
				$number = isset($number[1]) ? $number[1] : '';
				$current_month = date('Y-m-01');
				$current_month = strtotime($current_month);
				$start_date = date("Y-m-d", strtotime("-".$number." months",$current_month));
				$end_date = date('Y-m-d', strtotime('last day of last month'));
				
			}
			
			//echo "Last ".$number." months from $start_date to $end_date <br/><br/>";
		}
		 
	}
	
	foreach($slidingDateArr as $key => $val){
		if($key == $sort){
			$number = explode('_',$key);
			
			$number = isset($number[1]) ? ($number[1]+1) -1 : '';
			
			$yesterday_date = date('Y-m-d');
			$yesterday = strtotime($yesterday_date);
			
			$start_date = date("Y-m-d", strtotime("-".$number." days",$yesterday));
			$end_date = date('Y-m-d',strtotime("-1 days"));
			//$end_date = date('Y-m-d');
			
			//echo "Last ".$number." days from $start_date to $end_date <br/><br/>";
		}
	}
	
	$result['start_date'] = date('Y-m-d', strtotime($start_date));
	$result['end_date'] = date('Y-m-d', strtotime($end_date));
	$result['sorting_list'] = $listArr;
	//echo '<pre>result'; print_r($result); die;
	return $result;
}

public function getFilteredGraphData($filter_type,$number_format, $url_series){
	
	$graphDataArr = array();
	if(!empty($url_series)){
		if(isset($url_series->name) && $url_series->name == $filter_type){
			if(isset($url_series->series) && !empty($url_series->series)){
				
				
				$graphDataArr['series'] = $url_series->series;
				
				$average_position_old = reset($url_series->series);
				$average_position_current = end($url_series->series);
				
				if($filter_type == "up_down"){
					
					$graphDataArr['current_record'] = isset($average_position_current[1]) ? $average_position_current[1] : 0;
				
				}elseif($filter_type == "keyword_distribution"){
					
					$graphDataArr['current_record'] = isset($average_position_current[1]) ? $average_position_current[1] : 0;
					$graphDataArr['old_record'] = isset($average_position_old[1]) ? $average_position_old[1] : 0;
					$graphDataArr['change_value']['top_3'] = $graphDataArr['current_record']->top_3 - $graphDataArr['old_record']->top_3;
					$graphDataArr['change_value']['top_10'] = $graphDataArr['current_record']->top_10 - $graphDataArr['old_record']->top_10;
					$graphDataArr['change_value']['top_100'] = $graphDataArr['current_record']->top_100 - $graphDataArr['old_record']->top_100;
					$graphDataArr['change_value']['no_rank'] = $graphDataArr['current_record']->no_rank - $graphDataArr['old_record']->no_rank;
				}else{
					
					
					$graphDataArr['current_record'] = isset($average_position_current[1]) ? number_format($average_position_current[1],$number_format) : 0;
					
					$graphDataArr['old_record'] = isset($average_position_old[1]) ? number_format($average_position_old[1],$number_format) : 0;
					
					$average_position_result = $graphDataArr['current_record'] - $graphDataArr['old_record'];
					$graphDataArr['change_value'] = number_format($average_position_result, $number_format);
				}
				
				
			}
		}
	}
	return $graphDataArr;
	
}


	public function graphs_design(){
		$data = array();
		$this->load->view("admin/graphs_design", $data);
	}

}