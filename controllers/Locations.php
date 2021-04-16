<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Locations extends CI_Controller {


	public function index()

	{
		$data = array();
		
		$sql = "SELECT c . * , f.slug, f.published
				FROM `tblcontact` c LEFT JOIN tblfacilities f ON f.location_id = c.id
				WHERE c.published = '1' ORDER BY c.pos ASC ";
		
		// $contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));
		$contact_data = $this->db->query($sql) or die(mysqli_error($this->db->conn_id));

		$data['contactlocations'] = $contact_data->result();
		
		//echo '<pre>'; print_r($data['locations']); echo '</pre>';
		//exit;
		
		$this->load->view('locations', $data);
	}
	
	public function withoutmap()

	{
		$data = array();
		
		$sql = "SELECT c . * , f.slug
				FROM `tblcontact` c LEFT JOIN tblfacilities f ON f.location_id = c.id
				WHERE c.published = '1' ORDER BY c.pos ASC ";
		
		// $contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));
		$contact_data = $this->db->query($sql) or die(mysqli_error($this->db->conn_id));

		$data['contactlocations'] = $contact_data->result();
		
		//echo '<pre>'; print_r($data['locations']); echo '</pre>';
		//exit;
		
		// $this->load->view('locations', $data);
		
		$this->load->view('locations_withoutmap', $data);

	}

	function getlocationdata($location_id){
		
		$contact_data=$this->db->query("select * from `tblcontact`  where  id='".$location_id."' order by pos ASC") or die(mysqli_error($this->db->conn_id));
		$location = $contact_data->row_array();	
		echo json_encode($location);		
	}
	
	function getlocationdatabyname($location_name){	
		
		$contact_data=$this->db->query("select * from `tblcontact`  where  name='".urldecode($location_name)."' order by pos ASC") or die(mysqli_error($this->db->conn_id));
		$location = $contact_data->row_array();	
		echo json_encode($location);		
	}


	public function send(){		

		$this->load->helper('url');
		$this->load->library('session');
		
		if($_POST['website'] != ''){

			die("You spammer!");

		}

		$data = array();

		$insert_data = array();

		$insert_data['school'] = '';

		

		if(isset($_POST['email']) && empty($_POST['email'])){

			$data['location'] = isset($_POST['hid_location']) ? $_POST['hid_location'] : '';	

			if(!empty($_POST['form_email_2'])){

				$this->load->library("email");

				$sel_school='';

				if(isset($_POST['school'])){

					$insert_data['school'] = $sel_school=$_POST['school'];		

					$school_data=$this->db->query("select email from `tblcontact` where name='".mysqli_real_escape_string($this->db->conn_id,$_POST['school'])."';") or die(mysqli_error($this->db->conn_id));

					$school_data=$school_data->result();

					if(is_array($school_data) && count($school_data)>0){

						$school_email=($school_data[0]->email);	

					}else{

						$school_email=''; 

					}

				}			

				$query = $this->query_model->getbyTable('tblsite');			

				foreach($query as $row):

					$site_email = trim($row->email);

					$school_name = $row->title;

				endforeach;

				 

				if(isset($school_email)){

					$site_email = $school_email;

				}

			

				$insert_data['name'] = $sender = $_POST['name'];

				$insert_data['email'] = $sender_email = trim($_POST['form_email_2']);

				$insert_data['message'] = $cont = $_POST['message'];			
				
				$insert_data['program'] = $program = $_POST['program'];			
				
				$insert_data['age'] = $age = $_POST['age'];			

				$type = "Website Contact form ".$_POST['name'];

				$insert_data['phone'] = $phone = $_POST['phone1']."-".$_POST['phone2']."-".$_POST['phone3'];				
				
				// save data

				$this->query_model->insertData('tblcontactusleads', $insert_data);				
				

				$config['charset'] = 'iso-8859-1';

				$config['wordwrap'] = TRUE;

				$config['mailtype']="html";

				$this->email->initialize($config);

				$this->email->from($sender_email);

				$this->email->to($site_email);

				$this->email->subject($type);			

					$mes ="<html><head>";

					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

					$mes.="<style>

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 20px; text-transform:uppercase; font-family: 'Raleway', sans-serif; line-height:20px; margin: 5px 0;}

					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					.content{ margin-top: 5px;}

					.content .row{ margin: 5px 0;}

					.row .message{ width: 700px; padding-top: 10px; }

					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}

					label{ font-weight:400; }

					

					</style>";

					$mes .= "</head><body align='left'>";

					$mes .= "<h1>".$school_name."</h1>";

					$mes .= "<strong>Email Contact Form</strong>";

									

					$mes .= '<div class="content">';

					$mes .=	'<div class="row"><strong>Name: &nbsp;</strong><label>'.$sender.'</label></div>';

					$mes .=	'<div class="row"><strong>Email: &nbsp;</strong><label>'.$sender_email.'</label></div>';
					
					$mes .=	'<div class="row"><strong>Age: &nbsp;</strong><label>'.$age.'</label></div>';

					$mes .=	'<div class="row"><strong>Phone: &nbsp;</strong><label>'.$phone.'</label></div>';

					$mes .=	'<div class="row"><strong>School of Interest: &nbsp;</strong><label>'.$sel_school.'</label></div>';
					
					$mes .=	'<div class="row"><strong>Program of Interest: &nbsp;</strong><label>'.$program.'</label></div>';

					

					$mes .= '<div class="row">';

					$mes .= '<div class="message"><p>'.$cont.'</p></div>';

					$mes .= '</div></div>';

					$mes .= '</body></html>';		

											

					

					$this->email->message($mes);

			

					if($this->email->send()):

					

						// send email to websitedojo.com

						$this->email->initialize($config);

						$this->email->from($sender_email);

						$this->email->to('leads@websitedojo.com');

						$this->email->subject($type.' - '.$school_name);

						$this->email->message($mes);					

						$this->email->send();

						

						// thank you Email to user

						$qry = $this->db->query("select * from `tblsite` limit 1") or die(mysqli_error($this->db->conn_id));

						$site_settings = $qry->row_array();

						

						$site_email = $site_settings['email'];

						$site_title = $site_settings['title'];				

						

						$config['charset'] = 'iso-8859-1';

						$config['wordwrap'] = TRUE;

						$config['mailtype'] = "text";	

						

						$subject = $site_title.' | Thank you for your inquiry';

						$msg_body = "Thank you contacting ".$site_title.".  A representative will contact you to answer any questions you may have.  You may also contact us directly using the information at the bottom of this email.";			

						

						$msg_body .= "\r\n\r\n";

						$msg_body .= $site_title."\r\n";

						$msg_body .= $site_settings['phone']."\r\n";

						$msg_body .= $site_settings['address']."\r\n";

						$msg_body .= $site_settings['city'].", ".$site_settings['state']." ".$site_settings['zip'];

						

						$this->email->initialize($config);

						$this->email->from('noreply@websitedojo.com');

						$this->email->reply_to($site_email, $site_title);

						$this->email->to($sender_email);	

						$this->email->subject($subject);

						$this->email->message($msg_body);

						

						//echo '<br>subject: '.$subject;

						//echo '<br>msg_body: '.nl2br($msg_body);

						//exit;

						

						$this->email->send();

				

						$data['msg'] = 1;

						//redirect("contactus");

						$data['content'] = $this->query_model->getbyId("tblpages", 9);

						$data['school_name']=$school_name;

						$data['sel_school']=$sel_school;

						//$this->db->order_by("pos", "ASC");				

						//$data['contact'] = $this->query_model->getbyTable("tblcontact");

		

						$contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));

						$data['contact']=$contact_data->result();

						$query = $this->query_model->getbyTable('tblsite');		

						if(is_array($query) && count($query)>0):		

							$data['site_title']=$query[0]->title;

						else:

							$data['site_title']='';

						endif;

						

						// $this->load->view("contact-us-sent",$data);
						
						$this->session->set_userdata('msg', 'Thank You');
						
						redirect(base_url().'our-locations');

					else:

						$data['msg'] = 0;

						//redirect("contactus");

						$data['content'] = $this->query_model->getbyId("tblpages", 9);

						//$this->db->order_by("pos", "ASC");

						

						$contact_data=$this->db->query("select * from `tblcontact`  where  published='1' order by pos ASC") or die(mysqli_error($this->db->conn_id));

						$data['contact']=$contact_data->result();

						$query = $this->query_model->getbyTable('tblsite');		

						if(is_array($query) && count($query)>0):		

							$data['site_title']=$query[0]->title;

						else:

							$data['site_title']='';

						endif;				

						

						//$data['contact'] = $this->query_model->getbyTable("tblcontact");

						// $this->load->view("contact-us-sent",$data);
						
						$this->session->set_userdata('msg', 'failed');
						
						redirect(base_url().'our-locations');

					endif;

					

					}else{

						redirect("contact-us");

					}

			}	

			else{

				

				redirect("contact-us");

			}

	}		

