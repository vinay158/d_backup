<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/google_autoload.php';

class Dashboard extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }
		$this->load->model('user_model');
		$this->load->model('contact_model');
		$this->load->model('sparkpost_mail_model');
		
	}
	
	public function index()
	{
		
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!empty($is_logged_in) && $is_logged_in == true){
            $data['title'] = "Dashboard";
		
		$data['lead_types'] = array('email_opt_in'=>'Email Opt-in','free_trial'=>'Free Trial','paid_trial'=>'Paid Trial','upsell_trial'=>'Upsell Trial','contact_us'=>'Contact Us','dojocart'=>'Dojocart','birthday_parties'=>'Birthday Parties / Summer Camp');
		
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
			
		$data['date_sort'] = (isset($_GET['date_sort']) && !empty($_GET['date_sort'])) ? $_GET['date_sort'] : 'current_month';
		$data['dateRanges'] = $this->getStartAndEndDate($data['date_sort']);
		//echo '<pre>'; print_r($data['dateRanges']); die;
		$lead_status = (isset($_GET['lead_status']) && !empty($_GET['lead_status'])) ? $_GET['lead_status'] : '';
		$tags = (isset($_GET['tags']) && !empty($_GET['tags'])) ? $_GET['tags'] : '';
		
		
		
		$search_query = array(
							'kanban_status_id' => $lead_status,
							'tags' => $tags,
							);
		
		
		$data['start_date'] = $data['dateRanges']['start_date'];
		$data['end_date'] =  $data['dateRanges']['end_date'];
		
		$lead_type =  (isset($_GET['lead_type']) && !empty($_GET['lead_type'])) ? $_GET['lead_type'] : 'all';
		$location = (isset($_GET['location']) && !empty($_GET['location'])) ? $_GET['location'] : '';
		
		$data['leads'] = array();
		$data['filterd_leads'] = array();
		
		
		if($lead_type == "all" || $lead_type == "email_opt_in"){
			$data['leads']['email_opt_in_leads'] = $this->getOrderLeads($data['start_date'],$data['end_date'],'email_opt_in',$location,$search_query);
		}
		
		if($lead_type == "all" || $lead_type == "free_trial"){
			$data['leads']['free_trial_leads'] = $this->getOrderLeads($data['start_date'],$data['end_date'],'free_trial',$location,$search_query);
		}
		
		if($lead_type == "all" || $lead_type == "paid_trial"){
			$data['leads']['paid_trial_leads'] = $this->getOrderLeads($data['start_date'],$data['end_date'],'paid_trial',$location,$search_query);
		}
		
		if($lead_type == "all" || $lead_type == "upsell_trial"){
			$data['leads']['upsell_trial_leads'] = $this->getOrderLeads($data['start_date'],$data['end_date'],'upsell_trial',$location,$search_query);
		}
		
		if($lead_type == "all" || $lead_type == "birthday_parties"){
			$data['leads']['birthday_parties_leads'] = $this->getBirthdayPartiesLeads($data['start_date'],$data['end_date'],$search_query);
		}
		
		/*if($lead_type == "all" || $lead_type == "contact_us"){
			$data['leads']['contact_us_leads'] = $this->getContactUsLeads($data['start_date'],$data['end_date'],$location,$search_query);
		}*/
		
		if($lead_type == "all" || $lead_type == "dojocart"){
			$data['leads']['dojocart_leads'] = $this->getDojocartLeads($data['start_date'],$data['end_date'],$location,$search_query);
		}
		
		$data['custom_filterd_leads'] = array();
		if(isset($data['leads']) && !empty($data['leads'])){
			
			foreach($data['leads'] as $key=> $lead_data){
				$a = 0;
				if(!empty($lead_data)){
					foreach($lead_data as  $lead){
						$lead_type = str_replace('_leads','',$key);
						if($lead_type == "birthday_parties" || $lead_type == "contact_us" ){
							$created = $lead->date_added;
						}else{
							$created = $lead->created;
						}
						
						$unique_id = $lead->id.'_'.$lead->kanban_status_id.'_'.$lead_type;
						
						$data['filterd_leads'][$lead->email][$unique_id] = $lead;
						$data['filterd_leads'][$lead->email][$unique_id]->lead_type = $lead_type;
						
						if($lead_type == "birthday_parties" || $lead_type == "contact_us" ){
							$data['filterd_leads'][$lead->email][$unique_id]->created = $lead->date_added;
							$data['filterd_leads'][$lead->email][$unique_id]->offer_type = "";
							$data['filterd_leads'][$lead->email][$unique_id]->trans_status = "";
							if($lead_type == "contact_us"){
								if(!empty($lead->school)){
									$this->db->select(array('id','name'));
									$locationDetail = $this->query_model->getBySpecific('tblcontact','name',$lead->school);
									if(!empty($locationDetail)){
										$data['filterd_leads'][$lead->email][$unique_id]->location_id = $locationDetail[0]->id;
									}
								}
								
							}
						}elseif($lead_type == "dojocart"){
							$data['filterd_leads'][$lead->email][$unique_id]->location_id = $lead->location;
						}
						
						$data['custom_filterd_leads'][$lead->email][$unique_id]['created'] = $created;
						$data['custom_filterd_leads'][$lead->email][$unique_id]['email'] = $lead->email;
						$data['custom_filterd_leads'][$lead->email][$unique_id]['unique_id'] = $unique_id;
					$a++;
					}
				}
				
			}
		}
		
		$orderLeadsSortEmail = array();
		$data['all_leads'] = array();
		$data['latest_leads'] = array();
		$data['total_unique_leads'] = 0;
		
		
		if(isset($data['custom_filterd_leads']) && !empty($data['custom_filterd_leads'])){
			foreach($data['custom_filterd_leads'] as $lead_data){
				
				$last_date = '';
				foreach($lead_data as $key => $lead){
					if(strtotime($lead['created']) > $last_date){
						$last_date = strtotime($lead['created']);
						$orderLeadsSortEmail[$lead['email']] = $lead;
					}
				}
				//echo '<prE>'; print_r($orderLeadsSortEmail); die;
			}
			
			//ksort($orderLeadsSortEmail);
			
			if(!empty($orderLeadsSortEmail)){
				foreach($orderLeadsSortEmail as $email => $newlead_data){
					$lead = array();
					$lead = isset($data['filterd_leads'][$newlead_data['email']][$newlead_data['unique_id']]) ? $data['filterd_leads'][$newlead_data['email']][$newlead_data['unique_id']] : '';
					
					if(!empty($lead)){
						$created_date = strtotime($lead->created);
						$data['all_leads'][$created_date] = $lead;
					}
					
				}
			}
			
			krsort($data['all_leads']);
			
			$data['total_unique_leads'] = count($data['all_leads']);
			$data['latest_leads'] = array_slice($data['all_leads'], 0, 10);
		}
		
		$data['website_leads'] = $this->query_model->getTotalWebsiteOptinLeads($data['start_date'],$data['end_date'],'total_count_with_record',$search_query);
		
		$data['free_paid_trial_leads'] = $this->getFreePaidTrialLeads($data['start_date'],$data['end_date'],$location,$search_query);
		
		
		
		
		$result = $this->db->get("tblgoogleanaytics")->result();
		$data['analyticsDetail'] = $result[0];
		$graph_view_id = $result[0]->client_id;
		$credentials_file_path = $result[0]->client_secret;
		
		if(!empty($graph_view_id)){
			if(!empty($credentials_file_path)){
				
				$data['graph_view_id'] = $graph_view_id;
				
				if($_SERVER['HTTP_HOST'] == "localhost"){
					$data['access_token'] = 'ya29.c.Kp8BAQh_jeVxNozu8eMInNm_5daDN3jIxWQ8KPvvB9NSPYBFf2XgUgAw0QdQfh51QdVxGOETHijp-pCQ5i-wRCRK6MAdvUO1iPr_YO883XfU75mlA2JRWP3IKiYUqM2jKwiEgawWzKjeVM4OJj0k-qvW2pXpTshwVgiEqptpKSccJk4NEjPY3j_dYBiy7tI1VJsyoBoiCt0lLwqCxNTkdy_d';
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
		
			}
		}
		
	//	echo '<pre>data'; print_r($data); die;	
			/******************** OLD CODE *******************************************/
			// new code for update site setting email in main location when we are turning off multi location	
			$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
			$mainLocation = $this->query_model->getMainLocation("tblcontact");
			$site_setting =  $this->query_model->getbyTable("tblsite");
			//echo "<pre>site_setting"; print_r($site_setting); die;
			if($multiLocation[0]->field_value == 0){
				$site_setting_email = $site_setting[0]->email;
				$main_location_email = $mainLocation[0]->email;
				
				$site_setting_text_address = $site_setting[0]->text_address;
				$main_location_text_address = $mainLocation[0]->text_address;
				
				//echo $site_setting_email.'====>'.$main_location_email; 
				//echo $site_setting_text_address.'====>'.$main_location_text_address; die;
				if($site_setting_email != $main_location_email){
					$location_id = $mainLocation[0]->id;
					
					$sql = "UPDATE `tblcontact` SET `email` = '$site_setting_email' WHERE `id` = $location_id";
					$this->db->query($sql);	
				}
				
				if($site_setting_text_address != $main_location_text_address){
					
					$location_id = $mainLocation[0]->id;
					
					$sql = "UPDATE `tblcontact` SET `text_address` = '$site_setting_text_address' WHERE `id` = $location_id";
					$this->db->query($sql);	
				}
				
			} 
			
			/* --- Get Wordpress Blog Data --- */
			
			// vinay 05/2015
			
			 $filePath = base_url().'wp-blog.php';
			  $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_URL => $filePath,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_SSL_VERIFYHOST => 0,
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Postman-Token: 766cb339-f979-4a7d-88cc-9b6dabf41402",
					"cache-control: no-cache"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				 // echo "cURL Error #:" . $err;
				} else {
				  $wp_blogs =  $response;
				}
			 //$wp_blogs = file_get_contents($filePath);
   			 $data['wp_categories'] = json_decode($wp_blogs);
			//echo '<pre>'; print_r($data['wp_categories']); die;
			/* ------- </code> ------------- */
			 
			 
			 
			$data['users'] = $this->db->get("tbladmin")->result();
			$data['gallery_count'] = $this->db->count_all_results("tblgalleryname");
			$this->db->where("type", 1);
			$this->db->from("tblmedia");
			$data['image_count'] = $this->db->count_all_results();
			$this->db->where("type", 2);
			$this->db->from("tblmedia");
			$data['video_count'] = $this->db->count_all_results();
			$data['staff_count'] = $this->db->count_all_results("tblstaff");
			$data['event_count'] = $this->db->count_all_results("tblcalendar");
			$this->db->order_by("id", "DESC"); 
			//$data['recent'] = $this->query_model->getbyTable("tblgalleryname");
			$this->db->order_by("pos", "ASC");
			$data['contact'] = $this->contact_model->getAll();
			$data['setting']=$this->db->query("select title from tblsite")->result();
			
			
			$this->load->view('admin/dashboard',$data);
		}else{
			redirect('admin/login');
		}
	}


	
	
public function getOrderLeads($start_date,$end_date,$lead_type,$location = '',$search_query){
	
	/**** records ****/
	$where = 'is_delete = 0 and ';
	if(isset($location) && !empty($location)){
		//$this->db->where('location_id',$location);
		$where .= 'location_id ='.$location.' and ';
	}
	
	$where .= "DATE_FORMAT(created,'%Y-%m-%d') >= '".$start_date."' and ";
	$where .= "DATE_FORMAT(created,'%Y-%m-%d') <= '".$end_date."' and ";
	
	if($lead_type == "email_opt_in"){ 
		$where .= 'offer_type IS NULL';
	}elseif($lead_type == "free_trial"){
		$where .= 'offer_type = "Free"';
	}elseif($lead_type == "paid_trial"){
		$where .= 'offer_type = "Paid"';
	}elseif($lead_type == "upsell_trial"){
		$where .= 'last_order_id > 0';
	}
	
	$where .= $this->kanbanFilterSearchQuery($search_query,'trial_offer_lead');
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,location_id,last_order_id,offer_type,trans_status,is_unique_trial,trial_id,created,is_delete,kanban_status_id,page_url from tblorders order by id desc) as orders where ".$where);
	$leads = $query->result();
	
	return $leads;
}
	
	
public function getBirthdayPartiesLeads($start_date,$end_date,$search_query){
	
	$where = 'is_delete = 0 and ';
	$where .= "DATE_FORMAT(date_added,'%Y-%m-%d') >= '".$start_date."' and ";
	$where .= "DATE_FORMAT(date_added,'%Y-%m-%d') <= '".$end_date."'";
	
	$where .= $this->kanbanFilterSearchQuery($search_query,'birthday_party_lead');
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,location_id,party_date,guests,date_added,is_delete,kanban_status_id,program_id from tblbirthdayparty order by id desc) as orders where ".$where);
	$leads = $query->result();
	
	
	
	return $leads;
}
	
public function getContactUsLeads($start_date,$end_date,$location = '',$search_query){
	
	$where = 'is_delete = 0 and ';
	if(isset($location) && !empty($location)){
		$this->db->select(array('id','name'));
		$locationDetail = $this->query_model->getBySpecific('tblcontact','id',$location);
		if(!empty($locationDetail)){
			$where .= 'school ="'.$locationDetail[0]->name.'" and '; 
		}
		
	}
	
	$where .= "DATE_FORMAT(date_added,'%Y-%m-%d') >= '".$start_date."' and ";
	$where .= "DATE_FORMAT(date_added,'%Y-%m-%d') <= '".$end_date."'";
	
	
	$where .= $this->kanbanFilterSearchQuery($search_query,'contactus_lead');
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,school,message,date_added,is_delete,kanban_status_id from tblcontactusleads order by id desc) as orders where ".$where);
	$leads = $query->result();
	
	
	
	return $leads;
}

public function getDojocartLeads($start_date,$end_date,$location = '',$search_query){
	
	$where = 'is_delete = 0 and ';
	if(isset($location) && !empty($location)){
		$where .= 'location ='.$location.' and ';
	}
	
	$where .= "DATE_FORMAT(created,'%Y-%m-%d') >= '".$start_date."' and ";
	$where .= "DATE_FORMAT(created,'%Y-%m-%d') <= '".$end_date."'"; 
	
	$where .= $this->kanbanFilterSearchQuery($search_query,'dojocart_lead');
	
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,location,product_id,offer_type,amount,trans_status,created,is_delete,kanban_status_id from tbl_dojocart_orders order by id desc) as orders where ".$where);
	$leads = $query->result();
	
	
	return $leads;
}


public function kanbanFilterSearchQuery($search_query,$lead_type){
	$where = '';
							
	$kanban_status_id = (isset($search_query['kanban_status_id']) && !empty($search_query['kanban_status_id'])) ? $search_query['kanban_status_id'] : '';
	
	$tags = (isset($search_query['tags']) && !empty($search_query['tags'])) ? $search_query['tags'] : '';
	
	if(!empty($kanban_status_id)){
		$where .= ' and kanban_status_id = "'.$kanban_status_id.'"';
	}
	
	
	if(!empty($tags)){
		$orderIds = array();
		
		$this->db->select('order_id');
		$this->db->where('lead_type',$lead_type);
		$order_ids = $this->query_model->getBySpecific('tbl_kanban_lead_tags','tag',$tags);
		
		if(!empty($order_ids)){
			foreach($order_ids as $order_id){
				$orderIds[$order_id->order_id] = $order_id->order_id;
			}
			
			if(!empty($orderIds)){
				
				$orderids = implode(',',$orderIds);
				$where .= " and id IN ($orderids)";
			}
		}else{
			$where .= " and id = 0";
		}
		
	}
	return $where;
}



	
		
public function getStartAndEndDate($sort){
	
	$result  =array();
	
	
	
	$currentlyArr = array(
						//'currently'=>'---Currently---',
						//'current_week'=>'This Week',
						'current_month'=>'This Month',
						//'current_year'=>'This Year',
						//'fixed'=>'---Fixed---',
						//'last_week'=>'Last week',
						//'last_2_weeks'=>'Last 2 weeks',
						'last_month'=>'Last month');
						
	$fixedDateArr = array(
						//'last_2_months'=>'Last 2 months',
						//'last_3_months'=>'Last 3 months',
						//'last_6_months'=>'Last 6 months',
						'last_12_months'=>'Last 12 months',
						//'last_year'=>'Last year',
						//'custom_range' =>'Custom Range'
						);
						
	$slidingDateArr = array(
						//'sliding'=>'---Sliding---',
						//'today' => 'Today',
						//'yesterday' => 'Last day',
						//'last_2_days' => 'Last 2 days',
						//'last_7_days' => 'Last 7 Days',
						//'last_14_days' => 'Last 14 Days',
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
			//$monday = strtotime("last monday");
			//$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$start_date = date("Y-m-01");
			$end_date = date('Y-m-d');
			//echo "current_month from $start_date to $end_date <br/><br/>"; 
			
		}elseif($key == "current_year" && $key == $sort){
			$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$start_date = date("Y-01-01",$monday);
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
				//$end_date = date('Y-m-d', strtotime('last day of last month'));
				$end_date = date('Y-m-d');
				
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
			
			if($sort == "today"){
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d');
			}elseif($sort == "yesterday"){
				$start_date = date("Y-m-d", strtotime("-1 day"));
				$end_date = date('Y-m-d',strtotime("-1 day"));
			}else{
				$start_date = date("Y-m-d", strtotime("-".$number." days",$yesterday));
				$end_date = date('Y-m-d');
			}
			
			//echo "Last ".$number." days from $start_date to $end_date <br/><br/>";
		}
	}
	
	if($sort != "custom_range"){
		$result['start_date'] = date('Y-m-d', strtotime($start_date));
		$result['end_date'] = date('Y-m-d', strtotime($end_date));
	}
	
	$result['sorting_list'] = $listArr;
	//echo '<pre>result'; print_r($result); die;
	return $result;
}
		
		


public function getFreePaidTrialLeads($start_date,$end_date,$location = '',$search_query){
	
	/**** records ****/
	$where = 'is_delete = 0 and ';
	if(isset($location) && !empty($location)){
		//$this->db->where('location_id',$location);
		$where .= 'location_id ='.$location.' and ';
	}
	
	$where .= "DATE_FORMAT(created,'%Y-%m-%d') >= '".$start_date."' and ";
	$where .= "DATE_FORMAT(created,'%Y-%m-%d') <= '".$end_date."' and ";
	
	
	$where .= '(offer_type = "Free" OR offer_type = "Paid" )';
	//$where .= $this->kanbanFilterSearchQuery($search_query,'trial_offer_lead');
	
	
	$query = $this->db->query("select created from tblorders where ".$where);
	$leads = $query->result();
	
	$graphLeadRecord = array();
	if(!empty($leads)){
		foreach($leads as $lead){
			$created = date('Y-m-d', strtotime($lead->created));
			
			$this->db->select('count(*) as total_free_trial');
			$this->db->where("is_delete", 0);
			$this->db->where("DATE_FORMAT(created,'%Y-%m-%d')", $created);
			$graphLeadRecord[$created]['free_trials'] = $this->query_model->getBySpecific('tblorders','offer_type','Free');
			
			$this->db->select('count(*) as total_paid_trial');
			$this->db->where("is_delete", 0);
			$this->db->where("DATE_FORMAT(created,'%Y-%m-%d')", $created);
			$graphLeadRecord[$created]['paid_trials'] = $this->query_model->getBySpecific('tblorders','offer_type','Paid');
			
		}
		
	}
	//echo '<pre>graphLeadRecord'; print_r($graphLeadRecord); die;
	return $graphLeadRecord;
}
	
	

	// vinay 05/11
	public function getPostsByCategory(){
			if(count($_POST)> 0){
				
				 $category_id = $_POST['category_id'];
				 $filePath = base_url().'wp-blog.php?category_id='.$category_id;
				  $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_URL => $filePath,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_SSL_VERIFYHOST => 0,
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Postman-Token: 766cb339-f979-4a7d-88cc-9b6dabf41402",
					"cache-control: no-cache"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				 // echo "cURL Error #:" . $err;
				} else {
				  $wp_blogs =  $response;
				}
				 //$wp_blogs = file_get_contents($filePath);
				 $data['wp_cat_blogs'] = json_decode($wp_blogs);
				 if(count( $data['wp_cat_blogs']) < 1){
				 	$data['wp_cat_blogs'] = array();
				 }
				
				 $this->load->view('admin/wp_cat_blogs',$data);
			}
	}
	
	
	// vinay 05/11
	public function getPostsDetail(){
			if(count($_POST)> 0){
				
				 $blog_id = $_POST['blog_id'];
				 $category_id = $_POST['category'];
				 $filePath = base_url().'wp-blog.php?blog_id='.$blog_id.'&&category='.$category_id;
				 //$wp_blogs = file_get_contents($filePath);
				  $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_URL => $filePath,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_SSL_VERIFYHOST => 0,
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Postman-Token: 766cb339-f979-4a7d-88cc-9b6dabf41402",
					"cache-control: no-cache"
				  ),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
				 // echo "cURL Error #:" . $err;
				} else {
				  $wp_blogs =  $response;
				}
				 $data['wp_blog_detail'] = json_decode($wp_blogs);
				//echo '<pre>'; print_r($data['wp_blog_detail']); die;
				 $this->load->view('admin/wp_blog_detail',$data);
			}
	}
	
	
	public function ajax_publish_records(){
		$id = $_POST['pub_id'];
		$pub = $_POST['publish_type'];
		$table_name = $_POST['table_name'];
		
		$published_field = 'published';
		if($table_name == "tbl_static_pages"){
			$published_field = 'is_display';
		}
		
		$this->db->where("id", $id);
		if($this->db->update($table_name, array($published_field => $pub)))
		{	
			echo 1;
		}
	}
	
	public function ajax_delete_record(){
		
		parse_str($_POST['formData'], $searcharray);
		
		$id = isset($searcharray['delete-item-id']) ? $searcharray['delete-item-id'] : 0;
		$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
		
		if(!empty($id) && !empty($table_name)){
			
			if($table_name == "tbl_sparkpost_mail_templates"){
				$this->db->select(array('template_id'));
				$sparkpost_template_detail = $this->query_model->getBySpecific($table_name,'id',$id);
				
				if(!empty($sparkpost_template_detail)){
					
					if(isset($sparkpost_template_detail[0]->template_id) && !empty($sparkpost_template_detail[0]->template_id)){
						
						$requestData = array('template_id'=>$sparkpost_template_detail[0]->template_id);
						
						$request_result = $this->sparkpost_mail_model->requestSparkPostApi('delete_template',$requestData);
						
					}
				}
				
			}elseif($table_name == "tbl_sparkpost_mail_flows"){
				
				$this->db->select(array('id','template_id'));
				$sparkpost_templates = $this->query_model->getBySpecific('tbl_sparkpost_mail_templates','mail_flow_id',$id);
				
				if(!empty($sparkpost_templates)){
					foreach($sparkpost_templates as $sparkpost_template){
						
						if(isset($sparkpost_template->template_id) && !empty($sparkpost_template->template_id)){
								
								$requestData = array('template_id'=>$sparkpost_template->template_id);
								
								$request_result = $this->sparkpost_mail_model->requestSparkPostApi('delete_template',$requestData);
								
								
							}
					}
				}
				
				$this->db->where("mail_flow_id", $id);
				$this->db->delete('tbl_sparkpost_mail_templates');
			}
			
			$this->db->where("id", $id);
			if($this->db->delete($table_name))
			{
				if($table_name == "tblcontact"){
					// check if multi location enabled
					$this->load->model('facility_model');
					$IsAllowMultiFacility = $this->facility_model->IsAllowMultiFacility();
					if($IsAllowMultiFacility){
						$this->db->where("location_id", $id);
						$this->db->delete("tblfacilities");
					}
				}
				
				
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
		exit();	
	}
	
	
	public function ajax_record_sort(){
		parse_str($_POST['serial'], $searcharray);
		
		$menu = isset($searcharray['menu']) ? $searcharray['menu'] : '';
		$table_name = isset($_POST['table_name']) ? $_POST['table_name'] : '';
		
		$extra_field = (isset($_POST['extra_field']) && !empty($_POST['extra_field'])) ? $_POST['extra_field'] : '';
		$extra_value = (isset($_POST['extra_value']) && !empty($_POST['extra_value'])) ? $_POST['extra_value'] : '';
		
		if(!empty($table_name) && !empty($menu) ){
			for ($i = 0; $i < count($menu); $i++) {	
			
				if(!empty($extra_field) &&  !empty($extra_value)){
					
					$this->db->query("UPDATE $table_name SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "'   AND $extra_field ='" . $extra_value . "'  ") or die(mysqli_error($this->db->conn_id));
				
				}else{
					
					$this->db->query("UPDATE $table_name SET `pos`=" . $i . " WHERE `id`='" . $menu[$i] . "' ") or die(mysqli_error($this->db->conn_id));
				}
				
			}
		}
		
	}
	
	
	
	public function google_reviews(){
		
		require_once 'vendor/google_autoload.php';
		
		$credentials_file_path = "/home/demov5/public_html/google_my_business_reviews_credentials.json";
		
		$client = new Google_Client();
		$client->setScopes(array('https://www.googleapis.com/auth/plus.business.manage',"https://www.googleapis.com/auth/business.manage"));
	
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
		
		/*$my_business_account = new Google_Service_MyBusinessAccountManagement($client);
		$list_accounts_response = $my_business_account->accounts->listAccounts();
		Var_dump($list_accounts_response); 
		echo '<pre>list_accounts_response'; print_r($list_accounts_response); die;*/
		
		$locationName = "accounts/*/locations/*";
		$mybusinessService = new Google_Service_Mybusiness($client);
		$reviews = $mybusinessService->accounts_locations_reviews->listAccountsLocationsReviews($locationName);
		echo '<pre>reviews'; print_r($reviews); die;
		/*do{
			$listReviewsResponse = $reviews->listAccountsLocationsReviews($locationName, array('pageSize' => 100,
								'pageToken' => $listReviewsResponse->nextPageToken));

			$reviewsList = $listReviewsResponse->getReviews();
			foreach ($reviewsList as $index => $review) {
				
				echo '<prE>review'; print_r($review); die;
				
				//Accesing $review Object

				// $review->createTime;
				// $review->updateTime;
				// $review->starRating;
				// $review->reviewer->displayName;
				// $review->reviewReply->comment;
				// $review->getReviewReply()->getComment();
				// $review->getReviewReply()->getUpdateTime();
				

			}

		}while($listReviewsResponse->nextPageToken);*/

		echo '<pre>mybusinessService==>'; print_r($mybusinessService); 
		echo '<pre>reviews==>'; print_r($reviews); 
		echo '<pre>client==>'; print_r($client); 
		echo '<pre>arrayInfo==>'; print_r($arrayInfo); die;

	}
	
}