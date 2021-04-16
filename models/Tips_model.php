<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tips_model extends CI_Model {
	
	var $table = 'tblgettipsleads';
	
	function addTips(){
		
		$name = $this->input->post('name');
		
		$phone1 = $this->input->post('phone1');
		$phone2 = $this->input->post('phone2');
		$phone3 = $this->input->post('phone3');		
		
		$email = $this->input->post('form_email_2');
		
		$phone = $phone1."-".$phone2."-".$phone3;
		
				
		$data = array("name" => $name, "phone" => $phone, "email" => $email);					
		
		$record = $this->query_model->getbySpecific($this->table, 'email', $email);
		if($record){
			
			//$this->query_model->update($this->table, '', $data);	
			$this->db->where('email', $email);
			$this->db->update($this->table, $data);
			
		}else{
			$this->query_model->insertData($this->table, $data);
		}
		
		$this->load->library("email");
		
		$this->db->where("id", 1);
		$gettips = $this->db->get("tblgettips")->row_array();					
		
		$qry = $this->db->query("select * from `tblsite` limit 1") or die(mysqli_error($this->db->conn_id));
		$site_settings = $qry->row_array();
		
		$site_email = $site_settings['email'];
		$site_title = $site_settings['title'];	
		
		$variable_values = array('school_name' => $site_title);
		
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = "html";	
		
		$subject = $gettips['email_subject'];
		$msg_body = $gettips['email_body'];
		
		$msg_body = parse_globals($msg_body, $variable_values);
		
		$msg_body .= "<br/><br/>";
		$msg_body .= $site_title."<br/>";
		$msg_body .= $site_settings['phone']."<br/>";
		$msg_body .= $site_settings['address']."<br/>";
		$msg_body .= $site_settings['city'].", ".$site_settings['state']." ".$site_settings['zip'];
		
		$this->email->initialize($config);
		$this->email->from('noreply@websitedojo.com');
		$this->email->reply_to($site_email, $site_title);
		$this->email->to($email);	
		$this->email->subject($subject);
		$this->email->message($msg_body);
		
		//echo '<br>subject: '.$subject;
		//echo '<br>msg_body: '.nl2br($msg_body);
		//exit;
		
		$this->email->send();
		
		$msg_body ="<html><head>";

					$msg_body .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

					$msg_body.="<style>

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif;}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px;margin-top: 5px;}

					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					t { color:#006699; font-weight:900; }		

					</style>";

					$msg_body .= "</head><body>";
		
		// email to admin

		$subject = 'Lead Notification | A Prospect Submitted info from your GET TIPS online form';

		$msg_body  = 'Dear'  .$site_title.  'owner,'."<br/><br/>";		

		$msg_body .= "A prospect submitted their email in the 'GET TIPS' section of your website.  They received an automatic email reply with the TIPS they requested.  You may may want to follow up with them to invite them for a free class, or add their email to your Email Newsletter Database.  Their contact details are below:";

		$msg_body .= "<br/><br/>";

		$msg_body .= "<strong>Name:</strong>".$name."<br/>";

		$msg_body .= "<strong>Phone:</strong>".$phone."<br/>";

		$msg_body .= "<strong>Email:</strong>".$email."<br/>";		
$msg_body .= '</body></html>';
		$this->email->initialize($config);

		$this->email->from('noreply@websitedojo.com');

		$this->email->reply_to($site_email, $site_title);

		$this->email->to($site_email);
                
                $this->email->cc('leads@websitedojo.com'); 	

		$this->email->subject($subject);

		$this->email->message($msg_body);

		$this->email->send();	
		
		redirect(@base_url().'gettips/sendsuccessfull');		
	}	

		
	public function editTrial($data,$last_id){
		if(is_array($data)){
	        $sql = mysqli_query($this->db->conn_id,"UPDATE ".$this->table." SET `txnid`='".$data['txn_id']."',`payment_status`='".$data['payment_status']."' WHERE id='$last_id'");
		    return true;
	    }
	    return false;
	}
	
	function getTransactionDetails($tnxid) {		
		$sql = mysqli_query($this->db->conn_id,"SELECT * FROM ".$this->table." WHERE txnid = '$tnxid'");
	    if (mysqli_num_rows($sql) != 0) {
			while ($row = mysqli_fetch_array($sql)) {
				return $row;
			}
	    }
	    
	    return false;
	}
	
	function check_txnid($tnxid){
		$valid_txnid = true;
	    $sql = mysqli_query($this->db->conn_id,"SELECT * FROM ".$this->table." WHERE txnid = '$tnxid'");
		if($row = mysqli_fetch_array($sql)) {
	        $valid_txnid = false;
		}
	    return $valid_txnid;
	}
	
	function check_price($price, $id){
	    $valid_price = false;

	    //you could use the below to check whether the correct price has been paid for the product
		//if so uncomment the below code
	
		$sql = mysqli_query($this->db->conn_id,"SELECT amount FROM ".$this->table." WHERE id = '$id'");
	    if (mysqli_num_rows($sql) != 0) {
			while ($row = mysqli_fetch_array($sql)) {
				$num = (float)$row['amount'];
				if($num == $price){
					$valid_price = true;
				}
			}
	    }
		return $valid_price;
	}
	
	public function fnMakeLog($title,$message_arr,$file) {
		
		$handle = @fopen($_SERVER['DOCUMENT_ROOT']."/demo/".$file.".log", "a+");

		if($handle){			
			$message = "[".date("Y-m-d H:i:s")."] ".$title."\n";
			fwrite($handle,$message);
			foreach($message_arr as $field=>$value){
				$message = $field." => ".$value."\n";
				fwrite($handle,$message);
			}
			$message = "\n".str_repeat("=",90)."\n";
			fwrite($handle,$message);
			fclose($handle);	
		}
		
		return true; 
	}
}