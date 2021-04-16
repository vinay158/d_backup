<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carrer extends CI_Controller {

	public function index()
	{
		$data = array();
		$data['detail'] = $this->query_model->getBySpecific('tbl_static_pages','id',3);
		$this->load->view('career_opportunities', $data);
		
		
	}
	
	
	public function save_carrer_form(){
		
			if(isset($_POST['submit'])){
				
				$data = array();
				
				$data['name'] = isset($_POST['name']) ? $_POST['name'] : ''; 
				$data['address'] = isset($_POST['address']) ? $_POST['address'] : ''; 
				$data['city'] = isset($_POST['city']) ? $_POST['city'] : ''; 
				$data['state'] = isset($_POST['state']) ? $_POST['state'] : ''; 
				$data['zip'] = isset($_POST['zip']) ? $_POST['zip'] : ''; 
				$data['contact_way'] = isset($_POST['name']) ? $_POST['contact_way'] : ''; 
				$data['home_phone_number'] = isset($_POST['home_phone_number']) ? $_POST['home_phone_number'] : ''; 
				$data['cell_phone_number'] = isset($_POST['cell_phone_number']) ? $_POST['cell_phone_number'] : ''; 
				$data['email'] = isset($_POST['email']) ? $_POST['email'] : ''; 
				$data['birthdate'] = isset($_POST['birthdate']) ? $_POST['birthdate'] : ''; 
				$data['age'] = isset($_POST['age']) ? $_POST['age'] : ''; 
				$data['gender'] = isset($_POST['gender']) ? $_POST['gender'] : ''; 
				$data['school'] = isset($_POST['school']) ? $_POST['school'] : ''; 
				$data['position'] = isset($_POST['position']) ? $_POST['position'] : ''; 
				$data['specify_hours'] = isset($_POST['specify_hours']) ? $_POST['specify_hours'] : ''; 
				$data['spacify_start_date'] = isset($_POST['spacify_start_date']) ? $_POST['spacify_start_date'] : ''; 
				$data['worked'] = isset($_POST['worked']) ? $_POST['worked'] : ''; 
				$data['school_level'] = isset($_POST['school_level']) ? $_POST['school_level'] : ''; 
				$data['degree_earned'] = isset($_POST['degree_earned']) ? $_POST['degree_earned'] : ''; 
				$data['last_attended'] = isset($_POST['last_attended']) ? $_POST['last_attended'] : ''; 
				$data['special_skills_detail'] = isset($_POST['special_skills_detail']) ? $_POST['special_skills_detail'] : ''; 
				$data['previous_training_detail'] = isset($_POST['previous_training_detail']) ? $_POST['previous_training_detail'] : ''; 
				$data['present_employer'] = isset($_POST['present_employer']) ? $_POST['present_employer'] : ''; 
				$data['present_supervisor_name'] = isset($_POST['present_supervisor_name']) ? $_POST['present_supervisor_name'] : ''; 
				$data['present_supervisor_contact'] = isset($_POST['present_supervisor_contact']) ? $_POST['present_supervisor_contact'] : ''; 
				$data['conatct_refernce'] = isset($_POST['conatct_refernce']) ? $_POST['conatct_refernce'] : ''; 
				$data['present_work_address'] = isset($_POST['present_work_address']) ? $_POST['present_work_address'] : ''; 
				$data['present_duties_preformed'] = isset($_POST['present_duties_preformed']) ? $_POST['present_duties_preformed'] : ''; 
				$data['present_start_date'] = isset($_POST['present_start_date']) ? $_POST['present_start_date'] : ''; 
				$data['present_end_date'] = isset($_POST['present_end_date']) ? $_POST['present_end_date'] : ''; 
				$data['present_starting_salary'] = isset($_POST['present_starting_salary']) ? $_POST['present_starting_salary'] : ''; 
				$data['present_ending_salary'] = isset($_POST['present_ending_salary']) ? $_POST['present_ending_salary'] : ''; 
				$data['present_leaving_reason'] = isset($_POST['present_leaving_reason']) ? $_POST['present_leaving_reason'] : ''; 
				$data['previous_employer'] = isset($_POST['previous_employer']) ? $_POST['previous_employer'] : ''; 
				$data['previous_supervisor_name'] = isset($_POST['previous_supervisor_name']) ? $_POST['previous_supervisor_name'] : ''; 
				$data['previous_contact_number'] = isset($_POST['previous_contact_number']) ? $_POST['previous_contact_number'] : ''; 
				$data['previous_work_address'] = isset($_POST['previous_work_address']) ? $_POST['previous_work_address'] : ''; 
				$data['previous_duties_performed'] = isset($_POST['previous_duties_performed']) ? $_POST['previous_duties_performed'] : ''; 
				$data['previous_start_date'] = isset($_POST['previous_start_date']) ? $_POST['previous_start_date'] : ''; 
				$data['previous_end_date'] = isset($_POST['previous_end_date']) ? $_POST['previous_end_date'] : ''; 
				$data['previous_starting_salary'] = isset($_POST['previous_starting_salary']) ? $_POST['previous_starting_salary'] : ''; 
				$data['previous_ending_salary'] = isset($_POST['previous_ending_salary']) ? $_POST['previous_ending_salary'] : ''; 
				$data['previous_leaving_reason'] = isset($_POST['previous_leaving_reason']) ? $_POST['previous_leaving_reason'] : ''; 
				$data['first_referral_name'] = isset($_POST['first_referral_name']) ? $_POST['first_referral_name'] : ''; 
				$data['first_referral_contact_number'] = isset($_POST['first_referral_contact_number']) ? $_POST['first_referral_contact_number'] : ''; 
				$data['first_referral_years_known'] = isset($_POST['first_referral_years_known']) ? $_POST['first_referral_years_known'] : ''; 
				$data['first_referral_relationship'] = isset($_POST['first_referral_relationship']) ? $_POST['first_referral_relationship'] : ''; 
				$data['second_referral_name'] = isset($_POST['second_referral_name']) ? $_POST['second_referral_name'] : ''; 
				$data['second_referral_contact_number'] = isset($_POST['second_referral_contact_number']) ? $_POST['second_referral_contact_number'] : ''; 
				$data['second_referral_years_known'] = isset($_POST['second_referral_years_known']) ? $_POST['second_referral_years_known'] : ''; 
				$data['second_referral_relationship'] = isset($_POST['second_referral_relationship']) ? $_POST['second_referral_relationship'] : ''; 
				$data['email_signature'] = isset($_POST['email_signature']) ? $_POST['email_signature'] : ''; 
				
				if(!empty($data)){
					$this->sendCarrerEmail($data);
					
					$data['msg'] = 1;
					$this->load->view("carrer_thankyou_page",$data);
				}
			}
	}
	
	public function sendCarrerEmail($data){
					
					$multiLocation = $this->query_model->getbyTable("tblconfigcalendar");
					if($multiLocation[0]->field_value == 1){
						
						$main_location = $this->query_model->getMainLocation("tblcontact");	
						$reciverEmail = $main_location[0]->email;
					}else{
						$site_setting = $this->query_model->getbyTable('tblsite');	
						$reciverEmail = $site_setting[0]->email;
					}
					
					
					
					$subject = "Career Opportunity | ".$data['name'];
					
					$this->load->library("email");
					$config['charset'] = 'UTF-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype']="html";
					
					$this->email->initialize($config);
					$this->email->from($data['email']);
					$this->email->to($reciverEmail);
					//$this->email->bcc('leads@websitedojo.com');
					$this->email->subject($subject);

			

					$mes ="<html><head>";

					$mes .= "<link href='http://fonts.googleapis.com/css?family=Raleway:900' rel='stylesheet' type='text/css'>";

					$mes.="<style>

					*{ font-size: 14px; font-family:Verdana, Arial, Helvetica, sans-serif; color: #333333}

					body{ text-align: left; }

					h1{ font-weight:900; color: #006699; font-size: 16px; text-transform:capitalize; font-family: 'Raleway', sans-serif; line-height:20px; margin-bottom:15px;margin-top:0px;}
					
					h6{ font-size: 14px; color: #006699; line-height:14px;}

					strong{ color:#006699; font-weight:900; }

					.content{ margin-top: 5px;}

					.content .row{ margin: 5px 0;}

					.row .message{ width: 700px; padding-top: 10px; }

					.row .message p{ text-align:justify; margin: 10px 0; margin-bottom: 15px;}

					label{ font-weight:400; }

					

					</style>";

					$mes .= "</head><body align='left'>";
					$mes .= "<h1>Career Opportunity Form</h1>";
					$mes .= '<div class="content">';

					$mes .=	'<div class="row"><strong>Name:- </strong><label>'.$data['name'].'</label></div>';
					$mes .=	'<div class="row"><strong>Address:- </strong><label>'.$data['address'].'</label></div>';
					$mes .=	'<div class="row"><strong>City:- </strong><label>'.$data['city'].'</label></div>';
					$mes .=	'<div class="row"><strong>State:- </strong><label>'.$data['state'].'</label></div>';
					$mes .=	'<div class="row"><strong>Zip Code:- </strong><label>'.$data['zip'].'</label></div>';
					$mes .=	'<div class="row"><strong>Best way to contact you:- </strong><label>'.$data['contact_way'].'</label></div>';
					$mes .=	'<div class="row"><strong>Home Phone Number:- </strong><label>'.$data['home_phone_number'].'</label></div>';
					$mes .=	'<div class="row"><strong>Cell Phone Number:- </strong><label>'.$data['cell_phone_number'].'</label></div>';
					$mes .=	'<div class="row"><strong>E-mail:- </strong><label>'.$data['email'].'</label></div>';
					$mes .=	'<div class="row"><strong>Birthdate:- </strong><label>'.$data['birthdate'].'</label></div>';
					$mes .=	'<div class="row"><strong>Age:- </strong><label>'.$data['age'].'</label></div>';
					$mes .=	'<div class="row"><strong>Gender:- </strong><label>'.$data['gender'].'</label></div>';
					$mes .=	'<div class="row"><strong>Choose the school closest to you:- </strong><label>'.$data['school'].'</label></div>';
					$mes .=	'<div class="row"><strong>Position(s) Applying For:- </strong><label>'.$data['position'].'</label></div>';
					$mes .=	'<div class="row"><strong>Specify Hours if Part Time:- </strong><label>'.$data['specify_hours'].'</label></div>';
					$mes .=	'<div class="row"><strong>Specify Start Date :- </strong><label>'.$data['spacify_start_date'].'</label></div>';
					$mes .=	'<div class="row"><strong>Have you ever worked at before?:- </strong><label>'.$data['worked'].'</label></div>';
					$mes .=	'<div class="row"><strong>Highest Level of School:- </strong><label>'.$data['school_level'].'</label></div>';
					$mes .=	'<div class="row"><strong>Type of Degree Earned:- </strong><label>'.$data['degree_earned'].'</label></div>';
					$mes .=	'<div class="row"><strong>Name of School Last Attended:- </strong><label>'.$data['last_attended'].'</label></div>';
					$mes .=	'<div class="row"><strong>What special skills or qualifications do you feel would enhance your ability to work with? :- </strong><label>'.$data['special_skills_detail'].'</label></div>';
					$mes .=	'<div class="row"><strong>Please list your previous Basketball Training/Coaching experiences including where this was received :- </strong><label>'.$data['previous_training_detail'].'</label></div>';
					$mes .=	'<div class="row"><strong>Present Employer:- </strong><label>'.$data['present_employer'].'</label></div>';
					$mes .=	'<div class="row"><strong>Supervisor\n\'s Name:- </strong><label>'.$data['present_supervisor_name'].'</label></div>';
					$mes .=	'<div class="row"><strong>Supervisor\n\'s Contact Number:- </strong><label>'.$data['present_supervisor_contact'].'</label></div>';
					$mes .=	'<div class="row"><strong>May we contact them as a reference?:- </strong><label>'.$data['conatct_refernce'].'</label></div>';
					$mes .=	'<div class="row"><strong>Work Address:- </strong><label>'.$data['present_work_address'].'</label></div>';
					$mes .=	'<div class="row"><strong>Duties Performed:- </strong><label>'.$data['present_duties_preformed'].'</label></div>';
					$mes .=	'<div class="row"><strong>Start Date:- </strong><label>'.$data['present_start_date'].'</label></div>';
					$mes .=	'<div class="row"><strong>End Date:- </strong><label>'.$data['present_end_date'].'</label></div>';
					$mes .=	'<div class="row"><strong>Starting Salary:- </strong><label>'.$data['present_starting_salary'].'</label></div>';
					$mes .=	'<div class="row"><strong>Ending Salary:- </strong><label>'.$data['present_ending_salary'].'</label></div>';
					$mes .=	'<div class="row"><strong>Reason for Leaving:- </strong><label>'.$data['present_leaving_reason'].'</label></div>';
					$mes .=	'<div class="row"><strong>Previous Employer:- </strong><label>'.$data['previous_employer'].'</label></div>';
					$mes .=	'<div class="row"><strong>Supervisor\n\'s Name:- </strong><label>'.$data['previous_supervisor_name'].'</label></div>';
					$mes .=	'<div class="row"><strong>Supervisor\n\'s Contact Number:- </strong><label>'.$data['previous_contact_number'].'</label></div>';
					$mes .=	'<div class="row"><strong>Work Address:- </strong><label>'.$data['previous_work_address'].'</label></div>';
					$mes .=	'<div class="row"><strong>Duties Performed:- </strong><label>'.$data['previous_duties_performed'].'</label></div>';
					$mes .=	'<div class="row"><strong>Start Date:- </strong><label>'.$data['previous_start_date'].'</label></div>';
					$mes .=	'<div class="row"><strong>End Date:- </strong><label>'.$data['previous_end_date'].'</label></div>';
					$mes .=	'<div class="row"><strong>Starting Salary:- </strong><label>'.$data['previous_starting_salary'].'</label></div>';
					$mes .=	'<div class="row"><strong>Ending Salary:- </strong><label>'.$data['previous_ending_salary'].'</label></div>';
					$mes .=	'<div class="row"><strong>Reason for Leaving:- </strong><label>'.$data['previous_leaving_reason'].'</label></div>';
					$mes .=	'<div class="row"><strong>Referral Name:- </strong><label>'.$data['first_referral_name'].'</label></div>';
					$mes .=	'<div class="row"><strong>Contact Number:- </strong><label>'.$data['first_referral_contact_number'].'</label></div>';
					$mes .=	'<div class="row"><strong>Number of Years Known:- </strong><label>'.$data['first_referral_years_known'].'</label></div>';
					$mes .=	'<div class="row"><strong>Relationship:- </strong><label>'.$data['first_referral_relationship'].'</label></div>';
					$mes .=	'<div class="row"><strong>Referral Name:- </strong><label>'.$data['second_referral_name'].'</label></div>';
					$mes .=	'<div class="row"><strong>Contact Number:- </strong><label>'.$data['second_referral_contact_number'].'</label></div>';
					$mes .=	'<div class="row"><strong>Number of Years Known:- </strong><label>'.$data['second_referral_years_known'].'</label></div>';
					$mes .=	'<div class="row"><strong>Relationship:- </strong><label>'.$data['second_referral_relationship'].'</label></div>';
					$mes .=	'<div class="row"><strong>E-Signature:- </strong><label>'.$data['email_signature'].'</label></div>'; 


					$mes .= '<div class="row">';
					$mes .= '</div></div>';
					$mes .= '</body></html>';		
					
					$this->email->message($mes);
					$this->email->send();
					
					
	}

}