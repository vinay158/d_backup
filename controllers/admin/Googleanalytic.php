<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GoogleAnalytic extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("setting_model");
		
	}
	
	public function index(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			$data['title'] = 'Google Analytics';
			$data['googlecode'] = ''; 
			
			$result = $this->db->get("tblgoogleanaytics")->result();
			if($result){
				$data['googlecode'] = $result[0]->googlecode;
			}
	
			if(isset($_POST['update'])) :
				$googlecode = trim($_POST['googlecode']);
				
				if($this->query_model->update("tblgoogleanaytics", 1, array("googlecode" => $googlecode))):
					redirect("admin/googleanalytic");
				endif;
			endif;
				$this->load->view("admin/googleanalytic", $data);
		}else{
			redirect('admin/login');
		}
	}
	
	public function test_report(){
		
		require_once 'vendor/google_autoload.php';
		
		 $config = [
			'GOOGLE_APPLICATION_CREDENTIALS' => '/home/demov5/public_html/active-landing-269910-7df6638c0f9c.json'
		];
		
		 $client = new Google_Client();
			$client->setScopes(array('https://www.googleapis.com/auth/analytics'));
		 
			// provide the service account JSON file.
			// which holds all required information (private key, email, etc)
			putenv('GOOGLE_APPLICATION_CREDENTIALS=/home/demov5/public_html/active-landing-269910-7df6638c0f9c.json');
		 
			// apply the JSON file on the current client
			$client->useApplicationDefaultCredentials();
		 
			if ($client->isAccessTokenExpired()) {
			  $client->refreshTokenWithAssertion();
			}
		 
			// an array with information about access token
			$arrayInfo = $client->getAccessToken();
		 
			// access the access token directly
			$data['accesstoken'] = $arrayInfo['access_token'];
			
		
		 $this->load->view("admin/googleanalytic_test_report", $data);
		// echo '<prE>accesstoken'; print_r($accesstoken); die;
		 
	}
	public function show_report(){
	
		$data = array();
		$userData = array();
		
		$data['report_type'] = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : 'overview';
		
		$data['sort'] = (isset($_GET['sort']) && !empty($_GET['sort'])) ? $_GET['sort'] : 'current_week';
		
		$data['dateRanges'] = $this->getStartAndEndDate($data['sort']);
		
		
		$result = $this->db->get("tblgoogleanaytics")->result();
		$data['analyticsDetail'] = $result[0];
		$client_id = $result[0]->client_id;
		$client_secret = $result[0]->client_secret;
		
		if($result[0]->analytics_report_type == 1 && !empty($client_id) && !empty($client_secret)){
			
			$current_time  = strtotime(date('Y-m-d H:i:s'));
			$last_updated_token  = !empty($result[0]->last_updated_token) ? strtotime($result[0]->last_updated_token) + 50*60 : '';
			//echo $current_time.'====>'.$last_updated_token.'<br>';
			
			$is_expired_token = 1;
			if($last_updated_token >= $current_time){
				$is_expired_token = 0;
			}
			//$is_expired_token = 0;
		
			require_once 'vendor/google_autoload.php';
	   
			// Store values in variables from project created in Google Developer Console
			//$client_id = '277650455436-vajl8bkm1i6sfosqo0qg447qve7adbr4.apps.googleusercontent.com';
			//$client_secret = 'KSbr8uTVtsnOsOTCYQSP_37Y';
			
			
			$redirect_uri = base_url().'admin/googleanalytic/show_report';
			
			//$simple_api_key = '< Generated Server/API Key >';
	//echo $redirect_uri; die;
			// Create Client Request to access Google API
			$client = new Google_Client();
		//	echo '<pre>$client'; print_r($client); die;
			$client->setApplicationName("demov5");
			$client->setClientId($client_id);
			$client->setClientSecret($client_secret);
			$client->setRedirectUri($redirect_uri);
			$client->setIncludeGrantedScopes(true);
			
			// your app can refresh the access token without user interaction.
			$client->setAccessType('offline');
			//$client->setPrompt("consent");
			//$client->setApprovalPrompt("force");
			//$client->setDeveloperKey($simple_api_key);
			//$client->addScope("https://www.googleapis.com/auth/analytics");
			//$client->addScope("https://www.googleapis.com/auth/analytics.readonly");
			/*$client->setScopes(array(
				"https://www.googleapis.com/auth/plus.login",
				"https://www.googleapis.com/auth/userinfo.email",
				"https://www.googleapis.com/auth/userinfo.profile",
				"https://www.googleapis.com/auth/plus.me"
				));*/
			$client->addScope("https://www.googleapis.com/auth/userinfo.email");
			$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
			$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
			
			
			// Send Client Request
			$objOAuthService = new Google_Service_Oauth2($client);
			//echo '<prE>$objOAuthService'; print_r($result); 
			//echo '<prE>$objOAuthService'; print_r($objOAuthService); die;
		
		
		
		
		if($is_expired_token == 1){
			if(!empty($result[0]->refresh_token)){
				
				$client->refreshToken($result[0]->refresh_token);
				
				$_SESSION['googleAuth_access_token'] = $client->getAccessToken();
				
			}
		}else{
			// Add Access Token to Session
			if (isset($_GET['code'])) {
				
				$client->authenticate($_GET['code']);
			
				$_SESSION['googleAuth_access_token'] = $client->getAccessToken();
				
				$refresh_token = isset($_SESSION['googleAuth_access_token']['refresh_token']) ? $_SESSION['googleAuth_access_token']['refresh_token'] : '';
				$updateData['access_token'] = $_SESSION['googleAuth_access_token']['access_token'];
				if(!empty($refresh_token)){
					$updateData['refresh_token'] = $refresh_token;
				}
				
				$updateData['last_updated_token'] = date('Y-m-d H:i:s');
				
				$this->query_model->update("tblgoogleanaytics", 1, $updateData);
				
				header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
			}
		}
			
			
			

			// Set Access Token to make Request
			if (isset($_SESSION['googleAuth_access_token']) && $_SESSION['googleAuth_access_token']) {
				
				$client->setAccessToken($_SESSION['googleAuth_access_token']);
				
				
			 // Create an authorized analytics service object.
			  //$analytics = new Google_Service_AnalyticsReporting($client);
			
			  // Call the Analytics Reporting API V4.
			 // $response = $this->getReport($analytics);
				//echo '<pre>response'; print_r($response); die;
			  // Print the response.
			 // $this->printResults($response);
			  
			}else{
			   
				if(!empty($result[0]->refresh_token)){
				
					$client->refreshToken($result[0]->refresh_token);
					
					$_SESSION['googleAuth_access_token'] = $client->getAccessToken();
					
					$client->setAccessToken($_SESSION['googleAuth_access_token']);
					
				}
			}
		
		echo '<prE>dd=>'; print_r($client->getAccessToken());
		echo '<pre>session'; print_r($_SESSION['googleAuth_access_token']); die;
			// Get User Data from Google and store them in $data
			if ($client->getAccessToken()) {
				//echo '<prE>objOAuthService'; print_r($objOAuthService); 
				$userData = $objOAuthService->userinfo->get();
				$data['userData'] = $userData;
				echo '<pre>data'; print_r($data);
				
				
				$_SESSION['googleAuth_access_token'] = $client->getAccessToken();
			echo '<pre>client'; print_r($client->getAccessToken());
			echo '<pre>session'; print_r($_SESSION['googleAuth_access_token']); die;
				$refresh_token = isset($_SESSION['googleAuth_access_token']['refresh_token']) ? $_SESSION['googleAuth_access_token']['refresh_token'] : '';
				$updateData['access_token'] = $_SESSION['googleAuth_access_token']['access_token'];
				if(!empty($refresh_token)){
					$updateData['refresh_token'] = $refresh_token;
				}
				//$updateData['last_updated_token'] = date('Y-m-d H:i:s');
				if($is_expired_token == 1){
					$updateData['last_updated_token'] = date('Y-m-d H:i:s');
				}else{
					$updateData['last_updated_token'] = !empty($result[0]->last_updated_token) ? $result[0]->last_updated_token : date('Y-m-d H:i:s');
				}
				
				$this->query_model->update("tblgoogleanaytics", 1, $updateData);
				
				
			} else {
				$authUrl = $client->createAuthUrl();
				redirect($authUrl);
				//$data['authUrl'] = $authUrl;
				//header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
			}
		}
		
		$this->load->view("admin/googleanalytic_report", $data);
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