<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kanban_leads extends CI_Controller {

	
	function __construct(){
		parent::__construct();
		$this->load->model('pagination_model');
		$this->load->library('pagination');
		if (!$this->session->userdata('is_logged_in'))
        { 
            redirect('/admin/login');
        }		
	}
	
	public function index()
	{
		
		
		
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
		
		if(!isset($_GET['date'])){
			//$this->checkAndDeleteSimmilerEmailLeads();
		}
		
		$data['title'] = "Paid & Free Trials";
		$data['link_type'] = "leads/orders"; 
		
		$data['lead_types'] = array('email_opt_in'=>'Email Opt-in','free_trial'=>'Free Trial','paid_trial'=>'Paid Trial','upsell_trial'=>'Upsell Trial','birthday_parties'=>'Birthday Parties / Summer Camp','contact_us'=>'Contact Us','dojocart'=>'Dojocart');
		
		
		$data['date_sort'] = (isset($_GET['date_sort']) && !empty($_GET['date_sort'])) ? $_GET['date_sort'] : 'current_month';
		$data['dateRanges'] = $this->getStartAndEndDate($data['date_sort']);
		
		if($data['date_sort'] == "custom_range"){
			
			$data['start_date'] = (isset($_GET['start_date']) && !empty($_GET['start_date'])) ? $_GET['start_date'] : '';
			$data['end_date'] = (isset($_GET['end_date']) && !empty($_GET['end_date'])) ? $_GET['end_date'] : '';
		}else{
			$data['start_date'] = $data['dateRanges']['start_date'];
			$data['end_date'] =  $data['dateRanges']['end_date'];
		}
		
		$lead_type =  (isset($_GET['lead_type']) && !empty($_GET['lead_type'])) ? $_GET['lead_type'] : 'all';
		$location = (isset($_GET['location']) && !empty($_GET['location'])) ? $_GET['location'] : '';
		$lead_status = (isset($_GET['lead_status']) && !empty($_GET['lead_status'])) ? $_GET['lead_status'] : '';
		$tags = (isset($_GET['tags']) && !empty($_GET['tags'])) ? $_GET['tags'] : '';
		$search_keyword = (isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])) ? $_GET['search_keyword'] : '';
		
		$this->db->order_by('sort_number','asc');
		$this->db->select(array('id','title','color_code'));
		if(!empty($lead_status)){
			$this->db->where("id", $lead_status);
		}
		$data['kanban_lead_status'] = $this->query_model->getbyTable("tbl_kanban_lead_status");
		$search_query = array(
							'kanban_status_id' => $lead_status,
							'tags' => $tags,
							'search_keyword' => $search_keyword,
							);
							
		if(!isset($_GET['lead_status'])){
			$this->session->set_userdata('is_search_applied','hide');
		}
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
			$data['leads']['contact_us_leads'] = $this->getContactUsLeads($data['start_date'],$data['end_date'],$location);
		}*/
		
		if($lead_type == "all" || $lead_type == "dojocart"){
			$data['leads']['dojocart_leads'] = $this->getDojocartLeads($data['start_date'],$data['end_date'],$location,$search_query);
		}
		
		
		if(isset($data['leads']) && !empty($data['leads'])){
			
			foreach($data['leads'] as $key=> $lead_data){
				$a = 0;
				if(!empty($lead_data)){
					foreach($lead_data as  $lead){
					  if($lead->kanban_status_id > 0){
							$lead_type = str_replace('_leads','',$key);
							
							/*if($lead_type == "birthday_parties" || $lead_type == "contact_us" ){
								$created = strtotime($lead->date_added);
							}else{
								$created = strtotime($lead->created);
							}
							
							$new_lead_type = $this->query_model->getKanbanLeadTypeToOrderType($lead_type);
							
							$sort_number = $this->query_model->getKanbanOrderSortNumber($lead->kanban_status_id,$new_lead_type,$lead->id);
							if($sort_number == 0){
								$sort_number = $this->query_model->createAndGetKanbanOrderSortNumber($lead->kanban_status_id,$new_lead_type,$lead->id);
							}
							$lead->sort_number = $sort_number;*/
							$data['filterd_leads'][$lead->email][$a] = $lead;  
							$data['filterd_leads'][$lead->email][$a]->lead_type = $lead_type;
							if($lead_type == "birthday_parties" || $lead_type == "contact_us" ){
								$data['filterd_leads'][$lead->email][$a]->created = $lead->date_added;
								$data['filterd_leads'][$lead->email][$a]->offer_type = "";
								$data['filterd_leads'][$lead->email][$a]->trans_status = "";
								if($lead_type == "contact_us"){
									if(!empty($lead->school)){
										$this->db->select(array('id','name'));
										$locationDetail = $this->query_model->getBySpecific('tblcontact','name',$lead->school);
										if(!empty($locationDetail)){
											$data['filterd_leads'][$lead->email][$a]->location_id = $locationDetail[0]->id;
										}
									}
									
								}
							}elseif($lead_type == "dojocart"){
								$data['filterd_leads'][$lead->email][$a]->location_id = $lead->location;
							}
						$a++;
						}
					}
				}
				
			}
		}
		
	$orderLeadsSortEmail = array();
	$orderLeadsFiltered = array();
	if(isset($data['filterd_leads']) && !empty($data['filterd_leads'])){
		foreach($data['filterd_leads'] as $lead_data){
			foreach($lead_data as $key => $lead){
				$orderLeadsSortEmail[strtotime($lead->created)] = $lead;
			}
		}
		
		ksort($orderLeadsSortEmail);
		
		if(!empty($orderLeadsSortEmail)){
			foreach($orderLeadsSortEmail as $newlead_data){
				
				$new_lead_type = $this->query_model->getKanbanLeadTypeToOrderType($newlead_data->lead_type);
				//	echo '<pre>newlead_data'; print_r($new_lead_type); die;	
				$sort_number = $this->query_model->getKanbanOrderSortNumber($newlead_data->kanban_status_id,$new_lead_type,$newlead_data->id);
				
				if(empty($sort_number) || $sort_number == 0){
					$sort_number = $this->query_model->createAndGetKanbanOrderSortNumber($newlead_data->kanban_status_id,$new_lead_type,$newlead_data->id);
				}
				
				$newlead_data->sort_number = $sort_number;
				
				$orderLeadsFiltered[$newlead_data->kanban_status_id][$sort_number] = $newlead_data;
			}
		}
	}
	
	$data['all_leads'] = array();
	if(isset($data['kanban_lead_status']) && !empty($data['kanban_lead_status'])){
		foreach($data['kanban_lead_status'] as $status){
			if(isset($orderLeadsFiltered[$status->id]) && !empty($orderLeadsFiltered[$status->id])){
				ksort($orderLeadsFiltered[$status->id]);
				$data['all_leads'][$status->id] = $orderLeadsFiltered[$status->id];
			}
			
		}
	}
	
	
		
		$this->db->where('id',1);
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$this->db->order_by('sort_number','asc');
		$this->db->select(array('id','title','color_code'));
		$data['kanban_lead_all_status'] = $this->query_model->getbyTable("tbl_kanban_lead_status");
		
		$this->db->order_by('id','desc');
		$this->db->group_by('tag');
		$this->db->select('tag');
		$data['kanban_lead_tags'] = $this->query_model->getbyTable("tbl_kanban_lead_tags");
		
		//echo '<pre>'; print_r($data); die;	
		
		$this->load->view('admin/kanban_leads',$data);
		
}

public function get_filtered_lead_data($leads){
	$result = array();
	if(!empty($leads)){
		foreach($leads as $lead){
			$result[$lead->email] = $lead;
		}
	}
	
	return $result;
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
	//echo "select * from (select DISTINCT email,id,name,last_name,phone,location_id,last_order_id,offer_type,trans_status,is_unique_trial,trial_id,created,is_delete,kanban_status_id from tblorders order by id desc) as orders where ".$where." GROUP by orders.email"; die;
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,location_id,last_order_id,offer_type,trans_status,is_unique_trial,trial_id,created,is_delete,kanban_status_id from tblorders order by id desc) as orders where ".$where." GROUP by orders.email");
	$leads = $query->result();
	
	return $leads;
}

	
public function getBirthdayPartiesLeads($start_date,$end_date,$search_query){
	
	$where = 'is_delete = 0 and ';
	$where .= "DATE_FORMAT(date_added,'%Y-%m-%d') >= '".$start_date."' and ";
	$where .= "DATE_FORMAT(date_added,'%Y-%m-%d') <= '".$end_date."'";
	
	$where .= $this->kanbanFilterSearchQuery($search_query,'birthday_party_lead');
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,location_id,party_date,guests,date_added,is_delete,kanban_status_id from tblbirthdayparty order by id desc) as orders where ".$where." GROUP by orders.email");
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
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,school,message,date_added,is_delete,kanban_status_id from tblcontactusleads order by id desc) as orders where ".$where." GROUP by orders.email");
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
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,location,product_id,offer_type,amount,trans_status,created,is_delete,kanban_status_id from tbl_dojocart_orders order by id desc) as orders where ".$where." GROUP by orders.email");
	$leads = $query->result();
	
	
	return $leads;
}


public function kanbanFilterSearchQuery($search_query,$lead_type){
	$where = '';
							
	$kanban_status_id = (isset($search_query['kanban_status_id']) && !empty($search_query['kanban_status_id'])) ? $search_query['kanban_status_id'] : '';
	$search_keyword = (isset($search_query['search_keyword']) && !empty($search_query['search_keyword'])) ? $search_query['search_keyword'] : '';
	$tags = (isset($search_query['tags']) && !empty($search_query['tags'])) ? $search_query['tags'] : '';
	
	if(!empty($kanban_status_id)){
		$where .= ' and kanban_status_id = "'.$kanban_status_id.'"';
	}
	
	if(!empty($search_keyword)){
		$where .= ' and (name LIKE "%'.$search_keyword.'%" OR email LIKE "%'.$search_keyword.'%" OR phone LIKE "%'.$search_keyword.'%")';
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



public function ajax_kanban_lead_info(){
	
		$data = array();
		if(isset($_POST['action']) && $_POST['action'] == "get_record"){
			$lead_id = isset($_POST['lead_id']) ? $_POST['lead_id'] : '';
			$lead_type = isset($_POST['lead_type']) ? $_POST['lead_type'] : '';
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			
			if(!empty($lead_id) && !empty($email) && !empty($lead_type)){
				$new_lead_type = $this->query_model->getKanbanLeadTypeToOrderType($lead_type);
				//echo $new_lead_type;
				$page_name = '';
				
				$data['main_lead_detail'] = array();
				$main_lead_detail =  $this->getMainLeadById($lead_id,$lead_type);
				
				foreach($main_lead_detail as $key => $value){
					$data['main_lead_detail'][$key] = $value;
				}
				
				$data['main_lead_detail']['order_type'] = $lead_type;
				
				
				
				if($new_lead_type == "trial_offer_lead"){
					if(isset($data['main_lead_detail']['page_url']) && !empty($data['main_lead_detail']['page_url'])){
						$PagesList = $this->query_model->getMenuMainPages(0,3);
						$pagesListing = array();
						foreach($PagesList as $pages){
							$pagesListing =  $this->query_model->getAllPagesForAddCode($pages['id'], $pages['slug']);
						}
						
						$page_name = isset($pagesListing[$data['main_lead_detail']['page_url']]) ? $pagesListing[$data['main_lead_detail']['page_url']] : '';
					}
					
				}elseif($new_lead_type == "birthday_party_lead"){
					if(isset($data['main_lead_detail']['program_id']) && !empty($data['main_lead_detail']['program_id'])){
						
						$this->db->select('program');
						$program_detail = $this->query_model->getBySpecific('tblprogram','id',$data['main_lead_detail']['program_id']);
						
						$page_name = !empty($program_detail) ? $program_detail[0]->program : '';
						
					}
					
					$data['main_lead_detail']['created'] = $data['main_lead_detail']['date_added'];
				}elseif($new_lead_type == "dojocart_lead"){
					$data['main_lead_detail']['location_id'] = $main_lead_detail->location;
					if(isset($data['main_lead_detail']['product_id']) && !empty($data['main_lead_detail']['product_id'])){
						
						$this->db->select('product_title');
						$dojocart_detail = $this->query_model->getBySpecific('tbl_dojocarts','id',$data['main_lead_detail']['product_id']);
						
						$page_name = !empty($dojocart_detail) ? $dojocart_detail[0]->product_title : '';
					}
				}
				
				
				
				$data['page_name'] = $page_name;
				$data['lead_types'] = array('email_opt_in'=>'Email Opt-in','free_trial'=>'Free Trial','paid_trial'=>'Paid Trial','upsell_trial'=>'Upsell Trial','contact_us'=>'Contact Us','dojocart'=>'Dojocart','birthday_parties'=>'Birthday Parties / Summer Camp');
				
				
				//echo '<prE>data'; print_r($data); die;
				
			
			}
			
		}
	
	
		$this->load->view('admin/ajax_kanban_lead_info',$data);
		
}


public function getAllLeadsByEmail($email,$lead_type){
	
	$result = array();
	
	if($lead_type == "birthday_parties"){
		$this->db->select(array('email','id','name','last_name','phone','location_id','party_date','guests','date_added','ip_address','gdpr_compliant_checkbox','client_country_name','reserve_or_schedule'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblbirthdayparty', 'email',$email);
	
	}elseif($lead_type == "contact_us"){
		$this->db->select(array('email','id','name','last_name','phone','school','message','date_added','ip_address','gdpr_compliant_checkbox','client_country_name'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblcontactusleads', 'email',$email);
	
	}elseif($lead_type == "dojocart"){
		$this->db->select(array('email','id','name','last_name','phone','location','product_id','offer_type','amount','trans_status','created','is_multi_item_dojocart','quantity','coupon_code','coupon_discount','tax','amount','custom_fields','ip_address','client_country_name'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tbl_dojocart_orders', 'email',$email);
	
	}else{
		
		if($lead_type == "email_opt_in"){ 
			$this->db->where('offer_type',NULL);
		}elseif($lead_type == "free_trial"){
			$this->db->where('offer_type','Free');
		}elseif($lead_type == "paid_trial"){
			$this->db->where('offer_type','Paid');
		}/*elseif($lead_type == "upsell_trial"){
			$this->db->where('last_order_id >',0);
		}*/
		$this->db->select(array('email','id','name','last_name','phone','location_id','last_order_id','offer_type','trans_status','is_unique_trial','trial_id','created','child_name','child_age','program_id','upsells_title','coupon_code','coupon_discount','amount','ip_address','gdpr_compliant_checkbox','client_country_name','page_url'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblorders', 'email',$email);
	}
	
	return $result;
}


public function getMainLeadById($lead_id,$lead_type){
	
	if($lead_type == "birthday_parties"){
		$this->db->select(array('email','id','name','last_name','phone','location_id','party_date','guests','date_added','kanban_status_id','ip_address','program_id'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblbirthdayparty', 'id',$lead_id);
	}elseif($lead_type == "contact_us"){
		$this->db->select(array('email','id','name','last_name','phone','school','message','date_added','kanban_status_id','ip_address'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblcontactusleads', 'id',$lead_id);
	}elseif($lead_type == "dojocart"){
		$this->db->select(array('email','id','name','last_name','phone','location','product_id','offer_type','amount','trans_status','created','kanban_status_id','ip_address'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tbl_dojocart_orders', 'id',$lead_id);
	}else{
		$this->db->select(array('email','id','name','last_name','phone','location_id','last_order_id','offer_type','trans_status','is_unique_trial','trial_id','created','kanban_status_id','ip_address','page_url'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblorders', 'id',$lead_id);
	}
	
	$result = !empty($result) ? $result[0] : array();
	
	return $result;
}

public function ajax_delete_single_lead(){
	
	if(isset($_POST['action']) && $_POST['action'] == "delete_single_lead"){
		$item_id = (isset($_POST['item_id']) && !empty($_POST['item_id'])) ? $_POST['item_id'] : '';
		$lead_type = (isset($_POST['lead_type']) && !empty($_POST['lead_type'])) ? $_POST['lead_type'] : '';
		$email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : '';
		
		if(!empty($item_id) && !empty($lead_type) && !empty($email)){
			$table_name = '';
			if($lead_type == "birthday_parties"){
				$table_name = 'tblbirthdayparty';
			}elseif($lead_type == "contact_us"){
				$table_name = 'tblcontactusleads';
			}elseif($lead_type == "dojocart"){
				$table_name = 'tbl_dojocart_orders';
			}else{
				$table_name = 'tblorders';
			}
				
			$data['is_delete'] = 2;
			$this->db->where("email", $email);
			$this->db->where("id", $item_id);
			$this->db->update($table_name, $data); 
			
			echo 1; die;
		}
	}
}
	
public function ajax_delete_record(){
	
	parse_str($_POST['formData'], $searcharray);
		
		$id = isset($searcharray['delete-item-id']) ? $searcharray['delete-item-id'] : 0;
		$email = isset($searcharray['delete-lead-email']) ? $searcharray['delete-lead-email'] : '';
		$lead_type = isset($searcharray['lead_type']) ? $searcharray['lead_type'] : '';
		
		if(!empty($id) && !empty($lead_type) && !empty($email)){
			$tables = array('tblorders','tblbirthdayparty','tblcontactusleads','tbl_dojocart_orders');
			
			foreach($tables as $table){ 
				$data['is_delete'] = 2;
				$this->db->where("is_delete", 0);
				$this->db->where("email", $email);
				$this->db->update($table, $data);
			}
			
			echo 1; die;
		}
		exit();	
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
			$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$start_date = date("Y-m-01",$monday);
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
	
	
public function update_search_bar(){
	$is_display_search = (isset($_POST['is_display_search']) && !empty($_POST['is_display_search'])) ? $_POST['is_display_search'] : '';
	$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
	
	$data = array();
	$data['response'] = 0;
	if(!empty($is_display_search) && $action == "update_search_bar"){
		$this->session->set_userdata('is_search_applied',$is_display_search);
		$data['response'] = 1;
	}
	
	echo json_encode($data); die;
}

public function ajax_add_kanban_lead_status(){
	
	$action_type = (isset($_POST['action_type']) && !empty($_POST['action_type'])) ? $_POST['action_type'] : '';
	$item_id = (isset($_POST['item_id']) && !empty($_POST['item_id'])) ? $_POST['item_id'] : '';
	$table_name = (isset($_POST['table_name']) && !empty($_POST['table_name'])) ? $_POST['table_name'] : '';
	$form_type = (isset($_POST['form_type']) && !empty($_POST['form_type'])) ? $_POST['form_type'] : '';
	
	$records = array();
	
	if(!empty($action_type) && !empty($table_name)  && !empty($form_type) ){
		
		$records['action_type'] = $action_type;
		$records['item_id'] = $item_id;
		$records['form_type'] = $form_type;
		$records['table_name'] = $table_name;
		
		if($records['action_type'] == "edit" && !empty($records['item_id'])){
				
			$this->db->where("id", $records['item_id']);
			$detail = $this->query_model->getbyTable($records['table_name']);
			if(!empty($detail)){
				$records['detail'] = $detail[0];
			}
		}
		
		$this->load->view("admin/ajax_add_kanban_lead_status", $records);
		
	}
	
}


public function ajax_save_full_alternate_row(){
	
		
		parse_str($_POST['formData'], $searcharray);
		
		$result = array();
		$result['res'] = 0;
		if(isset($searcharray['update'])){
				
				$item_id = isset($searcharray['item_id']) ? $searcharray['item_id'] : '';
				
				$data['title'] = isset($searcharray['title']) ? $searcharray['title'] : '';
				$data['color_code'] = isset($searcharray['color_code']) ? $searcharray['color_code'] : '';					
				
				$table_name = isset($searcharray['table_name']) ? $searcharray['table_name'] : '';
				$form_type = isset($searcharray['form_type']) ? $searcharray['form_type'] : '';
				
				if(!empty($item_id)){
					
					$this->query_model->updateData($table_name,'id',$item_id, $data);
					$insert_id = $item_id;
					$result['form_action'] = 'edit';
				}else{
					
					$data['status'] = 1;
					$data['sort_number'] = 0;
					$this->query_model->insertData($table_name, $data);
					$insert_id = $this->db->insert_id();
					$result['form_action'] = 'add';
				}
					
					$result['res'] = 1;
					$result['id'] = $insert_id;
					$result['title'] = $data['title'];
					$result['form_type'] = $form_type;
					$result['table_name'] = $table_name;
					$result['color_code'] = $data['color_code'];
				
			}
		echo json_encode($result); 	die;
}

public function ajax_sort_kanban_status(){
	$responseData = (isset($_POST['responseData']) && !empty($_POST['responseData'])) ? $_POST['responseData'] : '';
	$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
	
	$data = array();
	$data['response'] = 0;
	if(!empty($responseData) && $action == "sort_kanban_status"){
		
		$sortPositions = array();
		foreach($responseData as $sort_data){
			
			$sortPositions[trim($sort_data['position'])] = $sort_data['kanban_status_id'];
		}
		
		ksort($sortPositions);
		
		$i = 1;
		foreach($sortPositions as $sort_position => $kanban_status_id){
			$updateData = array();
			$updateData['sort_number'] = $i;
			$this->query_model->updateData('tbl_kanban_lead_status','id',$kanban_status_id, $updateData);
		$i++;
		}
		
		$data['response'] = 1;
	}
	
	echo json_encode($data); die;
}

public function update_move_lead_status_id(){
	
	$lead_type = (isset($_POST['lead_type']) && !empty($_POST['lead_type'])) ? $_POST['lead_type'] : '';
	$lead_id = (isset($_POST['lead_id']) && !empty($_POST['lead_id'])) ? $_POST['lead_id'] : '';
	$new_kanban_status_id = (isset($_POST['new_kanban_status_id']) && !empty($_POST['new_kanban_status_id'])) ? $_POST['new_kanban_status_id'] : '';
	$old_kanban_status_id = (isset($_POST['old_kanban_status_id']) && !empty($_POST['old_kanban_status_id'])) ? $_POST['old_kanban_status_id'] : '';
	$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
	
	$data = array();
	$data['response'] = 0;
	if(!empty($lead_type) && !empty($lead_id) && !empty($new_kanban_status_id) && !empty($old_kanban_status_id) && $action == "update_lead_status"){
		
		$leadTypes = array('dojocart_lead'=>'tbl_dojocart_orders','birthday_party_lead'=>'tblbirthdayparty','trial_offer_lead'=>'tblorders');
		
		$table_name = isset($leadTypes[$lead_type]) ? $leadTypes[$lead_type] : '';
		
		if(!empty($table_name)){
			
			$updateData = array();
			$updateData['kanban_status_id'] = $new_kanban_status_id;
			$this->query_model->updateData($table_name,'id',$lead_id, $updateData);
			
			$this->db->where('kanban_status_id',$old_kanban_status_id);
			$this->db->where('lead_type',$lead_type);
			$this->db->where('lead_id',$lead_id);
			$this->db->delete('tbl_kanban_lead_sort_numbers');
			
			$this->query_model->createAndGetKanbanOrderSortNumber($new_kanban_status_id,$lead_type,$lead_id);
			
			$data['response'] = 1;
			$data['status_type_id'] = $new_kanban_status_id;
		}
		
	}
	
	echo json_encode($data); die;
}

public function ajax_sort_kanban_leads(){
	$responseData = (isset($_POST['responseData']) && !empty($_POST['responseData'])) ? $_POST['responseData'] : '';
	$kanban_status_id = (isset($_POST['kanban_status_id']) && !empty($_POST['kanban_status_id'])) ? $_POST['kanban_status_id'] : '';
	$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
	
	$data = array();
	$data['response'] = 0;
	if(!empty($responseData) && !empty($kanban_status_id) && $action == "sort_kanban_leads"){
		
		$sortPositions = array();
		foreach($responseData as $sort_data){
			$position = trim(str_replace(')','',$sort_data['position']));
			$sortPositions[$position] = $sort_data;
		}
		
		ksort($sortPositions);
		
		$this->db->where('kanban_status_id',$kanban_status_id);
		$this->db->delete('tbl_kanban_lead_sort_numbers');
		
		$i = 1000;
		foreach($sortPositions as $sort_position => $sort_data){
			$insertData = array();
			$insertData['sort_number'] = $i;
			$insertData['lead_type'] = $sort_data['lead_type'];
			$insertData['lead_id'] = $sort_data['lead_id'];
			$insertData['kanban_status_id'] = $kanban_status_id;
			$this->query_model->insertData('tbl_kanban_lead_sort_numbers',$insertData);
		$i++;
		}
		
		$data['response'] = 1;
	}
	
	echo json_encode($data); die;
}	


public function ajax_add_kanban_order_tag(){
	
	$lead_type = (isset($_POST['lead_type']) && !empty($_POST['lead_type'])) ? $_POST['lead_type'] : '';
	$lead_id = (isset($_POST['lead_id']) && !empty($_POST['lead_id'])) ? $_POST['lead_id'] : '';
	$tag_type = (isset($_POST['tag_type']) && !empty($_POST['tag_type'])) ? $_POST['tag_type'] : '';
	$tag = (isset($_POST['tag']) && !empty($_POST['tag'])) ? $_POST['tag'] : '';
	$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
	
	$data = array();
	$data['response'] = 0;
	if(!empty($lead_type) && !empty($lead_id) && !empty($tag_type) && !empty($tag) && $action == "add_kanban_tag"){
			$insertData = array();
			$insertData['lead_type'] = $lead_type;
			$insertData['order_id'] = $lead_id;
			$insertData['tag_type'] = $tag_type;
			$insertData['tag'] = $tag;
			$this->query_model->insertData('tbl_kanban_lead_tags',$insertData);
			$insert_id = $this->db->insert_id();
			
			$data['response'] = 1;
			$data['tag_id'] = $insert_id;
	}
	
	echo json_encode($data); die;
}



public function ajax_remove_kanban_order_tag(){
	
	$tag_id = (isset($_POST['tag_id']) && !empty($_POST['tag_id'])) ? $_POST['tag_id'] : '';
	$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
	
	$data = array();
	$data['response'] = 0;
	if(!empty($tag_id) && $action == "remove_kanban_tag"){
			
			$this->db->where('id',$tag_id);
			$this->db->delete('tbl_kanban_lead_tags');
			$data['response'] = 1;
	}
	
	echo json_encode($data); die;
}

public function save_lead_comment(){
	$lead_type = (isset($_POST['lead_type']) && !empty($_POST['lead_type'])) ? $_POST['lead_type'] : '';
	$lead_id = (isset($_POST['lead_id']) && !empty($_POST['lead_id'])) ? $_POST['lead_id'] : '';
	$comment = (isset($_POST['comment']) && !empty($_POST['comment'])) ? $_POST['comment'] : '';
	$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
	
	$data = array();
	$data['response'] = 0;
	if(!empty($lead_type) && !empty($lead_id) && !empty($comment) && $action == "send_comment"){
		
			$insertData = array();
			$insertData['lead_type'] = $lead_type;
			$insertData['lead_id'] = $lead_id;
			$insertData['comment'] = $comment;
			$insertData['created'] = date('Y-m-d H:i:s');
			
			$this->query_model->insertData('tbl_kanban_lead_comments',$insertData);
			$insert_id = $this->db->insert_id();
			
			$data['response'] = 1;
			$data['comment'] = $comment;
	}
	
	echo json_encode($data); die;
}


public function update_lead_status_id(){
	$lead_type = (isset($_POST['lead_type']) && !empty($_POST['lead_type'])) ? $_POST['lead_type'] : '';
	$lead_id = (isset($_POST['lead_id']) && !empty($_POST['lead_id'])) ? $_POST['lead_id'] : '';
	$status_type = (isset($_POST['status_type']) && !empty($_POST['status_type'])) ? $_POST['status_type'] : '';
	$old_kanban_status_id = (isset($_POST['kanban_status_id']) && !empty($_POST['kanban_status_id'])) ? $_POST['kanban_status_id'] : '';
	$action = (isset($_POST['action']) && !empty($_POST['action'])) ? $_POST['action'] : '';
	
	$data = array();
	$data['response'] = 0;
	if(!empty($lead_type) && !empty($lead_id) && !empty($status_type) && $action == "update_lead_status"){
		
		$leadTypes = array('dojocart_lead'=>'tbl_dojocart_orders','birthday_party_lead'=>'tblbirthdayparty','trial_offer_lead'=>'tblorders');
		$table_name = isset($leadTypes[$lead_type]) ? $leadTypes[$lead_type] : '';
		
		$kanban_status_id = ($status_type == "won") ? 5 : 6;
		$updateData = array();
		$updateData['kanban_status_id'] = $kanban_status_id;
		$this->query_model->updateData($table_name,'id',$lead_id, $updateData);
		
		$this->db->select('title');
		$kanban_status = $this->query_model->getBySpecific('tbl_kanban_lead_status','id',$kanban_status_id);
		$kanban_status_name = !empty($kanban_status) ? $kanban_status[0]->title : '';
		
		$this->db->select('title');
		$old_kanban_status = $this->query_model->getBySpecific('tbl_kanban_lead_status','id',$old_kanban_status_id);
		$old_kanban_status_name = !empty($old_kanban_status) ? $old_kanban_status[0]->title : '';
		
		$data['response'] = 1;
		$data['status_type_id'] = $kanban_status_id;
		$data['kanban_status_name'] = $kanban_status_name;
		$data['old_kanban_status_name'] = $old_kanban_status_name;
	}
	
	echo json_encode($data); die;
}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */