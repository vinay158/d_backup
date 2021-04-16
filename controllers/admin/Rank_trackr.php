<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/sparkpost_autoload.php';
use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class Rank_trackr extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		
		$this->load->model("rank_trackr_model");
		
	}
	
	public function index(){
		
		$data['user_level']=$this->session->userdata['user_level'];
		$is_logged_in = $this->session->userdata('is_logged_in');

		if(!empty($is_logged_in) && $is_logged_in == true){
			
			$group_type = (isset($_GET['url_type']) && !empty($_GET['url_type'])) ? $_GET['url_type'] :  'google';
			
			$searchData['url_type'] = $group_type;
			$searchData['start_date'] = (isset($_GET['start_date']) && !empty($_GET['start_date'])) ? $_GET['start_date'] :  '';
			$searchData['end_date'] = (isset($_GET['end_date']) && !empty($_GET['end_date'])) ? $_GET['end_date'] :  '';
			$searchData['keyword_id'] = (isset($_GET['keyword_id']) && !empty($_GET['keyword_id'])) ? $_GET['keyword_id'] :  '';
			$searchData['report_type'] = (isset($_GET['report_type']) && !empty($_GET['report_type'])) ? $_GET['report_type'] :  '';
			
			$data['searchData'] = $searchData;
			//$keywordsArr = array();
			
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
						
					$tokenRequest  = $this->rank_trackr_model->requestApi($rankTrackerDetail,'/api/v1/token','POST',$accessTokenRequestdata);
					
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
						$searchUrlRequest  = $this->rank_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls','GET',$search_url_request_data);
						
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
									$urlDetailRequest  = $this->rank_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls/'.$val->id,'GET',$show_url_request_data);
									
									if(!empty($urlDetailRequest)){
										$data['api_reponse_data']['url_detail'] = $urlDetailRequest;
									}*/
									
									
									// request for competitors
									$competitors_request_data = array(
																'access_token'=> $access_token
																);
									$competitorsRequest  = $this->rank_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls/'.$val->id.'/competitors','GET',$competitors_request_data);
									
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
									
									$keywordsListRequest  = $this->rank_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls/'.$val->id.'/keywords','GET',$keywords_list_request_data);
									
									//echo '<pre>keywordsListRequest'; print_r($keywordsListRequest); die;
									
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
									
									$generateReportRequest  = $this->rank_trackr_model->requestApi($rankTrackerDetail,'/api/v1/reports/generate','POST',$report_request_data);
									//echo '<pre>generateReportRequest'; print_r($generateReportRequest); die;
									if(isset($generateReportRequest->report_link) && !empty($generateReportRequest->report_link)){
										$data['api_reponse_data']['report_link'] = $generateReportRequest->report_link;
									}
									
									
									
									
									
								}
							}
						}
						
					}
					
				}
				
			}
			
			$data['selected_group_type'] = $group_type;
			
			$this->load->view("admin/rank_trackr", $data);
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
						
					$tokenRequest  = $this->rank_trackr_model->requestApi($rankTrackerDetail,'/api/v1/token','POST',$accessTokenRequestdata);
					
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
						$searchUrlRequest  = $this->rank_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls','GET',$search_url_request_data);
						
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
									
									$keywordsListRequest  = $this->rank_trackr_model->requestApi($rankTrackerDetail,'/api/v1/urls/'.$val->id.'/keywords','GET',$keywords_list_request_data);
									
									
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
	
	
	public function graphs_design(){
		$data = array();
		$this->load->view("admin/graphs_design", $data);
	}




	public function testSpartPost(){
		
		$httpClient = new GuzzleAdapter(new Client());
		$sparky = new SparkPost($httpClient, ['key'=>'ba64eb2dd3348165e3d95b31b5000d3627254e11']);
		
		
		
/*$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.sparkpost.com/api/v1/account',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: ba64eb2dd3348165e3d95b31b5000d3627254e11'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo '<pre>'; print_r(json_decode($response)); die;*/
		

$sparky->setOptions(['async' => false]);
$results = $sparky->transmissions->post([
  'options' => [
    'sandbox' => true
  ],
  'content' => [
    'from' => 'info@sparkpostbox.com',
    'subject' => 'Oh hey',
    'html' => '<html><body><p>Testing SparkPost - the most awesomest email service!</p></body></html>'
  ],
  'recipients' => [
    ['address' => ['email'=>'dojodeveloper158@gmail.com']]
  ]
]);

echo '<prE>results'; print_r($results); die;
		$promise = $sparky->transmissions->post([
    'content' => [
        'from' => [
            'name' => 'SparkPost Team',
            'email' => 'dojodeveloper158@gmail.com',
        ],
        'subject' => 'First Mailing From PHP',
        'html' => '<html><body><h1>Congratulations, {{name}}!</h1><p>You just sent your very first mailing!</p></body></html>',
        'text' => 'Congratulations, {{name}}! You just sent your very first mailing!',
    ],
    'substitution_data' => ['name' => 'dojodev'],
    'recipients' => [
        [
            'address' => [
                'name' => 'dojodev',
                'email' => 'dojodeveloper158@gmail.com',
            ],
        ],
    ],
]);
//echo '<pre>promise'; print_r($promise); die;
try {
    $response = $promise->wait();
    echo $response->getStatusCode()."\n";
    print_r($response->getBody())."\n";
} catch (\Exception $e) {
    echo $e->getCode()."\n";
    echo $e->getMessage()."\n";
}
		echo '<pre>sparky'; print_r($sparky); die;
	}
	
}