<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leads extends CI_Controller {

	
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
		
		$data['title'] = "Leads";
		$data['link_type'] = "leads/orders"; 
		
		$data['lead_types'] = array('email_opt_in'=>'Email Opt-in','free_trial'=>'Free Trial','paid_trial'=>'Paid Trial','upsell_trial'=>'Upsell Trial','birthday_parties'=>'Birthday Parties / Summer Camp','contact_us'=>'Contact Us','dojocart'=>'Dojocart');
		
		
		$data['date_sort'] = (isset($_GET['date_sort']) && !empty($_GET['date_sort'])) ? $_GET['date_sort'] : 'current_month';
		$data['dateRanges'] = $this->getStartAndEndDate($data['date_sort']);
		$lead_status = (isset($_GET['lead_status']) && !empty($_GET['lead_status'])) ? $_GET['lead_status'] : '';
		$tags = (isset($_GET['tags']) && !empty($_GET['tags'])) ? $_GET['tags'] : '';
		
		
		$this->db->order_by('sort_number','asc');
		$this->db->select(array('id','title','color_code'));
		if(!empty($lead_status)){
			$this->db->where("id", $lead_status);
		}
		$data['kanban_lead_status'] = $this->query_model->getbyTable("tbl_kanban_lead_status");
		$search_query = array(
							'kanban_status_id' => $lead_status,
							'tags' => $tags,
							);
		
		
		if($data['date_sort'] == "custom_range"){
			
			$data['start_date'] = (isset($_GET['start_date']) && !empty($_GET['start_date'])) ? $_GET['start_date'] : '';
			$data['end_date'] = (isset($_GET['end_date']) && !empty($_GET['end_date'])) ? $_GET['end_date'] : '';
		}else{
			$data['start_date'] = $data['dateRanges']['start_date'];
			$data['end_date'] =  $data['dateRanges']['end_date'];
		}
		
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
		
		if($lead_type == "all" || $lead_type == "contact_us"){
			$data['leads']['contact_us_leads'] = $this->getContactUsLeads($data['start_date'],$data['end_date'],$location,$search_query);
		}
		
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
			
		}
		
		//echo '<pre>'; print_r($data['all_leads']); die;
		//echo '<pre>orderLeadsSortEmail'; print_r($data['all_leads']); die;
		/*echo '<pre>'; print_r($data['filterd_leads']); die;
		$data['all_leads'] = array();
		$orderLeadsFiltered = array();
		if(isset($data['filterd_leads']) && !empty($data['filterd_leads'])){
			foreach($data['filterd_leads'] as $lead_data){
				foreach($lead_data as $key => $lead){
					$data['all_leads'][strtotime($lead->created)] = $lead;
				}
			}
			
			krsort($data['all_leads']);
			
			//echo '<pre>orderLeadsSortEmail'; print_r($orderLeadsSortEmail); die;
			
		}*/
		
		/*$data['all_leads'] = array();
		if(!empty($data['filterd_leads'])){
			foreach($data['filterd_leads'] as $email => $lead_data){
				$last_date = '';
				foreach($lead_data as $key => $lead){
					if(strtotime($lead->created) > $last_date){
						$last_date = strtotime($lead->created);
						$data['all_leads'][$lead->email] = $lead;
					}
				}
			}
		}*/
	//echo '<pre>'; print_r($data['all_leads']); die;	
		
		$this->db->where('id',1);
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		/*if($data['multiLocation'][11]->field_value == 1){
			$this->db->where("main_location", 0);
		}*/
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		$this->db->order_by('sort_number','asc');
		$this->db->select(array('id','title','color_code'));
		$data['kanban_lead_all_status'] = $this->query_model->getbyTable("tbl_kanban_lead_status");
		
		$this->db->order_by('id','desc');
		$this->db->group_by('tag');
		$this->db->select('tag');
		$data['kanban_lead_tags'] = $this->query_model->getbyTable("tbl_kanban_lead_tags");
		
		$this->load->view('admin/all_leads',$data);
		
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
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,location_id,last_order_id,offer_type,trans_status,is_unique_trial,trial_id,created,is_delete,kanban_status_id from tblorders order by id desc) as orders where ".$where);
	$leads = $query->result();
	
	return $leads;
}
	
	
public function getBirthdayPartiesLeads($start_date,$end_date,$search_query){
	
	$where = 'is_delete = 0 and ';
	$where .= "DATE_FORMAT(date_added,'%Y-%m-%d') >= '".$start_date."' and ";
	$where .= "DATE_FORMAT(date_added,'%Y-%m-%d') <= '".$end_date."'";
	
	$where .= $this->kanbanFilterSearchQuery($search_query,'birthday_party_lead');
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,location_id,party_date,guests,date_added,is_delete,kanban_status_id from tblbirthdayparty order by id desc) as orders where ".$where);
	$leads = $query->result();
	
	
	
	/*$this->db->where("DATE_FORMAT(date_added,'%Y-%m-%d') >= ", $start_date);
	$this->db->where("DATE_FORMAT(date_added,'%Y-%m-%d') <= ", $end_date);
	$this->db->order_by("id", "desc");
	$this->db->group_by('email');
	$this->db->select(array('id','name','last_name','phone','email','location_id','party_date','guests','date_added'));
	$leads = $this->query_model->getByTable('tblbirthdayparty');*/
	
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
	
	
	/*$this->db->where("DATE_FORMAT(date_added,'%Y-%m-%d') >= ", $start_date);
	$this->db->where("DATE_FORMAT(date_added,'%Y-%m-%d') <= ", $end_date);
	if(isset($location) && !empty($location)){
		$this->db->where('school',$location);
	}
	$this->db->order_by("id", "desc");
	$this->db->group_by('email');
	$this->db->select(array('id','name','last_name','phone','email','school','message','date_added'));
	$leads = $this->query_model->getByTable('tblcontactusleads');*/
	
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
	
	//"select * from (select DISTINCT email,id,name,last_name,phone,location,product_id,offer_type,amount,trans_status,created,is_delete,kanban_status_id from tbl_dojocart_orders order by id desc) as orders where ".$where." GROUP by orders.email"
	
	$query = $this->db->query("select * from (select DISTINCT email,id,name,last_name,phone,location,product_id,offer_type,amount,trans_status,created,is_delete,kanban_status_id from tbl_dojocart_orders order by id desc) as orders where ".$where);
	$leads = $query->result();
	
	/*$this->db->where("DATE_FORMAT(created,'%Y-%m-%d') >= ", $start_date);
	$this->db->where("DATE_FORMAT(created,'%Y-%m-%d') <= ", $end_date);
	if(isset($location) && !empty($location)){
		$this->db->where('location',$location);
	}
	$this->db->order_by("id", "desc");
	$this->db->group_by('email');
	$this->db->select(array('id','name','last_name','phone','email','location','product_id','offer_type','amount','trans_status','created'));
	$leads = $this->query_model->getByTable('tbl_dojocart_orders');*/
	
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