public function quicksend(){

	$data = array();	

	$this->load->library("email");

	

	$query = $this->query_model->getbyTable('tblsite');

	foreach($query as $row):

		$site_email = $row->email;

		$school_name = $row->title;

	endforeach;

	

	$sender = $_POST['name'];

    $sender_email = $_POST['email'];

	$cont = $_POST['message'];

	 

	$type = "Email Inquiry";

	

  	$config['charset'] = 'iso-8859-1';

	$config['wordwrap'] = TRUE;

	$config['mailtype']="html";

	$this->email->initialize($config);

	$this->email->from($sender_email);

	$this->email->to($site_email);

	$this->email->subject($type);

	

		$mes ="<html><head>";

		$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

		$mes.="<style>

		*{ margin: 0; padding: 0; font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

		body{ margin: 5px;text-align: left;  }

		h1{ font-weight:900; color: #006699; font-size: 26px; text-transform:uppercase; font-family: 'Raleway', sans-serif; margin: 5px 0;}

		h6{ font-size: 14px; color: #006699}

		strong{ color:#006699; font-weight:900; }

		.content{ margin-top: 5px;}

		.content .row{ margin: 5px 0;}

		.row .message{ width: 700px; padding-top: 10px; }

		.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px; text-indent: 20px;}

		label{ font-weight:400; }

		

		</style>";

		$mes .= "</head><body>";

		$mes .= "<h1>".$school_name."</h1>";

		$mes .= "<strong>Email Contact Form</strong>";

		

		$mes .= '<div class="content">';

		$mes .=	'<div class="row"><strong>Name: &nbsp;</strong><label>'.$sender.'</label></div>';

		$mes .=	'<div class="row"><strong>Email: &nbsp;</strong><label>'.$sender_email.'</label></div>';

		

		$mes .= '<div class="row">';

		$mes .= '<div class="message"><p>'.$cont.'</p></div>';

		$mes .= '</div></div>';

		$mes .= '</body></html>';

	

	$this->email->message($mes);

	

	if($this->email->send()):

		echo "<script language='javascript'>window.location.reload();</script>";

		//$this->load->view("contact-us",$data);

	else:

		echo "<script language='javascript'>window.location.reload();</script>";

		//$this->load->view("contact-us",$data);

	endif;

	}

}



/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */