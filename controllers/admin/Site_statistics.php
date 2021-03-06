<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_statistics extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("setting_model");
		
	}
	
	public function index(){
		
		
	}
	
	public function report(){
		$data = array();
		
		$data['report_type'] = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : 'overview';
		
		$data['sort'] = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $_GET['sort'] : 'current_month'; 
		
		$data['dateRanges'] = $this->getStartAndEndDate($data['sort']);
		
		$data['start_date'] = $data['dateRanges']['start_date'];
		$data['end_date'] =  $data['dateRanges']['end_date'];
		
		$search_query = array();
		$data['website_leads'] = $this->query_model->getTotalWebsiteOptinLeads($data['start_date'],$data['end_date'],'only_total_count',$search_query);
		
		require_once 'vendor/google_autoload.php';
		
		$result = $this->db->get("tblgoogleanaytics")->result();
		$data['analyticsDetail'] = $result[0];
		$graph_view_id = $result[0]->client_id;
		$credentials_file_path = $result[0]->client_secret;
		
		if(!empty($graph_view_id)){
			if(!empty($credentials_file_path)){
				
				$s_date = strtotime($data['dateRanges']['start_date']); // or your date as well
				$e_date = strtotime($data['dateRanges']['end_date']);
				$datediff = $e_date - $s_date;

				$data['bitween_days'] =  round($datediff / (60 * 60 * 24)); 

				$data['graph_view_id'] = $graph_view_id;
				
				//$data['total_unique_leads'] = $this->getTotalTrialLeads($data['dateRanges']['start_date'],$data['dateRanges']['end_date']);
				
				
				if($_SERVER['HTTP_HOST'] == "localhost"){
					$data['access_token'] = 'ya29.c.Kp8BBQgqla607ohCVuWDUOe3_TTr3Rxks_-4i3PQJaCL3BflRXsWEEWdXJk3HMu_Z4-HJRsd9yGnnVEDrqlhz4lshBb3EXQDcGw_pwMBjTPh9JLSzcHJqOu2GA136lSe3KZ8n87IPyFpWTV91XsDqg4Sh4b9_GLrrBPz0tFq24ju9Ef0d3CZOzWetS4mbLkdlIMkdqqwEm-hiwqmyxw8br8K';
				}else{
					$client = new Google_Client();
					$client->setScopes(array('https://www.googleapis.com/auth/analytics'));
				
					// provide the service account JSON file.
					// which holds all required information (private key, email, etc)
					putenv('GOOGLE_APPLICATION_CREDENTIALS='.$credentials_file_path);
				 
					// apply the JSON file on the current client
					$client->useApplicationDefaultCredentials();
				 
					if ($client->isAccessTokenExpired()) {
					  $client->refreshTokenWithAssertion();
					}
				 
					// an array with information about access token
					$arrayInfo = $client->getAccessToken();
				 
					// access the access token directly
					$data['access_token'] = $arrayInfo['access_token'];
				}
		//	echo '<pre>data'; print_r($data); die;
			
			if($data['report_type'] == "access_token"){
				echo $data['access_token']; die;
			}
					
				if($data['report_type'] == "overview"){
					 $this->load->view("admin/site_statistics_report", $data);
				}elseif($data['report_type'] == "social_media"){
					 $this->load->view("admin/site_statistics_report_social_media", $data);
					 
				}elseif($data['report_type'] == "top_reffers"){
					 $this->load->view("admin/site_statistics_report_top_reffers", $data);
					 
				}elseif($data['report_type'] == "top_keywords"){
					 $this->load->view("admin/site_statistics_report_top_keywords", $data);
					 
				}elseif($data['report_type'] == "top_pages"){
					 $this->load->view("admin/site_statistics_report_top_pages", $data);
					 
				}elseif($data['report_type'] == "your_visitors"){
					 $this->load->view("admin/site_statistics_report_your_visitors", $data);
				}
			}
		}
		
		
		 
	}
	
public function getTotalTrialLeads($start_date,$end_date){
	$where = 'is_delete = 0 and ';
	
	$where .= "DATE_FORMAT(created,'%Y-%m-%d') >= '".$start_date."' and ";
	$where .= "DATE_FORMAT(created,'%Y-%m-%d') <= '".$end_date."'";
	
	$query = $this->db->query("select DISTINCT(email) from tblorders where ".$where."");
	
	$leads = $query->result();
	
	return !empty($leads) ? count($leads) : 0;
}	

public function getStartAndEndDate($sort){
	
	$result  =array();
	
	$currentlyArr = array('currently'=>'---Currently---',
						'current_week'=>'This Week',
						'current_month'=>'This Month',
						'current_year'=>'This Year',
						'fixed'=>'---Fixed---',
						'last_week'=>'Last week',
						'last_2_weeks'=>'Last 2 weeks',
						'last_month'=>'Last month');
						
	$fixedDateArr = array('last_2_months'=>'Last 2 months',
						'last_3_months'=>'Last 3 months',
						'last_6_months'=>'Last 6 months',
						'last_12_months'=>'Last 12 months',
						'last_year'=>'Last year');
						
	$slidingDateArr = array('sliding'=>'---Sliding---',
						'last_7_days' => 'Last 7 Days',
						'last_14_days' => 'Last 14 Days',
						'last_30_days' => 'Last 30 Days',
						'last_60_days' => 'Last 60 Days',
						'last_90_days' => 'Last 90 Days',
						'last_180_days' => 'Last 180 Days',
						'last_365_days' => 'Last 365 Days');
						
						
	$listArr = array_merge($currentlyArr,$fixedDateArr,$slidingDateArr);
	
	$start_date = '';
	$end_date = '';
	foreach($currentlyArr as $key => $val){
		
		if($key == "current_week" && $key == $sort){
			
			$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$sunday = strtotime(date("d-m-Y",$monday)." +6 days");
			$start_date = date("Y-m-d",$monday);
			//$end_date = date("Y-m-d",$sunday);
			$end_date = date("Y-m-d");
			//echo "current_week from $start_date to $end_date <br/><br/>"; 
		
		}elseif($key == "current_month" && $key == $sort){
			//$monday = strtotime("last monday");
			//$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$start_date = date("Y-m-01");
			$end_date = date('Y-m-d');
			
		}elseif($key == "current_year" && $key == $sort){
			$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$start_date = date("Y-01-01",$monday);
			//$end_date = date('Y-m-d',strtotime("-1 days"));
			$end_date = date('Y-m-d');
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
			$number = isset($number[1]) ? $number[1] -1 : '';
			
			$yesterday_date = date('Y-m-d');
			$yesterday = strtotime($yesterday_date);
			
			$start_date = date("Y-m-d", strtotime("-".$number." days",$yesterday));
			//$end_date = date('Y-m-d',strtotime("-1 days"));
			$end_date = date('Y-m-d');
			
			//echo "Last ".$number." days from $start_date to $end_date <br/><br/>";
		}
	}
	
	$result['start_date'] = date('Y-m-d', strtotime($start_date));
	$result['end_date'] = date('Y-m-d', strtotime($end_date));
	$result['sorting_list'] = $listArr;
	
	return $result;
}
	
	
	/**
 * Queries the Analytics Reporting API V4.
 *
 * @param service An authorized Analytics Reporting API V4 service object.
 * @return The Analytics Reporting API V4 response.
 */
public function getReport($analytics) { 

  // Replace with your view ID, for example XXXX.
  $VIEW_ID = "212462976";

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("7daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:sessions");
  $sessions->setAlias("sessions");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}


/**
 * Parses and prints the Analytics Reporting API V4 response.
 *
 * @param An Analytics Reporting API V4 response.
 */
public function printResults($reports) { 
  for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    $report = $reports[ $reportIndex ];
    $header = $report->getColumnHeader();
    $dimensionHeaders = $header->getDimensions();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();

    for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
      $row = $rows[ $rowIndex ];
      $dimensions = $row->getDimensions();
      $metrics = $row->getMetrics();
      for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
        print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
      }

      for ($j = 0; $j < count($metrics); $j++) {
        $values = $metrics[$j]->getValues();
        for ($k = 0; $k < count($values); $k++) {
          $entry = $metricHeaders[$k];
          print($entry->getName() . ": " . $values[$k] . "\n");
        }
      }
    }
  } die('=>1');
}

}