public function ajax_trial_lead_info(){
	/*$_POST['action'] = "get_record";
	$_POST['email'] = "dojodeveloper158@gmail.com";
	$_POST['lead_id'] = 94;
	$_POST['lead_type'] = 'mini_trial';*/
	
		$data = array();
		$data['orders'] = array();
		if(isset($_POST['action']) && $_POST['action'] == "get_record"){
			$lead_id = isset($_POST['lead_id']) ? $_POST['lead_id'] : '';
			$lead_type = isset($_POST['lead_type']) ? $_POST['lead_type'] : '';
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			
			if(!empty($lead_id) && !empty($email) && !empty($lead_type)){
				
				$data['main_lead'] =  $this->getMainLeadById($lead_id,$lead_type);
				
				$data['lead_types'] = array('email_opt_in'=>'Email Opt-in','free_trial'=>'Free Trial','paid_trial'=>'Paid Trial','upsell_trial'=>'Upsell Trial','contact_us'=>'Contact Us','dojocart'=>'Dojocart','birthday_parties'=>'Birthday Parties / Summer Camp');
				
				foreach($data['lead_types'] as $lead_type => $lead_name){
					if($lead_type != "upsell_trial"){
						$data['all_leads'][$lead_type.'_leads'] = $this->getAllLeadsByEmail($email,$lead_type);
					}
				}
				
				//echo '<pre>'; print_r($data['all_leads']); die;
				
				if(isset($data['all_leads']) && !empty($data['all_leads'])){
			
					foreach($data['all_leads'] as $key=> $lead_data){
						
						$a = 0;
						if(!empty($lead_data)){
							foreach($lead_data as $lead){
								$type = '';
								$type = str_replace('_leads','',$key);
								if($type == "birthday_parties" || $type == "contact_us" ){
									$lead->created = $lead->date_added;
								}else{
									$lead->created = $lead->created;
								}
								
								$date_created = strtotime($lead->created);
								
								$data['orders'][$date_created][$a] = $lead;
								$data['orders'][$date_created][$a]->lead_type = $type;
								if($type == "birthday_parties" || $type == "contact_us" ){
									$data['orders'][$date_created][$a]->offer_type = "";
									$data['orders'][$date_created][$a]->trans_status = "";
									if($type == "contact_us"){
										if(!empty($lead->school)){
											$this->db->select(array('id','name'));
											$locationDetail = $this->query_model->getBySpecific('tblcontact','name',$lead->school);
											if(!empty($locationDetail)){
												$data['orders'][$date_created][$a]->location_id = $locationDetail[0]->id;
											}
										}
										
									}
								}elseif($type == "dojocart"){
									$data['orders'][$date_created][$a]->location_id = $lead->location;
								}
							$a++;
							}
						}
						
					}
				}
				
				krsort($data['orders']);
				//echo '<pre>'; print_r($data['orders']); die;
			
			}
			
		}
	
	
		$this->load->view('admin/ajax_trial_lead_info',$data);
		
}


