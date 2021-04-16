<?php

class Email_model extends CI_Model {
	var $table = 'tblinbox';
	function email($msg,$sender,$sender_email,$type){
		$this->load->library("email");
		$query = $this->query_model->getbyTable('tblsite');
		foreach($query as $row):
			$site_email = $row->email;
		endforeach;
		
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype']="html";
		$this->email->initialize($config);
		
		$this->email->from($sender_email);
		$this->email->to($site_email);
		$this->email->subject($type);
		$mes="<html>";
		$mes.="<style>
					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}
					body{ text-align: left; }
					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px;}
					h6{ font-size: 14px; color: #006699; line-height:14px;}
					strong{ color:#006699; font-weight:900; }
					.content{ margin-top: 20px;}
					.content .row{ margin: 5px 0;}
					.row .message{ width: 700px; padding-top: 10px; }
					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}
					label{ font-weight:400; }
			
					</style>";
		$mes.="<body>";
		$mes.="<div class='header'>".$type."</div>";
		$mes.="<div class='message-wrapper'>";
		$mes.=$msg;
		$mes.="<p class='sender'>Regards, <br /><br />".ucwords(strtolower($sender))."<br />";
		$mes.="<a id='email'>email : ".$sender_email."</a>";
		$mes.="</p>";
		$mes.="</div></body></html>";
		$this->email->message($mes);
		if($this->email->send()):
			$data = array(
				'name' => $sender,
				'email' => $sender_email,
				'type' => $type,
				'message' => $msg,
				'status' => 0 
			);
			if($this->query_model->insertData($this->table,$data)): return TRUE;
			else: return FALSE;
			endif;
		else: return FALSE;
		endif;
	}
}