<?php 
class Twilio_smsflow extends CI_Controller{
	

	function index(){
		
		$is_logged_in = $this->session->userdata('is_logged_in');
	
		if(!empty($is_logged_in) && $is_logged_in == true)
		{
			$data['title'] = "SMS Flows Setup";
			$data['link_type'] = "twilio_smsflow";
			
			$data['sms_flows'] = $this->query_model->getbyTable('tbl_twilio_sms_flows');
			
			$data['times'] = $this->get_hours_range();
			
			//echo '<pre>OST'; print_R($_POST); die;
			if(isset($_POST['update']) && !empty($_POST['update'])){
				
				if(isset($_POST['data']) && !empty($_POST['data'])){
					foreach($_POST['data'] as $key => $val){
						
						$record = $this->query_model->getbySpecific('tbl_twilio_sms_flows','id',$key);
						
						$updateDataArr = array();
						$updateDataArr['days'] = (isset($val['days']) && !empty($val['days'])) ? $val['days'] : 0;
						$updateDataArr['msg_type'] = (isset($val['msg_type']) && !empty($val['msg_type'])) ? $val['msg_type'] : '';
						$updateDataArr['start_time'] = (isset($val['start_time']) && !empty($val['start_time'])) ? $val['start_time'] : '';
						$updateDataArr['end_time'] = (isset($val['end_time']) && !empty($val['end_time'])) ? $val['end_time'] : '';
						$updateDataArr['msg_template'] = (isset($val['msg_template']) && !empty($val['msg_template'])) ? $val['msg_template'] : '';
						
						//echo '<pre>updateDataArr'; print_r($updateDataArr); die;
						if(!empty($record)){
							$this->query_model->update('tbl_twilio_sms_flows', $key, $updateDataArr);
						}else{
							$updateDataArr['msg_template'] = date('Y-m-d H:i:s');
							
							$this->query_model->insertData('tbl_twilio_sms_flows',$updateDataArr);
							
						}
						
					}
				}
				
				redirect("admin/twilio_smsflow");
			
			}
			
			$this->load->view('admin/twilio_sms_flows',$data);
		
		}else{
			redirect("admin/login");
		}

	}
	
	
	 
function get_hours_range( $start = 0, $end = 86400, $step = 3600, $format = 'g:i a' ) {
        $times = array();
        foreach ( range( $start, $end, $step ) as $timestamp ) {
                $hour_mins = gmdate( 'H:i', $timestamp );
                if ( ! empty( $format ) )
                        $times[$hour_mins] = gmdate( $format, $timestamp );
                else $times[$hour_mins] = $hour_mins;
        }
        return $times;
}


}