public function getAllLeadsByEmail($email,$lead_type){
	
	$result = array();
	
	if($lead_type == "birthday_parties"){
		$this->db->select(array('email','id','name','last_name','phone','location_id','party_date','guests','date_added','ip_address','gdpr_compliant_checkbox','client_country_name','reserve_or_schedule','kanban_status_id'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblbirthdayparty', 'email',$email);
	
	}elseif($lead_type == "contact_us"){
		$this->db->select(array('email','id','name','last_name','phone','school','message','date_added','ip_address','gdpr_compliant_checkbox','client_country_name','kanban_status_id'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblcontactusleads', 'email',$email);
	
	}elseif($lead_type == "dojocart"){
		$this->db->select(array('email','id','name','last_name','phone','location','product_id','offer_type','amount','trans_status','created','is_multi_item_dojocart','quantity','coupon_code','coupon_discount','tax','amount','custom_fields','ip_address','client_country_name','kanban_status_id'));
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
		$this->db->select(array('email','id','name','last_name','phone','location_id','last_order_id','offer_type','trans_status','is_unique_trial','trial_id','created','child_name','child_age','program_id','upsells_title','coupon_code','coupon_discount','amount','ip_address','gdpr_compliant_checkbox','client_country_name','page_url','kanban_status_id'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblorders', 'email',$email);
	}
	
	return $result;
}


public function getMainLeadById($lead_id,$lead_type){
	
	if($lead_type == "birthday_parties"){
		$this->db->select(array('email','id','name','last_name','phone','location_id','party_date','guests','date_added'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblbirthdayparty', 'id',$lead_id);
	}elseif($lead_type == "contact_us"){
		$this->db->select(array('email','id','name','last_name','phone','school','message','date_added'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tblcontactusleads', 'id',$lead_id);
	}elseif($lead_type == "dojocart"){
		$this->db->select(array('email','id','name','last_name','phone','location','product_id','offer_type','amount','trans_status','created'));
		$this->db->where('is_delete',0);
		$result = $this->query_model->getBySpecific('tbl_dojocart_orders', 'id',$lead_id);
	}else{
		$this->db->select(array('email','id','name','last_name','phone','location_id','last_order_id','offer_type','trans_status','is_unique_trial','trial_id','created'));
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
	
	
	
	
	public function trial(){
		
		$this->db->select('tblpayments.*, tblprogram.program');
		$this->db->from('tblpayments');
		$this->db->join('tblprogram', 'tblprogram.id = tblpayments.program_of_interest', 'left');
		$this->db->order_by("date_added", "desc");
		$this->db->order_by("tblpayments.id", "desc");
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$data['trials'] = $query->result();	
		
		$data['title'] = "Trial Leads";
		$data['link_type'] = "leads/trial";
			
		$this->load->view('admin/trialleads', $data);
	}
	
	function editTrial($id){
		
		$this->db->select('*');
		$this->db->from('tblorders');
		$this->db->where("tblorders.id", $id);
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$data['trial'] = $query->row_object();	
		//echo '<pre>'; print_r($data['trial']); echo '</pre>';	

		$this->db->select('*');
		$this->db->from('tblprogram');
		$query = $this->db->get();		
		$data['programs'] = $query->result();	
		
		$data['locations'] = $this->query_model->getAllPublishedLocation();
		
		//echo '<pre>'; print_r($data['programs']); echo '</pre>';		
		//echo '<pre>'; print_r($data['locations']); echo '</pre>';				
		
		$data['title'] = "Trial Leads";
		$data['link_type'] = "leads/trial";
			
		$this->load->view('admin/trialleads_edit', $data);
		
	}
	
	
	
	
	function deleteTrial($id){
		
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		if(isset($id)){
			$this->db->where("id", $id);
			$this->db->delete("tblpayments");
			redirect($base_url.'admin/leads/trial');
		}
	}
	
	function exportTrials(){
		
		$this->db->select('tblpayments.*, tblprogram.program');
		$this->db->from('tblpayments');
		$this->db->join('tblprogram', 'tblprogram.id = tblpayments.program_of_interest', 'left');
		$this->db->order_by("date_added", "desc");
		$this->db->order_by("tblpayments.id", "desc");
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$trials = $query->result();	
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=trial-leads.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$file = fopen('php://output', 'w');                              
      	fputcsv($file, array('Name', 'Phone', 'Email', 'Age', 'Program of interest', 'School of interest', 'Message', 'Payment Status', 'Date added'));
		
		foreach($trials as $trial){
			$record = array($trial->name, $trial->phone, $trial->email, $trial->age, $trial->program_of_interest, $trial->school_of_interest,
							str_replace(',', ' ', $trial->message), $trial->payment_status, $trial->date_added);
			fputcsv($file, $record);				
		}
		fclose($file);
		exit();	
		
	}
	
	function updateTrialLeads(){
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die;
		
		$id	= $this->input->post('id');
		$data['name']	= $this->input->post('name');
		$data['last_name']	= $this->input->post('last_name');
		$data['phone']	= $this->input->post('phone');
		$data['email'] = $this->input->post('email');
		//$data['age'] = $this->input->post('age');
		$data['location_id'] = $this->input->post('school_interest');
		$data['program_id'] = $this->input->post('program');
		//$data['message'] = $this->input->post('message');
		
		$this->db->where('id', $id);
		$this->db->update('tblorders', $data); 
		redirect('admin/leads/orders');		
	}
	
	function birthdayparties($page = 1){
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');

		$this->db->where("DATE_FORMAT(date_added,'%Y-%m')", $date);
		$totalOrders = $this->query_model->getBySpecific('tblbirthdayparty', 'is_delete',0);
		
		$totalOrders = count($totalOrders);
		
		$data['title'] = "Birthday Parties / Summer Camp Leads";
		$data['link_type'] = "leads/birthdayparties";
		
		$config = array();
	
		$config['per_page']= 20;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/leads/birthdayparties'; 
		
		$config['total_rows'] = $totalOrders;
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		$this->db->where('is_delete',0);
		$this->db->order_by("id", "desc");
		$this->db->where("DATE_FORMAT(date_added,'%Y-%m')", $date);
		$data['parties'] = $this->pagination_model->fetch_data('tblbirthdayparty',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		//echo '<pre>';print_r($config['total_rows']);
		
		$number = ($page * $config['per_page']) - $config['per_page'];
		$data['number'] = $number + 1;
		
		$this->load->view('admin/birthdayleads',$data);
		
	}
	
	function editBdayLead($id){
		
		$this->db->select('*');
		$this->db->from('tblbirthdayparty');
		$this->db->where("tblbirthdayparty.id", $id);
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$data['record'] = $query->row_object();	
		//echo '<pre>'; print_r($data['record']); echo '</pre>';					
		
		$data['title'] = "Birthday Leads";
		$data['link_type'] = "leads/birthdayparties";
			
		$this->load->view('admin/bdayleads_edit', $data);
		
	}
	
	function updateBdayLeads(){
		//echo '<pre>'; print_r($_POST); echo '</pre>';
		
		$id	= $this->input->post('id');
		$data['name']	= $this->input->post('name');
		$data['phone']	= $this->input->post('phone');
		$data['email'] = $this->input->post('email');
		$data['party_date'] = $this->input->post('party_date');
		$data['guests'] = $this->input->post('guests');
		
		$this->db->where('id', $id);
		$this->db->update('tblbirthdayparty', $data); 
		redirect('admin/leads/birthdayparties');		
	}
	
	
	function exportBday(){
		
		$this->db->select('*');
		$this->db->from('tblbirthdayparty');
		$this->db->order_by("date_added", "desc");
		$this->db->order_by("id", "desc");
		$this->db->where('is_delete',0);
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$records = $query->result();	
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=bday-leads.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$file = fopen('php://output', 'w');                              
      	fputcsv($file, array('Name','Last Name', 'Phone', 'Email', 'Party Date', 'Number of Guests', 'Date added'));
		
		foreach($records as $r){
			$name = ucfirst($r->name);
			$last_name = ucfirst($r->last_name);
			$record = array($name,$last_name, $r->phone, $r->email, $r->party_date, $r->guests, $r->date_added);
			fputcsv($file, $record);				
		}
		fclose($file);
		exit();	
		
	}
	
	function contactus($page = 1){
		
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
		
		$this->db->where("DATE_FORMAT(date_added,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('school',$_GET['location']);
		}
		$totalOrders = $this->query_model->getBySpecific('tblcontactusleads', 'is_delete',0);
		
		$totalOrders = count($totalOrders);
		
		$data['title'] = "Contact Us Leads";
		$data['link_type'] = "leads/contactus"; 
		$config = array();
	
		$config['per_page']= 20;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/leads/contactus'; 
		
		$config['total_rows'] = $totalOrders;
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		$this->db->where('is_delete',0);
		$this->db->order_by("id", "desc");
		$this->db->where("DATE_FORMAT(date_added,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('school',$_GET['location']);
		}
		$data['contacts'] = $this->pagination_model->fetch_data('tblcontactusleads',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		//echo '<pre>';print_r($config['total_rows']);
		
		$number = ($page * $config['per_page']) - $config['per_page'];
		$data['number'] = $number + 1;
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		/*if($data['multiLocation'][11]->field_value == 1){
			$this->db->where("main_location", 0);
		}*/
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		
		
		$this->load->view('admin/contactusleads',$data);
		
	}
	
	function editContactLead($id){
		
		$this->db->select('*');
		$this->db->from('tblcontactusleads');
		$this->db->where("tblcontactusleads.id", $id);
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$data['contact'] = $query->row_object();	
		//echo '<pre>'; print_r($data['contact']); echo '</pre>';
		
		$contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));
		$data['schools']=$contact_data->result();
		
		$data['title'] = "Contact Leads";
		$data['link_type'] = "leads/contactus";
			
		$this->load->view('admin/contactusleads_edit', $data);
	}
	
	function updateContactLeads(){
		//echo '<pre>'; print_r($_POST); echo '</pre>';
		
		$id	= $this->input->post('id');
		$data['name']	= $this->input->post('name');
		$data['phone']	= $this->input->post('phone');
		$data['email'] = $this->input->post('email');
		$data['school'] = $this->input->post('school');
		$data['message'] = $this->input->post('message');
		
		$this->db->where('id', $id);
		$this->db->update('tblcontactusleads', $data); 
		redirect('admin/leads/contactus');		
	}
	
	/*function deleteContactLead($id){
		
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		if(isset($id)){
			
			$this->db->where("id", $id);
			$this->db->delete("tblcontactusleads");
			redirect($base_url.'admin/leads/contactus');
		}
	}
	
	
	function deleteOnlineTrialLead($id){
		
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		if(isset($id)){
			//echo $id; die;
			$this->db->where("id", $id);
			$this->db->delete("tblorders");
			redirect($base_url.'admin/leads/orders');
		}
	}

	function deletecartLead($id){
		
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		if(isset($id)){
			//echo $id; die;
			$this->db->where("id", $id);
			$this->db->delete("tbl_dojocart_orders");
			redirect($base_url.'admin/leads/cartorders');
		}
	}

	
	function deleteBday($id){
		
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		if(isset($id)){
			$this->db->where("id", $id);
			$this->db->delete("tblbirthdayparty");
			redirect($base_url.'admin/leads/birthdayparties');
		}
	}
	*/
	
	function delete_order_leads(){
		
		$result =  0;
		if(isset($_POST['action']) && $_POST['action'] == 'delete_record'){
			
			$id = isset($_POST['number']) ? $_POST['number'] : 0;
			
			if($this->db->query("update tblorders set is_delete='1' where id=".$id.""))
			{	
				$result =  1;
			}
		}
		echo $result;
	}
	
	
	function delete_contactus_leads(){
		
		$result =  0;
		if(isset($_POST['action']) && $_POST['action'] == 'delete_record'){
			
			$id = isset($_POST['number']) ? $_POST['number'] : 0;
			
			if($this->db->query("update tblcontactusleads set is_delete='1' where id=".$id.""))
			{	
				$result =  1;
			}
		}
		echo $result;
	}
	
	function delete_cart_leads(){
		
		$result =  0;
		if(isset($_POST['action']) && $_POST['action'] == 'delete_record'){
			
			$id = isset($_POST['number']) ? $_POST['number'] : 0;
			
			if($this->db->query("update tbl_dojocart_orders set is_delete='1' where id=".$id.""))
			{	
				$result =  1;
			}
		}
		echo $result;
	}
	
	
	function delete_birthday_leads(){
		
		$result =  0;
		if(isset($_POST['action']) && $_POST['action'] == 'delete_record'){
			
			$id = isset($_POST['number']) ? $_POST['number'] : 0;
			
			if($this->db->query("update tblbirthdayparty set is_delete='1' where id=".$id.""))
			{	
				$result =  1;
			}
		}
		echo $result;
	}
	
	
	function exportContactLeads(){
		
		$this->db->select('*');
		$this->db->from('tblcontactusleads');
		$this->db->order_by("date_added", "desc");
		$this->db->where('is_delete',0);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('school',$_GET['location']);
		}
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$records = $query->result();	
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=contactleads-leads.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$file = fopen('php://output', 'w');                              
      	fputcsv($file, array('Name','Last Name', 'Phone', 'Email', 'School', 'Message', 'Date added'));
		
		foreach($records as $r){
			$name = ucfirst($r->name);
			$last_name = ucfirst($r->last_name);
			$record = array($name,$last_name, $r->phone, $r->email, $r->school, str_replace(',', ' ', $r->message), $r->date_added);
			fputcsv($file, $record);				
		}
		fclose($file);
		exit();	
		
	}
	
	function gettipsleads(){
		
		
		redirect('/admin/dashboard');
		
		
		$this->db->select('*');
		$this->db->from('tblgettipsleads');
		$this->db->order_by("date_added", "desc");
		$this->db->order_by("id", "desc");
		
		$query = $this->db->get();
		$data['tips'] = $query->result();			
		
		$data['title'] = "Get Tips Leads";
		$data['link_type'] = "leads/gettips";
			
		$this->load->view('admin/gettipsleads', $data);		
	}
	
	function editGettipsLead($id){
		
		$this->db->select('*');
		$this->db->from('tblgettipsleads');
		$this->db->where("id", $id);
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$data['tip'] = $query->row_object();	
		//echo '<pre>'; print_r($data['tip']); echo '</pre>';		
		
		$data['title'] = "Get Tip Leads";
		$data['link_type'] = "leads/gettipsleads";
			
		$this->load->view('admin/gettipsleads_edit', $data);
	}
	
	function updateGetTipsLeads(){
		//echo '<pre>'; print_r($_POST); echo '</pre>';
		
		$id	= $this->input->post('id');
		$data['name']	= $this->input->post('name');
		$data['phone']	= $this->input->post('phone');
		$data['email'] = $this->input->post('email');
		
		$this->db->where('id', $id);
		$this->db->update('tblgettipsleads', $data); 
		redirect('admin/leads/gettipsleads');		
	}
	
	function deleteGetTipslead($id){
		
		$this->load->helper(array('url'));
		$base_url = base_url();
		
		if(isset($id)){
			$this->db->where("id", $id);
			$this->db->delete("tblgettipsleads");
			redirect($base_url.'admin/leads/gettipsleads');
		}
	}
	
	function exportGetTipsleads(){
		
		$this->db->select('*');
		$this->db->from('tblgettipsleads');
		$this->db->order_by("date_added", "desc");
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$records = $query->result();	
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=gettips-leads.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$file = fopen('php://output', 'w');                              
      	fputcsv($file, array('Name', 'Phone', 'Email', 'Date added'));
		
		foreach($records as $r){
			$record = array($r->name, $r->phone, $r->email, $r->date_added);
			fputcsv($file, $record);				
		}
		fclose($file);
		exit();	
		
	}
	
	

public function orders($page = 1){
		
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
		
		if(!isset($_GET['date'])){
			//$this->checkAndDeleteSimmilerEmailLeads();
		}
		
		
		
		//$this->db->where('name !=','');
		//$this->db->where('last_name !=','');
		//$this->db->where('offer_type !=','');
		$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$totalOrders = $this->query_model->getBySpecific('tblorders', 'is_delete',0);
		//echo '<pre>totalOrders'; print_r($totalOrders); die;
		$totalOrders = count($totalOrders);
		
		$data['title'] = "Paid & Free Trials";
		$data['link_type'] = "leads/orders"; 
		$config = array();
	
		$config['per_page']=20;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/leads/orders'; 
		
		$config['total_rows'] = $totalOrders;
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		
		//$this->db->where('name !=','');
		//$this->db->where('last_name !=','');
		//$this->db->where('offer_type !=','');
		$this->db->where('is_delete',0);
		$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$this->db->order_by("id", "desc");
		$data['orders'] = $this->pagination_model->fetch_data('tblorders',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		//echo '<pre>';print_r($config['total_rows']);
		
		$number = ($page * $config['per_page']) - $config['per_page'];
		$data['number'] = $number + 1;
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		/*if($data['multiLocation'][11]->field_value == 1){
			$this->db->where("main_location", 0);
		}*/
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		
		
		$this->load->view('admin/orderleads',$data);
}


function exportorderleads(){ 
		$this->db->select('*');
		$this->db->from('tblorders');
		//$this->db->where('name !=','');
		//$this->db->where('last_name !=','');
		$this->db->where('is_delete',0);
		//$this->db->where('offer_type !=','');
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$this->db->order_by("id", "desc");
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$records = $query->result();	
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=orderleads-leads.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$file = fopen('php://output', 'w');                              
      	fputcsv($file, array('Name', 'Last Name', 'Phone', 'Email', 'Program', 'School','Trial Name','Trial Type','Upsell','Upsell Name','Coupon Code','Coupon Discount', 'Amount', 'Payment Status','Page Url', 'Date',"Child's Name","Child's Age",'Status','Tags'));
		
		$site_currency_type = $this->query_model->getSiteCurrencyType();
		
		foreach($records as $r){
			 $name = ucfirst($r->name);
			 $last_name = ucfirst($r->last_name);
			 $phone = $r->phone;
			 $email = $r->email;
			
			$program = '';
			 $prgram_detail = $this->query_model->getbySpecific('tblprogram','id',$r->program_id); 
			 if(isset($prgram_detail[0]) && !empty($prgram_detail[0])){
			       $program = $prgram_detail[0]->program;
			 }
			 
			 $school = '';
			 $school_detail = $this->query_model->getbySpecific('tblcontact','id',$r->location_id); 
			 if(isset($school_detail[0]) && !empty($school_detail[0])){
			 	$school =  $school_detail[0]->name;
			 }
			 if(!empty($r->amount)){
				$amount = $site_currency_type.$r->amount;
			 } else{
			 	$amount ='Free';
			 }
			 
			 $tblspecialoffer = ($r->is_unique_trial == 1) ? 'tbl_unique_specialoffer' : 'tblspecialoffer';
			  $offerDetail = $this->query_model->getBySpecific("$tblspecialoffer", 'id', $r->trial_id);
			 $offer_title = !empty($offerDetail) ? $offerDetail[0]->offer_title : '';
			 $upsell =  !empty($r->last_order_id) ? 'Yes' : 'No';
			 $offer_type = !empty($r->offer_type) ? $r->offer_type : ''; 
			 $child_name = !empty($r->child_name) ? $r->child_name : ''; 
			 $child_age = !empty($r->child_age) ? $r->child_age : ''; 
			
			
			
			 $payment_status = $r->trans_status;
			 $kanban_status = !empty($r->kanban_status_id) ?  $this->query_model->getKanbanStatusNameByID($r->kanban_status_id) : '';
			 
			// $lead_type = $this->query_model->getKanbanLeadTypeToOrderType('trial_offer_lead'); 
			 $tags = $this->query_model->getOrderTagsByOrderId($r->id,'trial_offer_lead');
			 $tags = !empty($tags) ? implode(',',$tags) : '';
						
			 $date = date('M d, Y ', strtotime($r->created));
			 $upsale_title = !empty($r->upsells_title ) ? str_replace( 'Upsell :-','',$r->upsells_title)  : '';
			 $coupon_code = $r->coupon_code;
			 $coupon_discount = !empty($r->coupon_discount) ? $site_currency_type.$r->coupon_discount : '';
			 $page_url = ($r->page_url != '/') ? $r->page_url : 'Home Page';
			
			//fputcsv($file, array('Name', 'Phone', 'Email', 'Program', 'School','Trial Name','Trial Type','Upsell','Upsell Name','Coupon Code','Coupon Discount', 'Amount', 'Status','Page Url', 'Date'));
			 
			 $record = array($name,$last_name, $phone, $email, $program, $school,$offer_title,$offer_type,$upsell,$upsale_title,$coupon_code,$coupon_discount, $amount,$payment_status,$page_url, $date,$child_name,$child_age,$kanban_status,$tags);
			fputcsv($file, $record);				
		}
		fclose($file);
		exit();	
		
	}


	// Dojocarts Orders Leads Start

	public function cartorders($page = 1){
		
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
		
		$data['title'] = "Dojocart Orders Leads";
		$data['link_type'] = "leads/cartorders";
		
		$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location',$_GET['location']);
		}
		$totalOrders = $this->query_model->getBySpecific('tbl_dojocart_orders', 'is_delete',0);
		
		$totalOrders = count($totalOrders);
		
		$config = array();
	
		$config['per_page']= 20;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/leads/cartorders'; 
		
		$config['total_rows'] = $totalOrders;
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		$this->db->where('is_delete',0);
		$this->db->order_by("id", "desc");
		$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location',$_GET['location']);
		}
		$data['cartorders'] = $this->pagination_model->fetch_data('tbl_dojocart_orders',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		//echo '<pre>';print_r($config['total_rows']);
		
		$number = ($page * $config['per_page']) - $config['per_page'];
		$data['number'] = $number + 1;
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		
		
		$this->load->view('admin/cartorderleads',$data);
		
	}

		function editcartLead($id){
		
		$this->db->select('*');
		$this->db->from('tbl_dojocart_orders');
		$this->db->where("tbl_dojocart_orders.id", $id);
		
		$query = $this->db->get();
		
		$data['trial'] = $query->row_object();	
		//echo '<pre>'; print_r($data['trial']); echo '</pre>';					
		
		$data['title'] = "Trial Leads";
		$data['link_type'] = "leads/trial";
			
		$this->load->view('admin/cartorderleads_edit', $data);
		
	}


		function updatecartLead(){
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die;
		
		$id	= $this->input->post('id');
		$data['name']	= $this->input->post('name');
		$data['last_name']	= $this->input->post('last_name');
		$data['phone']	= $this->input->post('phone');
		$data['email'] = $this->input->post('email');
		//$data['age'] = $this->input->post('age');
		//$data['message'] = $this->input->post('message');
		
		$this->db->where('id', $id);
		$this->db->update('tbl_dojocart_orders', $data); 
		redirect('admin/leads/cartorders');		
	}

		
	function exportcartorderleads(){
		$this->db->select('*');
		$this->db->where('is_delete',0);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location',$_GET['location']);
		}
		$this->db->from('tbl_dojocart_orders');
		$this->db->order_by("id", "desc");
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$records = $query->result();
		
		$this->db->select(array('id','label_text','type'));
		$this->db->group_by('label_text');
		$this->db->order_by('created','desc');
		$dojocart_custom_field_lists = $this->query_model->getByTable('tbl_dojocart_custom_fields');
		
		
		$excelFields = array('Name', 'Last Name', 'Phone', 'Email','Location','Dojo Cart','Trial', 'Quantity', 'Upsells','Dojocart Items','Coupon Code','Coupon Discount', 'Tax', 'Amount', 'Status', 'Date');
		if(!empty($dojocart_custom_field_lists)){
			$dojocartCustomFieldsArr = array();
			foreach($dojocart_custom_field_lists as $key => $val){
				$dojocartCustomFieldsArr[] = 'Custom Field: '.$val->label_text;
			}
			$excelFields = array_merge($excelFields,$dojocartCustomFieldsArr);
		}
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=cartorderleads-leads.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$file = fopen('php://output', 'w');                              
      	fputcsv($file, $excelFields); 
		
		$site_currency_type = $this->query_model->getSiteCurrencyType();
		foreach($records as $r){
			
			$dojo_cart = $this->query_model->getBySpecific('tbl_dojocarts', 'id', $r->product_id);
										
			$locationDetail = $this->query_model->getBySpecific('tblcontact', 'id', $r->location);
										
										
			 $name = $r->name;
			 $last_name = $r->last_name;
			 $phone = $r->phone;
			 $email = $r->email;
			 $location = !empty($locationDetail) ? $locationDetail[0]->name : '';
			 $dojocart = !empty($dojo_cart) ? $dojo_cart[0]->product_title : '';
			 $quantity = $r->quantity;
			 $upsells = !empty($r->upsells_title) ?  rtrim($r->upsells_title,', ') : '';
			 $dojocart_items = !empty($r->items_list) ?  rtrim($r->items_list,', ') : '';
			 $tax 	  = $r->tax;
			 
			 //$delimiter = ",";
			 $newline = "\n";
			
			 if(!empty($r->amount)){
				$amount = $site_currency_type.$r->amount;
			 } else{
			 	$amount ='Free';
			 }
			 $status = $r->trans_status;
			 $date = date('M d, Y ', strtotime($r->created));
			 $coupon_code = $r->coupon_code;
			 $coupon_discount = !empty($r->coupon_discount) ? $site_currency_type.$r->coupon_discount : '';
			$offer_type = !empty($r->offer_type) ? $r->offer_type : ''; 
			
			
			
			 $record = array($name, $last_name, $phone, $email, $location, $dojocart,$offer_type, $quantity, $upsells,$dojocart_items,$coupon_code,$coupon_discount, $tax, $amount,$status, $date);
			 
			 $excelValues = $record;
			if(!empty($dojocart_custom_field_lists)){
				$selectedCustomFieldsArr = array();
				foreach($dojocart_custom_field_lists as $key => $dojocart_custom_field){
					//echo '<pre>dojocart_custom_field'; print_r($dojocart_custom_field); die;
					if(!empty($r->custom_fields)){
						
						$custom_fields = unserialize($r->custom_fields);
						if(!empty($custom_fields)){
							$customFieldsLabelArr = array();
							foreach($custom_fields as $key => $custom_field){
								$custom_field_detail = $this->query_model->getBySpecific('tbl_dojocart_custom_fields', 'id', $key);
								//echo '<pre>custom_field_detail'; print_r($custom_field); die;
								if(!empty($custom_field_detail)){
									foreach($custom_field_detail as $key => $val){
										if($val->type == "checkbox"){
											$customFieldsLabelArr[$val->label_text] = implode(', ',$custom_field);
										}else{
											$customFieldsLabelArr[$val->label_text] = $custom_field;
										}
										
									}
								}
								
							}
						}
						//echo '<pre>customFieldsLabelArr'; print_R($customFieldsLabelArr); die;
						
						//$selectedCustomFieldsArr[] = isset($custom_fields[$dojocart_custom_field->id]) ? $custom_fields[$dojocart_custom_field->id] : '';
						$selectedCustomFieldsArr[] = isset($customFieldsLabelArr[$dojocart_custom_field->label_text]) ? $customFieldsLabelArr[$dojocart_custom_field->label_text] : '';
						
					}
				}
				
				
				if(!empty($selectedCustomFieldsArr)){
					$excelValues = array_merge($record,$selectedCustomFieldsArr);
				}
				
				$excelValues[] = $newline;
				
			}
			
			 
			
			 
			fputcsv($file, $excelValues);				
		}
		fclose($file);
		exit();	
		
	}

	// Dojocarts Orders Leads End
	public function deleteAllLeads(){
		
		if(isset($_POST['lead_ids']) && !empty($_POST['lead_ids'])){
			if(isset($_POST['table_name']) && !empty($_POST['table_name'])){
				foreach($_POST['lead_ids'] as $lead_id){
					$this->db->query("update ".$_POST['table_name']." set is_delete='1' where id=".$lead_id."");
				}
			}
		}
		$redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url']  : 'admin/dashboard';
		redirect($redirect_url);
		
	}


	

public function orders_email_only_leads($page = 1){
		
		if(!isset($_GET['date'])){
			//$this->checkAndDeleteSimmilerEmailLeads();
		}
		
		
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');

		//$this->db->where('name',NULL);
		//$this->db->where('last_name',NULL);
		$this->db->where('offer_type',NULL);
		//$this->db->or_where('offer_type','');
		$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$totalOrders = $this->query_model->getBySpecific('tblorders', 'is_delete',0);
		//echo '<pre>totalOrders'; print_R($totalOrders); die;
		$totalOrders = count($totalOrders);
		
		$data['title'] = "Leads";
		$data['link_type'] = "leads/orders_email_only_leads"; 
		$config = array();
	
		$config['per_page']= 20;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/leads/orders_email_only_leads'; 
		
		$config['total_rows'] = $totalOrders;
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		
		//$this->db->where('name',NULL);
		//$this->db->where('last_name',NULL);
		$this->db->where('offer_type',NULL);
		//$this->db->or_where('offer_type','');
		$this->db->where('is_delete',0);
		$this->db->order_by("created", "desc");
		$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$data['orders'] = $this->pagination_model->fetch_data('tblorders',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		//echo '<pre>';print_r($config['total_rows']);
		
		$number = ($page * $config['per_page']) - $config['per_page'];
		$data['number'] = $number + 1;
		
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		/*if($data['multiLocation'][11]->field_value == 1){
			$this->db->where("main_location", 0);
		}*/
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		
		$this->load->view('admin/orderemailonlyleads',$data);
}


public function checkAndDeleteSimmilerEmailLeads(){
	
	$this->db->select(array("id","email","created","page_url"));
	$this->db->where('name !=','');
	$this->db->where('last_name !=','');
	$orderLeads = $this->query_model->getBySpecific('tblorders', 'is_delete',0);
	
	if(!empty($orderLeads)){
		$orderLeadsArr = array();
		
		foreach($orderLeads as $order_lead){
			
			if(!empty($order_lead->email)){
				$lead_date = date("Ymd",strtotime($order_lead->created));
				$orderLeadsArr[$lead_date] = $order_lead;
			}
			
			 $updateData = array("is_delete" => 1);
			
			 $this->db->where('name',null);
			 $this->db->where('last_name',null);
			 $this->db->where('created <',$order_lead->created);
			 $this->db->where('email', $order_lead->email);
			 $this->db->update('tblorders', $updateData); 
			
		}
	}
	
	//echo '<pre>order_lead'; print_r($orderLeadsArr); die;
	// delete multiple order leads 
	if(!empty($orderLeadsArr)){
			foreach($orderLeadsArr as $order_lead){
				
				
					
					$updateData = array("is_delete" => 1);
					
					 $this->db->where('name !=','');
					 $this->db->where('last_name !=','');
					 $this->db->where('last_name !=','');
					 $this->db->where('offer_type',NULL);
					 $this->db->where('email', $order_lead->email);
					 $this->db->where('id !=', $order_lead->id);
					 $this->db->like('created',$order_lead->created);
					 $this->db->update('tblorders', $updateData);
				
				
			}
		}
		
	
	// delete multiple email opt in leads
	$this->db->select(array("id","email","created","page_url"));
	$this->db->where('name',NULL);
	$this->db->where('last_name',NULL);
	$this->db->order_by('id',"asc");
	//$this->db->group_by("DATE(created)");
	//$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
	$emailOnlyLeads = $this->query_model->getBySpecific('tblorders', 'is_delete',0);
	
	if(!empty($emailOnlyLeads)){
		$emailLeadsArr = array();
		
		foreach($emailOnlyLeads as $email_lead){
			if(!empty($email_lead->email)){
				$lead_date = date("Ymd",strtotime($email_lead->created));
				$emailLeadsArr[$lead_date] = $email_lead;
			}
		}
		
		if(!empty($emailLeadsArr)){
			foreach($emailLeadsArr as $email_order_lead){
				
				$updateData = array("is_delete" => 1);
				
				 $this->db->where('name',null);
				 $this->db->where('last_name',null);
				 //$this->db->where("DATE_FORMAT(created,'%Y-%m-%d')", $email_order_lead->created);
				 
				 $this->db->where('email', $email_order_lead->email);
				 $this->db->where('id !=', $email_order_lead->id);
				 $this->db->like('created',$email_order_lead->created);
				 $this->db->update('tblorders', $updateData);
			}
		}
	}
	
	
}
	
function export_email_only_leads(){
	
	
		$this->db->select('*');
		$this->db->from('tblorders');
		//$this->db->where('name',NULL);
		//$this->db->where('last_name',NULL);
		$this->db->where('offer_type',NULL);
		//$this->db->or_where('offer_type','');
		$this->db->where('is_delete',0);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('location_id',$_GET['location']);
		}
		$this->db->order_by("id", "desc");
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$records = $query->result();	
		//echo '<pre>records'; print_r($records); die;
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=order-email-leads-leads.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$file = fopen('php://output', 'w');                              
      	fputcsv($file, array('Name','Phone','Email', 'Program', 'School','Trial','Status','Page Url', 'Date'));
		
		foreach($records as $r){
			 $name = $r->name.' '.$r->last_name;
			 $phone = $r->phone;
			 $email = $r->email;
			
			$program = '';
			 $prgram_detail = $this->query_model->getbySpecific('tblprogram','id',$r->program_id); 
			 if(isset($prgram_detail[0]) && !empty($prgram_detail[0])){
			       $program = $prgram_detail[0]->program;
			 }
			 
			 $school = '';
			 $school_detail = $this->query_model->getbySpecific('tblcontact','id',$r->location_id); 
			 if(isset($school_detail[0]) && !empty($school_detail[0])){
			 	$school =  $school_detail[0]->name;
			 }
			 if(!empty($r->amount)){
				$amount = '$'.$r->amount;
			 } else{
			 	$amount ='Free';
			 }
			 
			  $tblspecialoffer = ($r->is_unique_trial == 1) ? 'tbl_unique_specialoffer' : 'tblspecialoffer';
			  $offerDetail = $this->query_model->getBySpecific("$tblspecialoffer", 'id', $r->trial_id);
			 $offer_title = !empty($offerDetail) ? $offerDetail[0]->offer_title : '';
			 $upsell =  !empty($r->last_order_id) ? 'Yes' : 'No';
			 $offer_type = !empty($r->offer_type) ? $r->offer_type : ''; 
			
			
			
			 $status = $r->trans_status;
			 $date = date('M d, Y', strtotime($r->created));
			 $page_url = ($r->page_url != '/') ? $r->page_url : 'Home Page';
			 
			 $record = array($name,$phone,$email, $program, $school,$offer_title,$status,$page_url, $date);
			fputcsv($file, $record);				
		}
		fclose($file);
		exit();	
		
	}
	
	
	
	
	function webhook_leads($page = 1){
		
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
		
		$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
		$totalOrders = $this->query_model->getBySpecific('tbl_webhook_leads', 'is_delete',0);
		
		$totalOrders = count($totalOrders);
		
		$data['title'] = "Webhook Leads";
		$data['link_type'] = "leads/webhook_leads"; 
		$config = array();
	
		$config['per_page']= 20;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/leads/webhook_leads'; 
		
		$config['total_rows'] = $totalOrders;
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		$this->db->where('is_delete',0);
		$this->db->order_by("created", "desc");
		$this->db->where("DATE_FORMAT(created,'%Y-%m')", $date);
		$data['contacts'] = $this->pagination_model->fetch_data('tbl_webhook_leads',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		//echo '<pre>';print_r($config['total_rows']);
		
		$number = ($page * $config['per_page']) - $config['per_page'];
		$data['number'] = $number + 1;
		
		$this->load->view('admin/webhook_leads',$data);
		
	}
	
	
	
	function exportWebhookLeads(){
		
		$this->db->select('*');
		$this->db->from('tbl_webhook_leads');
		$this->db->order_by("created", "desc");
		$this->db->where('is_delete',0);
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query();
		
		$records = $query->result();	
		
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=contactleads-leads.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$file = fopen('php://output', 'w');                              
      	fputcsv($file, array('Name','Last Name', 'Phone Number', 'Email', 'Website Url', 'Additional Comments','Ip Address','Page Name','Page Id','Page Url','Variant','Webhook Api','School Name' ,'Program','Last Updated','Inquiry Date','Date added'));
		
		foreach($records as $r){
			
			$webhookApi = $this->query_model->getBySpecific('tbl_webhook_apis_incoming', 'id',$r->webhook_incoming_api_id);
			$webhook_api_name = !empty($webhookApi) ? $webhookApi[0]->api_name : '';
			
			$name = ucfirst($r->name);
			$last_name = ucfirst($r->last_name);
			$record = array($name,$last_name, $r->phone_number, $r->email, $r->current_website_url, 
			$r->additional_comments,$r->ip_address,$r->page_name,$r->page_id,$r->page_url,$r->variant,$webhook_api_name,$r->school_name,$r->program,$r->last_updated,$r->inquiry_date, $r->created);
			fputcsv($file, $record);				
		}
		fclose($file);
		exit();	
		
	}
	
	
	function delete_webhook_leads(){
		
		$result =  0;
		if(isset($_POST['action']) && $_POST['action'] == 'delete_record'){
			
			$id = isset($_POST['number']) ? $_POST['number'] : 0;
			
			if($this->db->query("update tbl_webhook_leads set is_delete='1' where id=".$id.""))
			{	
				$result =  1;
			}
		}
		echo $result;
	}
	
	/***************************** Import CSV files and save leads version3 to version 5 ****/
	public function importOrderLeads(){
		
		if(isset($_FILES['importCsv']['name']) && !empty($_FILES['importCsv']['name'])){
				$_FILES['importCsv']['name'] = time().$_FILES['importCsv']['name'];
				
				$ext = pathinfo($_FILES['importCsv']['name'], PATHINFO_EXTENSION);
				
				$allowedExt = array('csv');
				if(in_array($ext, $allowedExt)){
					
					if(is_uploaded_file($_FILES['importCsv']['tmp_name'])) {
						$sourcePath = $_FILES['importCsv']['tmp_name'];
						
						$targetPath = "upload/importCsv/".$_FILES['importCsv']['name'];
						
						if(move_uploaded_file($sourcePath,$targetPath)) {
							$csv_file = "upload/importCsv/".$_FILES['importCsv']['name'];
							$n = 1;
							if (($handle = fopen($csv_file, "r")) !== FALSE) {
								while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
									
									if(isset($row[2]) && !empty($row[2]) && $row[2] != "Email"){
										$importDataArr = array();
										$importDataArr['name'] = (isset($row[0]) && !empty($row[0])) ? $row[0] : '';
										$importDataArr['phone'] = (isset($row[1]) && !empty($row[1])) ? $row[1] : '';
										$importDataArr['email'] = (isset($row[2]) && !empty($row[2])) ? $row[2] : '';
										
										$program = (isset($row[3]) && !empty($row[3])) ? trim($row[3]) : '';
										
										$importDataArr['program_id'] = 0;
										if(!empty($program)){
											$prgram_detail = $this->query_model->getbySpecific('tblprogram','program',$program); 
											 if(isset($prgram_detail[0]) && !empty($prgram_detail[0])){
												  $importDataArr['program_id'] = $prgram_detail[0]->id;
											 }
										}
										
										$school = (isset($row[4]) && !empty($row[4])) ? trim($row[4]) : '';
										$importDataArr['location_id'] = 0;
										if(!empty($school)){
											$location_detail = $this->query_model->getbySpecific('tblcontact','name',$school); 
											 if(isset($location_detail[0]) && !empty($location_detail[0])){
												   $importDataArr['location_id'] = $location_detail[0]->id;
											 }
										}
										
										 
										$importDataArr['amount'] = (isset($row[6]) && !empty($row[6])) ? $row[6] : '';
										
										$importDataArr['offer_type'] = (isset($row[5]) && !empty($row[5])) ? $row[5] : NULL;
										$importDataArr['trans_status'] = (isset($row[7]) && !empty($row[7])) ? $row[7] : '';
										$importDataArr['created'] = (isset($row[8]) && !empty($row[8])) ? date("Y-m-d H:i:s", strtotime($row[8])) : '';
										
										$importDataArr['is_imported'] = 1;
										
										
										$this->db->where("created",$importDataArr['created']);
										$this->db->where('is_imported',0);
										$existRecord = $this->query_model->getbySpecific('tblorders','email',$importDataArr['email']);
										
										//echo '<pre>existRecord'; print_r($row); 
										//echo '<pre>existRecord'; print_r($importDataArr); die;
										if(empty($existRecord)){
											$this->query_model->insertData('tblorders', $importDataArr);
										}
										
										
									}
								}
							}
						}
					}
				}
				
			}
		redirect($base_url.'admin/leads/orders');
	}
	
	
	
	public function importContactLeads(){
		
		if(isset($_FILES['importCsv']['name']) && !empty($_FILES['importCsv']['name'])){
				$_FILES['importCsv']['name'] = time().$_FILES['importCsv']['name'];
				
				$ext = pathinfo($_FILES['importCsv']['name'], PATHINFO_EXTENSION);
				
				$allowedExt = array('csv');
				if(in_array($ext, $allowedExt)){
					
					if(is_uploaded_file($_FILES['importCsv']['tmp_name'])) {
						$sourcePath = $_FILES['importCsv']['tmp_name'];
						
						$targetPath = "upload/importCsv/".$_FILES['importCsv']['name'];
						
						if(move_uploaded_file($sourcePath,$targetPath)) {
							$csv_file = "upload/importCsv/".$_FILES['importCsv']['name'];
							$n = 1;
							if (($handle = fopen($csv_file, "r")) !== FALSE) {
								while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
									
									if(isset($row[2])  && !empty($row[2]) && $row[2] != "Email"){
										//echo "<pre>row"; print_r($row); die;
										$importDataArr = array();
										$importDataArr['name'] = (isset($row[0]) && !empty($row[0])) ? $row[0] : '';
										$importDataArr['phone'] = (isset($row[1]) && !empty($row[1])) ? $row[1] : '';
										$importDataArr['email'] = (isset($row[2]) && !empty($row[2])) ? $row[2] : '';
										
										
										$school = (isset($row[3]) && !empty($row[3])) ? trim($row[3]) : '';
										$importDataArr['school'] = 0;
										if(!empty($school)){
											$location_detail = $this->query_model->getbySpecific('tblcontact','name',$school); 
											 if(isset($location_detail[0]) && !empty($location_detail[0])){
												   $importDataArr['school'] = $location_detail[0]->id;
											 }
										}
										
										$importDataArr['message'] = (isset($row[4]) && !empty($row[4])) ? $row[4] : ''; 
										
										$importDataArr['date_added'] = (isset($row[5]) && !empty($row[5])) ? date("Y-m-d H:i:s", strtotime($row[5])) : '';
										
										$importDataArr['is_imported'] = 1;
										
										//echo "<pre>importDataArr"; print_r($importDataArr); die;
										$this->db->where("date_added",$importDataArr['date_added']);
										$this->db->where('is_imported',0);
										$existRecord = $this->query_model->getbySpecific('tblcontactusleads','email',$importDataArr['email']);
										if(empty($existRecord)){
											$this->query_model->insertData('tblcontactusleads', $importDataArr);
										}
										
										
									}
								}
							}
						}
					}
				}
				
			}
		redirect($base_url.'admin/leads/contactus');
	}
	
	
	
	
	
	public function importBdayPartiesLeads(){
		
		if(isset($_FILES['importCsv']['name']) && !empty($_FILES['importCsv']['name'])){
				$_FILES['importCsv']['name'] = time().$_FILES['importCsv']['name'];
				
				$ext = pathinfo($_FILES['importCsv']['name'], PATHINFO_EXTENSION);
				
				$allowedExt = array('csv');
				if(in_array($ext, $allowedExt)){
					
					if(is_uploaded_file($_FILES['importCsv']['tmp_name'])) {
						$sourcePath = $_FILES['importCsv']['tmp_name'];
						
						$targetPath = "upload/importCsv/".$_FILES['importCsv']['name'];
						
						if(move_uploaded_file($sourcePath,$targetPath)) {
							$csv_file = "upload/importCsv/".$_FILES['importCsv']['name'];
							$n = 1;
							if (($handle = fopen($csv_file, "r")) !== FALSE) {
								while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
									
									if(isset($row[2])  && !empty($row[2]) && $row[2] != "Email"){
										
										$importDataArr = array();
										$importDataArr['name'] = (isset($row[0]) && !empty($row[0])) ? $row[0] : '';
										$importDataArr['phone'] = (isset($row[1]) && !empty($row[1])) ? $row[1] : '';
										$importDataArr['email'] = (isset($row[2]) && !empty($row[2])) ? $row[2] : '';
										$importDataArr['party_date'] = (isset($row[3]) && !empty($row[3])) ? $row[3] : '';
										
										
										
										
										$importDataArr['guests'] = (isset($row[4]) && !empty($row[4])) ? $row[4] : ''; 
										
										$importDataArr['date_added'] = (isset($row[5]) && !empty($row[5])) ? date("Y-m-d H:i:s", strtotime($row[5])) : '';
										
										$importDataArr['is_imported'] = 1;
										
										$this->db->where("date_added",$importDataArr['date_added']);
										$this->db->where('is_imported',0);
										$existRecord = $this->query_model->getbySpecific('tblbirthdayparty','email',$importDataArr['email']);
										//echo "<pre>importDataArr"; print_r($importDataArr); die;
										if(empty($existRecord)){
											$this->query_model->insertData('tblbirthdayparty', $importDataArr);
										}
										
										
									}
								}
							}
						}
					}
				}
				
			}
		redirect($base_url.'admin/leads/birthdayparties');
	}
	
	
	
	
	
	public function importCartOrderLeads(){
		
		if(isset($_FILES['importCsv']['name']) && !empty($_FILES['importCsv']['name'])){
				$_FILES['importCsv']['name'] = time().$_FILES['importCsv']['name'];
				
				$ext = pathinfo($_FILES['importCsv']['name'], PATHINFO_EXTENSION);
				
				$allowedExt = array('csv');
				if(in_array($ext, $allowedExt)){
					
					if(is_uploaded_file($_FILES['importCsv']['tmp_name'])) {
						$sourcePath = $_FILES['importCsv']['tmp_name'];
						
						$targetPath = "upload/importCsv/".$_FILES['importCsv']['name'];
						
						if(move_uploaded_file($sourcePath,$targetPath)) {
							$csv_file = "upload/importCsv/".$_FILES['importCsv']['name'];
							$n = 1;
							if (($handle = fopen($csv_file, "r")) !== FALSE) {
								while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
									
									if(isset($row[3]) && !empty($row[2])  && $row[3] != "Email"){
										$importDataArr = array();
										$importDataArr['name'] = (isset($row[0]) && !empty($row[0])) ? $row[0] : '';
										$importDataArr['last_name'] = (isset($row[1]) && !empty($row[1])) ? $row[1] : '';
										$importDataArr['phone'] = (isset($row[2]) && !empty($row[2])) ? $row[2] : '';
										$importDataArr['email'] = (isset($row[3]) && !empty($row[3])) ? $row[3] : '';
										
										
										$school = (isset($row[4]) && !empty($row[4])) ? trim($row[4]) : '';
										$importDataArr['location'] = 0;
										if(!empty($school)){
											$location_detail = $this->query_model->getbySpecific('tblcontact','name',$school); 
											 if(isset($location_detail[0]) && !empty($location_detail[0])){
												   $importDataArr['location'] = $location_detail[0]->id;
											 }
										}
										
										 
										$importDataArr['quantity'] = (isset($row[5]) && !empty($row[5])) ? $row[5] : 0;
										$importDataArr['upsells_title'] = (isset($row[6]) && !empty($row[6])) ? $row[6] : '';
										$importDataArr['tax'] = (isset($row[7]) && !empty($row[7])) ? $row[7] : '';
										$importDataArr['amount'] = (isset($row[8]) && !empty($row[8])) ? str_replace("$","",$row[8]) : '';
										$importDataArr['trans_status'] = (isset($row[9]) && !empty($row[9])) ? $row[9] : "failed";
										$importDataArr['created'] = (isset($row[10]) && !empty($row[10])) ? date("Y-m-d H:i:s", strtotime($row[10])) : '';
										
										$importDataArr['is_imported'] = 1;
									//	echo "<pre>importDataArr"; print_r($importDataArr); die;
										$this->db->where("created",$importDataArr['created']);
										$this->db->where('is_imported',0);
										$existRecord = $this->query_model->getbySpecific('tbl_dojocart_orders','email',$importDataArr['email']);
										if(empty($existRecord)){
											$this->query_model->insertData('tbl_dojocart_orders', $importDataArr);
										}
										
										
									}
								}
							}
						}
					}
				}
				
			}
		redirect($base_url.'admin/leads/cartorders');
	}
	
	
	
	
	
	function s_leads($page = 1){
		
		$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
		
		$this->db->where("DATE_FORMAT(created_at,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('school',$_GET['location']);
		}
		$totalOrders = $this->query_model->getByTable('tbl_sp_leads');
		
		$totalOrders = count($totalOrders);
		
		$data['title'] = "Leads";
		$data['link_type'] = "leads/s_leads"; 
		$config = array();
	
		$config['per_page']= 20;
		$config['page']= $page;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;

		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['base_url']= base_url().'admin/leads/s_leads'; 
		
		$config['total_rows'] = $totalOrders;
		$offset = ($page  == 1) ? 0 : ($page * $config['per_page']) - $config['per_page'];
		$this->db->order_by("id", "desc");
		$this->db->where("DATE_FORMAT(created_at,'%Y-%m')", $date);
		if(isset($_GET['location']) && !empty($_GET['location'])){
			$this->db->where('school',$_GET['location']);
		}
		$data['contacts'] = $this->pagination_model->fetch_data('tbl_sp_leads',$config["per_page"], $offset, $config['total_rows']);
		$this->pagination->initialize($config);
		//echo '<pre>'; print_r($data['staff']); die;
		$data['paginglinks'] = $this->pagination->create_links();
		$data['config'] = $config;
		//echo '<pre>';print_r($config['total_rows']);
		
		$number = ($page * $config['per_page']) - $config['per_page'];
		$data['number'] = $number + 1;
		
		$data['multiLocation'] = $this->query_model->getbyTable("tblconfigcalendar");
				
		$this->db->where("published", 1);
		$this->db->where("location_type", 'regular_link');
		/*if($data['multiLocation'][11]->field_value == 1){
			$this->db->where("main_location", 0);
		}*/
		$this->db->select(array('id','name'));
		$data['allLocations'] = $this->query_model->getbyTable("tblcontact");
		
		
		
		$this->load->view('admin/spam_leads',$data);
		
	}
	
	
	
	function delete_s_leads(){
		
		$result =  0;
		if(isset($_POST['action']) && $_POST['action'] == 'delete_record'){
			
			$id = isset($_POST['number']) ? $_POST['number'] : 0;
			
			$this->db->where('id',$id);
			$this->db->delete("tbl_sp_leads");
			
			$result =  1;
		}
		echo $result;
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
						'last_2_months'=>'Last 2 months',
						'last_3_months'=>'Last 3 months',
						'last_6_months'=>'Last 6 months',
						'last_year'=>'Last year',
						'custom_range' =>'Custom Range'
						);
						
	$slidingDateArr = array(
						//'sliding'=>'---Sliding---',
						'today' => 'Today',
						'yesterday' => 'Last day',
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
			//$monday = strtotime("last monday");
			//$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$start_date = date("Y-m-01");
			$end_date = date('Y-m-d');
			
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
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */